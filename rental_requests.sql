-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2025 at 03:02 PM
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
-- Database: `hasmin_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `rental_requests`
--

CREATE TABLE `rental_requests` (
  `request_id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `course_section` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `professor` varchar(255) NOT NULL,
  `user_classification` varchar(255) NOT NULL,
  `borrowing_date` date NOT NULL,
  `borrowing_time` time NOT NULL,
  `returning_date` date NOT NULL,
  `tools_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`tools_data`)),
  `request_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending',
  `approved_timestamp` timestamp NULL DEFAULT NULL,
  `remark` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rental_requests`
--

INSERT INTO `rental_requests` (`request_id`, `student_id`, `student_name`, `course_section`, `subject`, `professor`, `user_classification`, `borrowing_date`, `borrowing_time`, `returning_date`, `tools_data`, `request_timestamp`, `status`, `approved_timestamp`, `remark`) VALUES
(1, 'a', 'a', 'bist 3-2', 'a', 'dela rosa buhay', 'Non-HM Student', '2025-02-05', '18:51:00', '2025-02-14', '[{\"category\":\"Glassware\",\"name\":\"Beer Mug\",\"quantity\":1,\"img\":\"tools\\/beer-mug.png\"},{\"category\":\"Servingware\",\"name\":\"Bar Tray\",\"quantity\":1,\"img\":\"tools\\/bar-tray.png\"},{\"category\":\"Silverware\",\"name\":\"Bar Spoon\",\"quantity\":1,\"img\":\"tools\\/bar-spoon.png\"}]', '2025-02-05 02:51:46', 'Approved', '2025-02-05 11:41:07', NULL),
(2, 'a', 'a', 'bist 3-2', 'Hello its me', 'di ko alam', 'HM Student', '2025-02-05', '19:41:00', '2025-02-07', '[{\"category\":\"Servingware\",\"name\":\"Bar Tray\",\"quantity\":1,\"img\":\"tools\\/bar-tray.png\"}]', '2025-02-05 03:42:00', 'Approved', '2025-02-05 11:51:26', NULL),
(3, 'a', 'a', 'BSHM 1-1', 'pe', 'dela rosa buhay', 'HM Student', '2025-02-05', '06:00:00', '2025-02-06', '[{\"category\":\"Glassware\",\"name\":\"Beer Mug\",\"quantity\":1,\"img\":\"tools\\/beer-mug.png\"}]', '2025-02-05 05:57:47', 'Approved', '2025-02-05 14:00:49', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rental_requests`
--
ALTER TABLE `rental_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rental_requests`
--
ALTER TABLE `rental_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
