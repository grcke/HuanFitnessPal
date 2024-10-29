-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 06:39 AM
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
-- Database: `hfp`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `app_date` date NOT NULL,
  `app_time` time NOT NULL,
  `status` varchar(50) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `name`, `email`, `app_date`, `app_time`, `status`) VALUES
(1, 'Test User 1', 'testuser@example.com', '2024-10-29', '11:11:00', 'Pending'),
(2, 'Test User 2', 'testuser2@example.com', '2024-10-31', '12:12:00', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(2, 'Test User 1', 'testuser@example.com', 'testing', '2024-10-29 05:38:42');

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE `exercise` (
  `RecordID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `record` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exercise`
--

INSERT INTO `exercise` (`RecordID`, `UserID`, `start`, `end`, `record`) VALUES
(1, 1, '2024-10-27 10:10:00', '2024-10-27 11:11:00', 'Weight Lifting'),
(2, 4, '2024-10-31 11:11:00', '2024-10-31 12:22:00', 'Swimming');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `userID` int(10) NOT NULL,
  `type` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`userID`, `type`, `email`, `password`) VALUES
(1, 'user', 'testuser@example.com', '$2y$10$Hbsl5CybJeAenKaLY1wrJe.KUqcZwnxtcj6LqLtAsklNhDoFzwLFu'),
(2, 'admin', 'testadmin@example.com', '$2y$10$440/2O3hYSFxit5y7y3NzOoNKMRrit1.IUKVYV.5Esk32kloVQj0a'),
(3, 'user', 'testuser2@example.com', '$2y$10$KLB4m/LPNlwl3jqEY5JpCuY.SDKFlo/74IAX2Z0wjEbeZVuNIuXLS'),
(4, 'user', 'testuser3@example.com', '$2y$10$tLeNcGhvhDpb85HlNjkdc.m358SBCmvFYEGFlJwdRbGf.qKb9Rfzm');

-- --------------------------------------------------------

--
-- Table structure for table `water`
--

CREATE TABLE `water` (
  `RecordID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  `ammount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `water`
--

INSERT INTO `water` (`RecordID`, `UserID`, `DateTime`, `ammount`) VALUES
(1, 1, '2024-10-27 11:11:00', 1.1),
(2, 1, '2024-10-27 12:12:00', 2.44),
(3, 3, '2024-10-31 12:12:00', 12),
(5, 4, '1111-11-11 11:11:00', 12);

-- --------------------------------------------------------

--
-- Table structure for table `weight`
--

CREATE TABLE `weight` (
  `RecordID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Weight` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weight`
--

INSERT INTO `weight` (`RecordID`, `UserID`, `Date`, `Weight`) VALUES
(1, 1, '2024-10-26', 88),
(2, 1, '2024-10-26', 12),
(3, 3, '2024-10-31', 222),
(6, 4, '2024-10-15', 123);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`RecordID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `water`
--
ALTER TABLE `water`
  ADD PRIMARY KEY (`RecordID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `weight`
--
ALTER TABLE `weight`
  ADD PRIMARY KEY (`RecordID`),
  ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exercise`
--
ALTER TABLE `exercise`
  MODIFY `RecordID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `water`
--
ALTER TABLE `water`
  MODIFY `RecordID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `weight`
--
ALTER TABLE `weight`
  MODIFY `RecordID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exercise`
--
ALTER TABLE `exercise`
  ADD CONSTRAINT `exercise_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `userinfo` (`userID`);

--
-- Constraints for table `water`
--
ALTER TABLE `water`
  ADD CONSTRAINT `water_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `userinfo` (`userID`);

--
-- Constraints for table `weight`
--
ALTER TABLE `weight`
  ADD CONSTRAINT `weight_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `userinfo` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
