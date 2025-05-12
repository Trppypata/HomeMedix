-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 05:59 PM
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
-- Database: `homemedix_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `practitioner_id` int(11) NOT NULL,
  `fname` varchar(128) NOT NULL,
  `mname` varchar(128) NOT NULL,
  `lname` varchar(128) NOT NULL,
  `sex` tinyint(1) NOT NULL COMMENT '1-male, 2-female',
  `bday` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `barangay` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `zip` varchar(32) NOT NULL,
  `appointment_case` text NOT NULL,
  `service` tinyint(1) NOT NULL,
  `payment` tinyint(1) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0-draft, 1-pending, 2-approved',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `practitioner_id`, `fname`, `mname`, `lname`, `sex`, `bday`, `address`, `barangay`, `city`, `zip`, `appointment_case`, `service`, `payment`, `appointment_date`, `appointment_time`, `email`, `phone`, `status`, `created_at`) VALUES
(1, 2, 0, 'Jane', '', '', 2, '0000-00-00', '', '', '', '', '', 0, 0, '0000-00-00', '00:00:00', '0', '', 0, '2024-12-05 08:44:56'),
(2, 2, 4, 'John', 'Zobel', 'Doe', 1, '2000-01-01', 'Biringan Street', 'Brgy. Agartha', 'Atlantis City', '9999', 'case closed', 3, 0, '2024-11-10', '13:00:00', '0', '09123456789', 2, '2024-12-05 09:08:33'),
(7, 2, 0, 'Jasper', 'Dthee', 'Ghost', 1, '2024-12-18', 'Biringan Street', 'Brgy. Agartha', 'Atlantis City', '9999', 'open case', 1, 1, '2024-12-12', '12:00:00', 'jaseper@example.com', '09123456789', 1, '2024-12-05 15:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `practitioners`
--

CREATE TABLE `practitioners` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `specialization` varchar(128) DEFAULT NULL,
  `hire_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `practitioners`
--

INSERT INTO `practitioners` (`id`, `user_id`, `specialization`, `hire_date`, `created_at`) VALUES
(1, 4, 'D\' Specialez', '2024-12-05', '2024-12-05 03:43:02'),
(2, 5, NULL, '2024-12-04', '2024-12-05 03:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `token`, `created_at`) VALUES
(1, 1, '8469da0ad8d9b3e0383be312b74f75fd', '2024-12-04 03:12:27'),
(2, 2, '4a21d30964a0e494d988802312d1b40a', '2024-12-04 11:13:15'),
(3, 3, '784a60f730a777f954dcdfbff819971d', '2024-12-05 02:28:38'),
(4, 4, 'dcec665e0d46a04161ad57d7fe46c7eb', '2024-12-05 03:42:58'),
(5, 5, 'fe988bd14125e13dbdde6ecdee93c353', '2024-12-05 03:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(128) NOT NULL,
  `lname` varchar(128) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0-admin, 1-user, 2-prac',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-pending, 1-active, 2-inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `phone`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'John', 'Doe', '09123456789', 'admin@example.coom', '$2y$10$6KPdH.GKKc1cN3l1NNwy8Ol52WVDAn.8F/H0QmaV1mvbBC6A.PgPK', 0, 1, '2024-12-04 03:12:27'),
(2, 'Jane', 'Doesn', '09123456789', 'user@example.com', '$2y$10$dLY2qQG.CtUOd2ON0nnwwuNxL.h8jI/WsXdlg7ImPF6TiypOMDWDO', 1, 1, '2024-12-04 11:13:15'),
(4, 'thera', 'pist', '09123456789', 'therapist@example.com', '$2y$10$wJ.3uGkYdA2NUBbgohXuseNScEXs3w6nT9LmksUqv//qU91ueszPu', 2, 1, '2024-12-05 03:42:56'),
(5, 'de', 'caregiver', '09123456789', 'caregiver@example.com', '$2y$10$DltFoURYFB7TBe/2S/DYseTz2gK1aipU8zvmNBj22xhWvPmqhLrhK', 3, 0, '2024-12-05 03:44:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `practitioners`
--
ALTER TABLE `practitioners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `practitioners`
--
ALTER TABLE `practitioners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
