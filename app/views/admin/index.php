<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản trị - Xayabury Travel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/admin/index.css">
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