-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 11:57 AM
-- Server version: 10.4.14-MariaDB
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_status` int(10) NOT NULL,
  `category_added_by` int(10) UNSIGNED DEFAULT NULL,
  `category_created_at` datetime DEFAULT NULL,
  `category_updated_at` datetime DEFAULT NULL,
  `category_deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_status`, `category_added_by`, `category_created_at`, `category_updated_at`, `category_deleted_at`) VALUES
(32, 'Electronics', 0, 1, '2024-07-08 13:04:56', NULL, NULL),
(33, 'Apparel', 0, 2, '2024-07-08 13:04:56', NULL, NULL),
(34, 'Home & Kitchen', 0, 3, '2024-07-08 13:04:56', NULL, NULL),
(35, 'Books', 0, 4, '2024-07-08 13:04:56', NULL, NULL),
(36, 'Toys & Games', 0, 1, '2024-07-08 13:04:56', NULL, NULL),
(37, 'Sports & Outdoors', 0, 2, '2024-07-08 13:04:56', NULL, NULL),
(38, 'Health & Beauty', 0, 3, '2024-07-08 13:04:56', NULL, NULL),
(39, 'Automotive', 0, 4, '2024-07-08 13:04:56', NULL, NULL),
(40, 'Grocery & Gourmet Food', 0, 1, '2024-07-08 13:04:56', NULL, NULL),
(41, 'Pet Supplies', 0, 2, '2024-07-08 13:04:56', NULL, NULL),
(42, 'Office Products', 0, 3, '2024-07-08 13:04:56', NULL, NULL),
(43, 'Baby', 0, 4, '2024-07-08 13:04:56', NULL, NULL),
(44, 'Garden & Outdoor', 0, 1, '2024-07-08 13:04:56', NULL, NULL),
(45, 'Musical Instruments', 0, 2, '2024-07-08 13:04:56', NULL, NULL),
(46, 'Industrial & Scientific', 0, 3, '2024-07-08 13:04:56', NULL, NULL),
(47, 'Software', 0, 4, '2024-07-08 13:04:56', NULL, NULL),
(48, 'Jewelry', 0, 1, '2024-07-08 13:04:56', NULL, NULL),
(49, 'Shoes & Handbags', 0, 2, '2024-07-08 13:04:56', NULL, NULL),
(50, 'Video Games', 0, 3, '2024-07-08 13:04:56', NULL, NULL),
(51, 'Movies & TV', 0, 4, '2024-07-08 13:04:56', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `contact_first_name` varchar(30) NOT NULL,
  `contact_last_name` varchar(30) NOT NULL,
  `contact_company_name` varchar(40) NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `contact_email` varchar(40) NOT NULL,
  `contact_is_deleted` int(11) DEFAULT 0,
  `contact_created_at` datetime NOT NULL,
  `contact_updated_at` datetime DEFAULT NULL,
  `contact_deleted_at` datetime DEFAULT NULL,
  `contact_shared_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `user_id`, `contact_first_name`, `contact_last_name`, `contact_company_name`, `contact_phone`, `contact_email`, `contact_is_deleted`, `contact_created_at`, `contact_updated_at`, `contact_deleted_at`, `contact_shared_at`) VALUES
(2, 1, 'miguel', 'contact1', 'comp', '123', 'test@email.com', 1, '2024-06-24 04:20:57', NULL, NULL, NULL),
(3, 1, 'testshare', 'to-franco', 'comp', '123', 'test@email.com', 1, '2024-06-24 04:21:34', NULL, '2024-06-24 04:23:18', NULL),
(4, 1, 'shared-to', 'franco-test', 'comp', '123', 'test@email.com', 1, '2024-06-24 04:26:27', NULL, '2024-06-24 04:48:42', NULL),
(5, 1, 'shared-to', 'to-franco-test', 'comp', '123', 'test@email.com', 1, '2024-06-24 04:49:02', NULL, '2024-06-24 05:02:00', NULL),
(6, 1, 'shared', 'to-franco', 'comp', '123', 'test@email.com', 1, '2024-06-24 05:02:19', NULL, '2024-06-24 05:13:22', NULL),
(7, 2, 'shared', 'to-franco', 'comp', '123', 'test@email.com', 1, '2024-06-24 05:03:18', NULL, NULL, '2024-06-24 05:03:18'),
(8, 1, 'test-share-fr', 'test', 'comp', '123', 'test@email.com', 1, '2024-06-24 05:13:50', NULL, NULL, NULL),
(9, 2, 'test-share-fr', 'test', 'comp', '123', 'test@email.com', 1, '2024-06-24 05:15:34', NULL, NULL, '2024-06-24 05:15:34'),
(10, 1, 'migs-shared-to-franco', 'test', '123', 'test', 'test@email.com', 1, '2024-06-24 05:40:57', NULL, NULL, NULL),
(11, 2, 'migs-shared-to-franco', 'test', '123', 'test', 'test@email.com', 1, '2024-06-24 05:41:02', NULL, NULL, '2024-06-24 05:41:02'),
(12, 1, 'gihimogasdasd', 'modal', 'comp asdasd', '123', 'test@email.com', 1, '2024-06-24 05:47:11', '2024-06-25 08:29:50', '2024-06-25 08:35:34', NULL),
(13, 2, 'migs-share', 'to-franco', 'comp', '123', 'test@email.com', 0, '2024-06-24 05:47:41', '2024-06-24 05:55:27', NULL, '2024-06-24 05:47:41'),
(14, 2, 'franco', 'to-migs', 'comp', '123', 'test@email.com', 0, '2024-06-24 05:49:18', NULL, NULL, NULL),
(15, 1, 'franco-giedit-ni-migs', 'to-migs', 'comp', '123', 'test@email.com', 1, '2024-06-24 05:49:23', '2024-06-24 05:49:41', '2024-06-24 05:49:57', '2024-06-24 05:49:23'),
(16, 1, 'Drow', 'Ranger', 'Secret Shop', '09255028395', 'drow@email.com', 0, '2024-06-24 05:50:59', '2024-06-26 04:53:11', NULL, NULL),
(17, 1, 'Juggernaut', 'Yurnero', 'Bladekeeper Inc.', '09123456789', 'yurnero@email.com', 0, '2024-06-24 05:51:07', '2024-06-25 09:41:07', NULL, NULL),
(18, 1, 'Lina', 'Inverse', 'FireSoul LLC', '09234567890', 'lina.inverse@email.com', 0, '2024-06-24 05:51:22', '2024-06-28 07:45:41', NULL, NULL),
(19, 1, 'Rylai', 'Crestfall', 'FrostAegis Technologies', '09345678901', 'rylai.crestfall@email.com', 0, '2024-06-24 05:51:34', '2024-06-25 09:42:04', NULL, NULL),
(20, 1, 'Sven', 'Rogueknight', 'GreatCleave Corp.', '09456789012', 'sven.rogueknight@email.com', 0, '2024-06-24 05:51:43', '2024-06-25 09:42:28', NULL, NULL),
(21, 2, 'miguel', 'contact5', 'comp', '123', 'test@email.com', 0, '2024-06-24 05:58:22', NULL, NULL, '2024-06-24 05:58:22'),
(22, 1, 'miguel', 'contact5', 'comp', '123', 'test@email.com', 1, '2024-06-24 05:58:42', NULL, '2024-06-24 05:59:26', '2024-06-24 05:58:42'),
(23, 3, 'migs-share', 'to-franco', 'comp', '123', 'test@email.com', 1, '2024-06-24 07:24:08', NULL, '2024-06-24 07:24:34', '2024-06-24 07:24:08'),
(24, 3, 'migs-sharesssa', 'to-franco', 'comp', '123', 'test@email.com', 1, '2024-06-24 07:48:16', NULL, '2024-07-02 11:55:55', '2024-06-24 07:48:16'),
(25, 1, 'migz', 'testcontact', 'proweaver', '123', 'test@contact.com', 1, '2024-06-24 09:35:40', NULL, '2024-06-25 04:08:11', NULL),
(26, 2, 'migz-edit', 'testcontact', 'proweaver', '123', 'test@contact.com', 0, '2024-06-24 09:50:43', '2024-06-24 09:50:55', NULL, '2024-06-24 09:50:43'),
(27, 1, 'Mirana', 'Nightshade', 'SilverMoon Enterprises', '09567890123', 'mirana.nightshade@email.com', 0, '2024-06-24 10:33:19', '2024-06-25 10:09:39', NULL, NULL),
(28, 1, 'Kael', 'Invoker', 'Arcane Arts Ltd.', '09678901234', 'kael.invoker@email.com', 0, '2024-06-24 10:33:28', '2024-06-25 09:43:13', NULL, NULL),
(29, 1, 'Pudge', 'Butcher', 'FreshMeat LLC', '09789012345', 'pudge.butcher@email.com', 0, '2024-06-24 10:33:36', '2024-06-25 09:43:33', NULL, NULL),
(30, 1, 'Carl', 'Magus', 'Arcane Supremacy Ltd.', '09901234567', 'carl.magus@email.com', 0, '2024-06-24 10:33:45', '2024-06-26 04:07:43', NULL, NULL),
(31, 1, 'test-modalz', 'shareds', 'probonozzz', '09069760403', 'test123@email.comszczxc', 1, '2024-06-24 11:40:54', '2024-06-24 11:42:00', '2024-06-24 11:43:32', NULL),
(32, 2, 'edit-by-franco', 'shareds', 'probonozzz', '09069760403', 'test123@email.comszczxc', 0, '2024-06-24 11:42:14', '2024-06-24 11:43:01', NULL, '2024-06-24 11:42:14'),
(33, 1, 'Davion', 'Dragonknight', 'ElderDragon Inc.', '09123456780', 'davion.dragonknight@email.com', 0, '2024-06-25 05:17:42', '2024-06-25 09:44:20', NULL, NULL),
(34, 1, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 0, '2024-06-25 05:30:22', '2024-06-25 09:32:24', NULL, NULL),
(35, 2, 'archer', 'archer', 'comp', '123', 'aercher@email.com', 0, '2024-06-25 05:30:53', NULL, NULL, '2024-06-25 05:30:53'),
(36, 3, 'archers', 'archer', 'comp', '123', 'aercher@email.com', 0, '2024-06-25 05:52:52', NULL, NULL, '2024-06-25 05:52:52'),
(37, 4, 'edit ni mark!', 'edit-lastname', 'edit company', 'editphone', 'editemail@email.com', 1, '2024-06-25 07:57:33', '2024-06-25 07:58:14', '2024-06-25 07:58:28', '2024-06-25 07:57:33'),
(38, 1, 'Huskar', 'Daeda', 'RoshPit', '09065485625', 'hasker@email.com', 0, '2024-06-25 08:41:24', NULL, NULL, NULL),
(39, 1, 'Jerold', 'Lord', 'Facebook', '09063254879', 'jerry@email.com', 0, '2024-06-25 08:42:22', NULL, NULL, NULL),
(40, 1, 'Sisigs', 'Silog', 'Silogan ni Gian', '09063254866', 'alanmikko@email.com', 0, '2024-06-25 08:44:30', '2024-06-26 10:03:52', NULL, NULL),
(41, 4, 'Drow', 'Ranger', 'Secret Shop', '09255028395', 'drow@email.com', 0, '2024-06-25 08:48:26', NULL, NULL, '2024-06-25 08:48:26'),
(42, 2, 'Kael', 'Invoker', 'Arcane Arts Ltd.', '09678901234', 'kael.invoker@email.com', 0, '2024-06-25 09:47:53', NULL, NULL, '2024-06-25 09:47:53'),
(43, 2, 'Kael', 'Invoker', 'Arcane Arts Ltd.', '09678901234', 'kael.invoker@email.com', 1, '2024-06-25 09:55:41', NULL, '2024-06-25 09:56:49', '2024-06-25 09:55:41'),
(44, 2, 'Pudge', 'Butcher', 'FreshMeat LLC', '09789012345', 'pudge.butcher@email.com', 0, '2024-06-25 09:57:00', NULL, NULL, '2024-06-25 09:57:00'),
(45, 1, 'aaaatest', '123', '123', '123', '123@123.com', 1, '2024-06-25 09:58:41', NULL, '2024-06-25 10:00:14', NULL),
(46, 1, 'as', 'asd', 'asd', 'asd', 'asd@asd.com', 1, '2024-06-25 09:59:59', NULL, '2024-06-25 10:00:18', NULL),
(49, 2, 'Alan Edit Franc', 'Mikko', 'Silogan ni Gian', '09063254866', 'alanmikko@email.com', 0, '2024-06-25 10:28:10', '2024-06-25 10:30:18', NULL, '2024-06-25 10:28:10'),
(54, 1, '1s', '1s', '1s', '1s', '1@1.coms', 1, '2024-06-25 10:56:10', '2024-06-25 10:56:21', '2024-06-25 10:56:25', NULL),
(55, 1, 'Burger Steak', 'Silog', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-06-26 04:08:38', '2024-07-01 07:59:15', NULL, NULL),
(56, 4, 'Burger', 'Steak', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 1, '2024-06-26 04:15:19', NULL, '2024-06-26 04:18:12', '2024-06-26 04:15:19'),
(57, 4, 'Burger Steak ', 'Silog', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-06-26 04:18:17', NULL, NULL, '2024-06-26 04:18:17'),
(58, 1, 'Edit ni Migs', 'asd', 'Pro nga Weaver', 'asdad', 'asd@asd.com', 1, '2024-06-26 04:33:07', '2024-06-26 04:56:06', '2024-06-26 07:20:35', NULL),
(59, 1, 'asd', 'asd', 'asd', 'asd', 'asd@123.com', 1, '2024-06-26 07:21:18', NULL, '2024-06-26 07:21:32', NULL),
(60, 1, 'asd', 'asd', 'a', 'ass', 'asd@asd.com', 1, '2024-06-26 07:21:48', NULL, '2024-06-26 07:21:52', NULL),
(61, 1, 'a', 'a', '123', '123', 'asd@asd.com', 1, '2024-06-26 07:22:09', NULL, '2024-06-26 07:22:13', NULL),
(62, 1, 'asd', 'asd', '123', '123', 'asdasd@s.com', 1, '2024-06-26 07:24:23', NULL, '2024-06-26 07:24:27', NULL),
(63, 4, 'Lina', 'Inverse', 'FireSoul LLC', '09234567890', 'lina.inverse@email.com', 0, '2024-06-26 07:25:17', NULL, NULL, '2024-06-26 07:25:17'),
(64, 4, 'Kael', 'Invoker', 'Arcane Arts Ltd.', '09678901234', 'kael.invoker@email.com', 0, '2024-06-26 08:13:17', NULL, NULL, '2024-06-26 08:13:17'),
(65, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 1, '2024-06-26 10:21:55', NULL, '2024-06-26 10:22:31', '2024-06-26 10:21:55'),
(66, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 1, '2024-06-26 10:22:20', NULL, '2024-06-26 10:40:28', '2024-06-26 10:22:20'),
(67, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 1, '2024-06-26 10:33:46', NULL, '2024-06-26 10:57:33', '2024-06-26 10:33:46'),
(68, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 1, '2024-06-26 10:57:23', NULL, '2024-06-26 10:57:36', '2024-06-26 10:57:23'),
(69, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 1, '2024-06-26 10:57:28', NULL, '2024-06-26 10:58:21', '2024-06-26 10:57:28'),
(70, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 1, '2024-06-26 10:58:27', NULL, '2024-06-26 11:14:37', '2024-06-26 10:58:27'),
(71, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 1, '2024-06-26 11:13:46', NULL, '2024-06-26 11:14:40', '2024-06-26 11:13:46'),
(72, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 0, '2024-06-26 11:14:25', NULL, NULL, '2024-06-26 11:14:25'),
(73, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 0, '2024-06-26 11:14:47', NULL, NULL, '2024-06-26 11:14:47'),
(74, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 0, '2024-06-26 11:15:05', NULL, NULL, '2024-06-26 11:15:05'),
(75, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 0, '2024-06-26 11:16:43', NULL, NULL, '2024-06-26 11:16:43'),
(76, 4, 'Huskar', 'Daeda', 'RoshPit', '09065485625', 'hasker@email.com', 0, '2024-06-26 11:17:45', NULL, NULL, '2024-06-26 11:17:45'),
(77, 4, 'Burgezxcr Steakzcx', 'Silogzxc', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-06-26 11:21:02', '2024-07-05 11:22:18', NULL, '2024-06-26 11:21:02'),
(78, 4, 'Burger Steak', 'Silog', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-06-26 11:36:03', NULL, NULL, '2024-06-26 11:36:03'),
(79, 1, 'asd', 'asd', '123', '123', 'asd@asd.com', 1, '2024-06-26 11:39:56', NULL, '2024-06-26 11:40:01', NULL),
(80, 4, 'Burger Steak', 'Silogs', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-06-26 11:44:16', NULL, NULL, '2024-06-26 11:44:16'),
(81, 1, 'testjsonresp', 'testjsonresp', 'testjsonresp', 'testjsonresp', 'testjsonresp@email.com', 1, '2024-06-27 02:42:31', NULL, '2024-06-27 02:42:44', NULL),
(82, 1, 'zzzz', 'zzz', 'zzz', 'zzz', 'zzz@zzz.com', 1, '2024-06-27 02:44:56', NULL, '2024-06-27 02:45:17', NULL),
(83, 1, 'zzz', 'zzz', 'z', 'z', 'zzz@zzz.com', 1, '2024-06-27 02:45:25', NULL, '2024-06-27 02:45:50', NULL),
(84, 1, 'z', 'z', 'z', 'z', 'zzz@zzz.com', 1, '2024-06-27 02:45:56', NULL, '2024-06-27 02:46:14', NULL),
(85, 1, 'z', 'z', 'z', 'z', 'zzz@zzz.com', 1, '2024-06-27 02:46:17', NULL, '2024-06-27 02:46:21', NULL),
(86, 1, 'z', 'z', 'z', 'z', 'zzz@zzz.com', 1, '2024-06-27 02:46:34', NULL, '2024-06-27 02:46:39', NULL),
(87, 4, 'Christian', 'Basnillo', 'Company sa Bahrain', '09658487549', 'christian@email.com', 0, '2024-06-27 02:47:07', NULL, NULL, '2024-06-27 02:47:07'),
(88, 4, 'Lina', 'Inverse', 'FireSoul LLC', '09234567890', 'lina.inverse@email.com', 0, '2024-06-28 07:45:35', NULL, NULL, '2024-06-28 07:45:35'),
(89, 4, 'Burger Steak', 'Silog', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-06-28 08:25:32', NULL, NULL, '2024-06-28 08:25:32'),
(90, 4, 'Burger Steak', 'Silog', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-06-28 09:49:58', NULL, NULL, '2024-06-28 09:49:58'),
(91, 4, 'Burger Steak', 'Silog', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-06-28 09:50:29', NULL, NULL, '2024-06-28 09:50:29'),
(92, 19, 'Burger Steak', 'Silog', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-07-01 09:48:32', NULL, NULL, '2024-07-01 09:48:32'),
(93, 19, 'Burger Steak', 'Silog', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-07-01 09:48:40', NULL, NULL, '2024-07-01 09:48:40'),
(94, 18, 'Burger Steak', 'Silog', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-07-01 09:57:16', NULL, NULL, '2024-07-01 09:57:16'),
(95, 18, 'Burger Steak', 'Silog', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-07-01 09:57:31', NULL, NULL, '2024-07-01 09:57:31'),
(96, 4, 'Burger Steak', 'Silog', 'Silogan ni Gian', '09987542154', 'bsteak@silog.com', 0, '2024-07-02 11:01:00', NULL, NULL, '2024-07-02 11:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_tracking`
--

CREATE TABLE `inventory_tracking` (
  `inv_trk_id` int(10) UNSIGNED NOT NULL,
  `inv_trk_batch_num` varchar(255) NOT NULL,
  `inv_trk_location_id` int(10) UNSIGNED NOT NULL,
  `inv_trk_total_cost` varchar(255) DEFAULT NULL,
  `inv_trk_notes` varchar(250) NOT NULL,
  `inv_trk_supplier_id` int(10) UNSIGNED NOT NULL,
  `inv_trk_date_delivered` datetime NOT NULL,
  `inv_trk_status` int(10) UNSIGNED NOT NULL,
  `inv_trk_added_by` int(10) UNSIGNED NOT NULL,
  `inv_trk_added_at` datetime NOT NULL,
  `inv_trk_updated_at` datetime DEFAULT NULL,
  `inv_trk_attachment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory_tracking`
--

INSERT INTO `inventory_tracking` (`inv_trk_id`, `inv_trk_batch_num`, `inv_trk_location_id`, `inv_trk_total_cost`, `inv_trk_notes`, `inv_trk_supplier_id`, `inv_trk_date_delivered`, `inv_trk_status`, `inv_trk_added_by`, `inv_trk_added_at`, `inv_trk_updated_at`, `inv_trk_attachment`) VALUES
(4, 'B00000001', 4, NULL, 'asd', 35, '2024-07-09 12:00:00', 0, 1, '2024-07-08 11:52:15', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_category_id` int(10) UNSIGNED NOT NULL,
  `item_location_id` int(10) UNSIGNED NOT NULL,
  `item_status` int(11) DEFAULT NULL,
  `item_added_by` int(10) UNSIGNED DEFAULT NULL,
  `item_added_at` datetime DEFAULT NULL,
  `item_updated_at` datetime DEFAULT NULL,
  `item_deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `item_category_id`, `item_location_id`, `item_status`, `item_added_by`, `item_added_at`, `item_updated_at`, `item_deleted_at`) VALUES
(26, 'Smartphone', 32, 1, 0, 1, '2024-07-08 13:10:17', NULL, NULL),
(27, 'Laptop', 32, 2, 0, 2, '2024-07-08 13:10:17', NULL, NULL),
(28, 'T-shirt', 33, 3, 0, 3, '2024-07-08 13:10:17', NULL, NULL),
(29, 'Jeans', 33, 4, 0, 4, '2024-07-08 13:10:17', NULL, NULL),
(30, 'Blender', 34, 5, 0, 18, '2024-07-08 13:10:17', NULL, NULL),
(31, 'Coffee Maker', 34, 1, 0, 19, '2024-07-08 13:10:17', NULL, NULL),
(32, 'Novel', 35, 2, 0, 20, '2024-07-08 13:10:17', NULL, NULL),
(33, 'Textbook', 35, 3, 0, 1, '2024-07-08 13:10:17', NULL, NULL),
(34, 'Action Figure', 36, 4, 0, 2, '2024-07-08 13:10:17', NULL, NULL),
(35, 'Board Game', 36, 5, 0, 3, '2024-07-08 13:10:17', NULL, NULL),
(36, 'Tent', 37, 1, 0, 4, '2024-07-08 13:10:17', NULL, NULL),
(37, 'Bike', 37, 2, 0, 18, '2024-07-08 13:10:17', NULL, NULL),
(38, 'Shampoo', 38, 3, 0, 19, '2024-07-08 13:10:17', NULL, NULL),
(39, 'Lipstick', 38, 4, 0, 20, '2024-07-08 13:10:17', NULL, NULL),
(40, 'Car Battery', 39, 5, 0, 1, '2024-07-08 13:10:17', NULL, NULL),
(41, 'Car Oil', 39, 1, 0, 2, '2024-07-08 13:10:17', NULL, NULL),
(42, 'Pasta', 40, 2, 0, 3, '2024-07-08 13:10:17', NULL, NULL),
(43, 'Olive Oil', 40, 3, 0, 4, '2024-07-08 13:10:17', NULL, NULL),
(44, 'Dog Food', 41, 4, 0, 18, '2024-07-08 13:10:17', NULL, NULL),
(45, 'Cat Litter', 41, 5, 0, 18, '2024-07-08 13:10:17', NULL, NULL),
(46, 'Printer', 42, 1, 0, 20, '2024-07-08 13:10:17', NULL, NULL),
(47, 'Pen', 42, 2, 0, 1, '2024-07-08 13:10:17', NULL, NULL),
(48, 'Diapers', 43, 3, 0, 2, '2024-07-08 13:10:17', NULL, NULL),
(49, 'Baby Wipes', 43, 4, 0, 3, '2024-07-08 13:10:17', NULL, NULL),
(50, 'Garden Hose', 44, 5, 0, 4, '2024-07-08 13:10:17', NULL, NULL),
(51, 'Lawn Mower', 44, 1, 0, 18, '2024-07-08 13:10:17', NULL, NULL),
(52, 'Guitar', 45, 2, 0, 20, '2024-07-08 13:10:17', NULL, NULL),
(53, 'Piano', 45, 3, 0, 20, '2024-07-08 13:10:17', NULL, NULL),
(54, 'Microscope', 46, 4, 0, 1, '2024-07-08 13:10:17', NULL, NULL),
(55, 'Lab Coat', 46, 5, 0, 2, '2024-07-08 13:10:17', NULL, NULL),
(56, 'Antivirus', 47, 1, 0, 3, '2024-07-08 13:10:17', NULL, NULL),
(57, 'Office Suite', 47, 2, 0, 4, '2024-07-08 13:10:17', NULL, NULL),
(58, 'Necklace', 48, 3, 0, 18, '2024-07-08 13:10:17', NULL, NULL),
(59, 'Ring', 48, 4, 0, 18, '2024-07-08 13:10:17', NULL, NULL),
(60, 'Running Shoes', 49, 5, 0, 20, '2024-07-08 13:10:17', NULL, NULL),
(61, 'Handbag', 49, 1, 0, 1, '2024-07-08 13:10:17', NULL, NULL),
(62, 'Console', 50, 2, 0, 2, '2024-07-08 13:10:17', NULL, NULL),
(63, 'Game Controller', 50, 3, 0, 3, '2024-07-08 13:10:17', NULL, NULL),
(64, 'DVD', 51, 4, 0, 4, '2024-07-08 13:10:17', NULL, NULL),
(65, 'Blu-ray Player', 51, 5, 0, 18, '2024-07-08 13:10:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(10) UNSIGNED NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `location_address` varchar(255) NOT NULL,
  `location_status` int(10) NOT NULL,
  `location_added_by` int(10) UNSIGNED DEFAULT NULL,
  `location_added_at` datetime DEFAULT NULL,
  `location_updated_at` datetime DEFAULT NULL,
  `location_deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `location_name`, `location_address`, `location_status`, `location_added_by`, `location_added_at`, `location_updated_at`, `location_deleted_at`) VALUES
(1, 'Cebu IT Park Hub', 'Jose Maria del Mar St, Apas, Cebu City, 6000 Cebu, Philippines', 0, 1, '2024-07-03 04:41:19', '2024-07-03 07:01:09', '2024-07-05 03:53:40'),
(2, 'Ayala Center Cebu Tower Hub', 'Cebu Business Park, Archbishop Reyes Ave, Cebu City, 6000 Cebu, Philippines', 0, 1, '2024-07-03 04:41:42', '2024-07-03 08:01:01', '2024-07-05 03:53:29'),
(3, 'Keppel Office', 'Samar Loop, Cebu Business Park, Cebu City, 6000 Cebu, Philippines', 0, 1, '2024-07-03 04:41:46', '2024-07-04 05:52:22', '2024-07-05 03:53:23'),
(4, 'Cebu Business Park Hub', 'Cebu Business Park, Cebu City, 6000 Cebu, Philippines', 0, 1, '2024-07-03 04:41:50', '2024-07-03 07:01:46', '2024-07-05 03:53:34'),
(5, 'Filinvest Cyberzone Cebu Office', 'Salinas Drive, Lahug, Cebu City, 6000 Cebu, Philippines', 0, 1, '2024-07-03 04:41:52', '2024-07-03 07:01:54', '2024-07-05 03:53:45');

-- --------------------------------------------------------

--
-- Table structure for table `report_logs`
--

CREATE TABLE `report_logs` (
  `rlog_id` int(10) UNSIGNED NOT NULL,
  `rlog_item_id` int(10) UNSIGNED NOT NULL,
  `rlog_remarks` varchar(250) DEFAULT NULL,
  `rlog_attachment` text DEFAULT NULL,
  `rlog_status` enum('Pending','Reviewed','Disposed','Replaced') NOT NULL,
  `rlog_added_by` int(10) UNSIGNED DEFAULT NULL,
  `rlog_added_at` datetime DEFAULT NULL,
  `rlog_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_contact_person` varchar(255) NOT NULL,
  `supplier_contact_no` varchar(50) NOT NULL,
  `supplier_bank_name` varchar(255) NOT NULL,
  `supplier_account_name` varchar(255) NOT NULL,
  `supplier_account_no` varchar(50) NOT NULL,
  `supplier_status` int(10) NOT NULL,
  `supplier_added_by` int(10) UNSIGNED DEFAULT NULL,
  `supplier_added_at` datetime DEFAULT NULL,
  `supplier_updated_at` datetime DEFAULT NULL,
  `supplier_deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `supplier_contact_person`, `supplier_contact_no`, `supplier_bank_name`, `supplier_account_name`, `supplier_account_no`, `supplier_status`, `supplier_added_by`, `supplier_added_at`, `supplier_updated_at`, `supplier_deleted_at`) VALUES
(25, 'ABC Trading', 'Juan Dela Cruz', '09171234567', 'BDO', 'Juan Dela Cruz', '1234567890', 0, 1, '2024-07-08 13:16:55', NULL, NULL),
(26, 'XYZ Enterprises', 'Maria Clara', '09181234567', 'BPI', 'Maria Clara', '0987654321', 0, 2, '2024-07-08 13:16:55', NULL, NULL),
(27, 'DEF Supplies', 'Jose Rizal', '09192234567', 'Metrobank', 'Jose Rizal', '1122334455', 0, 3, '2024-07-08 13:16:55', NULL, NULL),
(28, 'GHI Distribution', 'Andres Bonifacio', '09202234567', 'Landbank', 'Andres Bonifacio', '5566778899', 0, 4, '2024-07-08 13:16:55', NULL, NULL),
(29, 'JKL Wholesalers', 'Emilio Aguinaldo', '09212234567', 'PNB', 'Emilio Aguinaldo', '2233445566', 0, 18, '2024-07-08 13:16:55', NULL, NULL),
(30, 'MNO Merchants', 'Gabriela Silang', '09222234567', 'Security Bank', 'Gabriela Silang', '3344556677', 0, 19, '2024-07-08 13:16:55', NULL, NULL),
(31, 'PQR Suppliers', 'Apolinario Mabini', '09232234567', 'China Bank', 'Apolinario Mabini', '4455667788', 0, 20, '2024-07-08 13:16:55', NULL, NULL),
(32, 'STU Traders', 'Antonio Luna', '09242234567', 'UnionBank', 'Antonio Luna', '5566778899', 0, 1, '2024-07-08 13:16:55', NULL, NULL),
(33, 'VWX Distributors', 'Diego Silang', '09252234567', 'BDO', 'Diego Silang', '6677889900', 0, 2, '2024-07-08 13:16:55', NULL, NULL),
(34, 'YZA Importers', 'Melchora Aquino', '09262234567', 'BPI', 'Melchora Aquino', '7788990011', 0, 3, '2024-07-08 13:16:55', NULL, NULL),
(35, 'BCD Exporters', 'Lapu-Lapu', '09272234567', 'Metrobank', 'Lapu-Lapu', '8899001122', 0, 4, '2024-07-08 13:16:55', '2024-07-08 10:36:44', NULL),
(36, 'EFG Producers', 'Manuel L. Quezon', '09282234567', 'Landbank', 'Manuel L. Quezon', '9900112233', 0, 18, '2024-07-08 13:16:55', NULL, NULL),
(37, 'HIJ Vendors', 'Sergio Osme?a', '09292234567', 'PNB', 'Sergio Osme?a', '0011223344', 0, 19, '2024-07-08 13:16:55', NULL, NULL),
(38, 'KLM Retailers', 'Ramon Magsaysay', '09302234567', 'Security Bank', 'Ramon Magsaysay', '1122334455', 0, 20, '2024-07-08 13:16:55', NULL, NULL),
(39, 'NOP Dealers', 'Carlos P. Garcia', '09312234567', 'China Bank', 'Carlos P. Garcia', '2233445566', 0, 1, '2024-07-08 13:16:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(10) UNSIGNED NOT NULL,
  `task_assigned_by` int(10) UNSIGNED NOT NULL,
  `task_title` varchar(100) NOT NULL,
  `task_description` text DEFAULT NULL,
  `task_created_at` datetime NOT NULL,
  `task_updated_at` datetime DEFAULT NULL,
  `task_completed_at` datetime DEFAULT NULL,
  `task_status` enum('unassigned','pending','in_progress','done') NOT NULL DEFAULT 'unassigned',
  `task_is_deleted` int(11) DEFAULT 0,
  `task_deleted_at` datetime DEFAULT NULL,
  `task_due_date` datetime DEFAULT NULL,
  `task_assigned_to_team` int(10) UNSIGNED DEFAULT NULL,
  `task_assigned_to_user` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_assigned_by`, `task_title`, `task_description`, `task_created_at`, `task_updated_at`, `task_completed_at`, `task_status`, `task_is_deleted`, `task_deleted_at`, `task_due_date`, `task_assigned_to_team`, `task_assigned_to_user`) VALUES
(62, 1, 'Prepare Monthly Sales Report', 'Compile sales data from all regions, create visual charts and graphs, and draft a comprehensive report summarizing the monthly sales performance.', '2024-07-02 11:41:43', NULL, NULL, 'pending', 0, NULL, '2024-07-29 12:25:00', NULL, 19),
(63, 1, 'Organize Team Meeting', 'Schedule a meeting with the team to discuss project updates, allocate tasks, and address any issues or concerns. Prepare an agenda and distribute it to all team members in advance.', '2024-07-02 11:42:06', NULL, NULL, 'pending', 0, NULL, '2024-07-16 02:00:00', NULL, 20),
(64, 1, 'Create Marketing Materials', 'Design brochures, flyers, and social media graphics for the upcoming product launch. Collaborate with the marketing team to ensure consistency in branding.', '2024-07-02 11:43:14', NULL, NULL, 'pending', 0, NULL, '2024-07-08 12:00:00', NULL, 2),
(65, 1, 'Conduct Employee Training Session', 'Organize a training session for new employees on company policies, procedures, and software tools. Prepare training materials and coordinate with the HR department.', '2024-07-02 11:43:33', NULL, NULL, 'pending', 0, NULL, '2024-07-04 15:00:00', NULL, 18),
(66, 1, 'Review Financial Statements', 'Analyze the company\'s financial statements, identify discrepancies, and prepare a summary report for the finance department. Ensure all financial records are accurate.', '2024-07-02 11:43:52', '2024-07-05 11:24:52', NULL, 'in_progress', 0, NULL, '2024-07-03 17:00:00', NULL, 4),
(67, 1, 'Arrange Business Travel', 'Book flights, hotels, and transportation for the upcoming business trip. Prepare a detailed itinerary and distribute it to the traveling employees.', '2024-07-02 11:44:09', NULL, NULL, 'pending', 0, NULL, '2024-07-10 10:00:00', NULL, 3),
(68, 1, 'Monitor Social Media Channels', 'Track and respond to comments, messages, and mentions on the company’s social media platforms. Engage with followers and address any customer inquiries.', '2024-07-02 11:44:43', NULL, NULL, 'pending', 0, NULL, '2024-07-08 11:00:00', NULL, 19),
(69, 1, 'Perform System Backup', 'Execute a full backup of the company’s data and systems. Verify that all critical information is securely stored and accessible in case of a system failure.', '2024-07-02 11:45:01', NULL, NULL, 'pending', 0, NULL, '2024-07-12 12:00:00', NULL, 20),
(70, 1, 'Draft Annual Budget Plan', 'Work with department heads to outline the budget for the upcoming year. Include projected expenses, revenue forecasts, and resource allocations.', '2024-07-02 11:45:20', NULL, NULL, 'pending', 0, NULL, '2024-07-04 11:00:00', NULL, 2),
(71, 1, 'Conduct Market Research', 'Gather and analyze data on industry trends, competitors, and customer preferences. Prepare a report summarizing the findings and insights for the marketing team.', '2024-07-02 11:45:48', NULL, NULL, 'pending', 0, NULL, '2024-07-31 12:00:00', NULL, 18),
(72, 1, 'Update Website Content', 'Review and revise the content on the company’s website. Ensure all information is current, accurate, and aligns with the company’s branding and messaging.', '2024-07-02 11:45:59', NULL, NULL, 'pending', 0, NULL, '2024-07-10 12:00:00', NULL, 19),
(73, 4, 'Process Payroll', 'Calculate employee salaries, deduct taxes, and process payments. Ensure all payroll activities comply with legal and regulatory requirements.', '2024-07-02 11:46:34', NULL, NULL, 'pending', 0, NULL, '2024-07-11 12:00:00', NULL, 1),
(74, 20, 'Plan Office Event', 'Organize and coordinate an office event, such as a team-building activity or holiday party. Manage the budget, venue, catering, and invitations.', '2024-07-02 11:47:09', '2024-07-02 11:48:06', NULL, 'in_progress', 0, NULL, '2024-07-13 10:00:00', NULL, 1),
(75, 18, 'Manage Email Campaign', 'Design and send out an email marketing campaign. Track open rates, click-through rates, and overall engagement to assess the campaign\'s effectiveness.', '2024-07-02 11:47:33', '2024-07-03 02:53:42', '2024-07-03 02:53:42', 'done', 0, NULL, '2024-07-27 16:00:00', NULL, 1),
(76, 3, 'Palit Chicken Proven', 'Tabok sa atbang, buy chicken proven with spicy sauce.', '2024-07-02 11:56:32', NULL, NULL, 'pending', 0, NULL, '2024-07-02 16:00:00', NULL, 1),
(77, 1, 'Test team', 'Test team task', '2024-07-03 02:55:21', NULL, NULL, 'pending', 0, NULL, '2024-07-12 12:00:00', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_id` int(10) UNSIGNED NOT NULL,
  `team_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_id`, `team_name`) VALUES
(1, 'Oldies'),
(2, 'Newbies');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_first_name` varchar(30) NOT NULL,
  `user_last_name` varchar(30) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_created_at` datetime DEFAULT NULL,
  `team_id` int(10) UNSIGNED DEFAULT NULL,
  `user_type_id` int(10) UNSIGNED DEFAULT NULL,
  `user_status` int(10) NOT NULL,
  `user_location_id` int(10) UNSIGNED DEFAULT NULL,
  `user_deleted_at` datetime DEFAULT NULL,
  `user_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_first_name`, `user_last_name`, `user_email`, `user_password`, `user_created_at`, `team_id`, `user_type_id`, `user_status`, `user_location_id`, `user_deleted_at`, `user_updated_at`) VALUES
(1, 'Miguel', 'Trinidad', 'miguel@email.com', '$2y$10$XysJgs0q9N9bLzk4rBtniO/F8Fvt2bptJk6hqkijTYFDOQ0T4KhTq', '2024-06-24 04:19:29', 2, 1, 0, 4, NULL, '2024-07-04 09:35:04'),
(2, 'Mark', 'Tablada', 'marktabs@email.com', '$2y$10$bfgrTzaLDuFAl3ajTlAmouWA0Sz7guJsj2YzF/tGcMww7qwTiKPYi', '2024-06-24 04:21:48', 2, 2, 0, 2, NULL, '2024-07-04 09:34:41'),
(3, 'Jerold', 'Lord', 'jerry@email.com', '$2y$10$oDXsWjSzdw5eGe6eJrIgbuC/hAzKXqT4WAhY/xlvxndUrhpuykegi', '2024-06-24 07:23:51', 2, 2, 0, 5, NULL, '2024-07-04 09:35:53'),
(4, 'Archer', 'Pizon', 'archer@email.com', '$2y$10$fsIWkbsqATDyXq7Zu.DrjOiFCLOu7c8xTZblSSW3uhamGvs/TJPSi', '2024-06-25 07:57:09', 2, 2, 0, 1, '2024-07-04 09:32:57', '2024-07-08 05:00:15'),
(18, 'Sittie', 'Almiah', 'sittie@email.com', '$2y$10$sXVbvSg/oAMAahJKd81nIeAepXAqCJtJV6q1ifBLYpukmkNsKXhXq', '2024-06-27 04:58:23', 1, 2, 0, 3, NULL, '2024-07-04 09:35:28'),
(19, 'Emmanuel', 'Angelo', 'emman@email.com', '$2y$10$bdKgxSlioRCY8amIP/qG0eWoAbbjjGzX1v/lSQNybJerhZ5q9w6yS', '2024-06-27 04:59:39', 1, 2, 0, 3, NULL, NULL),
(20, 'Supervisor', 'Vincent', 'supervisor@email.com', '$2y$10$ETn9ln/vP0XHoGQZ0vm2QOdC14LFJCo9yYQ7d07QiUebNQxeNN0Bm', '2024-07-01 08:04:06', 1, 2, 0, 3, NULL, NULL),
(27, 'test', 'select2', 'select2@email.com', '$2y$10$yv7LNiOH6H8ywezohTK7R.i0.KWtWo06eZMd40okCtO2OBytvskii', '2024-07-08 04:26:22', 1, 1, 1, 3, '2024-07-08 05:00:43', '2024-07-08 05:00:43'),
(28, 'select', 'select', 'select@email.com', '$2y$10$dPKiWzRAjrIIyEztVmgCXOGi1GHQtlayJaaAievtr2BFVrgk79v5G', '2024-07-08 04:48:04', 2, 2, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_contacts`
--

CREATE TABLE `user_contacts` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_contacts`
--

INSERT INTO `user_contacts` (`user_id`, `contact_id`) VALUES
(1, 2),
(1, 3),
(2, 3),
(1, 4),
(2, 4),
(2, 4),
(2, 4),
(1, 5),
(2, 5),
(1, 6),
(2, 6),
(1, 7),
(1, 8),
(2, 8),
(2, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(2, 13),
(2, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(2, 21),
(1, 22),
(3, 23),
(3, 24),
(1, 25),
(2, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(2, 32),
(1, 33),
(1, 34),
(2, 35),
(3, 36),
(4, 37),
(1, 38),
(1, 39),
(1, 40),
(4, 41),
(2, 42),
(2, 43),
(2, 44),
(1, 45),
(1, 46),
(2, 49),
(1, 54),
(1, 55),
(4, 56),
(4, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(4, 63),
(4, 64),
(4, 65),
(4, 66),
(4, 67),
(4, 68),
(4, 69),
(4, 70),
(4, 71),
(4, 72),
(4, 73),
(4, 74),
(4, 75),
(4, 76),
(4, 77),
(4, 78),
(1, 79),
(4, 80),
(1, 81),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(1, 86),
(4, 87),
(4, 88),
(4, 89),
(4, 90),
(4, 91),
(19, 92),
(19, 93),
(18, 94),
(18, 95),
(4, 96);

-- --------------------------------------------------------

--
-- Table structure for table `user_tasks`
--

CREATE TABLE `user_tasks` (
  `task_id` int(10) UNSIGNED NOT NULL,
  `task_assigned_to_user` int(10) UNSIGNED DEFAULT NULL,
  `task_assigned_by` int(10) UNSIGNED NOT NULL,
  `task_assigned_to_team` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_tasks`
--

INSERT INTO `user_tasks` (`task_id`, `task_assigned_to_user`, `task_assigned_by`, `task_assigned_to_team`) VALUES
(62, 19, 1, NULL),
(63, 20, 1, NULL),
(64, 2, 1, NULL),
(65, 18, 1, NULL),
(66, 4, 1, NULL),
(67, 3, 1, NULL),
(68, 19, 1, NULL),
(69, 20, 1, NULL),
(70, 2, 1, NULL),
(71, 18, 1, NULL),
(72, 19, 1, NULL),
(73, 1, 4, NULL),
(74, 1, 20, NULL),
(75, 1, 18, NULL),
(76, 1, 3, NULL),
(77, NULL, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(10) UNSIGNED NOT NULL,
  `user_type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type_name`) VALUES
(1, 'Admin'),
(2, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `whouse_id` int(10) UNSIGNED NOT NULL,
  `whouse_name` varchar(255) NOT NULL,
  `whouse_location_id` int(10) UNSIGNED NOT NULL,
  `whouse_address` varchar(255) NOT NULL,
  `whouse_status` int(10) NOT NULL,
  `whouse_added_by` int(10) UNSIGNED DEFAULT NULL,
  `whouse_added_at` datetime DEFAULT NULL,
  `whouse_updated_at` datetime DEFAULT NULL,
  `whouse_deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`whouse_id`, `whouse_name`, `whouse_location_id`, `whouse_address`, `whouse_status`, `whouse_added_by`, `whouse_added_at`, `whouse_updated_at`, `whouse_deleted_at`) VALUES
(1, 'Manila Main Warehouse', 1, '1234 Warehouse St, Manila, Philippines', 0, 1, '2024-07-05 10:00:37', NULL, NULL),
(2, 'Cebu Central Warehouse', 2, '5678 Industrial Ave, Cebu City, Philippines', 0, 2, '2024-07-05 10:00:37', NULL, NULL),
(3, 'Davao Main Warehouse', 3, '9101 Logistic Park, Davao City, Philippines', 0, 3, '2024-07-05 10:00:37', NULL, NULL),
(4, 'Makati Storage Facility', 4, '1213 Business Rd, Makati, Philippines', 0, 4, '2024-07-05 10:00:37', NULL, NULL),
(5, 'Quezon City Depot', 5, '1415 Warehouse Blvd, Quezon City, Philippines', 0, 18, '2024-07-05 10:00:37', NULL, NULL),
(6, 'Baguio Storage Facility', 6, '1617 Storage Ave, Baguio City, Philippines', 0, 19, '2024-07-05 10:00:37', NULL, NULL),
(7, 'Pasig City Warehouse', 7, '1819 Distribution St, Pasig City, Philippines', 0, 20, '2024-07-05 10:00:37', NULL, NULL),
(8, 'Taguig Logistic Center', 8, '2021 Global Hub, Taguig, Philippines', 0, 1, '2024-07-05 10:00:37', NULL, NULL),
(9, 'Iloilo Storage Facility', 9, '2223 Iloilo Rd, Iloilo City, Philippines', 0, 2, '2024-07-05 10:00:37', NULL, NULL),
(10, 'Bacolod Distribution Center', 10, '2425 Lacson St, Bacolod City, Philippines', 0, 3, '2024-07-05 10:00:37', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `category_added_by` (`category_added_by`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `inventory_tracking`
--
ALTER TABLE `inventory_tracking`
  ADD PRIMARY KEY (`inv_trk_id`),
  ADD KEY `fk_location_id` (`inv_trk_location_id`),
  ADD KEY `fk_supplier_id` (`inv_trk_supplier_id`),
  ADD KEY `fk_added_by` (`inv_trk_added_by`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_category` (`item_category_id`),
  ADD KEY `fk_location` (`item_location_id`),
  ADD KEY `fk_user` (`item_added_by`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `location_added_by` (`location_added_by`);

--
-- Indexes for table `report_logs`
--
ALTER TABLE `report_logs`
  ADD PRIMARY KEY (`rlog_id`),
  ADD KEY `rlog_item_id` (`rlog_item_id`),
  ADD KEY `rlog_added_by` (`rlog_added_by`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `supplier_added_by` (`supplier_added_by`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `task_assigned_by` (`task_assigned_by`),
  ADD KEY `task_assigned_to_team` (`task_assigned_to_team`),
  ADD KEY `task_assigned_to_user` (`task_assigned_to_user`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_team` (`team_id`),
  ADD KEY `fk_user_type` (`user_type_id`),
  ADD KEY `fk_user_location` (`user_location_id`);

--
-- Indexes for table `user_contacts`
--
ALTER TABLE `user_contacts`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `contact_id` (`contact_id`);

--
-- Indexes for table `user_tasks`
--
ALTER TABLE `user_tasks`
  ADD KEY `task_assigned_to` (`task_assigned_to_user`),
  ADD KEY `task_assigned_by` (`task_assigned_by`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `fk_user_tasks_assigned_to_team` (`task_assigned_to_team`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`whouse_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `inventory_tracking`
--
ALTER TABLE `inventory_tracking`
  MODIFY `inv_trk_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `report_logs`
--
ALTER TABLE `report_logs`
  MODIFY `rlog_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `whouse_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`category_added_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `inventory_tracking`
--
ALTER TABLE `inventory_tracking`
  ADD CONSTRAINT `fk_added_by` FOREIGN KEY (`inv_trk_added_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_location_id` FOREIGN KEY (`inv_trk_location_id`) REFERENCES `locations` (`location_id`),
  ADD CONSTRAINT `fk_supplier_id` FOREIGN KEY (`inv_trk_supplier_id`) REFERENCES `suppliers` (`supplier_id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`item_category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `fk_location` FOREIGN KEY (`item_location_id`) REFERENCES `locations` (`location_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`item_added_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`location_added_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `report_logs`
--
ALTER TABLE `report_logs`
  ADD CONSTRAINT `report_logs_ibfk_1` FOREIGN KEY (`rlog_item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `report_logs_ibfk_2` FOREIGN KEY (`rlog_added_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`supplier_added_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`task_assigned_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`task_assigned_to_team`) REFERENCES `team` (`team_id`),
  ADD CONSTRAINT `tasks_ibfk_4` FOREIGN KEY (`task_assigned_to_user`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_team` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`),
  ADD CONSTRAINT `fk_user_location` FOREIGN KEY (`user_location_id`) REFERENCES `locations` (`location_id`),
  ADD CONSTRAINT `fk_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`user_type_id`);

--
-- Constraints for table `user_contacts`
--
ALTER TABLE `user_contacts`
  ADD CONSTRAINT `user_contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_contacts_ibfk_2` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`contact_id`);

--
-- Constraints for table `user_tasks`
--
ALTER TABLE `user_tasks`
  ADD CONSTRAINT `fk_user_tasks_assigned_to_team` FOREIGN KEY (`task_assigned_to_team`) REFERENCES `team` (`team_id`),
  ADD CONSTRAINT `fk_user_tasks_assigned_to_user` FOREIGN KEY (`task_assigned_to_user`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_tasks_ibfk_3` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
