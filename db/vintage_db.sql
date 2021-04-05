-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2021 at 09:12 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vintage_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_posting`
--

CREATE TABLE `accounts_posting` (
  `id` int(11) NOT NULL,
  `accounts_posting_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `voucher_number` varchar(100) NOT NULL,
  `bank_id` int(11) DEFAULT 0,
  `income_head_id` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `narration` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_posting_details`
--

CREATE TABLE `accounts_posting_details` (
  `id` int(11) NOT NULL,
  `accounts_posting_details_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `voucher_number` varchar(100) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `income_head_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `payment_mode` int(11) NOT NULL,
  `accounts_posting_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assets_info`
--

CREATE TABLE `assets_info` (
  `id` int(11) NOT NULL,
  `assets_name` varchar(500) NOT NULL,
  `assets_code` varchar(500) DEFAULT NULL,
  `assets_quantity` int(11) NOT NULL,
  `assigned_assets_quantity` int(11) DEFAULT 0,
  `entry_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assign_assets`
--

CREATE TABLE `assign_assets` (
  `id` int(11) NOT NULL,
  `assets_info_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `assign_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_info`
--

CREATE TABLE `bank_info` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(500) NOT NULL,
  `branch_name` varchar(5000) NOT NULL,
  `branch_location` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_info`
--

INSERT INTO `bank_info` (`id`, `bank_name`, `branch_name`, `branch_location`) VALUES
(1, 'Dutch-Bangla Bank Limited', 'Shantinagar', 'Shantinagar'),
(3, 'BRAC BANK', 'Payable at any branch in Banagladesh', 'Dhaka'),
(4, 'Dhaka Bank', 'Dhaka Bank-Mohakhali', 'Mohakhali'),
(6, 'Jamuna Bank', 'Payable at any Branch of Jamuna Bank Limited', 'Dhaka'),
(8, 'Mercantile Bank', 'Mercantile Bank-Badda', 'Badda'),
(9, 'Sonali Bank Limited', 'Amin Bazar, Dhaka (200260132)', 'Amin Bazar'),
(10, 'Bank Asia Ltd.', 'TEJGAON LINK ROAD BRANCH (070264526)', 'Dhaka'),
(11, 'NCC Bank', 'Dilkusha Branch', 'Dhaka'),
(12, 'NRB Bank', 'NRB Bank-Dhaka', 'Dhaka'),
(13, 'Bangladesh Bank', 'Bangladesh Bank-Motijheel', 'Motijheel'),
(14, 'City Bank', 'City Bank-Any Branch', 'Dhaka'),
(15, 'Eastern Bank Limited', 'Eastern Bank Limited-Dhaka', 'Dhaka'),
(16, 'IFIC Bank Limited', 'NARSINGDI', 'NARSINGDI'),
(17, 'Janata Bank Limited', 'LOCAL OFFICE/DHAKA LOCAL OFFICE-135273881', 'Dhaka'),
(18, 'Mutual Trust Bank Ltd.', 'GULSHAN BRANCH (145261720)', 'GULSHAN'),
(21, 'Southeast Bank Limited', 'Principal Branch', 'Dhaka'),
(22, 'PUBALI BANK LIMITED', 'GULSHAN M.T. CORPORATE / 175261840', 'GULSHAN DHAKA'),
(23, 'Premier Bank', 'GARIB E NEWAZ AVENUE BRANCH (166)', 'Dhaka'),
(24, '(SIBL) Social Islami Bank Limited', 'Demra Branch', 'Demra Branch'),
(25, 'Agrani Bank Limited', 'Panthapath Branch, DHAKA NORTH ZONE 010263611', 'Dhaka'),
(27, 'Union Bank Ltd.', 'Mawna Branch', 'Mawna'),
(28, 'Standard Chartered Bank', 'Dhaka', 'Dhaka'),
(29, 'Islami Bank Bangladesh Limited', 'VIP ROAD, Dhaka (125276856)', 'Dhaka'),
(30, 'Mercantile Bank Limited', 'Gobindhagonj Branch (140320587)', 'Gobindhagonj'),
(31, 'AB BANK', 'Payable at any Branch in Bangladesh', 'Bagladesh'),
(32, 'United  Commercial Bank Limited', 'Payable at any Branch in Bangladesh', 'Payable at any Branch in Bangladesh'),
(33, 'EXIM Export Import Bank of Bangladesh Limited', 'Savar Bazar', 'Dhaka Savar'),
(34, 'Al-Arafah Islami Bank Limited', 'Mohammadpur Krishi Market (015263379)', 'Dhaka'),
(35, 'UNION BANK LTD.', 'MAWNA BRANCH (265331006)', 'Gazipur Mawna'),
(36, 'Prime Bank Limited', 'PANTHAPATH BRANCH (170263614)', 'Dhaka'),
(37, 'Uttara Bank Limited.', 'Gaibandha', 'Gaibandha'),
(38, 'Collection Discount', 'Shantinagar', 'Shantinagar Head Office'),
(39, 'Cash', 'Head Office (Shantinagar)', 'Shantinagar Head Office'),
(40, 'UCB Bank', 'Elephant Road Branch (24526338)', 'Dhaka'),
(42, 'NCC Bank', 'Baridhara Branch', 'Baridhara Dhaka'),
(43, 'Islami Bank Bangladesh Limited', 'Baridhara, Dhaka (125260525)', 'Baridhara Dhaka'),
(44, 'Dutch-Bangla Bank Limited', 'Payable at any Branch', 'Dhaka'),
(45, 'IFIC Bank Limited', 'Board Bazar (120330221)', 'Board Bazar'),
(46, 'Southeast Bank Limited', 'New Eskaton Branch', 'Eskaton Moghbazar'),
(47, 'Standard Bank Limited', 'Green Road Branch, Dhaka', 'Dhaka'),
(48, 'Prime Bank Limited', 'Gulshan Branch (170261724)', 'GULSHAN DHAKA'),
(49, 'PUBALI BANK LIMITED', 'MOGHBAZAR', 'MOGHBAZAR'),
(50, 'National Bank Ltd.', 'Mohakhali', 'Mohakhali'),
(51, 'IFIC Bank Limited', 'Shantinagar', 'Shantinagar'),
(52, 'Janata Bank Limited', 'GULSHAN CIRCLE-1 CORPORATE/DHAKA GULSHAN CIRCLE-1 135261756', 'GULSHAN'),
(53, 'Agrani Bank Limited', 'Shantinagar', 'Shantinagar'),
(54, 'Al-Arafah Islami Bank Limited', 'Gulshan (015261726)', 'GULSHAN DHAKA'),
(55, 'Agrani Bank Limited', 'Green Road Corp. Branch', 'Dhaka'),
(56, 'PUBALI BANK LIMITED', 'MALIBAGH Branch  175273946', 'Dhaka'),
(57, 'UCB Bank', 'Payable at any Branch in Bangladesh', 'Dhaka'),
(58, 'Agrani Bank Limited', 'Noagaon Branch', 'Noagaon'),
(59, 'EXIM Export Import Bank of Bangladesh Limited', 'karwan Bazar', 'Karwan Bazar Dhaka'),
(60, 'Dhaka Bank', 'Payable at any Branch in Bangladesh', 'Dhaka'),
(61, 'Agrani Bank Limited', 'Sir Iqbql Road Corporate Branch, Khulna', 'Khulan'),
(62, 'Cash', 'Banglabazar Showroom', 'Banglabazar'),
(63, 'Cash', 'Mohakhali Showroom', 'Mohakhali Showroom'),
(64, 'Uttara Bank Limited.', 'Shantinagar', 'Shantinagar'),
(65, 'Uttara Bank Limited.', 'Mirpur (250262680)', 'Mirpur'),
(66, 'Prime Bank Limited', 'BONOSREE (170260725)', 'Dhaka Bonosree'),
(67, 'Prime Bank Limited', 'JESSORE BRANCH (170410946)', 'JESSORE'),
(68, 'NRBC BABK', 'Payable at any in Bangladesh, PRINCIPAL BRANCH', 'Dhaka'),
(69, '(SIBL) Social Islami Bank Limited', 'RAMPURA BRANCH (195275740)', 'Rampura'),
(70, 'PUBALI BANK LIMITED', 'PEELKHAN (175275265', 'PEELKHANA'),
(71, 'Uttara Bank Limited.', 'Hatkhula', 'Hatkhula'),
(72, 'Bank Asia Ltd.', 'Motijheel Branch', 'Dhaka'),
(73, 'Prime Bank Limited', 'RACECOURSE BRANCH (170190390)', 'Dhaka'),
(74, 'Janata Bank Limited', 'AMIN BAZAR BR./DHAKA WEST 135260131', 'DHAKA AMIN BAZAR'),
(75, 'Al-Arafah Islami Bank Limited', 'Motijheel (015274247) Branch', 'Dhaka Motijheel'),
(76, 'UCB Bank', 'Kamrangichar (245273584)', 'Kamrangichar'),
(77, 'Janata Bank Limited', 'ISWARDI BR /PABNA PABNA', 'PABNA'),
(78, 'Mercantile Bank Limited', 'Payable at any branch in Bangladesh 140261725', 'Dhaka'),
(79, 'PUBALI BANK LIMITED', 'MYMENSINGH MAIN BRACNH (175611845)', 'Mymensingh'),
(80, 'Mutual Trust Bank Ltd.', 'Dilkusha Branch', 'Dhaka'),
(81, 'Midland Bank', 'Gulshan Branch (285261727)', 'Dhaka'),
(82, 'SBAC Bank Limited', 'KHULNA BRANCH (270471548)', 'Khulna'),
(83, '(SIBL) Social Islami Bank Limited', 'Mirpur Branch', 'Dhaka'),
(84, 'National Bank Ltd.', 'Mirpur (Dhaka) 150262985', 'Mirpur'),
(85, 'Janata Bank Limited', 'DARSANA/CHUADANGA CHUADANGA', 'CHUADANGA'),
(86, 'Bangladesh Bank', 'Bangladesh Bank Chittagong', 'Chittagong'),
(87, 'Rupali Bank Limited', 'Natore', 'Natore'),
(88, 'Sonali Bank Limited', 'DEWAGANJ SUGAR MILLS, JA MALPUR  200290523', 'MALPUR'),
(89, 'Sonali Bank Limited', 'Natore Sugar Mills Branch, Natore Zone', 'Natore'),
(90, 'Sonali Bank Limited', 'MOBARAKGANJ SUGAR MILLS, JHENAIDAH', 'JHENAIDAH'),
(91, 'Sonali Bank Limited', 'MADHUKHALI, FARIDPUR  200291093', 'FARIDPUR'),
(92, 'Islami Bank Bangladesh Limited', 'Mirpur, Dhaka (125262981)', 'Mirpur'),
(93, 'Agrani Bank Limited', 'NORTH BENGAL SUGAR MILLS, BR, GOPALPUR, NATORE ZONE  (010691038)', 'NATORE'),
(94, 'Janata Bank Limited', 'ISWARDI BR/ PABNA (135761214)', 'PABNA'),
(95, 'Sonali Bank Limited', 'THAKURGAON (SUGAR MILLS),', 'THAKURGAON'),
(96, 'Trust Bank', 'Chittagong', 'Chittagong'),
(97, 'Al-Arafah Islami Bank Limited', 'SHAHZADPUR (015881906)', 'SHAHZADPUR'),
(98, 'PUBALI BANK LIMITED', 'OLIPUR BAZAR (175360059)', 'OLIPUR BAZAR'),
(99, 'Sonali Bank Limited', 'Kushtia Sugar Mills', 'Kushtia'),
(100, 'Rupali Bank Limited', 'DHAPERHAT BRABCH, GAIBANDA', 'GAIBANDA'),
(101, 'Agrani Bank Limited', 'PRINCIPAL BRANCH 010275359', 'Dhaka'),
(102, 'Southeast Bank Limited', 'Malibag Branch', 'Dhaka'),
(103, 'Islami Bank Bangladesh Limited', 'Mohammadpur Krishi (125263377)', 'Mohammadpur'),
(104, 'NRB Bank', 'Motijheel', 'Motijheel'),
(105, 'Uttara Bank Limited.', 'Amin Bazar (250260137)', 'Amin Bazar'),
(106, 'UCBL Bank', 'Shantinagar', 'Shantinagar'),
(107, 'Bkash Account (Sales Department)', '01729339424', 'Sales Department'),
(108, 'Sonali Bank Limited', 'Any Branch In Bangladesh', 'Dhaka'),
(109, 'National Credit & Commerce Bank Ltd.', 'Dilkusha Branch', 'Motijheel'),
(110, 'Bkash Account (Sales Department)', '01307404012', 'Sales Department'),
(111, 'Eastern Bank Limited', 'Payable at any Branch in Bangladesh', 'Dhaka'),
(112, 'Bank Asia Ltd.', 'MCB Banani Branch (070274037)', 'Banani'),
(113, 'Islami Bank Bangladesh Limited', 'HEAD OFFICE COMPLEX, DHAKA(125272689)', 'DHAKA'),
(114, 'Jamuna Bank', 'Agrabad Chittagong', 'Agrabad Chittagong'),
(115, 'EXIM Export Import Bank of Bangladesh Limited', 'Agrabad Chittagong', 'Chittagong'),
(116, 'Sonali Bank Limited', 'MILL ROADSETABGANJ, DINAJPUR 2002281458', 'DINAJPUR'),
(117, 'Sonali Bank Limited', 'JOYPURHAT, JOYPURHAT', 'Joypurhat'),
(118, 'One Bank', 'Payable at any of our Branches within Bangladesh', 'Dhaka'),
(119, 'NCC Bank', 'Shyamoly Branch', 'Dhaka'),
(120, 'PUBALI BANK LIMITED', 'Kashimpur (175330913) Branch', 'Kashimpur');

-- --------------------------------------------------------

--
-- Table structure for table `block_ip`
--

CREATE TABLE `block_ip` (
  `id` bigint(20) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `login_log_details_id` bigint(20) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `country_code` varchar(100) DEFAULT NULL,
  `continent` varchar(100) DEFAULT NULL,
  `continent_code` varchar(100) DEFAULT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `current_date_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bonus_incentive_system`
--

CREATE TABLE `bonus_incentive_system` (
  `id` int(11) NOT NULL,
  `incentive_type` varchar(255) NOT NULL,
  `from_amount` double NOT NULL,
  `to_amount` double NOT NULL,
  `percent_of_incentive` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branchwise_product_store`
--

CREATE TABLE `branchwise_product_store` (
  `id` int(11) NOT NULL,
  `product_store_date` timestamp NULL DEFAULT current_timestamp(),
  `product_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `open_stock` int(11) NOT NULL DEFAULT 0 COMMENT '+',
  `receive_stock` int(11) NOT NULL DEFAULT 0 COMMENT '+',
  `transfer_stock` int(11) NOT NULL DEFAULT 0 COMMENT '-',
  `return_stock` double NOT NULL DEFAULT 0 COMMENT '-',
  `sale_from_stock` int(11) NOT NULL DEFAULT 0 COMMENT '-',
  `damage_stock` int(11) NOT NULL DEFAULT 0 COMMENT '-',
  `closing_stock` int(11) NOT NULL DEFAULT 0 COMMENT '='
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branchwise_product_store`
--

INSERT INTO `branchwise_product_store` (`id`, `product_store_date`, `product_id`, `branch_id`, `open_stock`, `receive_stock`, `transfer_stock`, `return_stock`, `sale_from_stock`, `damage_stock`, `closing_stock`) VALUES
(1, '2020-12-26 18:00:00', 9, 1, 0, 1, 0, 0, 0, 0, 1),
(2, '2020-12-26 18:00:00', 10, 1, 0, 1, 0, 0, 0, 0, 1),
(3, '2020-12-26 18:00:00', 214, 1, 0, 1, 0, 0, 0, 0, 1),
(4, '2020-12-26 18:00:00', 10, 11, 0, 1, 0, 0, 0, 0, 1),
(5, '2020-12-26 18:00:00', 214, 11, 0, 2, 0, 0, 0, 0, 2),
(6, '2020-12-26 18:00:00', 11, 11, 0, 2, 0, 0, 0, 0, 2),
(7, '2020-12-25 18:00:00', 9, 1, 0, 1, 0, 0, 0, 0, 1),
(8, '2020-12-24 18:00:00', 9, 1, 1, 1, 0, 0, 0, 0, 2),
(9, '2020-12-24 18:00:00', 10, 1, 0, 1, 0, 0, 0, 0, 1),
(10, '2020-12-23 18:00:00', 9, 1, 2, 1, 0, 0, 0, 0, 3),
(11, '2020-12-23 18:00:00', 10, 1, 1, 1, 0, 0, 0, 0, 2),
(12, '2020-12-22 18:00:00', 9, 11, 0, 1, 0, 0, 0, 0, 1),
(13, '2020-12-22 18:00:00', 10, 11, 0, 1, 0, 0, 0, 0, 1),
(14, '2020-12-22 18:00:00', 11, 11, 0, 1, 0, 0, 0, 0, 1),
(15, '2020-12-29 00:18:30', 9, 2, 0, 0, 1, 0, 0, 0, -1),
(16, '2020-12-28 20:51:07', 9, 1, 4, 0, 1, 0, 2, 0, 1),
(17, '2020-12-27 21:37:46', 193, 1, 0, 0, 1, 0, 0, 0, -1),
(18, '2020-12-28 21:54:01', 193, 1, 0, 0, 1, 0, 0, 0, -1),
(19, '2020-12-28 23:31:07', 10, 1, 3, 0, 2, 0, 0, 0, 1),
(20, '2021-03-25 00:33:46', 9, 1, 1, 0, 0, 0, 1, 0, 0),
(21, '2021-03-25 00:33:46', 10, 1, 2, 0, 0, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `branch_info`
--

CREATE TABLE `branch_info` (
  `id` int(11) NOT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `branch_name` varchar(500) NOT NULL,
  `branch_code` varchar(500) DEFAULT NULL,
  `business_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for table number; 1 for token number',
  `factory_status` tinyint(4) NOT NULL DEFAULT 0,
  `hot_kitchen_status` tinyint(4) NOT NULL DEFAULT 0,
  `assigned_branches` varchar(255) DEFAULT NULL,
  `branch_area` varchar(500) DEFAULT NULL,
  `vat_reg` varchar(2500) DEFAULT NULL,
  `mobile` varchar(500) DEFAULT NULL,
  `phone` varchar(500) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch_info`
--

INSERT INTO `branch_info` (`id`, `manager_id`, `branch_name`, `branch_code`, `business_type`, `factory_status`, `hot_kitchen_status`, `assigned_branches`, `branch_area`, `vat_reg`, `mobile`, `phone`, `logo`, `footer_text`, `address`) VALUES
(1, 6, 'Outlet - A', 'OL-00', 0, 0, 0, NULL, 'Mirpur', NULL, '01718508090', '01718508090', NULL, 'Thanks For Visit Us.\nExpectation Long Time Relationship.', 'Mirpur'),
(2, 6, 'Hot Kitchen - A', 'OL-01', 0, 0, 1, '4', 'Dhanmondi', '', '01718604080', '01718604080', '', 'Thanks For Visit Us.\r\nExpectation Long Time Relationship.', 'Dhanmondi'),
(3, 6, 'Outlet - B', 'OL-02', 0, 0, 0, NULL, 'Gulshan', '', '01920794613', '01920794613', '', 'Thanks For Visit Us.\r\nExpectation Long Time Relationship.', 'Gulshan'),
(4, 6, 'Outlet - C', 'OL-04', 0, 0, 0, NULL, 'Uttara', '', '01819197341', '01819197341', '', 'Thanks For Visit Us.\r\nExpectation Long Time Relationship.', 'Uttara'),
(7, NULL, 'Outlet - D', 'OL-05', 0, 0, 0, NULL, NULL, 'af321498kjhsfd', '01314157964', NULL, 'assets/uploads/branch_logo/max_response.png', 'Thanks For Visit Us.\r\nExpectation Long Time Relationship.', 'House - 60. Road - 10, Lane - 06, Block - A,\r\nSection - 02, Mirpur, Dhaka 1216'),
(9, NULL, 'Hot Kitchen - B', 'OL-06', 0, 0, 1, '1,3', NULL, 'vat-354684132135', '01897134697', NULL, 'assets/uploads/branch_logo/bg-101.jpg', 'Footer Text - F', 'Dhaka'),
(10, NULL, 'Outlet - E', 'OL-07', 0, 0, 0, NULL, NULL, 'vat-397646', '01117278494', NULL, 'assets/uploads/branch_logo/bg-10.jpg', 'Footer Text - G', 'Gulshan'),
(11, NULL, 'Factory - A', 'fac-001', 1, 1, 0, NULL, NULL, 'vat-013046', '01920243494', NULL, '', 'Dhaka', 'Dhaka'),
(12, NULL, 'Factory - B', 'fac-002', 0, 1, 0, NULL, NULL, 'vat-010204', '01717243479', NULL, '', 'Dhaka', 'Dhaka'),
(13, NULL, 'Factory - C', 'fac-003', 0, 1, 0, NULL, NULL, 'vat-019197', '01836017153', NULL, '', 'Dhaka', 'Dhaka'),
(14, NULL, 'Factory - D', 'fac-004', 0, 1, 0, NULL, NULL, 'vat-004679', '01618678990', NULL, '', 'Dhaka', 'Dhaka');

-- --------------------------------------------------------

--
-- Table structure for table `branch_stock`
--

CREATE TABLE `branch_stock` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch_stock`
--

INSERT INTO `branch_stock` (`id`, `branch_id`, `product_id`, `stock`) VALUES
(1, 1, 9, 0),
(2, 1, 10, 1),
(3, 1, 214, 1),
(4, 11, 10, 2),
(5, 11, 214, 2),
(6, 11, 11, 3),
(7, 11, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `challan_details`
--

CREATE TABLE `challan_details` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `delivery_certificate` varchar(500) NOT NULL,
  `date_of_issue` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `challan_product`
--

CREATE TABLE `challan_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `pack_size` varchar(500) DEFAULT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `total_price` double NOT NULL DEFAULT 0,
  `challan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cheque_print`
--

CREATE TABLE `cheque_print` (
  `id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `cheque_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pay_to` varchar(500) NOT NULL,
  `amount` double NOT NULL,
  `amount_in_words` varchar(500) NOT NULL,
  `details` text DEFAULT NULL,
  `current_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('g5ub6ag3tbkee2q15cbmkksl9tj0knc4', '::1', 1617398304, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631373339383330343b),
('mqt85j9g3p8mvado1ospuglt9ugd1cul', '::1', 1617476972, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631373437363639343b757365725f73657373696f6e7c613a32393a7b733a373a22757365725f6964223b733a323a223234223b733a343a226e616d65223b733a353a2241646d696e223b733a393a22757365725f6e616d65223b733a353a2261646d696e223b733a393a22757365725f74797065223b733a353a2261646d696e223b733a363a226f75746c6574223b613a313a7b693a303b733a333a22616c6c223b7d733a31303a22757365725f656d61696c223b733a31353a2261646d696e40676d61696c2e636f6d223b733a31313a22757365725f6d6f62696c65223b733a31313a223031393336303131313534223b733a31313a2269735f6c6f67676564496e223b623a313b733a31313a22656d706c6f7965655f6964223b733a313a2236223b733a393a2268725f616363657373223b733a313a2231223b733a31353a226163636f756e74735f616363657373223b733a313a2230223b733a31323a2273616c65735f616363657373223b733a313a2231223b733a31353a2273657474696e67735f616363657373223b733a313a2231223b733a31313a22757365725f616363657373223b733a313a2231223b733a32323a226163636f756e74735f7265706f72745f616363657373223b733a313a2230223b733a31363a2268725f7265706f72745f616363657373223b733a313a2231223b733a31393a2273616c65735f7265706f72745f616363657373223b733a313a2231223b733a32313a2270726f647563745f7265706f72745f616363657373223b733a313a2231223b733a32373a226d6f6e65795f726563656970745f7265706f72745f616363657373223b733a313a2230223b733a31323a227072696e745f616363657373223b733a313a2230223b733a31343a2270726f647563745f616363657373223b733a313a2231223b733a31333a22636c69656e745f616363657373223b733a313a2231223b733a31313a226c6f636b5f616363657373223b733a313a2231223b733a31343a22656469745f6d725f616363657373223b733a313a2230223b733a31393a22656469745f696e766f6963655f616363657373223b733a313a2231223b733a31383a226f726465725f73686565745f616363657373223b733a313a2230223b733a31393a226b69746368656e5f726f6f6d5f616363657373223b733a313a2231223b733a32333a22696e766f6963655f646973636f756e745f616363657373223b733a313a2231223b733a31343a22656d706c6f7965655f696d616765223b733a37363a22687474703a2f2f6c6f63616c686f73743a383038302f76696e746167652f6173736574732f75706c6f6164732f656d706c6f7965655f696d616765732f41646d696e5f696d6167652e706e67223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `client_accounts_transaction_details`
--

CREATE TABLE `client_accounts_transaction_details` (
  `id` bigint(20) NOT NULL,
  `client_id` int(11) NOT NULL,
  `voucher_number` varchar(100) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `mr_number` varchar(100) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `opening_balance` double NOT NULL DEFAULT 0,
  `debit_amount` double NOT NULL DEFAULT 0,
  `credit_amount` double NOT NULL DEFAULT 0,
  `closing_balance` double NOT NULL DEFAULT 0,
  `narration` varchar(500) DEFAULT NULL,
  `head_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_info`
--

CREATE TABLE `client_info` (
  `id` int(11) NOT NULL,
  `client_code` varchar(100) NOT NULL,
  `client_type` varchar(20) NOT NULL,
  `client_name` varchar(500) NOT NULL,
  `address` varchar(5000) DEFAULT NULL,
  `client_area` varchar(500) DEFAULT NULL,
  `cell_number` varchar(50) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `dealer_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `remarks` varchar(5000) DEFAULT NULL,
  `credit_balance` double NOT NULL DEFAULT 0,
  `total_sale` double NOT NULL DEFAULT 0,
  `advance_balance` double NOT NULL DEFAULT 0,
  `return_amount` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_info`
--

INSERT INTO `client_info` (`id`, `client_code`, `client_type`, `client_name`, `address`, `client_area`, `cell_number`, `phone_number`, `email`, `dealer_id`, `employee_id`, `remarks`, `credit_balance`, `total_sale`, `advance_balance`, `return_amount`) VALUES
(1, '1000', 'Factory', 'Client A', 'Dhaka', 'Dhaka', '01317243494', '01317243494', 'clienta@gmail.com', 0, 0, 'Remarks', 200, 1650, 0, 0),
(4, '1001', 'Factory', 'Client B', 'Dhaka', 'Dhaka', '01717243494', '01717243494', 'clientb@gmail.com', 0, 0, 'Remarks B', 300, 800, 0, 0),
(5, '1003', 'Factory', 'Client C', 'Dhaka', 'Dhaka', '01719253595', '01719253595', 'clientc@gmail.com', NULL, NULL, 'Remarks C', 0, 0, 0, 0),
(6, '1004', 'Factory', 'Client D', 'Dhaka', 'Dhaka', '015178129032', '015178129032', 'clientd@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(7, '1005', 'Outlet', 'Client E', 'Dhaka', 'Dhaka', '01813496791', '01813496791', 'cliente@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(8, 'f1245', 'Outlet', 'Client F', 'afdsa', 'asdfsadf', '01349764198', '01349764198', 'clientf@gmail.com', NULL, NULL, 'asfdasdf', 0, 0, 0, 0),
(9, '1000545', 'Outlet', 'Client G', 'gsdgf', 'sgfsdg', '013497892198', '013497892198', 'clientg@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(10, '12465', 'Outlet', 'Client H', 'Dhaka', 'Dhaka', '01349094198', '01349094198', 'clienth@gmail.com', NULL, NULL, 'Client H', 0, 0, 0, 0),
(11, 'C459712', 'Outlet', 'Client I', 'Dhaka', 'Dhaka', '01946781245', '01946781245', 'clienti@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(12, 'f1649736', 'Factory', 'Client J', 'Dhaka', 'Dhaka', '01346798294', '01346798294', 'clientj@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(13, 'f16976', 'Factory', 'Client K', 'Dhaka', 'Dhaka', '01554674512', '01554674512', 'clientk@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(14, 'c46791358', 'Outlet', 'Client L', 'Dhaka', 'Dhaka', '01679413495', '01679413495', 'client-l@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(15, 'f013971', 'Factory', 'Client M', 'Dhaka', 'Dhaka', '01464674512', '01464674512', 'clientm@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(16, 'f87946', 'Factory', 'Client N', 'Dhaka', 'Dhaka', '01846764748', '01846764748', 'clientn@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(17, 'f03179', 'Factory', 'Client O', 'Dhaka', 'Dhaka', '01xxxxxxxxx', '01xxxxxxxxx', 'cliento@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(18, 'c46730', 'Outlet', 'Client P', 'Dhaka', 'Dhaka', '01xxxxxxxxx', '01xxxxxxxxx', 'clientp@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(19, 'c87465', 'Outlet', 'Client Q', 'Dhaka', 'Dhaka', '01xxxxxxxxx', '01xxxxxxxxx', 'clientq@gmail.com', NULL, NULL, '', 0, 0, 0, 0),
(20, 'c9521', 'Outlet', 'Client R', 'Dhaka', 'Dhaka', '01xxxxxxxxx', '01xxxxxxxxx', 'clientr@gmail.com', NULL, NULL, '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `client_product_damage_or_defect_details`
--

CREATE TABLE `client_product_damage_or_defect_details` (
  `id` bigint(20) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `client_product_damage_or_defect_info_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_product_damage_or_defect_info`
--

CREATE TABLE `client_product_damage_or_defect_info` (
  `id` bigint(20) NOT NULL,
  `return_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `challan_number` varchar(100) DEFAULT NULL,
  `total_amount` double NOT NULL DEFAULT 0,
  `return_amount` double NOT NULL DEFAULT 0,
  `total_amount_after_return` double NOT NULL DEFAULT 0,
  `remarks` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_product_return_details`
--

CREATE TABLE `client_product_return_details` (
  `id` bigint(20) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `client_product_return_info_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_product_return_details`
--

INSERT INTO `client_product_return_details` (`id`, `product_id`, `quantity`, `unit_price`, `client_product_return_info_id`) VALUES
(1, 4, 4, 20, 1),
(2, 3, 4, 20, 2),
(3, 2, 2, 160, 3),
(4, 5, 1, 3250, 4),
(5, 6, 1, 4800, 4),
(6, 9, 1, 120, 5),
(7, 9, 1, 120, 8),
(8, 10, 1, 150, 8),
(9, 9, 1, 120, 9),
(10, 10, 1, 150, 9),
(11, 9, 1, 120, 10),
(12, 10, 1, 150, 10),
(13, 11, 1, 150, 10);

-- --------------------------------------------------------

--
-- Table structure for table `client_product_return_info`
--

CREATE TABLE `client_product_return_info` (
  `id` bigint(20) NOT NULL,
  `return_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `challan_number` varchar(100) DEFAULT NULL,
  `total_amount` double NOT NULL DEFAULT 0,
  `return_amount` double NOT NULL DEFAULT 0,
  `total_amount_after_return` double NOT NULL DEFAULT 0,
  `remarks` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_product_return_info`
--

INSERT INTO `client_product_return_info` (`id`, `return_date`, `branch_id`, `client_id`, `invoice_number`, `challan_number`, `total_amount`, `return_amount`, `total_amount_after_return`, `remarks`, `user_id`) VALUES
(1, '2020-11-10 15:18:03', 1, 1, 'inv-00000000013', NULL, 4, 80, -76, 'jhhhklhlk', 24),
(2, '2020-11-10 15:20:31', 1, 1, 'inv-00000000013', NULL, -76, 80, -156, 'fasfasdfsds', 24),
(3, '2020-11-10 15:23:18', 1, 1, 'inv-00000000013', NULL, -156, 320, -476, 'fasfasfda', 24),
(4, '2020-11-17 13:00:07', 1, 0, 'inv-00000000050', NULL, 2, 9257.5, -9255.5, 'yggyvy', 24),
(5, '2020-12-26 10:09:38', 1, 0, 'inv-00000000003', NULL, 120, 120, 0, 'Test - 005', 24),
(6, '2020-12-25 10:16:13', 1, 0, 'inv-00000000004', NULL, 270, 270, 0, 'sdfghjk', 24),
(7, '2020-12-25 10:22:20', 1, 0, 'inv-00000000004', NULL, 270, 270, 0, 'Test - 005', 24),
(8, '2020-12-25 10:35:25', 1, 0, 'inv-00000000004', NULL, 270, 270, 0, 'Test - 006', 24),
(9, '2020-12-24 10:37:01', 1, 0, 'inv-00000000005', NULL, 270, 270, 0, 'Test - 008', 24),
(10, '2020-12-23 11:31:14', 11, 8, 'inv-00000000006', NULL, 420, 420, 0, 'Test - 009', 24);

-- --------------------------------------------------------

--
-- Table structure for table `client_sales_commission`
--

CREATE TABLE `client_sales_commission` (
  `id` bigint(20) NOT NULL,
  `commission_record_number` text NOT NULL,
  `claim_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `invoice_details_id` bigint(20) NOT NULL DEFAULT 0,
  `commission_amount` double NOT NULL,
  `commission_bank_name` text NOT NULL,
  `commission_bank_account` text NOT NULL,
  `commission_bkash_number` text NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT 0,
  `current_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_sales_details`
--

CREATE TABLE `client_sales_details` (
  `id` bigint(20) NOT NULL,
  `client_id` int(11) NOT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_advance_balance` double NOT NULL DEFAULT 0,
  `total_credit_balance` double NOT NULL DEFAULT 0,
  `total_payment_from_advanced` double NOT NULL DEFAULT 0,
  `total_payment` double NOT NULL DEFAULT 0,
  `total_sale` double NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_sales_details`
--

INSERT INTO `client_sales_details` (`id`, `client_id`, `sale_date`, `total_advance_balance`, `total_credit_balance`, `total_payment_from_advanced`, `total_payment`, `total_sale`) VALUES
(1, 1, '2020-12-21 18:00:00', 100, 0, 50, 850, 800),
(3, 4, '2020-12-22 18:00:00', 0, 300, 0, 500, 800),
(4, 1, '2020-12-22 18:00:00', 0, 150, 150, 300, 600),
(7, 1, '2020-12-23 18:00:00', 0, 200, 0, -50, 0),
(8, 1, '2020-12-29 08:51:47', 0, 200, 200, 250, 250);

-- --------------------------------------------------------

--
-- Table structure for table `client_transaction_details`
--

CREATE TABLE `client_transaction_details` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_payment_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `opening_balance` double NOT NULL DEFAULT 0 COMMENT '(+)',
  `debit_amount` double NOT NULL DEFAULT 0 COMMENT '(-) as paid_amount',
  `credit_amount` double NOT NULL DEFAULT 0 COMMENT '(+) as sale_amount',
  `closing_balance` double NOT NULL DEFAULT 0,
  `narration` varchar(500) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 for edit, 2 for return',
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_transaction_details`
--

INSERT INTO `client_transaction_details` (`id`, `client_id`, `invoice_payment_id`, `invoice_id`, `transaction_date`, `opening_balance`, `debit_amount`, `credit_amount`, `closing_balance`, `narration`, `payment_type`, `status`, `user_id`) VALUES
(1, 1, 1, 52, '2020-12-22 12:19:47', -50, 150, 150, -50, 'MR No(1000)', 'Cash', 0, 24),
(2, 1, NULL, 53, '2020-12-22 12:20:41', -50, 0, 250, 200, '', 'Due', 0, 24),
(3, 1, 2, 54, '2020-12-22 12:22:29', 200, 100, 200, 300, 'MR No(1001)', 'Due', 0, 24),
(4, 1, 3, 55, '2020-12-22 12:23:06', 300, 200, 200, 300, 'MR No(1002)', 'Split', 0, 24),
(7, 1, 6, NULL, '2020-12-22 12:44:13', 300, 100, 0, 200, 'MR No(1003)', 'Cash', 0, 24),
(8, 1, 7, NULL, '2020-12-22 12:45:14', 200, 150, 0, 50, 'MR No(1004)', 'Cash', 0, 24),
(9, 1, 8, NULL, '2020-12-22 12:46:18', 50, 200, 0, -150, 'MR No(1005)', 'Cash', 0, 24),
(10, 4, 9, 56, '2020-12-23 06:27:01', 0, 50, 500, 450, 'MR No(1006)', 'Due', 0, 24),
(11, 4, 10, 57, '2020-12-23 06:29:17', 450, 300, 300, 450, 'MR No(1007)', 'Card', 0, 24),
(12, 4, 11, NULL, '2020-12-23 06:33:33', 450, 150, 0, 300, 'MR No(1008)', 'Card', 0, 24),
(13, 1, 12, 58, '2020-12-23 08:50:17', -150, 200, 600, 250, 'MR No(1009)', 'Due', 0, 24),
(14, 1, 13, NULL, '2020-12-23 08:54:51', 250, 100, 0, 150, 'MR No(1010)', 'Cash', 0, 24),
(17, 1, 0, NULL, '2020-12-24 13:48:21', 150, 0, 50, 200, 'MR No(1000)(Ret.)', 'Cash', 1, 24),
(18, 1, 14, 62, '2020-12-29 08:51:47', 200, 250, 250, 200, 'MR No(1011)', 'Cash', 0, 24);

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `id` int(11) NOT NULL,
  `menu_permission` text DEFAULT NULL,
  `company_name_1` varchar(500) NOT NULL,
  `company_name_2` varchar(500) NOT NULL,
  `company_address_1` varchar(500) NOT NULL,
  `company_address_2` varchar(500) NOT NULL,
  `button_backgound` varchar(50) DEFAULT NULL,
  `category_name` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 for show; 0 for hide',
  `phone` varchar(500) NOT NULL,
  `mobile` varchar(500) NOT NULL,
  `fax` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `website` varchar(500) NOT NULL,
  `casual_leave` int(11) NOT NULL DEFAULT 0,
  `medical_leave` int(11) NOT NULL DEFAULT 0,
  `earn_leave` int(11) NOT NULL DEFAULT 0,
  `company_logo` varchar(100) DEFAULT NULL,
  `super_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`id`, `menu_permission`, `company_name_1`, `company_name_2`, `company_address_1`, `company_address_2`, `button_backgound`, `category_name`, `phone`, `mobile`, `fax`, `email`, `website`, `casual_leave`, `medical_leave`, `earn_leave`, `company_logo`, `super_password`) VALUES
(7, '{\"outlet_access\":\"1\",\"factory_access\":\"1\",\"kitchen_room_access\":\"1\",\"money_receipt_access\":\"1\",\"edit_money_receipt_access\":\"1\",\"transaction_access\":\"1\"}', 'Vintage Bake & Cafe', '', '25 Happy Rahman\r\nPlaza Bangla Motor', '', 'image', 1, 'xxxxxx', '01766694541', '45', 'vinatge@gmail.com', 'www.vinatge.com.bd', 5, 15, 10, 'assets/uploads/company_logo/20210322130753.jpg', '5681a4aa48e897e33dc589981005b4d9009aab33');

-- --------------------------------------------------------

--
-- Table structure for table `currency_settings`
--

CREATE TABLE `currency_settings` (
  `id` int(11) NOT NULL,
  `currency_symbol` varchar(20) NOT NULL,
  `currency_name` varchar(20) NOT NULL,
  `placement` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency_settings`
--

INSERT INTO `currency_settings` (`id`, `currency_symbol`, `currency_name`, `placement`) VALUES
(1, 'TK', 'TAKA', 'left');

-- --------------------------------------------------------

--
-- Table structure for table `damage_or_defect_product_details`
--

CREATE TABLE `damage_or_defect_product_details` (
  `id` bigint(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `packsize` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchase_price` double NOT NULL DEFAULT 0,
  `damage_or_defect_product_info_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `damage_or_defect_product_info`
--

CREATE TABLE `damage_or_defect_product_info` (
  `id` bigint(20) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `damage_or_defect_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daywise_head_posting`
--

CREATE TABLE `daywise_head_posting` (
  `id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL DEFAULT 0,
  `posting_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opening_balance` double NOT NULL DEFAULT 0,
  `debit_amount` double NOT NULL DEFAULT 0,
  `credit_amount` double NOT NULL DEFAULT 0,
  `closing_balance` double NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daywise_head_posting`
--

INSERT INTO `daywise_head_posting` (`id`, `head_id`, `posting_date`, `opening_balance`, `debit_amount`, `credit_amount`, `closing_balance`, `user_id`) VALUES
(1, 1, '2020-10-04 18:00:00', 0, 5000, 0, 5000, 24);

-- --------------------------------------------------------

--
-- Table structure for table `dealer_info`
--

CREATE TABLE `dealer_info` (
  `id` int(11) NOT NULL,
  `dealer_name` varchar(5000) NOT NULL,
  `dealer_code` varchar(100) DEFAULT NULL,
  `address` varchar(5000) DEFAULT NULL,
  `cell_number` varchar(50) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_cost`
--

CREATE TABLE `delivery_cost` (
  `id` bigint(20) NOT NULL,
  `invoice_details_id` bigint(20) NOT NULL DEFAULT 0,
  `total_amount` double NOT NULL DEFAULT 0,
  `delivery_cost_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` bigint(11) NOT NULL DEFAULT 0,
  `current_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_cost_details`
--

CREATE TABLE `delivery_cost_details` (
  `id` bigint(20) NOT NULL,
  `delivery_cost_type_id` bigint(20) NOT NULL DEFAULT 0,
  `amount` double NOT NULL DEFAULT 0,
  `delivery_cost_id` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_cost_type`
--

CREATE TABLE `delivery_cost_type` (
  `id` bigint(20) NOT NULL,
  `delivery_cost_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `edit_invoice`
--

CREATE TABLE `edit_invoice` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `challan_number` varchar(255) DEFAULT NULL,
  `edit_invoice_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_id` int(11) NOT NULL,
  `previous_quantity` int(11) NOT NULL,
  `reduce_quantity` int(11) NOT NULL,
  `current_quantity` int(11) NOT NULL,
  `unit_price` double NOT NULL,
  `previous_amount` double NOT NULL,
  `current_amount` double NOT NULL,
  `usre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `edit_invoice`
--

INSERT INTO `edit_invoice` (`id`, `invoice_id`, `invoice_number`, `challan_number`, `edit_invoice_date`, `product_id`, `previous_quantity`, `reduce_quantity`, `current_quantity`, `unit_price`, `previous_amount`, `current_amount`, `usre_id`) VALUES
(1, 13, '0', NULL, '2020-11-10 15:18:03', 4, 4, 4, 0, 20, 80, 80, 24),
(2, 13, '0', NULL, '2020-11-10 15:20:31', 3, 4, 4, 0, 20, 80, 80, 24),
(3, 13, '0', NULL, '2020-11-10 15:23:18', 2, 2, 2, 0, 160, 320, 310.4, 24),
(4, 50, '0', NULL, '2020-11-18 13:00:07', 5, 1, 1, 0, 3250, 3250, 0, 24),
(5, 50, '0', NULL, '2020-11-18 13:00:07', 6, 1, 1, 0, 4800, 4800, 0, 24),
(6, 123, '0', NULL, '2020-11-23 07:37:48', 1, 2, 2, 0, 60, 120, 0, 24),
(7, 123, '0', NULL, '2020-11-23 07:37:48', 2, 2, 2, 0, 160, 320, 0, 24),
(8, 123, '0', NULL, '2020-11-23 07:37:48', 3, 2, 2, 0, 20, 40, 0, 24),
(9, 123, '0', NULL, '2020-11-23 07:37:48', 4, 2, 2, 0, 20, 40, 0, 24),
(10, 122, '0', NULL, '2020-11-23 07:39:39', 8, 5, 5, 0, 80, 400, 0, 24),
(11, 121, '0', NULL, '2020-11-23 08:23:48', 7, 1, 1, 0, 1700, 1700, 0, 24),
(12, 133, '0', NULL, '2020-11-23 15:27:47', 5, 1, 1, 0, 3250, 3250, 0, 24),
(13, 133, '0', NULL, '2020-11-23 15:27:47', 6, 1, 1, 0, 4800, 4800, 0, 24),
(14, 132, '0', NULL, '2020-11-23 15:52:20', 2, 2, 2, 0, 160, 320, 0, 24),
(15, 132, '0', NULL, '2020-11-23 15:52:20', 3, 1, 1, 0, 20, 20, 0, 24),
(16, 132, '0', NULL, '2020-11-23 15:52:20', 4, 1, 1, 0, 20, 20, 0, 24),
(17, 138, '0', NULL, '2020-11-24 09:53:12', 2, 3, 3, 0, 160, 480, 0, 24),
(18, 138, '0', NULL, '2020-11-24 09:53:12', 4, 3, 3, 0, 20, 60, 0, 24),
(19, 1, '0', NULL, '2020-12-27 08:39:24', 9, 1, 1, 0, 120, 120, 0, 24),
(20, 1, '0', NULL, '2020-12-27 08:39:24', 10, 1, 1, 0, 150, 150, 0, 24),
(21, 1, '0', NULL, '2020-12-27 08:39:24', 214, 1, 1, 0, 80, 80, 0, 24),
(22, 2, '0', NULL, '2020-12-27 08:43:17', 10, 1, 1, 0, 150, 150, 0, 24),
(23, 2, '0', NULL, '2020-12-27 08:43:17', 214, 2, 2, 0, 80, 160, 0, 24),
(24, 2, '0', NULL, '2020-12-27 08:43:17', 11, 2, 2, 0, 150, 300, 0, 24),
(25, 3, '0', NULL, '2020-12-27 10:09:38', 9, 1, 1, 0, 120, 120, 0, 24),
(26, 4, '0', NULL, '2020-12-27 10:35:25', 9, 1, 1, 0, 120, 120, 0, 24),
(27, 4, '0', NULL, '2020-12-27 10:35:25', 10, 1, 1, 0, 150, 150, 0, 24),
(28, 5, '0', NULL, '2020-12-27 10:37:01', 9, 1, 1, 0, 120, 120, 0, 24),
(29, 5, '0', NULL, '2020-12-27 10:37:01', 10, 1, 1, 0, 150, 150, 0, 24),
(42, 6, 'inv-00000000006', NULL, '2020-12-27 11:31:14', 9, 1, 1, 0, 120, 120, 0, 24),
(43, 6, 'inv-00000000006', NULL, '2020-12-27 11:31:14', 10, 1, 1, 0, 150, 150, 0, 24),
(44, 6, 'inv-00000000006', NULL, '2020-12-27 11:31:14', 11, 1, 1, 0, 150, 150, 0, 24);

-- --------------------------------------------------------

--
-- Table structure for table `edit_mr`
--

CREATE TABLE `edit_mr` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `mr_number` varchar(100) NOT NULL,
  `client_id` int(11) NOT NULL,
  `previous_amount` double NOT NULL,
  `resize_amount` double NOT NULL,
  `edit_mr_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `edit_mr`
--

INSERT INTO `edit_mr` (`id`, `payment_id`, `mr_number`, `client_id`, `previous_amount`, `resize_amount`, `edit_mr_date`, `user_id`) VALUES
(1, 1, '1000', 1, 150, 100, '2020-12-24 13:48:21', 24);

-- --------------------------------------------------------

--
-- Table structure for table `email_address_details`
--

CREATE TABLE `email_address_details` (
  `id` int(11) NOT NULL,
  `email_to` text DEFAULT NULL,
  `email_cc` text DEFAULT NULL,
  `email_bcc` text DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_benefit`
--

CREATE TABLE `employee_benefit` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `year` varchar(20) NOT NULL,
  `head_id` int(11) NOT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `voucher_posting_details_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_evaluation`
--

CREATE TABLE `employee_evaluation` (
  `id` bigint(20) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `job_knowledge_rating` int(11) NOT NULL,
  `job_knowledge_comments` varchar(500) NOT NULL,
  `work_quality_rating` int(11) NOT NULL,
  `work_quality_comments` varchar(500) NOT NULL,
  `attendance_punctuality_rating` int(11) NOT NULL,
  `attendance_punctuality_comments` varchar(500) NOT NULL,
  `communication_listening_skills_rating` int(11) NOT NULL,
  `communication_listening_skills_comments` varchar(500) NOT NULL,
  `dependability_rating` int(11) NOT NULL,
  `dependability_comments` varchar(500) NOT NULL,
  `overall_rating` int(11) NOT NULL,
  `average_rating` double NOT NULL,
  `additional_comments` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `current_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_info`
--

CREATE TABLE `employee_info` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(500) NOT NULL,
  `employee_code` varchar(500) NOT NULL,
  `employee_email` varchar(50) NOT NULL,
  `designation` varchar(500) NOT NULL,
  `gender` varchar(500) DEFAULT NULL,
  `phone` varchar(500) DEFAULT NULL,
  `mobile` varchar(500) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `joining_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `closing_date` timestamp NULL DEFAULT NULL,
  `basic_salary` double DEFAULT NULL,
  `phone_allowance` double DEFAULT NULL,
  `tuition_allowance` double DEFAULT NULL,
  `attendance_allowance` double DEFAULT NULL,
  `bonus` double DEFAULT NULL,
  `others` double DEFAULT NULL,
  `pf_contribution` double DEFAULT NULL,
  `loan_installment` int(11) DEFAULT NULL,
  `is_loan` tinyint(1) DEFAULT 0,
  `current_loan_id` int(11) DEFAULT 0,
  `deactivate_employee` tinyint(1) NOT NULL DEFAULT 0,
  `casual_leave` int(11) NOT NULL DEFAULT 0,
  `medical_leave` int(11) NOT NULL DEFAULT 0,
  `earn_leave` int(11) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 1,
  `permanent_address` varchar(500) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `others_benefit` double NOT NULL DEFAULT 0,
  `less_others_benefit` double NOT NULL DEFAULT 0,
  `less_others_misc` double NOT NULL DEFAULT 0,
  `pf_contribution_company_part` double NOT NULL DEFAULT 0,
  `employee_image` varchar(100) DEFAULT NULL,
  `target_amount` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_info`
--

INSERT INTO `employee_info` (`id`, `employee_name`, `employee_code`, `employee_email`, `designation`, `gender`, `phone`, `mobile`, `address`, `joining_date`, `closing_date`, `basic_salary`, `phone_allowance`, `tuition_allowance`, `attendance_allowance`, `bonus`, `others`, `pf_contribution`, `loan_installment`, `is_loan`, `current_loan_id`, `deactivate_employee`, `casual_leave`, `medical_leave`, `earn_leave`, `sort_order`, `permanent_address`, `blood_group`, `others_benefit`, `less_others_benefit`, `less_others_misc`, `pf_contribution_company_part`, `employee_image`, `target_amount`) VALUES
(6, 'Admin', 'e-5', 'admin@gmail.com', 'Manager', 'male', '01717387617', '01936011154', 'dhaka-1200', '2017-01-01 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 15, 10, 1000, 'dhaka-1200', 'o+', 0, 0, 0, 0, 'assets/uploads/employee_images/Admin_image.png', 0),
(7, 'Dew Hunt', 'em-1153', 'dew.fog1553@gmail.com', 'Sales Person', 'male', '01317243494', '01317243494', 'House - 04, Lane - 04, Road - 12, Block - B, Section - 11, Mirpur Dhaka - 1216', '2019-12-31 18:00:00', '0000-00-00 00:00:00', 30000, 1000, 1000, 2000, 15000, 1000, 15000, 0, 0, 0, 0, 10, 10, 10, 2, 'House - 04, Lane - 04, Road - 12, Block - B, Section - 11, Mirpur Dhaka - 1216', 'o+', 5000, 2000, 1000, 30000, '', 0),
(8, 'Himel', 'e-06', 'himel@gmail.com', 'Manager', 'male', '01317243494', '01317243494', 'Dhaka', '2004-12-31 18:00:00', '0000-00-00 00:00:00', 30000, 1000, 1000, 500, 15000, 1000, 10000, 0, 0, 0, 0, 0, 0, 0, 1, 'Dhaka', 'a+', 1000, 1000, 1000, 15000, '', 0),
(9, 'Asif', 'e-101', 'asif@gmail.com', 'Manager', 'male', '01647548932', '01647548932', 'Mirpur', '2014-12-31 18:00:00', '0000-00-00 00:00:00', 30000, 1000, 1000, 500, 15000, 1000, 15000, 0, 0, 0, 0, 10, 10, 10, 5, 'Mirpur', 'b-', 5000, 1000, 1000, 15000, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee_leave_details`
--

CREATE TABLE `employee_leave_details` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `total_day` int(11) NOT NULL,
  `comments` varchar(500) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL,
  `employee_total_leave_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_target`
--

CREATE TABLE `employee_target` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL DEFAULT 0,
  `target_start_date` timestamp NULL DEFAULT NULL,
  `target_end_date` timestamp NULL DEFAULT NULL,
  `target_amount` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_total_leave`
--

CREATE TABLE `employee_total_leave` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `year` varchar(10) NOT NULL,
  `total_casual_leave` int(11) NOT NULL,
  `total_medical_leave` int(11) NOT NULL,
  `total_earn_leave` int(11) NOT NULL,
  `paid_casual_leave` int(11) NOT NULL,
  `paid_medical_leave` int(11) NOT NULL,
  `paid_earn_leave` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_total_leave`
--

INSERT INTO `employee_total_leave` (`id`, `employee_id`, `year`, `total_casual_leave`, `total_medical_leave`, `total_earn_leave`, `paid_casual_leave`, `paid_medical_leave`, `paid_earn_leave`) VALUES
(1, 7, '2020', 10, 10, 10, 0, 0, 0),
(2, 8, '2005', 10, 10, 10, 0, 0, 0),
(3, 9, '2015', 10, 10, 10, 0, 0, 0),
(4, 8, '2020', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `envelope_print`
--

CREATE TABLE `envelope_print` (
  `id` int(11) NOT NULL,
  `envelope_title` varchar(500) NOT NULL,
  `from_envelope_details` text NOT NULL,
  `to_envelope_details` text NOT NULL,
  `envelope_size` varchar(10) NOT NULL,
  `current_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `color` varchar(20) NOT NULL DEFAULT '#3a87ad',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `financial_statement_accounts`
--

CREATE TABLE `financial_statement_accounts` (
  `id` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `financial_statement_accounts_assign`
--

CREATE TABLE `financial_statement_accounts_assign` (
  `id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL,
  `financial_statement_accounts_type` varchar(20) NOT NULL,
  `financial_statement_accounts_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gate_pass_details`
--

CREATE TABLE `gate_pass_details` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `challan_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `source` varchar(5000) NOT NULL,
  `date_of_issue` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `head_details`
--

CREATE TABLE `head_details` (
  `id` int(11) NOT NULL,
  `head_name` varchar(100) NOT NULL,
  `head_type` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `head_details`
--

INSERT INTO `head_details` (`id`, `head_name`, `head_type`, `is_active`) VALUES
(1, 'a', 'cr', 1);

-- --------------------------------------------------------

--
-- Table structure for table `head_details_posting`
--

CREATE TABLE `head_details_posting` (
  `id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `debit_amount` double NOT NULL,
  `credit_amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `head_details_posting`
--

INSERT INTO `head_details_posting` (`id`, `head_id`, `total_amount`, `debit_amount`, `credit_amount`) VALUES
(1, 1, 5000, 0, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_audit_log`
--

CREATE TABLE `invoice_audit_log` (
  `id` int(11) NOT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `previous_description` longtext NOT NULL,
  `current_description` longtext NOT NULL,
  `audit_type` longtext NOT NULL,
  `audit_status` longtext NOT NULL,
  `remarks` longtext NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delivery_status` tinyint(4) NOT NULL DEFAULT 0,
  `vat_registration_id` varchar(100) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `token_number` varchar(100) DEFAULT NULL,
  `challan_number` varchar(500) DEFAULT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_of_issue` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_total` double NOT NULL DEFAULT 0,
  `delivery_charge` double NOT NULL DEFAULT 0,
  `others_charge` double NOT NULL DEFAULT 0,
  `deduction_type` varchar(100) DEFAULT NULL,
  `deduction_rate` double NOT NULL DEFAULT 0,
  `deduction` double NOT NULL DEFAULT 0,
  `gross_payable` double NOT NULL DEFAULT 0,
  `advance_adjusted` double NOT NULL DEFAULT 0,
  `amount_to_paid` double NOT NULL DEFAULT 0,
  `total_vat` double NOT NULL DEFAULT 0,
  `mode_of_payment` varchar(500) NOT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `order_note` text DEFAULT NULL,
  `delivery_address` varchar(500) DEFAULT NULL,
  `cash_payment` double NOT NULL DEFAULT 0,
  `paid_amount` double NOT NULL DEFAULT 0,
  `change_amount` double NOT NULL DEFAULT 0,
  `card_payment` double NOT NULL DEFAULT 0,
  `due_payment` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `client_id`, `branch_id`, `table_id`, `employee_id`, `dealer_id`, `user_id`, `delivery_status`, `vat_registration_id`, `invoice_number`, `token_number`, `challan_number`, `order_number`, `order_date`, `date_of_issue`, `product_total`, `delivery_charge`, `others_charge`, `deduction_type`, `deduction_rate`, `deduction`, `gross_payable`, `advance_adjusted`, `amount_to_paid`, `total_vat`, `mode_of_payment`, `remarks`, `order_note`, `delivery_address`, `cash_payment`, `paid_amount`, `change_amount`, `card_payment`, `due_payment`) VALUES
(1, 0, 1, NULL, 0, 0, 24, 0, '', 'inv-00000000001', 'TN-201210-00001', NULL, NULL, '2020-12-10 13:43:47', '2020-12-10 13:43:47', 0, 0, 0, 'fixed', 0, 0, 0, 0, 0, 0, 'Return', 'Test', '', NULL, 0, 0, 0, 0, 0),
(2, 0, 11, NULL, 0, 0, 24, 0, '', 'inv-00000000002', 'TN-201210-00001', NULL, NULL, '2020-12-10 13:52:29', '2020-12-10 13:52:29', 0, 0, 0, 'fixed', 0, 0, 0, 0, 0, 0, 'Return', 'Test 01', '', NULL, 0, 0, 0, 0, 500),
(3, 0, 1, NULL, 0, 0, 24, 0, '', 'inv-00000000003', 'TN-201214-00001', NULL, NULL, '2020-12-14 05:24:53', '2020-12-14 05:24:53', 0, 0, 0, 'fixed', 0, 0, 0, 0, 0, 0, 'Return', 'Test - 005', '', NULL, 0, 0, 0, 0, 0),
(4, 0, 1, NULL, 0, 0, 24, 0, '', 'inv-00000000004', 'TN-201214-00002', NULL, NULL, '2020-12-14 07:44:54', '2020-12-14 07:44:54', 0, 0, 0, 'fixed', 0, 0, 0, 0, 0, 0, 'Return', 'Test - 006', '', NULL, 0, 0, 0, 0, 0),
(5, 0, 1, NULL, 0, 0, 24, 0, '', 'inv-00000000005', 'TN-201214-00003', NULL, NULL, '2020-12-14 09:26:52', '2020-12-14 09:26:52', 0, 0, 0, 'fixed', 0, 0, 0, 0, 0, 0, 'Void', 'Test - 008', '', NULL, 0, 0, 0, 0, 0),
(6, 8, 11, NULL, 0, 0, 24, 0, '', 'inv-00000000006', 'TN-201220-00001', NULL, NULL, '2020-12-20 14:12:23', '2020-12-20 14:12:23', 0, 0, 0, 'fixed', 0, 0, 0, 0, 0, 0, 'Return', 'Test - 009', '', NULL, 0, 0, 0, 0, 0),
(52, 1, 11, NULL, 0, 0, 24, 0, '', 'inv-00000000007', 'TN-201222-00001', NULL, NULL, '2020-12-22 12:19:47', '2020-12-22 12:19:47', 1, 0, 0, 'fixed', 0, 0, 150, 0, 150, 0, 'Cash', NULL, '', NULL, 150, 150, 0, 0, 0),
(53, 1, 11, NULL, 0, 0, 24, 0, '', 'inv-00000000053', 'TN-201222-00002', NULL, NULL, '2020-12-22 12:20:41', '2020-12-22 12:20:41', 1, 0, 0, 'fixed', 0, 0, 250, 0, 250, 0, 'Due', NULL, '', NULL, 0, 0, 0, 0, 250),
(54, 1, 11, NULL, 0, 0, 24, 0, '', 'inv-00000000054', 'TN-201222-00003', NULL, NULL, '2020-12-22 12:22:28', '2020-12-22 12:22:28', 1, 0, 0, 'fixed', 0, 0, 200, 0, 200, 0, 'Due', NULL, '', NULL, 100, 0, 0, 0, 100),
(55, 1, 11, NULL, 0, 0, 24, 0, '', 'inv-00000000055', 'TN-201222-00004', NULL, NULL, '2020-12-22 12:23:06', '2020-12-22 12:23:06', 1, 0, 0, 'fixed', 0, 0, 200, 0, 200, 0, 'Split', NULL, '', NULL, 100, 0, 0, 100, 0),
(56, 4, 11, NULL, 0, 0, 24, 0, '', 'inv-00000000056', 'TN-201223-00001', NULL, NULL, '2020-12-23 06:27:01', '2020-12-23 06:27:01', 2, 0, 0, 'fixed', 0, 0, 500, 0, 500, 0, 'Due', NULL, '', NULL, 50, 0, 0, 0, 450),
(57, 4, 11, NULL, 0, 0, 24, 0, '', 'inv-00000000057', 'TN-201223-00002', NULL, NULL, '2020-12-23 06:29:17', '2020-12-23 06:29:17', 1, 0, 0, 'fixed', 0, 0, 300, 0, 300, 0, 'Card', NULL, '', NULL, 0, 0, 0, 300, 0),
(58, 1, 11, NULL, 0, 0, 24, 0, '', 'inv-00000000058', 'TN-201223-00003', NULL, NULL, '2020-12-23 08:50:16', '2020-12-23 08:50:16', 2, 0, 0, 'fixed', 0, 0, 600, 0, 600, 0, 'Due', NULL, '', NULL, 200, 0, 0, 0, 400),
(59, 0, 1, 0, 0, 0, 24, 0, '', 'inv-00000000059', 'TN-201228-00001', NULL, NULL, '2020-12-28 05:40:49', '2020-12-28 05:40:49', 2, 0, 0, 'fixed', 0, 0, 250, 0, 250, 0, 'Cash', NULL, '', NULL, 250, 250, 0, 0, 0),
(60, 0, 1, NULL, 0, 0, 25, 0, '', 'inv-00000000060', 'TN-201228-00002', NULL, NULL, '2020-12-28 08:03:30', '2020-12-28 08:03:30', 2, 0, 0, 'fixed', 0, 0, 500, 0, 500, 0, 'pending', NULL, '', NULL, 0, 0, 0, 0, 0),
(61, 0, 1, NULL, 0, 0, 24, 0, '', 'inv-00000000061', 'TN-201229-00001', NULL, NULL, '2020-12-29 08:30:28', '2020-12-29 08:30:28', 1, 0, 0, 'fixed', 0, 0, 200, 0, 200, 0, 'Cash', NULL, '', NULL, 200, 200, 0, 0, 0),
(62, 1, 11, NULL, 0, 0, 24, 0, '', 'inv-00000000062', 'TN-201229-00001', NULL, NULL, '2020-12-29 08:51:47', '2020-12-29 08:51:47', 2, 0, 0, 'fixed', 0, 0, 250, 0, 250, 0, 'Cash', NULL, '', NULL, 250, 270, 20, 0, 0),
(66, 0, 1, 5, 0, 0, 24, 0, '', 'inv-00000000063', 'TN-210324-00001', NULL, NULL, '2021-03-24 12:10:45', '2021-03-24 12:10:45', 2, 0, 0, 'fixed', 0, 0, 250, 0, 250, 0, 'pending', NULL, '', NULL, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `leave_application`
--

CREATE TABLE `leave_application` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `total_day` int(11) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `leave_details` text NOT NULL,
  `application_status` varchar(50) NOT NULL,
  `accept_reject_employee_id` int(11) NOT NULL,
  `current_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `loan_start_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_loan_amount` double NOT NULL,
  `number_of_installment` int(11) NOT NULL,
  `per_installment_amount` double NOT NULL,
  `total_installment_amount` double NOT NULL,
  `details` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `already_paid_loan_amount` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_details`
--

CREATE TABLE `loan_details` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `month` varchar(500) NOT NULL,
  `year` varchar(500) NOT NULL,
  `loan_payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `per_installment` double NOT NULL,
  `total_loan_amount` double NOT NULL,
  `previous_loan_payment` double NOT NULL,
  `total_loan_payment` double NOT NULL,
  `due_loan_amount` double NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lock_time`
--

CREATE TABLE `lock_time` (
  `id` int(11) NOT NULL,
  `day_name` varchar(20) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lock_user`
--

CREATE TABLE `lock_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_log_details`
--

CREATE TABLE `login_log_details` (
  `id` bigint(20) NOT NULL,
  `login_time` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `logout_time` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) DEFAULT 0,
  `user_name_or_email` varchar(100) NOT NULL,
  `ip_address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_log_details`
--

INSERT INTO `login_log_details` (`id`, `login_time`, `logout_time`, `user_id`, `user_name_or_email`, `ip_address`) VALUES
(1, '2020-10-05 06:51:49', '0000-00-00 00:00:00', 0, 'admin', '::1'),
(2, '2020-10-05 06:52:01', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(3, '0000-00-00 00:00:00', '2020-10-05 09:42:39', 24, 'admin', '::1'),
(4, '2020-10-05 09:42:49', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(5, '2020-10-06 05:21:15', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(6, '0000-00-00 00:00:00', '2020-10-06 14:45:23', 24, 'admin', '::1'),
(7, '2020-10-07 05:25:11', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(8, '2020-10-07 12:09:42', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(9, '2020-10-08 05:36:10', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(10, '0000-00-00 00:00:00', '2020-10-08 05:48:10', 24, 'admin', '::1'),
(11, '2020-10-08 05:48:17', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(12, '0000-00-00 00:00:00', '2020-10-08 05:48:53', 24, 'admin', '::1'),
(13, '2020-10-08 05:49:00', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(14, '0000-00-00 00:00:00', '2020-10-08 05:52:33', 24, 'admin', '::1'),
(15, '2020-10-08 05:52:44', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(16, '2020-10-11 05:47:00', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(17, '2020-10-12 05:36:05', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(18, '0000-00-00 00:00:00', '2020-10-12 14:19:12', 24, 'admin', '::1'),
(19, '2020-10-12 14:19:20', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(20, '0000-00-00 00:00:00', '2020-10-12 14:19:37', 24, 'admin', '::1'),
(21, '2020-10-12 14:19:46', '0000-00-00 00:00:00', 25, 'dew hunt', '::1'),
(22, '0000-00-00 00:00:00', '2020-10-12 14:19:57', 25, 'dew hunt', '::1'),
(23, '2020-10-12 14:20:03', '0000-00-00 00:00:00', 0, 'admin', '::1'),
(24, '2020-10-12 14:20:08', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(25, '2020-10-13 05:22:25', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(26, '0000-00-00 00:00:00', '2020-10-13 06:05:58', 24, 'admin', '::1'),
(27, '2020-10-13 06:06:06', '0000-00-00 00:00:00', 25, 'dew hunt', '::1'),
(28, '0000-00-00 00:00:00', '2020-10-13 06:13:48', 25, 'dew hunt', '::1'),
(29, '2020-10-13 06:14:06', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(30, '0000-00-00 00:00:00', '2020-10-13 06:15:06', 25, 'dew', '::1'),
(31, '2020-10-13 06:15:12', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(32, '0000-00-00 00:00:00', '2020-10-13 06:38:02', 25, 'dew', '::1'),
(33, '2020-10-13 06:38:09', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(34, '0000-00-00 00:00:00', '2020-10-13 06:38:19', 24, 'admin', '::1'),
(35, '2020-10-13 06:38:34', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(36, '0000-00-00 00:00:00', '2020-10-13 06:38:42', 25, 'dew', '::1'),
(37, '2020-10-13 06:38:53', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(38, '2020-10-13 06:39:00', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(39, '0000-00-00 00:00:00', '2020-10-13 06:59:18', 25, 'dew', '::1'),
(40, '2020-10-13 06:59:31', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(41, '0000-00-00 00:00:00', '2020-10-13 07:00:43', 25, 'dew', '::1'),
(42, '2020-10-13 07:00:53', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(43, '2020-10-13 07:00:59', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(44, '0000-00-00 00:00:00', '2020-10-13 07:01:09', 25, 'dew', '::1'),
(45, '2020-10-13 07:01:19', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(46, '0000-00-00 00:00:00', '2020-10-13 07:19:28', 25, 'dew', '::1'),
(47, '2020-10-13 07:19:35', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(48, '0000-00-00 00:00:00', '2020-10-13 07:19:47', 25, 'dew', '::1'),
(49, '2020-10-13 07:20:24', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(50, '0000-00-00 00:00:00', '2020-10-13 07:24:10', 25, 'dew', '::1'),
(51, '2020-10-13 07:24:23', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(52, '0000-00-00 00:00:00', '2020-10-13 07:46:36', 25, 'dew', '::1'),
(53, '2020-10-13 07:46:43', '0000-00-00 00:00:00', 0, 'admin', '::1'),
(54, '2020-10-13 07:46:49', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(55, '0000-00-00 00:00:00', '2020-10-13 09:10:44', 24, 'admin', '::1'),
(56, '2020-10-13 09:11:19', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(57, '0000-00-00 00:00:00', '2020-10-13 09:12:29', 25, 'dew', '::1'),
(58, '2020-10-13 09:12:46', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(59, '0000-00-00 00:00:00', '2020-10-13 09:20:01', 25, 'dew', '::1'),
(60, '2020-10-13 09:20:23', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(61, '0000-00-00 00:00:00', '2020-10-13 10:09:18', 25, 'dew', '::1'),
(62, '2020-10-13 10:09:40', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(63, '0000-00-00 00:00:00', '2020-10-13 10:10:33', 25, 'dew', '::1'),
(64, '2020-10-13 10:10:39', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(65, '0000-00-00 00:00:00', '2020-10-13 11:46:09', 25, 'dew', '::1'),
(66, '2020-10-13 11:46:16', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(67, '0000-00-00 00:00:00', '2020-10-13 12:24:01', 24, 'admin', '::1'),
(68, '2020-10-13 12:24:07', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(69, '0000-00-00 00:00:00', '2020-10-13 12:24:19', 25, 'dew', '::1'),
(70, '2020-10-13 12:24:25', '0000-00-00 00:00:00', 0, 'admin', '::1'),
(71, '2020-10-13 12:24:31', '0000-00-00 00:00:00', 0, 'admin', '::1'),
(72, '2020-10-13 12:24:37', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(73, '2020-10-14 06:02:00', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(74, '0000-00-00 00:00:00', '2020-10-14 10:27:44', 24, 'admin', '::1'),
(75, '2020-10-14 10:27:52', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(76, '2020-10-15 05:38:14', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(77, '2020-10-15 07:01:55', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(78, '2020-10-18 05:31:02', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(79, '2020-10-18 06:39:26', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(80, '2020-10-18 14:04:44', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(81, '2020-11-04 14:07:43', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(82, '2020-11-04 14:09:58', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(83, '2020-11-05 05:21:35', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(84, '2020-11-05 05:38:35', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(85, '2020-11-05 08:49:43', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(86, '2020-11-05 11:26:03', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(87, '2020-11-05 12:18:48', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(88, '2020-11-08 05:15:35', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(89, '2020-11-08 05:43:32', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(90, '0000-00-00 00:00:00', '2020-11-08 05:43:45', 24, 'admin', '::1'),
(91, '0000-00-00 00:00:00', '2020-11-08 07:50:51', 24, 'admin', '::1'),
(92, '2020-11-08 07:51:02', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(93, '2020-11-08 07:51:11', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(94, '2020-11-08 07:51:27', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(95, '0000-00-00 00:00:00', '2020-11-08 07:58:53', 25, 'dew', '::1'),
(96, '2020-11-08 07:58:59', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(97, '2020-11-08 08:00:02', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(98, '2020-11-08 08:07:28', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(99, '0000-00-00 00:00:00', '2020-11-08 08:07:39', 25, 'dew', '::1'),
(100, '2020-11-08 08:07:44', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(101, '0000-00-00 00:00:00', '2020-11-08 08:43:07', 24, 'admin', '::1'),
(102, '2020-11-08 08:43:13', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(103, '2020-11-08 08:45:07', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(104, '0000-00-00 00:00:00', '2020-11-08 08:59:39', 25, 'dew', '::1'),
(105, '2020-11-08 08:59:49', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(106, '2020-11-08 09:06:56', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(107, '2020-11-08 09:11:22', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(108, '2020-11-08 09:14:46', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(109, '2020-11-08 09:18:44', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(110, '2020-11-08 09:20:15', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(111, '2020-11-08 09:20:20', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(112, '0000-00-00 00:00:00', '2020-11-08 09:26:13', 25, 'dew', '::1'),
(113, '2020-11-08 09:26:17', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(114, '0000-00-00 00:00:00', '2020-11-08 09:26:27', 24, 'admin', '::1'),
(115, '2020-11-08 09:26:31', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(116, '0000-00-00 00:00:00', '2020-11-08 09:26:51', 25, 'dew', '::1'),
(117, '2020-11-08 09:26:55', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(118, '0000-00-00 00:00:00', '2020-11-08 09:27:39', 24, 'admin', '::1'),
(119, '2020-11-08 09:27:44', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(120, '2020-11-08 09:37:08', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(121, '2020-11-08 09:43:36', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(122, '0000-00-00 00:00:00', '2020-11-08 09:45:31', 25, 'dew', '::1'),
(123, '2020-11-08 09:45:44', '0000-00-00 00:00:00', 0, 'admin', '::1'),
(124, '2020-11-08 09:45:49', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(125, '2020-11-09 05:03:49', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(126, '2020-11-10 05:22:11', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(127, '2020-11-10 08:10:07', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(128, '0000-00-00 00:00:00', '2020-11-10 10:35:30', 24, 'admin', '::1'),
(129, '2020-11-10 10:35:36', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(130, '0000-00-00 00:00:00', '2020-11-10 10:35:45', 25, 'dew', '::1'),
(131, '2020-11-10 10:35:51', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(132, '2020-11-11 05:33:21', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(133, '2020-11-11 06:31:18', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(134, '0000-00-00 00:00:00', '2020-11-11 07:12:48', 25, 'dew', '::1'),
(135, '2020-11-11 07:12:57', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(136, '0000-00-00 00:00:00', '2020-11-11 07:48:54', 25, 'dew', '::1'),
(137, '2020-11-11 07:49:01', '0000-00-00 00:00:00', 0, 'himel', '::1'),
(138, '2020-11-11 07:49:09', '0000-00-00 00:00:00', 0, 'himel', '::1'),
(139, '2020-11-11 07:49:15', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(140, '2020-11-11 10:59:02', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(141, '2020-11-11 11:11:53', '0000-00-00 00:00:00', 0, 'admin', '::1'),
(142, '2020-11-11 11:13:16', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(143, '0000-00-00 00:00:00', '2020-11-11 11:41:55', 24, 'admin', '::1'),
(144, '2020-11-11 11:42:05', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(145, '0000-00-00 00:00:00', '2020-11-11 14:00:49', 26, 'himel', '::1'),
(146, '2020-11-11 14:00:54', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(147, '2020-11-11 15:31:59', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(148, '2020-11-12 06:02:45', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(149, '2020-11-12 06:58:15', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(150, '0000-00-00 00:00:00', '2020-11-12 06:58:18', 24, 'admin', '::1'),
(151, '2020-11-12 06:58:28', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(152, '0000-00-00 00:00:00', '2020-11-12 07:10:03', 26, 'himel', '::1'),
(153, '2020-11-12 07:10:10', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(154, '0000-00-00 00:00:00', '2020-11-12 07:29:17', 25, 'dew', '::1'),
(155, '2020-11-12 07:29:23', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(156, '0000-00-00 00:00:00', '2020-11-12 07:34:28', 26, 'himel', '::1'),
(157, '2020-11-12 07:34:33', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(158, '0000-00-00 00:00:00', '2020-11-12 07:34:53', 25, 'dew', '::1'),
(159, '2020-11-12 07:35:02', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(160, '0000-00-00 00:00:00', '2020-11-12 07:47:22', 26, 'himel', '::1'),
(161, '2020-11-12 07:47:28', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(162, '0000-00-00 00:00:00', '2020-11-12 07:47:33', 25, 'dew', '::1'),
(163, '2020-11-12 07:47:49', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(164, '0000-00-00 00:00:00', '2020-11-12 08:22:13', 26, 'himel', '::1'),
(165, '2020-11-12 08:22:22', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(166, '0000-00-00 00:00:00', '2020-11-12 08:23:21', 26, 'himel', '::1'),
(167, '2020-11-12 08:23:26', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(168, '0000-00-00 00:00:00', '2020-11-12 08:34:09', 25, 'dew', '::1'),
(169, '2020-11-12 08:34:18', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(170, '0000-00-00 00:00:00', '2020-11-12 08:34:41', 26, 'himel', '::1'),
(171, '2020-11-12 08:34:51', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(172, '0000-00-00 00:00:00', '2020-11-12 09:29:45', 25, 'dew', '::1'),
(173, '2020-11-12 09:29:52', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(174, '0000-00-00 00:00:00', '2020-11-12 12:38:37', 26, 'himel', '::1'),
(175, '2020-11-12 12:38:42', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(176, '2020-11-12 12:40:32', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(177, '2020-11-12 13:37:51', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(178, '2020-11-12 14:23:55', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(179, '0000-00-00 00:00:00', '2020-11-12 14:24:30', 24, 'admin', '::1'),
(180, '2020-11-12 14:24:38', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(181, '0000-00-00 00:00:00', '2020-11-12 14:24:51', 26, 'himel', '::1'),
(182, '2020-11-12 14:24:56', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(183, '0000-00-00 00:00:00', '2020-11-12 14:36:58', 24, 'admin', '::1'),
(184, '2020-11-12 14:37:04', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(185, '0000-00-00 00:00:00', '2020-11-12 14:37:09', 25, 'dew', '::1'),
(186, '2020-11-12 14:37:15', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(187, '0000-00-00 00:00:00', '2020-11-12 14:37:30', 26, 'himel', '::1'),
(188, '2020-11-12 14:37:35', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(189, '0000-00-00 00:00:00', '2020-11-12 14:46:52', 24, 'admin', '::1'),
(190, '2020-11-12 14:47:02', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(191, '2020-11-14 11:15:14', '0000-00-00 00:00:00', 0, 'admin', '::1'),
(192, '2020-11-14 11:15:20', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(193, '2020-11-14 12:02:56', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(194, '2020-11-17 07:50:17', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(195, '2020-11-17 08:12:10', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(196, '2020-11-17 08:23:16', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(197, '2020-11-18 05:24:27', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(198, '2020-11-18 10:02:05', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(199, '2020-11-18 10:32:24', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(200, '2020-11-19 05:15:00', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(201, '2020-11-19 06:49:17', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(202, '2020-11-19 10:20:43', '0000-00-00 00:00:00', 0, 'admn', '::1'),
(203, '2020-11-19 10:20:48', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(204, '2020-11-19 12:16:43', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(205, '0000-00-00 00:00:00', '2020-11-19 12:18:17', 24, 'admin', '::1'),
(206, '2020-11-19 12:18:24', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(207, '2020-11-22 05:26:28', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(208, '2020-11-22 09:25:58', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(209, '0000-00-00 00:00:00', '2020-11-22 09:27:30', 25, 'dew', '::1'),
(210, '2020-11-22 09:27:41', '0000-00-00 00:00:00', 26, 'himel', '::1'),
(211, '0000-00-00 00:00:00', '2020-11-22 09:29:27', 26, 'himel', '::1'),
(212, '2020-11-22 09:29:31', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(213, '2020-11-22 12:13:08', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(214, '2020-11-23 05:20:59', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(215, '2020-11-23 14:07:36', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(216, '0000-00-00 00:00:00', '2020-11-23 14:10:43', 24, 'admin', '::1'),
(217, '2020-11-23 14:10:48', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(218, '2020-11-23 14:10:54', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(219, '2020-11-24 05:28:03', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(220, '2020-11-24 08:03:02', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(221, '2020-11-25 05:21:15', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(222, '2020-11-26 04:56:02', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(223, '2020-11-29 05:18:40', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(224, '2020-11-30 05:37:05', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(225, '2020-11-30 06:33:13', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(226, '0000-00-00 00:00:00', '2020-11-30 06:33:30', 24, 'admin', '::1'),
(227, '2020-11-30 10:37:56', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(228, '0000-00-00 00:00:00', '2020-11-30 10:39:34', 24, 'admin', '::1'),
(229, '2020-12-01 05:22:21', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(230, '2020-12-01 09:45:39', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(231, '2020-12-01 12:24:07', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(232, '2020-12-02 05:13:55', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(233, '0000-00-00 00:00:00', '2020-12-02 12:03:06', 24, 'admin', '::1'),
(234, '2020-12-02 12:03:11', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(235, '2020-12-02 12:18:55', '0000-00-00 00:00:00', 27, 'asif', '::1'),
(236, '0000-00-00 00:00:00', '2020-12-02 15:08:26', 24, 'admin', '::1'),
(237, '2020-12-03 05:29:37', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(238, '2020-12-03 10:22:03', '0000-00-00 00:00:00', 27, 'asif', '::1'),
(239, '0000-00-00 00:00:00', '2020-12-03 10:22:27', 27, 'asif', '::1'),
(240, '2020-12-03 10:22:32', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(241, '0000-00-00 00:00:00', '2020-12-03 10:24:12', 24, 'admin', '::1'),
(242, '2020-12-03 10:24:18', '0000-00-00 00:00:00', 27, 'asif', '::1'),
(243, '0000-00-00 00:00:00', '2020-12-03 10:57:48', 27, 'asif', '::1'),
(244, '2020-12-03 10:57:53', '0000-00-00 00:00:00', 27, 'asif', '::1'),
(245, '0000-00-00 00:00:00', '2020-12-03 11:04:26', 27, 'asif', '::1'),
(246, '2020-12-03 11:04:35', '0000-00-00 00:00:00', 27, 'asif', '::1'),
(247, '0000-00-00 00:00:00', '2020-12-03 11:05:19', 27, 'asif', '::1'),
(248, '2020-12-06 05:17:42', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(249, '2020-12-07 05:35:53', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(250, '2020-12-07 10:18:30', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(251, '2020-12-08 05:30:28', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(252, '0000-00-00 00:00:00', '2020-12-08 11:30:08', 24, 'admin', '::1'),
(253, '2020-12-08 11:30:15', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(254, '2020-12-08 11:46:23', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(255, '2020-12-09 05:22:53', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(256, '2020-12-09 12:21:02', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(257, '2020-12-09 12:39:27', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(258, '2020-12-09 13:19:24', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(259, '2020-12-10 05:32:35', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(260, '2020-12-10 07:58:55', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(261, '2020-12-10 11:06:24', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(262, '2020-12-10 13:49:24', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(263, '2020-12-13 05:45:48', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(264, '2020-12-13 11:47:31', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(265, '2020-12-13 12:53:09', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(266, '2020-12-13 12:53:14', '0000-00-00 00:00:00', 0, 'admin', '::1'),
(267, '2020-12-13 12:53:22', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(268, '0000-00-00 00:00:00', '2020-12-13 14:07:09', 25, 'dew', '::1'),
(269, '2020-12-13 14:07:20', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(270, '0000-00-00 00:00:00', '2020-12-13 14:07:48', 25, 'dew', '::1'),
(271, '2020-12-13 14:10:10', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(272, '2020-12-14 05:22:50', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(273, '2020-12-14 05:51:12', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(274, '2020-12-14 07:11:48', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(275, '2020-12-14 07:18:48', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(276, '0000-00-00 00:00:00', '2020-12-14 07:58:22', 24, 'admin', '::1'),
(277, '0000-00-00 00:00:00', '2020-12-14 08:08:58', 24, 'admin', '::1'),
(278, '2020-12-14 08:09:02', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(279, '2020-12-14 08:36:01', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(280, '2020-12-14 08:40:32', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(281, '2020-12-14 08:49:33', '0000-00-00 00:00:00', 24, 'admin', '127.0.0.1'),
(282, '2020-12-14 08:51:40', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(283, '2020-12-14 08:59:37', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(284, '2020-12-14 09:16:21', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(285, '2020-12-14 09:27:27', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(286, '0000-00-00 00:00:00', '2020-12-14 09:31:07', 24, 'admin', '::1'),
(287, '2020-12-14 09:31:12', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(288, '2020-12-14 12:58:11', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(289, '2020-12-15 05:11:49', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(290, '2020-12-17 05:31:24', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(291, '2020-12-20 05:22:58', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(292, '2020-12-20 11:21:20', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(293, '0000-00-00 00:00:00', '2020-12-20 15:28:33', 24, 'admin', '::1'),
(294, '2020-12-21 05:32:51', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(295, '2020-12-21 13:20:21', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(296, '2020-12-22 05:54:45', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(297, '2020-12-22 07:41:47', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(298, '2020-12-22 10:05:08', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(299, '2020-12-22 12:19:15', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(300, '2020-12-23 05:36:07', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(301, '2020-12-24 07:58:56', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(302, '2020-12-24 10:54:05', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(303, '2020-12-24 13:03:30', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(304, '2020-12-27 05:32:49', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(305, '0000-00-00 00:00:00', '2020-12-27 07:34:01', 24, 'admin', '::1'),
(306, '2020-12-27 07:34:06', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(307, '2020-12-27 09:00:50', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(308, '2020-12-28 05:24:38', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(309, '0000-00-00 00:00:00', '2020-12-28 06:30:00', 24, 'admin', '::1'),
(310, '2020-12-28 06:30:05', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(311, '0000-00-00 00:00:00', '2020-12-28 07:50:53', 24, 'admin', '::1'),
(312, '2020-12-28 07:50:59', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(313, '2020-12-28 07:52:32', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(314, '0000-00-00 00:00:00', '2020-12-28 11:27:04', 25, 'dew', '::1'),
(315, '2020-12-28 11:27:11', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(316, '2020-12-28 11:41:42', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(317, '2020-12-28 11:41:47', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(318, '0000-00-00 00:00:00', '2020-12-28 11:45:31', 25, 'dew', '::1'),
(319, '2020-12-28 11:45:38', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(320, '0000-00-00 00:00:00', '2020-12-28 11:46:23', 25, 'dew', '::1'),
(321, '2020-12-28 11:46:32', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(322, '0000-00-00 00:00:00', '2020-12-28 11:58:33', 25, 'dew', '::1'),
(323, '2020-12-28 11:58:41', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(324, '0000-00-00 00:00:00', '2020-12-28 11:58:54', 24, 'admin', '::1'),
(325, '2020-12-28 11:59:00', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(326, '0000-00-00 00:00:00', '2020-12-28 12:06:33', 25, 'dew', '::1'),
(327, '2020-12-28 12:06:39', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(328, '0000-00-00 00:00:00', '2020-12-28 12:07:10', 25, 'dew', '::1'),
(329, '2020-12-28 12:07:17', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(330, '2020-12-29 05:20:47', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(331, '0000-00-00 00:00:00', '2020-12-29 08:30:38', 24, 'admin', '::1'),
(332, '2020-12-29 08:30:42', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(333, '2020-12-29 12:07:03', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(334, '0000-00-00 00:00:00', '2020-12-29 12:07:07', 25, 'dew', '::1'),
(335, '2020-12-29 12:12:17', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(336, '0000-00-00 00:00:00', '2020-12-29 12:12:20', 25, 'dew', '::1'),
(337, '2020-12-29 12:29:31', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(338, '2020-12-29 12:29:39', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(339, '2020-12-30 06:51:16', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(340, '0000-00-00 00:00:00', '2020-12-30 06:57:45', 24, 'admin', '::1'),
(341, '2020-12-30 10:42:07', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(342, '2020-12-30 13:35:31', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(343, '0000-00-00 00:00:00', '2020-12-30 13:38:57', 24, 'admin', '::1'),
(344, '2021-01-06 13:04:01', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(345, '0000-00-00 00:00:00', '2021-01-06 13:07:17', 24, 'admin', '::1'),
(346, '2021-01-18 07:45:52', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(347, '2021-02-03 11:32:48', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(348, '2021-02-03 11:38:31', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(349, '2021-02-03 12:13:29', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(350, '2021-03-21 11:11:23', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(351, '2021-03-21 13:52:11', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(352, '2021-03-22 06:01:07', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(353, '2021-03-23 05:52:29', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(354, '2021-03-24 05:54:43', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(355, '0000-00-00 00:00:00', '2021-03-24 14:05:59', 24, 'admin', '::1'),
(356, '2021-03-24 14:06:12', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(357, '2021-03-24 14:06:19', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(358, '2021-03-24 14:06:33', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(359, '0000-00-00 00:00:00', '2021-03-24 14:41:59', 25, 'dew', '::1'),
(360, '2021-03-24 14:42:07', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(361, '0000-00-00 00:00:00', '2021-03-24 14:42:34', 25, 'dew', '::1'),
(362, '2021-03-24 14:42:41', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(363, '0000-00-00 00:00:00', '2021-03-24 14:44:23', 25, 'dew', '::1'),
(364, '2021-03-24 14:44:32', '0000-00-00 00:00:00', 0, 'dew', '::1'),
(365, '2021-03-24 14:44:37', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(366, '0000-00-00 00:00:00', '2021-03-24 14:52:30', 25, 'dew', '::1'),
(367, '2021-03-24 14:52:34', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(368, '0000-00-00 00:00:00', '2021-03-24 15:30:12', 24, 'admin', '::1'),
(369, '2021-03-24 15:30:16', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(370, '0000-00-00 00:00:00', '2021-03-24 15:30:56', 24, 'admin', '::1'),
(371, '2021-03-24 15:31:02', '0000-00-00 00:00:00', 25, 'dew', '::1'),
(372, '0000-00-00 00:00:00', '2021-03-24 15:31:26', 25, 'dew', '::1'),
(373, '2021-03-24 15:31:32', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(374, '0000-00-00 00:00:00', '2021-03-24 15:32:49', 24, 'admin', '::1'),
(375, '2021-03-24 15:32:54', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(376, '0000-00-00 00:00:00', '2021-03-24 15:35:05', 24, 'admin', '::1'),
(377, '2021-03-24 15:35:09', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(378, '0000-00-00 00:00:00', '2021-03-24 15:37:59', 24, 'admin', '::1'),
(379, '2021-03-24 15:38:05', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(380, '2021-03-25 07:04:26', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(381, '2021-03-25 07:29:40', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(382, '2021-03-25 12:50:57', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(383, '2021-03-28 09:02:59', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(384, '2021-03-28 11:36:06', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(385, '0000-00-00 00:00:00', '2021-03-28 11:36:23', 24, 'admin', '::1'),
(386, '2021-03-29 06:25:43', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(387, '2021-04-01 05:50:56', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(388, '2021-04-01 07:09:46', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(389, '0000-00-00 00:00:00', '2021-04-01 13:52:54', 24, 'admin', '::1'),
(390, '2021-04-01 13:52:58', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(391, '0000-00-00 00:00:00', '2021-04-01 14:02:11', 24, 'admin', '::1'),
(392, '2021-04-01 14:03:19', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(393, '0000-00-00 00:00:00', '2021-04-01 14:05:10', 24, 'admin', '::1'),
(394, '2021-04-01 14:05:14', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(395, '0000-00-00 00:00:00', '2021-04-01 14:05:45', 24, 'admin', '::1'),
(396, '2021-04-01 14:05:49', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(397, '0000-00-00 00:00:00', '2021-04-01 14:06:07', 24, 'admin', '::1'),
(398, '2021-04-01 14:06:20', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(399, '0000-00-00 00:00:00', '2021-04-01 14:34:28', 24, 'admin', '::1'),
(400, '2021-04-01 14:34:34', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(401, '0000-00-00 00:00:00', '2021-04-01 14:47:10', 24, 'admin', '::1'),
(402, '2021-04-01 14:47:15', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(403, '0000-00-00 00:00:00', '2021-04-01 14:47:40', 24, 'admin', '::1'),
(404, '2021-04-01 14:47:44', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(405, '0000-00-00 00:00:00', '2021-04-01 15:01:10', 24, 'admin', '::1'),
(406, '2021-04-01 15:01:15', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(407, '2021-04-02 15:32:12', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(408, '2021-04-02 17:39:59', '0000-00-00 00:00:00', 24, 'admin', '::1'),
(409, '0000-00-00 00:00:00', '2021-04-02 21:18:24', 24, 'admin', '::1'),
(410, '2021-04-03 18:33:09', '0000-00-00 00:00:00', 24, 'admin', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `parent_menu` int(11) DEFAULT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_link` varchar(255) DEFAULT NULL,
  `menu_icon` varchar(255) DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_menu`, `menu_name`, `menu_link`, `menu_icon`, `order_by`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Dashboard', '', 'fa fa-dashboard fa-fw', 1, 1, NULL, NULL),
(2, NULL, 'HR', '', 'fa fa-user-plus fa-fw', 2, 1, NULL, NULL),
(3, NULL, 'Settings', '', 'fa fa-wrench fa-fw', 3, 1, NULL, NULL),
(4, NULL, 'Factory', '', 'fa fa-industry', 4, 1, NULL, NULL),
(5, NULL, 'Invoice', 'sale_product/outlet_sale', 'fa fa-balance-scale fa-fw', 5, 1, NULL, NULL),
(6, NULL, 'Kitchen Room', 'kitchen_room', 'fa fa-cutlery', 6, 1, NULL, NULL),
(7, NULL, 'Transaction', '', 'fa fa-product-hunt fa-fw', 7, 1, NULL, NULL),
(8, NULL, 'Money Receipt', '', 'fa fa-money fa-fw', 8, 1, NULL, NULL),
(9, NULL, 'Reports', '', 'fa fa-bar-chart fa-fw', 9, 1, NULL, NULL),
(10, NULL, 'Edit Money Receipt', '', 'fa fa-edit fa-fw', 10, 1, NULL, NULL),
(11, NULL, 'Edit Invoice', '', 'fa fa-edit fa-fw', 11, 1, NULL, NULL),
(12, 2, 'Assets Details', 'assets_info', '', 1, 1, NULL, NULL),
(13, 2, 'Assign Assets', 'assign_assets', '', 2, 1, NULL, NULL),
(14, 2, 'Leave Settings', 'company/leave_settings', '', 3, 1, NULL, NULL),
(15, 2, 'Employee Leave', 'hr/employee_leave', '', 4, 1, NULL, NULL),
(16, 2, 'Weekend Settings', 'settings/weekend_settings', '', 5, 1, NULL, NULL),
(17, 2, 'Holidays Settings', 'settings/holidays_settings', '', 6, 1, NULL, NULL),
(18, 2, 'Currency Settings', 'settings/currency_settings', '', 7, 1, NULL, NULL),
(19, 2, 'Employee Evaluation', 'hr/employee_evaluation', '', 8, 1, NULL, NULL),
(20, 2, 'Warning Letter', 'hr/warning_letter', '', 9, 1, NULL, NULL),
(21, 2, 'Leave Application', 'hr/employee_leave/leave_application', '', 10, 1, NULL, NULL),
(22, 2, 'Employee Salary Generate', 'employee_salary_generate', '', 11, 1, NULL, NULL),
(23, 3, 'Company', 'company', '', 1, 1, NULL, NULL),
(24, 3, 'Outlet', 'branch', '', 2, 1, NULL, NULL),
(25, 3, 'Tables', 'table', '', 3, 1, NULL, NULL),
(26, 3, 'Employee', 'employee', '', 4, 1, NULL, NULL),
(27, 3, 'User', 'user', '', 5, 1, NULL, NULL),
(28, 3, 'Printer Setup', 'printer_setup', '', 6, 1, NULL, NULL),
(29, 3, 'Category', 'product_type', '', 7, 1, NULL, NULL),
(30, 3, 'Product', 'product', '', 8, 1, NULL, NULL),
(31, 3, 'Recipe', 'recipe/add', '', 9, 1, NULL, NULL),
(32, 3, 'Customer', 'client', '', 10, 1, NULL, NULL),
(33, 3, 'Lock Settings', 'settings/lock_settings', '', 11, 1, NULL, NULL),
(34, 3, 'Super Password', 'settings/super_password', '', 12, 1, NULL, NULL),
(35, 4, 'Product Purchase', 'product_purchase', '', 1, 1, NULL, NULL),
(36, 4, 'Factory Sale', 'sale_product/factory_sale', '', 2, 1, NULL, NULL),
(37, 4, 'Supplier', 'supplier', '', 3, 1, NULL, NULL),
(38, 4, 'Production', 'production', '', 4, 1, NULL, NULL),
(39, 4, 'Product Transfer', 'product_transfer', '', 5, 1, NULL, NULL),
(40, 4, 'Damage / Return / Defect', '', 'fa fa-eraser fa-fw', 6, 1, NULL, NULL),
(41, 40, 'Product (Damage/Defect', 'damage_or_defect_product', '', 1, 1, NULL, NULL),
(42, 40, 'Product (Return)', 'return_product', '', 2, 1, NULL, NULL),
(43, 7, 'Product Receive', 'product_receive', '', 1, 1, NULL, NULL),
(44, 7, 'Product Transfer', 'stock_transfer', '', 2, 1, NULL, NULL),
(45, 7, 'Product Return', 'product_return', '', 3, 1, NULL, NULL),
(46, 8, 'Money Receipt', 'payment', '', 1, 1, NULL, NULL),
(47, 9, 'HR Reports', '', '', 1, 1, NULL, NULL),
(48, 9, 'Factory Report', '', '', 2, 1, NULL, NULL),
(49, 48, 'Purchase Report', '', '', 1, 1, NULL, NULL),
(50, 9, 'Customer Report', '', '', 3, 1, NULL, NULL),
(51, 9, 'Void Report', '', '', 4, 1, NULL, NULL),
(52, 9, 'Sales Report', '', '', 5, 1, NULL, NULL),
(53, 52, 'Inventory Report', '', '', 4, 1, NULL, NULL),
(54, 47, 'Employee Leave Report', 'reports/hr_report/employee_leave_report/employee_leave_report', '', 1, 1, NULL, NULL),
(55, 47, 'Employee Evaluation Report', 'reports/hr_report/employee_evaluation_report', '', 2, 1, NULL, NULL),
(56, 47, 'Warning Letter Report', 'reports/hr_report/warning_letter_report', '', 3, 1, NULL, NULL),
(57, 48, 'Transfer Report', 'transfer_report', '', 2, 1, NULL, NULL),
(58, 48, 'Stock Report', 'stock_report', '', 3, 1, NULL, NULL),
(59, 49, 'Purchase Statement', 'purchase_statement', '', 1, 1, NULL, NULL),
(60, 49, 'Payment Statement', 'payment_statement', '', 2, 1, NULL, NULL),
(61, 50, 'Customer Balance', 'customer_balance', '', 1, 1, NULL, NULL),
(62, 50, 'Customer Ledger', 'customer_ledger', '', 2, 1, NULL, NULL),
(63, 50, 'Customer Payment', 'customer_payment', '', 3, 1, NULL, NULL),
(64, 50, 'Customer Bill', 'customer_bill', '', 4, 1, NULL, NULL),
(65, 51, 'Invoice Void Report', 'invoice_void_report', '', 1, 1, NULL, NULL),
(66, 52, 'Invoice Report', 'reports/invoice_report', '', 1, 1, NULL, NULL),
(67, 52, 'Product Report', 'reports/periodic_sales_details_report', '', 2, 1, NULL, NULL),
(68, 52, 'Client Wise Sales Report', 'reports/client_wise_sales_report', '', 3, 1, NULL, NULL),
(69, 53, 'Stock Report', 'branch_wise_stock_report', '', 1, 1, NULL, NULL),
(70, 10, 'Edit Money Receipt', 'edit_mr', '', 1, 1, NULL, NULL),
(71, 11, 'Edit Invoice', 'client_product_return', '', 1, 1, NULL, NULL),
(72, 3, 'Menu', 'menu', '', 13, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `narration`
--

CREATE TABLE `narration` (
  `id` int(11) NOT NULL,
  `narration` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `message_title` varchar(500) NOT NULL,
  `message_body` varchar(800) NOT NULL,
  `notification_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `propose_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification_assign`
--

CREATE TABLE `notification_assign` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL DEFAULT 0,
  `employee_id` int(11) NOT NULL DEFAULT 0,
  `open_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_show` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_sheet`
--

CREATE TABLE `order_sheet` (
  `id` int(11) NOT NULL,
  `online_order_number` varchar(100) NOT NULL,
  `issue_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `issue_time` time NOT NULL,
  `client_id` int(11) NOT NULL,
  `delivery_address` varchar(500) NOT NULL,
  `work_order_number` varchar(100) NOT NULL,
  `work_order_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `delivery_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `freight_charge` double NOT NULL,
  `discount` double NOT NULL,
  `bonus` double NOT NULL,
  `total` double NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `current_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_sheet_details`
--

CREATE TABLE `order_sheet_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `pack_size` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` double NOT NULL,
  `amount` double NOT NULL,
  `order_sheet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `receipt_mr_no` varchar(500) DEFAULT NULL,
  `receipt_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `client_id` int(11) NOT NULL,
  `amount_received` double DEFAULT 0,
  `client_code` varchar(500) NOT NULL,
  `payment_type` varchar(500) NOT NULL,
  `cheque_number` varchar(500) DEFAULT NULL,
  `cheque_date` timestamp NULL DEFAULT NULL,
  `bank_id` int(11) DEFAULT 0,
  `branch_name` varchar(500) DEFAULT NULL,
  `purpose` varchar(500) DEFAULT NULL,
  `invoice_number` varchar(500) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `branch_mr_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `receipt_mr_no`, `receipt_date`, `client_id`, `amount_received`, `client_code`, `payment_type`, `cheque_number`, `cheque_date`, `bank_id`, `branch_name`, `purpose`, `invoice_number`, `remarks`, `branch_id`, `branch_mr_no`) VALUES
(1, '1000', '2020-12-22 12:19:47', 1, 100, '', 'Cash', NULL, NULL, 0, NULL, NULL, 'inv-00000000007', NULL, 0, ''),
(2, '1001', '2020-12-22 12:22:29', 1, 100, '', 'Due', NULL, NULL, 0, NULL, NULL, 'inv-00000000054', NULL, 0, ''),
(3, '1002', '2020-12-22 12:23:06', 1, 200, '', 'Split', NULL, NULL, 0, NULL, NULL, 'inv-00000000055', NULL, 0, ''),
(6, '1003', '2020-12-21 18:00:00', 1, 100, '1000', 'Cash', NULL, NULL, 0, NULL, NULL, '', 'Remarks 001', 11, ''),
(7, '1004', '2020-12-21 18:00:00', 1, 150, '1000', 'Cash', NULL, NULL, 0, NULL, NULL, '', 'Remarks 002', 11, ''),
(8, '1005', '2020-12-21 18:00:00', 1, 200, '1000', 'Cash', NULL, NULL, 0, NULL, NULL, '', 'Remarks 003', 11, ''),
(9, '1006', '2020-12-23 06:27:01', 4, 50, '', 'Due', NULL, NULL, 0, NULL, NULL, 'inv-00000000056', NULL, 0, ''),
(10, '1007', '2020-12-23 06:29:17', 4, 300, '', 'Card', NULL, NULL, 0, NULL, NULL, 'inv-00000000057', NULL, 0, ''),
(11, '1008', '2020-12-22 18:00:00', 4, 150, '1001', 'Card', NULL, NULL, 0, NULL, NULL, '', 'Remarks - 006', 11, ''),
(12, '1009', '2020-12-23 08:50:17', 1, 200, '', 'Due', NULL, NULL, 0, NULL, NULL, 'inv-00000000058', NULL, 0, ''),
(13, '1010', '2020-12-23 08:54:51', 1, 100, '1000', 'Cash', NULL, NULL, 0, NULL, NULL, '', 'REmarks - 008', 11, ''),
(14, '1011', '2020-12-29 08:51:47', 1, 250, '', 'Cash', NULL, NULL, 0, NULL, NULL, 'inv-00000000062', NULL, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `pf_funds`
--

CREATE TABLE `pf_funds` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `pf_contribution_per_month` double NOT NULL,
  `total_deposit_amount` double NOT NULL,
  `starting_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pf_funds`
--

INSERT INTO `pf_funds` (`id`, `employee_id`, `pf_contribution_per_month`, `total_deposit_amount`, `starting_date`, `user_id`) VALUES
(1, 8, 10000, 36000, '2016-07-31 18:00:00', 24);

-- --------------------------------------------------------

--
-- Table structure for table `pf_funds_details`
--

CREATE TABLE `pf_funds_details` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `deposit_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `previous_deposit_amount` double NOT NULL,
  `deposit_amount` double NOT NULL,
  `deposit_amount_total` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `salary_details_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pf_funds_details`
--

INSERT INTO `pf_funds_details` (`id`, `employee_id`, `deposit_date`, `previous_deposit_amount`, `deposit_amount`, `deposit_amount_total`, `user_id`, `salary_details_id`) VALUES
(1, 8, '2020-10-14 18:00:00', 0, 36000, 36000, 24, 0);

-- --------------------------------------------------------

--
-- Table structure for table `printer_info`
--

CREATE TABLE `printer_info` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `printer_info`
--

INSERT INTO `printer_info` (`id`, `name`, `address`, `status`) VALUES
(1, 'Printer 01', 'Address 01', 1),
(2, 'Printer 02', 'Address 02', 1),
(4, 'Printer 03', 'Address 03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(500) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `image` text DEFAULT NULL,
  `hot_kitchen_status` tinyint(4) NOT NULL DEFAULT 0,
  `availability` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `product_stock` double DEFAULT 0,
  `product_range` varchar(500) NOT NULL,
  `purchase_price` double NOT NULL DEFAULT 0,
  `minimum_price` double NOT NULL DEFAULT 0,
  `maximum_price` double NOT NULL DEFAULT 0,
  `fixed_price` double NOT NULL DEFAULT 0,
  `vat_rate` double NOT NULL DEFAULT 0,
  `api` varchar(1000) DEFAULT NULL,
  `sae` varchar(1000) DEFAULT NULL,
  `iso` varchar(1000) DEFAULT NULL,
  `pack_size` varchar(1000) DEFAULT NULL,
  `origin_of_country` varchar(1000) DEFAULT NULL,
  `reorder_level` double NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_type_id`, `product_name`, `product_code`, `image`, `hot_kitchen_status`, `availability`, `unit`, `product_stock`, `product_range`, `purchase_price`, `minimum_price`, `maximum_price`, `fixed_price`, `vat_rate`, `api`, `sae`, `iso`, `pack_size`, `origin_of_country`, `reorder_level`, `sort_order`) VALUES
(9, 6, 'Espresso', '001', NULL, 0, 'All', '1', 3, '', 50, 120, 120, 100, 0, NULL, NULL, NULL, NULL, NULL, 0, 1),
(10, 6, 'Americano', '002', 'assets/uploads/product_images/20210322161810.jpg', 0, 'All', '2', 3, '', 56.31, 150, 150, 150, 0, NULL, NULL, NULL, NULL, NULL, 0, 2),
(11, 6, 'Macchiato', '003', NULL, 0, NULL, 'KG', 3, '', 64.03, 150, 150, 150, 0, NULL, NULL, NULL, NULL, NULL, 0, 3),
(12, 6, 'Cappuccino', '004', NULL, 0, NULL, 'Pcs', 41, '', 0, 245, 245, 200, 0, NULL, NULL, NULL, NULL, NULL, 0, 4),
(13, 6, 'Latte', '005', NULL, 0, NULL, 'KG', 47, '', 0, 245, 245, 250, 0, NULL, NULL, NULL, NULL, NULL, 0, 5),
(14, 6, 'Flavoure Latte', '006', NULL, 0, NULL, 'KG', 50, '', 0, 295, 295, 295, 0, NULL, NULL, NULL, NULL, NULL, 0, 6),
(15, 6, 'Mocha', '007', NULL, 0, NULL, 'KG', 50, '', 0, 295, 295, 295, 0, NULL, NULL, NULL, NULL, NULL, 0, 7),
(16, 6, 'Hot Chocolate', '008', NULL, 0, NULL, 'KG', 50, '', 0, 299, 299, 299, 0, NULL, NULL, NULL, NULL, NULL, 0, 8),
(17, 7, 'Iced Latte', '009', NULL, 0, NULL, NULL, 50, '', 0, 275, 275, 275, 0, NULL, NULL, NULL, NULL, NULL, 0, 9),
(18, 7, 'Iced Cappucinno', '010', NULL, 0, NULL, NULL, 0, '', 0, 275, 275, 275, 0, NULL, NULL, NULL, NULL, NULL, 0, 10),
(19, 7, 'Iced Mocha', '011', NULL, 0, NULL, NULL, 0, '', 0, 315, 315, 315, 0, NULL, NULL, NULL, NULL, NULL, 0, 11),
(20, 7, 'Iced Americano', '012', NULL, 0, NULL, NULL, 0, '', 0, 175, 175, 175, 0, NULL, NULL, NULL, NULL, NULL, 0, 12),
(21, 8, 'CoffeeNut Chiller', '013', NULL, 0, NULL, NULL, 0, '', 0, 345, 345, 345, 0, NULL, NULL, NULL, NULL, NULL, 0, 13),
(22, 8, 'Mocha Chiller', '014', NULL, 0, NULL, NULL, 0, '', 0, 345, 345, 345, 0, NULL, NULL, NULL, NULL, NULL, 0, 14),
(23, 8, 'Caramel Chiller', '015', NULL, 0, NULL, NULL, 0, '', 0, 345, 345, 345, 0, NULL, NULL, NULL, NULL, NULL, 0, 15),
(24, 8, 'Chocolate Chiller', '016', NULL, 0, NULL, NULL, 0, '', 0, 345, 345, 345, 0, NULL, NULL, NULL, NULL, NULL, 0, 16),
(25, 8, 'Strawberry Chiller', '017', NULL, 0, NULL, NULL, 0, '', 0, 345, 345, 345, 0, NULL, NULL, NULL, NULL, NULL, 0, 17),
(26, 9, 'Virgin Mojito', '018', NULL, 0, NULL, NULL, 0, '', 0, 280, 280, 280, 0, NULL, NULL, NULL, NULL, NULL, 0, 18),
(27, 9, 'Tropical Punch', '019', NULL, 0, NULL, NULL, 0, '', 0, 280, 280, 280, 0, NULL, NULL, NULL, NULL, NULL, 0, 19),
(28, 9, 'Strawberry Mix Berries Mocktail', '019', NULL, 0, NULL, NULL, 0, '', 0, 280, 280, 280, 0, NULL, NULL, NULL, NULL, NULL, 0, 19),
(29, 9, 'Blue Apple Mocktail', '020', NULL, 0, NULL, NULL, 0, '', 0, 280, 280, 280, 0, NULL, NULL, NULL, NULL, NULL, 0, 20),
(30, 9, 'Peach Mocktail', '021', NULL, 0, NULL, NULL, 0, '', 0, 280, 280, 280, 0, NULL, NULL, NULL, NULL, NULL, 0, 21),
(31, 10, 'Peach Soda', '023', NULL, 0, NULL, NULL, 0, '', 0, 170, 170, 170, 0, NULL, NULL, NULL, NULL, NULL, 0, 23),
(32, 10, 'Green Apple Soda', '024', NULL, 0, NULL, NULL, 0, '', 0, 170, 170, 170, 0, NULL, NULL, NULL, NULL, NULL, 0, 24),
(33, 10, 'Blueberry Soda', '025', NULL, 0, NULL, NULL, 0, '', 0, 170, 170, 170, 0, NULL, NULL, NULL, NULL, NULL, 0, 25),
(34, 10, 'Blue Ocean', '026', NULL, 0, NULL, NULL, 0, '', 0, 170, 170, 170, 0, NULL, NULL, NULL, NULL, NULL, 0, 26),
(35, 10, 'Papaya Juice', '027', NULL, 0, NULL, NULL, 0, '', 0, 150, 150, 150, 0, NULL, NULL, NULL, NULL, NULL, 0, 27),
(36, 11, 'Cup Cake with Topping', '027', NULL, 0, NULL, NULL, 0, '', 0, 99, 99, 99, 0, NULL, NULL, NULL, NULL, NULL, 0, 27),
(37, 11, 'Muffin Blueberry', '028', NULL, 0, NULL, NULL, 0, '', 0, 89, 89, 89, 0, NULL, NULL, NULL, NULL, NULL, 0, 28),
(38, 11, 'Muffin Strawberry', '029', NULL, 0, NULL, NULL, 0, '', 0, 89, 89, 89, 0, NULL, NULL, NULL, NULL, NULL, 0, 29),
(39, 11, 'Chocolate Muffin', '029', NULL, 0, NULL, NULL, 0, '', 0, 99, 99, 99, 0, NULL, NULL, NULL, NULL, NULL, 0, 29),
(40, 11, 'Chocolate Cup Cake with Topping', '030', NULL, 0, NULL, NULL, 0, '', 0, 109, 109, 109, 0, NULL, NULL, NULL, NULL, NULL, 0, 30),
(41, 11, 'Mix Fruit Cup Cake', '031', NULL, 0, NULL, NULL, 0, '', 0, 59, 59, 59, 0, NULL, NULL, NULL, NULL, NULL, 0, 31),
(42, 11, 'Butter Cake Premium', '031', NULL, 0, NULL, NULL, 0, '', 0, 350, 350, 350, 0, NULL, NULL, NULL, NULL, NULL, 0, 31),
(43, 11, 'Butter Cake Regular', '032', NULL, 0, NULL, NULL, 0, '', 0, 250, 250, 250, 0, NULL, NULL, NULL, NULL, NULL, 0, 32),
(44, 11, 'Mix Fruit Cake Premium', '033', NULL, 0, NULL, NULL, 0, '', 0, 375, 375, 375, 0, NULL, NULL, NULL, NULL, NULL, 0, 33),
(45, 11, 'Mix Fruit Cake Regular', '034', NULL, 0, NULL, NULL, 0, '', 0, 275, 275, 275, 0, NULL, NULL, NULL, NULL, NULL, 0, 34),
(46, 11, 'Marble Cake Premium', '035', NULL, 0, NULL, NULL, 0, '', 0, 335, 335, 335, 0, NULL, NULL, NULL, NULL, NULL, 0, 35),
(47, 11, 'Marble Cake Regular', '036', NULL, 0, NULL, NULL, 0, '', 0, 235, 235, 235, 0, NULL, NULL, NULL, NULL, NULL, 0, 36),
(48, 12, 'Butter Cookies (1KG)', '035', NULL, 0, NULL, NULL, 0, '', 0, 1190, 1190, 1190, 0, NULL, NULL, NULL, NULL, NULL, 0, 35),
(49, 12, 'Lite Chocolate Cookies (1KG)', '036', NULL, 0, NULL, NULL, 0, '', 0, 1255, 1255, 1255, 0, NULL, NULL, NULL, NULL, NULL, 0, 36),
(50, 12, 'Chocolate Chip with Almond Nut (1KG)', '037', NULL, 0, NULL, NULL, 0, '', 0, 1690, 1690, 1690, 0, NULL, NULL, NULL, NULL, NULL, 0, 37),
(51, 12, 'Oat Cookies (1KG)', '037', NULL, 0, NULL, NULL, 0, '', 0, 35, 35, 35, 0, NULL, NULL, NULL, NULL, NULL, 0, 37),
(52, 12, 'Nut Griba (1KG)', '038', NULL, 0, NULL, NULL, 0, '', 0, 1690, 1690, 1690, 0, NULL, NULL, NULL, NULL, NULL, 0, 38),
(53, 12, 'Peanut Butter Cookies (1KG)', '039', NULL, 0, NULL, NULL, 0, '', 0, 1190, 1190, 1190, 0, NULL, NULL, NULL, NULL, NULL, 0, 39),
(54, 12, 'Ginger Cookies (1KG)', '040', NULL, 0, NULL, NULL, 0, '', 0, 60, 60, 60, 0, NULL, NULL, NULL, NULL, NULL, 0, 40),
(55, 12, 'Ginger Decor (1KG)', '041', NULL, 0, NULL, NULL, 0, '', 0, 60, 60, 60, 0, NULL, NULL, NULL, NULL, NULL, 0, 41),
(56, 12, 'Dry Cake (1KG)', '042', NULL, 0, NULL, NULL, 0, '', 0, 999, 999, 999, 0, NULL, NULL, NULL, NULL, NULL, 0, 42),
(57, 12, 'Chocolate Dry Cake (1KG)', '043', NULL, 0, NULL, NULL, 0, '', 0, 1099, 1099, 1099, 0, NULL, NULL, NULL, NULL, NULL, 0, 43),
(58, 12, 'Plain Toast (1KG)', '044', NULL, 0, NULL, NULL, 0, '', 0, 450, 450, 450, 0, NULL, NULL, NULL, NULL, NULL, 0, 44),
(59, 12, 'Macaroon (1KG)', '045', NULL, 0, NULL, NULL, 0, '', 0, 99, 99, 99, 0, NULL, NULL, NULL, NULL, NULL, 0, 45),
(60, 12, 'Garlic Stick (1KG)', '046', NULL, 0, NULL, NULL, 0, '', 0, 1599, 1599, 1599, 0, NULL, NULL, NULL, NULL, NULL, 0, 46),
(61, 12, 'Salt Crackers (1KG)', '047', NULL, 0, NULL, NULL, 0, '', 0, 1399, 1399, 1399, 0, NULL, NULL, NULL, NULL, NULL, 0, 47),
(62, 13, 'Chicken Puff', '048', NULL, 0, NULL, NULL, 0, '', 0, 99, 99, 99, 0, NULL, NULL, NULL, NULL, NULL, 0, 48),
(63, 13, 'Beef Puff', '048', NULL, 0, NULL, NULL, 0, '', 0, 109, 109, 109, 0, NULL, NULL, NULL, NULL, NULL, 0, 48),
(64, 13, 'Chicken Pot Puff', '049', NULL, 0, NULL, NULL, 0, '', 0, 109, 109, 109, 0, NULL, NULL, NULL, NULL, NULL, 0, 49),
(65, 13, 'Spice Cheese Straw', '050', NULL, 0, NULL, NULL, 0, '', 0, 1599, 1599, 1599, 0, NULL, NULL, NULL, NULL, NULL, 0, 50),
(66, 13, 'Sugar Puff', '051', NULL, 0, NULL, NULL, 0, '', 0, 1299, 1299, 1299, 0, NULL, NULL, NULL, NULL, NULL, 0, 51),
(67, 13, 'Sea Salt Straw', '052', NULL, 0, NULL, NULL, 0, '', 0, 1299, 1299, 1299, 0, NULL, NULL, NULL, NULL, NULL, 0, 52),
(68, 13, 'Chicken Wallington', '053', NULL, 0, NULL, NULL, 0, '', 0, 119, 119, 119, 0, NULL, NULL, NULL, NULL, NULL, 0, 53),
(69, 15, 'Opera Slice', '054', NULL, 0, NULL, NULL, 0, '', 0, 200, 200, 200, 0, NULL, NULL, NULL, NULL, NULL, 0, 54),
(70, 15, 'Vanilla Cake Slice', '055', NULL, 0, NULL, NULL, 0, '', 0, 180, 180, 180, 0, NULL, NULL, NULL, NULL, NULL, 0, 55),
(71, 15, 'Chocolate Slice', '056', NULL, 0, NULL, NULL, 0, '', 0, 190, 190, 190, 0, NULL, NULL, NULL, NULL, NULL, 0, 56),
(72, 15, 'New York Cheese Cake Slice', '057', NULL, 0, NULL, NULL, 0, '', 0, 350, 350, 350, 0, NULL, NULL, NULL, NULL, NULL, 0, 57),
(73, 15, 'Blue Berry Cheese Cake Slice', '058', NULL, 0, NULL, NULL, 0, '', 0, 320, 320, 320, 0, NULL, NULL, NULL, NULL, NULL, 0, 58),
(74, 15, 'Swiss Roll', '059', NULL, 0, NULL, NULL, 0, '', 0, 150, 150, 150, 0, NULL, NULL, NULL, NULL, NULL, 0, 59),
(75, 15, 'Black Forest Cake Slice', '060', NULL, 0, NULL, NULL, 0, '', 0, 200, 200, 200, 0, NULL, NULL, NULL, NULL, NULL, 0, 60),
(76, 15, 'Red Velvet Cake Slice', '061', NULL, 0, NULL, NULL, 0, '', 0, 220, 220, 220, 0, NULL, NULL, NULL, NULL, NULL, 0, 61),
(77, 15, 'Tia Maria Cake Slice', '062', NULL, 0, NULL, NULL, 0, '', 0, 220, 220, 220, 0, NULL, NULL, NULL, NULL, NULL, 0, 62),
(78, 15, 'Rich Chocolate Cake Slice', '063', NULL, 0, NULL, NULL, 0, '', 0, 210, 210, 210, 0, NULL, NULL, NULL, NULL, NULL, 0, 63),
(79, 15, 'Tiramisu Slice', '064', NULL, 0, NULL, NULL, 0, '', 0, 320, 320, 320, 0, NULL, NULL, NULL, NULL, NULL, 0, 64),
(80, 16, 'Apple Pie', '065', NULL, 0, NULL, NULL, 0, '', 0, 150, 150, 150, 0, NULL, NULL, NULL, NULL, NULL, 0, 65),
(81, 16, 'Honey Dew Pai', '066', NULL, 0, NULL, NULL, 0, '', 0, 150, 150, 150, 0, NULL, NULL, NULL, NULL, NULL, 0, 66),
(82, 16, 'Double Chocolate Tart Large', '067', NULL, 0, NULL, NULL, 0, '', 0, 1600, 1600, 1600, 0, NULL, NULL, NULL, NULL, NULL, 0, 67),
(83, 16, 'Lemon Merang Tart Large', '068', NULL, 0, NULL, NULL, 0, '', 0, 1200, 1200, 1200, 0, NULL, NULL, NULL, NULL, NULL, 0, 68),
(84, 16, 'Royal Peanut Chocolate Tart Large', '069', NULL, 0, NULL, NULL, 0, '', 0, 1600, 1600, 1600, 0, NULL, NULL, NULL, NULL, NULL, 0, 69),
(85, 16, 'Egg Tart Hot', '070', NULL, 0, NULL, NULL, 0, '', 0, 150, 150, 150, 0, NULL, NULL, NULL, NULL, NULL, 0, 70),
(86, 16, 'Chicken Mushroom Quash', '071', NULL, 0, NULL, NULL, 0, '', 0, 250, 250, 250, 0, NULL, NULL, NULL, NULL, NULL, 0, 71),
(87, 16, 'Beef spinach Quash', '072', NULL, 0, NULL, NULL, 0, '', 0, 275, 275, 275, 0, NULL, NULL, NULL, NULL, NULL, 0, 72),
(88, 17, 'Cream Caramel', '073', NULL, 0, NULL, NULL, 0, '', 0, 120, 120, 120, 0, NULL, NULL, NULL, NULL, NULL, 0, 73),
(89, 17, 'Bread Butter Pudding', '074', NULL, 0, NULL, NULL, 0, '', 0, 130, 130, 130, 0, NULL, NULL, NULL, NULL, NULL, 0, 74),
(90, 17, 'Diplomat Pudding', '075', NULL, 0, NULL, NULL, 0, '', 0, 150, 150, 150, 0, NULL, NULL, NULL, NULL, NULL, 0, 75),
(91, 17, 'Rich Chocolate Brownie', '075', NULL, 0, NULL, NULL, 0, '', 0, 190, 190, 190, 0, NULL, NULL, NULL, NULL, NULL, 0, 75),
(92, 17, 'Nutty Fudge', '076', NULL, 0, NULL, NULL, 0, '', 0, 220, 220, 220, 0, NULL, NULL, NULL, NULL, NULL, 0, 76),
(93, 17, 'Mix Doughnut', '077', NULL, 0, NULL, NULL, 0, '', 0, 135, 135, 135, 0, NULL, NULL, NULL, NULL, NULL, 0, 77),
(94, 18, 'Sandwich Bread Small', '078', NULL, 0, NULL, NULL, 0, '', 0, 70, 70, 70, 0, NULL, NULL, NULL, NULL, NULL, 0, 78),
(95, 18, 'Sandwich Bread Big', '079', NULL, 0, NULL, NULL, 0, '', 0, 135, 135, 135, 0, NULL, NULL, NULL, NULL, NULL, 0, 79),
(96, 18, 'Burger Bun 2 pc', '080', NULL, 0, NULL, NULL, 0, '', 0, 50, 50, 50, 0, NULL, NULL, NULL, NULL, NULL, 0, 80),
(97, 18, 'Hotdog Bun (2 Pcs)', '081', NULL, 0, NULL, NULL, 0, '', 0, 50, 50, 50, 0, NULL, NULL, NULL, NULL, NULL, 0, 81),
(98, 18, 'Slider Bun (4 Pcs)', '082', NULL, 0, NULL, NULL, 0, '', 0, 60, 60, 60, 0, NULL, NULL, NULL, NULL, NULL, 0, 82),
(99, 18, 'French Bread', '083', NULL, 0, NULL, NULL, 0, '', 0, 99, 99, 99, 0, NULL, NULL, NULL, NULL, NULL, 0, 83),
(100, 18, 'Mix Fruit Bread', '084', NULL, 0, NULL, NULL, 0, '', 0, 175, 175, 175, 0, NULL, NULL, NULL, NULL, NULL, 0, 84),
(101, 18, 'Herbs Bread', '085', NULL, 0, NULL, NULL, 0, '', 0, 155, 155, 155, 0, NULL, NULL, NULL, NULL, NULL, 0, 85),
(102, 18, 'Multi Grain Bread', '086', NULL, 0, NULL, NULL, 0, '', 0, 180, 180, 180, 0, NULL, NULL, NULL, NULL, NULL, 0, 86),
(103, 18, 'Butter Bun', '087', NULL, 0, NULL, NULL, 0, '', 0, 45, 45, 45, 0, NULL, NULL, NULL, NULL, NULL, 0, 87),
(104, 18, 'English Muffin', '088', NULL, 0, NULL, NULL, 0, '', 0, 75, 75, 75, 0, NULL, NULL, NULL, NULL, NULL, 0, 88),
(105, 18, 'Brioch Bread Rolls', '089', NULL, 0, NULL, NULL, 0, '', 0, 70, 70, 70, 0, NULL, NULL, NULL, NULL, NULL, 0, 89),
(106, 18, 'Brioch Cheese Bread', '090', NULL, 0, NULL, NULL, 0, '', 0, 220, 220, 220, 0, NULL, NULL, NULL, NULL, NULL, 0, 90),
(107, 18, 'Vegetable Cheese Roll', '091', NULL, 0, NULL, NULL, 0, '', 0, 45, 45, 45, 0, NULL, NULL, NULL, NULL, NULL, 0, 91),
(108, 18, 'German bread (600 gm)', '092', NULL, 0, NULL, NULL, 0, '', 0, 350, 350, 350, 0, NULL, NULL, NULL, NULL, NULL, 0, 92),
(109, 18, 'Kito Bread (450 gm)', '093', NULL, 0, NULL, NULL, 0, '', 0, 900, 900, 900, 0, NULL, NULL, NULL, NULL, NULL, 0, 93),
(110, 19, 'Butter Croissant', '094', NULL, 0, NULL, NULL, 0, '', 0, 79, 79, 79, 0, NULL, NULL, NULL, NULL, NULL, 0, 94),
(111, 19, 'Chocolate Croissant', '095', NULL, 0, NULL, NULL, 0, '', 0, 99, 99, 99, 0, NULL, NULL, NULL, NULL, NULL, 0, 95),
(112, 19, 'Poched Apple Danish', '096', NULL, 0, NULL, NULL, 0, '', 0, 109, 109, 109, 0, NULL, NULL, NULL, NULL, NULL, 0, 96),
(113, 19, 'Cinnamon Roll (100 gm)', '097', NULL, 0, NULL, NULL, 0, '', 0, 65, 65, 65, 0, NULL, NULL, NULL, NULL, NULL, 0, 97),
(114, 19, 'Custard Danish', '098', NULL, 0, NULL, NULL, 0, '', 0, 99, 99, 99, 0, NULL, NULL, NULL, NULL, NULL, 0, 98),
(115, 19, 'Chicken Sandwich Cold', '099', NULL, 0, NULL, NULL, 0, '', 0, 45, 45, 45, 0, NULL, NULL, NULL, NULL, NULL, 0, 99),
(116, 19, 'Egg Sandwich Cold', '100', NULL, 0, NULL, NULL, 0, '', 0, 45, 45, 45, 0, NULL, NULL, NULL, NULL, NULL, 0, 100),
(117, 19, 'Club Sandwich', '101', NULL, 0, NULL, NULL, 0, '', 0, 99, 99, 99, 0, NULL, NULL, NULL, NULL, NULL, 0, 101),
(118, 19, 'Baked Koliga Singara', '102', NULL, 0, NULL, NULL, 0, '', 0, 45, 45, 45, 0, NULL, NULL, NULL, NULL, NULL, 0, 102),
(119, 19, 'Baked Chicken Samusa', '103', NULL, 0, NULL, NULL, 0, '', 0, 45, 45, 45, 0, NULL, NULL, NULL, NULL, NULL, 0, 103),
(120, 19, 'Baked Beef Samusa', '104', NULL, 0, NULL, NULL, 0, '', 0, 45, 45, 45, 0, NULL, NULL, NULL, NULL, NULL, 0, 104),
(121, 19, 'Baked Mutton Singara', '105', NULL, 0, NULL, NULL, 0, '', 0, 45, 45, 45, 0, NULL, NULL, NULL, NULL, NULL, 0, 105),
(122, 20, 'Slow Cook Beef Burger', '106', NULL, 0, NULL, NULL, 0, '', 0, 380, 380, 380, 0, NULL, NULL, NULL, NULL, NULL, 0, 106),
(123, 20, 'Chicken Burger', '107', NULL, 0, NULL, NULL, 0, '', 0, 265, 265, 265, 0, NULL, NULL, NULL, NULL, NULL, 0, 107),
(124, 20, 'Prawn Burger', '108', NULL, 0, NULL, NULL, 0, '', 0, 449, 449, 449, 0, NULL, NULL, NULL, NULL, NULL, 0, 108),
(125, 20, 'Sea Food Burger', '109', NULL, 0, NULL, NULL, 0, '', 0, 320, 320, 320, 0, NULL, NULL, NULL, NULL, NULL, 0, 109),
(126, 20, 'Crispy Chicken Burger', '110', NULL, 0, NULL, NULL, 0, '', 0, 265, 265, 265, 0, NULL, NULL, NULL, NULL, NULL, 0, 110),
(127, 20, 'Beef Burger', '111', NULL, 0, NULL, NULL, 0, '', 0, 415, 415, 415, 0, NULL, NULL, NULL, NULL, NULL, 0, 111),
(128, 20, 'Hot Dog Chicken', '112', NULL, 0, NULL, NULL, 0, '', 0, 260, 260, 260, 0, NULL, NULL, NULL, NULL, NULL, 0, 112),
(129, 20, 'Hotdog Slow Cooked Beef', '113', NULL, 0, NULL, NULL, 0, '', 0, 290, 290, 290, 0, NULL, NULL, NULL, NULL, NULL, 0, 113),
(130, 20, 'Smocked Chicken Sandwich', '114', NULL, 0, NULL, NULL, 0, '', 0, 145, 145, 145, 0, NULL, NULL, NULL, NULL, NULL, 0, 114),
(131, 20, 'Grilled Cheese Sandwich', '115', NULL, 0, NULL, NULL, 0, '', 0, 125, 125, 125, 0, NULL, NULL, NULL, NULL, NULL, 0, 115),
(132, 21, 'Vintage Special Wrap', '116', NULL, 0, NULL, NULL, 0, '', 0, 315, 315, 315, 0, NULL, NULL, NULL, NULL, NULL, 0, 116),
(133, 21, 'Spice Grill Chicken Wrap', '117', NULL, 0, NULL, NULL, 0, '', 0, 285, 285, 285, 0, NULL, NULL, NULL, NULL, NULL, 0, 117),
(134, 21, 'Tariyaki Chicken Wrap', '118', NULL, 0, NULL, NULL, 0, '', 0, 295, 295, 295, 0, NULL, NULL, NULL, NULL, NULL, 0, 118),
(135, 21, 'Kala Vuna Wrap', '119', NULL, 0, NULL, NULL, 0, '', 0, 345, 345, 345, 0, NULL, NULL, NULL, NULL, NULL, 0, 119),
(136, 22, 'Mexican Pizza (Big)', '120', NULL, 0, NULL, NULL, 0, '', 0, 999, 999, 999, 0, NULL, NULL, NULL, NULL, NULL, 0, 120),
(137, 22, 'Mexican Pizza (Small)', '121', NULL, 0, NULL, NULL, 0, '', 0, 666, 666, 666, 0, NULL, NULL, NULL, NULL, NULL, 0, 121),
(138, 22, 'Hawaiyan Pizza (Big)', '122', NULL, 0, NULL, NULL, 0, '', 0, 999, 999, 999, 0, NULL, NULL, NULL, NULL, NULL, 0, 122),
(139, 22, 'Hawaiyan Pizza (Small)', '123', NULL, 0, NULL, NULL, 0, '', 0, 666, 666, 666, 0, NULL, NULL, NULL, NULL, NULL, 0, 123),
(140, 22, 'Margarita Pizza (Big)', '124', NULL, 0, NULL, NULL, 0, '', 0, 777, 777, 777, 0, NULL, NULL, NULL, NULL, NULL, 0, 124),
(141, 22, 'Margarita Pizza (Small)', '125', NULL, 0, NULL, NULL, 0, '', 0, 555, 555, 555, 0, NULL, NULL, NULL, NULL, NULL, 0, 125),
(142, 22, 'Vintage Special Pizza (Big)', '126', NULL, 0, NULL, NULL, 0, '', 0, 1050, 1050, 1050, 0, NULL, NULL, NULL, NULL, NULL, 0, 126),
(143, 22, 'Vintage Special Pizza (Small)', '127', NULL, 0, NULL, NULL, 0, '', 0, 950, 950, 950, 0, NULL, NULL, NULL, NULL, NULL, 0, 127),
(144, 23, 'Tariyaki Chicken Platter', '128', NULL, 0, NULL, NULL, 0, '', 0, 435, 435, 435, 0, NULL, NULL, NULL, NULL, NULL, 0, 128),
(145, 23, 'Steam Fish Platter', '129', NULL, 0, NULL, NULL, 0, '', 0, 449, 449, 449, 0, NULL, NULL, NULL, NULL, NULL, 0, 129),
(146, 23, 'Kala Vuna Platter', '130', NULL, 0, NULL, NULL, 0, '', 0, 550, 550, 550, 0, NULL, NULL, NULL, NULL, NULL, 0, 130),
(147, 23, 'Sarlion Stake Platter', '131', NULL, 0, NULL, NULL, 0, '', 0, 1155, 1155, 1155, 0, NULL, NULL, NULL, NULL, NULL, 0, 131),
(148, 24, 'Sea Food Pasta', '132', NULL, 0, NULL, NULL, 0, '', 0, 550, 550, 550, 0, NULL, NULL, NULL, NULL, NULL, 0, 132),
(149, 24, 'Spicy Spaghetti', '133', NULL, 0, NULL, NULL, 0, '', 0, 330, 330, 330, 0, NULL, NULL, NULL, NULL, NULL, 0, 133),
(150, 25, 'Garden Fresh Salad', '134', NULL, 0, NULL, NULL, 0, '', 0, 250, 250, 250, 0, NULL, NULL, NULL, NULL, NULL, 0, 134),
(151, 25, 'Greek Salad', '135', NULL, 0, NULL, NULL, 0, '', 0, 480, 480, 480, 0, NULL, NULL, NULL, NULL, NULL, 0, 135),
(152, 25, 'Hawayain Salad', '136', NULL, 0, NULL, NULL, 0, '', 0, 320, 320, 320, 0, NULL, NULL, NULL, NULL, NULL, 0, 136),
(153, 25, 'Tariyaki Salad', '137', NULL, 0, NULL, NULL, 0, '', 0, 375, 375, 375, 0, NULL, NULL, NULL, NULL, NULL, 0, 137),
(154, 26, 'Potato Wedges (Large)', '136', NULL, 0, NULL, NULL, 0, '', 0, 250, 250, 250, 0, NULL, NULL, NULL, NULL, NULL, 0, 136),
(155, 26, 'French Fry (Large)', '137', NULL, 0, NULL, NULL, 0, '', 0, 200, 200, 200, 0, NULL, NULL, NULL, NULL, NULL, 0, 137),
(156, 26, 'Cheese Stick (6Pcs)', '138', NULL, 0, NULL, NULL, 0, '', 0, 250, 250, 250, 0, NULL, NULL, NULL, NULL, NULL, 0, 138),
(157, 26, 'Glazey Meat Stick (6Pcs)', '139', NULL, 0, NULL, NULL, 0, '', 0, 415, 415, 415, 0, NULL, NULL, NULL, NULL, NULL, 0, 139),
(158, 26, 'Beef Slider (4Pcs)', '140', NULL, 0, NULL, NULL, 0, '', 0, 550, 550, 550, 0, NULL, NULL, NULL, NULL, NULL, 0, 140),
(159, 26, 'Nectar Chicken', '141', NULL, 0, NULL, NULL, 0, '', 0, 415, 415, 415, 0, NULL, NULL, NULL, NULL, NULL, 0, 141),
(160, 14, 'Vanilla Cake (Large)', '142', NULL, 0, NULL, NULL, 1, '', 0, 1800, 1800, 1800, 0, NULL, NULL, NULL, NULL, NULL, 0, 142),
(161, 14, 'Vanilla Cake (Small)', '143', NULL, 0, NULL, NULL, 0, '', 0, 950, 950, 950, 0, NULL, NULL, NULL, NULL, NULL, 0, 143),
(162, 14, 'Chocolate Cake (Large)', '144', NULL, 0, NULL, NULL, 0, '', 0, 1900, 1900, 1900, 0, NULL, NULL, NULL, NULL, NULL, 0, 144),
(163, 14, 'Chocolate Cake (Small)', '145', NULL, 0, NULL, NULL, 0, '', 0, 1000, 1000, 1000, 0, NULL, NULL, NULL, NULL, NULL, 0, 145),
(164, 14, 'Tia Maria Cake (Large)', '146', NULL, 0, NULL, NULL, 1, '', 0, 2200, 2200, 2200, 0, NULL, NULL, NULL, NULL, NULL, 0, 146),
(165, 14, 'Tia Maria Cake (Small)', '147', NULL, 0, NULL, NULL, 0, '', 0, 1150, 1150, 1150, 0, NULL, NULL, NULL, NULL, NULL, 0, 147),
(166, 14, 'Rich Chocolate Cake (Large)', '148', NULL, 0, NULL, NULL, 0, '', 0, 2100, 2100, 2100, 0, NULL, NULL, NULL, NULL, NULL, 0, 148),
(167, 14, 'Rich Chocolate Cake (Small)', '149', NULL, 0, NULL, NULL, 0, '', 0, 1100, 1100, 1100, 0, NULL, NULL, NULL, NULL, NULL, 0, 149),
(168, 14, 'New York Cheese Cake (Large)', '150', NULL, 0, NULL, NULL, 0, '', 0, 3500, 3500, 3500, 0, NULL, NULL, NULL, NULL, NULL, 0, 150),
(169, 14, 'New York Cheese Cake (Small)', '151', NULL, 0, NULL, NULL, 0, '', 0, 1800, 1800, 1800, 0, NULL, NULL, NULL, NULL, NULL, 0, 151),
(170, 14, 'Blue Berry Cheese Cake (Large)', '152', NULL, 0, NULL, NULL, 0, '', 0, 3200, 3200, 3200, 0, NULL, NULL, NULL, NULL, NULL, 0, 152),
(171, 14, 'Blue Berry Cheese Cake (Small)', '153', NULL, 0, NULL, NULL, 0, '', 0, 1650, 1650, 1650, 0, NULL, NULL, NULL, NULL, NULL, 0, 153),
(172, 14, 'Japanese Cotton Cheese Cake (Large)', '154', NULL, 0, NULL, NULL, 0, '', 0, 3500, 3500, 3500, 0, NULL, NULL, NULL, NULL, NULL, 0, 154),
(173, 14, 'Japanese Cotton Cheese Cake (Small)', '155', NULL, 0, NULL, NULL, 0, '', 0, 1800, 1800, 1800, 0, NULL, NULL, NULL, NULL, NULL, 0, 155),
(174, 14, 'Tiramisu (Large)', '156', NULL, 0, NULL, NULL, 0, '', 0, 3200, 3200, 3200, 0, NULL, NULL, NULL, NULL, NULL, 0, 156),
(175, 14, 'Tiramisu (Small)', '157', NULL, 0, NULL, NULL, 0, '', 0, 1650, 1650, 1650, 0, NULL, NULL, NULL, NULL, NULL, 0, 157),
(176, 14, 'Strawberry Delight Cake (Large)', '158', NULL, 0, NULL, NULL, 0, '', 0, 2800, 2800, 2800, 0, NULL, NULL, NULL, NULL, NULL, 0, 158),
(177, 14, 'Strawberry Delight Cake (Small)', '159', NULL, 0, NULL, NULL, 0, '', 0, 1450, 1450, 1450, 0, NULL, NULL, NULL, NULL, NULL, 0, 159),
(178, 14, 'Mango Mousse Cake (Large)', '160', NULL, 0, NULL, NULL, 0, '', 0, 2800, 2800, 2800, 0, NULL, NULL, NULL, NULL, NULL, 0, 160),
(179, 14, 'Mango Mousse Cake (Small)', '161', NULL, 0, NULL, NULL, 0, '', 0, 1450, 1450, 1450, 0, NULL, NULL, NULL, NULL, NULL, 0, 161),
(180, 14, 'Salted Butter Scotch Cake (Large)', '162', NULL, 0, NULL, NULL, 0, '', 0, 2500, 2500, 2500, 0, NULL, NULL, NULL, NULL, NULL, 0, 162),
(181, 14, 'Salted Butter Scotch Cake (Small)', '163', NULL, 0, NULL, NULL, 0, '', 0, 1300, 1300, 1300, 0, NULL, NULL, NULL, NULL, NULL, 0, 163),
(182, 14, 'Salted Caramel Cake (Large)', '164', NULL, 0, NULL, NULL, 0, '', 0, 2300, 2300, 2300, 0, NULL, NULL, NULL, NULL, NULL, 0, 164),
(183, 14, 'Salted Caramel Cake (Small)', '165', NULL, 0, NULL, NULL, 0, '', 0, 1200, 1200, 1200, 0, NULL, NULL, NULL, NULL, NULL, 0, 165),
(184, 14, 'White & Dark Cho. Mousse Cake (Large)', '167', NULL, 0, NULL, NULL, 0, '', 0, 2800, 2800, 2800, 0, NULL, NULL, NULL, NULL, NULL, 0, 167),
(185, 14, 'White & Dark Cho. Mousse Cake (Small)', '168', NULL, 0, NULL, NULL, 0, '', 0, 1450, 1450, 1450, 0, NULL, NULL, NULL, NULL, NULL, 0, 168),
(186, 14, 'Chocolate Mud Cake (Large)', '169', NULL, 0, NULL, NULL, 0, '', 0, 2100, 2100, 2100, 0, NULL, NULL, NULL, NULL, NULL, 0, 169),
(187, 14, 'Chocolate Mud Cake (Small)', '170', NULL, 0, NULL, NULL, 0, '', 0, 1100, 1100, 1100, 0, NULL, NULL, NULL, NULL, NULL, 0, 170),
(188, 14, 'Oreo Cheese Cake (Large)', '171', NULL, 0, NULL, NULL, 0, '', 0, 2800, 2800, 2800, 0, NULL, NULL, NULL, NULL, NULL, 0, 171),
(189, 14, 'Oreo Cheese Cake (Small)', '172', NULL, 0, NULL, NULL, 0, '', 0, 1450, 1450, 1450, 0, NULL, NULL, NULL, NULL, NULL, 0, 172),
(190, 14, 'Black Forest Cake (Large)', '008', NULL, 0, NULL, NULL, 0, '', 0, 2000, 2000, 2000, 0, NULL, NULL, NULL, NULL, NULL, 0, 1),
(191, 14, 'Black Forest Cake (Small)', '009', NULL, 0, NULL, NULL, 0, '', 0, 1050, 1050, 1050, 0, NULL, NULL, NULL, NULL, NULL, 0, 1),
(192, 15, 'Oreo Cheese Cake Slice', '010', NULL, 0, NULL, NULL, 0, '', 0, 280, 280, 280, 0, NULL, NULL, NULL, NULL, NULL, 0, 1),
(193, 27, 'Mineral Water (500ml)', '008', NULL, 0, NULL, NULL, 1, '', 0, 15, 15, 15, 0, NULL, NULL, NULL, NULL, NULL, 0, 1),
(194, 12, 'Butter Cookies (250g)', '142', NULL, 0, NULL, NULL, 0, '', 0, 298, 298, 298, 0, NULL, NULL, NULL, NULL, NULL, 0, 142),
(195, 12, 'Lite Chocolate Cookies (250g)', '143', NULL, 0, NULL, NULL, 0, '', 0, 314, 314, 314, 0, NULL, NULL, NULL, NULL, NULL, 0, 143),
(196, 12, 'Nut Griba (250g)', '144', NULL, 0, NULL, NULL, 0, '', 0, 423, 423, 423, 0, NULL, NULL, NULL, NULL, NULL, 0, 144),
(197, 12, 'Peanut Butter Cookies (250g)', '145', NULL, 0, NULL, NULL, 0, '', 0, 298, 298, 298, 0, NULL, NULL, NULL, NULL, NULL, 0, 145),
(198, 12, 'Dry Cake (300g)', '146', NULL, 0, NULL, NULL, 0, '', 0, 303, 303, 303, 0, NULL, NULL, NULL, NULL, NULL, 0, 146),
(199, 12, 'Chocolate Dry Cake (300g)', '147', NULL, 0, NULL, NULL, 0, '', 0, 333, 333, 333, 0, NULL, NULL, NULL, NULL, NULL, 0, 147),
(200, 12, 'Plain Toast (250g)', '148', NULL, 0, NULL, NULL, 0, '', 0, 113, 113, 113, 0, NULL, NULL, NULL, NULL, NULL, 0, 148),
(201, 12, 'Almond Nut Chocolate (250g)', '149', NULL, 0, NULL, NULL, 0, '', 0, 423, 423, 423, 0, NULL, NULL, NULL, NULL, NULL, 0, 149),
(202, 12, 'Spice Cheese Straw (100g)', '150', NULL, 0, NULL, NULL, 0, '', 0, 160, 160, 160, 0, NULL, NULL, NULL, NULL, NULL, 0, 150),
(203, 12, 'Sugar Puff (100g)', '151', NULL, 0, NULL, NULL, 0, '', 0, 130, 130, 130, 0, NULL, NULL, NULL, NULL, NULL, 0, 151),
(204, 12, 'Sea Salt Straw (100g)', '152', NULL, 0, NULL, NULL, 0, '', 0, 130, 130, 130, 0, NULL, NULL, NULL, NULL, NULL, 0, 152),
(205, 12, 'Double Chocolate Tart Slice', '153', NULL, 0, NULL, NULL, 0, '', 0, 200, 200, 200, 0, NULL, NULL, NULL, NULL, NULL, 0, 153),
(206, 12, 'Lemon mango Tart Slice', '154', NULL, 0, NULL, NULL, 0, '', 0, 150, 150, 150, 0, NULL, NULL, NULL, NULL, NULL, 0, 154),
(207, 12, 'Royal Peanut chocolate Tart', '155', NULL, 0, NULL, NULL, 0, '', 0, 200, 200, 200, 0, NULL, NULL, NULL, NULL, NULL, 0, 155),
(208, 17, 'Panna Cotta', '156', NULL, 0, NULL, NULL, 0, '', 0, 280, 280, 280, 0, NULL, NULL, NULL, NULL, NULL, 0, 156),
(209, 18, 'Pandesal Breads (Big)', '157', NULL, 0, NULL, NULL, 0, '', 0, 135, 135, 135, 0, NULL, NULL, NULL, NULL, NULL, 0, 157),
(210, 18, 'Pandesal Breads (Small)', '158', NULL, 0, NULL, NULL, 0, '', 0, 70, 70, 70, 0, NULL, NULL, NULL, NULL, NULL, 0, 158),
(211, 18, 'Milk Bread (Small)', '159', NULL, 0, NULL, NULL, 0, '', 0, 70, 70, 70, 0, NULL, NULL, NULL, NULL, NULL, 0, 159),
(212, 13, 'Spicy Cheese Straw (100gm)', '160', NULL, 0, NULL, NULL, 0, '', 0, 160, 160, 160, 0, NULL, NULL, NULL, NULL, NULL, 0, 160),
(213, 18, 'Milk Bread (Big)', '161', NULL, 0, NULL, NULL, 0, '', 0, 135, 135, 135, 0, NULL, NULL, NULL, NULL, NULL, 0, 161),
(214, 6, 'Coffee 005', '005', NULL, 1, 'All', NULL, 2, '', 65, 65, 90, 80, 0, NULL, NULL, NULL, NULL, NULL, 0, 1),
(216, 6, 'Pro - 00', '0123', 'assets/uploads/product_images/20210322111917.png', 0, 'All', '2', 0, '', 50, 100, 70, 80, 0, NULL, NULL, NULL, NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `batch_no` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `total_item` int(11) DEFAULT NULL,
  `total_qty` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `create_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_product_list`
--

CREATE TABLE `production_product_list` (
  `id` int(11) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_receive`
--

CREATE TABLE `product_receive` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_receive_challan_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `product_receive_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `product_source` varchar(500) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `total_price` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_receive_challan`
--

CREATE TABLE `product_receive_challan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `challan_number` varchar(100) NOT NULL,
  `product_receive_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_item` int(11) DEFAULT 0,
  `total_qty` double DEFAULT 0,
  `remarks` varchar(500) NOT NULL,
  `status` tinyint(4) DEFAULT 0,
  `create_time` datetime DEFAULT NULL,
  `total_amount` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_reorder_level`
--

CREATE TABLE `product_reorder_level` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `reorder_level` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_return`
--

CREATE TABLE `product_return` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_return_challan_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `product_return_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `product_source` varchar(500) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `total_price` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_return_challan`
--

CREATE TABLE `product_return_challan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `challan_number` varchar(100) NOT NULL,
  `product_return_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_item` int(11) DEFAULT 0,
  `total_qty` double DEFAULT 0,
  `remarks` varchar(500) NOT NULL,
  `status` tinyint(4) DEFAULT 0,
  `create_time` datetime DEFAULT NULL,
  `total_amount` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_store`
--

CREATE TABLE `product_store` (
  `id` int(11) NOT NULL,
  `product_store_date` timestamp NULL DEFAULT current_timestamp(),
  `product_id` int(11) DEFAULT NULL,
  `open_stock` double NOT NULL DEFAULT 0 COMMENT '+',
  `receive_stock` double NOT NULL DEFAULT 0 COMMENT '+',
  `return_from_branch` double NOT NULL DEFAULT 0 COMMENT '+',
  `return_from_hot_kitchen` double NOT NULL DEFAULT 0 COMMENT '+',
  `transfer_stock` double NOT NULL DEFAULT 0 COMMENT '-',
  `sale_from_stock` double NOT NULL DEFAULT 0 COMMENT '-',
  `damage_stock` double NOT NULL DEFAULT 0 COMMENT '-',
  `return_to_supplier` double NOT NULL DEFAULT 0 COMMENT '-',
  `closing_stock` double NOT NULL DEFAULT 0 COMMENT '='
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_store`
--

INSERT INTO `product_store` (`id`, `product_store_date`, `product_id`, `open_stock`, `receive_stock`, `return_from_branch`, `return_from_hot_kitchen`, `transfer_stock`, `sale_from_stock`, `damage_stock`, `return_to_supplier`, `closing_stock`) VALUES
(1, '2020-12-17 20:25:09', 9, 0, 90, 0, 0, 0, 0, 0, 0, 90),
(2, '2020-12-17 20:25:09', 10, 0, 90, 0, 0, 0, 0, 0, 0, 90),
(3, '2020-12-17 20:25:09', 11, 0, 90, 0, 0, 0, 0, 0, 0, 90),
(4, '2020-12-18 20:41:01', 9, 30, 12, 0, 0, 0, 0, 0, 0, 42),
(5, '2020-12-18 20:41:01', 10, 30, 12, 0, 0, 0, 0, 0, 0, 42),
(6, '2020-12-18 20:41:01', 11, 30, 12, 0, 0, 0, 0, 0, 0, 42),
(7, '2020-12-19 20:51:46', 9, 42, 10, 0, 0, 0, 1, 0, 0, 51),
(8, '2020-12-19 20:51:46', 10, 42, 10, 0, 0, 0, 1, 0, 0, 51),
(9, '2020-12-19 20:51:46', 11, 42, 10, 0, 0, 0, 1, 0, 0, 51),
(10, '2020-12-17 21:04:04', 12, 0, 50, 0, 0, 0, 0, 0, 0, 50),
(11, '2020-12-17 21:04:04', 13, 0, 50, 0, 0, 0, 0, 0, 0, 50),
(12, '2020-12-17 21:04:04', 14, 0, 50, 0, 0, 0, 0, 0, 0, 50),
(13, '2020-12-18 21:08:26', 15, 0, 50, 0, 0, 0, 0, 0, 0, 50),
(14, '2020-12-18 21:08:26', 16, 0, 50, 0, 0, 0, 0, 0, 0, 50),
(15, '2020-12-18 21:08:26', 17, 0, 50, 0, 0, 0, 0, 0, 0, 50),
(16, '2020-12-18 21:08:26', 18, 0, 50, 0, 0, 0, 0, 0, 0, 50),
(17, '2020-12-18 21:08:26', 19, 0, 50, 0, 0, 0, 0, 0, 0, 50),
(18, '2020-12-18 21:08:26', 214, 0, 50, 0, 0, 0, 0, 0, 0, 50),
(19, '2020-12-09 23:23:29', 9, 0, 30, 0, 0, 0, 0, 0, 0, 30),
(20, '2020-12-09 23:23:29', 10, 0, 30, 0, 0, 0, 0, 0, 0, 30),
(21, '2020-12-09 23:23:29', 11, 0, 30, 0, 0, 0, 0, 0, 0, 30),
(22, '2020-12-10 23:25:58', 9, 30, 5, 0, 0, 0, 0, 0, 0, 35),
(23, '2020-12-10 23:25:59', 10, 30, 5, 0, 0, 0, 0, 0, 0, 35),
(24, '2020-12-10 23:25:59', 11, 30, 5, 0, 0, 0, 0, 0, 0, 35),
(25, '2020-12-11 23:30:24', 9, 35, 5, 0, 0, 0, 0, 0, 0, 40),
(26, '2020-12-11 23:30:24', 10, 35, 5, 0, 0, 0, 0, 0, 0, 40),
(27, '2020-12-11 23:30:24', 11, 35, 5, 0, 0, 0, 0, 0, 0, 40),
(28, '2020-12-13 23:38:06', 9, 40, 12, 0, 0, 0, 0, 0, 0, 52),
(29, '2020-12-13 23:38:06', 10, 40, 12, 0, 0, 0, 0, 0, 0, 52),
(30, '2020-12-13 23:38:06', 11, 40, 12, 0, 0, 0, 0, 0, 0, 52),
(31, '2020-12-16 23:51:55', 9, 52, 5, 0, 0, 0, 0, 0, 0, 57),
(32, '2020-12-16 23:51:55', 10, 52, 5, 0, 0, 0, 0, 0, 0, 57),
(33, '2020-12-16 23:51:55', 11, 52, 5, 0, 0, 0, 0, 0, 0, 57),
(34, '2020-12-20 19:53:21', 9, 56, 0, 0, 0, 0, 11, 0, 0, 45),
(35, '2020-12-21 01:30:21', 10, 56, 0, 0, 0, 0, 20, 0, 0, 36),
(36, '2020-12-21 01:34:16', 12, 50, 0, 0, 0, 0, 4, 0, 0, 46),
(37, '2020-12-21 22:08:48', 10, 36, 0, 0, 0, 0, 5, 0, 0, 31),
(38, '2020-12-21 22:14:54', 12, 46, 0, 0, 0, 0, 5, 0, 0, 41),
(39, '2020-12-21 22:21:13', 13, 50, 0, 0, 0, 0, 3, 0, 0, 47),
(40, '2020-12-23 06:27:01', 9, 45, 0, 0, 0, 0, 2, 0, 0, 43),
(41, '2020-12-23 06:27:01', 10, 31, 0, 0, 0, 0, 5, 0, 0, 26),
(42, '2020-12-23 06:29:17', 11, 56, 0, 0, 0, 0, 3, 0, 0, 53),
(43, '2020-12-26 18:00:00', 9, 43, 1, 0, 0, 0, 0, 0, 0, 44),
(44, '2020-12-26 18:00:00', 10, 26, 2, 0, 0, 0, 0, 0, 0, 28),
(45, '2020-12-26 18:00:00', 214, 50, 3, 0, 0, 0, 0, 0, 0, 53),
(46, '2020-12-26 18:00:00', 11, 53, 2, 0, 0, 0, 0, 0, 0, 55),
(47, '2020-12-25 18:00:00', 9, 43, 1, 0, 0, 0, 0, 0, 0, 44),
(48, '2020-12-24 18:00:00', 9, 44, 1, 0, 0, 0, 0, 0, 0, 45),
(49, '2020-12-24 18:00:00', 10, 26, 1, 0, 0, 0, 0, 0, 0, 27),
(50, '2020-12-23 18:00:00', 9, 45, 1, 0, 0, 0, 0, 0, 0, 46),
(51, '2020-12-23 18:00:00', 10, 27, 1, 0, 0, 0, 0, 0, 0, 28),
(52, '2020-12-22 18:00:00', 9, 46, 1, 0, 0, 0, 0, 0, 0, 47),
(53, '2020-12-22 18:00:00', 10, 28, 1, 0, 0, 0, 0, 0, 0, 29),
(54, '2020-12-22 18:00:00', 11, 53, 1, 0, 0, 0, 0, 0, 0, 54),
(55, '2020-12-28 20:51:47', 9, 4, 0, 0, 0, 0, 1, 0, 0, 3),
(56, '2020-12-28 20:51:47', 10, 4, 0, 0, 0, 0, 1, 0, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `id` int(11) NOT NULL,
  `printer_id` int(11) DEFAULT NULL,
  `product_type_name` varchar(255) NOT NULL,
  `food_type` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `button_color` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`id`, `printer_id`, `product_type_name`, `food_type`, `image`, `availability`, `button_color`, `sort_order`, `status`) VALUES
(6, 1, 'HOT COFFEE', 'Non-Food', 'assets/uploads/category_images/20210322133557.png', 'All', '#a23d3d', 1, 1),
(7, 1, 'ICE COFFEE', 'Non-Food', NULL, NULL, '#2b1a2f', 2, 1),
(8, 1, 'CHILLER', 'Non-Food', NULL, NULL, '#885fc5', 3, 1),
(9, 1, 'MOCKTAIL', 'Non-Food', NULL, NULL, '#4c42a4', 4, 1),
(10, 1, 'SODA', 'Non-Food', NULL, NULL, '#3db38b', 5, 1),
(11, 1, 'CUP CAKE', 'Food', NULL, NULL, '#6f3f92', 6, 1),
(12, 1, 'COOKIES', 'Food', NULL, NULL, '#bb7945', 7, 1),
(13, 1, 'PUFF PASTRY', 'Food', NULL, NULL, '#b95836', 8, 1),
(14, 1, 'BIRTHDAY CAKE', 'Food', NULL, NULL, '#46ae2f', 9, 1),
(15, 1, 'PASTRY SLICE', 'Food', NULL, NULL, '#2aa4a7', 10, 1),
(16, 1, 'TART & PIE', 'Food', NULL, NULL, '#35bcd2', 11, 1),
(17, 1, 'SIDE ITEMS', 'Food', NULL, NULL, '#3c569f', 12, 1),
(18, 1, 'BREAD & BUNS', 'Food', NULL, NULL, '#b937a9', 13, 1),
(19, 1, 'CROISSANT & DANISH', 'Food', NULL, NULL, '#a439d2', 14, 1),
(20, 1, 'BURGER & SANDWICH', 'Food', 'assets/uploads/category_images/20210322145337.jpg', 'All', '#107a95', 15, 1),
(21, 1, 'WRAP', 'Food', NULL, NULL, '#1a36e9', 16, 1),
(22, 1, 'PIZZA', 'Food', NULL, NULL, '#b0ca28', 17, 1),
(23, 1, 'SET MENU & PLATTER', 'Food', NULL, NULL, '#25e926', 18, 1),
(24, 1, 'PASTA', 'Food', NULL, NULL, '#228b1c', 19, 1),
(25, 1, 'SALAD', 'Food', NULL, NULL, '#23daf8', 20, 1),
(26, 1, 'SIDES', 'Food', NULL, NULL, '#23349a', 21, 1),
(27, 0, 'Mineral Water', 'Food', NULL, NULL, '#000000', 1, 1),
(28, 1, 'Cat - 00', 'Food', 'assets/uploads/category_images/20210322133222.jpg', 'All', '#2919b3', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchased_product`
--

CREATE TABLE `purchased_product` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_qty` int(11) DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchased_product`
--

INSERT INTO `purchased_product` (`id`, `user_id`, `supplier_id`, `date`, `total_qty`, `total_amount`, `payment_mode`, `paid_amount`, `due_amount`, `remarks`, `status`) VALUES
(1, 24, 1, '2020-12-09 23:23:28', 90, 4800, 'Cash', 1800, 3000, 'r-001', 1),
(2, 24, 1, '2020-12-10 23:25:58', 15, 900, 'Cash', 400, 500, 'r-002', 1),
(3, 24, 1, '2020-12-11 23:30:24', 15, 900, 'Cash', 400, 500, 'br-003', 1),
(4, 24, 1, '2020-12-13 23:38:06', 18, 1130, 'Cash', 630, 500, 'br-004', 1),
(5, 24, 1, '2020-12-13 23:42:06', 18, 1080, 'Cash', 0, 1080, 'br-005', 1),
(6, 24, 1, '2020-12-16 23:51:55', 15, 900, 'Cash', 80, 820, 'br-006', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchased_product_list`
--

CREATE TABLE `purchased_product_list` (
  `id` int(11) NOT NULL,
  `purchased_product_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchased_product_list`
--

INSERT INTO `purchased_product_list` (`id`, `purchased_product_id`, `product_id`, `rate`, `qty`, `amount`) VALUES
(1, 1, 9, 50, 30, 1500),
(2, 1, 10, 53.33, 30, 1600),
(3, 1, 11, 56.67, 30, 1700),
(4, 2, 9, 50, 5, 250),
(5, 2, 10, 60, 5, 300),
(6, 2, 11, 70, 5, 350),
(7, 3, 9, 50, 5, 250),
(8, 3, 10, 60, 5, 300),
(9, 3, 11, 70, 5, 350),
(10, 4, 9, 50, 6, 300),
(11, 4, 10, 58.33, 6, 350),
(12, 4, 11, 80, 6, 480),
(13, 5, 9, 50, 6, 300),
(14, 5, 10, 60, 6, 360),
(15, 5, 11, 70, 6, 420),
(16, 6, 9, 50, 5, 250),
(17, 6, 10, 60, 5, 300),
(18, 6, 11, 70, 5, 350);

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_product_id` int(11) DEFAULT NULL,
  `child_product_id` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `remove_head`
--

CREATE TABLE `remove_head` (
  `id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_for_discount`
--

CREATE TABLE `request_for_discount` (
  `id` int(11) NOT NULL,
  `token_number` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `token_key` varchar(255) DEFAULT NULL,
  `approved_discount` double DEFAULT NULL,
  `approved_by` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_for_discount`
--

INSERT INTO `request_for_discount` (`id`, `token_number`, `branch_id`, `discount`, `reason`, `token_key`, `approved_discount`, `approved_by`, `status`) VALUES
(1, 'TN-201214-00004', 1, 15, NULL, 'd4sNtrNyQIWmiGWF5fA6JnLp5', 0, 0, 0),
(9, 'TN-201215-00001', 1, 20, NULL, 'TVCEYppBoa5p8LnrEiuwUn8Zn', 0, 0, 2),
(10, 'TN-201215-00001', 1, 20, 'Reason 01', 'ik8kmP3kjUV099sIjEThNZV34', 0, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `return_product_details`
--

CREATE TABLE `return_product_details` (
  `id` bigint(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `packsize` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchase_price` double NOT NULL,
  `return_product_info_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `return_product_info`
--

CREATE TABLE `return_product_info` (
  `id` bigint(20) NOT NULL,
  `from_branch_id` int(11) NOT NULL,
  `to_branch_id` int(11) NOT NULL,
  `return_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `salary_details`
--

CREATE TABLE `salary_details` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `basic_salary` double NOT NULL,
  `phone_allowance` double NOT NULL,
  `tuition_allowance` double NOT NULL,
  `attendance_allowance` double NOT NULL,
  `bonus` double NOT NULL,
  `others` double NOT NULL,
  `gross_salary` double NOT NULL,
  `pf_contribution` double NOT NULL,
  `loan_installment` double NOT NULL,
  `net_salary` double NOT NULL,
  `month` varchar(500) NOT NULL,
  `year` varchar(500) NOT NULL,
  `employee_benefit` double DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `others_benefit` double NOT NULL DEFAULT 0,
  `less_others_benefit` double NOT NULL DEFAULT 0,
  `less_others_misc` double NOT NULL DEFAULT 0,
  `take_home_salary` double NOT NULL DEFAULT 0,
  `current_date_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_product`
--

CREATE TABLE `sale_product` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `delivery_status` tinyint(4) NOT NULL DEFAULT 0,
  `pack_size` varchar(500) DEFAULT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `discount_rate` double NOT NULL DEFAULT 0,
  `discount_amount` double NOT NULL DEFAULT 0,
  `sales_price_excluding_vat` double NOT NULL DEFAULT 0,
  `vat` double NOT NULL DEFAULT 0,
  `sales_price_including_vat` double NOT NULL DEFAULT 0,
  `gate_pass_remarks` varchar(5000) NOT NULL,
  `item_note` text DEFAULT NULL,
  `purchase_price` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_product`
--

INSERT INTO `sale_product` (`id`, `invoice_id`, `product_id`, `branch_id`, `delivery_status`, `pack_size`, `quantity`, `unit_price`, `discount_rate`, `discount_amount`, `sales_price_excluding_vat`, `vat`, `sales_price_including_vat`, `gate_pass_remarks`, `item_note`, `purchase_price`) VALUES
(59, 52, 10, 0, 0, NULL, 1, 150, 0, 0, 150, 0, 0, '', '', 0),
(60, 53, 13, 0, 0, NULL, 1, 250, 0, 0, 250, 0, 0, '', '', 0),
(61, 54, 12, 0, 0, NULL, 1, 200, 0, 0, 200, 0, 0, '', '', 0),
(62, 55, 12, 0, 0, NULL, 1, 200, 0, 0, 200, 0, 0, '', '', 0),
(63, 56, 9, 0, 0, NULL, 2, 100, 0, 0, 200, 0, 0, '', '', 0),
(64, 56, 10, 0, 0, NULL, 2, 150, 0, 0, 300, 0, 0, '', '', 0),
(65, 57, 11, 0, 0, NULL, 2, 150, 0, 0, 300, 0, 0, '', '', 0),
(66, 58, 10, 0, 0, NULL, 3, 150, 0, 0, 450, 0, 0, '', '', 0),
(67, 58, 11, 0, 0, NULL, 1, 150, 0, 0, 150, 0, 0, '', '', 0),
(68, 59, 9, 0, 0, NULL, 1, 100, 0, 0, 100, 0, 0, '', '', 0),
(69, 59, 10, 0, 0, NULL, 1, 150, 0, 0, 150, 0, 0, '', '', 0),
(70, 60, 9, 0, 0, NULL, 2, 100, 0, 0, 200, 0, 0, '', '', 0),
(71, 60, 10, 0, 0, NULL, 2, 150, 0, 0, 300, 0, 0, '', '', 0),
(72, 61, 9, 0, 0, NULL, 2, 100, 0, 0, 200, 0, 0, '', '', 0),
(73, 62, 9, 0, 0, NULL, 1, 100, 0, 0, 100, 0, 0, '', '', 0),
(74, 62, 10, 0, 0, NULL, 1, 150, 0, 0, 150, 0, 0, '', '', 0),
(81, 66, 9, 0, 0, NULL, 1, 100, 0, 0, 100, 0, 0, '', '', 0),
(82, 66, 10, 0, 0, NULL, 1, 150, 0, 0, 150, 0, 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

CREATE TABLE `stock_transfer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stock_transfer_challan_id` int(11) NOT NULL,
  `from_branch_id` int(11) NOT NULL,
  `to_branch_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date_of_transfer` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `transfer_reason` varchar(500) NOT NULL,
  `product_source` varchar(500) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `total_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_transfer`
--

INSERT INTO `stock_transfer` (`id`, `user_id`, `stock_transfer_challan_id`, `from_branch_id`, `to_branch_id`, `product_id`, `date_of_transfer`, `quantity`, `transfer_reason`, `product_source`, `status`, `total_price`) VALUES
(1, 24, 1, 2, 7, 9, '2020-12-29 00:18:30', 1, 'ukjhkj', 'factory', 0, 0),
(6, 24, 6, 1, 3, 10, '2020-12-28 23:34:56', 1, 'Test Product Transfer', 'factory', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_challan`
--

CREATE TABLE `stock_transfer_challan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `from_branch_id` int(11) NOT NULL,
  `to_branch_id` int(11) NOT NULL,
  `challan_number` varchar(100) DEFAULT NULL,
  `transfer_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_item` int(11) NOT NULL DEFAULT 0,
  `total_qty` double NOT NULL DEFAULT 0,
  `reason` varchar(500) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `total_amount` double NOT NULL,
  `create_time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_transfer_challan`
--

INSERT INTO `stock_transfer_challan` (`id`, `user_id`, `from_branch_id`, `to_branch_id`, `challan_number`, `transfer_date`, `total_item`, `total_qty`, `reason`, `status`, `total_amount`, `create_time`) VALUES
(1, 24, 2, 7, 'ggg', '2020-12-29 00:18:30', 1, 1, 'ukjhkj', 0, 0, '2020-12-28 06:18:30'),
(6, 24, 1, 3, 'ch-0258', '2020-12-28 23:34:56', 1, 1, 'Test Product Transfer', 0, 0, '2020-12-29 05:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `vat_id` varchar(255) DEFAULT NULL,
  `supplier_contact_number` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `contact_person_contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `advanced_amount` double NOT NULL DEFAULT 0,
  `paid_amount` double NOT NULL DEFAULT 0,
  `due_amount` double NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `user_id`, `name`, `vat_id`, `supplier_contact_number`, `contact_person_name`, `contact_person_contact_number`, `email`, `address`, `remarks`, `advanced_amount`, `paid_amount`, `due_amount`, `status`) VALUES
(1, 24, 'Supplier A', 'vat-001248', '01317243494', 'Jaman', '01713243494', 'suppliera@gmail.com', 'Dhaka', 'Dhaka', 0, 9310, 400, 1),
(2, 24, 'Supplier B', 'vat-0012413', '01317243595', 'Simul', '01717243694', 'supplierb@gmail.com', 'Dhaka', 'Dhaka', 0, 0, 0, 1),
(3, 24, 'Supplier C', 'vat-124578', '01817333444', 'Hamid', '01619243594', 'supplierc@gmail.com', 'Dhaka', 'Dhaka', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payment`
--

CREATE TABLE `supplier_payment` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `purchased_product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `money_receipt_no` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 for due, 2 for advance',
  `previous_amount` double NOT NULL DEFAULT 0 COMMENT 'as opening_balance',
  `purchase_amount` double NOT NULL DEFAULT 0,
  `paid_amount` double NOT NULL DEFAULT 0,
  `advanced_amount` double NOT NULL DEFAULT 0,
  `due_amount` double NOT NULL DEFAULT 0,
  `money_receipt_image` text DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier_payment`
--

INSERT INTO `supplier_payment` (`id`, `supplier_id`, `purchased_product_id`, `user_id`, `date`, `money_receipt_no`, `payment_mode`, `status`, `previous_amount`, `purchase_amount`, `paid_amount`, `advanced_amount`, `due_amount`, `money_receipt_image`, `remarks`) VALUES
(1, 1, 1, 24, '2020-12-09 23:23:28', 'b-001', 'Cash', 1, 0, 4800, 1800, 0, 3000, '', 'r-001'),
(2, 1, 2, 24, '2020-12-10 23:25:58', 'b-002', 'Cash', 1, 3000, 900, 400, 0, 3500, '', 'r-002'),
(3, 1, NULL, 24, '2020-12-11 23:27:42', 'mr-001', 'Cash', 1, 3500, 0, 1500, 0, 2000, '', 'r-001'),
(4, 1, 3, 24, '2020-12-11 23:30:24', 'b-003', 'Cash', 1, 2000, 900, 400, 0, 2500, '', 'br-003'),
(5, 1, NULL, 24, '2020-12-12 23:32:25', 'mr-002', 'Cash', 1, 2500, 0, 2500, 0, 0, '', 'mr-002'),
(6, 1, 4, 24, '2020-12-13 23:38:06', 'b-004', 'Cash', 1, 0, 1130, 630, 0, 500, '', 'br-004'),
(7, 1, NULL, 24, '2020-12-14 23:39:16', 'mr-003', 'Cash', 1, 500, 0, 1000, 500, 0, '', 'mr-003'),
(8, 1, 5, 24, '2020-12-13 23:42:06', 'b-005', 'Cash', 2, 500, 1080, 0, 0, 580, '', 'br-005'),
(9, 1, NULL, 24, '2020-12-15 23:49:56', 'mr-004', 'Cash', 1, 580, 0, 1000, 420, 0, '', 'mr-004'),
(10, 1, 6, 24, '2020-12-16 23:51:55', 'b-006', 'Cash', 2, 420, 900, 80, 0, 400, '', 'br-006');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `table_number` varchar(255) NOT NULL,
  `table_capacity` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 for unbooked; 1 for booked'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `branch_id`, `table_number`, `table_capacity`, `status`) VALUES
(1, 1, '01', 6, 0),
(3, 3, '01', 5, 0),
(5, 1, '02', 6, 1),
(6, 4, '01', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `unit_id`, `name`, `status`) VALUES
(1, 1, 'KG', 1),
(2, 2, 'Litre', 1),
(3, 3, 'Pcs', 1),
(4, 4, 'Litre', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `menu_permission` text NOT NULL,
  `name` varchar(500) NOT NULL,
  `user_name` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `user_type` varchar(500) NOT NULL,
  `outlet` varchar(255) DEFAULT NULL,
  `email` varchar(500) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `employee_id` int(11) NOT NULL DEFAULT 0,
  `hr_access` tinyint(1) NOT NULL DEFAULT 0,
  `accounts_access` tinyint(1) NOT NULL DEFAULT 0,
  `sales_access` tinyint(1) NOT NULL DEFAULT 0,
  `settings_access` tinyint(1) NOT NULL DEFAULT 0,
  `user_access` tinyint(1) NOT NULL DEFAULT 0,
  `accounts_report_access` tinyint(1) NOT NULL DEFAULT 0,
  `hr_report_access` tinyint(1) NOT NULL DEFAULT 0,
  `sales_report_access` tinyint(1) NOT NULL DEFAULT 0,
  `product_report_access` tinyint(1) NOT NULL DEFAULT 0,
  `money_receipt_report_access` tinyint(1) NOT NULL DEFAULT 0,
  `print_access` tinyint(1) NOT NULL DEFAULT 0,
  `product_access` tinyint(1) NOT NULL DEFAULT 0,
  `client_access` tinyint(1) NOT NULL DEFAULT 0,
  `lock_access` tinyint(1) NOT NULL DEFAULT 0,
  `edit_mr_access` tinyint(1) NOT NULL DEFAULT 0,
  `edit_invoice_access` tinyint(1) NOT NULL DEFAULT 0,
  `order_sheet_access` tinyint(1) NOT NULL DEFAULT 0,
  `kitchen_room_access` tinyint(1) NOT NULL DEFAULT 0,
  `invoice_discount_access` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `menu_permission`, `name`, `user_name`, `password`, `user_type`, `outlet`, `email`, `mobile`, `address`, `employee_id`, `hr_access`, `accounts_access`, `sales_access`, `settings_access`, `user_access`, `accounts_report_access`, `hr_report_access`, `sales_report_access`, `product_report_access`, `money_receipt_report_access`, `print_access`, `product_access`, `client_access`, `lock_access`, `edit_mr_access`, `edit_invoice_access`, `order_sheet_access`, `kitchen_room_access`, `invoice_discount_access`) VALUES
(24, '1,2,12,13,14,15,16,17,18,19,20,21,22,3,23,24,25,26,27,28,29,30,31,32,33,34,72,5,6', 'Admin', 'admin', '8cb2237d0679ca88db6464eac60da96345513964', 'admin', 'all', 'admin@gmail.com', '01936011154', 'dhaka-1200', 6, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0, 1, 1, 1, 0, 1, 0, 1, 1),
(25, '', 'Dew Hunt', 'dew', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Sales Person', '1', 'dew.fog1553@gmail.com', '01317243494', 'House - 04, Lane - 04, Road - 12, Block - B, Section - 11, Mirpur Dhaka - 1216', 7, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(26, '', 'Himel', 'himel', '8cb2237d0679ca88db6464eac60da96345513964', 'Sales Person', '1,2', 'himel@gmail.com', '01317243494', 'Dhaka', 8, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(27, '', 'Asif', 'asif', '8cb2237d0679ca88db6464eac60da96345513964', 'Manager', '11,2', 'asif@gmail.com', '01647548932', 'Mirpur', 9, 1, 0, 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `user_type` varchar(500) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `user_type`, `status`) VALUES
(1, 'admin', 1),
(2, 'hr', 1),
(3, 'accounts', 0),
(4, 'marketing', 0),
(5, 'technical', 0),
(6, 'branding', 0),
(7, 'logistics', 0),
(8, 'operational executive', 0),
(9, 'Manager', 1),
(10, 'Sales Person', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_order_summary`
-- (See below for the actual view)
--
CREATE TABLE `view_order_summary` (
`id` int(11)
,`order_date` timestamp
,`totalOrder` bigint(21)
,`branch_id` int(11)
,`user_id` int(11)
,`branchName` varchar(500)
,`subTotal` double
,`vatTotal` double
,`discountAmount` double
,`payableAmount` double
,`cashPayment` double
,`cardPayment` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_order_summary_product`
-- (See below for the actual view)
--
CREATE TABLE `view_order_summary_product` (
`id` int(11)
,`order_date` timestamp
,`product_id` int(11)
,`productName` varchar(500)
,`branchId` int(11)
,`branchName` varchar(500)
,`quantity` double
,`unit_price` double
,`discount_amount` double
,`sales_price_excluding_vat` double
,`vat` double
,`sales_price_including_vat` double
);

-- --------------------------------------------------------

--
-- Table structure for table `voucher_details`
--

CREATE TABLE `voucher_details` (
  `id` int(11) NOT NULL,
  `income_head_id` int(11) NOT NULL,
  `expense_head_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `mr_number` varchar(100) NOT NULL,
  `client_id` int(11) DEFAULT 0,
  `employee_id` int(11) DEFAULT 0,
  `month` varchar(20) NOT NULL,
  `year` varchar(20) NOT NULL,
  `narration` varchar(500) NOT NULL,
  `debit_amount` double NOT NULL,
  `credit_amount` double NOT NULL,
  `opening_balance` double NOT NULL DEFAULT 0,
  `closing_balance` double NOT NULL DEFAULT 0,
  `voucher_posting_details_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_posting_details`
--

CREATE TABLE `voucher_posting_details` (
  `id` int(11) NOT NULL,
  `posting_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `voucher_number` varchar(100) NOT NULL,
  `total_debit_amount` double NOT NULL,
  `total_credit_amount` double NOT NULL,
  `common_narration` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warning_letter`
--

CREATE TABLE `warning_letter` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `warning_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `warning_type_id` int(11) NOT NULL,
  `warning_details` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `current_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `warning_type`
--

CREATE TABLE `warning_type` (
  `id` int(11) NOT NULL,
  `warning_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `weekend_settings`
--

CREATE TABLE `weekend_settings` (
  `id` int(11) NOT NULL,
  `weekend_day` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yearend_head_assign`
--

CREATE TABLE `yearend_head_assign` (
  `id` int(11) NOT NULL,
  `opening_head_id` int(11) NOT NULL,
  `closing_head_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `view_order_summary`
--
DROP TABLE IF EXISTS `view_order_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_order_summary`  AS SELECT `invoice_details`.`id` AS `id`, `invoice_details`.`order_date` AS `order_date`, count(`invoice_details`.`branch_id`) AS `totalOrder`, `invoice_details`.`branch_id` AS `branch_id`, `invoice_details`.`user_id` AS `user_id`, `branch_info`.`branch_name` AS `branchName`, sum(`invoice_details`.`gross_payable`) AS `subTotal`, sum(`invoice_details`.`total_vat`) AS `vatTotal`, sum(`invoice_details`.`deduction`) AS `discountAmount`, sum(`invoice_details`.`amount_to_paid`) AS `payableAmount`, sum(`invoice_details`.`cash_payment`) AS `cashPayment`, sum(`invoice_details`.`card_payment`) AS `cardPayment` FROM (`invoice_details` left join `branch_info` on(`branch_info`.`id` = `invoice_details`.`branch_id`)) WHERE `invoice_details`.`mode_of_payment` <> 'pending' GROUP BY date_format(`invoice_details`.`order_date`,'%Y-%M-%d'), `invoice_details`.`branch_id` ;

-- --------------------------------------------------------

--
-- Structure for view `view_order_summary_product`
--
DROP TABLE IF EXISTS `view_order_summary_product`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_order_summary_product`  AS SELECT `sale_product`.`id` AS `id`, `invoice_details`.`order_date` AS `order_date`, `sale_product`.`product_id` AS `product_id`, `product`.`product_name` AS `productName`, `invoice_details`.`branch_id` AS `branchId`, `branch_info`.`branch_name` AS `branchName`, sum(`sale_product`.`quantity`) AS `quantity`, `sale_product`.`unit_price` AS `unit_price`, sum(`sale_product`.`discount_amount`) AS `discount_amount`, sum(`sale_product`.`sales_price_excluding_vat`) AS `sales_price_excluding_vat`, sum(`sale_product`.`vat`) AS `vat`, sum(`sale_product`.`sales_price_excluding_vat` + `sale_product`.`vat`) AS `sales_price_including_vat` FROM (((`sale_product` left join `invoice_details` on(`invoice_details`.`id` = `sale_product`.`invoice_id`)) left join `product` on(`product`.`id` = `sale_product`.`product_id`)) left join `branch_info` on(`branch_info`.`id` = `invoice_details`.`branch_id`)) GROUP BY date_format(`invoice_details`.`order_date`,'%Y-%M-%d'), `invoice_details`.`branch_id`, `sale_product`.`product_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts_posting`
--
ALTER TABLE `accounts_posting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_posting_details`
--
ALTER TABLE `accounts_posting_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets_info`
--
ALTER TABLE `assets_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_assets`
--
ALTER TABLE `assign_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_info`
--
ALTER TABLE `bank_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `block_ip`
--
ALTER TABLE `block_ip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonus_incentive_system`
--
ALTER TABLE `bonus_incentive_system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branchwise_product_store`
--
ALTER TABLE `branchwise_product_store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_info`
--
ALTER TABLE `branch_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_stock`
--
ALTER TABLE `branch_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `challan_details`
--
ALTER TABLE `challan_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `challan_product`
--
ALTER TABLE `challan_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cheque_print`
--
ALTER TABLE `cheque_print`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `client_accounts_transaction_details`
--
ALTER TABLE `client_accounts_transaction_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_info`
--
ALTER TABLE `client_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_product_damage_or_defect_details`
--
ALTER TABLE `client_product_damage_or_defect_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_product_damage_or_defect_info`
--
ALTER TABLE `client_product_damage_or_defect_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_product_return_details`
--
ALTER TABLE `client_product_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_product_return_info`
--
ALTER TABLE `client_product_return_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_sales_commission`
--
ALTER TABLE `client_sales_commission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_sales_details`
--
ALTER TABLE `client_sales_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_transaction_details`
--
ALTER TABLE `client_transaction_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency_settings`
--
ALTER TABLE `currency_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_or_defect_product_details`
--
ALTER TABLE `damage_or_defect_product_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_or_defect_product_info`
--
ALTER TABLE `damage_or_defect_product_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daywise_head_posting`
--
ALTER TABLE `daywise_head_posting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dealer_info`
--
ALTER TABLE `dealer_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_cost`
--
ALTER TABLE `delivery_cost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_cost_details`
--
ALTER TABLE `delivery_cost_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_cost_type`
--
ALTER TABLE `delivery_cost_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edit_invoice`
--
ALTER TABLE `edit_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edit_mr`
--
ALTER TABLE `edit_mr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_address_details`
--
ALTER TABLE `email_address_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_benefit`
--
ALTER TABLE `employee_benefit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_evaluation`
--
ALTER TABLE `employee_evaluation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_info`
--
ALTER TABLE `employee_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_leave_details`
--
ALTER TABLE `employee_leave_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_target`
--
ALTER TABLE `employee_target`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_total_leave`
--
ALTER TABLE `employee_total_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `envelope_print`
--
ALTER TABLE `envelope_print`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_statement_accounts`
--
ALTER TABLE `financial_statement_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_statement_accounts_assign`
--
ALTER TABLE `financial_statement_accounts_assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gate_pass_details`
--
ALTER TABLE `gate_pass_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `head_details`
--
ALTER TABLE `head_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `head_details_posting`
--
ALTER TABLE `head_details_posting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_audit_log`
--
ALTER TABLE `invoice_audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD UNIQUE KEY `challan_number` (`challan_number`);

--
-- Indexes for table `leave_application`
--
ALTER TABLE `leave_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_details`
--
ALTER TABLE `loan_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lock_time`
--
ALTER TABLE `lock_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lock_user`
--
ALTER TABLE `lock_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_log_details`
--
ALTER TABLE `login_log_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `narration`
--
ALTER TABLE `narration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_assign`
--
ALTER TABLE `notification_assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_sheet`
--
ALTER TABLE `order_sheet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `online_order_number` (`online_order_number`);

--
-- Indexes for table `order_sheet_details`
--
ALTER TABLE `order_sheet_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pf_funds`
--
ALTER TABLE `pf_funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pf_funds_details`
--
ALTER TABLE `pf_funds_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `printer_info`
--
ALTER TABLE `printer_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_name` (`product_name`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_product_list`
--
ALTER TABLE `production_product_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_receive`
--
ALTER TABLE `product_receive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_receive_challan`
--
ALTER TABLE `product_receive_challan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_reorder_level`
--
ALTER TABLE `product_reorder_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_return`
--
ALTER TABLE `product_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_return_challan`
--
ALTER TABLE `product_return_challan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_store`
--
ALTER TABLE `product_store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchased_product`
--
ALTER TABLE `purchased_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchased_product_list`
--
ALTER TABLE `purchased_product_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remove_head`
--
ALTER TABLE `remove_head`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_for_discount`
--
ALTER TABLE `request_for_discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_product_details`
--
ALTER TABLE `return_product_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_product_info`
--
ALTER TABLE `return_product_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_details`
--
ALTER TABLE `salary_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_product`
--
ALTER TABLE `sale_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transfer_challan`
--
ALTER TABLE `stock_transfer_challan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_payment`
--
ALTER TABLE `supplier_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher_details`
--
ALTER TABLE `voucher_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher_posting_details`
--
ALTER TABLE `voucher_posting_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warning_letter`
--
ALTER TABLE `warning_letter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warning_type`
--
ALTER TABLE `warning_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weekend_settings`
--
ALTER TABLE `weekend_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yearend_head_assign`
--
ALTER TABLE `yearend_head_assign`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts_posting`
--
ALTER TABLE `accounts_posting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_posting_details`
--
ALTER TABLE `accounts_posting_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets_info`
--
ALTER TABLE `assets_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_assets`
--
ALTER TABLE `assign_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_info`
--
ALTER TABLE `bank_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `block_ip`
--
ALTER TABLE `block_ip`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bonus_incentive_system`
--
ALTER TABLE `bonus_incentive_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branchwise_product_store`
--
ALTER TABLE `branchwise_product_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `branch_info`
--
ALTER TABLE `branch_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `branch_stock`
--
ALTER TABLE `branch_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `challan_details`
--
ALTER TABLE `challan_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `challan_product`
--
ALTER TABLE `challan_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cheque_print`
--
ALTER TABLE `cheque_print`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_accounts_transaction_details`
--
ALTER TABLE `client_accounts_transaction_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_info`
--
ALTER TABLE `client_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `client_product_damage_or_defect_details`
--
ALTER TABLE `client_product_damage_or_defect_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_product_damage_or_defect_info`
--
ALTER TABLE `client_product_damage_or_defect_info`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_product_return_details`
--
ALTER TABLE `client_product_return_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `client_product_return_info`
--
ALTER TABLE `client_product_return_info`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `client_sales_commission`
--
ALTER TABLE `client_sales_commission`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_sales_details`
--
ALTER TABLE `client_sales_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `client_transaction_details`
--
ALTER TABLE `client_transaction_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `company_info`
--
ALTER TABLE `company_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `currency_settings`
--
ALTER TABLE `currency_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `damage_or_defect_product_details`
--
ALTER TABLE `damage_or_defect_product_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damage_or_defect_product_info`
--
ALTER TABLE `damage_or_defect_product_info`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daywise_head_posting`
--
ALTER TABLE `daywise_head_posting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dealer_info`
--
ALTER TABLE `dealer_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_cost`
--
ALTER TABLE `delivery_cost`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_cost_details`
--
ALTER TABLE `delivery_cost_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_cost_type`
--
ALTER TABLE `delivery_cost_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edit_invoice`
--
ALTER TABLE `edit_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `edit_mr`
--
ALTER TABLE `edit_mr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_address_details`
--
ALTER TABLE `email_address_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_benefit`
--
ALTER TABLE `employee_benefit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_evaluation`
--
ALTER TABLE `employee_evaluation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_info`
--
ALTER TABLE `employee_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employee_leave_details`
--
ALTER TABLE `employee_leave_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_target`
--
ALTER TABLE `employee_target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_total_leave`
--
ALTER TABLE `employee_total_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `envelope_print`
--
ALTER TABLE `envelope_print`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_statement_accounts`
--
ALTER TABLE `financial_statement_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_statement_accounts_assign`
--
ALTER TABLE `financial_statement_accounts_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gate_pass_details`
--
ALTER TABLE `gate_pass_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `head_details`
--
ALTER TABLE `head_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `head_details_posting`
--
ALTER TABLE `head_details_posting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice_audit_log`
--
ALTER TABLE `invoice_audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `leave_application`
--
ALTER TABLE `leave_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_details`
--
ALTER TABLE `loan_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lock_time`
--
ALTER TABLE `lock_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lock_user`
--
ALTER TABLE `lock_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_log_details`
--
ALTER TABLE `login_log_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=411;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `narration`
--
ALTER TABLE `narration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_assign`
--
ALTER TABLE `notification_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_sheet`
--
ALTER TABLE `order_sheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_sheet_details`
--
ALTER TABLE `order_sheet_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pf_funds`
--
ALTER TABLE `pf_funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pf_funds_details`
--
ALTER TABLE `pf_funds_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `printer_info`
--
ALTER TABLE `printer_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_product_list`
--
ALTER TABLE `production_product_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_receive`
--
ALTER TABLE `product_receive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_receive_challan`
--
ALTER TABLE `product_receive_challan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_reorder_level`
--
ALTER TABLE `product_reorder_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_return`
--
ALTER TABLE `product_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_return_challan`
--
ALTER TABLE `product_return_challan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_store`
--
ALTER TABLE `product_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `purchased_product`
--
ALTER TABLE `purchased_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchased_product_list`
--
ALTER TABLE `purchased_product_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remove_head`
--
ALTER TABLE `remove_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_for_discount`
--
ALTER TABLE `request_for_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `return_product_details`
--
ALTER TABLE `return_product_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_product_info`
--
ALTER TABLE `return_product_info`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_details`
--
ALTER TABLE `salary_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_product`
--
ALTER TABLE `sale_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stock_transfer_challan`
--
ALTER TABLE `stock_transfer_challan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier_payment`
--
ALTER TABLE `supplier_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `voucher_details`
--
ALTER TABLE `voucher_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_posting_details`
--
ALTER TABLE `voucher_posting_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warning_letter`
--
ALTER TABLE `warning_letter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warning_type`
--
ALTER TABLE `warning_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weekend_settings`
--
ALTER TABLE `weekend_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yearend_head_assign`
--
ALTER TABLE `yearend_head_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
