<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorized Access - LGU H&S Compliance</title>
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            background: radial-gradient(circle at 50% 50%, #f1f5f9 0%, #cbd5e1 100%);
            margin: 0;
            padding: 20px;
        }
        [data-theme="dark"] body {
            background: radial-gradient(circle at 50% 50%, #1e293b 0%, #0f172a 100%);
        }
        
        .login-card { 
            background: var(--card-bg-1); 
            padding: 3.5rem 2.5rem; 
            border-radius: 1.5rem; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%; 
            max-width: 460px;
            border: 1px solid var(--border-color-1);
            position: relative;
            overflow: hidden;
        }
        
        .login-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color-1), #0ea5e9);
        }

        .login-header { 
            text-align: center; 
            margin-bottom: 2.5rem; 
        }
        
        .logo-box {
            width: 80px;
            height: 80px;
            background: rgba(76, 138, 137, 0.1);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        
        .logo-box i {
            font-size: 2.5rem;
            color: var(--primary-color-1);
        }

        .login-header h2 {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--text-color-1);
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: var(--text-secondary-1);
            font-size: 0.95rem;
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            color: var(--text-color-1);
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary-1);
            transition: color 0.2s ease;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 1px solid var(--border-color-1);
            border-radius: 0.75rem;
            background: var(--bg-color-1);
            color: var(--text-color-1);
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color-1);
            box-shadow: 0 0 0 4px rgba(76, 138, 137, 0.15);
        }

        .form-control:focus + i {
            color: var(--primary-color-1);
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            font-size: 1.125rem;
            font-weight: 700;
            margin-top: 1rem;
            background-color: var(--primary-color-1);
            border: none;
            color: white;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(76, 138, 137, 0.3);
            filter: brightness(1.1);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .login-footer {
            text-align: center;
            margin-top: 2.5rem;
            color: var(--text-secondary-1);
            font-size: 0.875rem;
        }

        .back-to-home {
            position: fixed;
            top: 2rem;
            left: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-color-1);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.75rem 1.25rem;
            background: var(--card-bg-1);
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color-1);
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .back-to-home:hover {
            transform: translateX(-5px);
            color: var(--primary-color-1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
</style>
    <script>
        // Disable back button navigation for login/otp pages
        (function() {
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function() {
                window.history.pushState(null, null, window.location.href);
            };
        })();
    </script>
</head>
<body>
    <a href="/" class="back-to-home">
        <i class="fas fa-arrow-left"></i>
        <span>Back to Home</span>
    </a>

    <div class="login-card">
        <div class="login-header">
            <div class="logo-box">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h2>Personnel Portal</h2>
            <p>Authorized access only</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle" style="margin-right: 0.75rem;"></i>
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <input type="email" name="email" class="form-control" placeholder="name@lgu.gov.ph" required autocomplete="email">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Access Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Identity Sign In
            </button>
        </form>

        <div class="login-footer">
            <p>&copy; <?= date('Y') ?> LGU Health & Safety Protection Bureau</p>
        </div>
    </div>
</body>
</html>
