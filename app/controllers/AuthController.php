<?php
class AuthController {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Hiển thị trang đăng nhập Admin
    public function login() {
        // Kiểm tra nếu ĐÃ ĐĂNG NHẬP VỚI QUYỀN ADMIN thì mới cho vào thẳng
        if (isset($_SESSION['admin_id']) && $_SESSION['role'] === 'admin') {
            header('Location: ' . URLROOT . '/admin');
            exit();
        }
        require_once '../app/views/auth/login.php';
    }

    // Xử lý dữ liệu gửi từ Form đăng nhập Admin
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $_POST['username'];
            $pass = $_POST['password'];

            $stmt = $this->db->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$user]);
            $foundUser = $stmt->fetch(PDO::FETCH_ASSOC);

            // 1. Kiểm tra mật khẩu (Sử dụng password_verify nếu bạn đã hash pass)
            if ($foundUser && $pass == $foundUser['password']) {
                
                // 2. THIẾT LẬP SESSION RIÊNG CHO ADMIN
                $_SESSION['admin_id'] = $foundUser['id'];
                $_SESSION['admin_name'] = $foundUser['fullname'];
                $_SESSION['role'] = 'admin'; // Gán vai trò là admin

                header('Location: ' . URLROOT . '/admin');
                exit();
            } else {
                die("Sai tên đăng nhập hoặc mật khẩu quản trị!");
            }
        }
    }

    // Đăng xuất Admin
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Chỉ xóa các session liên quan đến Admin để không làm ảnh hưởng session khách (nếu cần)
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['role']);

        // Hoặc hủy toàn bộ nếu muốn đăng xuất sạch sẽ
        session_destroy();

        header('Location: ' . URLROOT . '/home');
        exit();
    }
}