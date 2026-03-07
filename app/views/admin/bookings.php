
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đặt chỗ - Xayabury Travel</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #333; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        .status-pending { background: #ffcc00; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; }
        .btn-back { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo URLROOT; ?>/admin" class="btn-back">⬅ Quay lại Quản lý địa danh</a>
        <h1>Quản lý Danh sách Đặt chỗ</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Email</th>
                    <th>Địa danh đặt</th>
                    <th>Ngày dự kiến</th>
                    <th>Ngày gửi</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['bookings'])): ?>
                    <?php foreach($data['bookings'] as $b): ?>
                    <tr>
                        <td><?php echo $b['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($b['user_name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($b['user_email']); ?></td>
                        <td><?php echo htmlspecialchars($b['place_name']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($b['booking_date'])); ?></td>
                        <td><?php echo date('H:i d/m/Y', strtotime($b['created_at'])); ?></td>
                        <td><span class="status-pending"><?php echo $b['status']; ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center;">Chưa có yêu cầu đặt chỗ nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>