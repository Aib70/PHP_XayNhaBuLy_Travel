<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Khách sạn - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; padding: 30px; background-color: #f8fafc; color: #333; }
        .container { padding: 40px; max-width: 1300px; margin: auto; }
        h1 { color: #1e293b; font-size: 28px; font-weight: 800; margin-bottom: 30px; }
        .admin-header { display: flex; align-items: center; gap: 15px; margin-bottom: 35px; }

        .btn-add { 
            background: linear-gradient(135deg, #f39c12 0%, #d35400 100%);
            color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; 
            font-weight: bold; font-size: 14px; box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3); transition: 0.3s;
        }
        .btn-dashboard {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white !important; padding: 11px 22px; border-radius: 12px;
            text-decoration: none; font-weight: 600; font-size: 14px;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3); transition: 0.3s;
        }
        .btn-add:hover, .btn-dashboard:hover { transform: translateY(-2px); filter: brightness(1.1); }

        .admin-table { width: 100%; border-collapse: separate; border-spacing: 0 15px; }
        .admin-table thead th { background-color: #1e293b; color: #f8fafc; padding: 18px; font-size: 13px; text-transform: uppercase; text-align: left; border: none; }
        .admin-table thead th:first-child { border-radius: 8px 0 0 8px; text-align: center; }
        .admin-table thead th:last-child { border-radius: 0 8px 8px 0; }

        .admin-table tbody tr { background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: 0.3s; }
        .admin-table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }
        .admin-table td { padding: 20px; border: none; vertical-align: middle; }
        .admin-table td:first-child { border-radius: 12px 0 0 12px; text-align: center; }
        .admin-table td:last-child { border-radius: 0 12px 12px 0; }

        .hotel-img-container { width: 120px; height: 80px; overflow: hidden; border-radius: 8px; border: 1px solid #eee; }
        .hotel-img-container img { width: 100%; height: 100%; object-fit: cover; }

        .btn-action { padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; transition: 0.2s; text-decoration: none; display: inline-block; border: 1.5px solid; margin-right: 5px; }
        .btn-view { color: #10b981; border-color: #10b981; }
        .btn-view:hover { background: #10b981; color: white; }
        .btn-forum { background: #8b5cf6; color: white; border: none; }
        .btn-edit { color: #3b82f6; border-color: #3b82f6; }
        .btn-delete { color: #ef4444; border-color: #ef4444; }
        .btn-edit:hover { background: #3b82f6; color: #fff; }
        .btn-delete:hover { background: #ef4444; color: #fff; }

        .badge-stt { background: #334155; color: #fff; padding: 5px 12px; border-radius: 6px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h1>Quản lý Khách sạn</h1>
    
    <div class="admin-header">
        <a href="<?= URLROOT ?>/admin/add_hotel" class="btn-add">+ Thêm khách sạn mới</a>
        <a href="<?= URLROOT; ?>/admin/dashboard" class="btn-dashboard">🏠 Dashboard (Tổng quan)</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th width="80">STT</th>
                <th width="150">Hình ảnh</th>
                <th>Tên khách sạn</th>
                <th>Địa chỉ</th>
                <th width="320">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php $stt = 1; if(!empty($data['hotels'])): foreach($data['hotels'] as $hotel): ?>
            <tr>
                <td><span class="badge-stt"><?= $stt++; ?></span></td>
                <td>
                    <div class="hotel-img-container">
                        <img src="<?= URLROOT ?>/public/img/places/<?= $hotel['image_main'] ?? $hotel['image'] ?>">
                    </div>
                </td>
                <td>
                    <div style="font-weight: bold; color: #2c3e50; font-size: 16px;"><?= htmlspecialchars($hotel['name_vi'] ?? 'N/A'); ?></div>
                    <small style="color: #94a3b8;">ID: #<?= $hotel['id']; ?></small>
                </td>
                <td>
                    <div style="display: flex; align-items: center; gap: 8px; color: #475569;">
                        <i class="fa-solid fa-location-dot" style="color: #ef4444;"></i>
                        <span>
                            <?= !empty($hotel['addr_vi']) ? htmlspecialchars($hotel['addr_vi']) : '<small style="color: #94a3b8; font-style: italic;">Chưa cập nhật địa chỉ</small>'; ?>
                        </span>
                    </div>
                </td>
                <td>
                    <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                        <a href="<?= URLROOT; ?>/place/view/<?= $hotel['id']; ?>" class="btn-action btn-view" target="_blank"><i class="fa-solid fa-eye"></i> Xem</a>
                        <a href="<?= URLROOT; ?>/admin/forum/<?= $hotel['id']; ?>" class="btn-action btn-forum"><i class="fa-solid fa-comments"></i> Diễn đàn</a>
                        <a href="<?= URLROOT; ?>/admin/edit/<?= $hotel['id']; ?>" class="btn-action btn-edit"><i class="fa-solid fa-pen-to-square"></i> Sửa</a>
                        <a href="<?= URLROOT; ?>/admin/delete/<?= $hotel['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Xóa khách sạn này?')"><i class="fa-solid fa-trash"></i> Xóa</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="5" style="text-align:center; padding: 50px; color: #94a3b8;">Chưa có khách sạn nào.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>