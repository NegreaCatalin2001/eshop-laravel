<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function users()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function viewUser($id)
    {
        $users = User::find($id);
        return view('admin.users.view', compact('users'));
    }

    public function index()
    {
        $OrdersCount = Order::count();
        $UserCount = User::where('role_as', '0')->count();

        $completedOrdersCount = Order::where('status', '1')->count();

        $canceledOrdersCount = Order::where('status', '2')->count();

        $inDeliveryOrdersCount = Order::where('status', '3')->count();

        $productCount = Product::count();

        $totalRevenue = Order::whereNotIn('status', ['2'])->sum('total_price');

        $averageOrderValue = $OrdersCount > 0 ? $totalRevenue / $OrdersCount : 0;

        $pendingOrdersCount = Order::where('status', '0')->count();

        $outOfStockCount = Product::where('qty', 0)->count();

        $totalRevenueAfterTax = Order::whereNotIn('status', ['2'])->with('orderItems.products')->get()->sum(function ($order) {
            return $order->orderItems->sum(function ($orderItem) {
                if ($orderItem->products) {
                    $totalPriceWithTax = $orderItem->price;
                    $pricePerUnitWithoutTax = $orderItem->products->selling_price / (1 + $orderItem->products->tax / 100);
                    $totalPriceWithoutTax = $pricePerUnitWithoutTax * $orderItem->qty;
                    return $totalPriceWithoutTax;
                }
                return 0;
            });
        });

        return view('admin.index', compact('completedOrdersCount', 'inDeliveryOrdersCount', 'canceledOrdersCount', 'outOfStockCount', 'totalRevenueAfterTax', 'UserCount', 'OrdersCount', 'productCount', 'totalRevenue', 'averageOrderValue', 'pendingOrdersCount'));
    }

}
