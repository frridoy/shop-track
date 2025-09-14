<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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

        $totalOrders = Order::count();
        $productsInStock = Product::where('stock_qty', '>', 0)->count();
        $registeredCustomers = Customer::count();
        $totalSalesMonthly = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        return view('admin.dashboard.index', compact('lowStockProducts', 'recentOrders', 'totalOrders', 'productsInStock', 'registeredCustomers', 'totalSalesMonthly'));
    }

    public function getSalesData($year)
    {
        $sales = Order::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlySales = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlySales[] = $sales[$i] ?? 0;
        }

        return response()->json($monthlySales);

    }
}
