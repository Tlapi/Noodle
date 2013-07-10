-- phpMyAdmin SQL Dump
-- version 4.0.0-beta2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 10, 2013 at 11:53 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `noodle2`
--

-- --------------------------------------------------------

--
-- Table structure for table `filebank`
--

CREATE TABLE IF NOT EXISTS `filebank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `size` int(11) NOT NULL,
  `mimetype` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `isactive` int(11) NOT NULL,
  `savepath` varchar(250) COLLATE utf8_czech_ci NOT NULL,
  `keywords` varchar(500) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `filebank_keyword`
--

CREATE TABLE IF NOT EXISTS `filebank_keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileid` int(11) NOT NULL,
  `value` varchar(250) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_row_id` int(11) DEFAULT NULL,
  `parent_entity` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `select_id` int(11) NOT NULL,
  `picture` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `parent_row_id`, `parent_entity`, `name`, `title`, `select_id`, `picture`) VALUES
(2, NULL, NULL, 'asdf', 'asdf', 0, 0),
(3, NULL, NULL, 'test', '', 0, 0),
(4, NULL, NULL, 'asdf', 'asdf', 1, 0),
(5, NULL, NULL, 'sadf', '', 1, 0),
(6, NULL, NULL, 'asdf', '', 1, 0),
(7, NULL, NULL, 'asd', 'asd', 3, 0),
(8, NULL, NULL, 'asd', 'asd', 3, 0),
(9, NULL, NULL, 'asd', 'asd', 3, 0),
(10, NULL, NULL, 'asd', 'asd', 3, 0),
(11, NULL, NULL, 'Three', 'asd', 3, 0),
(12, NULL, NULL, 'Three', '', 3, 0),
(13, NULL, NULL, 'Three', '', 3, 0),
(14, NULL, NULL, 'asdf', 'asdf', 1, 0),
(15, NULL, NULL, 'asdf', '', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `relation`
--

CREATE TABLE IF NOT EXISTS `relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_row_id` int(11) DEFAULT NULL,
  `parent_entity` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `description` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_row_id` (`parent_row_id`,`parent_entity`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `relation`
--

INSERT INTO `relation` (`id`, `parent_row_id`, `parent_entity`, `title`, `description`) VALUES
(1, NULL, NULL, 'title', 'description'),
(3, NULL, NULL, 'My another row', 'Description'),
(5, 15, 'Modules\\Entity\\Test', 'asdfsadf', ''),
(6, 15, 'Modules\\Entity\\Test', 'asdfsadf2', ''),
(7, 15, 'Modules\\Entity\\Test', 'asadsa 9f87987', ' a6sd7f68 7adsf');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
