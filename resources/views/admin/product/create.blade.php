@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Add New Product</h4>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Back to Products</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">Product Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm"
                                placeholder="Enter product name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="category" class="form-label fw-bold">Category <span
                                    class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-select form-select-sm" required>
                                <option value="">Select Category</option>
                                <option value="Category A">Category A</option>
                                <option value="Category B">Category B</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="price" class="form-label fw-bold">Price <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="price" id="price" class="form-control form-control-sm"
                                placeholder="Enter price" min="0" step="0.01" required>
                        </div>

                        <div class="col-md-4">
                            <label for="stock" class="form-label fw-bold">Stock Quantity <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="stock" id="stock" class="form-control form-control-sm"
                                placeholder="Enter stock quantity" min="0" required>
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label fw-bold">Status <span
                                    class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select form-select-sm" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="image" class="form-label fw-bold">Product Image</label>
                            <input type="file" name="image" id="image" class="form-control form-control-sm"
                                accept="image/*">
                        </div>

                        <div class="col-md-6">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control form-control-sm"
                                placeholder="Enter product description"></textarea>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save Product</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
