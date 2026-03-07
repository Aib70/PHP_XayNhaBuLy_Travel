<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống Quản trị - Xayabury Travel</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 0; margin: 0; background-color: #f8f9fa; }
        
        /* Thanh điều hướng Admin */
        .admin-nav {
            background: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .admin-nav a { color: white; text-decoration: none; margin-left: 15px; font-size: 0.9rem; }
        .btn-logout { background: #dc3545; padding: 5px 12px; border-radius: 4px; font-weight: bold; }

        .container { max-width: 1100px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-top: 0; }
        
        .header-actions { display: flex; gap: 10px; margin-bottom: 20px; }
        .btn-add { background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .btn-bookings { background: #17a2b8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        
        .btn-add:hover { background: #218838; }
        .btn-bookings:hover { background: #138496; }

        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #dee2e6; padding: 12px; text-align: left; }
        th { background-color: #343a40; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        
        .action-links a { text-decoration: none; margin-right: 15px; font-weight: bold; font-size: 0.9rem; }
        .edit { color: #007bff; }
        .delete { color: #dc3545; }
        .view { color: #28a745; }
        
        .view:hover, .delete:hover, .edit:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="admin-nav">
        <div>
            <strong>XAYABURY ADMIN</strong> | 
            Chào, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?>
        </div>
        <div>
            <a href="<?php echo URLROOT; ?>/home" target="_blank">🏠 Xem trang chủ</a>
            <a href="<?php echo URLROOT; ?>/auth/logout" class="btn-logout" 
               onclick="return confirm('Bạn có chắc chắn muốn đăng xuất không?')">🚪 Đăng xuất</a>
        </div>
    </div>

    <div class="container">
        <h1>Quản lý địa danh Xayabury</h1>
        
        <div class="header-actions">
            <a href="<?php echo URLROOT; ?>/admin/add" class="btn-add">+ Thêm địa danh mới</a>
            <a href="<?php echo URLROOT; ?>/admin/bookings" class="btn-bookings">📋 Danh sách đặt chỗ</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiếng Việt</th>
                    <th>Tiếng Lào</th>
                    <th>Tiếng Anh</th> 
                    <th>Tọa độ (Lat, Lng)</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['places'])): ?>
                    <?php foreach($data['places'] as $place): ?>
                    <tr>
                        <td><?php echo $place['id']; ?></td>
                        <td><?php echo htmlspecialchars($place['name_vi'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($place['name_lo'] ?? 'ຍັງບໍ່ມີ'); ?></td>
                        <td><?php echo htmlspecialchars($place['name_en'] ?? 'N/A'); ?></td> 
                        <td style="font-size: 0.85rem; color: #666;">
                            <?php echo $place['latitude']; ?>, <?php echo $place['longitude']; ?>
                        </td>
                        <td class="action-links">
                            <a href="<?php echo URLROOT; ?>/place/view/<?php echo $place['id']; ?>" 
                               class="view" target="_blank">Xem</a>
                            <a href="<?php echo URLROOT; ?>/admin/edit/<?php echo $place['id']; ?>" 
                               class="edit">Sửa</a>
                            <a href="<?php echo URLROOT; ?>/admin/delete/<?php echo $place['id']; ?>" 
                               class="delete" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa địa danh này?')">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center; padding: 30px; color: #999;">Chưa có dữ liệu nào trong hệ thống.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>