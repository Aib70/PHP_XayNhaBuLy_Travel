<?php
class UserModel {
    private $db;

    public function __construct($pdo) { 
        $this->db = $pdo; 
    }

    //ĐĂNG KÝ & ĐĂNG NHẬP

    public function register($data) {
        try {
            $check = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $check->execute([$data['email']]);
            if($check->rowCount() > 0) return "email_exists";

            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (fullname, email, phone, password, created_at) 
                    VALUES (:name, :email, :phone, :pass, NOW())";
            
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([
                'name'  => $data['fullname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'pass'  => $hashed_password
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

    //THÔNG TIN NGƯỜI DÙNG

    public function getUserById($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateProfile($data) {
        $sql = "UPDATE users SET fullname = :name, phone = :phone WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name'  => $data['fullname'],
            'phone' => $data['phone'],
            'id'    => $data['id']
        ]);
    }

    public function updateProfileFull($data) {

        if ($data['password'] !== null) {
            $sql = "UPDATE users SET fullname = :name, phone = :phone, email = :email, password = :pass WHERE id = :id";
            $params = [
                'name'  => $data['fullname'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'pass'  => $data['password'],
                'id'    => $data['id']
            ];
        } else {
            $sql = "UPDATE users SET fullname = :name, phone = :phone, email = :email WHERE id = :id";
            $params = [
                'name'  => $data['fullname'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'id'    => $data['id']
            ];
        }

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    //BÌNH LUẬN

    public function getReviewsByUserId($userId) {
        $sql = "SELECT f.*, p.name_vi, p.name_en, p.name_lo 
                FROM forum_posts f
                JOIN places p ON f.place_id = p.id
                WHERE f.author_name = (SELECT fullname FROM users WHERE id = ?)
                ORDER BY f.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ĐẶT CHỖ

    public function getBookingsByType($userId, $type) {
        $lang = $_SESSION['lang'] ?? 'vi';
        $condition = ($type === 'NOT 2') ? "p.category_id != 2" : "p.category_id = 2";

        $sql = "SELECT b.*, pt.name as place_name 
                FROM bookings b 
                JOIN places p ON b.place_id = p.id 
                LEFT JOIN place_translations pt ON p.id = pt.place_id AND pt.lang_code = :lang
                WHERE b.user_id = :user_id 
                AND $condition 
                ORDER BY b.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'lang'    => $lang
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingById($id) {
        $stmt = $this->db->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteBooking($id) {
        $stmt = $this->db->prepare("DELETE FROM bookings WHERE id = ?");
        return $stmt->execute([$id]);
    }

}