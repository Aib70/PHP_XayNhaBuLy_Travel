<?php 
    // --- KHỐI LOGIC XỬ LÝ THÔNG BÁO ---
    $msg_text = "";
    $msg_bg = "";
    $msg_color = "";
    $msg_border = "";

    if (isset($_GET['msg'])) {
        switch ($_GET['msg']) {
            case 'confirmed':
                $msg_text = "Đã xác nhận đơn đặt chỗ thành công!";
                $msg_bg = "#d4edda";    // Xanh lá nhạt
                $msg_color = "#155724";  // Chữ xanh đậm
                $msg_border = "#c3e6cb";
                break;
            case 'deleted':
                $msg_text = "Đã xóa đơn đặt chỗ khỏi hệ thống!";
                $msg_bg = "#f8d7da";    // Đỏ nhạt
                $msg_color = "#721c24";  // Chữ đỏ đậm
                $msg_border = "#f5c6cb";
                break;
            case 'updated':
                $msg_text = "Cập nhật thông tin thành công!";
                $msg_bg = "#d1ecf1";    // Xanh biển nhạt
                $msg_color = "#0c5460";  // Chữ xanh biển đậm
                $msg_border = "#bee5eb";
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
        .status-badge { padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; }
        .pending { background: #ffeeba; color: #856404; }
        .confirmed { background: #d4edda; color: #155724; }
        .cancelled { background: #f8d7da; color: #721c24; }
        
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f7f6; margin: 0; padding: 20px; color: #333; }
        .container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-width: 1100px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #343a40; color: white; text-transform: uppercase; font-size: 0.85rem; }
        .btn { text-decoration: none; padding: 7px 12px; border-radius: 5px; font-size: 1rem; font-weight: bold; color: white; display: inline-block; border: none; cursor: pointer; }
        .btn-back { display: inline-block; margin-bottom: 20px; color: #555; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= URLROOT ?>/admin" class="btn-back">← Quay lại Quản lý</a>

        <?php if($msg_text != ""): ?>
            <div id="status-alert" style="background: <?= $msg_bg ?>; color: <?= $msg_color ?>; padding: 15px; border-radius: 8px; border: 1px solid <?= $msg_border ?>; margin-bottom: 20px; font-weight: bold; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <span>📢 <?= $msg_text ?></span>
                <button onclick="this.parentElement.style.display='none'" style="background:none; border:none; color:inherit; cursor:pointer; font-size:22px; font-weight:bold;">&times;</button>
            </div>

            <script>
                // Tự động ẩn thông báo sau 4 giây
                setTimeout(function() {
                    var alert = document.getElementById('status-alert');
                    if(alert) alert.style.display = 'none';
                }, 4000);
            </script>
        <?php endif; ?>

        <h2 style="color: #1565c0; margin-top: 10px;"><i class="fa fa-map-marked-alt"></i> Danh sách đặt Địa danh & Lễ hội</h2>
        <table border="1" width="100%" style="border-collapse: collapse; margin-bottom: 50px;">
            <thead>
                <tr style="background: #34495e; color: white;">
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Địa danh</th>
                    <th>Ngày tham quan</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['placeBookings'] as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><strong><?= htmlspecialchars($row['user_name']) ?></strong><br><small><?= $row['phone'] ?></small></td>
                    <td style="color: #1565c0; font-weight: bold;"><?= htmlspecialchars($row['place_name']) ?></td>
                    <td><?= $row['booking_date'] ?></td>
                    <td><span class="status-badge <?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span></td>
                    <td>
                        <a href="<?= URLROOT ?>/admin/approve_booking/<?= $row['id'] ?>" class="btn" style="background:#17a2b8" title="Xác nhận" onclick="return confirm('Xác nhận đơn đặt chỗ này?')">✔</a>
                        <a href="<?= URLROOT ?>/admin/delete_booking/<?= $row['id'] ?>" class="btn" style="background:#dc3545" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn XÓA đơn đặt chỗ này không? Hành động này không thể hoàn tác!');">✘</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <hr style="border: 0; border-top: 2px solid #eee;">

        <h2 style="color: #2e7d32; margin-top: 30px;"><i class="fa fa-hotel"></i> Danh sách đặt Khách sạn</h2>
        <table border="1" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr style="background: #2e7d32; color: white;">
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Khách sạn</th>
                    <th>Thời gian lưu trú</th>
                    <th>Số khách</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['hotelBookings'] as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><strong><?= htmlspecialchars($row['user_name']) ?></strong><br><small><?= $row['phone'] ?></small></td>
                    <td style="color: #2e7d32; font-weight: bold;"><?= htmlspecialchars($row['place_name']) ?></td>
                    <td>
                        <small>Check-in: <b><?= $row['checkin'] ?></b></small><br>
                        <small>Check-out: <b><?= $row['checkout'] ?></b></small>
                    </td>
                    <td style="text-align: center;"><?= $row['guests'] ?></td>
                    <td><span class="status-badge <?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span></td>
                    <td>
                        <a href="<?= URLROOT ?>/admin/approve_booking/<?= $row['id'] ?>" class="btn" style="background:#17a2b8" title="Xác nhận" onclick="return confirm('Xác nhận đặt phòng khách sạn này?')">✔</a>
                        <a href="<?= URLROOT ?>/admin/delete_booking/<?= $row['id'] ?>" class="btn" style="background:#dc3545" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn XÓA đơn đặt phòng này?');">✘</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>