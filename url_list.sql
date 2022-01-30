-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jan 23, 2022 at 08:00 PM
-- Server version: 10.3.14-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `speqta_workers`
--

-- --------------------------------------------------------

--
-- Table structure for table `url_list`
--

DROP TABLE IF EXISTS `url_list`;
CREATE TABLE IF NOT EXISTS `url_list` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `http_code` smallint(5) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `url_list`
--

INSERT INTO `url_list` (`id`, `url`, `status`, `http_code`) VALUES
(1, 'https://google.com', 'DONE', 200),
(2, 'https://www.reddit.com', 'DONE', 200),
(3, 'https://www.youtube.com', 'DONE', 200),
(4, 'https://twitter.com', 'DONE', 200),
(5, 'https://medium.com', 'DONE', 200),
(21, 'https://github.com/', 'NEW', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
