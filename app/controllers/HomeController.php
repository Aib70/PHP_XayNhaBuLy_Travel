<?php
class HomeController {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

  public function index() {
    $lang = $_SESSION['lang'] ?? 'vi';
    $keyword = $_GET['search'] ?? ''; // Lấy từ khóa từ thanh địa chỉ

    require_once '../app/models/PlaceModel.php';
    $placeModel = new PlaceModel($this->db);

    if (!empty($keyword)) {
        // Nếu có từ khóa, thực hiện tìm kiếm
        $places = $placeModel->searchPlaces($keyword, $lang);
    } else {
        // Nếu không, hiện danh sách mặc định
        $places = $placeModel->getPlacesHome($lang);
    }

    $data = [
        'places' => $places,
        'keyword' => $keyword
    ];

    require_once '../app/views/inc/header.php';
    require_once '../app/views/home/index.php';
}

    public function test($name = '') {
        echo "Chào bạn " . htmlspecialchars($name) . "!";
    }
}