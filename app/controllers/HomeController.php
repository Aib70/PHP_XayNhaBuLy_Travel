<?php
class HomeController {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

   public function index() {
    $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';

    // Gọi Model để lấy danh sách địa danh
    require_once '../app/models/PlaceModel.php';
    $placeModel = new PlaceModel($this->db);
    $featuredPlaces = $placeModel->getPlacesHome($lang);

    // Truyền dữ liệu vào view thông qua biến $data
    $data = [
        'places' => $featuredPlaces
    ];

    require_once '../app/views/inc/header.php';
    require_once '../app/views/home/index.php';
}

    public function test($name = '') {
        echo "Chào bạn " . htmlspecialchars($name) . "!";
    }
}