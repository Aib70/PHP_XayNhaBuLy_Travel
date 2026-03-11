<?php
class UserModel {
    private $db;
    public function __construct($pdo) { $this->db = $pdo; }

    public function register($data) {
        try {
            // 1. Kiểm tra email đã tồn tại chưa
            $check = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $check->execute([$data['email']]);
            if($check->rowCount() > 0) return "email_exists";

            // 2. Mã hóa mật khẩu bảo mật
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

            // 3. Cập nhật câu lệnh SQL: Thêm cột 'phone'
            $sql = "INSERT INTO users (fullname, email, phone, password, created_at) 
                    VALUES (:name, :email, :phone, :pass, NOW())";
            
            $stmt = $this->db->prepare($sql);
            
            // 4. Thực thi và truyền thêm dữ liệu 'phone' từ Form
            return $stmt->execute([
                'name'  => $data['fullname'],
                'email' => $data['email'],
                'phone' => $data['phone'], // Dòng mới thêm
                'pass'  => $hashed_password
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserByEmail($email) {
        // Hàm này sẽ lấy toàn bộ thông tin bao gồm cả Phone để dùng khi đặt chỗ
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}