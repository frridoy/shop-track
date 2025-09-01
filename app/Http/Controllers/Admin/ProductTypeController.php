<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::select('id', 'product_type_name', 'is_active')->where('is_updated', null)->get();
        return view('admin.product-type.index', compact('productTypes'));
    }

    public function create()
    {
        return view('admin.product-type.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'product_type_name' => 'required|string|max:100|unique:product_types,product_type_name',
            'is_active'         => 'required|in:0,1',
        ]);

        $productType = ProductType::create([
            'product_type_name' => ucwords($request->product_type_name),
            'is_active'         => $request->is_active,
        ]);

        return redirect()->route('products.types.index')->with('success', 'Product Type Created Successfully');
    }

    public function edit($id)
    {
        $productType = ProductType::findOrFail($id);
        return view('admin.product-type.edit', compact('productType'));
    }

    public function update(Request $request, $id)
    {
        $productType = ProductType::findOrFail($id);

        $validate = $request->validate([
            'product_type_name' => 'required|string|max:100|unique:product_types,product_type_name,' . $productType->id,
            'is_active'         => 'required|in:0,1',
        ]);

        $productType->create([
            'product_type_name' => ucwords($request->product_type_name),
            'is_active'         => $request->is_active,
        ]);

        $productType->update([
            'is_updated' => 1,
            'is_active' => 0
        ]);

        return redirect()->route('products.types.index')->with('success', 'Product Type Updated Successfully');
    }
}
