<?php require_once '../app/views/inc/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Xayabury Travel</title>
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/login.css">
<?php
    if (!isset($data)) {
    $data = [];
}
?>
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