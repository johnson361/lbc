-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 04, 2025 at 09:09 AM
-- Server version: 8.3.0
-- PHP Version: 8.1.28

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
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `offerings`
--

INSERT INTO `offerings` (`id`, `service_id`, `service_date`, `user_id`, `serial_no`, `denomination_2000`, `denomination_500`, `denomination_200`, `denomination_100`, `denomination_50`, `denomination_20_notes`, `denomination_20_coins`, `denomination_10_notes`, `denomination_10_coins`, `denomination_5_notes`, `denomination_5_coins`, `denomination_2_notes`, `denomination_2_coins`, `denomination_1_notes`, `denomination_1_coins`, `created_at`) VALUES
(104, 21, '2024-12-31', 91, 1, 0, 19, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 09:52:26'),
(105, 23, '2024-12-31', 93, 1, 0, 0, 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 09:54:07'),
(106, 23, '2024-12-31', 94, 2, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 09:54:21'),
(107, 23, '2024-12-31', 95, 3, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 09:54:36'),
(108, 23, '2024-12-31', 96, 4, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 09:54:50'),
(109, 23, '2024-12-31', 97, 5, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 09:55:23'),
(110, 23, '2024-12-31', 92, 6, 0, 0, 0, 6, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 09:55:59'),
(111, 23, '2024-12-31', 98, 7, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 09:56:25'),
(112, 23, '2024-12-31', 99, 8, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 09:56:46'),
(113, 23, '2024-12-31', 100, 9, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 09:56:57'),
(114, 24, '2024-12-31', 101, 1, 0, 47, 20, 169, 62, 150, 1, 82, 2, 0, 17, 0, 38, 0, 28, '2025-01-01 10:21:28'),
(115, 21, '2025-01-01', 102, 1, 0, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:37:59'),
(116, 21, '2025-01-01', 103, 2, 0, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:38:20'),
(117, 21, '2025-01-01', 104, 3, 0, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:38:36'),
(118, 21, '2025-01-01', 105, 4, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:38:55'),
(119, 21, '2025-01-01', 106, 5, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:39:09'),
(120, 21, '2025-01-01', 107, 6, 0, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:39:22'),
(121, 21, '2025-01-01', 108, 7, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:39:37'),
(122, 21, '2025-01-01', 109, 8, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:39:50'),
(123, 21, '2025-01-01', 110, 9, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:40:00'),
(124, 21, '2025-01-01', 111, 10, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:40:10'),
(125, 21, '2025-01-01', 112, 11, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:40:27'),
(126, 21, '2025-01-01', 113, 12, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:40:59'),
(127, 21, '2025-01-01', 114, 13, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:41:04'),
(128, 21, '2025-01-01', 115, 14, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:41:29'),
(129, 21, '2025-01-01', 117, 15, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:41:46'),
(130, 21, '2025-01-01', 116, 16, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:43:02'),
(131, 52, '2025-01-01', 101, 1, 0, 1, 0, 4, 1, 9, 0, 4, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:46:12'),
(132, 23, '2025-01-01', 118, 1, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:48:09'),
(133, 23, '2025-01-01', 119, 2, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:48:24'),
(134, 23, '2025-01-01', 120, 3, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:48:34'),
(135, 23, '2025-01-01', 121, 4, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:48:44'),
(136, 23, '2025-01-01', 122, 5, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:48:58'),
(137, 23, '2025-01-01', 123, 6, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:49:08'),
(138, 23, '2025-01-01', 124, 7, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:49:48'),
(139, 23, '2025-01-01', 125, 8, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:49:59'),
(140, 23, '2025-01-01', 126, 9, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:50:09'),
(141, 23, '2025-01-01', 127, 10, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:50:20'),
(142, 23, '2025-01-01', 128, 11, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:50:33'),
(143, 23, '2025-01-01', 129, 12, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:51:02'),
(144, 23, '2025-01-01', 130, 13, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:51:19'),
(145, 23, '2025-01-01', 131, 14, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:51:39'),
(146, 23, '2025-01-01', 132, 15, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:51:58'),
(147, 23, '2025-01-01', 133, 16, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:52:08'),
(148, 23, '2025-01-01', 134, 17, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:52:19'),
(149, 23, '2025-01-01', 135, 18, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:52:46'),
(150, 23, '2025-01-01', 136, 19, 0, 0, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:53:08'),
(151, 23, '2025-01-01', 100, 20, 0, 0, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:53:34'),
(152, 23, '2025-01-01', 137, 21, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:53:53'),
(153, 23, '2025-01-01', 138, 22, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:54:21'),
(154, 23, '2025-01-01', 139, 23, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:54:58'),
(155, 23, '2025-01-01', 140, 24, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:55:11'),
(156, 23, '2025-01-01', 141, 25, 0, 0, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:55:27'),
(157, 23, '2025-01-01', 142, 26, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-01 10:55:39'),
(158, 24, '2025-01-01', 101, 1, 0, 42, 20, 162, 75, 123, 1, 75, 4, 0, 7, 0, 9, 0, 7, '2025-01-01 10:57:56');

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
(51, NULL, 7, NULL, '2024-12-23 10:12:10'),
(52, NULL, 5, NULL, '2024-12-20 06:43:34'),
(53, NULL, 6, NULL, '2024-12-20 06:43:42');

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
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(142, 'T NISHANTH S/O T AMBEDKAR', NULL, '9700123836', '', '2025-01-01 10:55:39');

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
