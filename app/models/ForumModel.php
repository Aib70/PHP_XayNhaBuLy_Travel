<?php
class ForumModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // 1. LẤY DỮ LIỆU (GET)

    // Lấy tất cả bài viết (Admin duyệt)
    public function getPosts() {
        $stmt = $this->db->query(
            "SELECT * FROM forum_posts ORDER BY created_at DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy bình luận theo từng địa danh
    public function getCommentsByPlace($place_id) {
        $sql = "SELECT * FROM forum_posts 
                WHERE place_id = ? 
                ORDER BY created_at DESC";
            
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$place_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
 
    // 2. THÊM (CREATE)

    public function createPost($data) {
        $sql = "INSERT INTO forum_posts 
                (place_id, author_name, title, content, created_at) 
                VALUES (?, ?, ?, ?, NOW())";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $data['place_id'],
            $data['author_name'],
            $data['title'],
            $data['content']
        ]);
    }

    // 3. XÓA (DELETE)

    public function deletePost($id) {
        $sql = "DELETE FROM forum_posts WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }
}