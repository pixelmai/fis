-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2020 at 07:12 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fis`
--

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimensions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deactivated` tinyint(1) NOT NULL DEFAULT 0,
  `updatedby_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machines`
--

INSERT INTO `machines` (`id`, `name`, `status`, `brand`, `model`, `dimensions`, `notes`, `is_deactivated`, `updatedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Laser Cutter 1', 1, NULL, NULL, NULL, NULL, 0, 1, '2020-04-12 16:56:51', '2020-04-12 16:56:51'),
(2, 'Large Format Printer', 1, NULL, NULL, NULL, NULL, 0, 1, '2020-04-12 16:57:10', '2020-04-12 16:57:10'),
(3, '3D Printer', 1, NULL, NULL, NULL, NULL, 0, 1, '2020-04-12 16:57:23', '2020-04-12 16:57:23'),
(4, 'Desktop CNC Milling', 1, NULL, NULL, NULL, NULL, 0, 1, '2020-04-12 16:59:58', '2020-04-12 16:59:58'),
(5, 'Large CNC Milling', 1, NULL, NULL, NULL, NULL, 0, 1, '2020-04-12 17:00:09', '2020-04-12 17:00:09'),
(6, 'Vinyl Cutter', 1, NULL, NULL, NULL, NULL, 0, 1, '2020-04-12 17:00:40', '2020-04-12 17:00:40'),
(7, 'Laser Cutter 2', 1, NULL, NULL, NULL, NULL, 0, 1, '2020-04-12 17:01:11', '2020-04-12 17:01:11');

-- --------------------------------------------------------

--
-- Table structure for table `machines_services`
--

CREATE TABLE `machines_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `machines_id` int(10) UNSIGNED NOT NULL,
  `services_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machines_services`
--

INSERT INTO `machines_services` (`id`, `machines_id`, `services_id`) VALUES
(1, 1, 1),
(2, 7, 1),
(3, 2, 2),
(4, 3, 3),
(5, 4, 4),
(6, 5, 5),
(7, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `servcats_id` tinyint(4) NOT NULL,
  `servicesrates_id` tinyint(4) NOT NULL,
  `is_deactivated` tinyint(1) NOT NULL DEFAULT 0,
  `machines_id` int(11) NOT NULL DEFAULT 0,
  `updatedby_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `unit`, `servcats_id`, `servicesrates_id`, `is_deactivated`, `machines_id`, `updatedby_id`, `created_at`, `updated_at`) VALUES
(1, 'Laser Cutting', 'min.', 1, 1, 0, 1, 1, '2020-04-12 16:55:03', '2020-04-12 17:04:43'),
(2, 'Large Format Printing', 'sq. ft.', 1, 2, 0, 2, 1, '2020-04-12 17:02:58', '2020-04-12 17:02:58'),
(3, '3D Printing', 'min.', 1, 3, 0, 3, 1, '2020-04-12 17:03:31', '2020-04-12 17:03:32'),
(4, 'Desktop CNC', 'hr.', 1, 4, 0, 4, 1, '2020-04-12 17:04:07', '2020-04-12 17:04:07'),
(5, 'Large CNC', 'hr.', 1, 5, 0, 5, 1, '2020-04-12 17:04:32', '2020-04-12 17:04:32'),
(6, 'Vinyl Cutting', 'min.', 1, 6, 0, 6, 1, '2020-04-12 17:05:31', '2020-04-12 17:05:31'),
(7, 'Conference Room A', 'hr.', 4, 7, 0, 0, 1, '2020-04-12 17:07:17', '2020-04-12 17:07:29'),
(8, 'Conference Room A (with Computer Use)', 'hr.', 4, 8, 0, 0, 1, '2020-04-12 17:08:15', '2020-04-12 17:11:09'),
(9, 'Conference Room B', 'hr.', 4, 9, 0, 0, 1, '2020-04-12 17:08:41', '2020-04-12 17:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `servicesrates`
--

CREATE TABLE `servicesrates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `services_id` tinyint(4) NOT NULL,
  `def_price` decimal(15,6) NOT NULL,
  `up_price` decimal(15,6) NOT NULL,
  `updatedby_id` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `servicesrates`
--

INSERT INTO `servicesrates` (`id`, `services_id`, `def_price`, `up_price`, `updatedby_id`, `created_at`, `updated_at`) VALUES
(1, 1, '15.000000', '10.000000', 1, '2020-04-12 16:55:03', '2020-04-12 16:55:03'),
(2, 2, '85.000000', '80.000000', 1, '2020-04-12 17:02:58', '2020-04-12 17:02:58'),
(3, 3, '4.000000', '3.500000', 1, '2020-04-12 17:03:31', '2020-04-12 17:03:31'),
(4, 4, '180.000000', '100.000000', 1, '2020-04-12 17:04:07', '2020-04-12 17:04:07'),
(5, 5, '270.000000', '210.000000', 1, '2020-04-12 17:04:32', '2020-04-12 17:04:32'),
(6, 6, '3.000000', '2.000000', 1, '2020-04-12 17:05:31', '2020-04-12 17:05:31'),
(7, 7, '350.000000', '350.000000', 1, '2020-04-12 17:07:17', '2020-04-12 17:07:17'),
(8, 8, '450.000000', '450.000000', 1, '2020-04-12 17:08:15', '2020-04-12 17:08:15'),
(9, 9, '200.000000', '200.000000', 1, '2020-04-12 17:08:41', '2020-04-12 17:08:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machines_services`
--
ALTER TABLE `machines_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servicesrates`
--
ALTER TABLE `servicesrates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `machines_services`
--
ALTER TABLE `machines_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `servicesrates`
--
ALTER TABLE `servicesrates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
