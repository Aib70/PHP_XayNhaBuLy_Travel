<?php
class AdminController {

   private $db;

    public function __construct($pdo) {
    $this->db = $pdo;

    // Khởi động session nếu chưa có
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Chốt chặn: Nếu không có admin_id HOẶC vai trò không phải admin thì đá ra ngoài
    if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: ' . URLROOT . '/home');
        exit();
    }
}

    public function index() {

        require_once '../app/models/AdminModel.php';

        $adminModel = new AdminModel($this->db);

        $places = $adminModel->getAllPlacesForAdmin();

        $data = [
            'places'=>$places
        ];

        require_once '../app/views/admin/index.php';
    }

    public function add() {

        require_once '../app/views/admin/add.php';

    }

    public function store() {

        if($_SERVER['REQUEST_METHOD']=='POST'){

            $image_name='default.jpg';

            if(isset($_FILES['image_main']) && $_FILES['image_main']['error']==0){

                $ext=strtolower(pathinfo($_FILES['image_main']['name'],PATHINFO_EXTENSION));

                $image_name=time().'_'.uniqid().'.'.$ext;

                $target_dir="../public/img/places/";

                if(!is_dir($target_dir)){
                    mkdir($target_dir,0777,true);
                }

                move_uploaded_file($_FILES['image_main']['tmp_name'],$target_dir.$image_name);
            }

            $data=[

                'category_id'=>$_POST['category_id'],

                'lat'=>$_POST['lat'],
                'lng'=>$_POST['lng'],

                'image'=>$image_name,

                'name_vi'=>$_POST['name_vi'],
                'desc_vi'=>$_POST['desc_vi'],
                'addr_vi'=>$_POST['addr_vi'],

                'name_lo'=>$_POST['name_lo'],
                'desc_lo'=>$_POST['desc_lo'],
                'addr_lo'=>$_POST['addr_lo'],

                'name_en'=>$_POST['name_en'],
                'desc_en'=>$_POST['desc_en'],
                'addr_en'=>$_POST['addr_en']

            ];

            require_once '../app/models/AdminModel.php';

            $adminModel=new AdminModel($this->db);

            if($adminModel->addPlace($data)){

                header("Location: ".URLROOT."/admin");
                exit();

            }

        }

    }

    public function edit($id){

        require_once '../app/models/AdminModel.php';

        $adminModel=new AdminModel($this->db);

        $place=$adminModel->getPlaceById($id);

        if(!$place){

            die("Không tìm thấy địa danh!");

        }

        $data=['place'=>$place];

        require_once '../app/views/admin/edit.php';

    }

    public function update($id){

        if($_SERVER['REQUEST_METHOD']=='POST'){

            require_once '../app/models/AdminModel.php';

            $adminModel=new AdminModel($this->db);

            $image_name=$_POST['current_image'] ?? 'default.jpg';

            $data=[

                'category_id'=>$_POST['category_id'],

                'lat'=>$_POST['lat'],
                'lng'=>$_POST['lng'],

                'image'=>$image_name,

                'name_vi'=>$_POST['name_vi'],
                'desc_vi'=>$_POST['desc_vi'],
                'addr_vi'=>$_POST['addr_vi'],

                'name_lo'=>$_POST['name_lo'],
                'desc_lo'=>$_POST['desc_lo'],
                'addr_lo'=>$_POST['addr_lo'],

                'name_en'=>$_POST['name_en'],
                'desc_en'=>$_POST['desc_en'],
                'addr_en'=>$_POST['addr_en']

            ];

            if($adminModel->updatePlace($id,$data)){

                header("Location: ".URLROOT."/admin");
                exit();

            }

        }

    }

    public function delete($id){

        require_once '../app/models/AdminModel.php';

        $adminModel=new AdminModel($this->db);

        if($adminModel->deletePlace($id)){

            header("Location: ".URLROOT."/admin");
            exit();

        }else{

            die("Không thể xóa địa danh");

        }

    }

    public function bookings() {
    // Kiểm tra đăng nhập (đã cài ở __construct)
    require_once '../app/models/AdminModel.php';
    $adminModel = new AdminModel($this->db);
    
    $lang = $_SESSION['lang'] ?? 'vi';
    $bookings = $adminModel->getAllBookings($lang);

    $data = [
        'bookings' => $bookings
    ];

    require_once '../app/views/admin/bookings.php';
 }

 public function forum() {
    $stmt = $this->db->query("SELECT * FROM forum_posts ORDER BY status ASC, created_at DESC");
    $data['posts'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    require_once '../app/views/admin/forum.php';
}

public function approve_post($id) {
    $stmt = $this->db->prepare("UPDATE forum_posts SET status = 1 WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: ' . URLROOT . '/admin/forum');
  }
 
 }