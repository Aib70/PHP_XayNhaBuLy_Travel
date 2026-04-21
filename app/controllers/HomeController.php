<?php
class HomeController {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

  public function index() {
    $lang = $_SESSION['lang'] ?? 'vi';
    $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

    require_once '../app/models/PlaceModel.php';
    $placeModel = new PlaceModel($this->db);

    // 1. Khởi tạo câu SQL cơ bản
    $sql_p = "SELECT p.*, pt.name, pt.description 
              FROM places p 
              LEFT JOIN place_translations pt ON p.id = pt.place_id AND pt.lang_code = ?
              WHERE 1=1"; // Mẹo 1=1 để dễ dàng nối thêm điều kiện AND phía sau

    // 2. Xử lý Logic tìm kiếm
    if (!empty($keyword)) {
        // KHI CÓ TÌM KIẾM: Tìm trên toàn bộ hệ thống (bỏ qua is_special)
        $sql_p .= " AND (pt.name LIKE ? OR pt.description LIKE ?)";
    } else {
        // KHI KHÔNG TÌM KIẾM: Chỉ hiện những cái được đánh dấu đặc sắc
        $sql_p .= " AND p.is_special = 1 AND p.category_id != 2";
    }

    $sql_p .= " ORDER BY p.id DESC";
    $stmt_p = $this->db->prepare($sql_p);

    // 3. Thực thi SQL với tham số tương ứng
    if (!empty($keyword)) {
        $searchQuery = "%$keyword%";
        $stmt_p->execute([$lang, $searchQuery, $searchQuery]);
    } else {
        $stmt_p->execute([$lang]);
    }

    $specialPlaces = $stmt_p->fetchAll(PDO::FETCH_ASSOC);

    $data = [
        'special_places' => $specialPlaces,
        'lang'           => $lang,
        'keyword'        => $keyword
    ];

    require_once '../app/views/home/index.php';
}

    public function test($name = '') {
        echo "Chào bạn " . htmlspecialchars($name) . "!";
    }

    // --- TRANG VỀ CHÚNG TÔI ---
    public function about() {
        // Đã sửa lại để gọi đúng file view
        require_once '../app/views/home/about.php';
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
        $apiKey = "AIzaSyDBUT3RzhDiVYwEmf2_oskpFd--uOCbFaM"; 
        
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

public function translate_text($text, $target_lang) {
    // Đây là URL API miễn phí (không chính thức nhưng vẫn hoạt động tốt cho việc học tập)
    $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=" . $target_lang . "&dt=t&q=" . urlencode($text);
    
    $res = file_get_contents($url);
    $res = json_decode($res);
    
    return $res[0][0][0] ?? $text;
}

public function contact() {
   
     require_once '../app/views/home/contact.php';
}

}