<?php
class PlaceModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getPlaceDetail($id, $lang) {
        $sql = "SELECT p.*, pt.name, pt.description, pt.address 
                FROM places p 
                JOIN place_translations pt ON p.id = pt.place_id 
                WHERE p.id = :id AND pt.lang_code = :lang";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'lang' => $lang
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPlacesHome($lang) {
        $sql = "SELECT p.id, p.image_main, pt.name, pt.description 
                FROM places p 
                JOIN place_translations pt ON p.id = pt.place_id 
                WHERE pt.lang_code = :lang 
                ORDER BY p.id DESC 
                LIMIT 6";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['lang' => $lang]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔎 Hàm tìm kiếm
    public function searchPlaces($keyword, $lang) {
    try {
        $sql = "SELECT p.id, p.image_main, pt.name, pt.description 
                FROM places p 
                JOIN place_translations pt ON p.id = pt.place_id 
                WHERE pt.lang_code = :lang 
                AND (pt.name LIKE :key1 OR pt.description LIKE :key2)
                ORDER BY p.id DESC";
        
        $stmt = $this->db->prepare($sql);
        
        $searchQuery = '%' . $keyword . '%';
        
        // Bạn cần truyền đủ 3 tham số cho 3 vị trí :lang, :key1, :key2
        $stmt->execute([
            'lang' => $lang,
            'key1' => $searchQuery,
            'key2' => $searchQuery
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
  }

  public function createBooking($data) {
    // Sửa fullname -> user_name | email -> user_email để khớp với ảnh Workbench
    $sql = "INSERT INTO bookings (place_id, user_name, user_email, phone, booking_date, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    
    $stmt = $this->db->prepare($sql);
    
    return $stmt->execute([
        $data['place_id'],
        $data['name'],     // Dữ liệu từ Controller
        $data['email'],    // Dữ liệu từ Controller
        $data['phone'],    // Dữ liệu từ Controller
        $data['date']      // Dữ liệu từ Controller
    ]);
  }

  public function getPlacesByCategory($cat_id, $lang) {
    try {
        // Câu lệnh SQL này sẽ chỉ lấy những địa danh có category_id khớp với số truyền vào (ví dụ là 5)
        $sql = "SELECT p.id, p.image_main, pt.name, pt.description 
                FROM places p 
                JOIN place_translations pt ON p.id = pt.place_id 
                WHERE p.category_id = :cat_id 
                AND pt.lang_code = :lang 
                ORDER BY p.id DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'cat_id' => $cat_id, // Lúc này cat_id sẽ nhận giá trị là 5 từ Controller
            'lang' => $lang
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
  }

  // 1. Hàm lấy TẤT CẢ địa danh trong hệ thống
public function getAllPlacesWithLang($lang) {
    try {
        $sql = "SELECT p.*, pt.name, pt.description 
                FROM places p 
                JOIN place_translations pt ON p.id = pt.place_id 
                WHERE pt.lang_code = :lang 
                ORDER BY p.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['lang' => $lang]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// 2. Hàm chỉ lấy những địa danh được đánh dấu ĐẶC SẮC (is_special = 1)
public function getSpecialPlaces($lang) {
    try {
        // SQL lấy những bài có is_special = 1
        $sql = "SELECT p.id, p.image_main, pt.name, pt.description 
                FROM places p 
                JOIN place_translations pt ON p.id = pt.place_id 
                WHERE pt.lang_code = :lang 
                AND p.is_special = 1 
                ORDER BY p.id DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['lang' => $lang]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Thêm hàm này vào file PlaceModel.php
public function getAllDestinationsOnly($lang) {
    try {
        $sql = "SELECT p.id, p.image_main, pt.name, pt.description 
                FROM places p 
                JOIN place_translations pt ON p.id = pt.place_id 
                WHERE pt.lang_code = :lang 
                AND p.category_id != 2 
                ORDER BY p.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['lang' => $lang]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

}