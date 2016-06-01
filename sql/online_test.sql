-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 20, 2016 at 04:09 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `knoneaet_project1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `s.no` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(200) NOT NULL,
  `pass` varchar(200) NOT NULL,
  PRIMARY KEY (`s.no`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `s.no` int(4) NOT NULL AUTO_INCREMENT,
  `ques-id` varchar(20) NOT NULL,
  `ans-id` varchar(20) NOT NULL,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=174 ;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE IF NOT EXISTS `exam` (
  `s.no` int(11) NOT NULL AUTO_INCREMENT,
  `examid` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `questions` int(3) NOT NULL,
  `duration` int(3) NOT NULL,
  `created time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `instruction` varchar(10000) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`s.no`),
  UNIQUE KEY `examid` (`examid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `s.no` int(4) NOT NULL AUTO_INCREMENT,
  `id` text NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `feedback` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(50) NOT NULL,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `s.no` int(5) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `examid` text NOT NULL,
  `score` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `s.no` int(11) NOT NULL AUTO_INCREMENT,
  `ques-id` varchar(200) NOT NULL,
  `option` varchar(500) NOT NULL,
  `option-id` varchar(200) NOT NULL,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=761 ;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `s.no` int(11) NOT NULL AUTO_INCREMENT,
  `examid` varchar(200) NOT NULL,
  `ques-id` varchar(200) NOT NULL,
  `question` varchar(500) NOT NULL,
  `choice` int(1) NOT NULL,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=191 ;

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE IF NOT EXISTS `rank` (
  `s.no` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `score` int(3) NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `s.no` int(11) NOT NULL AUTO_INCREMENT,
  `uniqid` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `college` varchar(100) NOT NULL,
  `mob` bigint(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `rollno` varchar(40) NOT NULL,
  `status` int(1) DEFAULT '1',
  `login` varchar(200) DEFAULT NULL,
  `email-verify` int(1) DEFAULT NULL,
  `fname` varchar(50) NOT NULL,
  PRIMARY KEY (`s.no`),
  UNIQUE KEY `mob` (`mob`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `rollno` (`rollno`),
  UNIQUE KEY `uniqid` (`uniqid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `z_answer`
--

CREATE TABLE IF NOT EXISTS `z_answer` (
  `s.no` int(4) NOT NULL AUTO_INCREMENT,
  `ques-id` varchar(20) NOT NULL,
  `ans-id` varchar(20) NOT NULL,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=222 ;

-- --------------------------------------------------------

--
-- Table structure for table `z_exam`
--

CREATE TABLE IF NOT EXISTS `z_exam` (
  `s.no` int(11) NOT NULL AUTO_INCREMENT,
  `examid` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `questions` int(3) NOT NULL,
  `duration` int(3) NOT NULL,
  `created time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `instruction` varchar(10000) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`s.no`),
  UNIQUE KEY `examid` (`examid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `z_feedback`
--

CREATE TABLE IF NOT EXISTS `z_feedback` (
  `s.no` int(4) NOT NULL AUTO_INCREMENT,
  `id` text NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `feedback` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(50) NOT NULL,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `z_history`
--

CREATE TABLE IF NOT EXISTS `z_history` (
  `s.no` int(5) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `examid` text NOT NULL,
  `score` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `z_options`
--

CREATE TABLE IF NOT EXISTS `z_options` (
  `s.no` int(11) NOT NULL AUTO_INCREMENT,
  `ques-id` varchar(200) NOT NULL,
  `option` varchar(200) NOT NULL,
  `option-id` varchar(200) NOT NULL,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1818 ;

-- --------------------------------------------------------

--
-- Table structure for table `z_question`
--

CREATE TABLE IF NOT EXISTS `z_question` (
  `s.no` int(11) NOT NULL AUTO_INCREMENT,
  `examid` varchar(200) NOT NULL,
  `ques-id` varchar(200) NOT NULL,
  `question` varchar(200) NOT NULL,
  `choice` int(1) NOT NULL,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=264 ;

-- --------------------------------------------------------

--
-- Table structure for table `z_rank`
--

CREATE TABLE IF NOT EXISTS `z_rank` (
  `s.no` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `score` int(3) NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`s.no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `z_user`
--

CREATE TABLE IF NOT EXISTS `z_user` (
  `s.no` int(11) NOT NULL AUTO_INCREMENT,
  `uniqid` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` varchar(5) NOT NULL,
  `college` varchar(100) NOT NULL,
  `mob` bigint(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `rollno` varchar(40) NOT NULL,
  `status` int(1) DEFAULT '1',
  `eid` varchar(200) DEFAULT NULL,
  `email-verify` int(1) DEFAULT NULL,
  `fname` varchar(50) NOT NULL,
  PRIMARY KEY (`s.no`),
  UNIQUE KEY `mob` (`mob`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `rollno` (`rollno`),
  UNIQUE KEY `uniqid` (`uniqid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
