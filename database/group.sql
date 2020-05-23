-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2014 at 05:29 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bookonline`
--

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `status`, `ordering`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Admin', 0, 2, '2013-11-11 03:32:33', 'admin', '2014-02-18 03:17:18', 'admin'),
(2, 'Manager', 0, 4, '2013-11-07 00:00:00', 'admin', '2013-12-03 00:00:00', 'admin'),
(3, 'Member', 0, 1, '2013-11-12 00:00:00', 'admin', '2014-02-18 00:00:00', 'admin'),
(4, 'Member 1', 1, 2, '2013-11-12 00:00:00', 'admin', '2014-02-18 00:00:00', 'admin'),
(5, 'Member 2', 1, 3, '2013-11-12 00:00:00', 'admin', '2014-02-18 00:00:00', 'admin'),
(6, 'Member 3', 1, 4, '2013-11-12 00:00:00', 'admin', '2014-02-18 00:00:00', 'admin'),
(7, 'Member 4', 1, 5, '2013-11-12 00:00:00', 'admin', '2014-02-18 00:00:00', 'admin'),
(8, 'Member 5', 1, 3, '2013-11-12 00:00:00', 'admin', '2014-02-18 00:00:00', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
