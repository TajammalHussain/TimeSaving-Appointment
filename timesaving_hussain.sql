-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 22, 2021 at 07:26 AM
-- Server version: 10.3.28-MariaDB-log-cll-lve
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abuzzszo_appointment`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments_details`
--

CREATE TABLE `appointments_details` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `schedule` timestamp NULL DEFAULT current_timestamp(),
  `attainded_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'SCHEDULED',
  `booked_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `live_track` timestamp NULL DEFAULT NULL,
  `sharedPresc` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments_details`
--

INSERT INTO `appointments_details` (`id`, `patient_id`, `doctor_id`, `schedule`, `attainded_at`, `status`, `booked_at`, `live_track`, `sharedPresc`) VALUES
(1, 2, 1, '0000-00-00 00:00:00', NULL, 'SCHEDULED', '2020-11-05 11:14:47', NULL, 0),
(2, 2, 1, '2020-11-10 15:10:00', NULL, 'SCHEDULED', '2020-11-08 12:41:37', NULL, 0),
(3, 2, 1, '2020-11-10 15:20:00', NULL, 'SCHEDULED', '2020-11-08 14:18:07', NULL, 0),
(5, 2, 1, '2020-11-23 14:00:00', NULL, 'SCHEDULED', '2020-11-23 12:54:09', NULL, 0),
(6, 2, 1, '2020-11-23 14:10:00', NULL, 'SCHEDULED', '2020-11-23 12:54:30', NULL, 0),
(7, 2, 1, '2020-12-13 14:00:00', NULL, 'SCHEDULED', '2020-12-13 18:10:58', NULL, 0),
(8, 2, 1, '2020-12-14 14:00:00', '2020-12-15 00:37:15', 'ATTENDED', '2020-12-14 17:30:18', NULL, 0),
(9, 2, 1, '2020-12-15 14:00:00', NULL, 'SCHEDULED', '2020-12-14 19:32:07', NULL, 0),
(10, 2, 1, '2020-12-22 14:00:00', NULL, 'SCHEDULED', '2020-12-21 21:42:37', '2020-12-22 14:00:00', 0),
(11, 2, 1, '2020-12-21 14:00:00', NULL, 'CANCELED', '2020-12-21 21:44:07', '2020-12-21 14:00:00', 0),
(12, 2, 1, '2020-12-21 14:20:00', NULL, 'SCHEDULED', '2020-12-21 22:18:24', '2020-12-21 14:40:00', 1),
(13, 2, 1, '2021-02-02 14:00:00', NULL, 'CANCELED', '2021-01-30 16:34:21', '2021-02-02 14:00:00', 0),
(14, 2, 1, '2021-03-11 17:20:00', '2021-03-11 18:32:51', 'ATTENDED', '2021-03-11 13:26:21', '2021-03-11 17:20:00', 1),
(15, 2, 1, '2021-03-11 17:10:00', NULL, 'SCHEDULED', '2021-03-11 13:35:35', '2021-03-11 17:10:00', 0),
(16, 2, 1, '0000-00-00 00:00:00', NULL, 'SCHEDULED', '2021-03-15 07:52:58', '2021-03-15 16:20:00', 0),
(17, 2, 1, '0000-00-00 00:00:00', NULL, 'SCHEDULED', '2021-03-15 08:17:26', '2021-03-15 17:50:00', 0),
(18, 2, 1, '0000-00-00 00:00:00', NULL, 'SCHEDULED', '2021-03-15 08:18:34', '2021-03-16 13:00:00', 0),
(19, 2, 1, '0000-00-00 00:00:00', NULL, 'SCHEDULED', '2021-03-15 08:20:11', '2021-03-16 13:00:00', 0),
(20, 2, 1, '2021-03-16 13:20:00', NULL, 'SCHEDULED', '2021-03-15 08:21:54', '2021-03-16 13:00:00', 0),
(21, 2, 1, '2021-03-31 15:50:00', NULL, 'CANCELED', '2021-03-31 04:13:41', '2021-03-31 15:40:00', 0),
(22, 2, 1, '2021-03-31 16:20:00', NULL, 'CANCELED', '2021-03-31 06:05:29', '2021-03-31 16:20:00', 0),
(23, 2, 1, '2021-03-31 16:10:00', NULL, 'SCHEDULED', '2021-03-31 07:06:37', '2021-03-31 15:10:00', 0),
(24, 2, 1, '2021-04-05 13:00:00', NULL, 'SCHEDULED', '2021-04-04 16:52:22', '2021-04-05 13:00:00', 0),
(25, 2, 1, '2021-04-22 13:20:00', NULL, 'SCHEDULED', '2021-04-21 10:20:27', '2021-04-22 13:20:00', 0),
(26, 2, 1, '2021-04-21 16:30:00', NULL, 'SCHEDULED', '2021-04-21 11:24:24', '2021-04-21 16:30:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `doctors_schedule`
--

CREATE TABLE `doctors_schedule` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `week_days` varchar(20) NOT NULL,
  `from_1` varchar(20) NOT NULL,
  `to_1` varchar(20) NOT NULL,
  `time_per_patient` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctors_schedule`
--

INSERT INTO `doctors_schedule` (`id`, `doctor_id`, `hospital_id`, `week_days`, `from_1`, `to_1`, `time_per_patient`) VALUES
(1, 1, 1, 'M-T-W-T-F-S-S', '09:00', '14:00', 10);

-- --------------------------------------------------------

--
-- Table structure for table `doctors_speciality`
--

CREATE TABLE `doctors_speciality` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `speciality_id` int(11) NOT NULL,
  `speciality_from` date NOT NULL,
  `degree` varchar(100) NOT NULL,
  `timestmp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctors_speciality`
--

INSERT INTO `doctors_speciality` (`id`, `user_id`, `speciality_id`, `speciality_from`, `degree`, `timestmp`) VALUES
(1, 1, 1, '2010-11-03', 'MD', '2020-11-03 06:57:42');

-- --------------------------------------------------------

--
-- Table structure for table `dosctors_hospital`
--

CREATE TABLE `dosctors_hospital` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosctors_hospital`
--

INSERT INTO `dosctors_hospital` (`id`, `user_id`, `hospital_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hospital_details`
--

CREATE TABLE `hospital_details` (
  `id` int(11) NOT NULL,
  `hospital_name` varchar(500) NOT NULL,
  `hospital_address` varchar(500) NOT NULL,
  `facilities` varchar(5000) NOT NULL,
  `timestmp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hospital_details`
--

INSERT INTO `hospital_details` (`id`, `hospital_name`, `hospital_address`, `facilities`, `timestmp`) VALUES
(1, 'General Hospital Derbyshire', 'Derbyshire', 'Multihopitality', '2020-11-03 06:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '0=patient, 1=doctor',
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `registration_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `user_id`, `username`, `password`, `user_type`, `last_login`, `registration_date`) VALUES
(1, 1, 'andrew', '123456', 1, '2020-11-03 07:33:59', '2020-11-30 18:03:52'),
(2, 2, 'hussain', 'hussain', 0, '2020-11-03 07:34:05', '2020-11-30 18:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `msg` varchar(500) NOT NULL,
  `timestmp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `uid`, `doctor_id`, `msg`, `timestmp`) VALUES
(1, 2, 1, 'New schedule is available @ 2021-03-31 11:30:00', '2021-03-31 07:10:27');

-- --------------------------------------------------------

--
-- Table structure for table `patient_prescrition`
--

CREATE TABLE `patient_prescrition` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `complaints` varchar(5000) NOT NULL,
  `advise` varchar(5000) NOT NULL,
  `prescription` varchar(5000) NOT NULL,
  `followup` date DEFAULT NULL,
  `timestmp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_prescrition`
--

INSERT INTO `patient_prescrition` (`id`, `appointment_id`, `complaints`, `advise`, `prescription`, `followup`, `timestmp`) VALUES
(1, 8, 'Cold 1', 'Precause Cold', 'Dolo 650', '2020-12-23', '2020-12-14 19:52:54'),
(2, 14, 'Corona', 'Quarentine', 'Nemusulide,\r\nRebisac DSR', '2021-03-19', '2021-03-11 13:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `speciality`
--

CREATE TABLE `speciality` (
  `id` int(11) NOT NULL,
  `speciality` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `speciality`
--

INSERT INTO `speciality` (`id`, `speciality`) VALUES
(1, 'Psychologist'),
(2, 'General Physisian'),
(3, 'Dentist'),
(4, 'Urologist');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address_1` varchar(250) NOT NULL,
  `address_2` varchar(250) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `timestpm` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_name`, `contact`, `email`, `address_1`, `address_2`, `pincode`, `city`, `state`, `country`, `gender`, `dob`, `timestpm`) VALUES
(1, 'Andrew Pickersgill', '+447448048382', 'andrewExample@xyz.com', 'Derbyshire', 'DE237XB', 'DE237XB', 'Derbyshire', 'London', 'UK', 'Male', '1980-11-04', '2020-11-03 06:54:06'),
(2, 'Hussain', '+447448048382', 'abc@gmail.com', 'Derbishire', 'Derbishire', 'Derbishire', 'Derbishire', 'London', 'London', 'Male', '1999-11-11', '2020-11-03 07:32:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments_details`
--
ALTER TABLE `appointments_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors_schedule`
--
ALTER TABLE `doctors_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors_speciality`
--
ALTER TABLE `doctors_speciality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dosctors_hospital`
--
ALTER TABLE `dosctors_hospital`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital_details`
--
ALTER TABLE `hospital_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_prescrition`
--
ALTER TABLE `patient_prescrition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `speciality`
--
ALTER TABLE `speciality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments_details`
--
ALTER TABLE `appointments_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `doctors_schedule`
--
ALTER TABLE `doctors_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctors_speciality`
--
ALTER TABLE `doctors_speciality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hospital_details`
--
ALTER TABLE `hospital_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_prescrition`
--
ALTER TABLE `patient_prescrition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `speciality`
--
ALTER TABLE `speciality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
