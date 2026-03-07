<?php
class PlaceController {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function view($id) {
        $lang = $_SESSION['lang'] ?? 'vi';
        require_once '../app/models/AdminModel.php';
        $adminModel = new AdminModel($this->db);
        
        // Lấy dữ liệu địa danh
        $place = $adminModel->getPlaceById($id);

        // Kiểm tra nếu địa danh không có trong Database
        if (!$place) { 
            // Gọi trang 404 thay vì báo lỗi die()
            require_once '../app/views/404.php'; 
            exit(); 
        }

        // Lấy thêm danh sách liên quan
        $related = $adminModel->getRelatedPlaces($id, $lang);

        $data = [
            'place' => $place,
            'related' => $related,
            'lang' => $lang
        ];

        require_once '../app/views/inc/header.php';
        require_once '../app/views/places/view.php';
    }

    public function book() {
    // 1. Kiểm tra nếu có dữ liệu POST gửi lên
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // 2. Nhúng Model để xử lý lưu vào Database
        require_once '../app/models/PlaceModel.php';
        $placeModel = new PlaceModel($this->db);

        // 3. Chuẩn bị dữ liệu từ Form (Khớp với các cột trong bảng bookings của bạn)
        $bookingData = [
            'place_id' => $_POST['place_id'],
            'name'     => $_POST['name'],
            'email'    => $_POST['email'],
            'date'     => $_POST['date']
        ];

        // 4. Gọi hàm lưu trong Model (Chúng ta sẽ viết ở bước 2)
        if ($placeModel->createBooking($bookingData)) {
            // Nếu thành công, quay lại trang chi tiết và báo thành công
            header('Location: ' . URLROOT . '/place/view/' . $_POST['place_id'] . '?success=1');
            exit();
        } else {
            die("Lỗi: Không thể lưu thông tin đặt chỗ.");
        }
    } else {
        // Nếu ai đó truy cập trực tiếp bằng link mà không qua Form -> về Home
        header('Location: ' . URLROOT);
    }
  }
}