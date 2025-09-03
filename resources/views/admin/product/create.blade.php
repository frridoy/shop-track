@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <h4 class="fw-bold mb-3">Add Products</h4>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Product Type <span class="text-danger">*</span></label>
                <select name="product_type_id" class="form-select form-select-sm">
                    <option value="">Select Product Type</option>
                    @foreach ($productTypes as $type)
                        <option value="{{ $type->id }}" {{ old('product_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->product_type_name }}</option>
                    @endforeach
                </select>
                @error('product_type_id')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div id="products-wrapper">
                @php
                    $oldProducts = old('products', [0 => []]);
                @endphp

                @foreach ($oldProducts as $i => $oldProduct)
                    <div class="product-card border rounded shadow-sm p-3 mb-4 bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold mb-0">Product {{ $i + 1 }}</h6>
                            <button type="button" class="btn btn-outline-danger btn-sm remove-card">× Remove</button>
                        </div>
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="products[{{ $i }}][product_name]"
                                    class="form-control form-control-sm" value="{{ $oldProduct['product_name'] ?? '' }}">
                                @error("products.$i.product_name")
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="products[{{ $i }}][remarks]"
                                    class="form-control form-control-sm" value="{{ $oldProduct['remarks'] ?? '' }}">
                                @error("products.$i.remarks")
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Color</label>
                                <select name="products[{{ $i }}][color]" class="form-select form-select-sm">
                                    <option value="">Select</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}"
                                            {{ isset($oldProduct['color']) && $oldProduct['color'] == $color->id ? 'selected' : '' }}>
                                            {{ $color->lookup_name }}</option>
                                    @endforeach
                                </select>
                                @error("products.$i.color")
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Size</label>
                                <select name="products[{{ $i }}][size]" class="form-select form-select-sm">
                                    <option value="">Select</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}"
                                            {{ isset($oldProduct['size']) && $oldProduct['size'] == $size->id ? 'selected' : '' }}>
                                            {{ $size->lookup_name }}</option>
                                    @endforeach
                                </select>
                                @error("products.$i.size")
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="products[{{ $i }}][is_active]" class="form-select form-select-sm">
                                    <option value="1"
                                        {{ isset($oldProduct['is_active']) && $oldProduct['is_active'] == 1 ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0"
                                        {{ isset($oldProduct['is_active']) && $oldProduct['is_active'] == 0 ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                @error("products.$i.is_active")
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Stock Qty <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="products[{{ $i }}][stock_qty]"
                                    class="form-control form-control-sm" value="{{ $oldProduct['stock_qty'] ?? 0 }}">
                                @error("products.$i.stock_qty")
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Purchase Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="products[{{ $i }}][purchase_price]"
                                    class="form-control form-control-sm" value="{{ $oldProduct['purchase_price'] ?? 0 }}">
                                @error("products.$i.purchase_price")
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Selling Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="products[{{ $i }}][selling_price]"
                                    class="form-control form-control-sm" value="{{ $oldProduct['selling_price'] ?? 0 }}">
                                @error("products.$i.selling_price")
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Bottom Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="products[{{ $i }}][bottom_price]"
                                    class="form-control form-control-sm" value="{{ $oldProduct['bottom_price'] ?? 0 }}">
                                @error("products.$i.bottom_price")
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <button type="button" id="add-product" class="btn btn-success btn-sm">+ Add Another Product</button>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm me-2">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>
        </form>
    </div>

    <script>
        let index = {{ count(old('products', [0])) }};

        document.getElementById('add-product').addEventListener('click', function() {
            const wrapper = document.getElementById('products-wrapper');
            const firstCard = wrapper.querySelector('.product-card');
            const newCard = firstCard.cloneNode(true);

            newCard.querySelectorAll('input, select').forEach(el => {
                const name = el.getAttribute('name').replace(/\d+/, index);
                el.setAttribute('name', name);
                if (el.tagName === 'SELECT') el.selectedIndex = 0;
                else el.value = el.type === 'number' ? 0 : '';
            });

            newCard.querySelector("h6").innerText = "Product " + (index + 1);

            wrapper.appendChild(newCard);
            index++;
        });

        document.getElementById('products-wrapper').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-card')) {
                const cards = document.querySelectorAll('.product-card');
                if (cards.length > 1) e.target.closest('.product-card').remove();
            }
        });
    </script>
@endsection
