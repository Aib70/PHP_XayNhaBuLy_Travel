<?php
class AdminModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Lấy danh sách địa danh cho Admin (tối ưu JOIN)
    public function getAllPlacesForAdmin() {
        try {
            $sql = "SELECT 
                    p.id,
                    p.latitude,
                    p.longitude,
                    vi.name AS name_vi,
                    lo.name AS name_lo,
                    en.name AS name_en
                    FROM places p
                    LEFT JOIN place_translations vi 
                        ON vi.place_id = p.id AND vi.lang_code = 'vi'
                    LEFT JOIN place_translations lo 
                        ON lo.place_id = p.id AND lo.lang_code = 'lo'
                    LEFT JOIN place_translations en 
                        ON en.place_id = p.id AND en.lang_code = 'en'
                    ORDER BY p.id DESC";

            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            die("Lỗi lấy danh sách: " . $e->getMessage());
        }
    }

    public function addPlace($data) {
        try {
            $this->db->beginTransaction();

            $sql1 = "INSERT INTO places (category_id, latitude, longitude, image_main) 
                     VALUES (?, ?, ?, ?)";

            $stmt1 = $this->db->prepare($sql1);
            $stmt1->execute([
                $data['category_id'],
                $data['lat'],
                $data['lng'],
                $data['image']
            ]);

            $place_id = $this->db->lastInsertId();

            $sql2 = "INSERT INTO place_translations 
                    (place_id, lang_code, name, description, address) 
                    VALUES (?, ?, ?, ?, ?)";

            $stmt2 = $this->db->prepare($sql2);

            $langs = ['vi','lo','en'];

            foreach ($langs as $lang) {
                $stmt2->execute([
                    $place_id,
                    $lang,
                    $data['name_'.$lang],
                    $data['desc_'.$lang],
                    $data['addr_'.$lang]
                ]);
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            die("Lỗi Database khi thêm: " . $e->getMessage());
        }
    }

    public function deletePlace($id) {
        try {
            $sql = "DELETE FROM places WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            die("Lỗi khi xóa: " . $e->getMessage());
        }
    }

    public function getPlaceById($id) {
        try {

            $sql = "SELECT 
                    p.*,
                    vi.name AS name_vi, vi.description AS desc_vi, vi.address AS addr_vi,
                    lo.name AS name_lo, lo.description AS desc_lo, lo.address AS addr_lo,
                    en.name AS name_en, en.description AS desc_en, en.address AS addr_en

                    FROM places p

                    LEFT JOIN place_translations vi 
                    ON vi.place_id = p.id AND vi.lang_code='vi'

                    LEFT JOIN place_translations lo 
                    ON lo.place_id = p.id AND lo.lang_code='lo'

                    LEFT JOIN place_translations en 
                    ON en.place_id = p.id AND en.lang_code='en'

                    WHERE p.id = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            die("Lỗi lấy thông tin địa danh: " . $e->getMessage());
        }
    }

    public function updatePlace($id, $data) {

        try {

            $this->db->beginTransaction();

            $sql1 = "UPDATE places 
                     SET category_id=?, latitude=?, longitude=? 
                     WHERE id=?";

            $this->db->prepare($sql1)->execute([
                $data['category_id'],
                $data['lat'],
                $data['lng'],
                $id
            ]);

            $this->db->prepare("DELETE FROM place_translations WHERE place_id=?")
                     ->execute([$id]);

            $sql2 = "INSERT INTO place_translations 
                    (place_id, lang_code, name, description, address) 
                    VALUES (?, ?, ?, ?, ?)";

            $stmt2 = $this->db->prepare($sql2);

            $langs = ['vi','lo','en'];

            foreach ($langs as $lang) {

                $stmt2->execute([
                    $id,
                    $lang,
                    $data['name_'.$lang],
                    $data['desc_'.$lang],
                    $data['addr_'.$lang]
                ]);

            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {

            $this->db->rollBack();
            die("Lỗi khi cập nhật: " . $e->getMessage());

        }

    }

    public function getRelatedPlaces($current_id, $lang) {
    try {
        $sql = "SELECT p.id, p.image_main, pt.name 
                FROM places p 
                JOIN place_translations pt ON p.id = pt.place_id 
                WHERE pt.lang_code = :lang AND p.id != :current_id 
                ORDER BY RAND() LIMIT 3"; // Lấy ngẫu nhiên 3 địa danh khác
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['lang' => $lang, 'current_id' => $current_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
  }

  public function getAllBookings($lang = 'vi') {
    try {
        $sql = "SELECT b.*, pt.name as place_name 
                FROM bookings b
                JOIN place_translations pt ON b.place_id = pt.place_id
                WHERE pt.lang_code = :lang
                ORDER BY b.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['lang' => $lang]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
  }
}