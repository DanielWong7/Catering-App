-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2019 at 05:53 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cateringapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cateringdata`
--

CREATE TABLE `cateringdata` (
  `Date` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Meal` tinytext NOT NULL,
  `Room` text NOT NULL,
  `DeliveryTime` time NOT NULL,
  `MorningBreak` time NOT NULL,
  `AfternoonBreak` time NOT NULL,
  `Floor` tinyint(4) NOT NULL,
  `Attendees` int(6) NOT NULL,
  `Purpose` text NOT NULL,
  `Restrictions` text NOT NULL,
  `HotCold` text NOT NULL,
  `Drinks` text NOT NULL,
  `Vendor` text NOT NULL,
  `Food` text NOT NULL,
  `LoBCostCenter` int(9) NOT NULL,
  `Organizer` tinytext NOT NULL,
  `Cost` decimal(10,2) NOT NULL,
  `ID` int(11) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `ID` int(11) NOT NULL,
  `DateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `User` text NOT NULL,
  `BeforeChange` text NOT NULL,
  `AfterChange` text NOT NULL,
  `Type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cateringdata`
--
ALTER TABLE `cateringdata`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cateringdata`
--
ALTER TABLE `cateringdata`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `scheduledDeletion` ON SCHEDULE EVERY 1 MONTH STARTS '2019-05-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM cateringdata
	WHERE DateCreated< DATE_SUB(NOW(), INTERVAL 2 YEAR)$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
