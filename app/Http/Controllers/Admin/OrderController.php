<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::whereIn('status', ['0','3'])->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function view($id)
    {
        $orders = Order::where('id', $id)->first();
        return view('admin.orders.view', compact('orders'));
    }

    public function updateOrder(Request $request, $id)
    {
        $orders = Order::find($id);
        $orders->status = $request->input('order_status');
        $orders->update();

        return redirect('orders')->with('status', 'Order Updated Successfully');
    }

    public function orderHistory()
    {
        $orders = Order::whereIn('status', ['1','2'])->get();
        return view('admin.orders.history', compact('orders'));
    }

}
