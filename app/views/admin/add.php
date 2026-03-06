<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm địa danh mới</title>
    <style>
        body { font-family: Arial; padding: 20px; line-height: 1.6; background-color: #f4f4f4; }
        .container { background: white; padding: 30px; border-radius: 10px; max-width: 900px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .lang-block { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .vi { border-left: 5px solid red; }
        .lo { border-left: 5px solid blue; }
        .en { border-left: 5px solid green; }
        input, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        .upload-section { background: #fff3cd; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #ffeeba; }
        button { background: #28a745; color: white; padding: 12px 25px; border: none; cursor: pointer; font-size: 16px; border-radius: 5px; font-weight: bold; width: 100%; }
        button:hover { background: #218838; }
    </style>
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

            <label>ID Danh mục (Ví dụ: 1-Điểm tham quan, 2-Khách sạn):</label> 
            <input type="number" name="category_id" required>
            
            <label>Tọa độ bản đồ (Lấy từ Google Maps):</label>
            <div style="display: flex; gap: 10px;">
                <input type="text" name="lat" placeholder="Vĩ độ (Lat)">
                <input type="text" name="lng" placeholder="Kinh độ (Lng)">
            </div>

            <hr>

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

            <button type="submit">LƯU ĐỊA DANH VÀ ẢNH</button>
        </form>
        <br>
        <a href="<?php echo URLROOT; ?>/admin"> Quay lại danh sách</a>
    </div>
</body>
</html>