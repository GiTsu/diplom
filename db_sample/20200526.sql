-- MariaDB dump 10.17  Distrib 10.4.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: homestead
-- ------------------------------------------------------
-- Server version	10.4.12-MariaDB-1:10.4.12+maria~bionic-log

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
-- Table structure for table `answer_items`
--

DROP TABLE IF EXISTS `answer_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL COMMENT 'прямая ссылка на вопрос',
  `question_item_id` int(11) DEFAULT NULL,
  `value` text COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `answer_items_FK` (`question_item_id`),
  KEY `answer_items_FK_1` (`result_id`),
  KEY `answer_items_FK_2` (`question_id`),
  CONSTRAINT `answer_items_FK` FOREIGN KEY (`question_item_id`) REFERENCES `question_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `answer_items_FK_1` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`) ON DELETE CASCADE,
  CONSTRAINT `answer_items_FK_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer_items`
--

LOCK TABLES `answer_items` WRITE;
/*!40000 ALTER TABLE `answer_items` DISABLE KEYS */;
INSERT INTO `answer_items` VALUES (10,10,18,NULL,'19'),(11,10,19,NULL,'Queen'),(12,11,20,NULL,'21'),(13,11,21,NULL,'[\"23\",\"24\"]'),(14,11,22,NULL,'первый, второй, третий'),(15,11,23,NULL,'{\"25\":\"27\",\"26\":\"28\"}');
/*!40000 ALTER TABLE `answer_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (4,'Тестовая группа 1'),(5,'Тестовая группа 2');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lb_blocks`
--

DROP TABLE IF EXISTS `lb_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lb_blocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `raw_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `raw_content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rendered_content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'wp_block',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lb_blocks`
--

LOCK TABLES `lb_blocks` WRITE;
/*!40000 ALTER TABLE `lb_blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `lb_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lb_contents`
--

DROP TABLE IF EXISTS `lb_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lb_contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `raw_content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rendered_content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contentable_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'page',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lb_contents_contentable_type_contentable_id_index` (`contentable_type`,`contentable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lb_contents`
--

LOCK TABLES `lb_contents` WRITE;
/*!40000 ALTER TABLE `lb_contents` DISABLE KEYS */;
/*!40000 ALTER TABLE `lb_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2015_02_07_172606_create_roles_table',2),(5,'2015_02_07_172633_create_role_user_table',3),(6,'2015_02_07_172649_create_permissions_table',3),(7,'2015_02_07_172657_create_permission_role_table',3),(8,'2015_02_17_152439_create_permission_user_table',3),(9,'2015_11_30_232041_bigint_user_keys',3),(10,'2016_02_06_172606_create_users_table_if_doesnt_exist',3),(11,'2019_02_08_105647_create_blocks_contents_tables',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_user`
--

DROP TABLE IF EXISTS `permission_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_user_permission_id_index` (`permission_id`),
  KEY `permission_user_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_user`
--

LOCK TABLES `permission_user` WRITE;
/*!40000 ALTER TABLE `permission_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inherit_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_inherit_id_index` (`inherit_id`),
  KEY `permissions_name_index` (`name`),
  KEY `permissions_slug_index` (`slug`),
  CONSTRAINT `permissions_inherit_id_foreign` FOREIGN KEY (`inherit_id`) REFERENCES `permissions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,NULL,'авп','[]','авп','2020-05-25 19:51:35','2020-05-25 19:51:35');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_items`
--

DROP TABLE IF EXISTS `question_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `is_correct` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `linked_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_items_FK` (`linked_id`),
  CONSTRAINT `question_items_FK` FOREIGN KEY (`linked_id`) REFERENCES `question_items` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_items`
--

LOCK TABLES `question_items` WRITE;
/*!40000 ALTER TABLE `question_items` DISABLE KEYS */;
INSERT INTO `question_items` VALUES (17,'They',NULL,NULL),(18,'Are',NULL,NULL),(19,'The','1',NULL),(20,'Материнская плата',NULL,NULL),(21,'Корпус','1',NULL),(22,'Javascript',NULL,NULL),(23,'C++','1',NULL),(24,'Pascal','1',NULL),(25,'If',NULL,27),(26,'case',NULL,28),(27,'else',NULL,NULL),(28,'break',NULL,NULL);
/*!40000 ALTER TABLE `question_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_bin NOT NULL,
  `text` text COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_FK` (`subject_id`),
  CONSTRAINT `questions_FK` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (18,4,0,'Выберите артикль','<!-- wp:paragraph -->\r\n<p>Из предложенных вариантов, выберите артикль</p>\r\n<!-- /wp:paragraph -->'),(19,4,2,'Переведите слово','<!-- wp:paragraph -->\r\n<p>Напишите перевод слова \"Королева\"</p>\r\n<!-- /wp:paragraph -->'),(20,5,0,'Информатика №1','<!-- wp:paragraph -->\r\n<p>Что изображено на картинке?</p>\r\n<!-- /wp:paragraph -->\r\n\r\n<!-- wp:image {\"width\":180,\"height\":180,\"sizeSlug\":\"large\"} -->\r\n<figure class=\"wp-block-image size-large is-resized\"><img src=\"http://diplom.test/storage/photos/11/498936_v01_b.jpg\" alt=\"\" width=\"180\" height=\"180\"/><figcaption>1</figcaption></figure>\r\n<!-- /wp:image -->'),(21,5,1,'Информатика №2','<!-- wp:paragraph -->\r\n<p>Укажите компилируемые языки программирования</p>\r\n<!-- /wp:paragraph -->'),(22,5,2,'Информатика №3','<!-- wp:paragraph -->\r\n<p>Опишите основные принципы ООП</p>\r\n<!-- /wp:paragraph -->'),(23,5,3,'Информатика #4','<!-- wp:paragraph -->\r\n<p>Выберите используемые вместе ключевые слова в PHP</p>\r\n<!-- /wp:paragraph -->');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rel_questions_items`
--

DROP TABLE IF EXISTS `rel_questions_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rel_questions_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `question_item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rel_questions_items_FK` (`question_id`),
  KEY `rel_questions_items_FK_1` (`question_item_id`),
  CONSTRAINT `rel_questions_items_FK` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rel_questions_items_FK_1` FOREIGN KEY (`question_item_id`) REFERENCES `question_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rel_questions_items`
--

LOCK TABLES `rel_questions_items` WRITE;
/*!40000 ALTER TABLE `rel_questions_items` DISABLE KEYS */;
INSERT INTO `rel_questions_items` VALUES (13,18,17),(14,18,18),(15,18,19),(16,20,20),(17,20,21),(18,21,22),(19,21,23),(20,21,24),(21,23,25),(22,23,26),(23,23,27),(24,23,28);
/*!40000 ALTER TABLE `rel_questions_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rel_tests_questions`
--

DROP TABLE IF EXISTS `rel_tests_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rel_tests_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rel_tests_questions_FK` (`test_id`),
  KEY `rel_tests_questions_FK_1` (`question_id`),
  CONSTRAINT `rel_tests_questions_FK` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rel_tests_questions_FK_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rel_tests_questions`
--

LOCK TABLES `rel_tests_questions` WRITE;
/*!40000 ALTER TABLE `rel_tests_questions` DISABLE KEYS */;
INSERT INTO `rel_tests_questions` VALUES (20,7,18),(21,7,19),(22,8,20),(23,8,21),(24,8,22),(25,8,23);
/*!40000 ALTER TABLE `rel_tests_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rel_users_tests`
--

DROP TABLE IF EXISTS `rel_users_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rel_users_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `test_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rel_users_tests_FK` (`user_id`),
  KEY `rel_users_tests_FK_1` (`test_id`),
  CONSTRAINT `rel_users_tests_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rel_users_tests_FK_1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rel_users_tests`
--

LOCK TABLES `rel_users_tests` WRITE;
/*!40000 ALTER TABLE `rel_users_tests` DISABLE KEYS */;
/*!40000 ALTER TABLE `rel_users_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `results`
--

DROP TABLE IF EXISTS `results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `percent` float DEFAULT NULL,
  `mark` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `results_FK` (`test_id`),
  KEY `results_FK_1` (`user_id`),
  CONSTRAINT `results_FK` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `results_FK_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `results`
--

LOCK TABLES `results` WRITE;
/*!40000 ALTER TABLE `results` DISABLE KEYS */;
INSERT INTO `results` VALUES (10,7,12,'2020-05-26 07:42:31','2020-05-26 08:31:23',100,5),(11,8,13,'2020-05-26 09:32:49','2020-05-26 09:33:54',75,4);
/*!40000 ALTER TABLE `results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_index` (`role_id`),
  KEY `role_user_user_id_index` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,3,8,'2020-05-05 03:22:44','2020-05-05 03:22:44'),(5,1,11,'2020-05-25 19:58:17','2020-05-25 19:58:17'),(6,2,12,'2020-05-25 20:09:37','2020-05-25 20:09:37'),(7,2,13,'2020-05-26 06:43:55','2020-05-26 06:43:55');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Преподаватель','teacher','Позволяет заходить в админку, редактировать тесты и вопросы, ставить оценки','2020-03-17 03:42:23','2020-03-17 03:42:23'),(2,'Ученик','student',NULL,'2020-04-04 17:42:07','2020-04-04 17:42:07'),(3,'Администратор','admin','Полные права доступа','2020-05-25 18:25:38','2020-05-25 18:25:38');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (2,'Математика'),(4,'Английский язык'),(5,'Информатика');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `opt_return` tinyint(4) DEFAULT NULL,
  `opt_skip` tinyint(4) DEFAULT NULL,
  `opt_fullonly` tinyint(4) DEFAULT NULL,
  `opt_notime` tinyint(4) DEFAULT NULL,
  `opt_timelimit` int(11) DEFAULT NULL,
  `description` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tests`
--

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
INSERT INTO `tests` VALUES (7,'Первый тест по английскому',11,1,1,1,1,NULL,'Тест начальных знаний по английской мове.'),(8,'Тест по информатике',11,1,1,1,1,NULL,'Проверка знаний по информатике');
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_FK` (`group_id`),
  CONSTRAINT `users_FK` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (8,'Амин Админович','admin@diplom.test',NULL,'$2y$10$uG5JppsJHJ2zvDhVqfeLpur3lCHjKzG4IEVjkCd/0tb3UHcFZKaj.','seQH3FA1OeEl58ypPDZt1ApnaofH1zF301g6XLUuykl9z2kV7HDn0jhF8bhm','2020-05-05 03:22:44','2020-05-25 20:03:08',NULL),(11,'Исаак Исаакович Ньютон','teacher@diplom.test',NULL,'$2y$10$uj9HiIPKqr3KvUplg6ozS.xHS1Wx.MdhVLyJl3415k011CgoSlugi','m4coGvXwntV1VM6jYCTB4ZioXaMhOShkSQWMUszyczAe9RaYF9HIurDiMz2m','2020-05-25 19:58:05','2020-05-26 06:44:55',NULL),(12,'Барт Гомерович Симпсон','student@diplom.test',NULL,'$2y$10$aigp3P7ofzuez.J9LvdWA.mzIt19fLELrHafo/oOzTjfCyal7GplK','4oubuXsyKBImoa0rjOxEyxsqcT0zVYPq3cxq1KQOe6jnQGLcbRQoQN4v4YGY','2020-05-25 19:59:03','2020-05-26 06:42:56',4),(13,'Лиза Гомеровна Симпсон','student2@diplom.test',NULL,'$2y$10$l5JYGC9jn8wBdWJjNYCtNe4e3oj7mL5mBeGqGuBIyhk5Zyk0IeT7S',NULL,'2020-05-26 06:43:40','2020-05-26 06:43:50',5);
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

-- Dump completed on 2020-05-26  9:37:45
