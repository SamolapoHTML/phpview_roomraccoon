-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2024 at 01:02 PM
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
-- Database: `roomradash`
--

-- --------------------------------------------------------

--
-- Table structure for table `roomradash`
--

CREATE TABLE `roomradash` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `room_revenue` varchar(150) NOT NULL,
  `add_ons` varchar(150) NOT NULL,
  `adr` varchar(150) NOT NULL,
  `rev_par` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roomradash`
--

INSERT INTO `roomradash` (`id`, `date`, `room_revenue`, `add_ons`, `adr`, `rev_par`) VALUES
(1, '2024-08-25', '10580', '430', '165', '145'),
(2, '2024-08-20', '10580', '430', '165', '145'),
(3, '2024-07-05', '580', '630', '165', '145'),
(4, '2024-07-10', '10580', '630', '165', '145'),
(5, '2024-07-15', '10580', '630', '165', '145'),
(6, '2024-06-11', '10580', '630', '165', '145'),
(7, '2024-06-20', '10580', '630', '165', '145'),
(8, '2024-06-17', '10580', '630', '165', '145'),
(9, '2024-06-21', '10580', '630', '165', '145'),
(10, '2024-06-22', '10580', '630', '165', '145'),
(11, '2024-06-25', '10580', '630', '165', '145'),
(12, '2024-08-22', '15050', '490', '950', '600'),
(13, '2024-05-08', '15050', '490', '950', '600'),
(14, '2024-05-10', '10850', '490', '950', '600'),
(15, '2024-05-13', '10650', '490', '950', '600'),
(16, '2024-04-02', '106500', '490', '950', '600'),
(17, '2024-04-10', '101500', '490', '950', '600'),
(18, '2024-04-17', '10500', '490', '950', '600'),
(19, '2024-08-22', '15000', '500', '500', '500'),
(20, '2024-08-20', '10580', '430', '165', '145'),
(21, '2024-07-05', '580', '630', '165', '145'),
(22, '2024-08-15', '90580', '430', '165', '145'),
(23, '2024-08-20', '580', '430', '165', '145'),
(24, '2024-08-10', '10580', '630', '165', '145'),
(25, '2024-08-10', '5580', '630', '165', '145'),
(26, '2024-08-05', '580', '630', '165', '145'),
(27, '2024-07-01', '5580', '630', '165', '145'),
(28, '2024-08-01', '5580', '630', '165', '145'),
(29, '2024-07-10', '5580', '630', '165', '145'),
(30, '2024-08-15', '5580', '630', '165', '145'),
(31, '2024-07-20', '20580', '630', '165', '145'),
(32, '2024-07-25', '15580', '630', '165', '145');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roomradash`
--
ALTER TABLE `roomradash`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roomradash`
--
ALTER TABLE `roomradash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
