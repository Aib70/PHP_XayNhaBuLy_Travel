<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm người dùng mới</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f4f4; padding: 40px; }
        .form-container { background: white; max-width: 500px; margin: auto; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        h2 { color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        label { display: block; margin-top: 15px; font-weight: bold; color: #555; }
        input { width: 100%; padding: 12px; margin-top: 5px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-submit { background: #28a745; color: white; border: none; padding: 12px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 20px; width: 100%; }
        .btn-submit:hover { background: #218838; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Thêm người dùng mới</h2>
        <form action="<?= URLROOT ?>/admin/store_user" method="POST">
            <label>Họ và tên</label>
            <input type="text" name="fullname" placeholder="Nhập họ và tên..." required>
            
            <label>Email (Dùng để đăng nhập)</label>
            <input type="email" name="email" placeholder="example@gmail.com" required>
            
            <label>Số điện thoại</label>
            <input type="text" name="phone" placeholder="Nhập số điện thoại...">

            <label>Mật khẩu</label>
            <input type="password" name="password" placeholder="Nhập mật khẩu..." required minlength="6">

            <button type="submit" class="btn-submit">Tạo tài khoản</button>
            <a href="<?= URLROOT ?>/admin/users" class="back-link">⬅ Quay lại danh sách</a>
        </form>
    </div>
</body>
</html>