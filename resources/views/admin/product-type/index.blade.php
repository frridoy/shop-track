@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="font-size: 1rem;">Add Product Type</h5>
                <a href="{{ route('products.types.create') }}" class="btn btn-primary btn-sm">Add New Product Type</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3 fw-bold" style="font-size: 1rem;">Product Type List</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product Type Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($productTypes as $productType)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $productType->product_type_name ?? '' }}</td>
                                    <td>
                                        <x-status-toggle
                                            :id="$productType->id"
                                            :status="$productType->is_active"
                                            :route="route('admin.toggleStatus', $productType->id) . '?model=' . urlencode(App\Models\ProductType::class)"
                                        />
                                    </td>
                                    <td><a href="{{route('products.types.edit', $productType->id)}}" class="btn btn-sm btn-warning">Edit</a></td>
                                </tr>
                            @empty
                                <td colspan="4" class="text-danger"> No Product Type Found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
