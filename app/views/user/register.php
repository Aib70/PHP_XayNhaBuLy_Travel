<?php require_once '../app/views/inc/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Xayabury Travel</title>
    <style>
        /* Loại bỏ Flexbox khỏi body để Header không bị nhảy xuống giữa */
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background: #f4f7f6; 
            margin: 0; 
        }

        /* Vùng chứa Form để căn giữa màn hình */
        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px); /* Cân đối không gian dưới Header */
            padding: 20px;
        }

        .register-card { 
            background: white; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 400px; 
        }

        .register-card h2 { text-align: center; color: #333; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            box-sizing: border-box; 
            font-size: 1rem;
        }
        
        .btn-register { 
            width: 100%; 
            padding: 15px; 
            background: #ffcc00; 
            border: none; 
            border-radius: 8px; 
            font-weight: bold; 
            cursor: pointer; 
            font-size: 1rem; 
            transition: 0.3s;
        }
        .btn-register:hover { background: #e6b800; }
        
        .error-msg { 
            background: #fff5f5;
            color: #d9534f; 
            text-align: center; 
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px; 
            font-size: 0.9rem; 
            border: 1px solid #fbd5d5;
        }
        
        .login-link { text-align: center; margin-top: 25px; font-size: 0.9rem; color: #666; }
    </style>
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