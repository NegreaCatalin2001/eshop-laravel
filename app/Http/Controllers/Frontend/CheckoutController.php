<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index()
    {
        $old_cartitems = Cart::where('user_id', Auth::id())->get();
        foreach ($old_cartitems as $item) {
            $product = Product::where('id', $item->prod_id)->first();
            if ($product && $item->prod_qty > $product->qty) {
                $cartItem = Cart::where('user_id', Auth::id())->where('prod_id', $item->prod_id)->first();
                $cartItem->prod_qty = $product->qty; 
                $cartItem->save();
            }
        }

        $cartItems = Cart::where('user_id', Auth::id())->get();

        return view('frontend.checkout', compact('cartItems'));
    }
    public function stripePayment(Request $request, $total)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => $total * 100, 
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Descrierea plății',
            ]);

            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function placeorder(Request $request)
    {
        $rules = [
            'fname' => 'required|string|alpha|max:255',
            'lname' => 'required|string|alpha|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'regex:/^\+?(\d[\d\s\-()]{7,15})\d$/'],
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'county' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postalcode' => 'required|string|max:255',
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $total = 0;
        $cartitems_total = Cart::where('user_id', Auth::id())->get();
        foreach ($cartitems_total as $prod) {
            $total += $prod->products->selling_price * $prod->prod_qty;
        }

        $stripeToken = $request->input('stripeToken');
        if (!$stripeToken) {
            return back()->with('error', 'Eroare la procesarea plății. Vă rugăm să încercați din nou.');
        }

        $paymentResult = $this->stripePayment($request, $total);
        if (!$paymentResult['success']) {
            return back()->with('error', 'Eroare la procesarea plății.');
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->fname = $request->input('fname');
        $order->lname = $request->input('lname');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->address = $request->input('address');
        $order->city = $request->input('city');
        $order->county = $request->input('county');
        $order->country = $request->input('country');
        $order->postalcode = $request->input('postalcode');

        $total = 0;
        $cartitems_total = Cart::where('user_id', Auth::id())->get();
        foreach ($cartitems_total as $prod) {
            $total += $prod->products->selling_price * $prod->prod_qty;
        }

        $order->total_price = $total;

        $order->tracking_no = 'order' . rand(1111, 9999);
        $order->save();

        $cartItems = Cart::where('user_id', Auth::id())->get();
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'prod_id' => $item->prod_id,
                'qty' => $item->prod_qty,
                'price' => $item->products->selling_price,
            ]);

            $prod = Product::where('id', $item->prod_id)->first();
            $prod->qty = $prod->qty - $item->prod_qty;
            $prod->update();
        }

        if (Auth::user()->address == null) {
            $user = User::where('id', Auth::id())->first();
            $user->fname = $request->input('fname');
            $user->lname = $request->input('lname');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->city = $request->input('city');
            $user->county = $request->input('county');
            $user->country = $request->input('country');
            $user->postalcode = $request->input('postalcode');
            $user->update();
        }
        $cartItems = Cart::where('user_id', Auth::id())->get();
        Cart::destroy($cartItems);
        return redirect('/')->with('status', "Ordered placed Successfully");
    }

}
