<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Người dùng - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/admin_user_index.css">
       
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