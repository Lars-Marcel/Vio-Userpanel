-- phpMyAdmin SQL Dump
-- version 4.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 18. Mrz 2016 um 17:29
-- Server-Version: 5.5.47-0+deb8u1-log
-- PHP-Version: 7.0.4-1~dotdeb+8.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `vioex`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `coins`
--

CREATE TABLE IF NOT EXISTS `coins` (
  `Name` varchar(255) NOT NULL,
  `Coins` int(15) NOT NULL,
  `txn` text NOT NULL,
  `psc` text NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `marktplatz`
--

CREATE TABLE IF NOT EXISTS `marktplatz` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `seller` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(15) NOT NULL,
  `buyer` varchar(50) NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `objecttyp` varchar(25) NOT NULL,
  `objectID` int(8) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `support`
--

CREATE TABLE IF NOT EXISTS `support` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `player` text NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `state` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

ALTER TABLE `players` ADD `ts3uid` TEXT NOT NULL;