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

        $recentOrders = Order::with([
            'orderDetails.product:id,product_name',
            'customer:id,name'
        ])
            ->select('id', 'customer_id', 'customer_name', 'total_price', 'created_at')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('lowStockProducts', 'recentOrders'));
    }
}
