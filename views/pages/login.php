<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LGU Health & Safety</title>
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/forms.css">
    <link rel="stylesheet" href="/css/textfield.css">
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background-color: #f3f4f6; }
        .login-card { background: white; padding: 2.5rem; border-radius: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .login-logo { text-align: center; margin-bottom: 2rem; }
        .login-logo img { width: 80px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <img src="/images/logo.svg" alt="LGU Logo">
            <h2 style="margin-top: 1rem;">Health & Safety System</h2>
        </div>
        <form action="/api/login" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="textfield" required placeholder="admin@lgu.gov.ph">
            </div>
            <div class="form-group" style="margin-top: 1rem;">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="textfield" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn btn-primary btn-block" style="width: 100%; margin-top: 2rem; padding: 0.8rem;">
                Sign In
            </button>
        </form>
        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #666;">
            Local Government Unit - Health & Safety Dept
        </p>
    </div>
</body>
</html>
