<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Khách sạn - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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

        /* --- 2. CẬP NHẬT HEADER WRAPPER (TIÊU ĐỀ & TÌM KIẾM) --- */
        .admin-header-wrapper {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 35px; margin-top: 20px;
        }
        .header-left h1 { color: #1e293b; font-size: 28px; font-weight: 800; margin: 0 0 15px 0; }
        
        .header-actions { display: flex; align-items: center; gap: 12px; }

        .btn-main {
            text-decoration: none; padding: 12px 20px; border-radius: 12px;
            font-weight: bold; font-size: 14px; color: white; transition: 0.3s;
            display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer;
        }
        /* Màu cam đặc trưng cho khách sạn */
        .btn-add { background: linear-gradient(135deg, #f39c12 0%, #d35400 100%); box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3); }
        .btn-dashboard { background: linear-gradient(135deg, #64748b 0%, #475569 100%); box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3); }
        .btn-main:hover { transform: translateY(-2px); filter: brightness(1.1); }

        /* --- 3. Ô TÌM KIẾM BÊN PHẢI --- */
        .search-box-wrapper { position: relative; }
        .search-box-wrapper input {
            padding: 12px 15px 12px 42px; border-radius: 12px; border: 1px solid #ddd;
            width: 300px; outline: none; box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: 0.3s;
        }
        .search-box-wrapper input:focus { border-color: #f39c12; box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.1); }
        .search-box-wrapper i { position: absolute; left: 15px; top: 14px; color: #94a3b8; }

        /* TABLE STYLES */
        .admin-table { width: 100%; border-collapse: separate; border-spacing: 0 15px; }
        .admin-table thead th { background-color: #1e293b; color: #f8fafc; padding: 18px; font-size: 13px; text-transform: uppercase; text-align: left; border: none; }
        .admin-table thead th:first-child { border-radius: 8px 0 0 8px; text-align: center; }
        .admin-table thead th:last-child { border-radius: 0 8px 8px 0; }
        .admin-table tbody tr { background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: 0.3s; }
        .admin-table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }
        .admin-table td { padding: 20px; border: none; vertical-align: middle; }
        .admin-table td:first-child { border-radius: 12px 0 0 12px; text-align: center; }
        .admin-table td:last-child { border-radius: 0 12px 12px 0; }

        .hotel-img-container { width: 120px; height: 80px; overflow: hidden; border-radius: 8px; border: 1px solid #eee; }
        .hotel-img-container img { width: 100%; height: 100%; object-fit: cover; }
        .btn-action { padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: bold; margin-right: 5px; display: inline-block; border: 1.5px solid; transition: 0.2s; text-decoration: none; }
        .btn-view { color: #10b981; border-color: #10b981; }
        .btn-view:hover { background: #10b981; color: white; }
        .btn-forum { background: #8b5cf6; color: white; border: none; }
        .btn-edit { color: #3b82f6; border-color: #3b82f6; }
        .btn-delete { color: #ef4444; border-color: #ef4444; }
        .badge-stt { background: #334155; color: #fff; padding: 6px 12px; border-radius: 8px; font-weight: bold; }
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
                <h1>Quản lý Khách sạn</h1>
                <div class="header-actions">
                    <a href="<?= URLROOT ?>/admin/add_hotel" class="btn-main btn-add">
                        <i class="fa-solid fa-plus"></i> Thêm khách sạn mới
                    </a>
                    <a href="<?= URLROOT; ?>/admin/dashboard" class="btn-main btn-dashboard">
                        <i class="fa-solid fa-house"></i> Dashboard
                    </a>
                </div>
            </div>

            <div class="search-box-wrapper">
                <i class="fa fa-search"></i>
                <input type="text" id="hotelSearchInput" onkeyup="filterHotels()" placeholder="Tìm khách sạn, địa chỉ...">
            </div>
        </div>

        <table class="admin-table" id="hotelTable">
            <thead>
                <tr>
                    <th width="80">STT</th>
                    <th width="150">Hình ảnh</th>
                    <th>Tên khách sạn</th>
                    <th>Địa chỉ</th>
                    <th width="320">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; if(!empty($data['hotels'])): foreach($data['hotels'] as $hotel): ?>
                <tr>
                    <td><span class="badge-stt"><?= $stt++; ?></span></td>
                    <td>
                        <div class="hotel-img-container">
                            <img src="<?= URLROOT ?>/public/img/places/<?= $hotel['image_main'] ?? $hotel['image'] ?>">
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: bold; color: #2c3e50; font-size: 16px;"><?= htmlspecialchars($hotel['name_vi'] ?? 'N/A'); ?></div>
                        <small style="color: #94a3b8;">ID: #<?= $hotel['id']; ?></small>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px; color: #475569;">
                            <i class="fa-solid fa-location-dot" style="color: #ef4444;"></i>
                            <span><?= !empty($hotel['addr_vi']) ? htmlspecialchars($hotel['addr_vi']) : 'Chưa cập nhật địa chỉ'; ?></span>
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                            <a href="<?= URLROOT; ?>/place/view/<?= $hotel['id']; ?>" class="btn-action btn-view" target="_blank"><i class="fa-solid fa-eye"></i> Xem</a>
                            <a href="<?= URLROOT; ?>/admin/forum/<?= $hotel['id']; ?>" class="btn-action btn-forum"><i class="fa-solid fa-comments"></i> Diễn đàn</a>
                            <a href="<?= URLROOT; ?>/admin/edit/<?= $hotel['id']; ?>" class="btn-action btn-edit"><i class="fa-solid fa-pen-to-square"></i> Sửa</a>
                            <a href="<?= URLROOT; ?>/admin/delete/<?= $hotel['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Xóa khách sạn này?')"><i class="fa-solid fa-trash"></i> Xóa</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" style="text-align:center; padding: 50px; color: #94a3b8;">Chưa có khách sạn nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
    function filterHotels() {
        let input = document.getElementById("hotelSearchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("hotelTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let found = false;
            let td = tr[i].getElementsByTagName("td");
            if (td[2] || td[3]) {
                let nameValue = td[2].textContent || td[2].innerText;
                let addrValue = td[3].textContent || td[3].innerText;
                if (nameValue.toUpperCase().indexOf(filter) > -1 || addrValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                }
            }
            tr[i].style.display = found ? "" : "none";
        }
    }
    </script>
</body>
</html>