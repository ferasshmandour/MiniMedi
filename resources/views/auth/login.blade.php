<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - {{ trans('messages.login') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }

        .login-header {
            text-align: center;
            padding: 2rem 2rem 1rem;
            border-bottom: 1px solid #e9ecef;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .login-header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0;
        }

        .login-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
            color: white;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
            color: white;
        }

        .test-accounts {
            margin-top: 1.5rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 0.5rem;
            border: 1px solid #e9ecef;
        }

        .test-accounts h6 {
            color: #2c3e50;
            margin-bottom: 0.75rem;
        }

        .account-item {
            font-size: 0.85rem;
            padding: 0.25rem 0;
            color: #495057;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <h1>🏥 MiniMedi</h1>
            <p>{{ trans('messages.hospital_management_system') }}</p>
        </div>

        <div class="login-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">{{ trans('messages.email_address') }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                        required autofocus placeholder="{{ trans('messages.enter_email') }}">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ trans('messages.password') }}</label>
                    <input type="password" class="form-control" id="password" name="password" required
                        placeholder="{{ trans('messages.enter_password') }}">
                </div>

                <button type="submit" class="btn btn-login w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>{{ trans('messages.login') }}
                </button>
            </form>

            <div class="test-accounts">
                <h6><i class="bi bi-info-circle me-2"></i>{{ trans('messages.test_accounts') }}</h6>
                <div class="account-item">
                    <strong>{{ trans('messages.admin') }}:</strong> admin@hospital.com
                </div>
                <div class="account-item">
                    <strong>{{ trans('messages.doctor') }}:</strong> doctor@hospital.com
                </div>
                <div class="account-item">
                    <strong>{{ trans('messages.patient') }}:</strong> patient@example.com
                </div>
                <div class="account-item text-muted mt-2">
                    <small>Password: password123</small>
                </div>
            </div>

            <a href="/" class="back-link">
                <i class="bi bi-arrow-left me-1"></i>{{ trans('messages.back_to_home') }}
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
