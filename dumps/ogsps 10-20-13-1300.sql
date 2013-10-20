-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 20, 2013 at 05:00 AM
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

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`College_name`, `College_sec`) VALUES
('CAS', 'Ivan Marcelo Duka'),
('CDC', 'Lord Voldemort');

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

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Department_name`, `Department_head`, `College_name`) VALUES
('ICS', 'Jaime Samaniego', 'CAS'),
('INSTAT', 'Babidi', 'CAS'),
('DCE', 'Lord Voldemort', 'CDC');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE IF NOT EXISTS `grades` (
  `Lecturer` varchar(100) NOT NULL,
  `Student_no` char(10) NOT NULL,
  `Course_code` varchar(10) NOT NULL,
  `Section` varchar(5) NOT NULL,
  `Grade` enum('1.0','1.25','1.5','1.75','2.0','2.25','2.5','2.75','3.0','4.0','5.0') NOT NULL,
  `Remarks` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Lecturer`,`Student_no`,`Course_code`,`Section`),
  KEY `grades_course_code_fk` (`Course_code`),
  KEY `Section` (`Section`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`Lecturer`, `Student_no`, `Course_code`, `Section`, `Grade`, `Remarks`) VALUES
('Rommel Bulalacao', '2010-41746', 'CMSC 100', 'UV1', '5.0', 'Poor scholastic performance\r\n'),
('Rommel Bulalacao', '2010-41746', 'CMSC 165', 'V', '5.0', 'Poor scholastic performance\r\n'),
('Rommel Bulalacao', '2010-41746', 'CMSC 2', 'Y', '5.0', 'Poor scholastic performance\r\n'),
('Rommel Bulalacao', '2010-41746', 'DEVC 10', 'C', '5.0', 'Poor scholastic performance\r\n'),
('Rommel Bulalacao', '2011-12840', 'CMSC 100', 'UV1', '1.5', 'Good\r\n'),
('Rommel Bulalacao', '2011-12840', 'CMSC 165', 'V', '1.5', 'Good\r\n'),
('Rommel Bulalacao', '2011-12840', 'CMSC 2', 'Y', '1.5', 'Good\r\n'),
('Rommel Bulalacao', '2011-12840', 'DEVC 10', 'C', '1.5', 'Good\r\n'),
('Rommel Bulalacao', '2011-16328', 'CMSC 100', 'UV1', '1.25', 'Very good\r\n'),
('Rommel Bulalacao', '2011-16328', 'CMSC 165', 'V', '1.25', 'Very good\r\n'),
('Rommel Bulalacao', '2011-16328', 'CMSC 2', 'Y', '1.25', 'Very good\r\n'),
('Rommel Bulalacao', '2011-16328', 'DEVC 10', 'C', '1.25', 'Very good\r\n'),
('Rommel Bulalacao', '2011-31260', 'CMSC 100', 'UV1', '1.0', 'Genius'),
('Rommel Bulalacao', '2011-31260', 'CMSC 165', 'V', '1.0', 'Genius'),
('Rommel Bulalacao', '2011-31260', 'CMSC 2', 'Y', '1.0', 'Genius'),
('Rommel Bulalacao', '2011-31260', 'DEVC 10', 'C', '1.0', 'Genius');

-- --------------------------------------------------------

--
-- Table structure for table `gradesheet`
--

CREATE TABLE IF NOT EXISTS `gradesheet` (
  `Lecturer` varchar(100) NOT NULL,
  `Course_code` varchar(10) NOT NULL,
  `Section` varchar(5) NOT NULL,
  `Status` enum('PENDING','APPROVED','DISAPPROVED') NOT NULL,
  PRIMARY KEY (`Lecturer`,`Course_code`,`Section`),
  KEY `Course_code` (`Course_code`),
  KEY `Section` (`Section`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gradesheet`
--

INSERT INTO `gradesheet` (`Lecturer`, `Course_code`, `Section`, `Status`) VALUES
('Rommel Bulalacao', 'CMSC 100', 'UV1', 'PENDING'),
('Rommel Bulalacao', 'CMSC 165', 'A', 'PENDING'),
('Rommel Bulalacao', 'CMSC 165', 'V', 'PENDING'),
('Rommel Bulalacao', 'CMSC 2', 'Y', 'PENDING'),
('Rommel Bulalacao', 'CMSC 21', 'S', 'PENDING'),
('Rommel Bulalacao', 'CMSC 22', 'B', 'PENDING'),
('Rommel Bulalacao', 'DEVC 10', 'C', 'PENDING');

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
('CMSC 165', 'ICS'),
('CMSC 2', 'ICS'),
('CMSC 21', 'ICS'),
('CMSC 22', 'ICS'),
('DEVC 10', 'CDC');

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
('STD', '2011-16328', 'Conda', 'Anthony Allan Conda'),
('STD', '2011-88888', 'Rohan', 'Malakhir Rohan'),
('CLS', 'collegesec', '37048d2a6bf65d6aee6d71b3df23a23963f7ecd6', 'Ivan Marcelo Duka'),
('DPH', 'depthead', '4b5fa34addc47ec2e0df095cbecbe0c5c88b8723', 'Jaime Samaniego'),
('CLS', 'ishallnotbenamed', '6cf6d3b36d0510ef168abeba6bd8fe9bba19915c', 'Lord Voldemort'),
('LEC', 'lecturer', '1dfbba5b5fa79b789c93cfc2911d846124153615', 'Rommel Bulalacao'),
('LEC', 'lecturer2', '0a111f7835d81252bb5eaa0c4c9d4e8a892ef619', 'Yvette de Robles');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gradesheet`
--
ALTER TABLE `gradesheet`
  ADD CONSTRAINT `gradesheet_course_code_fk` FOREIGN KEY (`Course_code`) REFERENCES `subject` (`Course_code`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
