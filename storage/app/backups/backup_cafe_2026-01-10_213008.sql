-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: cafe
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Kopi','2026-01-10 12:24:57','2026-01-10 12:24:57'),(2,'Teh','2026-01-10 12:24:57','2026-01-10 12:24:57'),(3,'Jus','2026-01-10 12:24:57','2026-01-10 12:24:57'),(4,'Makanan','2026-01-10 12:24:57','2026-01-10 12:24:57'),(5,'Snack','2026-01-10 12:24:57','2026-01-10 12:24:57');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_category_id_foreign` (`category_id`),
  CONSTRAINT `menus_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,1,'Espress','Kopi espresso klasik',15000,'1768076281_images.jpg',1,'2026-01-10 12:24:57','2026-01-10 13:18:01'),(2,1,'Cappuccino','Kopi dengan susu foam',20000,'1768076330_cappuccino1-recipe.jpg',1,'2026-01-10 12:24:57','2026-01-10 13:18:50'),(3,1,'Latte','Kopi susu lembut',22000,'1768076388_cafe-latte1-recipe_resized.jpg',1,'2026-01-10 12:24:57','2026-01-10 13:19:48'),(4,1,'Americano','Espresso dengan air panas',18000,'1768076542_20250605103143000000COVERARTIKELWEBSITE2.png',1,'2026-01-10 12:24:57','2026-01-10 13:22:22'),(5,2,'Teh Tarik','Teh susu manis',12000,'1768076707_images (1).jpg',1,'2026-01-10 12:24:57','2026-01-10 13:25:07'),(6,2,'Green Tea','Teh hijau segar',15000,'1768076788_images (2).jpg',1,'2026-01-10 12:24:57','2026-01-10 13:26:28'),(7,3,'Jus Jeruk','Jus jeruk segar',15000,'1768076853_images (3).jpg',1,'2026-01-10 12:24:57','2026-01-10 13:27:33'),(8,3,'Jus Alpukat','Jus alpukat creamy',18000,'1768076900_epflbie5452jx8u.jpeg',1,'2026-01-10 12:24:57','2026-01-10 13:28:20'),(9,4,'Nasi Goreng','Nasi goreng spesial',25000,'1768076941_6456a450d2edd.jpg',1,'2026-01-10 12:24:57','2026-01-10 13:29:01'),(10,4,'Mie Goreng','Mie goreng pedas',22000,'1768076985_cara-membuat-mie-goreng-4-1-scaled.jpg',1,'2026-01-10 12:24:57','2026-01-10 13:29:45'),(11,5,'French Fries','Kentang goreng crispy',15000,'1768077016_air-fryer-french-fries-horizontal-hero-web-ready-1.jpg',1,'2026-01-10 12:24:57','2026-01-10 13:30:16'),(12,5,'Onion Rings','Bawang goreng renyah',18000,'1768077047_images (4).jpg',1,'2026-01-10 12:24:57','2026-01-10 13:30:47');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_01_10_000001_create_categories_table',1),(5,'2024_01_10_000002_create_menus_table',1),(6,'2024_01_10_000003_create_orders_table',1),(7,'2024_01_10_000004_create_order_items_table',1),(8,'2024_01_10_000005_create_stocks_table',1),(9,'2024_01_10_000006_create_stock_logs_table',1),(10,'2026_01_10_201459_add_customer_name_to_orders_table',2),(11,'2026_01_10_203450_add_table_number_to_orders_table',3),(12,'2026_01_10_204707_add_payment_method_to_orders_table',4),(13,'2026_01_10_210902_add_payment_status_and_notes_to_orders_table',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `menu_id` bigint(20) unsigned NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_menu_id_foreign` (`menu_id`),
  CONSTRAINT `order_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,15000,1,15000,'2026-01-10 12:33:47','2026-01-10 12:33:47'),(2,1,2,20000,1,20000,'2026-01-10 12:33:47','2026-01-10 12:33:47'),(3,1,3,22000,1,22000,'2026-01-10 12:33:47','2026-01-10 12:33:47'),(4,1,4,18000,1,18000,'2026-01-10 12:33:47','2026-01-10 12:33:47'),(5,2,1,15000,1,15000,'2026-01-10 12:56:14','2026-01-10 12:56:14'),(6,3,9,25000,1,25000,'2026-01-10 12:57:09','2026-01-10 12:57:09'),(7,3,10,22000,1,22000,'2026-01-10 12:57:09','2026-01-10 12:57:09'),(8,4,1,15000,1,15000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(9,4,2,20000,1,20000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(10,4,3,22000,1,22000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(11,4,4,18000,1,18000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(12,4,5,12000,1,12000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(13,4,6,15000,1,15000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(14,4,7,15000,1,15000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(15,4,8,18000,1,18000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(16,4,9,25000,1,25000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(17,4,10,22000,1,22000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(18,4,11,15000,1,15000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(19,4,12,18000,1,18000,'2026-01-10 12:59:07','2026-01-10 12:59:07'),(20,5,1,15000,2,30000,'2026-01-10 13:02:51','2026-01-10 13:02:51'),(21,6,1,15000,1,15000,'2026-01-10 13:09:21','2026-01-10 13:09:21'),(22,7,1,15000,2,30000,'2026-01-10 13:17:36','2026-01-10 13:17:36'),(23,7,2,20000,1,20000,'2026-01-10 13:17:36','2026-01-10 13:17:36'),(24,7,3,22000,1,22000,'2026-01-10 13:17:36','2026-01-10 13:17:36'),(25,7,4,18000,1,18000,'2026-01-10 13:17:36','2026-01-10 13:17:36'),(26,8,1,15000,2,30000,'2026-01-10 13:38:18','2026-01-10 13:38:18'),(27,8,3,22000,2,44000,'2026-01-10 13:38:18','2026-01-10 13:38:18'),(28,9,1,15000,1,15000,'2026-01-10 13:49:50','2026-01-10 13:49:50'),(29,10,1,15000,1,15000,'2026-01-10 13:52:03','2026-01-10 13:52:03'),(30,11,1,15000,1,15000,'2026-01-10 13:54:03','2026-01-10 13:54:03'),(31,12,1,15000,1,15000,'2026-01-10 13:54:54','2026-01-10 13:54:54'),(32,13,1,15000,1,15000,'2026-01-10 13:57:13','2026-01-10 13:57:13'),(33,14,1,15000,1,15000,'2026-01-10 14:00:40','2026-01-10 14:00:40'),(34,15,1,15000,1,15000,'2026-01-10 14:02:45','2026-01-10 14:02:45'),(35,16,2,20000,1,20000,'2026-01-10 14:04:10','2026-01-10 14:04:10'),(36,17,1,15000,1,15000,'2026-01-10 14:05:01','2026-01-10 14:05:01'),(37,18,1,15000,1,15000,'2026-01-10 14:05:16','2026-01-10 14:05:16');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_code` varchar(255) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `table_number` varchar(10) DEFAULT NULL,
  `payment_method` enum('cash','qris') NOT NULL DEFAULT 'cash',
  `payment_status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `status` enum('masuk','diproses','selesai') NOT NULL DEFAULT 'masuk',
  `total_price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_code_unique` (`order_code`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'ORD1768073627',NULL,NULL,'cash','pending',NULL,'selesai',75000,'2026-01-10 12:33:47','2026-01-10 12:34:21'),(2,'ORD1768074974',NULL,NULL,'cash','pending',NULL,'selesai',15000,'2026-01-10 12:56:14','2026-01-10 12:57:22'),(3,'ORD1768075029',NULL,NULL,'cash','pending',NULL,'selesai',47000,'2026-01-10 12:57:09','2026-01-10 12:57:31'),(4,'ORD1768075147',NULL,NULL,'cash','pending',NULL,'selesai',215000,'2026-01-10 12:59:07','2026-01-10 12:59:52'),(5,'ORD1768075371',NULL,NULL,'cash','pending',NULL,'selesai',30000,'2026-01-10 13:02:51','2026-01-10 13:03:03'),(6,'ORD1768075761',NULL,NULL,'cash','pending',NULL,'selesai',15000,'2026-01-10 13:09:21','2026-01-10 13:13:47'),(7,'ORD1768076255','eko saputra',NULL,'cash','pending',NULL,'selesai',90000,'2026-01-10 13:17:35','2026-01-10 13:31:40'),(8,'ORD1768077498','eko','no 2','cash','pending',NULL,'selesai',74000,'2026-01-10 13:38:18','2026-01-10 13:38:31'),(9,'ORD1768078190','a','a','qris','paid',NULL,'selesai',15000,'2026-01-10 13:49:50','2026-01-10 14:16:28'),(10,'ORD1768078323','a','a','qris','paid',NULL,'selesai',15000,'2026-01-10 13:52:03','2026-01-10 14:16:32'),(11,'ORD1768078443','a','a','qris','paid',NULL,'selesai',15000,'2026-01-10 13:54:03','2026-01-10 14:17:06'),(12,'ORD1768078494','a','a','qris','paid',NULL,'selesai',15000,'2026-01-10 13:54:54','2026-01-10 14:17:04'),(13,'ORD1768078633','a','a','qris','paid',NULL,'selesai',15000,'2026-01-10 13:57:13','2026-01-10 14:17:02'),(14,'ORD1768078840','q','q','qris','paid',NULL,'selesai',15000,'2026-01-10 14:00:40','2026-01-10 14:17:00'),(15,'ORD1768078965','q','q','qris','paid',NULL,'selesai',15000,'2026-01-10 14:02:45','2026-01-10 14:16:58'),(16,'ORD1768079050','1','1','cash','pending',NULL,'selesai',20000,'2026-01-10 14:04:10','2026-01-10 14:05:59'),(17,'ORD1768079101','q','q','cash','pending',NULL,'selesai',15000,'2026-01-10 14:05:01','2026-01-10 14:06:00'),(18,'ORD1768079116','q','q','qris','paid',NULL,'selesai',15000,'2026-01-10 14:05:16','2026-01-10 14:16:35');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('kIUAbAdn7KsYYmPfktBluFZwcHS74pItNfkR18PB',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT0FGcVo4ZUN1Vzd3bnduYWtDRlBST1luemIxcGc4T0JzaWRWejRpMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1768080242),('Y4oyIUwsN7gNlA4r75lA4fRxaqPFJGyZcooXF44s',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaDIydUJVcnFEa2IyWWxQM3BaN3NLMzJHeXBnY2xXMnU3VVBSMU96TiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMDoibWVudS5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1768076544),('YoiPWFZ26xytWvblrTPDfGwZIx5weFRh5IYeJfwW',NULL,'192.168.1.8','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Mobile Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmtTUDVoTjNoMEhGYWhDWVNhVld5OWlGTVR6Q0FvNmRNUldibXptVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly8xOTIuMTY4LjEuOTo4MDAwIjtzOjU6InJvdXRlIjtzOjEwOiJtZW51LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1768075147);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_logs`
--

DROP TABLE IF EXISTS `stock_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `type` enum('IN','OUT') NOT NULL,
  `qty` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_logs_menu_id_foreign` (`menu_id`),
  CONSTRAINT `stock_logs_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_logs`
--

LOCK TABLES `stock_logs` WRITE;
/*!40000 ALTER TABLE `stock_logs` DISABLE KEYS */;
INSERT INTO `stock_logs` VALUES (1,1,'IN',12,'mantap','2026-01-10 12:33:02','2026-01-10 12:33:02'),(2,2,'IN',100,'a','2026-01-10 13:07:04','2026-01-10 13:07:04'),(3,3,'IN',100,'Status diubah menjadi: tersedia','2026-01-10 13:07:08','2026-01-10 13:07:08'),(4,4,'IN',100,'Status diubah menjadi: tersedia','2026-01-10 13:13:01','2026-01-10 13:13:01'),(5,5,'IN',100,'Status diubah menjadi: tersedia','2026-01-10 13:13:20','2026-01-10 13:13:20'),(6,6,'IN',100,'Status diubah menjadi: tersedia','2026-01-10 13:13:22','2026-01-10 13:13:22'),(7,7,'IN',100,'Status diubah menjadi: tersedia','2026-01-10 13:13:25','2026-01-10 13:13:25'),(8,8,'IN',100,'Status diubah menjadi: tersedia','2026-01-10 13:13:27','2026-01-10 13:13:27'),(9,9,'IN',100,'Status diubah menjadi: tersedia','2026-01-10 13:13:30','2026-01-10 13:13:30'),(10,10,'IN',100,'Status diubah menjadi: tersedia','2026-01-10 13:13:32','2026-01-10 13:13:32'),(11,11,'IN',100,'Status diubah menjadi: tersedia','2026-01-10 13:13:35','2026-01-10 13:13:35'),(12,12,'IN',100,'Status diubah menjadi: tersedia','2026-01-10 13:13:38','2026-01-10 13:13:38');
/*!40000 ALTER TABLE `stock_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stocks_menu_id_foreign` (`menu_id`),
  CONSTRAINT `stocks_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (1,1,12,'2026-01-10 12:33:02','2026-01-10 12:33:02'),(2,2,100,'2026-01-10 13:07:04','2026-01-10 13:07:04'),(3,3,100,'2026-01-10 13:07:08','2026-01-10 13:07:08'),(4,4,100,'2026-01-10 13:13:01','2026-01-10 13:13:01'),(5,5,100,'2026-01-10 13:13:20','2026-01-10 13:13:20'),(6,6,100,'2026-01-10 13:13:22','2026-01-10 13:13:22'),(7,7,100,'2026-01-10 13:13:25','2026-01-10 13:13:25'),(8,8,100,'2026-01-10 13:13:27','2026-01-10 13:13:27'),(9,9,100,'2026-01-10 13:13:30','2026-01-10 13:13:30'),(10,10,100,'2026-01-10 13:13:32','2026-01-10 13:13:32'),(11,11,100,'2026-01-10 13:13:35','2026-01-10 13:13:35'),(12,12,100,'2026-01-10 13:13:37','2026-01-10 13:13:37');
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kasir') NOT NULL DEFAULT 'kasir',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin 1','admin1@cafe.com',NULL,'$2y$12$ZtnaSPZy3kFWSjD4nzoF/uF/DATc3yx6Dvwr8cx5L8UcRMFJMlnFC','admin',NULL,'2026-01-10 12:24:57','2026-01-10 12:24:57'),(2,'Admin 2','admin2@cafe.com',NULL,'$2y$12$BNXhEMq45cUascA7kc0QLO8S12E2IJ5Dl21tMYhh7H0IYUpJw5s4u','admin',NULL,'2026-01-10 12:24:57','2026-01-10 12:24:57');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-11  4:30:09
