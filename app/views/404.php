<?php require_once '../app/views/inc/header.php'; ?>

<div style="text-align: center; padding: 100px 20px; font-family: Arial, sans-serif;">
    <h1 style="font-size: 8rem; margin: 0; color: #ffcc00;">404</h1>
    <h2 style="font-size: 2rem; color: #333;">
        <?php 
            echo ($_SESSION['lang'] == 'vi') ? "Úi! Không tìm thấy trang" : 
                (($_SESSION['lang'] == 'lo') ? "ຂໍອະໄພ! ບໍ່ພົບໜ້າທີ່ທ່ານຕ້ອງການ" : "Oops! Page Not Found"); 
        ?>
    </h2>
    <p style="color: #666; margin-bottom: 30px;">
        <?php 
            echo ($_SESSION['lang'] == 'vi') ? "Đường dẫn bạn truy cập không tồn tại hoặc đã bị dời đi." : 
                "The link you followed may be broken, or the page may have been removed."; 
        ?>
    </p>
    <a href="<?php echo URLROOT; ?>" style="display: inline-block; padding: 12px 30px; background: #333; color: #ffcc00; text-decoration: none; border-radius: 30px; font-weight: bold;">
        <?php echo ($_SESSION['lang'] == 'vi') ? "Quay lại trang chủ" : "Back to Home"; ?>
    </a>
</div>