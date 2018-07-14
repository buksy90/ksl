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

LOCK TABLES `v2_game_roster` WRITE;
/*!40000 ALTER TABLE `v2_game_roster` DISABLE KEYS */;
TRUNCATE TABLE `v2_game_roster`;
INSERT INTO `v2_game_roster` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1);
/*!40000 ALTER TABLE `v2_game_roster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `games`
--

LOCK TABLES `v2_games` WRITE;
/*!40000 ALTER TABLE `v2_games` DISABLE KEYS */;
TRUNCATE TABLE `v2_games`;
INSERT INTO `v2_games` VALUES (1,1,1,2,"2010-1-02 15:30",1,1,'home',11,2),(2,1,2,1,"2028-12-18 15:30",1,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `v2_games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `players`
--

LOCK TABLES `v2_players` WRITE;
/*!40000 ALTER TABLE `v2_players` DISABLE KEYS */;
TRUNCATE TABLE `v2_players`;
INSERT INTO `v2_players` 
VALUES 
(1,'Michael','Jordan','air_jordan','Air Jordan','1963-02-17',23,'A','https://www.facebook.com/likemikelegend/',198,98,'male'),
(2,'Dennis','Rodman','the_worm','The Worm','1961-05-13',91,'A','https://www.facebook.com/DennisRodman/',201,100,'male'),
(3,'Scottie','Pippen','scottie_pippen','','1965-09-25',33,'A','',203,103,'male'),
(4,'Player','1','player_1','','1990-01-01',1,'B','',185,80,'male'),
(5,'Player','2','player_2','','1990-01-01',2,'B','',195,90,'male'),
(6,'Player','3','player_3','','1990-01-01',3,'B','',175,70,'male'),
(7,'Free','Agent','free_agent','','1995-01-01',0,'B','',168,84,'male');
/*!40000 ALTER TABLE `v2_players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `playground`
--

LOCK TABLES `v2_playground` WRITE;
/*!40000 ALTER TABLE `v2_playground` DISABLE KEYS */;
TRUNCATE TABLE `v2_playground`;
INSERT INTO `v2_playground` VALUES (1,'Playground 1','playground_1','Test Address','Test',99.99999999,44.00000000);
/*!40000 ALTER TABLE `v2_playground` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `roster`
--

LOCK TABLES `v2_roster` WRITE;
/*!40000 ALTER TABLE `v2_roster` DISABLE KEYS */;
TRUNCATE TABLE `v2_roster`;
INSERT INTO `v2_roster` VALUES (1,1,1),(1,2,1),(1,3,1),(2,4,1),(2,5,1),(2,6,1);
/*!40000 ALTER TABLE `v2_roster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `score_list`
--

LOCK TABLES `v2_score_list` WRITE;
/*!40000 ALTER TABLE `v2_score_list` DISABLE KEYS */;
TRUNCATE TABLE `v2_score_list`;
INSERT INTO `v2_score_list` 
VALUES 
(1, 1, 1000, 2),
(1, 1, 2000, 2),
(1, 1, 3000, 2),
(1, 1, 4000, 2),
(1, 3, 5000, 3);
/*!40000 ALTER TABLE `v2_score_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `season`
--

LOCK TABLES `v2_season` WRITE;
/*!40000 ALTER TABLE `v2_season` DISABLE KEYS */;
TRUNCATE TABLE `v2_season`;
INSERT INTO `v2_season` VALUES (1,'2017',2017,1);
/*!40000 ALTER TABLE `v2_season` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `teams`
--

LOCK TABLES `v2_teams` WRITE;
/*!40000 ALTER TABLE `v2_teams` DISABLE KEYS */;
TRUNCATE TABLE `v2_teams`;
INSERT INTO `v2_teams` VALUES (1,'Bulls','BUL',1),(2,'Team A','TEA',4),(3,'Team X','X',0);
/*!40000 ALTER TABLE `v2_teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `weather`
--

LOCK TABLES `v2_weather` WRITE;
/*!40000 ALTER TABLE `v2_weather` DISABLE KEYS */;
TRUNCATE TABLE `v2_weather`;
/*!40000 ALTER TABLE `v2_weather` ENABLE KEYS */;
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
