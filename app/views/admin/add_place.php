<h2>Thêm Địa Danh Mới</h2>
<form action="<?php echo URLROOT; ?>/admin/store" method="POST">
    <input type="number" name="category_id" placeholder="ID Danh mục">
    <input type="text" name="lat" placeholder="Vĩ độ (Lat)">
    <input type="text" name="lng" placeholder="Kinh độ (Lng)">

    <hr>
    <h3>Tiếng Việt</h3>
    <input type="text" name="name_vi" placeholder="Tên tiếng Việt">
    <textarea name="desc_vi" placeholder="Mô tả tiếng Việt"></textarea>

    <hr>
    <h3>Tiếng Lào</h3>
    <input type="text" name="name_lo" placeholder="Tên tiếng Lào">
    <textarea name="desc_lo" placeholder="Mô tả tiếng Lào"></textarea>

    <button type="submit">Lưu địa danh</button>
</form>
<a href="<?= URLROOT ?>/forum/forum/<?= $place['id'] ?>">
    📢 Quản lý Diễn đàn
</a>