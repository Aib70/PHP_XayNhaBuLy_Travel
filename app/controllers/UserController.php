<?php
class UserController {
    private $db;
    private $userModel;

    public function __construct($pdo) { 
        $this->db = $pdo; 
        require_once '../app/models/UserModel.php';
        $this->userModel = new UserModel($this->db);
    }

    // ================== 1. AUTH (ĐĂNG KÝ / ĐĂNG NHẬP / ĐĂNG XUẤT) ==================

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
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT);
            exit();
        }

        $lang = $_SESSION['lang'] ?? 'vi';
        $languages = [
            'vi' => ['login_title' => 'Đăng nhập người dùng', 'email' => 'Địa chỉ Email', 'pass' => 'Mật khẩu', 'btn' => 'ĐĂNG NHẬP'],
            'lo' => ['login_title' => 'ເຂົ້າສູ່ລະບົບ', 'email' => 'ອີເມວ', 'pass' => 'ລະຫັດຜ່ານ', 'btn' => 'ເຂົ້າສູ່ລະບົບ'],
            'en' => ['login_title' => 'User Login', 'email' => 'Email Address', 'pass' => 'Password', 'btn' => 'LOGIN']
        ];

        $data = ['text' => $languages[$lang]];
        require_once '../app/views/user/login.php';
    }

    public function login_process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once '../app/models/UserModel.php';
            $userModel = new UserModel($this->db);

            $email = $_POST['email'];
            $password = $_POST['password'];
            $lang = $_SESSION['lang'] ?? 'vi';

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
                $stmtAdmin = $this->db->prepare("SELECT * FROM admin WHERE email = ?");
                $stmtAdmin->execute([$email]);
                $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

                if ($admin) {
                    if ($password == $admin['password']) {
                        $_SESSION['admin_id'] = $admin['id'];
                        $_SESSION['admin_name'] = $admin['fullname'];
                        $_SESSION['user_email'] = $admin['email'];
                        $_SESSION['role'] = 'admin';
                        header('Location: ' . URLROOT . '/admin/dashboard');
                        exit();
                    } else {
                        $error_msg = $languages[$lang]['error_wrong_pass'];
                    }
                } else {
                    $error_msg = $languages[$lang]['error_not_found'];
                    $show_register = true;
                }
            }

            $data = [
                'text' => $this->getLoginLabels($lang),
                'error_msg' => $error_msg,
                'show_register_link' => $show_register ?? false
            ];
            require_once '../app/views/user/login.php';
        }
    }

    private function getLoginLabels($lang) {
        $labels = [
            'vi' => ['login_title' => 'Đăng nhập người dùng', 'email' => 'Địa chỉ Email', 'pass' => 'Mật khẩu', 'btn' => 'ĐĂNG NHẬP'],
            'lo' => ['login_title' => 'ເຂົ້າສູ່ລະບົບ', 'email' => 'ອີເມວ', 'pass' => 'ລະຫັດຜ່ານ', 'btn' => 'ເຂົ້າສູ່ລະບົບ'],
            'en' => ['login_title' => 'User Login', 'email' => 'Email Address', 'pass' => 'Password', 'btn' => 'LOGIN']
        ];
        return $labels[$lang];
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);

        header('Location: ' . URLROOT . '/home');
        exit();
    }

    // ================== 2. PROFILE (THÔNG TIN CÁ NHÂN) ==================

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/user/login');
            exit();
        }

        require_once '../app/models/UserModel.php';
        $userModel = new UserModel($this->db);
        $userData = $userModel->getUserById($_SESSION['user_id']);

        $data = [
            'title' => 'Thông tin cá nhân',
            'user' => $userData
        ];

        require_once '../app/views/user/profile.php';
    }

    public function edit_profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/user/login');
            exit();
        }

        $userModel = new UserModel($this->db);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_SESSION['user_id'];
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $hashed_password = null;
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            }

            $updateData = [
                'id' => $id,
                'fullname' => $fullname,
                'phone' => $phone,
                'email' => $email,
                'password' => $hashed_password
            ];

            if ($userModel->updateProfileFull($updateData)) {
                $_SESSION['user_name'] = $fullname;
                header('Location: ' . URLROOT . '/user/profile?msg=updated');
            } else {
                die("Lỗi: Email có thể đã tồn tại hoặc lỗi hệ thống.");
            }
        } else {
            $userData = $userModel->getUserById($_SESSION['user_id']);
            $data = ['user' => $userData];
            require_once '../app/views/user/edit_profile.php';
        }
    }

    // ================== 3. BOOKING HISTORY ==================

    public function history_hotels() {
        if (!isset($_SESSION['user_id'])) { 
            header('Location: ' . URLROOT . '/user/login'); 
            exit(); 
        }

        $bookings = $this->userModel->getBookingsByType($_SESSION['user_id'], 2);

        $data = [
            'bookings' => $bookings,
            'lang' => $_SESSION['lang'] ?? 'vi'
        ];
        
        require_once '../app/views/inc/header.php';
        require_once '../app/views/user/history_hotels.php';
        require_once '../app/views/inc/footer.php';
    }

    public function history_places() {
        if (!isset($_SESSION['user_id'])) { 
            header('Location: ' . URLROOT . '/user/login'); 
            exit(); 
        }

        $bookings = $this->userModel->getBookingsByType($_SESSION['user_id'], 'NOT 2');

        $data = [
            'bookings' => $bookings,
            'lang' => $_SESSION['lang'] ?? 'vi'
        ];
        
        require_once '../app/views/inc/header.php';
        require_once '../app/views/user/history_places.php';
        require_once '../app/views/inc/footer.php';
    }

    public function cancel_booking($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/user/login');
            exit();
        }

        $booking = $this->userModel->getBookingById($id);

        if ($booking && $booking['user_id'] == $_SESSION['user_id'] && $booking['status'] == 'pending') {
            if ($this->userModel->deleteBooking($id)) {
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?msg=cancelled');
                exit();
            }
        } else {
            die("Hành động không hợp lệ hoặc đơn hàng đã được Admin xác nhận!");
        }
    }

    // ================== 4. REVIEWS ==================

    public function my_reviews() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/user/login');
            exit();
        }

        require_once '../app/models/UserModel.php';
        $userModel = new UserModel($this->db);
        $myReviews = $userModel->getReviewsByUserId($_SESSION['user_id']);

        $data = [
            'reviews' => $myReviews,
            'title' => 'Bình luận của tôi'
        ];

        require_once '../app/views/inc/header.php';
        require_once '../app/views/user/my_reviews.php';
        require_once '../app/views/inc/footer.php';
    }
}