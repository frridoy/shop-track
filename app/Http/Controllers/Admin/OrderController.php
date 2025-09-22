<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Lookup;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'customer:id,name,mobile_no',
            'branch:id,branch_name,branch_code',
            'orderDetails:id,order_id,product_id,quantity,selling_price,color,size',
            'orderDetails.product:id,product_name,product_code'
        ])
            ->select('id', 'branch_id', 'customer_id', 'customer_name', 'customer_mobile', 'total_price', 'created_at')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.order.index', compact('orders'));
    }
    public function create()
    {
        $customers = Customer::all();
        return view('admin.order.create', compact('customers'));
    }

    public function getProductByBarcode($code)
    {
        try {
            $decodedCode = urldecode($code);

            $product = Product::where('product_code', $decodedCode)
                ->orWhere('product_code', $code)
                ->first();

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found'], 404);
            }

            if ($product->is_active == 0) {
                return response()->json(['success' => false, 'message' => 'Product is reserved'], 403);
            }

            if ($product->stock_qty <= 0) {
                return response()->json(['success' => false, 'message' => 'Product is out of stock'], 403);
            }

            $colorName = Lookup::where('id', $product->color)->value('lookup_name');
            $sizeName = Lookup::where('id', $product->size)->value('lookup_name');

            return response()->json([
                'success' => true,
                'product' => [
                    'id'    => $product->id,
                    'name'  => $product->product_name,
                    'color' => $colorName,
                    'size'  => $sizeName,
                    'price' => (float) $product->selling_price,
                    'stock' => $product->stock_qty,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching product by barcode: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }

    public function store(Request $request)
    {
        $branchId = Auth::user()->branch_id ?? null;

        foreach ($request->products as $p) {
            $product = Product::find($p['id']);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found']);
            }
            if ($product->is_active == 0) {
                return response()->json(['success' => false, 'message' => $product->product_name . ' is reserved']);
            }
            if ($p['qty'] > $product->stock_qty) {
                return response()->json(['success' => false, 'message' => 'Quantity for ' . $product->product_name . ' exceeds available stock']);
            }
        }

        if ($request->customer_id) {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'branch_id'   => $branchId,
                'total_price' => 0,
            ]);
        } else {
            $order = Order::create([
                'customer_id'     => null,
                'branch_id'       => $branchId,
                'customer_name'   => $request->customer_name,
                'customer_mobile' => $request->customer_mobile,
                'total_price'     => 0,
            ]);
        }

        $orderTotal = 0;

        foreach ($request->products as $productData) {
            $lineTotal = $productData['price'] * $productData['qty'];

            OrderDetail::create([
                'order_id'      => $order->id,
                'product_id'    => $productData['id'],
                'selling_price' => $productData['price'],
                'quantity'      => $productData['qty'],
                'color'         => $productData['color'] ?? null,
                'size'          => $productData['size'] ?? null,
                'total_price'   => $lineTotal,
                'selller_id'    => Auth::user()->id
            ]);

            Product::where('id', $productData['id'])->increment('sold_qty', $productData['qty']);
            Product::where('id', $productData['id'])->decrement('stock_qty', $productData['qty']);

            $orderTotal += $lineTotal;
        }

        $order->update(['total_price' => $orderTotal]);

        return response()->json(['success' => true, 'message' => 'Order created successfully']);
    }

    public function show($id)
    {
        $order = Order::with([
            'customer:id,name,mobile_no',
            'branch:id,branch_name,branch_code',
            'orderDetails:id,order_id,product_id,quantity,selling_price,color,size',
            'orderDetails.product:id,product_name,product_code'
        ])
            ->select('id', 'branch_id', 'customer_id', 'customer_name', 'customer_mobile', 'total_price', 'created_at')
            ->findOrFail($id);

        return view('admin.order.show', compact('order'));
    }
}
