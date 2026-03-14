<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa địa danh</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; padding: 20px; background-color: #f4f7f6; }
        .container { max-width: 850px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
        .lang-block { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 8px; }
        input, textarea, select { width: 100%; padding: 12px; margin: 8px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 14px; }
        label { font-weight: bold; display: block; margin-top: 10px; color: #2c3e50; }
        
        /* Phần Đặc Sắc */
        .special-box { 
            background: #e8f4fd; 
            padding: 20px; 
            border-radius: 10px; 
            border: 1px solid #b8daff; 
            margin: 25px 0; 
        }
        .special-box h3 { margin-top: 0; color: #004085; font-size: 18px; display: flex; align-items: center; }
        .checkbox-container { display: flex; align-items: center; cursor: pointer; font-size: 16px; margin-top: 10px; }
        .checkbox-container input { width: 22px; height: 22px; margin-right: 12px; cursor: pointer; }

        button { background: #28a745; color: white; padding: 14px 30px; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; font-size: 16px; transition: 0.3s; }
        button:hover { background: #218838; transform: translateY(-2px); }
        .img-preview { margin: 15px 0; padding: 15px; border: 1px dashed #bbb; border-radius: 8px; background: #fafafa; }
        .btn-cancel { margin-left: 15px; color: #666; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chỉnh sửa địa danh: <?php echo htmlspecialchars($data['place']['name_vi']); ?></h1>
        
        <form action="<?php echo URLROOT; ?>/admin/update/<?php echo $data['place']['id']; ?>" method="POST" enctype="multipart/form-data">
            
            <label>Danh mục địa danh:</label>
            <select name="category_id" required>
                <?php foreach($data['categories'] as $cat): ?>
                    <option value="<?= $cat['id']; ?>" <?= ($cat['id'] == $data['place']['category_id']) ? 'selected' : ''; ?>>
                        <?= $cat['id']; ?> - <?= $cat['icon']; ?> (Dữ liệu từ DB)
                    </option>
                <?php endforeach; ?>
            </select>

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
                         style="width: 250px; border-radius: 8px; border: 1px solid #ddd; display: block; margin-bottom: 10px;">
                    <input type="hidden" name="current_image" value="<?php echo $data['place']['image_main']; ?>">
                </div>
                
                <label>Thay đổi ảnh (để trống nếu giữ nguyên):</label>
                <input type="file" name="image_main" accept="image/*">
            </div>

            <div class="special-box">
                <h3>🌟 Phân loại hiển thị</h3>
                <label class="checkbox-container">
                    <input type="checkbox" name="is_special" value="1" 
                        <?php echo ($data['place']['is_special'] == 1) ? 'checked' : ''; ?>>
                    <strong>Đánh dấu là "Điểm Đến Đặc Sắc"</strong>
                </label>
                <p style="margin: 10px 0 0 34px; font-size: 0.9rem; color: #555;">
                    Trạng thái hiện tại: 
                    <b><?php echo ($data['place']['is_special'] == 1) ? '<span style="color: #28a745;">Đang là Đặc sắc (Hiện ở 2 menu)</span>' : '<span style="color: #6c757d;">Địa danh thường</span>'; ?></b>
                </p>
            </div>

            <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

            <div class="lang-block" style="border-left: 5px solid red;">
                <h3>🇻🇳 Tiếng Việt</h3>
                <input type="text" name="name_vi" value="<?php echo htmlspecialchars($data['place']['name_vi']); ?>" required placeholder="Tên địa danh">
                <textarea name="desc_vi" rows="4" placeholder="Mô tả chi tiết"><?php echo htmlspecialchars($data['place']['desc_vi']); ?></textarea>
                <input type="text" name="addr_vi" value="<?php echo htmlspecialchars($data['place']['addr_vi']); ?>" placeholder="Địa chỉ">
            </div>

            <div class="lang-block" style="border-left: 5px solid blue;">
                <h3>🇱🇦 Tiếng Lào</h3>
                <input type="text" name="name_lo" value="<?php echo htmlspecialchars($data['place']['name_lo']); ?>" required placeholder="ຊື່ສະຖານທີ່">
                <textarea name="desc_lo" rows="4" placeholder="ລາຍລະອຽດ"><?php echo htmlspecialchars($data['place']['desc_lo']); ?></textarea>
                <input type="text" name="addr_lo" value="<?php echo htmlspecialchars($data['place']['addr_lo']); ?>" placeholder="ທີ່ຢູ່">
            </div>

            <div class="lang-block" style="border-left: 5px solid green;">
                <h3>🇺🇸 English</h3>
                <input type="text" name="name_en" value="<?php echo htmlspecialchars($data['place']['name_en'] ?? ''); ?>" required placeholder="Place Name">
                <textarea name="desc_en" rows="4" placeholder="Description"><?php echo htmlspecialchars($data['place']['desc_en'] ?? ''); ?></textarea>
                <input type="text" name="addr_en" value="<?php echo htmlspecialchars($data['place']['addr_en'] ?? ''); ?>" placeholder="Address">
            </div>

            <div style="margin-top: 30px; text-align: center; border-top: 1px solid #eee; padding-top: 20px;">
                <button type="submit">CẬP NHẬT THAY ĐỔI</button>
                <a href="<?php echo URLROOT; ?>/admin" class="btn-cancel">Hủy bỏ</a>
            </div>
        </form>
    </div>
</body>
</html>