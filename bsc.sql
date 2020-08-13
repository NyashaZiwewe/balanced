-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2020 at 12:05 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsc`
--

-- --------------------------------------------------------

--
-- Table structure for table `bsc_360_answer_scale`
--

CREATE TABLE `bsc_360_answer_scale` (
  `id` int(11) NOT NULL,
  `value` text NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_360_answer_scale`
--

INSERT INTO `bsc_360_answer_scale` (`id`, `value`, `text`) VALUES
(1, '1', 'Very Poor'),
(2, '2', 'Poor'),
(3, '3', 'Good'),
(4, '4', 'Very Good'),
(5, '5', 'Excellent');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_360_questions`
--

CREATE TABLE `bsc_360_questions` (
  `id` int(11) NOT NULL,
  `step_id` text NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_360_questions`
--

INSERT INTO `bsc_360_questions` (`id`, `step_id`, `question`) VALUES
(1, '3', 'Does your organisation have enough resources to support your strategy?'),
(2, '3', 'Is there any alignment between the operations and the strategic goals?'),
(3, '1', 'How do you rate the pre-strategy internal assessment that was done on strengths and weaknesses? '),
(4, '1', 'How do you rate the pre-strategy external assessment that was done on threats and opportunities?'),
(5, '2', 'How effective is your organisation\'s strategic vision?'),
(6, '2', 'Give us your opinion on the balance between the short term and long term priorities of your organisation'),
(7, '2', 'Is your organisation pursuing growth and business development with as much passion as it does on operational efficiency?'),
(8, '3', 'Are your organisation\'s strategic goals well cascaded to lower levels?'),
(9, '3', 'How do you rate the effectiveness of strategic communication to all levels?'),
(10, '2', 'Are your strategic targets measurable?'),
(11, '2', 'How good is your organisation\'s vision?'),
(12, '2', 'How good is the match between your organisation\'s vision and mission and strategic objectives?'),
(13, '2', 'How good is the link between corporate strategy, business strategy and functional strategy from your are?'),
(14, '2', 'Was the competitive position of your organisation clearly defined?'),
(15, '4', 'How do you rate the strategy evaluation and control methods used?'),
(16, '3', 'Do you really know your role for your organisation to achieve its objectives?'),
(17, '3', 'Are the measurements standards standard across functions?');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_360_responses`
--

CREATE TABLE `bsc_360_responses` (
  `id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `client_id` text NOT NULL,
  `question_id` text NOT NULL,
  `value` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_360_steps`
--

CREATE TABLE `bsc_360_steps` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_360_steps`
--

INSERT INTO `bsc_360_steps` (`id`, `name`) VALUES
(1, 'Analysis'),
(2, 'Strategy Fomulation'),
(3, 'Strategy Implementation'),
(4, 'Evaluation and Control');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_access_levels`
--

CREATE TABLE `bsc_access_levels` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_access_levels`
--

INSERT INTO `bsc_access_levels` (`id`, `name`) VALUES
(1, 'Employee'),
(2, 'Supervisor'),
(3, 'Department Manager'),
(4, 'Business Unit Manager'),
(5, 'Super User');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_accounts`
--

CREATE TABLE `bsc_accounts` (
  `id` int(11) NOT NULL,
  `employee_number` text,
  `first_name` text,
  `middle_name` text,
  `last_name` text,
  `email` text,
  `password` text,
  `supervisoremail` text,
  `client` text,
  `department` text,
  `position` text,
  `account_type` text,
  `business_unit` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bsc_accounts`
--

INSERT INTO `bsc_accounts` (`id`, `employee_number`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `supervisoremail`, `client`, `department`, `position`, `account_type`, `business_unit`, `date`) VALUES
(1, '', 'Nyasha', 'Desire', 'Ziwewe', 'nyasha@ipcconsultants.com', 'ayipcmailnz', 'kudzai@ipcconsultants.com', '1', '60', 'Programmer', '4', '', '2019-04-10 06:03:18'),
(2, '2222', 'Evelyn', 'evy', 'Maparara', 'evelyn@ipcconsultants.com', 'ayipcmailem', 'david@ipcconsultants.com', '1', '39', 'Office admin', '4', '', '2019-04-10 11:28:43'),
(3, '', 'Kudzai', '', 'Derera', 'kudzai@ipcconsultants.com', 'ipc', 'mnguwi@ipcconsultants.com', '1', '60', 'Business Systems Manager', '3', '', '2019-04-10 12:32:13'),
(4, '', 'Carl', '', 'Tapi', 'carl@ipcconsultants.com', 'ayipcmailct', 'mnguwi@ipcconsultants.com', '1', '48', 'Organisational Development Manager', '3', NULL, '2019-06-05 09:07:19'),
(5, '', 'Memory', '', 'Nguwi', 'mnguwi@ipcconsultants.com', 'ipc', 'mnguwi@ipcconsultants.com', '1', '45', 'Manager Consulting', '1', NULL, '2019-06-10 08:55:43'),
(6, '', 'David', '', 'Shambare', 'david@ipcconsultants.com', 'ayipcmailds', 'mnguwi@ipcconsultants.com', '1', '39', 'Finance Manager', '3', NULL, '2019-06-11 12:04:08'),
(7, '', 'Newturn', '', 'Wikirefu', 'newturn@ipcconsultants.com', 'ayipcmailnw', 'mnguwi@ipcconsultants.com', '1', '49', 'Talent Acquisition Lead', '3', NULL, '2019-06-11 13:02:02'),
(8, '', 'Tapiwa', '', 'Gomo', 'tapiwago@ipcconsultants.com', 'ayipcmailtg', 'kudzai@ipcconsultants.com', '1', '60', 'Consultant', '4', NULL, '2019-06-11 13:10:13'),
(9, '', 'Jerry', '', 'Ndemera', 'jerry@ipcconsultants.com', 'ayipcmailjn', 'kudzai@ipcconsultants.com', '1', '60', 'Consultant', '4', NULL, '2019-06-11 13:10:50'),
(10, '', 'Benjamin', '', 'Sombi', 'benjamin@ipcconsultants.com', 'ayipcmailbs', 'mnguwi@ipcconsultants.com', '1', '44', 'Manager Analytics', '3', '', '2019-06-11 13:11:54'),
(11, '', 'Ifeoma', '', 'Obi', 'ifeoma@ipcconsultants.com', 'ayipcmailio', 'benjamin@ipcconsultants.com', '1', '44', 'Consultant', '4', '', '2019-06-11 13:14:11'),
(12, '', 'Taurai', '', 'Masunda', 'taurai@ipcconsultants.com', 'ayipcmailtm', 'benjamin@ipcconsultants.com', '1', '44', 'Consultant', '4', NULL, '2019-06-11 13:14:54'),
(13, '', 'Tatenda', '', 'Sayenda', 'tatenda@ipcconsultants.com', 'ayipcmailts', 'carl@ipcconsultants.com', '1', '48', 'Senior Consultant', '4', NULL, '2019-06-11 13:15:40'),
(14, '', 'Munodiwa', '', 'Zvemhara', 'munodiwa@ipcconsultants.com', 'ayipcmailmz', 'newturn@ipcconsultants.com', '1', '49', 'Consultant', '4', NULL, '2019-06-11 13:16:19'),
(15, '', 'Tinotenda', '', 'Sibanda', 'tinotendas@ipcconsultants.com', 'ayipcmailts', 'kudzai@ipcconsultants.com', '1', '60', 'Graphic Designer', '4', '', '2020-01-16 12:34:47'),
(16, '', 'Sifiso', '', 'Dingani', 'sifiso@ipcconsultants.com', 'ayipcmailsd', 'newturn@ipcconsultants.com', '1', '49', 'Business Development Consultant', '4', '', '2020-01-16 12:36:18'),
(17, '', 'Thandeka', '', 'Madziwanyika', 'thandeka@ipcconsultants.com', 'ayipcmailtm', 'newturn@ipcconsultants.com', '1', '49', 'Business Development Consultant', '4', '', '2020-01-16 12:37:18'),
(18, '', 'Takudzwa', '', 'Machingauta', 'takudzwa@ipcconsultants.com', 'ayipcmailtm', 'carl@ipcconsultants.com', '1', '48', 'Consultant', '4', '', '2020-01-16 12:38:27'),
(19, '', 'Nyasha', '', 'Mukechi', 'nyasham@ipcconsultants.com', 'ayipcmailnm', 'benjamin@ipcconsultants.com', '1', '44', 'Consultant', '4', '', '2020-01-16 12:39:20'),
(20, '', 'Fadzai', '', 'Danha', 'fadzai@ipcconsultants.com', 'ayipcmailfd', 'carl@ipcconsultants.com', '1', '48', 'Consultant', '4', '', '2020-01-16 12:40:07'),
(21, '', 'Milton ', '', 'Jack', 'milton@ipcconsultants.com', 'ayipcmailmj', 'carl@ipcconsultants.com', '1', '48', 'Consultant', '4', '', '2020-01-16 12:41:28'),
(22, '', 'Lindah', '', 'Mavengere', 'lindah@ipcconsultants.com', 'ayipcmaillm', 'newturn@ipcconsultants.com', '1', '49', 'Consultant', '4', '', '2020-01-17 07:15:28'),
(23, '', 'nyasha', '', 'ziwewe', 'nyasha@getbucks.co.zw', 'IPC56c7644867', 'bod', '2', '15', 'Programer', '3', '', '2020-01-27 08:26:36'),
(24, '', 'Shamiso', '', 'Mukombwe', 'shamiso@ipcconsultants.com', 'ayipcmailsm', 'david@ipcconsultants.com', '1', '39', 'Accounting Assistant', '4', '', '2020-01-28 12:50:20'),
(25, '', 'Dings', '', 'Mtetwa', 'dings@ipcconsultants.com', 'ayipcmaildm', 'david@ipcconsultants.com', '1', '39', 'Accounting assistant', '4', '', '2020-01-28 12:51:17'),
(26, '', 'Nyasha', '', 'Ziwewe', 'nyasha@crocoholdings.co.zw', 'IPCa49ba98704', 'bod', '3', '22', 'HR Manager', '3', '', '2020-01-29 10:29:32'),
(27, '', 'Jerry', '', 'Ndemera', 'jerry@crocoholdings.co.zw', 'IPCab01044631', 'nyasha@crocoholdings.co.zw', '3', '22', 'Human Resource officer', '4', '', '2020-01-29 10:30:32'),
(28, '', 'David', '', 'Shambare', 'david@bankx.com', 'IPCe656e31032', 'bod', '5', '61', 'Manager', '3', '', '2020-02-11 11:41:44'),
(30, '', 'Carl', '', 'Tapi', 'carl@bankx.com', 'IPC92b6a2820', 'bod', '5', '22', 'HR Manager', '3', '', '2020-02-11 11:42:53'),
(31, '', 'Kudzai  ', '', 'Derera', 'kudzai@bankx.com', 'IPCabee378549', 'bod', '5', '62', 'Manager', '3', '', '2020-02-11 11:44:35'),
(32, '', 'Tinotenda', '', 'Sibanda', 'tino@bankx.com', 'IPC019ce98310', 'kudzai@bankx.com', '5', '62', 'Designer', '4', '', '2020-02-11 11:45:53'),
(33, '', 'Tapiwa', '', 'Gomo', 'tapiwa@bankx.com', 'IPCdc40799910', 'kudzai@bankx.com', '5', '62', 'Engineer', '4', '', '2020-02-11 11:46:52'),
(34, '', 'Nyasha', '', 'Ziwewe', 'nyasha@bankx.com', 'IPCa49ba8538', 'kudzai@bankx.com', '5', '62', 'Engineer', '4', '', '2020-02-11 11:47:50'),
(35, '', 'Natasha', '', 'Mabuza', 'natasha@masaisai.co.zw', 'IPCc816738389', 'bod', '6', '59', 'HOD', '3', '', '2020-03-11 10:02:11'),
(36, '', 'Jerry', '', 'Ndemera', 'jerry@masaisai.co.zw', 'IPCab01079242', 'natasha@masaisai.co.zw', '6', '59', 'Teacher', '4', '', '2020-03-11 10:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_accounts_notifications`
--

CREATE TABLE `bsc_accounts_notifications` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `status` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_account_types`
--

CREATE TABLE `bsc_account_types` (
  `id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_account_types`
--

INSERT INTO `bsc_account_types` (`id`, `level`, `name`) VALUES
(1, 1, 'CEO'),
(2, 2, 'Business Unit Manager'),
(3, 3, 'Supervisor'),
(4, 4, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_action_plans`
--

CREATE TABLE `bsc_action_plans` (
  `id` int(11) NOT NULL,
  `scorecard_id` int(11) NOT NULL,
  `goal_id` int(11) DEFAULT NULL,
  `activity` text,
  `measure` text,
  `deadline` text,
  `employee` text,
  `status` int(11) DEFAULT '0',
  `evidence` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_admin`
--

CREATE TABLE `bsc_admin` (
  `admin_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `account_type` text,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_admin`
--

INSERT INTO `bsc_admin` (`admin_id`, `first_name`, `last_name`, `email`, `password`, `account_type`, `date_time`) VALUES
(5, 'Memory', 'Nguwi', 'mnguwi@ipcconsultants.com', 'ipc', 'Superuser', '2017-01-15 22:00:00'),
(7, 'Kudzai', 'Derera', 'kudzai@ipcconsultants.com', 'ipc', 'supervisor', '2017-01-16 22:00:00'),
(9, 'Linda', 'Mupawaenda', 'linda@ipcconsultants.com', 'ayipcmaillm', '', '2017-01-17 22:00:00'),
(11, 'Tatenda', 'Sayenda', 'tatenda@ipcconsultants.com', 'ayipcmailts', '', '2017-01-19 22:00:00'),
(12, 'Carl', 'Tapi', 'carl@ipcconsultants.com', 'ayipcmailct', '', '2017-01-20 22:00:00'),
(14, 'Collin', 'Bhiza', 'collin@ipcconsultants.com', 'ayipcmailcb', '', '2017-01-22 22:00:00'),
(22, 'Tendai', 'Hoto', 'thoto@ipcconsultants.com', 'ayipcmailth', '', '2017-01-27 22:00:00'),
(26, 'Newturn', 'Wikirefu', 'newturn@ipcconsultants.com', 'ayipcmailnw', '', '2017-01-28 22:00:00'),
(27, 'Albert', 'Mashamba', 'albert@ipcconsultants.com', 'Consultant', 'Consultant', '2017-01-29 22:00:00'),
(29, 'Nyasha', 'Ziwewe', 'nyasha@ipcconsultants.com', 'nyasha', 'Consultant', '2017-01-31 22:00:00'),
(30, 'Tapiwa', 'Gomo', 'tapiwago@ipcconsultants.com', 'ayipcmailtg', '', '2017-02-01 22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_audit`
--

CREATE TABLE `bsc_audit` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `table` text NOT NULL,
  `action` text NOT NULL,
  `old_value` text,
  `new_value` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_business_units`
--

CREATE TABLE `bsc_business_units` (
  `id` int(11) NOT NULL,
  `client_id` text NOT NULL,
  `name` text NOT NULL,
  `head` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_chart`
--

CREATE TABLE `bsc_chart` (
  `id` int(11) NOT NULL,
  `parent_id` text NOT NULL,
  `name` text NOT NULL,
  `salary` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_chart`
--

INSERT INTO `bsc_chart` (`id`, `parent_id`, `name`, `salary`, `image`) VALUES
(1, 'null', 'nyasha', '600', ''),
(2, '1', 'thelma', '200', ''),
(3, '1', 'tino', '200', ''),
(4, '2', 'muno', '100', '');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_city`
--

CREATE TABLE `bsc_city` (
  `city_id` int(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_city`
--

INSERT INTO `bsc_city` (`city_id`, `city`, `country_id`) VALUES
(1, 'Harare', 1),
(2, 'Bulawayo', 1),
(3, 'Chitungwiza', 1),
(4, 'Mutare', 1),
(5, 'Epworth', 1),
(6, 'Gweru', 1),
(7, 'Kwekwe', 1),
(8, 'Kadoma', 1),
(9, 'Masvingo', 1),
(11, 'Norton', 1),
(12, 'Marondera', 1),
(13, 'Ruwa', 1),
(14, 'Chegutu', 1),
(15, 'Zvishavane', 1),
(16, 'Bindura', 1),
(17, 'Beitbridge', 1),
(18, 'Redcliff', 1),
(19, 'Victoria Falls', 1),
(20, 'Rusape', 1),
(21, 'Chiredzi', 1),
(22, 'Kariba', 1),
(23, 'Karoi', 1),
(24, 'Chipinge', 1),
(25, 'Gokwe', 1),
(26, 'Shurugwi', 1),
(27, 'Mazowe', 1),
(29, 'other', 196),
(30, 'Ngezi', 1),
(31, 'china', 36);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_client`
--

CREATE TABLE `bsc_client` (
  `client_id` int(20) NOT NULL,
  `client` text NOT NULL,
  `profile` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_client`
--

INSERT INTO `bsc_client` (`client_id`, `client`, `profile`) VALUES
(1, 'IPC', ''),
(2, 'Getbucks', ''),
(3, 'Croco', ''),
(4, 'Barzem', ''),
(5, 'BankX', ''),
(6, 'Masaisai Trust', '');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_client_360_policy`
--

CREATE TABLE `bsc_client_360_policy` (
  `id` int(11) NOT NULL,
  `client_id` text NOT NULL,
  `mandatory` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_client_360_policy`
--

INSERT INTO `bsc_client_360_policy` (`id`, `client_id`, `mandatory`) VALUES
(1, '2', 1),
(2, '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_client_contact_details`
--

CREATE TABLE `bsc_client_contact_details` (
  `client_id` int(11) NOT NULL,
  `first_name` text,
  `middle_name` text,
  `last_name` text,
  `gender` text,
  `mobile` varchar(200) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `position` text,
  `level` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_client_contact_details`
--

INSERT INTO `bsc_client_contact_details` (`client_id`, `first_name`, `middle_name`, `last_name`, `gender`, `mobile`, `phone`, `position`, `level`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_client_credentials`
--

CREATE TABLE `bsc_client_credentials` (
  `client_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `employee_number` text,
  `supervisor_email` text,
  `status` varchar(30) DEFAULT '1',
  `special` int(11) NOT NULL DEFAULT '0',
  `date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_client_credentials`
--

INSERT INTO `bsc_client_credentials` (`client_id`, `email`, `password`, `employee_number`, `supervisor_email`, `status`, `special`, `date_time`) VALUES
(1, 'ipc@ipcconsultants.com', 'ipc', NULL, NULL, '1', 1, '2020-01-16 12:23:33'),
(2, 'patiencek@getbucks.com', 'getbucks', NULL, NULL, '1', 0, '2020-01-22 13:13:29'),
(3, 'angelag@crocoholdings.co.zw', 'croco', NULL, NULL, '1', 0, '2020-01-29 06:25:56'),
(4, 'awilliam@barzem.co.zw', 'barzem', NULL, NULL, '1', 0, '2020-02-06 06:41:57'),
(5, 'md@bankx.com', 'md', NULL, NULL, '1', 0, '2020-02-11 10:05:27'),
(6, 'admin@masaisai.co.zw', 'admin', NULL, NULL, '1', 0, '2020-03-11 09:33:42');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_client_notifications`
--

CREATE TABLE `bsc_client_notifications` (
  `notifications_id` int(11) NOT NULL,
  `client_id` varchar(100) NOT NULL,
  `user` int(25) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_client_perspectives`
--

CREATE TABLE `bsc_client_perspectives` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `perspective_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_client_perspectives`
--

INSERT INTO `bsc_client_perspectives` (`id`, `client_id`, `perspective_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 2, 1),
(6, 2, 2),
(7, 2, 3),
(8, 2, 4),
(9, 3, 1),
(10, 3, 2),
(11, 3, 3),
(12, 3, 4),
(13, 4, 1),
(14, 4, 2),
(15, 4, 3),
(16, 4, 4),
(17, 5, 1),
(18, 5, 2),
(19, 5, 3),
(20, 5, 4),
(21, 6, 1),
(22, 6, 2),
(23, 6, 3),
(24, 6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_client_work_address`
--

CREATE TABLE `bsc_client_work_address` (
  `client_id` int(11) NOT NULL,
  `stand_number` int(11) DEFAULT NULL,
  `street` text,
  `city` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_client_work_address`
--

INSERT INTO `bsc_client_work_address` (`client_id`, `stand_number`, `street`, `city`) VALUES
(1, 170, 'Arcturus Road', 'Harare'),
(2, NULL, NULL, NULL),
(3, NULL, NULL, NULL),
(4, NULL, NULL, NULL),
(5, NULL, NULL, NULL),
(6, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_client_work_details`
--

CREATE TABLE `bsc_client_work_details` (
  `client_id` int(11) NOT NULL,
  `company_name` text,
  `vat_number` text,
  `sector` int(11) DEFAULT NULL,
  `department` text,
  `tradename` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_client_work_details`
--

INSERT INTO `bsc_client_work_details` (`client_id`, `company_name`, `vat_number`, `sector`, `department`, `tradename`) VALUES
(1, 'IPC\r\n', NULL, NULL, NULL, 'IPC'),
(2, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, NULL, NULL),
(5, NULL, NULL, NULL, NULL, NULL),
(6, 'Masaisai Trust', NULL, NULL, NULL, 'Masaisai Trust');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_comments`
--

CREATE TABLE `bsc_comments` (
  `id` int(11) NOT NULL,
  `scorecard_id` text,
  `measure_id` text,
  `scope` text,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_comments`
--

INSERT INTO `bsc_comments` (`id`, `scorecard_id`, `measure_id`, `scope`, `comment`) VALUES
(1, '1', NULL, '2', NULL),
(2, '1', NULL, '1', '\n'),
(3, '2', NULL, '2', NULL),
(4, '2', NULL, '1', NULL),
(5, '3', NULL, '2', NULL),
(6, '3', NULL, '1', NULL),
(7, '4', NULL, '2', NULL),
(8, '4', NULL, '1', NULL),
(9, '5', NULL, '2', NULL),
(10, '5', NULL, '1', NULL),
(11, '6', NULL, '2', NULL),
(12, '6', NULL, '1', NULL),
(13, '7', NULL, '2', NULL),
(14, '7', NULL, '1', NULL),
(15, '8', NULL, '2', NULL),
(16, '8', NULL, '1', NULL),
(17, '9', NULL, '2', NULL),
(18, '9', NULL, '1', NULL),
(19, '10', NULL, '2', NULL),
(20, '10', NULL, '1', ''),
(21, '11', NULL, '2', NULL),
(22, '11', NULL, '1', NULL),
(23, '12', NULL, '2', NULL),
(24, '12', NULL, '1', NULL),
(25, '13', NULL, '2', NULL),
(26, '13', NULL, '1', NULL),
(27, '14', NULL, '2', NULL),
(28, '14', NULL, '1', NULL),
(29, '15', NULL, '2', ''),
(30, '15', NULL, '1', NULL),
(31, '16', NULL, '2', NULL),
(32, '16', NULL, '1', ''),
(33, '17', NULL, '2', NULL),
(34, '17', NULL, '1', NULL),
(35, '18', NULL, '2', NULL),
(36, '18', NULL, '1', ''),
(37, '19', NULL, '2', NULL),
(38, '19', NULL, '1', NULL),
(39, '20', NULL, '2', NULL),
(40, '20', NULL, '1', NULL),
(41, '21', NULL, '2', NULL),
(42, '21', NULL, '1', NULL),
(43, '22', NULL, '2', NULL),
(44, '22', NULL, '1', NULL),
(45, '23', NULL, '2', NULL),
(46, '23', NULL, '1', NULL),
(47, '24', NULL, '2', NULL),
(48, '24', NULL, '1', NULL),
(49, '25', NULL, '2', NULL),
(50, '25', NULL, '1', NULL),
(51, '26', NULL, '2', NULL),
(52, '26', NULL, '1', NULL),
(53, '27', NULL, '2', NULL),
(54, '27', NULL, '1', NULL),
(55, '10', '392', NULL, ''),
(56, '28', NULL, '2', NULL),
(57, '28', NULL, '1', NULL),
(58, '29', NULL, '2', NULL),
(59, '29', NULL, '1', NULL),
(60, '5', '440', NULL, 'KPI will help us track how much revenue we are losing from non paying clients.'),
(61, '5', '441', NULL, 'KPI will help us track long overdue invoices '),
(62, '30', NULL, '2', NULL),
(63, '30', NULL, '1', NULL),
(64, '31', NULL, '2', NULL),
(65, '31', NULL, '1', NULL),
(66, '32', NULL, '2', NULL),
(67, '32', NULL, '1', ''),
(68, '33', NULL, '2', NULL),
(69, '33', NULL, '1', NULL),
(70, '12', '212', NULL, ''),
(71, '6', '53', NULL, 'CV Reviewer was launched in January.'),
(72, '6', '33', NULL, 'Included Psychometric test revenue generated in January.'),
(75, '34', NULL, '2', NULL),
(76, '34', NULL, '1', NULL),
(77, '35', NULL, '2', NULL),
(78, '35', NULL, '1', NULL),
(79, '36', NULL, '2', NULL),
(80, '36', NULL, '1', ''),
(81, '37', NULL, '2', NULL),
(82, '37', NULL, '1', NULL),
(83, '38', NULL, '2', NULL),
(84, '38', NULL, '1', NULL),
(91, '42', NULL, '2', NULL),
(92, '42', NULL, '1', NULL),
(93, '43', NULL, '2', NULL),
(94, '43', NULL, '1', NULL),
(95, '44', NULL, '2', NULL),
(96, '44', NULL, '1', NULL),
(97, '45', NULL, '2', 'n,kcbvjn,fjnkcfjnk'),
(98, '45', NULL, '1', NULL),
(105, '1', '426', NULL, 'This is my comment'),
(106, '1', '426', NULL, 'This is my comment oijvdsuhvdsiuhfdsiuhfdsiuhiuhdsiudsujhdsudsdsjdsjhdskjhdskjdskj kjdsbdskjhbdskjhdskjhdskjdskjdskj\nhdsjhbdsjhdsjhdsjhdsjhdsjhds\nudsbdsjhbdskjhdskjdskjdskjds'),
(107, '1', '426', NULL, 'This is my comment fggghghghghghhhhghghghgh bvghhghghg'),
(108, '1', '491', NULL, 'nggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg\n jftttttttty'),
(109, '1', '491', NULL, 'bb'),
(110, '46', NULL, '2', NULL),
(111, '46', NULL, '1', NULL),
(112, '47', NULL, '2', NULL),
(113, '47', NULL, '1', NULL),
(114, '48', NULL, '2', NULL),
(115, '48', NULL, '1', NULL),
(116, '46', '568', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_config`
--

CREATE TABLE `bsc_config` (
  `id` int(11) NOT NULL,
  `domain_email` text NOT NULL,
  `reply_to` text NOT NULL,
  `copy_email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_consultant_in_charge`
--

CREATE TABLE `bsc_consultant_in_charge` (
  `consultant_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_consultant_notifications`
--

CREATE TABLE `bsc_consultant_notifications` (
  `notifications_id` int(11) NOT NULL,
  `user` int(25) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_country`
--

CREATE TABLE `bsc_country` (
  `country_id` int(11) NOT NULL,
  `country` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_country`
--

INSERT INTO `bsc_country` (`country_id`, `country`) VALUES
(1, 'Zimbabwe'),
(2, 'South Africa'),
(3, 'Afghanistan'),
(4, 'Albania'),
(5, 'Algeria'),
(6, 'Andorra'),
(7, 'Angola'),
(8, 'Antigua and Barbuda'),
(9, 'Argentina'),
(10, 'Armenia'),
(11, 'Australia'),
(12, 'Austria'),
(13, 'Azerbaijan'),
(14, 'Bangladesh'),
(15, 'Barbados'),
(16, 'Belarus'),
(17, 'Belgium'),
(18, 'Belize'),
(19, 'Benin'),
(20, 'Bhutan'),
(21, 'Bolivia'),
(22, 'Bosnia and Herzegovina'),
(23, 'Botswana'),
(24, 'Brazil'),
(25, 'Brunei'),
(26, 'Bulgaria'),
(27, 'Burkina Faso'),
(28, 'Burundi'),
(29, 'Cabo Verde'),
(30, 'Cambodia'),
(31, 'Cameroon'),
(32, 'Canada'),
(33, 'Central African Republic'),
(34, 'Chad'),
(35, 'Chile'),
(36, 'China'),
(37, 'Colombia'),
(38, 'Comoros'),
(39, 'Congo, Democratic Republic of the'),
(40, 'Congo, Republic of the'),
(41, 'Costa Rica'),
(42, 'Côte d’Ivoire'),
(43, 'Croatia'),
(44, 'Cuba'),
(45, 'Cyprus'),
(46, 'Czech Republic'),
(47, 'Denmark'),
(48, 'Djibouti'),
(49, 'Dominica'),
(50, 'Dominican Republic'),
(51, 'East Timor (Timor-Leste)'),
(52, 'Ecuador'),
(53, 'Egypt'),
(54, 'El Salvador'),
(55, 'Equatorial Guinea'),
(56, 'Eritrea'),
(57, 'Estonia'),
(58, 'Ethiopia'),
(59, 'Fiji'),
(60, 'Finland'),
(61, 'France'),
(62, 'Gabon'),
(63, 'The Gambia'),
(64, 'Georgia'),
(65, 'Germany'),
(66, 'Ghana'),
(67, 'Greece'),
(68, 'Grenada'),
(69, 'Guatemala'),
(70, 'Guinea'),
(71, 'Guinea-Bissau'),
(72, 'Guyana'),
(73, 'Haiti'),
(74, 'Honduras'),
(75, 'Hungary'),
(76, 'Iceland'),
(77, 'India'),
(78, 'Indonesia'),
(79, 'Iran'),
(80, 'Iraq'),
(81, 'Ireland'),
(82, 'Israel'),
(83, 'Italy'),
(84, 'Jamaica'),
(85, 'Japan'),
(86, 'Jordan'),
(87, 'Kazakhstan'),
(88, 'Kenya'),
(89, 'Kiribati'),
(90, 'Korea, North'),
(91, 'Korea, South'),
(92, 'Kosovo'),
(93, 'Kuwait'),
(94, 'Kyrgyzstan'),
(95, 'Laos'),
(96, 'Latvia'),
(97, 'Lebanon'),
(98, 'Lesotho'),
(99, 'Liberia'),
(100, 'Libya'),
(101, 'Liechtenstein'),
(102, 'Lithuania'),
(103, 'Luxembourg'),
(104, 'Macedonia'),
(105, 'Madagascar'),
(106, 'Malawi'),
(107, 'Malaysia'),
(108, 'Maldives'),
(109, 'Mali'),
(110, 'Malta'),
(111, 'Marshall Islands'),
(112, 'Mauritania'),
(113, 'Mauritius'),
(114, 'Mexico'),
(115, 'Micronesia, Federated States of'),
(116, 'Moldova'),
(117, 'Monaco'),
(118, 'Mongolia'),
(119, 'Montenegro'),
(120, 'Morocco'),
(121, 'Mozambique'),
(122, 'Myanmar (Burma)'),
(123, 'Namibia'),
(124, 'Nauru'),
(125, 'Nepal'),
(126, 'Netherlands'),
(127, 'New Zealand'),
(128, 'Nicaragua'),
(129, 'Niger'),
(130, 'Nigeria'),
(131, 'Norway'),
(132, 'Oman'),
(133, 'Pakistan'),
(134, 'Palau'),
(135, 'Panama'),
(136, 'Papua New Guinea'),
(137, 'Paraguay'),
(138, 'Peru'),
(139, 'Philippines'),
(140, 'Poland'),
(141, 'Portugal'),
(142, 'Qatar'),
(143, 'Romania'),
(144, 'Russia'),
(145, 'Rwanda'),
(146, 'Saint Kitts and Nevis'),
(147, 'Saint Lucia'),
(148, 'Saint Vincent and the Grenadines'),
(149, 'Samoa'),
(150, 'San Marino'),
(151, 'Sao Tome and Principe'),
(152, 'Saudi Arabia'),
(153, 'Senegal'),
(154, 'Serbia'),
(155, 'Seychelles'),
(156, 'Sierra Leone'),
(157, 'Singapore'),
(158, 'Slovakia'),
(159, 'Slovenia'),
(160, 'Solomon Islands'),
(161, 'Somalia'),
(162, 'South Africa'),
(163, 'Spain'),
(164, 'Sri Lanka'),
(165, 'Sudan'),
(166, 'Sudan, South'),
(167, 'Suriname'),
(168, 'Swaziland'),
(169, 'Sweden'),
(170, 'Switzerland'),
(171, 'Syria'),
(172, 'Taiwan'),
(173, 'Tajikistan'),
(174, 'Tanzania'),
(175, 'Thailand'),
(176, 'Togo'),
(177, 'Tonga'),
(178, 'Trinidad and Tobago'),
(179, 'Tunisia'),
(180, 'Turkey'),
(181, 'Turkmenistan'),
(182, 'Tuvalu'),
(183, 'Uganda'),
(184, 'Ukraine'),
(185, 'United Arab Emirates'),
(186, 'United Kingdom'),
(187, 'United States'),
(188, 'Uruguay'),
(189, 'Uzbekistan'),
(190, 'Vanuatu'),
(191, 'Vatican City'),
(192, 'Venezuela'),
(193, 'Vietnam'),
(194, 'Yemen'),
(195, 'Zambia'),
(196, 'other'),
(197, 'ziwewe'),
(198, 'malaba'),
(199, 'u');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_departments`
--

CREATE TABLE `bsc_departments` (
  `id` int(11) NOT NULL,
  `department` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_departments`
--

INSERT INTO `bsc_departments` (`id`, `department`) VALUES
(1, 'Demand Planning and Distribution '),
(2, 'Commercial Services'),
(3, 'Demand Planning and Warehousing '),
(4, 'Distribution'),
(9, 'Vending and Sales Shops'),
(10, 'Direct Services'),
(12, 'Sales Department'),
(13, 'Engineering '),
(14, 'Accounting'),
(15, 'Information Technology'),
(17, 'Marketing'),
(19, 'Internal Audit'),
(20, 'Manufacturing '),
(22, 'Human Resources'),
(28, 'Logistics '),
(29, 'Logistics Technical'),
(33, 'Procurement '),
(36, 'Production '),
(37, 'Quality Assurance'),
(38, 'Stores'),
(39, 'Finance and Administration'),
(40, 'Credit and Loans'),
(42, 'Monitoring and Evaluation'),
(43, 'Economics'),
(44, 'Analytics'),
(45, 'Consulting'),
(46, 'Quality control'),
(47, 'Planning'),
(48, 'Organisational Development'),
(49, 'Talent Management'),
(50, 'Office admin'),
(51, 'Operations'),
(52, 'Front Office'),
(53, 'House keeping'),
(54, 'Food and Beverages'),
(55, 'Outside Catering'),
(56, 'Functions'),
(57, 'Kitchen'),
(58, 'Maintenance'),
(59, 'Teaching'),
(60, 'Business Systems'),
(61, 'Commercial Banking'),
(62, 'Innovation and Digital'),
(63, 'Retail Banking'),
(64, 'Asset Management'),
(65, 'Audit and Risk');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_discussion`
--

CREATE TABLE `bsc_discussion` (
  `id` int(11) NOT NULL,
  `user` text NOT NULL,
  `topic_id` text NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_discussion_topic`
--

CREATE TABLE `bsc_discussion_topic` (
  `id` int(11) NOT NULL,
  `client_id` text NOT NULL,
  `topic` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_drafts`
--

CREATE TABLE `bsc_drafts` (
  `id` int(11) NOT NULL,
  `forwarded` varchar(10) NOT NULL DEFAULT '0',
  `reply_to` text,
  `recepient` text NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `sender` text NOT NULL,
  `status` varchar(1000) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_emails`
--

CREATE TABLE `bsc_emails` (
  `id` int(11) NOT NULL,
  `forwarded` varchar(100) NOT NULL DEFAULT '0',
  `reply_to` text,
  `recepient` text NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `sender` text NOT NULL,
  `status` varchar(1000) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_emails`
--

INSERT INTO `bsc_emails` (`id`, `forwarded`, `reply_to`, `recepient`, `subject`, `message`, `sender`, `status`, `date`) VALUES
(1, '0', '0', 'bis@ipcconsultants.com', 'Test Email', '<p>This is a test email.</p><p>Regards,</p><p>Admin</p>', 'ipc@ipcconsultants.com', '0', '2020-02-28 03:03:15');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_events`
--

CREATE TABLE `bsc_events` (
  `id` int(11) NOT NULL,
  `client_id` text NOT NULL,
  `level_id` text NOT NULL,
  `event` text NOT NULL,
  `start_date` text NOT NULL,
  `end_date` text NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_goals`
--

CREATE TABLE `bsc_goals` (
  `id` int(11) NOT NULL,
  `scorecard_id` text,
  `perspective_id` text,
  `goal` text,
  `company_goal` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_goals`
--

INSERT INTO `bsc_goals` (`id`, `scorecard_id`, `perspective_id`, `goal`, `company_goal`) VALUES
(1, '18', '1', 'Grow revenue \r\n', NULL),
(3, '18', '1', 'Manage  costs \r\n', NULL),
(4, '18', '2', 'Grow social media bases \r\n', NULL),
(5, '18', '2', 'Grow the business \r\n', NULL),
(6, '18', '3', 'Optimise portal\r\n', NULL),
(8, '18', '3', 'Comply with procedures\r\n', NULL),
(9, '18', '3', 'Toolkits development\r\n', NULL),
(10, '18', '4', 'Develop Self \r\n', NULL),
(11, '6', '1', 'Grow revenue \r\n', NULL),
(12, '6', '1', 'Manage  costs \r\n', NULL),
(13, '6', '2', 'Grow social meadia Bases \r\n', NULL),
(14, '6', '2', 'Grow the business \r\n', NULL),
(15, '6', '3', 'Optimise all portals \r\n', NULL),
(16, '6', '3', 'Comply with IPC procedures \r\n', NULL),
(17, '6', '3', 'Toolkits development\r\n', NULL),
(18, '6', '4', 'Develop Self \r\n', NULL),
(19, '20', '1', 'Grow revenue\r\n', ''),
(20, '20', '1', 'Manage  costs', ''),
(21, '20', '2', 'Grow the business', ''),
(22, '8', '1', 'Grow revenue', 'No options'),
(23, '20', '2', 'Deliver value to clients', ''),
(24, '8', '1', 'Manage  costs \r\n', NULL),
(25, '20', '3', 'Manage profitable projects', ''),
(26, '8', '2', 'Grow social media Bases \r\n', NULL),
(27, '20', '3', 'Comply with IPC procedures', ''),
(28, '20', '3', 'Develop new products/Services/Ideas', ''),
(29, '20', '4', 'Develop Self', ''),
(30, '8', '3', 'Comply with IPC procedures \r\n', NULL),
(31, '16', '1', 'Grow revenue', ''),
(32, '8', '4', 'Develop Self \r\n', NULL),
(34, '16', '1', 'Manage  costs \r\n', NULL),
(35, '16', '2', 'Grow social media bases \r\n', NULL),
(36, '21', '1', 'Grow Revenue', ''),
(37, '7', '1', 'Grow revenue \r\n', 'No options'),
(38, '15', '1', 'Grow revenue \r\n\r\n', 'No options'),
(39, '21', '1', 'Manage  costs \r\n', ''),
(40, '16', '2', 'Grow the business \r\n', NULL),
(41, '21', '2', 'Grow the business \r\n', ''),
(43, '26', '1', 'Grow revenue', NULL),
(44, '16', '3', 'Optimise portal\r\n', NULL),
(45, '15', '1', 'Manage  costs \r\n\r\n', ''),
(46, '7', '2', 'Grow the business \r\n', 'No options'),
(47, '21', '2', 'Deliver value to clients \r\n', ''),
(49, '21', '3', 'Manage profitable projects \r\n', ''),
(50, '26', '1', 'Manage Costs', NULL),
(51, '26', '2', 'Grow the business', NULL),
(52, '7', '2', 'Deliver value to clients \r\n', ''),
(54, '7', '3', 'Manage profitable projects \r\n', 'No options'),
(55, '26', '2', 'Deliver value to clients', NULL),
(57, '21', '3', 'Comply with IPC procedures \r\n', ''),
(58, '7', '3', 'Comply with IPC procedures \r\n', ''),
(59, '26', '3', 'Manage profitable projects', NULL),
(60, '21', '3', 'Develop new products/Services/Ideas\r\n', ''),
(62, '21', '4', 'Develop Self \r\n', ''),
(64, '7', '3', 'Develop new products/Services/Ideas\r\n', ''),
(65, '16', '3', 'Comply with IPC procedures \r\n', NULL),
(66, '16', '3', 'Toolkits development\r\n', NULL),
(67, '7', '4', 'Develop Self \r\n', 'No options'),
(72, '16', '4', 'Develop Self \r\n', NULL),
(73, '15', '4', 'Develop Self \r\n\r\n', 'No options'),
(75, '26', '3', 'Comply with IPC procedures', NULL),
(78, '26', '3', 'Develop new products/services/ideas', NULL),
(79, '26', '4', 'Develop self', NULL),
(80, '15', '2', 'Grow the business \r\n', 'No options'),
(81, '15', '3', 'Manage profitable projects \r\n', 'No options'),
(82, '12', '1', 'Grow revenue \r\n', 'No options'),
(83, '12', '1', 'Manage  costs \r\n', ''),
(84, '12', '2', 'Grow the business', 'No options'),
(86, '12', '2', 'Deliver value to clients \r\n', ''),
(87, '12', '3', 'Manage profitable projects \r\n', 'No options'),
(88, '11', '1', 'Grow Revenue', NULL),
(89, '12', '3', 'Comply with IPC procedures \r\n', ''),
(90, '11', '1', 'Manage Costs', NULL),
(91, '12', '3', 'Develop new products/Services/Ideas\r\n', ''),
(92, '12', '4', 'Develop Self \r\n', 'No options'),
(93, '11', '2', 'Grow the business', NULL),
(94, '11', '2', 'Deliver value to clients', NULL),
(95, '11', '3', 'Manage Profitable Projects', NULL),
(96, '11', '3', 'Comply with IPC procedures', NULL),
(97, '11', '4', 'Develop Self', NULL),
(98, '17', '1', 'Grow revenue', ''),
(99, '17', '1', 'Manage costs', ''),
(100, '17', '2', 'Grow the Business', NULL),
(101, '17', '2', 'Deliver value to clients', NULL),
(102, '17', '3', 'Manage profitable projects', NULL),
(103, '17', '3', 'Develop new products/Services/Ideas', NULL),
(104, '17', '4', 'Develop Self', NULL),
(105, '22', '1', 'Grow Revenue', ''),
(106, '22', '1', 'Manage Costs', NULL),
(107, '22', '2', 'Grow the Business', NULL),
(108, '22', '2', 'Deliver Value to Clients', NULL),
(109, '22', '3', 'Manage Profitable projects', NULL),
(110, '22', '4', 'Develop Self', NULL),
(111, '13', '1', 'Grow revenue \r\n', ''),
(112, '13', '1', 'Manage costs', ''),
(113, '13', '2', 'Grow the business', ''),
(114, '13', '3', 'Manage profitable projects \r\n', ''),
(115, '13', '3', 'Comply with IPC procedures \r\n', ''),
(116, '13', '3', 'Develop new products/Services/Ideas\r\n\r\n', ''),
(117, '13', '2', 'Deliver value to clients \r\n', NULL),
(118, '13', '4', 'Develop Self \r\n', ''),
(123, '3', '2', 'Grow the Business', NULL),
(124, '3', '1', 'Grow Revenue', NULL),
(125, '3', '3', 'Manage profitable products', NULL),
(127, '9', '1', 'Grow Revenue', NULL),
(128, '9', '1', 'Manage Costs', NULL),
(129, '9', '2', 'Grow the business', NULL),
(130, '9', '2', 'Deliver value to clients', NULL),
(131, '9', '3', 'Manage Profitable projects', NULL),
(132, '9', '3', 'Comply with IPC procedures', NULL),
(133, '9', '3', 'Develop new products/services/ideas', NULL),
(134, '9', '4', 'Develop Self', NULL),
(135, '3', '3', 'Comply with IPC procedures', NULL),
(136, '19', '1', 'Grow Revenue', NULL),
(137, '19', '1', 'Manage  costs', NULL),
(138, '19', '2', 'Grow social media bases', NULL),
(139, '19', '2', 'Grow the business', NULL),
(140, '19', '3', 'Optimise portal', NULL),
(141, '19', '3', 'Comply with procedures', NULL),
(142, '19', '3', 'Toolkits development', NULL),
(143, '19', '4', 'Develop Self', NULL),
(144, '7', '1', 'Manage Costs', ''),
(145, '10', '1', 'Grow Revenue', NULL),
(146, '22', '3', 'Comply with IPC', NULL),
(147, '10', '1', 'Manage Costs', NULL),
(148, '10', '2', 'Grow the Business', NULL),
(149, '22', '3', 'Develop New Products', NULL),
(150, '10', '2', 'Deliver Value to Clients', NULL),
(151, '10', '3', 'Manage Profitable Projects', NULL),
(152, '10', '3', 'Comply with IPC Procedures', NULL),
(153, '3', '1', 'Manage cost', NULL),
(154, '10', '3', 'Develop New Products/Services/Ideas', NULL),
(155, '10', '4', 'Develop Self', NULL),
(157, '27', '1', 'Grow Revenue', NULL),
(158, '11', '3', 'Develop new prod', ''),
(159, '15', '2', 'Deliver value to clients \r\n', NULL),
(160, '27', '2', 'Grow the business', 'No options'),
(161, '15', '3', 'Comply with IPC procedures \r\n', NULL),
(162, '15', '3', 'Develop new products/Services/Ideas\r\n', NULL),
(165, '27', '2', 'Deliver Value to Clients', ''),
(166, '27', '3', 'Manage profitable projects \r\n', 'No options'),
(167, '3', '3', 'Develop new products', NULL),
(168, '3', '4', 'Develop self', NULL),
(169, '1', '1', 'Grow Revenue', ''),
(170, '27', '3', 'Develop new products/Services/Ideas\r\n', ''),
(171, '27', '4', 'Self Development', 'No options'),
(172, '28', '1', 'Grow Revenue', ''),
(173, '28', '2', 'Increase market share', ''),
(174, '28', '3', 'Register As a commercial bank', ''),
(175, '28', '3', 'Automate processes', ''),
(176, '28', '4', 'Capacitate employees', ''),
(177, '5', '1', 'Reduce bad debts', ''),
(178, '5', '1', 'Reduce receivables collection period\r\n', ''),
(179, '5', '1', 'Manage Costs', ''),
(180, '5', '1', 'Reduce receivables collection period\r\n', ''),
(181, '5', '2', 'Satisfy customers\r\n', ''),
(182, '5', '3', 'Comply with internal procedures and policies\r\n', 'No options'),
(183, '5', '3', 'Respond to client queries on time\r\n', ''),
(184, '5', '3', 'Comply with Procedures & Reporting Calendar\r\n', ''),
(185, '5', '3', 'Adherence to supplier schedules \r\n', ''),
(186, '5', '3', 'Carry out compliance audits for consultants\r\n', ''),
(187, '5', '4', 'Develop capacity\r\n', 'No options'),
(189, '30', '1', 'Reduce receivables collection period', NULL),
(190, '30', '1', 'Reduce bad debts', NULL),
(191, '30', '1', 'Reduce receivables collection period', NULL),
(192, '30', '1', 'Manage Costs', NULL),
(193, '30', '2', 'Satisfy customers', NULL),
(194, '30', '3', 'Comply with internal procedures', NULL),
(195, '30', '3', 'Respond to client queries on time', NULL),
(196, '30', '3', 'Comply with procedures and reporting', NULL),
(197, '30', '3', 'Adhere to supplier schedules', NULL),
(198, '30', '3', 'Submit statutory returns on time', NULL),
(199, '30', '3', 'Carry out compliance audits for consultants', NULL),
(200, '30', '4', 'Develop Capacity', NULL),
(201, '14', '1', 'Reduce receivables collection period', 'No options'),
(202, '14', '1', 'Reduce bad debts', ''),
(204, '31', '1', 'Reduce receivables collection period', NULL),
(205, '31', '1', 'Reduce Bad Debts', NULL),
(207, '14', '1', 'Reduce Receivables Collection Period', ''),
(208, '31', '1', 'Reduce receivables collection period', NULL),
(209, '14', '2', 'Satisfy customers', 'No options'),
(210, '31', '1', 'Manage Costs', NULL),
(211, '31', '2', 'Satisfy customers', NULL),
(212, '31', '3', '%ge of Compliance time sheets', NULL),
(213, '31', '3', 'Respond to client queries on time', NULL),
(214, '31', '3', 'Comply with Procedures & Reporting Calendar', NULL),
(215, '31', '3', 'Adherence to supplier schedules', NULL),
(216, '31', '3', 'Submit statutory returns on time', NULL),
(217, '31', '3', 'Carry out compliance audits for consultants', NULL),
(218, '31', '4', 'Develop capacity', NULL),
(219, '14', '3', 'Comply with internal procedures', 'No options'),
(220, '14', '3', 'Respond to  client queries on time', ''),
(221, '14', '4', 'Develop Capacity', 'No options'),
(222, '32', '1', 'Grow occupancy levels', ''),
(223, '32', '1', 'Maximise assets utilisaton', ''),
(225, '1', '1', 'Reduce Receivables Collection Period', ''),
(226, '1', '1', 'Reduce Bad Debts', ''),
(227, '1', '1', 'Reduce Receivables Collection Periods', ''),
(228, '1', '1', 'Adhere to budgetary limits for expenses', ''),
(229, '1', '1', 'Manage costs', ''),
(230, '1', '2', 'Grow the business', ''),
(231, '1', '2', 'Grow social media basis', ''),
(232, '1', '2', 'Satisfy customers', ''),
(233, '1', '3', 'Manage Profitable projects', ''),
(234, '1', '3', 'Comply with internal procedures and policies', ''),
(235, '1', '4', 'Develop capacity', ''),
(236, '35', '1', 'Increase market share', ''),
(237, '35', '1', 'Manage costs', ''),
(238, '36', '1', 'Increase profit margin', ''),
(239, '36', '1', 'Reduce operating expenditure', ''),
(240, '36', '2', 'Increase customer satisfaction with service levels', ''),
(241, '36', '2', 'Increase customer satisfaction with new products and services', ''),
(242, '36', '3', 'Increase Market Share', ''),
(244, '36', '4', 'Increase staff capacity', ''),
(245, '42', '1', 'Grow Revenue', NULL),
(246, '42', '1', 'Manage Costs', NULL),
(247, '42', '2', 'Satisfy customer', NULL),
(248, '42', '3', 'Automate Processes', NULL),
(249, '42', '4', 'Capacitate employees', NULL),
(250, '43', '1', 'Increase revenue', NULL),
(251, '43', '4', 'Increase capacity', NULL),
(252, '43', '2', 'Increase social media reach', NULL),
(253, '43', '3', 'Increase compliance', NULL),
(254, '44', '1', 'Manage costs', NULL),
(255, '44', '2', 'Satisfy Customer', NULL),
(256, '44', '4', 'Acquire professional engineering certificates', NULL),
(257, '44', '3', 'Install solars', NULL),
(258, '45', '1', 'Grow revenue', NULL),
(259, '45', '1', 'Manage costs', NULL),
(260, '45', '2', 'Satisfy Customers', NULL),
(261, '45', '3', 'Automate processes', NULL),
(262, '45', '4', 'Write articles', NULL),
(263, '27', '1', 'Manage Costs', ''),
(264, '3', '2', 'Deliver value to clients', NULL),
(265, '17', '3', 'Comply with IPC Procedures', NULL),
(266, '8', '4', '360 degrees score', NULL),
(267, '46', '1', 'Reduce HR expenditure', ''),
(268, '46', '1', 'Reduce debtors', ''),
(269, '46', '1', 'Secure funding', ''),
(270, '46', '2', 'Improve Relationship with parents', ''),
(272, '46', '3', 'Maintain High Passrate', ''),
(273, '46', '3', 'Number of schools built', ''),
(274, '46', '3', 'Establish a conservation park', ''),
(275, '46', '4', 'Capacitate workforce', ''),
(276, '48', '2', 'Increase student satisfaction rate', NULL),
(277, '48', '3', 'Maintain High Pass Rate', NULL),
(278, '48', '4', 'Attend training workshops', NULL),
(279, '48', '2', 'Increase parent satisfaction rate', NULL),
(280, '48', '3', 'Increase classroom observation score', NULL),
(281, '48', '1', 'Reduce debtors', NULL),
(282, '47', '1', 'Grow revenue', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_half_yearly`
--

CREATE TABLE `bsc_half_yearly` (
  `id` int(11) NOT NULL,
  `target_id` text,
  `half` text,
  `amount` text,
  `evidence` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_half_yearly`
--

INSERT INTO `bsc_half_yearly` (`id`, `target_id`, `half`, `amount`, `evidence`, `date`) VALUES
(3, '436', NULL, NULL, NULL, '2020-01-27 08:35:15'),
(4, '439', NULL, NULL, NULL, '2020-01-27 08:40:59'),
(5, '505', NULL, NULL, NULL, '2020-02-04 13:40:35');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_levels`
--

CREATE TABLE `bsc_levels` (
  `id` varchar(2) NOT NULL,
  `level` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_levels`
--

INSERT INTO `bsc_levels` (`id`, `level`) VALUES
('1', 'Organisational '),
('2', 'Business Unit'),
('3', 'Departmental'),
('4', 'Individual');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_max_scorecards`
--

CREATE TABLE `bsc_max_scorecards` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `code` text NOT NULL,
  `start_date` text NOT NULL,
  `end_date` text NOT NULL,
  `max_scorecards` text NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_max_scorecards`
--

INSERT INTO `bsc_max_scorecards` (`id`, `client_id`, `code`, `start_date`, `end_date`, `max_scorecards`, `last_updated`) VALUES
(1, 1, 'cystsskssbbs1234nsnksjksjsdjksdddddddddddddddddddddlklkssueuieieoinemsdnbsdnmsdmnsdnmsdnsdmnsdnmsdmnsdmnsdmnsdnskjnqwqqJASNANJSASASMMMFDFDFDP', '2020-01-01', '2020-12-31', '35', '2020-04-08 05:10:36');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_measures_directory`
--

CREATE TABLE `bsc_measures_directory` (
  `id` int(11) NOT NULL,
  `scorecard_id` int(11) NOT NULL,
  `perspective_id` int(11) NOT NULL,
  `measures` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_measure_tasks`
--

CREATE TABLE `bsc_measure_tasks` (
  `id` int(11) NOT NULL,
  `measure_id` text NOT NULL,
  `task` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `due_date` text NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_measure_tasks`
--

INSERT INTO `bsc_measure_tasks` (`id`, `measure_id`, `task`, `status`, `due_date`, `last_updated`) VALUES
(1, '437', 'provide required information by authorities', 0, '2020-01-31', '2020-01-27 08:37:11');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_monthly`
--

CREATE TABLE `bsc_monthly` (
  `id` int(11) NOT NULL,
  `target_id` text,
  `month` text,
  `amount` text,
  `evidence` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_monthly`
--

INSERT INTO `bsc_monthly` (`id`, `target_id`, `month`, `amount`, `evidence`, `date`) VALUES
(3, '6', '2020-01', '0', NULL, '2020-02-03 09:50:26'),
(4, '7', '2020-01', '4.5', NULL, '2020-02-04 06:27:31'),
(5, '4', '2020-01', '0', NULL, '2020-03-06 09:34:46'),
(6, '8', '2020-01', '219', NULL, '2020-02-04 06:28:35'),
(7, '9', '2020-01', '802', NULL, '2020-02-03 14:09:34'),
(8, '10', '2020-01', '5', NULL, '2020-02-03 14:09:01'),
(9, '12', '2020-01', '76620', NULL, '2020-02-05 08:41:03'),
(10, '13', '2020-01', '58.17', NULL, '2020-02-04 06:35:01'),
(11, '19', '2020-01', '9.39', NULL, '2020-02-04 06:38:17'),
(12, '20', '2020-01', '19', NULL, '2020-02-04 06:37:30'),
(13, '21', '2020-01', '26', NULL, '2020-02-04 06:37:45'),
(15, '25', '2020-01', '100', NULL, '2020-02-05 06:03:49'),
(16, '26', '2020-01', '4', NULL, '2020-02-03 09:52:00'),
(17, '27', '2020-01', '14', NULL, '2020-02-05 06:10:31'),
(18, '28', NULL, NULL, NULL, '2020-01-17 10:44:49'),
(19, '29', NULL, NULL, NULL, '2020-01-17 10:44:49'),
(20, '30', '2020-01', '164.48', '5557-Terms of References.pdf', '2020-03-17 07:32:09'),
(21, '31', '2020-01', '0', NULL, '2020-02-03 14:04:11'),
(22, '32', '2020-01', '0', NULL, '2020-02-03 14:04:16'),
(23, '33', '2020-01', '859.58', NULL, '2020-02-04 12:46:01'),
(24, '52', '2020-01', '75.05', NULL, '2020-02-07 05:52:36'),
(25, '34', '2020-01', '-49', NULL, '2020-02-07 07:00:40'),
(26, '35', '2020-01', '219', NULL, '2020-02-03 14:05:57'),
(27, '36', '2020-01', '802', NULL, '2020-02-03 14:09:51'),
(28, '38', '2020-01', '15', NULL, '2020-02-03 14:11:01'),
(29, '39', '2020-01', '5', NULL, '2020-02-03 14:09:01'),
(31, '41', '2020-01', '8', NULL, '2020-02-03 14:07:57'),
(32, '42', '2020-01', '0', NULL, '2020-02-18 14:02:42'),
(33, '43', '2020-01', '76620', NULL, '2020-02-03 14:16:32'),
(34, '44', '2020-01', '58.71', NULL, '2020-02-03 14:16:22'),
(35, '45', '2020-01', '12', NULL, '2020-02-03 14:17:16'),
(36, '46', '2020-01', '17', NULL, '2020-02-03 14:17:29'),
(37, '47', '2020-01', '1', NULL, '2020-02-03 14:17:46'),
(38, '48', '2020-01', '16', NULL, '2020-02-03 14:18:01'),
(39, '49', '2020-01', '1', NULL, '2020-02-03 14:18:14'),
(40, '50', '2020-01', '19', NULL, '2020-02-03 14:21:00'),
(41, '51', '2020-01', '26', NULL, '2020-02-03 14:21:08'),
(43, '59', '2020-01', '200', NULL, '2020-02-04 07:04:16'),
(44, '60', '2020-01', '578.11', NULL, '2020-02-04 07:16:55'),
(45, '61', '2020-01', '98', NULL, '2020-02-04 07:24:09'),
(46, '62', '2020-01', '50', NULL, '2020-02-04 06:52:49'),
(48, '65', '2020-01', '0', NULL, '2020-02-04 07:40:05'),
(50, '66', '2020-01', '0', NULL, '2020-02-04 06:55:04'),
(51, '68', '2020-01', '14', NULL, '2020-02-06 07:55:12'),
(53, '69', '2020-01', '54', NULL, '2020-02-04 08:00:43'),
(54, '72', '2020-01', '12', NULL, '2020-02-06 12:22:07'),
(55, '73', '2020-01', '0', NULL, '2020-02-04 06:30:11'),
(56, '74', '2020-01', '0', NULL, '2020-02-04 06:29:16'),
(58, '70', '2020-01', '802', NULL, '2020-02-04 08:44:05'),
(59, '71', '2020-01', '219', NULL, '2020-02-04 08:46:00'),
(60, '76', '2020-01', '4', NULL, '2020-02-04 06:23:30'),
(61, '78', '2020-01', '290', NULL, '2020-02-04 07:41:25'),
(62, '77', '2020-01', '15', NULL, '2020-02-04 08:46:18'),
(63, '80', '2020-01', '5', NULL, '2020-02-04 08:46:39'),
(64, '81', '2020-01', '8', NULL, '2020-02-04 08:47:01'),
(65, '58', '2020-01', '9.39', NULL, '2020-02-03 14:22:07'),
(66, '54', '2020-01', '19', NULL, '2020-02-05 08:34:40'),
(67, '55', '2020-01', '52', NULL, '2020-02-05 07:07:09'),
(68, '82', '2020-01', '95', NULL, '2020-02-06 12:38:07'),
(69, '83', '2020-01', '88.6', NULL, '2020-02-05 06:07:48'),
(70, '86', '2020-01', '4', NULL, '2020-02-04 09:21:45'),
(71, '87', '2020-01', '54', NULL, '2020-02-04 09:18:10'),
(72, '88', NULL, NULL, NULL, '2020-01-17 13:07:23'),
(73, '85', '2020-01', '164.48', NULL, '2020-03-05 14:17:39'),
(74, '89', '2020-01', '0', NULL, '2020-02-04 14:32:17'),
(75, '91', '2020-01', '0', NULL, '2020-02-04 14:32:35'),
(76, '92', '2020-01', '4.40', NULL, '2020-03-06 07:24:40'),
(77, '94', '2020-01', '0', NULL, '2020-02-07 07:01:50'),
(78, '95', '2020-01', '219', NULL, '2020-03-06 06:59:59'),
(79, '96', '2020-01', '802', NULL, '2020-03-06 07:00:44'),
(81, '99', '2020-01', '3012.44', NULL, '2020-02-04 08:29:34'),
(82, '98', '2020-01', '5', NULL, '2020-03-06 07:03:14'),
(83, '102', '2020-01', '107', NULL, '2020-02-07 06:26:08'),
(84, '101', '2020-01', '200', NULL, '2020-02-04 08:10:01'),
(85, '106', '2020-01', '0', NULL, '2020-02-04 09:07:15'),
(86, '111', '2020-01', '43', NULL, '2020-02-04 09:10:14'),
(90, '109', '2020-01', '76620', NULL, '2020-02-04 06:10:32'),
(91, '114', '2020-01', '0', NULL, '2020-02-04 08:32:33'),
(93, '116', '2020-01', '58.17', NULL, '2020-02-04 06:10:12'),
(94, '118', '2020-01', '0', NULL, '2020-02-04 08:11:15'),
(96, '125', '2020-01', '101', NULL, '2020-02-07 05:49:47'),
(97, '117', '2020-02', '100', NULL, '2020-03-06 10:56:48'),
(99, '122', '2020-01', '0', NULL, '2020-03-06 10:57:06'),
(100, '129', '2020-01', '14', NULL, '2020-02-05 05:59:52'),
(102, '131', '2020-01', '0', NULL, '2020-03-06 10:57:58'),
(103, '134', '2020-01', '17', NULL, '2020-02-04 10:04:02'),
(105, '133', '2020-01', '19', NULL, '2020-02-04 06:08:38'),
(106, '124', '2020-01', '-24', NULL, '2020-02-05 07:23:49'),
(107, '135', '2020-01', '26', NULL, '2020-02-04 06:08:16'),
(108, '139', '2020-01', '0', NULL, '2020-02-04 10:06:04'),
(110, '141', '2020-01', '39', NULL, '2020-02-04 09:12:01'),
(111, '145', '2020-01', '11', NULL, '2020-02-07 09:18:03'),
(112, '143', '2020-01', '77.68', NULL, '2020-02-04 08:47:37'),
(113, '147', '2020-01', '0', NULL, '2020-02-04 08:11:42'),
(114, '146', '2020-01', '0', NULL, '2020-02-04 10:06:20'),
(115, '149', '2020-01', '12', NULL, '2020-02-07 06:24:47'),
(116, '150', '2020-01', '0', NULL, '2020-02-05 07:24:09'),
(117, '152', '2020-01', '0', NULL, '2020-02-05 06:48:12'),
(118, '151', '2020-01', '16', NULL, '2020-02-07 06:03:49'),
(120, '154', '2020-01', '0', NULL, '2020-03-06 11:24:06'),
(121, '123', '2020-01', '12', NULL, '2020-02-04 06:09:43'),
(122, '126', '2020-01', '17', NULL, '2020-02-04 06:09:27'),
(123, '127', '2020-01', '1', NULL, '2020-02-04 06:09:17'),
(124, '128', '2020-01', '16', NULL, '2020-02-04 06:09:03'),
(125, '130', '2020-01', '1', NULL, '2020-02-04 06:08:51'),
(126, '132', '2020-01', '9.39', NULL, '2020-02-04 06:11:26'),
(128, '161', '2020-01', '0', NULL, '2020-03-06 11:25:04'),
(129, '155', '2020-01', '56', NULL, '2020-02-10 14:11:26'),
(130, '157', '2020-01', '4', NULL, '2020-02-04 08:56:14'),
(131, '165', '2020-01', '4', NULL, '2020-02-04 08:26:49'),
(132, '166', '2020-01', '300', NULL, '2020-02-04 08:48:57'),
(133, '169', NULL, NULL, NULL, '2020-01-17 13:46:26'),
(134, '176', '2020-01', '4', NULL, '2020-02-07 05:37:40'),
(135, '181', '2020-01', '0', NULL, '2020-02-04 10:07:51'),
(136, '182', '2020-01', '0', NULL, '2020-02-04 10:08:23'),
(137, '178', '2020-01', '167', NULL, '2020-02-04 08:57:19'),
(138, '171', '2020-01', '4', NULL, '2020-02-04 06:11:53'),
(139, '174', '2020-01', '43', NULL, '2020-02-04 07:50:24'),
(142, '188', '2020-01', '0', NULL, '2020-02-04 08:12:20'),
(144, '191', '2020-01', '0', NULL, '2020-02-04 10:12:33'),
(145, '192', '2020-01', '31', NULL, '2020-02-13 06:44:36'),
(146, '172', '2020-01', '4', NULL, '2020-02-04 08:27:23'),
(149, '211', '2020-01', '242', NULL, '2020-02-05 14:55:51'),
(151, '216', '2020-01', '0', NULL, '2020-02-04 10:03:42'),
(152, '217', '2020-01', '0', NULL, '2020-02-04 10:04:04'),
(153, '193', '2020-01', '0', NULL, '2020-02-04 07:32:48'),
(154, '195', '2020-01', '411', NULL, '2020-02-04 07:33:57'),
(155, '194', '2020-01', '33', NULL, '2020-02-05 14:33:04'),
(156, '219', '2020-01', '0', NULL, '2020-02-04 10:04:48'),
(157, '220', '2020-01', '0', NULL, '2020-02-05 06:46:12'),
(159, '222', '2020-01', '0', NULL, '2020-02-05 06:47:25'),
(160, '223', '2020-01', '0', NULL, '2020-02-05 06:47:41'),
(161, '224', '2020-01', '0', NULL, '2020-02-05 06:48:06'),
(163, '226', '2020-01', '4', NULL, '2020-02-04 10:05:22'),
(164, '227', '2020-01', '324', NULL, '2020-02-04 10:46:19'),
(170, '252', '2020-01', '30', NULL, '2020-02-04 14:48:54'),
(171, '253', '2020-01', '0', NULL, '2020-02-04 14:40:16'),
(172, '254', '2020-01', '0', NULL, '2020-02-04 14:44:22'),
(173, '255', '2020-01', '0', NULL, '2020-02-07 06:02:13'),
(174, '256', '2020-01', '69.57', NULL, '2020-02-04 15:11:05'),
(175, '257', '2020-01', '3', NULL, '2020-02-04 14:50:17'),
(176, '258', '2020-01', '172', NULL, '2020-02-05 06:20:34'),
(177, '233', '2020-01', '0', NULL, '2020-03-02 10:01:59'),
(178, '234', '2020-01', '10', NULL, '2020-02-04 08:18:47'),
(179, '235', '2020-01', '60', NULL, '2020-03-02 10:03:45'),
(180, '236', '2020-01', '0', NULL, '2020-02-04 09:25:41'),
(181, '237', '2020-01', '0', NULL, '2020-02-04 09:02:28'),
(182, '238', '2020-01', '-21', NULL, '2020-02-06 06:16:02'),
(183, '239', '2020-01', '67.25', NULL, '2020-02-04 09:24:01'),
(187, '243', '2020-01', '0', NULL, '2020-02-04 09:20:26'),
(188, '244', '2020-01', '3', NULL, '2020-02-04 09:04:48'),
(189, '245', '2020-01', '75', NULL, '2020-02-04 09:19:40'),
(190, '246', '2020-01', '0', NULL, '2020-02-04 09:05:02'),
(191, '230', '2020-01', '7181.24', NULL, '2020-02-04 07:21:19'),
(192, '231', '2020-01', '25', NULL, '2020-02-06 06:19:39'),
(196, '263', '2020-01', '0', NULL, '2020-02-04 08:37:36'),
(198, '265', '2020-01', '0', NULL, '2020-02-04 08:30:35'),
(200, '267', '2020-01', '-59', NULL, '2020-03-06 11:14:42'),
(201, '268', '2020-01', '66.3', NULL, '2020-02-04 08:40:12'),
(203, '270', '2020-01', '0', NULL, '2020-02-04 08:35:18'),
(204, '271', '2020-01', '0', NULL, '2020-02-04 08:35:45'),
(205, '272', '2020-01', '0', NULL, '2020-02-04 07:57:52'),
(206, '273', '2020-01', '0', NULL, '2020-02-04 07:55:01'),
(207, '274', '2020-01', '4', NULL, '2020-02-04 08:29:53'),
(208, '275', '2020-01', '425', NULL, '2020-02-04 08:48:10'),
(210, '259', NULL, '0', NULL, '2020-02-03 15:40:55'),
(214, '285', '2020-01', '5', NULL, '2020-02-10 11:17:52'),
(217, '288', '2020-01', '5', NULL, '2020-02-14 05:28:56'),
(219, '79', NULL, NULL, NULL, '2020-01-20 13:32:18'),
(220, '294', NULL, NULL, NULL, '2020-01-20 14:20:41'),
(221, '297', NULL, NULL, NULL, '2020-01-20 14:22:29'),
(222, '298', NULL, NULL, NULL, '2020-01-20 14:47:24'),
(223, '299', NULL, NULL, NULL, '2020-01-20 14:47:24'),
(224, '300', NULL, NULL, NULL, '2020-01-20 14:47:24'),
(225, '301', NULL, NULL, NULL, '2020-01-20 14:47:24'),
(226, '302', NULL, NULL, NULL, '2020-01-20 14:47:24'),
(227, '303', NULL, NULL, NULL, '2020-01-20 14:47:25'),
(228, '304', NULL, NULL, NULL, '2020-01-20 14:47:25'),
(229, '305', NULL, NULL, NULL, '2020-01-20 14:47:25'),
(230, '306', NULL, NULL, NULL, '2020-01-20 14:47:25'),
(231, '307', NULL, NULL, NULL, '2020-01-20 14:47:25'),
(232, '308', NULL, NULL, NULL, '2020-01-20 14:47:25'),
(233, '309', NULL, NULL, NULL, '2020-01-20 14:47:26'),
(234, '310', NULL, NULL, NULL, '2020-01-20 14:47:26'),
(235, '311', NULL, NULL, NULL, '2020-01-20 14:47:26'),
(236, '284', '2020-01', '13883', NULL, '2020-02-14 06:51:52'),
(237, '290', '2020-01', '179', NULL, '2020-02-10 10:56:14'),
(238, '291', '2020-01', '73', NULL, '2020-02-10 12:19:24'),
(239, '14', '2020-01', '12', NULL, '2020-02-04 06:35:47'),
(240, '15', '2020-01', '17', NULL, '2020-02-04 06:35:37'),
(241, '16', '2020-01', '1', NULL, '2020-02-04 06:36:09'),
(242, '17', '2020-01', '16', NULL, '2020-02-04 06:36:27'),
(243, '18', '2020-01', '1', NULL, '2020-02-04 06:36:38'),
(244, '315', '2020-01', '164', NULL, '2020-02-03 07:20:53'),
(245, '316', '2020-01', '0', NULL, '2020-02-04 07:07:48'),
(246, '317', '2020-01', '0', NULL, '2020-02-05 06:49:36'),
(247, '318', '2020-01', '4.4', NULL, '2020-02-05 06:50:33'),
(248, '320', NULL, NULL, NULL, '2020-01-22 09:32:01'),
(249, '321', '2020-01', '219', NULL, '2020-02-04 06:47:02'),
(250, '323', '2020-01', '802', NULL, '2020-02-04 06:47:22'),
(251, '324', '2020-01', '5', NULL, '2020-02-04 06:47:59'),
(252, '325', '2020-01', '58.17', NULL, '2020-02-04 06:50:16'),
(253, '326', '2020-01', '76620', NULL, '2020-02-05 06:51:35'),
(254, '327', '2020-01', '12', NULL, '2020-02-04 06:50:41'),
(255, '328', '2020-01', '17', NULL, '2020-02-04 06:51:54'),
(256, '329', '2020-01', '1', NULL, '2020-02-04 06:52:22'),
(257, '330', '2020-01', '16', NULL, '2020-02-04 06:53:00'),
(258, '331', '2020-01', '1', NULL, '2020-02-04 06:53:21'),
(259, '332', '2020-01', '9.39', NULL, '2020-02-04 06:53:50'),
(260, '333', '2020-01', '19', NULL, '2020-02-04 06:54:25'),
(261, '334', '2020-01', '26', NULL, '2020-02-04 06:54:50'),
(262, '336', '2020-01', '100', NULL, '2020-02-04 06:59:11'),
(264, '338', '2020-01', '4', NULL, '2020-02-04 06:58:35'),
(265, '339', NULL, NULL, NULL, '2020-01-22 09:32:01'),
(266, '340', '2020-01', '0', NULL, '2020-02-04 07:00:21'),
(267, '341', '2020-01', '164.48', NULL, '2020-02-04 08:37:21'),
(268, '342', '2020-01', '0', NULL, '2020-02-05 06:10:21'),
(269, '343', '2020-01', '0', NULL, '2020-02-05 06:10:37'),
(270, '344', '2020-01', '76620', NULL, '2020-02-05 06:08:21'),
(271, '346', '2020-01', '15', NULL, '2020-03-06 07:03:45'),
(272, '345', '2020-01', '58.17', NULL, '2020-02-04 08:50:44'),
(273, '347', '2020-01', '8', NULL, '2020-03-06 07:05:38'),
(274, '348', '2020-01', '12', NULL, '2020-02-04 08:51:16'),
(275, '349', '2020-01', '17', NULL, '2020-02-04 08:51:34'),
(276, '350', '2020-01', '20', NULL, '2020-02-05 07:01:21'),
(277, '351', '2020-01', '1', NULL, '2020-02-04 08:51:55'),
(278, '352', '2020-01', '16', NULL, '2020-02-04 08:52:14'),
(280, '354', '2020-01', '9.39', NULL, '2020-02-04 08:53:37'),
(281, '355', '2020-01', '26', NULL, '2020-02-04 08:54:18'),
(282, '356', '2020-01', '19', NULL, '2020-02-04 08:54:36'),
(283, '357', '2020-01', '8', NULL, '2020-02-04 06:48:45'),
(284, '358', '2020-01', '15', NULL, '2020-02-04 06:48:29'),
(285, '196', '2020-01', '50', NULL, '2020-02-04 07:44:19'),
(287, '199', '2020-01', '0', NULL, '2020-02-04 07:41:50'),
(288, '201', '2020-01', '0', NULL, '2020-02-04 07:47:25'),
(289, '202', '2020-01', '-5250', NULL, '2020-02-05 07:41:04'),
(290, '205', '2020-01', '68.12', NULL, '2020-02-04 09:02:14'),
(292, '207', '2020-01', '0', NULL, '2020-02-04 12:31:52'),
(293, '208', '2020-01', '0', NULL, '2020-02-04 12:32:16'),
(294, '210', NULL, NULL, NULL, '2020-01-22 13:11:32'),
(295, '212', '2020-01', '4', NULL, '2020-02-04 06:44:48'),
(296, '213', '2020-01', '372', NULL, '2020-02-04 07:29:17'),
(298, '360', '2020-01', '55', NULL, '2020-02-07 06:05:31'),
(300, '362', '2020-01', '33.3', NULL, '2020-02-04 08:50:43'),
(301, '363', '2020-01', '0', NULL, '2020-02-04 08:34:19'),
(304, '115', '2020-01', '50', NULL, '2020-02-04 07:25:23'),
(305, '312', '2020-01', '56', NULL, '2020-02-10 10:51:20'),
(306, '313', '2020-01', '0', NULL, '2020-02-14 05:30:51'),
(307, '314', '2020-01', '0', NULL, '2020-02-14 05:31:18'),
(308, '364', '2020-01', '8', NULL, '2020-02-03 14:09:48'),
(309, '365', '2020-01', '15', NULL, '2020-02-04 06:29:25'),
(310, '248', '2020-01', '6704.53', NULL, '2020-02-05 06:19:58'),
(311, '228', '2020-01', '0', NULL, '2020-02-04 10:05:46'),
(312, '367', NULL, NULL, NULL, '2020-01-23 06:30:58'),
(313, '369', NULL, NULL, NULL, '2020-01-23 06:30:58'),
(314, '368', '2020-02', '74', NULL, '2020-03-03 14:02:21'),
(315, '370', NULL, NULL, NULL, '2020-01-23 06:31:58'),
(316, '371', '2020-01', '0', NULL, '2020-03-02 09:46:22'),
(317, '295', NULL, NULL, NULL, '2020-01-23 06:33:05'),
(318, '373', '2020-01', '0', NULL, '2020-03-02 09:46:45'),
(319, '375', NULL, '0', NULL, '2020-02-03 15:39:29'),
(320, '372', NULL, NULL, NULL, '2020-01-23 06:36:14'),
(321, '374', NULL, NULL, NULL, '2020-01-23 06:36:14'),
(322, '377', NULL, NULL, NULL, '2020-01-23 06:36:14'),
(323, '378', NULL, NULL, NULL, '2020-01-23 06:36:14'),
(324, '379', NULL, NULL, NULL, '2020-01-23 06:37:18'),
(325, '381', NULL, NULL, NULL, '2020-01-23 06:40:51'),
(326, '382', NULL, NULL, NULL, '2020-01-23 06:40:51'),
(327, '1', '2020-01', '164.48', NULL, '2020-02-03 06:52:48'),
(329, '385', NULL, NULL, NULL, '2020-01-23 06:44:16'),
(330, '387', NULL, NULL, NULL, '2020-01-23 06:44:16'),
(331, '389', NULL, NULL, NULL, '2020-01-23 06:44:16'),
(332, '391', NULL, NULL, NULL, '2020-01-23 06:45:38'),
(333, '376', '2020-01', '7302.53', NULL, '2020-02-04 08:11:22'),
(334, '390', NULL, NULL, NULL, '2020-01-23 06:46:29'),
(335, '113', '2020-01', '40', NULL, '2020-02-05 14:45:06'),
(336, '392', NULL, NULL, NULL, '2020-01-23 06:48:07'),
(337, '393', NULL, NULL, NULL, '2020-01-23 06:48:07'),
(338, '394', NULL, NULL, NULL, '2020-01-23 06:48:07'),
(339, '190', '2020-01', '0', NULL, '2020-02-04 08:23:21'),
(341, '399', '2020-01', '50', NULL, '2020-02-04 08:22:56'),
(342, '400', '2020-01', '0', NULL, '2020-02-04 08:15:47'),
(343, '396', '2020-01', '4520', NULL, '2020-02-04 09:27:02'),
(345, '401', '2020-01', '0', NULL, '2020-02-04 10:05:10'),
(347, '402', '2020-01', '0', NULL, '2020-02-04 08:15:13'),
(348, '407', '2020-01', '68.1', NULL, '2020-02-04 08:46:32'),
(349, '409', '2020-01', '21', NULL, '2020-02-13 06:48:30'),
(350, '408', '2020-01', '0', NULL, '2020-02-04 08:25:51'),
(351, '410', '2020-01', '0', NULL, '2020-02-04 08:26:26'),
(352, '411', '2020-01', '0', NULL, '2020-02-04 08:26:45'),
(353, '415', '2020-01', '200', NULL, '2020-02-04 09:31:08'),
(354, '416', '2020-01', '0', NULL, '2020-02-04 08:27:42'),
(355, '404', '2020-01', '67', NULL, '2020-02-04 10:27:53'),
(356, '405', '2020-01', '100', NULL, '2020-02-04 10:26:50'),
(357, '406', '2020-01', '0', NULL, '2020-02-04 10:28:43'),
(358, '414', '2020-01', '0', NULL, '2020-02-04 10:29:22'),
(359, '417', '2020-01', '-1753', NULL, '2020-02-06 14:30:23'),
(360, '418', '2020-01', '55', NULL, '2020-02-04 12:15:38'),
(361, '419', '2020-01', '25', NULL, '2020-02-06 14:02:07'),
(362, '420', '2020-01', '0', NULL, '2020-02-04 12:17:43'),
(363, '421', '2020-01', '0', NULL, '2020-02-04 12:17:57'),
(364, '428', '2020-01', '0', NULL, '2020-02-04 12:18:36'),
(366, '424', '2020-01', '200', NULL, '2020-02-10 11:59:23'),
(367, '425', '2020-01', '0', NULL, '2020-02-14 05:57:15'),
(371, '435', '2020-01', '700000', NULL, '2020-01-27 08:41:46'),
(372, '435', '2020-02', '1100000', NULL, '2020-01-27 08:43:42'),
(373, '435', NULL, NULL, NULL, '2020-01-27 08:43:42'),
(374, '440', '2020-01', '0', '14026-Data Structures and Algorithms in Java Fourth Edition.pdf', '2020-03-16 13:54:04'),
(375, '441', '2020-01', '11', NULL, '2020-02-06 13:11:19'),
(376, '443', NULL, NULL, NULL, '2020-01-28 10:03:25'),
(377, '444', '2020-01', '11', NULL, '2020-02-06 13:17:41'),
(378, '446', '2020-01', '74', NULL, '2020-02-06 13:37:58'),
(379, '447', '2020-01', '0', NULL, '2020-02-06 13:44:30'),
(380, '448', '2020-01', '0', NULL, '2020-02-06 13:46:10'),
(381, '449', '2020-01', '0', NULL, '2020-02-06 13:48:30'),
(382, '451', '2020-01', '100', NULL, '2020-02-06 13:49:59'),
(384, '466', '2020-01', '11', NULL, '2020-02-06 13:17:40'),
(385, '468', '2020-01', '0', NULL, '2020-02-06 13:07:50'),
(386, '473', '2020-01', '11', NULL, '2020-02-06 13:11:27'),
(387, '454', '2020-01', '11', NULL, '2020-02-06 13:16:41'),
(388, '455', '2020-01', '0', NULL, '2020-02-06 13:07:48'),
(389, '456', '2020-01', '11', NULL, '2020-02-06 13:12:33'),
(390, '457', '2020-01', '61', NULL, '2020-03-06 15:00:41'),
(391, '460', '2020-01', '0', NULL, '2020-02-06 13:44:42'),
(392, '461', '2020-01', '0', NULL, '2020-02-06 13:47:43'),
(393, '462', '2020-01', '0', NULL, '2020-02-06 13:48:53'),
(394, '463', '2020-01', '0', NULL, '2020-03-06 15:02:01'),
(395, '464', NULL, NULL, NULL, '2020-01-28 13:51:12'),
(396, '465', '2020-01', '100', NULL, '2020-02-06 13:49:57'),
(397, '470', '2020-01', '11', NULL, '2020-03-06 05:53:52'),
(398, '471', '2020-01', '0', NULL, '2020-02-06 13:07:38'),
(399, '474', '2020-01', '11', NULL, '2020-02-06 13:12:07'),
(400, '476', '2020-01', '61', NULL, '2020-03-06 06:00:19'),
(401, '479', '2020-01', '0', NULL, '2020-02-06 13:44:45'),
(402, '480', '2020-01', '0', NULL, '2020-02-06 13:46:32'),
(403, '481', '2020-01', '0', NULL, '2020-02-06 13:47:51'),
(404, '482', '2020-01', '0', NULL, '2020-02-06 13:48:49'),
(405, '483', NULL, NULL, NULL, '2020-01-28 14:19:30'),
(406, '484', '2020-01', '100', NULL, '2020-02-06 13:50:20'),
(407, '488', '2020-01', '100', NULL, '2020-01-29 10:14:41'),
(408, '489', '2020-01', '6', NULL, '2020-01-29 10:26:26'),
(409, '488', '2020-02', '90', NULL, '2020-01-29 10:20:58'),
(410, '488', '2020-03', '80', NULL, '2020-01-29 10:24:26'),
(411, '488', '2020-04', '95', NULL, '2020-01-29 10:25:15'),
(412, '488', NULL, NULL, NULL, '2020-01-29 10:25:15'),
(413, '489', NULL, NULL, NULL, '2020-01-29 10:26:26'),
(414, '429', '2020-01', '280', NULL, '2020-03-02 14:21:04'),
(415, '430', '2020-01', '4', NULL, '2020-03-02 14:20:48'),
(416, '431', '2020-01', '0', NULL, '2020-02-04 12:19:35'),
(417, '426', '2020-01', '49444.29', '88524-screenshots.docx', '2020-03-12 09:43:35'),
(418, '491', '2020-01', '11', NULL, '2020-02-04 14:08:08'),
(419, '492', '2020-01', '0', NULL, '2020-02-04 14:50:41'),
(420, '493', '2020-01', '10.92', NULL, '2020-02-04 14:51:51'),
(421, '494', NULL, NULL, NULL, '2020-01-30 08:12:46'),
(422, '495', '2020-01', '61', NULL, '2020-02-05 13:26:31'),
(423, '496', '2020-01', '5', NULL, '2020-02-06 12:24:42'),
(424, '497', '2020-01', '75', NULL, '2020-02-06 12:19:08'),
(425, '498', '2020-01', '100', NULL, '2020-02-06 12:19:50'),
(426, '499', '2020-01', '', NULL, '2020-02-06 12:24:27'),
(427, '500', '2020-01', '1049', NULL, '2020-02-06 12:28:22'),
(428, '501', '2020-01', '0', NULL, '2020-02-04 14:55:50'),
(429, '502', '2020-01', '33.37', NULL, '2020-02-04 15:09:03'),
(430, '503', '2020-01', '6.23', NULL, '2020-02-04 15:10:02'),
(431, '504', '2020-01', '7', NULL, '2020-02-05 07:05:33'),
(432, '505', '2020-01', '69', NULL, '2020-02-06 12:14:35'),
(433, '506', '2020-01', '100', NULL, '2020-02-04 15:10:36'),
(434, '1', '2020-02', '96.3', NULL, '2020-03-05 14:16:33'),
(435, '315', NULL, NULL, NULL, '2020-02-03 07:20:53'),
(436, '317', NULL, NULL, NULL, '2020-02-03 07:23:24'),
(437, '5', '2020-01', '0', NULL, '2020-02-03 09:50:16'),
(440, '30', '2020-02', '96.03', NULL, '2020-03-05 14:15:38'),
(453, '5', '2020-02', '0', NULL, '2020-03-06 09:39:18'),
(455, '6', '2020-02', '1', NULL, '2020-03-06 09:39:47'),
(456, '26', '2020-02', '4', NULL, '2020-03-02 10:50:03'),
(458, '26', NULL, NULL, NULL, '2020-02-03 09:52:00'),
(460, '31', NULL, NULL, NULL, '2020-02-03 14:04:11'),
(461, '32', '2020-02', '1', NULL, '2020-03-05 14:18:29'),
(464, '35', '2020-02', '132', NULL, '2020-03-05 14:28:45'),
(465, '8', '2020-02', '132', NULL, '2020-03-06 06:59:57'),
(466, '41', '2020-02', '1', NULL, '2020-03-06 07:05:28'),
(468, '41', NULL, NULL, NULL, '2020-02-03 14:06:31'),
(470, '10', '2020-02', '-23', NULL, '2020-03-06 07:03:06'),
(471, '39', '2020-02', '-23', NULL, '2020-03-05 14:54:00'),
(472, '9', '2020-02', '533', NULL, '2020-03-06 07:01:30'),
(473, '364', NULL, NULL, NULL, '2020-02-03 14:09:48'),
(474, '36', '2020-02', '533', NULL, '2020-03-05 14:51:17'),
(475, '38', '2020-02', '13', NULL, '2020-03-05 14:55:13'),
(480, '44', '2020-02', '62.24', NULL, '2020-03-05 15:04:03'),
(482, '45', '2020-02', '14', NULL, '2020-03-05 15:09:31'),
(483, '46', '2020-02', '16', NULL, '2020-03-05 15:06:52'),
(484, '46', NULL, NULL, NULL, '2020-02-03 14:17:25'),
(486, '47', '2020-02', '7', NULL, '2020-03-05 15:07:34'),
(487, '47', NULL, NULL, NULL, '2020-02-03 14:17:44'),
(488, '47', NULL, NULL, NULL, '2020-02-03 14:17:46'),
(490, '49', '2020-02', '1', NULL, '2020-03-05 15:08:39'),
(491, '50', '2020-02', '18', NULL, '2020-03-05 15:05:02'),
(492, '51', '2020-02', '27', NULL, '2020-03-05 15:04:52'),
(493, '58', '2020-02', '8.97', NULL, '2020-03-05 15:06:11'),
(503, '85', '2020-02', '96.03', NULL, '2020-03-05 14:18:03'),
(504, '92', '2020-02', '1262.60', NULL, '2020-03-06 07:25:36'),
(505, '95', '2020-02', '132', NULL, '2020-03-06 07:00:17'),
(506, '96', '2020-02', '533', NULL, '2020-03-06 07:00:56'),
(507, '98', '2020-02', '-23', NULL, '2020-03-06 07:03:10'),
(508, '346', '2020-02', '13', NULL, '2020-03-06 07:04:03'),
(509, '347', '2020-02', '1', NULL, '2020-03-06 07:05:50'),
(510, '109', '2020-02', '82244', NULL, '2020-03-06 07:12:14'),
(511, '109', NULL, NULL, NULL, '2020-02-03 14:37:01'),
(512, '116', '2020-02', '62.24', NULL, '2020-03-06 07:12:52'),
(517, '248', '2020-02', '14110.77', NULL, '2020-03-02 09:14:44'),
(518, '368', NULL, NULL, NULL, '2020-02-03 15:38:43'),
(519, '371', '2020-02', '0', NULL, '2020-03-02 09:46:30'),
(520, '373', '2020-02', '0', NULL, '2020-03-02 09:46:55'),
(521, '375', NULL, NULL, NULL, '2020-02-03 15:39:29'),
(522, '259', NULL, NULL, NULL, '2020-02-03 15:40:55'),
(523, '257', '2020-02', '3', NULL, '2020-03-02 10:11:14'),
(524, '257', NULL, NULL, NULL, '2020-02-03 15:42:21'),
(525, '257', NULL, NULL, NULL, '2020-02-03 15:42:39'),
(526, '248', NULL, NULL, NULL, '2020-02-04 05:57:08'),
(527, '123', '2020-02', '14', NULL, '2020-03-06 07:13:08'),
(528, '126', '2020-02', '16', NULL, '2020-03-06 07:13:45'),
(529, '127', '2020-02', '7', NULL, '2020-03-06 07:14:12'),
(530, '128', '2020-02', '15', NULL, '2020-03-06 07:14:35'),
(531, '130', '2020-02', '1', NULL, '2020-03-06 07:15:07'),
(532, '133', '2020-02', '18', NULL, '2020-03-06 07:16:03'),
(533, '135', '2020-02', '27', NULL, '2020-03-06 07:16:23'),
(534, '132', '2020-02', '8.97', NULL, '2020-03-06 07:15:32'),
(535, '171', '2020-02', '4', NULL, '2020-03-06 07:21:22'),
(536, '76', '2020-02', '4', NULL, '2020-03-04 14:32:27'),
(537, '76', NULL, NULL, NULL, '2020-02-04 06:23:37'),
(539, '8', NULL, NULL, NULL, '2020-02-04 06:28:35'),
(540, '74', '2020-02', '0', NULL, '2020-03-04 14:31:46'),
(541, '365', '2020-02', '13', NULL, '2020-03-06 07:25:53'),
(542, '75', NULL, NULL, NULL, '2020-02-04 06:29:50'),
(543, '73', '2020-02', '0', NULL, '2020-03-04 14:31:25'),
(544, '72', '2020-02', '0', NULL, '2020-03-04 14:30:49'),
(545, '72', NULL, NULL, NULL, '2020-02-04 06:30:46'),
(546, '78', NULL, NULL, NULL, '2020-02-04 06:34:26'),
(547, '78', NULL, NULL, NULL, '2020-02-04 06:34:40'),
(548, '13', '2020-02', '62.24', NULL, '2020-03-06 07:13:21'),
(549, '15', '2020-02', '16', NULL, '2020-03-06 07:13:53'),
(550, '14', '2020-02', '14', NULL, '2020-03-06 07:12:58'),
(551, '16', '2020-02', '7', NULL, '2020-03-06 07:14:21'),
(552, '17', '2020-04', '15', NULL, '2020-03-06 07:14:41'),
(553, '18', '2020-02', '1', NULL, '2020-03-06 07:15:09'),
(554, '20', '2020-02', '18', NULL, '2020-03-06 07:16:09'),
(555, '21', '2020-02', '27', NULL, '2020-03-06 07:16:38'),
(556, '19', '2020-02', '8.97', NULL, '2020-03-06 07:15:36'),
(557, '24', '2020-01', '79', NULL, '2020-02-06 13:00:19'),
(558, '212', '2020-02', '4', NULL, '2020-03-03 15:15:10'),
(559, '212', NULL, NULL, NULL, '2020-02-04 06:44:48'),
(561, '321', NULL, NULL, NULL, '2020-02-04 06:47:02'),
(562, '323', NULL, NULL, NULL, '2020-02-04 06:47:19'),
(563, '324', NULL, NULL, NULL, '2020-02-04 06:47:59'),
(564, '358', NULL, NULL, NULL, '2020-02-04 06:48:29'),
(565, '357', NULL, NULL, NULL, '2020-02-04 06:48:41'),
(567, '325', NULL, NULL, NULL, '2020-02-04 06:50:16'),
(568, '327', NULL, NULL, NULL, '2020-02-04 06:50:41'),
(569, '328', NULL, NULL, NULL, '2020-02-04 06:51:52'),
(570, '329', NULL, NULL, NULL, '2020-02-04 06:52:19'),
(571, '331', NULL, NULL, NULL, '2020-02-04 06:52:39'),
(572, '62', NULL, NULL, NULL, '2020-02-04 06:52:49'),
(573, '330', NULL, NULL, NULL, '2020-02-04 06:53:00'),
(574, '331', NULL, NULL, NULL, '2020-02-04 06:53:21'),
(576, '332', NULL, NULL, NULL, '2020-02-04 06:53:50'),
(577, '65', NULL, NULL, NULL, '2020-02-04 06:53:54'),
(578, '333', NULL, NULL, NULL, '2020-02-04 06:54:22'),
(580, '334', NULL, NULL, NULL, '2020-02-04 06:54:48'),
(581, '66', '2020-02', '0', NULL, '2020-03-04 14:35:34'),
(582, '66', NULL, NULL, NULL, '2020-02-04 06:55:35'),
(584, '336', NULL, NULL, NULL, '2020-02-04 06:58:57'),
(585, '336', NULL, NULL, NULL, '2020-02-04 06:59:11'),
(586, '340', NULL, NULL, NULL, '2020-02-04 07:00:14'),
(587, '340', NULL, NULL, NULL, '2020-02-04 07:00:25'),
(588, '59', '2020-02', '3206', NULL, '2020-03-04 14:33:53'),
(589, '316', NULL, NULL, NULL, '2020-02-04 07:07:48'),
(590, '60', NULL, NULL, NULL, '2020-02-04 07:16:51'),
(591, '60', NULL, NULL, NULL, '2020-02-04 07:16:55'),
(592, '60', NULL, NULL, NULL, '2020-02-04 07:16:58'),
(594, '230', '2020-02', '10258.66', NULL, '2020-03-02 09:15:54'),
(595, '230', NULL, NULL, NULL, '2020-02-04 07:21:19'),
(596, '61', NULL, NULL, NULL, '2020-02-04 07:24:09'),
(599, '231', NULL, NULL, NULL, '2020-02-04 07:26:13'),
(600, '75', NULL, NULL, NULL, '2020-02-04 07:28:12'),
(601, '213', NULL, NULL, NULL, '2020-02-04 07:29:17'),
(602, '213', NULL, NULL, NULL, '2020-02-04 07:29:26'),
(603, '215', NULL, NULL, NULL, '2020-02-04 07:29:55'),
(604, '193', '2020-02', '0', NULL, '2020-03-03 12:18:17'),
(605, '193', NULL, NULL, NULL, '2020-02-04 07:32:49'),
(608, '194', NULL, NULL, NULL, '2020-02-04 07:35:36'),
(609, '233', '2020-02', '0', NULL, '2020-03-02 10:02:22'),
(610, '65', NULL, NULL, NULL, '2020-02-04 07:40:05'),
(611, '65', NULL, NULL, NULL, '2020-02-04 07:40:18'),
(612, '78', NULL, NULL, NULL, '2020-02-04 07:41:25'),
(613, '78', NULL, NULL, NULL, '2020-02-04 07:41:36'),
(615, '199', NULL, NULL, NULL, '2020-02-04 07:41:50'),
(616, '75', NULL, NULL, NULL, '2020-02-04 07:41:55'),
(617, '75', NULL, NULL, NULL, '2020-02-04 07:42:08'),
(623, '201', '2020-02', '0', NULL, '2020-03-03 12:49:16'),
(625, '174', NULL, NULL, NULL, '2020-02-04 07:50:24'),
(628, '63', '2020-01', '65', NULL, '2020-02-06 07:54:51'),
(629, '273', '2020-02', '0', NULL, '2020-03-06 09:58:36'),
(631, '198', '2020-02', '38', NULL, '2020-03-03 12:46:41'),
(632, '272', '2020-02', '0', NULL, '2020-03-06 09:48:24'),
(637, '97', '2020-01', '70', NULL, '2020-02-04 08:04:22'),
(638, '97', '2020-02', '55', NULL, '2020-03-05 14:55:06'),
(639, '97', NULL, '', NULL, '2020-03-05 14:55:07'),
(640, '99', '2020-02', '2387.95', NULL, '2020-03-05 14:53:49'),
(641, '104', '2020-01', '7325.121852', NULL, '2020-02-05 06:15:16'),
(642, '101', '2020-02', '500', NULL, '2020-03-03 12:10:48'),
(643, '99', NULL, '', NULL, '2020-03-05 14:57:23'),
(644, '99', NULL, NULL, NULL, '2020-02-04 08:10:20'),
(646, '118', NULL, NULL, NULL, '2020-02-04 08:11:15'),
(647, '376', '2020-02', '800.11', NULL, '2020-03-03 12:43:04'),
(648, '376', NULL, NULL, NULL, '2020-02-04 08:11:34'),
(649, '147', NULL, NULL, NULL, '2020-02-04 08:11:42'),
(650, '188', NULL, NULL, NULL, '2020-02-04 08:12:20'),
(654, '113', '2020-02', '', NULL, '2020-03-03 12:44:28'),
(656, '122', NULL, NULL, NULL, '2020-02-04 08:12:54'),
(657, '113', NULL, NULL, NULL, '2020-02-04 08:12:55'),
(658, '122', NULL, NULL, NULL, '2020-02-04 08:13:02'),
(659, '131', '2020-02', '0', NULL, '2020-03-06 10:57:58'),
(660, '131', NULL, NULL, NULL, '2020-02-04 08:13:27'),
(661, '402', '2020-02', NULL, NULL, '2020-03-03 13:08:09'),
(662, '400', '2020-02', NULL, NULL, '2020-03-03 12:49:07'),
(663, '262', '2020-01', '125', NULL, '2020-02-07 06:24:25'),
(664, '262', '2020-02', '917', NULL, '2020-03-06 10:48:15'),
(665, '234', '2020-02', '25', NULL, '2020-03-02 10:10:34'),
(666, '399', '2020-02', '29', NULL, '2020-03-03 13:07:33'),
(667, '190', '2020-02', '50', NULL, '2020-03-03 12:48:17'),
(668, '192', '2020-02', '34', NULL, '2020-03-03 13:09:00'),
(669, '408', '2020-02', '0', NULL, '2020-03-03 13:11:14'),
(670, '409', '2020-02', '31', NULL, '2020-03-03 13:11:37'),
(671, '410', '2020-02', '0', NULL, '2020-03-03 13:12:13'),
(672, '411', '2020-02', '0', NULL, '2020-03-03 13:12:26'),
(673, '165', '2020-02', '4', NULL, '2020-03-06 11:18:06'),
(674, '172', '2020-02', '4', NULL, '2020-03-03 13:12:43'),
(675, '416', '2020-02', NULL, NULL, '2020-03-03 13:13:34'),
(676, '99', NULL, NULL, NULL, '2020-02-04 08:29:34'),
(677, '274', '2020-02', '4', NULL, '2020-03-06 09:55:11'),
(678, '99', NULL, NULL, NULL, '2020-02-04 08:30:09'),
(679, '265', '2020-02', '0', NULL, '2020-03-06 10:02:33'),
(680, '114', NULL, NULL, NULL, '2020-02-04 08:32:33'),
(681, '363', NULL, NULL, NULL, '2020-02-04 08:34:19'),
(682, '269', '2020-01', '12', NULL, '2020-02-07 07:06:31'),
(683, '269', '2020-02', '1', NULL, '2020-03-06 09:46:24'),
(684, '270', '2020-02', '0', NULL, '2020-03-06 09:47:33'),
(685, '270', NULL, NULL, NULL, '2020-02-04 08:35:32'),
(686, '271', '2020-02', '0', NULL, '2020-03-06 09:48:10'),
(688, '341', '2020-02', '96.03', NULL, '2020-03-05 14:17:20'),
(689, '263', '2020-02', '0', NULL, '2020-03-06 10:02:03'),
(692, '268', '2020-02', '50.15', NULL, '2020-03-06 10:14:46'),
(693, '64', '2020-01', '4.40', NULL, '2020-02-04 08:41:55'),
(695, '64', '2020-02', '2933', NULL, '2020-03-06 06:55:16'),
(696, '64', NULL, NULL, NULL, '2020-02-04 08:42:15'),
(697, '70', '2020-02', '533', NULL, '2020-03-06 07:00:45'),
(698, '221', '2020-01', '68.2', NULL, '2020-02-04 11:22:38'),
(700, '71', '2020-02', '132', NULL, '2020-03-06 07:00:21'),
(701, '77', '2020-02', '13', NULL, '2020-03-06 07:01:45'),
(702, '407', '2020-02', '69', NULL, '2020-03-03 13:10:32'),
(703, '80', '2020-02', '-23', NULL, '2020-03-06 07:02:27'),
(704, '407', NULL, NULL, NULL, '2020-02-04 08:46:43'),
(705, '81', '2020-02', '1', NULL, '2020-03-06 07:05:12'),
(707, '275', NULL, NULL, NULL, '2020-02-04 08:48:07'),
(708, '275', NULL, NULL, NULL, '2020-02-04 08:48:10'),
(710, '362', '2020-02', '16.7', NULL, '2020-03-06 10:50:17'),
(711, '345', '2020-02', '62.24', NULL, '2020-03-06 07:12:39'),
(712, '362', NULL, NULL, NULL, '2020-02-04 08:50:54'),
(713, '348', '2020-02', '14', NULL, '2020-03-06 07:12:59'),
(714, '349', '2020-02', '16', NULL, '2020-03-06 07:13:45'),
(715, '351', '2020-02', '7', NULL, '2020-03-06 07:14:11'),
(716, '352', '2020-02', '15', NULL, '2020-03-06 07:14:50'),
(717, '353', '2020-01', '1', NULL, '2020-02-04 08:53:08'),
(718, '353', '2020-02', '1', NULL, '2020-03-06 07:15:06'),
(719, '354', '2020-02', '8.97', NULL, '2020-03-06 07:15:30'),
(720, '355', '2020-02', '27', NULL, '2020-03-06 07:16:23'),
(721, '356', '2020-02', '18', NULL, '2020-03-06 07:16:07'),
(722, '157', NULL, NULL, NULL, '2020-02-04 08:56:14'),
(723, '178', NULL, NULL, NULL, '2020-02-04 08:57:19'),
(727, '205', '2020-02', '52', NULL, '2020-03-04 13:26:10'),
(728, '237', '2020-02', '0', NULL, '2020-03-02 10:05:15'),
(729, '244', '2020-02', '4', NULL, '2020-03-02 10:08:21'),
(730, '246', NULL, NULL, NULL, '2020-02-04 09:05:02'),
(731, '106', NULL, NULL, NULL, '2020-02-04 09:07:15'),
(732, '245', NULL, NULL, NULL, '2020-02-04 09:09:20'),
(733, '111', NULL, NULL, NULL, '2020-02-04 09:10:14'),
(734, '141', NULL, NULL, NULL, '2020-02-04 09:12:01'),
(735, '86', '2020-02', '4', NULL, '2020-03-06 07:17:05'),
(736, '87', '2020-02', '60', NULL, '2020-03-06 07:20:11'),
(737, '87', NULL, NULL, NULL, '2020-02-04 09:19:36'),
(738, '245', NULL, NULL, NULL, '2020-02-04 09:19:40'),
(739, '245', NULL, NULL, NULL, '2020-02-04 09:19:51'),
(740, '243', NULL, NULL, NULL, '2020-02-04 09:20:26'),
(741, '396', '2020-02', '12175.34', NULL, '2020-03-06 14:45:44'),
(743, '86', NULL, NULL, NULL, '2020-02-04 09:21:45'),
(745, '239', NULL, NULL, NULL, '2020-02-04 09:24:01'),
(746, '236', '2020-02', '0', NULL, '2020-03-02 10:04:41'),
(747, '396', NULL, NULL, NULL, '2020-02-04 09:26:09'),
(748, '396', NULL, NULL, NULL, '2020-02-04 09:27:02'),
(749, '415', '2020-02', '4', NULL, '2020-03-04 10:31:51'),
(751, '108', '2020-01', '18000', NULL, '2020-02-18 14:02:52'),
(753, '108', '2020-02', '18189.51', NULL, '2020-03-06 09:51:45'),
(755, '108', NULL, NULL, NULL, '2020-02-04 10:00:06'),
(759, '129', '2020-01', '16.7', NULL, '2020-03-06 10:37:56'),
(760, '216', '2020-02', '25', NULL, '2020-03-06 13:03:05'),
(761, '216', NULL, NULL, NULL, '2020-02-04 10:03:49'),
(762, '134', '2020-02', '63', NULL, '2020-03-06 10:25:58'),
(763, '217', '2020-02', '00', NULL, '2020-03-06 13:05:00'),
(764, '219', '2020-02', '0', NULL, '2020-03-06 14:33:09'),
(765, '129', NULL, NULL, NULL, '2020-02-04 10:04:50'),
(766, '401', '2020-02', '0', NULL, '2020-03-06 13:58:43'),
(767, '129', NULL, NULL, NULL, '2020-02-04 10:05:21'),
(768, '226', '2020-02', '4', NULL, '2020-03-06 13:59:04'),
(770, '228', '2020-02', '0', NULL, '2020-03-06 13:59:29'),
(772, '228', NULL, NULL, NULL, '2020-02-04 10:05:46'),
(773, '228', NULL, NULL, NULL, '2020-02-04 10:05:56'),
(774, '139', '2020-02', '0', NULL, '2020-03-06 10:26:36'),
(775, '146', '2020-02', '0', NULL, '2020-03-06 10:06:04'),
(776, '155', NULL, NULL, NULL, '2020-02-04 10:07:21'),
(777, '181', '2020-02', '0', NULL, '2020-03-06 10:06:21'),
(778, '176', NULL, NULL, NULL, '2020-02-04 10:08:14'),
(779, '182', NULL, NULL, NULL, '2020-02-04 10:08:23'),
(780, '187', '2020-01', '20', NULL, '2020-02-04 10:31:36'),
(782, '189', '2020-01', '1260', NULL, '2020-02-04 10:47:35'),
(783, '191', NULL, NULL, NULL, '2020-02-04 10:12:33'),
(785, '404', '2020-02', '93', NULL, '2020-03-02 13:16:56'),
(786, '405', '2020-02', '50', NULL, '2020-03-02 13:17:33'),
(787, '405', NULL, NULL, NULL, '2020-02-04 10:26:50'),
(788, '405', NULL, NULL, NULL, '2020-02-04 10:27:17'),
(789, '404', NULL, NULL, NULL, '2020-02-04 10:27:53'),
(790, '404', NULL, NULL, NULL, '2020-02-04 10:28:05'),
(791, '406', '2020-02', '0', NULL, '2020-03-02 13:18:06'),
(793, '414', '2020-02', '0', NULL, '2020-03-02 13:18:29'),
(794, '414', NULL, NULL, NULL, '2020-02-04 10:29:42'),
(796, '187', '2020-02', '21', NULL, '2020-03-06 10:20:59'),
(797, '227', NULL, NULL, NULL, '2020-02-04 10:46:19'),
(798, '189', NULL, NULL, NULL, '2020-02-04 10:47:35'),
(799, '380', '2020-01', '50', NULL, '2020-02-04 11:21:37'),
(800, '380', '2020-02', '0', NULL, '2020-03-06 13:55:03'),
(801, '380', NULL, NULL, NULL, '2020-02-04 11:21:47'),
(802, '221', NULL, NULL, NULL, '2020-02-04 11:22:38'),
(803, '418', '2020-02', '52', NULL, '2020-03-02 13:44:43'),
(804, '417', NULL, NULL, NULL, '2020-02-04 12:16:43'),
(805, '419', '2020-02', '20', NULL, '2020-03-02 13:45:07'),
(806, '420', '2020-02', '0', NULL, '2020-03-02 13:46:18'),
(807, '421', '2020-02', '0', NULL, '2020-03-02 13:46:45'),
(808, '421', NULL, NULL, NULL, '2020-02-04 12:18:16'),
(809, '428', '2020-02', '0', NULL, '2020-03-02 14:19:36'),
(810, '429', '2020-02', '300', NULL, '2020-03-02 14:21:07'),
(811, '431', NULL, NULL, NULL, '2020-02-04 12:19:35'),
(812, '431', NULL, NULL, NULL, '2020-02-04 12:19:48'),
(813, '430', '2020-02', '4', NULL, '2020-03-02 14:20:44'),
(815, '113', NULL, NULL, NULL, '2020-02-04 12:31:21'),
(817, '207', '2020-02', '0', NULL, '2020-03-03 15:14:00'),
(818, '207', NULL, NULL, NULL, '2020-02-04 12:31:58'),
(819, '208', '2020-02', '0', NULL, '2020-03-03 15:14:19'),
(820, '113', NULL, NULL, NULL, '2020-02-04 12:35:17'),
(838, '491', NULL, NULL, NULL, '2020-02-04 14:00:35'),
(839, '248', NULL, NULL, NULL, '2020-02-04 14:05:01'),
(840, '248', NULL, NULL, NULL, '2020-02-04 14:05:18'),
(845, '248', NULL, NULL, NULL, '2020-02-04 14:13:28'),
(846, '89', '2020-02', '0', NULL, '2020-03-06 07:26:06'),
(847, '91', '2020-02', '1', NULL, '2020-03-05 14:18:46'),
(848, '253', '2020-02', '0', NULL, '2020-03-02 09:39:52'),
(849, '254', '2020-02', '0', NULL, '2020-03-02 09:38:17'),
(851, '252', '2020-02', '0', NULL, '2020-03-02 09:35:38'),
(852, '257', NULL, NULL, NULL, '2020-02-04 14:50:17'),
(853, '257', NULL, NULL, NULL, '2020-02-04 14:50:40'),
(854, '492', NULL, NULL, NULL, '2020-02-04 14:50:41'),
(855, '493', '2020-02', '5', NULL, '2020-03-11 12:15:07'),
(857, '501', NULL, NULL, NULL, '2020-02-04 14:55:50'),
(858, '502', NULL, NULL, NULL, '2020-02-04 15:08:57'),
(859, '502', NULL, NULL, NULL, '2020-02-04 15:09:03'),
(860, '503', NULL, NULL, NULL, '2020-02-04 15:09:57'),
(865, '506', NULL, NULL, NULL, '2020-02-04 15:10:36'),
(866, '256', NULL, NULL, NULL, '2020-02-04 15:11:05'),
(867, '249', '2020-01', '19', NULL, '2020-02-05 14:29:42'),
(868, '108', NULL, NULL, NULL, '2020-02-05 05:55:01'),
(869, '108', NULL, NULL, NULL, '2020-02-05 05:55:14'),
(870, '129', NULL, NULL, NULL, '2020-02-05 05:59:52'),
(872, '83', '2020-02', '60', NULL, '2020-03-05 14:23:07'),
(873, '344', '2020-01', '82244', NULL, '2020-03-06 07:12:04'),
(874, '82', '2020-02', '90', NULL, '2020-03-05 14:19:30'),
(875, '342', NULL, NULL, NULL, '2020-02-05 06:10:21'),
(876, '27', NULL, NULL, NULL, '2020-02-05 06:10:31'),
(877, '343', '2020-02', '1', NULL, '2020-03-05 14:18:40'),
(878, '67', '2020-01', '0', NULL, '2020-02-07 07:01:55'),
(879, '104', '2020-02', '8209.38', NULL, '2020-03-06 10:46:48'),
(880, '248', NULL, NULL, NULL, '2020-02-05 06:14:55'),
(881, '104', NULL, NULL, NULL, '2020-02-05 06:15:06'),
(882, '104', NULL, NULL, NULL, '2020-02-05 06:15:08'),
(883, '104', NULL, NULL, NULL, '2020-02-05 06:15:16'),
(884, '248', NULL, NULL, NULL, '2020-02-05 06:19:44'),
(885, '248', NULL, NULL, NULL, '2020-02-05 06:19:58'),
(886, '248', NULL, NULL, NULL, '2020-02-05 06:20:12'),
(887, '258', NULL, NULL, NULL, '2020-02-05 06:20:34'),
(891, '53', '2020-01', '100', NULL, '2020-02-07 06:33:33'),
(892, '255', '2020-02', '0', NULL, '2020-03-06 14:39:08'),
(893, '267', '2020-02', '-91', NULL, '2020-03-06 11:10:57'),
(894, '211', '2020-02', '-314', NULL, '2020-03-06 13:03:14'),
(895, '211', NULL, NULL, NULL, '2020-02-05 06:45:34'),
(896, '220', '2020-02', '0', NULL, '2020-03-06 14:38:08'),
(898, '222', '2020-02', '1', NULL, '2020-03-06 13:59:59'),
(900, '223', '2020-02', '0', NULL, '2020-03-06 13:58:17'),
(901, '140', '2020-01', '-15', NULL, '2020-03-06 11:14:15'),
(903, '224', '2020-02', '0', NULL, '2020-03-06 13:58:32'),
(904, '152', '2020-02', '0', NULL, '2020-03-06 11:21:39'),
(907, '317', NULL, NULL, NULL, '2020-02-05 06:49:36'),
(908, '318', NULL, NULL, NULL, '2020-02-05 06:50:16'),
(909, '318', NULL, NULL, NULL, '2020-02-05 06:50:33'),
(915, '350', NULL, NULL, NULL, '2020-02-05 07:01:21'),
(920, '504', NULL, NULL, NULL, '2020-02-05 07:05:33'),
(922, '55', NULL, NULL, NULL, '2020-02-05 07:07:09'),
(923, '55', NULL, NULL, NULL, '2020-02-05 07:07:10'),
(925, '124', NULL, NULL, NULL, '2020-02-05 07:23:49'),
(926, '150', NULL, NULL, NULL, '2020-02-05 07:24:09'),
(927, '145', NULL, NULL, NULL, '2020-02-05 07:24:22'),
(928, '267', NULL, NULL, NULL, '2020-02-05 07:26:57'),
(929, '27', NULL, NULL, NULL, '2020-02-05 07:39:43'),
(930, '255', NULL, NULL, NULL, '2020-02-05 07:39:58'),
(932, '202', '2020-02', '-821', NULL, '2020-03-03 12:50:04'),
(933, '202', NULL, NULL, NULL, '2020-02-05 07:41:05'),
(934, '54', '2020-02', '20', NULL, '2020-03-05 14:59:02'),
(935, '12', '2020-02', '82244', NULL, '2020-03-06 07:12:13'),
(938, '495', NULL, NULL, NULL, '2020-02-05 13:26:31'),
(940, '102', NULL, NULL, NULL, '2020-02-05 14:26:34'),
(941, '249', '2020-02', '38', NULL, '2020-03-06 14:41:32'),
(942, '194', NULL, NULL, NULL, '2020-02-05 14:32:40'),
(943, '194', NULL, NULL, NULL, '2020-02-05 14:33:00'),
(945, '102', NULL, NULL, NULL, '2020-02-05 14:34:25'),
(946, '113', NULL, NULL, NULL, '2020-02-05 14:45:06'),
(947, '113', NULL, NULL, NULL, '2020-02-05 14:45:17'),
(948, '262', NULL, NULL, NULL, '2020-02-05 14:54:17'),
(949, '211', NULL, NULL, NULL, '2020-02-05 14:55:51'),
(950, '238', NULL, NULL, NULL, '2020-02-06 06:16:02'),
(951, '238', NULL, NULL, NULL, '2020-02-06 06:16:14'),
(952, '231', NULL, NULL, NULL, '2020-02-06 06:19:39'),
(953, '63', NULL, NULL, NULL, '2020-02-06 07:54:51'),
(954, '68', '2020-01', '91', NULL, '2020-03-04 14:29:06'),
(955, '62', NULL, NULL, NULL, '2020-02-06 07:56:17'),
(956, '509', '2020-02', '19', NULL, '2020-02-06 10:04:38'),
(957, '509', NULL, NULL, NULL, '2020-02-06 10:02:58'),
(958, '509', NULL, NULL, NULL, '2020-02-06 10:04:03'),
(959, '509', NULL, NULL, NULL, '2020-02-06 10:04:38'),
(960, '505', NULL, NULL, NULL, '2020-02-06 12:14:31'),
(961, '505', NULL, NULL, NULL, '2020-02-06 12:14:35'),
(962, '497', NULL, NULL, NULL, '2020-02-06 12:19:08'),
(963, '498', NULL, NULL, NULL, '2020-02-06 12:19:50'),
(964, '72', NULL, NULL, NULL, '2020-02-06 12:22:07'),
(965, '72', NULL, NULL, NULL, '2020-02-06 12:22:42'),
(966, '499', NULL, NULL, NULL, '2020-02-06 12:24:13'),
(968, '496', NULL, NULL, NULL, '2020-02-06 12:24:42'),
(969, '500', NULL, NULL, NULL, '2020-02-06 12:28:22'),
(970, '487', '2020-01', '100', NULL, '2020-02-06 13:49:53'),
(971, '82', NULL, NULL, NULL, '2020-02-06 12:38:07'),
(975, '206', '2020-01', '35', NULL, '2020-02-06 12:54:21'),
(976, '206', '2020-02', '3', NULL, '2020-03-03 15:12:57'),
(977, '24', '2020-02', '88', NULL, '2020-03-02 11:01:21'),
(978, '440', '2020-02', '0', NULL, '2020-03-05 14:17:41'),
(979, '471', '2020-02', '0', NULL, '2020-03-06 05:53:11'),
(980, '455', '2020-02', '0', NULL, '2020-03-06 14:52:42'),
(981, '468', NULL, NULL, NULL, '2020-02-06 13:07:50'),
(982, '455', NULL, NULL, NULL, '2020-02-06 13:08:08'),
(983, '160', '2020-01', '86', NULL, '2020-02-06 13:08:38'),
(984, '471', NULL, NULL, NULL, '2020-02-06 13:08:21'),
(985, '468', NULL, NULL, NULL, '2020-02-06 13:08:25'),
(986, '160', '2020-02', '94', NULL, '2020-03-06 07:18:17'),
(987, '162', '2020-01', '100', NULL, '2020-02-06 13:10:21'),
(988, '162', '2020-02', '', NULL, '2020-03-06 07:19:30'),
(989, '441', '2020-02', '6', NULL, '2020-03-05 14:19:50'),
(990, '473', NULL, NULL, NULL, '2020-02-06 13:11:27'),
(991, '474', '2020-02', '6', NULL, '2020-03-06 05:56:06'),
(992, '456', '2020-02', '6', NULL, '2020-03-06 14:53:07'),
(993, '474', NULL, NULL, NULL, '2020-02-06 13:12:41'),
(994, '454', '2020-02', '14', NULL, '2020-03-06 14:52:17'),
(995, '470', '2020-02', '14', NULL, '2020-03-06 05:55:21'),
(996, '466', NULL, NULL, NULL, '2020-02-06 13:17:40'),
(997, '444', '2020-02', '14', NULL, '2020-03-05 14:18:42'),
(998, '446', '2020-02', '93', NULL, '2020-03-05 14:22:05'),
(999, '445', '2020-01', '0', NULL, '2020-03-05 14:20:41'),
(1000, '446', NULL, NULL, NULL, '2020-02-06 13:37:58'),
(1001, '477', '2020-01', '0', NULL, '2020-03-06 06:02:37'),
(1002, '478', '2020-01', '100', NULL, '2020-02-06 13:41:53'),
(1003, '478', '2020-02', '100', NULL, '2020-03-06 06:21:31'),
(1004, '458', NULL, NULL, NULL, '2020-02-06 13:43:25'),
(1005, '459', '2020-01', '94', NULL, '2020-02-06 13:43:46'),
(1006, '475', '2020-01', '0', NULL, '2020-02-06 14:04:21'),
(1007, '485', NULL, NULL, NULL, '2020-02-06 13:43:45'),
(1008, '459', '2020-02', '100', NULL, '2020-03-06 14:58:04'),
(1009, '447', '2020-02', '0', NULL, '2020-03-05 14:25:21'),
(1010, '460', '2020-02', '0', NULL, '2020-03-06 14:58:43'),
(1011, '479', '2020-02', '0', NULL, '2020-03-06 06:22:05'),
(1012, '448', '2020-02', '0', NULL, '2020-03-05 14:25:55'),
(1013, '480', '2020-02', '0', NULL, '2020-03-06 06:22:22'),
(1014, '461', '2020-02', '0', NULL, '2020-03-06 14:59:18'),
(1015, '481', '2020-02', '0', NULL, '2020-03-06 06:27:38'),
(1016, '449', '2020-02', '0', NULL, '2020-03-05 14:32:09'),
(1017, '482', '2020-02', '0', NULL, '2020-03-06 06:28:31'),
(1018, '462', '2020-02', '0', NULL, '2020-03-06 14:59:51'),
(1019, '487', NULL, NULL, NULL, '2020-02-06 13:49:53'),
(1020, '465', '2020-02', '68', NULL, '2020-03-06 15:03:56'),
(1021, '451', '2020-02', '100', NULL, '2020-03-05 14:27:32'),
(1022, '484', '2020-02', '70', NULL, '2020-03-06 06:28:53'),
(1023, '463', '2020-02', '0', NULL, '2020-03-06 15:01:58'),
(1024, '419', NULL, NULL, NULL, '2020-02-06 14:02:07'),
(1025, '419', NULL, NULL, NULL, '2020-02-06 14:02:17'),
(1026, '475', NULL, NULL, NULL, '2020-02-06 14:04:21'),
(1027, '417', NULL, NULL, NULL, '2020-02-06 14:06:52'),
(1028, '417', NULL, NULL, NULL, '2020-02-06 14:30:23'),
(1029, '417', NULL, NULL, NULL, '2020-02-06 14:30:35'),
(1030, '176', NULL, NULL, NULL, '2020-02-07 05:37:40'),
(1031, '151', '2020-02', '1.4', NULL, '2020-03-06 10:07:03'),
(1033, '125', '2020-02', '-1.4', NULL, '2020-03-06 10:04:32'),
(1034, '52', '2020-02', '89.24', NULL, '2020-03-05 15:00:30'),
(1037, '151', NULL, NULL, NULL, '2020-02-07 05:58:41'),
(1041, '255', NULL, NULL, NULL, '2020-02-07 06:02:13'),
(1042, '255', NULL, NULL, NULL, '2020-02-07 06:02:24'),
(1043, '151', NULL, NULL, NULL, '2020-02-07 06:03:49'),
(1044, '360', '2020-02', '47', NULL, '2020-03-06 10:48:25'),
(1045, '360', NULL, NULL, NULL, '2020-02-07 06:05:42'),
(1047, '269', NULL, NULL, NULL, '2020-02-07 06:22:58'),
(1048, '262', NULL, NULL, NULL, '2020-02-07 06:24:25'),
(1049, '149', '2020-02', '6', NULL, '2020-03-06 11:22:21'),
(1050, '149', NULL, NULL, NULL, '2020-02-07 06:24:55'),
(1051, '102', NULL, NULL, NULL, '2020-02-07 06:26:08'),
(1052, '145', NULL, NULL, NULL, '2020-02-07 06:26:53'),
(1053, '53', '2020-02', '', NULL, '2020-03-06 07:20:39'),
(1054, '34', '2020-02', '4165', NULL, '2020-03-05 14:34:26'),
(1055, '94', NULL, NULL, NULL, '2020-02-07 07:01:50'),
(1056, '67', '2020-02', '0', NULL, '2020-03-06 06:56:20'),
(1057, '269', NULL, NULL, NULL, '2020-02-07 07:05:19'),
(1058, '269', NULL, NULL, NULL, '2020-02-07 07:06:31'),
(1059, '145', NULL, NULL, NULL, '2020-02-07 09:18:03'),
(1060, '423', '2020-01', '15', NULL, '2020-02-10 07:11:42'),
(1061, '423', '2020-02', '16', NULL, '2020-03-05 14:33:51'),
(1062, '423', NULL, NULL, NULL, '2020-02-10 07:11:42'),
(1063, '312', '2020-02', '18', NULL, '2020-03-05 14:31:14'),
(1064, '312', NULL, NULL, NULL, '2020-02-10 10:51:57'),
(1065, '290', NULL, '1', NULL, '2020-03-05 14:25:12'),
(1066, '290', NULL, NULL, NULL, '2020-02-10 10:56:47'),
(1071, '288', '2020-02', '30', NULL, '2020-03-05 14:21:22'),
(1073, '424', NULL, NULL, NULL, '2020-02-10 11:59:23'),
(1074, '422', '2020-01', '0', NULL, '2020-02-14 05:31:57'),
(1075, '291', '2020-02', '56', NULL, '2020-03-05 14:28:26'),
(1076, '291', NULL, NULL, NULL, '2020-02-10 12:19:41'),
(1077, '155', NULL, NULL, NULL, '2020-02-10 14:11:26'),
(1078, '288', NULL, NULL, NULL, '2020-02-10 14:31:25'),
(1079, '287', '2020-01', '0', NULL, '2020-02-14 05:28:03'),
(1081, '511', '2020-02', '200000', NULL, '2020-02-11 11:12:44'),
(1082, '511', '2020-03', '180000', NULL, '2020-02-11 11:13:10'),
(1084, '511', '2020-04', '70000', NULL, '2020-02-11 11:17:12'),
(1085, '511', '2020-05', '120000', NULL, '2020-02-11 11:17:29'),
(1086, '511', '2020-06', '70000', NULL, '2020-02-11 11:17:57'),
(1087, '511', NULL, NULL, NULL, '2020-02-11 11:16:31'),
(1089, '511', NULL, NULL, NULL, '2020-02-11 11:17:29'),
(1091, '519', '2020-01', '85', NULL, '2020-02-11 12:16:58'),
(1092, '522', '2020-02', '11000', NULL, '2020-02-11 12:13:43'),
(1093, '522', NULL, NULL, NULL, '2020-02-11 12:13:43'),
(1094, '517', '2020-01', '180000', NULL, '2020-02-11 12:15:36'),
(1095, '518', '2020-01', '3', NULL, '2020-02-11 12:16:15'),
(1096, '517', '2020-03', '300000', NULL, '2020-02-11 12:15:55'),
(1097, '517', NULL, NULL, NULL, '2020-02-11 12:15:55'),
(1098, '518', '2020-02', '4', NULL, '2020-02-11 12:16:23'),
(1099, '518', NULL, NULL, NULL, '2020-02-11 12:16:23'),
(1100, '519', '2020-02', '82', NULL, '2020-02-11 12:17:12'),
(1101, '519', NULL, NULL, NULL, '2020-02-11 12:16:58'),
(1102, '519', NULL, NULL, NULL, '2020-02-11 12:17:12'),
(1103, '524', '2020-02', '20', NULL, '2020-02-11 12:18:14'),
(1104, '524', NULL, NULL, NULL, '2020-02-11 12:18:14'),
(1105, '525', '2020-02', '98', NULL, '2020-02-11 12:19:53'),
(1106, '525', NULL, NULL, NULL, '2020-02-11 12:19:53'),
(1107, '527', NULL, NULL, NULL, '2020-02-11 12:24:19'),
(1108, '526', NULL, NULL, NULL, '2020-02-11 12:24:44'),
(1110, '192', NULL, NULL, NULL, '2020-02-13 06:44:36'),
(1111, '409', NULL, NULL, NULL, '2020-02-13 06:48:30'),
(1112, '287', NULL, '0', NULL, '2020-03-05 14:16:57'),
(1113, '287', NULL, NULL, NULL, '2020-02-14 05:28:31'),
(1114, '288', NULL, NULL, NULL, '2020-02-14 05:28:56'),
(1115, '288', NULL, NULL, NULL, '2020-02-14 05:30:03'),
(1116, '313', NULL, NULL, NULL, '2020-02-14 05:30:51'),
(1117, '314', NULL, NULL, NULL, '2020-02-14 05:31:18'),
(1118, '422', '2020-02', '0', NULL, '2020-03-02 10:06:27'),
(1119, '422', NULL, NULL, NULL, '2020-02-14 05:32:13'),
(1120, '530', '2020-01', '0.54', NULL, '2020-02-14 07:24:05'),
(1121, '425', '2020-02', '0', NULL, '2020-03-05 14:35:01'),
(1123, '530', '2020-02', '0', NULL, '2020-03-05 14:30:00'),
(1124, '530', NULL, NULL, NULL, '2020-02-14 07:34:44');
INSERT INTO `bsc_monthly` (`id`, `target_id`, `month`, `amount`, `evidence`, `date`) VALUES
(1125, '535', NULL, NULL, NULL, '2020-02-18 07:10:34'),
(1126, '531', '2020-01', '18000', NULL, '2020-02-18 07:13:40'),
(1127, '532', NULL, NULL, NULL, '2020-02-18 07:13:13'),
(1128, '533', NULL, NULL, NULL, '2020-02-18 07:13:13'),
(1129, '534', NULL, NULL, NULL, '2020-02-18 07:13:13'),
(1130, '531', NULL, NULL, NULL, '2020-02-18 07:13:40'),
(1131, '537', '2020-01', '40', NULL, '2020-02-18 13:56:23'),
(1132, '537', '2020-02', '', NULL, '2020-03-02 13:15:12'),
(1133, '537', NULL, NULL, NULL, '2020-02-18 13:56:37'),
(1135, '539', '2020-01', '0', NULL, '2020-02-18 14:03:03'),
(1136, '42', '2020-02', '0', NULL, '2020-03-05 15:08:56'),
(1137, '538', '2020-02', '0', NULL, '2020-03-05 14:22:22'),
(1138, '108', NULL, NULL, NULL, '2020-02-18 14:02:52'),
(1139, '539', '2020-02', '0', NULL, '2020-03-05 15:09:04'),
(1140, '540', NULL, NULL, NULL, '2020-02-18 14:10:06'),
(1141, '541', '2020-02', '0', NULL, '2020-03-02 13:48:21'),
(1142, '542', NULL, NULL, NULL, '2020-02-18 14:20:14'),
(1143, '248', NULL, NULL, NULL, '2020-03-02 08:29:56'),
(1144, '248', NULL, NULL, NULL, '2020-03-02 08:33:10'),
(1145, '248', NULL, NULL, NULL, '2020-03-02 08:33:35'),
(1146, '550', '2020-02', '96', NULL, '2020-03-02 09:01:50'),
(1147, '552', NULL, NULL, NULL, '2020-03-02 08:45:31'),
(1148, '547', NULL, NULL, NULL, '2020-03-02 08:47:37'),
(1149, '548', NULL, NULL, NULL, '2020-03-02 08:48:19'),
(1150, '549', '2020-02', '10', NULL, '2020-03-02 09:37:25'),
(1151, '551', NULL, NULL, NULL, '2020-03-02 08:48:19'),
(1152, '554', NULL, NULL, NULL, '2020-03-02 08:55:07'),
(1153, '550', NULL, NULL, NULL, '2020-03-02 09:01:50'),
(1154, '368', NULL, NULL, NULL, '2020-03-02 09:03:12'),
(1155, '230', NULL, NULL, NULL, '2020-03-02 09:14:43'),
(1156, '248', NULL, NULL, NULL, '2020-03-02 09:14:44'),
(1157, '230', NULL, NULL, NULL, '2020-03-02 09:14:50'),
(1158, '248', NULL, NULL, NULL, '2020-03-02 09:15:18'),
(1159, '230', NULL, NULL, NULL, '2020-03-02 09:15:35'),
(1160, '230', NULL, NULL, NULL, '2020-03-02 09:15:41'),
(1161, '230', NULL, NULL, NULL, '2020-03-02 09:15:54'),
(1162, '252', NULL, NULL, NULL, '2020-03-02 09:35:38'),
(1163, '549', NULL, NULL, NULL, '2020-03-02 09:36:09'),
(1164, '549', NULL, NULL, NULL, '2020-03-02 09:37:25'),
(1165, '254', NULL, NULL, NULL, '2020-03-02 09:38:17'),
(1166, '253', NULL, NULL, NULL, '2020-03-02 09:39:52'),
(1167, '234', NULL, NULL, NULL, '2020-03-02 09:40:51'),
(1168, '234', NULL, NULL, NULL, '2020-03-02 09:43:47'),
(1169, '371', NULL, NULL, NULL, '2020-03-02 09:46:30'),
(1170, '373', NULL, NULL, NULL, '2020-03-02 09:46:55'),
(1171, '233', NULL, NULL, NULL, '2020-03-02 10:01:59'),
(1172, '233', NULL, NULL, NULL, '2020-03-02 10:02:22'),
(1173, '235', '2020-02', '50', NULL, '2020-03-02 10:04:11'),
(1174, '235', NULL, NULL, NULL, '2020-03-02 10:03:11'),
(1175, '235', NULL, NULL, NULL, '2020-03-02 10:03:45'),
(1176, '235', NULL, NULL, NULL, '2020-03-02 10:04:11'),
(1177, '236', NULL, NULL, NULL, '2020-03-02 10:04:41'),
(1178, '237', NULL, NULL, NULL, '2020-03-02 10:05:15'),
(1179, '422', NULL, NULL, NULL, '2020-03-02 10:06:27'),
(1180, '244', NULL, NULL, NULL, '2020-03-02 10:08:21'),
(1181, '244', NULL, NULL, NULL, '2020-03-02 10:08:36'),
(1182, '234', NULL, NULL, NULL, '2020-03-02 10:10:34'),
(1183, '257', NULL, NULL, NULL, '2020-03-02 10:11:14'),
(1184, '26', NULL, NULL, NULL, '2020-03-02 10:50:03'),
(1185, '24', NULL, NULL, NULL, '2020-03-02 11:01:21'),
(1186, '546', NULL, NULL, NULL, '2020-03-02 11:38:52'),
(1187, '396', NULL, NULL, NULL, '2020-03-02 13:12:12'),
(1188, '396', NULL, NULL, NULL, '2020-03-02 13:12:25'),
(1189, '396', NULL, NULL, NULL, '2020-03-02 13:12:48'),
(1190, '396', NULL, NULL, NULL, '2020-03-02 13:13:37'),
(1191, '537', NULL, NULL, NULL, '2020-03-02 13:15:12'),
(1192, '537', NULL, NULL, NULL, '2020-03-02 13:15:32'),
(1193, '404', NULL, NULL, NULL, '2020-03-02 13:16:56'),
(1194, '405', NULL, NULL, NULL, '2020-03-02 13:17:33'),
(1195, '406', NULL, NULL, NULL, '2020-03-02 13:18:06'),
(1196, '414', NULL, NULL, NULL, '2020-03-02 13:18:29'),
(1197, '418', NULL, NULL, NULL, '2020-03-02 13:40:52'),
(1198, '418', NULL, NULL, NULL, '2020-03-02 13:44:43'),
(1199, '419', NULL, NULL, NULL, '2020-03-02 13:45:07'),
(1200, '420', NULL, NULL, NULL, '2020-03-02 13:46:18'),
(1201, '421', NULL, NULL, NULL, '2020-03-02 13:46:45'),
(1202, '541', NULL, NULL, NULL, '2020-03-02 13:48:21'),
(1203, '541', NULL, NULL, NULL, '2020-03-02 13:48:41'),
(1204, '428', NULL, NULL, NULL, '2020-03-02 14:19:36'),
(1205, '429', NULL, NULL, NULL, '2020-03-02 14:20:06'),
(1206, '430', NULL, NULL, NULL, '2020-03-02 14:20:44'),
(1207, '430', NULL, NULL, NULL, '2020-03-02 14:20:48'),
(1208, '429', NULL, NULL, NULL, '2020-03-02 14:21:04'),
(1209, '429', NULL, NULL, NULL, '2020-03-02 14:21:07'),
(1210, '101', NULL, NULL, NULL, '2020-03-03 12:10:48'),
(1211, '193', NULL, NULL, NULL, '2020-03-03 12:18:17'),
(1212, '195', '2020-02', '9735.34', NULL, '2020-03-03 12:25:56'),
(1213, '195', NULL, NULL, NULL, '2020-03-03 12:25:56'),
(1214, '376', NULL, NULL, NULL, '2020-03-03 12:43:04'),
(1215, '113', NULL, NULL, NULL, '2020-03-03 12:44:28'),
(1216, '190', NULL, NULL, NULL, '2020-03-03 12:44:56'),
(1217, '198', NULL, NULL, NULL, '2020-03-03 12:46:41'),
(1218, '198', NULL, NULL, NULL, '2020-03-03 12:46:55'),
(1219, '190', NULL, NULL, NULL, '2020-03-03 12:48:17'),
(1220, '196', NULL, NULL, NULL, '2020-03-03 12:48:35'),
(1221, '201', NULL, NULL, NULL, '2020-03-03 12:49:16'),
(1222, '202', NULL, NULL, NULL, '2020-03-03 12:49:59'),
(1223, '202', NULL, NULL, NULL, '2020-03-03 12:50:05'),
(1224, '399', NULL, NULL, NULL, '2020-03-03 13:07:33'),
(1225, '192', NULL, NULL, NULL, '2020-03-03 13:09:00'),
(1226, '407', NULL, NULL, NULL, '2020-03-03 13:10:32'),
(1227, '408', NULL, NULL, NULL, '2020-03-03 13:11:14'),
(1228, '409', NULL, NULL, NULL, '2020-03-03 13:11:37'),
(1229, '410', NULL, NULL, NULL, '2020-03-03 13:12:13'),
(1230, '411', NULL, NULL, NULL, '2020-03-03 13:12:23'),
(1231, '172', NULL, NULL, NULL, '2020-03-03 13:12:43'),
(1232, '368', NULL, NULL, NULL, '2020-03-03 14:02:21'),
(1233, '206', NULL, NULL, NULL, '2020-03-03 15:12:57'),
(1234, '207', NULL, NULL, NULL, '2020-03-03 15:14:00'),
(1235, '208', NULL, NULL, NULL, '2020-03-03 15:14:19'),
(1236, '212', NULL, NULL, NULL, '2020-03-03 15:15:10'),
(1237, '212', NULL, NULL, NULL, '2020-03-03 15:15:28'),
(1238, '97', NULL, NULL, NULL, '2020-03-04 07:05:14'),
(1239, '97', NULL, NULL, NULL, '2020-03-04 07:08:52'),
(1240, '415', NULL, NULL, NULL, '2020-03-04 10:31:51'),
(1241, '205', NULL, NULL, NULL, '2020-03-04 13:26:10'),
(1242, '205', NULL, NULL, NULL, '2020-03-04 13:26:28'),
(1243, '69', '2020-02', '68.1', NULL, '2020-03-04 14:25:48'),
(1247, '69', NULL, NULL, NULL, '2020-03-04 14:25:04'),
(1248, '69', NULL, NULL, NULL, '2020-03-04 14:25:48'),
(1249, '69', NULL, NULL, NULL, '2020-03-04 14:25:49'),
(1250, '68', NULL, NULL, NULL, '2020-03-04 14:29:06'),
(1251, '72', NULL, NULL, NULL, '2020-03-04 14:30:49'),
(1252, '73', NULL, NULL, NULL, '2020-03-04 14:31:25'),
(1253, '74', NULL, NULL, NULL, '2020-03-04 14:31:46'),
(1254, '76', NULL, NULL, NULL, '2020-03-04 14:32:27'),
(1255, '59', NULL, NULL, NULL, '2020-03-04 14:33:53'),
(1256, '66', NULL, NULL, NULL, '2020-03-04 14:35:34'),
(1257, '284', '2020-02', '24397', NULL, '2020-03-05 14:00:07'),
(1259, '285', NULL, '5', NULL, '2020-03-05 14:10:54'),
(1261, '284', NULL, NULL, NULL, '2020-03-05 13:58:12'),
(1263, '284', NULL, NULL, NULL, '2020-03-05 14:02:17'),
(1265, '284', NULL, NULL, NULL, '2020-03-05 14:02:44'),
(1266, '230', NULL, NULL, NULL, '2020-03-05 14:02:59'),
(1267, '230', NULL, NULL, NULL, '2020-03-05 14:03:10'),
(1268, '248', NULL, NULL, NULL, '2020-03-05 14:03:15'),
(1269, '441', NULL, NULL, NULL, '2020-03-05 14:08:26'),
(1270, '441', NULL, NULL, NULL, '2020-03-05 14:08:57'),
(1271, '441', NULL, NULL, NULL, '2020-03-05 14:09:09'),
(1272, '441', NULL, NULL, NULL, '2020-03-05 14:09:45'),
(1273, '441', NULL, NULL, NULL, '2020-03-05 14:09:49'),
(1274, '441', NULL, NULL, NULL, '2020-03-05 14:09:51'),
(1275, '285', NULL, NULL, NULL, '2020-03-05 14:10:54'),
(1276, '441', NULL, NULL, NULL, '2020-03-05 14:12:30'),
(1277, '30', NULL, NULL, NULL, '2020-03-05 14:15:38'),
(1278, '64', NULL, NULL, NULL, '2020-03-05 14:15:47'),
(1279, '441', NULL, NULL, NULL, '2020-03-05 14:16:01'),
(1280, '64', NULL, NULL, NULL, '2020-03-05 14:16:04'),
(1281, '441', NULL, NULL, NULL, '2020-03-05 14:16:09'),
(1282, '441', NULL, NULL, NULL, '2020-03-05 14:16:20'),
(1283, '1', NULL, NULL, NULL, '2020-03-05 14:16:33'),
(1284, '287', NULL, NULL, NULL, '2020-03-05 14:16:57'),
(1285, '341', NULL, NULL, NULL, '2020-03-05 14:17:20'),
(1286, '440', NULL, NULL, NULL, '2020-03-05 14:17:41'),
(1287, '85', NULL, NULL, NULL, '2020-03-05 14:18:03'),
(1290, '343', NULL, NULL, NULL, '2020-03-05 14:18:40'),
(1291, '444', NULL, NULL, NULL, '2020-03-05 14:18:42'),
(1292, '91', NULL, NULL, NULL, '2020-03-05 14:18:46'),
(1295, '82', NULL, NULL, NULL, '2020-03-05 14:19:30'),
(1296, '441', NULL, NULL, NULL, '2020-03-05 14:19:46'),
(1297, '441', NULL, NULL, NULL, '2020-03-05 14:19:50'),
(1298, '538', NULL, NULL, NULL, '2020-03-05 14:19:51'),
(1300, '6', NULL, NULL, NULL, '2020-03-05 14:19:59'),
(1301, '288', NULL, NULL, NULL, '2020-03-05 14:20:27'),
(1302, '445', '2020-02', '0', NULL, '2020-03-05 14:20:59'),
(1303, '288', NULL, NULL, NULL, '2020-03-05 14:20:58'),
(1304, '288', NULL, NULL, NULL, '2020-03-05 14:20:58'),
(1305, '445', NULL, NULL, NULL, '2020-03-05 14:20:59'),
(1306, '288', NULL, NULL, NULL, '2020-03-05 14:21:16'),
(1307, '288', NULL, NULL, NULL, '2020-03-05 14:21:24'),
(1308, '446', NULL, NULL, NULL, '2020-03-05 14:22:05'),
(1309, '538', NULL, NULL, NULL, '2020-03-05 14:23:05'),
(1310, '83', NULL, NULL, NULL, '2020-03-05 14:23:07'),
(1311, '83', NULL, NULL, NULL, '2020-03-05 14:24:06'),
(1312, '290', NULL, NULL, NULL, '2020-03-05 14:25:12'),
(1313, '447', NULL, NULL, NULL, '2020-03-05 14:25:21'),
(1314, '291', NULL, NULL, NULL, '2020-03-05 14:25:40'),
(1315, '448', NULL, NULL, NULL, '2020-03-05 14:25:55'),
(1316, '451', NULL, NULL, NULL, '2020-03-05 14:27:32'),
(1318, '291', NULL, NULL, NULL, '2020-03-05 14:28:59'),
(1319, '530', NULL, NULL, NULL, '2020-03-05 14:30:00'),
(1320, '312', NULL, NULL, NULL, '2020-03-05 14:31:14'),
(1321, '312', NULL, NULL, NULL, '2020-03-05 14:31:34'),
(1322, '449', NULL, NULL, NULL, '2020-03-05 14:32:09'),
(1323, '423', NULL, NULL, NULL, '2020-03-05 14:33:51'),
(1324, '34', NULL, NULL, NULL, '2020-03-05 14:34:26'),
(1325, '425', NULL, NULL, NULL, '2020-03-05 14:35:01'),
(1326, '97', NULL, NULL, NULL, '2020-03-05 14:42:53'),
(1327, '97', NULL, NULL, NULL, '2020-03-05 14:47:31'),
(1328, '99', NULL, NULL, NULL, '2020-03-05 14:47:48'),
(1330, '33', '2020-02', '1573.39', NULL, '2020-03-05 14:52:07'),
(1333, '99', NULL, NULL, NULL, '2020-03-05 14:52:50'),
(1334, '99', NULL, NULL, NULL, '2020-03-05 14:53:04'),
(1335, '99', NULL, NULL, NULL, '2020-03-05 14:53:49'),
(1337, '97', NULL, NULL, NULL, '2020-03-05 14:55:06'),
(1338, '97', NULL, NULL, NULL, '2020-03-05 14:55:07'),
(1340, '99', NULL, NULL, NULL, '2020-03-05 14:57:22'),
(1341, '99', NULL, NULL, NULL, '2020-03-05 14:57:23'),
(1344, '52', NULL, NULL, NULL, '2020-03-05 14:59:49'),
(1345, '52', NULL, NULL, NULL, '2020-03-05 15:00:30'),
(1346, '43', '2020-02', '82244', NULL, '2020-03-05 15:03:29'),
(1349, '44', NULL, NULL, NULL, '2020-03-05 15:03:46'),
(1352, '51', NULL, NULL, NULL, '2020-03-05 15:04:50'),
(1353, '51', NULL, NULL, NULL, '2020-03-05 15:04:52'),
(1354, '50', NULL, NULL, NULL, '2020-03-05 15:05:02'),
(1355, '58', NULL, NULL, NULL, '2020-03-05 15:06:11'),
(1356, '46', NULL, NULL, NULL, '2020-03-05 15:06:45'),
(1357, '46', NULL, NULL, NULL, '2020-03-05 15:06:47'),
(1359, '47', NULL, NULL, NULL, '2020-03-05 15:07:20'),
(1360, '47', NULL, NULL, NULL, '2020-03-05 15:07:34'),
(1361, '47', NULL, NULL, NULL, '2020-03-05 15:07:54'),
(1362, '48', '2020-02', '15', NULL, '2020-03-05 15:08:24'),
(1363, '48', NULL, NULL, NULL, '2020-03-05 15:08:16'),
(1364, '48', NULL, NULL, NULL, '2020-03-05 15:08:24'),
(1365, '49', NULL, NULL, NULL, '2020-03-05 15:08:32'),
(1366, '49', NULL, NULL, NULL, '2020-03-05 15:08:36'),
(1367, '49', NULL, NULL, NULL, '2020-03-05 15:08:40'),
(1368, '42', NULL, NULL, NULL, '2020-03-05 15:08:56'),
(1370, '45', NULL, NULL, NULL, '2020-03-05 15:09:31'),
(1371, '45', NULL, NULL, NULL, '2020-03-05 15:09:40'),
(1372, '471', NULL, NULL, NULL, '2020-03-06 05:53:11'),
(1373, '470', NULL, NULL, NULL, '2020-03-06 05:53:44'),
(1374, '470', NULL, NULL, NULL, '2020-03-06 05:53:52'),
(1375, '470', NULL, NULL, NULL, '2020-03-06 05:54:00'),
(1376, '470', NULL, NULL, NULL, '2020-03-06 05:55:21'),
(1377, '474', NULL, NULL, NULL, '2020-03-06 05:56:06'),
(1378, '476', '2020-02', '81', NULL, '2020-03-06 06:00:24'),
(1379, '476', NULL, NULL, NULL, '2020-03-06 05:59:31'),
(1380, '476', NULL, NULL, NULL, '2020-03-06 05:59:38'),
(1381, '476', NULL, NULL, NULL, '2020-03-06 06:00:19'),
(1382, '476', NULL, NULL, NULL, '2020-03-06 06:00:24'),
(1383, '477', '2020-02', '0', NULL, '2020-03-06 06:02:44'),
(1384, '477', NULL, NULL, NULL, '2020-03-06 06:02:37'),
(1385, '477', NULL, NULL, NULL, '2020-03-06 06:02:44'),
(1386, '478', NULL, NULL, NULL, '2020-03-06 06:21:31'),
(1387, '479', NULL, NULL, NULL, '2020-03-06 06:22:05'),
(1388, '480', NULL, NULL, NULL, '2020-03-06 06:22:22'),
(1389, '481', NULL, NULL, NULL, '2020-03-06 06:27:35'),
(1390, '481', NULL, NULL, NULL, '2020-03-06 06:27:38'),
(1391, '482', NULL, NULL, NULL, '2020-03-06 06:28:31'),
(1392, '484', NULL, NULL, NULL, '2020-03-06 06:28:53'),
(1393, '5', NULL, NULL, NULL, '2020-03-06 06:54:01'),
(1394, '64', NULL, NULL, NULL, '2020-03-06 06:55:16'),
(1395, '67', NULL, NULL, NULL, '2020-03-06 06:56:00'),
(1396, '67', NULL, NULL, NULL, '2020-03-06 06:56:20'),
(1397, '70', NULL, NULL, NULL, '2020-03-06 06:59:55'),
(1398, '8', NULL, NULL, NULL, '2020-03-06 06:59:57'),
(1399, '95', NULL, NULL, NULL, '2020-03-06 07:00:17'),
(1400, '71', NULL, NULL, NULL, '2020-03-06 07:00:21'),
(1401, '70', NULL, NULL, NULL, '2020-03-06 07:00:45'),
(1402, '96', NULL, NULL, NULL, '2020-03-06 07:00:56'),
(1403, '9', NULL, NULL, NULL, '2020-03-06 07:01:30'),
(1404, '77', NULL, NULL, NULL, '2020-03-06 07:01:45'),
(1405, '365', NULL, NULL, NULL, '2020-03-06 07:01:53'),
(1406, '80', NULL, NULL, NULL, '2020-03-06 07:02:27'),
(1407, '10', NULL, NULL, NULL, '2020-03-06 07:03:06'),
(1408, '98', NULL, NULL, NULL, '2020-03-06 07:03:10'),
(1409, '98', NULL, NULL, NULL, '2020-03-06 07:03:14'),
(1410, '346', NULL, NULL, NULL, '2020-03-06 07:03:45'),
(1411, '346', NULL, NULL, NULL, '2020-03-06 07:04:03'),
(1412, '81', NULL, NULL, NULL, '2020-03-06 07:05:12'),
(1413, '41', NULL, NULL, NULL, '2020-03-06 07:05:28'),
(1414, '347', NULL, NULL, NULL, '2020-03-06 07:05:50'),
(1416, '105', '2020-01', '0', NULL, '2020-03-06 07:08:05'),
(1417, '556', '2020-01', '0', NULL, '2020-03-06 07:09:04'),
(1418, '105', '2020-02', '0', NULL, '2020-03-06 07:08:21'),
(1419, '105', NULL, NULL, NULL, '2020-03-06 07:08:21'),
(1420, '556', '2020-02', '0', NULL, '2020-03-06 07:09:23'),
(1421, '556', NULL, NULL, NULL, '2020-03-06 07:09:23'),
(1422, '11', '2020-01', '0', NULL, '2020-03-06 07:11:42'),
(1423, '557', '2020-01', '0', NULL, '2020-03-06 09:23:01'),
(1424, '11', '2020-02', '0', NULL, '2020-03-06 09:23:49'),
(1425, '557', '2020-02', '0', NULL, '2020-03-06 09:23:08'),
(1426, '344', NULL, NULL, NULL, '2020-03-06 07:12:04'),
(1427, '12', NULL, NULL, NULL, '2020-03-06 07:12:04'),
(1428, '12', NULL, NULL, NULL, '2020-03-06 07:12:13'),
(1429, '109', NULL, NULL, NULL, '2020-03-06 07:12:14'),
(1430, '345', NULL, NULL, NULL, '2020-03-06 07:12:39'),
(1432, '116', NULL, NULL, NULL, '2020-03-06 07:12:52'),
(1433, '14', NULL, NULL, NULL, '2020-03-06 07:12:58'),
(1434, '348', NULL, NULL, NULL, '2020-03-06 07:12:59'),
(1435, '123', NULL, NULL, NULL, '2020-03-06 07:13:08'),
(1436, '126', NULL, NULL, NULL, '2020-03-06 07:13:45'),
(1437, '349', NULL, NULL, NULL, '2020-03-06 07:13:45'),
(1438, '15', NULL, NULL, NULL, '2020-03-06 07:13:53'),
(1439, '351', NULL, NULL, NULL, '2020-03-06 07:14:11'),
(1440, '127', NULL, NULL, NULL, '2020-03-06 07:14:12'),
(1441, '16', NULL, NULL, NULL, '2020-03-06 07:14:21'),
(1442, '352', NULL, NULL, NULL, '2020-03-06 07:14:32'),
(1443, '128', NULL, NULL, NULL, '2020-03-06 07:14:35'),
(1444, '352', NULL, NULL, NULL, '2020-03-06 07:14:36'),
(1445, '17', NULL, NULL, NULL, '2020-03-06 07:14:41'),
(1446, '352', NULL, NULL, NULL, '2020-03-06 07:14:50'),
(1447, '353', NULL, NULL, NULL, '2020-03-06 07:15:06'),
(1448, '130', NULL, NULL, NULL, '2020-03-06 07:15:07'),
(1449, '18', NULL, NULL, NULL, '2020-03-06 07:15:09'),
(1450, '354', NULL, NULL, NULL, '2020-03-06 07:15:30'),
(1451, '132', NULL, NULL, NULL, '2020-03-06 07:15:32'),
(1452, '19', NULL, NULL, NULL, '2020-03-06 07:15:36'),
(1453, '355', NULL, NULL, NULL, '2020-03-06 07:15:50'),
(1454, '133', NULL, NULL, NULL, '2020-03-06 07:16:03'),
(1455, '356', NULL, NULL, NULL, '2020-03-06 07:16:07'),
(1456, '20', NULL, NULL, NULL, '2020-03-06 07:16:09'),
(1457, '355', NULL, NULL, NULL, '2020-03-06 07:16:23'),
(1458, '135', NULL, NULL, NULL, '2020-03-06 07:16:23'),
(1459, '21', NULL, NULL, NULL, '2020-03-06 07:16:38'),
(1460, '160', NULL, NULL, NULL, '2020-03-06 07:16:49'),
(1461, '86', NULL, NULL, NULL, '2020-03-06 07:17:05'),
(1463, '160', NULL, NULL, NULL, '2020-03-06 07:17:10'),
(1464, '160', NULL, NULL, NULL, '2020-03-06 07:17:44'),
(1465, '87', NULL, NULL, NULL, '2020-03-06 07:17:59'),
(1466, '160', NULL, NULL, NULL, '2020-03-06 07:18:17'),
(1469, '87', NULL, NULL, NULL, '2020-03-06 07:20:11'),
(1471, '53', NULL, NULL, NULL, '2020-03-06 07:20:39'),
(1473, '171', NULL, NULL, NULL, '2020-03-06 07:21:22'),
(1474, '171', NULL, NULL, NULL, '2020-03-06 07:21:33'),
(1475, '92', NULL, NULL, NULL, '2020-03-06 07:25:02'),
(1478, '365', NULL, NULL, NULL, '2020-03-06 07:25:53'),
(1479, '89', NULL, NULL, NULL, '2020-03-06 07:26:06'),
(1498, '7', '2020-02', '1262.60', NULL, '2020-03-06 09:38:31'),
(1503, '557', NULL, NULL, NULL, '2020-03-06 08:32:54'),
(1507, '11', NULL, NULL, NULL, '2020-03-06 08:47:18'),
(1508, '4', NULL, NULL, NULL, '2020-03-06 09:34:46'),
(1509, '7', NULL, NULL, NULL, '2020-03-06 09:38:31'),
(1510, '271', NULL, NULL, NULL, '2020-03-06 09:48:10'),
(1511, '272', NULL, NULL, NULL, '2020-03-06 09:48:24'),
(1512, '274', NULL, NULL, NULL, '2020-03-06 09:55:11'),
(1513, '273', NULL, NULL, NULL, '2020-03-06 09:58:36'),
(1514, '263', NULL, NULL, NULL, '2020-03-06 10:02:03'),
(1515, '265', NULL, NULL, NULL, '2020-03-06 10:02:33'),
(1517, '125', NULL, NULL, NULL, '2020-03-06 10:04:32'),
(1518, '146', NULL, NULL, NULL, '2020-03-06 10:06:04'),
(1519, '181', NULL, NULL, NULL, '2020-03-06 10:06:21'),
(1521, '268', NULL, NULL, NULL, '2020-03-06 10:14:46'),
(1522, '561', '2020-01', '6726.5', NULL, '2020-03-06 10:16:25'),
(1523, '561', '2020-02', '304.27', NULL, '2020-03-06 10:18:02'),
(1524, '561', NULL, NULL, NULL, '2020-03-06 10:18:02'),
(1525, '187', NULL, NULL, NULL, '2020-03-06 10:20:59'),
(1526, '134', NULL, NULL, NULL, '2020-03-06 10:25:58'),
(1527, '139', NULL, NULL, NULL, '2020-03-06 10:26:36'),
(1528, '115', '2020-02', '33', NULL, '2020-03-06 10:52:52'),
(1529, '115', NULL, NULL, NULL, '2020-03-06 10:52:52'),
(1530, '117', NULL, NULL, NULL, '2020-03-06 10:55:48'),
(1531, '140', '2020-02', '114', NULL, '2020-03-06 11:14:03'),
(1532, '140', NULL, NULL, NULL, '2020-03-06 11:14:03'),
(1533, '165', NULL, NULL, NULL, '2020-03-06 11:18:06'),
(1534, '152', NULL, NULL, NULL, '2020-03-06 11:21:39'),
(1535, '154', '2020-02', '0', NULL, '2020-03-06 11:23:48'),
(1536, '154', NULL, NULL, NULL, '2020-03-06 11:23:48'),
(1537, '161', '2020-02', '0', NULL, '2020-03-06 11:24:59'),
(1538, '161', NULL, NULL, NULL, '2020-03-06 11:24:59'),
(1539, '565', NULL, NULL, NULL, '2020-03-06 11:33:15'),
(1540, '564', NULL, NULL, NULL, '2020-03-06 11:33:27'),
(1542, '217', NULL, NULL, NULL, '2020-03-06 13:05:00'),
(1543, '223', NULL, NULL, NULL, '2020-03-06 13:58:17'),
(1544, '224', NULL, NULL, NULL, '2020-03-06 13:58:32'),
(1545, '401', NULL, NULL, NULL, '2020-03-06 13:58:43'),
(1546, '226', NULL, NULL, NULL, '2020-03-06 13:59:04'),
(1547, '222', NULL, NULL, NULL, '2020-03-06 13:59:59'),
(1548, '566', '2020-01', '882.11', NULL, '2020-03-06 14:31:35'),
(1549, '566', '2020-02', '1006.38', NULL, '2020-03-06 14:29:11'),
(1550, '566', NULL, NULL, NULL, '2020-03-06 14:29:11'),
(1551, '219', NULL, NULL, NULL, '2020-03-06 14:33:09'),
(1552, '220', NULL, NULL, NULL, '2020-03-06 14:38:08'),
(1553, '249', NULL, NULL, NULL, '2020-03-06 14:41:32'),
(1554, '454', NULL, NULL, NULL, '2020-03-06 14:52:17'),
(1555, '456', NULL, NULL, NULL, '2020-03-06 14:53:07'),
(1556, '459', NULL, NULL, NULL, '2020-03-06 14:58:04'),
(1557, '460', NULL, NULL, NULL, '2020-03-06 14:58:43'),
(1558, '461', NULL, NULL, NULL, '2020-03-06 14:59:18'),
(1559, '462', NULL, NULL, NULL, '2020-03-06 14:59:51'),
(1560, '457', '2020-02', '81', NULL, '2020-03-06 15:00:54'),
(1561, '457', NULL, NULL, NULL, '2020-03-06 15:00:54'),
(1562, '463', NULL, NULL, NULL, '2020-03-06 15:01:58'),
(1563, '465', NULL, NULL, NULL, '2020-03-06 15:03:56'),
(1564, '568', '2020-01', '35', NULL, '2020-03-11 16:50:11'),
(1565, '570', NULL, NULL, NULL, '2020-03-11 10:33:53'),
(1566, '571', NULL, NULL, NULL, '2020-03-11 10:33:54'),
(1567, '493', NULL, NULL, NULL, '2020-03-11 12:15:07'),
(1568, '568', '2020-02', '50', NULL, '2020-03-11 16:51:30'),
(1569, '568', '2020-03', '30', NULL, '2020-03-11 16:53:10'),
(1570, '568', NULL, NULL, NULL, '2020-03-11 16:52:14'),
(1571, '426', NULL, NULL, NULL, '2020-03-12 09:51:52');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_notification_status`
--

CREATE TABLE `bsc_notification_status` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_notification_status`
--

INSERT INTO `bsc_notification_status` (`id`, `status`, `status_name`) VALUES
(1, 0, 'unread'),
(2, 1, 'read');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_payments`
--

CREATE TABLE `bsc_payments` (
  `id` int(11) NOT NULL,
  `client_id` text NOT NULL,
  `amount` text NOT NULL,
  `tockens_bought` text NOT NULL,
  `tockens_used` text NOT NULL,
  `level` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_pep`
--

CREATE TABLE `bsc_pep` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `scorecard_id` text NOT NULL,
  `reason` text NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_pep_check_list`
--

CREATE TABLE `bsc_pep_check_list` (
  `id` int(11) NOT NULL,
  `pep_id` int(11) NOT NULL,
  `list` text NOT NULL,
  `due_date` text NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_perspectives`
--

CREATE TABLE `bsc_perspectives` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_perspectives`
--

INSERT INTO `bsc_perspectives` (`id`, `name`, `description`) VALUES
(1, 'Financial', 'The Financial Pespective defines the financial objectives which represent the long-term objectives of the whole organization: to achieve higher profitability based on the capital employed'),
(2, 'Customer', 'This perspective considers external customers\' point of view, of organizations, which are a crucial factor for creating financial success, revenue from buying products and services'),
(3, 'Internal business processes', 'Internal processes create and deliver the value proposition for customers. Thus objectives in your strategy map\'s internal process perspective describes how you intend to accomplish your organization\'s strategy'),
(4, 'Learning and growth', 'Learning and development, a subset of HR, aims to improve group and individual performance by increasing and honing skills and knowledge.'),
(5, 'Innovation', 'The process of translating an idea or invention into a good or service that creates value or for which customers will pay. To be called an innovation, an idea must be replicable at an economical cost and must satisfy a specific need');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_projects`
--

CREATE TABLE `bsc_projects` (
  `id` int(11) NOT NULL,
  `client_id` text NOT NULL,
  `scorecard_id` text,
  `name` text NOT NULL,
  `description` text,
  `measure_of_success` text,
  `manager` text NOT NULL,
  `start_date` text,
  `end_date` text,
  `reason` text,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_projects`
--

INSERT INTO `bsc_projects` (`id`, `client_id`, `scorecard_id`, `name`, `description`, `measure_of_success`, `manager`, `start_date`, `end_date`, `reason`, `status`) VALUES
(1, '1', '1', 'Ad revenue Action Plans', 'Ad revenue Action Plans', '', '1', '2020-01-17', '2020-03-31', '', 0),
(2, '1', '1', 'Affiliate Marketing Revenue Action Plans', 'Affiliate Marketing Revenue Action Plans', '', '1\n', '2020-01-17', '2020-03-31', '', 1),
(3, '1', '1', 'Toolkits Revenue Action Plans', 'Toolkits Revenue Action Plans', '', '1', '2020-01-17', '2020-03-31', '', 0),
(4, '1', '1', 'PayGenius Revenue Action Plans', 'PayGenius Revenue Action Plans', '', '1', '2020-01-17', '2020-03-31', '', 1),
(5, '1', '1', 'PayGenius Revenue Action Plans', 'PayGenius Revenue Action Plans', '', '1', '2020-01-17', '2020-03-31', '', 0),
(6, '1', '8', 'AD REVENUE', 'AD REVENUE', '', '15', '2020-01-17', '2020-03-31', '', 1),
(7, '1', '8', 'Affiliate Marketing Revenue', 'Affiliate Marketing Revenue', '', '15', '2020-01-17', '2020-03-31', '', 1),
(8, '1', '8', 'Twitter monthly growth ', 'Twitter monthly growth \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '', '15', '2020-01-17', '2020-03-31', '', 1),
(9, '1', '8', 'LinkedIn monthly growth', 'LinkedIn monthly growth', '', '15', '2020-01-17', '2020-03-31', '', 1),
(10, '1', '8', 'Facebook monthly growth', 'Facebook monthly growth', '', '15', '2020-01-17', '2020-03-31', '', 1),
(11, '1', '8', 'YouTube monthly growth', 'YouTube monthly growth', '', '15', '2020-01-17', '2020-03-31', '', 1),
(12, '1', '8', 'Social', 'Social Media', '', '15', '2020-01-17', '2020-03-31', '', 1),
(13, '1', '8', 'Number of articles', 'Number of articles', '', '15', '2020-01-17', '2020-03-31', '', 1),
(14, '1', '8', 'Number of white papers', 'Number of white papers', '', '15', '2020-01-17', '2020-03-31', '', 0),
(15, '1', '26', 'Organise education based marketing on organisational design ', 'The workshop should have an  average revenue of US$2500.00 ', '', '21', '2020-01-20', '2020-03-31', '', 0),
(16, '1', '26', 'Organise education based marketing on job evaluation ', 'Workshop should have an average revenue of US$2500.00\r\n', '', '13', '2020-01-20', '2020-03-31', '', 0),
(17, '1', '26', 'Organise education based marketing on culture transformation ', 'Workshop should generate an average revenue of US$2500.00', '', '18', '2020-01-20', '2020-03-31', '', 0),
(18, '1', '26', 'Organise education based marketing on Staff Capacity Assessment ', 'Workshop should have an average revenue of US$2500.00', '', '20', '2020-01-20', '2020-03-31', '', 0),
(19, '1', '26', 'Relaunch the HR Toolkit ', 'Target sales of 30 organisations in the 1st quarter (6 companies/consultant)', '', '21', '2020-01-20', '2020-03-31', '', 0),
(20, '1', '26', 'Run an NGO Sector promotion in order to generate direct forex revenue ', 'KPI - Number of conversions ', '', '20', '2020-01-20', '2020-03-31', '', 0),
(21, '1', '20', 'Manufacturing  Report', 'We are going to collect data from as nearly 20 organisations and make sure all report are analysed and purchased through PayGenius.\r\n', '', '12', '2020-02-01', '2020-02-28', '', 1),
(22, '1', '26', 'Enforce strict compliance to project budgeting guidelines through taking disciplinary action fro staff who have had more than 3 non-compliance incidents ', 'KPI - Compliance rating ', '', '4', '2020-01-01', '2020-03-31', '', 0),
(23, '1', '26', 'Set-up an OD whatsapp broadcast to share articles, promotions and education based marketing material ', 'This should have a direct impact on our revenue generation. \r\n\r\nKPI - Revenue ', '', '20', '2020-01-01', '2020-03-31', '', 0),
(24, '1', '26', 'Setup OD Twitter Account to share Promotions, Education based marketing material and Articles ', 'KPI - Revenue generated ', '', '21', '2020-01-01', '2020-03-31', '', 0),
(25, '1', '26', 'Conduct a customer satisfaction survey in collaboration with Analytics ', 'A 2020 report and action plan should be produced by Q2. ', '', '18', '2020-01-01', '2020-06-30', '', 0),
(26, '1', '26', 'Conduct post project implementation reports to give us insight on areas we can improve on ', 'Evaluation Reports should be produced for all projects above US$5000.00\r\n', '', '4', '2020-01-20', '2020-03-31', '', 0),
(27, '1', '26', 'Enforce adherence to IPC Policies and Procedures through taking discplinary action for staff who have had more than 3 non-compliance incidents ', 'KPI - Compliance rating ', '', '4', '2020-01-20', '2020-03-31', '', 0),
(28, '1', '26', 'Enforce adherence to IPC Policies and Procedures through taking discplinary action for staff who have had more than 3 non-compliance incidents ', 'KPI - Compliance rating ', '', '4', '2020-01-20', '2020-03-31', '', 0),
(29, '1', '26', 'Train all Cluster Consultants to be Super Users of the Job Evaluation  {Polaris}', 'All Consultants attain Super User Status \r\n', '', '4', '2020-01-20', '2020-03-31', '', 0),
(30, '1', '26', 'Train all Cluster Consultants to be Super Users of the  i-Perform', 'All Consultants attain Super User Status \r\n', '', '4', '2020-01-20', '2020-03-31', '', 0),
(31, '1', '26', 'Train all Cluster Consultants to be Super Users of the  HR Trends ', 'All Consultants attain Super User Status \r\n', '', '4', '2020-01-20', '2020-03-31', '', 0),
(32, '1', '26', 'Train all staff on the following topics to develop internal capacity and improve work output ', '* Staff Capacity Assessement \r\n* Culture Audit \r\n* Headcount Analysis \r\n* Salary Survey and Pay Strucuture Design \r\n* Time Utilisation and Headcount Analysis \r\n', '', '4', '2020-01-20', '2020-03-31', '', 0),
(33, '1', '16', '360 Degrees Toolkit Business Development', 'Promote interest in the toolkit, exhibit demos to clients and have clients pay subscription for use of the toolkit.', '', '9', '2020-01-22', '2020-03-31', '', 1),
(34, '1', '16', 'iPerform Business Development', 'Promote interest in the toolkit, demonstrate and train potential clients, Have clients pay a subscription for the use of the toolkit', '', '9', '2020-01-01', '2020-03-31', '', 1),
(35, '1', '16', 'Productivity Analysis Software Development', 'Design and development of the toolkit', '', '9', '2020-01-01', '2020-03-31', '', 1),
(36, '1', '16', 'HR Trends Business Development', 'Research and implement on how best to make money from HR Trends', '', '9', '2020-01-01', '2020-03-31', '', 1),
(37, '1', '16', 'Digital Marketing', 'Make money online through all possible legal ways which include but not limited to Content Marketing, Search Engine Optimization and Affiliate Marketing', '', '9', '2020-01-01', '2020-03-31', '', 1),
(38, '1', '16', 'Personal Development, Research and Knowledge Sharing', 'Research and publish articles and whitepapers, share knowledge with fellow consultants  through training and published user manuals.', '', '9', '2020-01-01', '2020-03-31', '', 1),
(39, '1', '16', 'IT User Support and Systems Administration', 'Create master files, back ups, user support', '', '9', '2020-01-01', '2020-03-31', '', 0),
(40, '1', '6', 'Ad Revenue', 'Ad Revenue', '', '3', '2020-01-01', '2020-03-31', '', 4),
(41, '1', '6', 'Affiliate Marketing Revenue', 'Affiliate Marketing Revenue', '', '3', '2020-01-01', '2020-03-31', '', 1),
(42, '1', '6', 'Toolkits Revenue', 'Toolkits Revenue', '', '3', '2020-01-01', '2020-03-31', '', 4),
(43, '1', '6', 'Toolkits Revenue', 'Toolkits Revenue', '', '3', '2020-01-01', '2020-03-31', '', 0),
(44, '1', '6', 'PayGenius Revenue', 'PayGenius Revenue', '', '3', '2020-01-01', '2020-03-31', '', 1),
(45, '1', '6', 'Manage Costs', 'Manage costs', '', '3', '2020-01-01', '2020-03-31', '', 1),
(46, '1', '6', 'Twitter Growth', 'Twitter growth', '', '3', '2020-01-01', '2020-03-31', '', 1),
(47, '1', '6', 'LinkedIn Growth', 'LinkedIn Growth', '', '3', '2020-01-01', '2020-03-31', '', 1),
(48, '1', '6', 'Facebook Growth', 'Facebook Growth', '', '3', '2020-01-01', '2020-03-31', '', 1),
(49, '1', '6', 'YouTube Growth', 'YouTube growth', '', '3', '2020-01-01', '2020-03-31', '', 1),
(50, '1', '6', 'Proposal Success Rate', 'Proposal success rate', '', '3', '2020-01-01', '2020-03-31', '', 1),
(51, '1', '6', 'Page Views', 'Page Views', '', '3', '2020-01-01', '2020-03-31', '', 1),
(52, '1', '6', 'Organic traffic', 'Organic traffic', '', '3', '2020-01-01', '2020-03-31', '', 1),
(53, '1', '6', 'SEO', 'SEO SEO SEO', '', '3', '2020-01-01', '2020-03-31', '', 1),
(54, '1', '6', 'Usability', 'Usability Usability', '', '3', '2020-01-01', '2020-03-31', '', 1),
(55, '1', '6', 'Performance', 'Performance', '', '3', '2020-01-01', '2020-03-31', '', 1),
(56, '1', '6', 'Social', 'Social Social', '', '3', '2020-01-01', '2020-03-31', '', 1),
(57, '1', '6', 'Speed optimisation', 'Sped optimisation', '', '3', '2020-01-01', '2020-03-31', '', 1),
(58, '1', '6', 'Comply with procedures', 'Comply with procedures', '', '3', '2020-01-01', '2020-03-31', '', 1),
(59, '1', '6', '% of projects completed', '% of projects completed', '', '3', '2020-01-01', '2020-03-31', '', 1),
(60, '1', '6', 'Learning and Growth', 'Learning and growth', '', '3', '2020-01-01', '2020-03-31', '', 1),
(61, '1', '19', 'Proposal Success Rate', 'Create and acquire partnership agreements with regional consultants to sell online products', '', '8', '2020-01-01', '2020-03-31', '', 1),
(62, '1', '20', 'Headcount Analysis ', 'We will create material and use the RBZ venue which is nice and relatively cheap\r\n', '', '12', '2020-01-31', '2020-03-31', '', 0),
(63, '1', '20', 'Run Employee Engagement Promotion', 'Create brochures, social media banners and send them to clients through emails, facebook, twitter and linkedin.\r\n', '', '12', '2020-08-31', '2020-12-31', '', 0),
(64, '1', '20', 'Performance Analytics', 'Research on the best technical methodology and then present to team before writing a proposal template\r\n', '', '12', '2020-02-19', '2020-03-31', '', 0),
(65, '1', '19', 'Twitter monthly growth', 'Twitter monthly growth ', '', '8', '2020-01-01', '2020-03-31', '', 0),
(66, '1', '19', 'LinkedIn monthly growth', 'LinkedIn monthly growth', '', '8', '2020-01-01', '2020-03-31', '', 0),
(67, '1', '19', 'Facebook monthly growth', 'Facebook monthly growth', '', '8', '2020-01-01', '2020-03-31', '', 0),
(68, '1', '19', 'YouTube monthly growth', 'YouTube monthly growth', '', '8', '2020-01-01', '2020-01-31', '', 1),
(69, '1', '19', 'Proposal Success Rate', 'Proposal Success Rate', '', '8', '2020-01-01', '2020-03-31', '', 0),
(70, '1', '19', 'Page views', 'Page views', '', '8', '2020-01-01', '2020-03-31', '', 0),
(71, '1', '19', 'Performance', 'Performance', '', '8', '2020-01-01', '2020-03-31', '', 1),
(72, '1', '19', 'Number of articles', 'Number of articles', '', '8', '2020-01-01', '2020-03-31', '', 1),
(73, '1', '19', 'Number of articles page views', 'Number of articles page views', '', '8', '2020-01-01', '2020-03-31', '', 0),
(74, '1', '19', 'Number of white papers', 'Number of white papers', '', '8', '2020-01-01', '2020-03-31', '', 1),
(75, '1', '19', 'Number of toolkit trainings', 'Number of toolkit trainings', '', '8', '2020-01-01', '2020-01-31', '', 0),
(76, '1', '18', 'Optmise Portal', 'To improve site performance', '', '1', '2020-01-01', '2020-03-31', '', 1),
(77, '1', '18', 'Develop toolkits', 'Increase the level of automation', '', '1', '2020-01-01', '2020-01-31', '', 1),
(78, '1', '18', 'Develop self', 'To develop a writing culture', '', '1', '2020-01-01', '2020-03-31', '', 1),
(79, '1', '18', 'Sale toolkits', 'To get more revenue', '', '1', '2020-01-01', '2020-03-31', '', 1),
(80, '1', '27', 'National Salary Survey 2020', 'We will produce the following reports in Pay Genius;\r\n* NGO National Report \r\n* Manufacturing  Report\r\n* Financial Services Report\r\n* Insurance Report\r\n* Medical Insurance Report\r\n* Motor Industry Report\r\n* State Enterprises Report \r\n* NED Report \r\n* National Consolidated Report \r\n', '', '11', '2020-01-23', '2020-02-29', '', 1),
(81, '1', '27', 'Education Based Marketing', 'Organise 4 education-based marketing workshops for the cluster \r\n* Productivity Measurement\r\n* Workforce Planning \r\n* Headcount Analysis \r\n* Employee Engagement\r\n', '', '10', '2020-01-23', '2020-03-31', '', 0),
(82, '1', '27', 'Research Survey', 'Carry out 3  research surveys on topical issues as part of our education based marketing strategy \r\n', '', '10', '2020-01-23', '2020-03-31', '', 0),
(83, '1', '27', 'Partnership with Regional Clients', 'We will seek regional partners for the following projects;\r\nWorkforce Planning\r\nSalary Surveys\r\nEmployee Engagement\r\nProductivity Assessment', '', '10', '2020-01-23', '2020-12-31', '', 0),
(84, '1', '27', 'Analytics Promotions', 'We will run promotions for the following services;\r\n1. Salary Survey\r\n2. Employee Engagement\r\n3. Workforce Planning\r\n4. Time Utilisation\r\n5. Productivity Assessment', '', '10', '2020-01-23', '2020-12-31', '', 0),
(85, '1', '27', 'Customer Satisfaction Evaluation', 'Conduct post-project implementation reports to give us insight into areas we can improve on \r\n', '', '10', '2020-01-23', '2020-03-31', '', 0),
(86, '1', '27', 'Internal Business Processes ', 'Train all Cluster Consultants to be Super Users of the PayGenius System \r\nTrain all Cluster Consultants to be Super Users of the e-Pulse system \r\nRevamp and enhance the survey salary survey methodology through PayGenius \r\nTrain all Cluster Consultants to be Super Users of the Time utilization system \r\nAdd workload analysis to the Time Utilisation system\r\nRevamp the headcount analysis methodology.\r\n\r\n', '', '10', '2020-01-23', '2020-12-31', '', 0),
(87, '1', '27', 'Developing the AI Systems', 'Develop an AI system for detecting Deception using Machine learning \r\nDevelop an AI System to assist with Board Evaluations \r\nDevelop an AI system to do Personality Assessment  using Machine Learning \r\n', '', '10', '2020-01-23', '2020-12-31', '', 0),
(88, '1', '27', 'Learning and Growth ', 'Internal Training Plan for Capacity Development for all Analytics Cluster. Below are the training areas;\r\n* Job Evaluation\r\n* Machine Learning\r\n* Productivity Analysis\r\n* Staff Capacity Assessment \r\n* Culture Audit \r\n* Headcount Analysis \r\n', '', '10', '2020-01-23', '2020-12-31', '', 0),
(89, '1', '27', 'Winning Proposal Methodology Templates', 'Create proposal templates with standardised technical methodology that will be used for both local and international big proposals\r\n* Headcount Analysis \r\n* Time Utilisation\r\n* Workload Analysis\r\n* Workforce Planning \r\n* Employee Engagement\r\n* Pay Structure Design\r\n* Customised Salary Survey\r\n', '', '10', '2020-01-23', '2020-07-31', '', 0),
(90, '1', '12', 'Financial Services Salary Survey Report', 'We are going to collect data from as nearly 30 organisations and make sure all report are analysed and purchased through PayGenius.\r\n', '', '19', '2020-01-27', '2020-03-31', '', 1),
(91, '1', '12', 'Banking Sector Salary Survey Report', 'We are going to collect data from as nearly 15 banks and make sure all report are analysed and purchased through PayGenius.\r\n', '', '19', '2020-01-27', '2020-03-31', '', 0),
(92, '1', '12', 'NED Salary Survey Report', 'We are going to collect data from as nearly 30 organisations and make sure the report is analysed and purchased through PayGenius.\r\n', '', '19', '2020-01-27', '2020-03-31', '', 0),
(93, '1', '12', 'Workforce Planning ', 'We will create material for a marketing workshop and use the RBZ venue.', '', '19', '2020-01-27', '2020-03-31', '', 0),
(94, '1', '12', 'Carry out a research survey on topical issues as part of our education based marketing strategy ', 'Come up with new interesting relevant topics for clients, design questionnaires and publish results.\r\n', '', '19', '2020-01-27', '2020-03-31', '', 0),
(95, '1', '12', 'Run Workforce planning promotions in the region', 'Create brochures, social media banners and send them to clients through emails, Facebook, Twitter and LinkedIn.\r\n', '', '19', '2020-01-27', '2020-06-30', '', 0),
(96, '1', '12', 'Revamp the headcount analysis methodology.', 'Add models that take care of the issue of imbalanced data, small data set and other company variables in predicting headcount\r\n', '', '19', '2020-01-27', '2020-03-31', '', 0),
(97, '1', '12', 'Develop an AI system to do Personality Assessment  using Machine Learning ', 'Create machine learning code that assists with Personality Assessment and work with IT for integrating into the system\r\n', '', '19', '2020-01-27', '2020-11-30', '', 0),
(98, '1', '3', 'Homelink GT Recruitment', 'Finance Graduate Trainee', '', '7', '2020-01-23', '2020-01-30', '', 1),
(99, '1', '3', 'Talent Hunter', 'description', '', '7', '2020-02-03', '2020-03-30', '', 1),
(100, '1', '15', 'National Salary Survey 2020', 'Produce the following reports and make sure all report is analysed and purchased through PayGenius\r\n* State Enterprises Report \r\n* Construction Enterprises Report \r\n* Real Estate Enterprises Report \r\n', '', '11', '2020-01-23', '2020-03-31', '', 1),
(101, '1', '15', 'Education Based Marketing', 'Organise education-based marketing workshop for Employee Engagement\r\n', '', '11', '2020-01-23', '2020-03-31', '', 1),
(102, '1', '15', 'Research Survey', 'Carry out 3  research surveys on topical issues as part of our education based marketing strategy \r\n', '', '11', '2020-01-23', '2020-03-31', '', 1),
(103, '1', '15', 'Analytics Promotions', 'Run Salary Survey Promotion\r\nRun a team-building promotion\r\n', '', '11', '2020-01-23', '2020-12-31', '', 1),
(104, '1', '15', 'Internal Business Processes ', 'Add workload analysis to the Time Utilisation system\r\n* Productivity Analytics\r\n* Training and Development Analytics\r\n', '', '11', '2020-01-23', '2020-12-31', '', 1),
(105, '1', '15', 'Analytics Promotions', 'Run Salary Survey Promotion\r\nRun a team-building promotion\r\n', '', '11', '2020-01-23', '2020-12-31', '', 1),
(106, '1', '17', 'Talent Hunter ', 'Migrate 30 clients to the Talent Hunter by end April', '', '14', '2020-01-02', '2020-04-30', '', 1),
(107, '1', '17', 'Job Portal', 'Driving 200 job seekers to the Jobs Portal by end of April', '', '14', '2020-01-02', '2020-04-30', '', 1),
(108, '1', '17', 'Career Guidance', 'Run Career Guidance to at least 2 universities by the end of April', '', '14', '2020-01-02', '2020-04-30', '', 1),
(109, '1', '17', 'Balanced Scorecard', 'Become a balanced scorecard superuser by end of April', '', '14', '2020-01-02', '2020-04-30', '', 1),
(110, '1', '17', 'Job Evaluation', 'Become a superuser of the Polaris Job Evaluation system by end of April ', '', '14', '2020-01-02', '2020-04-30', '', 1),
(111, '1', '17', 'Job Evaluation', 'Become a superuser of the Polaris Job Evaluation system by end of April ', '', '14', '2020-01-02', '2020-04-30', '', 1),
(112, '1', '17', 'Competency Framework', 'Become a superuser of the competency framework by the end of April', '', '14', '2020-01-02', '2020-04-30', '', 1),
(113, '1', '10', 'Talent Hunter', 'Migrate 30 clients to the Talent Hunter by the end of April', '', '17', '2020-01-02', '2020-02-29', '', 0),
(114, '1', '10', 'Talent Hunter', 'Migrate 30 clients to the Talent Hunter by the end of April', '', '17', '2020-01-02', '2020-02-29', '', 0),
(115, '1', '10', 'Jobs Portal', 'Bring in 200 job seekers to the Jobs Portal by the end of April.', '', '17', '2020-01-02', '2020-02-29', '', 0),
(116, '1', '10', 'Career Guidance', 'Hold 2 career fairs by the end of April.', '', '17', '2020-01-02', '2020-02-29', '', 0),
(117, '1', '10', 'Balanced Scorecard', 'Become a super user of the balanced scorecard.', '', '17', '2020-01-02', '2020-02-29', '', 0),
(118, '1', '10', 'Job Evaluation ', 'Become a Polaris Job Evaluation super user by end of April', '', '17', '2020-01-02', '2020-04-30', '', 0),
(119, '1', '3', 'Balanced Scorecard', 'Train all consultants to be super users of the balanced scorcard', '', '7', '2020-01-02', '2020-04-30', '', 1),
(120, '1', '10', 'Jobs Portal', 'Bring in 200 job seekers to the jobs portal by the end of April.', '', '17', '2020-01-02', '2020-04-30', '', 0),
(121, '1', '3', 'Job Evaluation', 'Train all Consultants to be super users of the balanced scorecard', '', '7', '2020-01-02', '2020-04-30', '', 1),
(122, '1', '3', 'Career Guidance', 'Test at least 200 hundred candidates by the end of Feb', '', '7', '2020-01-02', '2020-04-30', '', 1),
(123, '1', '3', 'Competency profiling', 'Train all cluster consultants to be super users of the competency model', '', '7', '2020-01-02', '2020-04-30', '', 1),
(124, '1', '9', 'Talent Hunter', 'Bring in 30 clients to Talent Hunter by end of April', '', '16', '2020-01-02', '2020-04-30', '', 0),
(125, '1', '9', 'Jobs Portal', 'Bring in 200 job seekers by end of April', '', '16', '2020-01-02', '2020-04-30', '', 0),
(126, '1', '10', 'Competency Framework', 'Become a super user of the competency framework.', '', '17', '2020-01-02', '2020-04-30', '', 0),
(127, '1', '22', 'Talent Hunter', 'Migrate 30 Clients to the Talent Hunter', '', '22', '2020-01-01', '2020-04-30', '', 0),
(128, '1', '22', 'Jobs Portal', 'Have 200 New Jobseekers', '', '22', '2020-01-01', '2020-04-30', '', 0),
(129, '1', '22', 'Career Guidance', 'Hold 2 University Career fairs', '', '22', '2020-01-01', '2020-04-30', '', 0),
(130, '1', '9', 'Job Evaluation', 'Become superuser of the iPerfom system', '', '16', '2020-01-02', '2020-04-30', '', 0),
(131, '1', '22', 'Job Evaluation', 'Become a super user of the Polaris system', '', '22', '2020-01-01', '2020-04-30', '', 0),
(132, '1', '9', 'Balanced Scorecard', 'Become a superuser of the iPerform system', '', '16', '2020-01-02', '2020-04-30', '', 0),
(133, '1', '22', 'Balanced Scorecard', 'Become a super user of iPerform system', '', '22', '2020-01-01', '2020-04-30', '', 0),
(134, '1', '9', 'Competency Framework', 'Become a superuser of the competency framework', '', '16', '2020-01-02', '2020-04-30', '', 0),
(135, '1', '22', 'Competency Framework', 'Become a super user of the competency framework', '', '22', '2020-01-01', '2020-04-30', '', 0),
(136, '1', '9', 'Career Guidance ', 'Hold 2 university career fairs ', '', '16', '2020-01-02', '2020-04-30', '', 0),
(137, '1', '3', 'Psychometric Tests', 'Migrate 100 clients to the Talent Hunter by end of April', '', '7', '2020-01-02', '2020-04-30', '', 1),
(138, '2', '28', 'Train employees', 'Finance for non finance people trainuing', '', '23', '2020-01-27', '2020-01-31', '', 1),
(140, '3', '32', 'BSC Training', 'Balanced scorecard training', '', '27', '2020-01-29', '2020-02-29', '', 1),
(141, '1', '5', 'IPC Reporting Calendar', 'Reporting calendar is a schedule of all the reports that will originate from finance and aim to give insight to the team on financial performance and efficiency.', '', '6', '2020-01-01', '2020-12-31', '', 4),
(142, '1', '5', 'IPC Billquick Training- Introduction to Billquick', 'Inducting team on basic processes in the system', '', '6', '2020-02-03', '2020-02-07', '', 0),
(143, '1', '5', 'January Call log report', 'Prepare call log report flagging incidences were employees exceeded acceptable phone usage threshholds', '', '24', '2020-02-01', '2020-02-04', '', 0),
(144, '1', '5', 'General Ledger Handling Training', 'Train Shamiso and Dings on how to process data into the general ledger.\r\n\r\nSource documents-Journals-GL-TB', '', '6', '2020-02-10', '2020-02-14', '', 0),
(145, '1', '12', 'Revamp Salary Survey Methodology', 'To write out a step by step framework of the salary survey ', '', '19', '2020-02-03', '2020-02-28', '', 0),
(146, '5', '43', 'Digital Marketing', 'Social Media Marketing, Digital Campaigns', '', '32', '2020-02-01', '2020-10-31', '', 0),
(147, '5', '43', 'Design Reports', 'Designing repoorts', '', '32', '2020-02-14', '2020-03-31', '', 0),
(148, '5', '36', 'Presentation', 'Presentingh', '', '34', '2020-02-11', '2020-02-29', '', 1),
(149, '1', '18', 'Iperform Action Plans', 'New enhancements to iPerform', '', '1', '2020-02-12', '2020-02-29', '', 1),
(150, '1', '16', 'Human Capital Hub Development', 'Development of landing pages-user side for jobs portal, best employer, paygenius sections', '', '9', '2020-02-01', '2020-02-29', '', 0),
(151, '6', '48', 'Planning and Scheming Documents ', 'Planning for the term', '', '36', '2020-03-11', '2020-03-18', '', 0),
(153, '1', NULL, '', NULL, NULL, '16', NULL, NULL, NULL, 4),
(154, '1', NULL, '', NULL, NULL, '16', NULL, NULL, NULL, 4),
(155, '1', NULL, 'hjjkkjkj', NULL, NULL, '16', NULL, NULL, NULL, 4),
(156, '1', NULL, 'zlatan hjdhjdjdjhds', NULL, NULL, '16', NULL, NULL, NULL, 4),
(157, '1', NULL, 'tsdhgsdhgshgs', NULL, NULL, '16', NULL, NULL, NULL, 4),
(158, '1', NULL, 'yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy', NULL, NULL, '16', NULL, NULL, NULL, 4),
(159, '1', NULL, 'New Card My card', NULL, NULL, '25', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_project_status`
--

CREATE TABLE `bsc_project_status` (
  `id` int(11) NOT NULL,
  `status` text NOT NULL,
  `color` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_project_status`
--

INSERT INTO `bsc_project_status` (`id`, `status`, `color`) VALUES
(0, 'new', 'info'),
(1, 'In Progress', 'primary'),
(2, 'Onhold', 'warning'),
(3, 'complete', 'success'),
(4, 'Achieved', 'warning');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_project_tasks`
--

CREATE TABLE `bsc_project_tasks` (
  `id` int(11) NOT NULL,
  `project_id` text NOT NULL,
  `assigned` int(11) DEFAULT NULL,
  `task` text NOT NULL,
  `measure_of_success` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `completion` varchar(100) DEFAULT '0',
  `document` text NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `due_date` text NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_project_tasks`
--

INSERT INTO `bsc_project_tasks` (`id`, `project_id`, `assigned`, `task`, `measure_of_success`, `status`, `completion`, `document`, `start_date`, `due_date`, `last_updated`) VALUES
(1, '6', NULL, 'Amend posted articles, ensure they have the correct associated keywords and related articles links -content audit', '', 0, '0', '', '2020-01-17 13:40:19', '2020-03-31', '2020-02-06 14:32:24'),
(2, '6', NULL, 'Change currently posted article headings and add  visual image', '', 0, '0', '', '2020-01-17 13:41:05', '2020-03-31', '2020-02-06 14:32:24'),
(3, '6', NULL, 'Publish exclusive high quality articles and content on a regular basis', '', 0, '0', '', '2020-01-17 13:41:45', '2020-03-31', '2020-02-06 14:32:24'),
(4, '6', NULL, 'Re-sharing posts in different ways - getting different sharing tips from The Sun', '', 0, '50', '', '2020-01-17 13:42:17', '2020-03-31', '2020-01-17 13:55:10'),
(5, '6', NULL, 'Giving our audiences something valuable via the mailing lists e.g. CV reviewer tool, HR Perspective book (occasionally send exclusive content)', '', 0, '0', '', '2020-01-17 13:42:41', '2020-03-31', '2020-02-06 14:32:24'),
(6, '6', NULL, 'Re-engage inactive subscribers from the mailing lists', '', 0, '0', '', '2020-01-17 13:43:11', '2020-03-31', '2020-02-06 14:32:24'),
(7, '6', NULL, 'Personalising emails with free resources especially during the weekends', '', 0, '0', '', '2020-01-17 13:43:46', '2020-03-31', '2020-02-06 14:32:24'),
(8, '6', NULL, 'Personalising emails with free resources especially during the weekends', '', 0, '0', '', '2020-01-17 13:44:30', '2020-03-31', '2020-02-06 14:32:24'),
(9, '6', NULL, 'Add cliff-hangers to emails to get subscribers excited about the emails', '', 0, '0', '', '2020-01-17 13:46:26', '2020-03-31', '2020-02-06 14:32:24'),
(10, '6', NULL, 'Create a social media content planning calendar - added on the Social Media Calendar sheet', '', 0, '50', '', '2020-01-17 13:47:01', '2020-03-31', '2020-01-17 13:55:11'),
(11, '6', NULL, 'Consistent sharing of information about IPC to improve the brand image on social media platforms', '', 0, '0', '', '2020-01-17 13:47:25', '2020-03-31', '2020-02-06 14:32:24'),
(12, '6', NULL, 'Pay and share ads for content created on IPC sites or tools released', '', 0, '0', '', '2020-01-17 13:47:52', '2020-03-31', '2020-02-06 14:32:24'),
(13, '6', NULL, 'Tracking what competitors are doing and how they are marketing and getting valuable data for keyword research and other social media marketing insight', '', 0, '0', '', '2020-01-17 13:48:37', '2020-03-31', '2020-02-06 14:32:24'),
(14, '6', NULL, 'Blog every day to develop page authority', '', 0, '0', '', '2020-01-17 13:49:59', '2020-03-31', '2020-02-06 14:32:24'),
(15, '6', NULL, 'Advertise well curated content for online courses on readily available platforms e.g. Udemy, Coursera', '', 0, '0', '', '2020-01-17 13:50:27', '2020-03-31', '2020-02-06 14:32:24'),
(16, '6', NULL, 'Advertise well curated content for online courses on IPC online platforms', '', 0, '0', '', '2020-01-17 13:50:51', '2020-03-31', '2020-02-06 14:32:24'),
(17, '6', NULL, 'Facilitate development and designing of eBooks: January - Employee Engagement (to develop eBooks depending on trending topics within the month for us to remain relevant)', '', 0, '0', '', '2020-01-17 13:51:23', '2020-03-31', '2020-02-06 14:32:24'),
(18, '6', NULL, 'Invite guest writers to write and share content on IPC sites', '', 0, '0', '', '2020-01-17 13:51:45', '2020-03-31', '2020-02-06 14:32:24'),
(19, '7', NULL, 'Email marketing on convert kit and Mr Nguwi s mailing list to get interested clients', '', 0, '36', '', '2020-01-17 13:53:52', '2020-03-31', '2020-02-06 15:18:15'),
(20, '7', NULL, 'Advertise Time Utilisation mainly targeting NGOs', '', 0, '50', '', '2020-01-17 13:54:20', '2020-03-31', '2020-01-17 13:54:21'),
(21, '7', NULL, 'Email marketing on convert kit and Mr Nguwi s mailing list to get interested clients', '', 0, '0', '', '2020-01-17 13:54:50', '2020-03-31', '2020-02-06 15:18:22'),
(22, '7', NULL, 'Promote paid Google ads to increase brand awareness and sales', '', 0, '0', '', '2020-01-17 13:55:12', '2020-03-31', '2020-02-06 14:36:15'),
(23, '7', NULL, 'Social media marketing - advertising or making noise on social media about PayGenius', '', 0, '0', '', '2020-01-17 13:55:35', '2020-03-31', '2020-02-06 15:18:34'),
(24, '7', NULL, 'Manage project write downs', '', 0, '0', '', '2020-01-17 13:56:01', '2020-03-31', '2020-02-06 14:36:15'),
(25, '7', NULL, 'Contain project related costs', '', 0, '50', '', '2020-01-17 13:56:23', '2020-03-31', '2020-01-17 13:56:24'),
(26, '8', NULL, 'Share and fill up profile with diverse content. Optimise page e.g. add Chabotâ€™s for auto replyâ€™s, more content about IPC and links to the platforms.', '', 0, '50', '', '2020-01-17 13:57:43', '2020-03-31', '2020-01-17 13:57:44'),
(27, '8', NULL, 'Create and use different hashtags for each platform', '', 0, '0', '', '2020-01-17 13:58:42', '2020-03-31', '2020-02-06 14:36:15'),
(28, '8', NULL, 'Engage more with the audience and start conversations by responding to their comments or sharing triggering posts', '', 0, '50', '', '2020-01-17 13:59:05', '2020-03-31', '2020-01-17 13:59:21'),
(29, '8', NULL, 'Share controversial statements from Mr Nguwi', '', 0, '50', '', '2020-01-17 13:59:34', '2020-03-31', '2020-01-17 13:59:35'),
(30, '8', NULL, 'Use of great designed banners on the Twitter landing pages to attract the audience', '', 0, '0', '', '2020-01-17 13:59:54', '2020-03-31', '2020-02-06 14:36:15'),
(31, '8', NULL, 'Share well curated and designed videos and infographics e.g. Steve Jobs marketing 2 minute video', '', 0, '0', '', '2020-01-17 14:00:25', '2020-03-31', '2020-02-06 14:36:15'),
(32, '8', NULL, 'Run contests and polls', '', 0, '50', '', '2020-01-17 14:00:48', '2020-03-31', '2020-01-17 14:00:57'),
(33, '9', NULL, 'Share and fill up profile with diverse content. Optimise page e.g. add Chabotâ€™s for auto replyâ€™s, more content about IPC and links to the platforms.', '', 0, '50', '', '2020-01-17 14:02:39', '2020-03-31', '2020-01-17 14:02:40'),
(34, '9', NULL, 'Engage more with the audience and start conversations', '', 0, '50', '', '2020-01-17 14:03:03', '2020-03-31', '2020-01-17 14:03:03'),
(35, '9', NULL, 'Use of great designed banners', '', 0, '0', '', '2020-01-17 14:03:24', '2020-03-31', '2020-02-06 14:36:15'),
(36, '10', NULL, 'Tell stories and go live on Facebook on events e.g. Career Guidance events with parents, workshops etc.', '', 0, '0', '', '2020-01-17 14:04:47', '2020-03-31', '2020-02-06 14:36:15'),
(37, '10', NULL, 'Share and fill up profile with diverse content. Optimise page e.g. add Chabotâ€™s for auto replyâ€™s, more content about IPC and links to the platforms.', '', 0, '50', '', '2020-01-17 14:05:09', '2020-03-31', '2020-01-17 14:05:10'),
(38, '10', NULL, 'Create and share insightful videos and infographics', '', 0, '50', '', '2020-01-17 14:05:32', '2020-03-31', '2020-01-17 14:05:32'),
(39, '10', NULL, 'Customise and change call to action buttons', '', 0, '0', '', '2020-01-17 14:05:55', '2020-03-31', '2020-02-06 14:36:15'),
(40, '10', NULL, 'Engage more with the audience and start conversations', '', 0, '50', '', '2020-01-17 14:06:16', '2020-03-31', '2020-01-17 14:06:16'),
(41, '11', NULL, 'Fill up profile with insightful good quality videos', '', 0, '50', '', '2020-01-17 14:07:48', '2020-03-31', '2020-01-17 14:07:49'),
(42, '11', NULL, 'Email marketing - adding YouTube links to the mailing lists', '', 0, '0', '', '2020-01-17 14:08:08', '2020-03-31', '2020-02-06 14:36:15'),
(43, '11', NULL, 'Tell stories and go live', '', 0, '0', '', '2020-01-17 14:08:27', '2020-03-31', '2020-02-06 14:36:15'),
(44, '12', NULL, 'Invest in promoting ads to reach new audience', '', 0, '0', '', '2020-01-17 14:10:53', '2020-03-31', '2020-02-06 14:36:15'),
(45, '13', NULL, 'Write top quality content and optimise it', '', 0, '50', '', '2020-01-17 14:12:45', '2020-03-31', '2020-01-17 14:12:58'),
(46, '13', NULL, 'Number of articles page views', '', 0, '0', '', '2020-01-17 14:13:05', '2020-03-31', '2020-01-28 08:51:35'),
(47, '21', NULL, 'Report', '', 0, '100', '', '2020-01-20 13:36:21', '2020-02-28', '2020-03-04 14:22:03'),
(48, '40', NULL, 'Create an articles reserve on the main server for re-sharing', '', 0, '50', '', '2020-01-22 10:43:13', '2020-03-31', '2020-02-04 07:33:28'),
(49, '40', NULL, 'Add ads on sidebars for all sites pages', '', 0, '50', '', '2020-01-22 10:43:29', '2020-03-31', '2020-01-23 06:25:20'),
(50, '40', NULL, 'Add other platform links to the every site', '', 0, '50', '', '2020-01-22 10:43:39', '2020-03-31', '2020-02-04 07:33:28'),
(51, '40', NULL, 'Develop a community on free resources section were users talk about different topics e.g. the future of work', '', 0, '50', '', '2020-01-22 10:43:51', '2020-03-31', '2020-02-04 07:32:32'),
(52, '40', NULL, 'Invite guest writers to write and share content on IPC sites', '', 0, '0', '', '2020-01-22 10:43:59', '2020-03-31', '2020-02-06 14:36:15'),
(53, '40', NULL, 'Deliver good customer experience by revamping sites', '', 0, '100', '', '2020-01-22 10:44:08', '2020-03-31', '2020-01-22 10:44:23'),
(54, '41', NULL, 'Deliver good customer experience by revamping sites', '', 0, '0', '', '2020-01-22 10:44:53', '2020-03-31', '2020-02-06 14:36:15'),
(55, '42', NULL, 'Email marketing on convert kit and Mr Nguwi\'s mailing list to get interested clients', '', 0, '100', '', '2020-01-22 10:45:34', '2020-03-31', '2020-02-06 09:17:28'),
(56, '42', NULL, 'Apply for 360 tenders using 360 degrees, job evaluation and employee engagement', '', 0, '50', '', '2020-01-22 10:45:43', '2020-03-31', '2020-02-04 07:32:56'),
(57, '42', NULL, 'Reaching out to iPerform presented clients for possible sales with customisations requested implemented', '', 0, '80', '', '2020-01-22 10:45:51', '2020-03-31', '2020-02-06 09:17:37'),
(58, '42', NULL, 'Reach out to Harold Malawi to create a partnership and market toolkits', '', 0, '0', '', '2020-01-22 10:45:59', '2020-03-31', '2020-02-06 14:36:15'),
(59, '42', NULL, 'Advertise Time Utilisation mainly targeting NGOs', '', 0, '0', '', '2020-01-22 10:46:07', '2020-03-31', '2020-02-06 14:36:15'),
(60, '44', NULL, 'Email marketing on convert kit and Mr Nguwi\'s mailing list to get interested clients', '', 0, '50', '', '2020-01-22 10:47:36', '2020-03-31', '2020-02-06 09:17:49'),
(61, '44', NULL, 'Start using Chabot to increase user engagement, page views and help them get value of the salary information', '', 0, '50', '', '2020-01-22 10:47:48', '2020-03-31', '2020-02-06 09:18:33'),
(62, '44', NULL, 'Develop a currency converter using the current interbank rate', '', 0, '50', '', '2020-01-22 10:47:57', '2020-03-31', '2020-02-06 09:18:33'),
(63, '44', NULL, 'Integration of the WhatsApp API and advertise the IPC products', '', 0, '0', '', '2020-01-22 10:48:04', '2020-03-31', '2020-02-06 14:36:15'),
(64, '45', NULL, 'Manage project write downs', '', 0, '0', '', '2020-01-22 10:48:48', '2020-03-31', '2020-02-06 14:36:15'),
(65, '45', NULL, 'Contain project related costs', '', 0, '0', '', '2020-01-22 10:48:56', '2020-03-31', '2020-02-06 14:36:15'),
(66, '46', NULL, 'Add social media links on all IPC online platforms', '', 0, '0', '', '2020-01-22 10:50:52', '2020-03-31', '2020-02-06 14:36:15'),
(67, '47', NULL, 'Add social media links on all IPC online platforms', '', 0, '0', '', '2020-01-22 10:53:53', '2020-03-31', '2020-02-06 14:36:15'),
(68, '48', NULL, 'Tell stories and go live on Facebook on events e.g. Career Guidance events with parents, workshops etc.', '', 0, '0', '', '2020-01-22 10:55:55', '2020-03-31', '2020-02-06 14:36:15'),
(69, '48', NULL, 'Add social media links on all IPC online platforms', '', 0, '0', '', '2020-01-22 10:56:05', '2020-03-31', '2020-02-06 14:36:15'),
(70, '49', NULL, 'Email marketing - adding YouTube links to the mailing lists', '', 0, '0', '', '2020-01-22 10:56:45', '2020-03-31', '2020-02-06 14:36:15'),
(71, '49', NULL, 'Embedding the videos within free resources sections on the websites directly from the IPC YouTube account', '', 0, '0', '', '2020-01-22 10:56:59', '2020-03-31', '2020-02-06 14:36:15'),
(72, '49', NULL, 'Tell stories and go live', '', 0, '0', '', '2020-01-22 10:57:09', '2020-03-31', '2020-02-06 14:36:15'),
(73, '49', NULL, 'Add social media links on all IPC online platforms', '', 0, '0', '', '2020-01-22 10:57:19', '2020-03-31', '2020-02-06 14:36:15'),
(74, '49', NULL, 'Ask friends, family and relatives to subscribe to channel', '', 0, '0', '', '2020-01-22 10:57:27', '2020-03-31', '2020-02-06 14:36:15'),
(75, '50', NULL, 'Create and acquire partnership agreements with regional consultants to sell online products', '', 0, '0', '', '2020-01-22 10:58:08', '2020-03-31', '2020-02-06 14:36:15'),
(76, '51', NULL, 'Invite guest writers', '', 0, '0', '', '2020-01-22 11:01:25', '2020-03-31', '2020-02-06 14:36:15'),
(77, '51', NULL, 'Improve user experience', '', 0, '0', '', '2020-01-22 11:01:36', '2020-03-31', '2020-02-06 14:36:15'),
(78, '51', NULL, 'Launch free tools to the users e.g. CV reviewer and AI Interviewer just like the HiVue tool', '', 0, '0', '', '2020-01-22 11:01:44', '2020-03-31', '2020-02-06 14:36:15'),
(79, '51', NULL, 'Writing content that links within the sites - inbound links', '', 0, '0', '', '2020-01-22 11:01:56', '2020-03-31', '2020-02-06 14:36:15'),
(80, '51', NULL, 'Comment on other relevant blogs and add links to your site for more information', '', 0, '0', '', '2020-01-22 11:02:07', '2020-03-31', '2020-02-06 14:36:15'),
(81, '51', NULL, 'Add related content either on sidebars or at the bottom of the post', '', 0, '0', '', '2020-01-22 11:02:14', '2020-03-31', '2020-02-06 14:36:15'),
(82, '51', NULL, 'Ensure SEO is implemented for all sites using action plans under SEO measure', '', 0, '0', '', '2020-01-22 11:02:23', '2020-03-31', '2020-02-06 14:36:15'),
(83, '51', NULL, 'Break up long posts by using the page link tags â€“ pagination', '', 0, '0', '', '2020-01-22 11:02:31', '2020-03-31', '2020-02-06 14:36:15'),
(84, '51', NULL, 'Use PWA for mobile', '', 0, '50', '', '2020-01-22 11:02:38', '2020-03-31', '2020-01-22 11:02:49'),
(85, '51', NULL, 'Add opinion stage polls at another page linked within free resources', '', 0, '0', '', '2020-01-22 11:02:46', '2020-03-31', '2020-02-06 14:36:15'),
(86, '51', NULL, 'Embed videos with annotated links to other pages on your site and to YouTube', '', 0, '0', '', '2020-01-22 11:02:54', '2020-03-31', '2020-02-06 14:36:15'),
(87, '51', NULL, 'Link images to open in another page', '', 0, '50', '', '2020-01-22 11:03:01', '2020-03-31', '2020-01-22 11:03:12'),
(88, '51', NULL, 'Increase speed of the site by implementing  action plans under the speed measure', '', 0, '0', '', '2020-01-22 11:03:09', '2020-03-31', '2020-02-06 14:36:15'),
(89, '52', NULL, 'Drop Meaningful Comments on High Traffic posts in Your site', '', 0, '0', '', '2020-01-22 11:03:50', '2020-03-31', '2020-02-06 14:36:15'),
(90, '52', NULL, 'Create Podcasts, Radio Shows, and Use Audio Content to Boost Your Traffic', '', 0, '0', '', '2020-01-22 11:03:58', '2020-03-31', '2020-02-06 14:36:15'),
(91, '52', NULL, 'Aiming for any traffic source that lets you take advantage of user-generated content to boost your SEO', '', 0, '0', '', '2020-01-22 11:04:10', '2020-03-31', '2020-02-06 14:36:15'),
(92, '52', NULL, 'Offer value by sending e.g. monthly eBooks or write ups to the clients', '', 0, '0', '', '2020-01-22 11:04:19', '2020-03-31', '2020-02-06 14:36:15'),
(93, '52', NULL, 'Optimise content for readers - meta tags', '', 0, '0', '', '2020-01-22 11:04:27', '2020-03-31', '2020-02-06 14:36:15'),
(94, '52', NULL, 'Addition of knowledge games related to psychometric tests e.g. this game will help you improve your attention to detail', '', 0, '0', '', '2020-01-22 11:04:57', '2020-03-31', '2020-02-06 14:36:15'),
(95, '53', NULL, 'Find opportunity keywords to rank for on Google', '', 0, '0', '', '2020-01-22 11:06:13', '2020-03-31', '2020-02-06 14:36:15'),
(96, '53', NULL, 'Optimise for on-page SEO', '', 0, '0', '', '2020-01-22 11:06:30', '2020-03-31', '2020-02-06 14:36:15'),
(97, '53', NULL, 'Optimise for user intent', '', 0, '0', '', '2020-01-22 11:06:43', '2020-03-31', '2020-02-06 14:36:15'),
(98, '53', NULL, 'Add share triggers with counters for each post', '', 0, '0', '', '2020-01-22 11:07:57', '2020-03-31', '2020-02-06 14:36:15'),
(99, '53', NULL, 'Make content look awesome - user experience', '', 0, '0', '', '2020-01-22 11:08:22', '2020-03-31', '2020-02-06 14:36:15'),
(100, '53', NULL, 'Build links to your page from related posts', '', 0, '0', '', '2020-01-22 11:08:29', '2020-03-31', '2020-02-06 14:36:15'),
(101, '53', NULL, 'Improve and update content already shared on the sites', '', 0, '0', '', '2020-01-22 11:08:37', '2020-03-31', '2020-02-06 14:36:15'),
(102, '53', NULL, 'Build a community on your site', '', 0, '0', '', '2020-01-22 11:08:45', '2020-03-31', '2020-02-06 14:36:15'),
(103, '54', NULL, 'Ensure websites have clear website structure', '', 0, '0', '', '2020-01-22 11:10:19', '2020-03-31', '2020-02-06 14:36:15'),
(104, '54', NULL, 'Mobile-friendliness', '', 0, '50', '', '2020-01-22 11:10:25', '2020-03-31', '2020-01-22 11:10:33'),
(105, '54', NULL, 'Increase fast page load', '', 0, '0', '', '2020-01-22 11:10:37', '2020-03-31', '2020-02-06 14:36:15'),
(106, '54', NULL, 'UI/UX design to improve user experience', '', 0, '0', '', '2020-01-22 11:10:47', '2020-03-31', '2020-02-06 14:36:15'),
(107, '54', NULL, 'Ensure site is responsive, accessible and available', '', 0, '0', '', '2020-01-22 11:10:54', '2020-03-31', '2020-02-06 14:36:15'),
(108, '55', NULL, 'Reduce image size - compress them', '', 0, '0', '', '2020-01-22 11:12:55', '2020-03-31', '2020-02-06 14:36:15'),
(109, '55', NULL, 'Ensure site is developed from mobile-first quality and speed', '', 0, '0', '', '2020-01-22 11:13:13', '2020-03-31', '2020-02-06 14:36:15'),
(110, '55', NULL, 'Use CDN instead of adding files on the site to reduce the site size', '', 0, '0', '', '2020-01-22 11:13:26', '2020-03-31', '2020-02-06 14:36:15'),
(111, '55', NULL, 'Cache as much as possible to improve on site load time', '', 0, '0', '', '2020-01-22 11:13:34', '2020-03-31', '2020-02-06 14:36:15'),
(112, '55', NULL, 'Use web analytics and gather metrics to track', '', 0, '0', '', '2020-01-22 11:13:41', '2020-03-31', '2020-02-06 14:36:15'),
(113, '56', NULL, 'Go live on social media and embed in sites', '', 0, '0', '', '2020-01-22 11:14:18', '2020-03-31', '2020-02-06 14:36:15'),
(114, '56', NULL, 'Link social media platforms from your site ', '', 0, '0', '', '2020-01-22 11:14:26', '2020-03-31', '2020-02-06 14:36:15'),
(115, '57', NULL, 'Minimise HTTP requests to improve UI/UX', '', 0, '0', '', '2020-01-22 11:15:03', '2020-03-31', '2020-02-06 14:36:15'),
(116, '57', NULL, 'Minify and combine files to reduce the sites file size', '', 0, '0', '', '2020-01-22 11:15:12', '2020-03-31', '2020-02-06 14:36:15'),
(117, '57', NULL, 'Use asynchronous loading for CSS and JavaScript files', '', 0, '0', '', '2020-01-22 11:15:20', '2020-03-31', '2020-02-06 14:36:15'),
(118, '57', NULL, 'Defer JavaScript loading to load last after the rest of the information has loaded', '', 0, '0', '', '2020-01-22 11:15:29', '2020-03-31', '2020-02-06 14:36:15'),
(119, '57', NULL, 'Reduce server response time', '', 0, '0', '', '2020-01-22 11:16:23', '2020-03-31', '2020-02-06 14:36:15'),
(120, '57', NULL, 'Run compression audits of sites using tools such as Pingdom', '', 0, '0', '', '2020-01-22 11:16:30', '2020-03-31', '2020-02-06 14:36:15'),
(121, '57', NULL, 'Enable browser caching to increase page load speed', '', 0, '0', '', '2020-01-22 11:16:36', '2020-03-31', '2020-02-06 14:36:15'),
(122, '57', NULL, 'Reduce image sizes - compress them', '', 0, '0', '', '2020-01-22 11:16:43', '2020-03-31', '2020-02-06 14:36:15'),
(123, '57', NULL, 'Use a CDN instead of adding JS files to sites', '', 0, '0', '', '2020-01-22 11:16:53', '2020-03-31', '2020-02-06 14:36:15'),
(124, '57', NULL, 'Optimise CSS delivery', '', 0, '50', '', '2020-01-22 11:16:59', '2020-03-31', '2020-01-22 11:17:04'),
(125, '58', NULL, 'Review Timesheets and Trello updates daily ', '', 0, '0', '', '2020-01-22 11:17:36', '2020-03-31', '2020-02-06 14:36:15'),
(126, '58', NULL, 'Comply with proposal formatting and reviews', '', 0, '0', '', '2020-01-22 11:17:43', '2020-03-31', '2020-02-06 14:36:15'),
(127, '40', NULL, 'Looking for a new template for the website', '', 0, '100', '', '2020-01-22 11:18:34', '2020-01-31', '2020-01-22 11:18:35'),
(128, '40', 3, 'Single database creation and normalisation', '', 0, '0', '', '2020-01-22 11:18:46', '2020-03-31', '2020-03-17 07:30:44'),
(129, '40', 1, 'Customisation of the template integrating it with existing system', '', 0, '100', '', '2020-01-22 11:18:53', '2020-03-31', '2020-04-11 11:58:04'),
(130, '40', NULL, 'Buying a domain or change the PayGenius domain name and the hosting', '', 0, '100', '', '2020-01-22 11:19:09', '2020-03-31', '2020-04-11 11:58:10'),
(131, '40', NULL, 'Uploading website files online and testing', '', 0, '92', '', '2020-01-22 11:19:17', '2020-03-31', '2020-04-11 11:58:20'),
(132, '40', NULL, 'Advertising and making noise with the new site housing everything (parallel changeover or direct changeover)', '', 0, '100', '', '2020-01-22 11:19:27', '2020-03-31', '2020-04-11 11:57:55'),
(133, '59', NULL, 'Make PayGenius ready for market ', '', 0, '0', '', '2020-01-22 11:20:10', '2020-03-31', '2020-02-06 14:36:15'),
(134, '59', NULL, 'Uploading data from completed templates & refining the data automatically', '', 0, '0', '', '2020-01-22 11:20:17', '2020-03-31', '2020-02-06 14:36:15'),
(135, '59', NULL, 'Make Time Utilisation software ready for market ', '', 0, '0', '', '2020-01-22 11:20:26', '2020-03-31', '2020-02-06 14:36:15'),
(136, '59', NULL, 'Finalise all additions to Talent Hunter ', '', 0, '0', '', '2020-01-22 11:20:35', '2020-03-31', '2020-02-06 14:36:15'),
(137, '59', NULL, 'Make Polaris Job Evaluation System ready for market ', '', 0, '0', '', '2020-01-22 11:20:42', '2020-03-31', '2020-02-06 14:36:15'),
(138, '59', NULL, 'Develop Technical User Manuals for each Toolkit ', '', 0, '0', '', '2020-01-22 11:20:50', '2020-03-31', '2020-02-06 14:36:15'),
(139, '59', NULL, 'Create Master Files for all Toolkits', '', 0, '0', '', '2020-01-22 11:20:57', '2020-03-31', '2020-02-06 14:36:15'),
(140, '59', NULL, 'Train Master Users for each Toolkit - Minimum of 3', '', 0, '0', '', '2020-01-22 11:21:04', '2020-03-31', '2020-02-06 14:36:15'),
(141, '59', NULL, 'Organise free workshops to present  toolkits - Talent Hunter with 40 participants ', '', 0, '0', '', '2020-01-22 11:21:31', '2020-03-31', '2020-02-06 14:36:15'),
(142, '59', NULL, 'Organise free workshops to present  toolkits - 360 Degree Assessment with 40 participants ', '', 0, '50', '', '2020-01-22 11:21:43', '2020-03-31', '2020-01-22 11:22:06'),
(143, '59', NULL, 'Migrate Inquiries and Proposals system online to Talent Hunter', '', 0, '0', '', '2020-01-22 11:21:54', '2020-03-31', '2020-02-06 14:36:15'),
(144, '59', NULL, 'Migrate our email server to the Cloud ', '', 0, '0', '', '2020-01-22 11:22:03', '2020-03-31', '2020-02-06 14:36:15'),
(145, '60', NULL, 'Write top quality content and optimise it', '', 0, '0', '', '2020-01-22 11:23:19', '2020-03-31', '2020-02-06 14:36:15'),
(146, '60', NULL, 'Email marketing and social media marketing', '', 0, '0', '', '2020-01-22 11:23:28', '2020-03-31', '2020-02-06 14:36:15'),
(147, '60', NULL, 'Write top quality content and optimise it', '', 0, '0', '', '2020-01-22 11:23:35', '2020-03-31', '2020-02-06 14:36:15'),
(148, '60', NULL, 'Train all cluster consultants on all toolkits', '', 0, '0', '', '2020-01-22 11:23:46', '2020-03-31', '2020-02-06 14:36:15'),
(149, '61', NULL, 'Create and acquire partnership agreements with regional consultants to sell online products', '', 0, '47', '', '2020-01-22 11:49:31', '2020-03-31', '2020-01-23 06:46:39'),
(150, '72', NULL, 'Write top quality content and optimise it', '', 0, '50', '', '2020-01-23 06:05:44', '2020-03-31', '2020-01-23 06:06:34'),
(151, '72', NULL, 'Email marketing and social media marketing', '', 0, '0', '', '2020-01-23 06:06:14', '2020-03-31', '2020-02-06 14:36:15'),
(152, '74', NULL, 'Write top quality content and optimise it', '', 0, '0', '', '2020-01-23 06:06:52', '2020-03-31', '2020-02-06 14:36:15'),
(153, '71', NULL, 'Reduce image size - compress them', '', 0, '0', '', '2020-01-23 06:09:47', '2020-03-31', '2020-02-06 14:36:15'),
(154, '71', NULL, 'Ensure site is developed from mobile-first quality and speed', '', 0, '0', '', '2020-01-23 06:10:06', '2020-03-31', '2020-02-06 14:36:15'),
(155, '71', NULL, 'Use CDN instead of adding files on the site to reduce the site size', '', 0, '0', '', '2020-01-23 06:10:33', '2020-03-31', '2020-02-06 14:36:15'),
(156, '71', NULL, 'Go live on social media ', '', 0, '50', '', '2020-01-23 06:11:45', '2020-03-31', '2020-01-23 06:11:58'),
(157, '71', NULL, 'Link social media platforms from your site', '', 0, '0', '', '2020-01-23 06:12:07', '2020-03-31', '2020-02-06 14:36:15'),
(158, '71', NULL, 'Invest in promoting ads to reach new audience', '', 0, '50', '', '2020-01-23 06:12:39', '2020-03-31', '2020-01-23 06:14:51'),
(159, '71', NULL, 'Minimise HTTP requests to improve UI/UX', '', 0, '0', '', '2020-01-23 06:14:57', '2020-03-31', '2020-02-06 14:36:15'),
(160, '78', NULL, 'Conduct toolkits training', '', 0, '100', '', '2020-01-23 06:54:25', '2020-03-31', '2020-01-28 09:01:43'),
(161, '78', NULL, 'Write 12 articles every month', '', 0, '50', '', '2020-01-23 06:55:24', '2020-03-31', '2020-01-23 06:55:34'),
(162, '78', NULL, 'Write a white paper', '', 0, '0', '', '2020-01-23 06:55:56', '2020-03-31', '2020-01-28 09:01:47'),
(163, '79', NULL, 'Market our automated systems to to at least 10 new and existing clients combined', '', 0, '100', '', '2020-01-23 06:58:38', '2020-03-31', '2020-02-12 12:56:22'),
(164, '76', NULL, 'To incorporate google recommendations for our site to be optimal', '', 0, '0', '', '2020-01-23 06:59:55', '2020-03-31', '2020-01-23 07:00:32'),
(165, '76', NULL, 'Reduce file sizes for our HR platform to reduce load time', '', 0, '77', '', '2020-01-23 07:00:26', '2020-03-31', '2020-02-05 09:02:29'),
(166, '77', NULL, 'Select the best template for our new portal', '', 0, '100', '', '2020-01-23 07:01:53', '2020-01-23', '2020-02-05 09:02:39'),
(167, '77', NULL, 'To work on the design of the system to follow our standards', '', 0, '100', '', '2020-01-23 07:02:18', '2020-01-31', '2020-02-05 09:02:46'),
(168, '77', NULL, 'To develop a combined database for paygenius, jobsportal and bestemployer', '', 0, '100', '', '2020-01-23 07:02:51', '2020-01-30', '2020-02-05 09:02:49'),
(169, '77', NULL, 'Coding folowing the new designing', '', 0, '100', '', '2020-01-23 07:03:35', '2020-02-29', '2020-01-28 08:52:55'),
(170, '77', NULL, 'System integration and testing', '', 0, '100', '', '2020-01-23 07:03:57', '2020-02-29', '2020-02-18 08:05:47'),
(171, '77', NULL, 'To create a new domain and host the system live', '', 0, '100', '', '2020-01-23 07:04:40', '2020-03-18', '2020-02-05 09:03:04'),
(172, '68', NULL, 'Fill up profile with insightful good quality videos', '', 0, '0', '', '2020-01-23 07:26:44', '2020-03-31', '2020-02-06 14:36:15'),
(173, '68', NULL, 'Email marketing - adding YouTube links to the mailing lists', '', 0, '0', '', '2020-01-23 07:27:18', '2020-03-31', '2020-02-06 14:36:15'),
(174, '68', NULL, 'Embedding the videos within free resources sections on the websites directly from the IPC YouTube account', '', 0, '0', '', '2020-01-23 07:27:53', '2020-03-31', '2020-02-06 14:36:15'),
(175, '68', NULL, 'Tell stories and go live', '', 0, '0', '', '2020-01-23 07:28:20', '2020-03-31', '2020-02-06 14:36:15'),
(176, '68', NULL, 'Add social media links on all IPC online platforms', '', 0, '0', '', '2020-01-23 07:28:52', '2020-03-31', '2020-02-06 14:36:15'),
(177, '68', NULL, 'Ask friends, family and relatives to subscribe to channel', '', 0, '0', '', '2020-01-23 07:29:19', '2020-03-31', '2020-02-06 14:36:15'),
(178, '98', NULL, 'Sourcing CVs', '', 0, '0', '', '2020-01-23 15:30:40', '2020-01-24', '2020-01-23 15:31:29'),
(179, '99', NULL, 'Train all cluster consultants to be super users of the Talent Hunter', '', 0, '0', '', '2020-01-24 06:10:21', '2020-03-31', '2020-01-24 06:10:38'),
(180, '119', NULL, 'Train all consultants to be super users of the balanced scorecard', '', 0, '50', '', '2020-01-27 06:10:11', '2020-02-28', '2020-01-27 06:12:23'),
(181, '121', NULL, 'Train all consultants to be super users of the jobs portal', '', 0, '0', '', '2020-01-27 06:18:49', '2020-04-30', '2020-02-06 14:36:15'),
(182, '106', NULL, 'Migrate 30 clients to the Talent Hunter by end of April', '', 0, '99', '', '2020-01-27 06:18:57', '2020-04-30', '2020-03-14 15:15:55'),
(183, '107', NULL, 'Bring 200 job seekers to the Jobs Portal', '', 0, '74', '', '2020-01-27 06:20:08', '2020-04-30', '2020-03-14 15:17:44'),
(184, '107', 1, 'Bring 200 job seekers to the Jobs Portal', '', 0, '86', '', '2020-01-27 06:20:08', '2020-04-30', '2020-04-11 11:56:44'),
(185, '107', 24, 'Bring 200 job seekers to the Jobs Portal', '', 0, '74', '', '2020-01-27 06:20:08', '2020-04-30', '2020-03-23 13:18:11'),
(186, '108', NULL, 'Hold career fairs at 2 universities', '', 0, '0', '', '2020-01-27 06:21:11', '2020-04-30', '2020-02-06 14:36:15'),
(187, '109', 14, 'Become a superuser of the Balanced scorecard', '', 0, '0', '', '2020-01-27 06:21:47', '2020-04-30', '2020-03-14 15:39:47'),
(188, '110', NULL, 'Become a superuser of the iPerform system', '', 0, '50', '', '2020-01-27 06:22:25', '2020-04-30', '2020-01-27 06:22:26'),
(189, '112', NULL, 'Become a superuser of the Competency Framework', '', 0, '0', '', '2020-01-27 06:24:28', '2020-04-30', '2020-02-06 14:36:15'),
(190, '122', NULL, 'Run Career Fair Shows to at least 5 universities ', '', 0, '0', '', '2020-01-27 06:24:37', '2020-04-30', '2020-02-06 14:36:15'),
(191, '111', NULL, 'Become a superuser of the Polaris System', '', 0, '0', '', '2020-01-27 06:25:16', '2020-04-30', '2020-02-06 14:36:15'),
(192, '123', NULL, 'Train all cluster consultants to be super users of the competency framework', '', 0, '50', '', '2020-01-27 06:28:17', '2020-04-30', '2020-01-27 06:38:58'),
(193, '123', NULL, 'Train all cluster consultants to be super users of the competency framework', '', 0, '50', '', '2020-01-27 06:28:17', '2020-04-30', '2020-01-27 06:40:21'),
(194, '123', NULL, 'Run a competency framework development workshop', '', 0, '0', '', '2020-01-27 06:41:25', '2020-04-30', '2020-02-06 14:36:15'),
(195, '137', NULL, 'Migration of 100 clients to the Talent Hunter ', '', 0, '100', '', '2020-01-27 06:45:01', '2020-04-30', '2020-03-14 13:26:37'),
(196, '137', NULL, 'Run a workshop on interpretation of psychometric tests', '', 0, '0', '', '2020-01-27 06:45:58', '2020-04-30', '2020-02-06 14:36:15'),
(197, '138', NULL, 'preparing content', '', 0, '43', '', '2020-01-27 08:47:04', '2020-01-27', '2020-01-27 08:47:35'),
(199, '140', NULL, 'Preparation of training material', '', 0, '100', '', '2020-01-29 10:35:18', '2020-01-30', '2020-01-29 10:37:20'),
(200, '140', NULL, 'Inviting trainees', '', 0, '0', '', '2020-01-29 10:35:39', '2020-01-30', '2020-02-06 14:36:15'),
(201, '141', 6, 'Weekly business performance report', '', 0, '0', '', '2020-01-31 10:46:28', '2020-02-03', '2020-03-16 12:46:12'),
(202, '141', 2, 'Weekly business performance report 2 by Shamiso 8.30 am', '', 0, '0', '', '2020-01-31 10:57:34', '2020-02-10', '2020-03-16 13:50:54'),
(203, '141', 24, 'Weekly business performance report 3 By Shamiso 8.30 am', '', 0, '18', '', '2020-01-31 10:58:38', '2020-02-17', '2020-03-16 13:51:12'),
(204, '141', 24, 'Weekly business performance report 4 by Shamiso 8.30 am', '', 0, '50', '', '2020-01-31 11:02:55', '2020-02-24', '2020-03-14 18:25:42'),
(205, '141', 24, 'Weekly business performance 5 report by Shamiso 8.30 am', '', 0, '0', '', '2020-01-31 11:04:04', '2020-03-02', '2020-03-16 09:01:17'),
(206, '90', 19, 'Data collection', '', 0, '0', '', '2020-02-05 07:08:11', '', '2020-03-14 19:25:38'),
(207, '90', 19, 'Data cleaning', '', 0, '50', '', '2020-02-05 07:11:00', '2020-03-15', '2020-03-14 19:24:32'),
(208, '100', 4, 'Quasi - Government Sector', '', 0, '49', '', '2020-02-05 07:27:46', '2020-02-29', '2020-04-08 02:29:45'),
(209, '100', 13, 'Retail Sector', '', 0, '94', '', '2020-02-05 07:29:58', '2020-02-29', '2020-06-21 21:53:37'),
(210, '100', NULL, 'Construction Sector', '', 0, '50', '', '2020-02-05 07:30:54', '2020-02-29', '2020-02-05 07:31:12'),
(211, '90', 19, 'Data analysis', '', 0, '0', '', '2020-02-05 07:32:54', '2020-03-20', '2020-03-14 19:24:41'),
(212, '90', NULL, 'Report Writing', '', 0, '0', '', '2020-02-05 07:33:19', '2020-03-31', '2020-02-06 14:36:15'),
(213, '36', NULL, 'Enlist HR Trends for Adsense', '', 0, '100', '', '2020-02-06 13:23:20', '2020-02-06', '2020-02-06 13:25:03'),
(214, '36', NULL, 'Facilitate data entry-content addition to HR Trends', '', 0, '0', '', '2020-02-06 13:24:05', '2020-02-29', '2020-02-06 14:36:15'),
(215, '36', NULL, 'Record the first Dollar generated from HR Trends', '', 0, '0', '', '2020-02-06 13:24:37', '2020-02-29', '2020-02-06 14:36:15'),
(216, '38', NULL, 'Write 4 articles (one weekly)', '', 0, '75', '', '2020-02-06 13:26:16', '2020-02-29', '2020-02-18 13:31:56'),
(217, '38', NULL, 'Quarterly white paper', '', 0, '50', '', '2020-02-06 13:26:42', '2020-03-31', '2020-02-06 13:26:47'),
(218, '38', NULL, 'Greatminds Session Led', '', 0, '0', '', '2020-02-06 13:27:51', '2020-03-31', '2020-02-06 14:36:15'),
(219, '33', NULL, 'Book free presentations (7)', '', 0, '0', '', '2020-02-06 13:29:13', '2020-02-29', '2020-02-06 14:36:15'),
(220, '33', NULL, 'Sign up at least one client', '', 0, '0', '', '2020-02-06 13:29:37', '2020-02-29', '2020-02-06 14:36:15'),
(221, '34', NULL, 'Book free demo presentations', '', 0, '100', '', '2020-02-06 13:30:08', '2020-02-29', '2020-02-18 13:30:52'),
(222, '34', NULL, 'Sign up at least one client', '', 0, '100', '', '2020-02-06 13:30:39', '2020-02-29', '2020-02-18 13:30:59'),
(223, '35', NULL, 'Training with Mr. Zvomuya', '', 0, '75', '', '2020-02-06 13:31:18', '2020-02-29', '2020-02-18 13:32:41'),
(225, '35', NULL, 'Setting up development environment', '', 0, '100', '', '2020-02-06 13:32:32', '2020-02-29', '2020-02-18 13:33:16'),
(227, '37', NULL, 'Come up with new ideas and ways to increase digital revenue', '', 0, '0', '', '2020-02-06 13:37:40', '2020-02-29', '2020-02-06 14:36:15'),
(228, '148', NULL, 'Prepare presentation material', '', 0, '100', '', '2020-02-11 13:58:09', '2020-02-12', '2020-02-11 13:59:11'),
(229, '148', NULL, 'Prepare presentation material', '', 0, '100', '', '2020-02-11 13:58:09', '2020-02-12', '2020-02-18 09:43:12'),
(230, '149', NULL, 'Test on emails send to supervisor after I complete a task', '', 0, '100', '', '2020-02-12 12:33:52', '2020-02-13', '2020-02-12 12:34:02'),
(231, '149', NULL, 'Removing the option for action based measures column on the scorecard', '', 0, '100', '', '2020-02-12 12:40:33', '2020-02-13', '2020-02-12 12:40:40'),
(232, '149', NULL, 'Reviewing iPerform document with Jerry', '', 0, '100', '', '2020-02-12 12:53:06', '2020-02-13', '2020-02-12 12:53:15'),
(233, '79', NULL, 'Demostrating the system at Metbank 3 times', '', 0, '100', '', '2020-02-12 12:56:59', '2020-02-13', '2020-02-12 12:57:05'),
(234, '2', 1, 'engage developed suppliers', '', 0, '0', '', '2020-02-13 10:08:18', '2020-03-20', '2020-03-14 14:53:00'),
(235, '4', NULL, 'Advertise more on social media groups', '', 0, '100', '', '2020-02-13 10:19:07', '2020-02-22', '2020-02-18 08:01:51'),
(236, '146', NULL, 'zuva iperform demo', '', 0, '0', '', '2020-02-28 07:15:04', '2020-02-28', '2020-02-28 07:15:04'),
(237, '151', NULL, 'Preparation of the presentation material', '', 0, '100', '', '2020-03-11 16:54:36', '2020-03-11', '2020-03-11 16:57:21'),
(238, '151', NULL, 'Actual presentation', '', 0, '100', '', '2020-03-11 16:57:48', '2020-03-13', '2020-03-11 16:57:57'),
(239, '40', NULL, 'hjahjsahjsahjsahjsahjsahjsahjsahjsahjsahjsahj', '', 0, '0', '', '2020-03-13 13:25:22', '2020-03-20', '2020-03-13 13:25:22'),
(240, '40', NULL, 'hjahjsahjsahjsahjsahjsahjsahjsahjsahjsahjsahj', '', 0, '61', '', '2020-03-13 13:25:26', '2020-03-20', '2020-05-08 06:08:07'),
(241, '40', NULL, 'hjahjsahjsahjsahjsahjsahjsahjsahjsahjsahjsahj', '', 0, '0', '', '2020-03-13 13:26:41', '2020-03-20', '2020-03-13 13:26:41'),
(242, '40', NULL, 'hjahjsahjsahjsahjsahjsahjsahjsahjsahjsahjsahj', '', 0, '30', '', '2020-03-13 13:26:47', '2020-03-20', '2020-05-08 06:08:00'),
(243, '42', NULL, 'xxmnxmnxnmxmnxnmxnmxnm', '', 0, '0', '', '2020-03-13 13:28:55', '2020-03-20', '2020-03-13 13:28:55'),
(244, '158', NULL, 'this is my checklist also', '', 0, '100', 'jsdhjsjhsdjhsd', '2020-03-14 11:07:36', '2020-03-31', '2020-03-14 11:29:54'),
(245, '137', NULL, 'hsajsajhsajhsajhsajhsa', '', 0, '0', '', '2020-03-14 13:23:29', '2020-03-26', '2020-03-14 13:23:29'),
(246, '158', 16, 'to do thi and that by monthend', '', 0, '0', '', '2020-03-14 14:02:58', '2020-03-27', '2020-03-14 16:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_project_team`
--

CREATE TABLE `bsc_project_team` (
  `id` int(11) NOT NULL,
  `project_id` text NOT NULL,
  `member` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_quarterly`
--

CREATE TABLE `bsc_quarterly` (
  `id` int(11) NOT NULL,
  `target_id` text,
  `quarter` text,
  `amount` text,
  `evidence` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_quarterly`
--

INSERT INTO `bsc_quarterly` (`id`, `target_id`, `quarter`, `amount`, `evidence`, `date`) VALUES
(5, '113', NULL, NULL, NULL, '2020-01-17 13:27:01'),
(8, '153', '2020-01', '0', NULL, '2020-01-17 13:38:05'),
(13, '185', '2020-01', '0', NULL, '2020-01-17 13:51:09'),
(14, '175', NULL, NULL, NULL, '2020-01-17 13:53:23'),
(17, '322', NULL, NULL, NULL, '2020-01-22 09:32:01'),
(18, '450', NULL, NULL, NULL, '2020-01-28 10:19:50'),
(19, '259', NULL, NULL, NULL, '2020-02-04 05:55:58'),
(20, '79', NULL, NULL, NULL, '2020-02-04 06:29:27'),
(21, '339', '2020-01', '0', NULL, '2020-02-04 07:00:26'),
(28, '75', NULL, NULL, NULL, '2020-02-04 07:51:57'),
(29, '210', '2020-01', '0', NULL, '2020-02-04 07:52:27'),
(30, '215', '2020-02', '1', NULL, '2020-02-04 07:52:27'),
(31, '169', '2020-01', '0', NULL, '2020-02-04 08:27:19'),
(33, '153', NULL, NULL, NULL, '2020-02-04 08:58:18'),
(34, '507', '2020-01', '0', NULL, '2020-02-04 09:08:22'),
(35, '185', '2020-02', '0', NULL, '2020-02-04 10:30:53'),
(36, '210', '2020-02', '0', NULL, '2020-02-04 12:32:35'),
(37, '246', NULL, NULL, NULL, '2020-02-04 14:15:49'),
(42, '29', NULL, NULL, NULL, '2020-02-05 06:09:31'),
(46, '28', NULL, NULL, NULL, '2020-02-05 06:15:42'),
(47, '57', '2020-03', '1', NULL, '2020-02-05 06:16:21'),
(48, '56', NULL, NULL, NULL, '2020-02-05 06:16:26'),
(50, '179', '2020-02', '1', NULL, '2020-02-05 06:23:43'),
(53, '53', '2020-01', '100', NULL, '2020-02-05 06:26:01'),
(54, '507', '2020-02', '1', NULL, '2020-02-05 06:44:00'),
(55, '169', '2020-02', '0', NULL, '2020-02-05 06:49:23'),
(57, '179', NULL, NULL, NULL, '2020-02-05 08:39:55'),
(58, '105', NULL, NULL, NULL, '2020-02-06 13:10:46'),
(59, '483', NULL, NULL, NULL, '2020-02-06 13:50:22'),
(60, '339', NULL, NULL, NULL, '2020-02-06 14:13:50'),
(61, '53', NULL, NULL, NULL, '2020-02-07 06:33:10'),
(63, '510', '2020-03', '23', NULL, '2020-02-11 11:01:57'),
(66, '514', '2020-03', '30', NULL, '2020-02-11 11:01:57'),
(67, '516', '2020-03', '1', NULL, '2020-02-11 11:01:57'),
(68, '510', '2020-06', '18', NULL, '2020-02-11 11:07:11'),
(69, '510', '2020-09', '26', NULL, '2020-02-11 11:07:58'),
(70, '510', '2020-12', '40', NULL, '2020-02-11 11:08:38'),
(71, '510', NULL, NULL, NULL, '2020-02-11 11:09:01'),
(72, '512', '2020-03', '70', NULL, '2020-02-11 11:18:23'),
(73, '512', NULL, NULL, NULL, '2020-02-11 11:18:46'),
(74, '513', '2020-03', '60', NULL, '2020-02-11 11:19:03'),
(75, '513', NULL, NULL, NULL, '2020-02-11 11:19:30'),
(76, '514', NULL, NULL, NULL, '2020-02-11 11:19:54'),
(77, '516', NULL, NULL, NULL, '2020-02-11 11:20:31'),
(78, '520', '2020-03', '2', NULL, '2020-02-11 12:12:28'),
(79, '523', '2020-02', '3', NULL, '2020-02-11 12:14:58'),
(80, '523', NULL, NULL, NULL, '2020-02-11 12:15:38'),
(81, '520', NULL, NULL, NULL, '2020-02-11 12:18:08'),
(82, '529', NULL, NULL, NULL, '2020-02-11 12:23:27'),
(83, '191', NULL, '1', NULL, '2020-02-18 14:00:41'),
(85, '543', NULL, NULL, NULL, '2020-02-18 14:24:27'),
(86, '545', NULL, NULL, NULL, '2020-02-18 14:24:36'),
(87, '544', NULL, NULL, NULL, '2020-02-18 14:25:04'),
(88, '553', NULL, NULL, NULL, '2020-03-02 08:49:27'),
(89, '555', NULL, NULL, NULL, '2020-03-02 09:01:22'),
(90, '210', NULL, NULL, NULL, '2020-03-03 15:14:44'),
(91, '215', NULL, NULL, NULL, '2020-03-03 15:15:53'),
(94, '57', NULL, NULL, NULL, '2020-03-06 07:22:31'),
(96, '559', NULL, NULL, NULL, '2020-03-06 07:24:50'),
(97, '557', NULL, NULL, NULL, '2020-03-06 09:02:27'),
(99, '11', NULL, NULL, NULL, '2020-03-06 09:03:01'),
(100, '558', NULL, NULL, NULL, '2020-03-06 09:27:16'),
(101, '560', NULL, NULL, NULL, '2020-03-06 09:33:02'),
(102, '507', NULL, NULL, NULL, '2020-03-06 09:55:26'),
(103, '185', NULL, NULL, NULL, '2020-03-06 10:07:35'),
(104, '191', NULL, NULL, NULL, '2020-03-06 10:59:33'),
(105, '169', NULL, NULL, NULL, '2020-03-06 11:18:56'),
(106, '562', NULL, NULL, NULL, '2020-03-06 11:29:07'),
(107, '563', NULL, NULL, NULL, '2020-03-06 11:29:18'),
(108, '567', NULL, NULL, NULL, '2020-03-06 14:41:13'),
(109, '569', NULL, NULL, NULL, '2020-03-11 10:33:53'),
(110, '573', NULL, NULL, NULL, '2020-03-11 10:33:54'),
(111, '576', NULL, NULL, NULL, '2020-03-11 10:33:55'),
(112, '578', NULL, NULL, NULL, '2020-03-11 12:14:00'),
(113, '582', NULL, NULL, NULL, '2020-03-11 12:15:46'),
(114, '579', '2020-03', '2', NULL, '2020-03-11 12:17:24'),
(115, '577', NULL, NULL, NULL, '2020-03-11 12:19:16'),
(116, '580', NULL, NULL, NULL, '2020-03-11 12:19:16'),
(117, '583', '2020-03', '3', NULL, '2020-03-11 12:21:09'),
(118, '583', NULL, NULL, NULL, '2020-03-11 13:31:43'),
(119, '579', NULL, NULL, NULL, '2020-03-11 13:32:50'),
(120, '584', '2020-03', '230000', NULL, '2020-03-11 14:17:07'),
(121, '584', NULL, NULL, NULL, '2020-03-11 14:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_scorecards`
--

CREATE TABLE `bsc_scorecards` (
  `id` int(11) NOT NULL,
  `client_id` text,
  `leader` text,
  `owner` text,
  `department_id` text,
  `business_unit` text,
  `reporting_period` text,
  `level_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lock1` varchar(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_scorecards`
--

INSERT INTO `bsc_scorecards` (`id`, `client_id`, `leader`, `owner`, `department_id`, `business_unit`, `reporting_period`, `level_id`, `status`, `last_update`, `date`, `lock1`) VALUES
(1, '1', 'Managing Consultant', NULL, NULL, NULL, '2020-12-31', 1, 1, '2020-01-16 12:27:01', '2020-01-16 12:27:01', '0'),
(3, '1', 'Talent Acquisition Manager', '7', '49', '0', '2020-12-31', 3, 1, '2020-02-19 08:56:36', '2020-01-16 12:28:18', '0'),
(5, '1', 'Finance and Admin Manager', '6', '39', '0', '2020-12-31', 3, 1, '2020-02-19 08:58:56', '2020-01-16 12:28:42', '0'),
(6, '1', 'Business Systems Manager', '3', '60', '0', '2020-12-31', 3, 1, '2020-02-19 08:56:05', '2020-01-16 12:29:36', '0'),
(7, '1', NULL, '21', '48', '0', '2020-02-29', 4, 1, '2020-03-04 10:26:04', '2020-01-16 12:34:47', '0'),
(8, '1', NULL, '15', '60', '0', '2020-12-31', 4, 1, '2020-01-17 12:43:24', '2020-01-16 12:36:18', '0'),
(9, '1', NULL, '16', '49', '0', '2020-01-20', 4, 1, '2020-01-20 15:04:41', '2020-01-16 12:37:18', '0'),
(10, '1', NULL, '17', '49', '0', NULL, 4, 1, '2020-01-17 07:06:47', '2020-01-16 12:38:27', '0'),
(11, '1', NULL, '18', '48', '0', NULL, 4, 1, '2020-01-17 07:13:39', '2020-01-16 12:39:20', '0'),
(12, '1', NULL, '19', '44', '0', '', 4, 1, '2020-03-03 11:59:40', '2020-01-16 12:40:07', '0'),
(13, '1', NULL, '20', '48', '0', NULL, 4, 1, '2020-01-17 07:01:05', '2020-01-16 12:41:28', '0'),
(14, '1', NULL, '2', '39', NULL, '2020-12-31', 4, 1, '2020-01-28 14:16:17', '2020-01-16 13:39:39', '0'),
(15, '1', NULL, '11', '44', NULL, '2020-01-17', 4, 1, '2020-01-17 13:25:06', '2020-01-16 13:40:53', '0'),
(16, '1', NULL, '9', '60', NULL, '2020-12-31', 4, 1, '2020-01-17 13:46:17', '2020-01-16 13:42:16', '0'),
(17, '1', NULL, '14', '49', NULL, NULL, 4, 1, '2020-01-17 07:04:17', '2020-01-17 06:49:32', '0'),
(18, '1', NULL, '1', '60', NULL, '2020-12-31', 4, 1, '2020-01-17 09:23:03', '2020-01-17 06:49:40', '0'),
(19, '1', NULL, '8', '60', NULL, '2020-12-31', 4, 1, '2020-01-23 06:26:03', '2020-01-17 06:49:45', '0'),
(20, '1', NULL, '12', '44', NULL, '2020-01-31', 4, 1, '2020-03-03 06:02:09', '2020-01-17 06:49:51', '0'),
(21, '1', NULL, '13', '48', NULL, '2020-12-31', 4, 1, '2020-01-17 13:54:31', '2020-01-17 06:49:56', '0'),
(22, '1', NULL, '22', '49', '0', '', 4, 1, '2020-02-12 14:40:30', '2020-01-17 07:15:28', '0'),
(26, '1', 'OD Manager ', '4', '48', '0', '2020-12-31', 3, 1, '2020-02-19 08:59:37', '2020-01-17 13:16:05', '0'),
(27, '1', 'Analytics Manger', '10', '44', '0', '2020-02-01', 3, 1, '2020-02-19 09:00:57', '2020-01-20 13:15:56', '0'),
(28, '2', 'Patience Kapfunde', NULL, NULL, NULL, '2020-12-31', 1, 1, '2020-01-27 08:23:00', '2020-01-27 08:23:00', '0'),
(30, '1', NULL, '24', '39', '0', '2020-12-31', 4, 1, '2020-01-28 12:57:47', '2020-01-28 12:50:20', '0'),
(31, '1', NULL, '25', '39', '0', '2020-12-31', 4, 1, '2020-01-28 13:43:25', '2020-01-28 12:51:17', '0'),
(32, '3', 'CEO', NULL, NULL, NULL, '2020-12-31', 1, 1, '2020-01-29 09:59:43', '2020-01-29 09:59:43', '0'),
(33, '3', NULL, '27', '22', '0', NULL, 4, 1, '2020-01-29 10:30:32', '2020-01-29 10:30:32', '0'),
(35, '4', 'CEO', NULL, NULL, NULL, '2020-12-31', 1, 1, '2020-02-06 09:25:48', '2020-02-06 09:25:48', '0'),
(36, '5', 'Managing Director', NULL, NULL, NULL, '2020-12-31', 1, 1, '2020-02-11 10:08:27', '2020-02-11 10:08:27', '0'),
(37, '5', '30', NULL, '22', '0', '', 3, 1, '2020-02-11 11:48:58', '2020-02-11 10:20:46', '0'),
(38, '5', 'C B Manager', NULL, '61', '0', '2019-12-31', 3, 1, '2020-02-11 11:57:39', '2020-02-11 10:21:22', '0'),
(42, '5', 'Manager', NULL, '62', '0', '2019-12-31', 3, 1, '2020-02-11 11:58:59', '2020-02-11 10:23:51', '0'),
(43, '5', NULL, '32', '62', '0', '2020-12-31', 4, 1, '2020-02-11 12:03:14', '2020-02-11 11:45:53', '0'),
(44, '5', NULL, '33', '62', '0', '2020-12-31', 4, 1, '2020-02-11 12:19:58', '2020-02-11 11:46:52', '0'),
(45, '5', NULL, '34', '62', '0', '2020-12-31', 4, 1, '2020-02-18 07:08:24', '2020-02-11 11:47:50', '0'),
(46, '6', 'Trust Adminstrator', NULL, NULL, NULL, '2020-12-31', 1, 1, '2020-03-11 10:00:18', '2020-03-11 10:00:18', '0'),
(47, '6', 'Head of Department', '35', '59', '0', '2020-01-01', 3, 1, '2020-03-11 10:44:32', '2020-03-11 10:02:11', '0'),
(48, '6', NULL, '36', '59', '0', '2020-12-31', 4, 1, '2020-03-11 13:56:12', '2020-03-11 10:03:07', '0');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_scorecard_settings`
--

CREATE TABLE `bsc_scorecard_settings` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bsc_scorecard_settings`
--

INSERT INTO `bsc_scorecard_settings` (`id`, `client_id`, `status`) VALUES
(1, 1, 0),
(2, 2, 1),
(3, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_scorecard_settings2`
--

CREATE TABLE `bsc_scorecard_settings2` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `status` varchar(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_scorecard_status`
--

CREATE TABLE `bsc_scorecard_status` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_scorecard_status`
--

INSERT INTO `bsc_scorecard_status` (`id`, `name`) VALUES
(1, 'Curent'),
(2, 'Old');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_simple_template`
--

CREATE TABLE `bsc_simple_template` (
  `id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `activity` text NOT NULL,
  `measure_of_success` text NOT NULL,
  `impact` text NOT NULL,
  `actual` text NOT NULL,
  `carry_forward` varchar(10) NOT NULL DEFAULT '1',
  `due_date` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_strategy_map`
--

CREATE TABLE `bsc_strategy_map` (
  `id` int(11) NOT NULL,
  `scorecard_id` text NOT NULL,
  `perspective_id` text NOT NULL,
  `goal` text NOT NULL,
  `driver` text NOT NULL,
  `strength` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_strategy_map`
--

INSERT INTO `bsc_strategy_map` (`id`, `scorecard_id`, `perspective_id`, `goal`, `driver`, `strength`) VALUES
(1, '36', '1', '238', '241', ''),
(2, '36', '1', '239', '240', '');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_strategy_priorities`
--

CREATE TABLE `bsc_strategy_priorities` (
  `id` int(11) NOT NULL,
  `client_id` text NOT NULL,
  `points` text NOT NULL,
  `goal` text NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_strategy_steps`
--

CREATE TABLE `bsc_strategy_steps` (
  `id` int(11) NOT NULL,
  `step` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bsc_summary_ratings`
--

CREATE TABLE `bsc_summary_ratings` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `platinum` text,
  `gold` text,
  `diamond` text,
  `silver` text,
  `bronze` text,
  `nickel` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_summary_ratings`
--

INSERT INTO `bsc_summary_ratings` (`id`, `client_id`, `platinum`, `gold`, `diamond`, `silver`, `bronze`, `nickel`) VALUES
(1, 1, '60', '40', '20', '0', '-30', '-100'),
(2, 2, '60', '40', '20', '0', '-30', '-100'),
(3, 3, '60', '40', '20', '0', '-30', '-100'),
(4, 4, '60', '40', '20', '0', '-30', '-100'),
(5, 5, '60', '40', '20', '0', '-30', '-100'),
(6, 6, '60', '40', '20', '0', '-30', '-100');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_supporting_documents`
--

CREATE TABLE `bsc_supporting_documents` (
  `id` int(11) NOT NULL,
  `table_name` text NOT NULL,
  `scorecard_id` int(11) NOT NULL,
  `measure_id` text NOT NULL,
  `document` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_supporting_documents`
--

INSERT INTO `bsc_supporting_documents` (`id`, `table_name`, `scorecard_id`, `measure_id`, `document`) VALUES
(1, 'project_tasks', 28, '197', '75455-Scan0001.pdf'),
(2, 'project_tasks', 32, '199', '41821-Terms of References.pdf'),
(3, 'project_tasks', 36, '228', '79032-Terms of References.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_targets`
--

CREATE TABLE `bsc_targets` (
  `id` int(11) NOT NULL,
  `goal_id` text NOT NULL,
  `measure` text,
  `measure_type` int(11) DEFAULT '0',
  `unit` text,
  `reporting_frequency` text,
  `target_period` text,
  `base_target` text,
  `stretch_target` text,
  `actual` text,
  `allocated_weight` text,
  `trend_indicator` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_targets`
--

INSERT INTO `bsc_targets` (`id`, `goal_id`, `measure`, `measure_type`, `unit`, `reporting_frequency`, `target_period`, `base_target`, `stretch_target`, `actual`, `allocated_weight`, `trend_indicator`) VALUES
(1, '1', 'Ad Revenue \r\n', NULL, '$', 'M', 'Y', '120', '200', '130.00', '11', NULL),
(4, '3', 'Cost to income \r\n', NULL, '%', 'M', 'Y', '70', '60', '0.00', '2', NULL),
(5, '1', 'Affiliate Marketing Revenue\r\n', NULL, '$', 'M', 'Y', '25', '45', '0', '2', NULL),
(6, '1', 'Number of toolkit sales\r\n', NULL, '#', 'M', 'Y', '1', '2', '0.5', '5', NULL),
(7, '1', 'PayGenius Revenue & projects Revenue\r\n', NULL, '#', 'M', 'Y', '2933.33', '3666.67', '633.55', '10', NULL),
(8, '4', 'Twitter monthly growth \r\n', NULL, '#', 'M', 'Y', '150', '200', '175.00', '2', NULL),
(9, '4', 'Linkedin monthly growth \r\n', NULL, '#', 'M', 'Y', '750', '1000', '667.00', '2', NULL),
(10, '4', 'Facebook monthly growth \r\n', NULL, '#', 'M', 'Y', '150', '250', '-9.00', '2', NULL),
(11, '5', 'Proposal Success Rate foreign', NULL, '%', 'M', 'Y', '30', '35', '0.00', '2', NULL),
(12, '6', 'Page Views \r\n', NULL, '#', 'M', 'Y', '80000', '100000', '79432.00', '5', NULL),
(13, '6', 'Organic traffic share\r\n', NULL, '%', 'M', 'Y', '50', '60', '60.00', '5', NULL),
(14, '6', 'SEO\r\n', NULL, '#', 'M', 'Y', '16', '17', '13.00', '2', NULL),
(15, '6', 'Usability \r\n', NULL, '#', 'M', 'Y', '16', '17', '16.00', '2', NULL),
(16, '6', 'Performance \r\n', NULL, '#', 'M', 'Y', '16', '17', '4.00', '2', NULL),
(17, '6', 'Social \r\n', NULL, '#', 'M', 'Y', '16', '17', '15.00', '2', NULL),
(18, '6', 'Security \r\n', NULL, '#', 'M', 'Y', '16', '17', '1.00', '2', NULL),
(19, '6', 'Bounce Rate\r\n', NULL, '%', 'M', 'Y', '36', '20', '9.00', '2', NULL),
(20, '6', 'Domain Authority\r\n', NULL, '%', 'M', 'Y', '20', '25', '18.00', '2', NULL),
(21, '6', 'Page Authority\r\n', NULL, '%', 'M', 'Y', '25', '30', '26.00', '2', NULL),
(24, '8', 'Comply with procedures\r\n', NULL, '%', 'M', 'Y', '100', '100', '83.00', '2', NULL),
(25, '9', '% of projects completed\r\n', NULL, '%', 'M', 'Y', '60', '70', '100', '9', NULL),
(26, '10', '# of articles \r\n', NULL, '#', 'M', 'Y', '4', '5', '4.00', '3', NULL),
(27, '10', '# articles views average \r\n', NULL, '#', 'M', 'Y', '200', '300', '14.00', '3', NULL),
(28, '10', '# of white papers \r\n', NULL, '#', 'Q', 'Y', '1', '2', '0.00', '8', NULL),
(29, '10', '# of toolkit trainings\r\n', NULL, '#', 'Q', 'Y', '1', '2', '0.00', '4', NULL),
(30, '11', 'Ad Revenue \r\n', NULL, '$', 'M', 'Y', '120', '200', '130.00', '11', NULL),
(31, '11', 'Affiliate Marketing Revenue\r\n', NULL, '$', 'M', 'Y', '100', '150', '0.00', '2', NULL),
(32, '11', 'Number of toolkit sales\r\n', NULL, '#', 'M', 'Y', '2', '3', '0.00', '6', NULL),
(33, '11', 'PayGenius and Projects Revenue \r\n', NULL, '$', 'M', 'Y', '8800', '11000', '1216.00', '10', NULL),
(34, '12', 'Cost/income ratio', NULL, '%', 'M', 'Y', '70', '60', '2058.00', '2', NULL),
(35, '13', 'IPC Twitter monthly growth \r\n', NULL, '#', 'M', 'Y', '150', '250', '175.00', '2', NULL),
(36, '13', 'IPC Linkedin monthly growth \r\n', NULL, '#', 'M', 'Y', '750', '1000', '667.00', '2', NULL),
(38, '13', 'IPCCareerCenter monthly growth \r\n', NULL, '#', 'M', 'Y', '50', '60', '14.00', '2', NULL),
(39, '13', 'Facebook IPC monthly growth \r\n', NULL, '#', 'M', 'Y', '150', '250', '-9.00', '2', NULL),
(41, '13', 'YouTube monthly growth\r\n', NULL, '#', 'M', 'Y', '500', '600', '4.00', '2', NULL),
(42, '14', 'Local Proposal Success Rate', NULL, '%', 'M', 'Y', '60', '65', '0.00', '2', NULL),
(43, '15', 'Page View Average - All platforms \r\n', NULL, '#', 'M', 'Y', '80000', '100000', '79432.00', '5', NULL),
(44, '15', 'Organic traffic share average across all platforms \r\n', NULL, '%', 'M', 'Y', '50', '60', '60.00', '5', NULL),
(45, '15', 'SEO Average all platfforms average \r\n', NULL, '#', 'M', 'Y', '16', '17', '13.00', '2', NULL),
(46, '15', 'Usability All platforms average \r\n', NULL, '#', 'M', 'Y', '16', '17', '16.00', '2', NULL),
(47, '15', 'Performance \r\n', NULL, '#', 'M', 'Y', '16', '17', '4.00', '2', NULL),
(48, '15', 'Social \r\n', NULL, '#', 'M', 'Y', '16', '17', '15.00', '2', NULL),
(49, '15', 'Security \r\n', NULL, '#', 'M', 'Y', '16', '17', '1.00', '2', NULL),
(50, '15', 'Domain Authority\r\n', NULL, '#', 'M', 'Y', '20', '25', '18.00', '2', NULL),
(51, '15', 'Page Authority\r\n', NULL, '#', 'M', 'Y', '25', '30', '26.00', '2', NULL),
(52, '16', 'Comply with procedures\r\n', NULL, '%', 'M', 'Y', '100', '100', '82.00', '2', NULL),
(53, '17', '% of projects completed\r\n', NULL, '%', 'M', 'Y', '60', '70', '100.00', '9', NULL),
(54, '18', '# of articles \r\n', NULL, '#', 'M', 'Y', '19', '21', '19.00', '3', NULL),
(55, '18', '# articles views average \r\n', NULL, '#', 'M', 'Y', '300', '500', '52.00', '3', NULL),
(56, '18', '# of white papers \r\n', NULL, '#', 'Q', 'Y', '2', '3', '0.00', '2', NULL),
(57, '18', '# of toolkit trainings\r\n', NULL, '#', 'Q', 'Y', '3', '5', '1.00', '10', NULL),
(58, '15', 'Bounce Rate', NULL, '#', 'M', 'Y', '36', '20', '9.00', '2', NULL),
(59, '19', 'Forex Direct', NULL, '$', 'M', 'Y', '3000', '3000', '1703.00', '15', NULL),
(60, '19', 'Forex Converted', NULL, '$', 'M', 'Y', '3000', '3500', '578.00', '10', NULL),
(61, '20', 'Cost to income', NULL, '%', 'M', 'Y', '15', '12', '98.00', '5', NULL),
(62, '21', 'Proposals Success rate ', NULL, '%', 'M', 'Y', '60', '65', '50.00', '8', NULL),
(63, '21', 'Inquiries Success Rate', NULL, '%', 'M', 'Y', '60', '65', '65.00', '8', NULL),
(64, '22', 'PayGenius Revenue \r\n', NULL, '$', 'M', 'Y', '250', '300', '1468.00', '5', NULL),
(65, '21', 'Proposal Succes Rate - Regional ', NULL, '%', 'M', 'Y', '30', '30', '0.00', '8', NULL),
(66, '23', '# of client complaints', NULL, '#', 'M', 'Y', '0', '0', '0.00', '8', NULL),
(67, '24', 'Cost to income \r\n', NULL, '%', 'M', 'Y', '70', '60', '0.00', '2', NULL),
(68, '25', '% Write-downs', NULL, '%', 'M', 'Y', '20', '10', '52.00', '3', NULL),
(69, '25', 'Uitlisation ', NULL, '%', 'M', 'Y', '60', '70', '61.00', '10', NULL),
(70, '26', 'IPC Linkedin monthly growth \r\n', NULL, '#', 'M', 'Y', '750', '1000', '667.00', '2', NULL),
(71, '26', 'IPC Twitter monthly growth \r\n', NULL, '#', 'M', 'Y', '150', '250', '175.00', '2', NULL),
(72, '27', '# of NCs - Timesheets ', NULL, '%', 'M', 'Y', '0', '0', '6.00', '3', NULL),
(73, '27', '# of NCs -Proposals procedures ', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(74, '27', '# of NCs - Pre-Engagement Analysis', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(75, '28', '# of new  profitable ideas', NULL, '#', 'Q', 'Y', '1', '2', '0.00', '9', NULL),
(76, '29', '# of articles', NULL, '#', 'M', 'Y', '2', '3', '4.00', '3', NULL),
(77, '26', 'IPCCareerCenter monthly growth \r\n', NULL, '#', 'M', 'Y', '50', '60', '14.00', '2', NULL),
(78, '29', '# articles views average', NULL, '#', 'M', 'Y', '250', '300', '290.00', '2', NULL),
(79, '29', '# of white papers', NULL, '#', 'Q', 'Y', '1', '2', '0.00', '2', NULL),
(80, '26', 'Facebook IPC monthly growth \r\n', NULL, '#', 'M', 'Y', '150', '250', '-9.00', '2', NULL),
(81, '26', 'YouTube monthly growth\r\n', NULL, '#', 'M', 'Y', '500', '600', '4.00', '2', NULL),
(82, '30', 'Comply with procedures\r\n', NULL, '%', 'M', 'Y', '100', '100', '92.00', '5', NULL),
(83, '30', 'Infographic Development\r\n', NULL, '%', 'M', 'Y', '60', '70', '74.00', '11', NULL),
(85, '31', 'Ad Revenue', NULL, '$', 'M', 'Y', '120', '200', '130.00', '11', NULL),
(86, '32', '# of articles \r\n', NULL, '#', 'M', 'Y', '4', '5', '4.00', '5', NULL),
(87, '32', '# articles views average \r\n', NULL, '#', 'M', 'Y', '100', '300', '57.00', '3', NULL),
(88, '32', '# of white papers \r\n', NULL, '#', 'M', 'Q', '1', '2', '0.00', '8', NULL),
(89, '31', 'Affiliate Marketing Revenue', NULL, '$', 'M', 'Y', '100', '150', '0.00', '2', NULL),
(91, '31', 'Number of toolkit sales\r\n', NULL, '#', 'M', 'Y', '1', '2', '0.00', '5', NULL),
(92, '31', 'PayGenius and Projects Revenue\r\n', NULL, '$', 'M', 'Y', '2933.33', '3666.67', '633.5', '10', NULL),
(94, '34', 'Cost to income \r\n', NULL, '%', 'M', 'Y', '70', '60', '0', '2', NULL),
(95, '35', 'IPC Twitter monthly growth \r\n', NULL, '#', 'M', 'Y', '150', '250', '175.00', '2', NULL),
(96, '35', 'IPC Linkedin monthly growth \r\n', NULL, '#', 'M', 'Y', '750', '1000', '667.00', '2', NULL),
(97, '36', 'Forex- Direct \r\n', NULL, '$', 'M', 'Y', '3000', '3500', '62.00', '15', NULL),
(98, '35', 'IPC Facebook monthly growth \r\n', NULL, '#', 'M', 'Y', '150', '250', '-9.00', '2', NULL),
(99, '36', 'Forex - Local \r\n', NULL, '$', 'M', 'Y', '3000', '3500', '2700.00', '10', NULL),
(101, '38', 'Forex Direct\r\n', NULL, '$', 'M', 'M', '3000', '3000', '350.00', '15', NULL),
(102, '39', 'Cost to income', NULL, '%', 'M', 'Y', '40', '30', '107.00', '5', NULL),
(104, '37', 'Total revenue in USD equivalent ', NULL, '$', 'M', 'M', '6000', '6500', '7767.25', '15', NULL),
(105, '40', 'Local Proposal Success Rate Average \r\n', NULL, '%', 'M', 'Y', '60', '65', '0.00', '2', NULL),
(106, '41', 'Proposals Success rate \r\n', NULL, '%', 'M', 'Y', '60', '65', '0.00', '5', NULL),
(108, '43', 'Total revenue in USD equivalent', NULL, '$', 'M', 'M', '23000', '28000', '18094.76', '15', NULL),
(109, '44', 'Page View Average - All platforms \r\n\r\n', NULL, '#', 'M', 'Y', '80000', '100000', '79432.00', '5', NULL),
(111, '41', 'Inquiries Success Rate \r\n', NULL, '%', 'M', 'Y', '60', '65', '43.00', '8', NULL),
(113, '45', 'Cost to income \r\n', NULL, '%', 'M', 'M', '40', '35', '40.00', '5', NULL),
(114, '41', 'Proposal Succes Rate - Regional \r\n', NULL, '%', 'M', 'Y', '30', '30', '0.00', '5', NULL),
(115, '46', 'Quotation Success rate', NULL, '%', 'M', 'M', '60', '66', '41.5', '8', NULL),
(116, '44', 'Organic traffic share average across all platforms \r\n\r\n', NULL, '%', 'M', 'Y', '50', '60', '60.00', '5', NULL),
(117, '46', 'Proposals Success rate \r\n', NULL, '%', 'M', 'M', '60', '65', '100', '8', NULL),
(118, '47', '# of client complaints \r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '5', NULL),
(122, '46', 'Proposal Success Rate - Regional \r\n', NULL, '%', 'M', 'M', '30', '65', '0.00', '8', NULL),
(123, '44', 'SEO\r\n', NULL, '#', 'M', 'Y', '16', '17', '13.00', '2', NULL),
(124, '49', '% Write-downs\r\n', NULL, '%', 'M', 'Y', '20', '10', '-24.00', '6', NULL),
(125, '50', 'Cost to income ', NULL, '%', 'M', 'M', '40', '30', '49.8', '15', NULL),
(126, '44', 'Usability \r\n', NULL, '#', 'M', 'Y', '16', '17', '16.00', '2', NULL),
(127, '44', 'Performance \r\n', NULL, '#', 'M', 'Y', '16', '17', '4.00', '2', NULL),
(128, '44', 'Social \r\n', NULL, '#', 'M', 'Y', '16', '17', '15.00', '2', NULL),
(129, '51', 'Proposal success rate - Local ', NULL, '%', 'M', 'M', '60', '65', '15.35', '8', NULL),
(130, '44', 'Security \r\n', NULL, '#', 'M', 'Y', '16', '17', '1.00', '2', NULL),
(131, '52', '# of client complaints \r\n', NULL, '#', 'M', 'M', '0', '0', '0', '8', NULL),
(132, '44', 'Bounce Rate\r\n', NULL, '%', 'M', 'Y', '36', '20', '9.00', '2', NULL),
(133, '44', 'Domain Authority\r\n', NULL, '#', 'M', 'Y', '20', '25', '18.00', '2', NULL),
(134, '51', 'Quotation success rate ', NULL, '%', 'M', 'M', '60', '65', '40', '8', NULL),
(135, '44', 'Page Authority\r\n', NULL, '#', 'M', 'Y', '25', '35', '26.00', '2', NULL),
(139, '51', 'Proposal success rate - Regional ', NULL, '%', 'M', 'M', '30', '35', '0', '8', NULL),
(140, '54', '% Write-downs\r\n', NULL, '%', 'M', 'M', '20', '10', '49.5', '5', NULL),
(141, '49', 'Uitlisation \r\n', NULL, '%', 'M', 'Y', '65', '70', '39.00', '15', NULL),
(143, '54', 'Uitlisation \r\n', NULL, '%', 'M', 'M', '65', '70', '77.00', '5', NULL),
(145, '57', '# of NCs - Timesheets \r\n', NULL, '%', 'M', 'Y', '0', '0', '11.00', '3', NULL),
(146, '55', 'Number of client complaints ', NULL, '#', 'M', 'Y', '0', '0', '0', '8', NULL),
(147, '57', '# of NCs -Proposals procedures \r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(149, '58', '# of NCs - Timesheets \r\n', NULL, '#', 'M', 'M', '0', '0', '9', '3', NULL),
(150, '57', '# of NCs - Pre-Engagement Analysis \r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(151, '59', '% write-ups', NULL, '%', 'M', 'M', '20', '10', '8.7', '5', NULL),
(152, '58', '# of NCs -Proposals procedures \r\n', NULL, '#', 'M', 'M', '0', '0', '0', '3', NULL),
(153, '60', '# of new  profitable ideas\r\n', NULL, '#', 'Q', 'Y', '1', '2', '0.00', '5', NULL),
(154, '58', '# of NCs - Pre-Engagement Analysis \r\n', NULL, '#', 'M', 'M', '0', '0', '0', '3', NULL),
(155, '59', 'Billable Time Utilisation ', NULL, '%', 'M', 'M', '65', '70', '56.00', '5', NULL),
(157, '62', '# of articles \r\n', NULL, '#', 'M', 'Y', '2', '3', '4.00', '3', NULL),
(160, '65', 'Comply with procedures\r\n', NULL, '%', 'M', 'Y', '100', '100', '90.00', '2', NULL),
(161, '64', '# of new  profitable ideas\r\n', NULL, '#', 'M', 'M', '1', '2', '0', '9', NULL),
(162, '66', '% of projects completed\r\n', NULL, '%', 'M', 'Y', '60', '70', '100.00', '9', NULL),
(165, '67', '# of articles \r\n', NULL, '#', 'M', 'M', '2', '3', '4', '2', NULL),
(166, '67', '# articles views average \r\n', NULL, '#', 'M', 'M', '250', '300', '300.00', '2', NULL),
(169, '67', '# of white papers \r\n', NULL, '#', 'Q', 'Q', '1', '2', '0', '2', NULL),
(171, '72', '# of articles \r\n', NULL, '#', 'M', 'Y', '4', '5', '4.00', '3', NULL),
(172, '73', '# of articles ', NULL, '#', 'M', 'M', '2', '3', '4.00', '3', NULL),
(174, '72', '# articles views average \r\n', NULL, '#', 'M', 'Y', '300', '500', '43.00', '3', NULL),
(175, '72', '# of white papers \r\n', NULL, '#', 'Q', 'Y', '2', '5', '0.00', '8', NULL),
(176, '75', '# of NCs - Timesheets ', NULL, '#', 'M', 'M', '0', '0', '4.00', '3', NULL),
(178, '62', '# articles views average \r\n', NULL, '#', 'M', 'Y', '250', '300', '167.00', '2', NULL),
(179, '72', '# of toolkit trainings\r\n', NULL, '#', 'Q', 'Y', '3', '5', '1.00', '4', NULL),
(181, '75', '# of NCs - Proposals & Procedures ', NULL, '#', 'M', 'M', '0', '0', '0', '3', NULL),
(182, '75', '# of NCs - Pre-Engagement Analysis ', NULL, '#', 'M', 'M', '0', '0', '0.00', '3', NULL),
(185, '78', '# of new Products/ Services ', NULL, '#', 'Q', 'Q', '1', '2', '0', '9', NULL),
(187, '79', '# of articles ', NULL, '#', 'M', 'M', '20', '22', '20.5', '2', NULL),
(188, '62', '# of white papers \r\n', NULL, '#', 'M', 'Y', '1', '2', '0.00', '2', NULL),
(189, '79', '# of article views - average ', NULL, '#', 'M', 'M', '250', '300', '1260.00', '2', NULL),
(190, '80', 'Proposals Success rate \r\n', NULL, '%', 'M', 'M', '60', '65', '25.00', '8', NULL),
(191, '79', '# of white papers ', NULL, '#', 'Q', 'M', '5', '8', '0.00', '2', NULL),
(192, '81', '% Write-downs\r\n', NULL, '%', 'M', 'M', '20', '10', '32.00', '3', NULL),
(193, '82', 'Forex Direct\r\n', NULL, '$', 'M', 'Y', '3000', '3000', '0.00', '15', NULL),
(194, '83', 'Cost to income \r\n', NULL, '%', 'M', 'Y', '40', '35', '33.00', '5', NULL),
(195, '82', 'Forex Converted\r\n', NULL, '$', 'M', 'Y', '3000', '3500', '5073.00', '10', NULL),
(196, '84', 'Proposals Success rate ', NULL, '%', 'M', 'Y', '60', '65', '50.00', '8', NULL),
(198, '84', 'Inquiries Success Rate \r\n', NULL, '%', 'M', 'Y', '60', '65', '38.00', '8', NULL),
(199, '84', 'Proposal Succes Rate - Regional \r\n', NULL, '%', 'M', 'Y', '30', '30', '0.00', '8', NULL),
(201, '86', '# of client complaints \r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '8', NULL),
(202, '87', '% Write-downs\r\n', NULL, '%', 'M', 'Y', '20', '10', '-3035.00', '3', NULL),
(205, '87', 'Utilisation ', NULL, '%', 'M', 'Y', '65', '70', '60.00', '10', NULL),
(206, '89', '# of NCs - Timesheets \r\n', NULL, '%', 'M', 'Y', '0', '0', '19.00', '3', NULL),
(207, '89', '# of NCs - Proposals procedures \r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(208, '89', '# of NCs - Pre-Engagement Analysis \r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(210, '91', '# of new  profitable ideas\r\n', NULL, '#', 'Q', 'Y', '1', '2', '0.00', '9', NULL),
(211, '90', 'Cost to income', NULL, '%', 'M', 'Y', '40', '30', '-36', '15', NULL),
(212, '92', '# of articles \r\n', NULL, '#', 'M', 'Y', '2', '3', '4.00', '3', NULL),
(213, '92', '# articles views average \r\n', NULL, '#', 'M', 'Y', '250', '300', '372.00', '2', NULL),
(215, '92', '# of white papers \r\n', NULL, '#', 'Q', 'Y', '1', '2', '1.00', '2', NULL),
(216, '93', 'Proposal Success Rate', NULL, '%', 'M', 'Y', '60', '65', '12.5', '8', NULL),
(217, '93', 'Proposal Success Rate- Regional', NULL, '%', 'M', 'Y', '30', '30', '0', '8', NULL),
(219, '94', '# of client complaints', NULL, '#', 'M', 'Y', '0', '0', '0', '8', NULL),
(220, '95', '% Write-downs', NULL, '%', 'M', 'Y', '20', '10', '0', '5', NULL),
(221, '95', 'Utilisation', NULL, '%', 'M', 'Y', '65', '70', '68.00', '5', NULL),
(222, '96', '# of NCs - Timesheets ', NULL, '#', 'M', 'M', '0', '1', '0.5', '3', NULL),
(223, '96', '# of NCs -Proposals procedures ', NULL, '#', 'M', 'M', '0', '0', '0', '3', NULL),
(224, '96', '# of NCs - Pre-Engagement Analysis ', NULL, '#', 'M', 'Y', '0', '0', '0', '3', NULL),
(226, '97', '# of articles ', NULL, '#', 'M', 'Y', '2', '3', '4', '3', NULL),
(227, '97', '# articles views average ', NULL, '#', 'M', 'Y', '250', '300', '324.00', '2', NULL),
(228, '97', '# of white papers', NULL, '#', 'M', 'Y', '1', '2', '0', '2', NULL),
(230, '98', 'Total Revenue in USD Equivalent', NULL, '$', 'M', 'Y', '5575', '6500', '8719.00', '25', NULL),
(231, '99', 'Cost to income', NULL, '%', 'M', 'Y', '15', '12', '25.00', '5', NULL),
(233, '100', 'Proposal success rate (local)', NULL, '%', 'M', 'Y', '60', '65', '0.00', '8', NULL),
(234, '100', 'Recruitment success rate', NULL, '%', 'M', 'Y', '60', '65', '17.00', '6', NULL),
(235, '100', 'Quotation Success rate', NULL, '%', 'M', 'Y', '60', '65', '55.00', '6', NULL),
(236, '100', 'Proposal success rate- Regional', NULL, '%', 'M', 'Y', '30', '30', '0.00', '6', NULL),
(237, '101', '# of client complaints', NULL, '#', 'M', 'Y', '0', '0', '0.00', '6', NULL),
(238, '102', '% Write-downs', NULL, '%', 'M', 'Y', '20', '10', '-21.00', '5', NULL),
(239, '102', 'Billable Uitlisation ', NULL, '%', 'M', 'Y', '65', '70', '67.00', '5', NULL),
(243, '103', '# of new  profitable ideas', NULL, '#', 'M', 'Y', '1', '2', '0.00', '9', NULL),
(244, '104', '# of articles ', NULL, '#', 'M', 'Y', '2', '3', '3.00', '2', NULL),
(245, '104', '# articles views average ', NULL, '#', 'M', 'Y', '250', '300', '75.00', '2', NULL),
(246, '104', '# of white papers ', NULL, '#', 'Q', 'Y', '1', '2', '0.00', '2', NULL),
(248, '105', 'Total Revenue in USD Equivalent', NULL, '$', 'M', 'Y', '5750', '6500', '10407.00', '15', NULL),
(249, '106', 'Cost to Income ratio', NULL, '%', 'M', 'Y', '15', '12', '28.5', '15', NULL),
(252, '107', 'Proposal Success Rate - Local', NULL, '%', 'M', 'Y', '60', '65', '15.00', '8', NULL),
(253, '107', 'Proposal Success Rate - Regional', NULL, '%', 'M', 'Y', '30', '30', '0.00', '6', NULL),
(254, '108', 'Number of Client Complaints', NULL, '#', 'M', 'Y', '0', '0', '0.00', '6', NULL),
(255, '109', '% Write downs', NULL, '%', 'M', 'Y', '20', '10', '0', '3', NULL),
(256, '109', 'Billable Utilisation', NULL, '%', 'M', 'Y', '70', '80', '69.00', '10', NULL),
(257, '110', '# of Articles', NULL, '#', 'M', 'Y', '2', '3', '3.00', '3', NULL),
(258, '110', '# of Article views average', NULL, '#', 'M', 'Y', '250', '300', '172.00', '2', NULL),
(259, '110', '# of white papers', NULL, '#', 'Q', 'Y', '1', '2', '0.00', '2', NULL),
(262, '112', 'Cost to income \r\n', NULL, '%', 'M', 'M', '40', '30', '521', '15', NULL),
(263, '113', 'Proposals Success rate \r\n', NULL, '%', 'M', 'M', '60', '65', '0', '8', NULL),
(265, '113', 'Proposal Succes Rate - Regional \r\n', NULL, '%', 'M', 'M', '30', '30', '0', '8', NULL),
(267, '114', '% Write-downs\r\n', NULL, '%', 'M', 'M', '20', '10', '-16', '5', NULL),
(268, '114', 'Uitlisation \r\n', NULL, '%', 'M', 'M', '65', '70', '58.23', '5', NULL),
(269, '115', '# of NCs - Timesheets \r\n', NULL, '#', 'M', 'M', '0', '0', '6.5', '3', NULL),
(270, '115', '# of NCs -Proposals procedures \r\n', NULL, '#', 'M', 'M', '0', '0', '0', '3', NULL),
(271, '115', '# of NCs - Pre-Engagement Analysis \r\n', NULL, '#', 'M', 'M', '0', '0', '0', '3', NULL),
(272, '116', '# of new  profitable ideas\r\n\r\n', NULL, '#', 'M', 'M', '1', '2', '0', '9', NULL),
(273, '117', '# of client complaints \r\n', NULL, '#', 'M', 'M', '0', '0', '0', '8', NULL),
(274, '118', '# of articles \r\n', NULL, '#', 'M', 'M', '2', '3', '4', '3', NULL),
(275, '118', '# articles views average \r\n', NULL, '#', 'M', 'M', '250', '300', '425.00', '2', NULL),
(284, '124', 'Total Revenue in USD Equivalent', NULL, '$', 'M', 'Y', '18400', '23000', '19140.00', '15', NULL),
(285, '123', 'Recruitment Success Rate', NULL, '%', 'M', 'Y', '60', '65', '5.00', '8', NULL),
(287, '123', 'Proposal Success Rate Regional', NULL, '%', 'M', 'Y', '60', '65', '0.00', '6', NULL),
(288, '123', 'Quotation Success Rate Regional', NULL, '%', 'M', 'Y', '60', '65', '17.00', '6', NULL),
(290, '125', '% write down', NULL, '%', 'M', 'Y', '20', '10', '179.00', '5', NULL),
(291, '125', 'Billable Utilisation', NULL, '%', 'M', 'Y', '70', '80', '64.00', '5', NULL),
(294, '127', 'Forex Direct', NULL, '$', 'M', '', '3000', '3000', '0.00', '15', NULL),
(295, '127', 'Local Revenue in Forex', NULL, '$', 'M', '', '3000', '3500', '0.00', '10', NULL),
(297, '128', 'Cost to income', NULL, '%', 'M', '', '15', '12', '0.00', '5', NULL),
(298, '129', 'Proposals Success Rate', NULL, '%', 'M', '', '60', '65', '0.00', '6', NULL),
(299, '129', 'Recruitment Success Rate', NULL, '%', 'M', '', '60', '65', '0.00', '8', NULL),
(300, '129', 'Inquires Success Rate', NULL, '%', 'M', '', '60', '65', '0.00', '6', NULL),
(301, '129', 'Proposal Success Rate - Regional', NULL, '%', 'M', '', '30', '30', '0.00', '6', NULL),
(302, '130', '# of client complaints', NULL, '#', 'M', '', '0', '0', '0.00', '6', NULL),
(303, '131', '% Write downs', NULL, '%', 'M', '', '20', '10', '0.00', '3', NULL),
(304, '131', 'Utilisation', NULL, '%', 'M', '', '65', '70', '0.00', '10', NULL),
(305, '132', '# of NCs - Timesheets', NULL, '#', 'M', '', '0', '0', '0.00', '3', NULL),
(306, '132', '# of NCs - Proposal Procedures', NULL, '#', 'M', '', '0', '0', '0.00', '3', NULL),
(307, '132', '# of NCs - Pre-engagement analysis', NULL, '#', 'M', '', '0', '0', '0.00', '3', NULL),
(308, '133', '# of new profitable ideas', NULL, '#', 'M', '', '1', '2', '0.00', '9', NULL),
(309, '134', '# of articles', NULL, '#', 'M', '', '2', '3', '0.00', '3', NULL),
(310, '134', '# of article views average', NULL, '#', 'M', '', '250', '300', '0.00', '2', NULL),
(311, '134', '# of white papers', NULL, '#', 'M', '', '1', '2', '0.00', '2', NULL),
(312, '135', '# of NCS-Timesheets', NULL, '#', 'M', 'Y', '100', '100', '37.00', '3', NULL),
(313, '135', '# of NCs-Proposal Procedures', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(314, '135', '# of NCs pre-engagement analysis', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(315, '136', 'Ad revenue', NULL, '$', 'M', 'Y', '120', '200', '164.00', '13', NULL),
(316, '136', 'Affiliate Market', NULL, '$', 'M', 'Y', '100', '150', '0.00', '2', NULL),
(317, '136', 'Number of toolkit sales', NULL, '$', 'M', 'Y', '2', '3', '0.00', '10', NULL),
(318, '136', 'PayGenius Revenue', NULL, '#', 'M', 'Y', '85', '100', '4.00', '5', NULL),
(320, '137', 'Cost to income ', NULL, '%', 'M', 'Y', '4', '3', '0.00', '2', NULL),
(321, '138', 'IPC Twitter monthly growth', NULL, '#', 'M', 'Y', '150', '250', '219.00', '2', NULL),
(322, '139', 'Proposal Success Rate', NULL, '%', 'Q', 'Y', '60', '70', '0.00', '2', NULL),
(323, '138', 'IPC LinkedIn monthly growth \r\n', NULL, '#', 'M', 'Y', '750', '1000', '0.00', '2', NULL),
(324, '138', 'IPC Facebook monthly growth', NULL, '#', 'M', 'Y', '150', '250', '5.00', '2', NULL),
(325, '140', 'Organic traffic share', NULL, '%', 'M', 'Y', '40', '50', '58.00', '5', NULL),
(326, '140', 'Page Views all platforms', NULL, '#', 'M', 'Y', '80000', '100000', '76620.00', '5', NULL),
(327, '140', 'SEO', NULL, '#', 'M', 'Y', '16', '17', '12.00', '2', NULL),
(328, '140', 'Usability ', NULL, '#', 'M', 'Y', '16', '17', '0.00', '2', NULL),
(329, '140', 'Performance', NULL, '#', 'M', 'Y', '16', '17', '0.00', '2', NULL),
(330, '140', 'Social', NULL, '#', 'M', 'Y', '16', '17', '16.00', '2', NULL),
(331, '140', 'Security', NULL, '#', 'M', 'Y', '16', '17', '1.00', '2', NULL),
(332, '140', 'Bounce Rate', NULL, '%', 'M', 'Y', '36', '20', '9.00', '2', NULL),
(333, '140', 'Domain Authority', NULL, '%', 'M', 'Y', '20', '25', '0.00', '2', NULL),
(334, '140', 'Page Authority', NULL, '%', 'M', 'Y', '25', '30', '0.00', '2', NULL),
(335, '141', 'Comply with procedures', NULL, '%', 'W', 'Y', '100', '100', '75.00', '2', NULL),
(336, '142', '% of projects completed', NULL, '%', 'M', 'Y', '60', '70', '100.00', '9', NULL),
(338, '143', '# of articles', NULL, '#', 'M', 'Y', '4', '5', '4.00', '3', NULL),
(339, '143', '# of white papers', NULL, '#', 'Q', 'Y', '1', '2', '0.00', '8', NULL),
(340, '143', '# of toolkit training', NULL, '#', 'M', 'Y', '1', '2', '0.00', '5', NULL),
(341, '22', 'Ad Revenue', NULL, '$', 'M', 'Y', '120', '200', '130.00', '12', NULL),
(342, '22', 'Affiliate Revenue ', NULL, '$', 'M', 'Y', '100', '150', '0.00', '2', NULL),
(343, '22', 'Number of Toolkit', NULL, '#', 'M', 'Y', '2', '3', '0.00', '10', NULL),
(344, '30', 'Page View Average - All platforms ', NULL, '#', 'M', 'Y', '80000', '100000', '79432.00', '5', NULL),
(345, '30', 'Organic Traffic average across all platforms ', NULL, '%', 'M', 'Y', '50', '60', '60.00', '5', NULL),
(346, '35', 'IPCCareerCenter monthly growth \r\n', NULL, '#', 'M', 'Y', '50', '60', '14.00', '2', NULL),
(347, '35', 'YouTube monthly growth\r\n', NULL, '#', 'M', 'Y', '500', '600', '4.00', '2', NULL),
(348, '30', 'SEO average all platforms avarage ', NULL, '#', 'M', 'Y', '16', '17', '13.00', '2', NULL),
(349, '30', 'Usability all platforms', NULL, '#', 'M', 'Y', '16', '17', '16.00', '2', NULL),
(350, '143', '# of articles views', NULL, '#', 'M', 'Y', '200', '300', '20.00', '3', NULL),
(351, '30', 'Performance ', NULL, '#', 'M', 'Y', '16', '17', '4.00', '2', NULL),
(352, '30', 'Social', NULL, '#', 'M', 'Y', '16', '17', '15.00', '2', NULL),
(353, '30', 'Security', NULL, '#', 'M', 'Y', '16', '17', '1.00', '2', NULL),
(354, '30', 'Bonce Rate', NULL, '#', 'M', 'Y', '36', '20', '9.00', '2', NULL),
(355, '30', 'Page Authority', NULL, '#', 'M', 'Y', '25', '30', '26.00', '2', NULL),
(356, '30', 'Domain Authority', NULL, '#', 'M', 'Y', '20', '30', '18.00', '2', NULL),
(357, '138', 'IPC Youtube monthly growth', NULL, '#', 'M', 'Y', '500', '600', '0.00', '2', NULL),
(358, '138', 'IPC Career Center Growth', NULL, '#', 'M', 'Y', '50', '60', '15.00', '2', NULL),
(360, '144', 'Cost to income ', NULL, '%', 'M', 'M', '40', '30', '51', '15', NULL),
(362, '113', 'Quotation Success Rate', NULL, '%', 'M', 'M', '60', '65', '25', '8', NULL),
(363, '41', 'Quotation success rate', NULL, '%', 'M', 'Y', '60', '65', '0.00', '5', NULL),
(364, '4', 'Youtube monthly', NULL, '#', 'M', 'Y', '500', '600', '8.00', '2', NULL),
(365, '4', 'Career center', NULL, '#', 'M', 'Y', '50', '60', '14.00', '2', NULL),
(367, '145', 'Forex Direct ', NULL, '$', 'M', '', '3000', '3000', '0.00', '15', NULL),
(368, '146', '# of NC\'s - Times', NULL, '%', 'M', 'Y', '100', '100', '74.00', '3', NULL),
(369, '145', 'Local Revenue in Forex', NULL, '$', 'M', '', '3000', '3500', '0.00', '10', NULL),
(370, '147', 'Cost to Income ', NULL, '%', 'M', '', '15', '12', '0.00', '5', NULL),
(371, '146', '# of NC\'s - Proposals', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(372, '148', 'Proposals Success Rate', NULL, '%', 'M', '', '60', '65', '0.00', '6', NULL),
(373, '146', '# of NC\'s - Pre-Engagement analysis', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(374, '148', 'Recruitment Success Rate', NULL, '%', 'M', '', '60', '65', '0.00', '8', NULL),
(375, '149', '# of new profitable products', NULL, '#', 'M', 'Y', '1', '2', '0.00', '9', NULL),
(376, '38', 'Forex Converted\r\n', NULL, '$', 'M', 'M', '3000', '3498', '4051.00', '10', NULL),
(377, '148', 'Inquiries Success Rate', NULL, '%', 'M', '', '60', '65', '0.00', '6', NULL),
(378, '148', 'Proposal Success Rate', NULL, '%', 'M', '', '30', '30', '0.00', '6', NULL),
(379, '150', '# of Clients Complaints', NULL, '#', 'M', '', '0', '0', '0.00', '6', NULL),
(380, '93', 'Quotation Success Rate', NULL, '%', 'M', 'M', '60', '65', '25', '8', NULL),
(381, '151', '% Write Downs', NULL, '%', 'M', '', '20', '10', '0.00', '3', NULL),
(382, '151', 'Utilisation', NULL, '%', 'M', '', '65', '70', '0.00', '10', NULL),
(385, '152', '# of NCs - Timesheets', NULL, '#', 'M', '', '0', '0', '0.00', '3', NULL),
(387, '152', '# of NCs - Proposal Procedures', NULL, '#', 'M', '', '0', '0', '0.00', '3', NULL),
(389, '152', '# of NCs - Pre-engagement Analysis ', NULL, '#', 'M', '', '0', '0', '0.00', '3', NULL),
(390, '153', 'Cost to income ratio', NULL, '$', 'M', 'Y', '60', '70', '0.00', '15', NULL),
(391, '154', '# of New Profitable Ideas', NULL, '#', 'M', '', '1', '2', '0.00', '9', NULL),
(392, '155', '# of Articles ', 0, '#', 'M', 'Y', '2', '3', '0.00', '3', NULL),
(393, '155', '# of Article Views Average', 0, '#', 'M', 'Y', '250', '300', '0.00', '2', NULL),
(394, '155', '# of White Papers', 0, '#', 'M', 'Y', '1', '2', '0.00', '2', NULL),
(396, '157', 'Total Revenue in USD Equivalent', NULL, '$', 'M', 'Y', '18400', '23000', '8347.67', '15', NULL),
(399, '80', 'Inquiries Success Rate \r\n', NULL, '%', 'M', 'M', '60', '65', '39.00', '8', NULL),
(400, '80', 'Proposal Succes Rate - Regional \r\n', NULL, '%', 'M', 'M', '30', '30', '0.00', '8', NULL),
(401, '158', '# of new  profitable ideas', NULL, '#', 'M', 'Y', '1', '2', '0', '9', NULL),
(402, '159', '# of client complaints \r\n', NULL, '#', 'M', 'M', '0', '0', '0.00', '8', NULL),
(404, '160', 'Quotation Success Rate', NULL, '%', 'M', 'Y', '60', '65', '80.00', '8', NULL),
(405, '160', 'Proposal Success', NULL, '%', 'M', 'Y', '60', '65', '75.00', '8', NULL),
(406, '160', 'Regional Proposal Success', NULL, '%', 'M', 'Y', '30', '35', '0.00', '8', NULL),
(407, '81', 'Uitlisation \r\n', NULL, '%', 'M', 'M', '65', '70', '68.00', '10', NULL),
(408, '161', '# of NCs -Proposals procedures \r\n', NULL, '#', 'M', 'M', '0', '0', '0.00', '3', NULL),
(409, '161', '# of NCs - Timesheets \r\n', NULL, '#', 'M', 'M', '0', '0', '26.00', '3', NULL),
(410, '161', '# of NCs - Pre-Engagement Analysis \r\n', NULL, '#', 'M', 'M', '0', '0', '0.00', '3', NULL),
(411, '162', '# of new  profitable ideas\r\n', NULL, '#', 'M', 'M', '1', '2', '0.00', '9', NULL),
(414, '165', 'Number of Clients Complaints', NULL, '#', 'M', 'Y', '0', '0', '0.00', '8', NULL),
(415, '73', '# articles views average \r\n', NULL, '#', 'M', 'M', '250', '300', '102.00', '2', NULL),
(416, '73', '# of white papers \r\n', NULL, '#', 'M', 'M', '1', '2', '0.00', '2', NULL),
(417, '166', '% Write-downs\r\n', NULL, '%', 'M', 'Y', '20', '10', '-1753.00', '5', NULL),
(418, '166', 'Billable Time Utilisation \r\n', NULL, '%', 'M', 'Y', '50', '70', '53.00', '5', NULL),
(419, '166', '% of NCs - Timesheets \r\n', NULL, '%', 'M', 'Y', '15', '5', '22.00', '3', NULL),
(420, '166', '# of NCs -Proposals procedures \r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(421, '166', '# of NCs - Pre-Engagement Analysis \r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(422, '167', '# of new  products', NULL, '#', 'M', 'Y', '1', '2', '0.00', '9', NULL),
(423, '168', '# of articles', NULL, '#', 'M', 'Y', '16', '20', '15.00', '2', NULL),
(424, '168', '# of article views', NULL, '#', 'M', 'Y', '250', '300', '200.00', '2', NULL),
(425, '168', '# of white papers', NULL, '#', 'M', 'Y', '1', '2', '0.00', '2', NULL),
(426, '169', 'Total revenue in USD equivalent', NULL, '$', 'M', 'Y', '64000', '80000', '49444.29', '6', NULL),
(428, '170', '# of new  profitable ideas\r\n', NULL, '#', 'M', 'Y', '1', '2', '0.00', '9', NULL),
(429, '171', '# articles views average \r\n', NULL, '#', 'M', 'Y', '250', '300', '290.00', '2', NULL),
(430, '171', '# of articles \r\n', NULL, '#', 'M', 'Y', '2', '3', '4.00', '2', NULL),
(431, '171', '# of white papers \r\n', NULL, '#', 'M', 'Y', '1', '2', '0.00', '2', NULL),
(435, '172', 'Revenue', NULL, '$', 'M', 'Y', '1000000', '1200000', '900000.00', '25', NULL),
(436, '173', 'market share', NULL, '%', 'HY', 'Y', '20', '25', '0.00', '35', NULL),
(437, '174', 'Registration', 1, '#', 'Y', 'Y', '', '', '0.00', '15', NULL),
(438, '175', '% automation', NULL, '#', 'Y', 'Y', '4', '5', '0.00', '5', NULL),
(439, '176', 'Trainings per person', NULL, '#', 'HY', 'Q', '2', '3', '0.00', '20', NULL),
(440, '177', 'Current Year Bad Debts over Current year  Total Revenue to Date ', NULL, '%', 'M', 'Y', '2', '1', '0.00', '10', NULL),
(441, '178', '% Debtors over 30 Days\r\n Total Debtors >30 Days/Total Outstanding Debtors', NULL, '%', 'M', 'Y', '20', '15', '8.00', '10', NULL),
(443, '179', 'Cost/Income Ratio', NULL, '%', 'Y', 'Y', '70', '60', '0.00', '10', NULL),
(444, '180', 'Average Debtor Days', NULL, '#', 'M', 'Y', '30', '20', '12.00', '10', NULL),
(445, '181', '# Customer complaints', NULL, '#', 'M', 'M', '0', '0', '0.00', '10', NULL),
(446, '182', '% of compliant time sheets \r\n', NULL, '%', 'M', 'Y', '100', '100', '83.00', '5', NULL),
(447, '183', '# of delayed client responses observed\r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '5', NULL),
(448, '184', '# of Non Compliance Incidences\r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '5', NULL),
(449, '185', '# of Non Compliance Incidences\r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '5', NULL),
(450, '186', '# of performed audits', NULL, '#', 'Q', 'Y', '3', '4', '0.00', '5', NULL),
(451, '187', '% Personal Development plans completed\r\n', NULL, '%', 'M', 'Y', '100', '100', '100.00', '25', NULL),
(454, '189', 'debtor days', NULL, '#', 'M', 'Y', '30', '20', '12.5', '10', NULL),
(455, '190', 'bad debts over total book', NULL, '%', 'M', 'Y', '2', '1', '0', '10', NULL),
(456, '191', '%debtors over 30 days', NULL, '%', 'M', 'Y', '20', '15', '8.5', '10', NULL),
(457, '192', 'Costs/Income ratio', NULL, '%', 'M', 'Y', '70', '60', '71', '10', NULL),
(458, '193', '# of customer complaints', NULL, '#', 'M', 'M', '0', '0', '0.00', '10', NULL),
(459, '194', '% Compliance-Timesheets', NULL, '%', 'M', 'M', '100', '100', '97', '2.5', NULL),
(460, '195', '# of delayed client responses observed', NULL, '#', 'M', 'Y', '100', '0', '0', '2.5', NULL),
(461, '196', '# of non compliance incidences', NULL, '#', 'M', 'Y', '0', '0', '0', '5', NULL),
(462, '197', '# of non compliance incidences', NULL, '#', 'M', 'Y', '0', '0', '0', '5', NULL),
(463, '198', '# of non compliance incidences', NULL, '#', 'M', 'Y', '0', '0', '0', '5', NULL),
(464, '199', '# of audits undertaken', NULL, '#', 'M', 'Y', '3', '4', '0.00', '5', NULL),
(465, '200', '%personal development plans', NULL, '%', 'M', 'Y', '100', '100', '84', '25', NULL),
(466, '201', 'Debtors days', NULL, '#', 'M', 'Y', '30', '20', '11.00', '10', NULL),
(468, '202', 'Bad Debts over Total Book', NULL, '%', 'M', 'Y', '2', '1', '0.00', '10', NULL),
(470, '204', 'Average Debtor Days', NULL, '#', 'M', 'Y', '30', '20', '12.00', '10', NULL),
(471, '205', 'Bad Debts over Total Book', NULL, '%', 'M', 'Y', '2', '1', '0.00', '10', NULL),
(473, '207', NULL, 0, '%', 'M', 'Y', '20', '15', '11.00', '10', NULL),
(474, '208', '% Debtors over 30 Days', NULL, '%', 'M', 'Y', '20', '15', '8.00', '10', NULL),
(475, '209', '', NULL, '#', 'M', 'M', '0', '0', '0.00', '20', NULL),
(476, '210', 'Cost/Income ratio', NULL, '%', 'M', 'Y', '70', '60', '71.00', '10', NULL),
(477, '211', '# of customer complaints', NULL, '#', 'M', 'M', '0', '0', '0.00', '10', NULL),
(478, '212', '% of NCs - Timesheets', NULL, '%', 'M', 'M', '100', '100', '100.00', '2.5', NULL),
(479, '213', '# of delayed client responses observed', NULL, '#', 'M', 'Y', '0', '0', '0.00', '2.5', NULL),
(480, '214', '# of Non Compliance Incidences', NULL, '#', 'M', 'Y', '0', '0', '0.00', '5', NULL),
(481, '215', '# of Non Compliance Incidences', NULL, '#', 'M', 'Y', '0', '0', '0.00', '5', NULL),
(482, '216', '# of Non Compliance Incidences', NULL, '#', 'M', 'Y', '0', '0', '0.00', '5', NULL),
(483, '217', '# of Audits undertaken', NULL, '#', 'Q', 'Y', '3', '4', '0.00', '5', NULL),
(484, '218', '% Personal Development plans completed', NULL, '%', 'M', 'Y', '100', '100', '85.00', '25', NULL),
(485, '219', '%of Compliant Timesheet', NULL, '%', 'M', 'Y', '100', '100', '87.00', '15', NULL),
(486, '220', '# of delayed responses observed', NULL, '#', 'Y', 'Y', '0', '0', '0.00', '15', NULL),
(487, '221', '% of personal Development plans', NULL, '#', 'M', 'Y', '100.0', '100', '100.00', '20', NULL),
(488, '222', 'Occupancy', NULL, '%', 'M', 'Y', '99', '99', '91.00', '10', NULL),
(489, '223', 'Rent yield', NULL, '%', 'M', 'Y', '5', '8', '6.00', '5', NULL),
(491, '225', 'Debtor Days\r\n', NULL, '#', 'M', 'Y', '30', '20', '11', '4', NULL),
(492, '226', 'Bad debts over total revenue for the period\r\n', NULL, '%', 'M', 'Y', '2', '1', '0.00', '4', NULL),
(493, '227', '% debtors over 30 days\r\n', NULL, '%', 'M', 'Y', '20', '15', '7.96', '4', NULL),
(494, '228', '% budget variance adjusted for non budgeted expenditure\r\n', NULL, '%', 'Y', 'Y', '20', '10', '0.00', '3', NULL),
(495, '229', 'Cost/Income ratio\r\n', NULL, '%', 'M', 'Y', '70', '60', '61', '4', NULL),
(496, '230', 'Recruitment success rate\r\n', NULL, '%', 'M', 'Y', '60', '65', '5.00', '4', NULL),
(497, '230', 'Inquiries success rate\r\n', NULL, '%', 'M', 'Y', '60', '65', '75.00', '4', NULL),
(498, '230', 'Proposal success rate -local\r\n', NULL, '%', 'M', 'Y', '60', '65', '100.00', '4', NULL),
(499, '230', 'Proposal success rate regional\r\n', NULL, '%', 'M', 'Y', '30', '35', '', '5', NULL),
(500, '231', '# of social media followers\r\n', NULL, '#', 'M', 'M', '1760', '2420', '1049.00', '4', NULL),
(501, '232', '# of customer complaints\r\n', NULL, '#', 'M', 'Y', '0', '0', '0.00', '4', NULL),
(502, '233', 'Utilisation - billable\r\n', NULL, '%', 'M', 'Y', '65', '70', '33.00', '5', NULL),
(503, '233', 'Utilisation - business development', NULL, '%', 'M', 'Y', '10', '19', '6.23', '5', NULL),
(504, '233', '% Write downs\r\n', NULL, '%', 'M', 'Y', '-25', '-20', '7.00', '5', NULL),
(505, '234', '% Compliance', NULL, '%', 'M', 'Y', '100', '100', '69.00', '10', NULL),
(506, '235', '% Personal Development plans completed\r\n', NULL, '%', 'M', 'Y', '100', '100', '100.00', '25', NULL),
(507, '118', '# of white paper', NULL, '#', 'Q', 'Q', '1', '2', '0.5', '2', NULL),
(508, '236', 'market share', NULL, '%', 'Y', 'Y', '10', '15', '12.00', '25', NULL),
(509, '237', 'budget variance', NULL, '%', 'M', 'Y', '20', '15', '19.00', '10', NULL),
(510, '238', 'Profit margin', NULL, '%', 'Q', 'Y', '25', '29', '26.00', '25', NULL),
(511, '239', 'Operating Expenditure', NULL, '$', 'M', 'Y', '115000', '100000', '128000.00', '25', NULL),
(512, '240', 'Satisfied Customers with service levels ', NULL, '%', 'Q', 'Y', '80', '92', '70.00', '15', NULL),
(513, '241', 'Satisfied customers with new products', NULL, '%', 'Q', 'Y', '80', '90', '60.00', '15', NULL),
(514, '242', 'Market Share', NULL, '%', 'Q', 'Y', '30', '35', '30.00', '15', NULL),
(516, '244', 'Number of trainings', NULL, '#', 'Q', 'Y', '2', '3', '1.00', '5', NULL),
(517, '245', 'Revenue', NULL, '%', 'M', 'Y', '200000', '210000', '240000.00', '30', NULL),
(518, '246', 'Budget variance', NULL, '%', 'M', 'Y', '0', '5', '3.00', '12', NULL),
(519, '247', 'Customer Satisfaction index', NULL, '%', 'M', 'Y', '90', '100', '83.00', '25', NULL),
(520, '248', 'Automated processes', NULL, '#', 'Q', 'Y', '2', '3', '2.00', '8', NULL),
(521, '249', 'skills gap', NULL, '%', 'Y', 'Y', '40', '30', '25.00', '25', NULL),
(522, '250', 'Revenue collected', NULL, '$', 'M', 'Y', '10000', '12000', '11000.00', '30', NULL),
(523, '251', 'Number of trainings attended', NULL, '#', 'Q', 'Y', '2', '3', '3.00', '15', NULL),
(524, '252', 'Impressions', NULL, '%', 'M', 'Y', '15', '19', '20.00', '20', NULL),
(525, '253', 'Compliance', NULL, '%', 'M', 'Y', '100', '100', '98.00', '35', NULL),
(526, '254', 'Budget variance', NULL, '%', 'M', 'Y', '5', '0', '0.00', '3', NULL),
(527, '255', 'Customer Satisfaction endex', NULL, '%', 'M', 'Y', '90', '100', '0.00', '5', NULL),
(528, '256', 'Certifications', NULL, '#', 'Y', 'Y', '3', '4', '0.00', '28', NULL),
(529, '257', 'Solar stations', NULL, '#', 'Q', 'Y', '2', '3', '0.00', '32', NULL),
(530, '125', 'Business Utilisation', NULL, '%', 'M', 'Y', '10', '15', '0.00', '3', NULL),
(531, '258', 'Revenue', NULL, '%', 'M', 'Y', '20000', '22000', '18000.00', '20', NULL),
(532, '259', 'budget varience', NULL, '%', 'M', 'Y', '5', '0', '0.00', '15', NULL),
(533, '260', 'Customer satisfaction index', NULL, '%', 'M', 'Y', '80', '100', '0.00', '25', NULL),
(534, '261', 'percentage automation', NULL, '%', 'M', 'Y', '50', '60', '0.00', '20', NULL),
(535, '262', 'articles written', NULL, '#', 'M', 'Y', '2', '3', '0.00', '20', NULL),
(537, '263', 'Cost to Income Ratio', NULL, '%', 'M', 'Y', '70', '60', '40.00', '15', NULL),
(538, '123', 'Proposal success rate(local)', NULL, '%', 'M', 'Y', '60', '65', '0.00', '6', NULL),
(539, '14', 'Regional Proposal Success Rate', NULL, '%', 'M', 'Y', '30', '35', '0.00', '2', NULL),
(540, '75', 'Business Development Utilisation ', NULL, '#', 'M', 'M', '10', '15', '0.00', '3', NULL),
(541, '166', 'Business Development Time Utilisation', NULL, '%', 'M', 'Y', '7', '15', '0.00', '3', NULL),
(542, '264', 'Number of clients complaints', NULL, '#', 'M', 'Y', '0', '0', '0.00', '6', NULL),
(543, '79', '360 Degree Score ', NULL, '#', 'Q', 'Y', '3', '5', '0.00', '1', NULL),
(544, '168', '360 score', NULL, '#', 'Q', 'Y', '3', '5', '0.00', '1', NULL),
(545, '18', '360 Degrees Score', NULL, '#', 'Q', 'Y', '3', '5', '0.00', '1', NULL),
(546, '171', '360 Degrees Score', NULL, '#', 'M', 'Y', '3', '5', '0.00', '1', NULL),
(547, '265', '# of NCs - Pre-Engagement Analysis', NULL, '#', 'M', 'Y', '0', '0', '0.00', '3', NULL),
(548, '107', 'Recruitment Success Rate', NULL, '%', 'M', 'Y', '60', '65', '0.00', '6', NULL),
(549, '107', 'Quotation Success Rate', NULL, '%', 'M', 'Y', '60', '65', '10.00', '6', NULL),
(550, '265', '# of NCs - Timesheets', NULL, '%', 'M', 'Y', '100', '100', '96.00', '3', NULL),
(551, '109', 'Business Utilisation', NULL, '%', 'M', 'Y', '10', '15', '0.00', '', NULL),
(552, '265', '# of NCs -Proposals procedures', NULL, '#', 'M', 'Y', '0', '', '0.00', '3', NULL),
(553, '110', '360 Score', NULL, '#', 'Q', 'Y', '3', '5', '0.00', '', NULL),
(554, '102', 'Business utilisation', NULL, '%', 'M', 'Y', '10', '15', '0.00', '3', NULL),
(555, '104', '360 score', NULL, '#', 'Q', 'Y', '3', '5', '0.00', '1', NULL),
(556, '40', 'Regional Proposal Success Rate', NULL, '%', 'M', 'Y', '30', '35', '0.00', '2', NULL),
(557, '5', 'Local Success', NULL, '%', 'M', 'Y', '60', '65', '0.00', '2', NULL),
(558, '72', '360 Degrees Score', NULL, '#', 'Q', 'Y', '3', '5', '0.00', '1', NULL),
(559, '266', NULL, 0, '#', 'Q', 'Y', '3', '5', '0.00', '1', NULL),
(560, '10', '360% score', NULL, '#', 'Q', 'Y', '3', '5', '', '1', NULL),
(561, '111', 'Total revenue in usd ', NULL, '$', 'M', 'M', '6000', '6500', '6726.5', '15', NULL),
(562, '67', '360 Degree Score', NULL, '#', 'Q', 'Y', '3', '5', '', '1', NULL),
(563, '118', '360 Degree Score', NULL, '#', 'Q', 'Y', '3', '5', '', '', NULL),
(564, '58', 'Business development Utilisation ', NULL, '%', 'M', 'M', '10', '15', '', '3', NULL),
(565, '115', 'Business Development Utilisation', NULL, '%', 'M', 'M', '10', '15', '', '3', NULL),
(566, '88', 'Total revenue in USD Equivalent', NULL, '$', 'M', 'M', '6000', '6500', '944.25', '15', NULL),
(567, '96', 'Business Development Utilisation', NULL, '%', 'Q', 'Q', '', '', '', '3', NULL),
(568, '267', 'HR expenditure to total income', NULL, '%', 'M', 'Y', '40', '38', '38.33', '20', NULL),
(569, '268', 'debtors to total students', NULL, '%', 'Q', 'Y', '5', '0', '', '25', NULL),
(570, '269', 'funds secured', NULL, '$', 'M', 'Y', '8500', '10000', '', '5', NULL),
(571, '270', 'Number of complains', NULL, '#', 'M', 'Y', '10', '5', '', '15', NULL),
(573, '272', 'Passrate', NULL, '%', 'Q', 'Y', '90', '100', '', '10', NULL),
(574, '273', 'Number of schools built', NULL, '#', 'Y', 'Y', '1', '1', '', '3', NULL),
(575, '274', 'No of conservation parks built', NULL, '#', 'Y', 'Y', '1', '1', '', '2', NULL),
(576, '275', 'No of workshops facilitated', NULL, '#', 'Q', 'Y', '2', '3', '', '20', NULL),
(577, '276', 'student satisfaction rate', NULL, '%', 'Q', 'Y', '80', '90', '', '10', NULL),
(578, '277', 'Pass rate', NULL, '%', 'Q', 'Y', '90', '100', '', '30', NULL),
(579, '278', 'Number of workshops attended', NULL, '#', 'Q', 'Y', '2', '3', '2', '20', NULL),
(580, '279', 'parent satisfaction rate', NULL, '%', 'Q', 'Y', '80', '90', '', '10', NULL),
(582, '280', 'Classroom observation score', NULL, '%', 'Q', 'Y', '80', '90', '', '15', NULL),
(583, '281', 'debtors to total students in class', NULL, '%', 'Q', 'Y', '5', '0', '3', '15', NULL),
(584, '282', 'Revenue', NULL, '%', 'Q', 'Y', '200000', '220000', '230000', '25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bsc_test`
--

CREATE TABLE `bsc_test` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_test`
--

INSERT INTO `bsc_test` (`id`, `name`, `email`) VALUES
(1, 'jerry', 'jerry@ipcconsultants.com'),
(2, 'nyasha', 'nyasha@ipcconsultants.com'),
(3, 'kudzai', ''),
(4, 'tapiwa', '');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_weekly`
--

CREATE TABLE `bsc_weekly` (
  `id` int(11) NOT NULL,
  `target_id` text,
  `week` text,
  `amount` text,
  `evidence` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc_weekly`
--

INSERT INTO `bsc_weekly` (`id`, `target_id`, `week`, `amount`, `evidence`, `date`) VALUES
(1, '335', '2020-W01', '75', NULL, '2020-01-22 09:32:01'),
(2, '335', '2020-W02', '75', NULL, '2020-02-04 06:55:21'),
(3, '335', '2020-W03', '75', NULL, '2020-02-04 06:55:43'),
(4, '335', '2020-W04', '75', NULL, '2020-02-04 06:56:35'),
(5, '335', '2020-W05', '75', NULL, '2020-02-04 06:57:13'),
(6, '335', NULL, NULL, NULL, '2020-02-04 06:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_yearly`
--

CREATE TABLE `bsc_yearly` (
  `id` int(11) NOT NULL,
  `target_id` text,
  `year` text,
  `amount` text,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bsc_360_answer_scale`
--
ALTER TABLE `bsc_360_answer_scale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_360_questions`
--
ALTER TABLE `bsc_360_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_360_responses`
--
ALTER TABLE `bsc_360_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_360_steps`
--
ALTER TABLE `bsc_360_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_access_levels`
--
ALTER TABLE `bsc_access_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_accounts`
--
ALTER TABLE `bsc_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_accounts_notifications`
--
ALTER TABLE `bsc_accounts_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_account_types`
--
ALTER TABLE `bsc_account_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_action_plans`
--
ALTER TABLE `bsc_action_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_admin`
--
ALTER TABLE `bsc_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `bsc_audit`
--
ALTER TABLE `bsc_audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_business_units`
--
ALTER TABLE `bsc_business_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_chart`
--
ALTER TABLE `bsc_chart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_city`
--
ALTER TABLE `bsc_city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `bsc_client`
--
ALTER TABLE `bsc_client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `bsc_client_360_policy`
--
ALTER TABLE `bsc_client_360_policy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_client_contact_details`
--
ALTER TABLE `bsc_client_contact_details`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `bsc_client_credentials`
--
ALTER TABLE `bsc_client_credentials`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `bsc_client_notifications`
--
ALTER TABLE `bsc_client_notifications`
  ADD PRIMARY KEY (`notifications_id`);

--
-- Indexes for table `bsc_client_perspectives`
--
ALTER TABLE `bsc_client_perspectives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_client_work_address`
--
ALTER TABLE `bsc_client_work_address`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `bsc_client_work_details`
--
ALTER TABLE `bsc_client_work_details`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `bsc_comments`
--
ALTER TABLE `bsc_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_config`
--
ALTER TABLE `bsc_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_consultant_in_charge`
--
ALTER TABLE `bsc_consultant_in_charge`
  ADD PRIMARY KEY (`consultant_id`);

--
-- Indexes for table `bsc_consultant_notifications`
--
ALTER TABLE `bsc_consultant_notifications`
  ADD PRIMARY KEY (`notifications_id`);

--
-- Indexes for table `bsc_country`
--
ALTER TABLE `bsc_country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `bsc_departments`
--
ALTER TABLE `bsc_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_discussion`
--
ALTER TABLE `bsc_discussion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_discussion_topic`
--
ALTER TABLE `bsc_discussion_topic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_drafts`
--
ALTER TABLE `bsc_drafts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_emails`
--
ALTER TABLE `bsc_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_events`
--
ALTER TABLE `bsc_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_goals`
--
ALTER TABLE `bsc_goals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_half_yearly`
--
ALTER TABLE `bsc_half_yearly`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_levels`
--
ALTER TABLE `bsc_levels`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `bsc_max_scorecards`
--
ALTER TABLE `bsc_max_scorecards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_measures_directory`
--
ALTER TABLE `bsc_measures_directory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_measure_tasks`
--
ALTER TABLE `bsc_measure_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_monthly`
--
ALTER TABLE `bsc_monthly`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_notification_status`
--
ALTER TABLE `bsc_notification_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_payments`
--
ALTER TABLE `bsc_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_pep`
--
ALTER TABLE `bsc_pep`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_pep_check_list`
--
ALTER TABLE `bsc_pep_check_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_perspectives`
--
ALTER TABLE `bsc_perspectives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_projects`
--
ALTER TABLE `bsc_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_project_status`
--
ALTER TABLE `bsc_project_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_project_tasks`
--
ALTER TABLE `bsc_project_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_project_team`
--
ALTER TABLE `bsc_project_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_quarterly`
--
ALTER TABLE `bsc_quarterly`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_scorecards`
--
ALTER TABLE `bsc_scorecards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_scorecard_settings`
--
ALTER TABLE `bsc_scorecard_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_scorecard_settings2`
--
ALTER TABLE `bsc_scorecard_settings2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_scorecard_status`
--
ALTER TABLE `bsc_scorecard_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_simple_template`
--
ALTER TABLE `bsc_simple_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_strategy_map`
--
ALTER TABLE `bsc_strategy_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_strategy_priorities`
--
ALTER TABLE `bsc_strategy_priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_strategy_steps`
--
ALTER TABLE `bsc_strategy_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_summary_ratings`
--
ALTER TABLE `bsc_summary_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_supporting_documents`
--
ALTER TABLE `bsc_supporting_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_targets`
--
ALTER TABLE `bsc_targets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_test`
--
ALTER TABLE `bsc_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_weekly`
--
ALTER TABLE `bsc_weekly`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bsc_yearly`
--
ALTER TABLE `bsc_yearly`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bsc_360_answer_scale`
--
ALTER TABLE `bsc_360_answer_scale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bsc_360_questions`
--
ALTER TABLE `bsc_360_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bsc_360_responses`
--
ALTER TABLE `bsc_360_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_360_steps`
--
ALTER TABLE `bsc_360_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bsc_access_levels`
--
ALTER TABLE `bsc_access_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bsc_accounts`
--
ALTER TABLE `bsc_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `bsc_accounts_notifications`
--
ALTER TABLE `bsc_accounts_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_account_types`
--
ALTER TABLE `bsc_account_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bsc_action_plans`
--
ALTER TABLE `bsc_action_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_admin`
--
ALTER TABLE `bsc_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `bsc_audit`
--
ALTER TABLE `bsc_audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_business_units`
--
ALTER TABLE `bsc_business_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_chart`
--
ALTER TABLE `bsc_chart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bsc_city`
--
ALTER TABLE `bsc_city`
  MODIFY `city_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `bsc_client`
--
ALTER TABLE `bsc_client`
  MODIFY `client_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bsc_client_360_policy`
--
ALTER TABLE `bsc_client_360_policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bsc_client_credentials`
--
ALTER TABLE `bsc_client_credentials`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bsc_client_notifications`
--
ALTER TABLE `bsc_client_notifications`
  MODIFY `notifications_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_client_perspectives`
--
ALTER TABLE `bsc_client_perspectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `bsc_comments`
--
ALTER TABLE `bsc_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `bsc_config`
--
ALTER TABLE `bsc_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_consultant_notifications`
--
ALTER TABLE `bsc_consultant_notifications`
  MODIFY `notifications_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_country`
--
ALTER TABLE `bsc_country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `bsc_departments`
--
ALTER TABLE `bsc_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `bsc_discussion`
--
ALTER TABLE `bsc_discussion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_discussion_topic`
--
ALTER TABLE `bsc_discussion_topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_drafts`
--
ALTER TABLE `bsc_drafts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_emails`
--
ALTER TABLE `bsc_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bsc_events`
--
ALTER TABLE `bsc_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_goals`
--
ALTER TABLE `bsc_goals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT for table `bsc_half_yearly`
--
ALTER TABLE `bsc_half_yearly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bsc_max_scorecards`
--
ALTER TABLE `bsc_max_scorecards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bsc_measures_directory`
--
ALTER TABLE `bsc_measures_directory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_measure_tasks`
--
ALTER TABLE `bsc_measure_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bsc_monthly`
--
ALTER TABLE `bsc_monthly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1572;

--
-- AUTO_INCREMENT for table `bsc_notification_status`
--
ALTER TABLE `bsc_notification_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bsc_payments`
--
ALTER TABLE `bsc_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_pep`
--
ALTER TABLE `bsc_pep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_pep_check_list`
--
ALTER TABLE `bsc_pep_check_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_perspectives`
--
ALTER TABLE `bsc_perspectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bsc_projects`
--
ALTER TABLE `bsc_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `bsc_project_status`
--
ALTER TABLE `bsc_project_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bsc_project_tasks`
--
ALTER TABLE `bsc_project_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `bsc_project_team`
--
ALTER TABLE `bsc_project_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_quarterly`
--
ALTER TABLE `bsc_quarterly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `bsc_scorecards`
--
ALTER TABLE `bsc_scorecards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `bsc_scorecard_settings`
--
ALTER TABLE `bsc_scorecard_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bsc_scorecard_settings2`
--
ALTER TABLE `bsc_scorecard_settings2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bsc_scorecard_status`
--
ALTER TABLE `bsc_scorecard_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bsc_simple_template`
--
ALTER TABLE `bsc_simple_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_strategy_map`
--
ALTER TABLE `bsc_strategy_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bsc_strategy_priorities`
--
ALTER TABLE `bsc_strategy_priorities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_strategy_steps`
--
ALTER TABLE `bsc_strategy_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bsc_summary_ratings`
--
ALTER TABLE `bsc_summary_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bsc_supporting_documents`
--
ALTER TABLE `bsc_supporting_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bsc_targets`
--
ALTER TABLE `bsc_targets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=585;

--
-- AUTO_INCREMENT for table `bsc_test`
--
ALTER TABLE `bsc_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bsc_weekly`
--
ALTER TABLE `bsc_weekly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bsc_yearly`
--
ALTER TABLE `bsc_yearly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
