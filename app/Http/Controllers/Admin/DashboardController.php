<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $lowStockProducts = Product::where('stock_qty', '<', 5)->get();

        $authUser = Auth::user();
        $authId = $authUser->id;
        $branchId = $authUser->branch_id;
        $branchName = $authUser->branch->branch_name ?? null;

        if ($authUser->user_type == 1) {
            $recentOrders = Order::with([
                'orderDetails.product:id,product_name',
                'customer:id,name',
                'seller:id,name'
            ])
                ->select('id', 'customer_id', 'seller_id', 'customer_name', 'total_price', 'created_at')
                ->orderBy('id', 'desc')
                ->take(5)
                ->get();
        } elseif ($authUser->user_type == 2) {
            $recentOrders = Order::with([
                'orderDetails.product:id,product_name',
                'customer:id,name',
                'seller:id,name'
            ])
                ->select('id', 'customer_id', 'customer_name', 'seller_id', 'total_price', 'created_at')
                ->where('branch_id', $branchId)
                ->orderBy('id', 'desc')
                ->take(5)
                ->get();
        } else {
            $recentOrders = Order::with([
                'orderDetails.product:id,product_name',
                'customer:id,name',
                'seller:id,name'
            ])
                ->select('id', 'customer_id', 'customer_name', 'seller_id', 'total_price', 'created_at')
                ->where('branch_id', $branchId)
                ->where('seller_id', $authId)
                ->orderBy('id', 'desc')
                ->take(5)
                ->get();
        }

        // dd($recentOrders);

        if ($authUser->user_type == 1) {
            $totalOrders = Order::count();
            $totalSalesMonthly = Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_price');
            $pageTitle = 'ALL Records';
        } elseif ($authUser->user_type == 2) {
            $totalOrders = Order::where('branch_id', $branchId)->count();
            $totalSalesMonthly = Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('branch_id', $branchId)
                ->sum('total_price');
            $branchName = $authUser->branch->branch_name;
            $pageTitle = "$branchName Branch";
        } else {
            $totalOrders = Order::where('branch_id', $branchId)->where('seller_id', $authId)->count();
            $totalSalesMonthly = Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('branch_id', $branchId)
                ->where('seller_id', $authId)
                ->sum('total_price');
            $userName = $authUser->name;
            $branchName = $authUser->branch->branch_name;
            $pageTitle = "($userName')";
        }

        $productsInStock = Product::where('stock_qty', '>', 0)->count();
        $registeredCustomers = Customer::count();

        return view('admin.dashboard.index', compact('lowStockProducts', 'recentOrders', 'totalOrders', 'productsInStock', 'registeredCustomers', 'totalSalesMonthly', 'pageTitle', 'branchName'));
    }

    public function getSalesData($year)
    {
        $authUser = Auth::user();
        $authId = $authUser->id;
        $branchId = $authUser->branch_id;

        if ($authUser->user_type == 1) {

            $sales = Order::whereYear('created_at', $year)
                ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');
        } elseif ($authUser->user_type == 2) {

            $sales = Order::whereYear('created_at', $year)
                ->where('branch_id', $branchId)
                ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->where('branch_id', $branchId)
                ->pluck('total', 'month');
        } else {

            $sales = Order::whereYear('created_at', $year)
                ->where('branch_id', $branchId)
                ->where('seller_id', $authId)
                ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->where('branch_id', $branchId)
                ->where('seller_id', $authId)
                ->pluck('total', 'month');
        }
        $monthlySales = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlySales[] = $sales[$i] ?? 0;
        }

        return response()->json($monthlySales);
    }
}
