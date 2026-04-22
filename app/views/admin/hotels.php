<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Khách sạn - Xayabury Travel</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; padding: 30px; background: #f0f2f5; color: #333; }
        .container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); max-width: 1240px; margin: auto; }
        
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        h1 { margin: 0; font-size: 24px; color: #1a202c; }

        .btn-back { text-decoration: none; color: #666; display: flex; align-items: center; gap: 5px; margin-bottom: 15px; font-size: 14px; transition: 0.3s; }
        .btn-back:hover { color: #000; transform: translateX(-5px); }
        
        .btn-add { background: #f39c12; color: white; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; box-shadow: 0 4px 12px rgba(243,156,18,0.2); }
        .btn-add:hover { background: #e67e22; transform: translateY(-2px); }

        table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
        th { background: #f8f9fa; color: #4a5568; padding: 15px; text-align: left; font-size: 13px; text-transform: uppercase; }
        td { padding: 15px; background: #fff; border-top: 1px solid #edf2f7; border-bottom: 1px solid #edf2f7; vertical-align: middle; }
        
        td:first-child { border-left: 1px solid #edf2f7; border-radius: 10px 0 0 10px; text-align: center; }
        td:last-child { border-right: 1px solid #edf2f7; border-radius: 0 10px 10px 0; }

        .hotel-img { width: 80px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; }
        
        .btn-action { text-decoration: none; padding: 8px 12px; border-radius: 8px; font-size: 11px; font-weight: 600; transition: 0.3s; border: 1px solid transparent; display: inline-flex; align-items: center; gap: 4px; }
        
        /* Màu sắc cho từng nút */
        .btn-forum { color: #6c757d; border-color: #6c757d; }
        .btn-forum:hover { background: #6c757d; color: white; }
        
        .btn-edit { color: #007bff; border-color: #007bff; }
        .btn-edit:hover { background: #007bff; color: white; }
        
        .btn-delete { color: #dc3545; border-color: #dc3545; }
        .btn-delete:hover { background: #dc3545; color: white; }

        .alert { position: fixed; top: 20px; right: 20px; padding: 15px 25px; border-radius: 10px; color: white; font-weight: bold; z-index: 9999; box-shadow: 0 5px 15px rgba(0,0,0,0.2); animation: slideIn 0.5s ease forwards; }
        .alert-success { background: #2ecc71; }
        .alert-danger { background: #e74c3c; }
        @keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
    </style>
</head>
<body>

    <?php if(isset($_GET['msg'])): ?>
        <div id="alert" class="alert <?= ($_GET['msg'] == 'deleted') ? 'alert-danger' : 'alert-success' ?>">
            <?= ($_GET['msg'] == 'added') ? '✨ Thêm khách sạn thành công!' : (($_GET['msg'] == 'deleted') ? '🗑️ Đã xóa khách sạn!' : '📝 Đã cập nhật!') ?>
        </div>
        <script>setTimeout(() => { document.getElementById('alert').remove(); }, 3000);</script>
    <?php endif; ?>

    <div class="container">
        <a href="<?= URLROOT; ?>/admin" class="btn-back">⬅ Quay lại Admin</a>
        
        <div class="admin-header">
            <h1>Quản lý Khách sạn</h1>
            <a href="<?= URLROOT ?>/admin/add_hotel" class="btn-add">+ Thêm khách sạn mới</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="50">STT</th>
                    <th width="100">Hình ảnh</th>
                    <th width="300">Tên khách sạn</th>
                    <th>Địa chỉ</th>
                    <th width="240">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; if(!empty($data['hotels'])): foreach($data['hotels'] as $hotel): ?>
                <tr>
                    <td><strong><?= $stt++; ?></strong></td>
                    <td>
                        <img src="<?= URLROOT ?>/public/img/places/<?= $hotel['image_main'] ?? $hotel['image'] ?>" class="hotel-img">
                    </td>
                    <td>
                        <div style="font-weight: bold; color: #2c3e50;"><?= htmlspecialchars($hotel['name_vi'] ?? 'N/A'); ?></div>
                        <small style="color: #999;">ID: #<?= $hotel['id']; ?></small>
                    </td>
                    <td>
                        <div style="font-size: 13px; color: #666;">
                            <?= htmlspecialchars($hotel['addr_vi'] ?? ($hotel['address_vi'] ?? 'Chưa cập nhật')); ?>
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="<?= URLROOT; ?>/admin/forum/<?= $hotel['id']; ?>" class="btn-action btn-forum">
                                💬 Diễn đàn
                            </a>
                            
                            <a href="<?= URLROOT; ?>/admin/edit/<?= $hotel['id']; ?>" class="btn-action btn-edit">Sửa</a>
                            
                            <a href="<?= URLROOT; ?>/admin/delete/<?= $hotel['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Xóa khách sạn này?')">Xóa</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" style="text-align:center; padding: 30px;">Chưa có khách sạn nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>