-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 12. čec 2015, 23:09
-- Verze serveru: 5.1.49
-- Verze PHP: 5.4.43

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `your-db-name`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `wp_instaapi_userdata`
--

CREATE TABLE IF NOT EXISTS `wp_instaapi_userdata` (
  `id_i_ud` int(11) NOT NULL AUTO_INCREMENT,
  `instagram_id` text COLLATE utf8_czech_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `followed_by` int(11) NOT NULL,
  `follows` int(11) NOT NULL,
  `media` int(11) NOT NULL,
  `bio` text COLLATE utf8_czech_ci NOT NULL,
  `website` text COLLATE utf8_czech_ci NOT NULL,
  `fulname` text COLLATE utf8_czech_ci NOT NULL,
  `profile_picture` text COLLATE utf8_czech_ci NOT NULL,
  `existuje` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_i_ud`),
  UNIQUE KEY `username_2` (`username`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=48634 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `wp_instaapi_vazby2`
--

CREATE TABLE IF NOT EXISTS `wp_instaapi_vazby2` (
  `id_i_vazby` int(11) NOT NULL AUTO_INCREMENT,
  `userA` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `userB` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `zdroj` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `vazba` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `id_fotky` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_i_vazby`),
  KEY `userA` (`userA`),
  KEY `userB` (`userB`),
  KEY `zdroj` (`zdroj`),
  KEY `vazba` (`vazba`),
  KEY `id_fotky` (`id_fotky`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=140718 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
