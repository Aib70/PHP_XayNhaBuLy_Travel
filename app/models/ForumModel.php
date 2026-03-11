<?php
class ForumModel {
    private $db;
    public function __construct($pdo) { $this->db = $pdo; }

    public function getPosts() {
        // Lấy tất cả bài viết để Admin duyệt (không lọc status = 1)
        $stmt = $this->db->query("SELECT * FROM forum_posts ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createPost($data) {
        $sql = "INSERT INTO forum_posts (place_id, author_name, title, content, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['place_id'],
            $data['author_name'],
            $data['title'],
            $data['content']
        ]);
    }

    public function deletePost($id) {
        $sql = "DELETE FROM forum_posts WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Hàm lấy bình luận theo từng địa danh cụ thể
public function getCommentsByPlace($place_id) {
    // Chỉ lấy những bình luận có place_id tương ứng
    $sql = "SELECT * FROM forum_posts 
            WHERE place_id = ? 
            ORDER BY created_at DESC";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$place_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}