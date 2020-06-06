-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2020 at 02:21 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales-order`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`, `username`) VALUES
(1, 'vijaya@gmail.com', '[]', '$argon2i$v=19$m=65536,t=4,p=1$bmJoMmZyYk1neDQ0ZUNVag$M+g5KyxJMgKHuFq9I+oHEWeT+i22ErY25gGm2d0XINs', 'Vijaya', 'Kumar', 'vijaya');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `location`) VALUES
(1, 'Client-1', 'Location-1'),
(2, 'Client-1', 'Location-1');

-- --------------------------------------------------------

--
-- Table structure for table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200605043303', '2020-06-05 04:33:42');

-- --------------------------------------------------------

--
-- Table structure for table `sales_order`
--

CREATE TABLE `sales_order` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `sales_order_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_value` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_order`
--

INSERT INTO `sales_order` (`id`, `client_id`, `admin_id`, `sales_order_no`, `total_value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'SO-1591332669', 217, '2015-03-05 06:51:09', '2020-06-05 06:51:09'),
(2, 1, 1, 'SO-1591332629', 1306, '2015-04-05 06:51:09', '2020-06-05 06:51:09'),
(3, 1, 1, 'SO-1591332269', 1306, '2016-05-05 06:51:09', '2020-06-05 06:51:09'),
(4, 1, 1, 'SO-1591332469', 1306, '2016-07-05 06:51:09', '2020-06-05 06:51:09'),
(5, 1, 1, 'SO-1591332169', 1306, '2016-02-05 06:51:09', '2020-06-05 06:51:09'),
(6, 1, 1, 'SO-1591335669', 1306, '2016-01-05 06:51:09', '2020-06-05 06:51:09'),
(7, 1, 1, 'SO-1591337669', 1306, '2017-07-05 06:51:09', '2020-06-05 06:51:09'),
(8, 1, 1, 'SO-1591333669', 1306, '2017-09-05 06:51:09', '2020-06-05 06:51:09'),
(9, 1, 1, 'SO-1591338669', 1306, '2017-06-05 06:51:09', '2020-06-05 06:51:09'),
(10, 1, 1, 'SO-1591339669', 1306, '2018-11-05 06:51:09', '2020-06-05 06:51:09'),
(11, 1, 1, 'SO-1591302669', 1306, '2019-12-05 06:51:09', '2020-06-05 06:51:09'),
(12, 1, 1, 'SO-1591352669', 1306, '2019-10-05 06:51:09', '2020-06-05 06:51:09'),
(13, 1, 1, 'SO-1591331669', 1306, '2020-01-05 06:51:09', '2020-06-05 06:51:09'),
(14, 1, 1, 'SO-1591322669', 1306, '2020-03-05 06:51:09', '2020-06-05 06:51:09'),
(15, 1, 1, 'SO-1591355669', 1306, '2020-06-05 06:51:09', '2020-06-05 06:51:09');

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_item`
--

CREATE TABLE `sales_order_item` (
  `id` int(11) NOT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_order_item`
--

INSERT INTO `sales_order_item` (`id`, `item_code`, `item_description`, `price`) VALUES
(1, 'Item-1', 'Item-Desc-1', 539),
(2, 'Item-2', 'Item-Desc-2', 217),
(3, 'Item-3', 'Item-Desc-3', 619),
(4, 'Item-4', 'Item-Desc-4', 148),
(5, 'Item-5', 'Item-Desc-5', 269),
(6, 'Item-6', 'Item-Desc-6', 718),
(7, 'Item-7', 'Item-Desc-7', 694),
(8, 'Item-8', 'Item-Desc-8', 970),
(9, 'Item-9', 'Item-Desc-9', 728),
(10, 'Item-10', 'Item-Desc-10', 821),
(11, 'Item-11', 'Item-Desc-11', 900),
(12, 'Item-12', 'Item-Desc-12', 681),
(13, 'Item-13', 'Item-Desc-13', 373),
(14, 'Item-14', 'Item-Desc-14', 607),
(15, 'Item-15', 'Item-Desc-15', 524),
(16, 'Item-16', 'Item-Desc-16', 463),
(17, 'Item-17', 'Item-Desc-17', 736),
(18, 'Item-18', 'Item-Desc-18', 217),
(19, 'Item-19', 'Item-Desc-19', 630),
(20, 'Item-20', 'Item-Desc-20', 898);

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_mapping`
--

CREATE TABLE `sales_order_mapping` (
  `id` int(11) NOT NULL,
  `sales_order_id` int(11) NOT NULL,
  `sales_order_item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_order_mapping`
--

INSERT INTO `sales_order_mapping` (`id`, `sales_order_id`, `sales_order_item_id`) VALUES
(52, 2, 1),
(53, 2, 3),
(54, 2, 4),
(55, 3, 1),
(56, 3, 3),
(57, 3, 4),
(58, 4, 1),
(59, 4, 3),
(60, 4, 4),
(61, 5, 1),
(62, 5, 3),
(63, 5, 4),
(64, 6, 1),
(65, 6, 3),
(66, 6, 4),
(67, 7, 1),
(68, 7, 3),
(69, 7, 4),
(70, 8, 1),
(71, 8, 3),
(72, 8, 4),
(73, 9, 1),
(74, 9, 3),
(75, 9, 4),
(76, 10, 1),
(77, 10, 3),
(78, 10, 4),
(79, 11, 1),
(80, 11, 3),
(81, 11, 4),
(82, 12, 1),
(83, 12, 3),
(84, 12, 4),
(85, 13, 1),
(86, 13, 3),
(87, 13, 4),
(88, 14, 1),
(89, 14, 3),
(90, 14, 4),
(91, 15, 1),
(92, 15, 3),
(93, 15, 4),
(96, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_880E0D76E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_880E0D76F85E0677` (`username`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `sales_order`
--
ALTER TABLE `sales_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_36D222E18B0BA53` (`sales_order_no`),
  ADD KEY `IDX_36D222E19EB6921` (`client_id`),
  ADD KEY `IDX_36D222E642B8210` (`admin_id`);

--
-- Indexes for table `sales_order_item`
--
ALTER TABLE `sales_order_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_order_mapping`
--
ALTER TABLE `sales_order_mapping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7ABAF372C023F51C` (`sales_order_id`),
  ADD KEY `IDX_7ABAF37221338DA6` (`sales_order_item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales_order`
--
ALTER TABLE `sales_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sales_order_item`
--
ALTER TABLE `sales_order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sales_order_mapping`
--
ALTER TABLE `sales_order_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales_order`
--
ALTER TABLE `sales_order`
  ADD CONSTRAINT `FK_36D222E19EB6921` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `FK_36D222E642B8210` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`);

--
-- Constraints for table `sales_order_mapping`
--
ALTER TABLE `sales_order_mapping`
  ADD CONSTRAINT `FK_7ABAF37221338DA6` FOREIGN KEY (`sales_order_item_id`) REFERENCES `sales_order_item` (`id`),
  ADD CONSTRAINT `FK_7ABAF372C023F51C` FOREIGN KEY (`sales_order_id`) REFERENCES `sales_order` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
