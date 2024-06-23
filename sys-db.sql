-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2024 at 05:10 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miguel_cs`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(10) UNSIGNED NOT NULL,
  `contact_first_name` varchar(30) NOT NULL,
  `contact_last_name` varchar(30) NOT NULL,
  `contact_company_name` varchar(40) NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `contact_email` varchar(40) NOT NULL,
  `contact_is_deleted` int(11) DEFAULT 0,
  `contact_created_at` datetime NOT NULL,
  `contact_updated_at` datetime DEFAULT NULL,
  `contact_deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `contact_first_name`, `contact_last_name`, `contact_company_name`, `contact_phone`, `contact_email`, `contact_is_deleted`, `contact_created_at`, `contact_updated_at`, `contact_deleted_at`) VALUES
(1, 'miguel', 'contact1', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:56:32', NULL, NULL),
(2, 'miguel', 'contact2', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:56:42', NULL, NULL),
(3, 'miguel', 'contact3', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:56:52', NULL, NULL),
(4, 'miguel', 'contact4', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:56:59', NULL, NULL),
(5, 'miguel', 'contact5', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:57:07', NULL, NULL),
(6, 'miguel', 'contact6', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:57:23', NULL, NULL),
(7, 'miguel', 'contact7', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:57:31', NULL, NULL),
(8, 'miguel', 'contact8', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:57:44', NULL, NULL),
(9, 'franco', 'contact1', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:58:05', NULL, NULL),
(10, 'franco', 'contact2', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:58:13', NULL, NULL),
(11, 'franco', 'contact4', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:58:26', '2024-06-23 17:02:23', NULL),
(12, 'franco', 'contact3', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:58:37', NULL, NULL),
(13, 'franco', 'contact5', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:58:48', NULL, NULL),
(14, 'franco', 'contact6', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:59:08', NULL, NULL),
(15, 'franco', 'contact7', 'comp', '123', 'test@email.com', 0, '2024-06-23 14:59:16', NULL, NULL),
(16, 'tests', 'editdeleteeeesss', 'comp123asdqwe', '123sssss', 'asd@123.comaaaa', 1, '2024-06-23 14:59:35', '2024-06-23 14:59:59', '2024-06-23 15:00:25'),
(17, 'test', 'test', 'test', '123', 'test@email.com', 0, '2024-06-23 16:13:33', NULL, NULL),
(18, 'franco', 'contact8', 'comp', '123', 'test@email.com', 0, '2024-06-23 16:47:31', NULL, NULL),
(19, 'franco', 'contact9', 'comp', '123', 'test@email.com', 0, '2024-06-23 16:47:50', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
