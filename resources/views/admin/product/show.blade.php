<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            <h4 class="fw-bold mb-3 text-primary">
                {{ $product->product_name }}
            </h4>

            <div class="row g-3 text-muted">
                <div class="col-md-4 col-sm-6">
                    <strong class="text-dark">Type:</strong>
                    {{ $product->type->product_type_name ?? 'N/A' }}
                </div>

                <div class="col-md-4 col-sm-6">
                    <strong class="text-dark">Product Code:</strong>
                    {{ $product->product_code ?? '-' }}
                </div>

                <div class="col-md-4 col-sm-6">
                    <strong class="text-dark">Color:</strong>
                    {{ $color ?? '-' }}
                </div>

                <div class="col-md-4 col-sm-6">
                    <strong class="text-dark">Size:</strong>
                    {{ $size ?? '-' }}
                </div>

                <div class="col-md-4 col-sm-6">
                    <strong class="text-dark">Selling Price:</strong>
                    <span class="fw-semibold text-success">
                        {{ number_format($product->selling_price, 2 ?? 0) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
