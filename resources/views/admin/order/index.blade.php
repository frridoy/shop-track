@extends('admin.layouts.app')

@section('content')
<div class="container-fluid" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 0.9rem;">

    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold" style="font-size: 1rem;">Orders</h5>
            <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">Add New Order</a>
        </div>
    </div>

    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <form action="{{ route('orders.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" value="{{ request('customer_name') }}" class="form-control form-control-sm" placeholder="Enter customer name">
                </div>
                <div class="col-md-4">
                    <label> Customer Email</label>
                    <input type="text" name="customer_email" value="{{ request('customer_email') }}" class="form-control form-control-sm" placeholder="Enter customer email">
                </div>
                <div class="col-md-4">
                    <label>Customer Mobile</label>
                    <input type="text" name="customer_mobile" value="{{ request('customer_mobile') }}" class="form-control form-control-sm" placeholder="Enter customer mobile">
                </div>

                @if(Auth::user()->user_type == 1)
                <div class="col-md-3">
                    <label>Branch</label>
                    <select name="branch_id" class="form-control form-control-sm">
                        <option value="">All Branches</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2)
                <div class="col-md-3">
                    <label>Seller Name</label>
                    <select name="seller_id" class="form-control form-control-sm">
                        <option value="">All Sellers</option>
                        @foreach ($sellers as $seller)
                            <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                {{ $seller->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-md-3">
                    <label>From Date</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <label>To Date</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3 fw-bold" style="font-size: 1rem;">Order List</h5>
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
                            <th>Seller</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->branch->branch_name ?? 'N/A' }}<br><i>{{ $order->branch->branch_code ?? 'N/A' }}</i></td>
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
                                                @if ($detail->color) | Color: {{ $detail->color }} @endif
                                                @if ($detail->size) | Size: {{ $detail->size }} @endif
                                            </small>
                                        </div>
                                    @endforeach
                                </td>
                                <td>{{ number_format($order->total_price, 2) }}</td>
                                <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $order->seller->name ?? '' }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm open-modal"
                                        data-url="{{ route('orders.show', $order->id) }}"
                                        data-title="Order #{{ $order->id }}">
                                        View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-danger">No Order Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2 text-end fw-bold">
                Total Amount: {{ number_format($totalAmount, 2) }}
            </div>
        </div>
    </div>

</div>
@endsection
