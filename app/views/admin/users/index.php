<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Người dùng - Xayabury Travel</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 30px; background: #f0f2f5; color: #333; }
        .container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); max-width: 1200px; margin: auto; }
        
        /* Header & Tiêu đề */
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        h1 { margin: 0; font-size: 24px; color: #1a202c; }

        /* Nút quay lại & Thêm mới */
        .btn-back { text-decoration: none; color: #666; display: flex; align-items: center; gap: 5px; margin-bottom: 15px; font-size: 14px; transition: 0.3s; }
        .btn-back:hover { color: #000; transform: translateX(-5px); }
        
        .btn-add { background: #28a745; color: white; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; box-shadow: 0 4px 12px rgba(40,167,69,0.2); }
        .btn-add:hover { background: #218838; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(40,167,69,0.3); }

        /* Bảng dữ liệu */
        table { width: 100%; border-collapse: separate; border-spacing: 0 10px; margin-top: 10px; }
        th { background: #f8f9fa; color: #4a5568; padding: 15px; text-align: left; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; }
        td { padding: 15px; background: #fff; border-top: 1px solid #edf2f7; border-bottom: 1px solid #edf2f7; vertical-align: middle; }
        tr:hover td { background: #fcfcfc; }
        td:first-child { border-left: 1px solid #edf2f7; border-radius: 10px 0 0 10px; }
        td:last-child { border-right: 1px solid #edf2f7; border-radius: 0 10px 10px 0; }

        /* Nút thao tác đẹp hơn */
        .action-links { display: flex; gap: 8px; }
        .btn-action { text-decoration: none; padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; transition: 0.3s; border: 1px solid transparent; }
        
        .btn-view { color: #28a745; border-color: #28a745; }
        .btn-view:hover { background: #28a745; color: white; }
        
        .btn-edit { color: #007bff; border-color: #007bff; }
        .btn-edit:hover { background: #007bff; color: white; }
        
        .btn-delete { color: #dc3545; border-color: #dc3545; }
        .btn-delete:hover { background: #dc3545; color: white; }

        /* Thông báo (Toast Alert) */
        .alert {
            position: fixed; top: 20px; right: 20px; padding: 15px 25px; border-radius: 10px;
            color: white; font-weight: bold; z-index: 9999; box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            animation: slideIn 0.5s ease forwards;
        }
        .alert-success { background: #2ecc71; }
        .alert-danger { background: #e74c3c; }
        @keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
    </style>
</head>
<body>

    <?php if(isset($_GET['msg'])): ?>
        <div id="alert" class="alert <?= (strpos($_GET['msg'], 'deleted') !== false || strpos($_GET['msg'], 'error') !== false) ? 'alert-danger' : 'alert-success' ?>">
            <?php 
                if($_GET['msg'] == 'added') echo "✨ Thêm người dùng thành công!";
                if($_GET['msg'] == 'updated') echo "📝 Cập nhật thông tin thành công!";
                if($_GET['msg'] == 'deleted') echo "🗑️ Đã xóa người dùng!";
            ?>
        </div>
        <script>
            // Tự động ẩn thông báo sau 3 giây
            setTimeout(() => {
                const alert = document.getElementById('alert');
                alert.style.opacity = '0';
                alert.style.transition = '0.5s';
                setTimeout(() => alert.remove(), 500);
            }, 3000);
        </script>
    <?php endif; ?>

    <div class="container">
        <a href="<?= URLROOT; ?>/admin" class="btn-back">⬅ Quay lại Admin</a>
        
        <div class="admin-header">
            <h1>Quản lý người dùng</h1>
            <a href="<?= URLROOT ?>/admin/add_user" class="btn-add">
                <span>+</span> Thêm người dùng mới
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="60">STT</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Ngày tham gia</th>
                    <th width="220">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; if(!empty($data['users'])): foreach($data['users'] as $user): ?>
                <tr>
                    <td style="text-align: center;"><span style="background: #f1f3f5; padding: 5px 10px; border-radius: 6px; font-weight: bold;"><?= $stt++; ?></span></td>
                    <td><strong><?= htmlspecialchars($user['fullname']); ?></strong></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td style="color: #666;"><?= htmlspecialchars($user['phone']); ?></td>
                    <td style="font-size: 13px; color: #a0aec0;"><?= date('d/m/Y', strtotime($user['created_at'])); ?></td>
                    <td>
                        <div class="action-links">
                            <a href="<?= URLROOT; ?>/admin/user_detail/<?= $user['id']; ?>" class="btn-action btn-view">Xem</a>
                            <a href="<?= URLROOT; ?>/admin/edit_user/<?= $user['id']; ?>" class="btn-action btn-edit">Sửa</a>
                            <a href="<?= URLROOT; ?>/admin/delete_user/<?= $user['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xóa</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="6" style="text-align:center; padding: 50px; color: #999;">Chưa có người dùng nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>