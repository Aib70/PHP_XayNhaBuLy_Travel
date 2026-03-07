<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Nhúng file cấu hình hệ thống
require_once '../config/config.php';

// 2. Phân tích URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// 3. Xác định Controller
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';

// 4. Xác định Method
$methodName = isset($url[1]) ? $url[1] : 'index';

// 5. Xác định tham số
$params = array_slice($url, 2);

// 6. Đường dẫn file Controller
$controllerFile = "../app/controllers/" . $controllerName . ".php";

// 7. Kiểm tra và thực thi
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName($pdo);
    
    if (method_exists($controller, $methodName)) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        // THỬ LỖI 404: Nếu hàm không tồn tại
        require_once '../app/views/404.php';
    }
} else {
    // THỬ LỖI 404: Nếu Controller không tồn tại
    require_once '../app/views/404.php';
}