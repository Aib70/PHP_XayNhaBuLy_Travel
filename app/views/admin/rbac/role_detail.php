<?php require __DIR__ . '/_header.php'; ?>
<div class="rbac-header">
    <div class="rbac-title">
        <h1><?= htmlspecialchars($data['role']['display_name']) ?></h1>
        <p><strong><?= htmlspecialchars($data['role']['name']) ?></strong> - <?= htmlspecialchars($data['role']['description'] ?? '') ?></p>
    </div>
    <div class="rbac-actions">
        <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/edit_role/<?= $data['role']['id'] ?>">Sửa</a>
        <a class="rbac-btn primary" href="<?= URLROOT ?>/admin/assign_permissions/<?= $data['role']['id'] ?>">Gắn quyền</a>
        <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/roles">Danh sách</a>
    </div>
</div>
<div class="rbac-panel">
    <div class="rbac-grid">
        <?php foreach ($data['permissions'] as $permission): ?>
            <?php $has = in_array((int) $permission['id'], $data['assignedPermissionIds'], true); ?>
            <div class="rbac-check" style="<?= $has ? 'border-color:#22c55e;background:#f0fdf4;' : '' ?>">
                <span><?= $has ? '✓' : '-' ?></span>
                <div>
                    <strong><?= htmlspecialchars($permission['name']) ?></strong>
                    <small><?= htmlspecialchars($permission['display_name']) ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require __DIR__ . '/_footer.php'; ?>
