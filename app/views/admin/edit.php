<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa địa danh</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .lang-block { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Chỉnh sửa địa danh: <?php echo htmlspecialchars($data['place']['name_vi']); ?></h1>
    <form action="<?php echo URLROOT; ?>/admin/update/<?php echo $data['place']['id']; ?>" method="POST">
        
        <label>ID Danh mục:</label> 
        <input type="number" name="category_id" value="<?php echo $data['place']['category_id']; ?>" required>
        
        <label>Vĩ độ (Lat):</label> 
        <input type="text" name="lat" value="<?php echo $data['place']['latitude']; ?>">
        
        <label>Kinh độ (Lng):</label> 
        <input type="text" name="lng" value="<?php echo $data['place']['longitude']; ?>">

        <div class="lang-block">
            <h3>🇻🇳 Tiếng Việt</h3>
            <input type="text" name="name_vi" value="<?php echo htmlspecialchars($data['place']['name_vi']); ?>" required>
            <textarea name="desc_vi"><?php echo htmlspecialchars($data['place']['desc_vi']); ?></textarea>
            <input type="text" name="addr_vi" value="<?php echo htmlspecialchars($data['place']['addr_vi']); ?>">
        </div>

        <div class="lang-block">
            <h3>🇱🇦 Tiếng Lào</h3>
            <input type="text" name="name_lo" value="<?php echo htmlspecialchars($data['place']['name_lo']); ?>" required>
            <textarea name="desc_lo"><?php echo htmlspecialchars($data['place']['desc_lo']); ?></textarea>
            <input type="text" name="addr_lo" value="<?php echo htmlspecialchars($data['place']['addr_lo']); ?>">
        </div>

        <div class="lang-block" style="border-left: 5px solid green;">
            <h3>🇺🇸 English</h3>
            <label>Place Name:</label>
            <input type="text" name="name_en" value="<?php echo htmlspecialchars($data['place']['name_en'] ?? ''); ?>" required>
            
            <label>Description:</label>
            <textarea name="desc_en"><?php echo htmlspecialchars($data['place']['desc_en'] ?? ''); ?></textarea>
            
            <label>Address:</label>
            <input type="text" name="addr_en" value="<?php echo htmlspecialchars($data['place']['addr_en'] ?? ''); ?>">
        </div>

        <button type="submit">CẬP NHẬT THAY ĐỔI</button>
        <a href="<?php echo URLROOT; ?>/admin">Hủy bỏ</a>
    </form>
</body>
</html>