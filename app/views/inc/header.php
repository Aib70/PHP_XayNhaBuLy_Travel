<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xayabury Travel - <?php echo strtoupper($_SESSION['lang'] ?? 'VI'); ?></title>
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/header.css">
</head>

<body>

<?php 
    $lang = $_SESSION['lang'] ?? 'vi';
    $menu = [
        'vi' => [
            'home' => 'Trang chủ', 'places' => 'Địa danh', 'festivals' => 'Các lễ hội', 'about' => 'Về chúng tôi', 'logout' => 'Đăng xuất',
            'profile' => 'Thông tin cá nhân', // Mới thêm
            'history_place' => 'Lịch sử đặt địa danh', 'history_hotel' => 'Lịch sử đặt khách sạn', 'my_reviews' => 'Bình luận của tôi'
        ],
        'lo' => [
            'home' => 'ໜ້າຫຼັກ', 'places' => 'ສະຖານທີ່', 'festivals' => 'ບຸນປະເພນີ', 'about' => 'ກ່ຽວກັບພວກເຮົາ', 'logout' => 'ອອກຈາກລະບົບ',
            'profile' => 'ຂໍ້ມູນສ່ວນຕົວ', // Mới thêm
            'history_place' => 'ປະຫວັດການຈອງສະຖານທີ່', 'history_hotel' => 'ປະຫວັດການຈອງໂຮງແຮມ', 'my_reviews' => 'ຄຳຄິດເຫັນຂອງຂ້ອຍ'
        ],
        'en' => [
            'home' => 'Home', 'places' => 'Places', 'festivals' => 'Festivals', 'about' => 'About Us', 'logout' => 'Logout',
            'profile' => 'Personal Information', // Mới thêm
            'history_place' => 'Place Bookings', 'history_hotel' => 'Hotel Bookings', 'my_reviews' => 'My Reviews'
        ]
    ];
    $text = $menu[$lang];
    $current_cat = $data['cat_id'] ?? 0;
?>

<nav class="navbar">
    <a href="<?php echo URLROOT; ?>" class="logo">XAYABURY TRAVEL</a>
    
    <div class="nav-container">
        <ul class="nav-links">
            <li><a href="<?php echo URLROOT; ?>"><?php echo $text['home']; ?></a></li>
            <li><a href="<?php echo URLROOT; ?>/place/all" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/place/all') !== false) ? 'active-link' : ''; ?>"><?php echo $text['places']; ?></a></li>
            <li><a href="<?php echo URLROOT; ?>/place/category/2" class="<?php echo ($current_cat == 2) ? 'active-link' : ''; ?>"><?php echo ($lang == 'vi') ? 'Khách sạn' : (($lang == 'lo') ? 'ໂຮງແຮມ' : 'Hotels'); ?></a></li>           
            <li><a href="<?php echo URLROOT; ?>/place/category/5" class="<?php echo ($current_cat == 5) ? 'active-link' : ''; ?>"><?php echo $text['festivals']; ?></a></li>
            <li><a href="<?php echo URLROOT; ?>/home/about" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/home/about') !== false) ? 'active-link' : ''; ?>"><?php echo $text['about']; ?></a></li>
            
            <?php if(isset($_SESSION['admin_id']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="<?php echo URLROOT; ?>/admin" style="color: #28a745; font-weight: bold;">⚙ Admin</a></li>
            <?php endif; ?>

            <?php if(isset($_SESSION['user_id'])): ?>
                <li class="dropdown">
                    <div class="user-info-btn">
                        👤 <?php echo htmlspecialchars($_SESSION['user_name']); ?> ▾
                    </div>
                    <div class="dropdown-content">
                        <div class="dropdown-header"><?php echo ($lang == 'vi') ? 'Tài khoản của tôi' : 'My Account'; ?></div>
                        
                        <a href="<?php echo URLROOT; ?>/user/profile">👤 <?php echo $text['profile']; ?></a>
                        
                        <a href="<?php echo URLROOT; ?>/user/history_places">📍 <?php echo $text['history_place']; ?></a>
                        <a href="<?php echo URLROOT; ?>/user/history_hotels">🏨 <?php echo $text['history_hotel']; ?></a>
                        <a href="<?php echo URLROOT; ?>/user/my_reviews">💬 <?php echo $text['my_reviews']; ?></a>
                        <a href="<?php echo URLROOT; ?>/user/logout" class="btn-logout-item" onclick="return confirm('Logout?')">
                            <?php echo $text['logout']; ?>
                        </a>
                    </div>
                </li>
            <?php elseif(!isset($_SESSION['admin_id'])): ?>
                <li><a href="<?php echo URLROOT; ?>/user/login">Login</a></li>
            <?php endif; ?>
        </ul>

        <div id="google_translate_element" style="padding: 20px; text-align: right;"></div>
        <script type="text/javascript">
        function googleTranslateElementInit() {
          new google.translate.TranslateElement({
            pageLanguage: 'vi', 
            includedLanguages: 'vi,lo,en', 
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
          }, 'google_translate_element');
        }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    </div>
</nav>