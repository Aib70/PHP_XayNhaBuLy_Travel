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
        
        // 1. Lấy dữ liệu địa danh chi tiết
        $place = $adminModel->getPlaceById($id);

        if (!$place) { 
            require_once '../app/views/404.php'; 
            exit(); 
        }

        // 2. Lấy danh sách địa danh liên quan
        $related = $adminModel->getRelatedPlaces($id, $lang);

        // 3. CẬP NHẬT: Chỉ lấy danh sách Bình luận của địa danh này (status = 1 và place_id khớp)
        try {
            // Thêm điều kiện WHERE place_id = ? để lọc bình luận riêng biệt
            $stmt = $this->db->prepare("SELECT * FROM forum_posts WHERE status = 1 AND place_id = ? ORDER BY created_at DESC");
            $stmt->execute([$id]); // Truyền ID địa danh hiện tại vào câu lệnh
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $comments = [];
        }

        // 4. ĐỊNH NGHĨA BỘ TỪ ĐIỂN ĐA NGÔN NGỮ (Giữ nguyên phần từ điển của bạn)
        $languages = [
            'vi' => [
                'intro' => 'Giới thiệu', 'address' => 'Địa chỉ', 'location' => 'Vị trí trên bản đồ',
                'direction' => 'Chỉ đường đi', 'related' => 'Địa danh liên quan', 'booking_title' => 'Phiếu Đặt Chỗ',
                'date_label' => 'Ngày dự kiến tham quan:', 'btn_book' => 'GỬI YÊU CẦU ĐẶT CHỖ',
                'comment_title' => 'Bình luận & Đánh giá', 'comment_placeholder' => 'Viết bình luận của bạn tại đây...',
                'btn_comment' => 'Gửi bình luận', 'login_req' => 'Vui lòng đăng nhập để đặt chỗ.',
                'login_btn' => 'Đăng nhập ngay', 'subject' => 'Tiêu đề bình luận',
            ],
            'lo' => [
                'intro' => 'ກ່ຽວກັບ', 'address' => 'ທີ່ຢູ່', 'location' => 'ແຜນທີ່',
                'direction' => 'ເສັ້ນທາງ', 'related' => 'ສະຖານທີ່ທີ່ກ່ຽວຂ້ອງ', 'booking_title' => 'ແບບຟອມຈອງ',
                'date_label' => 'ວັນທີຄາດວ່າຈະມາຢ້ຽມຢາມ:', 'btn_book' => 'ສົ່ງຄຳຮ້ອງຈອງ',
                'comment_title' => 'ຄຳຄິດເຫັນ ແລະ ການໃຫ້ຄະແນນ', 'comment_placeholder' => 'ຂຽນຄຳຄິດເຫັນຂອງທ່ານທີ່ນີ້...',
                'btn_comment' => 'ສົ່ງຄຳຮ້ອງຈອງ', 'login_req' => 'ກະລຸນາເຂົ້າສູ່ລະບົບເພື່ອຈອງ.',
                'login_btn' => 'ເຂົ້າສູ່ລະບົບດຽວນີ້', 'subject' => 'ຫົວຂໍ້ຄຳຄິດເຫັນ',
            ],
            'en' => [
                'intro' => 'About', 'address' => 'Address', 'location' => 'Location',
                'direction' => 'Get Directions', 'related' => 'Related Places', 'booking_title' => 'Book Your Trip',
                'date_label' => 'Expected date:', 'btn_book' => 'SUBMIT REQUEST',
                'comment_title' => 'Comments & Reviews', 'comment_placeholder' => 'Write your comment here...',
                'btn_comment' => 'Post Comment', 'login_req' => 'Please login to book a trip.',
                'login_btn' => 'Login now', 'subject' => 'Comment Subject',
            ]
        ];

        $data = [
            'place' => $place,
            'related' => $related,
            'comments' => $comments,
            'lang' => $lang,
            'text' => $languages[$lang] 
        ];

        require_once '../app/views/inc/header.php';
        require_once '../app/views/places/view.php';
    }

    public function book() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once '../app/models/PlaceModel.php';
        $placeModel = new PlaceModel($this->db);

        $bookingData = [
            'place_id' => $_POST['place_id'],
            'name'     => $_POST['name'],
            'email'    => $_POST['email'],
            // Sử dụng ?? '' để nếu form trống cũng không bị lỗi Warning
            'phone'    => $_POST['phone'] ?? '', 
            'date'     => $_POST['date']
        ];

        if ($placeModel->createBooking($bookingData)) {
            header('Location: ' . URLROOT . '/place/view/' . $_POST['place_id'] . '?msg=booked');
            exit();
        } else {
            die("Lỗi: Không thể lưu dữ liệu vào cơ sở dữ liệu.");
        }
    }
  }
}