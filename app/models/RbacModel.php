<?php

class RbacModel
{
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function getRoles(string $keyword = ''): array
    {
        $sql = "SELECT r.*,
                       COUNT(DISTINCT rp.permission_id) AS permission_count,
                       COUNT(DISTINCT ur.user_id) AS user_count
                FROM roles r
                LEFT JOIN role_permissions rp ON rp.role_id = r.id
                LEFT JOIN user_roles ur ON ur.role_id = r.id";
        $params = [];

        if ($keyword !== '') {
            $sql .= " WHERE r.name LIKE ? OR r.display_name LIKE ?";
            $params = ["%$keyword%", "%$keyword%"];
        }

        $sql .= " GROUP BY r.id ORDER BY r.name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoleById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM roles WHERE id = ?");
        $stmt->execute([$id]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        return $role ?: null;
    }

    public function createRole(array $data): bool
    {
        $name = $this->normalizeRoleName($data['name'] ?? '');
        $displayName = trim($data['display_name'] ?? '');
        if ($name === '' || $displayName === '') {
            return false;
        }

        $stmt = $this->db->prepare("INSERT INTO roles (name, display_name, description) VALUES (?, ?, ?)");
        return $stmt->execute([
            $name,
            $displayName,
            trim($data['description'] ?? ''),
        ]);
    }

    public function updateRole(int $id, array $data): bool
    {
        $role = $this->getRoleById($id);
        if (!$role) {
            return false;
        }

        $name = $this->isSystemRole($role['name'])
            ? $role['name']
            : $this->normalizeRoleName($data['name'] ?? '');
        $displayName = trim($data['display_name'] ?? '');
        if ($name === '' || $displayName === '') {
            return false;
        }

        $stmt = $this->db->prepare("UPDATE roles SET name = ?, display_name = ?, description = ? WHERE id = ?");
        return $stmt->execute([
            $name,
            $displayName,
            trim($data['description'] ?? ''),
            $id,
        ]);
    }

    public function deleteRole(int $id): bool
    {
        $role = $this->getRoleById($id);
        if (!$role || $this->isSystemRole($role['name'])) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM roles WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getPermissions(string $keyword = ''): array
    {
        $sql = "SELECT p.*, COUNT(DISTINCT rp.role_id) AS role_count
                FROM permissions p
                LEFT JOIN role_permissions rp ON rp.permission_id = p.id";
        $params = [];

        if ($keyword !== '') {
            $sql .= " WHERE p.name LIKE ? OR p.display_name LIKE ?";
            $params = ["%$keyword%", "%$keyword%"];
        }

        $sql .= " GROUP BY p.id ORDER BY p.name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPermissionById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM permissions WHERE id = ?");
        $stmt->execute([$id]);
        $permission = $stmt->fetch(PDO::FETCH_ASSOC);

        return $permission ?: null;
    }

    public function createPermission(array $data): bool
    {
        $name = $this->normalizePermissionName($data['name'] ?? '');
        $displayName = trim($data['display_name'] ?? '');
        if ($name === '' || $displayName === '') {
            return false;
        }

        $stmt = $this->db->prepare("INSERT INTO permissions (name, display_name, description) VALUES (?, ?, ?)");
        return $stmt->execute([
            $name,
            $displayName,
            trim($data['description'] ?? ''),
        ]);
    }

    public function updatePermission(int $id, array $data): bool
    {
        $permission = $this->getPermissionById($id);
        if (!$permission) {
            return false;
        }

        $name = $this->isSystemPermission($permission['name'])
            ? $permission['name']
            : $this->normalizePermissionName($data['name'] ?? '');
        $displayName = trim($data['display_name'] ?? '');
        if ($name === '' || $displayName === '') {
            return false;
        }

        $stmt = $this->db->prepare("UPDATE permissions SET name = ?, display_name = ?, description = ? WHERE id = ?");
        return $stmt->execute([
            $name,
            $displayName,
            trim($data['description'] ?? ''),
            $id,
        ]);
    }

    public function deletePermission(int $id): bool
    {
        $permission = $this->getPermissionById($id);
        if (!$permission || $this->isSystemPermission($permission['name'])) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM permissions WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getRolePermissionIds(int $roleId): array
    {
        $stmt = $this->db->prepare("SELECT permission_id FROM role_permissions WHERE role_id = ?");
        $stmt->execute([$roleId]);

        return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
    }

    public function syncRolePermissions(int $roleId, array $permissionIds): bool
    {
        $this->db->beginTransaction();
        try {
            $this->db->prepare("DELETE FROM role_permissions WHERE role_id = ?")->execute([$roleId]);

            $stmt = $this->db->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
            foreach (array_unique(array_map('intval', $permissionIds)) as $permissionId) {
                if ($permissionId > 0) {
                    $stmt->execute([$roleId, $permissionId]);
                }
            }

            $this->db->commit();
            return true;
        } catch (Throwable $e) {
            $this->db->rollBack();
            error_log('RBAC sync role permissions failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getUsersWithRoles(string $keyword = ''): array
    {
        $sql = "SELECT u.id, u.fullname, u.email, u.phone, u.created_at,
                       GROUP_CONCAT(r.name ORDER BY r.name SEPARATOR ', ') AS roles
                FROM users u
                LEFT JOIN user_roles ur ON ur.user_id = u.id
                LEFT JOIN roles r ON r.id = ur.role_id";
        $params = [];

        if ($keyword !== '') {
            $sql .= " WHERE u.fullname LIKE ? OR u.email LIKE ? OR u.phone LIKE ?";
            $params = ["%$keyword%", "%$keyword%", "%$keyword%"];
        }

        $sql .= " GROUP BY u.id ORDER BY u.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserRoleIds(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT role_id FROM user_roles WHERE user_id = ?");
        $stmt->execute([$userId]);

        return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
    }

    public function syncUserRoles(int $userId, array $roleIds): bool
    {
        $roleIds = array_values(array_unique(array_filter(array_map('intval', $roleIds))));
        if (empty($roleIds)) {
            return false;
        }

        $this->db->beginTransaction();
        try {
            $this->db->prepare("DELETE FROM user_roles WHERE user_id = ?")->execute([$userId]);

            $stmt = $this->db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
            foreach ($roleIds as $roleId) {
                $stmt->execute([$userId, $roleId]);
            }

            $primaryRoleId = $roleIds[0];
            $this->db->prepare("UPDATE users SET role_id = ? WHERE id = ?")->execute([$primaryRoleId, $userId]);

            $this->db->commit();
            return true;
        } catch (Throwable $e) {
            $this->db->rollBack();
            error_log('RBAC sync user roles failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getRoleMatrix(): array
    {
        $roles = $this->getRoles();
        $permissions = $this->getPermissions();

        $matrix = [];
        $stmt = $this->db->query("SELECT role_id, permission_id FROM role_permissions");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $matrix[(int) $row['role_id']][(int) $row['permission_id']] = true;
        }

        return [
            'roles' => $roles,
            'permissions' => $permissions,
            'matrix' => $matrix,
        ];
    }

    public function roleHasUsers(int $roleId): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM user_roles WHERE role_id = ?");
        $stmt->execute([$roleId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function permissionHasRoles(int $permissionId): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM role_permissions WHERE permission_id = ?");
        $stmt->execute([$permissionId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function normalizeRoleName(string $value): string
    {
        $value = strtoupper(trim($value));
        $value = preg_replace('/[^A-Z0-9_]/', '_', $value);
        $value = preg_replace('/_+/', '_', $value);
        return trim($value, '_');
    }

    private function normalizePermissionName(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9_]/', '_', $value);
        $value = preg_replace('/_+/', '_', $value);
        return trim($value, '_');
    }

    private function isSystemRole(string $name): bool
    {
        return in_array(strtoupper($name), ['ADMIN', 'USER'], true);
    }

    private function isSystemPermission(string $name): bool
    {
        return in_array($name, Permissions::ADMIN_AREA, true);
    }
}
