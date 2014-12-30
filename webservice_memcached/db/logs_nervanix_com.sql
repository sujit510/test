-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2014 at 02:42 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `logs.nervanix.com`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_rows`(IN `table1` VARCHAR(512), IN `column1` VARCHAR(512), IN `value1` VARCHAR(512), IN `where1` VARCHAR(512))
    NO SQL
SELECT * FROM table1 WHERE 1 AND column1=value1 AND where1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_users`(IN `whr1` TEXT)
    NO SQL
SELECT * FROM users whr1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_dropdown_array`(IN `tablename` VARCHAR(512), IN `where1` VARCHAR(512))
    NO SQL
SELECT * FROM `roles` WHERE 1 AND where1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GET_ALL_ROWS`(IN table_name text, IN where_cond text, IN order_by text, IN limit_of text)
BEGIN
SET @t1 = CONCAT("SELECT * FROM ", table_name, " ", where_cond, " ", order_by, " ", limit_of);
PREPARE stmt FROM @t1;
EXECUTE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GET_COUNT`(IN table_name text, IN where_cond text)
BEGIN
SET @t1 = CONCAT("SELECT COUNT(*) as cnt FROM ", table_name, " ", where_cond);
PREPARE stmt FROM @t1;
EXECUTE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_SELECT_ORDERS`(IN where_cond text, IN order_by text, IN limit_of text)
BEGIN
SET @t1 = CONCAT("SELECT * FROM orders ", where_cond, " ", order_by, " ", limit_of);
PREPARE stmt FROM @t1;
EXECUTE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_SELECT_TENANTS`(IN where_cond text, IN order_by text, IN limit_of text)
BEGIN
SET @t1 = CONCAT("SELECT * FROM tenants ", where_cond, " ", order_by, " ", limit_of);
PREPARE stmt FROM @t1;
EXECUTE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_SELECT_USERS`(IN where_cond text, IN order_by text, IN limit_of text)
BEGIN
SET @t1 = CONCAT("SELECT * FROM users ", where_cond, " ", order_by, " ", limit_of);
PREPARE stmt FROM @t1;
EXECUTE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_SELECT_USER_ROLE_MAPPINGS`(IN where_cond text, IN order_by text, IN limit_of text)
BEGIN
SET @t1 = CONCAT("SELECT * FROM user_role ", where_cond, " ", order_by, " ", limit_of);
PREPARE stmt FROM @t1;
EXECUTE stmt;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `profiler`
--

CREATE TABLE IF NOT EXISTS `profiler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ProfilerData` text NOT NULL,
  `DateTime` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Table structure for table `trace`
--

CREATE TABLE IF NOT EXISTS `trace` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DateTime` datetime NOT NULL,
  `TracedData` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Table structure for table `webservice_logs`
--

CREATE TABLE IF NOT EXISTS `webservice_logs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Webservice` varchar(100) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Request` text NOT NULL,
  `Response` text NOT NULL,
  `DateTime` datetime NOT NULL,
  `RelatedID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `AuthKey` varchar(512) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
