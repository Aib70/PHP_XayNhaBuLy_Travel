<?php
class PlaceController {
    private $db;
    private $placeModel;

    public function __construct($pdo) {
        $this->db = $pdo;
        require_once '../app/models/PlaceModel.php';
        $this->placeModel = new PlaceModel($this->db);
    }


         // 1. Xem chi tiết một địa danh hoặc khách sạn
    public function view($id) {
    $lang = $_SESSION['lang'] ?? 'vi'; 
    require_once '../app/models/AdminModel.php';
    $adminModel = new AdminModel($this->db);
    
    $place = $adminModel->getPlaceById($id);
    if (!$place) { 
        require_once '../app/views/404.php'; 
        exit(); 
    }

    // --- BƯỚC 1: KHỞI TẠO BIẾN MẶC ĐỊNH ĐỂ TRÁNH LỖI ---
    $related = []; 
    $related_title = "";
    $comments = [];

    // --- BƯỚC 2: LẤY DỮ LIỆU LIÊN QUAN ---
    if ($place['category_id'] == 2) {
        // Nếu là khách sạn
        $related = $adminModel->getRelatedHotels($id, $lang);
        $related_title = ($lang == 'vi') ? 'Khách sạn liên quan' : 
                         (($lang == 'lo') ? 'ໂຮງແຮມທີ່ກ່ຽວຂ້ອງ' : 'Related Hotels');
    } else {
        // Nếu là địa danh thường (LỖI THƯỜNG Ở ĐÂY VÌ QUÊN GỌI HÀM)
        $related = $adminModel->getRelatedPlaces($id, $lang, $place['category_id']);
        $related_title = ($lang == 'vi') ? 'Địa danh liên quan' : 
                         (($lang == 'lo') ? 'ສະຖານທີ່ທີ່ກ່ຽວຂ້ອງ' : 'Related Places');
    }

    // --- BƯỚC 3: LẤY BÌNH LUẬN ---
    try {
        $stmt = $this->db->prepare("SELECT * FROM forum_posts WHERE status = 1 AND place_id = ? ORDER BY created_at DESC");
        $stmt->execute([$id]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $comments = [];
    }

    // --- BƯỚC 4: TỪ ĐIỂN ---
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

    // --- BƯỚC 5: GÁN VÀO DỮ LIỆU TRUYỀN SANG VIEW ---
    $data = [
        'place' => $place,
        'related' => $related, // Dòng này cực kỳ quan trọng
        'related_title' => $related_title,
        'comments' => $comments,
        'lang' => $lang,
        'text' => $languages[$lang] 
    ];

    require_once '../app/views/inc/header.php';

    if ($place['category_id'] == 1) {
        require_once '../app/views/places/view_special.php';
    } elseif ($place['category_id'] == 2) {
        require_once '../app/views/places/view_hotel.php';
    } else {
        require_once '../app/views/places/view.php';
    }

    require_once '../app/views/inc/footer.php';
}

    // 2. Hiển thị danh sách theo Danh mục (Lễ hội, Địa danh...)
    public function category($cat_id) {
        $lang = $_SESSION['lang'] ?? 'vi';
        
        $places = $this->placeModel->getPlacesByCategory($cat_id, $lang);

       // --- SỬA LOGIC TIÊU ĐỀ TẠI ĐÂY ---
    if ($cat_id == 2) {
        // Nếu là menu Khách sạn (ID = 2)
        $pageTitle = ($lang == 'vi') ? 'Khách sạn & Lưu trú' : 
                     (($lang == 'lo') ? 'ໂຮງແຮມ ແລະ ທີ່ພັກ' : 'Hotels & Accommodation');
    } elseif ($cat_id == 5) {
        // Nếu là menu Lễ hội (ID = 5)
        $pageTitle = ($lang == 'vi') ? 'Các lễ hội đặc sắc' : 
                     (($lang == 'lo') ? 'ບຸນປະເພນີ' : 'Special Festivals');
    } else {
        // Các danh mục khác mặc định là Địa danh
        $pageTitle = ($lang == 'vi') ? 'Địa danh du lịch' : 
                     (($lang == 'lo') ? 'ສະຖານທີ່ທ່ອງທ່ຽວ' : 'Tourist Attractions');
    }


        $data = [
            'places' => $places,
            'lang' => $lang,
            'cat_id' => $cat_id,
            'title' => $pageTitle
        ];

        require_once '../app/views/inc/header.php';
        require_once '../app/views/places/category.php';
        require_once '../app/views/inc/footer.php';
    }

    // 3. Xử lý đặt chỗ
    public function book() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/user/login');
            exit();
        }

        // Chuẩn bị dữ liệu để truyền vào Model
        $data = [
            'place_id'     => $_POST['place_id'],
            'user_id'      => $_SESSION['user_id'],
            'user_name'    => $_POST['name'],
            'user_email'   => $_SESSION['user_email'] ?? null,
            'phone'        => $_POST['phone'],
            // Nếu là địa danh dùng date, nếu là khách sạn dùng checkin
            'booking_date' => (!empty($_POST['date'])) ? $_POST['date'] : ($_POST['checkin'] ?? date('Y-m-d')),
            'checkin'      => !empty($_POST['checkin']) ? $_POST['checkin'] : null,
            'checkout'     => !empty($_POST['checkout']) ? $_POST['checkout'] : null,
            'guests'       => !empty($_POST['guests']) ? $_POST['guests'] : 1
        ];

        if ($this->placeModel->createBooking($data)) {
            header('Location: ' . URLROOT . '/place/view/' . $data['place_id'] . '?msg=booked');
            exit();
        } else {
            die('Lỗi thực thi câu lệnh SQL.');
        }
    }
}

    public function all() {
    $lang = $_SESSION['lang'] ?? 'vi';
    
    // SỬA TẠI ĐÂY: Thay vì lấy ALL, chỉ lấy Destinations (Trừ KS)
    $places = $this->placeModel->getAllDestinationsOnly($lang);
    
    $data = [
        'places' => $places,
        'title' => ($lang == 'vi') ? 'Tất cả địa danh du lịch' : 
                   (($lang == 'lo') ? 'ສະຖານທີ່ທ່ອງທ່ຽວທັງໝົດ' : 'All Destinations'),
        'cat_id' => 'all' 
    ];
    require_once '../app/views/inc/header.php';
    require_once '../app/views/places/category.php';
    require_once '../app/views/inc/footer.php';
  }
// 4. Xử lý gửi bình luận & đánh giá
  public function add_review($place_id) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
        // 1. Lấy dữ liệu từ Form
        $author_name = $_SESSION['user_name']; 
        $title = $_POST['title'] ?? 'Bình luận mới';
        
        // SỬA DÒNG NÀY: Đổi từ 'content' thành 'comment' cho khớp với Form
        $content = $_POST['comment'] ?? ''; 
        
        $rating = $_POST['rating'] ?? 5; 
        
        // 2. Câu lệnh SQL (Giữ nguyên vì bảng của bạn dùng cột content là đúng rồi)
        $sql = "INSERT INTO forum_posts (author_name, title, content, status, created_at, place_id, rating) 
                VALUES (?, ?, ?, 1, NOW(), ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        
        // 3. Thực thi
        if ($stmt->execute([$author_name, $title, $content, $place_id, $rating])) {
            header("Location: " . URLROOT . "/place/view/" . $place_id . "?msg=success");
            exit();
        } else {
            die("Lỗi: Không thể lưu bình luận.");
        }
    } else {
        header('Location: ' . URLROOT . '/user/login');
        exit();
    }
}
}