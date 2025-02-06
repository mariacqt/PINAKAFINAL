-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2025 at 08:18 PM
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
  `status` enum('Pending','Approved','Completed','Denied - Out of Stock') DEFAULT 'Pending',
  `approved_timestamp` timestamp NULL DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `completed_timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rental_requests`
--

INSERT INTO `rental_requests` (`request_id`, `student_id`, `student_name`, `course_section`, `subject`, `professor`, `user_classification`, `borrowing_date`, `borrowing_time`, `returning_date`, `tools_data`, `request_timestamp`, `status`, `approved_timestamp`, `remark`, `completed_timestamp`) VALUES
(1, 'a', 'a', 'bist 3-2', 'a', 'dela rosa buhay', 'Non-HM Student', '2025-02-05', '18:51:00', '2025-02-14', '[{\"category\":\"Glassware\",\"name\":\"Beer Mug\",\"quantity\":1,\"img\":\"tools\\/beer-mug.png\"},{\"category\":\"Servingware\",\"name\":\"Bar Tray\",\"quantity\":1,\"img\":\"tools\\/bar-tray.png\"},{\"category\":\"Silverware\",\"name\":\"Bar Spoon\",\"quantity\":1,\"img\":\"tools\\/bar-spoon.png\"}]', '2025-02-05 02:51:46', 'Completed', '2025-02-05 11:41:07', NULL, '2025-02-06 06:56:32'),
(2, 'a', 'a', 'bist 3-2', 'Hello its me', 'di ko alam', 'HM Student', '2025-02-05', '19:41:00', '2025-02-07', '[{\"category\":\"Servingware\",\"name\":\"Bar Tray\",\"quantity\":1,\"img\":\"tools\\/bar-tray.png\"}]', '2025-02-05 03:42:00', 'Completed', '2025-02-05 11:51:26', NULL, '2025-02-06 06:56:32'),
(3, 'a', 'a', 'BSHM 1-1', 'pe', 'dela rosa buhay', 'HM Student', '2025-02-05', '06:00:00', '2025-02-06', '[{\"category\":\"Glassware\",\"name\":\"Beer Mug\",\"quantity\":1,\"img\":\"tools\\/beer-mug.png\"}]', '2025-02-05 05:57:47', 'Completed', '2025-02-05 14:00:49', 'Missing', '2025-02-06 06:56:32'),
(4, 'a', 'a', 'BSIT 3-2', 'P.E', 'canlas', 'Non-HM Student', '2025-02-07', '14:51:00', '2025-02-12', '[{\"category\":\"Baking Tools\",\"name\":\"Ceramic Ramekin\",\"quantity\":1,\"img\":\"tools\\/ceramic-ramekin.png\"},{\"category\":\"Glassware\",\"name\":\"Champagne\",\"quantity\":1,\"img\":\"tools\\/champagne.png\"},{\"category\":\"Silverware\",\"name\":\"Cake Slicer\",\"quantity\":1,\"img\":\"tools\\/cake-slicer.png\"},{\"category\":\"Glassware\",\"name\":\"Goblet\",\"quantity\":1,\"img\":\"tools\\/goblet.png\"}]', '2025-02-05 22:52:08', 'Completed', '2025-02-06 06:52:43', NULL, '2025-02-06 06:52:48'),
(5, 'a', 'a', 'HAHA - 123', 'haah cute', 'ikaw lang', 'PUP Employee', '2025-02-07', '14:58:00', '2025-02-21', '[{\"category\":\"Glassware\",\"name\":\"Beer Mug\",\"quantity\":1,\"img\":\"tools\\/beer-mug.png\"},{\"category\":\"Servingware\",\"name\":\"Bar Tray\",\"quantity\":1,\"img\":\"tools\\/bar-tray.png\"},{\"category\":\"Bar Tools\",\"name\":\"Ice Scoop\",\"quantity\":1,\"img\":\"tools\\/ice-scoop.png\"},{\"category\":\"Tableware\",\"name\":\"Gravy Boat and Saucer\",\"quantity\":1,\"img\":\"tools\\/gravy-boat-saucer.png\"}]', '2025-02-05 22:58:12', 'Completed', '2025-02-06 06:58:44', NULL, '2025-02-06 07:07:41'),
(6, 'a', 'a', 'HAHA - 123', 'haah cute', 'ikaw lang', 'HM Student', '2025-02-07', '15:22:00', '2025-02-15', '[{\"category\":\"Glassware\",\"name\":\"Beer Mug\",\"quantity\":3,\"img\":\"tools\\/beer-mug.png\"}]', '2025-02-05 23:22:42', 'Completed', '2025-02-06 07:24:56', 'Missing', '2025-02-06 07:31:11'),
(7, 'a', 'a', 'BSIT 3-2', 'haah cute', 'ikaw lang', 'HM Student', '2025-02-07', '15:29:00', '2025-02-14', '[{\"category\":\"Servingware\",\"name\":\"Bar Tray\",\"quantity\":1,\"img\":\"tools\\/bar-tray.png\"}]', '2025-02-05 23:29:07', 'Completed', '2025-02-06 07:29:47', 'Broken', '2025-02-06 07:31:23'),
(8, 'a', 'a', 'BSIT 3-2', 'haah cute', 'ikaw lang', 'HM Student', '2025-02-07', '15:46:00', '2025-02-08', '[{\"category\":\"Servingware\",\"name\":\"Bar Tray\",\"quantity\":1,\"img\":\"tools\\/bar-tray.png\"}]', '2025-02-05 23:46:26', 'Completed', '2025-02-06 07:50:06', 'Late', '2025-02-06 07:50:41');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
