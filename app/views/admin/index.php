<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản trị - Xayabury Travel</title>
    <style>
        body { 
            margin: 0; 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background-color: #f8f9fa; 
            color: #333;
        }
        .container { padding: 30px; max-width: 1300px; margin: auto; }
        h1 { color: #2c3e50; font-size: 24px; margin-bottom: 25px; }

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

        .header-actions { display: flex; align-items: center; margin-bottom: 20px; gap: 10px; flex-wrap: wrap; }
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

        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
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
        .admin-table td:first-child { border-left: 1px solid #f1f1f1; border-radius: 10px 0 0 10px; text-align: center; }
        .admin-table td:last-child { border-right: 1px solid #f1f1f1; border-radius: 0 10px 10px 0; }

        /* Style cho cột Số thứ tự */
        .badge-stt { background: #34495e; padding: 5px 12px; border-radius: 5px; font-weight: bold; color: #fff; }
        
        .name-container div { margin-bottom: 3px; }
        .name-vi { font-weight: bold; color: #2c3e50; }
        .name-lo { font-size: 13px; color: #7f8c8d; }
        .name-en { font-size: 13px; color: #3498db; }

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

        /* Style chung cho nút quay lại Dashboard */
.btn-dashboard {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: white !important;
    padding: 10px 22px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    cursor: pointer;
}

/* Hiệu ứng khi di chuột vào */
.btn-dashboard:hover {
    background: linear-gradient(135deg, #495057 0%, #343a40 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(108, 117, 125, 0.4);
    filter: brightness(1.1);
}

/* Hiệu ứng khi nhấn giữ */
.btn-dashboard:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
}

/* Thêm icon khoảng cách nếu bạn dùng FontAwesome */
.btn-dashboard i {
    font-size: 16px;
}
    </style>

    
</head>

<style>
    .alert-toast {
        position: fixed; top: 20px; right: 20px; padding: 15px 25px; border-radius: 10px;
        color: white; font-weight: bold; z-index: 9999; box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        animation: slideIn 0.5s ease forwards;
        display: flex; align-items: center; gap: 10px;
    }
    .alert-success { background: #2ecc71; } /* Màu xanh khi thành công */
    .alert-danger { background: #e74c3c; }  /* Màu đỏ khi xóa hoặc lỗi */
    
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
</style>

<?php if(isset($_GET['msg'])): ?>
    <div id="toast" class="alert-toast <?= (strpos($_GET['msg'], 'deleted') !== false) ? 'alert-danger' : 'alert-success' ?>">
        <span>
            <?php 
                if($_GET['msg'] == 'added') echo "✅ Đã thêm địa danh mới thành công!";
                if($_GET['msg'] == 'updated') echo "📝 Đã cập nhật thông tin địa danh!";
                if($_GET['msg'] == 'deleted') echo "🗑️ Đã xóa địa danh khỏi hệ thống!";
            ?>
        </span>
    </div>

    <script>
        // Tự động ẩn sau 3 giây
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if(toast) {
                toast.style.transition = '0.5s';
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>
<?php endif; ?>

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
    <a href="<?= URLROOT; ?>/admin/add" class="btn-main btn-add">
        <i class="fas fa-plus"></i> + Thêm địa danh mới
    </a>

    <a href="<?= URLROOT; ?>/admin/dashboard" class="btn-dashboard">
        🏠 Dashboard (Tổng quan)
    </a>
</div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th width="80">STT</th> <th>Thông tin địa danh</th>
                    <th width="180">Tọa độ (Lat, Lng)</th>
                    <th width="350">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['places'])): ?>
                    <?php 
                        $stt = 1; // Khởi tạo biến đếm số thứ tự
                        foreach($data['places'] as $place): 
                    ?>
                    <tr>
                        <td><span class="badge-stt"><?php echo $stt++; ?></span></td>
                        
                        <td class="name-container">
                            <div class="name-vi"><?php echo htmlspecialchars($place['name_vi'] ?? 'Chưa có'); ?></div>
                            <div class="name-lo"><?php echo htmlspecialchars($place['name_lo'] ?? 'ຍັງບໍ່ມີ'); ?></div>
                            <div class="name-en">🇺🇸 <?php echo htmlspecialchars($place['name_en'] ?? 'N/A'); ?></div>
                            <small style="color: #ccc; font-size: 10px;">ID gốc: #<?php echo $place['id']; ?></small>
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
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa không? Hành động này sẽ không thể hoàn tác!')">Xóa</a>
                            </div>
                            <a href="<?php echo URLROOT; ?>/admin/forum/<?php echo $place['id']; ?>" class="btn-forum-small">📢 Quản lý Diễn đàn</a>
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