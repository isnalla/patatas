-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 20, 2013 at 06:18 PM
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
  `Grade` enum('1.0','1.25','1.5','1.75','2.0','2.25','2.5','2.75','3.0','4.0','5.0','INC') NOT NULL,
  `Remarks` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Lecturer`,`Student_no`,`Course_code`,`Section`),
  KEY `grades_course_code_fk` (`Course_code`),
  KEY `Section` (`Section`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`Lecturer`, `Student_no`, `Course_code`, `Section`, `Grade`, `Remarks`) VALUES
('Lailanie Danila', '2011-12840', 'CMSC 131', 'AB', '1.5', ''),
('Lailanie Danila', '2011-16328', 'CMSC 131', 'AB', '2.0', ''),
('Lailanie Danila', '2011-16328', 'CMSC 2', 'Y', '2.0', ''),
('Lailanie Danila', '2011-31260', 'CMSC 131', 'AB', '1.0', ''),
('Reginald Recario', '2011-16328', 'CMSC 127', 'S', '1.0', 'Promising'),
('Reginald Recario', '2011-31260', 'CMSC 127', 'S', '2.0', ''),
('Rommel Bulalacao', '2010-41746', 'CMSC 100', 'UV1', '5.0', 'Poor scholastic performance\r\n'),
('Rommel Bulalacao', '2010-41746', 'CMSC 165', 'V', '5.0', 'Poor scholastic performance\r\n'),
('Rommel Bulalacao', '2010-41746', 'CMSC 2', 'Y', '5.0', 'Poor scholastic performance\r\n'),
('Rommel Bulalacao', '2010-41746', 'DEVC 10', 'C', '5.0', 'Poor scholastic performance\r\n'),
('Rommel Bulalacao', '2011-12840', 'CMSC 100', 'UV1', '1.5', 'Good\r\n'),
('Rommel Bulalacao', '2011-12840', 'CMSC 165', 'V', '1.5', 'Good\r\n'),
('Rommel Bulalacao', '2011-12840', 'CMSC 2', 'Y', '1.5', 'Good\r\n'),
('Rommel Bulalacao', '2011-12840', 'DEVC 10', 'C', '1.5', 'Good\r\n'),
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
('Lailanie Danila', 'CMSC 131', 'AB', 'APPROVED'),
('Lailanie Danila', 'CMSC 2', 'Y', 'APPROVED'),
('Reginald Recario', 'CMSC 127', 'S', 'APPROVED'),
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
  `Grade` enum('1.0','1.25','1.5','1.75','2.0','2.25','2.5','2.75','3.0','4.0','5.0','INC') DEFAULT NULL,
  PRIMARY KEY (`Student_no`,`Course_code`,`Sem`,`Year`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plan_of_study`
--

INSERT INTO `plan_of_study` (`Student_no`, `Course_code`, `Sem`, `Year`, `Units`, `Grade`) VALUES
('2011-16328', 'CMSC 100', '1st', '3rd', '3.0', NULL),
('2011-16328', 'CMSC 11', '2nd', '1st', '3.0', NULL),
('2011-16328', 'CMSC 123', '2nd', '2nd', '3.0', NULL),
('2011-16328', 'CMSC 124', '1st', '3rd', '3.0', NULL),
('2011-16328', 'CMSC 125', '2nd', '3rd', '3.0', NULL),
('2011-16328', 'CMSC 127', '1st', '3rd', '3.0', '1.0'),
('2011-16328', 'CMSC 128', '2nd', '3rd', '3.0', NULL),
('2011-16328', 'CMSC 130', '2nd', '2nd', '3.0', NULL),
('2011-16328', 'CMSC 131', '1st', '3rd', '3.0', '2.0'),
('2011-16328', 'CMSC 132', '2nd', '3rd', '3.0', NULL),
('2011-16328', 'CMSC 137', '1st', '4th', '3.0', NULL),
('2011-16328', 'CMSC 141', '1st', '4th', '3.0', NULL),
('2011-16328', 'CMSC 142', '2nd', '4th', '3.0', NULL),
('2011-16328', 'CMSC 150', '1st', '4th', '3.0', NULL),
('2011-16328', 'CMSC 161', '2nd', '3rd', '3.0', NULL),
('2011-16328', 'CMSC 165', '1st', '3rd', '3.0', NULL),
('2011-16328', 'CMSC 170', '2nd', '3rd', '3.0', NULL),
('2011-16328', 'CMSC 190-1', '1st', '4th', '3.0', NULL),
('2011-16328', 'CMSC 190-2', '2nd', '4th', '3.0', NULL),
('2011-16328', 'CMSC 198', 'SUMMER', '3rd', '3.0', NULL),
('2011-16328', 'CMSC 199', '1st', '4th', '3.0', NULL),
('2011-16328', 'CMSC 2', '2nd', '1st', '3.0', '2.0'),
('2011-16328', 'CMSC 21', '1st', '2nd', '3.0', NULL),
('2011-16328', 'CMSC 22', '2nd', '2nd', '3.0', NULL),
('2011-16328', 'CMSC 56', '2nd', '1st', '3.0', NULL),
('2011-16328', 'CMSC 57', '1st', '2nd', '3.0', NULL),
('2011-16328', 'ENG 1', '1st', '1st', '3.0', NULL),
('2011-16328', 'ENG 10', '2nd', '3rd', '3.0', NULL),
('2011-16328', 'ENG 2', '2nd', '1st', '3.0', NULL),
('2011-16328', 'HIST 1', '1st', '4th', '3.0', NULL),
('2011-16328', 'HUM 1', '1st', '2nd', '3.0', NULL),
('2011-16328', 'HUM 3', '2nd', '4th', '3.0', NULL),
('2011-16328', 'JAP 10', '1st', '4th', '3.0', NULL),
('2011-16328', 'MATH 17', '1st', '1st', '5.0', NULL),
('2011-16328', 'MATH 26', '2nd', '1st', '3.0', NULL),
('2011-16328', 'MATH 27', '1st', '2nd', '3.0', NULL),
('2011-16328', 'MATH 28', '2nd', '2nd', '3.0', NULL),
('2011-16328', 'MGT 101', '2nd', '4th', '3.0', NULL),
('2011-16328', 'NASC 1', '1st', '1st', '3.0', NULL),
('2011-16328', 'NASC 3', '2nd', '1st', '3.0', NULL),
('2011-16328', 'NASC 4', '2nd', '2nd', '3.0', NULL),
('2011-16328', 'NASC 6', '2nd', '4th', '3.0', NULL),
('2011-16328', 'NASC 7', '1st', '2nd', '3.0', NULL),
('2011-16328', 'NSTP 1', '1st', '2nd', '3.0', NULL),
('2011-16328', 'NSTP 2', '2nd', '2nd', '3.0', NULL),
('2011-16328', 'PE 1', '1st', '1st', '3.0', NULL),
('2011-16328', 'PE 2-CH', '1st', '2nd', '3.0', NULL),
('2011-16328', 'PE 2-SDF', '2nd', '1st', '3.0', NULL),
('2011-16328', 'PE 2-TTN', '2nd', '2nd', '3.0', NULL),
('2011-16328', 'PHLO 1', '1st', '1st', '3.0', NULL),
('2011-16328', 'PI 10', '2nd', '4th', '3.0', NULL),
('2011-16328', 'PSY 1', '2nd', '2nd', '3.0', NULL),
('2011-16328', 'SOSC 1', '1st', '1st', '3.0', NULL),
('2011-16328', 'SPCM 1', '1st', '3rd', '3.0', NULL),
('2011-16328', 'STAT 1', '1st', '2nd', '3.0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `Course_code` varchar(10) NOT NULL,
  `Department` enum('IBS','IC','ICS','IMSP','INSTAT','DHUM','DSS','DHK','IAE','DEE','DCHE','DCE') NOT NULL,
  PRIMARY KEY (`Course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`Course_code`, `Department`) VALUES
('CMSC 100', 'ICS'),
('CMSC 11', 'ICS'),
('CMSC 123', 'ICS'),
('CMSC 124', 'ICS'),
('CMSC 125', 'ICS'),
('CMSC 127', 'ICS'),
('CMSC 130', 'ICS'),
('CMSC 131', 'ICS'),
('CMSC 132', 'ICS'),
('CMSC 137 ', 'ICS'),
('CMSC 141', 'ICS'),
('CMSC 142', 'ICS'),
('CMSC 150', 'ICS'),
('CMSC 161', 'ICS'),
('CMSC 165', 'ICS'),
('CMSC 170', 'ICS'),
('CMSC 190-1', 'ICS'),
('CMSC 190-2', 'ICS'),
('CMSC 199', 'ICS'),
('CMSC 2', 'ICS'),
('CMSC 21', 'ICS'),
('CMSC 22', 'ICS'),
('CMSC 56', 'ICS'),
('CMSC 57', 'ICS'),
('DEVC 10', 'DCE'),
('ENG 10', 'DHUM'),
('HIST 1', 'DSS'),
('HUM 1', 'DHUM'),
('HUM 3', 'DHUM'),
('JAP 10', 'DHUM'),
('MATH 17', 'IMSP'),
('MATH 26', 'IMSP'),
('NASC 3', 'IMSP'),
('NASC 4', 'IBS'),
('PE 2-CH', 'DHK'),
('PE 2-SDF', 'DHK'),
('PE 2-TTN', 'DHK'),
('PE1', 'DHK'),
('PHLO 1', 'DHUM'),
('PSY 1', 'DSS'),
('SOSC 1', 'DSS');

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
('STD', '2011-16328', 'ecf2e3b26ea2414a35178b19b8880b296c3d6d18', 'Anthony Allan Conda'),
('STD', '2011-88888', '07fecf9bad3f0c126933698c647ace85b646894b', 'Malakhir Rohan'),
('CLS', 'collegesec', '37048d2a6bf65d6aee6d71b3df23a23963f7ecd6', 'Ivan Marcelo Duka'),
('DPH', 'depthead', '4b5fa34addc47ec2e0df095cbecbe0c5c88b8723', 'Jaime Samaniego'),
('LEC', 'ina', 'acac461fba0c92b92f986c77f7181f8ae1976834', 'Ina Vergara'),
('CLS', 'ishallnotbenamed', '6cf6d3b36d0510ef168abeba6bd8fe9bba19915c', 'Lord Voldemort'),
('LEC', 'lanie', '58056d543a40e8b31ba79a487883e2c311bc5d4f', 'Lailanie Danila'),
('LEC', 'lecturer', '1dfbba5b5fa79b789c93cfc2911d846124153615', 'Rommel Bulalacao'),
('LEC', 'lecturer2', '0a111f7835d81252bb5eaa0c4c9d4e8a892ef619', 'Yvette de Robles'),
('LEC', 'regi', '1edfa65a5a12f6e99a93056c9fe92967f4a5bce9', 'Reginald Recario');

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
