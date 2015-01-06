-- phpMyAdmin SQL Dump
-- version 3.3.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 06, 2015 at 01:26 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.34

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `book_my_lawn`
--

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

--
-- Dumping data for table `orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`ID`, `RoleName`) VALUES
(3, 'Superadmin'),
(4, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE IF NOT EXISTS `tenants` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TenantName` varchar(512) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tenants`
--


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

--
-- Dumping data for table `tenant_user`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `UserFirstName`, `UserLastName`, `UserContactNumber`, `UserEmail`, `UserPassword`, `AddedOn`, `ModifiedOn`, `PassString`, `IsActive`) VALUES
(101, 'Sujit', 'Singh', '7878877788', 'admin@yopmail.com', '51e780f1ab138fb27a885aab264fd5d4', '2015-01-06 11:09:03', '0000-00-00 00:00:00', 'MjAxNTAxMDYxMTA5MDNuRjRtMnBkMA==', '0');

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

--
-- Dumping data for table `user_authkey`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`ID`, `UserID`, `RoleID`) VALUES
(1, 101, 3);
