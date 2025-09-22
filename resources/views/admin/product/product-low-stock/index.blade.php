@extends('admin.layouts.app')

@section('content')
<div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold" style="font-size: 1rem;">Low Stock Products</h5>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">Add New Product</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3 fw-bold" style="font-size: 1rem;">Products Below Stock Threshold</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>First Stock Qty</th>
                            <th>Sold Qty</th>
                            <th>Remaining Qty</th>
                            <th>Selling Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lowStockProducts as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->product_name ?? '' }}</td>
                                <td>{{ $product->product_code ?? '' }}</td>
                                <td>{{ $product->stock_qty + $product->sold_qty ?? '' }}</td>
                                <td>{{ $product->sold_qty ?? ''}}</td>
                                <td>{{ $product->stock_qty ?? ''}}</td>
                                <td>{{ $product->selling_price ?? ''}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-danger">No Low Stock Products Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
