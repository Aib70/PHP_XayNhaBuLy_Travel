

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
        <?php if (can(Permissions::MANAGE_PLACES)): ?><a href="<?= URLROOT ?>/admin/index"><i class="fa-solid fa-map-location-dot"></i> Địa danh</a><?php endif; ?>
        <?php if (can(Permissions::MANAGE_HOTELS)): ?><a href="<?= URLROOT ?>/admin/hotels"><i class="fa-solid fa-hotel"></i> Khách sạn</a><?php endif; ?>
        <?php if (can(Permissions::MANAGE_BOOKINGS)): ?><a href="<?= URLROOT ?>/admin/bookings"><i class="fa-solid fa-calendar-check"></i> Đặt chỗ</a><?php endif; ?>
        <?php if (can(Permissions::MANAGE_USERS)): ?><a href="<?= URLROOT ?>/admin/users"><i class="fa-solid fa-users"></i> Người dùng</a><?php endif; ?>
        <?php if (can(Permissions::MANAGE_ROLES)): ?><a href="<?= URLROOT ?>/admin/roles"><i class="fa-solid fa-user-shield"></i> Roles</a><?php endif; ?>
        <?php if (can(Permissions::MANAGE_PERMISSIONS)): ?><a href="<?= URLROOT ?>/admin/permissions"><i class="fa-solid fa-key"></i> Permissions</a><?php endif; ?>
        <?php if (can(Permissions::MANAGE_CONTACTS)): ?><a href="<?= URLROOT ?>/admin/help_requests"><i class="fa-solid fa-headset"></i> Trợ giúp</a><?php endif; ?>
        <?php if (can_any([Permissions::APPROVE_POSTS, Permissions::DELETE_POSTS])): ?><a href="<?= URLROOT ?>/admin/forum"><i class="fa-solid fa-comments"></i> Bình luận</a><?php endif; ?>
        <a href="<?= URLROOT ?>/auth/logout" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
    </div>

    <div class="main-content">
        <div class="welcome-box">
            <h1>Hệ thống Quản trị</h1>
            <p>Chào mừng Admin, đây là tình hình hoạt động của Xayabury Travel hôm nay.</p>
        </div>

        <div class="dashboard-grid">
            <?php if (can(Permissions::MANAGE_PLACES)): ?>
            <a href="<?= URLROOT ?>/admin/index" class="stat-card card-tour">
                <div class="stat-info">
                    <h3>Địa danh</h3>
                    <span class="count"><?= $data['count_places'] ?></span>
                    <span class="link-text">Quản lý ngay →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-mountain-sun"></i></div>
            </a>
            <?php endif; ?>

            <?php if (can(Permissions::MANAGE_HOTELS)): ?>
            <a href="<?= URLROOT ?>/admin/hotels" class="stat-card card-hotel">
                <div class="stat-info">
                    <h3>Khách sạn</h3>
                    <span class="count"><?= $data['count_hotels'] ?></span>
                    <span class="link-text">Quản lý ngay →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-bed"></i></div>
            </a>
            <?php endif; ?>

            <?php if (can(Permissions::MANAGE_BOOKINGS)): ?>
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
            <?php endif; ?>

            <?php if (can(Permissions::MANAGE_USERS)): ?>
            <a href="<?= URLROOT ?>/admin/users" class="stat-card card-user">
                <div class="stat-info">
                    <h3>Người dùng</h3>
                    <span class="count"><?= $data['count_users'] ?></span>
                    <span class="link-text">Quản lý ngay →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-user-group"></i></div>
            </a>
            <?php endif; ?>

            <?php if (can(Permissions::MANAGE_ROLES)): ?>
            <a href="<?= URLROOT ?>/admin/roles" class="stat-card card-user">
                <div class="stat-info">
                    <h3>Roles</h3>
                    <span class="count">RBAC</span>
                    <span class="link-text">Quản lý role →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-user-shield"></i></div>
            </a>
            <?php endif; ?>

            <?php if (can(Permissions::MANAGE_PERMISSIONS)): ?>
            <a href="<?= URLROOT ?>/admin/permissions" class="stat-card card-help">
                <div class="stat-info">
                    <h3>Permissions</h3>
                    <span class="count">ACL</span>
                    <span class="link-text">Quản lý quyền →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-key"></i></div>
            </a>
            <?php endif; ?>

            <?php if (can(Permissions::MANAGE_CONTACTS)): ?>
            <a href="<?= URLROOT ?>/admin/help_requests" class="stat-card card-help">
                <div class="stat-info">
                    <h3>Trợ giúp mới</h3>
                    <span class="count"><?= $data['count_contacts'] ?></span>
                    <span class="link-text">Phản hồi ngay →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
            </a>
            <?php endif; ?>

            <?php if (can_any([Permissions::APPROVE_POSTS, Permissions::DELETE_POSTS])): ?>
            <a href="<?= URLROOT ?>/admin/forum" class="stat-card card-forum">
                <div class="stat-info">
                    <h3>Bình luận</h3>
                    <span class="count"><?= $data['count_posts'] ?></span>
                    <span class="link-text">Kiểm duyệt ngay →</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-comments"></i></div>
            </a>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
