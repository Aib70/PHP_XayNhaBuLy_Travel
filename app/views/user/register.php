<?php require_once '../app/views/inc/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Xayabury Travel</title>
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/register.css">
</head>
<body>
    <div class="register-wrapper">
        <div class="register-card">
            <?php 
                // Định nghĩa ngôn ngữ nhanh cho trang đăng ký
                $lang = $_SESSION['lang'] ?? 'vi';
                $t = [
                    'vi' => ['title' => 'Tạo tài khoản mới', 'name' => 'Họ và tên', 'btn' => 'ĐĂNG KÝ NGAY', 'have_acc' => 'Đã có tài khoản?', 'login' => 'Đăng nhập'],
                    'lo' => ['title' => 'ສ້າງບັນຊີໃໝ່', 'name' => 'ຊື່ ແລະ ນາມສະກຸນ', 'btn' => 'ລົງທະບຽນດຽວນີ້', 'have_acc' => 'ມີບັນຊີແລ້ວບໍ?', 'login' => 'ເຂົ້າສູ່ລະບົບ'],
                    'en' => ['title' => 'Create New Account', 'name' => 'Full Name', 'btn' => 'REGISTER NOW', 'have_acc' => 'Already have an account?', 'login' => 'Login']
                ];
                $text = $t[$lang];
            ?>

            <h2><?php echo $text['title']; ?></h2>
            
            <?php if(isset($error)): ?>
                <div class="error-msg">⚠️ <?php echo $error; ?></div>
            <?php endif; ?>

          <form action="<?php echo URLROOT; ?>/user/register" method="POST">
    <div class="form-group">
        <input type="text" name="fullname" required 
               placeholder="<?php echo $text['name']; ?>">
    </div>

    <div class="form-group">
        <input type="email" name="email" required 
               placeholder="Email">
    </div>

    <div style="margin-bottom: 15px;">
    <input type="tel" name="phone" required 
           placeholder="<?php echo ($lang == 'lo') ? 'ເບີໂທລະສັບ' : (($lang == 'en') ? 'Phone Number' : 'Số điện thoại'); ?>" 
           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
    </div>

    <div class="form-group">
        <input type="password" name="password" required 
               placeholder="<?php echo ($lang == 'lo') ? 'ລະຫັດຜ່ານ' : (($lang == 'vi') ? 'Mật khẩu' : 'Password'); ?>">
    </div>

    <button type="submit" class="btn-register">
        <?php echo $text['btn']; ?>
    </button>
  </form>

            <div class="login-link">
                <?php echo $text['have_acc']; ?> 
                <a href="<?php echo URLROOT; ?>/user/login" style="color: #ffcc00; font-weight: bold; text-decoration: none;">
                    <?php echo $text['login']; ?>
                </a>
            </div>
        </div>
    </div>
</body>
</html>

<?php require_once '../app/views/inc/footer.php'; ?>