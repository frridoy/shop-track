<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Lookup;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Order::with([
            'customer:id,name,mobile_no,email',
            'branch:id,branch_name,branch_code',
            'seller:id,name',
            'orderDetails:id,order_id,product_id,quantity,selling_price,color,size',
            'orderDetails.product:id,product_name,product_code'
        ])->select('id', 'branch_id', 'customer_id', 'customer_name', 'customer_mobile', 'total_price', 'created_at', 'seller_id');

        if ($user->user_type == 2) {
            $query->where('branch_id', $user->branch_id);
        } elseif ($user->user_type == 3) {
            $query->where('seller_id', $user->id);
        }

        if ($request->filled('customer_name')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }

        if ($request->filled('customer_email')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->customer_email . '%');
            });
        }

        if ($request->filled('customer_mobile')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('mobile_no', 'like', '%' . $request->customer_mobile . '%');
            });
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('seller_id')) {
            $query->where('seller_id', $request->seller_id);
        }

        if ($user->user_type == 1) {
            $sellers = User::where('user_type', 3)->select('id', 'name')->get();
        }
        elseif ($user->user_type == 2) {
            $sellers = User::whereIn('user_type', [2, 3])
                ->where('branch_id', $user->branch_id)
                ->orWhere('id', $user->id)
                ->select('id', 'name')
                ->get();
        }
        else {
            $sellers = collect();
        }

        $orders = $query->orderBy('id', 'desc')->get();

        $totalAmount = $orders->sum('total_price');

        $branches = Branch::where('is_active', 1)->select('id', 'branch_name')->get();

        return view('admin.order.index', compact('orders', 'branches', 'totalAmount', 'sellers'));
    }
    public function create()
    {
        $customers = Customer::select('id', 'name', 'mobile_no')->get();
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
                'seller_id'    => Auth::user()->id
            ]);
        } else {
            $order = Order::create([
                'customer_id'     => null,
                'branch_id'       => $branchId,
                'customer_name'   => $request->customer_name,
                'customer_mobile' => $request->customer_mobile,
                'total_price'     => 0,
                'seller_id'    => Auth::user()->id
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
            'seller:id,name,phone_no',
            'orderDetails:id,order_id,product_id,quantity,selling_price,color,size',
            'orderDetails.product:id,product_name,product_code'
        ])
            ->select('id', 'branch_id', 'seller_id','customer_id', 'customer_name', 'customer_mobile', 'total_price', 'created_at')
            ->findOrFail($id);

        return view('admin.order.show', compact('order'));
    }
}
