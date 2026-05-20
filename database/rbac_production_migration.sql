-- Production RBAC hardening migration for xayabury_travel.
-- Run after database/rbac_migration.sql. Safe to run more than once on MySQL 8+.

START TRANSACTION;

UPDATE roles SET name = 'ADMIN', display_name = 'Admin'
WHERE LOWER(name) = 'admin';

UPDATE roles SET name = 'USER', display_name = 'User'
WHERE LOWER(name) IN ('customer', 'member');

INSERT INTO roles (name, display_name, description) VALUES
('USER', 'User', 'Default application user'),
('ADMIN', 'Admin', 'Full administrative access')
ON DUPLICATE KEY UPDATE
    display_name = VALUES(display_name),
    description = VALUES(description);

INSERT INTO permissions (name, display_name, description) VALUES
('view_dashboard', 'View Dashboard', 'Access admin dashboard'),
('manage_users', 'Manage Users', 'Create, read, update and delete users'),
('manage_roles', 'Manage Roles', 'Create, read, update and delete roles'),
('manage_permissions', 'Manage Permissions', 'Create, read, update and delete permissions'),
('manage_places', 'Manage Places', 'Create, read, update and delete destinations'),
('manage_hotels', 'Manage Hotels', 'Create, read, update and delete hotels'),
('manage_bookings', 'Manage Bookings', 'Review, approve and delete bookings'),
('approve_posts', 'Approve Posts', 'Approve forum posts and reviews'),
('delete_posts', 'Delete Posts', 'Delete forum posts and reviews'),
('manage_contacts', 'Manage Contacts', 'View and delete contact/help requests')
ON DUPLICATE KEY UPDATE
    display_name = VALUES(display_name),
    description = VALUES(description);

SET @admin_role_id = (SELECT id FROM roles WHERE name = 'ADMIN' LIMIT 1);
SET @user_role_id = (SELECT id FROM roles WHERE name = 'USER' LIMIT 1);

INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT @admin_role_id, p.id
FROM permissions p;

INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r
JOIN permissions p
WHERE LOWER(r.name) = 'super_admin';

UPDATE admin SET role_id = @admin_role_id WHERE role_id IS NULL;
UPDATE users SET role_id = @user_role_id WHERE role_id IS NULL;

CREATE TABLE IF NOT EXISTS user_roles (
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, role_id),
    KEY idx_user_roles_role_id (role_id),
    CONSTRAINT fk_user_roles_user
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_user_roles_role
        FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT IGNORE INTO user_roles (user_id, role_id)
SELECT id, role_id
FROM users
WHERE role_id IS NOT NULL;

SET @users_role_null_count = (SELECT COUNT(*) FROM users WHERE role_id IS NULL);
SET @sql = IF(
    @users_role_null_count = 0,
    'ALTER TABLE users MODIFY role_id INT NOT NULL',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @admin_role_null_count = (SELECT COUNT(*) FROM admin WHERE role_id IS NULL);
SET @sql = IF(
    @admin_role_null_count = 0,
    'ALTER TABLE admin MODIFY role_id INT NOT NULL',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

COMMIT;
