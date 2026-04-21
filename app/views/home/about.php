<?php require_once '../app/views/inc/header.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Về chúng tôi - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #f39c12;
            --secondary-color: #2c3e50;
            --text-color: #555;
            --bg-light: #f9f9f9;
        }

        body { font-family: 'Segoe UI', sans-serif; margin: 0; line-height: 1.6; color: var(--text-color); }

        /* Hero Section */
        .about-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('<?= URLROOT ?>/public/img/about_bg.jpg') center/cover;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .about-hero h1 { font-size: 3rem; margin: 0; text-transform: uppercase; letter-spacing: 2px; }

        .container { max-width: 1100px; margin: auto; padding: 60px 20px; }

        /* Intro Section */
        .intro-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center; }
        .intro-text h2 { color: var(--secondary-color); font-size: 2rem; border-left: 5px solid var(--primary-color); padding-left: 15px; }
        .intro-img img { width: 100%; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }

        /* Core Values */
        .values-section { background: var(--bg-light); padding: 80px 0; margin-top: 50px; }
        .values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; text-align: center; }
        
        .value-card-link { text-decoration: none; color: inherit; display: block; transition: 0.3s; }
        .value-card { 
            background: white; padding: 40px; border-radius: 15px; height: 100%; 
            box-sizing: border-box; cursor: pointer; transition: 0.3s;
        }
        .value-card:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .value-card i { font-size: 3rem; color: var(--primary-color); margin-bottom: 20px; }
        .value-card h3 { color: var(--secondary-color); margin-bottom: 15px; }

        /* Modal Đa ngôn ngữ */
        .lang-modal {
            display: none; position: fixed; z-index: 9999; left: 0; top: 0; 
            width: 100%; height: 100%; background-color: rgba(0,0,0,0.7);
            align-items: center; justify-content: center;
        }
        .modal-content {
            background: white; padding: 40px; border-radius: 20px; text-align: center;
            max-width: 500px; width: 90%; position: relative; animation: zoomIn 0.3s ease;
        }
        @keyframes zoomIn { from {transform: scale(0.8); opacity: 0;} to {transform: scale(1); opacity: 1;} }
        
        .lang-options { display: flex; justify-content: space-around; margin-top: 30px; gap: 15px; }
        .lang-item { 
            text-decoration: none; color: #333; font-weight: bold; 
            display: flex; flex-direction: column; align-items: center; gap: 10px;
        }
        .lang-item img { width: 60px; height: 40px; object-fit: cover; border-radius: 5px; border: 1px solid #eee; transition: 0.3s; }
        .lang-item:hover img { transform: scale(1.1); border-color: var(--primary-color); }
        .close-modal { position: absolute; right: 20px; top: 15px; font-size: 24px; cursor: pointer; color: #999; }

        /* Map Section */
        .map-section { margin-top: 50px; text-align: center; padding-bottom: 60px; }
        .map-container {
            width: 100%; height: 450px; border-radius: 20px; overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 5px solid white; margin-top: 20px;
        }

        /* Contact CTA */
        .cta-section { text-align: center; padding: 60px 20px; background: var(--secondary-color); color: white; border-radius: 15px; margin-top: 50px; }
        .btn-contact {
            display: inline-block; background: var(--primary-color); color: white; 
            padding: 15px 35px; border-radius: 30px; text-decoration: none; 
            font-weight: bold; margin-top: 20px; transition: 0.3s;
        }
        .btn-contact:hover { background: #e67e22; transform: scale(1.05); }

        @media (max-width: 768px) {
            .intro-grid, .values-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div id="languageModal" class="lang-modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeLangModal()">&times;</span>
            <h2 style="color: var(--secondary-color);">Chọn ngôn ngữ của bạn</h2>
            <div class="lang-options">
                <a href="<?= URLROOT ?>/language/change/vi" class="lang-item">
                    <img src="https://flagcdn.com/w80/vn.png" alt="VN">
                    <span>Tiếng Việt</span>
                </a>
                <a href="<?= URLROOT ?>/language/change/lo" class="lang-item">
                    <img src="https://flagcdn.com/w80/la.png" alt="LA">
                    <span>ພາສາລາວ</span>
                </a>
                <a href="<?= URLROOT ?>/language/change/en" class="lang-item">
                    <img src="https://flagcdn.com/w80/us.png" alt="EN">
                    <span>English</span>
                </a>
            </div>
        </div>
    </div>

    <section class="about-hero">
        <div>
            <h1>Khám Phá Xayabury</h1>
            <p>Người đồng hành tin cậy trên mọi cung đường tại Lào</p>
        </div>
    </section>

    <div class="container">
        <section class="intro-grid">
            <div class="intro-text">
                <h2>Sứ mệnh của chúng tôi</h2>
                <p><strong>Xayabury Travel</strong> ra đời với mục tiêu mang vẻ đẹp hoang sơ và huyền bí của "Vùng đất voi" Xayabury đến gần hơn với du khách quốc tế.</p>
                <p>Chúng tôi hiểu rằng một chuyến đi không chỉ là tham quan, mà là sự trải nghiệm văn hóa và kết nối tâm hồn. Vì vậy, nền tảng này cung cấp thông tin chân thực nhất từ chính những người dân địa phương am hiểu bản sắc.</p>
            </div>
            <div class="intro-img">
                <img src="https://images.unsplash.com/photo-1510009581131-4876258f7f21?q=80&w=1000" alt="Elephant Festival">
            </div>
        </section>
    </div>

    <section class="values-section">
        <div class="container">
            <h2 style="text-align:center; color: var(--secondary-color); margin-bottom: 50px;">Tại sao chọn Xayabury Travel?</h2>
            <div class="values-grid">
                
                <a href="<?= URLROOT ?>/place/all" class="value-card-link">
                    <div class="value-card">
                        <i class="fas fa-map-marked-alt"></i>
                        <h3>Thông tin bản địa</h3>
                        <p>Mọi địa danh và lễ hội đều được đội ngũ chúng tôi khảo sát thực tế và cập nhật chính xác nhất.</p>
                    </div>
                </a>

                <a href="<?= URLROOT ?>/place/category/2" class="value-card-link">
                    <div class="value-card">
                        <i class="fas fa-hotel"></i>
                        <h3>Đặt phòng dễ dàng</h3>
                        <p>Hệ thống đặt chỗ thông minh, minh bạch về giá cả và cam kết chất lượng phục vụ hàng đầu.</p>
                    </div>
                </a>

                <div class="value-card" onclick="openLangModal()">
                    <i class="fas fa-globe-asia"></i>
                    <h3>Đa ngôn ngữ</h3>
                    <p>Xóa tan rào cản ngôn ngữ với hỗ trợ Tiếng Lào, Tiếng Việt và Tiếng Anh xuyên suốt trải nghiệm.</p>
                </div>

            </div>
        </div>
    </section>

    <section class="map-section container">
        <h2>📍 Khám phá vị trí Xayabury</h2>
        <p>Xayabury nằm ở phía Tây Bắc nước Lào, là tỉnh duy nhất nằm hoàn toàn bên bờ Tây sông Mekong.</p>
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1901053.8681734912!2d100.22234053702581!3d19.231936365947355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31260338779956d9%3A0xe5493019808a90da!2zWGF5YWJ1cnksIEzDoG8!5e0!3m2!1svi!2s!4v1711234567890!5m2!1svi!2s" 
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>
    </section>

    <div class="container" style="padding-top: 0;">
        <section class="cta-section">
            <h2>Bạn đã sẵn sàng cho hành trình tiếp theo?</h2>
            <p>Hãy để Xayabury Travel giúp bạn tạo nên những kỷ niệm không thể nào quên tại đất nước triệu voi xinh đẹp.</p>
            <a href="<?= URLROOT ?>/home/contact" class="btn-contact">Liên hệ với chúng tôi ngay</a>
        </section>
    </div>

    <script>
        function openLangModal() {
            document.getElementById('languageModal').style.display = 'flex';
        }

        function closeLangModal() {
            document.getElementById('languageModal').style.display = 'none';
        }

        window.onclick = function(event) {
            let modal = document.getElementById('languageModal');
            if (event.target == modal) {
                closeLangModal();
            }
        }
    </script>
</body>
</html>
<?php require_once '../app/views/inc/footer.php'; ?>