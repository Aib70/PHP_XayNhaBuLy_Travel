<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản trị - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f8fafc; color: #333; }
        .container { padding: 40px; max-width: 1300px; margin: auto; }

        /* NAVIGATION BAR */
        .admin-nav {
            background: #1e293b; color: white; padding: 15px 35px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .admin-nav a { color: #cbd5e1; text-decoration: none; margin-left: 20px; font-size: 14px; transition: 0.3s; }
        .admin-nav a:hover { color: white; }
        .btn-logout { background: #ef4444; color: white !important; padding: 8px 18px; border-radius: 8px; font-weight: bold; }

        /* HEADER WRAPPER - PHÂN TÁCH TIÊU ĐỀ VÀ TÌM KIẾM */
        .admin-header-wrapper {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 35px; margin-top: 20px;
        }
        .header-left h1 { color: #1e293b; font-size: 28px; font-weight: 800; margin: 0 0 15px 0; }
        
        .header-actions { display: flex; align-items: center; gap: 12px; }

        /* NÚT BẤM */
        .btn-main {
            text-decoration: none; padding: 12px 20px; border-radius: 12px;
            font-weight: bold; font-size: 14px; color: white; transition: 0.3s;
            display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer;
        }
        .btn-add { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3); }
        .btn-dashboard { background: linear-gradient(135deg, #64748b 0%, #475569 100%); box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3); }
        .btn-main:hover { transform: translateY(-2px); filter: brightness(1.1); }

        /* Ô TÌM KIẾM CẬP NHẬT */
        .search-box-wrapper { position: relative; }
        .search-box-wrapper input {
            padding: 12px 15px 12px 42px; border-radius: 12px; border: 1px solid #ddd;
            width: 300px; outline: none; box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: 0.3s;
        }
        .search-box-wrapper input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .search-box-wrapper i { position: absolute; left: 15px; top: 14px; color: #94a3b8; }

        /* BẢNG DỮ LIỆU CARD-STYLE */
        .admin-table { width: 100%; border-collapse: separate; border-spacing: 0 15px; }
        .admin-table thead th { background-color: #1e293b; color: #f8fafc; padding: 18px; font-size: 13px; text-transform: uppercase; text-align: left; border: none; }
        .admin-table thead th:first-child { border-radius: 8px 0 0 8px; text-align: center; }
        .admin-table thead th:last-child { border-radius: 0 8px 8px 0; }

        .admin-table tbody tr { background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: 0.3s; }
        .admin-table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }
        .admin-table td { padding: 18px; vertical-align: middle; border: none; }
        .admin-table td:first-child { border-radius: 12px 0 0 12px; text-align: center; }
        .admin-table td:last-child { border-radius: 0 12px 12px 0; }

        .badge-stt { background: #334155; color: #fff; padding: 6px 12px; border-radius: 8px; font-weight: bold; }
        
        .name-container div { margin-bottom: 4px; }
        .name-vi { font-weight: bold; color: #1e293b; font-size: 15px; }
        .name-lo { font-size: 13px; color: #64748b; }
        .name-en { font-size: 13px; color: #3b82f6; font-weight: 500; }

        /* THAO TÁC */
        .btn-action { text-decoration: none; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: bold; margin-right: 5px; display: inline-block; border: 1.5px solid; transition: 0.2s; }
        .btn-view { color: #10b981; border-color: #10b981; }
        .btn-view:hover { background: #10b981; color: white; }
        .btn-edit { color: #3b82f6; border-color: #3b82f6; }
        .btn-edit:hover { background: #3b82f6; color: white; }
        .btn-delete { color: #ef4444; border-color: #ef4444; }
        .btn-delete:hover { background: #ef4444; color: white; }
        
        .btn-forum-small { background: #8b5cf6; color: white; padding: 7px 15px; border-radius: 20px; font-size: 11px; text-decoration: none; display: inline-block; margin-top: 10px; font-weight: bold; transition: 0.3s; }
        .btn-forum-small:hover { filter: brightness(1.2); transform: scale(1.05); }

        /* TOAST ALERT */
        .alert-toast { position: fixed; top: 20px; right: 20px; padding: 15px 25px; border-radius: 10px; color: white; font-weight: bold; z-index: 9999; box-shadow: 0 5px 15px rgba(0,0,0,0.2); animation: slideIn 0.5s ease forwards; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #10b981; }
        .alert-danger { background: #ef4444; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
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
        <div id="toast" class="alert-toast <?= (strpos($_GET['msg'], 'deleted') !== false) ? 'alert-danger' : 'alert-success' ?>">
            <span>
                <?php 
                    if($_GET['msg'] == 'added') echo "✅ Đã thêm địa danh mới thành công!";
                    if($_GET['msg'] == 'updated') echo "📝 Đã cập nhật thông tin địa danh!";
                    if($_GET['msg'] == 'deleted') echo "🗑️ Đã xóa địa danh khỏi hệ thống!";
                ?>
            </span>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('toast'); if(t) { t.style.opacity = '0'; setTimeout(() => t.remove(), 500); } }, 3000);</script>
    <?php endif; ?>

    <div class="container">
        <div class="admin-header-wrapper">
            <div class="header-left">
                <h1>Quản lý địa danh Xayabury</h1>
                <div class="header-actions">
                    <a href="<?= URLROOT; ?>/admin/add" class="btn-main btn-add"><i class="fa-solid fa-plus"></i> Thêm địa danh mới</a>
                    <a href="<?= URLROOT; ?>/admin/dashboard" class="btn-main btn-dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
                </div>
            </div>

            <div class="search-box-wrapper">
                <i class="fa fa-search"></i>
                <input type="text" id="placeSearchInput" onkeyup="filterPlaces()" placeholder="Tìm địa danh, tọa độ...">
            </div>
        </div>

        <table class="admin-table" id="placeTable">
            <thead>
                <tr>
                    <th width="80">STT</th>
                    <th>Thông tin địa danh</th>
                    <th width="180">Tọa độ (Lat, Lng)</th>
                    <th width="350">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['places'])): $stt = 1; foreach($data['places'] as $place): ?>
                <tr>
                    <td><span class="badge-stt"><?= $stt++; ?></span></td>
                    <td class="name-container">
                        <div class="name-vi"><?= htmlspecialchars($place['name_vi'] ?? 'Chưa có'); ?></div>
                        <div class="name-lo"><?= htmlspecialchars($place['name_lo'] ?? 'ຍັງບໍ່ມີ'); ?></div>
                        <div class="name-en">🇺🇸 <?= htmlspecialchars($place['name_en'] ?? 'N/A'); ?></div>
                        <small style="color: #cbd5e1; font-size: 10px;">ID gốc: #<?= $place['id']; ?></small>
                    </td>
                    <td style="font-family: monospace; color: #64748b; font-size: 12px; line-height: 1.5;">
                        📍 <?= number_format($place['latitude'], 6); ?>,<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<?= number_format($place['longitude'], 6); ?>
                    </td>
                    <td>
                        <div>
                            <a href="<?= URLROOT; ?>/place/view/<?= $place['id']; ?>" class="btn-action btn-view" target="_blank">Xem</a>
                            <a href="<?= URLROOT; ?>/admin/edit/<?= $place['id']; ?>" class="btn-action btn-edit">Sửa</a>
                            <a href="<?= URLROOT; ?>/admin/delete/<?= $place['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Xóa?')">Xóa</a>
                        </div>
                        <a href="<?= URLROOT; ?>/admin/forum/<?= $place['id']; ?>" class="btn-forum-small"><i class="fa-solid fa-comments"></i> Quản lý Diễn đàn</a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="4" style="text-align:center; padding: 50px; color: #94a3b8;">Chưa có dữ liệu.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
    function filterPlaces() {
        let input = document.getElementById("placeSearchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("placeTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let found = false;
            let td = tr[i].getElementsByTagName("td");
            
            // Kiểm tra cột Thông tin địa danh (index 1) và cột Tọa độ (index 2)
            if (td[1] || td[2]) {
                let nameInfo = td[1].textContent || td[1].innerText;
                let latInfo = td[2].textContent || td[2].innerText;
                
                if (nameInfo.toUpperCase().indexOf(filter) > -1 || latInfo.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                }
            }
            tr[i].style.display = found ? "" : "none";
        }
    }
    </script>
</body>
</html>