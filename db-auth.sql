-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table auth-myth.auth_activation_attempts: ~0 rows (approximately)

-- Dumping data for table auth-myth.auth_groups: ~0 rows (approximately)
INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
	(1, 'admin', 'Administrators. The top of the food chain.'),
	(2, 'member', 'Member everyday member.');

-- Dumping data for table auth-myth.auth_groups_permissions: ~5 rows (approximately)
INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(2, 1);

-- Dumping data for table auth-myth.auth_groups_users: ~0 rows (approximately)
INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
	(1, 1),
	(2, 1),
	(2, 2);

-- Dumping data for table auth-myth.auth_logins: ~0 rows (approximately)

-- Dumping data for table auth-myth.auth_permissions: ~0 rows (approximately)
INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
	(1, 'back-office', 'User can access to the administration panel.'),
	(2, 'manage-user', 'User can create, delete or modify the users.'),
	(3, 'role-permission', 'User can edit and define permissions for a role.'),
	(4, 'menu-permission', 'User cand create, delete or modify the menu.');

-- Dumping data for table auth-myth.auth_reset_attempts: ~0 rows (approximately)

-- Dumping data for table auth-myth.auth_tokens: ~0 rows (approximately)

-- Dumping data for table auth-myth.auth_users_permissions: ~0 rows (approximately)
INSERT INTO `auth_users_permissions` (`user_id`, `permission_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(2, 1);

-- Dumping data for table auth-myth.groups_menu: ~9 rows (approximately)
INSERT INTO `groups_menu` (`id`, `group_id`, `menu_id`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 1, 3),
	(4, 1, 4),
	(5, 1, 5),
	(6, 1, 6),
	(7, 2, 1),
	(8, 2, 2),
	(9, 2, 3);

-- Dumping data for table auth-myth.menus: ~0 rows (approximately)
INSERT INTO `menus` (`id`, `parent_id`, `active`, `title`, `icon`, `route`, `sequence`, `created_at`, `updated_at`) VALUES
	(1, 0, 1, 'Profile', 'fas fa-user', '/dashboard/profile', 1, '2024-02-29 09:01:58', '2024-02-29 09:01:58'),
	(2, 0, 1, 'User Management', 'fas fa-user-cog', '#', 2, '2024-02-29 09:01:58', '2024-02-29 09:01:58'),
	(3, 2, 1, 'Role', 'fas fa-user-md', '/dashboard/role', 3, '2024-02-29 09:01:58', '2024-02-29 09:01:58'),
	(4, 2, 1, 'User', 'fas fa-user-friends', '/dashboard/user', 4, '2024-02-29 09:01:58', '2024-02-29 09:01:58'),
	(5, 2, 1, 'Permission', 'fas fa-user-tag', '/dashboard/permission', 5, '2024-02-29 09:01:58', '2024-02-29 09:01:58'),
	(6, 0, 1, 'Menu', 'fas fa-list-ul', '/dashboard/menu', 6, '2024-02-29 09:01:58', '2024-02-29 09:01:58');

-- Dumping data for table auth-myth.migrations: ~1 rows (approximately)
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1709172069, 1),
	(2, '2024-02-22-023241', 'App\\Database\\Migrations\\CreateMenusTable', 'default', 'App', 1709172069, 1);

-- Dumping data for table auth-myth.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `email`, `fullname`, `username`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'admin@admin.com', 'Admin', 'admin', '$2y$10$Y3FWw/aKpYnIZhPNnUn0X.S1nkHGxryt0c9xrce8mBTcKW2gT2w3S', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-02-29 09:01:57', '2024-02-29 09:01:57', NULL),
	(2, 'user@user.com', 'User', 'user', '$2y$10$0DEZwfgwEVNkoCOMr9QVjOtYEgUyG3/jM6YKpEy/YWNz/jSoUB5l6', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-02-29 09:01:58', '2024-02-29 09:01:58', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
