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
-- Database: `rapidexp_rapid`
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
(1, 'admin@rapidexpressagency.com', 'Work@1234567');

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
(7, 'VB6UPQ0WLI', 'James Hwan', '13057036896', 'jahwan284@gmail.com', '200 Garden City Plaza, Garden City, NY 11530, United States.', 'On hold', '35.063254,-16.946388', 'meettitahere@gmail.com', 'Tita Destia', '6285245399355', 'Tanjung Pura Street Number 419, Benua Melayu Darat, Pontianak Selatan,  Pontianak City, West Borneo 78122. Indonesia', '2022-11-10', '2022-11-14', 'Consignment.', 'Taipei Songshan Airport, Taiwan', '2022-11-10 12:38:19'),
(8, 'U6XJH4DOV3', 'Ha-joon Hajun', '13057036896', 'gemh_ltd@yahoo.com', '200 Garden City Plaza, Garden City, NY 11530, United States.', 'On hold', '38.112949, 1.976532', '48805023@yahoo.com.TW', 'WANG HSINHO', '886910715437', 'No. 150, Sec. 6, Minquan E. Rd., Neihu Dist., Taipei City 114, Taiwan (R.O.C.)', '2022-11-10', '2022-11-14', 'Consignment.', 'Narita International Airport, Japan', '2022-11-10 20:19:06');

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
