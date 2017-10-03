-- MySQL dump 10.13  Distrib 5.7.16, for Win64 (x86_64)
--
-- Host: localhost    Database: wordpress
-- ------------------------------------------------------
-- Server version	5.7.16

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
-- Table structure for table `wp_table_words`
--

DROP TABLE IF EXISTS `wp_table_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_table_words` (
  `id_word` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `original_words` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `modified_word` varchar(55) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `options` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `id_rule` int(10) unsigned NOT NULL,
  `id_test` int(10) unsigned NOT NULL,
  `original_word` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id_word`),
  KEY `rule_ind` (`id_rule`),
  KEY `test_ind` (`id_test`),
  CONSTRAINT `wp_table_words_fk1` FOREIGN KEY (`id_test`) REFERENCES `wp_table_test` (`id_test`),
  CONSTRAINT `wp_table_words_fk2` FOREIGN KEY (`id_rule`) REFERENCES `wp_table_rules` (`id_rule`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_table_words`
--

LOCK TABLES `wp_table_words` WRITE;
/*!40000 ALTER TABLE `wp_table_words` DISABLE KEYS */;
INSERT INTO `wp_table_words` VALUES (1,'слово','сл_во','о, а, е',1,1,''),(2,'слово','сл_во','о, а, е',2,2,''),(3,'текст','те_ст','к, с, л',3,2,''),(4,'fgh','cf','vgbh',4,3,''),(5,'oj','dfgh','fgh',5,3,''),(6,'fvgbhinj','fvgbhinj','fcvughbjn',6,3,''),(7,'fgihoj','dcfvhjn','fvugbh',7,3,''),(8,'fugihoijk','fgiuhjk','cfuvhnj',8,3,''),(9,'Хостинг','Х_стинго','о, а, е',9,4,''),(10,'стеклянную','стекля_ую','н, нн',10,5,''),(11,'костяных','костя_ых','н, нн',11,5,''),(12,'пятиалтынного','пятиалты_ого','н, нн',12,5,''),(13,'кровяное','кровя_ое','н, нн',13,5,''),(14,'Утиный','Ути_ый','н, нн',14,5,''),(15,'львиным','льви_ым','н, нн',15,5,''),(16,'пустынные','пусты_ые','н, нн',16,5,'');
/*!40000 ALTER TABLE `wp_table_words` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_table_rules`
--

DROP TABLE IF EXISTS `wp_table_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_table_rules` (
  `id_rule` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rules_for_word` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id_rule`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_table_rules`
--

LOCK TABLES `wp_table_rules` WRITE;
/*!40000 ALTER TABLE `wp_table_rules` DISABLE KEYS */;
INSERT INTO `wp_table_rules` VALUES (1,'Потому что'),(2,'Потому что'),(3,'лол'),(4,'fvgbh'),(5,'rfgh'),(6,'fcvgubhi'),(7,'njfgvhbkjn'),(8,'fgihjk'),(9,'Вот так вот'),(10,'Прилагательное СТЕКЛЯННЫЙ - исключение, в нем пишется две буквы Н.'),(11,'Прилагательное образовано с помощью суффикса –ЯН-, поэтому в нем пишется одна буква Н.'),(12,'Прилагательное образовано с помощью суффикса –Н-, который присоединен к корню АЛТЫН, поэтому в слове пишется две буквы Н.'),(13,'Прилагательное образовано с помощью суффикса –ЯН-, поэтому в нем пишется одна буква Н.'),(14,'Прилагательное образовано с помощью суффикса –ИН-, поэтому в слове пишется одна буква Н.'),(15,'Прилагательное образовано с помощью суффикса –ИН-, поэтому в слове пишется одна буква Н.'),(16,'Прилагательное образовано с помощью суффикса –Н-, который присоединен к основе ПУСТЫН-, поэтому в слове пишется две буквы Н.');
/*!40000 ALTER TABLE `wp_table_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_table_test`
--

DROP TABLE IF EXISTS `wp_table_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_table_test` (
  `id_test` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id_test`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_table_test`
--

LOCK TABLES `wp_table_test` WRITE;
/*!40000 ALTER TABLE `wp_table_test` DISABLE KEYS */;
INSERT INTO `wp_table_test` VALUES (1,'Первый тест'),(2,'Первый тест'),(3,'sdfgvhbnjkm,'),(4,'123'),(5,'Упражнение');
/*!40000 ALTER TABLE `wp_table_test` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-03 11:50:44
