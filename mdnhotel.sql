-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 12:18 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mdnhotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `RoomId` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`Id`, `UserId`, `RoomId`, `StartDate`, `EndDate`) VALUES
(30, 15, 1, '2024-04-20', '2024-04-21'),
(31, 15, 2, '2024-04-20', '2024-04-28'),
(32, 14, 1, '2024-04-20', '2024-04-27');

-- --------------------------------------------------------

--
-- Table structure for table `roomrating`
--

CREATE TABLE `roomrating` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `RoomId` int(11) NOT NULL,
  `Rating` int(11) NOT NULL,
  `Text` varchar(128) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roomrating`
--

INSERT INTO `roomrating` (`Id`, `UserId`, `RoomId`, `Rating`, `Text`, `Date`) VALUES
(9, 14, 1, 4, 'ASDASDASD', '2024-04-20 20:20:42'),
(10, 14, 1, 2, 'DFGH', '2024-04-20 20:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `Id` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `Price` int(11) NOT NULL,
  `Capacity` int(11) NOT NULL,
  `Wifi` tinyint(1) NOT NULL,
  `Balcony` tinyint(1) NOT NULL,
  `AirConditioning` tinyint(1) NOT NULL,
  `Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`Id`, `Name`, `Price`, `Capacity`, `Wifi`, `Balcony`, `AirConditioning`, `Image`) VALUES
(1, 'Első Teszt szoba', 15000, 2, 0, 0, 0, 'hero.jpg'),
(2, 'Masodikk', 7001, 4, 0, 1, 1, 'hero.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Email` varchar(128) NOT NULL,
  `LastName` varchar(32) NOT NULL,
  `FirstName` varchar(32) NOT NULL,
  `Password` varchar(128) NOT NULL,
  `ProfileImg` varchar(255) NOT NULL DEFAULT 'DefaultProfileImg.png',
  `IsAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `RegDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Email`, `LastName`, `FirstName`, `Password`, `ProfileImg`, `IsAdmin`, `RegDate`) VALUES
(1, 'asd@as.com', 'sdgsdg', 'sdgs', '$2y$10$ii0/cJdqfsTBc1OKUMhUUe3UlfpSsURRBLttwsz80f07nQ/Zc/P66', 'DefaultProfileImg.png', 0, '0000-00-00 00:00:00'),
(14, 'a@a.com', 'Kekenja', 'Sabolcc', '$2y$10$cQDvINnWP1e4b/MlLht4MOoKPYUxMW1Lsuzw5ohAY6R32njNxthUS', 'DefaultProfileImg.png', 1, '2024-04-20 00:00:00'),
(15, 'b@b.com', 'b', 'b', '$2y$10$xwbS9a2Mx.lIvfPGzrRS/.uOKsZjOSyoYqaQyg9Zp5bw6vLMKONle', 'DefaultProfileImg.png', 1, '2024-04-20 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `RESERVATIONS_USERID_TO_USERS_ID` (`UserId`),
  ADD KEY `RESERVATIONS_ROOMID_TO_ROOMS_ID` (`RoomId`);

--
-- Indexes for table `roomrating`
--
ALTER TABLE `roomrating`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ROOMRATING_ROOMID_TO_ROOMID` (`RoomId`),
  ADD KEY `ROOMRATING_TO_USERID` (`UserId`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `roomrating`
--
ALTER TABLE `roomrating`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `RESERVATIONS_ROOMID_TO_ROOMS_ID` FOREIGN KEY (`RoomId`) REFERENCES `rooms` (`Id`),
  ADD CONSTRAINT `RESERVATIONS_USERID_TO_USERS_ID` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`);

--
-- Constraints for table `roomrating`
--
ALTER TABLE `roomrating`
  ADD CONSTRAINT `ROOMRATING_ROOMID_TO_ROOMID` FOREIGN KEY (`RoomId`) REFERENCES `rooms` (`Id`),
  ADD CONSTRAINT `ROOMRATING_TO_USERID` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
