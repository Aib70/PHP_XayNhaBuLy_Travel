<?php
class PlaceController {
    private $db;
    private $placeModel;

    // ================== 1. KHỞI TẠO ==================
    public function __construct($pdo) {
        $this->db = $pdo;
        require_once '../app/models/PlaceModel.php';
        $this->placeModel = new PlaceModel($this->db);
    }

    // ================== 2. CHI TIẾT ĐỊA DANH ==================

    // Xem chi tiết một địa danh hoặc khách sạn
    public function view($id) {
        $lang = $_SESSION['lang'] ?? 'vi'; 

        require_once '../app/models/AdminModel.php';
        $adminModel = new AdminModel($this->db);
        
        $place = $adminModel->getPlaceById($id);

        if (!$place) { 
            require_once '../app/views/404.php'; 
            exit(); 
        }

        // --- BƯỚC 1: KHỞI TẠO ---
        $related = []; 
        $related_title = "";
        $comments = [];

        // --- BƯỚC 2: DỮ LIỆU LIÊN QUAN ---
        if ($place['category_id'] == 2) {
            $related = $adminModel->getRelatedHotels($id, $lang);
            $related_title = ($lang == 'vi') ? 'Khách sạn liên quan' : 
                             (($lang == 'lo') ? 'ໂຮງແຮມທີ່ກ່ຽວຂ້ອງ' : 'Related Hotels');
        } else {
            $related = $adminModel->getRelatedPlaces($id, $lang, $place['category_id']);
            $related_title = ($lang == 'vi') ? 'Địa danh liên quan' : 
                             (($lang == 'lo') ? 'ສະຖານທີ່ທີ່ກ່ຽວຂ້ອງ' : 'Related Places');
        }

        // --- BƯỚC 3: BÌNH LUẬN ---
        try {
            $stmt = $this->db->prepare("SELECT * FROM forum_posts WHERE status = 1 AND place_id = ? ORDER BY created_at DESC");
            $stmt->execute([$id]);
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $comments = [];
        }

        // --- BƯỚC 4: TỪ ĐIỂN NGÔN NGỮ ---
        $languages = [
            'vi' => [
                'intro' => 'Giới thiệu','address' => 'Địa chỉ','location' => 'Vị trí trên bản đồ',
                'direction' => 'Chỉ đường đi','related' => 'Địa danh liên quan','booking_title' => 'Phiếu Đặt Chỗ',
                'date_label' => 'Ngày dự kiến tham quan:','btn_book' => 'GỬI YÊU CẦU ĐẶT CHỖ',
                'comment_title' => 'Bình luận & Đánh giá','comment_placeholder' => 'Viết bình luận của bạn tại đây...',
                'btn_comment' => 'Gửi bình luận','login_req' => 'Vui lòng đăng nhập để đặt chỗ.',
                'login_btn' => 'Đăng nhập ngay','subject' => 'Tiêu đề bình luận',
                'special_title' => 'Di Sản Văn Hóa Voi Xayabury'
            ],
            'lo' => [
                'intro' => 'ກ່ຽວກັບ','address' => 'ທີ່ຢູ່','location' => 'ແຜນທີ່',
                'direction' => 'ເສັ້ນທາງ','related' => 'ສະຖານທີ່ທີ່ກ່ຽວຂ້ອງ','booking_title' => 'ແບບຟອມຈອງ',
                'date_label' => 'ວັນທີຄາດວ່າຈະມາຢ້ຽມຢາມ:','btn_book' => 'ສົ່ງຄຳຮ້ອງຈອງ',
                'comment_title' => 'ຄຳຄິດເຫັນ ແລະ ການໃຫ້ຄະແນນ','comment_placeholder' => 'ຂຽນຄຳຄິດເຫັນ...',
                'btn_comment' => 'ສົ່ງຄຳຄິດເຫັນ','login_req' => 'ກະລຸນາເຂົ້າລະບົບ.',
                'login_btn' => 'ເຂົ້າລະບົບ','subject' => 'ຫົວຂໍ້',
                'special_title' => 'ມໍລະດົກຊ້າງ'
            ],
            'en' => [
                'intro' => 'About','address' => 'Address','location' => 'Location',
                'direction' => 'Get Directions','related' => 'Related Places','booking_title' => 'Book',
                'date_label' => 'Date:','btn_book' => 'BOOK NOW',
                'comment_title' => 'Comments','comment_placeholder' => 'Write...',
                'btn_comment' => 'Send','login_req' => 'Login required',
                'login_btn' => 'Login','subject' => 'Subject',
                'special_title' => 'Elephant Heritage'
            ]
        ];

        // --- BƯỚC 5: TRUYỀN DỮ LIỆU ---
        $data = [
            'place' => $place,
            'related' => $related,
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

    // ================== 3. DANH MỤC ==================

    public function category($cat_id) {
        $lang = $_SESSION['lang'] ?? 'vi';
        
        $places = $this->placeModel->getPlacesByCategory($cat_id, $lang);

        if ($cat_id == 2) {
            $pageTitle = ($lang == 'vi') ? 'Khách sạn & Lưu trú' : 
                         (($lang == 'lo') ? 'ໂຮງແຮມ' : 'Hotels');
        } elseif ($cat_id == 5) {
            $pageTitle = ($lang == 'vi') ? 'Các lễ hội đặc sắc' : 
                         (($lang == 'lo') ? 'ບຸນ' : 'Festivals');
        } else {
            $pageTitle = ($lang == 'vi') ? 'Địa danh du lịch' : 
                         (($lang == 'lo') ? 'ສະຖານທີ່' : 'Places');
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

    // ================== 4. ĐẶT CHỖ ==================

    public function book() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!isset($_SESSION['user_id'])) {
                header('Location: ' . URLROOT . '/user/login');
                exit();
            }

            $data = [
                'place_id' => $_POST['place_id'],
                'user_id' => $_SESSION['user_id'],
                'user_name' => $_POST['name'],
                'user_email' => $_SESSION['user_email'] ?? null,
                'phone' => $_POST['phone'],
                'booking_date' => (!empty($_POST['date'])) ? $_POST['date'] : ($_POST['checkin'] ?? date('Y-m-d')),
                'checkin' => !empty($_POST['checkin']) ? $_POST['checkin'] : null,
                'checkout' => !empty($_POST['checkout']) ? $_POST['checkout'] : null,
                'guests' => !empty($_POST['guests']) ? $_POST['guests'] : 1
            ];

            if ($this->placeModel->createBooking($data)) {
                header('Location: ' . URLROOT . '/place/view/' . $data['place_id'] . '?msg=booked');
                exit();
            } else {
                die('Lỗi SQL');
            }
        }
    }

    // ================== 5. DANH SÁCH TẤT CẢ ==================

    public function all() {
        $lang = $_SESSION['lang'] ?? 'vi';
        
        $places = $this->placeModel->getAllDestinationsOnly($lang);

        $data = [
            'places' => $places,
            'title' => 'All',
            'cat_id' => 'all'
        ];

        require_once '../app/views/inc/header.php';
        require_once '../app/views/places/category.php';
        require_once '../app/views/inc/footer.php';
    }

    // ================== 6. BÌNH LUẬN ==================

    public function add_review($place_id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {

            $author_name = $_SESSION['user_name'];
            $title = $_POST['title'] ?? 'Bình luận mới';
            $content = $_POST['comment'] ?? '';
            $rating = $_POST['rating'] ?? 5;

            $sql = "INSERT INTO forum_posts (author_name, title, content, status, created_at, place_id, rating) 
                    VALUES (?, ?, ?, 1, NOW(), ?, ?)";

            $stmt = $this->db->prepare($sql);

            if ($stmt->execute([$author_name, $title, $content, $place_id, $rating])) {
                header("Location: " . URLROOT . "/place/view/" . $place_id . "?msg=success");
                exit();
            } else {
                die("Lỗi");
            }

        } else {
            header('Location: ' . URLROOT . '/user/login');
            exit();
        }
    }
}