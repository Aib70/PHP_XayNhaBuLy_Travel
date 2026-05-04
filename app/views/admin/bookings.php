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
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/admin/bookings.css">
<?php
    if (!isset($data) || !isset($data['booking'])) {
    echo '<div style="max-width:600px;margin:50px auto;padding:20px;background:#ffe6e6;color:#990000;border:1px solid #ffb3b3;border-radius:12px;font-family:sans-serif;">Lỗi: dữ liệu đặt chỗ chưa được truyền vào view.</div>';
    return;
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