<!DOCTYPE html>
<html>
<head>
    <title>Register - Inventaris</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; justify-content: center; align-items: center; }
        .register-card { background: white; width: 400px; padding: 40px 35px; border-radius: 20px; }
        h2 { text-align: center; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group input { width: 100%; padding: 12px 15px; border: 1px solid #ccc; border-radius: 12px; }
        .register-btn { width: 100%; padding: 12px; background: #667eea; color: white; border: none; border-radius: 12px; cursor: pointer; }
        .alert { padding: 12px; border-radius: 12px; margin-bottom: 20px; }
        .alert-error { background: #fed7d7; color: #c53030; }
        .alert-success { background: #c6f6d5; color: #276749; }
    </style>
</head>
<body>
<div class="register-card">
    <h2>Daftar Akun</h2>
    <?php if(!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if(!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <form action="index.php?url=auth/register" method="POST">
        <div class="form-group"><input type="text" name="username" placeholder="Username" required></div>
        <div class="form-group"><input type="password" name="password" placeholder="Password" required></div>
        <div class="form-group"><input type="password" name="confirm_password" placeholder="Konfirmasi Password" required></div>
        <button type="submit" class="register-btn">Daftar</button>
    </form>
    <div style="text-align:center; margin-top:20px;">Sudah punya akun? <a href="index.php?url=auth/login">Login</a></div>
</div>
</body>
</html>