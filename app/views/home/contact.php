<style>
    /* --- CSS NÂNG CẤP GIAO DIỆN LIÊN HỆ --- */
    .contact-wrapper {
        display: grid;
        grid-template-columns: 1fr 1.6fr; /* Chia 2 cột: Thông tin và Form */
        gap: 30px;
        margin-top: 40px;
        align-items: stretch;
    }

    /* Cột bên trái: Thông tin liên hệ */
    .contact-info {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        padding: 40px;
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        gap: 25px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .contact-info h2 { color: #f39c12; margin: 0 0 10px 0; font-size: 1.8rem; }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 10px;
        transition: 0.3s;
    }

    .info-item:hover { transform: translateX(10px); }

    .info-item i { color: #f39c12; font-size: 1.2rem; margin-top: 4px; }

    .info-item strong { display: block; font-size: 0.85rem; text-transform: uppercase; color: #f39c12; margin-bottom: 3px; }

    .info-item p { margin: 0; font-size: 1rem; line-height: 1.5; opacity: 0.9; }

    /* Cột bên phải: Form gửi tin nhắn */
    .contact-form-container {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border: 1px solid #eee;
    }

    .form-group { margin-bottom: 20px; }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        font-size: 0.95rem;
    }

    /* SỬA LỖI VIỀN ĐEN: Làm các ô input thanh mảnh và sang trọng hơn */
    .contact-form-container input, 
    .contact-form-container textarea {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid #ddd; /* Viền xám nhạt tinh tế */
        border-radius: 12px;
        box-sizing: border-box;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fdfdfd;
        font-family: inherit;
    }

    .contact-form-container input:focus, 
    .contact-form-container textarea:focus {
        border-color: #f39c12;
        background: white;
        outline: none;
        box-shadow: 0 5px 15px rgba(243, 156, 18, 0.1);
    }

    /* Nút bấm hiện đại */
    .btn-submit-contact {
        background: linear-gradient(to right, #f39c12, #e67e22);
        color: white;
        padding: 16px;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
        box-shadow: 0 8px 20px rgba(243, 156, 18, 0.3);
    }

    .btn-submit-contact:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(243, 156, 18, 0.4);
        filter: brightness(1.1);
    }

    /* Responsive cho điện thoại */
    @media (max-width: 850px) {
        .contact-wrapper { grid-template-columns: 1fr; }
    }

    .login-required-box {
        text-align: center;
        padding: 25px;
        border: 2px dashed #f39c12;
        border-radius: 15px;
        background: #fffcf5;
        margin-top: 10px;
    }
    .login-required-box p {
        color: #666;
        margin-bottom: 15px;
        font-weight: 500;
    }
    .btn-login-now {
        display: inline-block;
        padding: 10px 25px;
        background: #2c3e50;
        color: #f39c12;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn-login-now:hover {
        background: #1a252f;
        transform: scale(1.05);
    }

</style>
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