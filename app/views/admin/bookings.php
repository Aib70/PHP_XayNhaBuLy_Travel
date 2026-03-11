<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đặt chỗ - Xayabury Travel</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f7f6; margin: 0; padding: 20px; color: #333; }
        .container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-width: 1100px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #343a40; color: white; text-transform: uppercase; font-size: 0.85rem; }
        .btn { text-decoration: none; padding: 7px 12px; border-radius: 5px; font-size: 0.8rem; font-weight: bold; color: white; display: inline-block; }
        .btn-view { background: #17a2b8; margin-right: 5px; } /* Màu xanh teal */
        .btn-delete { background: #dc3545; } /* Màu đỏ */
        .btn-back { display: inline-block; margin-bottom: 20px; color: #555; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo URLROOT; ?>/admin" class="btn-back">⬅ Quay lại Quản lý</a>
        <h1>Danh sách Đặt chỗ</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Địa danh</th>
                    <th>Ngày dự kiến</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['bookings'])): foreach($data['bookings'] as $b): ?>
                <tr>
                    <td><?php echo $b['id']; ?></td>
                    <td><strong><?php echo htmlspecialchars($b['user_name']); ?></strong></td>
                    <td><?php echo htmlspecialchars($b['place_name']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($b['booking_date'])); ?></td>
                    <td>
                        <a href="<?php echo URLROOT; ?>/admin/booking_detail/<?php echo $b['id']; ?>" class="btn btn-view">👁 Xem</a>
                        
                        <a href="<?php echo URLROOT; ?>/admin/delete_booking/<?php echo $b['id']; ?>" 
                           class="btn btn-delete" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa đơn đặt chỗ này?')">🗑 Xóa</a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" style="text-align:center;">Chưa có dữ liệu.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>