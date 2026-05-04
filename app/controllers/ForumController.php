<?php
class ForumController {
    private $db;

    // ================== 1. KHỞI TẠO ==================
    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // ================== 2. THÊM BÌNH LUẬN ==================

    // Gửi bình luận mới
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            require_once '../app/models/ForumModel.php';
            $forumModel = new ForumModel($this->db);

            $data = [
                'place_id' => $_POST['place_id'],
                'author_name' => $_POST['author_name'],
                'title' => $_POST['title'],
                'content' => $_POST['content']
            ];

            if ($forumModel->createPost($data)) {

                // quay lại trang địa điểm sau khi gửi bình luận
                header("Location: " . URLROOT . "/place/view/" . $_POST['place_id'] . "?msg=success");
                exit();

            } else {
                die("Lỗi: Không thể gửi bình luận.");
            }
        }
    }

    // ================== 3. XÓA BÌNH LUẬN ==================

    // Xóa bình luận (có kiểm tra quyền admin)
    public function delete($id, $place_id = 0) {

        // Kiểm tra quyền Admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . URLROOT . '/home');
            exit();
        }

        require_once '../app/models/ForumModel.php';
        $forumModel = new ForumModel($this->db);

        // Thực hiện xóa
        if ($forumModel->deletePost($id)) {

            // Điều hướng sau khi xóa
            if ($place_id > 0) {
                header('Location: ' . URLROOT . '/place/view/' . $place_id . '?msg=deleted');
            } else {
                header('Location: ' . URLROOT . '/admin/forum?msg=deleted');
            }
            exit();

        } else {
            die("Lỗi: Không thể xóa bình luận.");
        }
    }
}