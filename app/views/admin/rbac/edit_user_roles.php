<?php require __DIR__ . '/_header.php'; ?>
<div class="rbac-header">
    <div class="rbac-title">
        <h1>Assign Role To User</h1>
        <p><?= htmlspecialchars($data['user']['fullname']) ?> - <?= htmlspecialchars($data['user']['email']) ?></p>
    </div>
    <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/user_roles">Quay lại</a>
</div>
<div class="rbac-panel">
    <form method="POST" action="<?= URLROOT ?>/admin/update_user_roles/<?= $data['user']['id'] ?>">
        <?= Csrf::field() ?>
        <div class="rbac-grid">
            <?php foreach ($data['roles'] as $role): ?>
                <label class="rbac-check">
                    <input type="checkbox" name="role_ids[]" value="<?= $role['id'] ?>" <?= in_array((int) $role['id'], $data['assignedRoleIds'], true) ? 'checked' : '' ?>>
                    <span>
                        <strong><?= htmlspecialchars($role['name']) ?></strong>
                        <small><?= htmlspecialchars($role['display_name']) ?></small>
                    </span>
                </label>
            <?php endforeach; ?>
        </div>
        <div style="padding: 0 18px 18px;">
            <button class="rbac-btn primary" type="submit">Lưu user roles</button>
        </div>
    </form>
</div>
<?php require __DIR__ . '/_footer.php'; ?>
