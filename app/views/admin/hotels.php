<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Khách sạn - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/admin/hotels.css">
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