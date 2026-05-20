<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBAC Admin - Xayabury Travel</title>
    <?php require __DIR__ . '/_style.php'; ?>
</head>
<body>
<div class="rbac-topbar">
    <strong>XAYABURY RBAC</strong>
    <nav>
        <a href="<?= URLROOT ?>/admin/dashboard">Dashboard</a>
        <?php if (can(Permissions::MANAGE_ROLES)): ?>
            <a href="<?= URLROOT ?>/admin/roles">Roles</a>
            <a href="<?= URLROOT ?>/admin/role_matrix">Matrix</a>
        <?php endif; ?>
        <?php if (can(Permissions::MANAGE_PERMISSIONS)): ?>
            <a href="<?= URLROOT ?>/admin/permissions">Permissions</a>
        <?php endif; ?>
        <?php if (can(Permissions::MANAGE_USERS)): ?>
            <a href="<?= URLROOT ?>/admin/user_roles">User Roles</a>
        <?php endif; ?>
        <a href="<?= URLROOT ?>/auth/logout">Đăng xuất</a>
    </nav>
</div>
<main class="rbac-wrap">
    <?php if (!empty($_GET['msg'])): ?>
        <div class="rbac-alert ok"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>
    <?php if (!empty($_GET['error'])): ?>
        <div class="rbac-alert err"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
