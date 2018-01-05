-- MySQL dump 10.16  Distrib 10.1.9-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: financeiro
-- ------------------------------------------------------
-- Server version	10.1.9-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account_types`
--

DROP TABLE IF EXISTS `account_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unique_name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_types_unique_name_unique` (`unique_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_types`
--

LOCK TABLES `account_types` WRITE;
/*!40000 ALTER TABLE `account_types` DISABLE KEYS */;
INSERT INTO `account_types` VALUES (1,'conta_corrente','2017-01-22 23:39:58','2017-01-22 23:39:58'),(2,'conta_poupanca','2017-01-22 23:39:58','2017-01-22 23:39:58'),(3,'cartao_credito','2017-01-22 23:39:58','2017-01-22 23:39:58');
/*!40000 ALTER TABLE `account_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_type_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(145) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(5) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accounts_account_type_id_foreign` (`account_type_id`),
  KEY `accounts_user_id_foreign` (`user_id`),
  CONSTRAINT `accounts_account_type_id_foreign` FOREIGN KEY (`account_type_id`) REFERENCES `account_types` (`id`),
  CONSTRAINT `accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,1,2,'Itau',1,'2017-01-22 23:39:59','2017-01-22 23:39:59'),(2,1,2,'Santander',1,'2017-01-22 23:39:59','2017-01-22 23:39:59'),(3,1,2,'Banco do Brasil',1,'2017-01-22 23:39:59','2017-01-22 23:39:59'),(4,1,2,'Caixa',1,'2017-01-22 23:39:59','2017-01-22 23:39:59'),(5,3,2,'Cartão Visa Santander',1,'2017-10-05 13:16:29','2017-10-05 13:16:29'),(6,2,2,'Itau Poupança',1,'2017-10-05 13:16:52','2017-10-05 13:16:52');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(5) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_user_id_foreign` (`user_id`),
  CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,2,'Salário',1,'2017-01-22 23:39:57','2017-01-22 23:39:57'),(2,2,'Aluguel',1,'2017-01-22 23:39:58','2017-01-22 23:39:58'),(3,2,'Financiamento Apartamento',1,'2017-01-22 23:39:58','2017-01-22 23:39:58'),(4,2,'Teka Maria',1,'2017-01-22 23:39:58','2017-01-22 23:39:58'),(5,2,'Farmácia',1,'2017-01-22 23:39:58','2017-01-22 23:39:58'),(6,2,'Lazer',1,'2017-01-22 23:39:58','2017-01-22 23:39:58'),(7,2,'Telefonia',1,'2017-01-22 23:39:58','2017-01-22 23:39:58'),(8,2,'Seguro',1,'2017-01-22 23:39:58','2017-01-22 23:39:58'),(9,2,'Carro',1,'2017-01-22 23:39:58','2017-01-22 23:39:58'),(10,2,'Despesas Bancárias',1,'2017-01-22 23:39:58','2017-01-22 23:39:58'),(11,2,'Transferência entre contas',1,'2017-01-22 23:39:58','2017-01-22 23:39:58'),(12,2,'Indefinida',1,'2017-01-22 23:39:58','2017-01-22 23:39:58'),(13,2,'Remessa Brasil',1,'2017-10-07 12:40:38','2017-10-07 12:40:38'),(14,2,'Alimentação',1,'2017-10-07 12:41:28','2017-10-07 12:41:28'),(15,2,'Supermercado',1,'2017-10-07 12:42:16','2017-10-07 12:42:16'),(16,2,'Transporte',1,'2017-10-07 12:44:22','2017-10-07 12:44:22');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incomes`
--

DROP TABLE IF EXISTS `incomes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incomes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `values` decimal(14,2) NOT NULL,
  `status` smallint(5) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `incomes_account_id_foreign` (`account_id`),
  KEY `incomes_user_id_foreign` (`user_id`),
  CONSTRAINT `incomes_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `incomes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incomes`
--

LOCK TABLES `incomes` WRITE;
/*!40000 ALTER TABLE `incomes` DISABLE KEYS */;
/*!40000 ALTER TABLE `incomes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (67,'2014_10_12_000000_create_users_table',1),(68,'2014_10_12_100000_create_password_resets_table',1),(69,'2017_01_16_000001_create_account_types_table',1),(70,'2017_01_16_000002_create_accounts_table',1),(71,'2017_01_16_000003_create_categories_table',1),(72,'2017_01_16_000004_create_transaction_types_table',1),(73,'2017_01_16_000005_create_incomes_table',1),(74,'2017_01_16_000006_create_transaction_references_table',1),(75,'2017_01_16_000007_create_provisions_table',1),(76,'2017_01_16_000008_create_provision_dates_table',1),(77,'2017_01_16_000009_create_transactions_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provision_dates`
--

DROP TABLE IF EXISTS `provision_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provision_dates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provision_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `target_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provision_dates_provision_id_foreign` (`provision_id`),
  KEY `provision_dates_user_id_foreign` (`user_id`),
  CONSTRAINT `provision_dates_provision_id_foreign` FOREIGN KEY (`provision_id`) REFERENCES `provisions` (`id`),
  CONSTRAINT `provision_dates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provision_dates`
--

LOCK TABLES `provision_dates` WRITE;
/*!40000 ALTER TABLE `provision_dates` DISABLE KEYS */;
INSERT INTO `provision_dates` VALUES (1,1,2,'2017-01-22 23:22:38','2017-01-22 23:22:36','2017-01-22 23:22:37'),(2,5,2,'2017-01-05 07:00:00','2017-10-05 13:44:02','2017-10-05 13:44:02'),(3,5,2,'2017-02-05 07:00:00','2017-10-05 13:44:02','2017-10-05 13:44:02');
/*!40000 ALTER TABLE `provision_dates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provisions`
--

DROP TABLE IF EXISTS `provisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `transaction_type_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `value` decimal(14,2) NOT NULL,
  `status` smallint(5) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provisions_category_id_foreign` (`category_id`),
  KEY `provisions_transaction_type_id_foreign` (`transaction_type_id`),
  KEY `provisions_user_id_foreign` (`user_id`),
  CONSTRAINT `provisions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `provisions_transaction_type_id_foreign` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_types` (`id`),
  CONSTRAINT `provisions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provisions`
--

LOCK TABLES `provisions` WRITE;
/*!40000 ALTER TABLE `provisions` DISABLE KEYS */;
INSERT INTO `provisions` VALUES (1,1,1,2,5600.00,1,'2017-01-22 23:39:59','2017-01-22 23:39:59'),(2,2,2,2,1430.00,0,'2017-01-22 23:39:59','2017-01-22 23:39:59'),(3,4,2,2,300.00,1,'2017-01-22 23:39:59','2017-01-22 23:39:59'),(4,3,2,2,3125.00,1,'2017-01-22 23:39:59','2017-01-22 23:39:59'),(5,4,2,2,150.00,1,'2017-10-05 13:44:02','2017-10-05 13:44:02'),(6,4,2,2,425.00,1,'2017-10-05 13:44:02','2017-10-05 13:44:02');
/*!40000 ALTER TABLE `provisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_references`
--

DROP TABLE IF EXISTS `transaction_references`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_references` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_references_user_id_foreign` (`user_id`),
  CONSTRAINT `transaction_references_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_references`
--

LOCK TABLES `transaction_references` WRITE;
/*!40000 ALTER TABLE `transaction_references` DISABLE KEYS */;
INSERT INTO `transaction_references` VALUES (1,'INT TED D',2,0,'2017-10-05 13:30:11','2017-10-05 13:30:11'),(2,'IOF',2,0,'2017-10-05 13:30:11','2017-10-05 13:30:11'),(3,'TED .RICARDO A ME',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(4,'INT TED TEKA',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(5,'SISPAG NOVA BARAO IMOV',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(6,'LISJUROS',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(7,'INT PAG TIT BANCO',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(8,'TBI . tokpag',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(9,'DA NET SERVIÇOS',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(10,'DOCD INT PARASANT',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(11,'RSHOPSTATIONE',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(12,'TBI .',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(13,'DA CLARO SP',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(14,'SEGURO CARTAO',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(15,'TEC DEPOSITO DINHEIRO',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(16,'INT TED',2,0,'2017-10-05 13:30:12','2017-10-05 13:30:12'),(17,'MISC PAYMENT',2,13,'2017-10-07 12:40:14','2017-10-07 13:02:27'),(18,'Withdrawal',2,12,'2017-10-07 12:40:14','2017-10-07 13:02:27'),(19,'YIG CITY MARKET',2,15,'2017-10-07 12:40:14','2017-10-07 13:02:27'),(20,'CIDP PURCHASE',2,0,'2017-10-07 12:40:14','2017-10-07 12:40:14'),(21,'PINE SUSHI SQUA',2,0,'2017-10-07 12:40:14','2017-10-07 12:40:14'),(22,'IKEA RICHMOND',2,0,'2017-10-07 12:40:14','2017-10-07 12:40:14'),(23,'WALMART',2,0,'2017-10-07 12:40:14','2017-10-07 12:40:14'),(24,'NORTH VANCOUVER',2,0,'2017-10-07 12:40:14','2017-10-07 12:40:14'),(25,'LONDON DRUGS',2,0,'2017-10-07 12:40:14','2017-10-07 12:40:14'),(26,'DOLLAR TREE',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(27,'MIDP PURCHASE',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(28,'FRESH BOWL GAST',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(29,'LONSDALE VETERI',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(30,'ALHADBAH MEDIT',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(31,'WWWINTERAC PUR',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(32,'LA SENZA',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(33,'COMPASS VENDING',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(34,'CASH WITHDRAWAL',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(35,'PAYROLL DEPOSIT',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(36,'Transfer',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(37,'DAEJI',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(38,'WHITE SPOT',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(39,'LONDON DRUGS NORTH VANCOUVBC',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(40,'YIG CITY MARKET LONS N VANCOUVER BC',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(41,'WHITE SPOT N. VANCOUVER BC',2,0,'2017-10-07 12:40:15','2017-10-07 12:40:15'),(42,'SQ FRESH BOWL FOODS LTD Vancouver BC',2,0,'2017-10-07 12:40:16','2017-10-07 12:40:16'),(43,'PAYMENT THANK YOU PAIEMENT MERCI',2,0,'2017-10-07 12:40:16','2017-10-07 12:40:16'),(44,'WALMART SUPERCENTERVANCOUVER BC',2,0,'2017-10-07 12:40:16','2017-10-07 12:40:16'),(45,'STARBUCKS VANCOUVER BC',2,0,'2017-10-07 12:40:16','2017-10-07 12:40:16'),(46,'CHARTWELLSCAPILANO U NORTH VANCOUVBC',2,0,'2017-10-07 12:40:16','2017-10-07 12:40:16');
/*!40000 ALTER TABLE `transaction_references` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_types`
--

DROP TABLE IF EXISTS `transaction_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unique_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_types_unique_name_unique` (`unique_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_types`
--

LOCK TABLES `transaction_types` WRITE;
/*!40000 ALTER TABLE `transaction_types` DISABLE KEYS */;
INSERT INTO `transaction_types` VALUES (1,'credit','2017-01-22 23:39:58','2017-01-22 23:39:58'),(2,'debit','2017-01-22 23:39:58','2017-01-22 23:39:58');
/*!40000 ALTER TABLE `transaction_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `transaction_type_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(14,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_account_id_foreign` (`account_id`),
  KEY `transactions_category_id_foreign` (`category_id`),
  KEY `transactions_transaction_type_id_foreign` (`transaction_type_id`),
  KEY `transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `transactions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `transactions_transaction_type_id_foreign` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_types` (`id`),
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,1,2,2,2,'Aluguel',1900.00,'2016-12-22 02:00:00','2017-01-23 03:53:01','2017-01-23 03:53:01'),(2,1,4,2,2,'Passeio',300.00,'2017-01-05 06:21:05','2017-01-23 03:53:01','2017-01-23 03:53:01'),(3,1,13,1,2,'MISC PAYMENT',1923.90,'2017-08-30 07:00:00','2017-10-07 13:02:27','2017-10-07 13:02:27'),(4,1,12,2,2,'Withdrawal',1000.00,'2017-08-30 07:00:00','2017-10-07 13:02:27','2017-10-07 13:02:27'),(5,1,12,2,2,'Withdrawal',200.00,'2017-08-31 07:00:00','2017-10-07 13:02:27','2017-10-07 13:02:27'),(6,1,15,2,2,'YIG CITY MARKET',10.22,'2017-09-01 07:00:00','2017-10-07 13:02:27','2017-10-07 13:02:27');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Adminstrador','admin@financeiro.com.br','$2y$10$LBseV/eu7VddIj0xQP7AgugXjSMzhbWg1XT8szZ6qfJM9I8I7jOZ.','secret','2017-01-22 23:39:57','2017-01-22 23:39:57'),(2,'Ricardo','ricardo@financeiro.com.br','$2y$10$KRHoD/Qbn.cLsd/h6mHCIe8OjlVb6pYeg4zZJg5fkZ88GlCatNjU2','secret','2017-01-22 23:39:57','2017-01-22 23:39:57');
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

-- Dump completed on 2018-01-04 22:11:24
