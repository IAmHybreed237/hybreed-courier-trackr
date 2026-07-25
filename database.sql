-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 16, 2022 at 10:30 AM
-- Server version: 10.6.8-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hybreed_courier`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin@hybreedinc.com', 'change_this_password');

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `id` int(11) NOT NULL,
  `tracking_number` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `sender_contact` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `sender_address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `dispatch_location` varchar(255) NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `receiver_contact` varchar(255) NOT NULL,
  `receiver_address` varchar(255) NOT NULL,
  `dispatch_date` varchar(255) NOT NULL,
  `delivery_date` varchar(255) NOT NULL,
  `pdesc` varchar(255) NOT NULL,
  `current_location` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tracking`
--

INSERT INTO `tracking` (`id`, `tracking_number`, `sender_name`, `sender_contact`, `sender_email`, `sender_address`, `status`, `dispatch_location`, `receiver_email`, `receiver_name`, `receiver_contact`, `receiver_address`, `dispatch_date`, `delivery_date`, `pdesc`, `current_location`, `date`) VALUES
(7, 'VB6UPQ0WLI', 'John Smith', '15551234567', 'john.smith@example.com', '123 Main Street, New York, NY 10001, United States.', 'On hold', '40.7128,-74.0060', 'jane.doe@example.com', 'Jane Doe', '15557654321', '456 Oak Avenue, Los Angeles, CA 90001, United States.', '2022-11-10', '2022-11-14', 'Electronics package.', 'Chicago O Hare Airport, USA', '2022-11-10 12:38:19'),
(8, 'U6XJH4DOV3', 'Alice Brown', '15559876543', 'alice.brown@example.com', '789 Pine Lane, Miami, FL 33101, United States.', 'In Transit', '25.7617,-80.1918', 'bob.wilson@example.com', 'Bob Wilson', '15552223344', '321 Elm Street, Seattle, WA 98101, United States.', '2022-11-10', '2022-11-14', 'Documents.', 'Dallas Fort Worth Airport, USA', '2022-11-10 20:19:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracking`
--
ALTER TABLE `tracking`
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
-- AUTO_INCREMENT for table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

-- --------------------------------------------------------

--
-- Table structure for table `shipment_history`
--

CREATE TABLE `shipment_history` (
  `id` int(11) NOT NULL,
  `tracking_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for table `shipment_history`
--
ALTER TABLE `shipment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tracking_number` (`tracking_number`);

--
-- AUTO_INCREMENT for table `shipment_history`
--
ALTER TABLE `shipment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
