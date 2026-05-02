<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Trợ giúp - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* TỔNG THỂ */
        body { margin: 0; font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f8fafc; color: #333; }
        .container { padding: 40px; max-width: 1300px; margin: auto; }

        /* --- 1. NAVIGATION BAR ĐỒNG BỘ --- */
        .admin-nav {
            background: #1e293b; color: white; padding: 15px 35px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .admin-nav a { color: #cbd5e1; text-decoration: none; margin-left: 20px; font-size: 14px; transition: 0.3s; }
        .admin-nav a:hover { color: white; }
        .btn-logout { background: #ef4444; color: white !important; padding: 8px 18px; border-radius: 8px; font-weight: bold; }

        /* --- 2. HEADER & SEARCH --- */
        .admin-header-wrapper {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 35px; margin-top: 20px;
        }
        .header-left h1 { margin: 0; font-size: 28px; color: #1e293b; font-weight: 800; display: flex; align-items: center; gap: 12px; }
        
        .btn-dashboard {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white !important; padding: 12px 22px; border-radius: 12px;
            text-decoration: none; font-weight: 600; font-size: 14px;
            display: inline-flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3); transition: 0.3s; margin-top: 15px;
        }
        .btn-dashboard:hover { transform: translateY(-2px); filter: brightness(1.1); }

        .search-box-wrapper { position: relative; }
        .search-box-wrapper input {
            padding: 12px 15px 12px 42px; border-radius: 12px; border: 1px solid #ddd;
            width: 300px; outline: none; box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: 0.3s;
        }
        .search-box-wrapper input:focus { border-color: #e84393; box-shadow: 0 0 0 3px rgba(232, 67, 147, 0.1); }
        .search-box-wrapper i { position: absolute; left: 15px; top: 14px; color: #94a3b8; }

        /* --- 3. BẢNG DỮ LIỆU --- */
        .admin-table { width: 100%; border-collapse: separate; border-spacing: 0 15px; }
        .admin-table thead th { 
            background-color: #1e293b; color: #f8fafc; padding: 18px; 
            font-size: 13px; text-transform: uppercase; text-align: left; 
        }
        .admin-table thead th:first-child { border-radius: 8px 0 0 8px; text-align: center; }
        .admin-table thead th:last-child { border-radius: 0 8px 8px 0; }

        .admin-table tbody tr { background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: 0.3s; }
        .admin-table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }

        .admin-table td { padding: 20px; vertical-align: top; border: none; }
        .admin-table td:first-child { border-radius: 12px 0 0 12px; text-align: center; }
        .admin-table td:last-child { border-radius: 0 12px 12px 0; }

        .badge-stt { background: #334155; color: #fff; padding: 6px 12px; border-radius: 8px; font-weight: bold; }
        .sender-name { font-weight: bold; color: #1e293b; font-size: 16px; display: block; }
        .contact-tag { background: #e0f2fe; color: #0369a1; padding: 6px 12px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; border: 1.5px solid transparent; transition: 0.2s; }
        .contact-tag:hover { border-color: #0369a1; }
        
        .message-content { line-height: 1.6; color: #475569; font-style: italic; background: #f8fafc; padding: 15px; border-radius: 10px; border-left: 4px solid #cbd5e1; }

        .btn-delete { 
            color: #ef4444; text-decoration: none; font-weight: bold; 
            border: 1.5px solid #ef4444; padding: 8px 16px; border-radius: 8px; 
            font-size: 13px; transition: 0.3s; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-delete:hover { background: #ef4444; color: white; }
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