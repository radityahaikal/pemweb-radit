<!doctype html>
<html lang="en">
<head>
    <title>Login - Sistem Purbalingga Knalpot</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #064469, #5790AB);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            padding: 50px;
            max-width: 450px;
            width: 100%;
        }
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .login-header h1 {
            color: #072D44;
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .login-header p {
            color: #666;
            font-size: 14px;
        }
        .form-group label {
            color: #072D44;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .form-control {
            border: 1px solid #e3e6f0;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #5790AB;
            box-shadow: 0 0 0 0.2rem rgba(87, 144, 171, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #064469, #5790AB);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 10px;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #042a4d, #476b8a);
            color: white;
        }
        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }
        .forgot-password a {
            color: #5790AB;
            text-decoration: none;
            font-size: 14px;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
        .register-link a {
            color: #5790AB;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #5790AB;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-cube"></i> Purbalingga Knalpot</h1>
            <p>Sistem Manajemen Produksi & Penjualan</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <strong>Login Gagal!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-info" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="info-box">
            <strong>Demo Credentials:</strong><br>
            Admin: admin@example.com / password123<br>
            Cashier: cashier@example.com / password123
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email Anda">
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="remember_me" class="custom-control custom-checkbox">
                    <input id="remember_me" type="checkbox" class="custom-control-input" name="remember">
                    <span class="custom-control-label" style="color: #666; font-size: 14px;">Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>

            @if (Route::has('password.request'))
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">Lupa password?</a>
                </div>
            @endif

            @if (Route::has('register'))
                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                </div>
            @endif
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
