-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2016 at 02:28 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `discoverycrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `acres_api_credentials`
--

CREATE TABLE `acres_api_credentials` (
  `id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `acres_username` varchar(50) NOT NULL,
  `acres_pswd` varchar(50) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acres_api_credentials`
--

INSERT INTO `acres_api_credentials` (`id`, `source_id`, `acres_username`, `acres_pswd`, `comp_id`, `last_updated_by`) VALUES
(1, 2, 'urban@111', '0lq0Q5nE7J', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `assigned_lead`
--

CREATE TABLE `assigned_lead` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_date` datetime NOT NULL,
  `is_reassigned` int(1) NOT NULL DEFAULT '0',
  `comp_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assigned_lead`
--

INSERT INTO `assigned_lead` (`id`, `lead_id`, `assigned_to`, `assigned_by`, `assigned_date`, `is_reassigned`, `comp_id`, `is_active`) VALUES
(1, 243, 2, 0, '2016-01-20 18:15:12', 3, 1, 1),
(2, 244, 2, 0, '2016-01-20 18:15:12', 0, 1, 1),
(3, 245, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(4, 246, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(5, 247, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(6, 248, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(7, 249, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(8, 250, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(9, 251, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(10, 252, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(11, 253, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(12, 254, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(13, 255, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(14, 256, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(15, 257, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(16, 258, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(17, 259, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(18, 260, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(19, 261, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(20, 262, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(21, 263, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(22, 264, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(23, 265, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(24, 266, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(25, 267, 2, 0, '2016-01-20 18:15:13', 0, 1, 1),
(26, 268, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(27, 269, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(28, 270, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(29, 271, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(30, 272, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(31, 273, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(32, 274, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(33, 275, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(34, 276, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(35, 277, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(36, 278, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(37, 279, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(38, 280, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(39, 281, 2, 0, '2016-01-20 18:15:14', 0, 1, 1),
(40, 153, 7, 2, '2016-01-29 15:36:21', 0, 1, 1),
(41, 154, 7, 2, '2016-01-29 15:36:21', 0, 1, 1),
(42, 158, 7, 2, '2016-01-29 15:36:21', 0, 1, 1),
(43, 159, 7, 2, '2016-01-29 15:36:21', 0, 1, 1),
(44, 160, 7, 2, '2016-01-29 15:36:21', 0, 1, 1),
(45, 161, 1, 2, '2016-01-29 15:42:06', 0, 1, 1),
(46, 162, 1, 2, '2016-01-29 15:42:06', 0, 1, 1),
(47, 163, 1, 2, '2016-01-29 15:42:06', 0, 1, 1),
(48, 132, 2, 2, '2016-01-29 17:01:26', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `auto_assign_source_user`
--

CREATE TABLE `auto_assign_source_user` (
  `id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `assign_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auto_assign_source_user`
--

INSERT INTO `auto_assign_source_user` (`id`, `source_id`, `user_id`, `comp_id`, `assign_date`) VALUES
(2, 2, 6, 1, '2016-01-21'),
(4, 1, 2, 1, '2016-01-21'),
(5, 3, 7, 1, '2016-01-21');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `company_logo` varchar(100) NOT NULL,
  `company_token` varchar(50) NOT NULL,
  `is_active` int(1) NOT NULL,
  `is_delete` int(1) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `company_logo`, `company_token`, `is_active`, `is_delete`, `date_created`) VALUES
(1, 'Discovery Solutions', '', '11111111', 1, 0, '2015-10-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `company_rights`
--

CREATE TABLE `company_rights` (
  `id` int(11) NOT NULL,
  `right_name` varchar(50) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `is_delete` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_rights`
--

INSERT INTO `company_rights` (`id`, `right_name`, `comp_id`, `is_active`, `is_delete`) VALUES
(1, 'Punching', 1, 1, 0),
(2, 'Assign Lead', 1, 1, 0),
(3, 'Update Lead Status', 1, 1, 0),
(4, 'Delete', 1, 1, 0),
(5, 'Download Data', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `company_roles`
--

CREATE TABLE `company_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `seniority` int(2) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `is_delete` int(1) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_roles`
--

INSERT INTO `company_roles` (`id`, `role_name`, `comp_id`, `seniority`, `created_by`, `last_updated_by`, `is_active`, `is_delete`, `creation_date`, `last_updated`) VALUES
(1, 'Admin', 1, 1, 2, 2, 1, 0, '2015-10-31 10:14:38', '2015-12-23 15:02:37'),
(13, 'Sub Admin', 1, 2, 2, 2, 1, 0, '2015-12-23 12:59:15', '2015-12-25 11:47:27'),
(14, 'Manager', 1, 3, 2, 2, 1, 0, '2015-12-23 13:09:23', '2015-12-24 14:50:38'),
(15, 'Executive', 1, 4, 2, 2, 1, 0, '2015-12-23 13:09:35', '2015-12-24 13:10:17'),
(16, 'Punching', 1, 5, 2, 2, 1, 0, '2016-01-14 00:00:00', '2016-01-14 18:41:49');

-- --------------------------------------------------------

--
-- Table structure for table `company_role_rights`
--

CREATE TABLE `company_role_rights` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `is_delete` int(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_role_rights`
--

INSERT INTO `company_role_rights` (`id`, `role_id`, `right_id`, `comp_id`, `is_active`, `is_delete`, `created_by`, `last_updated_by`, `creation_date`, `last_updated`) VALUES
(1, 1, 1, 1, 1, 0, 2, 2, '2015-10-31 10:14:38', '2015-12-23 15:02:38'),
(2, 1, 2, 1, 1, 0, 2, 2, '2015-10-31 10:14:38', '2015-12-23 15:02:38'),
(3, 1, 3, 1, 1, 0, 2, 2, '2015-10-31 10:14:38', '2015-12-23 15:02:38'),
(4, 1, 4, 1, 1, 0, 2, 2, '2015-10-31 10:14:38', '2015-12-23 15:02:38'),
(5, 1, 5, 1, 1, 0, 2, 2, '2015-10-31 10:14:38', '2015-12-23 15:02:38'),
(58, 12, 1, 1, 1, 0, 2, 2, '2015-11-23 13:53:02', '2015-11-23 13:53:02'),
(59, 12, 2, 1, 0, 0, 2, 2, '2015-11-23 13:53:02', '2015-11-23 13:53:02'),
(60, 12, 3, 1, 1, 0, 2, 2, '2015-11-23 13:53:02', '2015-11-23 13:53:02'),
(61, 12, 4, 1, 1, 0, 2, 2, '2015-11-23 13:53:02', '2015-11-23 13:53:02'),
(62, 12, 5, 1, 0, 0, 2, 2, '2015-11-23 13:53:03', '2015-11-23 13:53:03'),
(63, 13, 1, 1, 1, 0, 2, 2, '2015-12-23 12:59:15', '2015-12-25 11:47:27'),
(64, 13, 2, 1, 1, 0, 2, 2, '2015-12-23 12:59:15', '2015-12-25 11:47:27'),
(65, 13, 3, 1, 1, 0, 2, 2, '2015-12-23 12:59:15', '2015-12-25 11:47:27'),
(66, 13, 4, 1, 0, 0, 2, 2, '2015-12-23 12:59:15', '2015-12-25 11:47:28'),
(67, 13, 5, 1, 1, 0, 2, 2, '2015-12-23 12:59:15', '2015-12-25 11:47:28'),
(68, 14, 1, 1, 1, 0, 2, 2, '2015-12-23 13:09:23', '2015-12-24 14:50:38'),
(69, 14, 2, 1, 1, 0, 2, 2, '2015-12-23 13:09:23', '2015-12-24 14:50:38'),
(70, 14, 3, 1, 1, 0, 2, 2, '2015-12-23 13:09:23', '2015-12-24 14:50:38'),
(71, 14, 4, 1, 0, 0, 2, 2, '2015-12-23 13:09:23', '2015-12-24 14:50:38'),
(72, 14, 5, 1, 0, 0, 2, 2, '2015-12-23 13:09:23', '2015-12-24 14:50:38'),
(73, 15, 1, 1, 1, 0, 2, 2, '2015-12-23 13:09:35', '2015-12-24 13:10:17'),
(74, 15, 2, 1, 1, 0, 2, 2, '2015-12-23 13:09:35', '2015-12-24 13:10:17'),
(75, 15, 3, 1, 0, 0, 2, 2, '2015-12-23 13:09:35', '2015-12-24 13:10:17'),
(76, 15, 4, 1, 0, 0, 2, 2, '2015-12-23 13:09:35', '2015-12-24 13:10:17'),
(77, 15, 5, 1, 0, 0, 2, 2, '2015-12-23 13:09:35', '2015-12-24 13:10:17'),
(78, 16, 1, 1, 1, 0, 2, 2, '2016-01-14 18:41:49', '2016-01-14 18:41:49'),
(79, 16, 2, 1, 0, 0, 2, 2, '2016-01-14 18:41:49', '2016-01-14 18:41:49'),
(80, 16, 3, 1, 0, 0, 2, 2, '2016-01-14 18:41:49', '2016-01-14 18:41:49'),
(81, 16, 4, 1, 0, 0, 2, 2, '2016-01-14 18:41:49', '2016-01-14 18:41:49'),
(82, 16, 5, 1, 0, 0, 2, 2, '2016-01-14 18:41:49', '2016-01-14 18:41:49');

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE `company_settings` (
  `id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `lead_auto_assign` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_settings`
--

INSERT INTO `company_settings` (`id`, `comp_id`, `lead_auto_assign`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lead_list`
--

CREATE TABLE `lead_list` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `alt_no` varchar(50) NOT NULL,
  `other_no` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `source_of_enquiry` int(11) NOT NULL,
  `budget` int(11) NOT NULL,
  `project_interested` int(11) NOT NULL,
  `requirement` text NOT NULL,
  `punch_date` datetime NOT NULL,
  `is_assigned` int(1) NOT NULL DEFAULT '0',
  `comp_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `is_delete` int(1) NOT NULL,
  `date_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lead_list`
--

INSERT INTO `lead_list` (`id`, `customer_name`, `mobile`, `alt_no`, `other_no`, `email`, `address`, `source_of_enquiry`, `budget`, `project_interested`, `requirement`, `punch_date`, `is_assigned`, `comp_id`, `created_by`, `last_updated_by`, `is_active`, `is_delete`, `date_created`, `last_updated`) VALUES
(1, 'sdfsdfds tttttt', '2147483647', '9911370888', '2000083647', 'arvind@discoverysolutions.in', 'sfsdfd', 3, 52264890, 11, '', '2015-12-15 06:24:00', 1, 1, 2, 2, 1, 0, '2015-11-24 07:36:18', '2015-12-07 12:05:57'),
(2, 'sdfsdfds - 1', '2147483647', '0', '0', 'arvind@discoverysolutions.in', 'sfsdfd', 1, 555555, 1, '', '2015-12-15 06:24:00', 1, 1, 2, 2, 1, 0, '2015-11-24 08:31:17', '2015-11-24 08:31:17'),
(3, 'sdfsdfds - 3', '2147483647', '0', '0', 'arvind@discoverysolutions.inmmmm', 'sfsdfd', 3, 0, 4, 'qqqqqqqqqqqq', '2015-12-15 06:24:00', 1, 1, 2, 2, 1, 0, '2015-11-24 08:31:53', '2015-11-24 11:46:00'),
(4, 'sdfsdfds', '2147483647', '0', '0', 'arvind@discoverysolutions.in', 'sfsdfd', 1, 10000000, 1, '', '2015-12-15 06:24:00', 1, 1, 2, 2, 1, 0, '2015-11-24 08:33:42', '2015-12-09 13:14:25'),
(5, 'kavita', '2147483647', '0', '0', 'kavita@gmail.com', '', 1, 0, 2, '', '2015-12-15 06:24:00', 1, 1, 2, 2, 1, 0, '2015-11-28 07:38:05', '2015-11-28 07:38:05'),
(6, 'lead 1', '2147483647', '0', '0', 'lead1@gmail.com', '', 1, 0, 1, '', '2015-12-15 06:24:00', 1, 1, 2, 2, 1, 0, '2015-12-11 11:27:08', '2015-12-11 11:27:08'),
(7, 'lead 22', '2147480000', '0', '0', 'lead2@gmail.com', '', 2, 0, 5, 'lead 22 requirement field content', '2015-12-15 06:24:00', 0, 1, 2, 2, 1, 1, '2015-12-11 11:27:37', '2015-12-14 16:44:46'),
(8, 'lead 3', '2147483647', '8888888888', '0', 'lead3@gmail.com', '', 4, 0, 2, 'lead 3 requirement field content', '2015-12-15 06:24:00', 0, 1, 2, 2, 1, 1, '2015-12-11 11:28:17', '2015-12-24 11:36:45'),
(9, 'lead 4', '2147483647', '0', '0', 'lead4@gmail.com', '', 3, 0, 4, '', '2015-12-15 06:24:00', 1, 1, 2, 2, 1, 0, '2015-12-11 11:28:50', '2015-12-11 11:28:50'),
(10, 'lead5', '2147483647', '0', '0', 'lead5@gmail.com', '', 2, 0, 2, '', '2015-12-15 06:24:00', 1, 1, 2, 2, 1, 0, '2015-12-11 11:29:56', '2015-12-11 11:30:18'),
(11, 'lead 4', '2147483647', '0', '0', 'lead4@gmail.com', '', 2, 0, 5, 'lead 4 requirement field content', '2015-12-15 06:24:00', 0, 1, 2, 2, 1, 1, '2015-12-14 16:47:03', '2015-12-14 16:47:03'),
(12, 'sdfsdfds---testing', '1111888888', '0', '0', '', '', 3, 777888888, 4, '', '2015-12-15 06:24:00', 1, 1, 2, 2, 1, 0, '2015-12-14 18:26:12', '2015-12-26 16:30:49'),
(13, 'lead-16-dec-1', '2147483647', '2147483647', '0', '', '', 2, 0, 4, '', '0000-00-00 00:00:00', 0, 1, 2, 2, 1, 1, '2015-12-16 15:02:20', '2015-12-16 15:04:06'),
(14, 'ghfghf', '4567898888', '5555555555', '5555555555', '', '', 2, 0, 5, '', '0000-00-00 00:00:00', 0, 1, 2, 2, 1, 1, '2015-12-17 18:57:46', '2015-12-17 18:57:46'),
(15, 'sdfds', '7777788855', '0', '0', '', '', 2, 0, 4, '', '0000-00-00 00:00:00', 0, 1, 2, 2, 1, 1, '2015-12-18 11:18:33', '2015-12-18 11:18:33'),
(16, 'sdf', '8855858585', '0', '0', '', '', 2, 0, 4, '', '0000-00-00 00:00:00', 0, 1, 2, 2, 1, 1, '2015-12-18 11:23:22', '2015-12-18 11:23:22'),
(17, '18-dec-lead-1', '2147480088', '0', '0', '', '', 1, 0, 1, '18-dec-lead-1 dfsdfdsf', '0000-00-00 00:00:00', 0, 1, 2, 2, 1, 1, '2015-12-18 11:25:24', '2015-12-18 16:29:28'),
(18, 'werew', '8888555587', '8888555587', '0', '', '', 2, 0, 4, '', '0000-00-00 00:00:00', 0, 1, 2, 2, 1, 1, '2015-12-18 11:41:28', '2015-12-18 11:41:28'),
(19, '18-dec-lead-2', '4353454354', '2147482222', '2147465566', '', '', 1, 0, 5, '', '0000-00-00 00:00:00', 0, 1, 2, 2, 1, 1, '2015-12-18 16:36:24', '2015-12-18 16:36:24'),
(20, '18-dec-lead-3', '3698521478', '0', '0', '', '', 3, 0, 11, '', '2015-12-18 19:00:53', 0, 1, 2, 2, 1, 1, '2015-12-18 19:00:53', '2015-12-24 11:37:03'),
(21, 'kavita-lead-1', '9898989567', '0', '0', '', '', 3, 0, 11, '', '2015-12-24 13:11:54', 0, 1, 3, 3, 1, 1, '2015-12-24 13:11:54', '2015-12-24 13:11:54'),
(22, 'kavita-lead-2', '5599668874', '0', '0', '', '', 3, 0, 12, '', '2015-12-24 14:44:46', 0, 1, 3, 3, 1, 1, '2015-12-24 14:44:46', '2015-12-24 14:44:46'),
(23, 'kavita-lead-3', '2200550085', '0', '0', '', '', 4, 0, 4, '', '2015-12-24 14:45:28', 0, 1, 3, 3, 1, 1, '2015-12-24 14:45:28', '2015-12-24 14:45:28'),
(24, 'pooja-lead-1', '5566958778', '0', '0', '', '', 2, 0, 4, '', '2015-12-24 14:54:40', 0, 1, 6, 6, 1, 1, '2015-12-24 14:54:40', '2015-12-24 14:54:40'),
(25, 'pooja-lead-2', '2255889966', '0', '0', '', '', 3, 0, 4, '', '2015-12-24 14:55:23', 0, 1, 6, 6, 1, 1, '2015-12-24 14:55:23', '2015-12-24 14:55:23'),
(26, 'pooja-lead-3', '7885566998', '0', '0', '', '', 2, 0, 11, '', '2015-12-24 14:56:39', 0, 1, 6, 6, 1, 1, '2015-12-24 14:56:39', '2015-12-24 14:56:39'),
(27, '26-dec-lead-1', '8995577669', '0', '0', '', '', 3, 0, 4, '', '2015-12-26 12:33:57', 1, 1, 2, 2, 1, 0, '2015-12-26 12:33:57', '2015-12-26 12:33:57'),
(28, '28-dec-lead-1', '0', '0', '0', '', '', 2, 0, 2, '', '2015-12-28 11:51:53', 1, 1, 2, 2, 1, 0, '2015-12-28 11:51:53', '2015-12-28 15:31:28'),
(29, '28-dec-lead-2', '0', '0', '0', '', '', 3, 0, 4, '', '2015-12-28 12:04:12', 1, 1, 2, 2, 1, 0, '2015-12-28 12:04:12', '2015-12-28 15:33:18'),
(30, '28-dec-lead-3---', '0', '0', '0', '', '', 3, 0, 4, '', '2015-12-28 18:51:44', 1, 1, 2, 2, 1, 0, '2015-12-28 18:51:44', '2015-12-30 19:05:48'),
(31, '30-dec-lead-1----', '0', '0', '0', '', '', 2, 0, 2, 'this is some dummy text', '2015-12-30 11:07:20', 0, 1, 2, 2, 1, 0, '2015-12-30 11:07:20', '2015-12-30 19:05:24'),
(124, 'Arun', 'OTI1MDc1NjM1MA==', '', '', 'aksaini50@yahoo.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida I am interested in your Project. I am looking for 1, 2, 3, 4 BHK in Budget range -15.87 Lacs to 1.28 Cr.', '2016-01-07 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-07 16:03:44', '2016-01-07 16:03:44'),
(125, 'ND Haswani', 'OTkxMTM3MDA0NA==', '', '', 'ndhaswani@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida I am interested in your Project. I am looking for 1, 2, 3, 4 BHK in Budget range -15.87 Lacs to 1.28 Cr.Time Line to buy -Within 3 months.  Site visit -More than a week.', '2016-01-07 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-07 16:03:44', '2016-01-07 16:03:44'),
(126, 'Prawal Pratap Singh', 'MDk2MTA1MjY2OTU=', '', '', 'prawalpratapsingh12335@gmail.com', '', 1, 0, 0, 'Supertech Sports Village, Greater Noida - I am interested in your project. Please contact me.', '2016-01-07 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-07 16:03:44', '2016-01-07 16:03:44'),
(127, 'Kabir Satpathy', 'OTcxMTE1MzMwMA==', '', '', 'kabirsatpathy@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida I am interested in your Project. I am looking for 1, 2, 3, 4 BHK in Budget range -15.87 Lacs to 1.28 Cr.Time Line to buy -Within 3 months.  Site visit -Require more details from Builder site.', '2016-01-07 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-07 16:03:44', '2016-01-07 16:03:44'),
(128, 'Arindam Bhattacharjee', 'ODgyNjI1NDc3Nw==', '', '', 'arindam.86@hotmail.com', '', 1, 0, 0, 'Paramount floraville, Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -53.30 Lacs to 85.94 Lacs.Time Line to buy -Within 3 months.  Site visit -Require more details from Builder site.', '2016-01-07 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-07 16:03:44', '2016-01-07 16:03:44'),
(129, 'Meenakshi', 'OTcxMTMwODk2Mw==', '', '', 'meenakshi.pandey36@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida I am interested in your Project. I am looking for 1, 2, 3, 4 BHK in Budget range -15.87 Lacs to 1.28 Cr.Time Line to buy -Within 3 months.  Site visit -Require more details from Builder site.', '2016-01-07 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-07 16:03:44', '2016-01-07 16:03:44'),
(130, 'Ranjeet Kumar', 'OTk5OTc0Mzc3MQ==', '', '', 'ranjeetsaini93@gmail.com', '', 1, 0, 0, 'This user is looking for 1 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-07 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-07 16:03:44', '2016-01-07 16:03:44'),
(131, 'OBAIDULLAH FAIZ', 'OTkxMTQ5OTE3Mw==', '', '', 'obaidullahfaiz@ymail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida I am interested in your Project. I am looking for 1, 2, 3, 4 BHK in Budget range -15.87 Lacs to 1.28 Cr.Time Line to buy -Immediately.  Site visit -Require more details from Builder site.', '2016-01-07 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-07 16:03:44', '2016-01-07 16:03:44'),
(132, 'Ashish', 'OTQyNjYxMzU2OQ==', '', '', 'ashishbhugg1@gmail.com', '', 1, 0, 1, 'Paramount floraville, Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -53.30 Lacs to 85.94 Lacs.Time Line to buy -Within 3 months.  Site visit -Require more details from Builder site.', '2016-01-07 00:00:00', 1, 1, 1, 2, 1, 0, '2016-01-07 16:03:44', '2016-01-29 17:00:56'),
(133, 'Kuldip Yadav', 'OTkxMTY3MTIyMA==', '', '', 'kuldip045@gmail.com', '', 1, 0, 1, 'Paramount Golf Foreste, Greater Noida I am interested in your Project. I am looking for 1, 2, 3, 4 BHK in Budget range -15.87 Lacs to 1.28 Cr.Time Line to buy -Within 3 months.  Site visit -Require more details from Builder site.', '2016-01-07 00:00:00', 0, 1, 1, 2, 1, 0, '2016-01-07 16:03:45', '2016-01-29 17:01:06'),
(134, 'Rishabh', 'OTE2ODM1Nzk3NQ==', '', '', 'temptirishabh@gmail.com', '', 1, 0, 0, 'Paramount Emotions, Noida - I am interested in your property. Please contact me. Additional Details - Multistorey Apartment', '2016-01-07 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(135, 'Tripathi', 'OTkxMDI2MjExNQ==', '', '', 'tripathi1117@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-06 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(136, 'Ranjeet Kumar ', 'OTU5OTQ4Nzk4MA==', '', '', 'mahendradpr7@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-06 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(137, 'Arun', 'OTg3MTQxNDQ4Mw==', '', '', 'sehgal_arun1@yahoo.com', '', 1, 0, 0, 'Paramount floraville, Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -53.30 Lacs to 85.94 Lacs.Time Line to buy -Within 3 months.  Site visit -Require more details from Builder site.', '2016-01-06 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(138, 'A K Sinha', 'ODUyNzQ4MjU1NQ==', '', '', 'toabhishek28@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(139, 'Silky Mahajan', 'OTU1NTMwOTM2Mw==', '', '', 'silkymahajan12@gmail.com', '', 1, 0, 0, 'Paramount floraville, Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -53.30 Lacs to 85.94 Lacs.Time Line to buy -Within 1 month.  Site visit -With in a week.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(140, 'Sameer', 'OTU1NTY1OTk2Ng==', '', '', 'ssameer075@gmail.com', '', 1, 0, 0, 'This user is looking for 1 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(141, 'Himan Ghosh', 'OTY0MzgxNTc4OQ==', '', '', 'himan.ghosh@gmail.com', '', 1, 0, 0, 'This user is looking for 3 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(142, 'Sat Bhshan Gupta', 'OTg3MjQyMjAzMA==', '', '', 'sbgupta345@gmail.com', '', 1, 0, 0, 'This user is looking for 3 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(143, 'Shashank Patel', 'OTY1MDIzNDg2OQ==', '', '', 'patelshashank777@gmail.com', '', 1, 0, 0, 'This user is looking for 3 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(144, 'RAJEEV SHARMA', 'ODEzMDE5MDQ2MA==', '', '', 'fresher2009@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Zeta 1, Greater Noida and has viewed your contact details.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(145, 'Sunil Jha', 'OTgxMDkzMDMwNQ==', '', '', 'sjha03@gmail.com', '', 1, 0, 0, 'Paramount floraville, Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -53.30 Lacs to 85.94 Lacs.Time Line to buy -Within 3 months.  Site visit -Require more details from Builder site.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(146, 'Shinto Kallattu', 'OTkxMTkzODg0NA==', '', '', 'shintokallattu@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(147, 'Archina Kaul', 'OTk3MTA2NzUyMA==', '', '', 'archinaraina@gmail.com', '', 1, 0, 0, 'I am looking for agent/broker dealing in  Galaxy Vega, Noida. Looking for 2,3 BHK(S) Multistorey Apartment Sale . Please get in touch with me.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(148, 'Sachin', 'OTcxMTk4OTc0NA==', '', '', 'sachin.amityit06@gmail.com', '', 1, 0, 0, 'Paramount floraville, Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -53.30 Lacs to 85.94 Lacs.Time Line to buy -Within 3 months.  Site visit -With in a week.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(149, 'Rahul', 'OTcxNjM3NjQwMw==', '', '', 'anuradhaloverahul@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida I am interested in your Project. I am looking for 1, 2, 3, 4 BHK in Budget range -15.87 Lacs to 1.28 Cr.Time Line to buy -Within 3 months.  Site visit -With in a week.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(150, 'Nupoor Jha', 'MDkzNTA3NTg2NTY=', '', '', 'nupoorjha7@gmail.com', '', 1, 0, 0, 'I am looking for agent/broker dealing in  Paramount Emotions, Noida. Looking for 2,3 BHK(S) Villa Sale . Please get in touch with me.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:45', '2016-01-07 16:03:45'),
(151, 'Asis', 'NzA3NzU0MDgyNQ==', '', '', 'ashishgnex6@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Greater Noida and has viewed your contact details.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:46', '2016-01-07 16:03:46'),
(152, 'Rahul', 'OTkxNTA4NTQ3MQ==', '', '', 'rahulkhatri70@gmail.com', '', 1, 0, 0, 'This user is looking for 1 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-06 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-07 16:03:46', '2016-01-07 16:03:46'),
(153, 'Amitesh', 'KzkxLTk5NTgxMDIxOTY=', '', '', 'amitesh.purwar05@gmail.com', '', 2, 0, 0, '2BHK Residential Apartment Ajnara Ambrosia Sector-118 Noida', '2016-01-05 23:23:49', 1, 1, 1, 1, 1, 0, '2016-01-07 17:16:10', '2016-01-07 17:16:10'),
(154, 'Sanghi', 'KzkxLTcyMDc4MTc3MzY=', '', '', 'dimpal1974@gmail.com', '', 2, 0, 0, 'Rs. 68 Lac, 2 Bed, Apartment for Sale in 3C Lotus Panache, Sector-110 Noida ', '2016-01-05 18:45:37', 1, 1, 1, 1, 1, 0, '2016-01-07 17:16:11', '2016-01-07 17:16:11'),
(155, 'Tirthraj Yadav', 'KzkxLTk5MzA2MDQwNjc=', '', '', 'crystalultrasonics@gmail.com', '', 2, 0, 0, '2BHK Residential Apartment Patel Neotown Greater Noida West', '2016-01-05 16:47:53', 1, 1, 1, 1, 1, 0, '2016-01-07 17:16:11', '2016-01-07 17:16:11'),
(156, 'Nitin Bansal', 'KzkxLTk5OTkwMDk4ODY=', '', '', 'bansal.knitin@gmail.com', '', 2, 0, 0, 'Rs. 1.05 Crore, 3 Bed, Apartment for Sale in ATS Advantage, Indirapuram,Ghaziabad ', '2016-01-05 16:31:20', 1, 1, 1, 1, 1, 0, '2016-01-07 17:16:11', '2016-01-07 17:16:11'),
(157, 'Mohan Lal Chopra', 'KzkxLTk4NjgxODQzMjQ=', '', '', 'mohanlalchopra6@gmail.com', '', 2, 0, 0, 'Rs. 40.43 Lac, 3 Bed, Apartment for Sale in Noida Extension ', '2016-01-05 18:32:53', 1, 1, 1, 1, 1, 0, '2016-01-07 17:16:11', '2016-01-07 17:16:11'),
(158, 'Navin Pandey', 'KzkxLTg4MDA5NzU3NzI=', '', '', 'belpatram@gmail.com', '', 2, 0, 0, 'Rs. 1.09 Crore, 3 Bed, Apartment for Sale in Ajnara Daffodil, Sector-137 Noida ', '2016-01-05 16:44:22', 1, 1, 1, 1, 1, 0, '2016-01-07 17:16:11', '2016-01-07 17:16:11'),
(159, 'Jai', 'KzkxLTg0NzE5ODE1MDE=', '', '', 'jaibahuguna1111@gmail.com', '', 2, 0, 0, 'Agent/Dealer Profile', '2016-01-05 15:57:20', 1, 1, 1, 1, 1, 0, '2016-01-07 17:16:11', '2016-01-07 17:16:11'),
(160, 'Arshad', 'KzkxLTk4OTE0Nzc3MDE=', '', '', 'arshad.indiarise@gmail.com', '', 2, 0, 0, 'Rs. 1.25 Crore, 4 Bed, Apartment for Sale in Ajnara Grand Heritage, Sector-74 Noida ', '2016-01-05 12:48:49', 1, 1, 1, 1, 1, 0, '2016-01-07 17:16:11', '2016-01-07 17:16:11'),
(161, 'Tes', 'KzkxLTk4NzY1NDMyMTA=', '', '', 'test@gmail.com', '', 2, 0, 0, ' Gaur City Greater Noida West', '2016-01-07 23:00:30', 1, 1, 1, 1, 1, 0, '2016-01-08 11:08:59', '2016-01-08 11:08:59'),
(162, 'Rajesh Saini', 'KzkxLTg4MDA0NTUyMzM=', '', '', 'rajesh.16may@gmail.com', '', 2, 0, 0, '2BHK Residential Apartment Sam Palm Olympia Noida Extension', '2016-01-07 16:34:47', 1, 1, 1, 1, 1, 0, '2016-01-08 11:08:59', '2016-01-08 11:08:59'),
(163, 'Pallavi', 'KzkxLTk4NzMyNDQ3NjA=', '', '', 'pallavi.sitm@gmail.com', '', 2, 0, 0, '2BHK Residential Apartment Gaur City Greater Noida West', '2016-01-07 13:51:42', 1, 1, 1, 1, 1, 0, '2016-01-08 11:08:59', '2016-01-08 11:08:59'),
(164, 'Avaneesh', 'KzkxLTk3OTIzNjMyMTk=', '', '', 'mayank.ims@gmail.com', '', 2, 0, 0, '3BHK Residential Apartment Ajnara Ambrosia Sector-118 Noida', '2016-01-07 11:33:12', 0, 1, 1, 1, 1, 0, '2016-01-08 11:08:59', '2016-01-08 11:08:59'),
(165, 'Ankita Deshpande', 'KzkxLTk2NDMxNDE4NDk=', '', '', 'ankita.dpande@gmail.com', '', 2, 0, 0, ' Ajnara Ambrosia Sector-118 Noida', '2016-01-07 10:44:03', 0, 1, 1, 1, 1, 0, '2016-01-08 11:08:59', '2016-01-08 11:08:59'),
(166, 'Asfasfasf', 'KzkxLTM0NTIzNTMyNTMyNTM=', '', '', 'fasfas@fasf.com', '', 2, 0, 0, '2BHK Residential Apartment Ajnara Ambrosia Sector-118 Noida', '2016-01-07 11:20:02', 0, 1, 1, 1, 1, 0, '2016-01-08 11:08:59', '2016-01-08 11:08:59'),
(167, 'Gs Mishra', 'OTAxNTQyNjM0Mg==', '', '', 'mishragsm@gmail.com', '', 1, 0, 0, 'Rudra Aqua Casa, Greater Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -33.00 Lacs to 45.00 Lacs.Time Line to buy -Within 1 month.  Site visit -More than a week.', '2016-01-11 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:13', '2016-01-11 18:19:13'),
(168, 'Pranay', 'OTY1MDIzMzE2Ng==', '', '', 'pranayraj98@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-11 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:13', '2016-01-11 18:19:13'),
(169, 'Zaheer', 'MDk3MTg1NzA0OTU=', '', '', 'zaheer.304@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-11 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:13', '2016-01-11 18:19:13'),
(170, 'Sanjeev', 'OTg5OTQzMDA1MA==', '', '', 'sksk.shakti@gmail.com', '', 1, 0, 0, 'This user is looking for 1 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-11 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:13', '2016-01-11 18:19:13'),
(171, 'Larieb Ahmed', 'ODQzNTk4NDk2OA==', '', '', 'ahmedlarieb@gmail.com', '', 1, 0, 0, 'This user is looking for 3 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-11 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:13', '2016-01-11 18:19:13'),
(172, 'Swamy', 'OTg2ODM5OTU3Ng==', '', '', 'swamysnswamy10@gmail.com', '', 1, 0, 0, 'This user is looking for 3 BHK Multistorey Apartment for Sale in Sector 137, Noida and has viewed your contact details.', '2016-01-11 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:13', '2016-01-11 18:19:13'),
(173, 'Ravi Sharma', 'OTMzMDA4ODQ5NA==', '', '', 'shraddhavansh15@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Greater Noida and has viewed your contact details.', '2016-01-10 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:13', '2016-01-11 18:19:13'),
(174, 'Mohit', 'ODgyNjk2Mzk5OQ==', '', '', 'mverma.gipl@ymail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Sector 137, Noida and has viewed your contact details.', '2016-01-10 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:13', '2016-01-11 18:19:13'),
(175, 'Rima Tiwari', 'OTgxMDI0ODQ0NQ==', '', '', 'rimakumaripandey@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida - I am interested in your property. Please contact me. Additional Details - Multistorey Apartment, Villa, Studio Apartment', '2016-01-10 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:13', '2016-01-11 18:19:13'),
(176, 'Sahib Singh', 'ODUyNzQ5MTIxMg==', '', '', 'sahibsinghnbcc@gmail.com', '', 1, 0, 0, 'This user is looking for 3 BHK Multistorey Apartment for Sale in Greater Noida West, Greater Noida and has viewed your contact details.', '2016-01-10 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:13', '2016-01-11 18:19:13'),
(177, 'Shivraj', 'OTcxMTkxMzY5Mg==', '', '', 'shivrajchoudhary2000@gmail.com', '', 1, 0, 0, 'This user is looking for 3 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-10 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:14', '2016-01-11 18:19:14'),
(178, 'Rajesh', 'OTgxMTQ1NTUzMA==', '', '', 'geet05523@gmail.com', '', 1, 0, 0, 'This user is looking for 1 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-10 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:14', '2016-01-11 18:19:14'),
(179, 'Ashish Shukla', 'KzkxLTk3MTk1Mzg4MDg=', '', '', 'ashishshukla4590@gmail.com', '', 2, 0, 0, ' Ajnara Ambrosia Sector-118 Noida', '2016-01-10 23:30:01', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(180, 'Ayush Anand', 'KzkxLTc4Mzg4NTY1OTU=', '', '', 'ayushanand2021@gmail.com', '', 2, 0, 0, '2BHK Residential Apartment Gaur City Greater Noida West', '2016-01-10 18:55:43', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(181, 'Nikhil Sharma', 'KzkxLTcwNDIxOTkyNzg=', '', '', 'nikhil.sharma@finlace.com', '', 2, 0, 0, 'Rs. 52.67 Lac, 2 Bed, Apartment for Sale in Ajnara Grand Heritage, Sector-74 Noida ', '2016-01-10 17:55:10', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(182, 'Vishwa', 'KzkxLTc4Mjc0MTM3NzU=', '', '', 'vishwabhushanrao@gmail.com', '', 2, 0, 0, '3BHK Residential Apartment Ajnara Ambrosia Sector-118 Noida', '2016-01-10 17:02:30', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(183, 'Sachin', 'KzkxLTk4OTkwNTY1MTI=', '', '', 'kumar.sachin.sachin@gmail.com', '', 2, 0, 0, ' Ajnara Sports City Greater Noida West', '2016-01-10 14:58:31', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(184, 'Siddharth', 'KzkxLTg4NjAwNjgyNDg=', '', '', 'siddsingh47@gmail.com', '', 2, 0, 0, '2BHK Residential Apartment Patel Neotown Greater Noida West', '2016-01-10 14:42:12', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(185, 'Abhishek', 'KzkxLTk2NTQ3ODczODM=', '', '', 'aabhishekk2020@gmail.com', '', 2, 0, 0, '2BHK Residential Apartment Patel Neotown Greater Noida West', '2016-01-10 12:33:49', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(186, 'Sachin', 'KzkxLTk4MTE4MTA3Nzg=', '', '', 'indersachinverma@gmail.com', '', 2, 0, 0, 'Rs. 1.05 Crore, 3 Bed, Apartment for Sale in ATS Advantage, Indirapuram,Ghaziabad ', '2016-01-10 12:06:58', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(187, 'Parteek Kaushik', 'KzkxLTk3MTg5MzU1MDE=', '', '', 'pratik_kuk@rediffmail.com', '', 2, 0, 0, 'Rs. 43.71 Lac, 2 Bed, Apartment for Sale in Supertech Cape Town, Sector-74 Noida ', '2016-01-10 11:10:46', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(188, 'Sunny', 'KzkxLTk3OTc0NTQ2NTU=', '', '', 'taliyan1@gmail.com', '', 2, 0, 0, ' Ajnara Sports City Greater Noida West', '2016-01-10 11:00:44', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(189, 'Hemant', 'KzkxLTg1MDYwNTY2Njc=', '', '', 'hemantaquarius@gmail.com', '', 2, 0, 0, '2BHK Residential Apartment Patel Neotown Greater Noida West', '2016-01-10 10:55:12', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(190, 'Kirti Arora', 'KzkxLTk5OTA4NTg0NzQ=', '', '', 'kirti.arora0502@gmail.com', '', 2, 0, 0, ' Gaur City Greater Noida West', '2016-01-10 00:55:43', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(191, 'Kapil', 'KzkxLTg1ODg4MDAzNTM=', '', '', 'kapssood@gmail.com', '', 2, 0, 0, 'Rs. 1.05 Crore, 3 Bed, Apartment for Sale in ATS Advantage, Indirapuram,Ghaziabad ', '2016-01-10 18:50:40', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(192, 'Anshula', 'KzkxLTc1MDM3NjA5MTk=', '', '', 'anshulagaur1990@gmail.com', '', 2, 0, 0, 'Rs. 39.83 Lac, 3 Bed, Apartment for Sale in Mahagun Mywoods, Noida Extension ', '2016-01-10 17:19:59', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(193, 'Kamal Sharma', 'KzkxLTc4NDA4NTc5MDA=', '', '', 'kk.sharma7840@gmail.com', '', 2, 0, 0, 'Rs. 52.67 Lac, 2 Bed, Apartment for Sale in Ajnara Grand Heritage, Sector-74 Noida ', '2016-01-10 14:47:11', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:33', '2016-01-11 18:19:33'),
(194, 'Amit', 'KzkxLTg1NTg5NDcyNzI=', '', '', 'amitnauty@gmail.com', '', 2, 0, 0, ' Ajnara Le Garden Greater Noida West', '2016-01-10 10:12:51', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:34', '2016-01-11 18:19:34'),
(195, 'Saket Kumar', 'KzkxLTg4ODI5MTIwOTE=', '', '', 'saket.rocku@gmail.com', '', 2, 0, 0, 'Rs. 39.83 Lac, 3 Bed, Apartment for Sale in Mahagun Mywoods, Noida Extension ', '2016-01-10 02:07:56', 0, 1, 1, 1, 1, 0, '2016-01-11 18:19:34', '2016-01-11 18:19:34'),
(196, 'Shashi Bhushan Sharma', 'MDk1NjAwNzgzODc=', '', '', 'shashi_sharma75@ymail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Greater Noida and has viewed your contact details.', '2016-01-11 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:38', '2016-01-12 10:18:38'),
(197, 'Ashish Gupta', 'OTk5OTAzNjE5MQ==', '', '', 'ashish.gupta17@hotmail.com', '', 1, 0, 0, 'Rudra Aqua Casa, Greater Noida - I am interested in your property. Please contact me. Additional Details - Multistorey Apartment', '2016-01-11 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:38', '2016-01-12 10:18:38'),
(198, 'Anil Singh', 'KzkxLTk4MTg3NTU0NDQ=', '', '', 'sixsense.anil@gmail.com', '', 2, 0, 0, ' Ajnara Ambrosia Sector-118 Noida', '2016-01-11 23:24:07', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:46', '2016-01-12 10:18:46'),
(199, 'Keshav Aggarwal', 'KzkxLTk5MTEzNjg1MDU=', '', '', 'ka8187@gmail.com', '', 2, 0, 0, 'Rs. 45.19 Lac, 3 Bed, Apartment for Sale in Galaxy North Avenue 2, Noida Extension ', '2016-01-11 22:58:08', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:46', '2016-01-12 10:18:46'),
(200, 'J P Tripathi', 'KzkxLTk4NzM5MzMwOTA=', '', '', 'jwalatrips@gmail.com', '', 2, 0, 0, ' Ajnara Sports City Greater Noida West', '2016-01-11 22:10:36', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:46', '2016-01-12 10:18:46'),
(201, 'Chitrangna Saxena', 'KzkxLTkzMzYyNzMyMTI=', '', '', 'ravi.saxena234@gmail.com', '', 2, 0, 0, '2BHK Residential Apartment JM Florence Noida Extension', '2016-01-11 19:29:45', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:46', '2016-01-12 10:18:46'),
(202, 'Naveen', 'KzkxLTk5MTAwOTMxNjI=', '', '', 'utsav.con@gmail.com', '', 2, 0, 0, ' Gaur City Greater Noida West', '2016-01-11 17:49:20', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:46', '2016-01-12 10:18:46'),
(203, 'Avi Kashyap', 'KzkxLTk5MTE2NDU2MjU=', '', '', 'avinashkashyap.ak@gmail.com', '', 2, 0, 0, ' Gaur City Greater Noida West', '2016-01-11 14:00:03', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:46', '2016-01-12 10:18:46'),
(204, 'Vikas', 'KzEtNDA4MjAzNzU4OA==', '', '', 'vikasiitgzb23@gmail.com', '', 2, 0, 0, '2BHK Residential Apartment Gaur City Greater Noida West', '2016-01-11 09:20:40', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:46', '2016-01-12 10:18:46'),
(205, 'Kavinder Singh', 'KzkxLTk5OTAwNTQ0Njg=', '', '', 'ransinghtewatia@rediffmail.com', '', 2, 0, 0, 'Agent/Dealer Profile', '2016-01-11 17:18:05', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:47', '2016-01-12 10:18:47'),
(206, 'Koushik', 'KzkxLTk4MTAwNDQ4NDA=', '', '', 'kaushik81.biswas@gmail.com', '', 2, 0, 0, 'Rs. 40 Lac, 2 Bed, Apartment for Sale in VXL Eastern Heights, Indirapuram,Ghaziabad ', '2016-01-11 13:49:16', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:47', '2016-01-12 10:18:47'),
(207, 'Amit Sharma', 'KzkxLTk5OTA5MDU1NTc=', '', '', 'ak@gmail.com', '', 2, 0, 0, 'Agent/Dealer Profile', '2016-01-11 12:36:06', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:47', '2016-01-12 10:18:47'),
(208, 'Rajesh Soni', 'KzkxLTk4MTA0OTQ2Mjg=', '', '', 'rajeshsoni.dopt@gmail.com', '', 2, 0, 0, 'Rs. 37.46 Lac, 3 Bed, Apartment for Sale in Ajnara Le Garden, Greater Noida West ', '2016-01-11 12:04:11', 0, 1, 1, 1, 1, 0, '2016-01-12 10:18:47', '2016-01-12 10:18:47'),
(209, 'Vikas', 'OTkxMTE1MTc1Mg==', '', '', 'vikascu03@gmail.com', '', 1, 0, 0, 'This user is looking for 3 BHK Multistorey Apartment for Sale in Greater Noida West, Greater Noida and has viewed your contact details.', '2016-01-13 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-13 10:59:16', '2016-01-13 10:59:16'),
(210, 'Ashutosh Singh', 'OTk1ODc0ODc1Nw==', '', '', 'ashutoshsingh.nd11@gmail.com', '', 1, 0, 0, 'This user is looking for 1 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-13 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-13 10:59:16', '2016-01-13 10:59:16'),
(211, 'Pankaj Kumar', 'MDk5OTA2NDA4Nzk=', '', '', 'pankaj.1004@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Greater Noida and has viewed your contact details.', '2016-01-13 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-13 10:59:16', '2016-01-13 10:59:16'),
(212, 'Dilip Kumar Das', 'ODUwNjk5NzI2Mg==', '', '', 'dkdas2@gmail.com', '', 1, 0, 0, 'This user is looking for 4 BHK Villa for Sale in Zeta 1, Greater Noida and has viewed your contact details.', '2016-01-12 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-13 10:59:16', '2016-01-13 10:59:16'),
(213, 'Pradeep', 'OTk5OTg3MDAyNA==', '', '', 'meetashwin85@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-12 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-13 10:59:16', '2016-01-13 10:59:16'),
(214, 'Moolchand', 'OTk5MDI1NTkxMQ==', '', '', 'mcsharma91@gmail.com', '', 1, 0, 0, 'Gaur Saundrayam, Greater Noida I am interested in your Project. I am looking for 3 BHK in Budget range -55.00 Lacs to 85.00 Lacs.Time Line to buy -Immediately.  Site visit -With in a week.', '2016-01-12 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-13 10:59:16', '2016-01-13 10:59:16'),
(215, 'Neeraj', 'OTU5OTMzOTIyNw==', '', '', 'leaseinaday@gmail.com', '', 1, 0, 0, 'Rudra Aqua Casa, Greater Noida - I am interested in your property. Please contact me. Additional Details - Multistorey Apartment', '2016-01-12 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-13 10:59:16', '2016-01-13 10:59:16'),
(216, 'Abhinav', 'OTIwMDc0NDg4OA==', '', '', 'abhinavagnihotri@hotmail.com', '', 1, 0, 0, 'Paramount floraville, Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -53.30 Lacs to 85.94 Lacs.Time Line to buy -Immediately.  Site visit -With in a week.', '2016-01-12 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-13 10:59:16', '2016-01-13 10:59:16'),
(217, 'Nihit', 'OTY1NDc3NjAwNw==', '', '', 'nihit27@gmail.com', '', 1, 0, 0, 'This user is looking for 4 BHK Villa for Sale in Zeta 1, Greater Noida and has viewed your contact details.', '2016-01-12 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-13 10:59:16', '2016-01-13 10:59:16'),
(218, 'Rajesh', 'OTgxMDI0NDUxOQ==', '', '', 'rajesh.30@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida - I am interested in your property. Please contact me. Additional Details - Multistorey Apartment, Villa, Studio Apartment', '2016-01-12 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-13 10:59:16', '2016-01-13 10:59:16'),
(219, 'Debashis   Dey', 'OTU2MDA1NjA3NA==', '', '', 'ddey55@gmail.com', '', 1, 0, 0, 'Paramount floraville, Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -53.30 Lacs to 85.94 Lacs.Time Line to buy -Within 3 months.  Site visit -Require more details from Builder site.', '2016-01-13 00:00:00', 0, 1, 1, 1, 1, 0, '2016-01-13 11:30:41', '2016-01-13 11:30:41'),
(222, 'Aaaaa', 'ODg4ODg=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-15 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:04:16', '2016-01-15 18:04:16'),
(223, 'Aaaaa', 'ODg4ODg=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-15 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:07:30', '2016-01-15 18:07:30'),
(224, 'Aaaaa2', 'OTIwMDc0NDg4OA==', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-16 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:07:30', '2016-01-15 18:07:30'),
(225, 'Aaaaa3', 'ODg4OTA=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-17 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:07:30', '2016-01-15 18:07:30'),
(226, 'Aaaaa4', 'ODg4OTE=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-18 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:07:30', '2016-01-15 18:07:30'),
(227, 'Aaaaa5', 'ODg4OTI=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-19 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:07:30', '2016-01-15 18:07:30'),
(228, 'Aaaaa6', 'ODg4OTM=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-20 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:07:30', '2016-01-15 18:07:30'),
(229, 'Aaaaa7', 'ODg4OTQ=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-21 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:07:30', '2016-01-15 18:07:30'),
(230, 'Aaaaa5', 'ODg4OTQx', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-19 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:10:57', '2016-01-15 18:10:57'),
(231, 'Aaaaa6', 'ODg2ODkx', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-20 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:10:57', '2016-01-15 18:10:57'),
(232, 'Aaaaa7', 'ODkwODg5MQ==', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-21 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:10:57', '2016-01-15 18:10:57'),
(233, 'Aaaaa4', 'NTU4ODg5MQ==', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-18 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:12:23', '2016-01-15 18:12:23'),
(234, 'Aaaaa5', 'NTU4ODg5NDE=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-19 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:12:23', '2016-01-15 18:12:23'),
(235, 'Aaaaa6', 'NTU1ODg2ODkx', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-20 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:12:23', '2016-01-15 18:12:23'),
(236, 'Aaaaa7', 'NjY2NDQ0NA==', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-21 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:12:23', '2016-01-15 18:12:23'),
(237, 'Aaaaa2', 'OTIwNDA3NDQ4ODg=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-16 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:22:12', '2016-01-15 18:22:12'),
(238, 'Aaaaa3', 'OTIwMDc0NjQ4ODg=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-17 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:22:12', '2016-01-15 18:22:12'),
(239, 'Aaaaa4', 'OTIwMDg3NDQ4ODg=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-18 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:22:12', '2016-01-15 18:22:12'),
(240, 'Aaaaa5', 'OTIwMDA3NDQ4ODg=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-19 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:22:12', '2016-01-15 18:22:12'),
(241, 'Aaaaa6', 'OTIwMDM3NDQ4ODg=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-20 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:22:12', '2016-01-15 18:22:12'),
(242, 'Aaaaa7', 'OTIwODA3NDQ4ODg=', '', '', 'hhhhh', '', 3, 0, 0, 'hkhkjhkjh', '2016-01-21 00:00:00', 0, 1, 2, 2, 1, 0, '2016-01-15 18:22:12', '2016-01-15 18:22:12'),
(243, 'Prateek', 'OTcxMTEyNTMwMQ==', '', '', 'prateekmanit17@gmail.com', '', 1, 0, 0, 'Paramount floraville, Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -53.30 Lacs to 85.94 Lacs.Time Line to buy -Within 3 months.  Site visit -More than a week.', '2016-01-18 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:13', '2016-01-18 16:46:13'),
(244, 'Gaurav Bajpai', 'OTg3MzcyMjcxNA==', '', '', 'gauravbajp@gmail.com', '', 1, 0, 0, 'Paramount floraville, Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -53.30 Lacs to 85.94 Lacs.Time Line to buy -Within 1 month.  Site visit -With in a week.', '2016-01-18 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:13', '2016-01-18 16:46:13'),
(245, 'Aarushi', 'OTgxODE2MDk3OQ==', '', '', 'aarushi.pavitram@gmail.com', '', 1, 0, 0, 'Rudra Aqua Casa, Greater Noida - I am interested in your property. Please contact me. Additional Details - Multistorey Apartment', '2016-01-18 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:13', '2016-01-18 16:46:13'),
(246, 'MagicBricks User', 'MDk4NzE3MzYyMjA=', '', '', 'akhileshsrivastav17@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida - Paramount Golf Foreste , Greater Noida I am interested in your Project. I am looking for 1, 2, 3, 4  BHK.  Timeline_to_Buy  3months | Site_Visit:- Require more details from Builder |Additional Details  1800000 Additional Details -', '2016-01-18 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:13', '2016-01-18 16:46:13'),
(247, 'Ravindra Singh', 'MDk5MTAwMDc4Mjk=', '', '', 'redniverhgnis61@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida - Paramount Golf Foreste , Greater Noida I am interested in your Project. I am looking for 1, 2, 3, 4  BHK.  Timeline_to_Buy  3months | Site_Visit:- With in a week |Additional Details  2985400 Additional Details -', '2016-01-18 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:14', '2016-01-18 16:46:14'),
(248, 'Sanjeev', 'MDk4OTk0MzAwNTA=', '', '', 'sksk.shakti@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida - Paramount Golf Foreste , Greater Noida I am interested in your Project. I am looking for 1, 2, 3, 4  BHK.  Timeline_to_Buy  3months | Site_Visit:- Require more details from Builder |Additional Details  1424500 Additional Details -', '2016-01-18 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:14', '2016-01-18 16:46:14'),
(249, 'Rajesh', 'OTk2ODQ2MDE1Mg==', '', '', 'rajeshdl1200@gmail.com', '', 1, 0, 0, 'This user is looking for 1 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-18 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:14', '2016-01-18 16:46:14'),
(250, 'Shirish', 'OTQxNTA0MzIzMw==', '', '', 'prabhaventerprises@gmail.com', '', 1, 0, 0, 'I am looking for agent/broker dealing in  Shri Radha Aqua Gardens, Greater Noida. Looking for 2,3 BHK(S) Multistorey Apartment Sale . Please get in touch with me.', '2016-01-18 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:14', '2016-01-18 16:46:14'),
(251, 'Bidyut Patra', 'NzczNTI1ODI1MA==', '', '', 'patrabidyut06@yahoo.co.in', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Greater Noida and has viewed your contact details.', '2016-01-17 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:14', '2016-01-18 16:46:14'),
(252, 'Ila', 'OTM1MDM5MzM5OQ==', '', '', 'shailie.ila@gmail.com', '', 1, 0, 0, 'Paramount Emotions, Noida - I am interested in your project. Please contact me.', '2016-01-17 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:14', '2016-01-18 16:46:14'),
(253, 'Manish', 'OTcxNzc3NTM3OQ==', '', '', 'manishsaxena77@yahoo.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-17 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:14', '2016-01-18 16:46:14'),
(254, 'Sarbjeet', 'OTQxOTQxMDI2MA==', '', '', 'gillsarbjeet8@gmail.com', '', 1, 0, 0, 'This user is looking for 4 BHK Villa for Sale in Zeta 1, Greater Noida and has viewed your contact details.', '2016-01-17 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:14', '2016-01-18 16:46:14'),
(255, 'Himanshu', 'OTk5OTQzMzY3NA==', '', '', 'himanshu1.chugh@gmail.com', '', 1, 0, 0, 'Rudra Aqua Casa, Greater Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -33.00 Lacs to 45.00 Lacs.Time Line to buy -Within 3 months.  Site visit -With in a week.', '2016-01-17 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:14', '2016-01-18 16:46:14'),
(256, 'Abhishek', 'OTk5OTYxMDk4MQ==', '', '', 'abhishekabc79@gmail.com', '', 1, 0, 0, 'I am looking for agent/broker dealing in  Paramount Golf Foreste, Greater Noida. Looking for 3,4 BHK(S) Villa Sale . Please get in touch with me.', '2016-01-17 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:14', '2016-01-18 16:46:14'),
(257, 'Binoy', 'OTI2NjYyOTkwMw==', '', '', 'binoy26@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida - I am interested in your property. Please contact me. Additional Details - Multistorey Apartment, Villa, Studio Apartment', '2016-01-17 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-18 16:46:14', '2016-01-18 16:46:14'),
(258, 'Sanjay', 'NzA2NTgwMjgyNA==', '', '', 'testuser14321@gmail.com', '', 1, 0, 0, 'Paramount Emotions, Noida - I am Interested. Please call me Additional Details -  City: DelhiNCR', '2016-01-20 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:41', '2016-01-20 16:44:41'),
(259, 'Deepak Kumar', 'OTg5OTg5NzA5Nw==', '', '', 'dev99bhati1989@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida - I am interested in your project. Please contact me.', '2016-01-20 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(260, 'Narendra', 'OTgxODYwMDk2Mg==', '', '', 'narendrasharma88@gmail.com', '', 1, 0, 0, 'Paramount Emotions, Noida - I am Interested. Please call me Additional Details -  City: DelhiNCR', '2016-01-20 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(261, 'Praveen Yadav', 'OTY0MzIwNjkyOA==', '', '', 'punitjournalist@gmail.com', '', 1, 0, 0, 'Paramount Emotions, Noida - I am Interested. Please call me Additional Details -  City: DelhiNCR', '2016-01-20 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(262, 'Suraj', 'ODUwNjAxMjgzOQ==', '', '', 'callmesammy1990@gmail.com', '', 1, 0, 0, 'Paramount Emotions, Noida - I am Interested. Please call me Additional Details -  City: DelhiNCR', '2016-01-20 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(263, 'Ruby Vinayak', 'OTAxNTU0MDEzNw==', '', '', 'rubyvinayak77@gmail.com', '', 1, 0, 0, 'Paramount Emotions, Noida - I am Interested. Please call me Additional Details -  City: DelhiNCR', '2016-01-20 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(264, 'Hasan', 'OTk2ODI1MDIyOQ==', '', '', 'aliya.hasan09@gmail.com', '', 1, 0, 0, 'Paramount floraville, Noida I am interested in your Project. I am looking for 2, 3 BHK in Budget range -53.30 Lacs to 85.94 Lacs.Time Line to buy -Within 1 month.  Site visit -With in a week.  IAdditional Details -C.R. 2.', '2016-01-20 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(265, 'Vipin', 'OTk3MTM2MzczOA==', '', '', 'vm9971363738@gmail.com', '', 1, 0, 0, 'i am  looking for property in Greater Noida for residential property and has viewed your contact details from the company profile.', '2016-01-20 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(266, 'Sunil', 'OTk3MTg5MjgwNQ==', '', '', 'esunil.nagar85@gmail.com', '', 1, 0, 0, 'Shivalik Homes 2, Greater Noida - I am Interested. Please call me Additional Details -  City: DelhiNCR', '2016-01-20 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(267, 'Subham', 'OTcxNzI5MTE3Nw==', '', '', 'p.subham2006@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Greater Noida West, Greater Noida and has viewed your contact details.', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(268, 'Pradeep Sinha', 'MDk4Njg0Mzg4ODg=', '', '', 'pradiprashmi@gmail.com', '', 1, 0, 0, 'Paramount Floraville, Noida - Paramount floraville , Noida I am interested in your Project. I am looking for 2, 3  BHK.  Timeline_to_Buy  3months | Site_Visit:- Require more details from Builder |Additional Details  6131400 Additional Details -', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(269, 'Bhupal', 'MDc4NDAwNTEwNzE=', '', '', 'bhupalsinghrawal@gmail.com', '', 1, 0, 0, 'This user is looking for 2 BHK Multistorey Apartment for Sale in Noida Extension, Greater Noida and has viewed your contact details.', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(270, 'Harish Makhija', 'MDk4MTA2NzY0MjQ=', '', '', 'h.makhija55@gmail.com', '', 1, 0, 0, 'Paramount Floraville, Noida - Paramount floraville , Noida I am interested in your Project. I am looking for 2, 3  BHK.  Timeline_to_Buy  1month | Site_Visit:- With in a week |Additional Details  8800000 Additional Details -', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(271, 'Nutan', 'MDk4NzM5ODYyODU=', '', '', 'nutanlavania@gmail.com', '', 1, 0, 0, 'Paramount Floraville, Noida - Paramount floraville , Noida I am interested in your Project. I am looking for 2, 3  BHK.  Timeline_to_Buy  3months | Site_Visit:- More than a week |Additional Details  4895000 Additional Details -', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(272, 'Pankaj', 'OTgxODk5Mjg4OA==', '', '', 'pankajbel@hotmail.com', '', 1, 0, 0, 'This user is looking for 4 BHK Villa for Sale in Zeta 1, Greater Noida and has viewed your contact details.', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(273, 'Krishnna', 'ODg2MDA3MDI4Mg==', '', '', 'krishnakadipur@gmail.com', '', 1, 0, 0, 'This user is looking for 3 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(274, 'Anubhav', 'MDgzNzU4MjEzNDg=', '', '', 'adolfincu@gmail.com', '', 1, 0, 0, 'Paramount Floraville, Noida - Paramount floraville , Noida I am interested in your Project. I am looking for 2, 3  BHK.  Timeline_to_Buy  3months | Site_Visit:- More than a week |Additional Details  5610000 Additional Details -', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(275, 'Ramdeo Jha', 'OTk1ODUzMzQ1NQ==', '', '', 'ramdeojha782@gmail.com', '', 1, 0, 0, 'Shivalik Homes 2, Greater Noida - I am Interested. Please call me Additional Details -  City: DelhiNCR', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(276, 'Vikash', 'OTk5MDI4OTg4OA==', '', '', 'vikash.gupta@hays.com', '', 1, 0, 0, 'Shivalik Homes 2, Greater Noida - I am Interested. Please call me Additional Details -  City: DelhiNCR', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(277, 'Bikram Singh', 'MDk5MTAxNzY3OTA=', '', '', 'bikram.pathania83@gmail.com', '', 1, 0, 0, 'Paramount Golf Foreste, Greater Noida - Paramount Golf Foreste , Greater Noida I am interested in your Project. I am looking for 1, 2, 3, 4  BHK.  Timeline_to_Buy  1month | Site_Visit:- More than a week |Additional Details  2640000 Additional Details -', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(278, 'Sanjay', 'OTkxMDIxMjIzMQ==', '', '', 'sanjaychaudharyc@gmail.com', '', 1, 0, 0, 'Shivalik Homes 2, Greater Noida - I am Interested. Please call me Additional Details -  City: DelhiNCR', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(279, 'Vibhu', 'MDc3Mjg4ODY5NTU=', '', '', 'vpraks007@gmail.com', '', 1, 0, 0, 'Paramount Floraville, Noida - Paramount floraville , Noida I am interested in your Project. I am looking for 2, 3  BHK.  Timeline_to_Buy  3months | Site_Visit:- Require more details from Builder |Additional Details  6600000 Additional Details -', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:42', '2016-01-20 16:44:42'),
(280, 'Sapna', 'MDkzMTM2ODExMTA=', '', '', 'sap0aryan@gmail.com', '', 1, 0, 0, 'Paramount Floraville, Noida - Paramount floraville , Noida I am interested in your Project. I am looking for 2, 3  BHK.  Timeline_to_Buy  3months | Site_Visit:- Require more details from Builder |Additional Details  6400000 Additional Details -', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:43', '2016-01-20 16:44:43'),
(281, 'S P Bedi', 'OTcxMTE5Mjg2Ng==', '', '', 'spbedi@gmail.com', '', 1, 0, 0, 'This user is looking for 3 BHK Multistorey Apartment for Sale in Noida Extension, Noida and has viewed your contact details.', '2016-01-19 00:00:00', 1, 1, 1, 1, 1, 0, '2016-01-20 16:44:43', '2016-01-20 16:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `magic_brick_credentials`
--

CREATE TABLE `magic_brick_credentials` (
  `id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `magic_brick_key` varchar(100) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `magic_brick_credentials`
--

INSERT INTO `magic_brick_credentials` (`id`, `source_id`, `magic_brick_key`, `comp_id`, `last_updated_by`) VALUES
(1, 1, 'zq7ocOSRvSQ~~~~~~3D', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `otp_codes`
--

CREATE TABLE `otp_codes` (
  `id` int(11) NOT NULL,
  `otp_code` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_used` int(1) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otp_codes`
--

INSERT INTO `otp_codes` (`id`, `otp_code`, `user_id`, `is_used`, `company_id`, `date_created`) VALUES
(1, '888888', 0, 0, 0, '0000-00-00 00:00:00'),
(2, '888888', 0, 0, 0, '0000-00-00 00:00:00'),
(3, '888888', 0, 0, 0, '0000-00-00 00:00:00'),
(4, '888888', 0, 0, 0, '0000-00-00 00:00:00'),
(5, '888888', 0, 0, 0, '0000-00-00 00:00:00'),
(6, '888888', 0, 0, 0, '0000-00-00 00:00:00'),
(7, '888888', 0, 0, 0, '0000-00-00 00:00:00'),
(8, '723666', 0, 0, 0, '0000-00-00 00:00:00'),
(9, '989013', 0, 0, 0, '0000-00-00 00:00:00'),
(10, '201815', 1, 0, 0, '0000-00-00 00:00:00'),
(11, '235681', 1, 0, 0, '2015-10-15 07:18:24'),
(12, '209561', 1, 1, 0, '2015-10-15 07:20:00'),
(13, '549533', 1, 0, 0, '2015-10-15 08:28:49'),
(14, '514733', 1, 0, 0, '2015-10-15 08:28:57'),
(15, '687850', 1, 0, 0, '2015-10-15 08:29:33'),
(16, '384078', 1, 0, 0, '2015-10-15 08:29:54'),
(17, '592736', 1, 0, 0, '2015-10-15 08:30:14'),
(18, '316128', 1, 0, 0, '2015-10-15 08:30:29'),
(19, '751763', 1, 1, 0, '2015-10-15 08:30:51'),
(20, '433984', 1, 0, 0, '2015-10-15 08:49:09'),
(21, '122631', 1, 1, 0, '2015-10-15 08:56:02'),
(22, '156826', 1, 0, 0, '2015-10-15 09:08:47'),
(23, '551730', 1, 0, 0, '2015-10-15 09:16:00'),
(24, '529235', 1, 1, 0, '2015-10-15 09:16:10'),
(25, '512893', 1, 1, 0, '2015-10-16 09:13:20'),
(26, '932296', 2, 0, 0, '2015-10-16 09:50:04'),
(27, '160974', 2, 0, 0, '2015-10-16 09:50:57'),
(28, '616494', 2, 0, 0, '2015-10-16 09:54:07'),
(29, '0', 2, 0, 0, '2015-10-16 12:03:03'),
(30, 'ODE1OD', 2, 0, 0, '2015-10-16 12:06:20'),
(31, 'ODY4Nj', 2, 0, 0, '2015-10-16 12:09:32'),
(32, 'MjA3Mjgx', 2, 1, 0, '2015-10-16 12:12:20'),
(33, 'NzIzNTI5', 2, 1, 0, '2015-10-16 12:32:14'),
(34, 'NDI4MDI0', 2, 0, 0, '2015-10-16 12:36:29'),
(35, 'ODgyNzc1', 2, 0, 0, '2015-10-16 12:36:52'),
(36, 'OTk0NTYx', 2, 1, 0, '2015-10-17 07:49:36'),
(37, 'NTg5MzU4', 2, 0, 0, '2015-10-17 08:06:11'),
(38, 'ODkwMDgx', 2, 0, 0, '2015-10-17 08:09:12'),
(39, 'NDExMTA1', 2, 0, 0, '2015-10-17 08:10:33'),
(40, 'NTAxMTEw', 2, 0, 0, '2015-10-17 08:11:30'),
(41, 'MzQxMzk3', 2, 1, 0, '2015-10-17 08:12:07'),
(42, 'MzUwNTE1', 2, 1, 0, '2015-10-17 14:14:44'),
(43, 'OTMwMjA5', 2, 1, 0, '2015-10-19 11:23:28'),
(44, 'ODQ2Nzk1', 2, 0, 0, '2015-10-20 08:36:26'),
(45, 'NzU1NDE2', 2, 1, 0, '2015-10-20 08:37:24'),
(46, 'NzY2MjM4', 2, 1, 0, '2015-10-21 07:57:05'),
(47, 'NzMyODEy', 2, 1, 0, '2015-10-26 06:31:53'),
(48, 'MzMwNDY1', 2, 1, 0, '2015-10-29 06:16:25'),
(49, 'MjQwOTI3', 2, 1, 0, '2015-10-30 06:04:53'),
(50, 'MTQ1Mzcz', 2, 1, 0, '2015-10-31 06:02:06'),
(51, 'NTc3Njg1', 2, 1, 0, '2015-11-02 06:31:46'),
(52, 'NDEzMDAw', 2, 1, 0, '2015-11-03 06:30:43'),
(53, 'MjA2OTc5', 2, 1, 0, '2015-11-03 07:19:43'),
(54, 'NjEyODY5', 2, 1, 0, '2015-11-04 06:29:51'),
(55, 'Njc5MDM0', 2, 1, 0, '2015-11-05 07:16:26'),
(56, 'OTg5OTIw', 2, 1, 0, '2015-11-16 06:26:10'),
(57, 'NTYzNzg3', 2, 1, 0, '2015-11-16 07:54:37'),
(58, 'NzIyNzA1', 2, 1, 0, '2015-11-17 06:37:34'),
(59, 'NzMzNjM2', 2, 1, 0, '2015-11-18 08:37:05'),
(60, 'NjA3ODcw', 2, 1, 0, '2015-11-19 05:52:47'),
(61, 'NjcxNzAx', 2, 1, 0, '2015-11-20 12:58:53'),
(62, 'NTE0OTUz', 2, 1, 0, '2015-11-23 05:56:08'),
(63, 'NzczOTI4', 2, 0, 0, '2015-11-23 06:25:58'),
(64, 'MjkyNDgw', 2, 1, 0, '2015-11-23 06:29:13'),
(65, 'OTUyNTkz', 2, 1, 0, '2015-11-23 12:18:51'),
(66, 'ODkxMzcy', 2, 1, 0, '2015-11-24 06:31:46'),
(67, 'NTUwMDAw', 2, 1, 0, '2015-11-25 06:32:55'),
(68, 'NTY4NTEx', 2, 1, 0, '2015-11-26 06:46:33'),
(69, 'NjY2NjE5', 2, 1, 0, '2015-11-27 06:04:35'),
(70, 'ODc4NTE4', 2, 1, 0, '2015-11-28 07:31:38'),
(71, 'Mzg3MzE5', 2, 1, 0, '2015-11-30 06:27:49'),
(72, 'MjQyNzY3', 2, 0, 0, '2015-12-02 13:28:21'),
(73, 'NjQ2MzIy', 2, 0, 0, '2015-12-02 14:53:11'),
(74, 'ODMzOTk2', 2, 0, 0, '2015-12-02 14:55:05'),
(75, 'NDM5OTk5', 2, 0, 0, '2015-12-02 14:56:38'),
(76, 'ODkxMzE3', 2, 0, 0, '2015-12-02 14:57:57'),
(77, 'NzI3ODQx', 2, 0, 0, '2015-12-02 14:58:35'),
(78, 'MjA2NTY3', 2, 1, 0, '2015-12-02 14:58:50'),
(79, 'OTE0MzA2', 2, 0, 0, '2015-12-04 11:10:54'),
(80, 'NzczNDg5', 2, 1, 0, '2015-12-04 11:13:26'),
(81, 'MzY2Nzc1', 2, 0, 0, '2015-12-04 12:16:55'),
(82, 'NTkxMDMz', 2, 0, 0, '2015-12-04 12:18:45'),
(83, 'MzI3Mzg5', 2, 0, 0, '2015-12-04 12:34:47'),
(84, 'NzAyNDA3', 2, 1, 0, '2015-12-04 14:40:40'),
(85, 'NjgxNTg4', 2, 1, 0, '2015-12-05 10:53:23'),
(86, 'MTQzNTMz', 2, 0, 0, '2015-12-05 16:34:50'),
(87, 'MTUxNjYz', 2, 1, 0, '2015-12-05 16:35:50'),
(88, 'NjUxNzA1', 2, 1, 0, '2015-12-06 10:57:44'),
(89, 'NjM5MTgx', 2, 1, 0, '2015-12-07 10:39:35'),
(90, 'OTAyNTIz', 2, 1, 0, '2015-12-09 10:41:20'),
(91, 'NzQ2NzY1', 2, 0, 0, '2015-12-10 10:48:42'),
(92, 'OTYzNDk3', 2, 1, 0, '2015-12-10 10:49:34'),
(93, 'ODgxMzc1', 2, 1, 0, '2015-12-11 10:54:59'),
(94, 'MTQwMjY0', 2, 1, 0, '2015-12-12 10:59:18'),
(95, 'NjM3MzEz', 2, 1, 0, '2015-12-12 11:31:18'),
(96, 'MzI3MTk3', 2, 0, 0, '2015-12-14 11:04:53'),
(97, 'Njc4NTY3', 2, 1, 0, '2015-12-14 11:05:10'),
(98, 'MTk2MDQ3', 2, 1, 0, '2015-12-16 11:02:26'),
(99, 'MjU0MTY1', 2, 1, 0, '2015-12-16 17:33:53'),
(100, 'MzY5Nzk2', 2, 0, 0, '2015-12-17 10:35:21'),
(101, 'OTQ4NDc0', 2, 1, 0, '2015-12-17 10:35:50'),
(102, 'Njk4MjA1', 2, 1, 0, '2015-12-17 17:36:36'),
(103, 'NjE0Mjcw', 2, 1, 0, '2015-12-17 17:53:48'),
(104, 'ODgwOTYz', 2, 1, 0, '2015-12-18 10:17:51'),
(105, 'NTM3OTY5', 2, 1, 0, '2015-12-21 10:45:42'),
(106, 'ODkzNDg3', 2, 1, 0, '2015-12-21 14:23:18'),
(107, 'NTk3ODQ1', 2, 1, 0, '2015-12-21 14:31:55'),
(108, 'ODg0OTE4', 2, 1, 0, '2015-12-23 10:22:32'),
(109, 'MTQ3NDMz', 2, 0, 0, '2015-12-23 12:07:06'),
(110, 'NTYwODc2', 2, 1, 0, '2015-12-23 12:07:34'),
(111, 'ODk5NTMw', 2, 1, 0, '2015-12-23 15:44:19'),
(112, 'MjAzNDYz', 2, 1, 0, '2015-12-23 15:48:43'),
(113, 'NDgwNjc2', 2, 1, 0, '2015-12-23 15:59:51'),
(114, 'ODAyNjMw', 2, 1, 0, '2015-12-23 16:01:01'),
(115, 'NTUzOTI3', 2, 1, 0, '2015-12-23 16:02:16'),
(116, 'NzAwMTU1', 2, 1, 0, '2015-12-23 16:42:27'),
(117, 'NzgwOTg3', 2, 1, 0, '2015-12-23 16:46:44'),
(118, 'OTY0MTU3', 2, 1, 0, '2015-12-23 16:52:52'),
(119, 'ODIxMjUy', 2, 1, 0, '2015-12-23 16:54:29'),
(120, 'OTI0MzMx', 2, 1, 0, '2015-12-23 17:09:54'),
(121, 'MjYyNzM0', 2, 1, 0, '2015-12-23 18:11:33'),
(122, 'MjQ2MTQ1', 1, 0, 0, '2015-12-23 18:59:42'),
(123, 'NzE4NzUw', 1, 1, 0, '2015-12-23 19:01:13'),
(124, 'NjY5MzY2', 1, 1, 0, '2015-12-23 19:03:10'),
(125, 'ODExODg2', 2, 1, 0, '2015-12-24 10:43:35'),
(126, 'OTg3MDM2', 3, 1, 0, '2015-12-24 11:07:18'),
(127, 'MjM0MzM1', 3, 1, 0, '2015-12-24 11:12:13'),
(128, 'MTU1MDQx', 3, 1, 0, '2015-12-24 11:32:13'),
(129, 'MTQzMTc2', 3, 1, 0, '2015-12-24 13:10:27'),
(130, 'NTg5MDI4', 6, 1, 0, '2015-12-24 14:48:01'),
(131, 'Nzk0MTQz', 6, 1, 0, '2015-12-24 14:50:46'),
(132, 'MzA3MzM5', 3, 1, 0, '2015-12-24 18:41:15'),
(133, 'NDA5Mzc1', 2, 1, 0, '2015-12-25 10:53:12'),
(134, 'OTI3MjQz', 6, 1, 0, '2015-12-25 11:33:55'),
(135, 'MzU5MTEy', 1, 0, 0, '2015-12-25 11:35:02'),
(136, 'MzI0Njcw', 2, 1, 0, '2015-12-25 11:35:19'),
(137, 'NjQxNzA4', 2, 1, 0, '2015-12-25 11:35:49'),
(138, 'MzQ2ODkw', 2, 1, 0, '2015-12-25 11:37:17'),
(139, 'OTU0Nzkx', 1, 1, 0, '2015-12-25 11:37:45'),
(140, 'OTg3ODA1', 1, 1, 0, '2015-12-25 11:47:45'),
(141, 'MTE2ODkx', 3, 1, 0, '2015-12-25 15:42:45'),
(142, 'MTI1NTE1', 2, 1, 0, '2015-12-26 11:42:44'),
(143, 'ODYyNTMz', 2, 1, 0, '2015-12-28 11:06:07'),
(144, 'MzM1OTMx', 2, 1, 0, '2015-12-30 10:52:13'),
(145, 'NTU1ODUw', 2, 1, 0, '2015-12-31 10:51:17'),
(146, 'OTQwOTQ4', 2, 1, 0, '2015-12-31 13:06:28'),
(147, 'NjYwNzY5', 2, 1, 0, '2015-12-31 13:11:13'),
(148, 'NDQzOTI3', 2, 1, 0, '2015-12-31 13:16:29'),
(149, 'MTI4MjA3', 2, 1, 0, '2016-01-02 10:47:50'),
(150, 'NTQxMDQ2', 2, 1, 0, '2016-01-02 12:47:40'),
(151, 'OTI3OTI5', 2, 1, 0, '2016-01-04 11:08:56'),
(152, 'MTQxMDg4', 2, 1, 0, '2016-01-06 10:49:57'),
(153, 'MTE1MjE2', 2, 1, 0, '2016-01-07 10:16:26'),
(154, 'Mzc5Mjcy', 2, 1, 0, '2016-01-08 10:34:01'),
(155, 'NjgwMTMz', 2, 1, 0, '2016-01-09 10:46:43'),
(156, 'MjI0MDkw', 2, 1, 0, '2016-01-11 10:31:00'),
(157, 'NjIzNTUz', 2, 1, 0, '2016-01-11 18:04:59'),
(158, 'MjUzNjk4', 2, 0, 0, '2016-01-12 10:18:59'),
(159, 'MTQ4NDc3', 2, 1, 0, '2016-01-12 10:19:28'),
(160, 'ODE4MzQx', 2, 1, 0, '2016-01-13 10:39:35'),
(161, 'MTk0MzQ1', 6, 1, 0, '2016-01-13 12:55:35'),
(162, 'ODk5NDIw', 2, 1, 0, '2016-01-13 13:57:56'),
(163, 'MjQ2MjAw', 3, 1, 0, '2016-01-13 13:59:16'),
(164, 'MjM5Nzcz', 2, 1, 0, '2016-01-13 14:03:05'),
(165, 'OTcwMTQ0', 3, 1, 0, '2016-01-13 18:51:12'),
(166, 'NDUzNzA0', 2, 1, 0, '2016-01-14 11:22:50'),
(167, 'NDczOTQ3', 2, 1, 0, '2016-01-15 10:29:18'),
(168, 'MzQ3MzAy', 2, 1, 0, '2016-01-18 10:25:12'),
(169, 'ODI4MTE4', 2, 1, 0, '2016-01-18 15:48:32'),
(170, 'ODczMzAw', 2, 1, 0, '2016-01-19 14:35:23'),
(171, 'OTQ2MTM5', 2, 1, 0, '2016-01-20 10:29:23'),
(172, 'MzkwMDY2', 2, 1, 0, '2016-01-21 10:05:34'),
(173, 'NzIwNzgy', 2, 1, 0, '2016-01-22 11:12:10'),
(174, 'ODMzODg2', 2, 1, 0, '2016-01-23 10:38:36'),
(175, 'NDUzMDE4', 2, 1, 1, '2016-01-23 16:55:05'),
(176, 'MzI5NDQ5', 2, 1, 1, '2016-01-25 10:31:24'),
(177, 'NjM1NzIw', 2, 1, 1, '2016-01-27 10:21:36'),
(178, 'NzIzOTEz', 2, 1, 1, '2016-01-27 15:44:11'),
(179, 'MTQxMzkw', 2, 1, 1, '2016-01-27 16:50:22'),
(180, 'MzMxNjc0', 2, 1, 1, '2016-01-28 10:47:15'),
(181, 'NDMwMjIx', 2, 1, 1, '2016-01-28 12:43:18'),
(182, 'MTAxNDI4', 2, 1, 1, '2016-02-01 14:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `project_list`
--

CREATE TABLE `project_list` (
  `id` int(11) NOT NULL,
  `project_name` varchar(150) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_list`
--

INSERT INTO `project_list` (`id`, `project_name`, `comp_id`, `created_by`, `last_updated_by`, `is_active`, `is_delete`, `creation_date`, `last_updated`) VALUES
(1, 'Project -1', 1, 2, 2, 1, 0, '0000-00-00 00:00:00', '2015-12-30 19:07:01'),
(2, 'Project- 2', 1, 2, 2, 1, 0, '2015-11-03 07:48:01', '2015-11-03 11:35:16'),
(3, 'Project 3', 1, 2, 2, 1, 1, '2015-11-03 07:48:38', '2015-11-03 07:48:38'),
(4, 'Project 3--+++-', 1, 2, 2, 1, 0, '2015-11-03 07:57:40', '2015-12-05 12:31:07'),
(5, 'test project', 1, 2, 2, 1, 1, '2015-11-03 11:38:16', '2015-12-17 18:14:30'),
(6, 'Project --- 3 ', 1, 2, 2, 1, 1, '2015-11-03 11:40:25', '2015-11-03 11:40:25'),
(7, 'Project 3', 1, 2, 2, 1, 1, '2015-11-03 11:43:01', '2015-11-03 11:43:01'),
(8, 'Project 3', 1, 2, 2, 1, 1, '2015-11-03 11:44:02', '2015-11-03 11:44:02'),
(9, 'Project 3 ----', 1, 2, 2, 1, 1, '2015-11-03 11:44:33', '2015-11-03 11:44:33'),
(10, 'Project 1', 1, 2, 2, 1, 1, '2015-11-03 11:45:19', '2015-11-03 11:45:19'),
(11, 'test project 2', 1, 2, 2, 1, 1, '2015-12-05 12:31:24', '2015-12-05 12:31:24'),
(12, 'test project', 1, 2, 2, 1, 1, '2015-12-17 12:26:45', '2015-12-17 12:26:45'),
(13, 'test project', 1, 2, 2, 1, 1, '2015-12-17 18:12:05', '2015-12-17 18:12:05'),
(14, 'new project', 1, 2, 2, 1, 0, '2015-12-17 18:12:18', '2015-12-28 17:56:32'),
(15, 'fffff', 1, 2, 2, 1, 1, '2015-12-17 18:12:38', '2015-12-17 18:12:38');

-- --------------------------------------------------------

--
-- Table structure for table `sms_api_credentials`
--

CREATE TABLE `sms_api_credentials` (
  `id` int(11) NOT NULL,
  `sms_user_name` varchar(50) NOT NULL,
  `sms_pswd` varchar(50) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_api_credentials`
--

INSERT INTO `sms_api_credentials` (`id`, `sms_user_name`, `sms_pswd`, `comp_id`, `last_updated_by`) VALUES
(1, 'sdfdsf', 'sdfdfdf333333', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `source_list`
--

CREATE TABLE `source_list` (
  `id` int(11) NOT NULL,
  `source_name` varchar(150) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `last_updated_by` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `source_list`
--

INSERT INTO `source_list` (`id`, `source_name`, `comp_id`, `created_by`, `last_updated_by`, `is_active`, `is_delete`, `creation_date`, `last_updated`) VALUES
(1, 'Magic Brick', 1, 2, 2, 1, 0, '0000-00-00 00:00:00', '2015-12-18 18:13:06'),
(2, '99 Acres', 1, 2, 2, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'CSV Upload', 1, 2, 2, 1, 0, '2015-11-04 12:28:29', '2016-01-15 13:59:31'),
(4, 'Source ++--1', 1, 2, 2, 1, 0, '2015-12-18 18:11:22', '2015-12-18 18:11:22');

-- --------------------------------------------------------

--
-- Table structure for table `updated_lead_status`
--

CREATE TABLE `updated_lead_status` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `status_type` int(1) NOT NULL,
  `interested_type` int(1) NOT NULL,
  `bogus_lead` int(1) NOT NULL,
  `date_time_value` datetime NOT NULL,
  `lead_rating` int(1) NOT NULL,
  `client_type` int(1) NOT NULL,
  `last_feedback` text,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `comp_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `updated_lead_status`
--

INSERT INTO `updated_lead_status` (`id`, `lead_id`, `status_type`, `interested_type`, `bogus_lead`, `date_time_value`, `lead_rating`, `client_type`, `last_feedback`, `updated_by`, `updated_on`, `comp_id`, `is_active`) VALUES
(3, 5, 1, 1, 0, '2015-12-18 09:30:00.0', 1, 1, 'testing first lead update', 2, '2015-12-09 18:06:40', 0, 0),
(4, 5, 1, 2, 0, '2015-12-18 09:30:00.0', 2, 2, 'testing first lead update 2', 2, '2015-12-09 18:07:05', 0, 0),
(5, 5, 2, 0, 2, '0000-00-00 00:00:00.0', 0, 0, 'bogus lead 1', 2, '2015-12-09 18:07:26', 0, 0),
(6, 5, 2, 0, 2, '0000-00-00 00:00:00.0', 0, 0, 'SSSSSSSSSSSSSSSS', 2, '2015-12-09 18:16:36', 1, 0),
(7, 5, 2, 0, 2, '0000-00-00 00:00:00.0', 0, 0, 'dfgfgfdgfd', 2, '2015-12-09 18:17:03', 1, 0),
(8, 5, 1, 1, 0, '2015-12-25 09:10:00.0', 1, 2, 'ffffffffffffffff', 2, '2015-12-09 18:26:29', 1, 0),
(9, 5, 2, 0, 1, '0000-00-00 00:00:00.0', 0, 0, 'sdsfsdfdsfd', 2, '2015-12-09 18:27:52', 1, 0),
(10, 5, 2, 0, 1, '0000-00-00 00:00:00.0', 0, 0, 'aaaaaaaaaaaaaaa', 2, '2015-12-10 19:16:03', 1, 0),
(11, 5, 1, 1, 0, '2015-12-25 15:15:00.0', 2, 1, 'latest lead update', 2, '2015-12-10 19:18:23', 1, 1),
(12, 4, 1, 2, 0, '2015-12-12 10:50:00.0', 2, 1, 'sdfsdfsdfdsf', 2, '2015-12-11 13:15:37', 1, 1),
(13, 1, 1, 3, 0, '2015-12-24 22:50:00.0', 1, 2, 'adasdasdsa', 2, '2015-12-11 13:16:34', 1, 1),
(14, 9, 2, 0, 1, '0000-00-00 00:00:00.0', 0, 0, 'sdfdsfds', 2, '2015-12-11 15:52:05', 1, 1),
(15, 2, 3, 0, 0, '0000-00-00 00:00:00.0', 0, 0, 'sdfdsfdsf', 2, '2015-12-11 15:52:40', 1, 1),
(16, 3, 1, 2, 0, '2015-12-26 18:35:00.0', 1, 1, 'pppppppppppp', 2, '2015-12-12 18:10:05', 1, 1),
(17, 12, 1, 1, 0, '2015-12-20 10:55:00.0', 1, 1, 'update lead status sdfsdfds---testing', 2, '2015-12-17 10:44:47', 1, 0),
(18, 12, 2, 0, 1, '0000-00-00 00:00:00.0', 0, 0, 'update lead status sdfsdfds---testing-- not intesrested -- bogus lead', 2, '2015-12-17 10:57:46', 1, 0),
(19, 12, 1, 2, 0, '2015-12-26 10:35:00.0', 2, 1, 'update lead status sdfsdfds---testing-- -- interested', 2, '2015-12-17 12:08:35', 1, 0),
(20, 12, 1, 2, 0, '2015-12-26 10:35:00.0', 2, 2, 'update lead status sdfsdfds---testing-- -- interested', 2, '2015-12-17 12:22:41', 1, 0),
(21, 12, 1, 3, 0, '2015-12-26 22:55:00.0', 2, 2, 'update lead status sdfsdfds---testing-- -- interested', 2, '2015-12-17 12:22:57', 1, 0),
(22, 6, 1, 1, 0, '2015-12-26 10:35:00.0', 1, 1, 'fgdfgfdgf fgdfgfd gfgfgf', 2, '2015-12-21 13:03:39', 1, 1),
(23, 10, 1, 1, 0, '2015-12-27 11:35:00.0', 2, 1, 'fdfdf dfdfd dfdf erere ghghgh', 2, '2015-12-21 13:09:26', 1, 0),
(24, 10, 2, 0, 1, '0000-00-00 00:00:00.0', 0, 2, 'fffffffffffffhhhhhhhhhhhhhhhhhh', 2, '2015-12-21 13:09:46', 1, 1),
(25, 12, 1, 3, 0, '2015-12-26 22:55:00.0', 2, 2, '', 2, '2015-12-26 12:29:02', 1, 1),
(26, 30, 1, 2, 0, '2015-12-31 09:30:00.0', 1, 1, 'dfsdfsdfds', 2, '2015-12-30 19:06:19', 1, 1),
(27, 124, 2, 0, 2, '0000-00-00 00:00:00.0', 0, 1, 'here is some description.', 2, '2016-01-08 11:37:34', 1, 1),
(28, 129, 1, 1, 0, '2016-01-16 10:30:00.0', 1, 1, 'sdfdsssd', 2, '2016-01-13 13:49:29', 1, 0),
(29, 126, 2, 0, 1, '0000-00-00 00:00:00.0', 0, 1, NULL, 2, '2016-01-13 13:50:35', 1, 1),
(30, 127, 3, 0, 0, '0000-00-00 00:00:00.0', 0, 2, 'sdfsdfdsf', 2, '2016-01-13 13:51:13', 1, 1),
(31, 130, 1, 1, 0, '2016-01-22 16:30:00.0', 2, 1, NULL, 2, '2016-01-13 14:04:35', 1, 1),
(32, 129, 1, 1, 0, '2016-01-13 20:25:00.0', 1, 1, 'sdfdsssd', 2, '2016-01-13 18:05:44', 1, 1),
(33, 137, 1, 2, 0, '2016-01-15 14:05:00.0', 1, 1, NULL, 2, '2016-01-13 18:09:52', 1, 0),
(34, 137, 1, 2, 0, '2016-01-13 18:50:00.0', 1, 1, NULL, 2, '2016-01-13 18:10:21', 1, 1),
(35, 135, 1, 3, 0, '2016-01-13 20:10:00.0', 1, 1, NULL, 2, '2016-01-13 18:12:34', 1, 0),
(36, 135, 1, 3, 0, '2016-01-22 14:50:00.0', 1, 1, NULL, 2, '2016-01-13 18:33:43', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `userlist`
--

CREATE TABLE `userlist` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `mobile` bigint(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt_key` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `reporting_manager` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  `created_by` tinyint(1) NOT NULL,
  `last_updated_by` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL,
  `comp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlist`
--

INSERT INTO `userlist` (`id`, `username`, `useremail`, `mobile`, `password`, `salt_key`, `role_id`, `reporting_manager`, `is_active`, `is_delete`, `created_by`, `last_updated_by`, `date_created`, `last_updated`, `comp_id`) VALUES
(1, 'Arvind Jha', 'arvindjha304@gmail.com', 1234567890, 'cGFzc3dvcmQ=n3HnHdV+Tks=', 'n3HnHdV+Tks=', 13, 2, 1, 0, 1, 2, '2015-11-11 03:13:27', '2015-12-30 12:03:14', 1),
(2, 'Arvinddd kr', 'arvind@discoverysolutions.in', 2147483647, 'cGFzc3dvcmQ=+xDnOAKJRiE=', '+xDnOAKJRiE=', 1, 0, 1, 0, 1, 2, '2015-11-18 00:00:00', '2015-12-30 19:06:40', 1),
(3, 'Kavita Singh-3', 'kavita@discoverysolutions.in', 2147483647, 'cGFzc3dvcmQ=3R8W+sve848=', '3R8W+sve848=', 15, 6, 1, 0, 2, 2, '2015-10-17 14:37:50', '2015-12-24 14:52:23', 1),
(4, 'Kavita Singhhhh', 'kavitasinghmca@gmail.com', 2147483647, 'YzJSbWMyUm1OWlhTWm0yMkUvVT0=TFah5OWE4i8=', 'TFah5OWE4i8=', 5, 7, 0, 0, 2, 2, '2015-10-20 12:21:09', '2015-12-02 15:03:58', 1),
(5, 'satish', 'satish@discoverysolution.in', 1234567890, 'cGFzc3dvcmQ=aobYd1mpBnY=', 'aobYd1mpBnY=', 1, 0, 1, 0, 2, 2, '2015-10-31 12:39:10', '2015-10-31 12:39:10', 1),
(6, 'Pooja', 'pooja@discoverysolutions.in', 1234567890, 'cGFzc3dvcmQ=5NflRfQ6Bko=', '5NflRfQ6Bko=', 14, 5, 1, 0, 2, 2, '2015-11-27 07:42:48', '2015-12-30 11:58:03', 1),
(7, 'new Admin', 'newAdmin@gmail.com', 1234567899, 'cGFzc3dvcmQ=AJT2rvZoqBg=', 'AJT2rvZoqBg=', 1, 0, 1, 0, 2, 2, '2015-11-27 10:35:02', '2015-11-27 10:42:53', 1),
(8, 'Arvinddd - 2', 'customercare@discoverysolutions.in', 1234567890, 'cGFzc3dvcmQ=xjt+7HU2OCg=', 'xjt+7HU2OCg=', 10, 5, 1, 0, 2, 2, '2015-11-27 12:52:00', '2015-11-27 12:52:19', 1),
(9, '28-dec-user-1', 'nnewAdmin@gmail.com', 1111888558, 'cGFzc3dvcmQ=BIwW0xYRk98=', 'BIwW0xYRk98=', 13, 5, 1, 0, 2, 2, '2015-12-28 16:58:27', '2015-12-28 16:58:27', 1),
(10, 'admin - 30-dec', 'akash.bhardwaj590@gmail.com', 7894561230, 'cGFzc3dvcmQ=OBzsxzDzhSE=', 'OBzsxzDzhSE=', 1, 0, 1, 0, 2, 2, '2015-12-30 12:02:34', '2015-12-30 12:02:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_login_history`
--

CREATE TABLE `user_login_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `comp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login_history`
--

INSERT INTO `user_login_history` (`id`, `user_id`, `ip_address`, `login_time`, `logout_time`, `status`, `comp_id`) VALUES
(1, 2, '::1', '2015-12-31 13:06:49', '0000-00-00 00:00:00', 1, 1),
(2, 2, '::1', '2015-12-31 13:11:39', '2015-12-31 13:11:53', 1, 1),
(3, 2, '::1', '2015-12-31 13:16:49', '0000-00-00 00:00:00', 1, 1),
(4, 2, '::1', '2016-01-02 10:48:09', '0000-00-00 00:00:00', 1, 1),
(5, 2, '::1', '2016-01-02 12:48:21', '0000-00-00 00:00:00', 1, 1),
(6, 2, '::1', '2016-01-04 11:09:28', '0000-00-00 00:00:00', 1, 1),
(7, 2, '::1', '2016-01-06 10:50:16', '0000-00-00 00:00:00', 1, 1),
(8, 2, '::1', '2016-01-07 10:17:11', '0000-00-00 00:00:00', 1, 1),
(9, 2, '::1', '2016-01-08 10:34:27', '0000-00-00 00:00:00', 1, 1),
(10, 2, '::1', '2016-01-09 10:47:09', '0000-00-00 00:00:00', 1, 1),
(11, 2, '::1', '2016-01-11 10:31:45', '0000-00-00 00:00:00', 1, 1),
(12, 2, '::1', '2016-01-11 18:06:04', '0000-00-00 00:00:00', 1, 1),
(13, 2, '::1', '2016-01-12 10:19:52', '0000-00-00 00:00:00', 1, 1),
(14, 2, '::1', '2016-01-13 10:40:32', '0000-00-00 00:00:00', 1, 1),
(15, 6, '::1', '2016-01-13 12:58:09', '0000-00-00 00:00:00', 0, 1),
(16, 2, '::1', '2016-01-13 13:58:45', '2016-01-13 13:59:09', 1, 1),
(17, 3, '::1', '2016-01-13 13:59:47', '2016-01-13 14:02:57', 1, 1),
(18, 2, '::1', '2016-01-13 14:03:26', '0000-00-00 00:00:00', 1, 1),
(19, 3, '::1', '2016-01-13 18:51:56', '0000-00-00 00:00:00', 0, 1),
(20, 2, '::1', '2016-01-14 11:23:12', '0000-00-00 00:00:00', 1, 1),
(21, 2, '::1', '2016-01-15 10:29:56', '0000-00-00 00:00:00', 1, 1),
(22, 2, '::1', '2016-01-18 10:25:31', '0000-00-00 00:00:00', 1, 1),
(23, 2, '::1', '2016-01-18 15:49:06', '0000-00-00 00:00:00', 1, 1),
(24, 2, '::1', '2016-01-19 14:35:44', '0000-00-00 00:00:00', 1, 1),
(25, 2, '::1', '2016-01-20 10:29:44', '0000-00-00 00:00:00', 1, 1),
(26, 2, '::1', '2016-01-21 10:06:06', '0000-00-00 00:00:00', 1, 1),
(27, 2, '::1', '2016-01-22 11:12:38', '0000-00-00 00:00:00', 1, 1),
(28, 2, '::1', '2016-01-23 10:39:22', '0000-00-00 00:00:00', 1, 1),
(29, 2, '::1', '2016-01-23 16:55:30', '0000-00-00 00:00:00', 1, 1),
(30, 2, '::1', '2016-01-25 10:31:40', '0000-00-00 00:00:00', 1, 1),
(31, 2, '::1', '2016-01-27 10:22:04', '0000-00-00 00:00:00', 1, 1),
(32, 2, '::1', '2016-01-27 15:44:36', '0000-00-00 00:00:00', 1, 1),
(33, 2, '::1', '2016-01-27 16:57:32', '0000-00-00 00:00:00', 1, 1),
(34, 2, '::1', '2016-01-28 10:48:22', '0000-00-00 00:00:00', 1, 1),
(35, 2, '::1', '2016-01-28 12:43:42', '0000-00-00 00:00:00', 1, 1),
(36, 2, '::1', '2016-02-01 14:32:02', '0000-00-00 00:00:00', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acres_api_credentials`
--
ALTER TABLE `acres_api_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `source_id` (`source_id`),
  ADD KEY `comp_id` (`comp_id`);

--
-- Indexes for table `assigned_lead`
--
ALTER TABLE `assigned_lead`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_lead_comp_id` (`comp_id`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `comp_id` (`comp_id`),
  ADD KEY `is_active` (`is_active`);

--
-- Indexes for table `auto_assign_source_user`
--
ALTER TABLE `auto_assign_source_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `source_id` (`source_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comp_id` (`comp_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_rights`
--
ALTER TABLE `company_rights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fKey_role_rights_comp_id` (`comp_id`),
  ADD KEY `comp_id` (`comp_id`),
  ADD KEY `is_active` (`is_active`),
  ADD KEY `is_delete` (`is_delete`),
  ADD KEY `is_active_2` (`is_active`);

--
-- Indexes for table `company_roles`
--
ALTER TABLE `company_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_roles_comp_id_fKey` (`comp_id`),
  ADD KEY `company_roles_created_by_fKey` (`created_by`),
  ADD KEY `company_roles_last_updated_by_fKey` (`last_updated_by`);

--
-- Indexes for table `company_role_rights`
--
ALTER TABLE `company_role_rights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fKey_company_role_rights_role_id` (`role_id`),
  ADD KEY `fKey_company_role_rights_right_id` (`right_id`),
  ADD KEY `fKey_company_role_rights_comp_id` (`comp_id`),
  ADD KEY `company_role_rights_created_by_fKey` (`created_by`),
  ADD KEY `company_role_rights_last_updated_by_fKey` (`last_updated_by`),
  ADD KEY `is_active` (`is_active`),
  ADD KEY `is_delete` (`is_delete`);

--
-- Indexes for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_list`
--
ALTER TABLE `lead_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `source_of_enquiry_lead_list` (`source_of_enquiry`),
  ADD KEY `project_list_lead_list` (`project_interested`),
  ADD KEY `comp_id_lead_list` (`comp_id`),
  ADD KEY `created_by_lead_list` (`created_by`),
  ADD KEY `last_updated_by_lead_list` (`last_updated_by`),
  ADD KEY `mobile` (`mobile`),
  ADD KEY `alt_no` (`alt_no`),
  ADD KEY `other_no` (`other_no`);

--
-- Indexes for table `magic_brick_credentials`
--
ALTER TABLE `magic_brick_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `last_updated_by` (`last_updated_by`),
  ADD KEY `comp_id` (`comp_id`),
  ADD KEY `is_active` (`is_active`),
  ADD KEY `is_delete` (`is_delete`);

--
-- Indexes for table `sms_api_credentials`
--
ALTER TABLE `sms_api_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `source_list`
--
ALTER TABLE `source_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comp_id` (`comp_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `updated_lead_status`
--
ALTER TABLE `updated_lead_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `update_lead_status_lead_id` (`lead_id`),
  ADD KEY `updated_lead_status_updated_by` (`updated_by`),
  ADD KEY `updated_lead_status_comp_id` (`comp_id`),
  ADD KEY `status_type` (`status_type`),
  ADD KEY `interested_type` (`interested_type`);

--
-- Indexes for table `userlist`
--
ALTER TABLE `userlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `last_updated_by` (`last_updated_by`),
  ADD KEY `company_id` (`comp_id`),
  ADD KEY `company_id_2` (`comp_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `reporting_manager` (`reporting_manager`),
  ADD KEY `is_active` (`is_active`),
  ADD KEY `is_delete` (`is_delete`);

--
-- Indexes for table `user_login_history`
--
ALTER TABLE `user_login_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comp_id` (`comp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acres_api_credentials`
--
ALTER TABLE `acres_api_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `assigned_lead`
--
ALTER TABLE `assigned_lead`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `auto_assign_source_user`
--
ALTER TABLE `auto_assign_source_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `company_rights`
--
ALTER TABLE `company_rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `company_roles`
--
ALTER TABLE `company_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `company_role_rights`
--
ALTER TABLE `company_role_rights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `lead_list`
--
ALTER TABLE `lead_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;
--
-- AUTO_INCREMENT for table `magic_brick_credentials`
--
ALTER TABLE `magic_brick_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;
--
-- AUTO_INCREMENT for table `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `sms_api_credentials`
--
ALTER TABLE `sms_api_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `source_list`
--
ALTER TABLE `source_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `updated_lead_status`
--
ALTER TABLE `updated_lead_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `userlist`
--
ALTER TABLE `userlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user_login_history`
--
ALTER TABLE `user_login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
