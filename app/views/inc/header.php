<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xayabury Travel - <?php echo strtoupper($_SESSION['lang'] ?? 'VI'); ?></title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: #333; color: white; display: flex; justify-content: space-between; align-items: center; padding: 15px 50px; position: sticky; top: 0; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.3); }
        .logo { font-size: 24px; font-weight: bold; color: #ffcc00; text-decoration: none; }
        .nav-container { display: flex; align-items: center; }
        .nav-links { list-style: none; display: flex; margin: 0; padding: 0; align-items: center; }
        .nav-links li { margin-left: 20px; }
        .nav-links a { color: white; text-decoration: none; transition: 0.3s; font-size: 15px; }
        .nav-links a:hover { color: #ffcc00; }
        .nav-links a.active-link { color: #ffcc00; font-weight: bold; border-bottom: 2px solid #ffcc00; padding-bottom: 5px; }
        
        /* CSS CHO DROPDOWN MENU */
        .dropdown { position: relative; display: inline-block; }
        .user-info-btn { color: #ffcc00; font-weight: bold; font-size: 14px; cursor: pointer; padding: 5px 10px; display: flex; align-items: center; gap: 5px; }
        
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #004a7c; /* Màu xanh đậm giống ảnh mẫu */
            min-width: 220px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1100;
            border-radius: 4px;
            margin-top: 5px;
            overflow: hidden;
        }

        .dropdown-content a {
            color: white !important;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .dropdown-content a:hover { background-color: #003559; color: #ffcc00 !important; }
        .dropdown:hover .dropdown-content { display: block; }
        
        .dropdown-header { background: #003559; color: #7cb5ec; padding: 8px 16px; font-size: 11px; text-transform: uppercase; font-weight: bold; }
        .btn-logout-item { background-color: #dc3545 !important; text-align: center !important; font-weight: bold; }

        .lang-switcher { border: 1px solid #555; padding: 5px 10px; border-radius: 4px; background: #444; margin-left: 20px; }
        .lang-switcher a { color: #fff; text-decoration: none; font-size: 13px; margin: 0 5px; }
        .lang-switcher a.active { color: #ffcc00; font-weight: bold; }
    </style>
    
</head>
 



<body>

<?php 
    $lang = $_SESSION['lang'] ?? 'vi';
    $menu = [
        'vi' => [
            'home' => 'Trang chủ', 'places' => 'Địa danh', 'festivals' => 'Các lễ hội', 'about' => 'Về chúng tôi', 'logout' => 'Đăng xuất',
            'history_place' => 'Lịch sử đặt địa danh', 'history_hotel' => 'Lịch sử đặt khách sạn', 'my_reviews' => 'Bình luận của tôi'
        ],
        'lo' => [
            'home' => 'ໜ້າຫຼັກ', 'places' => 'ສະຖານທີ່', 'festivals' => 'ບຸນປະເພນີ', 'about' => 'ກ່ຽວກັບພວກເຮົາ', 'logout' => 'ອອກຈາກລະບົບ',
            'history_place' => 'ປະຫວັດການຈອງສະຖານທີ່', 'history_hotel' => 'ປະຫວັດການຈອງໂຮງແຮມ', 'my_reviews' => 'ຄຳຄິດເຫັນຂອງຂ້ອຍ'
        ],
        'en' => [
            'home' => 'Home', 'places' => 'Places', 'festivals' => 'Festivals', 'about' => 'About Us', 'logout' => 'Logout',
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
    includedLanguages: 'vi,lo,en', // Chỉ cho phép dịch sang Tiếng Việt, Lào, Anh
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
  }, 'google_translate_element');
}
</script>
       <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</div>
</nav>