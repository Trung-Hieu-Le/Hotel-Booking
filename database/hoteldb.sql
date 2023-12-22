-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: hoteldb
-- ------------------------------------------------------
-- Server version	5.7.33

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
-- Table structure for table `chosen_room`
--

DROP TABLE IF EXISTS `chosen_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chosen_room` (
  `reservation_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  PRIMARY KEY (`reservation_id`,`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chosen_room`
--

LOCK TABLES `chosen_room` WRITE;
/*!40000 ALTER TABLE `chosen_room` DISABLE KEYS */;
INSERT INTO `chosen_room` VALUES (14,4),(14,10),(22,10),(22,13),(23,11),(24,14),(25,11),(30,11),(30,12),(31,11),(31,12),(32,12),(33,4),(36,13),(37,4),(39,11),(41,12),(41,13),(46,11),(53,14),(54,13),(55,12),(57,4),(58,4),(58,12),(59,22);
/*!40000 ALTER TABLE `chosen_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chosen_service`
--

DROP TABLE IF EXISTS `chosen_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chosen_service` (
  `reservation_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`reservation_id`,`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chosen_service`
--

LOCK TABLES `chosen_service` WRITE;
/*!40000 ALTER TABLE `chosen_service` DISABLE KEYS */;
INSERT INTO `chosen_service` VALUES (1,5),(11,4),(12,4),(12,5),(13,4),(14,6),(15,4),(15,5),(16,4),(16,5),(16,6),(16,8),(16,9),(16,10),(16,11),(21,4),(22,6),(23,8),(24,9),(25,5),(25,6),(30,4),(30,5),(31,4),(31,5),(32,5),(32,6),(32,8),(33,4),(33,5),(33,6),(36,4),(36,5),(37,4),(37,5),(39,5),(39,8),(39,12),(41,4),(41,5),(41,6),(41,8),(41,12),(46,8),(53,5),(53,6),(54,4),(54,5),(54,6),(54,8),(55,6),(55,8),(57,4),(57,5),(57,6),(57,8),(57,12),(58,4),(58,14),(58,15),(59,4),(59,5),(59,6),(59,8),(59,12),(59,13),(59,14),(59,15);
/*!40000 ALTER TABLE `chosen_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_id` int(11) NOT NULL,
  `room_total` int(15) NOT NULL,
  `service_total` int(15) NOT NULL,
  `final_total` int(15) NOT NULL,
  `method` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (109,32,10000000,400000,10400000,'Tiá»n máº·t','2023-12-21 07:03:31'),(110,33,1000000,400000,1400000,'Tiá»n máº·t','2023-12-21 07:03:46'),(112,36,8000000,450000,8450000,'Chuyá»ƒn khoáº£n','2023-12-21 07:03:59'),(113,37,2000000,600000,2600000,'Tiá»n máº·t','2023-12-21 07:04:07'),(114,41,6000000,3000000,9000000,'Chuyá»ƒn khoáº£n','2023-12-21 07:04:16'),(115,53,4000000,350000,4350000,'Tiá»n máº·t','2023-12-21 07:04:26'),(116,55,1000000,600000,1600000,'Tiá»n máº·t','2023-12-21 07:04:43'),(122,58,12000000,1600000,13600000,'Tiá»n máº·t','2023-12-22 00:42:30');
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `address` varchar(500) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_room` int(5) NOT NULL,
  `no_guess` int(5) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `no_day` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
INSERT INTO `reservation` VALUES (32,'LÃª Minh TÃ¹ng','','04848654551','',1,1,'2023-12-13','2023-12-22',10,1,'','2023-12-13 05:41:32'),(33,'Anh TÃº','','0254254221','',1,1,'2023-12-13','2023-12-13',1,1,'','2023-12-13 06:21:01'),(36,'Nguyá»…n HoÃ ng Äá»©c','','0123456789','',1,3,'2023-12-13','2023-12-16',4,1,'','2023-12-13 14:09:32'),(37,'Minh','','0425458542','',1,4,'2023-12-14','2023-12-15',2,1,'','2023-12-14 05:47:05'),(39,'Anh ThÆ°','ttgdegdrg','0427872876','letrunghieuconj@gmail.com',1,2,'2023-12-31','2024-01-01',2,2,'','2023-12-14 06:50:50'),(41,'Nguyá»…n Thá»‹ ThÆ¡m','TP. HCM','0425458250','',2,4,'2023-12-15','2023-12-16',2,1,'','2023-12-15 02:12:43'),(46,'Nguyá»…n Gia HÆ°ng','Báº¡ch Mai, Hai BÃ  TrÆ°ng, HÃ  Ná»™i','0123456789','Rio_de_Janeiro@gmail.com',1,1,'2023-12-18','2023-12-19',2,0,'khÃ´ng cÃ³','2023-12-18 06:11:41'),(53,'Anh Duy','','0345708107','',1,1,'2024-01-01','2024-01-02',2,1,'','2023-12-18 06:35:47'),(54,'Nguyá»…n Thá»‹ ThÃ¹y Trang','TP. HCM','0344785420','Rio_de_Janeiro@gmail.com',1,1,'2023-12-18','2023-12-20',3,0,'khÃ´ng cÃ³','2023-12-18 06:57:13'),(55,'Äinh Trung DÅ©ng','ttgdegdrg','0386746841','letrunghieuconj@gmail.com',1,2,'2024-01-26','2024-01-26',1,1,'','2023-12-18 07:04:40'),(57,'Trung Hiáº¿u','HÃ  Ná»™i abc','0123456789','johnny123@gmail.com',1,8,'2023-12-24','2023-12-30',7,2,'','2023-12-21 04:46:52'),(58,'PhÃ¹ng VÄƒn VÅ©','NhÃ  BÃ¨','0345678912','pvvu@gmail.com',2,4,'2023-12-31','2024-01-05',6,1,'','2023-12-21 06:48:38'),(59,'William','Amsterdam','0545415153','willi@gmail.com',1,2,'2024-02-13','2024-02-15',3,0,'Can you put some scented candles in my room?','2023-12-21 06:55:49');
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(15) NOT NULL,
  `room_type` varchar(15) NOT NULL,
  `price` int(15) DEFAULT NULL,
  `no_guess` int(5) NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES (4,'104','standard',1000000,4,'phÃ²ng hai giÆ°á»ng Ä‘Ã´i',1),(11,'105','standard',1000000,2,'',2),(12,'106','standard',1000000,3,'',1),(13,'108','superior',2000000,3,'',2),(14,'109','superior',2000000,4,'',1),(16,'201','superior',2000000,2,'',1),(17,'203','deluxe',3000000,2,NULL,1),(18,'204','deluxe',3000000,4,NULL,1),(19,'205','deluxe',3000000,4,NULL,1),(20,'206','superior',2000000,3,NULL,1),(21,'207','suite',4000000,2,'beach view',1),(22,'209','suite',4000000,2,'beach view',2),(23,'301','deluxe',3000000,4,NULL,1),(24,'302','suite',4000000,3,NULL,1),(25,'304','superior',2000000,4,NULL,1),(26,'306','superior',2000000,2,'maintaining',0),(27,'307','deluxe',3000000,3,NULL,1),(28,'308','deluxe',3000000,4,NULL,1),(29,'309','suite',4000000,2,NULL,1);
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` int(15) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (4,'Taxi',50000,'ThuÃª taxi',_binary ''),(5,'Giáº·t lÃ ',100000,'giáº·t khÃ´ lÃ  hÆ¡i',_binary ''),(6,'spa',250000,'',_binary ''),(8,'há»“ bÆ¡i',50000,'',_binary ''),(11,'SÃ¢n tennis',600000,'',_binary '\0'),(12,'PhÃ²ng xÃ´ng hÆ¡i',300000,'',_binary ''),(13,'Gym',120000,NULL,_binary ''),(14,'Ä‚n sÃ¡ng',150000,NULL,_binary ''),(15,'Ä‚n tá»‘i',200000,NULL,_binary '');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (5,'admin','123456','Admin'),(11,'admin2','123456','Receptionist');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-22  8:44:54
