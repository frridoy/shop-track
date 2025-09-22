<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lookup;
use App\Models\Product;
use App\Models\ProductType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS1D;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('type:id,product_type_name');

        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('type', function ($q) use ($request) {
                $q->where('product_type_name', $request->category);
            });
        }

        $productTypes = ProductType::where('is_active', 1)->get();
        $products = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        $productSize = Lookup::where('lookup_type', 1)->select('id', 'lookup_name')->get();
        $productColor = Lookup::where('lookup_type', 2)->select('id', 'lookup_name')->get();

        return view('admin.product.index', compact('products', 'productTypes', 'productSize', 'productColor'));
    }

    public function create()
    {
        $productTypes = ProductType::where('is_active', 1)
            ->whereNull('is_updated')
            ->select('id', 'product_type_name')
            ->get();

        $sizes = Lookup::where('lookup_type', 1)->select('id', 'lookup_name')->get();
        $colors = Lookup::where('lookup_type', 2)->select('id', 'lookup_name')->get();
        return view('admin.product.create', compact('productTypes', 'sizes', 'colors'));
    }
    public function store(Request $request)
    {
        // 1. Validation rules
        $rules = [
            'product_type_id' => 'required|exists:product_types,id',
            'products' => 'required|array|min:1',
            // 'products.*.product_name' => 'required|string|max:100|distinct',
            'products.*.color' => 'nullable|numeric|exists:lookups,id',
            'products.*.size' => 'nullable|numeric|exists:lookups,id',
            'products.*.stock_qty' => 'required|numeric|min:0',
            'products.*.purchase_price' => 'required|numeric|min:0',
            'products.*.selling_price' => 'required|numeric|min:0',
            'products.*.bottom_price' => 'required|numeric|min:0',
            'products.*.remarks' => 'nullable|string|max:255',
            'products.*.is_active' => 'required|in:0,1',
        ];

        // 2. Custom error messages
        $messages = [];
        foreach ($request->products ?? [] as $i => $product) {
            $row = $i + 1;
            $messages["products.$i.product_name.required"] = "Product #$row Name is required.";
            $messages["products.$i.stock_qty.required"] = "Product #$row Stock Qty is required.";
            $messages["products.$i.purchase_price.required"] = "Product #$row Purchase Price is required.";
            $messages["products.$i.selling_price.required"] = "Product #$row Selling Price is required.";
            $messages["products.$i.bottom_price.required"] = "Product #$row Bottom Price is required.";
            $messages["products.$i.is_active.required"] = "Product #$row Status is required.";
        }

        $request->validate($rules, $messages);

        $productTypeId = $request->product_type_id;
        $productName = $request->product_name;
        $productsData = $request->products;
        $createdBy = Auth::id();

        $now = Carbon::now();
        $month = $now->format('m');
        $year = $now->format('y');

        // 3. Determine next product code sequence
        $lastProduct = Product::whereYear('created_at', $now->year)
            ->where('product_code', 'like', 'P' . $month . $year . '-%')
            ->orderByDesc('product_code')
            ->first();

        $startSequence = 1;
        if ($lastProduct && preg_match('/P\d{4}-(\d{4})/', $lastProduct->product_code, $matches)) {
            $startSequence = (int)$matches[1] + 1;
        }

        // 4. Collect all size and color IDs
        $sizeIds = collect($productsData)->pluck('size')->filter()->unique();
        $colorIds = collect($productsData)->pluck('color')->filter()->unique();
        $lookups = Lookup::whereIn('id', $sizeIds->merge($colorIds))->get()->keyBy('id');

        // 5. Create products
        $createdProducts = [];
        foreach ($productsData as $index => $product) {
            $sequence = $startSequence + $index;
            $code = 'P' . $month . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

            $createdProduct = Product::create([
                'product_type_id' => $productTypeId,
                'product_name' =>  $productName,
                'entry_no' => Product::max('entry_no') + 1,
                'color' => $product['color'] ?? null,
                'size' => $product['size'] ?? null,
                'stock_qty' => $product['stock_qty'],
                'purchase_price' => $product['purchase_price'],
                'selling_price' => $product['selling_price'],
                'bottom_price' => $product['bottom_price'],
                'remarks' => $product['remarks'] ?? null,
                'is_active' => $product['is_active'],
                'product_code' => $code,
                'created_by' => $createdBy,
            ]);

            // 6. size and color names for barcode view
            $createdProduct->size_name = $product['size'] ? ($lookups[$product['size']]->lookup_name ?? null) : null;
            $createdProduct->color_name = $product['color'] ? ($lookups[$product['color']]->lookup_name ?? null) : null;

            // 7. Push same product multiple times = stock_qty barcodes
            for ($i = 0; $i < $product['stock_qty']; $i++) {
                $createdProducts[] = $createdProduct;
            }
        }

        // 7. Return to barcode view
        return view('admin.product.barcode', compact('createdProducts'));
    }
    public function singleProductBarcode(Product $product)
    {
        // attach color & size names
        $product->color_name = $product->color ? (Lookup::find($product->color)->lookup_name ?? null) : null;
        $product->size_name  = $product->size ? (Lookup::find($product->size)->lookup_name ?? null) : null;

        // repeat product according to stock_qty
        $createdProducts = [];
        for ($i = 0; $i < $product->stock_qty; $i++) {
            $createdProducts[] = $product;
        }

        return view('admin.product.barcode', compact('createdProducts'));
    }

    public function show($id)
    {
        $product = Product::with('type')->findOrFail($id);
        $size = Lookup::where('lookup_type', 1)->where('id', $product->size)->value('lookup_name');
        $color = Lookup::where('lookup_type', 2)->where('id', $product->color)->value('lookup_name');
        return view('admin.product.show', compact('product', 'size', 'color'));
    }
}
