-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: localhost    Database: php_server
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.18.04.4

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
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `id_phone_book` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emails`
--

LOCK TABLES `emails` WRITE;
/*!40000 ALTER TABLE `emails` DISABLE KEYS */;
INSERT INTO `emails` VALUES (1,'ffreeman@gmail.com',0),(2,'renato@gmail.com',0),(3,'ffreeman@gmail.com',0),(4,'renato@gmail.com',0),(5,'ffreeman@gmail.com',32),(6,'renato@gmail.com',32),(7,'ffreeman@gmail.com',33),(8,'renato@gmail.com',33),(9,'ffreeman@gmail.com',0),(10,'renato@gmail.com',0),(11,'ffreeman@gmail.com',0),(12,'renato@gmail.com',0),(13,'ffreeman@gmail.com',39),(14,'renato@gmail.com',39),(15,'ffreeman@gmail.com',38),(16,'gg@gmail.com',38),(17,'lolo@gmail.com',38),(18,'grangerg@gmail.com',38);
/*!40000 ALTER TABLE `emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phone_books`
--

DROP TABLE IF EXISTS `phone_books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phone_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `surname` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `img_url` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone_books`
--

LOCK TABLES `phone_books` WRITE;
/*!40000 ALTER TABLE `phone_books` DISABLE KEYS */;
INSERT INTO `phone_books` VALUES (1,'','',NULL),(2,'frak','renato',NULL),(3,'frak','renato',NULL),(4,'maria','renato',NULL),(5,'bibi','renato',NULL),(6,'','',NULL),(7,'','',NULL),(8,'lolo','renato',NULL),(9,'lolo','renato',NULL),(10,'lolo','renato',NULL),(11,'lolo','renato',NULL),(12,'lolo','renato',NULL),(13,'lolo','renato',NULL),(14,'lolo','renato',NULL),(15,'lolo','renato',NULL),(16,'lolo','renato',NULL),(17,'lolo','renato',NULL),(18,'lolo','renato',NULL),(19,'lolo','renato',NULL),(20,'lolo','renato',NULL),(22,'rene','renato',NULL),(23,'','',NULL),(24,'lolomagico','renato',NULL),(25,'lolomagico','renato',NULL),(26,'lolomagico','renato',NULL),(27,'lolomagico','renato',NULL),(28,'renatico magico','renato',NULL),(29,'renatico magico','renato',NULL),(30,'renatico magico with emails','renato',NULL),(31,'renatico magico with emails','renato',NULL),(32,'renatico magico with emails','renato',NULL),(33,'renatico magico with emails','renato',NULL),(34,'','','./images/'),(35,'','','./images/'),(36,'','','./images/'),(37,'','','./images/'),(38,'lolamente','renato',', '),(39,'renatico magico with','renato','./images/');
/*!40000 ALTER TABLE `phone_books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phone_numbers`
--

DROP TABLE IF EXISTS `phone_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phone_numbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number_phone` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `id_phone_book` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone_numbers`
--

LOCK TABLES `phone_numbers` WRITE;
/*!40000 ALTER TABLE `phone_numbers` DISABLE KEYS */;
INSERT INTO `phone_numbers` VALUES (1,'2462021020',20),(2,'123456789',20),(5,'2462021020',22),(6,'123456789',22),(7,'2462021020',24),(8,'123456789',24),(9,'2462021020',25),(10,'123456789',25),(11,'2462021020',28),(12,'123456789',28),(13,'2462021020',29),(14,'123456789',29),(15,'2462021020',0),(16,'123456789',0),(17,'2462021020',0),(18,'123456789',0),(19,'2462021020',0),(20,'123456789',0),(21,'2462021020',0),(22,'123456789',0),(23,'2462021020',0),(24,'123456789',0),(25,'2462021020',31),(26,'123456789',31),(27,'2462021020',32),(28,'123456789',32),(29,'2462021020',33),(30,'123456789',33),(31,'2462021020',0),(32,'123456789',0),(33,'2462021020',0),(34,'123456789',0),(35,'2462021020',39),(36,'123456789',39),(37,'2462024116',38),(38,'123452620',38);
/*!40000 ALTER TABLE `phone_numbers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-27  9:31:34
