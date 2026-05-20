<?php

final class Authorization
{
    private const SESSION_PERMISSIONS = 'auth_permissions';
    private const SESSION_ROLES = 'auth_roles';
    private const SESSION_ROLE_IDS = 'auth_role_ids';
    private const SESSION_ACTOR_TYPE = 'auth_actor_type';
    private const SESSION_ACTOR_ID = 'auth_actor_id';

    public static function loadForAdmin(PDO $db, array $admin): bool
    {
        if (empty($admin['id'])) {
            self::clear();
            return false;
        }

        return self::loadPermissions($db, 'admin', (int) $admin['id'], $admin['role_id'] ?? null);
    }

    public static function loadForUser(PDO $db, array $user): bool
    {
        if (empty($user['id'])) {
            self::clear();
            return false;
        }

        return self::loadPermissions($db, 'user', (int) $user['id'], $user['role_id'] ?? null);
    }

    public static function refreshCurrent(PDO $db): bool
    {
        if (!empty($_SESSION['admin_id'])) {
            $stmt = $db->prepare("SELECT * FROM admin WHERE id = ? LIMIT 1");
            $stmt->execute([$_SESSION['admin_id']]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            return $admin ? self::loadForAdmin($db, $admin) : false;
        }

        if (!empty($_SESSION['user_id'])) {
            $stmt = $db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user ? self::loadForUser($db, $user) : false;
        }

        self::clear();
        return false;
    }

    public static function clear(): void
    {
        unset($_SESSION[self::SESSION_PERMISSIONS]);
        unset($_SESSION[self::SESSION_ROLES]);
        unset($_SESSION[self::SESSION_ROLE_IDS]);
        unset($_SESSION[self::SESSION_ACTOR_TYPE]);
        unset($_SESSION[self::SESSION_ACTOR_ID]);
        unset($_SESSION['role']);
    }

    public static function hasPermission(string $permission): bool
    {
        if (!self::hasAuthenticatedActor()) {
            return false;
        }

        $permissions = $_SESSION[self::SESSION_PERMISSIONS] ?? [];
        if (!is_array($permissions)) {
            return false;
        }

        return in_array($permission, $permissions, true);
    }

    public static function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (self::hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    public static function requirePermission(string $permission, ?string $redirectUrl = null): void
    {
        if (!self::hasPermission($permission)) {
            self::deny($redirectUrl);
        }
    }

    public static function requireAnyPermission(array $permissions, ?string $redirectUrl = null): void
    {
        if (!self::hasAnyPermission($permissions)) {
            self::deny($redirectUrl);
        }
    }

    public static function roles(): array
    {
        $roles = $_SESSION[self::SESSION_ROLES] ?? [];
        return is_array($roles) ? $roles : [];
    }

    public static function roleName(): ?string
    {
        $roles = self::roles();
        return $roles[0] ?? ($_SESSION['role'] ?? null);
    }

    public static function currentPermissions(): array
    {
        $permissions = $_SESSION[self::SESSION_PERMISSIONS] ?? [];
        return is_array($permissions) ? $permissions : [];
    }

    public static function currentActorType(): ?string
    {
        return $_SESSION[self::SESSION_ACTOR_TYPE] ?? null;
    }

    public static function currentActorId(): ?int
    {
        return isset($_SESSION[self::SESSION_ACTOR_ID]) ? (int) $_SESSION[self::SESSION_ACTOR_ID] : null;
    }

    public static function roleIdByName(PDO $db, string $roleName): ?int
    {
        try {
            $stmt = $db->prepare("SELECT id FROM roles WHERE name = ? LIMIT 1");
            $stmt->execute([$roleName]);
            $roleId = $stmt->fetchColumn();

            return $roleId ? (int) $roleId : null;
        } catch (Throwable $e) {
            error_log('RBAC role lookup failed: ' . $e->getMessage());
            return null;
        }
    }

    private static function hasAuthenticatedActor(): bool
    {
        $type = $_SESSION[self::SESSION_ACTOR_TYPE] ?? null;
        $id = $_SESSION[self::SESSION_ACTOR_ID] ?? null;

        if ($type === 'admin') {
            return !empty($_SESSION['admin_id']) && (int) $_SESSION['admin_id'] === (int) $id;
        }

        if ($type === 'user') {
            return !empty($_SESSION['user_id']) && (int) $_SESSION['user_id'] === (int) $id;
        }

        return false;
    }

    private static function loadPermissions(PDO $db, string $actorType, int $actorId, $legacyRoleId): bool
    {
        try {
            $roles = self::fetchRoles($db, $actorType, $actorId, $legacyRoleId);
            if (empty($roles)) {
                self::clear();
                return false;
            }

            $roleIds = array_column($roles, 'id');
            $permissions = self::fetchPermissionsForRoles($db, $roleIds);

            $_SESSION[self::SESSION_ACTOR_TYPE] = $actorType;
            $_SESSION[self::SESSION_ACTOR_ID] = $actorId;
            $_SESSION[self::SESSION_ROLE_IDS] = $roleIds;
            $_SESSION[self::SESSION_ROLES] = array_column($roles, 'name');
            $_SESSION[self::SESSION_PERMISSIONS] = $permissions;
            $_SESSION['role'] = $_SESSION[self::SESSION_ROLES][0] ?? null;

            return true;
        } catch (Throwable $e) {
            error_log('RBAC permission load failed: ' . $e->getMessage());
            self::clear();
            return false;
        }
    }

    private static function fetchRoles(PDO $db, string $actorType, int $actorId, $legacyRoleId): array
    {
        if ($actorType === 'user') {
            $sql = "SELECT DISTINCT r.id, r.name
                    FROM roles r
                    JOIN user_roles ur ON ur.role_id = r.id
                    WHERE ur.user_id = ?
                    ORDER BY r.id";
            $stmt = $db->prepare($sql);
            $stmt->execute([$actorId]);
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($roles)) {
                return $roles;
            }
        }

        if ($legacyRoleId) {
            $stmt = $db->prepare("SELECT id, name FROM roles WHERE id = ? LIMIT 1");
            $stmt->execute([$legacyRoleId]);
            $role = $stmt->fetch(PDO::FETCH_ASSOC);
            return $role ? [$role] : [];
        }

        return [];
    }

    private static function fetchPermissionsForRoles(PDO $db, array $roleIds): array
    {
        if (empty($roleIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($roleIds), '?'));
        $sql = "SELECT DISTINCT p.name
                FROM permissions p
                JOIN role_permissions rp ON rp.permission_id = p.id
                WHERE rp.role_id IN ($placeholders)
                ORDER BY p.name";
        $stmt = $db->prepare($sql);
        $stmt->execute($roleIds);

        return array_values(array_filter($stmt->fetchAll(PDO::FETCH_COLUMN)));
    }

    private static function deny(?string $redirectUrl = null): void
    {
        $target = $redirectUrl ?: (defined('URLROOT') ? URLROOT . '/home' : '/');
        header('Location: ' . $target);
        exit();
    }
}

if (!function_exists('can')) {
    function can(string $permission): bool
    {
        return Authorization::hasPermission($permission);
    }
}

if (!function_exists('can_any')) {
    function can_any(array $permissions): bool
    {
        return Authorization::hasAnyPermission($permissions);
    }
}
