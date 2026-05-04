<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm địa danh mới</title>
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/admin/add.css">
   
</head>
<body>
    <div class="container">
        <h1>Nhập thông tin địa danh mới</h1>
        
        <form action="<?php echo URLROOT; ?>/admin/store" method="POST" enctype="multipart/form-data">
            
            <div class="upload-section">
                <h3>🖼 Hình ảnh đại diện</h3>
                <label>Chọn file ảnh từ máy tính:</label>
                <input type="file" name="image_main" accept="image/*" required>
                <small>Hỗ trợ: JPG, PNG, WEBP. Ảnh nên có tỉ lệ 4:3 hoặc 16:9.</small>
            </div>

            <label>Danh mục địa danh:</label> 
            <select name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php if(!empty($data['categories'])): ?>
                    <?php foreach($data['categories'] as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>">
                            <?php echo $cat['id']; ?> - <?php echo $cat['icon']; ?> (Dữ liệu từ DB)
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="1">1 - fa-elephant (Mặc định)</option>
                    <option value="2">2 - fa-tree (Mặc định)</option>
                <?php endif; ?>
            </select>
            
            <label>Tọa độ bản đồ (Lấy từ Google Maps):</label>
            <div style="display: flex; gap: 10px;">
                <input type="text" name="lat" placeholder="Vĩ độ (Lat)">
                <input type="text" name="lng" placeholder="Kinh độ (Lng)">
            </div>

            <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

            <div class="lang-block vi">
                <h3>🇻🇳 Tiếng Việt</h3>
                <input type="text" name="name_vi" placeholder="Tên địa danh" required>
                <textarea name="desc_vi" rows="4" placeholder="Mô tả chi tiết"></textarea>
                <input type="text" name="addr_vi" placeholder="Địa chỉ cụ thể">
            </div>

            <div class="lang-block lo">
                <h3>🇱🇦 Tiếng Lào</h3>
                <input type="text" name="name_lo" placeholder="ຊື່ສະຖານທີ່" required>
                <textarea name="desc_lo" rows="4" placeholder="ລາຍລະອຽດ"></textarea>
                <input type="text" name="addr_lo" placeholder="ທີ່ຢູ່">
            </div>

            <div class="lang-block en">
                <h3>🇺🇸 Tiếng Anh</h3>
                <input type="text" name="name_en" placeholder="Place Name" required>
                <textarea name="desc_en" rows="4" placeholder="Description"></textarea>
                <input type="text" name="addr_en" placeholder="Address">
            </div>
<div style="background: #e8f4fd; padding: 20px; border-radius: 10px; border: 1px solid #b8daff; margin: 20px 0;">
    <h3 style="margin-top: 0; color: #004085;">🌟 Phân loại hiển thị</h3>
    <label style="display: flex; align-items: center; cursor: pointer; font-size: 16px;">
        <input type="checkbox" name="is_special" value="1" style="width: 22px; height: 22px; margin-right: 12px;">
        <strong>Đánh dấu là "Điểm Đến Đặc Sắc"</strong>
    </label>
    <p style="margin: 10px 0 0 34px; font-size: 0.9rem; color: #555;">
        (Nếu tích chọn, địa danh này sẽ xuất hiện ở cả menu <b>Địa danh</b> và menu <b>Các lễ hội/Đặc sắc</b>)
    </p>
</div>
            <button type="submit">LƯU ĐỊA DANH VÀ ẢNH</button>
        </form>
        
        <a href="<?php echo URLROOT; ?>/admin" class="back-link">⬅ Quay lại danh sách quản lý</a>
    </div>
</body>
</html>