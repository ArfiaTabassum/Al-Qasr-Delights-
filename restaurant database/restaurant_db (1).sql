-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2025 at 01:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin@1234');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `map_link` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `phone`, `map_link`, `created_at`, `lat`, `lng`) VALUES
(1, 'Al-Qasr Dining - Whitefield', 'Forum Mall, Whitefield Main Road', '+91 80 4123 4567', 'https://maps.app.goo.gl/2SPgUHj1q9c3K8yy5', '2025-04-27 10:40:01', 12.97159800, 77.75059400),
(2, 'Al-Qasr Fine Dining - Malleshwaram', 'Sampige Road, Near Mantri Square', '+91 80 2345 6789', 'https://maps.app.goo.gl/jwC68V7BH9rexewp9', '2025-04-27 10:40:28', 13.00680200, 77.56146200),
(3, 'Qasr Delights  - Jayanagar', '4th Block, Near South End Circle', '+91 80 3456 7890', 'https://maps.app.goo.gl/wzuCZQRdUcRCXMMf7', '2025-04-27 10:41:09', 12.93042800, 77.58340600),
(4, 'Qasr Fine Dining - Rajajinagar', 'Dr. Rajkumar Road, Navrang Theater', '+91 80 4567 8901', 'https://maps.app.goo.gl/CGnhHhco9Txuss6D8', '2025-04-27 10:41:39', 12.97706300, 77.55334400),
(5, 'Al-Qasr Dining - Electronic City', 'Phase 1, Near Infosys Gate', '+91 80 5678 9012', 'https://maps.app.goo.gl/QtjAEc1tC6wgb2Lh9', '2025-04-27 10:42:24', 12.84591000, 77.66026600),
(6, 'Qasr Delights Dining - Yelahanka', 'Airforce Station Road, Near Manyata Tech Park', '+91 80 6789 0123', 'https://maps.app.goo.gl/xEEZ4JLbDvMn6MtbA', '2025-04-27 10:42:54', 13.10029400, 77.59632100);

-- --------------------------------------------------------

--
-- Table structure for table `deleted_reservations`
--

CREATE TABLE `deleted_reservations` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `guests` int(11) NOT NULL,
  `time_slot` varchar(50) NOT NULL,
  `edays` varchar(50) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `dates` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_number` varchar(50) DEFAULT NULL,
  `item_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_number`, `item_name`, `price`, `quantity`, `created_at`, `order_id`) VALUES
('ORD-20250713-123844-e4fe35', 'Hummus Bil Tahini', 260.00, 1, '2025-07-13 10:38:44', 1),
('ORD-20250713-123844-e4fe35', 'Falafel Platter', 280.00, 1, '2025-07-13 10:38:44', 2),
('ORD-20250713-123844-e4fe35', 'Um Ali', 220.00, 1, '2025-07-13 10:38:44', 3),
('ORD-20250713-123844-e4fe35', 'Mandi Lamb', 560.00, 1, '2025-07-13 10:38:44', 4),
('ORD-20250713-123844-e4fe35', 'Baklava', 200.00, 1, '2025-07-13 10:38:44', 5),
('ORD-20250713-124026-8ddeb9', 'Mandi Lamb', 560.00, 1, '2025-07-13 10:40:26', 6),
('ORD-20250713-124026-8ddeb9', 'Basbousa', 180.00, 1, '2025-07-13 10:40:26', 7),
('ORD-20250713-124026-8ddeb9', 'Mint Tea', 100.00, 1, '2025-07-13 10:40:26', 8),
('ORD-20250713-124555-9d2e87', 'Hummus Bil Tahini', 260.00, 1, '2025-07-13 10:45:55', 9),
('ORD-20250713-124555-9d2e87', 'Baklava', 200.00, 1, '2025-07-13 10:45:55', 10),
('ORD-20250713-124555-9d2e87', 'Mandi Lamb', 1120.00, 2, '2025-07-13 10:45:55', 11),
('ORD-20250713-124555-9d2e87', 'Arabic Qahwa', 140.00, 1, '2025-07-13 10:45:55', 12),
('ORD-20250713-130212-c27049', 'Um Ali', 220.00, 1, '2025-07-13 11:02:12', 13),
('ORD-20250713-130816-a8ef77', 'Kabsa Chicken', 520.00, 1, '2025-07-13 11:08:16', 14),
('ORD-20250713-130816-a8ef77', 'Baklava', 200.00, 1, '2025-07-13 11:08:16', 15),
('ORD-20250713-131300-658da0', 'Mandi Lamb', 560.00, 1, '2025-07-13 11:13:00', 16),
('ORD-20250713-131312-064894', 'Mandi Lamb', 560.00, 1, '2025-07-13 11:13:12', 17),
('ORD-20250713-131439-7cc03d', 'Mandi Lamb', 560.00, 1, '2025-07-13 11:14:39', 18),
('ORD-20250713-133325-274945', 'Mandi Lamb', 560.00, 1, '2025-07-13 11:33:25', 19);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `guests` int(11) DEFAULT NULL,
  `time_slot` varchar(50) DEFAULT NULL,
  `edays` varchar(50) DEFAULT NULL,
  `dates` date DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `full_name`, `phone`, `email`, `guests`, `time_slot`, `edays`, `dates`, `branch`, `status`, `created_at`, `order_number`) VALUES
(1, 'Hani Ahmed', '8904123294', 'ummehani99800@gmail.com', 6, '7:00 PM', 'Wednesday', '2025-07-16', 'Al-Qasr Fine Dining - Malleshwaram', 'confirmed', '2025-07-13 10:39:32', 'ORD-20250713-123844-e4fe35'),
(2, 'Zaiba Ahmed', '8867907827', 'ummezaiba79@gmail.com', 8, '3:00 PM', 'Monday', '2025-07-14', 'Al-Qasr Fine Dining - Malleshwaram', 'cancelled', '2025-07-13 10:41:36', 'ORD-20250713-124026-8ddeb9');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `rating`, `comment`, `created_at`) VALUES
(1, 'Umme Hani', 4, 'good ambience', '2025-07-13 11:39:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_reservations`
--
ALTER TABLE `deleted_reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reservation_order_number` (`order_number`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `deleted_reservations`
--
ALTER TABLE `deleted_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
