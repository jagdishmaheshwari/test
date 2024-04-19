-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2024 at 08:01 PM
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
-- Database: `kachchhkala`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`category_id`, `category_name`, `description`) VALUES
(1, 'Saree', 'asas'),
(2, 'Kurta', 'Hello World lorem ipsum dolor shit hello Hello World lorem ipsum dolor shit hello Hello World lorem ipsum dolor shit hello'),
(3, 'Baby', 'OKOKok');

-- --------------------------------------------------------

--
-- Table structure for table `color_list`
--

CREATE TABLE `color_list` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(100) NOT NULL,
  `color_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `color_list`
--

INSERT INTO `color_list` (`color_id`, `color_name`, `color_code`) VALUES
(3, 'Pink', '#ff33da'),
(4, 'Red', '#ff0000'),
(5, 'Blue', '#0034ad'),
(6, 'as', '#ff0a0a'),
(7, 'as', '#ce1c1c'),
(8, 'as', '#ff0000');

-- --------------------------------------------------------

--
-- Table structure for table `contact_queries`
--

CREATE TABLE `contact_queries` (
  `query_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `query` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_queries`
--

INSERT INTO `contact_queries` (`query_id`, `full_name`, `mobile_no`, `email`, `subject`, `query`, `status`, `response`, `created_at`, `updated_at`) VALUES
(1, 'Jagdish Maheshwari', '9586661184', 'bhavdep@gm.vk', 'MJBJ', 'MJJBKJ', 1, 'ds sdsd sd sd sd sd sd sd sd', '2024-03-29 09:33:22', '2024-04-08 18:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_registered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_images`
--

CREATE TABLE `item_images` (
  `image_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `priority` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_images`
--

INSERT INTO `item_images` (`image_id`, `item_id`, `image_url`, `created_at`, `priority`) VALUES
(1, 634, 'SLKSAREEA2020ODDSD-08ec2efcf0142e45c607570add5be471abd4504c_20240401112010.jpeg', '2024-04-01 17:50:10', 0),
(2, 634, 'SLKSAREEA2020ODDSD-08ec2efcf0142e45c607570add5be471abd4504c_20240401112013.jpg', '2024-04-01 17:50:13', 0),
(3, 626, 'SLKSAREE2020ODD-9a84e151813e6605a751da99bf06757a0cb5b278_20240401112138.jpeg', '2024-04-01 17:51:38', 0),
(4, 626, 'SLKSAREE2020ODD-9a84e151813e6605a751da99bf06757a0cb5b278_20240401112141.jpg', '2024-04-01 17:51:41', 0),
(5, 626, 'SLKSAREE2020ODD-9a84e151813e6605a751da99bf06757a0cb5b278_20240401112143.jpeg', '2024-04-01 17:51:43', 0),
(6, 626, 'SLKSAREE2020ODD-9a84e151813e6605a751da99bf06757a0cb5b278_20240401112146.jpg', '2024-04-01 17:51:46', 0),
(7, 626, 'SLKSAREE2020ODD-9a84e151813e6605a751da99bf06757a0cb5b278_20240401112149.jpg', '2024-04-01 17:51:49', 0),
(8, 636, 'SLKSAREE2020ODD-bc60205da2555fc0304c24d2a1b8532bba3350e5_20240401112217.jpeg', '2024-04-01 17:52:17', 1),
(9, 636, 'SLKSAREE2020ODD-bc60205da2555fc0304c24d2a1b8532bba3350e5_20240401112219.jpg', '2024-04-01 17:52:19', 0),
(10, 637, 'SLKSAREE2020ODD-bc60205da2555fc0304c24d2a1b8532bba3350e5_20240401112219.jpg', '2024-04-01 17:52:40', 0),
(11, 637, 'SLKSAREE2020ODD-bc60205da2555fc0304c24d2a1b8532bba3350e5_20240401112217.jpeg', '2024-04-01 17:52:40', 0),
(12, 638, 'BBH1212JN-afc3bf9d346f20c15bd914465c0beae12e0dba2e_20240401112721.jpeg', '2024-04-01 17:57:21', 0),
(15, 639, 'BBH1212JN-afc3bf9d346f20c15bd914465c0beae12e0dba2e_20240401112721.jpeg', '2024-04-01 17:59:38', 0),
(16, 640, 'SLKSAREEA2020ODDSD-08ec2efcf0142e45c607570add5be471abd4504c_20240401112010.jpeg', '2024-04-08 18:34:44', 0),
(17, 640, 'SLKSAREEA2020ODDSD-08ec2efcf0142e45c607570add5be471abd4504c_20240401112013.jpg', '2024-04-08 18:34:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_list`
--

CREATE TABLE `item_list` (
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `mrp` int(10) UNSIGNED NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 0,
  `priority` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_list`
--

INSERT INTO `item_list` (`item_id`, `category_id`, `product_id`, `color_id`, `size_id`, `mrp`, `price`, `visible`, `priority`) VALUES
(626, 2, 12, 5, 3, 12, 210, 0, 0),
(634, 1, 8, 5, 1, 79, 210, 1, 0),
(636, 2, 12, 5, 3, 12121, 210, 1, 0),
(637, 2, 12, 5, 2, 1200, 1, 1, 0),
(638, 3, 13, 5, 2, 3333, 1, 1, 12),
(639, 3, 13, 5, 1, 3333, 210, 1, 0),
(640, 1, 8, 5, 3, 122, 210, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs_visitors`
--

CREATE TABLE `logs_visitors` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `visit_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs_visitors`
--

INSERT INTO `logs_visitors` (`id`, `item_id`, `ip_address`, `visit_timestamp`) VALUES
(1, 636, '::1', '2024-04-07 17:16:51'),
(2, 636, '::1', '2024-04-08 17:17:20'),
(3, 634, '::1', '2024-04-08 17:17:33'),
(4, 637, '::1', '2024-04-08 17:18:11'),
(5, 634, '12', '2024-04-08 17:19:26'),
(6, 634, '12', '2024-04-08 17:19:57'),
(7, 634, '12', '2024-04-08 17:20:01'),
(8, 634, '12', '2024-04-08 17:20:02'),
(9, 634, '12', '2024-04-08 17:20:06'),
(10, 638, '::1', '2024-04-08 17:46:55'),
(11, 636, '::1', '2024-04-08 18:30:44'),
(12, 637, '::1', '2024-04-08 19:05:50'),
(13, 634, '::1', '2024-04-08 19:25:41'),
(14, 636, '192.168.85.89', '2024-04-09 17:33:14'),
(15, 634, '192.168.85.89', '2024-04-09 17:33:53'),
(16, 634, '::1', '2024-04-11 17:29:02'),
(17, 634, '::1', '2024-04-11 18:52:01');

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `gender` char(2) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `priority` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`product_id`, `category_id`, `created_at`, `updated_at`, `product_code`, `product_name`, `description`, `keywords`, `gender`, `visible`, `priority`) VALUES
(8, 1, '2024-03-25 01:11:19', '2024-04-09 01:58:41', 'SLKSAREEA2020ODDSD', 'Best Designed saree with silk fabric hello world helo world', '12', 'saree,women,saree,silk saree', 'f', 1, 0),
(12, 2, '2024-03-25 21:29:15', '2024-04-05 21:18:43', 'SLKSAREE2020ODD', 'qwwe', 'eqvqw qw qw vq r', 'kurta, men, men kurta, mens kurta, women', 'f', 1, 3),
(13, 3, '2024-04-01 23:26:51', '2024-04-01 23:26:51', 'BBH1212JN', 'Baby&#039;s special wedding kurta', 'This kurta is best suitable for babies oniajdoa sd amsdn asmdjasmdn asmdna sdmnas dmsand msan amsnd asmdn sadm f', 'a', 'm', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_specifications`
--

CREATE TABLE `product_specifications` (
  `specification_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `priority` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` varchar(50) NOT NULL,
  `amount` int(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `size_list`
--

CREATE TABLE `size_list` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `size_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size_list`
--

INSERT INTO `size_list` (`size_id`, `size_name`, `size_code`) VALUES
(1, 'Small', 'S'),
(2, 'Medium', 'M'),
(3, 'Extra Small', 'XS'),
(4, 'Large', 'L');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `remark` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `item_id`, `location`, `quantity`, `remark`, `updated_at`) VALUES
(1, 626, 'Bhuj', -100, 'w', '2024-04-02 17:01:38'),
(2, 626, 'Bhuj', 100, '100', '2024-04-02 17:01:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('Male','Female','NotToSay') DEFAULT 'NotToSay',
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `gender`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 'Jagdish Maheshwari', 'Jagdishmaheshwari1703@gmail.com', '7b52009b64fd0a2a49e6d8a939753077792b0554', 'Male', '9586661184', '2024-04-09 20:40:27', '2024-04-09 20:49:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `color_list`
--
ALTER TABLE `color_list`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `contact_queries`
--
ALTER TABLE `contact_queries`
  ADD PRIMARY KEY (`query_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `item_images`
--
ALTER TABLE `item_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `item_list`
--
ALTER TABLE `item_list`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `logs_visitors`
--
ALTER TABLE `logs_visitors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_item_id1` (`item_id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD PRIMARY KEY (`specification_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `customer_id` (`customer_id`) USING BTREE;

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD UNIQUE KEY `unique_rating_per_purchase` (`customer_id`,`purchase_id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `size_list`
--
ALTER TABLE `size_list`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `fk_item_id` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `color_list`
--
ALTER TABLE `color_list`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact_queries`
--
ALTER TABLE `contact_queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_images`
--
ALTER TABLE `item_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `item_list`
--
ALTER TABLE `item_list`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=641;

--
-- AUTO_INCREMENT for table `logs_visitors`
--
ALTER TABLE `logs_visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_specifications`
--
ALTER TABLE `product_specifications`
  MODIFY `specification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `size_list`
--
ALTER TABLE `size_list`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `item_images`
--
ALTER TABLE `item_images`
  ADD CONSTRAINT `item_images_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`item_id`);

--
-- Constraints for table `item_list`
--
ALTER TABLE `item_list`
  ADD CONSTRAINT `item_list_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`category_id`),
  ADD CONSTRAINT `item_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`product_id`),
  ADD CONSTRAINT `item_list_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `color_list` (`color_id`),
  ADD CONSTRAINT `item_list_ibfk_4` FOREIGN KEY (`size_id`) REFERENCES `size_list` (`size_id`);

--
-- Constraints for table `logs_visitors`
--
ALTER TABLE `logs_visitors`
  ADD CONSTRAINT `fk_item_id1` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`item_id`);

--
-- Constraints for table `product_list`
--
ALTER TABLE `product_list`
  ADD CONSTRAINT `product_list_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`category_id`);

--
-- Constraints for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD CONSTRAINT `product_specifications_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`product_id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`item_id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`purchase_id`),
  ADD CONSTRAINT `ratings_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`item_id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_item_id` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
