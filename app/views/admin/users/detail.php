<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết người dùng</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
        .card { background: white; max-width: 500px; margin: auto; padding: 20px; border-radius: 10px; shadow: 0 0 10px rgba(0,0,0,0.1); }
        .info-group { margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        label { font-weight: bold; color: #666; display: block; }
        .btn-back { display: inline-block; margin-top: 20px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Thông tin chi tiết #<?= $data['user']['id'] ?></h2>
        
        <div class="info-group">
            <label>Họ và tên:</label>
            <div><?= htmlspecialchars($data['user']['fullname']) ?></div>
        </div>
        
        <div class="info-group">
            <label>Email:</label>
            <div><?= htmlspecialchars($data['user']['email']) ?></div>
        </div>

        <div class="info-group">
            <label>Số điện thoại:</label>
            <div><?= htmlspecialchars($data['user']['phone'] ?? 'Chưa cập nhật') ?></div>
        </div>

        <div class="info-group">
            <label>Ngày tham gia:</label>
            <div><?= date('d/m/Y H:i', strtotime($data['user']['created_at'])) ?></div>
        </div>

        <a href="<?= URLROOT ?>/admin/users" class="btn-back">⬅ Quay lại danh sách</a>
    </div>
</body>
</html>