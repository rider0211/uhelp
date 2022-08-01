/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100418
 Source Host           : localhost:3306
 Source Schema         : copypet

 Target Server Type    : MySQL
 Target Server Version : 100418
 File Encoding         : 65001

 Date: 31/07/2022 12:07:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for activations
-- ----------------------------
DROP TABLE IF EXISTS `activations`;
CREATE TABLE `activations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` datetime(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `activations_user_id_index`(`user_id`) USING BTREE,
  CONSTRAINT `activations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of activations
-- ----------------------------
INSERT INTO `activations` VALUES (1, 1, 'd7bT3mjoPXRzhFtk3E9CF1aQOzYYiRPT', 1, '2022-07-22 15:33:35', '2022-07-22 15:33:35', '2022-07-22 15:33:35');

-- ----------------------------
-- Table structure for activity_log
-- ----------------------------
DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE `activity_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` int(11) NULL DEFAULT NULL,
  `subject_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `causer_id` int(11) NULL DEFAULT NULL,
  `causer_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `properties` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `activity_log_log_name_index`(`log_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of activity_log
-- ----------------------------
INSERT INTO `activity_log` VALUES (1, 'user', 'login', 1, 'Modules\\User\\Entities\\User', 1, 'Modules\\User\\Entities\\User', '{\"subject\":{\"id\":1,\"first_name\":\"Ryan\",\"last_name\":\"Blake\",\"username\":\"ryanblake\",\"email\":\"lamskills113@gmail.com\",\"permissions\":null,\"last_login\":\"2022-07-22T15:34:29.000000Z\",\"about\":null,\"facebook\":null,\"twitter\":null,\"google\":null,\"instagram\":null,\"linkedin\":null,\"youtube\":null,\"created_at\":\"2022-07-22T15:33:35.000000Z\",\"updated_at\":\"2022-07-22T15:34:29.000000Z\",\"full_name\":\"Ryan Blake\"},\"causer\":{\"id\":1,\"first_name\":\"Ryan\",\"last_name\":\"Blake\",\"username\":\"ryanblake\",\"email\":\"lamskills113@gmail.com\",\"permissions\":null,\"last_login\":\"2022-07-22T15:34:29.000000Z\",\"about\":null,\"facebook\":null,\"twitter\":null,\"google\":null,\"instagram\":null,\"linkedin\":null,\"youtube\":null,\"created_at\":\"2022-07-22T15:33:35.000000Z\",\"updated_at\":\"2022-07-22T15:34:29.000000Z\",\"full_name\":\"Ryan Blake\"}}', '2022-07-22 15:34:29', '2022-07-22 15:34:29');
INSERT INTO `activity_log` VALUES (2, 'user', 'login', 1, 'Modules\\User\\Entities\\User', 1, 'Modules\\User\\Entities\\User', '{\"subject\":{\"id\":1,\"first_name\":\"Ryan\",\"last_name\":\"Blake\",\"username\":\"ryanblake\",\"email\":\"lamskills113@gmail.com\",\"permissions\":null,\"last_login\":\"2022-07-22T15:38:25.000000Z\",\"about\":null,\"facebook\":null,\"twitter\":null,\"google\":null,\"instagram\":null,\"linkedin\":null,\"youtube\":null,\"created_at\":\"2022-07-22T15:33:35.000000Z\",\"updated_at\":\"2022-07-22T15:38:25.000000Z\",\"full_name\":\"Ryan Blake\"},\"causer\":{\"id\":1,\"first_name\":\"Ryan\",\"last_name\":\"Blake\",\"username\":\"ryanblake\",\"email\":\"lamskills113@gmail.com\",\"permissions\":null,\"last_login\":\"2022-07-22T15:38:25.000000Z\",\"about\":null,\"facebook\":null,\"twitter\":null,\"google\":null,\"instagram\":null,\"linkedin\":null,\"youtube\":null,\"created_at\":\"2022-07-22T15:33:35.000000Z\",\"updated_at\":\"2022-07-22T15:38:25.000000Z\",\"full_name\":\"Ryan Blake\"}}', '2022-07-22 15:38:25', '2022-07-22 15:38:25');

-- ----------------------------
-- Table structure for author_translations
-- ----------------------------
DROP TABLE IF EXISTS `author_translations`;
CREATE TABLE `author_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `author_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `author_translations_author_id_locale_unique`(`author_id`, `locale`) USING BTREE,
  CONSTRAINT `author_translations_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for authors
-- ----------------------------
DROP TABLE IF EXISTS `authors`;
CREATE TABLE `authors`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `authors_slug_unique`(`slug`) USING BTREE,
  INDEX `authors_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `authors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(10) UNSIGNED NULL DEFAULT NULL,
  `is_searchable` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `categories_slug_unique`(`slug`) USING BTREE,
  INDEX `categories_parent_id_foreign`(`parent_id`) USING BTREE,
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for category_translations
-- ----------------------------
DROP TABLE IF EXISTS `category_translations`;
CREATE TABLE `category_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `category_translations_category_id_locale_unique`(`category_id`, `locale`) USING BTREE,
  CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `commenter_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `commenter_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `guest_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `guest_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `commentable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 1,
  `child_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `comments_commenter_id_commenter_type_index`(`commenter_id`, `commenter_type`) USING BTREE,
  INDEX `comments_commentable_type_commentable_id_index`(`commentable_type`, `commentable_id`) USING BTREE,
  INDEX `comments_child_id_foreign`(`child_id`) USING BTREE,
  CONSTRAINT `comments_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ebook_authors
-- ----------------------------
DROP TABLE IF EXISTS `ebook_authors`;
CREATE TABLE `ebook_authors`  (
  `ebook_id` int(10) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ebook_id`, `author_id`) USING BTREE,
  INDEX `ebook_authors_author_id_foreign`(`author_id`) USING BTREE,
  CONSTRAINT `ebook_authors_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `ebook_authors_ebook_id_foreign` FOREIGN KEY (`ebook_id`) REFERENCES `ebooks` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ebook_categories
-- ----------------------------
DROP TABLE IF EXISTS `ebook_categories`;
CREATE TABLE `ebook_categories`  (
  `ebook_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ebook_id`, `category_id`) USING BTREE,
  INDEX `ebook_categories_category_id_foreign`(`category_id`) USING BTREE,
  CONSTRAINT `ebook_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `ebook_categories_ebook_id_foreign` FOREIGN KEY (`ebook_id`) REFERENCES `ebooks` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ebook_translations
-- ----------------------------
DROP TABLE IF EXISTS `ebook_translations`;
CREATE TABLE `ebook_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ebook_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `publisher` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `ebook_translations_ebook_id_locale_unique`(`ebook_id`, `locale`) USING BTREE,
  FULLTEXT INDEX `title`(`title`),
  CONSTRAINT `ebook_translations_ebook_id_foreign` FOREIGN KEY (`ebook_id`) REFERENCES `ebooks` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ebooks
-- ----------------------------
DROP TABLE IF EXISTS `ebooks`;
CREATE TABLE `ebooks`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `file_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `embed_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `isbn` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `price` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `buy_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `publication_year` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `viewed` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `download` int(11) NOT NULL DEFAULT 0,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `is_private` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `ebooks_slug_unique`(`slug`) USING BTREE,
  INDEX `ebooks_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `ebooks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for entity_files
-- ----------------------------
DROP TABLE IF EXISTS `entity_files`;
CREATE TABLE `entity_files`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `files_id` int(10) UNSIGNED NOT NULL,
  `entity_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_id` bigint(20) UNSIGNED NOT NULL,
  `zone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `entity_files_entity_type_entity_id_index`(`entity_type`, `entity_id`) USING BTREE,
  INDEX `entity_files_files_id_index`(`files_id`) USING BTREE,
  INDEX `entity_files_zone_index`(`zone`) USING BTREE,
  CONSTRAINT `entity_files_files_id_foreign` FOREIGN KEY (`files_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for favorite_lists
-- ----------------------------
DROP TABLE IF EXISTS `favorite_lists`;
CREATE TABLE `favorite_lists`  (
  `user_id` int(10) UNSIGNED NOT NULL,
  `ebook_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`, `ebook_id`) USING BTREE,
  INDEX `favorite_lists_ebook_id_foreign`(`ebook_id`) USING BTREE,
  CONSTRAINT `favorite_lists_ebook_id_foreign` FOREIGN KEY (`ebook_id`) REFERENCES `ebooks` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `favorite_lists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for files
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `download` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `files_user_id_index`(`user_id`) USING BTREE,
  INDEX `files_filename_index`(`filename`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for menu_item_translations
-- ----------------------------
DROP TABLE IF EXISTS `menu_item_translations`;
CREATE TABLE `menu_item_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_item_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `menu_item_translations_menu_item_id_locale_unique`(`menu_item_id`, `locale`) USING BTREE,
  CONSTRAINT `menu_item_translations_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for menu_items
-- ----------------------------
DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE `menu_items`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `category_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `page_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `target` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(10) UNSIGNED NULL DEFAULT NULL,
  `is_root` tinyint(1) NOT NULL DEFAULT 0,
  `is_fluid` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_items_parent_id_foreign`(`parent_id`) USING BTREE,
  INDEX `menu_items_page_id_foreign`(`page_id`) USING BTREE,
  INDEX `menu_items_menu_id_index`(`menu_id`) USING BTREE,
  CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `menu_items_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for menu_translations
-- ----------------------------
DROP TABLE IF EXISTS `menu_translations`;
CREATE TABLE `menu_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `menu_translations_menu_id_locale_unique`(`menu_id`, `locale`) USING BTREE,
  CONSTRAINT `menu_translations_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for meta_data
-- ----------------------------
DROP TABLE IF EXISTS `meta_data`;
CREATE TABLE `meta_data`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `entity_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `meta_data_entity_type_entity_id_index`(`entity_type`, `entity_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for meta_data_translations
-- ----------------------------
DROP TABLE IF EXISTS `meta_data_translations`;
CREATE TABLE `meta_data_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `meta_data_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `meta_data_translations_meta_data_id_locale_unique`(`meta_data_id`, `locale`) USING BTREE,
  CONSTRAINT `meta_data_translations_meta_data_id_foreign` FOREIGN KEY (`meta_data_id`) REFERENCES `meta_data` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2018_06_30_113500_create_comments_table', 1);
INSERT INTO `migrations` VALUES (2, '2019_08_24_104134_create_sliders_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_24_105134_create_slider_translations_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_08_24_105234_create_slider_slides_table', 1);
INSERT INTO `migrations` VALUES (5, '2019_08_24_105534_create_slider_slide_translations_table', 1);
INSERT INTO `migrations` VALUES (6, '2019_08_30_061505_create_pages_table', 1);
INSERT INTO `migrations` VALUES (7, '2019_08_30_061505_create_settings_table', 1);
INSERT INTO `migrations` VALUES (8, '2019_08_30_061605_create_page_translations_table', 1);
INSERT INTO `migrations` VALUES (9, '2019_08_30_061712_create_setting_translations_table', 1);
INSERT INTO `migrations` VALUES (10, '2019_08_30_102225_create_translations_table', 1);
INSERT INTO `migrations` VALUES (11, '2019_08_30_102429_create_translation_translations_table', 1);
INSERT INTO `migrations` VALUES (12, '2019_09_01_061505_create_meta_data_table', 1);
INSERT INTO `migrations` VALUES (13, '2019_09_01_061605_create_meta_data_translations_table', 1);
INSERT INTO `migrations` VALUES (14, '2019_09_01_160015_create_menus_table', 1);
INSERT INTO `migrations` VALUES (15, '2019_09_01_160138_create_menu_translations_table', 1);
INSERT INTO `migrations` VALUES (16, '2019_09_01_160753_create_menu_items_table', 1);
INSERT INTO `migrations` VALUES (17, '2019_09_01_160804_create_menu_item_translation_table', 1);
INSERT INTO `migrations` VALUES (18, '2019_09_17_083103_migration_cartalyst_sentinel', 1);
INSERT INTO `migrations` VALUES (19, '2019_09_24_054528_create_activity_log_table', 1);
INSERT INTO `migrations` VALUES (20, '2019_09_24_104134_create_files_table', 1);
INSERT INTO `migrations` VALUES (21, '2019_09_25_083103_create_authors_table', 1);
INSERT INTO `migrations` VALUES (22, '2019_09_25_083103_create_categories_table', 1);
INSERT INTO `migrations` VALUES (23, '2019_09_25_092538_add_fields_to_users_table', 1);
INSERT INTO `migrations` VALUES (24, '2019_09_25_092538_create_author_translations_table', 1);
INSERT INTO `migrations` VALUES (25, '2019_09_25_092538_create_category_translations_table', 1);
INSERT INTO `migrations` VALUES (26, '2019_09_25_104134_create_entity_files_table', 1);
INSERT INTO `migrations` VALUES (27, '2019_10_24_163159_create_ebooks_table', 1);
INSERT INTO `migrations` VALUES (28, '2019_10_24_163222_create_ebook_translations_table', 1);
INSERT INTO `migrations` VALUES (29, '2019_10_24_163319_create_ebook_authors_table', 1);
INSERT INTO `migrations` VALUES (30, '2019_10_24_163319_create_ebook_categories_table', 1);
INSERT INTO `migrations` VALUES (31, '2019_10_25_163159_create_favorite_lists_table', 1);
INSERT INTO `migrations` VALUES (32, '2019_10_25_163159_create_reviews_table', 1);
INSERT INTO `migrations` VALUES (33, '2019_10_27_182852_create_reported_ebooks_table', 1);
INSERT INTO `migrations` VALUES (34, '2020_04_07_102818_add_more_fields_to_ebooks_table', 1);
INSERT INTO `migrations` VALUES (35, '2020_05_11_085648_add_file_type_embed_code_fields_to_ebooks_table', 1);
INSERT INTO `migrations` VALUES (36, '2020_06_14_120806_add_download_field_to_ebooks_table', 1);

-- ----------------------------
-- Table structure for page_translations
-- ----------------------------
DROP TABLE IF EXISTS `page_translations`;
CREATE TABLE `page_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `page_translations_page_id_locale_unique`(`page_id`, `locale`) USING BTREE,
  CONSTRAINT `page_translations_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `pages_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for persistences
-- ----------------------------
DROP TABLE IF EXISTS `persistences`;
CREATE TABLE `persistences`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `persistences_code_unique`(`code`) USING BTREE,
  INDEX `persistences_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `persistences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of persistences
-- ----------------------------
INSERT INTO `persistences` VALUES (2, 1, 'r2aN483vusqxwbtdTpIfr5CY2aLuSAnG', '2022-07-22 15:38:25', '2022-07-22 15:38:25');

-- ----------------------------
-- Table structure for reminders
-- ----------------------------
DROP TABLE IF EXISTS `reminders`;
CREATE TABLE `reminders`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` datetime(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `reminders_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `reminders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reported_ebooks
-- ----------------------------
DROP TABLE IF EXISTS `reported_ebooks`;
CREATE TABLE `reported_ebooks`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ebook_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `reported_ebooks_ebook_id_foreign`(`ebook_id`) USING BTREE,
  INDEX `reported_ebooks_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `reported_ebooks_ebook_id_foreign` FOREIGN KEY (`ebook_id`) REFERENCES `ebooks` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `reported_ebooks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reviews
-- ----------------------------
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reviewer_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `ebook_id` int(10) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `reviewer_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `reviews_reviewer_id_index`(`reviewer_id`) USING BTREE,
  INDEX `reviews_ebook_id_index`(`ebook_id`) USING BTREE,
  CONSTRAINT `reviews_ebook_id_foreign` FOREIGN KEY (`ebook_id`) REFERENCES `ebooks` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'admin', 'Admin', '{\"admin.users.index\":true,\"admin.users.create\":true,\"admin.users.edit\":true,\"admin.users.destroy\":true,\"admin.roles.index\":true,\"admin.roles.create\":true,\"admin.roles.edit\":true,\"admin.roles.destroy\":true,\"admin.menus.index\":true,\"admin.menus.create\":true,\"admin.menus.edit\":true,\"admin.menus.destroy\":true,\"admin.menu_items.index\":true,\"admin.menu_items.create\":true,\"admin.menu_items.edit\":true,\"admin.menu_items.destroy\":true,\"admin.files.index\":true,\"admin.files.create\":true,\"admin.files.destroy\":true,\"admin.pages.index\":true,\"admin.pages.create\":true,\"admin.pages.edit\":true,\"admin.pages.destroy\":true,\"admin.translations.index\":true,\"admin.translations.edit\":true,\"admin.settings.edit\":true,\"admin.ebooks.index\":true,\"admin.ebooks.create\":true,\"admin.ebooks.edit\":true,\"admin.ebooks.destroy\":true,\"admin.reportedebooks.index\":true,\"admin.reportedebooks.destroy\":true,\"admin.reviews.index\":true,\"admin.reviews.create\":true,\"admin.reviews.edit\":true,\"admin.reviews.destroy\":true,\"admin.importer.index\":true,\"admin.importer.create\":true,\"admin.sliders.index\":true,\"admin.sliders.create\":true,\"admin.sliders.edit\":true,\"admin.sliders.destroy\":true,\"admin.categories.index\":true,\"admin.categories.create\":true,\"admin.categories.edit\":true,\"admin.categories.destroy\":true,\"admin.authors.index\":true,\"admin.authors.create\":true,\"admin.authors.edit\":true,\"admin.authors.destroy\":true,\"admin.activity.index\":true,\"admin.cynoebook.edit\":true}', '2022-07-22 15:33:34', '2022-07-22 15:33:34');
INSERT INTO `roles` VALUES (2, 'user', 'User', '[]', '2022-07-22 15:33:36', '2022-07-22 15:33:36');

-- ----------------------------
-- Table structure for setting_translations
-- ----------------------------
DROP TABLE IF EXISTS `setting_translations`;
CREATE TABLE `setting_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `setting_translations_setting_id_locale_unique`(`setting_id`, `locale`) USING BTREE,
  CONSTRAINT `setting_translations_setting_id_foreign` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of setting_translations
-- ----------------------------
INSERT INTO `setting_translations` VALUES (1, 1, 'en', 's:11:\"CopyMyPooch\";');
INSERT INTO `setting_translations` VALUES (2, 30, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (3, 31, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (4, 32, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (5, 19, 'en', 's:61:\"Copyright © {{ site_name }} {{ year }}. All rights reserved.\";');
INSERT INTO `setting_translations` VALUES (6, 33, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (7, 34, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (8, 35, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (9, 36, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (10, 37, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (11, 38, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (12, 39, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (13, 40, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (14, 41, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (15, 42, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (16, 43, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (17, 44, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (18, 45, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (19, 46, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (20, 47, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (21, 48, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (22, 49, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (23, 50, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (24, 51, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (25, 52, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (26, 53, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (27, 54, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (28, 55, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (29, 110, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (30, 111, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (31, 112, 'en', 'N;');
INSERT INTO `setting_translations` VALUES (32, 113, 'en', 'N;');

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plainValue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `isTranslatable` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `settings_name_unique`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 116 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'site_name', NULL, 1, '2022-07-22 15:33:35', '2022-07-22 15:33:35');
INSERT INTO `settings` VALUES (2, 'site_email', 's:23:\"support@copymypooch.com\";', 0, '2022-07-22 15:33:36', '2022-07-22 15:33:36');
INSERT INTO `settings` VALUES (3, 'active_theme', 's:9:\"Cynoebook\";', 0, '2022-07-22 15:33:36', '2022-07-22 15:33:36');
INSERT INTO `settings` VALUES (4, 'supported_locales', 'a:1:{i:0;s:2:\"en\";}', 0, '2022-07-22 15:33:36', '2022-07-22 15:33:36');
INSERT INTO `settings` VALUES (5, 'default_locale', 's:2:\"en\";', 0, '2022-07-22 15:33:36', '2022-07-22 15:33:36');
INSERT INTO `settings` VALUES (6, 'default_timezone', 's:3:\"UTC\";', 0, '2022-07-22 15:33:36', '2022-07-22 15:33:36');
INSERT INTO `settings` VALUES (7, 'user_role', 's:1:\"2\";', 0, '2022-07-22 15:33:36', '2022-07-22 15:33:36');
INSERT INTO `settings` VALUES (8, 'auto_approve_user', 's:1:\"1\";', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (9, 'cookie_bar_enabled', 's:1:\"1\";', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (10, 'enable_comment', 's:1:\"1\";', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (11, 'member_only_reading_books', 's:1:\"0\";', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (12, 'enable_ebook_report', 'b:1;', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (13, 'enable_ebook_print', 'b:1;', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (14, 'enable_ebook_download', 'b:1;', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (15, 'enable_ebook_upload', 'b:1;', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (16, 'enable_registrations', 'b:1;', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (17, 'reviews_enabled', 'b:1;', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (18, 'auto_approve_reviews', 'b:1;', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (19, 'cynoebook_copyright_text', 's:61:\"Copyright © {{ site_name }} {{ year }}. All rights reserved.\";', 1, '2022-07-22 15:33:37', '2022-07-22 15:59:02');
INSERT INTO `settings` VALUES (20, 'allowed_file_types', 'a:7:{i:0;s:3:\"pdf\";i:1;s:4:\"epub\";i:2;s:4:\"docx\";i:3;s:3:\"doc\";i:4;s:3:\"txt\";i:5;s:3:\"mp3\";i:6;s:3:\"wav\";}', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (21, 'theme_logo_header_color', 's:4:\"blue\";', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (22, 'theme_navbar_header_color', 's:5:\"blue2\";', 0, '2022-07-22 15:33:37', '2022-07-22 15:33:37');
INSERT INTO `settings` VALUES (23, 'theme_sidebar_color', 's:5:\"white\";', 0, '2022-07-22 15:33:38', '2022-07-22 15:33:38');
INSERT INTO `settings` VALUES (24, 'theme_background_color', 's:3:\"bg1\";', 0, '2022-07-22 15:33:38', '2022-07-22 15:33:38');
INSERT INTO `settings` VALUES (25, 'cynoebook_theme', 's:17:\"theme-marrs-green\";', 0, '2022-07-22 15:59:00', '2022-07-22 15:59:42');
INSERT INTO `settings` VALUES (26, 'cynoebook_mail_theme', 's:11:\"theme-black\";', 0, '2022-07-22 15:59:00', '2022-07-22 15:59:00');
INSERT INTO `settings` VALUES (27, 'cynoebook_layout', 's:7:\"default\";', 0, '2022-07-22 15:59:00', '2022-07-22 15:59:00');
INSERT INTO `settings` VALUES (28, 'cynoebook_slider', 'N;', 0, '2022-07-22 15:59:00', '2022-07-22 15:59:00');
INSERT INTO `settings` VALUES (29, 'cynoebook_privacy_page', 'N;', 0, '2022-07-22 15:59:00', '2022-07-22 15:59:00');
INSERT INTO `settings` VALUES (30, 'cynoebook_footer_summary', NULL, 1, '2022-07-22 15:59:00', '2022-07-22 15:59:00');
INSERT INTO `settings` VALUES (31, 'cynoebook_footer_two_title', NULL, 1, '2022-07-22 15:59:01', '2022-07-22 15:59:01');
INSERT INTO `settings` VALUES (32, 'cynoebook_footer_two', NULL, 1, '2022-07-22 15:59:01', '2022-07-22 15:59:01');
INSERT INTO `settings` VALUES (33, 'cynoebook_category_menu_title', NULL, 1, '2022-07-22 15:59:02', '2022-07-22 15:59:02');
INSERT INTO `settings` VALUES (34, 'cynoebook_footer_menu_title_1', NULL, 1, '2022-07-22 15:59:02', '2022-07-22 15:59:02');
INSERT INTO `settings` VALUES (35, 'cynoebook_footer_menu_title_2', NULL, 1, '2022-07-22 15:59:02', '2022-07-22 15:59:02');
INSERT INTO `settings` VALUES (36, 'contact_info', NULL, 1, '2022-07-22 15:59:02', '2022-07-22 15:59:02');
INSERT INTO `settings` VALUES (37, 'cynoebook_featured_ebooks_section_title', NULL, 1, '2022-07-22 15:59:02', '2022-07-22 15:59:02');
INSERT INTO `settings` VALUES (38, 'cynoebook_popular_ebooks_section_title', NULL, 1, '2022-07-22 15:59:02', '2022-07-22 15:59:02');
INSERT INTO `settings` VALUES (39, 'cynoebook_banner_section_1_banner_file_id', NULL, 1, '2022-07-22 15:59:02', '2022-07-22 15:59:02');
INSERT INTO `settings` VALUES (40, 'cynoebook_banner_section_1_banner_caption_1', NULL, 1, '2022-07-22 15:59:02', '2022-07-22 15:59:02');
INSERT INTO `settings` VALUES (41, 'cynoebook_banner_section_1_banner_caption_2', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (42, 'cynoebook_banner_section_1_banner_call_to_action_text', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (43, 'cynoebook_authors_section_title', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (44, 'cynoebook_recent_ebooks_section_title', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (45, 'cynoebook_banner_section_2_banner_file_id', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (46, 'cynoebook_banner_section_2_banner_caption_1', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (47, 'cynoebook_banner_section_2_banner_caption_2', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (48, 'cynoebook_banner_section_2_banner_call_to_action_text', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (49, 'cynoebook_category_tabs_section_title', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (50, 'cynoebook_category_tabs_section_tab_1_title', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (51, 'cynoebook_category_tabs_section_tab_2_title', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (52, 'cynoebook_category_tabs_section_tab_3_title', NULL, 1, '2022-07-22 15:59:03', '2022-07-22 15:59:03');
INSERT INTO `settings` VALUES (53, 'cynoebook_category_tabs_section_tab_4_title', NULL, 1, '2022-07-22 15:59:04', '2022-07-22 15:59:04');
INSERT INTO `settings` VALUES (54, 'cynoebook_category_tabs_section_tab_5_title', NULL, 1, '2022-07-22 15:59:04', '2022-07-22 15:59:04');
INSERT INTO `settings` VALUES (55, 'cynoebook_users_section_title', NULL, 1, '2022-07-22 15:59:04', '2022-07-22 15:59:04');
INSERT INTO `settings` VALUES (56, 'cynoebook_primary_menu', 'N;', 0, '2022-07-22 15:59:04', '2022-07-22 15:59:04');
INSERT INTO `settings` VALUES (57, 'cynoebook_category_menu', 'N;', 0, '2022-07-22 15:59:04', '2022-07-22 15:59:04');
INSERT INTO `settings` VALUES (58, 'cynoebook_footer_menu_1', 'N;', 0, '2022-07-22 15:59:04', '2022-07-22 15:59:04');
INSERT INTO `settings` VALUES (59, 'cynoebook_footer_menu_2', 'N;', 0, '2022-07-22 15:59:04', '2022-07-22 15:59:04');
INSERT INTO `settings` VALUES (60, 'cynoebook_fb_link', 'N;', 0, '2022-07-22 15:59:04', '2022-07-22 15:59:04');
INSERT INTO `settings` VALUES (61, 'cynoebook_twitter_link', 'N;', 0, '2022-07-22 15:59:04', '2022-07-22 15:59:04');
INSERT INTO `settings` VALUES (62, 'cynoebook_instagram_link', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (63, 'cynoebook_linkedin_link', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (64, 'cynoebook_pinterest_link', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (65, 'cynoebook_google_plus_link', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (66, 'cynoebook_youtube_link', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (67, 'cynoebook_ad1_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (68, 'cynoebook_ad_1', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (69, 'cynoebook_ad2_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (70, 'cynoebook_ad_2', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (71, 'cynoebook_ad3_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (72, 'cynoebook_ad_3', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (73, 'cynoebook_home_ad1_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (74, 'cynoebook_home_ad_1', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (75, 'cynoebook_featured_ebooks_carousel_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (76, 'cynoebook_featured_ebooks_section_total_ebooks', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (77, 'cynoebook_popular_ebooks_carousel_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (78, 'cynoebook_popular_ebooks_by', 's:6:\"review\";', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (79, 'cynoebook_popular_ebooks_section_total_ebooks', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (80, 'cynoebook_banner_section_1_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (81, 'cynoebook_banner_section_1_banner_call_to_action_url', 'N;', 0, '2022-07-22 15:59:05', '2022-07-22 15:59:05');
INSERT INTO `settings` VALUES (82, 'cynoebook_banner_section_1_banner_open_in_new_window', 's:1:\"0\";', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (83, 'cynoebook_authors_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (84, 'cynoebook_authors_order_by', 's:6:\"latest\";', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (85, 'cynoebook_authors_section_total_authors', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (86, 'cynoebook_home_ad2_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (87, 'cynoebook_home_ad_2', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (88, 'cynoebook_recent_ebooks_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (89, 'cynoebook_recent_ebooks_section_total_ebooks', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (90, 'cynoebook_banner_section_2_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (91, 'cynoebook_banner_section_2_banner_call_to_action_url', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (92, 'cynoebook_banner_section_2_banner_open_in_new_window', 's:1:\"0\";', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (93, 'cynoebook_category_tabs_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (94, 'cynoebook_category_tabs_section_tab_1_category', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (95, 'cynoebook_category_tabs_section_tab_1_total_ebooks', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (96, 'cynoebook_category_tabs_section_tab_2_category', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (97, 'cynoebook_category_tabs_section_tab_2_total_ebooks', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (98, 'cynoebook_category_tabs_section_tab_3_category', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (99, 'cynoebook_category_tabs_section_tab_3_total_ebooks', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (100, 'cynoebook_category_tabs_section_tab_4_category', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (101, 'cynoebook_category_tabs_section_tab_4_total_ebooks', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (102, 'cynoebook_category_tabs_section_tab_5_category', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (103, 'cynoebook_category_tabs_section_tab_5_total_ebooks', 'N;', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (104, 'cynoebook_home_ad3_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:06', '2022-07-22 15:59:06');
INSERT INTO `settings` VALUES (105, 'cynoebook_home_ad_3', 'N;', 0, '2022-07-22 15:59:07', '2022-07-22 15:59:07');
INSERT INTO `settings` VALUES (106, 'cynoebook_users_section_enabled', 's:1:\"0\";', 0, '2022-07-22 15:59:07', '2022-07-22 15:59:07');
INSERT INTO `settings` VALUES (107, 'cynoebook_users_order_by', 's:6:\"latest\";', 0, '2022-07-22 15:59:07', '2022-07-22 15:59:07');
INSERT INTO `settings` VALUES (108, 'cynoebook_users_section_total_authors', 'N;', 0, '2022-07-22 15:59:07', '2022-07-22 15:59:07');
INSERT INTO `settings` VALUES (109, 'cynoebook_ebook_carousel_section_ebooks', 'N;', 0, '2022-07-22 15:59:07', '2022-07-22 15:59:07');
INSERT INTO `settings` VALUES (110, 'cynoebook_slider_banner_file_id', NULL, 1, '2022-07-22 15:59:22', '2022-07-22 15:59:22');
INSERT INTO `settings` VALUES (111, 'cynoebook_slider_banner_caption_1', NULL, 1, '2022-07-22 15:59:22', '2022-07-22 15:59:22');
INSERT INTO `settings` VALUES (112, 'cynoebook_slider_banner_caption_2', NULL, 1, '2022-07-22 15:59:22', '2022-07-22 15:59:22');
INSERT INTO `settings` VALUES (113, 'cynoebook_slider_banner_call_to_action_text', NULL, 1, '2022-07-22 15:59:22', '2022-07-22 15:59:22');
INSERT INTO `settings` VALUES (114, 'cynoebook_slider_banner_call_to_action_url', 'N;', 0, '2022-07-22 15:59:23', '2022-07-22 15:59:23');
INSERT INTO `settings` VALUES (115, 'cynoebook_slider_banner_open_in_new_window', 's:1:\"0\";', 0, '2022-07-22 15:59:23', '2022-07-22 15:59:23');

-- ----------------------------
-- Table structure for slider_slide_translations
-- ----------------------------
DROP TABLE IF EXISTS `slider_slide_translations`;
CREATE TABLE `slider_slide_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `slider_slide_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `files_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `caption_1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `caption_2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `caption_3` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `call_to_action_text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `slider_slide_translations_slider_slide_id_locale_unique`(`slider_slide_id`, `locale`) USING BTREE,
  CONSTRAINT `slider_slide_translations_slider_slide_id_foreign` FOREIGN KEY (`slider_slide_id`) REFERENCES `slider_slides` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for slider_slides
-- ----------------------------
DROP TABLE IF EXISTS `slider_slides`;
CREATE TABLE `slider_slides`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `slider_id` int(10) UNSIGNED NOT NULL,
  `options` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `call_to_action_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `open_in_new_window` tinyint(1) NULL DEFAULT NULL,
  `position` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `slider_slides_slider_id_foreign`(`slider_id`) USING BTREE,
  CONSTRAINT `slider_slides_slider_id_foreign` FOREIGN KEY (`slider_id`) REFERENCES `sliders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for slider_translations
-- ----------------------------
DROP TABLE IF EXISTS `slider_translations`;
CREATE TABLE `slider_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `slider_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `slider_translations_slider_id_locale_unique`(`slider_id`, `locale`) USING BTREE,
  CONSTRAINT `slider_translations_slider_id_foreign` FOREIGN KEY (`slider_id`) REFERENCES `sliders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sliders
-- ----------------------------
DROP TABLE IF EXISTS `sliders`;
CREATE TABLE `sliders`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `autoplay` tinyint(1) NULL DEFAULT NULL,
  `autoplay_speed` int(11) NULL DEFAULT NULL,
  `arrows` tinyint(1) NULL DEFAULT NULL,
  `dots` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for throttle
-- ----------------------------
DROP TABLE IF EXISTS `throttle`;
CREATE TABLE `throttle`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `throttle_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `throttle_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for translation_translations
-- ----------------------------
DROP TABLE IF EXISTS `translation_translations`;
CREATE TABLE `translation_translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `translation_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `translation_translations_translation_id_locale_unique`(`translation_id`, `locale`) USING BTREE,
  CONSTRAINT `translation_translations_translation_id_foreign` FOREIGN KEY (`translation_id`) REFERENCES `translations` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for translations
-- ----------------------------
DROP TABLE IF EXISTS `translations`;
CREATE TABLE `translations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `translations_key_index`(`key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles`  (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`, `role_id`) USING BTREE,
  INDEX `user_roles_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_roles
-- ----------------------------
INSERT INTO `user_roles` VALUES (1, 1, '2022-07-22 15:33:35', '2022-07-22 15:33:35');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_login` datetime(0) NULL DEFAULT NULL,
  `about` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `facebook` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `twitter` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `google` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `instagram` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `linkedin` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `youtube` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Ryan', 'Blake', 'ryanblake', 'lamskills113@gmail.com', '$2y$10$NkPK1oZuFJW5ouCglQwDKeHiYGyYJAphtF9UePafVBmT4p9iDKy4.', NULL, '2022-07-22 15:38:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-22 15:33:35', '2022-07-22 15:38:25');

SET FOREIGN_KEY_CHECKS = 1;
