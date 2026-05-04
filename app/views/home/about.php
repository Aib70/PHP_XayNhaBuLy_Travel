<?php require_once '../app/views/inc/header.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Về chúng tôi - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/home/about.css">
<?php
    if (!isset($data)) {
    $data = [];
}
?>
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

    <!-- Hero Section -->
    <section class="about-hero">
        <div class="hero-text">
            <h1>Khám Phá Xayabury</h1>
            <p>Người đồng hành tin cậy trên mọi cung đường tại Lào</p>
        </div>
    </section>

    <div class="container">
        <section class="intro-grid">
            <div class="intro-text">
                <h2>Sứ mệnh của chúng tôi</h2>
                <p><strong>Xayabury Travel</strong> ra đời với mục tiêu mang vẻ đẹp hoang sơ และ huyền bí của "Vùng đất voi" Xayabury đến gần hơn với du khách quốc tế.</p>
                <p>Chúng tôi hiểu rằng một chuyến đi không chỉ là tham quan, mà là sự trải nghiệm văn hóa และ kết nối tâm hồn. Vì vậy, nền tảng này cung cấp thông tin chân thực nhất từ chính những người dân địa phương am hiểu bản sắc.</p>
            </div>
            <div class="intro-img">
                <img src="https://tapchilaoviet.org/wp-content/uploads/2019/05/23.png" alt="Elephant Festival">
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
                        <p>Mọi địa danh và lễ hội đều được đội ngũ chúng tôi khảo sát thực tế และ cập nhật chính xác nhất.</p>
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
            <p>Hãy để Xayabury Travel giúp bạn tạo nên những kỷ niệm không thể nào quên tại đấtน้ำ triệu voi xinh đẹp.</p>
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