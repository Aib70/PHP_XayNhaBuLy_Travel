<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Bình luận - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/admin/forum.css">
<?php
    if (!isset($data)) {
    $data = [];
}
?>

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

<div class="container">
    <div class="admin-header-wrapper">
        <div class="header-left">
            <h1><i class="fa-solid fa-comments" style="color: #8b5cf6;"></i> Quản lý Bình Luận</h1>
            <a href="<?= URLROOT ?>/admin/dashboard" class="btn-dashboard">
                <i class="fa-solid fa-house-chimney"></i> Dashboard
            </a>
        </div>

        <div class="search-box-wrapper">
            <i class="fa fa-search"></i>
            <input type="text" id="forumSearch" onkeyup="filterForum()" placeholder="Tìm tên, địa điểm, nội dung...">
        </div>
    </div>

    <div class="filter-info">
        <i class="fa-solid fa-filter"></i> <?= $data['place_name'] ?>
    </div>

    <table class="admin-table" id="forumTable">
        <thead>
            <tr>
                <th width="180">Người đăng</th>
                <th>Nội dung bình luận</th>
                <th width="150">Trạng thái</th>
                <th width="200">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($data['posts'])): ?>
                <?php foreach($data['posts'] as $p): ?>
                <tr>
                    <td style="text-align: center;">
                        <span class="author-tag"><i class="fa-solid fa-circle-user"></i> <?= htmlspecialchars($p['author_name']); ?></span>
                        <small style="color: #94a3b8; font-size: 10px;"><?= $p['created_at'] ?></small>
                    </td>
                    <td>
                        <?php if(isset($p['place_name'])): ?>
                            <span class="place-tag"><i class="fa-solid fa-location-dot"></i> Tại: <?= htmlspecialchars($p['place_name']) ?></span>
                        <?php endif; ?>

                        <span class="post-title"><?= htmlspecialchars($p['title']); ?></span>
                        <div class="post-content"><?= nl2br(htmlspecialchars($p['content'])); ?></div>
                    </td>
                    <td style="text-align: center;">
                        <?php if($p['status'] == 1): ?>
                            <span class="status-badge status-approved">✅ Đã duyệt</span>
                        <?php else: ?>
                            <span class="status-badge status-pending">⏳ Chờ duyệt</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($p['status'] == 0 && can(Permissions::APPROVE_POSTS)): ?>
                            <form method="POST" action="<?= URLROOT; ?>/admin/approve_post/<?= $p['id']; ?>" style="display:inline;">
                                <?= Csrf::field() ?>
                                <button type="submit" class="btn-action btn-approve" style="border:0;">
                                    <i class="fa-solid fa-check"></i> Duyệt
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if (can(Permissions::DELETE_POSTS)): ?>
                            <form method="POST" action="<?= URLROOT; ?>/admin/delete_comment/<?= $p['id']; ?>" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                <?= Csrf::field() ?>
                                <button type="submit" class="btn-action btn-delete" style="border:0;">
                                    <i class="fa-solid fa-trash-can"></i> Xóa
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="padding: 80px; text-align: center; color: #94a3b8; font-style: italic;">
                        <div style="font-size: 50px; margin-bottom: 20px; opacity: 0.5;">📭</div>
                        Hiện chưa có bình luận nào cần xử lý.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
function filterForum() {
    let input = document.getElementById("forumSearch");
    let filter = input.value.toUpperCase();
    let table = document.getElementById("forumTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let found = false;
        let td = tr[i].getElementsByTagName("td");
        
        // Kiểm tra cột Người đăng (0) và Nội dung (1)
        if (td[0] || td[1]) {
            let authorInfo = td[0].textContent || td[0].innerText;
            let contentInfo = td[1].textContent || td[1].innerText;
            
            if (authorInfo.toUpperCase().indexOf(filter) > -1 || contentInfo.toUpperCase().indexOf(filter) > -1) {
                found = true;
            }
        }
        tr[i].style.display = found ? "" : "none";
    }
}
</script>

</body>
</html>
