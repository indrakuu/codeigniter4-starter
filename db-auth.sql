-- -------------------------------------------------------------
-- TablePlus 6.3.2(586)
--
-- https://tableplus.com/
--
-- Database: codeigniter4-starter
-- Generation Time: 2025-03-08 00:19:34.6590
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE TABLE `auth_activation_attempts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `auth_groups` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `auth_groups_permissions` (
  `group_id` int unsigned NOT NULL DEFAULT '0',
  `permission_id` int unsigned NOT NULL DEFAULT '0',
  KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`) USING BTREE,
  KEY `group_id_permission_id` (`group_id`,`permission_id`) USING BTREE,
  CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `auth_groups_users` (
  `group_id` int unsigned NOT NULL DEFAULT '0',
  `user_id` int unsigned NOT NULL DEFAULT '0',
  KEY `auth_groups_users_user_id_foreign` (`user_id`) USING BTREE,
  KEY `group_id_user_id` (`group_id`,`user_id`) USING BTREE,
  CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `auth_logins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `email` (`email`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `auth_permissions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `auth_reset_attempts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `auth_tokens` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `hashedValidator` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `auth_tokens_user_id_foreign` (`user_id`) USING BTREE,
  KEY `selector` (`selector`) USING BTREE,
  CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `auth_users_permissions` (
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `permission_id` int unsigned NOT NULL DEFAULT '0',
  KEY `auth_users_permissions_permission_id_foreign` (`permission_id`) USING BTREE,
  KEY `user_id_permission_id` (`user_id`,`permission_id`) USING BTREE,
  CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `groups_menu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int unsigned NOT NULL DEFAULT '0',
  `menu_id` int unsigned NOT NULL DEFAULT '0',
  KEY `groups_menu_menu_id_foreign` (`menu_id`) USING BTREE,
  KEY `groups_menu_group_id_foreign` (`group_id`) USING BTREE,
  KEY `id_group_id_menu_id` (`id`,`group_id`,`menu_id`) USING BTREE,
  CONSTRAINT `groups_menu_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `groups_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `menus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `icon` varchar(55) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `route` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `sequence` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `class` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `namespace` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `username` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `reset_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status_message` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrators. The top of the food chain.'),
(2, 'member', 'Member everyday member.');

INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1);

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(1, 2),
(2, 1);

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(41, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 00:30:48', 1),
(42, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 00:43:58', 1),
(43, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 00:44:30', 1),
(44, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 00:52:13', 1),
(45, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 08:44:10', 1),
(46, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 08:44:58', 1),
(47, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 08:45:29', 1),
(48, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 08:48:09', 1),
(49, '127.0.0.1', 'admin', NULL, '2025-03-07 08:49:27', 0),
(50, '127.0.0.1', 'admin', NULL, '2025-03-07 08:50:15', 0),
(51, '127.0.0.1', 'admin', NULL, '2025-03-07 08:50:21', 0),
(52, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 08:50:25', 1),
(53, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 08:51:17', 1),
(54, '127.0.0.1', 'admin', NULL, '2025-03-07 08:52:42', 0),
(55, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 08:52:56', 1),
(56, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 09:06:48', 1),
(57, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 09:06:54', 1),
(58, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 09:47:39', 1),
(59, '127.0.0.1', 'admin', NULL, '2025-03-07 22:24:35', 0),
(60, '127.0.0.1', 'admin', NULL, '2025-03-07 22:24:45', 0),
(61, '127.0.0.1', 'admin', NULL, '2025-03-07 22:25:44', 0),
(62, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 22:26:07', 1),
(63, '127.0.0.1', 'admin@admin.com', 1, '2025-03-07 22:48:51', 1),
(64, '::1', 'admin@admin.com', 1, '2025-03-07 23:10:13', 1),
(65, '::1', 'admin@admin.com', 1, '2025-03-07 23:11:06', 1),
(66, '::1', 'admin@admin.com', 1, '2025-03-07 23:15:37', 1),
(67, '::1', 'admin@admin.com', 1, '2025-03-07 23:15:45', 1),
(68, '::1', 'admin@admin.com', 1, '2025-03-07 23:20:00', 1),
(69, '::1', 'admin@admin.com', 1, '2025-03-07 23:21:09', 1),
(70, '::1', 'admin@admin.com', 1, '2025-03-08 00:00:18', 1),
(71, '::1', 'admin@admin.com', 1, '2025-03-08 00:00:38', 1);

INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
(1, 'back-office', 'User can access to the administration panel.'),
(2, 'manage-user', 'User can create, delete or modify the users.'),
(3, 'role-permission', 'User can edit and define permissions for a role.'),
(4, 'menu-permission', 'User cand create, delete or modify the menu.');

INSERT INTO `auth_users_permissions` (`user_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2),
(2, 3),
(2, 4);

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

INSERT INTO `menus` (`id`, `parent_id`, `active`, `title`, `icon`, `route`, `sequence`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Profile', 'fas fa-user', '/dashboard/profile', 1, '2024-02-29 09:01:58', '2024-02-29 09:01:58'),
(2, 0, 1, 'User Management', 'fas fa-user-cog', '#', 2, '2024-02-29 09:01:58', '2024-02-29 09:01:58'),
(3, 2, 1, 'Role', 'fas fa-user-md', '/dashboard/role', 4, '2024-02-29 09:01:58', '2024-02-29 09:01:58'),
(4, 2, 1, 'User', 'fas fa-user-friends', '/dashboard/user', 3, '2024-02-29 09:01:58', '2024-02-29 09:01:58'),
(5, 2, 1, 'Permission', 'fas fa-user-tag', '/dashboard/permission', 5, '2024-02-29 09:01:58', '2024-02-29 09:01:58'),
(6, 0, 1, 'Menu', 'fas fa-list-ul', '/dashboard/menu', 6, '2024-02-29 09:01:58', '2024-02-29 09:01:58');

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1709172069, 1),
(2, '2024-02-22-023241', 'App\\Database\\Migrations\\CreateMenusTable', 'default', 'App', 1709172069, 1);

INSERT INTO `users` (`id`, `email`, `fullname`, `username`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin@admin.com', 'Admin', 'admin', '$2y$10$Y3FWw/aKpYnIZhPNnUn0X.S1nkHGxryt0c9xrce8mBTcKW2gT2w3S', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-02-29 09:01:57', '2025-03-08 00:02:19', NULL),
(2, 'user@user.com', 'User', 'user', '$2y$10$0DEZwfgwEVNkoCOMr9QVjOtYEgUyG3/jM6YKpEy/YWNz/jSoUB5l6', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2024-02-29 09:01:58', '2025-03-07 23:18:31', NULL);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;