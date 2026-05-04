<?php
class LanguageController {

    // ================== 1. KHỞI TẠO ==================
    public function __construct() {}

    // ================== 2. CHUYỂN ĐỔI NGÔN NGỮ ==================

    // Thay đổi ngôn ngữ hiển thị
    public function change($lang = 'vi') {

        // Danh sách ngôn ngữ cho phép
        $allowed_langs = ['vi', 'lo', 'en'];
        
        // Kiểm tra hợp lệ rồi lưu vào session
        if (in_array($lang, $allowed_langs)) {
            $_SESSION['lang'] = $lang;
        }

        // Quay lại trang trước đó
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : URLROOT;
        header('Location: ' . $referer);
        exit();
    }
}