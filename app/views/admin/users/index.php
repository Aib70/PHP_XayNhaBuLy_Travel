<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Người dùng - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* TỔNG THỂ */
        body { margin: 0; font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f8fafc; color: #333; }
        .container { padding: 40px; max-width: 1300px; margin: auto; }

        /* --- 1. CẬP NHẬT NAVIGATION BAR (TRÊN CÙNG) --- */
        .admin-nav {
            background: #1e293b; color: white; padding: 15px 35px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .admin-nav a { color: #cbd5e1; text-decoration: none; margin-left: 20px; font-size: 14px; transition: 0.3s; }
        .admin-nav a:hover { color: white; }
        .btn-logout { background: #ef4444; color: white !important; padding: 8px 18px; border-radius: 8px; font-weight: bold; }

        /* --- 2. HEADER ACTIONS & SEARCH --- */
        .admin-header-wrapper {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 35px; margin-top: 20px;
        }
        h1 { margin: 0; font-size: 28px; color: #1e293b; font-weight: 800; }
        
        .header-actions { display: flex; align-items: center; gap: 15px; }

        .search-box { position: relative; }
        .search-box input {
            padding: 12px 15px 12px 42px; border-radius: 12px; border: 1px solid #ddd;
            width: 280px; outline: none; transition: 0.3s; font-size: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .search-box input:focus { border-color: #6f42c1; box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.1); }
        .search-box i { position: absolute; left: 15px; top: 14px; color: #aaa; }

        .btn-main {
            text-decoration: none; padding: 12px 20px; border-radius: 12px;
            font-weight: bold; font-size: 14px; color: white; transition: 0.3s;
            display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer;
        }
        .btn-add { background: linear-gradient(135deg, #6f42c1 0%, #59359a 100%); box-shadow: 0 4px 12px rgba(111, 66, 193, 0.3); }
        .btn-dashboard { background: linear-gradient(135deg, #64748b 0%, #475569 100%); box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3); }
        .btn-main:hover { transform: translateY(-2px); filter: brightness(1.1); }

        /* BẢNG PHONG CÁCH THẺ */
        .admin-table { width: 100%; border-collapse: separate; border-spacing: 0 15px; }
        .admin-table thead th { background-color: #1e293b; color: #f8fafc; padding: 18px; font-size: 13px; text-transform: uppercase; text-align: left; }
        .admin-table thead th:first-child { border-radius: 8px 0 0 8px; text-align: center; }
        .admin-table thead th:last-child { border-radius: 0 8px 8px 0; }
        .admin-table tbody tr { background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: 0.3s; }
        .admin-table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }
        .admin-table td { padding: 20px; border: none; vertical-align: middle; }
        .admin-table td:first-child { border-radius: 12px 0 0 12px; text-align: center; }
        .admin-table td:last-child { border-radius: 0 12px 12px 0; }

        .badge-stt { background: #334155; color: #fff; padding: 6px 12px; border-radius: 8px; font-weight: bold; }
        .btn-action { text-decoration: none; padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; transition: 0.3s; border: 1.5px solid; display: inline-block; margin-right: 5px; }
        .btn-view { color: #28a745; border-color: #28a745; }
        .btn-view:hover { background: #28a745; color: white; }
        .btn-edit { color: #007bff; border-color: #007bff; }
        .btn-edit:hover { background: #007bff; color: white; }
        .btn-delete { color: #dc3545; border-color: #dc3545; }
        .btn-delete:hover { background: #dc3545; color: white; }

        /* TOAST ALERT */
        .alert { position: fixed; top: 20px; right: 20px; padding: 15px 25px; border-radius: 10px; color: white; font-weight: bold; z-index: 9999; box-shadow: 0 5px 15px rgba(0,0,0,0.2); animation: slideIn 0.5s ease forwards; }
        .alert-success { background: #2ecc71; }
        .alert-danger { background: #e74c3c; }
        @keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
    </style>
</head>
<body>

    <div class="admin-nav">
        <div>
            <strong>XAYABURY ADMIN</strong> | Chào, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?>
        </div>
        <div>
            <a href="<?= URLROOT; ?>/home" target="_blank"><i class="fa-solid fa-earth-asia"></i> Xem trang chủ</a>
            <a href="<?= URLROOT; ?>/auth/logout" class="btn-logout" onclick="return confirm('Đăng xuất?')"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
        </div>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div id="alert" class="alert <?= (strpos($_GET['msg'], 'deleted') !== false) ? 'alert-danger' : 'alert-success' ?>">
            <?php 
                if($_GET['msg'] == 'added') echo "✨ Thêm người dùng thành công!";
                if($_GET['msg'] == 'updated') echo "📝 Cập nhật thông tin thành công!";
                if($_GET['msg'] == 'deleted') echo "🗑️ Đã xóa người dùng!";
            ?>
        </div>
        <script>setTimeout(() => { const a = document.getElementById('alert'); if(a){ a.style.opacity='0'; a.style.transition='0.5s'; setTimeout(()=>a.remove(), 500); }}, 3000);</script>
    <?php endif; ?>

    <div class="container">
        <div class="admin-header-wrapper">
            <div class="header-left">
                <h1>Quản lý người dùng</h1>
                <div class="header-actions" style="margin-top: 15px;">
                    <a href="<?= URLROOT ?>/admin/add_user" class="btn-main btn-add">
                        <i class="fa-solid fa-user-plus"></i> Thêm người dùng mới
                    </a>
                    <a href="<?= URLROOT; ?>/admin/dashboard" class="btn-main btn-dashboard">
                        <i class="fa-solid fa-house"></i> Dashboard
                    </a>
                </div>
            </div>

            <div class="search-box">
                <i class="fa fa-search"></i>
                <input type="text" id="userInput" onkeyup="searchUsers()" placeholder="Tìm theo tên, email, sđt...">
            </div>
        </div>

        <table class="admin-table" id="userTable">
            <thead>
                <tr>
                    <th width="80">STT</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Ngày tham gia</th>
                    <th width="250">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; if(!empty($data['users'])): foreach($data['users'] as $user): ?>
                <tr>
                    <td><span class="badge-stt"><?= $stt++; ?></span></td>
                    <td>
                        <div style="font-weight: bold; color: #1e293b; font-size: 16px;"><?= htmlspecialchars($user['fullname']); ?></div>
                        <small style="color: #64748b;">ID: #<?= $user['id']; ?></small>
                    </td>
                    <td style="color: #475569; font-weight: 500;"><?= htmlspecialchars($user['email']); ?></td>
                    <td style="color: #64748b;"><i class="fa-solid fa-phone" style="font-size: 12px;"></i> <?= htmlspecialchars($user['phone']); ?></td>
                    <td style="font-size: 13px; color: #94a3b8;"><?= date('d/m/Y', strtotime($user['created_at'])); ?></td>
                    <td>
                        <a href="<?= URLROOT; ?>/admin/user_detail/<?= $user['id']; ?>" class="btn-action btn-view">Xem</a>
                        <a href="<?= URLROOT; ?>/admin/edit_user/<?= $user['id']; ?>" class="btn-action btn-edit">Sửa</a>
                        <a href="<?= URLROOT; ?>/admin/delete_user/<?= $user['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="6" style="text-align:center; padding: 50px; color: #94a3b8;">Chưa có người dùng nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
    function searchUsers() {
        let input = document.getElementById("userInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("userTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let found = false;
            let td = tr[i].getElementsByTagName("td");
            for (let j = 1; j <= 3; j++) {
                if (td[j]) {
                    let txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }
            tr[i].style.display = found ? "" : "none";
        }
    }
    </script>

</body>
</html>