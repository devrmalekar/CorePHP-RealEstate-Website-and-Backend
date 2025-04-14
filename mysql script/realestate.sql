-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 05:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realestate`
--
CREATE DATABASE IF NOT EXISTS `realestate` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `realestate`;

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

DROP TABLE IF EXISTS `about`;
CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `BusinessBackground` text NOT NULL,
  `CompanyProfile` text NOT NULL,
  `Contact No` bigint(11) NOT NULL,
  `fb` text NOT NULL,
  `linkledn` text NOT NULL,
  `gplus` text NOT NULL,
  `twitter` text NOT NULL,
  `Email` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Truncate table before insert `about`
--

TRUNCATE TABLE `about`;
-- --------------------------------------------------------

--
-- Table structure for table `agentdetail`
--

DROP TABLE IF EXISTS `agentdetail`;
CREATE TABLE `agentdetail` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Contact` bigint(20) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `District` varchar(50) NOT NULL,
  `StreetAddr` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `imgURL` text NOT NULL,
  `Status` varchar(10) NOT NULL,
  `gaddress` varchar(500) NOT NULL,
  `glat` double NOT NULL,
  `glng` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Truncate table before insert `agentdetail`
--

TRUNCATE TABLE `agentdetail`;
--
-- Dumping data for table `agentdetail`
--

INSERT INTO `agentdetail` (`id`, `FirstName`, `LastName`, `Contact`, `Country`, `District`, `StreetAddr`, `Email`, `Description`, `imgURL`, `Status`, `gaddress`, `glat`, `glng`) VALUES
(1, 'Hari', 'Kumar', 123456, '', '', '', 'hari@gmail.com', 'first', '~/images/agents/10662133_787888017916165_5524807832539052602_o4b99a8b4ab6c5d1f0b1662023488b56c.jpg', 'available', 'Bhaktapur Municipality, Garud Kundal Road, Bhaktapur, Central Region, Nepal', -0.0113296508050607, 0.00506401062011719);

-- --------------------------------------------------------

--
-- Table structure for table `home property`
--

DROP TABLE IF EXISTS `home property`;
CREATE TABLE `home property` (
  `id` bigint(20) NOT NULL,
  `HomeName` varchar(50) NOT NULL,
  `HomeType` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `Zone` varchar(50) NOT NULL,
  `District` varchar(50) NOT NULL,
  `StreetAddr` varchar(50) NOT NULL,
  `WardNo` varchar(50) NOT NULL,
  `Floor` tinyint(4) NOT NULL,
  `Room` tinyint(4) NOT NULL,
  `Bathroom` tinyint(4) NOT NULL,
  `HomeNum` varchar(50) NOT NULL,
  `Dinning` tinyint(4) NOT NULL,
  `Living` tinyint(4) NOT NULL,
  `LandArea` mediumint(9) NOT NULL,
  `HouseArea` mediumint(9) NOT NULL,
  `ParkingArea` mediumint(9) NOT NULL,
  `MainRoadDistance` tinyint(4) NOT NULL,
  `FaceToward` varchar(50) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Purpose` varchar(50) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `SalesDate` datetime NOT NULL,
  `Description` text NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Price` int(11) NOT NULL,
  `counter` int(11) NOT NULL,
  `agent` int(11) NOT NULL,
  `gaddress` varchar(500) NOT NULL,
  `glat` double NOT NULL,
  `glng` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Truncate table before insert `home property`
--

TRUNCATE TABLE `home property`;
--
-- Dumping data for table `home property`
--

INSERT INTO `home property` (`id`, `HomeName`, `HomeType`, `Country`, `Zone`, `District`, `StreetAddr`, `WardNo`, `Floor`, `Room`, `Bathroom`, `HomeNum`, `Dinning`, `Living`, `LandArea`, `HouseArea`, `ParkingArea`, `MainRoadDistance`, `FaceToward`, `Status`, `Purpose`, `EntryDate`, `SalesDate`, `Description`, `Username`, `Price`, `counter`, `agent`, `gaddress`, `glat`, `glng`) VALUES
(1, 'Home For Sale', 'Apartment', '', '', '', '', '', 2, 4, 2, '224AE', 1, 1, 150, 120, 10, 120, 'east', 'new', 'rent', '2015-04-14 08:37:25', '0000-00-00 00:00:00', 'Home For sale', 'rmalkear', 2500000, 6, 1, 'Itachhe Tol, Bhaktapur 44800, Nepal', 27.6721554883609, 85.4255571309357);

-- --------------------------------------------------------

--
-- Table structure for table `ipaddrlog`
--

DROP TABLE IF EXISTS `ipaddrlog`;
CREATE TABLE `ipaddrlog` (
  `id` int(11) NOT NULL,
  `ipAddr` text NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Truncate table before insert `ipaddrlog`
--

TRUNCATE TABLE `ipaddrlog`;
--
-- Dumping data for table `ipaddrlog`
--

INSERT INTO `ipaddrlog` (`id`, `ipAddr`, `Name`) VALUES
(1, '27.34.19.140', '224AE'),
(2, '27.34.19.140', '224AE'),
(3, '27.34.19.140', '224AE'),
(4, '27.34.19.140', '224AE'),
(5, '27.34.27.82', '224AE'),
(6, '27.34.27.82', '224AE');

-- --------------------------------------------------------

--
-- Table structure for table `land property`
--

DROP TABLE IF EXISTS `land property`;
CREATE TABLE `land property` (
  `id` bigint(20) NOT NULL,
  `LandName` varchar(50) NOT NULL,
  `LandNumber` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `Zone` varchar(50) NOT NULL,
  `District` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `StreetAddr` varchar(50) NOT NULL,
  `WardNo` varchar(50) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `EntryDate` datetime NOT NULL,
  `SalesDate` datetime NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Area` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Description` text NOT NULL,
  `MainRoadDistance` tinyint(4) NOT NULL,
  `Purpose` varchar(50) NOT NULL,
  `counter` int(11) NOT NULL,
  `agent` int(11) NOT NULL,
  `gaddress` varchar(500) NOT NULL,
  `glat` double NOT NULL,
  `glng` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Truncate table before insert `land property`
--

TRUNCATE TABLE `land property`;
--
-- Dumping data for table `land property`
--

INSERT INTO `land property` (`id`, `LandName`, `LandNumber`, `Country`, `Zone`, `District`, `City`, `StreetAddr`, `WardNo`, `Status`, `EntryDate`, `SalesDate`, `Username`, `Area`, `Price`, `Description`, `MainRoadDistance`, `Purpose`, `counter`, `agent`, `gaddress`, `glat`, `glng`) VALUES
(1, 'My land', '122332', '', '', '', '', '', '', 'New', '2015-04-10 01:38:36', '0000-00-00 00:00:00', 'testuser', 121212121, 1000000, 'TEst ', 1, 'sale', 0, 0, 'Bhaktapur, Nepal', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `photo gallery`
--

DROP TABLE IF EXISTS `photo gallery`;
CREATE TABLE `photo gallery` (
  `id` bigint(20) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Propname` varchar(50) NOT NULL,
  `Propnum` varchar(50) NOT NULL,
  `PhotoURL` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Truncate table before insert `photo gallery`
--

TRUNCATE TABLE `photo gallery`;
--
-- Dumping data for table `photo gallery`
--

INSERT INTO `photo gallery` (`id`, `Username`, `Propname`, `Propnum`, `PhotoURL`) VALUES
(1, 'testuser', 'My land', '122332', 'images/uploaded/testuser/banner_01cd04452f4bd50bcca009c4337b102522.jpg'),
(2, 'rmalkear', 'Home For Sale', '224AE', 'images/uploaded/rmalkear/home-18cae7136124340983d0d641e5933ba4bb.png'),
(4, 'rmalkear', 'Home For Sale', '224AE', 'images/uploaded/rmalkear/home-18cae7136124340983d0d641e5933ba4bb.pngimages891923f52bd53b1d700126128f5d247a.jpgbright-house2b92457c0e5ddfe447cc031d9f9d7816.png');

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

DROP TABLE IF EXISTS `userprofile`;
CREATE TABLE `userprofile` (
  `id` bigint(20) NOT NULL,
  `First Name` varchar(50) NOT NULL,
  `Last Name` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Street` varchar(50) NOT NULL,
  `Contact` bigint(10) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `User Role` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `gaddress` varchar(500) NOT NULL,
  `glat` double NOT NULL,
  `glng` double NOT NULL,
  `temp_password` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Truncate table before insert `userprofile`
--

TRUNCATE TABLE `userprofile`;
--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`id`, `First Name`, `Last Name`, `Country`, `City`, `Street`, `Contact`, `Email`, `UserName`, `Password`, `User Role`, `Date`, `gaddress`, `glat`, `glng`, `temp_password`) VALUES
(1, 'Admin', 'Admin', '', '', '', 0, 'rmalekar1992@gmail.com', 'administrator2071', '485ac11402228b8b868def176b8b8373', 'superadmin', '0000-00-00', '', 0, 0, ''),
(2, 'Jack', 'Sparrow', '', '', '', 9849347506, 'neu.santosh@gmail.com', 'testuser', '5d9c68c6c50ed3d02a2fcf54f63993b6', 'user', '0000-00-00', 'Thapa Gaun, Bagmati, Central Region, Nepal', 0, 0, ''),
(3, 'Rehman ', 'Malekar', '', '', '', 9813184471, 'rmalekar1992@hotmail.com', 'rmalkear', 'b5ea27f5b95e55dd8c5d019a34230bd5', 'user', '0000-00-00', 'Bhaktapur, Nepal', 27.6718288681172, 85.4284867737322, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agentdetail`
--
ALTER TABLE `agentdetail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Contact` (`Contact`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `home property`
--
ALTER TABLE `home property`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `HomeName` (`HomeName`),
  ADD UNIQUE KEY `HomeNum` (`HomeNum`),
  ADD UNIQUE KEY `HomeName_2` (`HomeName`),
  ADD UNIQUE KEY `HomeName_3` (`HomeName`);

--
-- Indexes for table `ipaddrlog`
--
ALTER TABLE `ipaddrlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `land property`
--
ALTER TABLE `land property`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `LandName` (`LandName`),
  ADD UNIQUE KEY `LandNumber` (`LandNumber`);

--
-- Indexes for table `photo gallery`
--
ALTER TABLE `photo gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agentdetail`
--
ALTER TABLE `agentdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `home property`
--
ALTER TABLE `home property`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ipaddrlog`
--
ALTER TABLE `ipaddrlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `land property`
--
ALTER TABLE `land property`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `photo gallery`
--
ALTER TABLE `photo gallery`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `userprofile`
--
ALTER TABLE `userprofile`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
