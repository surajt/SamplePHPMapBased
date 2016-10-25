-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2016 at 12:25 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `rotarysample`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(64) DEFAULT NULL,
  `contact_info` varchar(164) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `zip_code` varchar(5) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `contact_person` varchar(64) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `contact_info`, `state`, `city`, `zip_code`, `phone`, `email`, `contact_person`, `is_active`, `updated_date`) VALUES
(4, 'Latte', '985 KAINS AVE', 'CA', 'ALBANY', '94706', '5107509398', 'opensource.suraj@gmail.com', 'Suraj Thapaliya', 1, '2016-10-12 20:03:57'),
(5, 'Mocha', '1000 N. 4 ST.', 'IA', 'Fairfield', '52557', '6414513274', 'opensource.suraj@gmail.com', 'Suraj Thapaliya', 1, '2016-10-12 20:29:27'),
(6, 'Customer Service', '1000 N. 4 ST.', 'IA', 'Fairfield', '52557', '6414513274', 'opensource.suraj@gmail.com', 'Suraj Thapaliya', 1, '2016-10-12 20:59:51');