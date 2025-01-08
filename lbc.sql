-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 08, 2025 at 04:03 AM
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
  `is_check` tinyint(1) NOT NULL DEFAULT '0',
  `check_no` int DEFAULT NULL,
  `check_amount` int DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `offerings`
--

INSERT INTO `offerings` (`id`, `service_id`, `service_date`, `user_id`, `serial_no`, `is_check`, `check_no`, `check_amount`, `denomination_2000`, `denomination_500`, `denomination_200`, `denomination_100`, `denomination_50`, `denomination_20_notes`, `denomination_20_coins`, `denomination_10_notes`, `denomination_10_coins`, `denomination_5_notes`, `denomination_5_coins`, `denomination_2_notes`, `denomination_2_coins`, `denomination_1_notes`, `denomination_1_coins`, `created_at`) VALUES
(217, 24, '2025-01-06', 165, 1, 1, NULL, NULL, 0, 44, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-06 16:29:50'),
(218, 24, '2025-01-06', 167, 2, 1, NULL, NULL, 0, 44, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-06 16:30:16'),
(219, 24, '2025-01-06', 168, 3, 1, NULL, NULL, 0, 4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-06 16:30:40'),
(220, 24, '2025-01-06', 169, 4, 1, NULL, NULL, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-06 16:30:50'),
(221, 24, '2025-01-06', 170, 5, 0, NULL, NULL, 0, 3, 0, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-06 16:30:56'),
(222, 24, '2025-01-06', 171, 6, 0, NULL, NULL, 0, 7, 8, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-06 16:31:14');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `offering_types`
--

INSERT INTO `offering_types` (`id`, `offering_name`, `created_at`) VALUES
(1, 'Tithe', '2024-12-15 13:04:35'),
(2, 'Poor Offering', '2024-12-15 13:04:35'),
(3, 'Thanksgiving', '2024-12-15 13:04:35'),
(4, 'General', '2024-12-26 09:44:03'),
(5, 'Sunday School', '2024-12-20 12:13:03'),
(6, 'Teens', '2024-12-20 12:13:03'),
(7, 'Youth', '2024-12-23 15:41:42'),
(8, 'Womens', '2024-12-23 15:41:54');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `language_id` int DEFAULT NULL,
  `offering_type_id` int NOT NULL,
  `service_slot` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_language_offering_service` (`language_id`,`offering_type_id`,`service_slot`),
  KEY `offering_type_id` (`offering_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `language_id`, `offering_type_id`, `service_slot`, `created_at`) VALUES
(11, 1, 1, '7 am', '2024-12-15 08:15:55'),
(12, 1, 2, '7 am', '2024-12-15 08:20:27'),
(13, 1, 3, '7 am', '2024-12-15 08:20:56'),
(14, 1, 4, '7 am', '2024-12-26 04:14:17'),
(21, 2, 1, NULL, '2024-12-15 10:59:24'),
(22, 2, 2, NULL, '2024-12-17 03:40:44'),
(23, 2, 3, NULL, '2024-12-17 03:40:44'),
(24, 2, 4, NULL, '2024-12-26 04:14:26'),
(31, 3, 1, NULL, '2024-12-17 03:43:59'),
(32, 3, 2, NULL, '2024-12-17 03:43:59'),
(33, 3, 3, NULL, '2024-12-17 03:43:59'),
(34, 3, 4, NULL, '2024-12-26 04:14:33'),
(41, 1, 1, '7 pm', '2024-12-17 03:45:02'),
(42, 1, 2, '7 pm', '2024-12-17 03:45:02'),
(43, 1, 3, '7 pm', '2024-12-17 03:45:02'),
(44, 1, 4, '7 pm', '2024-12-26 04:14:40'),
(50, NULL, 8, NULL, '2024-12-23 10:12:51'),
(51, NULL, 7, NULL, '2024-12-23 10:12:10');

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
  `phone2` varchar(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `phone2`, `created_at`) VALUES
(1, 'Nallori Robert Johnson', 'johnson@gmail.com', '8008255268', '', '2025-01-02 07:39:16'),
(91, 'EVANGELYNE ESTHER', NULL, '8977434860', '', '2025-01-01 09:50:17'),
(92, 'JAMES AND FRIENDS', NULL, NULL, '', '2025-01-01 09:51:05'),
(93, 'L MARY BHARATHI', NULL, NULL, '', '2025-01-01 09:54:07'),
(94, 'MARK PRABAKAR', NULL, NULL, '', '2025-01-01 09:54:21'),
(95, 'C SUNITHA PHILIPS', NULL, NULL, '', '2025-01-01 09:54:36'),
(96, 'DR M ARUNA BHARATHI', NULL, NULL, '', '2025-01-01 09:54:50'),
(97, 'B GRECHITH S/O BHASKAR ROA', NULL, NULL, '', '2025-01-01 09:55:23'),
(98, 'MR A AKASH MOHANATH', NULL, NULL, '', '2025-01-01 09:56:25'),
(99, 'MR D ANNIE VINUTHNA AKASH', NULL, NULL, '', '2025-01-01 09:56:46'),
(100, 'NAMELESS', NULL, NULL, '', '2025-01-01 09:56:57'),
(101, 'GENERAL', NULL, NULL, '', '2025-01-01 10:21:28'),
(102, 'JACOB SANDRA', NULL, '9848998462', '', '2025-01-01 10:37:59'),
(103, 'DR T YESUPADAM', NULL, '8187811405', '', '2025-01-01 10:38:20'),
(104, 'MR SAMUEL PADDETI', NULL, '9789918652', '9940615639', '2025-01-01 10:38:36'),
(105, 'PRABHU CHARAN MURAVANI', NULL, '9704779323', '', '2025-01-01 10:38:55'),
(106, 'PULLA PREM KUMAR', NULL, '9848744667', '', '2025-01-01 10:39:09'),
(107, 'S B SHEEBA RANI', NULL, NULL, '', '2025-01-01 10:39:22'),
(108, 'MALLARAPU MARTHAMMA MOSUS', NULL, '9848308420', '', '2025-01-01 10:39:37'),
(109, 'P VIJAUY CHANDRA KIRAN', NULL, NULL, '', '2025-01-01 10:39:50'),
(110, 'PC RAMULU', NULL, '8121179048', '', '2025-01-01 10:40:00'),
(111, 'M MANO RANI', NULL, '9494058188', '', '2025-01-01 10:40:10'),
(112, 'V T DAVID', NULL, NULL, '', '2025-01-01 10:40:27'),
(113, 'D SHAKUNTALA', NULL, NULL, '', '2025-01-01 10:40:59'),
(114, 'PA SAMPATH KUMAR', NULL, '9177851986', '', '2025-01-01 10:41:04'),
(115, 'MR ROOP KUMAR V MODIDA', NULL, '9989614652', '', '2025-01-01 10:41:29'),
(116, 'B DANIEL S/O ASEERVADAM', NULL, NULL, '', '2025-01-01 10:41:46'),
(117, 'P SUSILA SRINIVAS', NULL, '8142687882', '', '2025-01-01 10:42:50'),
(118, 'J SUSHEEL KUMAR S/O SUDHAKAR AGNESS', NULL, '9247148540', '', '2025-01-01 10:48:09'),
(119, 'KARTALA JAYASHEELA YESURATNAM', NULL, NULL, '', '2025-01-01 10:48:24'),
(120, 'A ESTHER DANIEL', NULL, NULL, '', '2025-01-01 10:48:34'),
(121, 'GADDAM SAMUEL SAMSON', NULL, '9849645126', '', '2025-01-01 10:48:44'),
(122, 'AVULA RATHNA LATHA ANAND', NULL, '9154206244', '', '2025-01-01 10:48:58'),
(123, 'P HELEN', NULL, NULL, '', '2025-01-01 10:49:08'),
(124, 'ANNAMANI DANIEL', NULL, '8125314271', '', '2025-01-01 10:49:48'),
(125, 'NAGARJUNA', NULL, '8125314271', '', '2025-01-01 10:49:59'),
(126, 'M PADMA KISHORE', NULL, '9908325596', '', '2025-01-01 10:50:09'),
(127, 'N NELSON', NULL, NULL, '', '2025-01-01 10:50:20'),
(128, 'ANKAM HARI BABU', NULL, NULL, '', '2025-01-01 10:50:33'),
(129, 'GARIKWOD VENKATESH', NULL, '7013704667', '', '2025-01-01 10:51:02'),
(130, 'K DHRUV S/O PRASHANT RAJ', NULL, '8107490749', '', '2025-01-01 10:51:19'),
(131, 'G SAMUEL SAMSON', NULL, NULL, '', '2025-01-01 10:51:39'),
(132, 'B VAJRAMMA SHURDASHAN', NULL, '9010404677', '', '2025-01-01 10:51:58'),
(133, 'T SRIKANTH', NULL, '8886148884', '', '2025-01-01 10:52:08'),
(134, 'MANDHA GOUTHAM KUMAR', NULL, '9052158544', '', '2025-01-01 10:52:19'),
(135, 'MOSES SIKKA (HITLAR)', NULL, '9494217729', '', '2025-01-01 10:52:46'),
(136, 'A KANKA RAJ BENJAIMIN', NULL, '7588926335', '', '2025-01-01 10:53:08'),
(137, 'MAYDAH SURESH AND SAILAJA', NULL, '8801490598', '', '2025-01-01 10:53:53'),
(138, 'RAUABHARAMI SAROJINI', NULL, NULL, '', '2025-01-01 10:54:21'),
(139, 'G PAVAN AND LATHA', NULL, '8142770660', '', '2025-01-01 10:54:58'),
(140, 'JAYA KUMARI', NULL, '7569893597', '', '2025-01-01 10:55:11'),
(141, 'M SAUDHAMANI W/O JAIPAL', NULL, '9866887553', '', '2025-01-01 10:55:27'),
(142, 'T NISHANTH S/O T AMBEDKAR', NULL, '9700123836', '', '2025-01-01 10:55:39'),
(147, 'TEST1', NULL, NULL, '', '2025-01-06 14:14:07'),
(148, 'TEST2', NULL, NULL, '', '2025-01-06 14:14:44'),
(149, 'TEST3', NULL, NULL, '', '2025-01-06 14:14:56'),
(150, 'TEST4', NULL, NULL, '', '2025-01-06 14:17:17'),
(151, 'TEST5', NULL, NULL, '', '2025-01-06 14:20:04'),
(152, 'TEST6', NULL, NULL, '', '2025-01-06 14:20:23'),
(153, 'TEST7', NULL, NULL, '', '2025-01-06 14:21:20'),
(154, 'TEST8', NULL, NULL, '', '2025-01-06 14:25:46'),
(155, 'TEST9', NULL, NULL, '', '2025-01-06 14:26:59'),
(156, 'TEST10', NULL, NULL, '', '2025-01-06 14:32:47'),
(157, 'TEST11', NULL, NULL, '', '2025-01-06 14:33:03'),
(158, 'TEST22', NULL, NULL, '', '2025-01-06 14:57:49'),
(159, 'TEST43', NULL, NULL, '', '2025-01-06 15:13:57'),
(160, 'TEST', NULL, NULL, '', '2025-01-06 15:16:25'),
(161, 'TEST45345', NULL, NULL, '', '2025-01-06 15:16:30'),
(162, 'TET3', NULL, NULL, '', '2025-01-06 15:59:25'),
(163, 'TET2', NULL, NULL, '', '2025-01-06 16:15:27'),
(164, 'TSEST', NULL, NULL, '', '2025-01-06 16:20:12'),
(165, 'AAA', NULL, NULL, '', '2025-01-06 16:28:01'),
(166, 'BBB', NULL, NULL, '', '2025-01-06 16:28:33'),
(167, 'SSS', NULL, NULL, '', '2025-01-06 16:30:29'),
(168, 'CCC', NULL, NULL, '', '2025-01-06 16:30:40'),
(169, 'FFF', NULL, NULL, '', '2025-01-06 16:30:50'),
(170, 'JJ', NULL, NULL, '', '2025-01-06 16:30:56'),
(171, 'JJJ', NULL, NULL, '', '2025-01-06 16:31:14');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_detail_offerings`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_detail_offerings`;
CREATE TABLE IF NOT EXISTS `view_detail_offerings` (
`service_name` varchar(361)
,`full_name` varchar(100)
,`id` int
,`service_id` int
,`service_date` date
,`user_id` int
,`serial_no` int
,`is_check` tinyint(1)
,`check_no` int
,`check_amount` int
,`denomination_2000` int
,`denomination_500` int
,`denomination_200` int
,`denomination_100` int
,`denomination_50` int
,`denomination_20_notes` int
,`denomination_20_coins` int
,`denomination_10_notes` int
,`denomination_10_coins` int
,`denomination_5_notes` int
,`denomination_5_coins` int
,`denomination_2_notes` int
,`denomination_2_coins` int
,`denomination_1_notes` int
,`denomination_1_coins` int
,`total_amount` int
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `view_detail_offerings`
--
DROP TABLE IF EXISTS `view_detail_offerings`;

DROP VIEW IF EXISTS `view_detail_offerings`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_detail_offerings`  AS SELECT concat(coalesce(`languages`.`language_name`,'N/A'),' - ',coalesce(`offering_types`.`offering_name`,'N/A'),' - ',coalesce(`services`.`service_slot`,'N/A')) AS `service_name`, `users`.`name` AS `full_name`, `offerings`.`id` AS `id`, `offerings`.`service_id` AS `service_id`, `offerings`.`service_date` AS `service_date`, `offerings`.`user_id` AS `user_id`, `offerings`.`serial_no` AS `serial_no`, `offerings`.`is_check` AS `is_check`, `offerings`.`check_no` AS `check_no`, `offerings`.`check_amount` AS `check_amount`, `offerings`.`denomination_2000` AS `denomination_2000`, `offerings`.`denomination_500` AS `denomination_500`, `offerings`.`denomination_200` AS `denomination_200`, `offerings`.`denomination_100` AS `denomination_100`, `offerings`.`denomination_50` AS `denomination_50`, `offerings`.`denomination_20_notes` AS `denomination_20_notes`, `offerings`.`denomination_20_coins` AS `denomination_20_coins`, `offerings`.`denomination_10_notes` AS `denomination_10_notes`, `offerings`.`denomination_10_coins` AS `denomination_10_coins`, `offerings`.`denomination_5_notes` AS `denomination_5_notes`, `offerings`.`denomination_5_coins` AS `denomination_5_coins`, `offerings`.`denomination_2_notes` AS `denomination_2_notes`, `offerings`.`denomination_2_coins` AS `denomination_2_coins`, `offerings`.`denomination_1_notes` AS `denomination_1_notes`, `offerings`.`denomination_1_coins` AS `denomination_1_coins`, `offerings`.`total_amount` AS `total_amount`, `offerings`.`created_at` AS `created_at` FROM ((((`services` join `languages` on((`services`.`language_id` = `languages`.`id`))) join `offering_types` on((`services`.`offering_type_id` = `offering_types`.`id`))) join `offerings` on((`services`.`id` = `offerings`.`service_id`))) join `users` on((`offerings`.`user_id` = `users`.`id`))) ORDER BY `offerings`.`serial_no` ASC ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `offerings`
--
ALTER TABLE `offerings`
  ADD CONSTRAINT `offerings_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `offerings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_ibfk_2` FOREIGN KEY (`offering_type_id`) REFERENCES `offering_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
