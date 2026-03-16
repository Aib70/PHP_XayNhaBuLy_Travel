<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đặt chỗ - Xayabury Travel</title>
    <style>
    .status-badge { padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; }
    .pending { background: #ffeeba; color: #856404; }   /* Vàng */
    .confirmed { background: #d4edda; color: #155724; } /* Xanh lá */
    .cancelled { background: #f8d7da; color: #721c24; } /* Đỏ */
</style>
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
        <h2>Quản lý Đặt chỗ</h2>
<table border="1" width="100%" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Điện thoại</th>
            <th>Địa danh</th>
            <th>Ngày dự kiến</th>
            <th>Ngày đặt</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data['bookings'] as $row): ?>
<tr>
    <td><?= $row['id'] ?></td>
    
    <td><?= htmlspecialchars($row['user_name'] ?? 'N/A') ?></td>
    
    <td><?= htmlspecialchars($row['phone'] ?? 'N/A') ?></td>
    
    <td><?= htmlspecialchars($row['user_email'] ?? 'N/A') ?></td>
    
    <td><?= htmlspecialchars($row['booking_date'] ?? 'N/A') ?></td>
    
    <td>
        <span class="status-badge <?= $row['status'] ?>">
            <?= ucfirst($row['status']) ?>
        </span>
    </td>
    
    <td><?= $row['created_at'] ?></td>
</tr>
<?php endforeach; ?>
    </tbody>
</table>
        
    </div>
</body>
</html>