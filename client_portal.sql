-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2025 at 04:27 PM
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
-- Database: `client_portal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `description`, `created_at`) VALUES
(1, 6, 'Deleted project: \'projectN1\'', '2025-08-17 20:09:15'),
(2, 6, 'Assigned new project: \'projectN#\' to user ID 5 (Status: Completed)', '2025-08-17 20:11:32'),
(3, 6, 'Updated project: \'Task Management\' (Status: Completed)', '2025-08-17 20:11:58'),
(4, 6, 'Updated project: \'kkkkkk\' (Status: In Progress)', '2025-08-17 20:31:18'),
(5, 6, 'Deleted project: \'kkkkkk\'', '2025-08-17 20:31:39'),
(6, 6, 'Assigned new project: \'hohhoh\' to user ID 4 (Status: Completed)', '2025-08-17 23:24:13'),
(7, 8, 'Assigned new project: \'dasfdf\' to user ID 4 (Status: Pending)', '2025-08-18 12:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'sado lamen', 'sado@gmail.com', 'want to add project', 'how much', '2025-08-17 22:00:06'),
(2, 'sado lamen', 'sado@gmail.com', 'want to add project', 'how much', '2025-08-17 22:01:17'),
(3, 'sado lamen', 'sado@gmail.com', 'want to add project', 'how much', '2025-08-17 22:01:42'),
(4, 'sado lamen', 'sado@gmail.com', 'want to add project', 'how much', '2025-08-17 22:01:50'),
(5, 'sado lamen', 'sado@gmail.com', 'want to add project', 'how much', '2025-08-17 22:01:59'),
(6, 'safdf', 'asdfadf@gmail.com', 'sdsfddf', 'sdfddsf', '2025-08-18 13:01:57');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `deadline` date DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `project_name`, `status`, `deadline`, `file_path`, `created_at`) VALUES
(1, 3, 'Task Management', 'Completed', '2025-08-18', NULL, '2025-08-07 09:15:51'),
(18, 7, 'projectN0', 'Pending', '2025-08-17', NULL, '2025-08-17 13:20:40'),
(22, 4, 'hohhoh', 'Completed', '2025-08-13', NULL, '2025-08-17 23:24:13'),
(23, 4, 'dasfdf', 'Pending', '2025-08-30', NULL, '2025-08-18 12:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','admin') DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `profile_image` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `status`, `profile_image`) VALUES
(3, 'yassine', 'yassine@example.com', '$2y$10$HDL5M8all2s35de4wQISA.vJCQvQMBCv2MTHlxmSXb3/LSinprWH6', 'client', '2025-08-04 14:12:56', 'Active', 'default.png'),
(4, 'draken', 'draken@example.com', '$2y$10$7BO2gqiV1P/RYpfP/e473uIqkUdP8agtYAAlFpaOFSKJEnsJvwcu.', 'client', '2025-08-04 17:43:24', 'Active', 'default.png'),
(5, 'othmqho', 'otgqnjdhhdn@gmail.com', '$2y$10$wC86lJdt.jW4dIXpwYRg5O2c5Qk9TfWbSrtcqB0pA7hTYaVkHCjsy', 'client', '2025-08-05 19:57:10', 'Inactive', 'default.png'),
(6, 'yassine', 'admin@kubops.local', '$2y$10$1MimXSh6tH1ikTf6EBFM6OqbIuk8v.i.LjbaUn8baYNC3SLxCiBKa', 'admin', '2025-08-06 23:58:49', 'Active', 'best me.jpg'),
(7, 'colonel', 'colonel@gmail.com', '$2y$10$RVFvq.uicLoaid48wPf5..w1VM7h/qsaBMKGarTCU9elHFinZ6Bp2', 'client', '2025-08-10 21:43:38', 'Inactive', 'default.png'),
(8, 'sado', 'sado@gmail.com', '$2y$10$dQCkrTNisNX9EDVsuYLTU.AxiyHm/wzpnZirxp/p/xQl2N9wq3ZLa', 'client', '2025-08-17 20:49:47', 'Active', 'cartoon me.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
