-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 24, 2022 at 03:30 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BettingCenter`
--

-- --------------------------------------------------------

--
-- Table structure for table `betting`
--

CREATE TABLE `betting` (
  `id` int(11) NOT NULL,
  `customer` varchar(10) NOT NULL,
  `bettingDate` date NOT NULL,
  `bettingCenterId` int(11) NOT NULL,
  `bettingAmount` double NOT NULL,
  `calculateBettingAmount` double DEFAULT NULL,
  `winningAmount` double NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `betting`
--

INSERT INTO `betting` (`id`, `customer`, `bettingDate`, `bettingCenterId`, `bettingAmount`, `calculateBettingAmount`, `winningAmount`, `createdDate`, `createdBy`) VALUES
(1, '123', '2022-01-19', 1, 3500, NULL, 5000, '2022-01-21 23:56:24', 30),
(2, '123', '2022-01-19', 1, 3500, NULL, 0, '2022-01-23 04:54:14', 30),
(3, '123', '2022-01-19', 1, 3500, NULL, 0, '2022-01-23 04:56:03', 30),
(4, '123', '2022-01-19', 1, 3500, NULL, 0, '2022-01-23 04:57:53', 30),
(5, '123', '2022-01-19', 1, 3500, NULL, 0, '2022-01-23 04:58:13', 30),
(6, '123', '2022-01-19', 1, 3500, NULL, 0, '2022-01-23 05:00:01', 30),
(7, '123', '2022-01-19', 1, 3500, NULL, 0, '2022-01-23 05:01:34', 30),
(8, '123', '2022-01-19', 1, 3500, NULL, 0, '2022-01-23 05:02:27', 30),
(9, '123', '2022-01-19', 1, 3500, NULL, 0, '2022-01-23 05:04:31', 30);

-- --------------------------------------------------------

--
-- Table structure for table `bettingAmount`
--

CREATE TABLE `bettingAmount` (
  `id` int(11) NOT NULL,
  `horseCollectionId` int(11) NOT NULL,
  `bettingAmountType` int(11) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bettingAmount`
--

INSERT INTO `bettingAmount` (`id`, `horseCollectionId`, `bettingAmountType`, `amount`) VALUES
(1, 1, 1, 5000),
(2, 5, 2, 100),
(3, 5, 1, 20),
(4, 6, 2, 100),
(5, 6, 1, 20),
(6, 7, 2, 100),
(7, 7, 1, 20),
(8, 8, 2, 100),
(9, 8, 1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `bettingAmountType`
--

CREATE TABLE `bettingAmountType` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bettingAmountType`
--

INSERT INTO `bettingAmountType` (`id`, `code`, `description`) VALUES
(1, 'FRONT', 'front'),
(2, 'BACK', 'back'),
(3, 'DOUBLE', 'double'),
(4, 'TRIPLE', 'triple');

-- --------------------------------------------------------

--
-- Table structure for table `bettingCenter`
--

CREATE TABLE `bettingCenter` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contactPerson` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `isActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bettingCenter`
--

INSERT INTO `bettingCenter` (`id`, `name`, `address`, `contactPerson`, `phone`, `isActive`) VALUES
(1, 'Chamika', 'Gallle', 'Telephone', '0770417852', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `bettingClosing`
--

CREATE TABLE `bettingClosing` (
  `id` int(11) NOT NULL,
  `bettingDate` date NOT NULL,
  `closingTime` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bettingClosing`
--

INSERT INTO `bettingClosing` (`id`, `bettingDate`, `closingTime`, `CreatedBy`, `createdDate`) VALUES
(1, '2022-01-20', '2022-01-20 05:00:00', 12, '2022-01-21 23:55:31');

-- --------------------------------------------------------

--
-- Table structure for table `bettingHorse`
--

CREATE TABLE `bettingHorse` (
  `id` int(11) NOT NULL,
  `horseCollectionId` int(11) NOT NULL,
  `raceCode` varchar(40) NOT NULL,
  `horseCode` varchar(20) NOT NULL,
  `bettingId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bettingHorse`
--

INSERT INTO `bettingHorse` (`id`, `horseCollectionId`, `raceCode`, `horseCode`, `bettingId`) VALUES
(1, 1, '4', 'HC05', 1),
(2, 8, 'w1', 'Fine', 9),
(3, 8, 'w3', 'Fine 32', 9),
(4, 8, 'w2', 'DEC', 9);

-- --------------------------------------------------------

--
-- Table structure for table `horseCollection`
--

CREATE TABLE `horseCollection` (
  `id` int(11) NOT NULL,
  `bettingId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `horseCollection`
--

INSERT INTO `horseCollection` (`id`, `bettingId`) VALUES
(1, 2),
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(6, 7),
(7, 8),
(8, 9);

-- --------------------------------------------------------

--
-- Table structure for table `race`
--

CREATE TABLE `race` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `identifier` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `description` text DEFAULT NULL,
  `extendedJson` text DEFAULT NULL,
  `createdBy` int(11) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `isDeleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `race`
--

INSERT INTO `race` (`id`, `name`, `identifier`, `date`, `description`, `extendedJson`, `createdBy`, `createdDate`, `isDeleted`) VALUES
(1, 'Nisal Sampath', 'nisal', '2022-01-20', 'Good', 'Wow', 10, '2022-01-23', 2);

-- --------------------------------------------------------

--
-- Table structure for table `raceWinning`
--

CREATE TABLE `raceWinning` (
  `id` int(11) NOT NULL,
  `raceId` int(11) NOT NULL,
  `raceIdentifier` varchar(20) NOT NULL,
  `raceDateTime` datetime NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `raceWinningCalculation`
--

CREATE TABLE `raceWinningCalculation` (
  `id` int(11) NOT NULL,
  `bittingDate` date NOT NULL,
  `executingDateTime` datetime NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime DEFAULT NULL,
  `createdBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `raceWinningHorse`
--

CREATE TABLE `raceWinningHorse` (
  `id` int(11) NOT NULL,
  `raceWinningId` int(11) NOT NULL,
  `raceId` int(11) NOT NULL,
  `horseCode` varchar(20) NOT NULL,
  `winingPlace` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `isNotRun` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `companyName` varchar(30) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `tax` double NOT NULL DEFAULT 0,
  `extendedJson` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `userName` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `isActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `userName`, `password`, `isActive`) VALUES
(1, 'Wisal', 'Sandeepa', 'WisSan79', 'c391191df8ddca1c81fc833acf15dbb6', b'1'),
(2, 'Wisal1', 'Sandeepa', 'WisSan791', 'c391191df8ddca1c81fc833acf15dbb6', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `betting`
--
ALTER TABLE `betting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bettingAmount`
--
ALTER TABLE `bettingAmount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bettingAmountType`
--
ALTER TABLE `bettingAmountType`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bettingCenter`
--
ALTER TABLE `bettingCenter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bettingClosing`
--
ALTER TABLE `bettingClosing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bettingHorse`
--
ALTER TABLE `bettingHorse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horseCollection`
--
ALTER TABLE `horseCollection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `race`
--
ALTER TABLE `race`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raceWinning`
--
ALTER TABLE `raceWinning`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raceWinningCalculation`
--
ALTER TABLE `raceWinningCalculation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raceWinningHorse`
--
ALTER TABLE `raceWinningHorse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `betting`
--
ALTER TABLE `betting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bettingAmount`
--
ALTER TABLE `bettingAmount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bettingAmountType`
--
ALTER TABLE `bettingAmountType`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bettingCenter`
--
ALTER TABLE `bettingCenter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bettingClosing`
--
ALTER TABLE `bettingClosing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bettingHorse`
--
ALTER TABLE `bettingHorse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `horseCollection`
--
ALTER TABLE `horseCollection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `race`
--
ALTER TABLE `race`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `raceWinning`
--
ALTER TABLE `raceWinning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `raceWinningCalculation`
--
ALTER TABLE `raceWinningCalculation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `raceWinningHorse`
--
ALTER TABLE `raceWinningHorse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
