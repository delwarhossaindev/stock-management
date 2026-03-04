<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Register') }} - {{ __('Stock Management') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e2a3a 0%, #2d1b4e 50%, #1e2a3a 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body::before {
            content: '';
            position: fixed;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(124, 58, 237, 0.06) 0%, transparent 50%);
            animation: bgShift 15s ease-in-out infinite alternate;
            z-index: 0;
        }
        @keyframes bgShift {
            0%   { transform: translate(0, 0); }
            100% { transform: translate(-5%, 3%); }
        }
        .register-card {
            max-width: 440px;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        .register-card .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        }
        .register-card .card-body { padding: 2.5rem !important; }
        .register-card .bi-box-seam {
            color: #4f46e5;
            filter: drop-shadow(0 0 12px rgba(79, 70, 229, 0.3));
        }
        .register-card h4 { font-weight: 700; color: #1e293b; }
        .register-card .form-control {
            border-radius: 0.5rem;
            padding: 0.65rem 0.85rem;
            border: 1.5px solid #e2e8f0;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .register-card .form-control:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .register-card .form-label { font-weight: 500; font-size: 0.85rem; color: #475569; }
        .register-card .input-group-text {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 0.5rem 0 0 0.5rem;
            color: #94a3b8;
        }
        .register-card .input-group .form-control {
            border-left: none;
            border-radius: 0 0.5rem 0.5rem 0;
        }
        .register-card .input-group:focus-within .input-group-text {
            border-color: #818cf8;
            color: #4f46e5;
        }
        .register-card .input-group:focus-within .form-control {
            border-color: #818cf8;
        }
        .register-card .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: 0.5rem;
            padding: 0.65rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        .register-card .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
            background: linear-gradient(135deg, #4338ca, #6d28d9);
        }
        .register-card a { color: #4f46e5; font-weight: 500; }
        .register-card a:hover { color: #4338ca; }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-card mx-auto">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-box-seam fs-1 text-primary"></i>
                        <h4 class="mt-2">{{ __('Stock Management') }}</h4>
                        <p class="text-muted">{{ __('Create new account') }}</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Name') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Confirm Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('Register') }}</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none">{{ __('Have account? Login') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
