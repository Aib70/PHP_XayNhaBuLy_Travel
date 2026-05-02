<?php 
    // --- KHỐI LOGIC XỬ LÝ THÔNG BÁO ---
    $msg_text = ""; $msg_bg = ""; $msg_color = ""; $msg_border = "";
    if (isset($_GET['msg'])) {
        switch ($_GET['msg']) {
            case 'confirmed':
                $msg_text = "Đã xác nhận đơn đặt chỗ thành công!";
                $msg_bg = "#d4edda"; $msg_color = "#155724"; $msg_border = "#c3e6cb";
                break;
            case 'deleted':
                $msg_text = "Đã xóa đơn đặt chỗ khỏi hệ thống!";
                $msg_bg = "#f8d7da"; $msg_color = "#721c24"; $msg_border = "#f5c6cb";
                break;
        }
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đặt chỗ - Xayabury Travel</title>
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

        /* --- 2. NÚT DASHBOARD --- */
        .btn-dashboard {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white !important; padding: 12px 22px; border-radius: 12px;
            text-decoration: none; font-weight: 600; font-size: 14px;
            display: inline-flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
            transition: 0.3s; margin-bottom: 30px; margin-top: 20px;
        }
        .btn-dashboard:hover { transform: translateY(-2px); filter: brightness(1.1); }

        /* --- 3. Ô TÌM KIẾM --- */
        .search-container { position: relative; }
        .search-input {
            padding: 12px 15px 12px 42px; border-radius: 12px; 
            border: 1px solid #ddd; width: 280px; outline: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: 0.3s;
        }
        .search-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .search-icon { position: absolute; left: 15px; top: 14px; color: #94a3b8; }

        /* TIÊU ĐỀ & HEADER BẢNG */
        .table-header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .section-title { font-size: 22px; font-weight: 800; display: flex; align-items: center; gap: 10px; }
        .title-place { color: #1e3a8a; }
        .title-hotel { color: #065f46; margin-top: 50px; }

        /* BẢNG PHONG CÁCH THẺ */
        .admin-table { width: 100%; border-collapse: separate; border-spacing: 0 12px; }
        .admin-table thead th { background-color: #1e293b; color: #f8fafc; padding: 15px; font-size: 12px; text-transform: uppercase; text-align: left; }
        .admin-table thead th:first-child { border-radius: 8px 0 0 8px; text-align: center; }
        .admin-table thead th:last-child { border-radius: 0 8px 8px 0; }

        .admin-table tbody tr { background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: 0.3s; }
        .admin-table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.08); }
        .admin-table td { padding: 15px 20px; border: none; vertical-align: middle; font-size: 14px; }
        .admin-table td:first-child { border-radius: 12px 0 0 12px; font-weight: bold; color: #334155; text-align: center; }
        .admin-table td:last-child { border-radius: 0 12px 12px 0; }

        /* TRẠNG THÁI */
        .status-badge { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
        .confirmed { background: #dcfce7; color: #166534; }
        .pending { background: #fef3c7; color: #92400e; }

        /* NÚT */
        .btn-op { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; color: white; text-decoration: none; transition: 0.2s; }
        .btn-confirm { background-color: #10b981; }
        .btn-delete { background-color: #ef4444; }
        .btn-op:hover { transform: scale(1.1); }
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
        <a href="<?= URLROOT ?>/admin/dashboard" class="btn-dashboard">
            <i class="fa-solid fa-house-chimney"></i> Dashboard (Tổng quan)
        </a>

        <div class="table-header-flex">
            <div class="section-title title-place">
                <i class="fa fa-map-marked-alt"></i> Danh sách đặt Địa danh & Lễ hội
            </div>
            <div class="search-container">
                <i class="fa fa-search search-icon"></i>
                <input type="text" id="searchPlace" onkeyup="filterTable('searchPlace', 'tablePlace')" 
                       placeholder="Tìm địa danh, khách..." class="search-input">
            </div>
        </div>

        <table class="admin-table" id="tablePlace">
            <thead>
                <tr>
                    <th width="60">STT</th>
                    <th>Khách hàng</th>
                    <th>Địa danh</th>
                    <th>Ngày tham quan</th>
                    <th>Trạng thái</th>
                    <th width="120">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $sttPlace = 1; foreach($data['placeBookings'] as $row): ?>
                <tr>
                    <td>#<?= $sttPlace++ ?></td>
                    <td>
                        <div style="font-weight: bold; color: #1e293b;"><?= htmlspecialchars($row['user_name']) ?></div>
                        <small style="color: #64748b;"><i class="fa fa-phone"></i> <?= $row['phone'] ?></small>
                    </td>
                    <td style="color: #2563eb; font-weight: 600;"><?= htmlspecialchars($row['place_name']) ?></td>
                    <td><i class="fa fa-calendar-day"></i> <?= $row['booking_date'] ?></td>
                    <td><span class="status-badge <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                    <td>
                        <a href="<?= URLROOT ?>/admin/approve_booking/<?= $row['id'] ?>" class="btn-op btn-confirm" title="Xác nhận"><i class="fa fa-check"></i></a>
                        <a href="<?= URLROOT ?>/admin/delete_booking/<?= $row['id'] ?>" class="btn-op btn-delete" title="Xóa" onclick="return confirm('Xóa đơn này?')"><i class="fa fa-trash-can"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="table-header-flex" style="margin-top: 50px;">
            <div class="section-title title-hotel">
                <i class="fa fa-hotel"></i> Danh sách đặt Khách sạn
            </div>
            <div class="search-container">
                <i class="fa fa-search search-icon"></i>
                <input type="text" id="searchHotel" onkeyup="filterTable('searchHotel', 'tableHotel')" 
                       placeholder="Tìm khách sạn, khách..." class="search-input">
            </div>
        </div>

        <table class="admin-table" id="tableHotel">
            <thead>
                <tr>
                    <th width="60">STT</th>
                    <th>Khách hàng</th>
                    <th>Khách sạn</th>
                    <th>Thời gian lưu trú</th>
                    <th>Số khách</th>
                    <th>Trạng thái</th>
                    <th width="120">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $sttHotel = 1; foreach($data['hotelBookings'] as $row): ?>
                <tr>
                    <td>#<?= $sttHotel++ ?></td>
                    <td>
                        <div style="font-weight: bold; color: #1e293b;"><?= htmlspecialchars($row['user_name']) ?></div>
                        <small style="color: #64748b;"><i class="fa fa-phone"></i> <?= $row['phone'] ?></small>
                    </td>
                    <td style="color: #059669; font-weight: 600;"><?= htmlspecialchars($row['place_name']) ?></td>
                    <td style="font-size: 12px; line-height: 1.4;">
                        <span style="color: #059669;">📥 In:</span> <b><?= $row['checkin'] ?></b><br>
                        <span style="color: #dc2626;">📤 Out:</span> <b><?= $row['checkout'] ?></b>
                    </td>
                    <td style="text-align: center;"><i class="fa fa-users"></i> <?= $row['guests'] ?></td>
                    <td><span class="status-badge <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                    <td>
                        <a href="<?= URLROOT ?>/admin/approve_booking/<?= $row['id'] ?>" class="btn-op btn-confirm" title="Xác nhận"><i class="fa fa-check"></i></a>
                        <a href="<?= URLROOT ?>/admin/delete_booking/<?= $row['id'] ?>" class="btn-op btn-delete" title="Xóa" onclick="return confirm('Xóa đơn này?')"><i class="fa fa-trash-can"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
    function filterTable(inputId, tableId) {
        let input = document.getElementById(inputId);
        let filter = input.value.toUpperCase();
        let table = document.getElementById(tableId);
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let found = false;
            let td = tr[i].getElementsByTagName("td");
            for (let j = 0; j < td.length; j++) {
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