<?php
class AuthController {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Hiển thị trang đăng nhập
    public function login() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/admin');
            exit();
        }
        require_once '../app/views/auth/login.php';
    }

    // Xử lý dữ liệu gửi từ Form
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $_POST['username'];
            $pass = $_POST['password'];

            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$user]);
            $foundUser = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra mật khẩu (Ở đây so sánh trực tiếp, sau này nên dùng password_verify)
            if ($foundUser && $pass == $foundUser['password']) {
                $_SESSION['user_id'] = $foundUser['id'];
                $_SESSION['user_name'] = $foundUser['fullname'];
                header('Location: ' . URLROOT . '/admin');
                exit();
            } else {
                die("Sai tên đăng nhập hoặc mật khẩu!");
            }
        }
    }

    // Đăng xuất
    public function logout() {
    // 1. Bắt đầu session (nếu chưa có)
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // 2. Xóa toàn bộ biến session
    $_SESSION = array();

    // 3. Hủy session trên server
    session_destroy();

    // 4. Chuyển hướng người dùng về trang đăng nhập hoặc trang chủ
    header('Location: ' . URLROOT . '/home');
    exit();
}
}