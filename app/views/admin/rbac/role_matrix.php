<?php require __DIR__ . '/_header.php'; ?>
<div class="rbac-header">
    <div class="rbac-title">
        <h1>Role-Permission Matrix</h1>
        <p>Xem nhanh mapping giữa role và permission.</p>
    </div>
    <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/roles">Roles</a>
</div>
<div class="rbac-panel rbac-matrix">
    <table class="rbac-table">
        <thead>
            <tr>
                <th>Permission</th>
                <?php foreach ($data['roles'] as $role): ?>
                    <th><?= htmlspecialchars($role['name']) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['permissions'] as $permission): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($permission['name']) ?></strong></td>
                    <?php foreach ($data['roles'] as $role): ?>
                        <td><?= !empty($data['matrix'][(int) $role['id']][(int) $permission['id']]) ? '✓' : '-' ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/_footer.php'; ?>
