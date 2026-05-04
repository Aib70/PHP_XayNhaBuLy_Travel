<?php
class HomeController {
    private $db;

    // ================== 1. KHỞI TẠO ==================
    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // ================== 2. TRANG CHỦ ==================

    // Hiển thị trang chủ + tìm kiếm
    public function index() {
        $lang = $_SESSION['lang'] ?? 'vi';
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

        require_once '../app/models/PlaceModel.php';
        $placeModel = new PlaceModel($this->db);

        $sql_p = "SELECT p.*, pt.name, pt.description 
                  FROM places p 
                  LEFT JOIN place_translations pt ON p.id = pt.place_id AND pt.lang_code = ?
                  WHERE 1=1";

        if (!empty($keyword)) {
            $sql_p .= " AND (pt.name LIKE ? OR pt.description LIKE ?)";
        } else {
            $sql_p .= " AND p.is_special = 1 AND p.category_id != 2";
        }

        $sql_p .= " ORDER BY p.id DESC";
        $stmt_p = $this->db->prepare($sql_p);

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

    // Test đơn giản
    public function test($name = '') {
        echo "Chào bạn " . htmlspecialchars($name) . "!";
    }

    // ================== 3. TRANG TĨNH ==================

    // Trang giới thiệu
    public function about() {
        require_once '../app/views/home/about.php';
    }

    // Trang liên hệ
    public function contact() {
        require_once '../app/views/home/contact.php';
    }

    // ================== 4. AI CHAT ==================

    // API chat AI
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

            $apiKey = "AIzaSyDr2SkxAV92tnh4az9P6doYV-Ws7ffSLSE"; 
            $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=". $apiKey;

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
                $errorDetail = $result['error']['message'] ?? 'ลองตรวจสอบสถานะ API Key หรือรุ่นของโมเดลอีกครั้ง';
                echo json_encode(['reply' => "ระบบแจ้งว่า ({$httpCode}): " . $errorDetail]);
            }
        } catch (Exception $e) {
            echo json_encode(['reply' => 'Error: ' . $e->getMessage()]);
        }
        exit();
    }

    // ================== 5. DỊCH NGÔN NGỮ ==================

    // Dịch text
    public function translate_text($text, $target_lang) {
        $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=" . $target_lang . "&dt=t&q=" . urlencode($text);
        
        $res = file_get_contents($url);
        $res = json_decode($res);
        
        return $res[0][0][0] ?? $text;
    }

    // ================== 6. LIÊN HỆ ==================

    // Gửi form liên hệ
    public function send_contact() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name = htmlspecialchars($_POST['name'] ?? '');
            $contact = htmlspecialchars($_POST['contact'] ?? '');
            $message = htmlspecialchars($_POST['message'] ?? '');

            try {
                $sql = "INSERT INTO contacts (name, contact_info, message) VALUES (?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                
                if ($stmt->execute([$name, $contact, $message])) {
                    header('Location: ' . URLROOT . '/home/contact?msg=sent');
                    exit();
                } else {
                    die("Lỗi: Không thể lưu tin nhắn.");
                }
            } catch (Exception $e) {
                die("Lỗi Database: " . $e->getMessage());
            }

        } else {
            header('Location: ' . URLROOT . '/home/index');
        }
    }
}