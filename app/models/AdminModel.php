<?php
class AdminModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Lấy danh sách địa danh
    public function getAllPlacesForAdmin() {
        try {
            $sql = "SELECT 
                    p.id,
                    p.latitude,
                    p.longitude,
                    p.image_main,
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

    // 4. Hàm Thêm mới
    public function addPlace($data) {
        try {
            $this->db->beginTransaction();
            $sql1 = "INSERT INTO places (category_id, latitude, longitude, image_main, is_special) VALUES (?, ?, ?, ?, ?)";
            $stmt1 = $this->db->prepare($sql1);
            $stmt1->execute([
                $data['category_id'], $data['lat'], $data['lng'], $data['image'], $data['is_special']
            ]);

            $place_id = $this->db->lastInsertId();
            $sql2 = "INSERT INTO place_translations (place_id, lang_code, name, description, address) VALUES (?, ?, ?, ?, ?)";
            $stmt2 = $this->db->prepare($sql2);
            $langs = ['vi','lo','en'];
            foreach ($langs as $lang) {
                $stmt2->execute([$place_id, $lang, $data['name_'.$lang], $data['desc_'.$lang], $data['addr_'.$lang]]);
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // 5. Hàm Xóa
    public function deletePlace($id) {
        $this->db->prepare("DELETE FROM place_translations WHERE place_id=?")->execute([$id]);
        return $this->db->prepare("DELETE FROM places WHERE id=?")->execute([$id]);
    }

    // 3. Lấy chi tiết một địa danh theo ID (Dùng để Sửa)
    public function getPlaceById($id) {
        $sql = "SELECT p.*, 
                vi.name AS name_vi, vi.description AS desc_vi, vi.address AS addr_vi,
                lo.name AS name_lo, lo.description AS desc_lo, lo.address AS addr_lo,
                en.name AS name_en, en.description AS desc_en, en.address AS addr_en
                FROM places p
                LEFT JOIN place_translations vi ON vi.place_id = p.id AND vi.lang_code='vi'
                LEFT JOIN place_translations lo ON lo.place_id = p.id AND lo.lang_code='lo'
                LEFT JOIN place_translations en ON en.place_id = p.id AND en.lang_code='en'
                WHERE p.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 6. Cập nhật bài viết
    public function updatePlace($id, $data) {
        try {
            $this->db->beginTransaction();
            $sql = "UPDATE places SET category_id=?, latitude=?, longitude=?, image_main=?, is_special=? WHERE id=?";
            $this->db->prepare($sql)->execute([$data['category_id'], $data['lat'], $data['lng'], $data['image'], $data['is_special'], $id]);
            
            $this->db->prepare("DELETE FROM place_translations WHERE place_id=?")->execute([$id]);
            $stmt2 = $this->db->prepare("INSERT INTO place_translations (place_id, lang_code, name, description, address) VALUES (?, ?, ?, ?, ?)");
            foreach (['vi','lo','en'] as $lang) {
                $stmt2->execute([$id, $lang, $data['name_'.$lang], $data['desc_'.$lang], $data['addr_'.$lang]]);
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // Lấy địa danh liên quan
    public function getRelatedPlaces($current_id, $lang) {

        try {

            $sql = "SELECT p.id, p.image_main, pt.name
                    FROM places p
                    JOIN place_translations pt ON p.id = pt.place_id
                    WHERE pt.lang_code = :lang 
                    AND p.id != :current_id
                    ORDER BY RAND()
                    LIMIT 3";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                'lang' => $lang,
                'current_id' => $current_id
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy địa danh theo danh mục
    public function getPlacesByCategory($cat_id, $lang) {

        try {

            $sql = "SELECT 
                    p.id,
                    p.image_main,
                    pt.name,
                    pt.description,
                    pt.address
                    FROM places p
                    JOIN place_translations pt ON p.id = pt.place_id
                    WHERE p.category_id = :cat_id
                    AND pt.lang_code = :lang
                    ORDER BY p.id DESC";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                'cat_id' => $cat_id,
                'lang' => $lang
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {

            error_log("Lỗi lấy địa danh: ".$e->getMessage());
            return [];

        }
    }

// Hàm 1: Lấy tất cả trừ Khách sạn
public function getAllPlacesExceptHotels() {
        try {
            $sql = "SELECT p.*, vi.name AS name_vi, lo.name AS name_lo, en.name AS name_en
                    FROM places p
                    LEFT JOIN place_translations vi ON vi.place_id = p.id AND vi.lang_code = 'vi'
                    LEFT JOIN place_translations lo ON lo.place_id = p.id AND lo.lang_code = 'lo'
                    LEFT JOIN place_translations en ON en.place_id = p.id AND en.lang_code = 'en'
                    WHERE p.category_id != 2
                    ORDER BY p.id DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die("Lỗi lấy danh sách địa danh: " . $e->getMessage());
        }
    }

    // 2. Chỉ lấy Khách sạn (Dùng cho trang Quản lý khách sạn)
    public function getOnlyHotels() {
        try {
            $sql = "SELECT p.*, vi.name AS name_vi, lo.name AS name_lo, en.name AS name_en
                    FROM places p
                    LEFT JOIN place_translations vi ON vi.place_id = p.id AND vi.lang_code = 'vi'
                    LEFT JOIN place_translations lo ON lo.place_id = p.id AND lo.lang_code = 'lo'
                    LEFT JOIN place_translations en ON en.place_id = p.id AND en.lang_code = 'en'
                    WHERE p.category_id = 2
                    ORDER BY p.id DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die("Lỗi lấy danh sách khách sạn: " . $e->getMessage());
        }
    }

// Hàm 2: Chỉ lấy Khách sạn
public function getPlacesByCategoryForAdmin($cat_id) {
    $sql = "SELECT p.*, pt.name as name_vi 
            FROM places p 
            LEFT JOIN place_translations pt ON p.id = pt.place_id AND pt.lang_code = 'vi'
            WHERE p.category_id = ? 
            ORDER BY p.id DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$cat_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Thêm hàm này vào file AdminModel.php
public function getRelatedHotels($current_id, $lang) {
    try {
        // Lọc thêm điều kiện category_id = 2
        $sql = "SELECT p.id, p.image_main, pt.name
                FROM places p
                JOIN place_translations pt ON p.id = pt.place_id
                WHERE pt.lang_code = :lang 
                AND p.category_id = 2
                AND p.id != :current_id
                ORDER BY RAND()
                LIMIT 3";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'lang' => $lang,
            'current_id' => $current_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}

}