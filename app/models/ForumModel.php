<?php
class ForumModel {
    private $db;
    public function __construct($pdo) { $this->db = $pdo; }

    // Lấy tất cả bài viết đã duyệt
    public function getPosts() {
        $stmt = $this->db->query("SELECT * FROM forum_posts WHERE status = 1 ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Gửi bài viết mới
    public function createPost($data) {
        $sql = "INSERT INTO forum_posts (author_name, title, content, status) VALUES (:name, :title, :content, 0)"; // Mặc định status = 0 (chờ duyệt)
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
}