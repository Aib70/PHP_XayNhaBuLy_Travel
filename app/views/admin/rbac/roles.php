<?php require __DIR__ . '/_header.php'; ?>
<div class="rbac-header">
    <div class="rbac-title">
        <h1>Role Management</h1>
        <p>Tạo, sửa, xóa role và quản lý permission theo role.</p>
    </div>
    <div class="rbac-actions">
        <form class="rbac-search" method="GET" action="<?= URLROOT ?>/admin/roles">
            <input name="q" value="<?= htmlspecialchars($data['q'] ?? '') ?>" placeholder="Tìm role...">
            <button class="rbac-btn secondary" type="submit">Tìm</button>
        </form>
        <a class="rbac-btn primary" href="<?= URLROOT ?>/admin/add_role">Thêm role</a>
    </div>
</div>
<div class="rbac-panel">
    <table class="rbac-table">
        <thead><tr><th>Role</th><th>Mô tả</th><th>Permissions</th><th>Users</th><th>Thao tác</th></tr></thead>
        <tbody>
        <?php foreach ($data['roles'] as $role): ?>
            <tr>
                <td><strong><?= htmlspecialchars($role['name']) ?></strong><br><small><?= htmlspecialchars($role['display_name']) ?></small></td>
                <td><?= htmlspecialchars($role['description'] ?? '') ?></td>
                <td><span class="rbac-badge"><?= (int) $role['permission_count'] ?></span></td>
                <td><span class="rbac-badge"><?= (int) $role['user_count'] ?></span></td>
                <td>
                    <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/role_detail/<?= $role['id'] ?>">Xem</a>
                    <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/edit_role/<?= $role['id'] ?>">Sửa</a>
                    <a class="rbac-btn primary" href="<?= URLROOT ?>/admin/assign_permissions/<?= $role['id'] ?>">Gắn quyền</a>
                    <form method="POST" action="<?= URLROOT ?>/admin/delete_role/<?= $role['id'] ?>" style="display:inline" onsubmit="return confirm('Xóa role này?')">
                        <?= Csrf::field() ?>
                        <button class="rbac-btn danger" type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/_footer.php'; ?>
