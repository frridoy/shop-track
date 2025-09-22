@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
    <div class="dashboard-content">
        <!-- Statistics Cards Row -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Sales ({{ now()->format('F Y') }})
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $totalSalesMonthly ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-taka-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Orders
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $totalOrders ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Products in Stock
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ $productsInStock ?? 0 }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width:  85%"
                                                aria-valuenow="85 }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Registered Customers
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $registeredCustomers ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Sales Overview</h6>

                        <div class="dropdown no-arrow ms-3" style="margin-left: -10px;">
                            <select id="salesYear" class="form-select form-select-sm">
                                @foreach (range(date('Y'), 2025) as $year)
                                    <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="chart-area" style="position: relative; height:400px;">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add New Product
                            </a>
                            <a href="{{ route('orders.create') }}" class="btn btn-success">
                                <i class="fas fa-shopping-cart me-2"></i>Create Order
                            </a>
                            <a href="{{ route('customers.create') }}" class="btn btn-info">
                                <i class="fas fa-users me-2"></i>Add Customer
                            </a>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-chart-bar me-2"></i>View Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Row -->
        <div class="row">
            <!-- Recent Orders -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Amount (BDT)</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->customer->name ?? $order->customer_name }}</td>
                                            <td>{{ number_format($order->total_price, 2) }}</td>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm open-modal"
                                                    data-url="{{ route('orders.show', $order->id) }}"
                                                    data-title="Order #{{ $order->id }}">
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-danger">Low Stock Alerts</h6>
                        <a href="{{ route('product.lowStock') }}" class="btn btn-sm btn-danger">View All</a>
                    </div>

                    <div id="lowStockSlider">
                        @foreach ($lowStockProducts->chunk(2) as $chunkIndex => $chunk)
                            <div class="low-stock-slide {{ $chunkIndex === 0 ? 'active' : 'd-none' }}">
                                <div class="card-body py-2">
                                    @foreach ($chunk as $lowStockProduct)
                                        <div class="alert alert-warning d-flex align-items-center mb-2 py-2"
                                            role="alert">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <div class="flex-grow-1">
                                                <strong>{{ $lowStockProduct->product_name ?? '' }}</strong><br>
                                                <small>
                                                    Sold: {{ $lowStockProduct->sold_qty ?? 0 }}
                                                    (Available: {{ $lowStockProduct->stock_qty ?? 0 }})
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15);
        }

        .border-left-primary {
            border-left: 0.25rem solid #007bff !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #28a745 !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #17a2b8 !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #ffc107 !important;
        }

        .progress-sm {
            height: 0.5rem;
        }

        .chart-area {
            position: relative;
            height: 400px;
        }

        .chart-pie {
            position: relative;
            height: 300px;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .text-gray-800 {
            color: #5a5c69 !important;
        }

        .text-gray-300 {
            color: #dddfeb !important;
        }

        @media (max-width: 768px) {
            .chart-area {
                height: 300px;
            }

            .chart-pie {
                height: 250px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(0, 123, 255, 0.4)');
        gradient.addColorStop(1, 'rgba(0, 123, 255, 0.05)');

        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Sales',
                    data: [],
                    borderColor: '#007bff',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '৳' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => '৳' + value.toLocaleString()
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        const currentYear = new Date().getFullYear();
        document.getElementById('salesYear').value = currentYear;

        function loadSalesData(year) {
            const url = "{{ route('admin.sales-data', ':year') }}".replace(':year', year);

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    salesChart.data.datasets[0].data = data;
                    salesChart.update();
                });
        }

        loadSalesData(currentYear);

        document.getElementById('salesYear').addEventListener('change', function() {
            loadSalesData(this.value);
        });

        //low stock product slider
        document.addEventListener("DOMContentLoaded", function() {
            const slides = document.querySelectorAll("#lowStockSlider .low-stock-slide");
            let current = 0;

            setInterval(() => {
                slides[current].classList.add("d-none");
                slides[current].classList.remove("active");

                current = (current + 1) % slides.length;

                slides[current].classList.remove("d-none");
                slides[current].classList.add("active");
            }, 2000);
        });

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'doughnut',
            data: {
                labels: ['Online Sales', 'In-Store', 'Wholesale'],
                datasets: [{
                    data: [65, 25, 10],
                    backgroundColor: ['#007bff', '#28a745', '#17a2b8'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush
