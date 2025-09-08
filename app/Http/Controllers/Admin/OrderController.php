<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Lookup;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'orderDetails'])->get();
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
            Log::info('Scanned barcode: ' . $code);
            $decodedCode = urldecode($code);
            Log::info('Decoded barcode: ' . $decodedCode);

            $product = Product::where('product_code', $decodedCode)
                ->orWhere('product_code', $code)
                ->first();

            if (!$product) {
                Log::warning('Product not found for barcode: ' . $code);
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found for barcode: ' . $code
                ], 404);
            }

            Log::info('Product found: ' . $product->product_name);

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
                    'stock' => $product->stock_quantity ?? 0,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching product by barcode: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error occurred while fetching product'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        if ($request->customer_id) {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'total_price' => 0,
            ]);
        } else {
            $order = Order::create([
                'customer_id'     => null,
                'customer_name'   => $request->customer_name,
                'customer_mobile' => $request->customer_mobile,
                'total_price'     => 0,
            ]);
        }

        $orderTotal = 0;

        foreach ($request->products as $product) {
            $lineTotal = $product['price'] * $product['qty'];

            OrderDetail::create([
                'order_id'      => $order->id,
                'product_id'    => $product['id'],
                'selling_price' => $product['price'],
                'quantity'      => $product['qty'],
                'color'         => $product['color'] ?? null,
                'size'          => $product['size'] ?? null,
                'total_price'   => $lineTotal,
            ]);

            $orderTotal += $lineTotal;
        }

        $order->update(['total_price' => $orderTotal]);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully!',
        ]);
    }
}
