-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2013 at 07:16 PM
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
-- Table structure for table `college`
--

CREATE TABLE IF NOT EXISTS `college` (
  `College_name` enum('CA','CAS','CHE','CEM','CDC','CVM','CEAT','CFNR','CPAD') NOT NULL,
  `College_sec` varchar(100) NOT NULL,
  PRIMARY KEY (`College_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `Department_name` enum('IBS','IC','ICS','IMSP','INSTAT','DHUM','DSS','DHK','IAE','DEE','DCHE','DCE') NOT NULL,
  `Department_head` varchar(100) NOT NULL,
  `College_name` enum('CA','CAS','CHE','CEM','CDC','CVM','CEAT','CFNR','CPAD') NOT NULL,
  PRIMARY KEY (`Department_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `Lecturer` varchar(100) NOT NULL,
  `Student_no` char(10) NOT NULL,
  `Course_code` varchar(10) NOT NULL,
  `Grade` enum('1.0','1.25','1.5','1.75','2.0','2.25','2.5','2.75','3.0','4.0','5.0') NOT NULL,
  `Remarks` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Lecturer`,`Student_no`,`Course_code`),
  KEY `grades_course_code_fk` (`Course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`Lecturer`, `Student_no`, `Course_code`, `Grade`, `Remarks`) VALUES
('Roms Bulacs', '2010-41746', 'CMSC 100', '5.0', 'Poor scholastic performance\r\n'),
('Roms Bulacs', '2011-12840', 'CMSC 100', '1.5', 'Good\r\n'),
('Roms Bulacs', '2011-16328', 'CMSC 100', '1.25', 'Very good\r\n'),
('Roms Bulacs', '2011-31260', 'CMSC 100', '1.0', 'Genius');

-- --------------------------------------------------------

--
-- Table structure for table `gradesheet`
--

CREATE TABLE IF NOT EXISTS `gradesheet` (
  `Lecturer` varchar(100) NOT NULL,
  `Course_code` varchar(10) NOT NULL,
  `Section` varchar(5) NOT NULL,
  `Status` enum('PENDING','APPROVED','DISAPPROVED') NOT NULL,
  PRIMARY KEY (`Lecturer`,`Course_code`),
  KEY `Course_code` (`Course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gradesheet`
--

INSERT INTO `gradesheet` (`Lecturer`, `Course_code`, `Section`, `Status`) VALUES
('Roms Bulacs', 'CMSC 100', 'EF-5L', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `Course_code` varchar(10) NOT NULL,
  `Department` varchar(10) NOT NULL,
  PRIMARY KEY (`Course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`Course_code`, `Department`) VALUES
('CMSC 100', 'ICS'),
('CMSC 124', 'ICS'),
('CMSC 127', 'ICS'),
('CMSC 131', 'ICS'),
('CMSC 150', 'ICS'),
('CMSC 165', 'ICS');

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
('DPH', 'depthead', '4b5fa34addc47ec2e0df095cbecbe0c5c88b8723', 'Jaime Samaniego'),
('LEC', 'lecturer', '1dfbba5b5fa79b789c93cfc2911d846124153615', 'Roms Bulacs');

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
