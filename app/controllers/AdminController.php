<?php
class AdminController {
    private $db;

    // ================== 1. KHỞI TẠO & BẢO MẬT ==================
    public function __construct($pdo) {
        $this->db = $pdo;

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Chốt chặn bảo mật
        if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . URLROOT . '/home');
            exit();
        }
    }

    // ================== 2. ĐỊA DANH & KHÁCH SẠN ==================

    // Trang Quản lý ĐỊA DANH
    public function index() {
        require_once '../app/models/AdminModel.php';
        $adminModel = new AdminModel($this->db);
        $places = $adminModel->getAllPlacesExceptHotels(); 
        $data = ['places' => $places, 'is_hotel_page' => false];
        require_once '../app/views/admin/index.php';
    }

    // Trang Quản lý KHÁCH SẠN
    public function hotels() {
        $sql = "SELECT p.*, pt.name as name_vi, pt.address as addr_vi 
                FROM places p 
                JOIN place_translations pt ON p.id = pt.place_id 
                WHERE p.category_id = 2 AND pt.lang_code = 'vi'
                ORDER BY p.id DESC";
        $stmt = $this->db->query($sql);
        $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = ['hotels' => $hotels];
        require_once '../app/views/admin/hotels.php'; 
    }

    // Trang thêm Khách sạn
    public function add_hotel() {
        require_once '../app/views/admin/add_hotel.php';
    }

    // Trang thêm Địa danh
    public function add() {
        $stmt = $this->db->query("SELECT * FROM categories WHERE id != 2");
        $data = ['categories' => $stmt->fetchAll(PDO::FETCH_ASSOC)];
        require_once '../app/views/admin/add.php';
    }

    // Lưu dữ liệu
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image_name = 'default.jpg';

            if (isset($_FILES['image_main']) && $_FILES['image_main']['error'] == 0) {
                $image_name = time() . '_' . $_FILES['image_main']['name'];
                move_uploaded_file($_FILES['image_main']['tmp_name'], "../public/img/places/" . $image_name);
            }

            $data = [
                'category_id' => $_POST['category_id'],
                'lat' => $_POST['lat'],
                'lng' => $_POST['lng'],
                'image' => $image_name,
                'is_special' => isset($_POST['is_special']) ? 1 : 0,
                'name_vi' => $_POST['name_vi'], 'desc_vi' => $_POST['desc_vi'], 'addr_vi' => $_POST['addr_vi'],
                'name_lo' => $_POST['name_lo'], 'desc_lo' => $_POST['desc_lo'], 'addr_lo' => $_POST['addr_lo'],
                'name_en' => $_POST['name_en'], 'desc_en' => $_POST['desc_en'], 'addr_en' => $_POST['addr_en']
            ];

            require_once '../app/models/AdminModel.php';
            $adminModel = new AdminModel($this->db);

            if ($adminModel->addPlace($data)) {
                $redirect = ($_POST['category_id'] == 2) ? '/admin/hotels' : '/admin/index';
                header("Location: " . URLROOT . $redirect . "?msg=added");
                exit();
            }
        }
    }

    // Form chỉnh sửa
    public function edit($id) {
        require_once '../app/models/AdminModel.php';
        $adminModel = new AdminModel($this->db);

        $place = $adminModel->getPlaceById($id);
        if (!$place) die("Không tìm thấy địa danh!");

        $stmt = $this->db->query("SELECT * FROM categories");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'place' => $place,
            'categories' => $categories
        ];

        require_once '../app/views/admin/edit.php';
    }

    // Cập nhật dữ liệu
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $image_name = $_POST['current_image'];

            if (isset($_FILES['image_main']) && $_FILES['image_main']['error'] == 0) {
                $ext = strtolower(pathinfo($_FILES['image_main']['name'], PATHINFO_EXTENSION));
                $image_name = time() . '_' . uniqid() . '.' . $ext;
                $target_dir = "../public/img/places/";

                if (move_uploaded_file($_FILES['image_main']['tmp_name'], $target_dir . $image_name)) {
                    if ($_POST['current_image'] != 'default.jpg' && file_exists($target_dir . $_POST['current_image'])) {
                        unlink($target_dir . $_POST['current_image']);
                    }
                }
            }

            $data = [
                'category_id' => $_POST['category_id'],
                'lat' => $_POST['lat'],
                'lng' => $_POST['lng'],
                'price_range' => $_POST['price_range'],
                'image' => $image_name,
                'is_special' => isset($_POST['is_special']) ? 1 : 0,
                'name_vi' => $_POST['name_vi'], 'desc_vi' => $_POST['desc_vi'], 'addr_vi' => $_POST['addr_vi'],
                'name_lo' => $_POST['name_lo'], 'desc_lo' => $_POST['desc_lo'], 'addr_lo' => $_POST['addr_lo'],
                'name_en' => $_POST['name_en'], 'desc_en' => $_POST['desc_en'], 'addr_en' => $_POST['addr_en']
            ];

            require_once '../app/models/AdminModel.php';
            $adminModel = new AdminModel($this->db);

            if ($adminModel->updatePlace($id, $data)) {
                $redirect = ($_POST['category_id'] == 2) ? '/admin/hotels' : '/admin/index';
                header("Location: " . URLROOT . $redirect . "?msg=updated");
                exit();
            }
        }
    }

    // Xóa địa danh
    public function delete($id) {
        require_once '../app/models/AdminModel.php';
        $adminModel = new AdminModel($this->db);

        if ($adminModel->deletePlace($id)) {
            header("Location: " . URLROOT . "/admin/index?msg=deleted");
            exit();
        } else {
            die("Lỗi: Không thể xóa địa danh này trong Database.");
        }
    }

    // ================== 3. BOOKINGS ==================

    // Danh sách đơn đặt chỗ
    public function bookings() {
        require_once '../app/models/AdminModel.php';
        $adminModel = new AdminModel($this->db);

        $allBookings = $adminModel->getAllBookings();

        $hotelBookings = [];
        $placeBookings = [];

        foreach ($allBookings as $booking) {
            if (isset($booking['category_id']) && $booking['category_id'] == 2) {
                $hotelBookings[] = $booking;
            } else {
                $placeBookings[] = $booking;
            }
        }

        $data = [
            'hotelBookings' => $hotelBookings,
            'placeBookings' => $placeBookings
        ];

        require_once '../app/views/admin/bookings.php';
    }

    // Chi tiết booking
    public function booking_detail($id) {
        $sql = "SELECT b.*, p.name_vi as place_name 
                FROM bookings b 
                JOIN places p ON b.place_id = p.id 
                WHERE b.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$booking) die("Không tìm thấy thông tin đơn đặt chỗ!");

        $data = ['booking' => $booking];
        require_once '../app/views/admin/booking_detail.php';
    }

    // Xóa booking
    public function delete_booking($id) {
        $stmt = $this->db->prepare("DELETE FROM bookings WHERE id = ?");
        if ($stmt->execute([$id])) {
            header('Location: ' . URLROOT . '/admin/bookings?msg=deleted');
        } else {
            die("Lỗi: Không thể xóa đơn đặt chỗ.");
        }
    }

    // Duyệt booking
    public function approve_booking($id) {
        $stmt = $this->db->prepare("UPDATE bookings SET status = 'confirmed' WHERE id = ?");
        if ($stmt->execute([$id])) {
            header('Location: ' . URLROOT . '/admin/bookings?msg=confirmed');
        } else {
            die("Lỗi: Không thể xác nhận đơn hàng.");
        }
    }

    // ================== 4. FORUM ==================

    // Hiển thị bình luận
    public function forum($place_id = null) {
        if (!empty($place_id)) {

            $sqlPlace = "SELECT name FROM place_translations WHERE place_id = ? AND lang_code = 'vi' LIMIT 1";
            $stmtPlace = $this->db->prepare($sqlPlace);
            $stmtPlace->execute([$place_id]);
            $place = $stmtPlace->fetch(PDO::FETCH_ASSOC);

            $placeName = "📍 Địa danh: " . ($place ? $place['name'] : "Không xác định");

            $sqlPosts = "SELECT * FROM forum_posts WHERE place_id = ? ORDER BY created_at DESC";
            $stmtPosts = $this->db->prepare($sqlPosts);
            $stmtPosts->execute([$place_id]);

        } else {

            $placeName = "🌍 Tất cả bình luận trên hệ thống";

            $sqlPosts = "SELECT f.*, pt.name as place_name 
                         FROM forum_posts f
                         LEFT JOIN place_translations pt ON f.place_id = pt.place_id AND pt.lang_code = 'vi'
                         ORDER BY f.status ASC, f.created_at DESC";

            $stmtPosts = $this->db->prepare($sqlPosts);
            $stmtPosts->execute();
        }

        $posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'posts' => $posts,
            'place_name' => $placeName
        ];

        require_once '../app/views/admin/forum.php';
    }

    // Duyệt bình luận
    public function approve_post($id) {
        $stmt = $this->db->prepare("UPDATE forum_posts SET status = 1 WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: ' . URLROOT . '/admin/forum');
    }

    // Xóa bình luận
    public function delete_comment($id) {
        $stmt = $this->db->prepare("DELETE FROM forum_posts WHERE id = ?");
        if ($stmt->execute([$id])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            die("Lỗi: Không thể xóa bình luận.");
        }
    }

    // ================== 5. USERS ==================

    // Danh sách user
    public function users() {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = ['users' => $users];
        require_once '../app/views/admin/users/index.php';
    }

    // Chi tiết user
    public function user_detail($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) die("Không tìm thấy người dùng!");

        $data = ['user' => $user];
        require_once '../app/views/admin/users/detail.php';
    }

    // Thêm user (form)
    public function add_user() {
        require_once '../app/views/admin/users/add.php';
    }

    // Lưu user
    public function store_user() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];

            $check = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $check->execute([$email]);

            if($check->rowCount() > 0) {
                die("Lỗi: Email này đã được sử dụng!");
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (fullname, email, phone, password, created_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);

            if ($stmt->execute([$fullname, $email, $phone, $hashed_password])) {
                header('Location: ' . URLROOT . '/admin/users?msg=added');
            } else {
                die("Lỗi: Không thể thêm người dùng.");
            }
        }
    }

    // Sửa user (form)
    public function edit_user($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $data = ['user' => $user];
        require_once '../app/views/admin/users/edit.php';
    }

    // Cập nhật user
    public function update_user($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            $sql = "UPDATE users SET fullname = ?, email = ?, phone = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);

            if ($stmt->execute([$fullname, $email, $phone, $id])) {
                header('Location: ' . URLROOT . '/admin/users?msg=updated');
            } else {
                die("Lỗi cập nhật người dùng.");
            }
        }
    }

    // Xóa user
    public function delete_user($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt->execute([$id])) {
            header('Location: ' . URLROOT . '/admin/users?msg=deleted');
        } else {
            die("Lỗi: Không thể xóa người dùng này.");
        }
    }

    // ================== 6. HỖ TRỢ ==================

    // Danh sách liên hệ
    public function help_requests() {
        $sql = "SELECT c.*, u.phone as register_phone 
                FROM contacts c 
                LEFT JOIN users u ON c.contact_info = u.email 
                ORDER BY c.created_at DESC";

        $stmt = $this->db->query($sql);
        $data = ['requests' => $stmt->fetchAll(PDO::FETCH_ASSOC)];

        require_once '../app/views/admin/help/index.php';
    }

    // Xóa liên hệ
    public function delete_help($id) {
        $stmt = $this->db->prepare("DELETE FROM contacts WHERE id = ?");
        if ($stmt->execute([$id])) {
            header('Location: ' . URLROOT . '/admin/help_requests?msg=deleted');
        } else {
            die("Lỗi: Không thể xóa yêu cầu này.");
        }
    }

    // ================== 7. DASHBOARD ==================

    // Dashboard thống kê
    public function dashboard() {

        $totalPlaces = $this->db->query("SELECT COUNT(*) FROM places WHERE category_id != 2")->fetchColumn();
        $totalHotels = $this->db->query("SELECT COUNT(*) FROM places WHERE category_id = 2")->fetchColumn();
        $totalUsers = $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $totalContacts = $this->db->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
        $totalPosts = $this->db->query("SELECT COUNT(*) FROM forum_posts")->fetchColumn();

        $sqlPlaceBookings = "SELECT COUNT(*) FROM bookings b JOIN places p ON b.place_id = p.id WHERE p.category_id != 2";
        $countPlaceBookings = $this->db->query($sqlPlaceBookings)->fetchColumn();

        $sqlHotelBookings = "SELECT COUNT(*) FROM bookings b JOIN places p ON b.place_id = p.id WHERE p.category_id = 2";
        $countHotelBookings = $this->db->query($sqlHotelBookings)->fetchColumn();
        
        
        $data = [
            'count_places' => $totalPlaces,
            'count_hotels' => $totalHotels,
            'count_users' => $totalUsers,
            'count_contacts' => $totalContacts,
            'count_posts' => $totalPosts,
            'count_place_bookings' => $countPlaceBookings,
            'count_hotel_bookings' => $countHotelBookings
        ];

        require_once '../app/views/admin/dashboard.php';
    }
}