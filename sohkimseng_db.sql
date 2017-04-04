-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2017 at 01:47 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sohkimseng_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 123456789),
('developer', '2', 1486451748),
('sales', '3', 1487918909),
('sales', '4', 1486452408),
('sales', '5', 1490583656);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Admin', NULL, NULL, 1486450843, 1486450843),
('developer', 1, 'Developer', NULL, NULL, 1486450843, 1486450843),
('driver', 1, 'Driver', NULL, NULL, 1486450842, 1486450842),
('sales', 1, 'Sales', NULL, NULL, 1486450843, 1486450843),
('technician', 1, 'Technician', NULL, NULL, 1486450842, 1486450842);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `type` int(5) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `uen_no` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `nric` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `shipping_address` text NOT NULL,
  `race_id` int(5) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` int(15) NOT NULL,
  `mobile_number` int(15) NOT NULL,
  `fax_number` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `type`, `company_name`, `uen_no`, `fullname`, `nric`, `address`, `shipping_address`, `race_id`, `email`, `phone_number`, `mobile_number`, `fax_number`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 1, 'maxwell freight management pte ltd', '198305727m', 'kristine pan smith', '', '20 maxwell road 0612 maxwell house singapore 069113', '201 maxwell road 0612 maxwell house singapore 069113', 0, 'kristine@maxwellfreight.com.sg', 62216988, 62216988, '62213325', 1, '2017-04-04 18:39:20', 1, '0000-00-00 00:00:00', 0),
(3, 2, '', '', 'johnny tang', '19880305ph', '25th floor bpi buendia center makati city', '25th floor bpi buendia center makati city', 1, 'johnsmith@bpi.com.ph', 2147483647, 9557545, '9551236', 1, '2017-04-04 18:39:58', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `designated_position`
--

CREATE TABLE `designated_position` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designated_position`
--

INSERT INTO `designated_position` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'web programmer', 'responsible for developing cms and crm\n', 1, '2017-04-04 14:44:18', 1, '0000-00-00 00:00:00', 0),
(2, 'supervisor', 'responsible for supervise the facility', 1, '2017-04-04 14:44:48', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gst`
--

CREATE TABLE `gst` (
  `id` int(11) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `quotation_code` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `user_id` int(5) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `date_issue` date NOT NULL,
  `grand_total` double NOT NULL,
  `gst` double(10,2) NOT NULL,
  `net` double NOT NULL,
  `remarks` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `do` int(5) NOT NULL,
  `paid` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `quotation_code`, `invoice_no`, `user_id`, `customer_id`, `date_issue`, `grand_total`, `gst`, `net`, `remarks`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `do`, `paid`, `deleted`) VALUES
(1, '0', 'INV201703001', 3, 6, '2017-03-03', 1501, 105.07, 1606.07, 'for test case', 1, '2017-03-02 13:13:37', 2, '0000-00-00 00:00:00', 0, 0, 0, 0),
(2, '0', 'INV201703001', 3, 6, '2017-03-03', 1501, 105.07, 1606.07, 'for test case', 1, '2017-03-02 13:13:40', 2, '0000-00-00 00:00:00', 0, 0, 0, 0),
(3, '0', 'INV201703001', 3, 6, '2017-03-03', 1501, 105.07, 1606.07, 'for test case', 1, '2017-03-02 13:15:15', 2, '0000-00-00 00:00:00', 0, 0, 0, 0),
(4, '0', 'INV201703004', 3, 3, '2017-03-03', 72, 5.04, 77.04, 'for test case', 1, '2017-03-02 13:15:46', 2, '0000-00-00 00:00:00', 0, 0, 0, 0),
(5, '0', 'INV201703005', 3, 3, '2017-03-03', 176, 12.32, 188.32, 'for test case', 1, '2017-03-02 13:17:00', 2, '0000-00-00 00:00:00', 0, 0, 0, 0),
(6, '0', 'INV201703006', 3, 3, '2017-03-03', 101, 7.07, 108.07, 'for test case', 1, '2017-03-02 13:20:23', 2, '0000-00-00 00:00:00', 0, 0, 0, 0),
(7, '0', 'INV201703007', 3, 3, '2017-03-03', 109, 0.00, 109, 'FOR TEST CASE', 1, '2017-03-02 13:21:08', 2, '2017-03-02 13:45:52', 2, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `id` int(11) NOT NULL,
  `invoice_id` int(5) NOT NULL,
  `description` int(5) NOT NULL,
  `quantity` int(5) NOT NULL,
  `unit_price` double NOT NULL,
  `sub_total` double NOT NULL,
  `type` int(5) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_detail`
--

INSERT INTO `invoice_detail` (`id`, `invoice_id`, `description`, `quantity`, `unit_price`, `sub_total`, `type`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`) VALUES
(3, 7, 4, 3, 3, 9, 1, 1, '2017-03-02 13:45:52', 2, '2017-03-02 13:45:52', 2, 0),
(4, 7, 4, 1, 100, 100, 0, 1, '2017-03-02 13:45:52', 2, '2017-03-02 13:45:52', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1485746530),
('m130524_201442_init', 1485746536),
('m140506_102106_rbac_init', 1486450540),
('m170130_035147_create_user_table', 1485747488),
('m170130_040250_create_role_table', 1485749174),
('m170130_041241_create_user_permission_table', 1485749900),
('m170130_041907_create_user_permission_foreignkey', 1485750016),
('m170201_070315_create_customer_table', 1485933195),
('m170202_064144_create_staff_table', 1486017762),
('m170202_072813_create_driver_table', 1486020744),
('m170202_081712_create_technician_table', 1486023528),
('m170202_083209_add_phone_number_column_to_technician_table', 1486024378),
('m170202_094525_create_supplier_table', 1486028898),
('m170203_015220_create_module_table', 1486086799),
('m170203_022141_create_storage_location_table', 1486089330),
('m170203_031024_create_service_category_table', 1486092375),
('m170203_040219_create_service_table', 1486094716),
('m170203_040615_create_service_category_foreignkey', 1486094859),
('m170204_043603_create_parts_category_table', 1486183065),
('m170204_063626_create_parts_table', 1486190220),
('m170204_063740_create_parts_category_foreignkey', 1486190327),
('m170204_082122_create_product_category_table', 1486196908),
('m170204_090511_create_product_table', 1486199173),
('m170204_090644_create_product_category_foreignkey', 1486199284),
('m170204_112748_create_staff_group_table', 1486207756),
('m170204_115659_add_staff_group_id_column_to_staff_table', 1486209529),
('m170204_115934_create_staff_group_foreignkey', 1486212358),
('m170204_123533_create_parts_inventory_table', 1486212358),
('m170204_124417_add_parts_code_column_to_parts_table', 1486212359),
('m170204_124807_add_unit_of_measure_column_to_parts_table', 1486212533),
('m170204_142853_create_parts_inventory_foreignkey', 1486218675),
('m170206_014539_add_product_code_and_unit_of_measure_to_product_table', 1486345653),
('m170206_034043_create_product_inventory_table', 1486352536),
('m170206_034256_create_product_inventory_foreignkey', 1486352693),
('m170206_043840_create_quotation_table', 1486358917),
('m170206_052126_create_quotation_detail_table', 1486358918),
('m170206_053020_create_quotation_foreignkey', 1486359247),
('m170206_053250_create_quotation_detail_foreignkey', 1486359247),
('m170207_065638_create_rbac_init', 1486450843),
('m170224_035010_add_gst_and_invoice_created_columns_to_quotation_table', 1487908367),
('m170227_042157_create_gst_table', 1488169693),
('m170227_110130_add_type_column_to_quotation_detail_table', 1488193359),
('m170228_011356_create_race_table', 1488244502),
('m170228_011808_create_race_foreignkey', 1488244819),
('m170301_092800_create_invoice_table', 1488360781),
('m170301_093601_create_invoice_detail_table', 1488361014),
('m170301_093809_create_invoice_foreignkey', 1488361163),
('m170301_093951_create_invoice_detail_foreignkey', 1488361260),
('m170404_052826_create_designated_position_table', 1491283756),
('m170404_061727_add_designated_position_id_to_staff_table', 1491286715),
('m170404_061939_create_designated_position_foreignkey', 1491286930),
('m170404_080009_add_columns_to_customer_table', 1491293117),
('m170404_080843_add_company_name_column_to_customer_table', 1491293392);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 'role', 1, '2017-02-03 10:08:17', 1, '2017-02-07 13:23:33', 1),
(3, 'user', 1, '2017-02-07 13:23:26', 1, '2017-04-04 13:44:03', 1),
(5, 'testing', 0, '2017-04-04 11:53:59', 1, '2017-04-04 11:54:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id` int(11) NOT NULL,
  `parts_category_id` int(5) NOT NULL,
  `parts_code` varchar(100) NOT NULL,
  `parts_name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `unit_of_measure` varchar(100) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`id`, `parts_category_id`, `parts_code`, `parts_name`, `description`, `unit_of_measure`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(4, 2, 'PARTS-2017-25448', 'for test ', 'for test only', 'large', 1, '2017-02-04 22:04:33', 1, '0000-00-00 00:00:00', 0),
(5, 1, 'PARTS-2017-37040', 'TIRE TEST', 'FOR TIRE TEST ', 'KILOGRAM', 1, '2017-02-04 22:14:37', 1, '2017-02-04 22:18:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parts_category`
--

CREATE TABLE `parts_category` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parts_category`
--

INSERT INTO `parts_category` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'tire', 'tireless', 1, '2017-02-04 14:28:17', 1, '0000-00-00 00:00:00', 0),
(2, 'TESTING CASE', 'FOR TESTING CASE ONLY', 1, '2017-02-04 14:30:31', 1, '2017-02-04 14:32:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parts_inventory`
--

CREATE TABLE `parts_inventory` (
  `id` int(11) NOT NULL,
  `parts_id` int(5) NOT NULL,
  `supplier_id` int(5) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` double NOT NULL,
  `status` int(5) NOT NULL,
  `date_imported` date NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parts_inventory`
--

INSERT INTO `parts_inventory` (`id`, `parts_id`, `supplier_id`, `quantity`, `price`, `status`, `date_imported`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 4, 1, 1, 1, 1, '2017-02-05', '2017-02-05 19:36:20', 1, '2017-02-05 19:36:20', 1),
(2, 4, 1, 1, 1, 1, '2017-02-05', '2017-02-05 21:27:20', 1, '2017-02-05 21:27:20', 1),
(3, 5, 2, 2, 2, 1, '2017-02-05', '2017-02-05 21:27:20', 1, '2017-02-05 21:27:20', 1),
(4, 5, 2, 3, 3, 1, '2017-02-05', '2017-02-05 21:27:48', 1, '2017-02-05 21:27:48', 1),
(5, 4, 2, 15, 25, 1, '2017-02-08', '2017-02-08 18:38:38', 1, '2017-02-08 18:38:38', 1),
(6, 5, 2, 10, 10, 1, '2017-02-05', '2017-02-05 21:37:50', 1, '2017-02-05 21:37:50', 1),
(7, 5, 1, 15, 20, 1, '2017-02-05', '2017-02-05 21:37:50', 1, '2017-02-05 21:37:50', 1),
(8, 4, 2, 20, 30, 1, '2017-02-05', '2017-02-05 21:37:50', 1, '2017-02-05 21:37:50', 1),
(10, 4, 2, 14, 15, 1, '2017-02-05', '2017-02-05 21:41:17', 1, '2017-02-05 21:41:17', 1),
(11, 4, 1, 15, 15, 1, '2017-02-08', '2017-02-08 18:39:10', 1, '2017-02-08 18:39:10', 1),
(13, 5, 1, 30, 50, 1, '2017-02-08', '2017-02-08 18:39:43', 1, '2017-02-08 18:39:43', 1),
(15, 5, 2, 13, 14, 1, '2017-02-08', '2017-02-08 18:40:10', 1, '2017-02-08 18:40:10', 1),
(16, 5, 2, 2, 2, 1, '2017-02-08', '2017-02-08 19:24:02', 1, '2017-02-08 19:24:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_category_id` int(5) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `unit_of_measure` varchar(100) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_category_id`, `product_code`, `product_name`, `description`, `unit_of_measure`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 3, 'PRODUCTS-2017-09424', 'SAN MIG LIGHT', 'DRINK MODERATELY', 'KILOGRAM', 1, '2017-02-06 11:34:28', 1, '2017-02-06 11:49:51', 1),
(4, 3, 'PRODUCTS-2017-34902', 'PIATOS', 'JUNK FOODS ', 'PIECES', 1, '2017-02-06 11:39:56', 1, '2017-02-06 11:49:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'test', 'sadsa 233', 1, '2017-02-04 16:58:26', 1, '0000-00-00 00:00:00', 0),
(3, 'for test case', 'for test case purposes only', 1, '2017-02-04 17:03:34', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_inventory`
--

CREATE TABLE `product_inventory` (
  `id` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `supplier_id` int(5) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` double NOT NULL,
  `status` int(5) NOT NULL,
  `date_imported` date NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_inventory`
--

INSERT INTO `product_inventory` (`id`, `product_id`, `supplier_id`, `quantity`, `price`, `status`, `date_imported`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 3, 2, 5, 100, 1, '2017-02-06', '2017-02-06 12:24:14', 1, '2017-02-06 12:24:14', 1),
(2, 3, 2, 30, 75, 1, '2017-02-06', '2017-02-06 12:23:59', 1, '2017-02-06 12:23:59', 1),
(3, 4, 2, 15, 125, 1, '2017-02-06', '2017-02-06 12:23:48', 1, '2017-02-06 12:23:48', 1),
(5, 4, 2, 10, 15, 1, '2017-02-08', '2017-02-08 19:15:39', 1, '2017-02-08 19:15:39', 1),
(6, 3, 2, 100, 200, 1, '2017-02-08', '2017-02-08 19:15:39', 1, '2017-02-08 19:15:39', 1),
(7, 4, 2, 10, 100, 1, '2017-02-24', '2017-02-24 11:18:21', 1, '2017-02-24 11:18:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE `quotation` (
  `id` int(11) NOT NULL,
  `quotation_code` varchar(100) NOT NULL,
  `user_id` int(5) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `date_issue` date NOT NULL,
  `grand_total` double NOT NULL,
  `gst` double NOT NULL,
  `net` double NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `status` int(5) NOT NULL,
  `invoice_created` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`id`, `quotation_code`, `user_id`, `customer_id`, `date_issue`, `grand_total`, `gst`, `net`, `remarks`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `invoice_created`, `deleted`) VALUES
(1, 'QUO201702001', 3, 3, '2017-02-28', 186, 0, 186, 'FOR TEST CASE purposes only', '2017-02-28 11:11:44', 2, '2017-03-01 12:53:09', 2, 1, 0, 0),
(2, 'QUO201702002', 3, 1, '2017-02-28', 462, 32.34, 494.34, 'test', '2017-02-28 14:41:25', 2, '0000-00-00 00:00:00', 0, 1, 0, 0),
(3, 'QUO201703003', 3, 6, '2017-03-02', 44, 3.08, 47.08, 'for test case only', '2017-03-01 17:16:32', 2, '0000-00-00 00:00:00', 0, 1, 0, 0),
(4, 'QUO201703004', 3, 1, '2017-03-03', 1501, 105.07, 1606.07, 'testing purposes', '2017-03-03 10:22:40', 1, '0000-00-00 00:00:00', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quotation_detail`
--

CREATE TABLE `quotation_detail` (
  `id` int(11) NOT NULL,
  `quotation_id` int(5) NOT NULL,
  `description` int(5) NOT NULL,
  `quantity` int(5) NOT NULL,
  `unit_price` double NOT NULL,
  `sub_total` double NOT NULL,
  `type` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `status` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation_detail`
--

INSERT INTO `quotation_detail` (`id`, `quotation_id`, `description`, `quantity`, `unit_price`, `sub_total`, `type`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `deleted`) VALUES
(4, 2, 3, 3, 4, 12, 1, '2017-02-28 14:41:25', 2, '0000-00-00 00:00:00', 0, 1, 0),
(5, 2, 3, 3, 150, 450, 0, '2017-02-28 14:41:25', 2, '0000-00-00 00:00:00', 0, 1, 0),
(6, 1, 3, 4, 15, 60, 0, '2017-03-01 12:53:09', 2, '2017-03-01 12:53:09', 2, 1, 0),
(7, 1, 1, 2, 3, 6, 1, '2017-03-01 12:53:09', 2, '2017-03-01 12:53:09', 2, 1, 0),
(8, 1, 2, 4, 5, 20, 1, '2017-03-01 12:53:09', 2, '2017-03-01 12:53:09', 2, 1, 0),
(9, 1, 4, 1, 100, 100, 0, '2017-03-01 12:53:09', 2, '2017-03-01 12:53:09', 2, 1, 0),
(10, 3, 2, 2, 4, 8, 1, '2017-03-01 17:16:32', 2, '2017-03-01 17:16:32', 2, 1, 0),
(11, 3, 1, 3, 12, 36, 0, '2017-03-01 17:16:32', 2, '2017-03-01 17:16:32', 2, 1, 0),
(12, 4, 2, 1, 1, 1, 1, '2017-03-03 10:22:40', 1, '2017-03-03 10:22:40', 1, 1, 0),
(13, 4, 3, 1, 1500, 1500, 0, '2017-03-03 10:22:40', 1, '2017-03-03 10:22:40', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `race`
--

CREATE TABLE `race` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `race`
--

INSERT INTO `race` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Filipino', 'all filipino citizen', 1, '2017-02-28 09:57:44', 2, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'developer', 1, '2017-02-07 15:10:00', 1, '0000-00-00 00:00:00', 0),
(2, 'admin', 1, '2017-02-07 15:10:00', 1, '0000-00-00 00:00:00', 0),
(3, 'sales', 1, '2017-02-07 15:10:00', 1, '0000-00-00 00:00:00', 0),
(4, 'driver', 1, '2017-02-07 15:10:00', 1, '0000-00-00 00:00:00', 0),
(5, 'technician', 1, '2017-02-07 15:10:00', 1, '0000-00-00 00:00:00', 0),
(7, 'testing', 0, '2017-04-04 11:53:06', 1, '2017-04-04 11:53:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `service_category_id` int(5) NOT NULL,
  `service_name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `service_category_id`, `service_name`, `description`, `price`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 3, 'teLstra', 'test only', 100, 1, '2017-02-03 14:30:00', 1, '0000-00-00 00:00:00', 0),
(3, 1, 'automotive', 'wheel alignment', 1500, 1, '2017-02-03 17:59:46', 1, '2017-02-03 18:00:42', 1),
(4, 1, 'breaking', 'we offer all kinds of auto parts', 100, 1, '2017-02-04 11:26:28', 1, '0000-00-00 00:00:00', 0),
(5, 1, 'qwe', 'qwerty', 250, 1, '2017-02-04 12:10:08', 1, '2017-02-04 12:11:56', 1),
(6, 3, 'testing case', '123 testing case', 100, 0, '2017-04-04 19:43:50', 1, '2017-04-04 19:44:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_category`
--

CREATE TABLE `service_category` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_category`
--

INSERT INTO `service_category` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Test', 'testing case only', 1, '2017-02-03 11:48:30', 1, '0000-00-00 00:00:00', 0),
(3, 'test case', 'for testing purposes only', 1, '2017-02-03 11:54:37', 1, '2017-02-03 11:56:32', 1),
(4, 'TESTINGs', '123 TESTing', 0, '2017-04-04 19:30:42', 1, '2017-04-04 19:31:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_group_id` int(5) NOT NULL,
  `designated_position_id` int(5) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `race_id` int(5) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_group_id`, `designated_position_id`, `fullname`, `address`, `race_id`, `email`, `mobile_number`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 1, 'JC YANGA', '148 SANCHEZ STREET MANGGAHAN COMMONWEALTH QUEZON CITY', 1, 'JCYANGA28@YAHOO.COM', '09959575415', 1, '2017-04-04 14:45:30', 1, '2017-04-04 14:46:32', 1),
(2, 3, 2, 'testing', '123 test', 1, 'test@test.com', '123456', 1, '2017-04-04 14:49:39', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff_group`
--

CREATE TABLE `staff_group` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_group`
--

INSERT INTO `staff_group` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'IT DEPARTMENT', 'ALL KNOWLEDGEABLE IN IT', 1, '2017-02-04 19:52:24', 1, '2017-02-04 19:53:23', 1),
(3, 'driver department', 'all knowledgeable in driving', 1, '2017-02-04 19:54:13', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `storage_location`
--

CREATE TABLE `storage_location` (
  `id` int(11) NOT NULL,
  `rack` varchar(50) NOT NULL,
  `bay` varchar(50) NOT NULL,
  `level` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `storage_location`
--

INSERT INTO `storage_location` (`id`, `rack`, `bay`, `level`, `position`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'A', '02', 'D', '2', 1, '2017-02-03 10:54:55', 1, '0000-00-00 00:00:00', 0),
(2, 'testing case', 'testing case', 'testing case', 'testing case', 1, '2017-02-03 10:55:26', 1, '2017-02-03 11:03:22', 1),
(3, 'B', '2', '5', 'TOP', 0, '2017-04-04 19:25:27', 1, '2017-04-04 19:25:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `supplier_code` varchar(150) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_code`, `name`, `address`, `contact_number`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'SUPPLIERS-2017-19873', 'test', '123 test', '1234567', 1, '2017-02-02 20:13:23', 1, '0000-00-00 00:00:00', 0),
(2, 'SUPPLIERS-2017-78164', 'san miguel corporation', 'san miguel avenue julia vargas pasig city', '4855585', 1, '2017-02-02 20:13:54', 1, '2017-02-03 09:42:03', 1),
(3, 'SUPPLIERS-2017-91732', 'TESTINGs', '123 TESTing', '123456', 0, '2017-04-04 19:18:47', 1, '2017-04-04 19:19:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `role_id` int(10) NOT NULL,
  `roles` int(5) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `password_hash` varchar(100) NOT NULL,
  `password_reset_token` varchar(100) NOT NULL,
  `auth_key` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `deleted` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role_id`, `roles`, `fullname`, `email`, `username`, `password`, `password_hash`, `password_reset_token`, `auth_key`, `image`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`) VALUES
(1, 1, 20, 'Jose Czar Yanga', 'jcyanga412060@gmail.com', 'jcyanga28', 'password', '$2y$13$KLYNdyN9n.CXY4uELu9Td.6LJ1BoXrXQY0dmrnb9HUMegb1dPw.YK', '', 'R5BJVsB83hg7xshurVUaXb6qYn4HrFi8', 'user.png', 1, '2017-02-02 09:20:00', 1, '0000-00-00 00:00:00', 0, 0),
(2, 1, 20, 'web developer', 'developer@firstcom.com.ph', 'developer', '', '$2y$13$Xr0Jr2bmqyRDCy0B2cuTjuLVSodQc/KAaMEiDO1Nr/AYS2.dH.uVa', '', 'xTr-fhDCnt0iz-gaaHRox_pNpQHNsbAf', 'user.png', 1, '2017-02-07 15:15:47', 1, '0000-00-00 00:00:00', 0, 0),
(3, 3, 20, 'cherry lim', 'cherrylim@yahoo.com', 'sales', 'password', '$2y$13$ee1Glhw5QiVzMrTShsTemudAtCsRfJzOMxNni6YXxD8vJWsomTcNG', '', 'xhd3Gmx23S52nzJmK_YmJ-oW8bHfn2jY', 'user.png', 1, '2017-02-24 14:48:28', 2, '0000-00-00 00:00:00', 0, 0),
(4, 3, 20, 'vicky roman', 'vickyroman@yahoo.com', 'vickyroman', 'password', '$2y$13$5ZcxbbpVqIXYbsv766qeQe0Yse5mg8MDAVLljLmzCzK//7cWcsTmy', '', 'ojvVOb7xdRQudsxky1HSpk1SCxk6F_n-', 'user.png', 1, '2017-03-27 11:00:15', 1, '0000-00-00 00:00:00', 0, 0),
(5, 3, 20, 'vicky romans', 'vickyromans@yahoo.com', 'vickyromans', 'password', '$2y$13$ilIk7RfO6r6GEv2wMtIUF.v8SZdONEMpKu/ThG6m9HrtdwnbN0eJO', '', 'Jr8BmF7PbY2jwDEn5heeJRo1ZMIcCI9X', 'user.png', 1, '2017-03-27 11:00:55', 1, '0000-00-00 00:00:00', 0, 0),
(6, 5, 20, 'testing', 'test@test.com', 'test123', 'password', '$2y$13$Am3vLOqjEuM2vQtlnScL7.cM/vGzLBnkUbkV8oO0eahIv6l/N3q7y', '', 'phEPW_szLccAF7o8ZqbgMFcM9rqLXOxi', 'user.png', 0, '2017-04-04 13:16:22', 1, '2017-04-04 13:17:18', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` int(11) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `role_id` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`id`, `controller`, `action`, `role_id`, `created_at`, `updated_at`) VALUES
(39, 'Customer', 'index', 2, '2017-02-08 16:17:08', '0000-00-00 00:00:00'),
(40, 'Customer', 'view', 2, '2017-02-08 16:17:08', '0000-00-00 00:00:00'),
(41, 'Customer', 'create', 2, '2017-02-08 16:17:08', '0000-00-00 00:00:00'),
(42, 'Customer', 'update', 2, '2017-02-08 16:17:09', '0000-00-00 00:00:00'),
(43, 'Customer', 'get-data', 2, '2017-02-08 16:17:09', '0000-00-00 00:00:00'),
(44, 'Customer', 'delete', 2, '2017-02-08 16:17:09', '0000-00-00 00:00:00'),
(45, 'Customer', 'delete-column', 2, '2017-02-08 16:17:09', '0000-00-00 00:00:00'),
(46, 'Customer', 'export-pdf', 2, '2017-02-08 16:17:09', '0000-00-00 00:00:00'),
(47, 'Customer', 'index', 1, '2017-02-24 13:49:26', '0000-00-00 00:00:00'),
(48, 'Customer', 'view', 1, '2017-02-24 13:49:26', '0000-00-00 00:00:00'),
(49, 'Customer', 'create', 1, '2017-02-24 13:49:26', '0000-00-00 00:00:00'),
(50, 'Customer', 'update', 1, '2017-02-24 13:49:26', '0000-00-00 00:00:00'),
(51, 'Customer', 'get-data', 1, '2017-02-24 13:49:26', '0000-00-00 00:00:00'),
(52, 'Customer', 'delete', 1, '2017-02-24 13:49:26', '0000-00-00 00:00:00'),
(53, 'Customer', 'delete-column', 1, '2017-02-24 13:49:26', '0000-00-00 00:00:00'),
(54, 'Customer', 'export-pdf', 1, '2017-02-24 13:49:26', '0000-00-00 00:00:00'),
(55, 'Quotation', 'index', 1, '2017-02-27 10:33:05', '0000-00-00 00:00:00'),
(56, 'Quotation', 'view', 1, '2017-02-27 10:33:05', '0000-00-00 00:00:00'),
(57, 'Quotation', 'create', 1, '2017-02-27 10:33:05', '0000-00-00 00:00:00'),
(58, 'Quotation', 'update', 1, '2017-02-27 10:33:05', '0000-00-00 00:00:00'),
(59, 'Quotation', 'delete', 1, '2017-02-27 10:33:05', '0000-00-00 00:00:00'),
(60, 'Quotation', 'get-parts-price-and-qty', 1, '2017-02-27 10:33:05', '0000-00-00 00:00:00'),
(68, 'DesignatedPosition', 'index', 1, '2017-04-04 13:34:23', '0000-00-00 00:00:00'),
(69, 'DesignatedPosition', 'view', 1, '2017-04-04 13:34:23', '0000-00-00 00:00:00'),
(70, 'DesignatedPosition', 'create', 1, '2017-04-04 13:34:23', '0000-00-00 00:00:00'),
(71, 'DesignatedPosition', 'update', 1, '2017-04-04 13:34:23', '0000-00-00 00:00:00'),
(72, 'DesignatedPosition', 'delete', 1, '2017-04-04 13:34:23', '0000-00-00 00:00:00'),
(73, 'DesignatedPosition', 'index', 2, '2017-04-04 13:34:32', '0000-00-00 00:00:00'),
(74, 'DesignatedPosition', 'view', 2, '2017-04-04 13:34:32', '0000-00-00 00:00:00'),
(75, 'DesignatedPosition', 'create', 2, '2017-04-04 13:34:32', '0000-00-00 00:00:00'),
(76, 'DesignatedPosition', 'update', 2, '2017-04-04 13:34:32', '0000-00-00 00:00:00'),
(77, 'DesignatedPosition', 'delete', 2, '2017-04-04 13:34:32', '0000-00-00 00:00:00'),
(78, 'Module', 'index', 1, '2017-04-04 13:34:49', '0000-00-00 00:00:00'),
(79, 'Module', 'view', 1, '2017-04-04 13:34:49', '0000-00-00 00:00:00'),
(80, 'Module', 'create', 1, '2017-04-04 13:34:49', '0000-00-00 00:00:00'),
(81, 'Module', 'update', 1, '2017-04-04 13:34:50', '0000-00-00 00:00:00'),
(82, 'Module', 'get-data', 1, '2017-04-04 13:34:50', '0000-00-00 00:00:00'),
(83, 'Module', 'delete', 1, '2017-04-04 13:34:50', '0000-00-00 00:00:00'),
(84, 'Module', 'delete-column', 1, '2017-04-04 13:34:50', '0000-00-00 00:00:00'),
(85, 'Module', 'export-pdf', 1, '2017-04-04 13:34:50', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fullname` (`fullname`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `company_name` (`company_name`),
  ADD KEY `fk-customer-race_id` (`race_id`);

--
-- Indexes for table `designated_position`
--
ALTER TABLE `designated_position`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `gst`
--
ALTER TABLE `gst`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_id` (`branch_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-invoice-user_id` (`user_id`),
  ADD KEY `fk-invoice-customer_id` (`customer_id`);

--
-- Indexes for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-invoice_detail-invoice_id` (`invoice_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`parts_name`),
  ADD KEY `fk-parts-parts_category_id` (`parts_category_id`);

--
-- Indexes for table `parts_category`
--
ALTER TABLE `parts_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `parts_inventory`
--
ALTER TABLE `parts_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-parts_inventory-parts_id` (`parts_id`),
  ADD KEY `fk-parts_inventory-supplier_id` (`supplier_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_name` (`product_name`),
  ADD KEY `fk-product-product_category_id` (`product_category_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `product_inventory`
--
ALTER TABLE `product_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-product_inventory-product_id` (`product_id`),
  ADD KEY `fk-product_inventory-supplier_id` (`supplier_id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-quotation-user_id` (`user_id`),
  ADD KEY `fk-quotation-customer_id` (`customer_id`);

--
-- Indexes for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-quotation_detail-quotation_id` (`quotation_id`);

--
-- Indexes for table `race`
--
ALTER TABLE `race`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`service_name`),
  ADD KEY `fk-service-service_category_id` (`service_category_id`);

--
-- Indexes for table `service_category`
--
ALTER TABLE `service_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fullname` (`fullname`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk-staff-staff_group_id` (`staff_group_id`),
  ADD KEY `fk-staff-race_id` (`race_id`),
  ADD KEY `fk-staff-designated_position_id` (`designated_position_id`);

--
-- Indexes for table `staff_group`
--
ALTER TABLE `staff_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `storage_location`
--
ALTER TABLE `storage_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supplier_code` (`supplier_code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk-user-role_id` (`role_id`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-user_permission-role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `designated_position`
--
ALTER TABLE `designated_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gst`
--
ALTER TABLE `gst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `parts_category`
--
ALTER TABLE `parts_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `parts_inventory`
--
ALTER TABLE `parts_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `product_inventory`
--
ALTER TABLE `product_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `race`
--
ALTER TABLE `race`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `service_category`
--
ALTER TABLE `service_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `staff_group`
--
ALTER TABLE `staff_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `storage_location`
--
ALTER TABLE `storage_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `fk-invoice-customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-invoice-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD CONSTRAINT `fk-invoice_detail-invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parts`
--
ALTER TABLE `parts`
  ADD CONSTRAINT `fk-parts-parts_category_id` FOREIGN KEY (`parts_category_id`) REFERENCES `parts_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parts_inventory`
--
ALTER TABLE `parts_inventory`
  ADD CONSTRAINT `fk-parts_inventory-parts_id` FOREIGN KEY (`parts_id`) REFERENCES `parts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-parts_inventory-supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk-product-product_category_id` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_inventory`
--
ALTER TABLE `product_inventory`
  ADD CONSTRAINT `fk-product_inventory-product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-product_inventory-supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quotation`
--
ALTER TABLE `quotation`
  ADD CONSTRAINT `fk-quotation-customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-quotation-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  ADD CONSTRAINT `fk-quotation_detail-quotation_id` FOREIGN KEY (`quotation_id`) REFERENCES `quotation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `fk-service-service_category_id` FOREIGN KEY (`service_category_id`) REFERENCES `service_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `fk-staff-designated_position_id` FOREIGN KEY (`designated_position_id`) REFERENCES `designated_position` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-staff-race_id` FOREIGN KEY (`race_id`) REFERENCES `race` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-staff-staff_group_id` FOREIGN KEY (`staff_group_id`) REFERENCES `staff_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk-user-role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD CONSTRAINT `fk-user_permission-role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
