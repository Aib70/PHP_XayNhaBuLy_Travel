

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/admin/dashboard.css">
<?php
    if (!isset($data)) {
    $data = [];
}
?>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h2>XAYABURY TRAVEL</h2>
        </div>
        <a href="<?= URLROOT ?>/admin/dashboard" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="<?= URLROOT ?>/admin/index"><i class="fa-solid fa-map-location-dot"></i> Địa danh</a>
        <a href="<?= URLROOT ?>/admin/hotels"><i class="fa-solid fa-hotel"></i> Khách sạn</a>
        <a href="<?= URLROOT ?>/admin/bookings"><i class="fa-solid fa-calendar-check"></i> Đặt chỗ</a>
        <a href="<?= URLROOT ?>/admin/users"><i class="fa-solid fa-users"></i> Người dùng</a>
        <a href="<?= URLROOT ?>/admin/help_requests"><i class="fa-solid fa-headset"></i> Trợ giúp</a>
        <a href="<?= URLROOT ?>/admin/forum"><i class="fa-solid fa-comments"></i> Bình luận</a>
        <a href="<?= URLROOT ?>/auth/logout" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
    </div>

    <div class="main-content">
        <div class="welcome-box">
            <h1>Hệ thống Quản trị</h1>
            <p>Chào mừng Admin, đây là tình hình hoạt động của Xayabury Travel hôm nay.</p>
        </div>

        <div class="dashboard-grid">
            <a href="<?= URLROOT ?>/admin/index" class="stat-card card-tour">
                <div class="stat-info">
                    <h3>Địa danh</h3>
                    <span class="count"><?= $data['count_places'] ?></span>
                    <span class="link-text">Quản lý ngay →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-mountain-sun"></i></div>
            </a>

            <a href="<?= URLROOT ?>/admin/hotels" class="stat-card card-hotel">
                <div class="stat-info">
                    <h3>Khách sạn</h3>
                    <span class="count"><?= $data['count_hotels'] ?></span>
                    <span class="link-text">Quản lý ngay →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-bed"></i></div>
            </a>

            <a href="<?= URLROOT ?>/admin/bookings" class="stat-card card-booking-place">
                <div class="stat-info">
                    <h3>Đặt địa danh</h3>
                    <span class="count"><?= $data['count_place_bookings'] ?></span>
                    <span class="link-text">Xem chi tiết →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-ticket"></i></div>
            </a>

            <a href="<?= URLROOT ?>/admin/bookings" class="stat-card card-booking-hotel">
                <div class="stat-info">
                    <h3>Đặt khách sạn</h3>
                    <span class="count"><?= $data['count_hotel_bookings'] ?></span>
                    <span class="link-text">Xem chi tiết →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-suitcase-rolling"></i></div>
            </a>

            <a href="<?= URLROOT ?>/admin/users" class="stat-card card-user">
                <div class="stat-info">
                    <h3>Người dùng</h3>
                    <span class="count"><?= $data['count_users'] ?></span>
                    <span class="link-text">Quản lý ngay →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-user-group"></i></div>
            </a>

            <a href="<?= URLROOT ?>/admin/help_requests" class="stat-card card-help">
                <div class="stat-info">
                    <h3>Trợ giúp mới</h3>
                    <span class="count"><?= $data['count_contacts'] ?></span>
                    <span class="link-text">Phản hồi ngay →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
            </a>

            <a href="<?= URLROOT ?>/admin/forum" class="stat-card card-forum">
                <div class="stat-info">
                    <h3>Bình luận</h3>
                    <span class="count"><?= $data['count_posts'] ?></span>
                    <span class="link-text">Kiểm duyệt ngay →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-comments"></i></div>
            </a>
        </div>
    </div>

</body>
</html>