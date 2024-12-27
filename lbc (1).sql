-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 27, 2024 at 05:28 PM
-- Server version: 8.2.0
-- PHP Version: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lbc`
--

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `language_name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language_name`, `created_at`) VALUES
(1, 'English', '2024-12-15 13:04:34'),
(2, 'Telugu', '2024-12-15 13:04:34'),
(3, 'Hindi', '2024-12-15 13:04:34');

-- --------------------------------------------------------

--
-- Table structure for table `offerings`
--

DROP TABLE IF EXISTS `offerings`;
CREATE TABLE IF NOT EXISTS `offerings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_id` int NOT NULL,
  `service_date` date DEFAULT NULL,
  `user_id` int NOT NULL,
  `serial_no` int NOT NULL DEFAULT '0',
  `denomination_2000` int NOT NULL DEFAULT '0',
  `denomination_500` int DEFAULT '0',
  `denomination_200` int DEFAULT '0',
  `denomination_100` int DEFAULT '0',
  `denomination_50` int DEFAULT '0',
  `denomination_20_notes` int DEFAULT '0',
  `denomination_20_coins` int DEFAULT '0',
  `denomination_10_notes` int DEFAULT '0',
  `denomination_10_coins` int DEFAULT '0',
  `denomination_5_notes` int DEFAULT '0',
  `denomination_5_coins` int DEFAULT '0',
  `denomination_2_notes` int DEFAULT '0',
  `denomination_2_coins` int DEFAULT '0',
  `denomination_1_notes` int DEFAULT '0',
  `denomination_1_coins` int DEFAULT '0',
  `total_amount` int GENERATED ALWAYS AS ((((((((((((((((`denomination_2000` * 2000) + (`denomination_500` * 500)) + (`denomination_200` * 200)) + (`denomination_100` * 100)) + (`denomination_50` * 50)) + (`denomination_20_notes` * 20)) + (`denomination_20_coins` * 20)) + (`denomination_10_notes` * 10)) + (`denomination_10_coins` * 10)) + (`denomination_5_notes` * 5)) + (`denomination_5_coins` * 5)) + (`denomination_2_notes` * 2)) + (`denomination_2_coins` * 2)) + (`denomination_1_notes` * 1)) + (`denomination_1_coins` * 1))) STORED,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `offerings`
--

INSERT INTO `offerings` (`id`, `service_id`, `service_date`, `user_id`, `serial_no`, `denomination_2000`, `denomination_500`, `denomination_200`, `denomination_100`, `denomination_50`, `denomination_20_notes`, `denomination_20_coins`, `denomination_10_notes`, `denomination_10_coins`, `denomination_5_notes`, `denomination_5_coins`, `denomination_2_notes`, `denomination_2_coins`, `denomination_1_notes`, `denomination_1_coins`, `created_at`) VALUES
(59, 11, '2024-12-27', 51, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:37:43'),
(60, 11, '2024-12-27', 52, 2, 2, 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:37:49'),
(61, 11, '2024-12-27', 53, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:38:13'),
(62, 11, '2024-12-27', 54, 4, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:38:18'),
(63, 11, '2024-12-27', 55, 5, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:38:28'),
(64, 12, '2024-12-27', 56, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:38:56'),
(65, 12, '2024-12-27', 57, 2, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:39:02'),
(66, 12, '2024-12-27', 58, 3, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:39:07'),
(67, 12, '2024-12-27', 59, 4, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:39:13'),
(68, 12, '2024-12-27', 60, 5, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:41:21'),
(69, 12, '2024-12-27', 61, 6, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:41:25'),
(70, 12, '2024-12-27', 62, 7, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:41:29'),
(71, 12, '2024-12-27', 63, 8, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:41:32'),
(72, 12, '2024-12-27', 64, 9, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:41:36'),
(73, 12, '2024-12-27', 65, 10, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:41:40'),
(74, 12, '2024-12-27', 66, 11, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:41:43'),
(75, 12, '2024-12-27', 67, 12, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:41:46'),
(76, 12, '2024-12-27', 68, 13, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:41:54'),
(77, 12, '2024-12-27', 66, 14, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:41:59'),
(78, 12, '2024-12-27', 69, 15, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:06'),
(79, 12, '2024-12-27', 70, 16, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:09'),
(80, 12, '2024-12-27', 71, 17, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:14'),
(81, 12, '2024-12-27', 72, 18, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:17'),
(82, 12, '2024-12-27', 73, 19, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:20'),
(83, 12, '2024-12-27', 74, 20, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:26'),
(84, 12, '2024-12-27', 75, 21, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:30'),
(85, 12, '2024-12-27', 76, 22, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:40'),
(86, 12, '2024-12-27', 77, 23, 0, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:45'),
(87, 12, '2024-12-27', 77, 24, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:48'),
(88, 12, '2024-12-27', 78, 25, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:53'),
(89, 12, '2024-12-27', 79, 26, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:42:57'),
(90, 12, '2024-12-27', 80, 27, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:43:00'),
(91, 12, '2024-12-27', 81, 28, 55, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:43:04'),
(92, 12, '2024-12-27', 82, 29, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:43:07'),
(93, 12, '2024-12-27', 83, 30, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:43:11'),
(94, 12, '2024-12-27', 84, 31, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:47:31'),
(95, 12, '2024-12-27', 85, 32, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:49:31'),
(96, 12, '2024-12-27', 86, 33, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-12-26 16:49:40'),
(97, 30, '2024-12-27', 87, 1, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 20, 0, 0, 10, '2024-12-27 15:22:19');

-- --------------------------------------------------------

--
-- Table structure for table `offering_types`
--

DROP TABLE IF EXISTS `offering_types`;
CREATE TABLE IF NOT EXISTS `offering_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `offering_name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `offering_types`
--

INSERT INTO `offering_types` (`id`, `offering_name`, `created_at`) VALUES
(1, 'Tithe', '2024-12-15 13:04:35'),
(2, 'Poor Offering', '2024-12-15 13:04:35'),
(3, 'Special Offering', '2024-12-15 13:04:35'),
(4, 'Thanksgiving', '2024-12-15 13:04:35'),
(5, 'Sunday School', '2024-12-20 12:13:03'),
(6, 'Teens', '2024-12-20 12:13:03'),
(7, 'Youth', '2024-12-23 15:41:42'),
(8, 'Womens', '2024-12-23 15:41:54'),
(9, 'General', '2024-12-26 09:44:03');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `language_id` int NOT NULL,
  `offering_type_id` int NOT NULL,
  `service_slot` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_language_offering_service` (`language_id`,`offering_type_id`,`service_slot`),
  KEY `offering_type_id` (`offering_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `language_id`, `offering_type_id`, `service_slot`, `created_at`) VALUES
(1, 1, 1, '7 am', '2024-12-15 13:45:55'),
(2, 1, 2, '7 am', '2024-12-15 13:50:27'),
(3, 1, 4, '7 am', '2024-12-15 13:50:56'),
(4, 1, 3, '7 am', '2024-12-15 13:52:50'),
(11, 2, 1, '10 am', '2024-12-15 16:29:24'),
(12, 2, 2, '10 am', '2024-12-17 09:10:44'),
(13, 2, 3, '10 am', '2024-12-17 09:10:44'),
(14, 2, 4, '10 am', '2024-12-17 09:10:44'),
(30, 3, 1, '4 pm', '2024-12-17 09:13:59'),
(31, 3, 2, '4 pm', '2024-12-17 09:13:59'),
(32, 3, 3, '4 pm', '2024-12-17 09:13:59'),
(33, 3, 4, '4 pm', '2024-12-17 09:13:59'),
(40, 1, 1, '7 pm', '2024-12-17 09:15:02'),
(41, 1, 2, '7 pm', '2024-12-17 09:15:02'),
(42, 1, 3, '7 pm', '2024-12-17 09:15:02'),
(43, 1, 4, '7 pm', '2024-12-17 09:15:02'),
(44, 2, 5, '10 am', '2024-12-20 12:13:34'),
(45, 2, 6, '7 pm', '2024-12-20 12:13:42'),
(46, 2, 7, '7 pm', '2024-12-23 15:42:10'),
(47, 2, 8, '4 pm', '2024-12-23 15:42:51'),
(48, 1, 9, '7 am', '2024-12-26 09:44:17'),
(49, 2, 9, '10 am', '2024-12-26 09:44:26'),
(50, 3, 9, '4 pm', '2024-12-26 09:44:33'),
(51, 1, 9, '7 pm', '2024-12-26 09:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `phone_number` (`phone`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `created_at`) VALUES
(51, 'johnson', NULL, NULL, '2024-12-26 16:37:43'),
(52, 'samson', NULL, NULL, '2024-12-26 16:37:49'),
(53, 'kiran', NULL, NULL, '2024-12-26 16:38:13'),
(54, 'sagar', NULL, NULL, '2024-12-26 16:38:18'),
(55, 'kumar', NULL, NULL, '2024-12-26 16:38:28'),
(56, 'graham', NULL, NULL, '2024-12-26 16:38:56'),
(57, 'billy', NULL, NULL, '2024-12-26 16:39:02'),
(58, 'james', NULL, NULL, '2024-12-26 16:39:07'),
(59, 'frankin', NULL, NULL, '2024-12-26 16:39:13'),
(60, 'aaaaaaaa', NULL, NULL, '2024-12-26 16:41:21'),
(61, 'bbbbbbbbbbbbb', NULL, NULL, '2024-12-26 16:41:25'),
(62, 'vvvvvvv', NULL, NULL, '2024-12-26 16:41:29'),
(63, 'ddddddddddd', NULL, NULL, '2024-12-26 16:41:32'),
(64, 'hhhhhhhhhhhhhh', NULL, NULL, '2024-12-26 16:41:36'),
(65, 'iiiiiiiiiiiiiii', NULL, NULL, '2024-12-26 16:41:40'),
(66, 'dddddddddddddd', NULL, NULL, '2024-12-26 16:41:43'),
(67, 'eeeeeeeeeee', NULL, NULL, '2024-12-26 16:41:46'),
(68, 'rfffffffffff', NULL, NULL, '2024-12-26 16:41:50'),
(69, '4444444444444', NULL, NULL, '2024-12-26 16:42:05'),
(70, '55555555555', NULL, NULL, '2024-12-26 16:42:09'),
(71, '6666666666666', NULL, NULL, '2024-12-26 16:42:14'),
(72, '77777777', NULL, NULL, '2024-12-26 16:42:16'),
(73, '6666666666', NULL, NULL, '2024-12-26 16:42:20'),
(74, '77777777777', NULL, NULL, '2024-12-26 16:42:26'),
(75, '66666666666', NULL, NULL, '2024-12-26 16:42:30'),
(76, 'tttttttt', NULL, NULL, '2024-12-26 16:42:40'),
(77, '777777777777777', NULL, NULL, '2024-12-26 16:42:45'),
(78, '5555555555556', NULL, NULL, '2024-12-26 16:42:50'),
(79, '888888888888888888', NULL, NULL, '2024-12-26 16:42:57'),
(80, '8888888888888888888', NULL, NULL, '2024-12-26 16:43:00'),
(81, '8444444444', NULL, NULL, '2024-12-26 16:43:04'),
(82, '88888888888888', NULL, NULL, '2024-12-26 16:43:07'),
(83, '8888888888888', NULL, NULL, '2024-12-26 16:43:11'),
(84, 'sam', NULL, NULL, '2024-12-26 16:47:31'),
(85, 'sams', NULL, NULL, '2024-12-26 16:49:31'),
(86, 'kum', NULL, NULL, '2024-12-26 16:49:40'),
(87, 'karunakar', NULL, NULL, '2024-12-27 15:22:19');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_detail_offerings`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_detail_offerings`;
CREATE TABLE IF NOT EXISTS `view_detail_offerings` (
`created_at` timestamp
,`denomination_100` int
,`denomination_10_coins` int
,`denomination_10_notes` int
,`denomination_1_coins` int
,`denomination_1_notes` int
,`denomination_200` int
,`denomination_2000` int
,`denomination_20_coins` int
,`denomination_20_notes` int
,`denomination_2_coins` int
,`denomination_2_notes` int
,`denomination_50` int
,`denomination_500` int
,`denomination_5_coins` int
,`denomination_5_notes` int
,`full_name` varchar(100)
,`id` int
,`serial_no` int
,`service_date` date
,`service_id` int
,`service_name` varchar(361)
,`total_amount` int
,`user_id` int
);

-- --------------------------------------------------------

--
-- Structure for view `view_detail_offerings`
--
DROP TABLE IF EXISTS `view_detail_offerings`;

DROP VIEW IF EXISTS `view_detail_offerings`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_detail_offerings`  AS SELECT concat(coalesce(`languages`.`language_name`,'N/A'),' - ',coalesce(`offering_types`.`offering_name`,'N/A'),' - ',coalesce(`services`.`service_slot`,'N/A')) AS `service_name`, `users`.`name` AS `full_name`, `offerings`.`id` AS `id`, `offerings`.`service_id` AS `service_id`, `offerings`.`service_date` AS `service_date`, `offerings`.`user_id` AS `user_id`, `offerings`.`serial_no` AS `serial_no`, `offerings`.`denomination_2000` AS `denomination_2000`, `offerings`.`denomination_500` AS `denomination_500`, `offerings`.`denomination_200` AS `denomination_200`, `offerings`.`denomination_100` AS `denomination_100`, `offerings`.`denomination_50` AS `denomination_50`, `offerings`.`denomination_20_notes` AS `denomination_20_notes`, `offerings`.`denomination_20_coins` AS `denomination_20_coins`, `offerings`.`denomination_10_notes` AS `denomination_10_notes`, `offerings`.`denomination_10_coins` AS `denomination_10_coins`, `offerings`.`denomination_5_notes` AS `denomination_5_notes`, `offerings`.`denomination_5_coins` AS `denomination_5_coins`, `offerings`.`denomination_2_notes` AS `denomination_2_notes`, `offerings`.`denomination_2_coins` AS `denomination_2_coins`, `offerings`.`denomination_1_notes` AS `denomination_1_notes`, `offerings`.`denomination_1_coins` AS `denomination_1_coins`, `offerings`.`total_amount` AS `total_amount`, `offerings`.`created_at` AS `created_at` FROM ((((`services` join `languages` on((`services`.`language_id` = `languages`.`id`))) join `offering_types` on((`services`.`offering_type_id` = `offering_types`.`id`))) join `offerings` on((`services`.`id` = `offerings`.`service_id`))) join `users` on((`offerings`.`user_id` = `users`.`id`))) ORDER BY `offerings`.`serial_no` ASC ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `offerings`
--
ALTER TABLE `offerings`
  ADD CONSTRAINT `offerings_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offerings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_ibfk_2` FOREIGN KEY (`offering_type_id`) REFERENCES `offering_types` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
