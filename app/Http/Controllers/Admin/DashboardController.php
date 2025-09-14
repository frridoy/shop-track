<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $lowStockProducts = Product::lowStock()->take(5);

        $recentOrders = Order::with('orderDetails.product', 'customer')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('lowStockProducts', 'recentOrders'));
    }
}
