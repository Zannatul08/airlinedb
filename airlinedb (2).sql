-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2024 at 04:22 PM
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
-- Database: `airlinedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `role`) VALUES
(1, 'Moontaha Rawshan', '$2y$10$GKtXVHpzT6.AJXWyGc.JOOtzVhM9s19etq318.fpqo.bw5Sstsxb.', 'admin'),
(2, 'Raiyan', '$2y$10$8sGSD9mIUlxzqka7qrgOquq1JDkwFv0KACa/wEEMsUvslDija5wCS', 'admin'),
(3, 'mrm', '$2y$10$XufCyShrtE.MtJAUpOqLi.bzS017.5MhfENLfJKTyUVHqd6dUWocC', 'admin'),
(4, 'xRae04', '$2y$10$w9ssJTEY2s35mq7XZzofj.GYYx/YTgIGe46sQxs2PqGRNQvYfjCwK', 'admin'),
(5, 'Sheikh Hasina', '$2y$10$XOK.Gdoz3B9VEF8b4OGHSeSGJ2xV0ccXmlnKFctcTH0Oy6vJeyfkW', 'admin'),
(6, 'Raiyan Khan', '$2y$10$RXTERIV6qleaxyO5LLlHMOoUjUDkU9TAOnoVgJM4KXRiBNMsymdMG', 'admin'),
(7, 'aha_tomater', '$2y$10$Lb.q/Q5j9pSbllxVs7KVYuAVWz7E3y2c.OVFYRyt5o/1L57BETSXS', 'admin'),
(8, 'Ayman Khan', '$2y$10$Lf.0xHZQYEA5gJQEVHys4.eyTeECeUkag1u4QLQq4rxAcG.hVyXpu', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `airline`
--

CREATE TABLE `airline` (
  `airline_id` int(11) NOT NULL,
  `airline_name` varchar(100) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airline`
--

INSERT INTO `airline` (`airline_id`, `airline_name`, `country`) VALUES
(1, 'Biman ', 'Bangladesh'),
(2, 'US Bangla', 'Bangladesh'),
(3, 'American Airlines', 'USA'),
(4, 'Delta Airlines', 'USA'),
(5, 'Air India', 'India'),
(6, 'Lufthansa', 'Germany');

-- --------------------------------------------------------

--
-- Table structure for table `airplane`
--

CREATE TABLE `airplane` (
  `airplane_id` int(11) NOT NULL,
  `model` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `airline_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airplane`
--

INSERT INTO `airplane` (`airplane_id`, `model`, `capacity`, `airline_id`) VALUES
(1, 'Boeng 373', 200, 1),
(2, 'Boeing 777', 350, 1),
(3, 'Airbus A320', 180, 2),
(4, 'Boeing 787', 300, 3),
(5, 'Airbus A380', 500, 4);

-- --------------------------------------------------------

--
-- Table structure for table `airport`
--

CREATE TABLE `airport` (
  `airport_id` int(11) NOT NULL,
  `airport_name` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `IATA_code` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airport`
--

INSERT INTO `airport` (`airport_id`, `airport_name`, `city`, `country`, `IATA_code`) VALUES
(1, 'Dhaka International Airport', 'Dhaka', 'Bangladesh', '332'),
(2, 'Sylhet International Airport', 'Sylhet', 'Bangladesh', '223'),
(3, 'John F. Kennedy International Airport', 'New York', 'USA', 'JFK'),
(4, 'Los Angeles International Airport', 'Los Angeles', 'USA', 'LAX'),
(5, 'Indira Gandhi International Airport', 'Delhi', 'India', 'DEL'),
(6, 'Frankfurt Airport', 'Frankfurt', 'Germany', 'FRA');

-- --------------------------------------------------------

--
-- Table structure for table `airport_maintenance`
--

CREATE TABLE `airport_maintenance` (
  `maintenance_id` int(11) NOT NULL,
  `airport_id` int(11) NOT NULL,
  `service_type` enum('Runway Check','Fueling','Technical Inspection') NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airport_maintenance`
--

INSERT INTO `airport_maintenance` (`maintenance_id`, `airport_id`, `service_type`, `start_time`, `end_time`, `status`) VALUES
(1, 3, '', '2024-11-21 18:26:00', '2024-11-21 06:26:00', 'Completed'),
(2, 1, '', '2024-11-22 08:00:00', '2024-11-22 12:00:00', 'Completed'),
(3, 2, '', '2024-11-23 10:00:00', '2024-11-23 18:00:00', 'In Progress'),
(4, 3, '', '2024-11-24 06:00:00', '2024-11-24 10:00:00', 'Scheduled'),
(5, 4, '', '2024-11-25 09:00:00', '2024-11-25 14:00:00', 'Scheduled'),
(6, 1, '', '2024-11-26 13:00:00', '2024-11-26 17:00:00', 'In Progress');

-- --------------------------------------------------------

--
-- Table structure for table `airport_security`
--

CREATE TABLE `airport_security` (
  `security_id` int(11) NOT NULL,
  `airport_id` int(11) NOT NULL,
  `security_type` varchar(50) NOT NULL,
  `staff_count` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `last_inspection_date` date NOT NULL,
  `next_inspection_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airport_security`
--

INSERT INTO `airport_security` (`security_id`, `airport_id`, `security_type`, `staff_count`, `status`, `last_inspection_date`, `next_inspection_date`) VALUES
(1, 2, 'Perimeter Security', 12, 'Active', '2024-11-21', '2024-11-22');

-- --------------------------------------------------------

--
-- Table structure for table `co_pilot`
--

CREATE TABLE `co_pilot` (
  `crew_id` int(11) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `flight_hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crew`
--

CREATE TABLE `crew` (
  `crew_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `role` enum('Pilot','Co-Pilot','Flight Attendant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crew`
--

INSERT INTO `crew` (`crew_id`, `name`, `date_of_birth`, `role`) VALUES
(1, 'Raiyan Khan', '0000-00-00', 'Pilot'),
(2, 'Raiyan Khan', '0000-00-00', 'Pilot'),
(3, 'Rumman Khan', '0000-00-00', 'Pilot'),
(4, 'Ayman Khan', '0000-00-00', 'Flight Attendant'),
(5, 'Ayman Khan', '0000-00-00', 'Flight Attendant'),
(6, 'Ayman Khan', '0000-00-00', 'Flight Attendant'),
(7, 'Ayman Khan', '0000-00-00', 'Flight Attendant'),
(8, 'Ayman Khan', '0000-00-00', 'Flight Attendant'),
(9, 'Ayman Khan', '0000-00-00', 'Flight Attendant'),
(10, 'Maya Ali', '1985-03-10', 'Pilot'),
(11, 'John Doe', '1990-06-15', 'Co-Pilot'),
(12, 'Sarah Lee', '1992-09-25', 'Flight Attendant'),
(13, 'Mark Smith', '1987-04-05', 'Flight Attendant'),
(14, 'Emma Watson', '1993-01-12', 'Co-Pilot'),
(15, 'James Brown', '1980-07-18', 'Pilot');

-- --------------------------------------------------------

--
-- Table structure for table `crew_assignment`
--

CREATE TABLE `crew_assignment` (
  `schedule_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `crew_id` int(11) NOT NULL,
  `shift_start` datetime NOT NULL,
  `shift_end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crew_assignment`
--

INSERT INTO `crew_assignment` (`schedule_id`, `flight_id`, `crew_id`, `shift_start`, `shift_end`) VALUES
(1, 1, 1, '2024-11-22 06:00:00', '2024-11-22 12:00:00'),
(2, 1, 11, '2024-11-22 06:00:00', '2024-11-22 12:00:00'),
(3, 1, 12, '2024-11-22 06:00:00', '2024-11-22 12:00:00'),
(4, 2, 3, '2024-11-22 12:00:00', '2024-11-22 18:00:00'),
(5, 2, 14, '2024-11-22 12:00:00', '2024-11-22 18:00:00'),
(6, 2, 13, '2024-11-22 12:00:00', '2024-11-22 18:00:00'),
(7, 3, 10, '2024-11-23 04:00:00', '2024-11-23 10:00:00'),
(8, 3, 14, '2024-11-23 04:00:00', '2024-11-23 10:00:00'),
(9, 3, 13, '2024-11-23 04:00:00', '2024-11-23 10:00:00'),
(10, 10, 15, '2024-11-16 06:41:00', '2024-11-16 20:41:00'),
(11, 10, 11, '2024-11-16 06:41:00', '2024-11-16 20:41:00'),
(12, 10, 12, '2024-11-16 06:41:00', '2024-11-16 20:41:00'),
(13, 12, 1, '2024-11-16 18:48:00', '2024-11-17 08:48:00'),
(14, 12, 14, '2024-11-16 18:48:00', '2024-11-17 08:48:00'),
(15, 12, 13, '2024-11-16 18:48:00', '2024-11-17 08:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flight_id` int(11) NOT NULL,
  `flight_number` varchar(20) NOT NULL,
  `departure_time` datetime NOT NULL,
  `arrival_time` datetime NOT NULL,
  `status` varchar(30) NOT NULL,
  `route_id` int(11) DEFAULT NULL,
  `airplane_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flight_id`, `flight_number`, `departure_time`, `arrival_time`, `status`, `route_id`, `airplane_id`) VALUES
(1, 'FL001', '2024-11-22 08:00:00', '2024-11-22 12:00:00', 'Scheduled', 11, 1),
(2, 'FL002', '2024-11-22 14:00:00', '2024-11-22 18:00:00', 'Scheduled', 12, 2),
(3, 'FL003', '2024-11-23 06:00:00', '2024-11-23 10:00:00', 'Scheduled', 13, 3),
(10, '123', '2024-11-16 08:41:00', '2024-11-16 20:41:00', 'Scheduled', 13, 1),
(12, '132', '2024-11-16 20:48:00', '2024-11-16 08:48:00', 'Scheduled', 11, 2);

-- --------------------------------------------------------

--
-- Table structure for table `flight_attendant`
--

CREATE TABLE `flight_attendant` (
  `crew_id` int(11) NOT NULL,
  `training_certification` varchar(50) NOT NULL,
  `languages_spoken` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flight_status`
--

CREATE TABLE `flight_status` (
  `status_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `status_update` varchar(20) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_assistance`
--

CREATE TABLE `medical_assistance` (
  `medical_team_id` int(11) NOT NULL,
  `team_lead` varchar(100) NOT NULL,
  `service_type` enum('Emergency Response','First Aid','Health Checks') NOT NULL,
  `availability_status` enum('Available','Engaged') NOT NULL,
  `response_time` int(11) NOT NULL,
  `airport_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_assistance`
--

INSERT INTO `medical_assistance` (`medical_team_id`, `team_lead`, `service_type`, `availability_status`, `response_time`, `airport_id`) VALUES
(1, 'moontaha', 'Health Checks', 'Available', 56, 1),
(2, 'raiyan', 'Health Checks', 'Available', 23, 2),
(5, 'Moontaha Rawshan', 'First Aid', 'Engaged', 12, 2),
(6, 'Sheikh Hasina', 'Health Checks', 'Engaged', 40, 1),
(7, 'Ayman', 'First Aid', 'Available', 5, 1),
(8, 'Rumman', 'Emergency Response', 'Available', 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pilot`
--

CREATE TABLE `pilot` (
  `crew_id` int(11) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `flight_hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `route_id` int(11) NOT NULL,
  `origin_airport_id` int(11) NOT NULL,
  `destination_airport_id` int(11) NOT NULL,
  `distance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`route_id`, `origin_airport_id`, `destination_airport_id`, `distance`) VALUES
(11, 1, 2, 4000),
(12, 2, 3, 13000),
(13, 3, 4, 6500);

-- --------------------------------------------------------

--
-- Table structure for table `team_lead`
--

CREATE TABLE `team_lead` (
  `team_leader_id` int(11) NOT NULL,
  `medical_team_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_lead`
--

INSERT INTO `team_lead` (`team_leader_id`, `medical_team_id`, `start_date`, `end_date`) VALUES
(1, 8, '2024-11-21', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`airline_id`);

--
-- Indexes for table `airplane`
--
ALTER TABLE `airplane`
  ADD PRIMARY KEY (`airplane_id`),
  ADD KEY `airline_id` (`airline_id`);

--
-- Indexes for table `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`airport_id`),
  ADD UNIQUE KEY `IATA_code` (`IATA_code`);

--
-- Indexes for table `airport_maintenance`
--
ALTER TABLE `airport_maintenance`
  ADD PRIMARY KEY (`maintenance_id`),
  ADD KEY `airport_id` (`airport_id`);

--
-- Indexes for table `airport_security`
--
ALTER TABLE `airport_security`
  ADD PRIMARY KEY (`security_id`),
  ADD KEY `airport_id` (`airport_id`);

--
-- Indexes for table `co_pilot`
--
ALTER TABLE `co_pilot`
  ADD PRIMARY KEY (`crew_id`),
  ADD UNIQUE KEY `license_number` (`license_number`);

--
-- Indexes for table `crew`
--
ALTER TABLE `crew`
  ADD PRIMARY KEY (`crew_id`);

--
-- Indexes for table `crew_assignment`
--
ALTER TABLE `crew_assignment`
  ADD PRIMARY KEY (`schedule_id`),
  ADD UNIQUE KEY `flight_id` (`flight_id`,`crew_id`),
  ADD KEY `crew_id` (`crew_id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flight_id`),
  ADD UNIQUE KEY `flight_number` (`flight_number`),
  ADD KEY `route_id` (`route_id`),
  ADD KEY `airplane_id` (`airplane_id`);

--
-- Indexes for table `flight_attendant`
--
ALTER TABLE `flight_attendant`
  ADD PRIMARY KEY (`crew_id`);

--
-- Indexes for table `flight_status`
--
ALTER TABLE `flight_status`
  ADD PRIMARY KEY (`status_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `medical_assistance`
--
ALTER TABLE `medical_assistance`
  ADD PRIMARY KEY (`medical_team_id`),
  ADD KEY `airport_id` (`airport_id`);

--
-- Indexes for table `pilot`
--
ALTER TABLE `pilot`
  ADD PRIMARY KEY (`crew_id`),
  ADD UNIQUE KEY `license_number` (`license_number`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`route_id`),
  ADD UNIQUE KEY `origin_airport_id` (`origin_airport_id`,`destination_airport_id`),
  ADD KEY `destination_airport_id` (`destination_airport_id`);

--
-- Indexes for table `team_lead`
--
ALTER TABLE `team_lead`
  ADD PRIMARY KEY (`team_leader_id`),
  ADD KEY `medical_team_id` (`medical_team_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `airline`
--
ALTER TABLE `airline`
  MODIFY `airline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `airplane`
--
ALTER TABLE `airplane`
  MODIFY `airplane_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `airport`
--
ALTER TABLE `airport`
  MODIFY `airport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `airport_maintenance`
--
ALTER TABLE `airport_maintenance`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `airport_security`
--
ALTER TABLE `airport_security`
  MODIFY `security_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `crew`
--
ALTER TABLE `crew`
  MODIFY `crew_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `crew_assignment`
--
ALTER TABLE `crew_assignment`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `flight_status`
--
ALTER TABLE `flight_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_assistance`
--
ALTER TABLE `medical_assistance`
  MODIFY `medical_team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `team_lead`
--
ALTER TABLE `team_lead`
  MODIFY `team_leader_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `airplane`
--
ALTER TABLE `airplane`
  ADD CONSTRAINT `airplane_ibfk_1` FOREIGN KEY (`airline_id`) REFERENCES `airline` (`airline_id`) ON DELETE SET NULL;

--
-- Constraints for table `airport_maintenance`
--
ALTER TABLE `airport_maintenance`
  ADD CONSTRAINT `airport_maintenance_ibfk_1` FOREIGN KEY (`airport_id`) REFERENCES `airport` (`airport_id`) ON DELETE CASCADE;

--
-- Constraints for table `airport_security`
--
ALTER TABLE `airport_security`
  ADD CONSTRAINT `airport_security_ibfk_1` FOREIGN KEY (`airport_id`) REFERENCES `airport` (`airport_id`) ON DELETE CASCADE;

--
-- Constraints for table `co_pilot`
--
ALTER TABLE `co_pilot`
  ADD CONSTRAINT `co_pilot_ibfk_1` FOREIGN KEY (`crew_id`) REFERENCES `crew` (`crew_id`) ON DELETE CASCADE;

--
-- Constraints for table `crew_assignment`
--
ALTER TABLE `crew_assignment`
  ADD CONSTRAINT `crew_assignment_ibfk_1` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `crew_assignment_ibfk_2` FOREIGN KEY (`crew_id`) REFERENCES `crew` (`crew_id`) ON DELETE CASCADE;

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `flight_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flight_ibfk_2` FOREIGN KEY (`airplane_id`) REFERENCES `airplane` (`airplane_id`) ON DELETE SET NULL;

--
-- Constraints for table `flight_attendant`
--
ALTER TABLE `flight_attendant`
  ADD CONSTRAINT `flight_attendant_ibfk_1` FOREIGN KEY (`crew_id`) REFERENCES `crew` (`crew_id`) ON DELETE CASCADE;

--
-- Constraints for table `flight_status`
--
ALTER TABLE `flight_status`
  ADD CONSTRAINT `flight_status_ibfk_1` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_assistance`
--
ALTER TABLE `medical_assistance`
  ADD CONSTRAINT `medical_assistance_ibfk_1` FOREIGN KEY (`airport_id`) REFERENCES `airport` (`airport_id`) ON DELETE CASCADE;

--
-- Constraints for table `pilot`
--
ALTER TABLE `pilot`
  ADD CONSTRAINT `pilot_ibfk_1` FOREIGN KEY (`crew_id`) REFERENCES `crew` (`crew_id`) ON DELETE CASCADE;

--
-- Constraints for table `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `route_ibfk_1` FOREIGN KEY (`origin_airport_id`) REFERENCES `airport` (`airport_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `route_ibfk_2` FOREIGN KEY (`destination_airport_id`) REFERENCES `airport` (`airport_id`) ON DELETE CASCADE;

--
-- Constraints for table `team_lead`
--
ALTER TABLE `team_lead`
  ADD CONSTRAINT `team_lead_ibfk_1` FOREIGN KEY (`medical_team_id`) REFERENCES `medical_assistance` (`medical_team_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
