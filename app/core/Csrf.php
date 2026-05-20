<?php

final class Csrf
{
    private const SESSION_KEY = 'csrf_token';
    private const FIELD = '_csrf_token';

    public static function token(): string
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::SESSION_KEY];
    }

    public static function field(): string
    {
        return '<input type="hidden" name="' . self::FIELD . '" value="' . htmlspecialchars(self::token(), ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function validateRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            self::deny();
        }

        $submitted = $_POST[self::FIELD] ?? '';
        $expected = $_SESSION[self::SESSION_KEY] ?? '';

        if (!is_string($submitted) || !is_string($expected) || $expected === '' || !hash_equals($expected, $submitted)) {
            self::deny();
        }
    }

    private static function deny(): void
    {
        http_response_code(419);
        die('CSRF token không hợp lệ hoặc request không được phép.');
    }
}
