-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 17, 2017 at 12:37 PM
-- Server version: 5.7.19
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`) VALUES
(1, 'Casino Milyon'),
(2, 'Casino Dunya');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `project_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `name`, `created`, `updated`, `priority`, `status`, `project_id`, `user_id`) VALUES
(1, 'HTML & fix', '2017-11-16 14:44:13', '2017-11-17 12:06:05', 1, 0, 2, 1),
(3, 'Bug fix', '2017-11-16 14:44:13', '2017-11-17 11:37:28', 0, 1, 1, 1),
(4, 'HTML fix 2', '2017-11-16 14:44:13', '2017-11-17 14:32:07', 2, 0, 2, 1),
(5, 'Test 1', '2017-11-17 10:23:46', '2017-11-17 11:39:37', 0, 0, 2, 1),
(6, 'Test', '2017-11-17 10:23:56', '2017-11-17 10:23:56', 0, 0, 2, 1),
(7, 'Test 1', '2017-11-17 10:24:53', '2017-11-17 12:20:16', 0, 0, 2, 1),
(8, 'Test', '2017-11-17 10:24:55', '2017-11-17 10:24:55', 0, 0, 2, 1),
(9, 'New design', '2017-11-17 14:32:31', '2017-11-17 14:32:31', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `psw` varchar(33) NOT NULL,
  `tocken` varchar(33) DEFAULT NULL,
  `expires` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_name`, `psw`, `tocken`, `expires`) VALUES
(1, 'Test', 'test', '098f6bcd4621d373cade4e832627b4f6', '613fk2kceq51og1ijenn0itka5', 1510923411);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
