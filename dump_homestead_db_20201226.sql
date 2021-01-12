-- MySQL dump 10.13  Distrib 5.7.31, for Linux (x86_64)
--
-- Host: localhost    Database: homestead
-- ------------------------------------------------------
-- Server version	5.7.31-0ubuntu0.18.04.1

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
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext COLLATE utf8mb4_bin,
  `body` text COLLATE utf8mb4_bin,
  `created_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ads`
--

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;
INSERT INTO `ads` VALUES (1,'Test 1 ads','Sed quis interdum nunc. Aenean eget accumsan odio, nec elementum ipsum. In viverra fermentum scelerisque. In commodo leo non massa tristique, et convallis massa ornare. Quisque sit amet fermentum quam. Nullam quis arcu sed mauris euismod cursus ut quis erat. Aliquam erat volutpat. Duis vitae est vel erat finibus elementum ac a mi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nulla non libero quam. Etiam ac accumsan ante, in tristique ex. Maecenas malesuada venenatis urna non posuere. Fusce placerat accumsan erat, eget feugiat magna vestibulum ut. Pellentesque maximus ligula non eros tristique mattis.','2020-12-25 17:48:14',1),(2,'Test 2 ads','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eu ipsum eget arcu semper ultricies. Nam mattis, augue a tincidunt aliquam, risus metus mattis massa, et suscipit urna quam quis nisi. Donec dolor tortor, suscipit in convallis eu, iaculis eu nisl. Donec vitae urna malesuada, molestie ex eu, semper urna. Aenean rutrum finibus felis, eu posuere sem finibus eu. Aliquam leo nunc, semper sed malesuada eget, condimentum ut enim. Pellentesque eu varius velit. Integer libero elit, finibus ut blandit quis, rutrum id nisi. Sed nec ipsum eu tortor iaculis eleifend a ac est. Integer eget consequat tellus. Aliquam erat volutpat. Nunc condimentum nibh id feugiat efficitur. Nulla accumsan vel urna ac viverra. Praesent vestibulum in eros sit amet ullamcorper.','2020-12-25 17:49:41',1),(3,'Test 3 ads','Aenean lacinia scelerisque urna. Vestibulum fermentum, magna non faucibus porta, purus massa rhoncus ipsum, eget euismod nunc tortor in orci. Nullam efficitur leo nec eros semper sollicitudin. Morbi ac fermentum dolor. Etiam tempus lobortis euismod. Suspendisse a ante eget orci ornare placerat. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris orci mauris, interdum sit amet pulvinar nec, euismod in lacus. Etiam euismod sit amet justo quis elementum. Sed interdum convallis tortor in viverra. Vivamus accumsan neque sed arcu aliquam viverra. Curabitur non odio in eros vehicula viverra sit amet sed felis. Morbi euismod quis nibh ut interdum. Nullam mollis mi ac venenatis maximus.','2020-12-26 10:39:26',1),(4,'Test 4 ads','Ut nec tortor sit amet sapien iaculis gravida. Donec iaculis sapien in tortor dictum iaculis. Etiam viverra ante libero, imperdiet faucibus felis tincidunt nec. Maecenas ut lacinia nisl. Donec vel porttitor felis, eget consequat arcu. Vestibulum tincidunt tellus vel eros dignissim consectetur. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pretium tincidunt porttitor. Aliquam sem nulla, varius sed libero quis, interdum viverra ante. Suspendisse a dolor id ante suscipit convallis sit amet eu odio.','2020-12-26 10:41:24',1);
/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_bin NOT NULL,
  `email` text COLLATE utf8mb4_bin NOT NULL,
  `password` tinytext COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Table of all users';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Alex','alex.test@gmail.com','test1234','2020-12-25 07:26:15',1),(2,'Max','max.test@gmail.com','test987','2020-12-25 07:27:34',1),(3,'Jhon','jhon.test@gmail.com','test4567','2020-12-25 07:31:05',1),(4,'Ilon','ilon.test@gmail.com','test5432','2020-12-25 07:32:54',1);
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

-- Dump completed on 2020-12-26 20:52:42
