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

DROP TABLE IF EXISTS `v2_game_roster`;
DROP TABLE IF EXISTS `v2_user_permissions`;
DROP TABLE IF EXISTS `v2_games`;
DROP TABLE IF EXISTS `v2_players`;
DROP TABLE IF EXISTS `v2_playground`;
DROP TABLE IF EXISTS `v2_roster`;
DROP TABLE IF EXISTS `v2_score_list`;
DROP TABLE IF EXISTS `v2_season`;
DROP TABLE IF EXISTS `v2_teams`;
DROP TABLE IF EXISTS `v2_thumbs`;
DROP TABLE IF EXISTS `v2_weather`;
DROP TABLE IF EXISTS `v2_pending_teams`;
DROP TABLE IF EXISTS `v2_news`;
DROP TABLE IF EXISTS `v2_users`;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `games`
--

CREATE TABLE IF NOT EXISTS `v2_games` (
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

CREATE TABLE `v2_players` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `seo` varchar(32) NOT NULL,
  `nick` varchar(16) NOT NULL,
  `birthdate` datetime NOT NULL,
  `jersey` tinyint(3) unsigned NOT NULL,
  `category` enum(''A'',''B'') NOT NULL,
  `facebook` varchar(64) NOT NULL,
  `height` smallint(6) DEFAULT NULL,
  `weight` smallint(6) DEFAULT NULL,
  `sex` enum(''male'',''female'') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8


-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `playground`
--

CREATE TABLE IF NOT EXISTS `v2_playground` (
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

CREATE TABLE IF NOT EXISTS `v2_roster` (
  `team_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `season_id` tinyint(3) unsigned NOT NULL,
  UNIQUE KEY `player_id` (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `score_list`
--

CREATE TABLE IF NOT EXISTS `v2_score_list` (
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

CREATE TABLE IF NOT EXISTS `v2_season` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(5) NOT NULL,
  `year` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `v2_season` SET `name` = "2018", `year` = "2018", `active` = "1";

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `teams`
--

CREATE TABLE IF NOT EXISTS `v2_teams` (
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

CREATE TABLE IF NOT EXISTS `v2_thumbs` (
  `VID` int(10) unsigned NOT NULL DEFAULT '0',
  `thumbs_up` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `thumbs_down` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `weather`
--

CREATE TABLE IF NOT EXISTS `v2_weather` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `hour` tinyint(3) unsigned NOT NULL,
  `type` enum('temperature','temperature_feel','humidity','rain') NOT NULL,
  `value` decimal(3,1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`,`hour`,`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=673 ;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `v2_game_roster` (
  `player_id` int(11) unsigned NOT NULL,
  `game_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `unique` (`player_id`,`game_id`),
  KEY `fk_game_roster_2_idx` (`game_id`),
  CONSTRAINT `fk_game_roster_1` FOREIGN KEY (`player_id`) REFERENCES `v2_players` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_game_roster_2` FOREIGN KEY (`game_id`) REFERENCES `v2_games` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `pending_teams`
--

CREATE TABLE IF NOT EXISTS `v2_pending_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `short` char(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `news`
--

CREATE TABLE IF NOT EXISTS `v2_news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf32_slovak_ci NOT NULL,
  `text` text COLLATE utf32_slovak_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf32 COLLATE=utf32_slovak_ci;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `user`
--

CREATE TABLE IF NOT EXISTS `v2_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(45) COLLATE utf32_slovak_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf32_slovak_ci DEFAULT NULL,
  `firstName` varchar(45) COLLATE utf32_slovak_ci DEFAULT NULL,
  `lastName` varchar(45) COLLATE utf32_slovak_ci DEFAULT NULL,
  `avatarUrl` varchar(255) COLLATE utf32_slovak_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf32 COLLATE=utf32_slovak_ci;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `user_permissions`
--

CREATE TABLE IF NOT EXISTS `v2_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission` enum('none','admin') COLLATE utf32_slovak_ci NOT NULL,
  PRIMARY KEY (`user_id`,`permission`)
) ENGINE=MyISAM DEFAULT CHARSET=utf32 COLLATE=utf32_slovak_ci;
