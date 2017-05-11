-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: ksl_test
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Dumping data for table `game_roster`
--

LOCK TABLES `game_roster` WRITE;
/*!40000 ALTER TABLE `game_roster` DISABLE KEYS */;
INSERT INTO `game_roster` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1);
/*!40000 ALTER TABLE `game_roster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,1,1,2,1485957600,1,1,'home',11,2),(2,1,2,1,1738418400,1,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `players`
--

LOCK TABLES `players` WRITE;
/*!40000 ALTER TABLE `players` DISABLE KEYS */;
INSERT INTO `players` VALUES (1,'Michael','Jordan','air_jordan','Air Jordan','1963-02-17',23,'A','https://www.facebook.com/likemikelegend/',198,98),(2,'Dennis','Rodman','the_worm','The Worm','1961-05-13',91,'A','https://www.facebook.com/DennisRodman/',201,100),(3,'Scottie','Pippen','scottie_pippen','','1965-09-25',33,'A','',203,103),(4,'Player','1','player_1','','1990-01-01',1,'B','',185,80),(5,'Player','2','player_2','','1990-01-01',2,'B','',195,90),(6,'Player','3','player_3','','1990-01-01',3,'B','',175,70),(7,'Free','Agent','free_agent','','1995-01-01',0,'B','',168,84);
/*!40000 ALTER TABLE `players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `playground`
--

LOCK TABLES `playground` WRITE;
/*!40000 ALTER TABLE `playground` DISABLE KEYS */;
INSERT INTO `playground` VALUES (1,'Playground 1','playground_1','Test Address','Test',99.99999999,44.00000000);
/*!40000 ALTER TABLE `playground` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `roster`
--

LOCK TABLES `roster` WRITE;
/*!40000 ALTER TABLE `roster` DISABLE KEYS */;
INSERT INTO `roster` VALUES (1,1,1),(1,2,1),(1,3,1),(2,4,1),(2,5,1),(2,6,1);
/*!40000 ALTER TABLE `roster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `score_list`
--

LOCK TABLES `score_list` WRITE;
/*!40000 ALTER TABLE `score_list` DISABLE KEYS */;
INSERT INTO `score_list` VALUES (363,1,1,1,10,'2'),(364,1,1,1,20,'2'),(365,1,1,1,30,'2'),(366,1,1,1,40,'2'),(367,1,3,1,50,'3'),(368,1,4,2,60,'2');
/*!40000 ALTER TABLE `score_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `season`
--

LOCK TABLES `season` WRITE;
/*!40000 ALTER TABLE `season` DISABLE KEYS */;
INSERT INTO `season` VALUES (1,'2017',2017,1);
/*!40000 ALTER TABLE `season` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'Bulls','BUL',1),(2,'Team A','TEA',4),(3,'Team X','X',0);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `weather`
--

LOCK TABLES `weather` WRITE;
/*!40000 ALTER TABLE `weather` DISABLE KEYS */;
/*!40000 ALTER TABLE `weather` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-11 12:23:08
