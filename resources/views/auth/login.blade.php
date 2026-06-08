<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMII System Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex; align-items: center; justify-content: center;
            margin: 0;
            color: #111827;
        }
        .login-wrapper {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        .login-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 40px 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        .brand-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            text-align: center;
            margin-bottom: 5px;
            letter-spacing: -0.025em;
        }
        .brand-subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 30px;
        }
        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 0.95rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            outline: none;
        }
        .btn-login {
            background-color: #0f172a;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 10px 16px;
            font-weight: 500;
            width: 100%;
            margin-top: 10px;
            font-size: 0.95rem;
            transition: 0.15s ease-in-out;
        }
        .btn-login:hover {
            background-color: #1e293b;
        }
        .password-wrapper {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
        }
        .password-toggle:hover {
            color: #4b5563;
        }
        .rbac-info {
            margin-top: 25px;
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
            padding: 15px;
            font-size: 0.8rem;
            color: #475569;
        }
        .rbac-info strong {
            color: #0f172a;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="brand-title">TMII Admin</div>
            <div class="brand-subtitle">Sign in to your account</div>

            @if(session('error'))
                <div class="alert alert-danger" style="font-size: 0.85rem; padding: 10px; border-radius: 6px;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="alamat@email.com" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                        <i class="fa-regular fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                </div>
                <button type="submit" class="btn-login">Sign in</button>
            </form>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
