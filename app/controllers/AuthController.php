<?php
class AuthController {
    private $db;

    // ================== 1. KHỞI TẠO ==================
    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // ================== 2. ĐĂNG NHẬP ADMIN ==================

    // Hiển thị trang đăng nhập
    public function login() {
        if (isset($_SESSION['admin_id']) && empty(Authorization::currentPermissions())) {
            $stmt = $this->db->prepare("SELECT * FROM admin WHERE id = ?");
            $stmt->execute([$_SESSION['admin_id']]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($admin) {
                Authorization::loadForAdmin($this->db, $admin);
            }
        }

        // Nếu đã đăng nhập admin thì chuyển thẳng vào dashboard
        if (isset($_SESSION['admin_id']) && Authorization::hasPermission('view_dashboard')) {
            header('Location: ' . URLROOT . '/admin/dashboard');
            exit();
        }

        require_once '../app/views/auth/login.php';
    }

    // Xử lý đăng nhập
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user = $_POST['username'];
            $pass = $_POST['password'];

            $stmt = $this->db->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$user]);
            $foundUser = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra tài khoản và mật khẩu
            if ($foundUser && $pass == $foundUser['password']) {

                // Tạo session admin
                $_SESSION['admin_id'] = $foundUser['id'];
                $_SESSION['admin_name'] = $foundUser['fullname'];
                $_SESSION['user_name'] = $foundUser['fullname'];
                $_SESSION['user_email'] = $foundUser['email'] ?? null;
                Authorization::loadForAdmin($this->db, $foundUser);

                header('Location: ' . URLROOT . '/admin/dashboard');
                exit();

            } else {
                die("Sai tên đăng nhập hoặc mật khẩu quản trị!");
            }
        }
    }

    // ================== 3. ĐĂNG XUẤT ==================

    // Xử lý đăng xuất admin
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Xóa session admin
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['role']);
        Authorization::clear();

        // Hủy toàn bộ session
        session_destroy();

        header('Location: ' . URLROOT . '/home');
        exit();
    }
}
