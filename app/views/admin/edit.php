<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa địa danh</title>
    <style>
        body { font-family: Arial; padding: 20px; background-color: #f4f7f6; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .lang-block { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        input, textarea { width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        button { background: #28a745; color: white; padding: 12px 25px; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; }
        button:hover { background: #218838; }
        .img-preview { margin: 15px 0; padding: 10px; border: 1px dashed #bbb; border-radius: 5px; background: #fafafa; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chỉnh sửa địa danh: <?php echo htmlspecialchars($data['place']['name_vi']); ?></h1>
        
        <form action="<?php echo URLROOT; ?>/admin/update/<?php echo $data['place']['id']; ?>" method="POST" enctype="multipart/form-data">
            
            <label>ID Danh mục:</label> 
            <input type="number" name="category_id" value="<?php echo $data['place']['category_id']; ?>" required>
            
            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label>Vĩ độ (Lat):</label> 
                    <input type="text" name="lat" value="<?php echo $data['place']['latitude']; ?>">
                </div>
                <div style="flex: 1;">
                    <label>Kinh độ (Lng):</label> 
                    <input type="text" name="lng" value="<?php echo $data['place']['longitude']; ?>">
                </div>
            </div>

            <div class="img-preview">
                <h3>🖼 Hình ảnh địa danh</h3>
                <div style="margin-bottom: 10px;">
                    <p style="font-size: 0.8rem; color: #666;">Ảnh hiện tại:</p>
                    <img src="<?php echo URLROOT; ?>/public/img/places/<?php echo $data['place']['image_main']; ?>" 
                         style="width: 200px; border-radius: 8px; border: 1px solid #ddd; display: block;">
                    
                    <input type="hidden" name="current_image" value="<?php echo $data['place']['image_main']; ?>">
                </div>
                
                <label>Chọn ảnh mới (để trống nếu giữ nguyên):</label>
                <input type="file" name="image_main" accept="image/*">
            </div>

            <div class="lang-block">
                <h3>🇻🇳 Tiếng Việt</h3>
                <input type="text" name="name_vi" value="<?php echo htmlspecialchars($data['place']['name_vi']); ?>" required>
                <textarea name="desc_vi" rows="4"><?php echo htmlspecialchars($data['place']['desc_vi']); ?></textarea>
                <input type="text" name="addr_vi" value="<?php echo htmlspecialchars($data['place']['addr_vi']); ?>">
            </div>

            <div class="lang-block">
                <h3>🇱🇦 Tiếng Lào</h3>
                <input type="text" name="name_lo" value="<?php echo htmlspecialchars($data['place']['name_lo']); ?>" required>
                <textarea name="desc_lo" rows="4"><?php echo htmlspecialchars($data['place']['desc_lo']); ?></textarea>
                <input type="text" name="addr_lo" value="<?php echo htmlspecialchars($data['place']['addr_lo']); ?>">
            </div>

            <div class="lang-block" style="border-left: 5px solid green;">
                <h3>🇺🇸 English</h3>
                <input type="text" name="name_en" value="<?php echo htmlspecialchars($data['place']['name_en'] ?? ''); ?>" required>
                <textarea name="desc_en" rows="4"><?php echo htmlspecialchars($data['place']['desc_en'] ?? ''); ?></textarea>
                <input type="text" name="addr_en" value="<?php echo htmlspecialchars($data['place']['addr_en'] ?? ''); ?>">
            </div>

            <button type="submit">CẬP NHẬT THAY ĐỔI</button>
            <a href="<?php echo URLROOT; ?>/admin" style="margin-left: 15px; color: #666;">Hủy bỏ</a>
        </form>
    </div>
</body>
</html>