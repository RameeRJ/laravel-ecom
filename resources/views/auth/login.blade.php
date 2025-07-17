<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | ShopEase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            min-height: 100vh;
        }
        .card {
            border: none;
            box-shadow: 0 4px 24px 0 rgba(99,102,241,0.08);
        }
        .btn-primary {
            background-color: #6366f1;
            border-color: #6366f1;
        }
        .btn-primary:hover {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        .form-label {
            color: #3730a3;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card p-4">
                <div class="card-body">
                    <h4 class="mb-4 text-center text-primary fw-bold">Login to ShopEase</h4>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        <div class="text-center mt-3">
                            <a href="{{ route('register') }}" class="btn btn-link">Don't have an account? Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>