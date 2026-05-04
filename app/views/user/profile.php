<?php require_once '../app/views/inc/header.php'; ?>
<?php
    if (!isset($data)) {
    $data = [];
}
?>
<div style="max-width: 600px; margin: 50px auto; padding: 30px; background: white; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #333;">👤 Thông tin cá nhân</h2>
    <hr style="margin-bottom: 30px; opacity: 0.2;">

    <div style="line-height: 2; font-size: 16px;">
        <p><strong>Họ và tên:</strong> <?= htmlspecialchars($data['user']['fullname']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($data['user']['email']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($data['user']['phone'] ?? 'Chưa cập nhật') ?></p>
        <p><strong>Ngày tham gia:</strong> <?= date('d/m/Y', strtotime($data['user']['created_at'])) ?></p>
    </div>

    <div style="margin-top: 30px; text-align: center;">
        <a href="<?= URLROOT ?>/user/edit_profile" style="padding: 10px 25px; background: #ffcc00; color: #333; text-decoration: none; border-radius: 8px; font-weight: bold;">Sửa thông tin</a>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>