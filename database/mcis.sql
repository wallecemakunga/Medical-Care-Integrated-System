-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 03:29 PM
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
-- Database: `mcis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(100) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'admin',
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `Full_Name`, `role`, `password`) VALUES
(100, 'angel barnabas', 'admin', '25f9e794323b453885f5181f1b624d0b');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(100) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `patient_id` varchar(100) NOT NULL,
  `phone_number` int(10) NOT NULL,
  `clinic_id` int(100) NOT NULL,
  `doctor_id` varchar(100) NOT NULL,
  `date_of_appointment` date NOT NULL,
  `service` varchar(100) NOT NULL,
  `appointment_details` varchar(255) NOT NULL,
  `status` varchar(15) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(5) NOT NULL,
  `countryid` int(5) DEFAULT NULL,
  `stateid` int(5) DEFAULT NULL,
  `cityname` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `countryid`, `stateid`, `cityname`) VALUES
(1, 1, 100, 'Moshono'),
(2, 1, 100, 'Majengo'),
(3, 1, 100, 'Sakina'),
(4, 1, 101, 'Tengeru'),
(5, 1, 101, 'Usa_river'),
(6, 1, 101, 'meru'),
(7, 1, 101, 'Nanja'),
(8, 2, 103, 'Majengo'),
(9, 2, 103, 'kcmc'),
(10, 2, 103, 'Uzunguni'),
(11, 2, 104, 'O'),
(12, 2, 104, 'Scholastica'),
(13, 2, 104, 'Mizani'),
(14, 3, 106, 'Changarawe'),
(15, 3, 106, 'Mzumbe'),
(16, 3, 107, 'Kilakala'),
(17, 3, 107, 'Mazimbu');

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `clinic_id` int(100) NOT NULL,
  `clinic_name` varchar(100) NOT NULL,
  `region` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `ward` varchar(100) NOT NULL,
  `phone_number` int(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`clinic_id`, `clinic_name`, `region`, `district`, `ward`, `phone_number`, `address`, `email`) VALUES
(1, 'kcmc', '2', '103', ' kcmc', 712000000, 'p.o box 2 kilimanjaro', 'kcmc@gmail.com'),
(2, 'almc', '1', '100', ' Sakina', 713000000, 'p.o box,3 Arusha', 'almc@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(5) NOT NULL,
  `countryname` varchar(250) DEFAULT NULL,
  `creationdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `countryname`, `creationdate`) VALUES
(1, 'Arusha', '2023-09-29 05:58:45'),
(2, 'Kilimanjaro', '2023-09-29 05:58:45'),
(3, 'Morogoro', '2023-09-29 05:58:45');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` varchar(100) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `phone_number` int(15) NOT NULL,
  `dob` date NOT NULL,
  `passport` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `clinic_id` int(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_suffix` int(100) NOT NULL,
  `role` varchar(15) NOT NULL DEFAULT 'Doctor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `medical_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `patient_id` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `bodytemp` float DEFAULT NULL,
  `heartpulse` int(11) DEFAULT NULL,
  `resprate` int(11) DEFAULT NULL,
  `bloodpress` varchar(7) DEFAULT NULL,
  `lab_records` text DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `date_added` timestamp(4) NOT NULL DEFAULT current_timestamp(4) ON UPDATE current_timestamp(4)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nurses`
--

CREATE TABLE `nurses` (
  `nurse_id` varchar(100) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(100) NOT NULL,
  `Phone_number` int(15) NOT NULL,
  `clinic_id` int(100) NOT NULL,
  `passport` varchar(100) NOT NULL,
  `id_suffix` int(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'Nurse'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` varchar(100) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `Phone_number` int(15) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `passport` varchar(100) NOT NULL,
  `id_suffix` int(100) NOT NULL,
  `date_added` timestamp(4) NOT NULL DEFAULT current_timestamp(4) ON UPDATE current_timestamp(4)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `Full_Name`, `email`, `Phone_number`, `dob`, `address`, `Gender`, `passport`, `id_suffix`, `date_added`) VALUES
('F-20041227-2', 'tshabas', 'billy12@gmail.com', 711111111, '2004-12-27', 'p.o box 12,Arusha', 'Female', '', 2, '2024-06-14 12:59:30.0851'),
('F-20090720-1', 'angel barnabas', 'billy@gmail.com', 676420220, '2009-07-20', 'p.o box 12,Arusha', 'Female', '', 1, '2024-05-30 14:07:05.3138');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `StCode` int(11) NOT NULL,
  `countryid` int(5) DEFAULT NULL,
  `StateName` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`StCode`, `countryid`, `StateName`) VALUES
(100, 1, 'Arusha Mjini'),
(101, 1, 'Arumeru'),
(103, 2, 'Moshi Mjini'),
(104, 2, 'Himo'),
(105, 2, 'Marangu'),
(106, 3, 'Mvomero'),
(107, 3, 'Morogoro');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `clinic_id` (`clinic_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`clinic_id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD KEY `clinic_id` (`clinic_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`medical_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`nurse_id`),
  ADD UNIQUE KEY `Phone_number` (`Phone_number`),
  ADD KEY `clinic_id` (`clinic_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `Phone_number` (`Phone_number`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`StCode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `clinic_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `medical_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `StCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`clinic_id`);

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`clinic_id`);

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nurses`
--
ALTER TABLE `nurses`
  ADD CONSTRAINT `nurses_ibfk_1` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`clinic_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
