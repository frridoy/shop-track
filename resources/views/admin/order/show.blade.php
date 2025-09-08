<div class="container-fluid p-4">
    <!-- Order Header -->
    <div class="mb-4 border-bottom pb-2">
        <h4 class="fw-bold mb-1">Order #{{ $order->id }}</h4>
        <div class="d-flex flex-wrap gap-3 text-muted">
            <div><strong>Branch:</strong> {{ $order->branch->branch_name ?? '' }} <small>({{ $order->branch->branch_code ?? '' }})</small></div>
            <div><strong>Customer:</strong> {{ $order->customer->name ?? $order->customer_name }}</div>
            <div><strong>Contact:</strong> {{ $order->customer->mobile_no ?? $order->customer_mobile }}</div>
            <div><strong>Sold Date:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</div>
        </div>
    </div>

    <!-- Products Table -->
    <h5 class="fw-semibold mb-3">Products</h5>
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center mb-3">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th class="text-start">Product Name</th>
                    <th>Code</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-start">{{ $detail->product->product_name ?? 'N/A' }}</td>
                        <td>{{ $detail->product->product_code ?? 'N/A' }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->selling_price, 2) }}</td>
                        <td>
                            @if($detail->color)
                                <span class="badge bg-info text-dark">{{ $detail->color }}</span>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>
                            @if($detail->size)
                                <span class="badge bg-secondary">{{ $detail->size }}</span>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>{{ number_format($detail->quantity * $detail->selling_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Total Price -->
    <div class="d-flex justify-content-end mt-3">
        <h5 class="fw-bold">Total Price: <span class="text-success">{{ number_format($order->total_price, 2) }}</span></h5>
    </div>
</div>
