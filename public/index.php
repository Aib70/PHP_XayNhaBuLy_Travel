
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/**
 * TRÁI TIM CỦA HỆ THỐNG (ROUTER) - XAYABURY TRAVEL
 */

// 1. Nhúng file cấu hình hệ thống (Đã bao gồm kết nối Database PDO và session_start)
require_once '../config/config.php';

// 2. Phân tích URL từ thanh địa chỉ
// Ví dụ: localhost/xayabury_travel/place/view/1 -> url[0]=place, url[1]=view, url[2]=1
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// 3. Xác định Controller (Mặc định là HomeController)
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';

// 4. Xác định Method (Mặc định là index)
$methodName = isset($url[1]) ? $url[1] : 'index';

// 5. Xác định tham số truyền vào (Params)
$params = array_slice($url, 2);

// 6. Đường dẫn đến file Controller
$controllerFile = "../app/controllers/" . $controllerName . ".php";

// 7. Kiểm tra và thực thi
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Khởi tạo Controller và truyền biến $pdo để tương tác Database
    $controller = new $controllerName($pdo);
    
    // Kiểm tra xem hàm (Method) có tồn tại trong Controller không
    if (method_exists($controller, $methodName)) {
        // Gọi hàm và truyền các tham số vào
        call_user_func_array([$controller, $methodName], $params);
    } else {
        die("Lỗi: Hàm <strong>$methodName</strong> không tồn tại trong <strong>$controllerName</strong>.");
    }
} else {
    die("Lỗi: Trang <strong>$controllerName</strong> không tồn tại (Không tìm thấy $controllerName).");
}