<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LGU Health & Safety</title>
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/textfield.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --login-bg: #f8fafc;
        }
        body { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            background-color: var(--login-bg);
            font-family: var(--font-family-1);
            margin: 0;
            padding: 20px;
        }
        .login-card { 
            background: white; 
            padding: 3rem 2.5rem; 
            border-radius: 1.25rem; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 100%; 
            max-width: 440px;
            border: 1px solid var(--border-color-1);
        }
        .login-header { 
            text-align: center; 
            margin-bottom: 2.5rem; 
        }
        .login-header img { 
            width: 100px; 
            margin-bottom: 1.5rem;
        }
        .login-header h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--dark-color-1);
            letter-spacing: -0.025em;
            margin: 0;
        }
        .form-group {
            margin-bottom: 1.5rem;
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
            font-size: 1rem;
        }
        .form-control {
            padding-left: 2.75rem !important;
            height: 3.25rem;
            font-size: 0.95rem;
        }
        .btn-login {
            width: 100%;
            height: 3.25rem;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 1rem;
            background-color: var(--primary-color-1);
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-login:hover {
            background-color: #3d6e6d;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 138, 137, 0.25);
        }
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color-1);
        }
        .login-footer p {
            font-size: 0.875rem;
            color: var(--text-secondary-1);
            font-weight: 500;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <img src="/images/logo.svg" alt="LGU Logo">
            <h2>Health & Safety System</h2>
        </div>

        <?php 
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['error'])): 
        ?>
            <div style="background: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.875rem; text-align: center; border: 1px solid #fecaca;">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" class="form-control" 
                           required placeholder="admin@lgu.gov.ph" autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" class="form-control" 
                           required placeholder="••••••••">
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: var(--text-secondary-1); cursor: pointer;">
                    <input type="checkbox" style="width: 1rem; height: 1rem; cursor: pointer;"> Remember me
                </label>
                <a href="#" style="font-size: 0.875rem; color: var(--primary-color-1); text-decoration: none; font-weight: 600;">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-primary btn-login">
                Sign In <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
            </button>
        </form>

        <div class="login-footer">
            <p>Local Government Unit - Health & Safety Dept</p>
        </div>
    </div>
</body>
</html>
