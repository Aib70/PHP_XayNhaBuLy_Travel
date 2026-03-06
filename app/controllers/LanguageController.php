<?php
class LanguageController {
    public function __construct() {}

    public function change($lang = 'vi') {
        // Cập nhật danh sách cho phép có thêm 'en'
        $allowed_langs = ['vi', 'lo', 'en'];
        
        if (in_array($lang, $allowed_langs)) {
            $_SESSION['lang'] = $lang;
        }

        // Quay lại trang trước đó
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : URLROOT;
        header('Location: ' . $referer);
        exit();
    }
}