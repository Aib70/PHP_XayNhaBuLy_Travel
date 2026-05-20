<?php require __DIR__ . '/_header.php'; ?>
<div class="rbac-header">
    <div class="rbac-title">
        <h1>Assign Permissions</h1>
        <p>Role: <strong><?= htmlspecialchars($data['role']['name']) ?></strong></p>
    </div>
    <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/roles">Quay lại</a>
</div>
<div class="rbac-panel">
    <form method="POST" action="<?= URLROOT ?>/admin/update_role_permissions/<?= $data['role']['id'] ?>">
        <?= Csrf::field() ?>
        <div class="rbac-grid">
            <?php foreach ($data['permissions'] as $permission): ?>
                <label class="rbac-check">
                    <input type="checkbox" name="permission_ids[]" value="<?= $permission['id'] ?>" <?= in_array((int) $permission['id'], $data['assignedPermissionIds'], true) ? 'checked' : '' ?>>
                    <span>
                        <strong><?= htmlspecialchars($permission['name']) ?></strong>
                        <small><?= htmlspecialchars($permission['display_name']) ?></small>
                    </span>
                </label>
            <?php endforeach; ?>
        </div>
        <div style="padding: 0 18px 18px;">
            <button class="rbac-btn primary" type="submit">Lưu permissions</button>
        </div>
    </form>
</div>
<?php require __DIR__ . '/_footer.php'; ?>
