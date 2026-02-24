<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - LGU H&S Compliance</title>
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
            background: var(--card-bg-1, #ffffff); 
            padding: 3.5rem 2.5rem; 
            border-radius: 1.5rem; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%; 
            max-width: 460px;
            border: 1px solid var(--border-color-1, #e2e8f0);
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
            background: linear-gradient(90deg, var(--primary-color-1, #4c8a89), #0ea5e9);
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
            color: var(--primary-color-1, #4c8a89);
        }

        .login-header h2 {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--text-color-1, #1e293b);
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: var(--text-secondary-1, #64748b);
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
            color: var(--text-color-1, #1e293b);
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary-1, #64748b);
            transition: color 0.2s ease;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 1px solid var(--border-color-1, #e2e8f0);
            border-radius: 0.75rem;
            background: var(--bg-color-1, #ffffff);
            color: var(--text-color-1, #1e293b);
            font-size: 1rem;
            transition: all 0.2s ease;
            box-sizing: border-box;
            text-align: center;
            letter-spacing: 0.25rem;
            font-weight: bold;
        }
        
        .form-control::placeholder {
            letter-spacing: normal;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color-1, #4c8a89);
            box-shadow: 0 0 0 4px rgba(76, 138, 137, 0.15);
        }

        .form-control:focus + i {
            color: var(--primary-color-1, #4c8a89);
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            font-size: 1.125rem;
            font-weight: 700;
            margin-top: 1rem;
            background-color: var(--primary-color-1, #4c8a89);
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
            color: var(--text-secondary-1, #64748b);
            font-size: 0.875rem;
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: var(--primary-color-1, #4c8a89);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="logo-box">
                <i class="fas fa-key"></i>
            </div>
            <h2>Verify Identity</h2>
            <p>Please enter the 6-digit OTP sent to your email.</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle" style="margin-right: 0.75rem;"></i>
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="/login/otp" method="POST">
            <div class="form-group">
                <label class="form-label">OTP Code</label>
                <div class="input-wrapper">
                    <input type="text" name="otp" class="form-control" placeholder="123456" required autocomplete="one-time-code" maxlength="6" pattern="\d{6}">
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Verify OTP
            </button>
        </form>
        
        <a href="/login" class="back-link"><i class="fas fa-arrow-left"></i> Back to Login</a>

        <div class="login-footer">
            <p>&copy; <?= date('Y') ?> LGU Health & Safety Protection Bureau</p>
        </div>
    </div>
</body>
</html>
