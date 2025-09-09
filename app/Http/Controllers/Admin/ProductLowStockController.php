<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductLowStockController extends Controller
{
    public function lowStock()
    {
        $lowStockProducts = Product::lowStock();
        return view('admin.product.product-low-stock.index', compact('lowStockProducts'));
    }
}
