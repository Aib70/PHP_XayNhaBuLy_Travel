<?php require __DIR__ . '/_header.php'; ?>
<div class="rbac-header">
    <div class="rbac-title">
        <h1>User Role Mapping</h1>
        <p>Gắn hoặc revoke role cho người dùng hiện có.</p>
    </div>
    <form class="rbac-search" method="GET" action="<?= URLROOT ?>/admin/user_roles">
        <input name="q" value="<?= htmlspecialchars($data['q'] ?? '') ?>" placeholder="Tìm user...">
        <button class="rbac-btn secondary" type="submit">Tìm</button>
    </form>
</div>
<div class="rbac-panel">
    <table class="rbac-table">
        <thead><tr><th>User</th><th>Email</th><th>Phone</th><th>Roles</th><th>Thao tác</th></tr></thead>
        <tbody>
        <?php foreach ($data['users'] as $user): ?>
            <tr>
                <td><strong><?= htmlspecialchars($user['fullname']) ?></strong><br><small>ID #<?= (int) $user['id'] ?></small></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['phone'] ?? '') ?></td>
                <td><?= htmlspecialchars($user['roles'] ?? 'Chưa có role') ?></td>
                <td><a class="rbac-btn primary" href="<?= URLROOT ?>/admin/edit_user_roles/<?= $user['id'] ?>">Gắn role</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/_footer.php'; ?>
