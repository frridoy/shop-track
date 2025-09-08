@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="font-size: 1rem;">Add Order</h5>
                <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">Add New Order</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3 fw-bold" style="font-size: 1rem;">Branch List</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Branch</th>
                                <th>Customer</th>
                                <th>Contact</th>
                                <th>Products</th>
                                <th>Total Price</th>
                                <th>Sold Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->branch->branch_name ?? 'N/A' }}
                                        <br>
                                        <i>{{ $order->branch->branch_code ?? 'N/A' }}</i>
                                    </td>
                                    <td>{{ $order->customer->name ?? $order->customer_name }}</td>
                                    <td>{{ $order->customer->mobile_no ?? $order->customer_mobile }}</td>
                                    <td class="text-center">
                                        @foreach ($order->orderDetails as $detail)
                                            <div class="border-bottom py-1">
                                                <div class="fw-semibold">{{ $detail->product->product_name ?? 'N/A' }}</div>
                                                <small class="text-muted">
                                                    Code: {{ $detail->product->product_code ?? 'N/A' }} |
                                                    Qty: {{ $detail->quantity }} |
                                                    Price: {{ number_format($detail->selling_price, 2) }}
                                                    @if ($detail->color)
                                                        | Color: {{ $detail->color }}
                                                    @endif
                                                    @if ($detail->size)
                                                        | Size: {{ $detail->size }}
                                                    @endif
                                                </small>
                                            </div>
                                        @endforeach
                                    </td>

                                    <td>{{ number_format($order->total_price, 2) }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <td colspan="8" class="text-danger"> No Order Found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
