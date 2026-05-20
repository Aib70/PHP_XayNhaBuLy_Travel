<?php require __DIR__ . '/_header.php'; ?>
<div class="rbac-header">
    <div class="rbac-title">
        <h1><?= htmlspecialchars($data['permission']['display_name']) ?></h1>
        <p><strong><?= htmlspecialchars($data['permission']['name']) ?></strong> - <?= htmlspecialchars($data['permission']['description'] ?? '') ?></p>
    </div>
    <div class="rbac-actions">
        <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/edit_permission/<?= $data['permission']['id'] ?>">Sửa</a>
        <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/permissions">Danh sách</a>
    </div>
</div>
<?php require __DIR__ . '/_footer.php'; ?>
