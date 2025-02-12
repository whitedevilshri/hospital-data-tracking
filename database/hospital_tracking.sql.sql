-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2024 at 10:32 PM
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
-- Database: `dbms_hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctortype`
--

CREATE TABLE `doctortype` (
  `doctor_type_id` int(11) NOT NULL,
  `doctor_type_name` varchar(255) DEFAULT NULL,
  `specialization_area` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `average_fee` decimal(10,2) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1,
  `contact_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctortype`
--

INSERT INTO `doctortype` (`doctor_type_id`, `doctor_type_name`, `specialization_area`, `description`, `average_fee`, `available`, `contact_info`) VALUES
(1, 'Cardiologist', NULL, NULL, NULL, 1, NULL),
(2, 'Dermatologist', NULL, NULL, NULL, 1, NULL),
(3, 'Endocrinologist', NULL, NULL, NULL, 1, NULL),
(4, 'Gastroenterologist', NULL, NULL, NULL, 1, NULL),
(5, 'Neurologist', NULL, NULL, NULL, 1, NULL),
(6, 'Oncologist', NULL, NULL, NULL, 1, NULL),
(7, 'Pediatrician', NULL, NULL, NULL, 1, NULL),
(8, 'Psychiatrist', NULL, NULL, NULL, 1, NULL),
(9, 'Surgeon', NULL, NULL, NULL, 1, NULL),
(10, 'Orthopedic Surgeon', NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `hospital_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `total_beds` int(11) DEFAULT NULL,
  `available_beds` int(11) DEFAULT NULL,
  `total_staff` int(11) DEFAULT NULL,
  `available_staff` int(11) DEFAULT NULL,
  `total_patients` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `available_doctors` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`hospital_id`, `name`, `total_beds`, `available_beds`, `total_staff`, `available_staff`, `total_patients`, `admin_id`, `available_doctors`) VALUES
(2, 'Apollo Hospital', 200, 150, 200, 100, 70, 12, 0),
(4, 'Sunshine Community Hospital', 100, 30, 80, 40, 50, 17, 0),
(7, 'Ocean Breeze Hospital', 250, 60, 200, 40, 220, 20, 0),
(8, 'Forest Hills Hospital', 160, 35, 120, 20, 140, 22, 0),
(9, 'spider-man seva Kendra', 200, 100, 90, 40, 50, 23, 1),
(10, 'Blue Cross Hospital', 180, 50, 220, 160, 140, 24, 5),
(11, 'Harmony Health Clinic', 120, 30, 140, 100, 90, NULL, 0),
(12, 'Apex Care Hospital', 170, 55, 210, 170, 130, NULL, 0),
(13, 'Sunrise Health Center', 140, 40, 180, 140, 110, NULL, 0),
(14, 'Blossom Health Clinic', 110, 25, 130, 90, 70, NULL, 0),
(15, 'Silverline Hospital', 190, 50, 230, 180, 140, NULL, 0),
(16, 'Emerald City Hospital', 150, 40, 200, 150, 110, NULL, 0),
(17, 'Golden Care Hospital', 120, 30, 140, 100, 90, NULL, 0),
(18, 'Pearl Health Institute', 130, 35, 160, 120, 100, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hospitaldoctor`
--

CREATE TABLE `hospitaldoctor` (
  `hospital_doctor_id` int(11) NOT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `doctor_type_id` int(11) DEFAULT NULL,
  `total_doctors` int(11) DEFAULT NULL,
  `available_doctors` int(11) DEFAULT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `specification` varchar(255) NOT NULL,
  `doctor_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitaldoctor`
--

INSERT INTO `hospitaldoctor` (`hospital_doctor_id`, `hospital_id`, `doctor_type_id`, `total_doctors`, `available_doctors`, `doctor_name`, `specification`, `doctor_email`) VALUES
(23, 9, 5, NULL, NULL, 'Dr. Alice Johnson', '', ''),
(24, 10, 5, NULL, NULL, 'Dr. Emily Davis', '', ''),
(25, 9, 1, NULL, NULL, 'Dr. John Smith', '', ''),
(26, 10, 1, NULL, NULL, 'Dr. Robert Brown', '', ''),
(27, 10, NULL, NULL, NULL, 'Dr. rudra', 'Pediatrician', 'rudra@example.com'),
(28, 10, 9, NULL, NULL, 'Dr.bharat', 'Surgeon', 'bharat@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'hospital_admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `role_id`, `hospital_id`, `role`) VALUES
(4, 'michael_jones', 'password111', 'michael.jones@example.com', NULL, NULL, NULL),
(5, 'emily_clark', 'password222', 'emily.clark@example.com', NULL, NULL, NULL),
(6, 'shri01', '$2y$10$z7Ol5nLoMGGRiIbqdEktZ.JnsQI6uLsNqpKY1eyFEx4JlUOvS0lw2', 'shri01@gmail.com', NULL, NULL, NULL),
(8, 'shri02', '$2y$10$gHI1PHGIWl249UFd30rp6.MJhJtgMxbBveQyWxfdolloSOoiJRY7W', 'shri02@gmail.com', NULL, NULL, NULL),
(9, 'yash01', 'rajure01', 'yash01@gmail.com', NULL, 4, NULL),
(12, 'admin_username', 'admin_password', NULL, NULL, 2, 'hospital_admin'),
(17, 'new_admin_username', 'admin_password', NULL, NULL, NULL, 'hospital_admin'),
(20, 'sunanda', 'sunanda_password', 'sunanda@vit.edu', 2, 7, NULL),
(22, 'himanshu', 'himanshu_password', 'himanshu@gmail.com', 2, 8, NULL),
(23, 'spider', 'spider_password', 'spider@vit.edu', 2, 9, 'hospital_admin'),
(24, 'hosadmin10', 'hosadmin10_pass', 'hosadmin10@vit.edu', 2, 10, 'hospital_admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctortype`
--
ALTER TABLE `doctortype`
  ADD PRIMARY KEY (`doctor_type_id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`hospital_id`),
  ADD KEY `hospital_ibfk_1` (`admin_id`);

--
-- Indexes for table `hospitaldoctor`
--
ALTER TABLE `hospitaldoctor`
  ADD PRIMARY KEY (`hospital_doctor_id`),
  ADD KEY `doctor_type_id` (`doctor_type_id`),
  ADD KEY `hospitaldoctor_ibfk_1` (`hospital_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_ibfk_2` (`hospital_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctortype`
--
ALTER TABLE `doctortype`
  MODIFY `doctor_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `hospital_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hospitaldoctor`
--
ALTER TABLE `hospitaldoctor`
  MODIFY `hospital_doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hospital`
--
ALTER TABLE `hospital`
  ADD CONSTRAINT `hospital_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `hospitaldoctor`
--
ALTER TABLE `hospitaldoctor`
  ADD CONSTRAINT `hospitaldoctor_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`hospital_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hospitaldoctor_ibfk_2` FOREIGN KEY (`doctor_type_id`) REFERENCES `doctortype` (`doctor_type_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`hospital_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
