<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống Quản trị - Xayabury Travel</title>
    <style>
        /* TỔNG THỂ */
        body { 
            margin: 0; 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background-color: #f8f9fa; 
            color: #333;
        }
        .container { padding: 30px; max-width: 1300px; margin: auto; }
        h1 { color: #2c3e50; font-size: 24px; margin-bottom: 25px; }

        /* THANH NAV TRÊN CÙNG */
        .admin-nav {
            background: #2c3e50;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .admin-nav a { color: #bdc3c7; text-decoration: none; margin-left: 20px; font-size: 14px; }
        .admin-nav a:hover { color: white; }
        .btn-logout { background: #e74c3c; color: white !important; padding: 7px 15px; border-radius: 5px; }

        /* CÁC NÚT HÀNH ĐỘNG CHÍNH (Thêm, Bookings...) */
        .header-actions { display: flex; align-items: center; margin-bottom: 20px; gap: 10px; }
        .btn-main {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            color: white;
            transition: 0.3s;
        }
        .btn-add { background: #28a745; }
        .btn-bookings { background: #17a2b8; }
        .btn-users { background: #6f42c1; }
        .btn-main:hover { opacity: 0.9; transform: translateY(-2px); }

        /* BẢNG DỮ LIỆU HIỆN ĐẠI */
        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px; /* Khoảng cách giữa các dòng */
            margin-top: 10px;
        }
        .admin-table thead th {
            background-color: #343a40;
            color: #ffffff;
            padding: 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
            border: none;
        }
        .admin-table tbody tr {
            background-color: #ffffff;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .admin-table tbody tr:hover {
            transform: scale(1.005);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .admin-table td {
            padding: 15px;
            vertical-align: middle;
            font-size: 14px;
            border-top: 1px solid #f1f1f1;
            border-bottom: 1px solid #f1f1f1;
        }
        /* Bo góc cho dòng dữ liệu */
        .admin-table td:first-child { border-left: 1px solid #f1f1f1; border-radius: 10px 0 0 10px; text-align: center; }
        .admin-table td:last-child { border-right: 1px solid #f1f1f1; border-radius: 0 10px 10px 0; }

        /* THÀNH PHẦN BÊN TRONG TD */
        .badge-id { background: #e9ecef; padding: 5px 10px; border-radius: 5px; font-weight: bold; color: #495057; }
        .name-container div { margin-bottom: 3px; }
        .name-vi { font-weight: bold; color: #2c3e50; }
        .name-lo { font-size: 13px; color: #7f8c8d; }
        .name-en { font-size: 13px; color: #3498db; }

        /* NÚT THAO TÁC TRONG BẢNG */
        .btn-action {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
            margin-right: 5px;
            display: inline-block;
            border: 1px solid transparent;
        }
        .btn-view { color: #28a745; border-color: #28a745; }
        .btn-view:hover { background: #28a745; color: white; }
        .btn-edit { color: #007bff; border-color: #007bff; }
        .btn-edit:hover { background: #007bff; color: white; }
        .btn-delete { color: #dc3545; border-color: #dc3545; }
        .btn-delete:hover { background: #dc3545; color: white; }
        
        .btn-forum-small {
            background: #6f42c1;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            text-decoration: none;
            display: inline-block;
            margin-top: 8px;
        }
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
            <a href="<?php echo URLROOT; ?>/admin/add" class="btn-main btn-add">+ Thêm địa danh mới</a>
            <a href="<?php echo URLROOT; ?>/admin/bookings" class="btn-main btn-bookings">📋 Danh sách đặt chỗ</a>
            <a href="<?php echo URLROOT; ?>/admin/users" class="btn-main btn-users">👥 Quản lý người dùng</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th>Thông tin địa danh</th>
                    <th width="180">Tọa độ (Lat, Lng)</th>
                    <th width="280">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['places'])): ?>
                    <?php foreach($data['places'] as $place): ?>
                    <tr>
                        <td><span class="badge-id"><?php echo $place['id']; ?></span></td>
                        <td class="name-container">
                            <div class="name-vi"><?php echo htmlspecialchars($place['name_vi'] ?? 'Chưa có'); ?></div>
                            <div class="name-lo"><?php echo htmlspecialchars($place['name_lo'] ?? 'ຍັງບໍ່ມີ'); ?></div>
                            <div class="name-en">🇺🇸 <?php echo htmlspecialchars($place['name_en'] ?? 'N/A'); ?></div>
                        </td>
                        <td style="font-family: monospace; color: #666; font-size: 12px;">
                            📍 <?php echo number_format($place['latitude'], 6); ?>,<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($place['longitude'], 6); ?>
                        </td>
                        <td>
                            <div>
                                <a href="<?php echo URLROOT; ?>/place/view/<?php echo $place['id']; ?>" 
                                   class="btn-action btn-view" target="_blank">Xem</a>
                                <a href="<?php echo URLROOT; ?>/admin/edit/<?php echo $place['id']; ?>" 
                                   class="btn-action btn-edit">Sửa</a>
                                <a href="<?php echo URLROOT; ?>/admin/delete/<?php echo $place['id']; ?>" 
                                   class="btn-action btn-delete" 
                                   onclick="return confirm('Xác nhận xóa địa danh này?')">Xóa</a>
                            </div>
                            <a href="<?php echo URLROOT; ?>/admin/forum" class="btn-forum-small">📢 Quản lý Diễn đàn</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align:center; padding: 50px; color: #999;">Chưa có dữ liệu nào trong hệ thống.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>