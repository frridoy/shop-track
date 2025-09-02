@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="font-size: 1rem;">Product List</h5>
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">Add New Product</a>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3 fw-bold" style="font-size: 1rem;">Filter Products</h5>
                <form action="{{ route('products.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Search Product" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach ($productTypes as $type)
                                <option value="{{ $type->product_type_name }}"
                                    {{ request('category') == $type->product_type_name ? 'selected' : '' }}>
                                    {{ $type->product_type_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success btn-sm w-100">Filter</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Stock Qty</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $key => $product)
                                <tr>
                                    <td>{{ $products->firstItem() + $key }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->type->product_type_name ?? '-' }}</td>
                                    <td>{{ number_format($product->stock_qty, '0') }}</td>
                                    <td>
                                        Purchase: {{ number_format($product->purchase_price, '0') }}<br>
                                        Selling: {{ number_format($product->selling_price, '0') }}<br>
                                        Bottom: {{ number_format($product->bottom_price, '0') }}
                                    </td>

                                    <td>
                                        @if ($product->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-sm btn-info">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
