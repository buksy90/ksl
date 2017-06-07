-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Hostiteľ: 127.0.0.1
-- Vygenerované: Št 23.Feb 2017, 09:27
-- Verzia serveru: 5.5.50-0ubuntu0.14.04.1
-- Verzia PHP: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databáza: `c9`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `games`
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE IF NOT EXISTS `games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `season_id` tinyint(3) unsigned NOT NULL,
  `hometeam` int(11) NOT NULL,
  `awayteam` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `playground_id` int(11) NOT NULL,
  `referee` int(11) NOT NULL,
  `won` enum('home','away') DEFAULT NULL,
  `home_score` tinyint(3) unsigned DEFAULT NULL,
  `away_score` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `players`
--

DROP TABLE IF EXISTS `players`;
CREATE TABLE `players` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `seo` varchar(32) NOT NULL,
  `nick` varchar(16) NOT NULL,
  `birthdate` int(10) unsigned NOT NULL,
  `jersey` tinyint(3) unsigned NOT NULL,
  `category` enum('A','B') NOT NULL,
  `facebook` varchar(64) NOT NULL,
  `height` smallint(6) DEFAULT NULL,
  `weight` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `playground`
--

DROP TABLE IF EXISTS `playground`;
CREATE TABLE IF NOT EXISTS `playground` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `link` varchar(16) NOT NULL,
  `address` varchar(64) NOT NULL,
  `district` varchar(16) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `roster`
--

DROP TABLE IF EXISTS `roster`;
CREATE TABLE IF NOT EXISTS `roster` (
  `team_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `season_id` tinyint(3) unsigned NOT NULL,
  UNIQUE KEY `player_id` (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `score_list`
--

DROP TABLE IF EXISTS `score_list`;
CREATE TABLE IF NOT EXISTS `score_list` (
  `game_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `value` tinyint(4) NOT NULL,
  UNIQUE KEY `game_id` (`game_id`,`player_id`,`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `season`
--

DROP TABLE IF EXISTS `season`;
CREATE TABLE IF NOT EXISTS `season` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(5) NOT NULL,
  `year` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `short` varchar(3) NOT NULL,
  `captain_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `thumbs`
--

DROP TABLE IF EXISTS `thumbs`;
CREATE TABLE IF NOT EXISTS `thumbs` (
  `VID` int(10) unsigned NOT NULL DEFAULT '0',
  `thumbs_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `thumbs_down` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `weather`
--

DROP TABLE IF EXISTS `weather`;
CREATE TABLE IF NOT EXISTS `weather` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `hour` tinyint(3) unsigned NOT NULL,
  `type` enum('temperature','temperature_feel','humidity','rain') NOT NULL,
  `value` decimal(3,1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`,`hour`,`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=673 ;

-- --------------------------------------------------------


DROP TABLE IF EXISTS `game_roster`;
CREATE TABLE `game_roster` (
  `player_id` int(11) unsigned NOT NULL,
  `game_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `unique` (`player_id`,`game_id`),
  KEY `fk_game_roster_2_idx` (`game_id`),
  CONSTRAINT `fk_game_roster_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_game_roster_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `pending_teams`
--

CREATE TABLE `pending_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `short` char(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------