-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: taxisys
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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `accountID` smallint(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `emailAddress` varchar(30) NOT NULL,
  `phoneNumber` varchar(15) DEFAULT NULL,
  `status` enum('a','i') DEFAULT NULL,
  PRIMARY KEY (`accountID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'arthurM','morgan1899','arthurM@gmail.com','0845678901','a'),(2,'rioF','ferdinand3','rioF@hotmail.com','0876543210','a'),(3,'nani','nani08no9','nani@gmail.com','0854321098','a'),(4,'dutch','got1plan','dutch@amail.com','0890123456','a'),(5,'bill','w1lliamson','bill@mtu.com','0887654321','a'),(6,'john','marston1900','john@bingmail.com','0843210987','a'),(7,'jackmac','carthy28','jackmac@gmail.com','0812345670','a'),(8,'eddiemac','egghead19','eddiemac@hotmail.com','0834567890','a'),(9,'tom','gman1234','tom@gmail.com','0821098765','a'),(10,'brian','bizzyP123','brian@gmail.com','0865432109','a');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `bookingID` smallint(4) NOT NULL AUTO_INCREMENT,
  `driverID` smallint(4) NOT NULL,
  `accountID` smallint(4) NOT NULL,
  `timestart` datetime DEFAULT NULL,
  `timeend` datetime DEFAULT NULL,
  `destination` varchar(30) NOT NULL,
  `passengers` tinyint(1) NOT NULL,
  `cost` decimal(5,2) DEFAULT NULL,
  `status` enum('a','f') DEFAULT NULL,
  PRIMARY KEY (`bookingID`),
  KEY `driverID` (`driverID`),
  KEY `accountID` (`accountID`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`driverID`) REFERENCES `drivers` (`driverID`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`accountID`) REFERENCES `accounts` (`accountID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (1,1,1,'2024-04-27 15:08:43','2024-04-27 16:01:42','fenit',2,24.60,'f'),(2,6,1,'2024-04-27 15:31:21','2024-04-27 16:01:56','Spa',2,15.80,'f'),(3,8,1,'2024-04-27 16:34:09','2024-04-27 17:04:40','killarney',1,15.80,'f'),(4,1,1,'2024-04-27 16:35:52','2024-04-27 17:06:03','killorglin',1,15.80,'f');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drivers`
--

DROP TABLE IF EXISTS `drivers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drivers` (
  `driverID` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `phoneNumber` varchar(15) DEFAULT NULL,
  `driverLicenseNo` varchar(9) NOT NULL,
  `carMake` varchar(15) DEFAULT NULL,
  `carModel` varchar(15) DEFAULT NULL,
  `carRegNo` varchar(14) NOT NULL,
  `carNoSeats` tinyint(1) DEFAULT NULL,
  `status` enum('a','b','i') DEFAULT NULL,
  PRIMARY KEY (`driverID`),
  UNIQUE KEY `driverLicenseNo` (`driverLicenseNo`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drivers`
--

LOCK TABLES `drivers` WRITE;
/*!40000 ALTER TABLE `drivers` DISABLE KEYS */;
INSERT INTO `drivers` VALUES (1,'DJ McCarthy','0871234567','123456789','Renault','Megane','12-KY-211',4,'a'),(2,'Emma Smith','0872345678','987654321','Toyota','Yaris','151-D-345',5,'a'),(3,'John Doe','0873456789','567890123','Ford','Focus','08-D-456',3,'a'),(4,'Alice Johnson','0874567890','901234567','Hyundai','i10','11-L-57',3,'a'),(5,'Bob Williams','0875678901','234567890','Honda','Civic','212-D-6728',7,'a'),(6,'Sophia Brown','0876789012','678901234','Toyota','Corrolla','162-D-789',5,'a'),(7,'Sarah Williams','0876789012','456789012','Hyundai','i30','201-L-567',4,'a'),(8,'David Wilson','0877890123','567890133','Nissan','Qashqai','192-D-890',5,'a'),(9,'Laura Taylor','0878901234','678902234','Kia','Sportage','181-KY-901',5,'a'),(10,'Ryan Martinez','0879012345','789013345','BMW','3 Series','131-C-456',5,'a'),(11,'Jennifer Garcia','0870123456','890123556','Mercedes-Benz','C-Class','181-G-789',4,'a');
/*!40000 ALTER TABLE `drivers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-27 16:40:13
