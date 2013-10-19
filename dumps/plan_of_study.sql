-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 19, 2013 at 06:45 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ogsps`
--

-- --------------------------------------------------------

--
-- Table structure for table `plan_of_study`
--

CREATE TABLE IF NOT EXISTS `plan_of_study` (
  `Student_no` char(10) NOT NULL,
  `Course_code` char(10) NOT NULL,
  `Sem` enum('1st','2nd','SUMMER') NOT NULL,
  `Year` enum('1st','2nd','3rd','4th') NOT NULL,
  `Units` enum('0.0','5.0','3.0') NOT NULL,
  `Grade` enum('1.0','1.25','1.5','1.75','2.0','2.25','2.5','2.75','3.0','4.0','5.0') DEFAULT NULL,
  PRIMARY KEY (`Student_no`,`Course_code`,`Sem`,`Year`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
