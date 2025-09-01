@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Add New Product Type</h4>
            <a href="{{ route('products.types.index') }}" class="btn btn-secondary btn-sm">Back to Product Types</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('products.types.update', $productType->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="product_type_name" class="form-label fw-bold">Product Type Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="product_type_name" id="product_type_name"
                                class="form-control form-control-sm" placeholder="Enter product type name"
                                value="{{ $productType->product_type_name }}" required>
                            <span class="text-danger">
                                @error('product_type_name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-4">
                            <label for="is_active" class="form-label fw-bold">Status <span
                                    class="text-danger">*</span></label>
                            <select name="is_active" id="is_active" class="form-select form-select-sm" required>
                                <option value="1" {{ $productType->is_active == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $productType->is_active == 0 ? 'selected' : '' }}>Inactive
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('products.types.index') }}" class="btn btn-secondary btn-sm me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Update Product Type</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
