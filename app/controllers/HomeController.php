<?php
class HomeController {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

  public function index() {
    $lang = $_SESSION['lang'] ?? 'vi';
    require_once '../app/models/PlaceModel.php';
    $placeModel = new PlaceModel($this->db);

    // Lấy Địa danh đặc sắc (Không bao gồm category 2)
    $sql_p = "SELECT p.*, pt.name FROM places p JOIN place_translations pt ON p.id = pt.place_id 
              WHERE pt.lang_code = ? AND p.is_special = 1 AND p.category_id != 2";
    $stmt_p = $this->db->prepare($sql_p);
    $stmt_p->execute([$lang]);
    $specialPlaces = $stmt_p->fetchAll(PDO::FETCH_ASSOC);

    // Lấy Khách sạn đặc sắc (Chỉ category 2)
    $sql_h = "SELECT p.*, pt.name FROM places p JOIN place_translations pt ON p.id = pt.place_id 
              WHERE pt.lang_code = ? AND p.is_special = 1 AND p.category_id = 2";
    $stmt_h = $this->db->prepare($sql_h);
    $stmt_h->execute([$lang]);
    $specialHotels = $stmt_h->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        'special_places' => $specialPlaces,
        'special_hotels' => $specialHotels,
        'lang' => $lang
    ];

    require_once '../app/views/home/index.php';
}

    public function test($name = '') {
        echo "Chào bạn " . htmlspecialchars($name) . "!";
    }
}