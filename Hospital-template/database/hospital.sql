-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2022 at 06:21 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `attempt_table`
--

CREATE TABLE `attempt_table` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(30) NOT NULL,
  `time_count` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `date_joined` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `username`, `password`, `firstname`, `middlename`, `lastname`, `user_type`, `date_joined`) VALUES
(1, 'admin', '$2y$10$hjciAnX6Er1KFGZQdkfGEOOEIezrq3zdMIvPYEliSusP2zpuODF8O', 'James Philip', 'Amante ', 'Gomera', 'SUPER ADMIN', '2022-12-23 11:43:41'),
(2, 'hrAdmin', '$2y$10$KhlJUrv3IkEn.eUVlO57E.KvZjT4QiKMAcMrzos/8.7nKbAIyCSfC', 'HR Admin', 'HR Admin', 'HR Admin', 'HR ADMIN', '2022-12-23 11:45:40'),
(3, 'coreAdmin', '$2y$10$nRzy3TSKDblfd8r2Lsk7iueSxGwIp7Bda02HkTmcZtxsPv2LJMYai', 'Core Admin', 'Core Admin', 'Core Admin', 'CORE ADMIN', '2022-12-23 11:46:14'),
(4, 'logisticAdmin', '$2y$10$1IfeFQvEh2tHOA9Zngv9Zu/xZP6aocUz66ctWxbI40TILgc12eAzO', 'Logistic Admin', 'Logistic Admin', 'Logistic Admin', 'LOGISTICS ADMIN', '2022-12-23 11:46:50'),
(5, 'financialAdmin', '$2y$10$S.ByH2SYx00b.JPdDL8Bfe7xr9moFCnDb/KGxpU/0sN2P8NPU0OHG', 'Financial Admin', 'Financial Admin', 'Financial Admin', 'FINANCIALS ADMIN', '2022-12-23 11:47:34'),
(6, 'admin', '$2y$10$lKVzKNj11/rucxyY5hKXauUCqD3BpZGLk.g0Gumug3lfF6wxlAfru', 'James', 'Amante', 'Gomera', 'CORE ADMIN', '2022-12-23 12:43:23'),
(9, 'test', '$2y$10$MoayOqcLNwowOl0sQS/dLe36DN5Nsf6UKxmZhgaGGWz6iEdLzGeWa', 'test', 'test', 'test', 'HR ADMIN', '2022-12-23 12:51:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attempt_table`
--
ALTER TABLE `attempt_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attempt_table`
--
ALTER TABLE `attempt_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
