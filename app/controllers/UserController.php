<?php
class UserController {
    private $db;
    public function __construct($pdo) { $this->db = $pdo; }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once '../app/models/UserModel.php';
            $userModel = new UserModel($this->db);

            $result = $userModel->register($_POST);

            if ($result === true) {
                header('Location: ' . URLROOT . '/user/login?registered=1');
            } else {
                $error = ($result == "email_exists") ? "Email này đã được sử dụng!" : "Có lỗi xảy ra.";
                require_once '../app/views/user/register.php';
            }
        } else {
            require_once '../app/views/user/register.php';
        }
    }

    public function login() {
    // 1. Kiểm tra xem người dùng đã đăng nhập chưa, nếu rồi thì về trang chủ
    if (isset($_SESSION['user_id'])) {
        header('Location: ' . URLROOT);
        exit();
    }

    // 2. Định nghĩa bộ từ điển đa ngôn ngữ cho trang Login (Tương tự như view)
    $lang = $_SESSION['lang'] ?? 'vi';
    $languages = [
        'vi' => ['login_title' => 'Đăng nhập người dùng', 'email' => 'Địa chỉ Email', 'pass' => 'Mật khẩu', 'btn' => 'ĐĂNG NHẬP'],
        'lo' => ['login_title' => 'ເຂົ້າສູ່ລະບົບ', 'email' => 'ອີເມວ', 'pass' => 'ລະຫັດຜ່ານ', 'btn' => 'ເຂົ້າສູ່ລະບົບ'],
        'en' => ['login_title' => 'User Login', 'email' => 'Email Address', 'pass' => 'Password', 'btn' => 'LOGIN']
    ];

    $data = [
        'text' => $languages[$lang]
    ];

    // 3. Gọi file giao diện
    require_once '../app/views/user/login.php';
  }

public function login_process() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once '../app/models/UserModel.php';
        $userModel = new UserModel($this->db);

        $email = $_POST['email'];
        $password = $_POST['password'];
        $lang = $_SESSION['lang'] ?? 'vi';

        // Bộ từ điển thông báo lỗi
        $languages = [
            'vi' => [
                'error_not_found' => 'Tài khoản không tồn tại. Vui lòng đăng ký!',
                'error_wrong_pass' => 'Mật khẩu không chính xác!'
            ],
            'lo' => [
                'error_not_found' => 'ບໍ່ມີບັນຊີນີ້ໃນລະບົບ. ກະລຸນາລົງທະບຽນ!',
                'error_wrong_pass' => 'ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ!'
            ],
            'en' => [
                'error_not_found' => 'Account does not exist. Please register!',
                'error_wrong_pass' => 'Incorrect password!'
            ]
        ];

        // --- TẦNG 1: KIỂM TRA TRONG BẢNG USERS (KHÁCH HÀNG) ---
        $user = $userModel->getUserByEmail($email);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fullname'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['role'] = 'member';
                header('Location: ' . URLROOT . '/home');
                exit();
            } else {
                $error_msg = $languages[$lang]['error_wrong_pass'];
            }
        } else {
            // --- TẦNG 2: KIỂM TRA TRONG BẢNG ADMIN (NẾU KHÔNG THẤY TRONG USERS) ---
            $stmtAdmin = $this->db->prepare("SELECT * FROM admin WHERE email = ?");
            $stmtAdmin->execute([$email]);
            $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                // Kiểm tra mật khẩu Admin (So khớp trực tiếp '123456' theo DB của bạn)
                if ($password == $admin['password']) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_name'] = $admin['fullname'];
                    $_SESSION['user_email'] = $admin['email'];
                    $_SESSION['role'] = 'admin';
                    header('Location: ' . URLROOT . '/admin');
                    exit();
                } else {
                    $error_msg = $languages[$lang]['error_wrong_pass'];
                }
            } else {
                // KHÔNG TÌM THẤY Ở CẢ 2 BẢNG
                $error_msg = $languages[$lang]['error_not_found'];
                $show_register = true;
            }
        }

        // Nếu có lỗi, tải lại trang login kèm thông báo
        $data = [
            'text' => $this->getLoginLabels($lang), // Hàm lấy nhãn ngôn ngữ
            'error_msg' => $error_msg,
            'show_register_link' => $show_register ?? false
        ];
        require_once '../app/views/user/login.php';
    }
}

// Hàm phụ để lấy nhãn ngôn ngữ tránh lặp code
private function getLoginLabels($lang) {
    $labels = [
        'vi' => ['login_title' => 'Đăng nhập người dùng', 'email' => 'Địa chỉ Email', 'pass' => 'Mật khẩu', 'btn' => 'ĐĂNG NHẬP'],
        'lo' => ['login_title' => 'ເຂົ້າສູ່ລະບົບ', 'email' => 'ອີເມວ', 'pass' => 'ລະຫັດຜ່ານ', 'btn' => 'ເຂົ້າສູ່ລະບົບ'],
        'en' => ['login_title' => 'User Login', 'email' => 'Email Address', 'pass' => 'Password', 'btn' => 'LOGIN']
    ];
    return $labels[$lang];
}

  public function logout() {
    // 1. Kiểm tra session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // 2. Chỉ xóa các biến Session của User khách
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    
    // Lưu ý: Không dùng session_destroy() ở đây nếu bạn muốn giữ lại 
    // lựa chọn ngôn ngữ ($_SESSION['lang']) cho khách sau khi thoát.

    // 3. Chuyển hướng về trang chủ
    header('Location: ' . URLROOT . '/home');
    exit();
 }

}