<?php require __DIR__ . '/_header.php'; ?>
<?php $role = $data['role'] ?? null; $isEdit = !empty($role); ?>
<div class="rbac-header">
    <div class="rbac-title">
        <h1><?= $isEdit ? 'Sửa role' : 'Thêm role' ?></h1>
        <p>Role name dùng chữ hoa, số và dấu gạch dưới.</p>
    </div>
    <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/roles">Quay lại</a>
</div>
<div class="rbac-panel">
    <form class="rbac-form" method="POST" action="<?= URLROOT ?>/admin/<?= $isEdit ? 'update_role/' . $role['id'] : 'store_role' ?>">
        <?= Csrf::field() ?>
        <div>
            <label>Role name</label>
            <input name="name" value="<?= htmlspecialchars($role['name'] ?? '') ?>" required maxlength="50" <?= in_array(strtoupper($role['name'] ?? ''), ['ADMIN','USER'], true) ? 'readonly' : '' ?>>
        </div>
        <div>
            <label>Display name</label>
            <input name="display_name" value="<?= htmlspecialchars($role['display_name'] ?? '') ?>" required maxlength="100">
        </div>
        <div>
            <label>Mô tả</label>
            <textarea name="description"><?= htmlspecialchars($role['description'] ?? '') ?></textarea>
        </div>
        <button class="rbac-btn primary" type="submit">Lưu role</button>
    </form>
</div>
<?php require __DIR__ . '/_footer.php'; ?>
