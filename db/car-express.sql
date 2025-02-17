-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 01:57 PM
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
-- Database: `car-express`
--

-- --------------------------------------------------------

--
-- Table structure for table `car_brands`
--

CREATE TABLE `car_brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_brands`
--

INSERT INTO `car_brands` (`id`, `brand_name`, `created_at`) VALUES
(1, 'Toyota', '2025-02-16 06:01:47'),
(2, 'Honda', '2025-02-16 06:01:47'),
(3, 'Ford', '2025-02-16 06:01:47'),
(4, 'BMW', '2025-02-16 06:01:47'),
(5, 'Mercedes', '2025-02-16 06:01:47'),
(6, 'Audi', '2025-02-16 06:01:47'),
(7, 'Tesla', '2025-02-16 06:01:47'),
(8, 'Nissan', '2025-02-16 06:01:47'),
(9, 'Chevrolet', '2025-02-16 06:01:47'),
(10, 'Hyundai', '2025-02-16 06:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `car_category_info`
--

CREATE TABLE `car_category_info` (
  `id` int(11) NOT NULL,
  `car_manufacturer` varchar(255) NOT NULL,
  `car_model` varchar(255) NOT NULL,
  `car_variant` varchar(255) DEFAULT NULL,
  `added_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_category_info`
--

INSERT INTO `car_category_info` (`id`, `car_manufacturer`, `car_model`, `car_variant`, `added_date`) VALUES
(1, 'Tesla', 'Model X', 'Long Range', '2025-02-13 10:00:00'),
(2, 'Ford', 'Mustang GT', 'GT', '2025-02-13 11:00:00'),
(3, 'Ford', 'Focus', 'Titanium', '2025-02-13 12:00:00'),
(4, 'Honda', 'Civic', 'Sport', '2025-02-13 13:00:00'),
(5, 'Honda', 'Accord', 'EX-L', '2025-02-13 14:00:00'),
(6, 'Toyota', 'Corolla', 'LE', '2025-02-13 15:00:00'),
(7, 'Audi', 'A4', 'Premium', '2025-02-13 16:00:00'),
(8, 'Bugatti', 'Chiron', 'Super Sport', '2025-02-13 17:00:00'),
(9, 'Tesla', 'Model 3', 'Standard Range Plus', '2025-02-13 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `car_models`
--

CREATE TABLE `car_models` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_models`
--

INSERT INTO `car_models` (`id`, `brand_id`, `model_name`, `created_at`) VALUES
(1, 1, 'Corolla', '2025-02-16 06:01:47'),
(2, 1, 'Camry', '2025-02-16 06:01:47'),
(3, 2, 'Civic', '2025-02-16 06:01:47'),
(4, 2, 'Accord', '2025-02-16 06:01:47'),
(5, 3, 'Mustang', '2025-02-16 06:01:47'),
(6, 3, 'F-150', '2025-02-16 06:01:47'),
(7, 4, 'X5', '2025-02-16 06:01:47'),
(8, 4, 'M3', '2025-02-16 06:01:47'),
(9, 5, 'C-Class', '2025-02-16 06:01:47'),
(10, 5, 'E-Class', '2025-02-16 06:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `car_variants`
--

CREATE TABLE `car_variants` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `variant_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_variants`
--

INSERT INTO `car_variants` (`id`, `brand_id`, `model_id`, `variant_name`, `created_at`) VALUES
(1, 1, 1, 'Corolla Base Model', '2025-02-16 06:01:47'),
(2, 1, 1, 'Corolla Sport Edition', '2025-02-16 06:01:47'),
(3, 1, 2, 'Camry Hybrid', '2025-02-16 06:01:47'),
(4, 1, 2, 'Camry XSE', '2025-02-16 06:01:47'),
(5, 2, 3, 'Civic LX', '2025-02-16 06:01:47'),
(6, 2, 3, 'Civic Sport', '2025-02-16 06:01:47'),
(7, 2, 4, 'Accord Touring', '2025-02-16 06:01:47'),
(8, 2, 4, 'Accord EX-L', '2025-02-16 06:01:47'),
(9, 3, 5, 'Mustang GT', '2025-02-16 06:01:47'),
(10, 3, 5, 'Mustang EcoBoost', '2025-02-16 06:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `state` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `city_name`, `pincode`, `state`, `created_at`) VALUES
(1, 'delhi', '784510', 'delhi', '2025-01-24 06:28:38'),
(2, 'Mumbai', '123456', 'Mumbai', '2025-01-24 07:03:47'),
(3, 'pune', '784512', 'Gujrat', '2025-01-24 11:04:19'),
(4, 'Gopalganj', '459863', 'Bihar', '2025-01-24 11:05:15'),
(9, 'Mohali', '1168686', 'hkhjghjbj', '2025-02-06 12:34:34');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `language_id` int(11) NOT NULL,
  `language_code` varchar(10) DEFAULT NULL,
  `language_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`language_id`, `language_code`, `language_name`) VALUES
(1, 'en', 'English'),
(2, 'hi', 'हिंदी');

-- --------------------------------------------------------

--
-- Table structure for table `location_city`
--

CREATE TABLE `location_city` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(255) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location_city`
--

INSERT INTO `location_city` (`city_id`, `city_name`, `state_id`, `created_at`) VALUES
(1, 'Hyderabad', 12, '2025-02-17 05:44:16'),
(2, 'Bengaluru', 12, '2025-02-17 05:44:16'),
(3, 'Mumbai', 15, '2025-02-17 05:44:16'),
(4, 'Pune', 15, '2025-02-17 05:44:16'),
(5, 'Delhi', 30, '2025-02-17 05:44:16'),
(6, 'Chennai', 22, '2025-02-17 05:44:16'),
(7, 'Kolkata', 19, '2025-02-17 05:44:16'),
(8, 'Jaipur', 21, '2025-02-17 05:44:16'),
(9, 'Lucknow', 28, '2025-02-17 05:44:16'),
(10, 'Bhopal', 14, '2025-02-17 05:44:16'),
(11, 'Patna', 4, '2025-02-17 05:44:16'),
(12, 'Ahmedabad', 9, '2025-02-17 05:44:16'),
(13, 'Chandigarh', 2, '2025-02-17 05:44:16'),
(14, 'Goa', 6, '2025-02-17 05:44:16'),
(15, 'Thiruvananthapuram', 13, '2025-02-17 05:44:16'),
(16, 'Shillong', 17, '2025-02-17 05:44:16'),
(17, 'Agartala', 24, '2025-02-17 05:44:16'),
(18, 'Indore', 14, '2025-02-17 05:44:16'),
(19, 'Visakhapatnam', 1, '2025-02-17 05:44:16'),
(20, 'Vadodara', 9, '2025-02-17 05:44:16'),
(21, 'Dehradun', 33, '2025-02-17 05:44:16'),
(22, 'Gangtok', 23, '2025-02-17 05:44:16'),
(23, 'Imphal', 16, '2025-02-17 05:44:16'),
(24, 'Raipur', 5, '2025-02-17 05:44:16'),
(25, 'Aurangabad', 15, '2025-02-17 05:44:16'),
(26, 'Nagpur', 15, '2025-02-17 05:44:16'),
(27, 'Vijayawada', 1, '2025-02-17 05:44:16');

-- --------------------------------------------------------

--
-- Table structure for table `location_state`
--

CREATE TABLE `location_state` (
  `state_id` int(11) NOT NULL,
  `state_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location_state`
--

INSERT INTO `location_state` (`state_id`, `state_name`, `created_at`) VALUES
(1, 'Andhra Pradesh', '2025-02-17 05:40:01'),
(2, 'Arunachal Pradesh', '2025-02-17 05:40:01'),
(3, 'Assam', '2025-02-17 05:40:01'),
(4, 'Bihar', '2025-02-17 05:40:01'),
(5, 'Chhattisgarh', '2025-02-17 05:40:01'),
(6, 'Goa', '2025-02-17 05:40:01'),
(7, 'Gujarat', '2025-02-17 05:40:01'),
(8, 'Haryana', '2025-02-17 05:40:01'),
(9, 'Himachal Pradesh', '2025-02-17 05:40:01'),
(10, 'Jharkhand', '2025-02-17 05:40:01'),
(11, 'Karnataka', '2025-02-17 05:40:01'),
(12, 'Kerala', '2025-02-17 05:40:01'),
(13, 'Madhya Pradesh', '2025-02-17 05:40:01'),
(14, 'Maharashtra', '2025-02-17 05:40:01'),
(15, 'Manipur', '2025-02-17 05:40:01'),
(16, 'Meghalaya', '2025-02-17 05:40:01'),
(17, 'Mizoram', '2025-02-17 05:40:01'),
(18, 'Nagaland', '2025-02-17 05:40:01'),
(19, 'Odisha', '2025-02-17 05:40:01'),
(20, 'Punjab', '2025-02-17 05:40:01'),
(21, 'Rajasthan', '2025-02-17 05:40:01'),
(22, 'Sikkim', '2025-02-17 05:40:01'),
(23, 'Tamil Nadu', '2025-02-17 05:40:01'),
(24, 'Telangana', '2025-02-17 05:40:01'),
(25, 'Tripura', '2025-02-17 05:40:01'),
(26, 'Uttar Pradesh', '2025-02-17 05:40:01'),
(27, 'Uttarakhand', '2025-02-17 05:40:01'),
(28, 'West Bengal', '2025-02-17 05:40:01'),
(29, 'Andaman and Nicobar Islands', '2025-02-17 05:40:01'),
(30, 'Chandigarh', '2025-02-17 05:40:01'),
(31, 'Dadra and Nagar Haveli and Daman and Diu', '2025-02-17 05:40:01'),
(32, 'Lakshadweep', '2025-02-17 05:40:01'),
(33, 'Delhi', '2025-02-17 05:40:01'),
(34, 'Puducherry', '2025-02-17 05:40:01');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `product_condition` enum('New','Used') NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Sold','Pending') DEFAULT 'Active',
  `year_of_registration` year(4) NOT NULL,
  `fuel_type` varchar(255) NOT NULL,
  `transmission` enum('Manual','Automatic') NOT NULL,
  `mileage` int(11) NOT NULL,
  `number_of_owners` int(2) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `car_brand` varchar(255) DEFAULT NULL,
  `car_model` varchar(100) DEFAULT NULL,
  `car_variant` varchar(100) DEFAULT NULL,
  `location_city` int(11) DEFAULT NULL,
  `location_state` int(11) DEFAULT NULL,
  `location_pin_code` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `user_id`, `created_at`, `product_name`, `price`, `description`, `product_condition`, `product_image`, `status`, `year_of_registration`, `fuel_type`, `transmission`, `mileage`, `number_of_owners`, `tags`, `car_brand`, `car_model`, `car_variant`, `location_city`, `location_state`, `location_pin_code`) VALUES
(1, '9876543210', '2025-02-12 07:09:01', 'iPhone 13jkhldshgjdshfjvlxzjkcvhjzkhgvjkghfdgjkhskgjhfsdkjghsdkfjghkfdsgfdsjiogjoisdfjglcxvbcvv', 900, 'Used iPhone 13 in good condition', 'Used', '../image.jpg', 'Active', '0000', '', 'Manual', 0, 0, NULL, 'Nissan', 'Camry', 'Corolla Base Model', 12, 7, NULL),
(2, '9876543210', '2025-02-12 07:15:00', 'iPhone 13', 600, 'Used iPhone 13 in good condition', 'Used', '../image.jpg', 'Active', '0000', '', 'Manual', 0, 0, NULL, 'Toyota', 'Camry', 'Corolla Base Model', NULL, NULL, NULL),
(10, '9876543210', '2025-02-16 11:47:11', 'Toyota Corolla 2020', 15001, 'Well-maintained car, single owner.', 'Used', 'corolla.jpg', 'Active', '2020', 'Petrol', 'Automatic', 13, 1, 'Toyota, Sedan, Petrol, Automatic', 'Toyota', 'Corolla', 'Altis', NULL, NULL, NULL),
(11, '9876543210', '2025-02-17 09:15:26', '32fgdfgsfd', 32432, 'fgsdfgf', 'New', '../imge.jpeg', 'Active', '2025', 'Petrol', 'Automatic', 234, 1, 'gfdsg', 'Toyota', '2', '4', 20, 9, 342332),
(14, '9876543210', '2025-02-17 09:39:37', 'fdgsfdrg', 45645, 'sfdgdfgfd', 'New', '..dfsds.eg', 'Active', '2025', 'Petrol', 'Manual', 456, 1, 'rfhgf', 'Toyota', '5', '2', 2, 3, 456456),
(18, '9876543210', '2025-02-17 09:48:08', 'dfsgsdfg', 234234, 'fsgfsdgsfdg', 'New', '.img.g', 'Active', '2025', 'Petrol', 'Manual', 234, 1, 'fdgfdsg', '3', '5', '9', 21, 33, 423423),
(19, '9876543210', '2025-02-17 09:48:25', 'dfsgsdfg', 234234, 'fsgfsdgsfdg', 'New', '.img.g', 'Active', '2025', 'Petrol', 'Manual', 234, 1, 'fdgfdsg', '3', '5', '9', 21, 33, 423423),
(20, '9876543210', '2025-02-17 09:51:36', 'dfsgsdfg', 234234, 'fsgfsdgsfdg', 'New', '.img.g', 'Active', '2025', 'Petrol', 'Manual', 234, 1, 'fdgfdsg', '3', '5', '9', 21, 33, 423423),
(21, '9876543210', '2025-02-17 09:51:50', 'dfsgsdfg', 234234, 'fsgfsdgsfdg', 'New', '.img.g', 'Active', '2025', 'Petrol', 'Manual', 234, 1, 'fdgfdsg', '3', '5', '9', 21, 33, 423423),
(22, '9876543210', '2025-02-17 09:52:14', 'dfsgsdfg', 234234, 'fsgfsdgsfdg', 'New', '.img.g', 'Active', '2025', 'Petrol', 'Manual', 234, 1, 'fdgfdsg', '3', '5', '9', 21, 33, 423423),
(23, '9876543210', '2025-02-17 09:52:25', 'dfsgsdfg', 234234, 'fsgfsdgsfdg', 'New', '.img.g', 'Active', '2025', 'Petrol', 'Manual', 234, 1, 'fdgfdsg', '3', '5', '9', 21, 33, 423423),
(24, '9876543210', '2025-02-17 09:53:54', 'dfsgsdfg', 234234, 'fsgfsdgsfdg', 'New', '', 'Active', '2025', 'Petrol', 'Manual', 234, 1, 'fdgfdsg', '3', '5', '9', 21, 33, 423423),
(25, '9876543210', '2025-02-17 09:55:18', 'dfsgsdfg', 234234, 'fsgfsdgsfdg', 'New', '', 'Active', '2025', 'Petrol', 'Manual', 234, 1, 'fdgfdsg', '3', '5', '9', 21, 33, 423423),
(26, '9876543210', '2025-02-17 09:56:18', 'ghgfjgh', 5664576, 'hgjfghhgfjj', 'Used', '', 'Active', '2025', 'Petrol', 'Manual', 456, 1, 'hgghj', '3', '5', '9', 21, 33, 545634),
(27, '9876543210', '2025-02-17 09:57:59', 'ghgfjgh', 5664576, 'hgjfghhgfjj', 'Used', '', 'Active', '2025', 'Petrol', 'Manual', 456, 1, 'hgghj', '3', '5', '9', 21, 33, 545634),
(28, '9876543210', '2025-02-17 10:02:28', 'ghgfjgh', 5664576, 'hgjfghhgfjj', 'Used', '', 'Active', '2025', 'Petrol', 'Manual', 456, 1, 'hgghj', '3', '5', '9', 21, 33, 545634),
(29, '9876543210', '2025-02-17 10:06:16', 'ghgfjgh', 5664576, 'hgjfghhgfjj', 'Used', '', 'Active', '2025', 'Petrol', 'Manual', 456, 1, 'hgghj', '3', '5', '9', 21, 33, 545634),
(30, '9876543210', '2025-02-17 10:13:02', 'Car check uploading', 750000, 'WhatsApp Image 2025-02-10 at 2.48.55 PM.jpeg - File size must be between 100KB and 500KB.\r\nwhite-coupe-sport-car-standing-road-front-view-min.jpg - File size must be between 100KB and 500KB.\r\nwhite-coupe-sport-car-standing-road-front-view.jpg - File size must be between 100KB and 500KB.\r\nimages (7).jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-23 at 11.14.06 AM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-18 at 10.44.11 AM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 2.16.34 PM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 16.09.47.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 15.12.07.jpeg - File size must be between 100KB and 500KB.\r\nimages (6).jpeg - File size must be between 100KB and 500KB.\r\nimages (5).jpeg - File size must be between 100KB and 500KB.\r\ndownload (4).jpeg - File size must be between 100KB and 500KB.', '', '', 'Active', '2017', 'CNG', 'Manual', 24, 1, 'Testing12', '3', '5', '9', 5, 30, 210056),
(31, '9876543210', '2025-02-17 10:16:16', 'asdfghjsdfcvgbnm,fghjk', 88888888, 'qwertyuioasdfghjklzxcvbnm,', 'New', '', 'Active', '2003', 'Electric', 'Automatic', 78, 5, 'Testing', '3', '5', '9', 13, 2, 110041),
(32, '9876543210', '2025-02-17 10:22:25', 'ghgfjgh', 5664576, 'hgjfghhgfjj', 'Used', '', 'Active', '2025', 'Petrol', 'Manual', 456, 1, 'hgghj', '3', '5', '9', 21, 33, 545634),
(33, '9876543210', '2025-02-17 10:28:05', 'fdsfdsf', 333333333, 'WhatsApp Image 2025-02-10 at 2.48.55 PM.jpeg - File size must be between 100KB and 500KB.\r\nwhite-coupe-sport-car-standing-road-front-view-min.jpg - File size must be between 100KB and 500KB.\r\nwhite-coupe-sport-car-standing-road-front-view.jpg - File size must be between 100KB and 500KB.\r\nimages (7).jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-23 at 11.14.06 AM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-18 at 10.44.11 AM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 2.16.34 PM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 16.09.47.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 15.12.07.jpeg - File size must be between 100KB and 500KB.\r\nimages (6).jpeg - File size must be between 100KB and 500KB.\r\nimages (5).jpeg - File size must be between 100KB and 500KB.\r\ndownload (4).jpeg - File size must be between 100KB and 500KB.', 'New', '', 'Active', '1987', 'CNG', 'Manual', 12, 3, 'Testing1', '3', '5', '10', 21, 33, 784510),
(34, '9876543210', '2025-02-17 10:31:32', 'fdsfdsf', 333333333, 'WhatsApp Image 2025-02-10 at 2.48.55 PM.jpeg - File size must be between 100KB and 500KB.\r\nwhite-coupe-sport-car-standing-road-front-view-min.jpg - File size must be between 100KB and 500KB.\r\nwhite-coupe-sport-car-standing-road-front-view.jpg - File size must be between 100KB and 500KB.\r\nimages (7).jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-23 at 11.14.06 AM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-18 at 10.44.11 AM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 2.16.34 PM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 16.09.47.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 15.12.07.jpeg - File size must be between 100KB and 500KB.\r\nimages (6).jpeg - File size must be between 100KB and 500KB.\r\nimages (5).jpeg - File size must be between 100KB and 500KB.\r\ndownload (4).jpeg - File size must be between 100KB and 500KB.', 'New', '', 'Active', '1987', 'CNG', 'Manual', 12, 3, 'Testing1', '3', '5', '10', 21, 33, 784510),
(35, '9876543210', '2025-02-17 10:31:41', 'fdsfdsf', 333333333, 'WhatsApp Image 2025-02-10 at 2.48.55 PM.jpeg - File size must be between 100KB and 500KB.\r\nwhite-coupe-sport-car-standing-road-front-view-min.jpg - File size must be between 100KB and 500KB.\r\nwhite-coupe-sport-car-standing-road-front-view.jpg - File size must be between 100KB and 500KB.\r\nimages (7).jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-23 at 11.14.06 AM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-18 at 10.44.11 AM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 2.16.34 PM.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 16.09.47.jpeg - File size must be between 100KB and 500KB.\r\nWhatsApp Image 2025-01-14 at 15.12.07.jpeg - File size must be between 100KB and 500KB.\r\nimages (6).jpeg - File size must be between 100KB and 500KB.\r\nimages (5).jpeg - File size must be between 100KB and 500KB.\r\ndownload (4).jpeg - File size must be between 100KB and 500KB.', 'New', '', 'Active', '1987', 'CNG', 'Manual', 12, 3, 'Testing1', '3', '5', '10', 21, 33, 784510);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `followers` int(11) DEFAULT 0,
  `following` int(11) DEFAULT 0,
  `about_me` text DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `preferred_language` varchar(50) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `created_at`, `followers`, `following`, `about_me`, `phone_number`, `email`, `preferred_language`, `city`, `state`, `pincode`) VALUES
(1, 'John Doe', '2025-02-11 11:01:52', 150, 100, 'Love to explore new places.', '1234567890', 'john@example.com', 'English', 'delhi', NULL, NULL),
(2, 'Alice Smith', '2025-02-11 11:01:52', 200, 180, 'Tech enthusiast and blogger.', '9876543210', 'alice@example.com', 'हिंदी', 'Gopalganj', NULL, NULL),
(3, 'Bob Johnson', '2025-02-11 11:01:52', 90, 120, 'Car lover and trader.', '1122334455', 'bob@example.com', 'English', 'pune', NULL, NULL),
(4, 'Emma Brown', '2025-02-11 11:01:52', 300, 250, 'Fitness freak and traveler.', '6677889900', 'emma@example.com', 'हिंदी', 'Mumbai', NULL, NULL),
(5, 'David Wilson', '2025-02-11 11:01:52', 50, 60, 'Aspiring musician.', '9988776655', 'david@example.com', 'English', 'delhi', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car_brands`
--
ALTER TABLE `car_brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brand_name` (`brand_name`);

--
-- Indexes for table `car_category_info`
--
ALTER TABLE `car_category_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_models`
--
ALTER TABLE `car_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brand_id` (`brand_id`,`model_name`);

--
-- Indexes for table `car_variants`
--
ALTER TABLE `car_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model_id` (`model_id`,`variant_name`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_city_name` (`city_name`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`language_id`),
  ADD UNIQUE KEY `language_name` (`language_name`);

--
-- Indexes for table `location_city`
--
ALTER TABLE `location_city`
  ADD PRIMARY KEY (`city_id`),
  ADD UNIQUE KEY `unique_city_per_state` (`city_name`,`state_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `location_state`
--
ALTER TABLE `location_state`
  ADD PRIMARY KEY (`state_id`),
  ADD UNIQUE KEY `state_name` (`state_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_brand_name` (`car_brand`),
  ADD KEY `fk_location_city` (`location_city`),
  ADD KEY `fk_location_state` (`location_state`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD KEY `fk_preferred_language` (`preferred_language`),
  ADD KEY `fk_city` (`city`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car_brands`
--
ALTER TABLE `car_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `car_category_info`
--
ALTER TABLE `car_category_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `car_models`
--
ALTER TABLE `car_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `car_variants`
--
ALTER TABLE `car_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `location_city`
--
ALTER TABLE `location_city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `location_state`
--
ALTER TABLE `location_state`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `car_models`
--
ALTER TABLE `car_models`
  ADD CONSTRAINT `car_models_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `car_brands` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `car_variants`
--
ALTER TABLE `car_variants`
  ADD CONSTRAINT `car_variants_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `car_brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `car_variants_ibfk_2` FOREIGN KEY (`model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `location_city`
--
ALTER TABLE `location_city`
  ADD CONSTRAINT `location_city_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `location_state` (`state_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_location_city` FOREIGN KEY (`location_city`) REFERENCES `location_city` (`city_id`),
  ADD CONSTRAINT `fk_location_state` FOREIGN KEY (`location_state`) REFERENCES `location_state` (`state_id`),
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`phone_number`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_city` FOREIGN KEY (`city`) REFERENCES `city` (`city_name`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_preferred_language` FOREIGN KEY (`preferred_language`) REFERENCES `languages` (`language_name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`phone_number`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
