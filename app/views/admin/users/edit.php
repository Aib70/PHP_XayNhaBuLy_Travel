<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa người dùng</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
        .form-container { background: white; max-width: 500px; margin: auto; padding: 20px; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Chỉnh sửa người dùng</h2>
        <form action="<?= URLROOT ?>/admin/update_user/<?= $data['user']['id'] ?>" method="POST">
            <label>Họ và tên</label>
            <input type="text" name="fullname" value="<?= htmlspecialchars($data['user']['fullname']) ?>" required>
            
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($data['user']['email']) ?>" required>
            
            <label>Số điện thoại</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($data['user']['phone'] ?? '') ?>">

            <button type="submit">Cập nhật thông tin</button>
            <a href="<?= URLROOT ?>/admin/users" style="margin-left:10px; color:#666;">Hủy</a>
        </form>
    </div>
</body>
</html>