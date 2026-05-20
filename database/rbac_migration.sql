-- RBAC migration for xayabury_travel.
-- Safe to run more than once on MySQL 8+.
-- Existing users/admin records are preserved and mapped to default roles.

START TRANSACTION;

CREATE TABLE IF NOT EXISTS roles (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    display_name VARCHAR(100) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_roles_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS permissions (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    display_name VARCHAR(150) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_permissions_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (role_id, permission_id),
    KEY idx_role_permissions_permission_id (permission_id),
    CONSTRAINT fk_role_permissions_role
        FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE,
    CONSTRAINT fk_role_permissions_permission
        FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO roles (name, display_name, description) VALUES
('super_admin', 'Super Admin', 'Full system access'),
('admin', 'Admin', 'Administrative access for travel operations'),
('moderator', 'Moderator', 'Forum moderation access'),
('editor', 'Editor', 'Content management access'),
('support', 'Support', 'Booking and contact support access'),
('customer', 'Customer', 'Default registered customer role')
ON DUPLICATE KEY UPDATE
    display_name = VALUES(display_name),
    description = VALUES(description);

INSERT INTO permissions (name, display_name, description) VALUES
('view_dashboard', 'View Dashboard', 'Access admin dashboard'),
('manage_users', 'Manage Users', 'Create, read, update and delete users'),
('manage_places', 'Manage Places', 'Create, read, update and delete destinations'),
('manage_hotels', 'Manage Hotels', 'Create, read, update and delete hotels'),
('manage_bookings', 'Manage Bookings', 'Review, approve and delete bookings'),
('approve_posts', 'Approve Posts', 'Approve forum posts and reviews'),
('delete_posts', 'Delete Posts', 'Delete forum posts and reviews'),
('manage_contacts', 'Manage Contacts', 'View and delete contact/help requests')
ON DUPLICATE KEY UPDATE
    display_name = VALUES(display_name),
    description = VALUES(description);

INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r
JOIN permissions p
WHERE r.name = 'super_admin';

INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r
JOIN permissions p ON p.name IN (
    'view_dashboard',
    'manage_users',
    'manage_places',
    'manage_hotels',
    'manage_bookings',
    'approve_posts',
    'delete_posts',
    'manage_contacts'
)
WHERE r.name = 'admin';

INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r
JOIN permissions p ON p.name IN ('view_dashboard', 'approve_posts', 'delete_posts')
WHERE r.name = 'moderator';

INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r
JOIN permissions p ON p.name IN ('view_dashboard', 'manage_places', 'manage_hotels')
WHERE r.name = 'editor';

INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r
JOIN permissions p ON p.name IN ('view_dashboard', 'manage_bookings', 'manage_contacts')
WHERE r.name = 'support';

SET @admin_role_id = (SELECT id FROM roles WHERE name = 'admin' LIMIT 1);
SET @customer_role_id = (SELECT id FROM roles WHERE name = 'customer' LIMIT 1);

SET @admin_role_column_exists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'admin'
      AND COLUMN_NAME = 'role_id'
);
SET @sql = IF(
    @admin_role_column_exists = 0,
    'ALTER TABLE admin ADD COLUMN role_id INT NULL AFTER fullname',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @users_role_column_exists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'users'
      AND COLUMN_NAME = 'role_id'
);
SET @sql = IF(
    @users_role_column_exists = 0,
    'ALTER TABLE users ADD COLUMN role_id INT NULL AFTER password',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

UPDATE admin SET role_id = @admin_role_id WHERE role_id IS NULL;
UPDATE users SET role_id = @customer_role_id WHERE role_id IS NULL;

SET @admin_role_index_exists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'admin'
      AND INDEX_NAME = 'idx_admin_role_id'
);
SET @sql = IF(
    @admin_role_index_exists = 0,
    'CREATE INDEX idx_admin_role_id ON admin (role_id)',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @users_role_index_exists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'users'
      AND INDEX_NAME = 'idx_users_role_id'
);
SET @sql = IF(
    @users_role_index_exists = 0,
    'CREATE INDEX idx_users_role_id ON users (role_id)',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @admin_role_fk_exists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'admin'
      AND CONSTRAINT_NAME = 'fk_admin_role'
      AND CONSTRAINT_TYPE = 'FOREIGN KEY'
);
SET @sql = IF(
    @admin_role_fk_exists = 0,
    'ALTER TABLE admin ADD CONSTRAINT fk_admin_role FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE RESTRICT ON UPDATE CASCADE',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @users_role_fk_exists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'users'
      AND CONSTRAINT_NAME = 'fk_users_role'
      AND CONSTRAINT_TYPE = 'FOREIGN KEY'
);
SET @sql = IF(
    @users_role_fk_exists = 0,
    'ALTER TABLE users ADD CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE RESTRICT ON UPDATE CASCADE',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

COMMIT;
