-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 25, 2023 at 03:24 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accountier`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `message` text NOT NULL,
  `isRead` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `from`, `to`, `message`, `isRead`, `created_at`, `updated_at`) VALUES
(1, 1, 77, 'Hii', '1', '2023-03-05 07:20:28', '2023-03-05 07:20:28'),
(2, 77, 1, 'Hello', '1', '2023-03-05 07:21:21', '2023-03-05 07:23:56'),
(3, 1, 77, 'Hello', '1', '2023-03-05 07:22:50', '2023-03-05 07:22:50'),
(4, 1, 77, 'Hello', '1', '2023-03-05 08:05:53', '2023-03-05 08:05:53'),
(5, 1, 77, 'Hello', '1', '2023-03-05 08:09:32', '2023-03-05 08:09:32'),
(6, 1, 77, 'Hello', '1', '2023-03-05 08:09:34', '2023-03-05 08:09:34'),
(7, 1, 77, 'Hello', '1', '2023-03-05 08:09:35', '2023-03-05 08:09:35'),
(8, 1, 77, 'Hello', '1', '2023-03-05 08:09:38', '2023-03-05 08:09:38'),
(9, 1, 77, 'Hello', '1', '2023-03-05 08:10:18', '2023-03-05 08:10:19'),
(10, 77, 1, 'Hello', '1', '2023-03-05 08:10:30', '2023-03-05 08:10:37'),
(11, 1, 77, 'Hii', '1', '2023-03-05 09:31:42', '2023-03-05 09:31:42'),
(12, 77, 1, 'How are you ?', '1', '2023-03-05 09:31:53', '2023-03-05 09:33:22'),
(13, 1, 77, 'Fine', '1', '2023-03-05 09:47:58', '2023-03-05 09:47:58'),
(14, 1, 77, 'Hello', '1', '2023-03-05 13:51:50', '2023-03-05 13:51:50'),
(15, 77, 1, 'How are you ?', '1', '2023-03-05 13:51:59', '2023-03-05 14:07:37'),
(16, 1, 108, 'Hi', '0', '2023-03-05 14:07:43', '2023-03-05 14:07:43'),
(17, 1, 108, 'I am superadmin', '0', '2023-03-05 14:07:53', '2023-03-05 14:07:53'),
(18, 1, 99, 'Hello my name is superadmin owner of website', '1', '2023-03-05 14:21:38', '2023-03-05 18:42:21'),
(19, 1, 99, 'Hello my name is superadmin owner of website', '1', '2023-03-05 17:18:00', '2023-03-05 18:42:21'),
(20, 99, 1, 'Hii', '1', '2023-03-05 17:36:41', '2023-03-05 17:43:36'),
(21, 99, 1, 'i am practitioner', '1', '2023-03-05 17:36:57', '2023-03-05 17:43:36'),
(22, 1, 99, 'Hello I am superadmin', '1', '2023-03-05 17:37:06', '2023-03-05 18:42:21'),
(23, 99, 1, 'Hii', '1', '2023-03-05 17:40:18', '2023-03-05 17:43:36'),
(24, 99, 1, 'Hello my name is superadmin owner of website', '1', '2023-03-05 17:53:34', '2023-03-05 18:02:28'),
(25, 1, 99, 'Hello my name is superadmin owner of website\r\n\r\nHello my name is superadmin owner of website', '1', '2023-03-05 18:03:51', '2023-03-05 18:42:21'),
(26, 99, 1, 'Hello my name is superadmin owner of website Hello my name is superadmin owner of websiteHello my name is superadmin owner of website Hello my name is superadmin owner of website', '1', '2023-03-05 18:19:26', '2023-03-05 18:36:07'),
(27, 99, 1, 'Hello', '1', '2023-03-05 18:42:31', '2023-03-05 18:42:31'),
(28, 99, 1, 'Hello', '1', '2023-03-05 18:42:41', '2023-03-05 18:42:41'),
(29, 99, 1, 'Hello', '1', '2023-03-09 17:20:09', '2023-03-09 17:20:09'),
(30, 1, 99, 'how are u ?', '1', '2023-03-09 17:20:23', '2023-03-09 17:20:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
