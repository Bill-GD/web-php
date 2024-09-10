-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: mysql-issue-tracker-dc87b75-issue-tracking-app.h.aivencloud.com    Database: issue_tracker_db
-- ------------------------------------------------------
-- Server version	8.0.30

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '4e4891df-6f22-11ef-a8bc-ee93b77d533a:1-15,
5cfac560-0939-11ef-b314-7223a2d6cf1b:1-906,
7ab57c63-64e8-11ef-975b-56cdcb166a04:1-15';

--
-- Table structure for table `issue`
--

DROP TABLE IF EXISTS `issue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `issue` (
  `issue_id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `priority` varchar(5) NOT NULL,
  `assignee` int DEFAULT NULL,
  `issuer` int DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`issue_id`),
  KEY `project_id` (`project_id`),
  KEY `assignee` (`assignee`),
  KEY `issuer` (`issuer`),
  CONSTRAINT `issue_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE,
  CONSTRAINT `issue_ibfk_2` FOREIGN KEY (`assignee`) REFERENCES `user` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `issue_ibfk_3` FOREIGN KEY (`issuer`) REFERENCES `user` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue`
--

LOCK TABLES `issue` WRITE;
/*!40000 ALTER TABLE `issue` DISABLE KEYS */;
INSERT INTO `issue` VALUES (1,1,'test_issue','This is a test issue for test project','closed','low',2,4,'2024-06-19 16:54:47','2024-06-20 07:54:01'),(2,1,'test issue 2','Test issue after fully implemented issue related features','pending','mid',4,4,'2024-06-19 19:54:22','2024-06-20 14:49:54'),(6,2,'1','11','closed','mid',NULL,3,'2024-06-19 23:39:28','2024-06-19 23:41:17'),(7,2,'2','afa','open','low',NULL,3,'2024-06-19 23:40:43','2024-06-19 23:40:43'),(8,2,'3','122333','cancelled','high',NULL,3,'2024-06-20 00:02:29','2024-06-20 17:50:29'),(10,4,'bugs in project','this is a bug','open','high',NULL,5,'2024-06-20 03:02:59','2024-06-20 03:02:59'),(11,5,'New Issue','Issue description','pending','high',2,9,'2024-06-20 15:30:17','2024-06-20 15:31:50'),(12,5,'Issue 2','Issue desc 2','open','high',NULL,9,'2024-06-20 15:33:10','2024-06-20 15:33:10'),(13,5,'Issue 3','Issue desc 3','tested','low',NULL,2,'2024-06-20 15:33:27','2024-06-20 17:50:27');
/*!40000 ALTER TABLE `issue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_image`
--

DROP TABLE IF EXISTS `issue_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `issue_image` (
  `image_id` int NOT NULL,
  `issue_id` int NOT NULL,
  `bytes` text NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `issue_id` (`issue_id`),
  CONSTRAINT `issue_image_ibfk_1` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`issue_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_image`
--

LOCK TABLES `issue_image` WRITE;
/*!40000 ALTER TABLE `issue_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `issue_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project` (
  `project_id` int NOT NULL AUTO_INCREMENT,
  `project_name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL,
  `owner` int NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`project_id`),
  KEY `owner` (`owner`),
  CONSTRAINT `project_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,'test_project_with_role','2024-06-17 19:06:24',4,'Save Owner role when this project is created. This shall be the project with ID of 1.'),(2,'second_project','2024-06-19 23:16:55',3,'2'),(4,'new project','2024-06-20 02:55:09',5,'1234'),(5,'New Project','2024-06-20 15:27:41',9,'Project description'),(6,'Test','2024-06-21 21:15:14',10,'Test');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_role`
--

DROP TABLE IF EXISTS `project_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_role` (
  `project_id` int NOT NULL,
  `user_id` int NOT NULL,
  `user_role` varchar(20) NOT NULL,
  PRIMARY KEY (`project_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `project_role_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE,
  CONSTRAINT `project_role_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_role`
--

LOCK TABLES `project_role` WRITE;
/*!40000 ALTER TABLE `project_role` DISABLE KEYS */;
INSERT INTO `project_role` VALUES (1,2,'tester'),(1,3,'tester'),(1,4,'owner'),(2,3,'owner'),(4,5,'owner'),(4,6,'tester'),(5,2,'tester'),(5,9,'owner'),(6,10,'owner');
/*!40000 ALTER TABLE `project_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `avatar_url` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL,
  `github_access_token` text,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin@gmail.com','admin','e3274be5c857fb42ab72d786e281b4b8','public/assets/admin_pfp.png',1,'2024-06-11 11:56:37',NULL),(2,'user2@gmail.com','User 2','6cb75f652a9b52798eb6cf2201057c73','public/assets/default_avatar.png',0,'2024-06-20 07:51:54',NULL),(3,'123@gmail.com','123','25f9e794323b453885f5181f1b624d0b','public/assets/default_avatar.png',0,'2024-06-12 13:59:02',NULL),(4,'geometrydashbill@gmail.com','Bill-GD','acd5c91a8b1e76382c58efab17a024e3','https://github.com/Bill-GD.png',0,'2024-06-14 18:29:08','67686f5f6f4e69573658474a384b597869427a4f57514943555953485a533675426c333663775857'),(5,'bachdoancris3@gmail.com','doanbach','83422503bcfc01d303030e8a7cc80efc','public/assets/default_avatar.png',0,'2024-06-19 23:56:42',NULL),(6,'bachdquan03@gmail.com','DoanHBach','25f9e794323b453885f5181f1b624d0b','https://github.com/DoanHBach.png',0,'2024-06-20 03:04:09','67686f5f6c374a4e5151453179775766416d47754355627a425566594c4a52744e75314834687455'),(8,'app@gmail.com','Nam','25d55ad283aa400af464c76d713c07ad','public/assets/default_avatar.png',0,'2024-06-20 14:39:31',NULL),(9,'21011878@st.phenikaa-uni.edu.vn','duongducbinh','5f4dcc3b5aa765d61d8327deb882cf99','https://github.com/duongducbinh.png',0,'2024-06-20 15:25:47','67686f5f64485a3437396d586e696c30456e384b6735714c447466787272445653573261334e4d46'),(10,'nglthu@gmail.com','Nglthu','ff0ea5ee83aaa8dd0b03e91a7b03276e','public/assets/default_avatar.png',0,'2024-06-21 21:13:54',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-10 11:02:29
