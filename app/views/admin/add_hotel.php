<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Khách sạn mới - Xayabury Admin</title>
    <style>
        :root {
            --primary-color: #f39c12;
            --secondary-color: #2c3e50;
            --bg-color: #f4f7f6;
            --white: #ffffff;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background-color: var(--bg-color); 
            margin: 0; 
            padding: 20px; 
        }

        .container { 
            max-width: 900px; 
            margin: auto; 
            background: var(--white); 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
        }

        h1 { 
            color: var(--secondary-color); 
            text-align: center; 
            margin-bottom: 30px; 
            font-size: 28px;
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 10px;
            display: inline-block;
        }

        .section-title {
            background: #fdf2e2;
            padding: 10px 15px;
            border-left: 5px solid var(--primary-color);
            margin: 25px 0 15px 0;
            font-weight: bold;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
        }

        .form-group { margin-bottom: 20px; }
        
        label { 
            display: block; 
            font-weight: 600; 
            margin-bottom: 8px; 
            color: #444; 
        }

        input[type="text"], 
        input[type="file"], 
        textarea, 
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 15px;
            transition: 0.3s;
        }

        input:focus, textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 5px rgba(243, 156, 18, 0.2);
        }

        .lang-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .lang-card {
            background: #fff;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 10px;
        }

        .upload-box {
            border: 2px dashed var(--primary-color);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            background: #fffcf5;
        }

        .special-check {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            border: 1px solid #b8daff;
        }

        .btn-submit {
            background: var(--primary-color);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 30px;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #d35400;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
            text-decoration: none;
        }

        .back-link:hover { color: var(--secondary-color); }

        .helper-text { font-size: 12px; color: #7f8c8d; margin-top: 5px; }
    </style>
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

        <button type="submit" class="btn-submit">LƯU KHÁCH SẠN VÀ ẢNH</button>
        
        <a href="<?php echo URLROOT; ?>/admin/hotels" class="back-link">⬅ Quay lại danh sách quản lý khách sạn</a>
    </form>
</div>

</body>
</html>