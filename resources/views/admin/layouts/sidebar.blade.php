<aside id="sidebar" class="sidebar bg-dark">
    <div class="sidebar-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-store text-primary fs-3 me-2"></i>
                <div class="sidebar-title">
                    <h4 class="text-white mb-0">ShopTrack</h4>
                    <small class="text-muted">Admin Panel</small>
                </div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') ?? '#' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Products Management -->
            <li class="nav-item">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#productsMenu" aria-expanded="false">
                    <i class="fas fa-box"></i>
                    <span class="nav-text">Products</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.products.*') ? 'show' : '' }}" id="productsMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link sub-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
                                href="#">
                                <i class="fas fa-list"></i>
                                <span class="nav-text">All Products</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}"
                                href="#">
                                <i class="fas fa-plus"></i>
                                <span class="nav-text">Add Product</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                                href="#">
                                <i class="fas fa-tags"></i>
                                <span class="nav-text">Categories</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}"
                                href="#">
                                <i class="fas fa-trademark"></i>
                                <span class="nav-text">Brands</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Inventory Management -->
            <li class="nav-item">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#inventoryMenu" aria-expanded="false">
                    <i class="fas fa-warehouse"></i>
                    <span class="nav-text">Inventory</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.inventory.*') ? 'show' : '' }}" id="inventoryMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-boxes"></i>
                                <span class="nav-text">Stock Management</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span class="nav-text">Low Stock Alerts</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-truck"></i>
                                <span class="nav-text">Stock Movement</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Orders Management -->
            <li class="nav-item">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#ordersMenu" aria-expanded="false">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="nav-text">Orders</span>
                    {{-- <span class="badge bg-danger ms-auto">12</span> --}}
                </a>
                <div class="collapse {{ request()->routeIs('admin.orders.*') ? 'show' : '' }}" id="ordersMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-list-alt"></i>
                                <span class="nav-text">All Orders</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-clock"></i>
                                <span class="nav-text">Pending Orders</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-check-circle"></i>
                                <span class="nav-text">Completed Orders</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-ban"></i>
                                <span class="nav-text">Cancelled Orders</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Customers Management -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" href="#">
                    <i class="fas fa-users"></i>
                    <span class="nav-text">Customers</span>
                </a>
            </li>

            <!-- Reports & Analytics -->
            <li class="nav-item">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#reportsMenu" aria-expanded="false">
                    <i class="fas fa-chart-bar"></i>
                    <span class="nav-text">Reports</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.reports.*') ? 'show' : '' }}" id="reportsMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-dollar-sign"></i>
                                <span class="nav-text">Sales Report</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-box-open"></i>
                                <span class="nav-text">Inventory Report</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-user-chart"></i>
                                <span class="nav-text">Customer Report</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Settings -->
            <li class="nav-item">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#settingsMenu" aria-expanded="false">
                    <i class="fas fa-cog"></i>
                    <span class="nav-text">Settings</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.settings.*') ? 'show' : '' }}" id="settingsMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-store-alt"></i>
                                <span class="nav-text">Store Settings</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-credit-card"></i>
                                <span class="nav-text">Payment Methods</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-shipping-fast"></i>
                                <span class="nav-text">Shipping Options</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sub-link" href="#">
                                <i class="fas fa-user-cog"></i>
                                <span class="nav-text">User Management</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</aside>

<style>
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 250px;
        transition: all 0.3s ease;
        z-index: 1000;
        overflow-y: auto;
    }

    .sidebar.collapsed {
        width: 70px;
    }

    .sidebar.collapsed .sidebar-title,
    .sidebar.collapsed .nav-text {
        display: none;
    }

    .sidebar-header {
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-title h4 {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .sidebar-nav {
        padding: 20px 0;
    }

    .nav-link {
        color: #adb5bd !important;
        padding: 12px 20px;
        border-radius: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .nav-link:hover {
        color: #fff !important;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .nav-link.active {
        color: #fff !important;
        background-color: #007bff;
    }

    .nav-link i {
        width: 20px;
        font-size: 16px;
        margin-right: 12px;
    }

    .sub-link {
        padding-left: 45px !important;
        font-size: 0.9rem;
    }

    .sub-link i {
        width: 16px;
        font-size: 14px;
        margin-right: 10px;
    }

    .badge {
        font-size: 10px;
    }

    /* Mobile Styles */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar.collapsed {
            width: 250px;
        }
    }

    /* Custom Scrollbar */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: #2c3e50;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: #007bff;
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: #0056b3;
    }
</style>
