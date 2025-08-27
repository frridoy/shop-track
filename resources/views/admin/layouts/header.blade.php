<header class="header bg-white shadow-sm py-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <!-- Sidebar Toggle Button -->
                    <button class="btn btn-link d-none d-md-block me-3" onclick="toggleSidebar()"
                        style="text-decoration: none;">
                        <i class="fas fa-bars text-dark"></i>
                    </button>

                    <!-- Mobile Sidebar Toggle -->
                    <button class="btn btn-link d-md-none me-3" onclick="toggleMobileSidebar()"
                        style="text-decoration: none;">
                        <i class="fas fa-bars text-dark"></i>
                    </button>

                    <!-- Search Box -->
                    <div class="search-box">
                        <form class="d-flex" role="search">
                            <div class="input-group">
                                <input class="form-control" type="search" placeholder="Search products, orders..."
                                    aria-label="Search" style="border-right: none;">
                                <span class="input-group-text bg-white" style="border-left: none;">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- Notifications -->
                    <div class="dropdown me-3">
                        <button class="btn btn-link position-relative" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="text-decoration: none;">
                            <i class="fas fa-bell text-dark fs-5"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 10px;">
                                3
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="width: 300px;">
                            <li>
                                <h6 class="dropdown-header">Notifications</h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-shopping-cart text-success me-2"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold">New Order Received</div>
                                            <div class="text-muted small">Order #12345 from John Doe</div>
                                            <div class="text-muted small">2 minutes ago</div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold">Low Stock Alert</div>
                                            <div class="text-muted small">iPhone 15 Pro - Only 2 left</div>
                                            <div class="text-muted small">5 minutes ago</div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-center" href="#">View All Notifications</a></li>
                        </ul>
                    </div>

                    <!-- Messages -->
                    <div class="dropdown me-3">
                        <button class="btn btn-link position-relative" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="text-decoration: none;">
                            <i class="fas fa-envelope text-dark fs-5"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary"
                                style="font-size: 10px;">
                                5
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="width: 280px;">
                            <li>
                                <h6 class="dropdown-header">Messages</h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=0d6efd&color=fff"
                                            class="rounded-circle me-2" width="32" height="32" alt="User">
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold small">Sarah Johnson</div>
                                            <div class="text-muted small">Question about my order...</div>
                                        </div>
                                        <div class="text-muted small">1h</div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-center" href="#">View All Messages</a></li>
                        </ul>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-link d-flex align-items-center" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="text-decoration: none;">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin User' }}&background=28a745&color=fff"
                                class="rounded-circle me-2" width="32" height="32" alt="Profile">
                            <div class="d-none d-md-block text-start">
                                <div class="fw-semibold text-dark small">{{ Auth::user()->name ?? 'Admin User' }}</div>
                                <div class="text-muted small">Administrator</div>
                            </div>
                            <i class="fas fa-chevron-down text-muted ms-2"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">Account</h6>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>My
                                    Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a>
                            </li>
                            <li><a class="dropdown-item" href="#"><i
                                        class="fas fa-bell me-2"></i>Preferences</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    .header {
        border-bottom: 1px solid #dee2e6;
    }

    .search-box {
        width: 300px;
    }

    @media (max-width: 768px) {
        .search-box {
            width: 200px;
        }
    }

    @media (max-width: 576px) {
        .search-box {
            display: none;
        }
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 8px;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
</style>
