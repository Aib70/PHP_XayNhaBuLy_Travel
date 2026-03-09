<?php
class UserModel {
    private $db;
    public function __construct($pdo) { $this->db = $pdo; }

    public function register($data) {
        try {
            // Kiểm tra email đã tồn tại chưa
            $check = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $check->execute([$data['email']]);
            if($check->rowCount() > 0) return "email_exists";

            // Mã hóa mật khẩu bảo mật
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (fullname, email, password) VALUES (:name, :email, :pass)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'name' => $data['fullname'],
                'email' => $data['email'],
                'pass' => $hashed_password
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserByEmail($email) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}