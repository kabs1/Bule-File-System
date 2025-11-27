-- MySQL dump 10.13  Distrib 8.0.41, for macos15 (x86_64)
--
-- Host: localhost    Database: bulefilesystem
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `note` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint DEFAULT NULL,
  `branch_id` bigint DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
INSERT INTO `activity_log` VALUES (1,'default','User superadmin has been created',NULL,NULL,NULL,NULL,NULL,'user','created',1,NULL,NULL,'{\"attributes\": {\"email\": \"superadmin@example.com\", \"status\": 1, \"contact\": null, \"password\": \"$2y$12$6kt/tYMGDub9PNASEGBiIep9oOxE261.j2c/QjuuOgRA/x479Z7te\", \"username\": \"superadmin\", \"branch_id\": null, \"last_name\": \"Admin\", \"user_type\": null, \"first_name\": \"Super\", \"profile_picture\": null, \"all_branch_access\": null, \"created_by_user_id\": null}}',NULL,'2025-11-26 21:47:38','2025-11-26 21:47:38'),(2,'default','User testuser has been created',NULL,NULL,NULL,NULL,NULL,'user','created',2,NULL,NULL,'{\"attributes\": {\"email\": \"test@example.com\", \"status\": 1, \"contact\": null, \"password\": \"$2y$12$95IcPXGhsyFUXjOrWCF5O.wM.4fAGaL8AHMFX5PNHr2T.14fWJ3z.\", \"username\": \"testuser\", \"branch_id\": null, \"last_name\": \"User\", \"user_type\": null, \"first_name\": \"Test\", \"profile_picture\": null, \"all_branch_access\": null, \"created_by_user_id\": null}}',NULL,'2025-11-26 21:47:38','2025-11-26 21:47:38'),(3,'default','created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\Branch','created',1,'user',1,'{\"attributes\": {\"status\": 2, \"user_id\": 1, \"branch_name\": \"efa\", \"description\": \"ascaf\", \"date_created\": \"2025-11-27T03:59:32.000000Z\", \"date_updated\": null}}',NULL,'2025-11-26 21:59:32','2025-11-26 21:59:32'),(4,'default','User testuser has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',2,'user',1,'{\"old\": {\"branch_id\": null}, \"attributes\": {\"branch_id\": 1}}',NULL,'2025-11-26 21:59:53','2025-11-26 21:59:53'),(5,'default','created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\Branch','created',2,'user',1,'{\"attributes\": {\"status\": 2, \"user_id\": 1, \"branch_name\": \"dscasv\", \"description\": \"dca\", \"date_created\": \"2025-11-27T04:21:49.000000Z\", \"date_updated\": null}}',NULL,'2025-11-26 22:21:49','2025-11-26 22:21:49'),(6,'default','created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\Currency','created',1,'user',1,'{\"attributes\": {\"user_id\": \"1\", \"date_created\": \"2025-11-27T04:22:02.000000Z\", \"date_updated\": null, \"currency_name\": \"asca\", \"currency_symbol\": \"acv\"}}',NULL,'2025-11-26 22:22:02','2025-11-26 22:22:02'),(7,'default','created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\MeasureUnit','created',1,'user',1,'{\"attributes\": {\"name\": \"sca\", \"short_name\": \"svds\"}}',NULL,'2025-11-26 22:22:17','2025-11-26 22:22:17'),(8,'default','User admissions@reinhardcolleges.net has been created',NULL,NULL,NULL,NULL,NULL,'user','created',3,'user',1,'{\"attributes\": {\"email\": \"admissions@reinhardcolleges.net\", \"status\": 2, \"contact\": null, \"role_id\": 4, \"password\": \"$2y$12$wYnWYpig5/1hx/GoeWLCluxgAsQORkxFSR6ccEeMpZx6Eu9K.kFHa\", \"username\": \"admissions@reinhardcolleges.net\", \"branch_id\": 1, \"last_name\": \"Ronald\", \"user_type\": null, \"first_name\": \"Kabanda\", \"profile_picture\": null, \"all_branch_access\": null, \"created_by_user_id\": 1}}',NULL,'2025-11-26 23:11:57','2025-11-26 23:11:57'),(9,'default','User testuser has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',2,'user',1,'{\"old\": {\"role_id\": null}, \"attributes\": {\"role_id\": 2}}',NULL,'2025-11-26 23:12:34','2025-11-26 23:12:34'),(10,'default','User testuser has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',2,'user',1,'{\"old\": {\"role_id\": 2}, \"attributes\": {\"role_id\": 3}}',NULL,'2025-11-26 23:13:11','2025-11-26 23:13:11'),(11,'default','User admin@amentotech.com has been created',NULL,NULL,NULL,NULL,NULL,'user','created',4,'user',1,'{\"attributes\": {\"email\": \"admin@amentotech.com\", \"status\": 2, \"contact\": null, \"role_id\": 3, \"password\": \"$2y$12$IsuPwrfiMQpU/3Ezc4yACO7PIKSrjOMaIRDLID3FtfnU0UwpcCHJG\", \"username\": \"admin@amentotech.com\", \"branch_id\": 1, \"last_name\": \"RONALD\", \"user_type\": null, \"first_name\": \"KABANDA\", \"profile_picture\": null, \"all_branch_access\": null, \"created_by_user_id\": 1}}',NULL,'2025-11-26 23:14:48','2025-11-26 23:14:48'),(12,'default','User admissions@reinhardcolleges.net has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',3,'user',1,'{\"old\": {\"role_id\": 4}, \"attributes\": {\"role_id\": 3}}',NULL,'2025-11-26 23:15:14','2025-11-26 23:15:14'),(13,'default','User admin@amentotech.com has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',4,'user',1,'{\"old\": {\"role_id\": 3}, \"attributes\": {\"role_id\": 5}}',NULL,'2025-11-26 23:19:33','2025-11-26 23:19:33'),(14,'default','User admissions@reinhardcolleges.net has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',3,'user',1,'{\"old\": {\"role_id\": null}, \"attributes\": {\"role_id\": 14}}',NULL,'2025-11-26 23:34:34','2025-11-26 23:34:34'),(15,'default','created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\MeasureUnit','created',2,'user',1,'{\"attributes\": {\"name\": \"wg\", \"short_name\": \"sdfb\"}}',NULL,'2025-11-26 23:35:24','2025-11-26 23:35:24'),(16,'default','created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\Currency','created',2,'user',1,'{\"attributes\": {\"user_id\": \"1\", \"date_created\": \"2025-11-27T05:35:40.000000Z\", \"date_updated\": null, \"currency_name\": \"dv\", \"currency_symbol\": \"df\"}}',NULL,'2025-11-26 23:35:40','2025-11-26 23:35:40'),(17,'default','created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\Branch','created',3,'user',1,'{\"attributes\": {\"status\": 2, \"user_id\": 1, \"branch_name\": \"test\", \"description\": \"test\", \"date_created\": \"2025-11-27T05:35:56.000000Z\", \"date_updated\": null}}',NULL,'2025-11-26 23:35:56','2025-11-26 23:35:56'),(18,'default','User admin@amentotech.com has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',4,'user',1,'{\"old\": {\"role_id\": null}, \"attributes\": {\"role_id\": 15}}',NULL,'2025-11-26 23:37:31','2025-11-26 23:37:31'),(19,'default','User testuser has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',2,'user',1,'{\"old\": {\"role_id\": null, \"branch_id\": 1}, \"attributes\": {\"role_id\": 15, \"branch_id\": 2}}',NULL,'2025-11-26 23:38:29','2025-11-26 23:38:29'),(20,'default','User info@broadwingconsulting.com has been created',NULL,NULL,NULL,NULL,NULL,'user','created',5,'user',1,'{\"attributes\": {\"email\": \"info@broadwingconsulting.com\", \"status\": 2, \"contact\": null, \"role_id\": 15, \"password\": \"$2y$12$BDYgt.C3YdEOnxURlC9SUu6GYHDUq9y.HCC7RtVvhlUpIWcBOzKx.\", \"username\": \"info@broadwingconsulting.com\", \"branch_id\": 1, \"last_name\": \"Ronald\", \"user_type\": null, \"first_name\": \"Kabanda\", \"profile_picture\": null, \"all_branch_access\": null, \"created_by_user_id\": 1}}',NULL,'2025-11-26 23:38:55','2025-11-26 23:38:55'),(21,'default','User testuser has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',2,'user',1,'{\"old\": {\"role_id\": 15}, \"attributes\": {\"role_id\": 14}}',NULL,'2025-11-26 23:41:26','2025-11-26 23:41:26'),(22,'default','User info@broadwingconsulting.com has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',5,'user',1,'{\"old\": {\"role_id\": null}, \"attributes\": {\"role_id\": 17}}',NULL,'2025-11-26 23:42:50','2025-11-26 23:42:50'),(23,'default','User admissions@reinhardcolleges.net has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',3,'user',1,'{\"old\": {\"status\": 2}, \"attributes\": {\"status\": 3}}',NULL,'2025-11-26 23:44:12','2025-11-26 23:44:12'),(24,'default','User admin@amentotech.com has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',4,'user',1,'{\"old\": {\"role_id\": null, \"branch_id\": 1}, \"attributes\": {\"role_id\": 17, \"branch_id\": 2}}',NULL,'2025-11-26 23:44:25','2025-11-26 23:44:25'),(25,'default','User admissions@reinhardcolleges.net has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',3,'user',1,'{\"old\": {\"role_id\": null}, \"attributes\": {\"role_id\": 17}}',NULL,'2025-11-26 23:45:03','2025-11-26 23:45:03'),(26,'default','User admissions@reinhardcolleges.net has been deleted',NULL,NULL,NULL,NULL,NULL,'user','deleted',3,'user',1,'{\"old\": {\"email\": \"admissions@reinhardcolleges.net\", \"status\": 3, \"contact\": null, \"role_id\": 17, \"password\": \"$2y$12$wYnWYpig5/1hx/GoeWLCluxgAsQORkxFSR6ccEeMpZx6Eu9K.kFHa\", \"username\": \"admissions@reinhardcolleges.net\", \"branch_id\": 1, \"last_name\": \"Ronald\", \"user_type\": null, \"first_name\": \"Kabanda\", \"profile_picture\": null, \"all_branch_access\": null, \"created_by_user_id\": 1}}',NULL,'2025-11-26 23:52:15','2025-11-26 23:52:15'),(27,'default','User testuser has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',2,'user',1,'{\"old\": {\"role_id\": null}, \"attributes\": {\"role_id\": 17}}',NULL,'2025-11-26 23:55:29','2025-11-26 23:55:29'),(28,'default','User ronkabanda@gmail.com has been created',NULL,NULL,NULL,NULL,NULL,'user','created',6,'user',1,'{\"attributes\": {\"email\": \"ronkabanda@gmail.com\", \"status\": 2, \"contact\": null, \"role_id\": 18, \"password\": \"$2y$12$1oO1UbzD8PfTEuLaxKvMNO5fksTdfgzf.WqvkC0P6eaLBzcsnexiq\", \"username\": \"ronkabanda@gmail.com\", \"branch_id\": 1, \"last_name\": \"Ronald\", \"user_type\": null, \"first_name\": \"Kabanda\", \"profile_picture\": null, \"all_branch_access\": null, \"created_by_user_id\": 1}}',NULL,'2025-11-27 01:58:37','2025-11-27 01:58:37'),(29,'default','User testuser has been updated',NULL,NULL,NULL,NULL,NULL,'user','updated',2,'user',1,'{\"old\": {\"branch_id\": 2}, \"attributes\": {\"branch_id\": 1}}',NULL,'2025-11-27 01:59:31','2025-11-27 01:59:31');
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `branches` (
  `branch_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`branch_id`),
  UNIQUE KEY `branches_branch_name_unique` (`branch_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` VALUES (1,'efa','ascaf','2025-11-27 00:59:32',NULL,1,2,'2025-11-26 21:59:32','2025-11-26 21:59:32'),(2,'dscasv','dca','2025-11-27 01:21:49',NULL,1,2,'2025-11-26 22:21:49','2025-11-26 22:21:49'),(3,'test','test','2025-11-27 02:35:56',NULL,1,2,'2025-11-26 23:35:56','2025-11-26 23:35:56');
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel_cache_spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:5:{i:0;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:17:\"activity_log.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:16;}}i:1;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:11:\"backup.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:16;}}i:2;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:13:\"backup.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:16;}}i:3;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:15:\"backup.download\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:16;}}i:4;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:13:\"backup.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:16;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:16;s:1:\"b\";s:11:\"super-admin\";s:1:\"c\";s:3:\"web\";}}}',1764299123);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
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
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currencies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `currency_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'2025-11-27 01:22:02',NULL,'asca','acv','1','2025-11-26 22:22:02','2025-11-26 22:22:02'),(2,'2025-11-27 02:35:40',NULL,'dv','df','1','2025-11-26 23:35:40','2025-11-26 23:35:40');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `customer_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` bigint NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Kabanda',NULL,'Ronald','787 698 7','ronkabanda@gmail.com',1,'2025-11-27 02:53:36',NULL,2,1,'2025-11-26 23:53:36','2025-11-26 23:53:36');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint NOT NULL,
  `branch_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_group_code_unique` (`group_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inward_management`
--

DROP TABLE IF EXISTS `inward_management`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inward_management` (
  `inward_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `inward_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` bigint NOT NULL DEFAULT '1',
  `user_id` bigint NOT NULL,
  `branch_id` bigint NOT NULL,
  `lot_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`inward_id`),
  UNIQUE KEY `inward_management_inward_code_unique` (`inward_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inward_management`
--

LOCK TABLES `inward_management` WRITE;
/*!40000 ALTER TABLE `inward_management` DISABLE KEYS */;
/*!40000 ALTER TABLE `inward_management` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
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
-- Table structure for table `lab_results`
--

DROP TABLE IF EXISTS `lab_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_results` (
  `record_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `melt_id` bigint DEFAULT NULL,
  `stock_id` bigint DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_results`
--

LOCK TABLES `lab_results` WRITE;
/*!40000 ALTER TABLE `lab_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `lab_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lot_management`
--

DROP TABLE IF EXISTS `lot_management`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lot_management` (
  `lot_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lot_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lot_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint NOT NULL,
  `branch_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`lot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lot_management`
--

LOCK TABLES `lot_management` WRITE;
/*!40000 ALTER TABLE `lot_management` DISABLE KEYS */;
/*!40000 ALTER TABLE `lot_management` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measure_units`
--

DROP TABLE IF EXISTS `measure_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `measure_units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `measure_units_name_unique` (`name`),
  UNIQUE KEY `measure_units_short_name_unique` (`short_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measure_units`
--

LOCK TABLES `measure_units` WRITE;
/*!40000 ALTER TABLE `measure_units` DISABLE KEYS */;
INSERT INTO `measure_units` VALUES (1,'sca','svds','2025-11-26 22:22:17','2025-11-26 22:22:17'),(2,'wg','sdfb','2025-11-26 23:35:24','2025-11-26 23:35:24');
/*!40000 ALTER TABLE `measure_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `melt_records`
--

DROP TABLE IF EXISTS `melt_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `melt_records` (
  `melt_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `melt_weight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '1',
  `inward_id` bigint DEFAULT NULL,
  `stock_id` bigint DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`melt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `melt_records`
--

LOCK TABLES `melt_records` WRITE;
/*!40000 ALTER TABLE `melt_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `melt_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (63,'2025_11_26_214232_remove_role_id_from_users_table',1),(64,'2025_11_26_214541_make_role_id_nullable_in_users_table',1),(65,'0001_01_01_000000_create_users_table',2),(66,'0001_01_01_000001_create_cache_table',2),(67,'0001_01_01_000002_create_jobs_table',2),(68,'2025_11_22_110024_add_two_factor_columns_to_users_table',2),(69,'2025_11_22_110132_create_personal_access_tokens_table',2),(70,'2025_11_22_110316_create_teams_table',2),(71,'2025_11_22_110317_create_team_user_table',2),(72,'2025_11_22_110318_create_team_invitations_table',2),(73,'2025_11_22_121654_create_permission_tables',2),(74,'2025_11_24_033910_add_created_by_user_id_to_users_table',2),(75,'2025_11_24_062805_create_branches_table',2),(76,'2025_11_24_062950_add_branch_id_to_users_table',2),(77,'2025_11_24_073320_create_settings_table',2),(78,'2025_11_24_083709_create_currencies_table',2),(79,'2025_11_24_084316_create_measure_units_table',2),(80,'2025_11_24_090227_create_activity_log_table',2),(81,'2025_11_24_090228_add_event_column_to_activity_log_table',2),(82,'2025_11_24_090229_add_batch_uuid_column_to_activity_log_table',2),(83,'2025_11_25_105023_create_customers_table',2),(84,'2025_11_25_105144_create_lot_management_table',2),(85,'2025_11_25_105219_create_inward_management_table',2),(86,'2025_11_25_105249_create_stock_table',2),(87,'2025_11_25_105324_create_melt_records_table',2),(88,'2025_11_25_105354_create_lab_results_table',2),(89,'2025_11_25_105425_create_packaging_table',2),(90,'2025_11_25_105456_create_wallets_table',2),(91,'2025_11_25_105527_create_purchases_table',2),(92,'2025_11_25_105606_create_groups_table',2),(93,'2025_11_25_105647_create_units_table',2),(94,'2025_11_25_111247_add_missing_columns_to_activity_log_table',2),(95,'2025_11_27_020824_update_role_id_column_in_users_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (16,'user',1),(16,'user',2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `packaging`
--

DROP TABLE IF EXISTS `packaging`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packaging` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` int DEFAULT NULL,
  `gross_weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remit_weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loss_gain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sample` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `net_weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `x_summary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_summary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_recorded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packaging`
--

LOCK TABLES `packaging` WRITE;
/*!40000 ALTER TABLE `packaging` DISABLE KEYS */;
/*!40000 ALTER TABLE `packaging` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (58,'activity_log.view','web','2025-11-26 23:41:36','2025-11-26 23:41:36'),(59,'backup.view','web','2025-11-26 23:41:36','2025-11-26 23:41:36'),(60,'backup.create','web','2025-11-26 23:41:36','2025-11-26 23:41:36'),(61,'backup.download','web','2025-11-26 23:41:36','2025-11-26 23:41:36'),(62,'backup.delete','web','2025-11-26 23:41:36','2025-11-26 23:41:36');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchases` (
  `puchase_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallet_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wallet_stock_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_recorded` date NOT NULL DEFAULT (curdate()),
  `date_updated` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`puchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (58,16),(59,16),(60,16),(61,16),(62,16);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (16,'super-admin','web','2025-11-26 23:41:36','2025-11-26 23:41:36'),(17,'Admin','sanctum','2025-11-26 23:42:25','2025-11-26 23:42:25'),(18,'Test role','sanctum','2025-11-27 00:05:23','2025-11-27 00:05:23');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
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
INSERT INTO `sessions` VALUES ('8IQAo74FVthCVSfZpGgF0uesKsCvUnzTu1nHoXRv',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoieTcyOE1BZWlWRloxdmZWVGtXZG9OekZYanpsNHNTMmxLTGJabUNlOCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2JhY2t1cHMiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyNzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1764219454),('mHoDLQLN8TeUOQM22d6KE0ToJlSKhNuGrjTEoIlK',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Trae/1.104.3 Chrome/138.0.7204.251 Electron/37.6.1 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNGRGN24wNVdaWVRZY3diMVdHejJOaWhmQ1JnVGxsWVRDcUViZmh1eCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL3JvbGVzIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1764206791),('MMPBKA2BZkq2d1Qd3mjDOui0hneaDVLSCxORNBHv',NULL,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU3M0ZHM0b2NJc0Z6SzVRODF3MVNrVENJUFpPeDdVd2lQNEJQZDJ4OSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL3JvbGVzIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1764212749),('y1qg5LZDpuMzUoG2tYhGJUkEBdF1ahhA8Ah1uMQ3',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZ0c2d3hZVkVMdjl3OXRKdUNvQk5Xc3pPSGNtb2tvQTBlTXVjTnFMbyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBwL3VzZXJzLzIiO3M6NToicm91dGUiO3M6MTA6InVzZXJzLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEyJDZrdC90WU1HRHViOVBOQVNFR0JpSWVwOW9PeEUyNjEuajJjL1FqdXVPZ1JBL3g0NzlaN3RlIjt9',1764219656);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock` (
  `stock_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gross_weight` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xray` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` bigint NOT NULL DEFAULT '1',
  `inward_id` bigint DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_invitations`
--

DROP TABLE IF EXISTS `team_invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_invitations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_invitations_team_id_email_unique` (`team_id`,`email`),
  CONSTRAINT `team_invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_invitations`
--

LOCK TABLES `team_invitations` WRITE;
/*!40000 ALTER TABLE `team_invitations` DISABLE KEYS */;
/*!40000 ALTER TABLE `team_invitations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_user`
--

DROP TABLE IF EXISTS `team_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_user_team_id_user_id_unique` (`team_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_user`
--

LOCK TABLES `team_user` WRITE;
/*!40000 ALTER TABLE `team_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `team_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_team` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teams_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `unit_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `all_branch_access` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` bigint NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by_user_id` bigint unsigned DEFAULT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  `role_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_created_by_user_id_foreign` (`created_by_user_id`),
  KEY `users_branch_id_foreign` (`branch_id`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`branch_id`) ON DELETE SET NULL,
  CONSTRAINT `users_created_by_user_id_foreign` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super','Admin','superadmin@example.com',NULL,NULL,NULL,'superadmin','$2y$12$6kt/tYMGDub9PNASEGBiIep9oOxE261.j2c/QjuuOgRA/x479Z7te',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'2025-11-26 21:47:38','2025-11-26 21:47:38',NULL,NULL,NULL),(2,'Test','User','test@example.com',NULL,NULL,NULL,'testuser','$2y$12$95IcPXGhsyFUXjOrWCF5O.wM.4fAGaL8AHMFX5PNHr2T.14fWJ3z.',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'2025-11-26 21:47:38','2025-11-27 01:59:31',NULL,1,17),(4,'KABANDA','RONALD','admin@amentotech.com',NULL,NULL,NULL,'admin@amentotech.com','$2y$12$IsuPwrfiMQpU/3Ezc4yACO7PIKSrjOMaIRDLID3FtfnU0UwpcCHJG',NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,'2025-11-26 23:14:48','2025-11-26 23:44:25',1,2,17),(5,'Kabanda','Ronald','info@broadwingconsulting.com',NULL,NULL,NULL,'info@broadwingconsulting.com','$2y$12$BDYgt.C3YdEOnxURlC9SUu6GYHDUq9y.HCC7RtVvhlUpIWcBOzKx.',NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,'2025-11-26 23:38:55','2025-11-26 23:42:50',1,1,17),(6,'Kabanda','Ronald','ronkabanda@gmail.com',NULL,NULL,NULL,'ronkabanda@gmail.com','$2y$12$1oO1UbzD8PfTEuLaxKvMNO5fksTdfgzf.WqvkC0P6eaLBzcsnexiq',NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,'2025-11-27 01:58:37','2025-11-27 01:58:37',1,1,18);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallets` (
  `wallet_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallet_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inwardmeltweight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_recorded` date NOT NULL DEFAULT (curdate()),
  `date_updated` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`wallet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallets`
--

LOCK TABLES `wallets` WRITE;
/*!40000 ALTER TABLE `wallets` DISABLE KEYS */;
/*!40000 ALTER TABLE `wallets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-27  8:24:19
