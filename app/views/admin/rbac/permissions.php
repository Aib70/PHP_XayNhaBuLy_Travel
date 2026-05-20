<?php require __DIR__ . '/_header.php'; ?>
<div class="rbac-header">
    <div class="rbac-title">
        <h1>Permission Management</h1>
        <p>Quản lý permission backend dùng cho RBAC.</p>
    </div>
    <div class="rbac-actions">
        <form class="rbac-search" method="GET" action="<?= URLROOT ?>/admin/permissions">
            <input name="q" value="<?= htmlspecialchars($data['q'] ?? '') ?>" placeholder="Tìm permission...">
            <button class="rbac-btn secondary" type="submit">Tìm</button>
        </form>
        <a class="rbac-btn primary" href="<?= URLROOT ?>/admin/add_permission">Thêm permission</a>
    </div>
</div>
<div class="rbac-panel">
    <table class="rbac-table">
        <thead><tr><th>Permission</th><th>Mô tả</th><th>Roles</th><th>Thao tác</th></tr></thead>
        <tbody>
        <?php foreach ($data['permissions'] as $permission): ?>
            <tr>
                <td><strong><?= htmlspecialchars($permission['name']) ?></strong><br><small><?= htmlspecialchars($permission['display_name']) ?></small></td>
                <td><?= htmlspecialchars($permission['description'] ?? '') ?></td>
                <td><span class="rbac-badge"><?= (int) $permission['role_count'] ?></span></td>
                <td>
                    <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/permission_detail/<?= $permission['id'] ?>">Xem</a>
                    <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/edit_permission/<?= $permission['id'] ?>">Sửa</a>
                    <form method="POST" action="<?= URLROOT ?>/admin/delete_permission/<?= $permission['id'] ?>" style="display:inline" onsubmit="return confirm('Xóa permission này?')">
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
