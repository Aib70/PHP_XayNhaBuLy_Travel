<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Diễn đàn - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* TỔNG THỂ */
        body { font-family: 'Segoe UI', Tahoma, sans-serif; padding: 30px; background-color: #f8fafc; color: #333; }
        .container { padding: 40px; max-width: 1200px; margin: auto; }

        /* NÚT DASHBOARD ĐỒNG BỘ */
        .btn-dashboard {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white !important; padding: 10px 22px; border-radius: 12px;
            text-decoration: none; font-weight: 600; font-size: 14px;
            display: inline-flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
            transition: 0.3s; margin-bottom: 30px;
        }
        .btn-dashboard:hover { transform: translateY(-2px); filter: brightness(1.1); }

        /* TIÊU ĐỀ & SEARCH */
        .header-flex { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 10px; }
        h1 { margin: 0; font-size: 28px; color: #1e293b; font-weight: 800; display: flex; align-items: center; gap: 12px; }
        
        .search-box { position: relative; }
        .search-box input {
            padding: 10px 15px 10px 40px; border-radius: 12px; border: 1px solid #ddd;
            width: 300px; outline: none; transition: 0.3s; font-size: 14px;
        }
        .search-box input:focus { border-color: #8b5cf6; box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1); }
        .search-box i { position: absolute; left: 15px; top: 12px; color: #aaa; }

        .filter-info { 
            background: #fff; padding: 15px 20px; border-radius: 10px; 
            border-left: 5px solid #e67e22; margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            font-weight: bold; color: #475569;
        }

        /* BẢNG PHONG CÁCH THẺ */
        .admin-table { width: 100%; border-collapse: separate; border-spacing: 0 15px; }
        .admin-table thead th { 
            background-color: #1e293b; color: #f8fafc; padding: 18px; 
            font-size: 13px; text-transform: uppercase; text-align: left; border: none; 
        }
        .admin-table thead th:first-child { border-radius: 8px 0 0 8px; text-align: center; }
        .admin-table thead th:last-child { border-radius: 0 8px 8px 0; }

        .admin-table tbody tr { background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: 0.3s; }
        .admin-table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }

        .admin-table td { padding: 20px; border: none; vertical-align: middle; }
        .admin-table td:first-child { border-radius: 12px 0 0 12px; text-align: center; }
        .admin-table td:last-child { border-radius: 0 12px 12px 0; }

        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .status-approved { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }

        .post-title { font-weight: bold; color: #1e293b; font-size: 16px; margin-bottom: 5px; display: block; }
        .place-tag { font-size: 12px; color: #3b82f6; font-weight: bold; margin-bottom: 8px; display: block; }
        .post-content { color: #64748b; font-size: 14px; line-height: 1.5; background: #f8fafc; padding: 10px; border-radius: 8px; }
        .author-tag { background: #f1f5f9; padding: 6px 12px; border-radius: 8px; font-size: 13px; color: #475569; font-weight: 600; display: block; }

        .btn-action { text-decoration: none; padding: 8px 15px; border-radius: 8px; font-size: 12px; font-weight: bold; transition: 0.3s; display: inline-flex; align-items: center; gap: 5px; }
        .btn-approve { color: #10b981; border: 1.5px solid #10b981; margin-right: 5px; }
        .btn-approve:hover { background: #10b981; color: white; }
        .btn-delete { color: #ef4444; border: 1.5px solid #ef4444; }
        .btn-delete:hover { background: #ef4444; color: white; }
    </style>
</head>
<body>

<div class="container">
    <a href="<?= URLROOT ?>/admin/dashboard" class="btn-dashboard">
        <i class="fa-solid fa-house-chimney"></i> Dashboard (Tổng quan)
    </a>

    <div class="header-flex">
        <h1><i class="fa-solid fa-comments" style="color: #8b5cf6;"></i> Quản lý Bình Luận</h1>
        
        <div class="search-box">
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
                        <?php if($p['status'] == 0): ?>
                            <a href="<?= URLROOT; ?>/admin/approve_post/<?= $p['id']; ?>" class="btn-action btn-approve">
                                <i class="fa-solid fa-check"></i> Duyệt
                            </a>
                        <?php endif; ?>

                        <a href="<?= URLROOT; ?>/admin/delete_comment/<?= $p['id']; ?>" 
                           class="btn-action btn-delete"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                           <i class="fa-solid fa-trash-can"></i> Xóa
                        </a>
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
        for (let j = 0; j < 2; j++) {
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