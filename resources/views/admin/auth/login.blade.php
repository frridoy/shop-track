<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome (for icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        body {
            /* background: linear-gradient(135deg, #4e73df 0%, #1cc88a 100%); */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            border-radius: 15px;
        }
        .login-header {
            font-weight: 600;
            color: #4e73df;
        }
        .form-label {
            font-weight: 500;
        }
        .btn-login {
            border-radius: 8px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 shadow-lg login-card">
        <div class="text-center mb-4">
            <i class="fas fa-user-circle fa-3x text-primary"></i>
            <h3 class="login-header mt-2">Welcome Back</h3>
            <p class="text-muted">Please login to your account</p>
        </div>

        <form action="{{ url('/login') }}" method="POST" novalidate>
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required
                       autofocus>
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <button class="btn btn-primary w-100 btn-login">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Show/Hide password toggle
        function togglePassword() {
            const password = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");

            if (password.type === "password") {
                password.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                password.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }

        (function() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "4000"
            };

            function showToastr(message, type) {
                switch (type) {
                    case 'success': toastr.success(message); break;
                    case 'error': toastr.error(message); break;
                    case 'info': toastr.info(message); break;
                    case 'warning': toastr.warning(message); break;
                }
            }

            @if (Session::has('success'))
                showToastr("{{ session('success') }}", 'success');
            @endif

            @if (Session::has('error'))
                showToastr("{{ session('error') }}", 'error');
            @endif

            @if (Session::has('warning'))
                showToastr("{{ session('warning') }}", 'warning');
            @endif

            @if (Session::has('info'))
                showToastr("{{ session('info') }}", 'info');
            @endif

            @if (Session::has('message'))
                showToastr("{{ session('message') }}", 'success');
            @endif
        })();
    </script>

</body>
</html>
