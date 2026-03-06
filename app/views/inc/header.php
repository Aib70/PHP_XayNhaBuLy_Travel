<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xayabury Travel - <?php echo strtoupper($_SESSION['lang']); ?></title>
    <style>
        /* CSS cơ bản cho Menu */
        body { margin: 0; font-family: 'Arial', sans-serif; }
        .navbar { background: #333; color: white; display: flex; justify-content: space-between; align-items: center; padding: 15px 50px; position: sticky; top: 0; z-index: 1000; }
        .logo { font-size: 24px; font-weight: bold; color: #ffcc00; text-decoration: none; }
        .nav-links { list-style: none; display: flex; margin: 0; padding: 0; }
        .nav-links li { margin-left: 20px; }
        .nav-links a { color: white; text-decoration: none; transition: 0.3s; }
        .nav-links a:hover { color: #ffcc00; }
        
        /* Menu ngôn ngữ */
        .lang-switcher { border: 1px solid #555; padding: 5px 10px; border-radius: 4px; background: #444; }
        .lang-switcher a { color: #fff; font-size: 14px; margin: 0 5px; }
        .lang-switcher a.active { color: #ffcc00; font-weight: bold; }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="<?php echo URLROOT; ?>" class="logo">XAYABURY TRAVEL</a>
    
    <ul class="nav-links">
        <li><a href="<?php echo URLROOT; ?>">Trang chủ</a></li>
        <li><a href="#">Địa danh</a></li>
        <li><a href="#">Về chúng tôi</a></li>
        <li><a href="<?php echo URLROOT; ?>/admin">Admin</a></li>
    </ul>

    <div class="lang-switcher">
        <?php $current = $_SESSION['lang']; ?>
        <a href="<?php echo URLROOT; ?>/language/change/vi" class="<?php echo $current == 'vi' ? 'active' : ''; ?>">VI</a> |
        <a href="<?php echo URLROOT; ?>/language/change/lo" class="<?php echo $current == 'lo' ? 'active' : ''; ?>">LO</a> |
        <a href="<?php echo URLROOT; ?>/language/change/en" class="<?php echo $current == 'en' ? 'active' : ''; ?>">EN</a>
    </div>
</nav>