<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống Quản trị - Xayabury Travel</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f8f9fa; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .btn-add { display: inline-block; background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #dee2e6; padding: 12px; text-align: left; }
        th { background-color: #343a40; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .action-links a { text-decoration: none; margin-right: 15px; font-weight: bold; }
        .edit { color: #007bff; }
        .delete { color: #dc3545; }
        .view { color: #28a745; } /* Màu xanh lá cây cho nút Xem */
        .view:hover { text-decoration: underline; }
        .delete:hover { text-decoration: underline; }
        .edit:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quản lý địa danh Xayabury</h1>
        
        <a href="<?php echo URLROOT; ?>/admin/add" class="btn-add">+ Thêm địa danh mới</a>

      <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tiếng Việt</th>
            <th>Tiếng Lào</th>
            <th>Tiếng Anh</th> <th>Tọa độ (Lat, Lng)</th>
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
                <td><?php echo htmlspecialchars($place['name_en'] ?? 'N/A'); ?></td> <td><?php echo $place['latitude']; ?>, <?php echo $place['longitude']; ?></td>
                <td class="action-links">
                    <a href="<?php echo URLROOT; ?>/place/view/<?php echo $place['id']; ?>" 
                       class="view" target="_blank">Xem</a>
                    <a href="<?php echo URLROOT; ?>/admin/edit/<?php echo $place['id']; ?>" 
                       class="edit">Sửa</a>
                    <a href="<?php echo URLROOT; ?>/admin/delete/<?php echo $place['id']; ?>" 
                       class="delete" 
                       onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" style="text-align:center;">Chưa có dữ liệu nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
    </div>
</body>
</html>