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
    try {
        $sql = "INSERT INTO bookings (place_id, user_name, user_email, booking_date, status) 
                VALUES (:place_id, :name, :email, :date, 'pending')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'place_id'   => $data['place_id'],
            'name'       => $data['name'],
            'email'      => $data['email'],
            'date'       => $data['date']
        ]);
    } catch (PDOException $e) {
        return false;
    }
 }
}