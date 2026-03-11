<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Người dùng</title>
    <style>
        /* Bạn có thể dùng chung CSS với trang quản lý địa danh */
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f7f6; }
        .container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #343a40; color: white; }
        .btn { text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 0.8rem; color: white; }
        .btn-view { background: #28a745; }
        .btn-edit { background: #007bff; }
        .btn-delete { background: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        
        <a href="<?php echo URLROOT; ?>/admin" style="text-decoration: none;">⬅ Quay lại Admin</a>
         <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
    <h1>Quản lý người dùng</h1>
    <a href="<?= URLROOT ?>/admin/add_user" style="background: #28a745; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">
        + Thêm người dùng mới
    </a>
    </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Ngày tham gia</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['users'] as $u): ?>
                <tr>
                    <td><?php echo $u['id']; ?></td>
                    <td><strong><?php echo htmlspecialchars($u['fullname']); ?></strong></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td><?php echo htmlspecialchars($u['phone'] ?? 'N/A'); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($u['created_at'])); ?></td>
                    <td>
                        <a href="<?php echo URLROOT; ?>/admin/user_detail/<?php echo $u['id']; ?>" class="btn btn-view">Xem</a>
                        <a href="<?php echo URLROOT; ?>/admin/edit_user/<?php echo $u['id']; ?>" class="btn btn-edit">Sửa</a>
                        <a href="<?php echo URLROOT; ?>/admin/delete_user/<?php echo $u['id']; ?>" 
                           class="btn btn-delete" onclick="return confirm('Xác nhận xóa người dùng này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>