<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Trợ giúp - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/help_index.css">
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
                <h1><i class="fa-solid fa-envelope-open-text" style="color: #e84393;"></i> Quản lý trợ giúp</h1>
                <a href="<?= URLROOT; ?>/admin/dashboard" class="btn-dashboard">
                    <i class="fa-solid fa-house-chimney"></i> Dashboard
                </a>
            </div>

            <div class="search-box-wrapper">
                <i class="fa fa-search"></i>
                <input type="text" id="helpSearchInput" onkeyup="filterHelp()" placeholder="Tìm tên, email, nội dung...">
            </div>
        </div>

        <table class="admin-table" id="helpTable">
            <thead>
                <tr>
                    <th width="80">STT</th>
                    <th width="25%">Khách hàng</th>
                    <th width="50%">Nội dung tin nhắn</th>
                    <th width="15%">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; if(!empty($data['requests'])): foreach($data['requests'] as $req): ?>
                <tr>
                    <td><span class="badge-stt"><?= $stt++; ?></span></td>
                    <td>
                        <span class="sender-name"><?= htmlspecialchars($req['name']) ?></span>
                        <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 10px;">
                            <a href="mailto:<?= htmlspecialchars($req['contact_info']) ?>" class="contact-tag" title="Gửi email">
                                <i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($req['contact_info']) ?>
                            </a>
                            <?php if(!empty($req['register_phone'])): ?>
                                <span class="contact-tag" style="background: #f0fdf4; color: #166534;">
                                    <i class="fa-solid fa-phone"></i> <?= htmlspecialchars($req['register_phone']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <span style="display: block; margin-top: 10px; font-size: 0.8rem; color: #94a3b8;">
                            <i class="fa-regular fa-clock"></i> <?= date('H:i d/m/Y', strtotime($req['created_at'])) ?>
                        </span>
                    </td>
                    <td>
                        <div class="message-content">
                            "<?= nl2br(htmlspecialchars($req['message'])) ?>"
                        </div>
                    </td>
                    <td>
                        <a href="<?= URLROOT ?>/admin/delete_help/<?= $req['id'] ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Xóa yêu cầu này?')">
                           <i class="fa-solid fa-trash-can"></i> Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 80px; color: #94a3b8; font-style: italic;">
                        📭 Hiện chưa có yêu cầu trợ giúp nào.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
    function filterHelp() {
        let input = document.getElementById("helpSearchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("helpTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let found = false;
            let td = tr[i].getElementsByTagName("td");
            
            // Kiểm tra cột Khách hàng (1) và Nội dung (2)
            if (td[1] || td[2]) {
                let nameInfo = td[1].textContent || td[1].innerText;
                let msgInfo = td[2].textContent || td[2].innerText;
                
                if (nameInfo.toUpperCase().indexOf(filter) > -1 || msgInfo.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                }
            }
            tr[i].style.display = found ? "" : "none";
        }
    }
    </script>
</body>
</html>