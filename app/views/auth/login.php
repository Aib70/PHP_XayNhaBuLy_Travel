<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Xayabury Travel</title>
    <style>
        body { background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: Arial; }
        .login-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #ffcc00; border: none; font-weight: bold; cursor: pointer; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 style="text-align: center;">ADMIN LOGIN</h2>
        <form action="<?php echo URLROOT; ?>/auth/authenticate" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">ĐĂNG NHẬP</button>
        </form>
    </div>
</body>
</html>