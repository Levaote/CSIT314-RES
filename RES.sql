SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `fddwxl3t1j0vixe2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `fddwxl3t1j0vixe2`;

CREATE TABLE `MortgageCalculations` (
  `calculation_id` int NOT NULL,
  `user_id` int NOT NULL,
  `loan_amount` decimal(15,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `loan_term_years` int NOT NULL,
  `monthly_repayment` decimal(15,2) NOT NULL,
  `total_interest` decimal(15,2) NOT NULL,
  `calculation_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `MortgageCalculations` (`calculation_id`, `user_id`, `loan_amount`, `interest_rate`, `loan_term_years`, `monthly_repayment`, `total_interest`, `calculation_date`) VALUES
(3, 3, 200000.00, 4.50, 30, 1013.37, 164813.21, '2024-05-20 20:48:29'),
(4, 25, 120000.00, 3.80, 10, 1204.81, 24577.63, '2024-05-20 20:48:29'),
(5, 25, 180000.00, 4.20, 25, 976.84, 114053.94, '2024-05-20 20:48:29'),
(6, 25, 220000.00, 4.70, 30, 1141.48, 191332.76, '2024-05-20 20:48:29'),
(7, 26, 130000.00, 3.60, 20, 763.86, 53069.20, '2024-05-20 20:48:29'),
(8, 26, 175000.00, 4.10, 25, 933.13, 105938.75, '2024-05-20 20:48:29'),
(9, 26, 250000.00, 4.60, 30, 1280.62, 213020.72, '2024-05-20 20:48:29'),
(10, 27, 140000.00, 3.70, 15, 1013.96, 43512.18, '2024-05-20 20:48:29'),
(11, 27, 160000.00, 4.30, 20, 969.69, 72625.60, '2024-05-20 20:48:29'),
(12, 27, 210000.00, 4.80, 30, 1101.25, 186450.25, '2024-05-20 20:48:29'),
(26, 3, 600000.00, 3.85, 35, 2603.00, 493233.00, '2024-05-24 09:03:55'),
(27, 3, 600000.00, 3.85, 28, 2920.00, 381283.00, '2024-05-24 09:04:47'),
(28, 3, 600000.00, 4.25, 35, 2747.00, 553893.00, '2024-05-24 09:05:13'),
(32, 3, 60000000.00, 3.00, 35, 230910.00, 36982248.00, '2024-05-24 13:33:29'),
(33, 3, 10000.00, 3.00, 35, 38.00, 6164.00, '2024-05-24 14:08:12');

CREATE TABLE `PropertyInteractions` (
  `interaction_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `listing_id` int DEFAULT NULL,
  `agent_id` int DEFAULT NULL,
  `interaction_type` varchar(50) DEFAULT NULL,
  `interaction_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `PropertyInteractions` (`interaction_id`, `user_id`, `listing_id`, `agent_id`, `interaction_type`, `interaction_timestamp`) VALUES
(1, 3, 1, NULL, 'View', '2024-05-12 16:58:26'),
(2, 3, 2, NULL, 'Save', '2024-05-12 16:58:26'),
(3, 4, 1, NULL, 'View', '2024-05-12 16:58:26'),
(4, 4, NULL, 2, 'Rate', '2024-05-12 16:58:26'),
(5, 3, 5, NULL, 'Save', '2024-05-19 04:31:55'),
(6, 3, 4, NULL, 'Save', '2024-05-19 04:49:23'),
(7, 3, 1, NULL, 'View', '2024-05-20 01:22:12'),
(8, 3, 1, NULL, 'View', '2024-05-20 01:22:23'),
(9, 3, 1, NULL, 'View', '2024-05-20 01:22:33'),
(10, 3, 24, NULL, 'View', '2024-05-20 01:32:39'),
(11, 3, 11, NULL, 'View', '2024-05-20 01:32:49'),
(12, 3, 1, NULL, 'View', '2024-05-20 01:41:48'),
(13, 3, 2, NULL, 'View', '2024-05-20 01:41:58'),
(14, 3, 13, NULL, 'View', '2024-05-20 01:42:03'),
(15, 3, 13, NULL, 'View', '2024-05-20 01:42:05'),
(16, 3, 13, NULL, 'View', '2024-05-20 01:42:17'),
(17, 3, 13, NULL, 'View', '2024-05-20 01:42:26'),
(18, 3, 13, NULL, 'View', '2024-05-20 01:42:32'),
(19, 3, 13, NULL, 'View', '2024-05-20 01:44:31'),
(20, 3, 13, NULL, 'View', '2024-05-20 01:45:28'),
(21, 3, 13, NULL, 'View', '2024-05-20 01:45:36'),
(22, 3, 13, NULL, 'View', '2024-05-20 01:45:48'),
(23, 3, 13, NULL, 'View', '2024-05-20 01:46:31'),
(24, 3, 13, NULL, 'View', '2024-05-20 01:52:22'),
(25, 3, 1, NULL, 'View', '2024-05-20 02:07:25'),
(26, 3, 1, NULL, 'View', '2024-05-20 02:07:31'),
(27, 3, 1, NULL, 'View', '2024-05-20 02:07:40'),
(28, 3, 1, NULL, 'View', '2024-05-20 02:08:00'),
(29, 3, 1, NULL, 'View', '2024-05-20 02:09:09'),
(30, 3, 1, NULL, 'View', '2024-05-20 02:09:13'),
(31, 3, 1, NULL, 'View', '2024-05-20 02:09:18'),
(32, 3, 1, NULL, 'View', '2024-05-20 02:09:36'),
(34, 3, 1, NULL, 'View', '2024-05-20 02:09:41'),
(35, 3, 1, NULL, 'View', '2024-05-20 02:10:27'),
(36, 3, 12, NULL, 'View', '2024-05-20 02:19:48'),
(38, 3, 12, NULL, 'View', '2024-05-20 02:19:52'),
(39, 3, 12, NULL, 'View', '2024-05-20 02:19:57'),
(40, 3, 12, NULL, 'View', '2024-05-20 02:21:58'),
(41, 3, 12, NULL, 'View', '2024-05-20 02:22:23'),
(42, 3, 10, NULL, 'View', '2024-05-20 02:22:51'),
(43, 3, 10, NULL, 'View', '2024-05-20 02:23:19'),
(44, 3, 10, NULL, 'View', '2024-05-20 02:26:16'),
(45, 3, 2, NULL, 'View', '2024-05-20 03:06:08'),
(46, 3, 1, NULL, 'View', '2024-05-20 03:06:43'),
(47, 3, 9, NULL, 'View', '2024-05-20 03:10:56'),
(48, 3, 9, NULL, 'View', '2024-05-20 03:12:30'),
(49, 3, 1, NULL, 'View', '2024-05-20 08:45:39'),
(50, 3, 1, NULL, 'View', '2024-05-20 08:45:43'),
(51, 3, 2, NULL, 'View', '2024-05-20 08:45:51'),
(52, 3, 2, NULL, 'View', '2024-05-20 08:45:55'),
(53, 3, 1, NULL, 'View', '2024-05-20 08:47:40'),
(54, 3, 1, NULL, 'View', '2024-05-20 08:47:43'),
(55, 3, 1, NULL, 'Save', '2024-05-20 08:47:44'),
(56, 3, 1, NULL, 'View', '2024-05-20 08:47:44'),
(57, 3, 1, NULL, 'View', '2024-05-20 08:47:45'),
(58, 3, 1, NULL, 'View', '2024-05-20 08:47:50'),
(59, 3, 1, NULL, 'View', '2024-05-20 08:48:51'),
(60, 3, 1, NULL, 'View', '2024-05-20 08:48:56'),
(61, 3, 1, NULL, 'View', '2024-05-20 08:49:07'),
(62, 3, 1, NULL, 'View', '2024-05-20 08:49:14'),
(63, 3, 1, NULL, 'View', '2024-05-20 08:51:17'),
(64, 3, 11, NULL, 'View', '2024-05-20 08:51:23'),
(65, 3, 1, NULL, 'View', '2024-05-21 09:23:57'),
(66, 3, 2, NULL, 'View', '2024-05-21 09:26:46'),
(67, 3, 3, NULL, 'View', '2024-05-21 10:30:32'),
(68, 3, 3, NULL, 'View', '2024-05-21 10:30:38'),
(69, 3, 3, NULL, 'View', '2024-05-21 10:30:41'),
(70, 3, 2, NULL, 'View', '2024-05-21 10:30:44'),
(71, 3, 2, NULL, 'View', '2024-05-21 10:34:29'),
(72, 3, 3, NULL, 'View', '2024-05-21 10:34:31'),
(73, 3, 1, NULL, 'View', '2024-05-21 10:34:57'),
(74, 3, 3, NULL, 'View', '2024-05-21 10:35:01'),
(75, 3, 1, NULL, 'View', '2024-05-21 13:08:38'),
(76, 3, 2, NULL, 'View', '2024-05-21 13:08:41'),
(77, 3, 1, NULL, 'View', '2024-05-21 13:09:10'),
(78, 3, 3, NULL, 'View', '2024-05-21 13:09:19'),
(79, 3, 3, NULL, 'View', '2024-05-21 13:15:30'),
(80, 3, 1, NULL, 'View', '2024-05-21 13:46:24'),
(81, 3, 1, NULL, 'View', '2024-05-21 13:47:23'),
(82, 3, 13, NULL, 'View', '2024-05-21 13:47:26'),
(84, 3, 13, NULL, 'View', '2024-05-21 13:47:28'),
(85, 3, 13, NULL, 'View', '2024-05-21 13:47:32'),
(86, 3, 13, NULL, 'View', '2024-05-21 13:47:33'),
(87, 3, 13, NULL, 'View', '2024-05-21 13:47:38'),
(89, 3, 13, NULL, 'View', '2024-05-21 13:47:40'),
(90, 3, 13, NULL, 'View', '2024-05-21 13:47:43'),
(91, 3, 13, NULL, 'View', '2024-05-21 13:47:44'),
(92, 3, 3, NULL, 'View', '2024-05-21 15:19:55'),
(93, 3, 3, NULL, 'View', '2024-05-21 15:20:01'),
(94, 3, 2, NULL, 'View', '2024-05-21 15:21:37'),
(95, 3, 2, NULL, 'View', '2024-05-21 15:21:42'),
(96, 3, 1, NULL, 'View', '2024-05-21 15:22:27'),
(97, 3, 1, NULL, 'View', '2024-05-21 15:56:24'),
(98, 3, 1, NULL, 'View', '2024-05-21 15:56:26'),
(99, 3, 20, NULL, 'View', '2024-05-21 17:57:34'),
(100, 3, 20, NULL, 'Save', '2024-05-21 17:57:35'),
(101, 3, 20, NULL, 'View', '2024-05-21 17:57:36'),
(102, 3, 9, NULL, 'View', '2024-05-21 17:58:45'),
(103, 3, 9, NULL, 'View', '2024-05-21 17:58:48'),
(104, 3, NULL, 2, 'Rate', '2024-05-21 18:24:45'),
(105, 3, 1, NULL, 'View', '2024-05-21 18:37:24'),
(106, 3, 1, NULL, 'View', '2024-05-21 18:40:00'),
(107, 3, 1, NULL, 'View', '2024-05-21 18:45:03'),
(108, 3, 1, NULL, 'View', '2024-05-21 18:46:04'),
(109, 3, 2, NULL, 'View', '2024-05-21 18:46:10'),
(110, 3, 1, NULL, 'View', '2024-05-21 18:47:47'),
(111, 3, 1, NULL, 'View', '2024-05-21 18:48:04'),
(112, 3, 9, NULL, 'View', '2024-05-21 18:48:55'),
(113, 3, 1, NULL, 'View', '2024-05-21 18:52:46'),
(114, 3, 1, NULL, 'View', '2024-05-21 18:53:23'),
(115, 3, 1, NULL, 'View', '2024-05-21 18:54:09'),
(116, 3, 1, NULL, 'View', '2024-05-21 18:54:14'),
(117, 3, 1, NULL, 'View', '2024-05-21 18:54:32'),
(118, 3, 1, NULL, 'View', '2024-05-21 18:54:46'),
(119, 3, 1, NULL, 'View', '2024-05-21 18:55:01'),
(120, 3, 1, NULL, 'View', '2024-05-21 18:55:10'),
(121, 3, 1, NULL, 'View', '2024-05-21 18:55:15'),
(122, 3, 1, NULL, 'View', '2024-05-21 18:55:22'),
(123, 3, 1, NULL, 'View', '2024-05-21 18:59:24'),
(124, 3, 4, NULL, 'View', '2024-05-21 19:01:26'),
(125, 3, 2, NULL, 'View', '2024-05-21 19:06:54'),
(126, 3, 9, NULL, 'View', '2024-05-21 23:17:13'),
(127, 3, 2, NULL, 'View', '2024-05-22 01:37:06'),
(128, 3, 4, NULL, 'View', '2024-05-22 01:41:40'),
(129, 3, 10, NULL, 'View', '2024-05-22 02:00:55'),
(130, 3, 12, NULL, 'View', '2024-05-22 02:58:48'),
(131, 3, 11, NULL, 'View', '2024-05-22 03:05:57'),
(132, 3, 3, NULL, 'View', '2024-05-22 04:06:59'),
(133, 4, NULL, 2, 'Rate', '2024-05-22 09:18:06'),
(134, 3, 1, NULL, 'View', '2024-05-22 09:19:06'),
(135, 3, 1, NULL, 'View', '2024-05-22 10:49:38'),
(136, 3, 1, NULL, 'View', '2024-05-22 10:50:16'),
(137, 3, 1, NULL, 'View', '2024-05-22 10:50:40'),
(138, 3, 1, NULL, 'View', '2024-05-22 10:53:13'),
(139, 3, 1, NULL, 'View', '2024-05-22 10:54:10'),
(140, 3, 1, NULL, 'View', '2024-05-22 10:54:16'),
(141, 3, 1, NULL, 'View', '2024-05-22 10:54:22'),
(142, 3, 1, NULL, 'View', '2024-05-22 10:54:39'),
(143, 3, 1, NULL, 'View', '2024-05-22 10:57:15'),
(144, 3, 12, NULL, 'View', '2024-05-22 10:57:21'),
(145, 3, 1, NULL, 'View', '2024-05-22 10:58:38'),
(146, 3, 1, NULL, 'View', '2024-05-22 10:59:22'),
(147, 3, 1, NULL, 'View', '2024-05-22 11:05:40'),
(148, 3, 1, NULL, 'View', '2024-05-22 11:05:46'),
(149, 3, NULL, 2, 'Rate', '2024-05-22 11:22:44'),
(150, 3, 5, NULL, 'View', '2024-05-22 11:25:45'),
(151, 4, NULL, 2, 'Rate', '2024-05-23 08:53:12'),
(152, 3, 1, NULL, 'View', '2024-05-23 10:17:33'),
(153, 3, 5, NULL, 'View', '2024-05-23 10:17:53'),
(154, 3, 25, NULL, 'View', '2024-05-23 10:20:06'),
(155, 3, 1, NULL, 'View', '2024-05-23 10:20:55'),
(156, 3, 1, NULL, 'View', '2024-05-23 10:21:35'),
(157, 3, 13, NULL, 'View', '2024-05-23 10:21:53'),
(158, 4, NULL, 2, 'Rate', '2024-05-23 11:15:18'),
(159, 3, 2, NULL, 'View', '2024-05-24 03:04:05'),
(160, 3, 25, NULL, 'View', '2024-05-24 03:04:22'),
(162, 3, 25, NULL, 'View', '2024-05-24 03:07:53'),
(163, 3, 25, NULL, 'View', '2024-05-24 03:08:00'),
(164, 3, 13, NULL, 'View', '2024-05-24 03:08:17'),
(165, 3, 13, NULL, 'View', '2024-05-24 03:26:53'),
(166, 3, 13, NULL, 'Save', '2024-05-24 03:27:06'),
(167, 3, 13, NULL, 'View', '2024-05-24 03:27:07'),
(168, 3, NULL, 2, 'Rate', '2024-05-24 03:28:35'),
(170, 3, 1, NULL, 'View', '2024-05-24 09:00:55'),
(171, 3, 25, NULL, 'View', '2024-05-24 10:44:03'),
(172, 3, 1, NULL, 'View', '2024-05-24 10:44:11'),
(173, 3, 2, NULL, 'View', '2024-05-24 10:44:20'),
(174, 3, 4, NULL, 'View', '2024-05-24 11:06:44'),
(175, 3, 1, NULL, 'View', '2024-05-24 11:11:18'),
(176, 3, 1, NULL, 'View', '2024-05-24 11:18:06');

CREATE TABLE `PropertyListings` (
  `listing_id` int NOT NULL,
  `agent_id` int DEFAULT NULL,
  `seller_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `property_type` varchar(100) DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('Active','Sold','Expired') DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `PropertyListings` (`listing_id`, `agent_id`, `seller_id`, `title`, `description`, `property_type`, `price`, `location`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 'Luxury Condo with Marina View', 'Spacious waterfront condo with stunning views.', 'Condo', 1500000.00, 'Marina Bay', 'Active', '2024-05-12 16:58:26', '2024-05-24 13:06:27'),
(2, 2, 4, 'Family-Friendly HDB Apartment', 'Renovated 4-room HDB flat in central location.', 'HDB', 600000.00, 'Tiong Bahru', 'Active', '2024-05-12 16:58:26', '2024-05-15 04:36:30'),
(3, 2, 4, 'Prime Office Space', 'Commercial office space in CBD area.', 'Office', 2500000.00, 'Raffles Place', 'Active', '2024-05-12 16:58:26', '2024-05-12 16:58:26'),
(4, 2, 4, 'Bungalow with Garden', 'Exclusive bungalow with lush garden.', 'House', 5000000.00, 'Yishun', 'Active', '2024-05-12 16:58:26', '2024-05-18 08:43:39'),
(5, 2, 4, 'HDD Apartment for Small Family', '3-room HDB', 'HDB', 500000.00, 'Lakeside', 'Active', '2024-05-17 06:42:31', '2024-05-18 08:43:36'),
(9, 2, 20, 'High Floor in Luxury Condo', 'Situated at level 28 with stunning city view.', 'Condo', 2000000.00, 'Orchard', 'Active', '2024-05-19 04:30:05', '2024-05-19 04:30:05'),
(10, 2, 4, 'Luxurious Condo at Orchard', 'A beautiful and luxurious condo located in the heart of Orchard.', 'Condo', 2000000.00, 'Orchard', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(11, 22, 20, 'Cozy Apartment near Raffles Place', 'A cozy and modern apartment close to Raffles Place MRT.', 'Apartment', 1500000.00, 'Raffles Place', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(12, 22, 20, 'Spacious HDB Flat in Tampines', 'A spacious HDB flat perfect for families, located in Tampines.', 'HDB', 800000.00, 'Tampines', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(13, 23, 28, 'Modern Studio at Tanjong Pagar', 'A modern studio apartment located in Tanjong Pagar.', 'Studio', 1200000.00, 'Tanjong Pagar', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(14, 23, 28, 'Elegant Townhouse in Bukit Timah', 'An elegant townhouse with a beautiful garden in Bukit Timah.', 'Townhouse', 3000000.00, 'Bukit Timah', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(15, 24, 29, 'Stylish Condo at Marina Bay', 'A stylish and luxurious condo with a stunning view of Marina Bay.', 'Condo', 2500000.00, 'Marina Bay', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(16, 24, 29, 'Comfortable HDB Flat in Bedok', 'A comfortable and affordable HDB flat in Bedok.', 'HDB', 700000.00, 'Bedok', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(17, 24, 30, 'Chic Apartment at Clarke Quay', 'A chic and trendy apartment located near Clarke Quay.', 'Apartment', 1800000.00, 'Clarke Quay', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(18, 23, 30, 'Luxurious Condo at Sentosa', 'A luxurious condo with stunning sea views in Sentosa.', 'Condo', 3500000.00, 'Sentosa', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(19, 22, 30, 'Spacious Bungalow in Yishun', 'A spacious and serene bungalow located in Yishun.', 'Bungalow', 4000000.00, 'Yishun', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(20, 2, 4, 'Modern Apartment in Bishan', 'A modern and stylish apartment located in Bishan.', 'Apartment', 1600000.00, 'Bishan', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(21, 24, 20, 'Cozy HDB Flat in Jurong East', 'A cozy and convenient HDB flat located in Jurong East.', 'HDB', 750000.00, 'Jurong East', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(22, 24, 28, 'Elegant Condo at Bukit Batok', 'An elegant condo with modern amenities in Bukit Batok.', 'Condo', 2200000.00, 'Bukit Batok', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(23, 23, 29, 'Comfortable Apartment in Sengkang', 'A comfortable and well-connected apartment in Sengkang.', 'Apartment', 1400000.00, 'Sengkang', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(24, 22, 30, 'Modern Studio at Paya Lebar', 'A modern and compact studio apartment in Paya Lebar.', 'Studio', 1100000.00, 'Paya Lebar', 'Active', '2024-05-19 21:14:19', '2024-05-19 21:14:19'),
(25, 2, 4, '2 bedroom condo', 'Discover The Chuan Park, a remarkable addition to Lorong Chuan’s peaceful neighborhood. Spanning 400,588 sqft, this 99-year leasehold condominium in District 19 offers 900 thoughtfully designed units', '2 bedroom condo', 580000.00, 'Serangoon', 'Active', '2024-05-23 07:53:06', '2024-05-23 07:58:48');

CREATE TABLE `Reviews` (
  `review_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `agent_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comments` text,
  `review_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

INSERT INTO `Reviews` (`review_id`, `user_id`, `agent_id`, `rating`, `comments`, `review_timestamp`) VALUES
(1, 3, 2, 4, 'Agent was very helpful and knowledgeable about properties in Singapore.', '2024-05-12 16:58:26'),
(2, 4, 2, 5, 'Excellent service from the agent. Highly recommended for property transactions in Singapore.', '2024-05-12 16:58:26'),
(3, 3, 2, 5, 'Great experience working with the agent. Very professional.', '2024-05-13 10:15:20'),
(4, 25, 22, 4, 'The agent was helpful but could improve on communication.', '2024-05-13 11:45:30'),
(5, 26, 23, 3, 'Average service. The agent was not very responsive.', '2024-05-14 09:25:50'),
(6, 27, 24, 2, 'Not satisfied with the service. The agent lacked knowledge.', '2024-05-14 14:15:10'),
(7, 4, 2, 5, 'Excellent service from the agent. Highly recommended.', '2024-05-14 16:58:26'),
(8, 20, 22, 4, 'Good experience. The agent was knowledgeable and friendly.', '2024-05-15 12:30:40'),
(9, 28, 23, 3, 'Service was okay. The agent could have been more proactive.', '2024-05-15 15:20:10'),
(10, 29, 24, 2, 'Disappointed with the service. The agent was unprofessional.', '2024-05-16 11:05:30'),
(11, 30, 2, 4, 'Satisfied with the service. The agent was helpful.', '2024-05-16 13:45:50'),
(12, 3, 22, 5, 'Outstanding service. The agent went above and beyond.', '2024-05-16 16:20:20'),
(13, 25, 23, 4, 'Good experience. The agent was responsive and professional.', '2024-05-17 10:10:30'),
(14, 26, 24, 3, 'Average service. The agent could have been more attentive.', '2024-05-17 12:25:40'),
(15, 27, 2, 5, 'Fantastic experience. The agent was very knowledgeable.', '2024-05-17 14:40:50'),
(16, 4, 22, 4, 'Good service. The agent was friendly and helpful.', '2024-05-17 16:55:00'),
(17, 20, 23, 3, 'Average experience. The agent was not very proactive.', '2024-05-18 09:15:20'),
(18, 28, 24, 2, 'Not happy with the service. The agent was unresponsive.', '2024-05-18 11:30:30'),
(19, 29, 2, 4, 'Satisfied with the service. The agent was knowledgeable.', '2024-05-18 13:45:40'),
(20, 30, 22, 5, 'Excellent service. The agent was very professional.', '2024-05-18 15:00:50'),
(21, 3, 23, 4, 'Good experience. The agent was helpful.', '2024-05-18 17:15:00'),
(22, 25, 24, 3, 'Average service. The agent could improve.', '2024-05-19 09:30:10'),
(23, 26, 2, 5, 'Great experience. The agent was very knowledgeable.', '2024-05-19 11:45:20'),
(24, 27, 22, 4, 'Satisfied with the service. The agent was friendly.', '2024-05-19 14:00:30'),
(25, 4, 23, 3, 'Average service. The agent was not very proactive.', '2024-05-19 16:15:40'),
(26, 20, 24, 2, 'Not happy with the service. The agent was unresponsive.', '2024-05-20 09:30:50'),
(27, 28, 2, 5, 'Fantastic experience. The agent was very professional.', '2024-05-20 11:45:00'),
(28, 29, 22, 4, 'Good service. The agent was knowledgeable.', '2024-05-20 14:00:10'),
(29, 30, 23, 3, 'Average experience. The agent could improve.', '2024-05-20 16:15:20'),
(30, 3, 24, 2, 'Not satisfied with the service. The agent was unresponsive.', '2024-05-21 09:30:30'),
(31, 25, 2, 5, 'Excellent service. The agent was very professional.', '2024-05-21 11:45:40'),
(32, 26, 22, 4, 'Good experience. The agent was helpful.', '2024-05-21 14:00:50'),
(33, 27, 23, 3, 'Average service. The agent could improve.', '2024-05-21 16:15:00'),
(34, 4, 24, 2, 'Not happy with the service. The agent was unresponsive.', '2024-05-22 09:30:10'),
(35, 20, 2, 5, 'Great experience. The agent was very knowledgeable.', '2024-05-22 11:45:20'),
(36, 28, 22, 4, 'Satisfied with the service. The agent was friendly.', '2024-05-22 14:00:30'),
(37, 29, 23, 3, 'Average service. The agent was not very proactive.', '2024-05-22 16:15:40'),
(38, 30, 24, 2, 'Disappointed with the service. The agent was unprofessional.', '2024-05-23 09:30:50'),
(39, 3, 2, 5, 'Outstanding service. The agent went above and beyond.', '2024-05-23 11:45:00'),
(40, 25, 22, 4, 'Good experience. The agent was responsive and professional.', '2024-05-23 14:00:10'),
(41, 26, 23, 3, 'Average experience. The agent could have been more attentive.', '2024-05-23 16:15:20'),
(42, 4, 2, 2, 'fef', '2024-05-21 15:04:59'),
(43, 4, 2, 3, 'nice agent', '2024-05-21 15:05:12'),
(44, 4, 2, 2, 'good agent', '2024-05-21 15:05:36'),
(45, 4, 24, 4, 'feffe', '2024-05-21 15:06:42'),
(46, 4, 24, 4, 'very nice agent that provides good services.', '2024-05-21 15:08:56'),
(47, 4, 24, 4, 'very nice agent that provides good services.', '2024-05-21 15:09:04'),
(48, 4, 24, 4, 'very nice agent that provides good services.', '2024-05-21 15:09:27'),
(49, 4, 23, 3, 'good agent', '2024-05-21 15:09:46'),
(50, 4, 2, 2, 'ew', '2024-05-21 15:11:15'),
(51, 3, 2, 1, 'ed', '2024-05-21 17:56:45'),
(52, 3, 2, 2, 'fe', '2024-05-21 17:58:13'),
(53, 3, 2, 2, '1', '2024-05-21 18:19:28'),
(54, 3, 2, 3, 'yy', '2024-05-21 18:23:48'),
(55, 3, 2, 5, 'provided superb service.', '2024-05-21 18:24:45'),
(56, 4, 2, 5, 'very good agent that provided superb service', '2024-05-22 09:18:06'),
(57, 3, 2, 5, 'Agent 1 has rendered excellent service for my property purchases. I would recommend her! ', '2024-05-22 11:22:44'),
(58, 4, 2, 2, 'amazing service', '2024-05-23 08:53:12'),
(59, 4, 2, 5, 'Good good', '2024-05-23 11:15:18'),
(60, 3, 2, 5, 'Satisfied with service.', '2024-05-24 03:28:35'),
(61, 4, NULL, 4, 'satisfied with service.', '2024-05-24 05:44:37');

CREATE TABLE `SavedListings` (
  `save_id` int NOT NULL,
  `buyer_id` int DEFAULT NULL,
  `listing_id` int DEFAULT NULL,
  `saved_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `SavedListings` (`save_id`, `buyer_id`, `listing_id`, `saved_at`) VALUES
(3, 4, 1, '2024-05-12 16:58:26'),
(6, 4, 1, '2024-05-12 16:58:27'),
(32, 3, 2, '2024-05-16 20:11:49'),
(33, 3, 3, '2024-05-16 20:11:50'),
(37, 3, 4, '2024-05-16 21:42:35'),
(42, 3, 5, '2024-05-18 09:07:45'),
(60, 3, 1, '2024-05-20 08:47:44'),
(63, 3, 20, '2024-05-21 17:57:35'),
(65, 3, 13, '2024-05-24 03:27:06');

CREATE TABLE `Transactions` (
  `transaction_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `transaction_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `UserProfiles` (
  `profile_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `address` text,
  `profile_picture` varchar(255) DEFAULT NULL,
  `bio` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `UserProfiles` (`profile_id`, `user_id`, `first_name`, `last_name`, `address`, `profile_picture`, `bio`) VALUES
(1, 1, 'Admin', 'One', '123 Admin St, Adminville', 'admin.jpg', 'I am the system administrator.'),
(2, 2, 'Agent', 'Smith', '456 Agent Rd, Agent City', 'agent.jpg', 'Experienced real estate agent in Singapore.'),
(3, 3, 'John', 'Doe', '789 Buyer Ave, Buyer Town', 'buyer.jpg', 'Looking to buy a new home in Singapore.'),
(4, 4, 'Jane', 'Doe', '321 Seller Blvd, Seller Springs', 'seller.jpg', 'Selling properties in Singapore.'),
(5, 5, 'Afirst', 'Alast', '1122 ABC Street', '', 'A Bio'),
(8, 20, 'jack', 'stack', '221B Baker Street', '', 'test bio'),
(9, 21, 'ad', 'min', 'admin street\r\nadmin colony', '', 'test bio'),
(10, 22, 'Agent', 'Seven', '123 Agent St, Agentville', 'agent7.jpg', 'Experienced real estate agent.'),
(11, 23, 'Agent', 'Eight', '124 Agent St, Agentville', 'agent8.jpg', 'Experienced real estate agent.'),
(12, 24, 'Agent', 'Nine', '125 Agent St, Agentville', 'agent9.jpg', 'Experienced real estate agent.'),
(13, 25, 'Buyer', 'Seven', '123 Buyer St, Buyer Town', 'buyer7.jpg', 'Looking to buy a new home.'),
(14, 26, 'Buyer', 'Eight', '124 Buyer St, Buyer Town', 'buyer8.jpg', 'Looking to buy a new home.'),
(15, 27, 'Buyer', 'Nine', '125 Buyer St, Buyer Town', 'buyer9.jpg', 'Looking to buy a new home.'),
(16, 28, 'Seller', 'Seven', '123 Seller St, Seller Springs', 'seller7.jpg', 'Selling properties.'),
(17, 29, 'Seller', 'Eight', '124 Seller St, Seller Springs', 'seller8.jpg', 'Selling properties.'),
(18, 30, 'Seller', 'Nine', '125 Seller St, Seller Springs', 'seller9.jpg', 'Selling properties.'),
(19, 31, 'Ad', 'Min20', 'Test address ', '', 'Test bio'),
(23, 35, 'Buy', 'Er50', '321 Buyer50 Road', '', 'no Bio');

CREATE TABLE `Users` (
  `user_id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('System Administrator','Real Estate Agent','Buyer','Seller') NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `Users` (`user_id`, `username`, `password`, `role`, `email`, `phone`, `is_active`, `last_login`, `created_at`) VALUES
(1, 'admin1', 'adminpass', 'System Administrator', 'admin1@example.com', '1234567890', 1, NULL, '2024-05-12 16:58:26'),
(2, 'agent1', 'agentpass', 'Real Estate Agent', 'agent1@example.com', '9876543210', 1, NULL, '2024-05-12 16:58:26'),
(3, 'buyer1', 'buyerpass', 'Buyer', 'buyer1@example.com', '5551234567', 1, NULL, '2024-05-12 16:58:26'),
(4, 'seller1', 'sellerpass', 'Seller', 'seller1@example.com', '9998765432', 1, NULL, '2024-05-12 16:58:26'),
(5, 'admin231311241', 'Password', 'System Administrator', 'admin@admin.com', '123456789', 0, NULL, '2024-05-12 20:15:30'),
(20, 'Jack28', 'jackpass', 'Seller', 'jack99@hmail.com', '87676543', 1, NULL, '2024-05-17 10:02:47'),
(21, 'admin10', 'password123', 'System Administrator', 'myemail@domain.com', '12349876', 1, NULL, '2024-05-19 10:02:36'),
(22, 'agent7', 'password123', 'Real Estate Agent', 'agent7@example.com', '123-456-7897', 1, '2024-05-19 21:06:13', '2024-05-19 21:06:13'),
(23, 'agent8', 'password123', 'Real Estate Agent', 'agent8@example.com', '123-456-7898', 1, '2024-05-19 21:06:13', '2024-05-19 21:06:13'),
(24, 'agent9', 'password123', 'Real Estate Agent', 'agent9@example.com', '123-456-7899', 1, '2024-05-19 21:06:13', '2024-05-19 21:06:13'),
(25, 'buyer7', 'password789', 'Buyer', 'buyer7@example.com', '223-456-7897', 1, '2024-05-19 21:06:13', '2024-05-19 21:06:13'),
(26, 'buyer8', 'password123', 'Buyer', 'buyer8@example.com', '223-456-7898', 1, '2024-05-19 21:06:13', '2024-05-19 21:06:13'),
(27, 'buyer9', 'password123', 'Buyer', 'buyer9@example.com', '223-456-7899', 1, '2024-05-19 21:06:13', '2024-05-19 21:06:13'),
(28, 'seller7', 'password123', 'Seller', 'seller7@example.com', '323-456-7897', 1, '2024-05-19 21:06:14', '2024-05-19 21:06:14'),
(29, 'seller8', 'password123', 'Seller', 'seller8@example.com', '323-456-7898', 1, '2024-05-19 21:06:14', '2024-05-19 21:06:14'),
(30, 'seller9', 'password123', 'Seller', 'seller9@example.com', '323-456-7899', 1, '2024-05-19 21:06:14', '2024-05-19 21:06:14'),
(31, 'Admin20', 'admin20pass', 'System Administrator', 'test20@testmail.com', '87654567', 1, NULL, '2024-05-23 06:40:44'),
(35, 'buyer50', 'buyer50pass', 'Buyer', 'buyer50@zmail.com', '83746362', 1, NULL, '2024-05-24 02:59:14');


ALTER TABLE `MortgageCalculations`
  ADD PRIMARY KEY (`calculation_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `PropertyInteractions`
  ADD PRIMARY KEY (`interaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `listing_id` (`listing_id`),
  ADD KEY `agent_id` (`agent_id`) USING BTREE;

ALTER TABLE `PropertyListings`
  ADD PRIMARY KEY (`listing_id`),
  ADD KEY `agent_id` (`agent_id`,`seller_id`) USING BTREE,
  ADD KEY `PropertyListings_ibfk_2` (`seller_id`);

ALTER TABLE `Reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `agent_id` (`agent_id`);

ALTER TABLE `SavedListings`
  ADD PRIMARY KEY (`save_id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `listing_id` (`listing_id`);

ALTER TABLE `Transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `UserProfiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `MortgageCalculations`
  MODIFY `calculation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

ALTER TABLE `PropertyInteractions`
  MODIFY `interaction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

ALTER TABLE `PropertyListings`
  MODIFY `listing_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

ALTER TABLE `Reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `SavedListings`
  MODIFY `save_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

ALTER TABLE `Transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `UserProfiles`
  MODIFY `profile_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

ALTER TABLE `Users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;


ALTER TABLE `MortgageCalculations`
  ADD CONSTRAINT `MortgageCalculations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

ALTER TABLE `PropertyInteractions`
  ADD CONSTRAINT `PropertyInteractions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `PropertyInteractions_ibfk_2` FOREIGN KEY (`listing_id`) REFERENCES `PropertyListings` (`listing_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `PropertyInteractions_ibfk_3` FOREIGN KEY (`agent_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `PropertyListings`
  ADD CONSTRAINT `PropertyListings_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `Users` (`user_id`),
  ADD CONSTRAINT `PropertyListings_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `Users` (`user_id`);

ALTER TABLE `Reviews`
  ADD CONSTRAINT `Reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Reviews_ibfk_2` FOREIGN KEY (`agent_id`) REFERENCES `Users` (`user_id`) ON DELETE SET NULL;

ALTER TABLE `SavedListings`
  ADD CONSTRAINT `SavedListings_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `SavedListings_ibfk_2` FOREIGN KEY (`listing_id`) REFERENCES `PropertyListings` (`listing_id`) ON DELETE CASCADE;

ALTER TABLE `Transactions`
  ADD CONSTRAINT `Transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE;

ALTER TABLE `UserProfiles`
  ADD CONSTRAINT `UserProfiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
