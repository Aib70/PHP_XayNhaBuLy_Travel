<?php require __DIR__ . '/_header.php'; ?>
<?php $permission = $data['permission'] ?? null; $isEdit = !empty($permission); ?>
<div class="rbac-header">
    <div class="rbac-title">
        <h1><?= $isEdit ? 'Sửa permission' : 'Thêm permission' ?></h1>
        <p>Permission name nên là snake_case theo action backend.</p>
    </div>
    <a class="rbac-btn secondary" href="<?= URLROOT ?>/admin/permissions">Quay lại</a>
</div>
<div class="rbac-panel">
    <form class="rbac-form" method="POST" action="<?= URLROOT ?>/admin/<?= $isEdit ? 'update_permission/' . $permission['id'] : 'store_permission' ?>">
        <?= Csrf::field() ?>
        <div>
            <label>Permission name</label>
            <input name="name" value="<?= htmlspecialchars($permission['name'] ?? '') ?>" required maxlength="100" <?= in_array($permission['name'] ?? '', Permissions::ADMIN_AREA, true) ? 'readonly' : '' ?>>
        </div>
        <div>
            <label>Display name</label>
            <input name="display_name" value="<?= htmlspecialchars($permission['display_name'] ?? '') ?>" required maxlength="150">
        </div>
        <div>
            <label>Mô tả</label>
            <textarea name="description"><?= htmlspecialchars($permission['description'] ?? '') ?></textarea>
        </div>
        <button class="rbac-btn primary" type="submit">Lưu permission</button>
    </form>
</div>
<?php require __DIR__ . '/_footer.php'; ?>
