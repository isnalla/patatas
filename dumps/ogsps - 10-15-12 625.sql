-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2013 at 10:24 AM
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
CREATE DATABASE IF NOT EXISTS `ogsps` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ogsps`;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `Lecturer` varchar(100) NOT NULL,
  `Student_no` char(10) NOT NULL,
  `Course_code` varchar(10) NOT NULL,
  `Grade` enum('''1.0'',''1.25'',''1.5'',''1.75'',''2.0'',''2.25'',''2.5'',''2.75'',''3.0'',''4.0'',''5.0''') NOT NULL,
  `Remarks` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Lecturer`,`Student_no`,`Course_code`),
  KEY `grades_course_code_fk` (`Course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gradesheet`
--

CREATE TABLE IF NOT EXISTS `gradesheet` (
  `Lecturer` varchar(100) NOT NULL,
  `Course_code` varchar(10) NOT NULL,
  `Status` enum('PENDING','APPROVED','DISAPPROVED') NOT NULL,
  PRIMARY KEY (`Lecturer`,`Course_code`),
  KEY `Course_code` (`Course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `Course_code` varchar(10) NOT NULL,
  `Department` varchar(10) NOT NULL,
  PRIMARY KEY (`Course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `Role` enum('LEC','CLS','DPH','STD') NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Role`, `Username`, `Password`, `Name`) VALUES
('DPH', 'depthead', '4b5fa34addc47ec2e0df095cbecbe0c5c88b8723', 'Jaime Samaniego');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_course_code_fk` FOREIGN KEY (`Course_code`) REFERENCES `subject` (`Course_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grades_lecturer_fk` FOREIGN KEY (`Lecturer`) REFERENCES `gradesheet` (`Lecturer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gradesheet`
--
ALTER TABLE `gradesheet`
  ADD CONSTRAINT `gradesheet_course_code_fk` FOREIGN KEY (`Course_code`) REFERENCES `subject` (`Course_code`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
