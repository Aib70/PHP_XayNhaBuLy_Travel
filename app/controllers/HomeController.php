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

   public function ai_chat_api() {
    header('Content-Type: application/json');
    try {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $userMessage = $data->message ?? '';

        if (empty($userMessage)) {
            echo json_encode(['reply' => 'กรุณาพิมพ์ข้อความ...']);
            exit();
        }

        // 1. ใส่ API Key ของคุณที่นี่
        $apiKey = "AIzaSyCyfq6df6oFwkLtnbes3q8xa-M1Iq6R-nM"; 
        
        // 2. ปรับ URL เป็น v1beta และใช้ชื่อโมเดลแบบเต็ม
        // โครงสร้างที่ถูกต้อง: .../v1beta/models/gemini-1.5-flash:generateContent?key=...
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . $apiKey;

        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => "Bạn là nhân viên thông tin du lịch của tỉnh Xayaburi. Vui lòng trả lời ngắn gọn và thân thiện: " . $userMessage]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 1,
                "maxOutputTokens" => 800
            ]
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        // ข้ามการตรวจ SSL สำหรับ localhost (XAMPP)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            echo json_encode(['reply' => 'CURL Error: ' . $err]);
            exit();
        }

        $result = json_decode($response, true);

        if ($httpCode === 200 && isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $aiReply = $result['candidates'][0]['content']['parts'][0]['text'];
            echo json_encode(['reply' => $aiReply]);
        } else {
            // ดึงข้อความแจ้งเตือนจริงจาก Google มาแสดง
            $errorDetail = $result['error']['message'] ?? 'ลองตรวจสอบสถานะ API Key หรือรุ่นของโมเดลอีกครั้ง';
            echo json_encode(['reply' => "ระบบแจ้งว่า ({$httpCode}): " . $errorDetail]);
        }
    } catch (Exception $e) {
        echo json_encode(['reply' => 'Error: ' . $e->getMessage()]);
    }
    exit();
}
}