<link rel="stylesheet" href="<?= URLROOT; ?>/public/css/home/contact.css">
<?php
    if (!isset($data)) {
    $data = [];
}
?>
<?php require_once '../app/views/inc/header.php'; ?>

<div class="container" style="background: transparent; box-shadow: none; padding: 40px 20px;">
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="border-bottom: 3px solid #f39c12; padding-bottom: 10px; display: inline-block; color: #2c3e50;">Liên hệ với chúng tôi</h1>
        <p style="color: #666; margin-top: 15px;">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ hành trình của bạn tại Xayabury.</p>
    </div>

    <div class="contact-wrapper">
        <div class="contact-info">
            <h2>Kết nối nhanh</h2>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <strong>Địa chỉ</strong>
                    <p>Trung tâm thông tin du lịch tỉnh Xayabury, Lào</p>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-phone-alt"></i>
                <div>
                    <strong>Hotline / WhatsApp</strong>
                    <p>+856 20 96 776 795</p>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <strong>Email hỗ trợ</strong>
                    <p>info@xayaburytravel.com</p>
                </div>
            </div>
        </div>

        <div class="contact-form-container">
            <form action="<?= URLROOT ?>/home/send_contact" method="POST">
                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="name" 
                           value="<?= isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>" 
                           placeholder="Nhập tên của bạn..." required>
                </div>
                <div class="form-group">
                    <label>Email hoặc Số điện thoại</label>
                    <input type="text" name="contact" 
                           value="<?= isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>" 
                           placeholder="Để chúng tôi có thể phản hồi lại..." required>
                </div>
                <div class="form-group">
                    <label>Nội dung cần tư vấn</label>
                    <textarea name="message" rows="5" placeholder="Bạn cần chúng tôi giúp đỡ điều gì?" required></textarea>
                </div>

                <?php if(isset($_SESSION['user_id'])) : ?>
                    <button type="submit" class="btn-submit-contact">Gửi tin nhắn ngay</button>
                <?php else : ?>
                    
<?php if(isset($_GET['msg']) && $_GET['msg'] == 'sent'): ?>
    <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-weight: bold;">
        ✅ Tin nhắn của bạn đã được gửi thành công! Admin sẽ phản hồi sớm nhất.
    </div>
<?php endif; ?>

                    <div class="login-required-box">
                        <p>Vui lòng đăng nhập để gửi yêu cầu hỗ trợ cho chúng tôi.</p>
                        <a href="<?= URLROOT; ?>/user/login" class="btn-login-now">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập ngay
                        </a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>