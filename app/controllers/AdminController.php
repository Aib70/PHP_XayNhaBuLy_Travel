<?php
class AdminController {
    private $db;

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

    // Trang Quản lý ĐỊA DANH
    public function index() {
        require_once '../app/models/AdminModel.php';
        $adminModel = new AdminModel($this->db);
        $places = $adminModel->getAllPlacesExceptHotels(); 
        $data = ['places' => $places, 'is_hotel_page' => false];
        require_once '../app/views/admin/index.php';
    }

    // Trang Quản lý KHÁCH SẠN
   // Trang Quản lý KHÁCH SẠN
public function hotels() {
    // Thay vì gọi Model, ta viết SQL trực tiếp để lấy cột pt.address (địa chỉ)
    $sql = "SELECT p.*, pt.name as name_vi, pt.address as addr_vi 
            FROM places p 
            JOIN place_translations pt ON p.id = pt.place_id 
            WHERE p.category_id = 2 AND pt.lang_code = 'vi'
            ORDER BY p.id DESC";
            
    $stmt = $this->db->query($sql);
    $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        'hotels' => $hotels
    ];

    require_once '../app/views/admin/hotels.php'; 
}

    // Trang thêm Khách sạn (Giao diện riêng)
    public function add_hotel() {
        require_once '../app/views/admin/add_hotel.php';
    }

   // Trang thêm Địa danh
    public function add() {
        $stmt = $this->db->query("SELECT * FROM categories WHERE id != 2");
        $data = ['categories' => $stmt->fetchAll(PDO::FETCH_ASSOC)];
        require_once '../app/views/admin/add.php';
    }

    // Hàm lưu dữ liệu (Dùng chung)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image_name = 'default.jpg';
            if (isset($_FILES['image_main']) && $_FILES['image_main']['error'] == 0) {
                $image_name = time() . '_' . $_FILES['image_main']['name'];
                move_uploaded_file($_FILES['image_main']['tmp_name'], "../public/img/places/" . $image_name);
            }

            $data = [
                'category_id' => $_POST['category_id'],
                'lat' => $_POST['lat'], 'lng' => $_POST['lng'],
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
            // Thêm ?msg=added vào cuối đường dẫn
            header("Location: " . URLROOT . $redirect . "?msg=added");
            exit();
            }
        }
    }

    public function edit($id) {
    require_once '../app/models/AdminModel.php';
    $adminModel = new AdminModel($this->db);
    
    // 1. Lấy dữ liệu của địa danh hiện tại
    $place = $adminModel->getPlaceById($id);
    if (!$place) die("Không tìm thấy địa danh!");

    // 2. Lấy danh sách tất cả danh mục để hiển thị trong select box
    $stmt = $this->db->query("SELECT * FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Truyền cả 2 dữ liệu sang View
    $data = [
        'place' => $place,
        'categories' => $categories
    ];
    
    require_once '../app/views/admin/edit.php';
}

    public function update($id) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Mặc định lấy tên ảnh hiện tại
        $image_name = $_POST['current_image'];

        // Xử lý upload ảnh mới
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

        // BẠN CẦN CẬP NHẬT MẢNG NÀY ĐẦY ĐỦ NHƯ SAU:
       $data = [
            'category_id' => $_POST['category_id'],
            'lat'         => $_POST['lat'],
            'lng'         => $_POST['lng'],
            'price_range' => $_POST['price_range'], // THÊM DÒNG NÀY ĐỂ LƯU GIÁ
            'image'       => $image_name,
            'is_special'  => isset($_POST['is_special']) ? 1 : 0,
            
            'name_vi'     => $_POST['name_vi'],
            'desc_vi'     => $_POST['desc_vi'],
            'addr_vi'     => $_POST['addr_vi'],
            
            'name_lo'     => $_POST['name_lo'],
            'desc_lo'     => $_POST['desc_lo'],
            'addr_lo'     => $_POST['addr_lo'],
            
            'name_en'     => $_POST['name_en'],
            'desc_en'     => $_POST['desc_en'],
            'addr_en'     => $_POST['addr_en']
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

    public function delete($id) {
    require_once '../app/models/AdminModel.php';
    $adminModel = new AdminModel($this->db);

    if ($adminModel->deletePlace($id)) { 
        // Thêm ?msg=deleted để hiện thông báo màu đỏ
        header("Location: " . URLROOT . "/admin/index?msg=deleted"); 
        exit(); 
    } else {
        die("Lỗi: Không thể xóa địa danh này trong Database.");
    }
}
    // --- QUẢN LÝ ĐẶT CHỖ (ĐÃ RÚT GỌN) ---
    
   

    // 2. Xem chi tiết thông tin khách hàng (Để lấy SĐT, Email...)
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

    // 3. Xóa đơn đặt chỗ (Dùng khi đã xử lý xong hoặc đơn rác)
    public function delete_booking($id) {
        $sql = "DELETE FROM bookings WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$id])) {
            header('Location: ' . URLROOT . '/admin/bookings?msg=deleted');
        } else {
            die("Lỗi: Không thể xóa đơn đặt chỗ.");
        }
    }

    // --- HÀM XÓA MỘT BÌNH LUẬN DUY NHẤT ---
public function delete_comment($id) {
    // Đảm bảo dùng WHERE id = ? để chỉ xóa đúng 1 bình luận
    $stmt = $this->db->prepare("DELETE FROM forum_posts WHERE id = ?");
    if ($stmt->execute([$id])) {
        // Quay lại trang quản lý bình luận vừa xem
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        die("Lỗi: Không thể xóa bình luận.");
    }
}

    // --- QUẢN LÝ DIỄN ĐÀN ---
    // Thêm tham số $id vào hàm
// Trong file app/controllers/AdminController.php
// --- QUẢN LÝ DIỄN ĐÀN (Đã sửa để lọc theo từng địa danh) ---
public function forum($place_id = null) {
    if (!empty($place_id)) {
        // TRƯỜNG HỢP 1: Xem bình luận của 1 địa danh cụ thể (Khi nhấn từ nút Diễn đàn ở dòng Địa danh)
        $sqlPlace = "SELECT name FROM place_translations WHERE place_id = ? AND lang_code = 'vi' LIMIT 1";
        $stmtPlace = $this->db->prepare($sqlPlace);
        $stmtPlace->execute([$place_id]);
        $place = $stmtPlace->fetch(PDO::FETCH_ASSOC);
        $placeName = "📍 Địa danh: " . ($place ? $place['name'] : "Không xác định");

        $sqlPosts = "SELECT * FROM forum_posts WHERE place_id = ? ORDER BY created_at DESC";
        $stmtPosts = $this->db->prepare($sqlPosts);
        $stmtPosts->execute([$place_id]);
    } else {
        // TRƯỜNG HỢP 2: Xem TẤT CẢ bình luận (Khi nhấn từ Dashboard)
        $placeName = "🌍 Tất cả bình luận trên hệ thống";
        $sqlPosts = "SELECT f.*, pt.name as place_name 
                     FROM forum_posts f
                     LEFT JOIN place_translations pt ON f.place_id = pt.place_id AND pt.lang_code = 'vi'
                     ORDER BY f.status ASC, f.created_at DESC"; // Ưu tiên hiện bài chưa duyệt lên đầu
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

    public function approve_post($id) {
        $stmt = $this->db->prepare("UPDATE forum_posts SET status = 1 WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: ' . URLROOT . '/admin/forum');
    }

    // --- QUẢN LÝ NGƯỜI DÙNG (USERS) ---

// 1. Hiển thị danh sách User
public function users() {
    $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $data = ['users' => $users];
    require_once '../app/views/admin/users/index.php';
}

// 2. Xem chi tiết User
public function user_detail($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) die("Không tìm thấy người dùng!");
    
    $data = ['user' => $user];
    require_once '../app/views/admin/users/detail.php';
}

// 3. Xóa User
public function delete_user($id) {
    $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$id])) {
        header('Location: ' . URLROOT . '/admin/users?msg=deleted');
    } else {
        die("Lỗi: Không thể xóa người dùng này.");
    }
}

// 4. Sửa User (Giao diện)
public function edit_user($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $data = ['user' => $user];
    require_once '../app/views/admin/users/edit.php';
 }

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

 // 1. Giao diện Form thêm người dùng
public function add_user() {
    require_once '../app/views/admin/users/add.php';
}

// 2. Xử lý lưu người dùng mới vào Database
public function store_user() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        // Kiểm tra email đã tồn tại chưa
        $check = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if($check->rowCount() > 0) {
            die("Lỗi: Email này đã được sử dụng!");
        }

        // Mã hóa mật khẩu
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

 // 1. Hiển thị danh sách tất cả đơn đặt chỗ (Đây là hàm bạn đang thiếu)
   public function bookings() {
    require_once '../app/models/AdminModel.php';
    $adminModel = new AdminModel($this->db);
    
    $allBookings = $adminModel->getAllBookings();

    // Phân loại dữ liệu thành 2 mảng riêng biệt
    $hotelBookings = [];
    $placeBookings = [];

    foreach ($allBookings as $booking) {
    // Kiểm tra xem key có tồn tại không trước khi dùng để an toàn tuyệt đối
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

public function approve_booking($id) {
    $stmt = $this->db->prepare("UPDATE bookings SET status = 'confirmed' WHERE id = ?");
    if ($stmt->execute([$id])) {
        header('Location: ' . URLROOT . '/admin/bookings?msg=confirmed');
    } else {
        die("Lỗi: Không thể xác nhận đơn hàng.");
    }
}

// --- QUẢN LÝ TRỢ GIÚP (LIÊN HỆ) ---

// 1. Hiển thị danh sách tin nhắn
public function help_requests() {
    // Sử dụng LEFT JOIN để lấy thêm số điện thoại từ bảng users dựa trên email khách gửi
    $sql = "SELECT c.*, u.phone as register_phone 
            FROM contacts c 
            LEFT JOIN users u ON c.contact_info = u.email 
            ORDER BY c.created_at DESC";
            
    $stmt = $this->db->query($sql);
    $data = ['requests' => $stmt->fetchAll(PDO::FETCH_ASSOC)];
    require_once '../app/views/admin/help/index.php';
}

// 2. Xóa yêu cầu trợ giúp
public function delete_help($id) {
    $stmt = $this->db->prepare("DELETE FROM contacts WHERE id = ?");
    if ($stmt->execute([$id])) {
        header('Location: ' . URLROOT . '/admin/help_requests?msg=deleted');
    } else {
        die("Lỗi: Không thể xóa yêu cầu này.");
    }
}


public function dashboard() {
    // 1. Giữ nguyên các phần đếm cũ
    $totalPlaces = $this->db->query("SELECT COUNT(*) FROM places WHERE category_id != 2")->fetchColumn();
    $totalHotels = $this->db->query("SELECT COUNT(*) FROM places WHERE category_id = 2")->fetchColumn();
    $totalUsers = $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $totalContacts = $this->db->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
    $totalPosts = $this->db->query("SELECT COUNT(*) FROM forum_posts")->fetchColumn();

    // 2. TÁCH RIÊNG ĐẶT CHỖ
    // Đếm đơn đặt Địa danh (category_id != 2)
    $sqlPlaceBookings = "SELECT COUNT(*) FROM bookings b JOIN places p ON b.place_id = p.id WHERE p.category_id != 2";
    $countPlaceBookings = $this->db->query($sqlPlaceBookings)->fetchColumn();

    // Đếm đơn đặt Khách sạn (category_id = 2)
    $sqlHotelBookings = "SELECT COUNT(*) FROM bookings b JOIN places p ON b.place_id = p.id WHERE p.category_id = 2";
    $countHotelBookings = $this->db->query($sqlHotelBookings)->fetchColumn();

    $data = [
        'count_places'          => $totalPlaces,
        'count_hotels'          => $totalHotels,
        'count_users'           => $totalUsers,
        'count_contacts'        => $totalContacts,
        'count_posts'           => $totalPosts,
        'count_place_bookings'  => $countPlaceBookings, // Số lượng đặt địa danh
        'count_hotel_bookings'  => $countHotelBookings  // Số lượng đặt khách sạn
    ];

    require_once '../app/views/admin/dashboard.php';
}

}