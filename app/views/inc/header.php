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
        
        /* CSS cho phần User/Auth */
        .user-info { color: #ffcc00; font-weight: bold; font-size: 14px; border-right: 1px solid #555; padding-right: 15px; margin-right: 15px; }
        .btn-logout { background: #dc3545; color: white !important; padding: 5px 12px; border-radius: 4px; font-size: 13px !important; }
        
        /* Menu ngôn ngữ */
        .lang-switcher { border: 1px solid #555; padding: 5px 10px; border-radius: 4px; background: #444; margin-left: 20px; }
        .lang-switcher a { color: #fff; text-decoration: none; font-size: 13px; margin: 0 5px; }
        .lang-switcher a.active { color: #ffcc00; font-weight: bold; }
    </style>
</head>
<body>

<?php 
    // Bộ từ điển nhanh cho Header - ĐÃ THÊM 'festivals'
    $lang = $_SESSION['lang'] ?? 'vi';
    $menu = [
        'vi' => [
            'home' => 'Trang chủ', 
            'places' => 'Địa danh', 
            'festivals' => 'Các lễ hội', // Thêm mới
            'about' => 'Về chúng tôi', 
            'logout' => 'Đăng xuất'
        ],
        'lo' => [
            'home' => 'ໜ້າຫຼັກ', 
            'places' => 'ສະຖານທີ່', 
            'festivals' => 'ບຸນປະເພນີ', // Thêm mới
            'about' => 'ກ່ຽວກັບພວກເຮົາ', 
            'logout' => 'ອອກຈາກລະບົບ'
        ],
        'en' => [
            'home' => 'Home', 
            'places' => 'Places', 
            'festivals' => 'Festivals', // Thêm mới
            'about' => 'About Us', 
            'logout' => 'Logout'
        ]
    ];
    $text = $menu[$lang];
?>

<nav class="navbar">
    <a href="<?php echo URLROOT; ?>" class="logo">XAYABURY TRAVEL</a>
    
    <div class="nav-container">
        <ul class="nav-links">
            <li><a href="<?php echo URLROOT; ?>"><?php echo $text['home']; ?></a></li>
            <li><a href="#"><?php echo $text['places']; ?></a></li>
            
            <li>
            <a href="<?php echo URLROOT; ?>/place/category/5" >
            <?php echo $text['festivals']; ?>
            </a>
            </li>

            <li><a href="#"><?php echo $text['about']; ?></a></li>
            
            <?php if(isset($_SESSION['admin_id']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="<?php echo URLROOT; ?>/admin" style="color: #28a745; font-weight: bold;">⚙ Admin</a></li>
            <?php endif; ?>

            <?php if(isset($_SESSION['user_id'])): ?>
                <li class="user-info">👤 <?php echo htmlspecialchars($_SESSION['user_name']); ?></li>
                <li><a href="<?php echo URLROOT; ?>/user/logout" class="btn-logout" onclick="return confirm('Logout?')"><?php echo $text['logout']; ?></a></li>
            <?php elseif(!isset($_SESSION['admin_id'])): ?>
                <li><a href="<?php echo URLROOT; ?>/user/login">Login</a></li>
            <?php endif; ?>
        </ul>

        <div class="lang-switcher">
            <a href="<?php echo URLROOT; ?>/language/change/vi" class="<?php echo $lang == 'vi' ? 'active' : ''; ?>">VI</a> |
            <a href="<?php echo URLROOT; ?>/language/change/lo" class="<?php echo $lang == 'lo' ? 'active' : ''; ?>">LO</a> |
            <a href="<?php echo URLROOT; ?>/language/change/en" class="<?php echo $lang == 'en' ? 'active' : ''; ?>">EN</a>
        </div>
    </div>
</nav>