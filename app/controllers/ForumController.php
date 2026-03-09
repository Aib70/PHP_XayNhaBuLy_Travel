<?php
class ForumController {
    private $db;
    public function __construct($pdo) { $this->db = $pdo; }

    public function index() {
        require_once '../app/models/ForumModel.php';
        $forumModel = new ForumModel($this->db);
        $data['posts'] = $forumModel->getPosts();
        $data['lang'] = $_SESSION['lang'] ?? 'vi';

        require_once '../app/views/inc/header.php';
        require_once '../app/views/forum/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once '../app/models/ForumModel.php';
            $forumModel = new ForumModel($this->db);
            $forumModel->createPost([
                'name' => $_POST['author_name'],
                'title' => $_POST['title'],
                'content' => $_POST['content']
            ]);
            header('Location: ' . URLROOT . '/forum?msg=success');
        }
    }
}