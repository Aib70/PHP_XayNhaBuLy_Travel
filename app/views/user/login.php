<?php require_once '../app/views/inc/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Xayabury Travel</title>
    <style>
        /* 2. Sửa CSS: Không để Flex cho body để Header nằm yên trên cùng */
        body { 
            font-family: 'Segoe UI', sans-serif; 
            background: #f4f7f6; 
            margin: 0; 
        }

        /* 3. Tạo một vùng chứa riêng cho Form để căn giữa */
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px); /* Trừ đi chiều cao ước tính của Header */
        }

        .login-card { 
            background: white; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 350px; 
        }

        .login-card h2 { text-align: center; color: #333; margin-bottom: 25px; }
        .form-group { margin-bottom: 15px; }
        .form-group input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            box-sizing: border-box; 
        }
        .btn-submit { 
            width: 100%; 
            padding: 15px; 
            background: #333; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: 0.3s;
        }
        .btn-submit:hover { background: #555; }
        .error-box {
            background: #fff5f5; 
            color: #d9534f; 
            padding: 12px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            border: 1px solid #fbd5d5; 
            text-align: center; 
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <h2><?php echo $data['text']['login_title']; ?></h2>

            <?php if(isset($data['error_msg'])): ?>
                <div class="error-box">
                    ⚠️ <?php echo $data['error_msg']; ?>
                    <?php if(isset($data['show_register_link'])): ?>
                        <br>
                        <a href="<?php echo URLROOT; ?>/user/register" style="font-weight: bold; text-decoration: underline; color: #d9534f;">
                            <?php echo ($_SESSION['lang'] == 'lo') ? "ລົງທະບຽນດຽວນີ້" : "Đăng ký ngay tại đây"; ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <form action="<?php echo URLROOT; ?>/user/login_process" method="POST">
                <div class="form-group">
                    <input type="email" name="email" required placeholder="<?php echo $data['text']['email']; ?>">
                </div>
                <div class="form-group">
                    <input type="password" name="password" required placeholder="<?php echo $data['text']['pass']; ?>">
                </div>
                <button type="submit" class="btn-submit"><?php echo $data['text']['btn']; ?></button>
            </form>

            <p style="text-align:center; margin-top:20px; font-size:0.9rem; color: #666;">
                <?php echo ($_SESSION['lang'] == 'lo') ? "ຍັງບໍ່ມີບັນຊີບໍ?" : "Chưa có tài khoản?"; ?> 
                <a href="<?php echo URLROOT; ?>/user/register" style="color:#ffcc00; font-weight: bold; text-decoration: none;">
                    <?php echo ($_SESSION['lang'] == 'lo') ? "ລົງທະບຽນເລີຍ" : "Đăng ký ngay"; ?>
                </a>
            </p>
        </div>
    </div>
</body>
</html>

<?php require_once '../app/views/inc/footer.php'; ?>