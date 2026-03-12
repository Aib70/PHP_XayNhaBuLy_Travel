<?php
class PlaceController {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // 1. Hiển thị chi tiết địa danh (Giữ nguyên logic chuyên đề Giai đoạn 3)
    public function view($id) {
        $lang = $_SESSION['lang'] ?? 'vi'; 
        require_once '../app/models/AdminModel.php';
        $adminModel = new AdminModel($this->db);
        
        $place = $adminModel->getPlaceById($id);

        if (!$place) { 
            require_once '../app/views/404.php'; 
            exit(); 
        }

        $related = $adminModel->getRelatedPlaces($id, $lang);

        try {
            $stmt = $this->db->prepare("SELECT * FROM forum_posts WHERE status = 1 AND place_id = ? ORDER BY created_at DESC");
            $stmt->execute([$id]);
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $comments = [];
        }

        $languages = [
            'vi' => [
                'intro' => 'Giới thiệu', 'address' => 'Địa chỉ', 'location' => 'Vị trí trên bản đồ',
                'direction' => 'Chỉ đường đi', 'related' => 'Địa danh liên quan', 'booking_title' => 'Phiếu Đặt Chỗ',
                'date_label' => 'Ngày dự kiến tham quan:', 'btn_book' => 'GỬI YÊU CẦU ĐẶT CHỖ',
                'comment_title' => 'Bình luận & Đánh giá', 'comment_placeholder' => 'Viết bình luận của bạn tại đây...',
                'btn_comment' => 'Gửi bình luận', 'login_req' => 'Vui lòng đăng nhập để đặt chỗ.',
                'login_btn' => 'Đăng nhập ngay', 'subject' => 'Tiêu đề bình luận',
                'special_title' => 'Di Sản Văn Hóa Voi Xayabury'
            ],
            'lo' => [
                'intro' => 'ກ່ຽວກັບ', 'address' => 'ທີ່ຢູ່', 'location' => 'ແຜນທີ່',
                'direction' => 'ເສັ້ນທາງ', 'related' => 'ສະຖານທີ່ທີ່ກ່ຽວຂ້ອງ', 'booking_title' => 'ແບບຟອມຈອງ',
                'date_label' => 'ວັນທີຄາດວ່າຈະມາຢ້ຽມຢາມ:', 'btn_book' => 'ສົ່ງຄຳຮ້ອງຈອງ',
                'comment_title' => 'ຄຳຄິດເຫັນ ແລະ ການໃຫ້ຄະແນນ', 'comment_placeholder' => 'ຂຽນຄຳຄິດເຫັນຂອງທ່ານທີ່ນີ້...',
                'btn_comment' => 'ສົ່ງຄຳຮ້ອງຈອງ', 'login_req' => 'ກະລຸນາເຂົ້າສູ່ລະບົບເພື່ອຈອງ.',
                'login_btn' => 'ເຂົ້າສູ່ລະບົບດຽວນີ້', 'subject' => 'ຫົວຂໍ້ຄຳຄິດເຫັນ',
                'special_title' => 'ມໍລະດົກວັດທະນະທຳຊ້າງ ໄຊຍະບູລີ'
            ],
            'en' => [
                'intro' => 'About', 'address' => 'Address', 'location' => 'Location',
                'direction' => 'Get Directions', 'related' => 'Related Places', 'booking_title' => 'Book Your Trip',
                'date_label' => 'Expected date:', 'btn_book' => 'SUBMIT REQUEST',
                'comment_title' => 'Comments & Reviews', 'comment_placeholder' => 'Write your comment here...',
                'btn_comment' => 'Post Comment', 'login_req' => 'Please login to book a trip.',
                'login_btn' => 'Login now', 'subject' => 'Comment Subject',
                'special_title' => 'Xayabury Elephant Cultural Heritage'
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

        if ($place['category_id'] == 1) {
            require_once '../app/views/places/view_special.php';
        } else {
            require_once '../app/views/places/view.php';
        }

        require_once '../app/views/inc/footer.php';
    }

    // 2. MỚI: Xử lý hiển thị danh sách theo Danh mục (Lễ hội, Thác nước, vv.)
    public function category($cat_id) {
        $lang = $_SESSION['lang'] ?? 'vi';
        require_once '../app/models/PlaceModel.php';
        $placeModel = new PlaceModel($this->db);

        // Lấy danh sách địa danh thuộc category_id này
        $places = $placeModel->getPlacesByCategory($cat_id, $lang);

        $data = [
            'places' => $places,
            'lang' => $lang,
            'cat_id' => $cat_id,
            'title' => ($cat_id == 1) ? (($lang == 'lo') ? 'ບຸນປະເພນີ' : (($lang == 'en') ? 'Festivals' : 'Các lễ hội')) : 'Địa danh'
        ];

        require_once '../app/views/inc/header.php';
        require_once '../app/views/places/category.php'; // Bạn cần tạo file này
        require_once '../app/views/inc/footer.php';
    }

    // 3. Xử lý đặt chỗ
    public function book() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once '../app/models/PlaceModel.php';
            $placeModel = new PlaceModel($this->db);

            $bookingData = [
                'place_id' => $_POST['place_id'],
                'name'     => $_POST['name'],
                'email'    => $_POST['email'],
                'phone'    => $_POST['phone'] ?? '', 
                'date'     => $_POST['date']
            ];

            if ($placeModel->createBooking($bookingData)) {
                header('Location: ' . URLROOT . '/place/view/' . $_POST['place_id'] . '?msg=booked');
                exit();
            } else {
                die("Lỗi: Không thể lưu dữ liệu.");
            }
        }
    }
}