<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-dark: #1e293b;
            --sidebar-width: 260px;
        }

        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f1f5f9; margin: 0; display: flex; }

        /* SIDEBAR CHUYÊN NGHIỆP */
        .sidebar { 
            width: var(--sidebar-width); 
            background: var(--primary-dark); 
            min-height: 100vh; 
            color: white; 
            position: fixed;
            transition: 0.3s;
        }
        .sidebar-header { padding: 30px 20px; text-align: center; border-bottom: 1px solid #334155; }
        .sidebar-header h2 { font-size: 20px; margin: 0; letter-spacing: 1px; color: #f39c12; }

        .sidebar a { 
            display: flex; align-items: center; gap: 12px; color: #94a3b8; 
            padding: 15px 25px; text-decoration: none; transition: 0.3s;
            border-left: 4px solid transparent;
        }
        .sidebar a:hover, .sidebar a.active { 
            background: #334155; color: white; border-left-color: #f39c12; 
        }
        .sidebar a i { width: 20px; font-size: 18px; }

        /* NỘI DUNG CHÍNH */
        .main-content { 
            flex: 1; 
            margin-left: var(--sidebar-width); 
            padding: 40px; 
        }

        .welcome-box { margin-bottom: 40px; }
        .welcome-box h1 { font-size: 28px; color: #1e293b; margin: 0; }
        .welcome-box p { color: #64748b; margin-top: 5px; }

        /* GRID HỆ THỐNG THẺ THỐNG KÊ (STAT CARDS) */
        .dashboard-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); 
            gap: 25px; 
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .stat-info h3 { font-size: 14px; color: #64748b; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-info .count { font-size: 32px; font-weight: 800; color: #1e293b; margin: 10px 0; display: block; }
        .stat-info .link-text { font-size: 12px; color: #f39c12; font-weight: 600; }

        .stat-icon {
            width: 60px; height: 60px;
            border-radius: 15px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
        }

        /* MÀU SẮC TỪNG THẺ */
        .card-tour .stat-icon { background: #fff7ed; color: #f97316; }
        .card-hotel .stat-icon { background: #f0fdf4; color: #22c55e; }
        .card-booking-place .stat-icon { background: #eff6ff; color: #3b82f6; }
        .card-booking-hotel .stat-icon { background: #f5f3ff; color: #8b5cf6; }
        .card-user .stat-icon { background: #fdf2f8; color: #ec4899; }
        .card-help .stat-icon { background: #fffbeb; color: #f59e0b; }
        .card-forum .stat-icon { background: #f0f9ff; color: #0ea5e9; }

        /* Logout button */
        .btn-logout { color: #ef4444 !important; margin-top: 50px; }
        .btn-logout:hover { background: #fef2f2 !important; }
    </style>
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