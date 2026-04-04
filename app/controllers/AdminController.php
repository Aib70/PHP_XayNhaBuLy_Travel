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
    public function hotels() {
    require_once '../app/models/AdminModel.php';
    $adminModel = new AdminModel($this->db);
    
    // Lấy danh sách khách sạn từ model (Category ID = 2)
    $hotels = $adminModel->getOnlyHotels(); 

    $data = [
        'hotels' => $hotels
    ];

    // Thay đổi dòng này để gọi đúng file view mới tạo ở Bước 1
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
            'image'       => $image_name,
            'is_special' => isset($_POST['is_special']) ? 1 : 0,
            
            // Tiếng Việt
            'name_vi'     => $_POST['name_vi'],
            'desc_vi'     => $_POST['desc_vi'],
            'addr_vi'     => $_POST['addr_vi'],
            
            // Tiếng Lào (Bổ sung thêm các dòng này)
            'name_lo'     => $_POST['name_lo'],
            'desc_lo'     => $_POST['desc_lo'],
            'addr_lo'     => $_POST['addr_lo'],
            
            // Tiếng Anh (Bổ sung thêm các dòng này)
            'name_en'     => $_POST['name_en'],
            'desc_en'     => $_POST['desc_en'],
            'addr_en'     => $_POST['addr_en']
        ];

        require_once '../app/models/AdminModel.php';
        $adminModel = new AdminModel($this->db);
        if ($adminModel->updatePlace($id, $data)) {
            // Thêm ?msg=updated để hiện thông báo màu xanh
            header("Location: " . URLROOT . "/admin/index?msg=updated");
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

    // --- QUẢN LÝ DIỄN ĐÀN ---
    public function forum() {
        $stmt = $this->db->query("SELECT * FROM forum_posts ORDER BY status ASC, created_at DESC");
        $data['posts'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        // Truy vấn lấy danh sách đơn đặt chỗ kết hợp với tên địa danh (tiếng Việt)
        $sql = "SELECT b.*, p.name_vi as place_name 
                FROM bookings b 
                JOIN places p ON b.place_id = p.id 
                ORDER BY b.created_at DESC";
        
        $stmt = $this->db->query($sql);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Đóng gói dữ liệu để truyền sang View
        $data = [
            'bookings' => $bookings
        ];

        // Gọi file giao diện hiển thị danh sách đơn đặt chỗ
        require_once '../app/views/admin/bookings.php';
    }

}