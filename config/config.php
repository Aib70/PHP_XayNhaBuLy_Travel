<?php
/**
 * FILE CẤU HÌNH HỆ THỐNG - XAYABURY TRAVEL
 */

// 1. Cấu hình Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // Mặc định của XAMPP
define('DB_PASS', '123456');          // Mặc định của XAMPP là trống
define('DB_NAME', 'xayabury_travel');
define('DB_CHARSET', 'utf8mb4');

// 2. Cấu hình Đường dẫn (URL)
// Thay đổi 'xayabury_travel' nếu bạn đặt tên thư mục khác
define('URLROOT', 'http://localhost/xayabury_travel');

// Tên website
define('SITENAME', 'Xayabury Travel Support');

// 3. Kết nối Database bằng PDO
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Đẩy lỗi ra để dễ sửa khi đang code
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Trả về dữ liệu dạng mảng kết hợp
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Tăng tính bảo mật chống SQL Injection
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
    // Nếu kết nối thành công, có thể dùng biến $pdo ở mọi nơi
} catch (PDOException $e) {
    // Nếu lỗi, dừng chương trình và hiện thông báo
    die("Lỗi kết nối Database: " . $e->getMessage());
}

// 4. Khởi tạo Session (Dùng cho đa ngôn ngữ và đăng nhập sau này)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    
}
// Nếu chưa chọn ngôn ngữ, mặc định là tiếng Việt

if (!isset($_SESSION['lang'])) {

    $_SESSION['lang'] = 'vi';

}