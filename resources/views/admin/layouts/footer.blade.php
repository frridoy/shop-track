<footer class="footer bg-white border-top mt-auto">
    <div class="container-fluid">
        <div class="row py-3">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <span class="text-muted small">
                        &copy; {{ date('Y') }}
                        <strong class="text-primary">ShopTrack</strong>
                        Admin Panel. All rights reserved.
                    </span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-md-end justify-content-start mt-2 mt-md-0">
                    <div class="d-flex align-items-center me-4">
                        <span class="text-muted small">Version 1.0.0</span>
                    </div>

                    <div class="footer-links">
                        <a href="#" class="text-muted small text-decoration-none me-3" title="Help & Support">
                            <i class="fas fa-question-circle"></i>
                            Help
                        </a>
                        <a href="#" class="text-muted small text-decoration-none me-3" title="Documentation">
                            <i class="fas fa-book"></i>
                            Docs
                        </a>
                        <a href="#" class="text-muted small text-decoration-none" title="Contact Support">
                            <i class="fas fa-envelope"></i>
                            Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer {
        margin-top: auto;
    }

    .status-indicator .badge {
        font-size: 10px;
        padding: 4px 8px;
    }

    .footer-links a:hover {
        color: #007bff !important;
    }

    @media (max-width: 768px) {
        .footer .row>div {
            text-align: center !important;
        }

        .footer-links {
            margin-top: 10px;
        }

        .footer .d-flex.justify-content-md-end {
            justify-content: center !important;
            flex-wrap: wrap;
        }

        .footer .d-flex.justify-content-md-end>div {
            margin: 5px;
        }
    }
</style>
