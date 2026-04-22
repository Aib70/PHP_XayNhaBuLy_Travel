<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Trợ giúp - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 30px; background: #f4f7f6; }
        .container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); max-width: 1100px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #333; color: white; padding: 15px; text-align: left; }
        td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: top; }
        .btn-delete { color: #e74c3c; text-decoration: none; font-weight: bold; border: 1px solid #e74c3c; padding: 5px 10px; border-radius: 5px; }
        .btn-delete:hover { background: #e74c3c; color: white; }
        .time { font-size: 0.85rem; color: #999; }
        .contact-tag { background: #e8f4fd; color: #2980b9; padding: 2px 8px; border-radius: 4px; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📩 Quản lý yêu cầu trợ giúp</h1>
            <a href="<?= URLROOT ?>/admin" style="text-decoration: none; color: #666;">⬅ Quay lại Admin</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="20%">Khách hàng</th>
                    <th width="60%">Nội dung tin nhắn</th>
                    <th width="20%">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['requests'])): foreach($data['requests'] as $req): ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($req['name']) ?></strong><br>
                        <span class="contact-tag"><?= htmlspecialchars($req['contact_info']) ?></span><br>
                        <span class="time"><?= date('H:i d/m/Y', strtotime($req['created_at'])) ?></span>
                    </td>
                    <td style="line-height: 1.6; color: #444;">
                        <?= nl2br(htmlspecialchars($req['message'])) ?>
                    </td>
                    <td>
                        <a href="<?= URLROOT ?>/admin/delete_help/<?= $req['id'] ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Bạn đã xử lý xong và muốn xóa yêu cầu này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="3" style="text-align: center; padding: 50px; color: #999;">Chưa có yêu cầu trợ giúp nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>