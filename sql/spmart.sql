-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2024 at 04:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `message` text NOT NULL,
  `created_at` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'meow', 'meow@s.com', 'abc', '10-08-23 05:50:59'),
(2, 'dog', 'a@s.com', 'meow', '10-08-23 05:53:09'),
(3, 'karen', 's@s.com', 'i want to file a lawsuit', '12-08-23 09:32:34');

-- --------------------------------------------------------

--
-- Table structure for table `orders_list`
--

CREATE TABLE `orders_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` text DEFAULT NULL,
  `product_price` int(11) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `order_date` text DEFAULT NULL,
  `order_type` text DEFAULT NULL,
  `qr_code` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_list`
--

INSERT INTO `orders_list` (`id`, `product_id`, `product_name`, `product_price`, `product_quantity`, `order_id`, `user_id`, `address`, `order_date`, `order_type`, `qr_code`) VALUES
(55, NULL, NULL, 120, 8, 1, 1, 'N/A', '23-01-24 03:48:00', 'Self-Pickup', 'pickupQR/1.png'),
(56, NULL, NULL, 19, 1, 2, 1, 'N/A', '23-01-24 04:12:10', 'Self-Pickup', 'pickupQR/2.png');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_sku` int(11) NOT NULL,
  `image_link` text NOT NULL,
  `product_name` text NOT NULL,
  `product_desc` text NOT NULL,
  `product_price` int(11) NOT NULL,
  `products_category` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_sku`, `image_link`, `product_name`, `product_desc`, `product_price`, `products_category`) VALUES
(1, 1000000001, 'img/featured_pmnt1.jpg', 'test1', 'testing', 15, 'kao'),
(2, 1000000002, 'img/featured_pmnt1.jpg', 'test2', 'testing', 19, 'kao'),
(3, 1000000003, 'img/featured_pmnt_gatsby1.png', 'Gatsby Facial Wash STRONG', 'FACIAL WASH PERFECT SCRUB STRONG CLEANSING POWER Thoroughly removes dirt, evens rough skin and leaves the skin refreshed!', 5, 'gatsby');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `original_price` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `details` text NOT NULL,
  `img_filepath` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `name`, `original_price`, `sale_price`, `start_date`, `end_date`, `details`, `img_filepath`) VALUES
(1, 'Biore UV Aqua Rich Aqua Protect Mist SPF50 PA++++', 16, 16, '0000-00-00', '2023-10-10', 'Biore unique Aqua Protect Mist Technology', 'img/carousel_pmnt1.jpg'),
(2, 'Biore UV Perfect Milk SPF50+ PA++++', 0, 12, '0000-00-00', '2023-10-10', 'Lasting powdery smooth finish\r\n    + Smooth Skin Feel', 'img/carousel_pmnt2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reward_codes`
--

CREATE TABLE `reward_codes` (
  `id` int(10) UNSIGNED NOT NULL,
  `discount` int(11) NOT NULL,
  `discount_code` varchar(20) NOT NULL,
  `used_code` bit(1) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reward_codes`
--

INSERT INTO `reward_codes` (`id`, `discount`, `discount_code`, `used_code`, `user_id`) VALUES
(1, 5, 'AAAAAAAAAAAAAAAAAAAA', b'0', 1),
(3, 2, 'siDCO7bRsmfspjDfaYxx', b'0', 1),
(4, 2, 'RPUqrbMsNpYi3WWE3JtP', b'0', 4);

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_link` text DEFAULT NULL,
  `product_name` text DEFAULT NULL,
  `product_price` int(11) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `user_address` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `username` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `img_filepath` text DEFAULT NULL,
  `created_at` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `address`, `phone`, `img_filepath`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin@spmart.com', 'ilovecsad', '535 Clementi Rd, Singapore 599489, JCC clubroom', '11111111', 'user-profile-icon/default.png', '199 BC'),
(4, 'gyoza', 'gyoza11', 's@s.com', '1234', 'your house', '', 'user-profile-icon/gyoza.png', '2006');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_list`
--
ALTER TABLE `orders_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_codes`
--
ALTER TABLE `reward_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders_list`
--
ALTER TABLE `orders_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reward_codes`
--
ALTER TABLE `reward_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10009;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reward_codes`
--
ALTER TABLE `reward_codes`
  ADD CONSTRAINT `reward_codes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
