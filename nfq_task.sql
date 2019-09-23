-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2019 at 10:34 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nfq_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `staff_id` int(20) DEFAULT NULL,
  `served` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `staff_id`, `served`) VALUES
(1, 'David', 3, 0),
(2, 'Daniel', 4, 0),
(3, 'Mark', 1, 1),
(4, 'Steven', 5, 0),
(6, 'Andrew', 3, 0),
(7, 'Kevin', 2, 0),
(8, 'Edward', 4, 0),
(9, 'Edward', 4, 0),
(10, 'Edward', 4, 0),
(11, 'Alan', 1, 0),
(12, 'Brandon', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `available` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `available`) VALUES
(1, 'James', 0),
(2, 'John', 0),
(3, 'Robert', 0),
(4, 'Michael', 0),
(5, 'William', 0);

-- --------------------------------------------------------

--
-- Table structure for table `visit_times`
--

CREATE TABLE `visit_times` (
  `id` int(20) NOT NULL,
  `customer_id` int(20) NOT NULL,
  `staff_id` int(20) DEFAULT NULL,
  `visit_start_time` timestamp NULL DEFAULT NULL,
  `visit_end_time` timestamp NULL DEFAULT NULL,
  `visit_duration` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `visit_times`
--

INSERT INTO `visit_times` (`id`, `customer_id`, `staff_id`, `visit_start_time`, `visit_end_time`, `visit_duration`) VALUES
(1, 1, 3, '2019-09-22 23:07:07', NULL, NULL),
(2, 2, 4, '2019-09-23 00:08:10', NULL, NULL),
(3, 3, 1, '2019-09-23 00:11:11', NULL, NULL),
(4, 4, 5, '2019-09-23 00:10:12', NULL, NULL),
(5, 6, 3, '2019-09-23 01:09:09', NULL, NULL),
(6, 7, 2, '2019-09-23 00:11:12', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visit_times`
--
ALTER TABLE `visit_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `visit_times`
--
ALTER TABLE `visit_times`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `visit_times`
--
ALTER TABLE `visit_times`
  ADD CONSTRAINT `visit_times_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_times_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
