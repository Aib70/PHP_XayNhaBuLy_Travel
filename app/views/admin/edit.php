<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa địa danh</title>
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/admin/edit.css">


<?php
    if (!isset($data)) {
    $data = [];
}
?>

   
</head>
<body>
    <div class="container">
        <h1>Chỉnh sửa: <?php echo htmlspecialchars($data['place']['name_vi']); ?></h1>
        
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

            <!-- CHỈ HIỂN THỊ GIÁ PHÒNG NẾU DANH MỤC LÀ KHÁCH SẠN (ID = 2) -->
            <?php if($data['place']['category_id'] == 2): ?>
            <div style="margin-bottom: 20px; padding: 15px; background: #fff3cd; border-radius: 8px; border: 1px solid #ffeeba;">
                <label style="font-weight: bold; color: #856404;">💰 Giá phòng (VNĐ/đêm):</label>
                <input type="number" name="price_range" 
                       value="<?php echo $data['place']['price_range']; ?>" 
                       placeholder="Ví dụ: 500000" 
                       style="width: 100%; padding: 12px; margin-top: 8px; border: 1px solid #ddd; border-radius: 6px;">
                <small style="color: #666;">* Nhập số nguyên, không cần nhập dấu chấm.</small>
            </div>
            <?php else: ?>
                <!-- Gửi ẩn giá trị cũ để tránh lỗi SQL nếu không phải khách sạn -->
                <input type="hidden" name="price_range" value="<?php echo $data['place']['price_range']; ?>">
            <?php endif; ?>

            <div class="img-preview">
                <h3>🖼 Hình ảnh</h3>
                <img src="<?php echo URLROOT; ?>/public/img/places/<?php echo $data['place']['image_main']; ?>" 
                     style="width: 250px; border-radius: 8px; display: block; margin-bottom: 10px;">
                <label>Thay đổi ảnh:</label>
                <input type="file" name="image_main" accept="image/*">
            </div>

            <div class="special-box">
                <h3>🌟 Phân loại hiển thị</h3>
                <label class="checkbox-container">
                    <input type="checkbox" name="is_special" value="1" 
                        <?php echo ($data['place']['is_special'] == 1) ? 'checked' : ''; ?>>
                    <strong>Đánh dấu là "Điểm Đến Đặc Sắc"</strong>
                </label>
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

            <div class="lang-block">
                <h3>🇺🇸 English</h3>
                <input type="text" name="name_en" value="<?php echo htmlspecialchars($data['place']['name_en'] ?? ''); ?>" required>
                <textarea name="desc_en" rows="4"><?php echo htmlspecialchars($data['place']['desc_en'] ?? ''); ?></textarea>
                <input type="text" name="addr_en" value="<?php echo htmlspecialchars($data['place']['addr_en'] ?? ''); ?>">
            </div>

            <div style="margin-top: 30px; text-align: center;">
                <button type="submit">CẬP NHẬT THAY ĐỔI</button>
                <a href="<?php echo URLROOT; ?>/admin" class="btn-cancel">Hủy bỏ</a>
            </div>
        </form>
    </div>
</body>
</html>