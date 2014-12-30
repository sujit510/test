-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2014 at 02:38 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dev.nervanix.com`
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
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TenantID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE IF NOT EXISTS `tenants` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TenantName` varchar(512) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tenant_user`
--

CREATE TABLE IF NOT EXISTS `tenant_user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TenantID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserFirstName` varchar(100) NOT NULL,
  `UserLastName` varchar(100) NOT NULL,
  `UserContactNumber` varchar(50) NOT NULL,
  `UserEmail` varchar(100) NOT NULL,
  `UserPassword` varchar(100) NOT NULL,
  `AddedOn` datetime NOT NULL,
  `ModifiedOn` datetime NOT NULL,
  `PassString` varchar(100) NOT NULL,
  `IsActive` enum('0','1') NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_authkey`
--

CREATE TABLE IF NOT EXISTS `user_authkey` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `AuthKey` varchar(512) NOT NULL,
  `CreatedOn` datetime NOT NULL,
  `DestroyedOn` datetime NOT NULL,
  `IsAuthKeyActive` enum('1','0') NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
