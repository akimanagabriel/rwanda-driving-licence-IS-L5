-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2024 at 05:32 PM
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
-- Database: `rdl`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminId` int(11) NOT NULL,
  `adminName` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminId`, `adminName`, `password`) VALUES
(1, 'leirbag', '123'),
(2, 'gabson', '123');

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `candidateNationalId` varchar(16) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `gender` text NOT NULL,
  `dob` date NOT NULL DEFAULT current_timestamp(),
  `examDate` date NOT NULL DEFAULT current_timestamp(),
  `phoneNumber` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`candidateNationalId`, `firstName`, `lastName`, `gender`, `dob`, `examDate`, `phoneNumber`) VALUES
('12000348378232', 'muhirwa', 'Jean Claude', 'Female', '2343-07-22', '2024-05-07', '078346734'),
('120008000384374', 'MUJAWIMANA', 'anne marei', 'Female', '2001-01-08', '2024-04-29', '0781309920'),
('12000834763483', 'DATAWERA', 'MAOMBI', 'Female', '8889-09-07', '2024-04-29', '07823624');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `candidateNationalId` varchar(16) NOT NULL,
  `licenseExamCategory` text NOT NULL,
  `obtainedMarks` int(11) NOT NULL,
  `decision` text NOT NULL DEFAULT 'Fail' COMMENT 'Pass / Fail'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`candidateNationalId`, `licenseExamCategory`, `obtainedMarks`, `decision`) VALUES
('12000834763483', 'C', 20, 'Pass'),
('120008000384374', 'D', 10, 'Fail'),
('12000348378232', 'D', 11, 'Fail');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`candidateNationalId`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD KEY `candidate` (`candidateNationalId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `candidate` FOREIGN KEY (`candidateNationalId`) REFERENCES `candidate` (`candidateNationalId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
