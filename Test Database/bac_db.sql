-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 26, 2019 at 03:11 PM
-- Server version: 10.1.40-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bac_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alignments`
--

CREATE TABLE `alignments` (
  `AL_ID` int(11) NOT NULL,
  `AL_CON_ID` int(11) NOT NULL,
  `AL_TIM` int(11) DEFAULT NULL,
  `AL_1E` int(11) DEFAULT NULL,
  `AL_1B` int(11) DEFAULT NULL,
  `AL_2E` int(11) DEFAULT NULL,
  `AL_2B` int(11) DEFAULT NULL,
  `AL_3E` int(11) DEFAULT NULL,
  `AL_3B` int(11) DEFAULT NULL,
  `AL_4E` int(11) DEFAULT NULL,
  `AL_4B` int(11) DEFAULT NULL,
  `AL_LEFT` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alignments`
--

INSERT INTO `alignments` (`AL_ID`, `AL_CON_ID`, `AL_TIM`, `AL_1E`, `AL_1B`, `AL_2E`, `AL_2B`, `AL_3E`, `AL_3B`, `AL_4E`, `AL_4B`, `AL_LEFT`) VALUES
(1, 1660, 0002, 0006, 0005, 0007, 0001, 0009, 0008, 0004, 0, '[]'),
(2, 1868, 0001, 0006, 0007, 0010, 0004, 0002, 0008, 0005, 0, '[]'),
(3, 1984, 0001, 0006, 0010, 0005, 0007, 0008, 0002, 0004, 0, '[]'),
(4, 2060, 0, 0006, 0001, 0007, 0002, 0009, 0005, 0004, 0, '[]'),
(5, 2198, 0007, 0005, 0001, 0004, 0002, 0009, 0008, 0, 0, '[]'),
(6, 2355, 0010, 0006, 0001, 0, 0002, 0009, 0005, 0, 0, '[]'),
(7, 2467, 0010, 0006, 0001, 0007, 0002, 0009, 0005, 0004, 0008, '[]'),
(8, 2588, 0006, 0, 0001, 0008, 0002, 0009, 0005, 0004, 0, '[]'),
(9, 2699, 0006, 0010, 0001, 0008, 0002, 0009, 0005, 0004, 0, '[]'),
(10, 2758, 0008, 0006, 0001, 0007, 0002, 0009, 0005, 0004, 0, '[]');

-- --------------------------------------------------------

--
-- Table structure for table `bot__users`
--

CREATE TABLE `bot__users` (
  `id` int(11) NOT NULL,
  `user_chat_id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `user_role_id` int(1) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bot__users`
--

INSERT INTO `bot__users` (`id`, `user_chat_id`, `name`, `user_role_id`, `active`) VALUES
(8, 0000, 'TestUser-0', 1, 1),
(9, 0001, 'TestUser-1', 3, 1),
(10, 0002, 'TestUser-11', 2, 1),
(12, 0003, 'TestUser-2', 2, 1),
(13, 0004, 'TestUser-3', 2, 1),
(14, 0005, 'TestUser-4', 4, 1),
(15, 0006, 'TestUser-5', 2, 1),
(16, 0007, 'TestUser-6', 2, 1),
(17, 0008, 'TestUser-7', 2, 1),
(18, 0009, 'TestUser-8', 2, 1),
(19, 0010, 'TestUser-9', 2, 1),
(20, 0011, 'TestUser-10', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cancel__types`
--

CREATE TABLE `cancel__types` (
  `CT_ID` int(11) NOT NULL,
  `CT_NAME` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cancel__types`
--

INSERT INTO `cancel__types` (`CT_ID`, `CT_NAME`) VALUES
(1, 'Not enough people.'),
(2, 'Bad Weather.');

-- --------------------------------------------------------

--
-- Table structure for table `convocations`
--

CREATE TABLE `convocations` (
  `CON_ID` int(15) NOT NULL,
  `CON_TEXT` varchar(500) NOT NULL,
  `CON_DATE` datetime NOT NULL,
  `CON_START_DATE` datetime DEFAULT NULL,
  `CON_END_DATE` datetime DEFAULT NULL,
  `CON_USER_ID` int(11) NOT NULL,
  `CON_TEAM_ID` int(11) NOT NULL,
  `CON_MIN` int(11) DEFAULT NULL,
  `CON_MAX` int(11) DEFAULT NULL,
  `CON_STATUS` varchar(20) DEFAULT NULL,
  `CON_TT` int(11) DEFAULT NULL,
  `CON_CT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `convocations`
--

INSERT INTO `convocations` (`CON_ID`, `CON_TEXT`, `CON_DATE`, `CON_START_DATE`, `CON_END_DATE`, `CON_USER_ID`, `CON_TEAM_ID`, `CON_MIN`, `CON_MAX`, `CON_STATUS`, `CON_TT`, `CON_CT`) VALUES
(809, 'C01', '2019-04-14 20:30:00', '2019-04-14 12:21:09', NULL, 0000, 1, NULL, NULL, 'CANCELLED', 1, 1),
(822, 'C02', '2019-04-14 20:15:00', '2019-04-14 12:22:40', NULL, 0000, 1, NULL, NULL, 'CANCELLED', 3, NULL),
(982, 'C03', '2019-04-15 20:30:00', '2019-04-15 06:57:25', NULL, 0000, 1, NULL, NULL, 'CANCELLED', 1, 1),
(1054, 'C04', '2019-04-16 20:15:00', '2019-04-16 19:17:52', NULL, 0011, 1, NULL, NULL, 'CANCELLED', 2, NULL),
(1086, 'C05', '2019-04-16 20:15:00', '2019-04-16 21:21:20', NULL, 0011, 1, NULL, NULL, 'CANCELLED', 2, 2),
(1163, 'C06', '2019-04-21 20:30:00', '2019-04-21 15:33:17', NULL, 0011, 1, NULL, NULL, 'CONFIRMED', 1, NULL),
(1198, 'C07', '2019-04-24 20:15:00', '2019-04-23 11:11:09', '2019-04-24 20:15:00', 0011, 1, NULL, NULL, 'CONFIRMED', 3, NULL),
(1320, 'C08', '2019-04-29 20:30:00', '2019-04-28 09:29:58', '2019-04-28 21:39:00', 0000, 1, NULL, NULL, 'CANCELLED', 2, 1),
(1467, 'C09', '2019-05-01 10:00:00', '2019-04-30 08:28:47', '2019-05-01 11:56:00', 0001, 1, NULL, NULL, 'CANCELLED', 2, 2),
(1488, 'C10', '2019-05-01 18:00:00', '2019-04-30 08:29:32', '2019-05-01 11:56:00', 0001, 1, NULL, NULL, 'CONFIRMED', 3, NULL),
(1521, 'C11', '2019-05-01 21:15:00', '2019-04-30 08:30:48', '2019-05-01 11:56:00', 0001, 1, NULL, NULL, 'CANCELLED', 1, 1),
(1660, 'C12', '2019-05-06 20:30:00', '2019-05-05 11:01:24', '2019-05-05 21:07:05', 0001, 1, NULL, NULL, 'CONFIRMED', 1, NULL),
(1868, 'C13', '2019-05-08 20:15:00', '2019-05-06 22:17:29', '2019-05-07 21:45:40', 0001, 1, NULL, NULL, 'CONFIRMED', 1, NULL),
(1984, 'C14', '2019-05-12 20:30:00', '2019-05-12 12:36:17', '2019-05-12 22:48:48', 0001, 1, NULL, NULL, 'CONFIRMED', 1, NULL),
(2060, 'C15', '2019-06-08 15:00:00', '2019-05-13 22:24:53', '2019-05-19 22:51:16', 0001, 1, NULL, NULL, 'CONFIRMED', 4, NULL),
(2092, 'C16', '2019-05-15 20:15:00', '2019-05-14 09:37:42', '2019-05-14 20:32:56', 0001, 1, NULL, NULL, 'CANCELLED', 1, 1),
(2198, 'C17', '2019-05-20 20:30:00', '2019-05-19 11:43:59', '2019-05-20 15:14:52', 0001, 1, NULL, NULL, 'CONFIRMED', 1, NULL),
(2355, 'C18', '2019-05-22 20:15:00', '2019-05-21 09:04:18', '2019-05-21 22:26:38', 0001, 1, NULL, NULL, 'CONFIRMED', 1, NULL),
(2467, 'C19', '2019-05-27 20:30:00', '2019-05-26 09:43:35', '2019-05-26 22:09:34', 0001, 1, NULL, NULL, 'CONFIRMED', 2, NULL),
(2588, 'C20', '2019-05-29 20:15:00', '2019-05-28 12:28:39', '2019-05-28 22:27:50', 0001, 1, NULL, NULL, 'CONFIRMED', 1, NULL),
(2699, 'C21', '2019-06-03 20:30:00', '2019-06-02 10:12:48', '2019-06-02 20:27:30', 0001, 1, NULL, NULL, 'CONFIRMED', 2, NULL),
(2758, 'C22', '2019-06-05 20:15:00', '2019-06-04 09:00:15', '2019-06-04 16:50:31', 0001, 1, NULL, NULL, 'CONFIRMED', 2, NULL),
(2819, 'C23', '2019-06-10 20:15:00', '2019-06-09 12:44:39', '2019-06-09 21:51:04', 0001, 1, NULL, NULL, 'CANCELLED', 2, 1),
(2856, 'C24', '2019-06-10 18:00:00', '2019-06-09 15:51:19', '2019-06-09 21:51:28', 0001, 1, NULL, NULL, 'CANCELLED', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `con__responses`
--

CREATE TABLE `con__responses` (
  `CR_ID` int(11) NOT NULL,
  `CR_CON_ID` int(15) NOT NULL,
  `CR_USER_ID` int(11) NOT NULL,
  `CR_DATE` datetime NOT NULL,
  `CR_MSG` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `con__responses`
--

INSERT INTO `con__responses` (`CR_ID`, `CR_CON_ID`, `CR_USER_ID`, `CR_DATE`, `CR_MSG`) VALUES
(14, 822, 0000, '2019-04-14 12:22:43', 'ACCEPTED'),
(15, 822, 0001, '2019-04-14 12:23:21', 'ACCEPTED'),
(16, 822, 0002, '2019-04-14 12:23:30', 'DENIED'),
(17, 982, 0011, '2019-04-15 06:58:08', 'ACCEPTED'),
(18, 982, 0008, '2019-04-15 06:58:19', 'DENIED'),
(19, 982, 0002, '2019-04-15 06:59:21', 'DENIED'),
(20, 982, 0005, '2019-04-15 07:00:17', 'ACCEPTED'),
(21, 982, 0009, '2019-04-15 07:02:28', 'ACCEPTED'),
(22, 982, 0007, '2019-04-15 07:06:37', 'DENIED'),
(23, 982, 0006, '2019-04-15 07:16:12', 'ACCEPTED'),
(24, 982, 0003, '2019-04-15 09:54:14', 'ACCEPTED'),
(25, 982, 0001, '2019-04-15 10:20:06', 'ACCEPTED'),
(26, 1054, 0011, '2019-04-16 19:17:56', 'ACCEPTED'),
(27, 1054, 0001, '2019-04-16 19:18:12', 'DENIED'),
(28, 1054, 0006, '2019-04-16 19:20:07', 'ACCEPTED'),
(29, 1054, 0004, '2019-04-16 19:23:08', 'DENIED'),
(30, 1054, 0010, '2019-04-16 19:36:27', 'DENIED'),
(31, 1054, 0005, '2019-04-16 19:45:14', 'ACCEPTED'),
(32, 1086, 0011, '2019-04-16 21:21:21', 'ACCEPTED'),
(33, 1086, 0009, '2019-04-16 21:21:58', 'ACCEPTED'),
(34, 1086, 0001, '2019-04-16 21:22:05', 'DENIED'),
(35, 1086, 0008, '2019-04-16 21:23:19', 'DENIED'),
(36, 1086, 0010, '2019-04-16 22:14:15', 'DENIED'),
(37, 1086, 0007, '2019-04-16 22:53:36', 'DENIED'),
(38, 1086, 0002, '2019-04-17 05:22:05', 'DENIED'),
(39, 1086, 0006, '2019-04-17 06:03:14', 'ACCEPTED'),
(40, 1163, 0011, '2019-04-21 15:33:20', 'ACCEPTED'),
(41, 1163, 0002, '2019-04-21 15:34:24', 'ACCEPTED'),
(42, 1163, 0001, '2019-04-21 15:43:43', 'ACCEPTED'),
(43, 1163, 0006, '2019-04-21 17:44:38', 'ACCEPTED'),
(44, 1163, 0009, '2019-04-21 18:13:44', 'ACCEPTED'),
(45, 1163, 0008, '2019-04-21 18:26:36', 'DENIED'),
(46, 1163, 0005, '2019-04-21 20:03:39', 'ACCEPTED'),
(47, 1163, 0010, '2019-04-21 23:02:29', 'ACCEPTED'),
(48, 1163, 0007, '2019-04-23 06:56:47', 'DENIED'),
(49, 1198, 0011, '2019-04-23 11:11:19', 'DENIED'),
(51, 1198, 0002, '2019-04-23 11:16:53', 'ACCEPTED'),
(52, 1198, 0001, '2019-04-23 11:18:06', 'ACCEPTED'),
(53, 1198, 0009, '2019-04-23 11:28:59', 'ACCEPTED'),
(54, 1198, 0008, '2019-04-23 11:51:59', 'ACCEPTED'),
(55, 1198, 0010, '2019-04-23 12:01:28', 'ACCEPTED'),
(56, 1198, 0006, '2019-04-23 13:27:01', 'ACCEPTED'),
(57, 1198, 0005, '2019-04-23 19:59:46', 'ACCEPTED'),
(58, 1198, 0004, '2019-04-24 06:59:17', 'ACCEPTED'),
(60, 1320, 0002, '2019-04-28 09:30:11', 'ACCEPTED'),
(61, 1320, 0001, '2019-04-28 09:41:43', 'ACCEPTED'),
(62, 1320, 0008, '2019-04-28 09:52:04', 'DENIED'),
(65, 1320, 0009, '2019-04-28 10:12:19', 'ACCEPTED'),
(66, 1320, 0006, '2019-04-28 15:28:53', 'ACCEPTED'),
(67, 1320, 0005, '2019-04-28 16:36:50', 'ACCEPTED'),
(68, 1320, 0004, '2019-04-28 17:38:17', 'ACCEPTED'),
(69, 1320, 0010, '2019-04-28 19:35:13', 'DENIED'),
(70, 1320, 0007, '2019-04-28 20:34:46', 'DENIED'),
(73, 1467, 0002, '2019-04-30 08:30:48', 'ACCEPTED'),
(74, 1521, 0001, '2019-04-30 08:30:50', 'ACCEPTED'),
(75, 1488, 0002, '2019-04-30 08:30:52', 'ACCEPTED'),
(76, 1521, 0002, '2019-04-30 08:30:54', 'ACCEPTED'),
(77, 1488, 0001, '2019-04-30 08:31:05', 'ACCEPTED'),
(78, 1467, 0001, '2019-04-30 08:31:12', 'DENIED'),
(79, 1467, 0007, '2019-04-30 08:32:32', 'ACCEPTED'),
(80, 1488, 0007, '2019-04-30 08:32:33', 'ACCEPTED'),
(81, 1521, 0007, '2019-04-30 08:32:34', 'ACCEPTED'),
(82, 1467, 0005, '2019-04-30 08:59:32', 'ACCEPTED'),
(83, 1467, 0006, '2019-04-30 09:12:18', 'ACCEPTED'),
(84, 1488, 0006, '2019-04-30 09:12:26', 'ACCEPTED'),
(85, 1521, 0006, '2019-04-30 09:12:32', 'DENIED'),
(86, 1467, 0008, '2019-04-30 09:22:39', 'ACCEPTED'),
(87, 1488, 0008, '2019-04-30 09:22:50', 'ACCEPTED'),
(88, 1521, 0008, '2019-04-30 09:22:53', 'DENIED'),
(89, 1488, 0003, '2019-04-30 10:18:32', 'ACCEPTED'),
(90, 1467, 0009, '2019-04-30 13:48:43', 'ACCEPTED'),
(91, 1488, 0009, '2019-04-30 13:48:45', 'DENIED'),
(92, 1521, 0009, '2019-04-30 13:48:47', 'DENIED'),
(93, 1488, 0004, '2019-04-30 15:05:45', 'ACCEPTED'),
(94, 1467, 0004, '2019-04-30 15:05:58', 'DENIED'),
(95, 1521, 0004, '2019-04-30 15:06:04', 'ACCEPTED'),
(96, 1521, 0005, '2019-04-30 18:19:29', 'DENIED'),
(97, 1488, 0005, '2019-04-30 18:19:31', 'DENIED'),
(98, 1488, 0010, '2019-04-30 19:27:43', 'DENIED'),
(99, 1467, 0010, '2019-04-30 19:27:59', 'DENIED'),
(100, 1521, 0010, '2019-04-30 19:28:00', 'ACCEPTED'),
(101, 1660, 0001, '2019-05-05 11:01:29', 'ACCEPTED'),
(102, 1660, 0002, '2019-05-05 11:01:42', 'ACCEPTED'),
(103, 1660, 0006, '2019-05-05 11:19:46', 'ACCEPTED'),
(104, 1660, 0003, '2019-05-05 11:54:11', 'DENIED'),
(105, 1660, 0008, '2019-05-05 13:46:18', 'ACCEPTED'),
(106, 1660, 0005, '2019-05-05 15:44:51', 'ACCEPTED'),
(107, 1660, 0009, '2019-05-05 19:02:01', 'ACCEPTED'),
(108, 1660, 0007, '2019-05-05 19:12:38', 'ACCEPTED'),
(109, 1660, 0010, '2019-05-05 20:12:06', 'DENIED'),
(110, 1660, 0004, '2019-05-05 21:01:36', 'ACCEPTED'),
(111, 1868, 0001, '2019-05-06 22:17:33', 'ACCEPTED'),
(112, 1868, 0002, '2019-05-06 22:17:56', 'ACCEPTED'),
(113, 1868, 0004, '2019-05-06 22:21:57', 'ACCEPTED'),
(114, 1868, 0006, '2019-05-06 22:40:10', 'ACCEPTED'),
(115, 1868, 0005, '2019-05-07 01:33:01', 'ACCEPTED'),
(116, 1868, 0009, '2019-05-07 12:13:08', 'DENIED'),
(117, 1868, 0010, '2019-05-07 15:29:36', 'ACCEPTED'),
(118, 1868, 0008, '2019-05-07 18:00:18', 'ACCEPTED'),
(119, 1868, 0007, '2019-05-07 21:12:32', 'ACCEPTED'),
(120, 1984, 0001, '2019-05-12 12:36:18', 'ACCEPTED'),
(121, 1984, 0002, '2019-05-12 12:36:25', 'ACCEPTED'),
(122, 1984, 0004, '2019-05-12 12:46:23', 'ACCEPTED'),
(123, 1984, 0008, '2019-05-12 15:18:51', 'ACCEPTED'),
(124, 1984, 0006, '2019-05-12 15:39:43', 'ACCEPTED'),
(125, 1984, 0010, '2019-05-12 21:33:00', 'ACCEPTED'),
(126, 1984, 0005, '2019-05-12 21:41:34', 'ACCEPTED'),
(127, 1984, 0007, '2019-05-12 21:45:36', 'ACCEPTED'),
(128, 2060, 0001, '2019-05-13 22:24:56', 'ACCEPTED'),
(129, 2060, 0002, '2019-05-13 22:25:28', 'ACCEPTED'),
(130, 2092, 0001, '2019-05-14 09:37:42', 'ACCEPTED'),
(131, 2092, 0005, '2019-05-14 09:38:15', 'DENIED'),
(132, 2092, 0010, '2019-05-14 09:38:19', 'DENIED'),
(133, 2060, 0010, '2019-05-14 09:40:20', 'DENIED'),
(134, 2092, 0002, '2019-05-14 09:44:58', 'DENIED'),
(135, 2092, 0004, '2019-05-14 09:55:39', 'ACCEPTED'),
(136, 2092, 0008, '2019-05-14 10:13:44', 'ACCEPTED'),
(137, 2060, 0008, '2019-05-14 10:13:52', 'DENIED'),
(138, 2060, 0007, '2019-05-14 11:09:55', 'ACCEPTED'),
(139, 2092, 0007, '2019-05-14 11:10:19', 'ACCEPTED'),
(140, 2060, 0006, '2019-05-14 16:45:27', 'ACCEPTED'),
(141, 2092, 0006, '2019-05-14 16:45:29', 'ACCEPTED'),
(142, 2092, 0009, '2019-05-14 19:15:08', 'DENIED'),
(143, 2060, 0005, '2019-05-14 19:33:00', 'ACCEPTED'),
(144, 2060, 0004, '2019-05-14 21:33:02', 'ACCEPTED'),
(145, 2060, 0003, '2019-05-14 22:18:21', 'DENIED'),
(146, 2060, 0009, '2019-05-18 19:54:31', 'ACCEPTED'),
(147, 2198, 0001, '2019-05-19 11:43:59', 'ACCEPTED'),
(148, 2198, 0004, '2019-05-19 11:44:17', 'ACCEPTED'),
(149, 2198, 0009, '2019-05-19 11:46:13', 'ACCEPTED'),
(150, 2198, 0002, '2019-05-19 11:49:28', 'ACCEPTED'),
(151, 2198, 0006, '2019-05-19 12:06:43', 'DENIED'),
(152, 2198, 0008, '2019-05-19 16:29:48', 'ACCEPTED'),
(153, 2198, 0007, '2019-05-19 19:58:05', 'ACCEPTED'),
(154, 2198, 0005, '2019-05-19 21:00:05', 'ACCEPTED'),
(155, 2198, 0010, '2019-05-19 21:18:08', 'DENIED'),
(156, 2355, 0001, '2019-05-21 09:04:19', 'ACCEPTED'),
(157, 2355, 0009, '2019-05-21 09:04:36', 'ACCEPTED'),
(158, 2355, 0002, '2019-05-21 09:05:19', 'ACCEPTED'),
(159, 2355, 0004, '2019-05-21 09:12:17', 'DENIED'),
(160, 2355, 0006, '2019-05-21 12:56:57', 'ACCEPTED'),
(161, 2355, 0005, '2019-05-21 14:36:11', 'ACCEPTED'),
(162, 2355, 0008, '2019-05-21 16:26:32', 'DENIED'),
(163, 2355, 0010, '2019-05-21 18:13:07', 'ACCEPTED'),
(164, 2355, 0007, '2019-05-21 21:25:00', 'DENIED'),
(165, 2467, 0001, '2019-05-26 09:43:37', 'ACCEPTED'),
(166, 2467, 0002, '2019-05-26 09:43:59', 'ACCEPTED'),
(167, 2467, 0010, '2019-05-26 09:55:23', 'ACCEPTED'),
(168, 2467, 0007, '2019-05-26 09:59:58', 'ACCEPTED'),
(169, 2467, 0004, '2019-05-26 10:15:35', 'ACCEPTED'),
(170, 2467, 0009, '2019-05-26 10:26:54', 'ACCEPTED'),
(171, 2467, 0006, '2019-05-26 12:07:15', 'ACCEPTED'),
(172, 2467, 0005, '2019-05-26 21:31:29', 'ACCEPTED'),
(173, 2467, 0008, '2019-05-26 21:45:07', 'ACCEPTED'),
(174, 2588, 0001, '2019-05-28 12:28:44', 'ACCEPTED'),
(175, 2588, 0004, '2019-05-28 12:29:04', 'ACCEPTED'),
(176, 2588, 0006, '2019-05-28 12:42:09', 'ACCEPTED'),
(177, 2588, 0009, '2019-05-28 12:47:16', 'ACCEPTED'),
(178, 2588, 0008, '2019-05-28 13:24:04', 'ACCEPTED'),
(179, 2588, 0002, '2019-05-28 12:29:04', 'ACCEPTED'),
(180, 2588, 0007, '2019-05-28 21:41:01', 'DENIED'),
(181, 2588, 0005, '2019-05-28 22:00:17', 'ACCEPTED'),
(182, 2699, 0001, '2019-06-02 10:12:49', 'ACCEPTED'),
(183, 2699, 0008, '2019-06-02 10:17:04', 'ACCEPTED'),
(184, 2699, 0009, '2019-06-02 11:09:55', 'ACCEPTED'),
(185, 2699, 0002, '2019-06-02 11:34:52', 'ACCEPTED'),
(186, 2699, 0004, '2019-06-02 12:28:41', 'ACCEPTED'),
(187, 2699, 0005, '2019-06-02 13:39:30', 'ACCEPTED'),
(188, 2699, 0006, '2019-06-02 19:57:53', 'ACCEPTED'),
(189, 2699, 0010, '2019-06-02 20:17:07', 'ACCEPTED'),
(190, 2758, 0001, '2019-06-04 09:00:18', 'ACCEPTED'),
(191, 2758, 0002, '2019-06-04 09:06:24', 'ACCEPTED'),
(192, 2758, 0009, '2019-06-04 09:13:03', 'ACCEPTED'),
(193, 2758, 0005, '2019-06-04 09:15:33', 'ACCEPTED'),
(194, 2758, 0004, '2019-06-04 09:51:01', 'ACCEPTED'),
(195, 2758, 0007, '2019-06-04 12:24:23', 'ACCEPTED'),
(196, 2758, 0008, '2019-06-04 12:34:59', 'ACCEPTED'),
(197, 2758, 0006, '2019-06-04 15:01:51', 'ACCEPTED'),
(198, 2819, 0009, '2019-06-09 12:45:21', 'DENIED'),
(199, 2819, 0005, '2019-06-09 12:49:02', 'DENIED'),
(200, 2819, 0007, '2019-06-09 13:33:56', 'DENIED'),
(201, 2819, 0004, '2019-06-09 14:58:45', 'ACCEPTED'),
(204, 2856, 0005, '2019-06-09 15:53:18', 'DENIED'),
(206, 2856, 0009, '2019-06-09 17:22:28', 'ACCEPTED'),
(207, 2856, 0001, '2019-06-09 19:28:43', 'DENIED'),
(208, 2819, 0006, '2019-06-09 19:45:24', 'DENIED'),
(209, 2856, 0006, '2019-06-09 19:45:25', 'DENIED'),
(210, 2819, 0002, '2019-06-09 20:47:01', 'ACCEPTED'),
(211, 2856, 0002, '2019-06-09 20:47:02', 'ACCEPTED'),
(212, 2819, 0010, '2019-06-09 21:27:50', 'ACCEPTED'),
(213, 2856, 0010, '2019-06-09 21:27:52', 'ACCEPTED');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_05_19_091454_c_roles_tb', 1),
(2, '2019_05_19_091900_c_alignments_tb', 1),
(3, '2019_05_19_092405_c_canceltypes_tb', 1),
(4, '2019_05_19_093425_c_convocations_tb', 1),
(5, '2019_05_19_094016_c_conresponse_tb', 1),
(6, '2019_05_19_094248_c_teamstb', 1),
(7, '2019_05_19_094453_c_teammembers_tb', 1),
(8, '2019_05_19_094811_c_trainingtypes_tb', 1),
(9, '2019_05_22_215532_create_team_members_table', 2),
(10, '2019_05_28_214837_add_timestamps_to_teams', 3),
(11, '2019_05_29_215517_create_table_teams', 4);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_des` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `role_des`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'System ADMIN', NULL, NULL),
(2, 'Regular User', '', NULL, NULL),
(3, 'Captain', '', NULL, NULL),
(4, 'Chief of Section', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_desc` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_capt_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `team_name`, `team_desc`, `team_capt_id`, `created_at`, `updated_at`) VALUES
(1, 'Test Team G4', 'Test Team G4', 9, '2019-04-30 22:00:00', '2019-06-10 14:01:46'),
(2, 'DEBUG', 'DEBUG-Debug--', 8, NULL, '2019-06-10 14:23:24');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tm_team_id` int(11) NOT NULL,
  `tm_user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `tm_team_id`, `tm_user_id`, `created_at`, `updated_at`) VALUES
(23, 1, 12, '2019-06-10 13:48:06', '2019-06-10 13:48:06'),
(24, 1, 13, '2019-06-10 13:48:08', '2019-06-10 13:48:08'),
(25, 1, 14, '2019-06-10 13:48:10', '2019-06-10 13:48:10'),
(26, 1, 15, '2019-06-10 13:48:12', '2019-06-10 13:48:12'),
(27, 1, 16, '2019-06-10 13:48:14', '2019-06-10 13:48:14'),
(28, 1, 17, '2019-06-10 13:48:16', '2019-06-10 13:48:16'),
(29, 1, 18, '2019-06-10 13:48:19', '2019-06-10 13:48:19'),
(30, 1, 19, '2019-06-10 13:48:21', '2019-06-10 13:48:21'),
(33, 1, 9, '2019-06-10 13:55:55', '2019-06-10 13:55:55'),
(34, 1, 10, '2019-06-10 13:56:02', '2019-06-10 13:56:02'),
(35, 2, 8, '2019-06-10 14:23:37', '2019-06-10 14:23:37'),
(36, 2, 10, '2019-06-10 14:23:44', '2019-06-10 14:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `training__types`
--

CREATE TABLE `training__types` (
  `TT_ID` int(11) NOT NULL,
  `TT_NAME` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `training__types`
--

INSERT INTO `training__types` (`TT_ID`, `TT_NAME`) VALUES
(1, 'Cardio.'),
(2, 'Fuerza.'),
(3, 'Prep. Regata.'),
(4, 'Regata.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_chat_id` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `user_chat_id`, `password`, `user_role_id`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Test User', 'test@test.com', 0, '$2y$10$LXdOq8npLQYkGXxZO7Pc1urNK5X/ap99TnhBMM2xh2LHaZ0ReTqWK', 1, 1, NULL, '2019-05-25 12:18:35', '2019-06-16 08:57:51'),
(3, 'Test User2', 'test2@test.com', 0000, '$2y$10$RWpodXsDW1mV.XhhHg22tuWIwd8hucjikZlgZXtHfOoUtc322Qqxq', 3, 1, NULL, '2019-05-29 21:18:08', '2019-06-12 17:29:21'),
(4, 'Lorenzo', 'Lorenzo@test.com', 0000, '$2y$10$LTHrArhULhso5mD0bvgOfuYAlhuFq4G0fibjHUyOpMldIDOD3ks06', 1, 1, NULL, '2019-05-30 15:56:24', '2019-06-10 13:22:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alignments`
--
ALTER TABLE `alignments`
  ADD PRIMARY KEY (`AL_ID`);

--
-- Indexes for table `bot__users`
--
ALTER TABLE `bot__users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cancel__types`
--
ALTER TABLE `cancel__types`
  ADD PRIMARY KEY (`CT_ID`);

--
-- Indexes for table `convocations`
--
ALTER TABLE `convocations`
  ADD PRIMARY KEY (`CON_ID`);

--
-- Indexes for table `con__responses`
--
ALTER TABLE `con__responses`
  ADD PRIMARY KEY (`CR_ID`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training__types`
--
ALTER TABLE `training__types`
  ADD PRIMARY KEY (`TT_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alignments`
--
ALTER TABLE `alignments`
  MODIFY `AL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `bot__users`
--
ALTER TABLE `bot__users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `cancel__types`
--
ALTER TABLE `cancel__types`
  MODIFY `CT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `convocations`
--
ALTER TABLE `convocations`
  MODIFY `CON_ID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2857;
--
-- AUTO_INCREMENT for table `con__responses`
--
ALTER TABLE `con__responses`
  MODIFY `CR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `training__types`
--
ALTER TABLE `training__types`
  MODIFY `TT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
