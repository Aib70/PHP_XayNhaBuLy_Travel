<?php
class PlaceController {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function view($id) {
        // 1. Lấy ngôn ngữ từ Session
        $current_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';

        // 2. Gọi Model lấy dữ liệu
        require_once '../app/models/PlaceModel.php';
        $model = new PlaceModel($this->db);
        $data = $model->getPlaceDetail($id, $current_lang);

        // 3. Hiển thị
        if ($data) {
            echo "<div style='font-family: Arial; padding: 20px; max-width: 800px; margin: auto;'>";
                echo "<h1>" . htmlspecialchars($data['name']) . "</h1>";
                echo "<p style='color: gray;'>Ngôn ngữ hiện tại: <strong>" . strtoupper($current_lang) . "</strong></p>";
                echo "<hr>";
                echo "<div style='font-size: 1.2em; line-height: 1.6;'>" . nl2br(htmlspecialchars($data['description'])) . "</div>";
                echo "<p><strong>📍 Địa chỉ:</strong> " . htmlspecialchars($data['address'] ?? 'Updating...') . "</p>";
                
                // PHẦN QUAN TRỌNG: Nút chuyển đổi 3 ngôn ngữ
                echo "<div style='margin-top: 30px; padding: 10px; background: #f4f4f4;'>";
                    echo "<strong>Chuyển đổi ngôn ngữ: </strong>";
                    echo "<a href='".URLROOT."/language/change/vi'>Tiếng Việt</a> | ";
                    echo "<a href='".URLROOT."/language/change/lo'>Tiếng Lào</a> | ";
                    echo "<a href='".URLROOT."/language/change/en'>English</a>";
                echo "</div>";
                
                echo "<br><a href='".URLROOT."/admin'>← Quay lại Admin</a>";
            echo "</div>";
        } else {
            echo "Dữ liệu không tồn tại cho ngôn ngữ này!";
        }
    }
}