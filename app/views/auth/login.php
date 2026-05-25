<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Inventaris</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: white;
            width: 400px;
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .login-card h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #1a202c;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            background: #fafbfc;
            transition: 0.2s;
            box-sizing: border-box;
        }
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .checkbox-group input {
            width: auto;
            margin: 0;
            transform: scale(1.1);
            cursor: pointer;
        }
        .checkbox-group label {
            margin: 0;
            font-weight: normal;
            color: #4a5568;
            cursor: pointer;
        }
        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .alert {
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
        .alert-error {
            background: #fed7d7;
            color: #c53030;
        }
        .alert-success {
            background: #c6f6d5;
            color: #276749;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .register-link a {
            color: #667eea;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="login-card">
    <h2>Login</h2>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error">Username atau password salah</div>
    <?php endif; ?>
    <?php if(isset($_GET['logout'])): ?>
        <div class="alert alert-success">Anda telah logout</div>
    <?php endif; ?>

    <form action="index.php?url=auth/login" method="POST">
        <div class="form-group">
            <input type="text" name="username" placeholder="Username" required autofocus>
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Ingat saya</label>
        </div>
        <button type="submit" class="login-btn">Login</button>
    </form>

    <div class="register-link">
        Belum punya akun? <a href="index.php?url=auth/register">Daftar</a>
    </div>
</div>
</body>
</html>