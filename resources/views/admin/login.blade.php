<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Pemerintah Desa Duren</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #1e3a8a;
            --primary-light: #2563eb;
            --accent: #f59e0b;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --bg-main: #f8fafc;
            --white: #ffffff;
            --border-color: #e2e8f0;
            --radius-md: 8px;
            --radius-lg: 16px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.08);
            border: 1px solid rgba(37, 99, 235, 0.1);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
            padding: 40px;
            display: flex;
            flex-direction: column;
        }

        .login-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .login-logo img {
            height: 48px;
        }

        .login-logo span {
            font-weight: 800;
            font-size: 1.3rem;
            color: var(--primary);
            line-height: 1.1;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            font-size: 0.95rem;
            outline: none;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .remember-forgot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            font-size: 0.85rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-light);
            color: var(--white);
            border: none;
            border-radius: var(--radius-md);
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 400px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: opacity 0.4s ease, transform 0.4s ease;
            opacity: 1;
            transform: translateY(0);
        }

        .alert.hide {
            opacity: 0;
            transform: translateY(-20px);
        }

        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="login-logo">
            <img src="{{ asset('img/logo-semarang.png') }}" alt="Logo">
            <span>PORTAL DESA<br>DUREN TENGARAN</span>
        </div>

        <div class="login-header">
            <h1>Login Admin</h1>
            <p>Masukkan kredensial untuk masuk ke panel admin.</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exmark"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exmark"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="admin@duren.desa.id"
                    required autofocus value="{{ old('email') }}">
            </div>

            <div class="form-group" style="margin-bottom: 25px;">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••"
                    required>
            </div>

            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    Ingat Saya
                </label>
            </div>

            <button type="submit" class="btn-submit">
                Masuk <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </button>
        </form>
    </div>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function (alert) {
            // Create close button
            const closeBtn = document.createElement('button');
            closeBtn.innerHTML = '&times;';
            closeBtn.className = 'alert-close-btn';

            // Style close button dynamically
            closeBtn.style.background = 'none';
            closeBtn.style.border = 'none';
            closeBtn.style.fontSize = '1.3rem';
            closeBtn.style.lineHeight = '1';
            closeBtn.style.cursor = 'pointer';
            closeBtn.style.marginLeft = 'auto';
            closeBtn.style.padding = '0 0 0 12px';
            closeBtn.style.color = 'inherit';
            closeBtn.style.opacity = '0.5';
            closeBtn.style.transition = 'opacity 0.2s';
            closeBtn.setAttribute('aria-label', 'Close alert');

            closeBtn.addEventListener('mouseenter', () => closeBtn.style.opacity = '1');
            closeBtn.addEventListener('mouseleave', () => closeBtn.style.opacity = '0.5');

            alert.appendChild(closeBtn);

            // Dismiss function
            const dismiss = () => {
                alert.classList.add('hide');
                setTimeout(() => {
                    alert.remove();
                }, 400); // Wait for CSS transition
            };

            // Close button click listener
            closeBtn.addEventListener('click', dismiss);

            // Auto-dismiss after 4 seconds
            setTimeout(dismiss, 4000);
        });
    });
</script>

</html>