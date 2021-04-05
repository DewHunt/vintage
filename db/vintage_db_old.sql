-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2020 at 08:33 AM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aocl_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_posting`
--

CREATE TABLE `accounts_posting` (
  `id` int(11) NOT NULL,
  `accounts_posting_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `voucher_number` varchar(100) NOT NULL,
  `bank_id` int(11) DEFAULT '0',
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
  `accounts_posting_details_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `assigned_assets_quantity` int(11) DEFAULT '0',
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  `assign_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `current_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  `product_store_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `open_stock` int(11) NOT NULL,
  `receive_stock` int(11) NOT NULL,
  `transfer_stock` int(11) NOT NULL,
  `sale_from_stock` int(11) NOT NULL,
  `damage_stock` int(11) NOT NULL DEFAULT '0',
  `closing_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branch_info`
--

CREATE TABLE `branch_info` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(500) NOT NULL,
  `branch_code` varchar(500) DEFAULT NULL,
  `branch_area` varchar(500) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `mobile` varchar(500) DEFAULT NULL,
  `phone` varchar(500) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branch_stock`
--

CREATE TABLE `branch_stock` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `challan_details`
--

CREATE TABLE `challan_details` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `delivery_certificate` varchar(500) NOT NULL,
  `date_of_issue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `quantity` double NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `total_price` double NOT NULL DEFAULT '0',
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
  `details` text,
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
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `opening_balance` double NOT NULL DEFAULT '0',
  `debit_amount` double NOT NULL DEFAULT '0',
  `credit_amount` double NOT NULL DEFAULT '0',
  `closing_balance` double NOT NULL DEFAULT '0',
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
  `client_name` varchar(500) NOT NULL,
  `client_code` varchar(100) NOT NULL,
  `address` varchar(5000) DEFAULT NULL,
  `client_area` varchar(500) DEFAULT NULL,
  `cell_number` varchar(50) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `dealer_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `remarks` varchar(5000) DEFAULT NULL,
  `credit_balance` double NOT NULL DEFAULT '0',
  `total_sale` double NOT NULL DEFAULT '0',
  `advance_balance` double NOT NULL DEFAULT '0',
  `client_type` varchar(20) NOT NULL,
  `return_amount` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_product_damage_or_defect_details`
--

CREATE TABLE `client_product_damage_or_defect_details` (
  `id` bigint(20) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `client_product_damage_or_defect_info_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_product_damage_or_defect_info`
--

CREATE TABLE `client_product_damage_or_defect_info` (
  `id` bigint(20) NOT NULL,
  `return_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `challan_number` varchar(100) DEFAULT NULL,
  `total_amount` double NOT NULL DEFAULT '0',
  `return_amount` double NOT NULL DEFAULT '0',
  `total_amount_after_return` double NOT NULL DEFAULT '0',
  `remarks` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_product_return_details`
--

CREATE TABLE `client_product_return_details` (
  `id` bigint(20) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `client_product_return_info_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_product_return_info`
--

CREATE TABLE `client_product_return_info` (
  `id` bigint(20) NOT NULL,
  `return_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `challan_number` varchar(100) DEFAULT NULL,
  `total_amount` double NOT NULL DEFAULT '0',
  `return_amount` double NOT NULL DEFAULT '0',
  `total_amount_after_return` double NOT NULL DEFAULT '0',
  `remarks` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_sales_commission`
--

CREATE TABLE `client_sales_commission` (
  `id` bigint(20) NOT NULL,
  `commission_record_number` text NOT NULL,
  `claim_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `invoice_details_id` bigint(20) NOT NULL DEFAULT '0',
  `commission_amount` double NOT NULL,
  `commission_bank_name` text NOT NULL,
  `commission_bank_account` text NOT NULL,
  `commission_bkash_number` text NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `current_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_sales_details`
--

CREATE TABLE `client_sales_details` (
  `id` bigint(20) NOT NULL,
  `client_id` int(11) NOT NULL,
  `sale_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_credit_balance` double NOT NULL DEFAULT '0',
  `total_advance_balance` double NOT NULL DEFAULT '0',
  `total_sale` double NOT NULL DEFAULT '0',
  `total_payment` double NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_transaction_details`
--

CREATE TABLE `client_transaction_details` (
  `id` bigint(20) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_payment_id` bigint(20) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `opening_balance` double NOT NULL DEFAULT '0',
  `debit_amount` double NOT NULL DEFAULT '0',
  `credit_amount` double NOT NULL DEFAULT '0',
  `closing_balance` double NOT NULL DEFAULT '0',
  `narration` varchar(500) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `id` int(11) NOT NULL,
  `company_name_1` varchar(500) NOT NULL,
  `company_name_2` varchar(500) NOT NULL,
  `company_address_1` varchar(500) NOT NULL,
  `company_address_2` varchar(500) NOT NULL,
  `phone` varchar(500) NOT NULL,
  `mobile` varchar(500) NOT NULL,
  `fax` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `website` varchar(500) NOT NULL,
  `casual_leave` int(11) NOT NULL DEFAULT '0',
  `medical_leave` int(11) NOT NULL DEFAULT '0',
  `earn_leave` int(11) NOT NULL DEFAULT '0',
  `company_logo` varchar(100) DEFAULT NULL,
  `super_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`id`, `company_name_1`, `company_name_2`, `company_address_1`, `company_address_2`, `phone`, `mobile`, `fax`, `email`, `website`, `casual_leave`, `medical_leave`, `earn_leave`, `company_logo`, `super_password`) VALUES
(7, 'test', '', 'test', '', '53465436', '56436346', '45', 'abc@gmail.com', 'www.test.com.bd', 5, 15, 10, '', '5681a4aa48e897e33dc589981005b4d9009aab33');

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
  `purchase_price` double NOT NULL DEFAULT '0',
  `damage_or_defect_product_info_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `damage_or_defect_product_info`
--

CREATE TABLE `damage_or_defect_product_info` (
  `id` bigint(20) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `damage_or_defect_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reason` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daywise_head_posting`
--

CREATE TABLE `daywise_head_posting` (
  `id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL DEFAULT '0',
  `posting_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opening_balance` double NOT NULL DEFAULT '0',
  `debit_amount` double NOT NULL DEFAULT '0',
  `credit_amount` double NOT NULL DEFAULT '0',
  `closing_balance` double NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `invoice_details_id` bigint(20) NOT NULL DEFAULT '0',
  `total_amount` double NOT NULL DEFAULT '0',
  `delivery_cost_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` bigint(11) NOT NULL DEFAULT '0',
  `current_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_cost_details`
--

CREATE TABLE `delivery_cost_details` (
  `id` bigint(20) NOT NULL,
  `delivery_cost_type_id` bigint(20) NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `delivery_cost_id` bigint(20) NOT NULL DEFAULT '0'
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
  `invoice_number` int(11) NOT NULL,
  `challan_number` int(11) NOT NULL,
  `edit_invoice_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_id` int(11) NOT NULL,
  `previous_quantity` int(11) NOT NULL,
  `reduce_quantity` int(11) NOT NULL,
  `current_quantity` int(11) NOT NULL,
  `unit_price` double NOT NULL,
  `previous_amount` double NOT NULL,
  `current_amount` double NOT NULL,
  `usre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `edit_mr_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_address_details`
--

CREATE TABLE `email_address_details` (
  `id` int(11) NOT NULL,
  `email_to` text,
  `email_cc` text,
  `email_bcc` text,
  `user_id` int(11) NOT NULL DEFAULT '0'
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
  `amount` double NOT NULL DEFAULT '0',
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
  `joining_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `closing_date` timestamp NULL DEFAULT NULL,
  `basic_salary` double DEFAULT NULL,
  `phone_allowance` double DEFAULT NULL,
  `tuition_allowance` double DEFAULT NULL,
  `attendance_allowance` double DEFAULT NULL,
  `bonus` double DEFAULT NULL,
  `others` double DEFAULT NULL,
  `pf_contribution` double DEFAULT NULL,
  `loan_installment` int(11) DEFAULT NULL,
  `is_loan` tinyint(1) DEFAULT '0',
  `current_loan_id` int(11) DEFAULT '0',
  `deactivate_employee` tinyint(1) NOT NULL DEFAULT '0',
  `casual_leave` int(11) NOT NULL DEFAULT '0',
  `medical_leave` int(11) NOT NULL DEFAULT '0',
  `earn_leave` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '1',
  `permanent_address` varchar(500) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `others_benefit` double NOT NULL DEFAULT '0',
  `less_others_benefit` double NOT NULL DEFAULT '0',
  `less_others_misc` double NOT NULL DEFAULT '0',
  `pf_contribution_company_part` double NOT NULL DEFAULT '0',
  `employee_image` varchar(100) DEFAULT NULL,
  `target_amount` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_info`
--

INSERT INTO `employee_info` (`id`, `employee_name`, `employee_code`, `employee_email`, `designation`, `gender`, `phone`, `mobile`, `address`, `joining_date`, `closing_date`, `basic_salary`, `phone_allowance`, `tuition_allowance`, `attendance_allowance`, `bonus`, `others`, `pf_contribution`, `loan_installment`, `is_loan`, `current_loan_id`, `deactivate_employee`, `casual_leave`, `medical_leave`, `earn_leave`, `sort_order`, `permanent_address`, `blood_group`, `others_benefit`, `less_others_benefit`, `less_others_misc`, `pf_contribution_company_part`, `employee_image`, `target_amount`) VALUES
(6, 'Admin', 'e-5', 'admin@gmail.com', 'Manager', 'male', '01717387617', '01936011154', 'dhaka-1200', '2017-01-01 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 15, 10, 1000, 'dhaka-1200', 'o+', 0, 0, 0, 0, 'assets/uploads/employee_images/Admin_image.png', 0);

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
  `employee_id` int(11) NOT NULL DEFAULT '0',
  `target_start_date` timestamp NULL DEFAULT NULL,
  `target_end_date` timestamp NULL DEFAULT NULL,
  `target_amount` double NOT NULL DEFAULT '0'
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
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `date_of_issue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `invoice_number` varchar(100) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `challan_number` varchar(500) NOT NULL,
  `client_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `vat_registration_id` varchar(100) NOT NULL,
  `date_of_issue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_total` double NOT NULL DEFAULT '0',
  `delivery_charge` double NOT NULL DEFAULT '0',
  `others_charge` double NOT NULL DEFAULT '0',
  `deduction` double NOT NULL DEFAULT '0',
  `deduction_type` varchar(100) DEFAULT NULL,
  `gross_payable` double NOT NULL DEFAULT '0',
  `advance_adjusted` double NOT NULL DEFAULT '0',
  `amount_to_paid` double NOT NULL DEFAULT '0',
  `mode_of_payment` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remarks` varchar(500) DEFAULT NULL,
  `delivery_address` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `is_show` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `loan_start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_loan_amount` double NOT NULL,
  `number_of_installment` int(11) NOT NULL,
  `per_installment_amount` double NOT NULL,
  `total_installment_amount` double NOT NULL,
  `details` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `already_paid_loan_amount` double NOT NULL DEFAULT '0'
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
  `loan_payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `user_id` int(11) DEFAULT '0',
  `user_name_or_email` varchar(100) NOT NULL,
  `ip_address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `notification_id` int(11) NOT NULL DEFAULT '0',
  `employee_id` int(11) NOT NULL DEFAULT '0',
  `open_date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_show` tinyint(1) NOT NULL DEFAULT '0'
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
  `receipt_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `client_id` int(11) NOT NULL,
  `amount_received` double DEFAULT '0',
  `client_code` varchar(500) NOT NULL,
  `payment_type` varchar(500) NOT NULL,
  `cheque_number` varchar(500) DEFAULT NULL,
  `cheque_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bank_id` int(11) DEFAULT '0',
  `branch_name` varchar(500) DEFAULT NULL,
  `purpose` varchar(500) DEFAULT NULL,
  `invoice_number` varchar(500) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `branch_mr_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pf_funds`
--

CREATE TABLE `pf_funds` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `pf_contribution_per_month` double NOT NULL,
  `total_deposit_amount` double NOT NULL,
  `starting_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pf_funds_details`
--

CREATE TABLE `pf_funds_details` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `deposit_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `previous_deposit_amount` double NOT NULL,
  `deposit_amount` double NOT NULL,
  `deposit_amount_total` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `salary_details_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(500) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_range` varchar(500) NOT NULL,
  `minimum_price` double NOT NULL DEFAULT '0',
  `maximum_price` double NOT NULL DEFAULT '0',
  `fixed_price` double NOT NULL DEFAULT '0',
  `product_stock` int(11) DEFAULT '0',
  `api` varchar(1000) DEFAULT NULL,
  `sae` varchar(1000) DEFAULT NULL,
  `iso` varchar(1000) DEFAULT NULL,
  `pack_size` varchar(1000) DEFAULT NULL,
  `origin_of_country` varchar(1000) DEFAULT NULL,
  `purchase_price` double NOT NULL DEFAULT '0',
  `reorder_level` double NOT NULL DEFAULT '0',
  `product_type_id` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_receive`
--

CREATE TABLE `product_receive` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_source` varchar(500) DEFAULT NULL,
  `total_price` double NOT NULL DEFAULT '0',
  `product_receive_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_receive_challan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_receive_challan`
--

CREATE TABLE `product_receive_challan` (
  `id` int(11) NOT NULL,
  `challan_number` varchar(100) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `product_receive_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_reorder_level`
--

CREATE TABLE `product_reorder_level` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `reorder_level` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_store`
--

CREATE TABLE `product_store` (
  `id` int(11) NOT NULL,
  `product_store_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_id` int(11) NOT NULL,
  `open_stock` int(11) NOT NULL,
  `receive_stock` int(11) NOT NULL,
  `transfer_stock` int(11) NOT NULL,
  `sale_from_stock` int(11) NOT NULL,
  `damage_stock` int(11) NOT NULL DEFAULT '0',
  `closing_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `id` int(11) NOT NULL,
  `product_type_name` varchar(255) NOT NULL
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
  `return_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `employee_benefit` double DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `others_benefit` double NOT NULL DEFAULT '0',
  `less_others_benefit` double NOT NULL DEFAULT '0',
  `less_others_misc` double NOT NULL DEFAULT '0',
  `take_home_salary` double NOT NULL DEFAULT '0',
  `current_date_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sale_product`
--

CREATE TABLE `sale_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `pack_size` varchar(500) DEFAULT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `sales_price_excluding_vat` double NOT NULL DEFAULT '0',
  `vat` double NOT NULL DEFAULT '0',
  `sales_price_including_vat` double NOT NULL DEFAULT '0',
  `invoice_id` int(11) NOT NULL,
  `gate_pass_remarks` varchar(5000) NOT NULL,
  `purchase_price` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

CREATE TABLE `stock_transfer` (
  `id` int(11) NOT NULL,
  `from_branch_id` int(11) NOT NULL,
  `to_branch_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_of_transfer` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `transfer_reason` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` double NOT NULL,
  `product_source` varchar(500) DEFAULT NULL,
  `stock_transfer_challan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_challan`
--

CREATE TABLE `stock_transfer_challan` (
  `id` int(11) NOT NULL,
  `from_branch_id` int(11) NOT NULL,
  `to_branch_id` int(11) NOT NULL,
  `challan_number` varchar(100) DEFAULT NULL,
  `total_amount` double NOT NULL,
  `reason` varchar(500) DEFAULT NULL,
  `transfer_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `user_name` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `user_type` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `employee_id` int(11) NOT NULL DEFAULT '0',
  `hr_access` tinyint(1) NOT NULL DEFAULT '0',
  `accounts_access` tinyint(1) NOT NULL DEFAULT '0',
  `sales_access` tinyint(1) NOT NULL DEFAULT '0',
  `settings_access` tinyint(1) NOT NULL DEFAULT '0',
  `user_access` tinyint(1) NOT NULL DEFAULT '0',
  `accounts_report_access` tinyint(1) NOT NULL DEFAULT '0',
  `hr_report_access` tinyint(1) NOT NULL DEFAULT '0',
  `sales_report_access` tinyint(1) NOT NULL DEFAULT '0',
  `product_report_access` tinyint(1) NOT NULL DEFAULT '0',
  `money_receipt_report_access` tinyint(1) NOT NULL DEFAULT '0',
  `print_access` tinyint(1) NOT NULL DEFAULT '0',
  `product_access` tinyint(1) NOT NULL DEFAULT '0',
  `client_access` tinyint(1) NOT NULL DEFAULT '0',
  `lock_access` tinyint(1) NOT NULL DEFAULT '0',
  `edit_mr_access` tinyint(1) NOT NULL DEFAULT '0',
  `edit_invoice_access` tinyint(1) NOT NULL DEFAULT '0',
  `order_sheet_access` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `name`, `user_name`, `password`, `user_type`, `email`, `mobile`, `address`, `employee_id`, `hr_access`, `accounts_access`, `sales_access`, `settings_access`, `user_access`, `accounts_report_access`, `hr_report_access`, `sales_report_access`, `product_report_access`, `money_receipt_report_access`, `print_access`, `product_access`, `client_access`, `lock_access`, `edit_mr_access`, `edit_invoice_access`, `order_sheet_access`) VALUES
(24, 'Admin', 'admin', 'aa16b0bafdee249f381815c83e9e60d669944d46', 'admin', 'admin@gmail.com', '01936011154', 'dhaka-1200', 6, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `user_type` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `user_type`) VALUES
(1, 'admin'),
(2, 'hr'),
(3, 'accounts'),
(4, 'marketing'),
(5, 'technical'),
(6, 'branding'),
(7, 'logistics'),
(8, 'operational executive');

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
  `client_id` int(11) DEFAULT '0',
  `employee_id` int(11) DEFAULT '0',
  `month` varchar(20) NOT NULL,
  `year` varchar(20) NOT NULL,
  `narration` varchar(500) NOT NULL,
  `debit_amount` double NOT NULL,
  `credit_amount` double NOT NULL,
  `opening_balance` double NOT NULL DEFAULT '0',
  `closing_balance` double NOT NULL DEFAULT '0',
  `voucher_posting_details_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_posting_details`
--

CREATE TABLE `voucher_posting_details` (
  `id` int(11) NOT NULL,
  `posting_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_name` (`product_name`);

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
-- Indexes for table `remove_head`
--
ALTER TABLE `remove_head`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `branch_info`
--
ALTER TABLE `branch_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `branch_stock`
--
ALTER TABLE `branch_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_product_return_info`
--
ALTER TABLE `client_product_return_info`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_sales_commission`
--
ALTER TABLE `client_sales_commission`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_sales_details`
--
ALTER TABLE `client_sales_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_transaction_details`
--
ALTER TABLE `client_transaction_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edit_mr`
--
ALTER TABLE `edit_mr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `head_details_posting`
--
ALTER TABLE `head_details_posting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoice_audit_log`
--
ALTER TABLE `invoice_audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pf_funds`
--
ALTER TABLE `pf_funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pf_funds_details`
--
ALTER TABLE `pf_funds_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
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
-- AUTO_INCREMENT for table `product_store`
--
ALTER TABLE `product_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `remove_head`
--
ALTER TABLE `remove_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_transfer_challan`
--
ALTER TABLE `stock_transfer_challan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
