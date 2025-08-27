<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shop Track Admin') }} - @yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        .content-wrapper {
            padding: 20px;
            min-height: calc(100vh - 120px);
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }

        .page-header {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            margin: 0;
            color: #333;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .breadcrumb-nav {
            margin-top: 10px;
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main-content">
            @include('admin.layouts.header')

            <div class="content-wrapper">
                <div class="page-header">
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('breadcrumb')
                        <nav class="breadcrumb-nav" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                    @endif
                </div>
                @yield('content')
            </div>
            @include('admin.layouts.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');

            sidebar.classList.toggle('collapsed');
            if (sidebar.classList.contains('collapsed')) {
                mainContent.style.marginLeft = '70px';
            } else {
                mainContent.style.marginLeft = '250px';
            }
        }

        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>

    @stack('scripts')
</body>

</html>
