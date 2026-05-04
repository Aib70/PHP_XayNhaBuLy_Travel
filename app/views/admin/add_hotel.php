<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Khách sạn mới - Xayabury Admin</title>
     <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/admin/add_hotel.css">
</head>
<body>

<div class="container">
    <div style="text-align: center;">
        <h1>🏨 Nhập thông tin Khách sạn mới</h1>
    </div>

    <form action="<?php echo URLROOT; ?>/admin/store" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="category_id" value="2">

        <div class="section-title">🖼 Hình ảnh đại diện</div>
        <div class="upload-box">
            <label>Chọn file ảnh từ máy tính:</label>
            <input type="file" name="image_main" accept="image/*" required>
            <p class="helper-text">Hỗ trợ: JPG, PNG, WEBP. Ảnh nên có tỉ lệ 4:3 hoặc 16:9.</p>
        </div>

        <div class="section-title">📍 Tọa độ bản đồ (Google Maps)</div>
        <div style="display: flex; gap: 20px;">
            <div style="flex: 1;">
                <label>Vĩ độ (Lat):</label>
                <input type="text" name="lat" placeholder="Ví dụ: 19.236222" required>
            </div>
            <div style="flex: 1;">
                <label>Kinh độ (Lng):</label>
                <input type="text" name="lng" placeholder="Ví dụ: 101.711539" required>
            </div>
        </div>

        <div class="section-title">🌎 Nội dung đa ngôn ngữ</div>
        <div class="lang-grid">
            <div class="lang-card" style="border-top: 4px solid #da251d;">
                <label>🇻🇳 Tiếng Việt</label>
                <input type="text" name="name_vi" placeholder="Tên khách sạn" required>
                <textarea name="desc_vi" placeholder="Mô tả khách sạn..." style="margin-top:10px;"></textarea>
                <input type="text" name="addr_vi" placeholder="Địa chỉ" style="margin-top:10px;">
            </div>

            <div class="lang-card" style="border-top: 4px solid #002868;">
                <label>🇱🇦 Tiếng Lào</label>
                <input type="text" name="name_lo" placeholder="ຊື່ໂຮງແຮມ" required>
                <textarea name="desc_lo" placeholder="ລາຍລະອຽດ..." style="margin-top:10px;"></textarea>
                <input type="text" name="addr_lo" placeholder="ທີ່ຢູ່" style="margin-top:10px;">
            </div>

            <div class="lang-card" style="border-top: 4px solid #046a38;">
                <label>🇺🇸 English</label>
                <input type="text" name="name_en" placeholder="Hotel Name" required>
                <textarea name="desc_en" placeholder="Description..." style="margin-top:10px;"></textarea>
                <input type="text" name="addr_en" placeholder="Address" style="margin-top:10px;">
            </div>
        </div>

        <div class="section-title">🌟 Phân loại hiển thị</div>
        <div class="special-check">
            <input type="checkbox" name="is_special" value="1" id="special" style="width: 20px; height: 20px; margin-right: 15px;">
            <label for="special" style="margin-bottom: 0; cursor: pointer;">
                Đánh dấu là <strong>"Khách sạn nổi bật"</strong>
                <br><span style="font-weight: normal; font-size: 13px; color: #555;">(Sẽ xuất hiện tại mục đề xuất ở trang chủ)</span>
            </label>
        </div>

        <div class="section-title">💰 Thông tin đặt phòng</div>
<div style="display: flex; gap: 20px;">
    <div style="flex: 1;">
        <label>Giá thuê (VNĐ/Đêm):</label>
        <input type="number" name="price" placeholder="Ví dụ: 500000" class="form-control">
    </div>
    <div style="flex: 1;">
        <label>Hạng sao:</label>
        <select name="star_rating" class="form-control">
            <option value="1">1 Sao ⭐</option>
            <option value="2">2 Sao ⭐⭐</option>
            <option value="3">3 Sao ⭐⭐⭐</option>
            <option value="4">4 Sao ⭐⭐⭐⭐</option>
            <option value="5" selected>5 Sao ⭐⭐⭐⭐⭐</option>
        </select>
    </div>
</div>

        <button type="submit" class="btn-submit">LƯU KHÁCH SẠN VÀ ẢNH</button>
        
        <a href="<?php echo URLROOT; ?>/admin/hotels" class="back-link">⬅ Quay lại danh sách quản lý khách sạn</a>
    </form>
</div>

</body>
</html>