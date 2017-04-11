-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2017 at 02:04 PM
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
(3, 2, '', '', 'johnny tang', '19880305ph', '25th floor bpi buendia center makati city', '25th floor bpi buendia center makati city', 1, 'johnsmith@bpi.com.ph', 2147483647, 9557545, '9551236', 1, '2017-04-04 18:39:58', 1, '0000-00-00 00:00:00', 0),
(6, 1, 'blade asia', '20101201ph', 'jaimee miyuki', '', '3rd floor pacific star building makati avenue makati city', 'blk 5 belair makati avenue makati city', 0, 'jaimeemiyuki@bladeasia.com', 8728292, 9224312, '9221236-', 1, '2017-04-08 19:46:13', 1, '0000-00-00 00:00:00', 0),
(8, 1, 'wang san corporation', '19000865sph', 'danilo ang', '', 'jackson building belair street malugay makati city', '24th street malugay makati city', 0, 'admin@wangsan.com.ph', 9557282, 9557283, '9557284', 1, '2017-04-11 16:28:33', 1, '0000-00-00 00:00:00', 0),
(9, 1, 'zu wang kim trading corporation', '18000525cph', 'jackylou zu', '', 'acascia building binondo manila', 'blk 7 lot 12 turnisia street sta cruz manila', 0, 'jackyzu@yahoo.com', 7668696, 7669616, '7668656', 1, '2017-04-11 19:53:57', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_order`
--

CREATE TABLE `delivery_order` (
  `id` int(11) NOT NULL,
  `delivery_order_code` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `user_id` int(5) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `date_issue` date NOT NULL,
  `grand_total` double NOT NULL,
  `gst` double NOT NULL,
  `gst_value` double NOT NULL,
  `net` double NOT NULL,
  `remarks` text NOT NULL,
  `payment_type_id` int(5) NOT NULL,
  `discount_amount` double NOT NULL,
  `discount_remarks` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `paid` int(5) NOT NULL,
  `deleted` int(5) NOT NULL,
  `condition` int(5) NOT NULL,
  `action_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_order`
--

INSERT INTO `delivery_order` (`id`, `delivery_order_code`, `invoice_no`, `user_id`, `customer_id`, `date_issue`, `grand_total`, `gst`, `gst_value`, `net`, `remarks`, `payment_type_id`, `discount_amount`, `discount_remarks`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `paid`, `deleted`, `condition`, `action_by`) VALUES
(1, 'DO201704001', '0', 4, 2, '2017-04-11', 770, 53.9, 7, 723.9, 'for testing case', 2, 100, 'HOLY WEEK DISCOUNT', 1, '2017-04-11 18:26:58', 1, '2017-04-11 19:35:29', 1, 0, 0, 0, 0),
(2, 'QUO201704002', '0', 4, 9, '2017-04-11', 1525, 106.75, 7, 1531.75, 'for testing purposes only', 1, 100, 'holy week discount', 1, '2017-04-11 19:55:46', 1, '0000-00-00 00:00:00', 0, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_order_detail`
--

CREATE TABLE `delivery_order_detail` (
  `id` int(11) NOT NULL,
  `delivery_order_id` int(5) NOT NULL,
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
-- Dumping data for table `delivery_order_detail`
--

INSERT INTO `delivery_order_detail` (`id`, `delivery_order_id`, `description`, `quantity`, `unit_price`, `sub_total`, `type`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`) VALUES
(4, 1, 2, 1, 120, 120, 1, 1, '2017-04-11 19:35:30', 1, '2017-04-11 19:35:30', 1, 0),
(5, 1, 3, 1, 150, 150, 1, 1, '2017-04-11 19:35:30', 1, '2017-04-11 19:35:30', 1, 0),
(6, 1, 4, 1, 500, 500, 0, 1, '2017-04-11 19:35:30', 1, '2017-04-11 19:35:30', 1, 0),
(7, 1, 4, 2, 130, 260, 1, 1, '2017-04-11 19:35:30', 1, '2017-04-11 19:35:30', 1, 0),
(8, 1, 5, 1, 750, 750, 0, 1, '2017-04-11 19:35:30', 1, '2017-04-11 19:35:30', 1, 0),
(9, 2, 5, 3, 175, 525, 1, 1, '2017-04-11 19:55:46', 1, '2017-04-11 19:55:46', 1, 0),
(10, 2, 7, 1, 1000, 1000, 0, 1, '2017-04-11 19:55:46', 1, '2017-04-11 19:55:46', 1, 0);

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
  `gst_value` double NOT NULL,
  `net` double NOT NULL,
  `remarks` text NOT NULL,
  `payment_type_id` int(5) NOT NULL,
  `discount_amount` double NOT NULL,
  `discount_remarks` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `do` int(5) NOT NULL,
  `paid` int(5) NOT NULL,
  `deleted` int(5) NOT NULL,
  `condition` int(5) NOT NULL,
  `action_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `quotation_code`, `invoice_no`, `user_id`, `customer_id`, `date_issue`, `grand_total`, `gst`, `gst_value`, `net`, `remarks`, `payment_type_id`, `discount_amount`, `discount_remarks`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `do`, `paid`, `deleted`, `condition`, `action_by`) VALUES
(1, '0', 'INV201704001', 4, 6, '2017-04-11', 1870, 130.90, 7, 1900.9, 'for testing case', 2, 100, 'SUMMER DISCOUNT', 1, '2017-04-11 15:35:00', 1, '2017-04-11 15:58:25', 1, 0, 0, 0, 0, 0),
(2, '0', 'QUO201704002', 3, 8, '2017-04-11', 680, 47.60, 7, 627.6, 'for test case', 1, 100, 'summer discount', 1, '2017-04-11 16:37:26', 1, '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0);

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
(17, 1, 1, 1, 150, 150, 1, 1, '2017-04-11 15:58:25', 1, '2017-04-11 15:58:25', 1, 0),
(18, 1, 2, 1, 120, 120, 1, 1, '2017-04-11 15:58:26', 1, '2017-04-11 15:58:26', 1, 0),
(19, 1, 6, 1, 150, 150, 1, 1, '2017-04-11 15:58:26', 1, '2017-04-11 15:58:26', 1, 0),
(20, 1, 1, 1, 250, 250, 0, 1, '2017-04-11 15:58:26', 1, '2017-04-11 15:58:26', 1, 0),
(21, 1, 3, 1, 300, 300, 0, 1, '2017-04-11 15:58:26', 1, '2017-04-11 15:58:26', 1, 0),
(22, 1, 7, 1, 900, 900, 0, 1, '2017-04-11 15:58:26', 1, '2017-04-11 15:58:26', 1, 0),
(23, 1, 4, 1, 130, 130, 1, 1, '2017-04-11 15:58:26', 1, '2017-04-11 15:58:26', 1, 0),
(24, 1, 6, 1, 100, 100, 0, 1, '2017-04-11 15:58:26', 1, '2017-04-11 15:58:26', 1, 0),
(25, 2, 2, 1, 120, 120, 1, 1, '2017-04-11 16:37:26', 1, '2017-04-11 16:37:26', 1, 0),
(26, 2, 4, 2, 130, 260, 1, 1, '2017-04-11 16:37:26', 1, '2017-04-11 16:37:26', 1, 0),
(27, 2, 3, 1, 300, 300, 0, 1, '2017-04-11 16:37:27', 1, '2017-04-11 16:37:27', 1, 0);

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
('m170404_080843_add_company_name_column_to_customer_table', 1491293392),
('m170405_025933_add_columns_to_parts_table', 1491361366),
('m170405_030356_create_supplier_foreignkey', 1491361488),
('m170405_050015_add_columns_to_parts_inventory_table', 1491368637),
('m170405_071119_add_columns_to_product_table', 1491376326),
('m170405_071334_create_supplier_to_product_foreignkey', 1491456541),
('m170406_052219_add_storage_location_id_column_to_parts_table', 1491456542),
('m170406_052726_add_columns_to_product_inventory_table', 1491456546),
('m170406_052825_add_storage_location_id_column_to_product_table', 1491456546),
('m170406_052952_create_storage_location_foreignkey', 1491456670),
('m170406_111715_add_columns_to_quotation_and_invoice_table', 1491477583),
('m170406_112007_create_payment_type_table', 1491477726),
('m170406_112228_create_payment_type_foreignkey', 1491478026),
('m170407_082009_add_condition_and_action_by_columns_to_quotation_and_invoice_table', 1491553382),
('m170410_050145_add_gst_value_column_to_quotation_and_invoice_table', 1491800613),
('m170411_083920_create_delivery_order_table', 1491900522),
('m170411_083940_create_delivery_order_detail_table', 1491900522),
('m170411_084931_create_delivery_order_foreignkey', 1491900712),
('m170411_085048_create_delivery_order_detail_foreignkey', 1491900713);

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
  `supplier_id` int(5) NOT NULL,
  `storage_location_id` int(5) NOT NULL,
  `parts_category_id` int(5) NOT NULL,
  `parts_code` varchar(100) NOT NULL,
  `parts_name` varchar(150) NOT NULL,
  `unit_of_measure` varchar(100) NOT NULL,
  `quantity` int(50) NOT NULL,
  `cost_price` double NOT NULL,
  `gst_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `reorder_level` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`id`, `supplier_id`, `storage_location_id`, `parts_category_id`, `parts_code`, `parts_name`, `unit_of_measure`, `quantity`, `cost_price`, `gst_price`, `selling_price`, `reorder_level`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 1, 1, 'parts-2017-80692', 'bumper', 'pieces', 11, 120, 7, 150, 10, 1, '2017-04-06 14:12:29', 1, '0000-00-00 00:00:00', 0),
(2, 1, 1, 1, 'parts-2017-70705', 'cowl screen', 'pieces', 19, 99, 7, 120, 10, 1, '2017-04-06 14:14:36', 1, '0000-00-00 00:00:00', 0),
(3, 2, 2, 2, 'parts-2017-76511', 'hinges', 'pieces', 19, 120, 7, 150, 10, 1, '2017-04-06 16:53:33', 1, '0000-00-00 00:00:00', 0),
(4, 2, 2, 2, 'parts-2017-20208', 'fuel tank', 'pieces', 20, 99, 7, 130, 10, 1, '2017-04-06 14:15:59', 1, '0000-00-00 00:00:00', 0),
(5, 3, 4, 4, 'parts-2017-58484', 'window regulator', 'pieces', 32, 130, 7, 175, 10, 1, '2017-04-06 14:16:36', 1, '0000-00-00 00:00:00', 0),
(6, 3, 4, 4, 'parts-2017-30373', 'window seal', 'pieces', 22, 120, 7, 150, 10, 1, '2017-04-06 14:17:20', 1, '0000-00-00 00:00:00', 0);

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
(1, 'body components', 'for body and main parts of the vehicle', 1, '2017-02-04 14:28:17', 1, '2017-04-05 13:12:48', 1),
(2, 'doors', 'for doors of the vehicle', 1, '2017-02-04 14:30:31', 1, '2017-04-05 13:13:06', 1),
(3, 'testing cases', 'for testing case only', 0, '2017-04-05 10:53:45', 1, '2017-04-05 10:55:11', 1),
(4, 'windows', 'for windows of the vehicle', 1, '2017-04-05 13:13:22', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `parts_inventory`
--

CREATE TABLE `parts_inventory` (
  `id` int(11) NOT NULL,
  `parts_id` int(5) NOT NULL,
  `old_quantity` int(25) NOT NULL,
  `new_quantity` int(25) NOT NULL,
  `qty_purchased` int(25) NOT NULL,
  `type` int(5) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `datetime_imported` datetime NOT NULL,
  `datetime_purchased` datetime NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parts_inventory`
--

INSERT INTO `parts_inventory` (`id`, `parts_id`, `old_quantity`, `new_quantity`, `qty_purchased`, `type`, `invoice_no`, `datetime_imported`, `datetime_purchased`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 25, 25, 0, 1, '', '2017-04-06 14:12:29', '0000-00-00 00:00:00', 1, '2017-04-06 14:12:29', 1, '2017-04-06 14:12:29', 1),
(2, 2, 25, 25, 0, 1, '', '2017-04-06 14:14:37', '0000-00-00 00:00:00', 1, '2017-04-06 14:14:37', 1, '2017-04-06 14:14:37', 1),
(3, 3, 35, 35, 0, 1, '', '2017-04-06 14:15:24', '0000-00-00 00:00:00', 1, '2017-04-06 14:15:24', 1, '2017-04-06 14:15:24', 1),
(4, 4, 20, 20, 0, 1, '', '2017-04-06 14:15:59', '0000-00-00 00:00:00', 1, '2017-04-06 14:15:59', 1, '2017-04-06 14:15:59', 1),
(5, 5, 30, 30, 0, 1, '', '2017-04-06 14:16:36', '0000-00-00 00:00:00', 1, '2017-04-06 14:16:36', 1, '2017-04-06 14:16:36', 1),
(6, 6, 30, 30, 0, 1, '', '2017-04-06 14:17:21', '0000-00-00 00:00:00', 1, '2017-04-06 14:17:21', 1, '2017-04-06 14:17:21', 1),
(7, 4, 20, 25, 0, 3, '', '2017-04-06 14:56:28', '0000-00-00 00:00:00', 1, '2017-04-06 14:56:28', 1, '2017-04-06 14:56:28', 1),
(8, 4, 20, 25, 0, 3, '', '2017-04-06 14:56:33', '0000-00-00 00:00:00', 1, '2017-04-06 14:56:33', 1, '2017-04-06 14:56:33', 1),
(9, 6, 30, 27, 0, 3, '', '2017-04-06 14:58:20', '0000-00-00 00:00:00', 1, '2017-04-06 14:58:20', 1, '2017-04-06 14:58:20', 1),
(10, 5, 30, 35, 0, 3, '', '2017-04-06 14:59:08', '0000-00-00 00:00:00', 1, '2017-04-06 14:59:08', 1, '2017-04-06 14:59:08', 1),
(11, 1, 25, 24, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 09:33:28', 1, '0000-00-00 00:00:00', 0),
(12, 2, 25, 24, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 09:33:28', 1, '0000-00-00 00:00:00', 0),
(13, 6, 27, 26, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 09:33:28', 1, '0000-00-00 00:00:00', 0),
(14, 1, 24, 23, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 09:34:49', 1, '0000-00-00 00:00:00', 0),
(15, 2, 24, 23, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 09:34:50', 1, '0000-00-00 00:00:00', 0),
(16, 6, 26, 25, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 09:34:50', 1, '0000-00-00 00:00:00', 0),
(17, 1, 23, 22, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 09:36:03', 1, '0000-00-00 00:00:00', 0),
(18, 2, 23, 22, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 09:36:03', 1, '0000-00-00 00:00:00', 0),
(19, 6, 25, 24, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 09:36:03', 1, '0000-00-00 00:00:00', 0),
(20, 1, 22, 21, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 10:15:05', 1, '0000-00-00 00:00:00', 0),
(21, 2, 22, 21, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 10:15:05', 1, '0000-00-00 00:00:00', 0),
(22, 6, 24, 23, 1, 2, 'INV201704001', '0000-00-00 00:00:00', '2017-04-10 00:00:00', 1, '2017-04-11 10:15:05', 1, '0000-00-00 00:00:00', 0),
(23, 3, 35, 34, 1, 3, 'INV201704003', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 12:17:03', 1, '0000-00-00 00:00:00', 0),
(24, 1, 21, 20, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 14:56:56', 1, '0000-00-00 00:00:00', 0),
(25, 6, 23, 22, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 14:56:57', 1, '0000-00-00 00:00:00', 0),
(26, 1, 20, 19, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 14:57:15', 1, '0000-00-00 00:00:00', 0),
(27, 6, 22, 21, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 14:57:15', 1, '0000-00-00 00:00:00', 0),
(28, 1, 19, 18, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 14:59:12', 1, '0000-00-00 00:00:00', 0),
(29, 3, 34, 33, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 14:59:12', 1, '0000-00-00 00:00:00', 0),
(30, 1, 18, 17, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:00:00', 1, '0000-00-00 00:00:00', 0),
(31, 3, 33, 32, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:00:01', 1, '0000-00-00 00:00:00', 0),
(32, 1, 17, 16, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:03:46', 1, '0000-00-00 00:00:00', 0),
(33, 3, 32, 30, 2, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:03:46', 1, '0000-00-00 00:00:00', 0),
(34, 1, 16, 15, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:04:27', 1, '0000-00-00 00:00:00', 0),
(35, 3, 30, 28, 2, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:04:27', 1, '0000-00-00 00:00:00', 0),
(36, 1, 15, 14, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:14:42', 1, '0000-00-00 00:00:00', 0),
(37, 3, 28, 27, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:14:42', 1, '0000-00-00 00:00:00', 0),
(38, 1, 14, 13, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:15:10', 1, '0000-00-00 00:00:00', 0),
(39, 3, 27, 26, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:15:10', 1, '0000-00-00 00:00:00', 0),
(40, 1, 13, 12, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:32:32', 1, '0000-00-00 00:00:00', 0),
(41, 3, 26, 25, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:32:32', 1, '0000-00-00 00:00:00', 0),
(42, 1, 12, 11, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:35:00', 1, '0000-00-00 00:00:00', 0),
(43, 3, 25, 24, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:35:01', 1, '0000-00-00 00:00:00', 0),
(44, 1, 12, 11, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:35:40', 1, '0000-00-00 00:00:00', 0),
(45, 3, 24, 23, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:35:40', 1, '0000-00-00 00:00:00', 0),
(46, 1, 12, 11, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:50:36', 1, '0000-00-00 00:00:00', 0),
(47, 3, 23, 22, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:50:36', 1, '0000-00-00 00:00:00', 0),
(48, 1, 12, 11, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:58:26', 1, '0000-00-00 00:00:00', 0),
(49, 2, 24, 23, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:58:26', 1, '0000-00-00 00:00:00', 0),
(50, 6, 23, 22, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:58:26', 1, '0000-00-00 00:00:00', 0),
(51, 4, 25, 24, 1, 3, 'INV201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 15:58:26', 1, '0000-00-00 00:00:00', 0),
(52, 2, 23, 22, 1, 3, 'QUO201704002', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 16:37:26', 1, '0000-00-00 00:00:00', 0),
(53, 4, 24, 22, 2, 3, 'QUO201704002', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 16:37:27', 1, '0000-00-00 00:00:00', 0),
(54, 2, 22, 20, 2, 3, 'DO201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 18:25:40', 1, '0000-00-00 00:00:00', 0),
(55, 3, 22, 20, 2, 3, 'DO201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 18:25:40', 1, '0000-00-00 00:00:00', 0),
(56, 2, 20, 19, 1, 3, 'DO201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 18:26:58', 1, '0000-00-00 00:00:00', 0),
(57, 3, 20, 19, 1, 3, 'DO201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 18:26:58', 1, '0000-00-00 00:00:00', 0),
(58, 2, 20, 19, 1, 3, 'DO201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 19:35:30', 1, '0000-00-00 00:00:00', 0),
(59, 3, 20, 19, 1, 3, 'DO201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 19:35:30', 1, '0000-00-00 00:00:00', 0),
(60, 4, 22, 20, 2, 3, 'DO201704001', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 19:35:30', 1, '0000-00-00 00:00:00', 0),
(61, 5, 35, 32, 3, 3, 'QUO201704002', '0000-00-00 00:00:00', '2017-04-11 00:00:00', 1, '2017-04-11 19:55:46', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `interest` int(5) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`id`, `name`, `description`, `interest`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'cash', 'customer need to pay thru cash payment', 0, 1, '2017-04-07 12:02:13', 1, '0000-00-00 00:00:00', 0),
(2, 'nets ', 'customer need to pay thru nets payment ', 0, 1, '2017-04-07 12:07:04', 1, '0000-00-00 00:00:00', 0),
(3, 'testing', 'testing', 5, 0, '2017-04-07 12:07:28', 1, '2017-04-07 12:08:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `supplier_id` int(5) NOT NULL,
  `storage_location_id` int(5) NOT NULL,
  `product_category_id` int(5) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `unit_of_measure` varchar(100) NOT NULL,
  `quantity` int(50) NOT NULL,
  `cost_price` double NOT NULL,
  `gst_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `reorder_level` int(10) NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `supplier_id`, `storage_location_id`, `product_category_id`, `product_code`, `product_name`, `unit_of_measure`, `quantity`, `cost_price`, `gst_price`, `selling_price`, `reorder_level`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 1, 1, 'product-2017-96678', 'blade micro fiber cleaning cloth pack of 3', 'pieces', 30, 88, 7, 100, 10, 1, '2017-04-06 15:45:43', 1, '0000-00-00 00:00:00', 0),
(2, 1, 1, 1, 'product-2017-19360', 'blade micro fiber cleaning cloth pack of 5', 'pieces', 25, 88, 7, 100, 10, 1, '2017-04-06 15:46:37', 1, '0000-00-00 00:00:00', 0),
(3, 2, 2, 3, 'product-2017-02318', 'blades tireder blacker 250ml', 'ml', 30, 120, 7, 165, 10, 1, '2017-04-06 16:57:30', 1, '0000-00-00 00:00:00', 0),
(4, 2, 2, 3, 'product-2017-96593', 'blade scratch remover 200ml', 'ml', 40, 88, 7, 120, 10, 1, '2017-04-06 15:48:01', 1, '0000-00-00 00:00:00', 0),
(5, 3, 4, 4, 'product-2017-37770', 'blade gluegun off 200ml ', 'ml', 35, 100, 7, 175, 10, 1, '2017-04-06 16:57:47', 1, '0000-00-00 00:00:00', 0),
(6, 3, 4, 4, 'product-2017-82860', 'blade wiper wash 1l blue', 'l', 35, 120, 7, 175, 10, 1, '2017-04-06 15:49:06', 1, '0000-00-00 00:00:00', 0),
(7, 4, 5, 5, 'product-2017-66351', 'bosch fc2 compacter 12v horn', 'pieces', 25, 730, 7, 850, 10, 1, '2017-04-06 16:58:17', 1, '0000-00-00 00:00:00', 0),
(8, 4, 5, 5, 'product-2017-73060', 'korsa 60bo1200 12v shell type horn', 'pieces', 40, 600, 7, 700, 10, 1, '2017-04-06 15:50:26', 1, '0000-00-00 00:00:00', 0);

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
(1, 'car care', 'all products for car caring', 1, '2017-02-04 16:58:26', 1, '2017-04-06 15:05:33', 1),
(3, 'exterior accessories', 'all kinds of external accessories', 1, '2017-02-04 17:03:34', 1, '2017-04-06 15:06:10', 1),
(4, 'interior accessories', 'all kinds of internal accessories', 1, '2017-04-06 15:06:34', 1, '0000-00-00 00:00:00', 0),
(5, 'auto electronics', 'all kinds of auto electricity', 1, '2017-04-06 15:07:15', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_inventory`
--

CREATE TABLE `product_inventory` (
  `id` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `old_quantity` int(25) NOT NULL,
  `new_quantity` int(25) NOT NULL,
  `type` int(5) NOT NULL,
  `qty_purchased` int(25) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `datetime_imported` datetime NOT NULL,
  `datetime_purchased` datetime NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_inventory`
--

INSERT INTO `product_inventory` (`id`, `product_id`, `old_quantity`, `new_quantity`, `type`, `qty_purchased`, `invoice_no`, `datetime_imported`, `datetime_purchased`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 2, 30, 30, 1, 0, '', '2017-04-06 15:46:37', '0000-00-00 00:00:00', 1, '2017-04-06 15:46:37', 1, '2017-04-06 15:46:37', 1),
(2, 3, 25, 25, 1, 0, '', '2017-04-06 15:47:31', '0000-00-00 00:00:00', 1, '2017-04-06 15:47:31', 1, '2017-04-06 15:47:31', 1),
(3, 4, 40, 40, 1, 0, '', '2017-04-06 15:48:01', '0000-00-00 00:00:00', 1, '2017-04-06 15:48:01', 1, '2017-04-06 15:48:01', 1),
(4, 5, 30, 30, 1, 0, '', '2017-04-06 15:48:26', '0000-00-00 00:00:00', 1, '2017-04-06 15:48:26', 1, '2017-04-06 15:48:26', 1),
(5, 6, 30, 30, 1, 0, '', '2017-04-06 15:49:07', '0000-00-00 00:00:00', 1, '2017-04-06 15:49:07', 1, '2017-04-06 15:49:07', 1),
(6, 7, 25, 25, 1, 0, '', '2017-04-06 15:49:51', '0000-00-00 00:00:00', 1, '2017-04-06 15:49:51', 1, '2017-04-06 15:49:51', 1),
(7, 8, 40, 40, 1, 0, '', '2017-04-06 15:50:26', '0000-00-00 00:00:00', 1, '2017-04-06 15:50:26', 1, '2017-04-06 15:50:26', 1),
(8, 2, 30, 31, 3, 0, '', '2017-04-06 17:50:55', '0000-00-00 00:00:00', 1, '2017-04-06 17:50:55', 1, '2017-04-06 17:50:55', 1),
(9, 5, 30, 32, 3, 0, '', '2017-04-06 17:50:56', '0000-00-00 00:00:00', 1, '2017-04-06 17:50:56', 1, '2017-04-06 17:50:56', 1),
(10, 3, 25, 28, 3, 0, '', '2017-04-06 17:50:56', '0000-00-00 00:00:00', 1, '2017-04-06 17:50:56', 1, '2017-04-06 17:50:56', 1),
(11, 5, 32, 35, 3, 0, '', '2017-04-06 17:51:22', '0000-00-00 00:00:00', 1, '2017-04-06 17:51:22', 1, '2017-04-06 17:51:22', 1),
(12, 6, 30, 35, 3, 0, '', '2017-04-06 17:51:22', '0000-00-00 00:00:00', 1, '2017-04-06 17:51:22', 1, '2017-04-06 17:51:22', 1),
(13, 4, 41, 40, 3, 0, '', '2017-04-06 18:26:08', '0000-00-00 00:00:00', 1, '2017-04-06 18:26:08', 1, '2017-04-06 18:26:08', 1),
(14, 2, 31, 25, 3, 0, '', '2017-04-06 18:26:20', '0000-00-00 00:00:00', 1, '2017-04-06 18:26:20', 1, '2017-04-06 18:26:20', 1),
(15, 3, 28, 30, 3, 0, '', '2017-04-06 18:26:31', '0000-00-00 00:00:00', 1, '2017-04-06 18:26:31', 1, '2017-04-06 18:26:31', 1);

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
  `gst_value` double NOT NULL,
  `net` double NOT NULL,
  `remarks` text NOT NULL,
  `payment_type_id` int(5) NOT NULL,
  `discount_amount` double NOT NULL,
  `discount_remarks` text NOT NULL,
  `status` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(5) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(5) NOT NULL,
  `invoice_created` int(5) NOT NULL,
  `deleted` int(5) NOT NULL,
  `condition` int(5) NOT NULL,
  `action_by` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`id`, `quotation_code`, `user_id`, `customer_id`, `date_issue`, `grand_total`, `gst`, `gst_value`, `net`, `remarks`, `payment_type_id`, `discount_amount`, `discount_remarks`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `invoice_created`, `deleted`, `condition`, `action_by`) VALUES
(1, 'QUO201704001', 3, 2, '2017-04-10', 850, 59.5, 7, 909.5, 'FOR TEST CASE', 1, 0, 'NO DISCOUNT REMARKS', 1, '2017-04-10 19:26:25', 1, '0000-00-00 00:00:00', 0, 0, 0, 0, 0),
(2, 'QUO201704002', 3, 3, '2017-04-10', 445, 31.15, 7, 476.15, 'test', 1, 0, 'No discount remarks', 1, '2017-04-11 09:02:08', 1, '0000-00-00 00:00:00', 0, 0, 0, 0, 0);

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
(13, 1, 1, 1, 150, 150, 1, '2017-04-10 19:26:25', 1, '2017-04-10 19:26:25', 1, 1, 0),
(14, 1, 2, 1, 150, 150, 1, '2017-04-10 19:26:25', 1, '2017-04-10 19:26:25', 1, 1, 0),
(15, 1, 3, 1, 250, 250, 0, '2017-04-10 19:26:26', 1, '2017-04-10 19:26:26', 1, 1, 0),
(16, 1, 4, 1, 300, 300, 0, '2017-04-10 19:26:26', 1, '2017-04-10 19:26:26', 1, 1, 0),
(17, 1, 6, 1, 150, 150, 1, '2017-04-10 19:26:26', 1, '2017-04-10 19:26:26', 1, 1, 0),
(18, 1, 1, 1, 250, 250, 0, '2017-04-10 19:26:26', 1, '2017-04-10 19:26:26', 1, 1, 0),
(19, 2, 1, 1, 150, 150, 1, '2017-04-11 09:02:08', 1, '2017-04-11 09:02:08', 1, 1, 0),
(20, 2, 2, 1, 120, 120, 1, '2017-04-11 09:02:08', 1, '2017-04-11 09:02:08', 1, 1, 0),
(21, 2, 5, 1, 175, 175, 1, '2017-04-11 09:02:08', 1, '2017-04-11 09:02:08', 1, 1, 0);

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
(1, 'Filipino', 'all filipino citizen', 1, '2017-02-28 09:57:44', 2, '0000-00-00 00:00:00', 0),
(2, 'singaporean', 'all singapore citizen', 1, '2017-04-07 11:31:04', 1, '2017-04-07 11:31:20', 1),
(3, 'malaysian', 'all malaysia citizen', 1, '2017-04-07 11:31:37', 1, '0000-00-00 00:00:00', 0),
(4, 'test', 'testing', 0, '2017-04-07 11:31:54', 1, '0000-00-00 00:00:00', 0);

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
(1, 3, 'rentals of forklifter', 'renting of forklifts', 250, 1, '2017-02-03 14:30:00', 1, '2017-04-06 14:20:06', 1),
(3, 5, 'forklift solid tyre', 'checking of all forklift tyres', 300, 1, '2017-02-03 17:59:46', 1, '2017-04-06 14:21:01', 1),
(4, 5, 'forklift maintenance and servicing ', 'all service that needed a forklift', 500, 1, '2017-02-04 11:26:28', 1, '2017-04-06 14:21:32', 1),
(5, 6, 'trader in or scrapped of used lorries', 'trading of non usable lorries', 750, 1, '2017-02-04 12:10:08', 1, '2017-04-06 14:23:45', 1),
(6, 3, 'testing case', '123 testing case', 100, 0, '2017-04-04 19:43:50', 1, '2017-04-04 19:44:37', 1),
(7, 6, 'trades in scrapped of used forklift', 'trading of non usable forklifts', 900, 1, '2017-04-06 14:23:19', 1, '0000-00-00 00:00:00', 0);

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
(1, 'sales', 'selling of forklift', 1, '2017-02-03 11:48:30', 1, '2017-04-06 14:17:57', 1),
(3, 'rental', 'renting of forklift', 1, '2017-02-03 11:54:37', 1, '2017-04-06 14:18:14', 1),
(4, 'TESTINGs', '123 TESTing', 0, '2017-04-04 19:30:42', 1, '2017-04-04 19:31:02', 1),
(5, 'servicing', 'all kinds of service with forklift', 1, '2017-04-06 14:18:54', 1, '0000-00-00 00:00:00', 0),
(6, 'trade in', 'trading of items that needed forklift', 1, '2017-04-06 14:19:30', 1, '0000-00-00 00:00:00', 0);

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
(1, 'a', 'a1', '1', 'bottom', 1, '2017-02-03 10:54:55', 1, '2017-04-06 14:02:19', 1),
(2, 'a', 'a2', '2', 'bottom', 1, '2017-02-03 10:55:26', 1, '2017-04-06 14:02:41', 1),
(4, 'a', 'a3', '3', 'middle', 1, '2017-04-06 14:03:00', 1, '0000-00-00 00:00:00', 0),
(5, 'a', 'a4', '4', 'middle', 1, '2017-04-06 14:03:15', 1, '0000-00-00 00:00:00', 0),
(6, 'a', 'a5', '5', 'top', 1, '2017-04-06 14:03:24', 1, '0000-00-00 00:00:00', 0);

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
(1, 'suppliers-2017-60189', 'advance automotive center', '2734e taft avenue ext pasay city', '028311296', 1, '2017-04-06 13:58:37', 1, '0000-00-00 00:00:00', 0),
(2, 'suppliers-2017-82599', 'alto motor parts', '385d banawe st qc', '027113053', 1, '2017-04-06 13:59:06', 1, '0000-00-00 00:00:00', 0),
(3, 'suppliers-2017-54287', 'atco auto supply', '275860 taft avenue extension pasay city', '028316365', 1, '2017-04-06 13:59:35', 1, '0000-00-00 00:00:00', 0),
(4, 'suppliers-2017-35259', 'autospecs motor sales', '37h banawe st qc', '027115046', 1, '2017-04-06 13:59:59', 1, '0000-00-00 00:00:00', 0),
(5, 'suppliers-2017-10441', 'bbw sales international', '35b banawe st qc', '027417906', 1, '2017-04-06 14:00:29', 1, '0000-00-00 00:00:00', 0);

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
-- Indexes for table `delivery_order`
--
ALTER TABLE `delivery_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-delivery_order-user_id` (`user_id`),
  ADD KEY `fk-delivery_order-customer_id` (`customer_id`);

--
-- Indexes for table `delivery_order_detail`
--
ALTER TABLE `delivery_order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-delivery_order_detail-delivery_order_id` (`delivery_order_id`);

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
  ADD KEY `fk-invoice-customer_id` (`customer_id`),
  ADD KEY `fk-invoice-payment_type_id` (`payment_type_id`);

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
  ADD KEY `fk-parts-parts_category_id` (`parts_category_id`),
  ADD KEY `fk-parts-supplier_id` (`supplier_id`),
  ADD KEY `fk-parts-storage_location_id` (`storage_location_id`);

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
  ADD KEY `fk-parts_inventory-parts_id` (`parts_id`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_name` (`product_name`),
  ADD KEY `fk-product-product_category_id` (`product_category_id`),
  ADD KEY `fk-product-supplier_id` (`supplier_id`),
  ADD KEY `fk-product-storage_location_id` (`storage_location_id`);

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
  ADD KEY `fk-product_inventory-product_id` (`product_id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-quotation-user_id` (`user_id`),
  ADD KEY `fk-quotation-customer_id` (`customer_id`),
  ADD KEY `fk-quotation-payment_type_id` (`payment_type_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `delivery_order`
--
ALTER TABLE `delivery_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `delivery_order_detail`
--
ALTER TABLE `delivery_order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `parts_category`
--
ALTER TABLE `parts_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `parts_inventory`
--
ALTER TABLE `parts_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `product_inventory`
--
ALTER TABLE `product_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `race`
--
ALTER TABLE `race`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `service_category`
--
ALTER TABLE `service_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
-- Constraints for table `delivery_order`
--
ALTER TABLE `delivery_order`
  ADD CONSTRAINT `fk-delivery_order-customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-delivery_order-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery_order_detail`
--
ALTER TABLE `delivery_order_detail`
  ADD CONSTRAINT `fk-delivery_order_detail-delivery_order_id` FOREIGN KEY (`delivery_order_id`) REFERENCES `delivery_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `fk-invoice-customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-invoice-payment_type_id` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  ADD CONSTRAINT `fk-parts-parts_category_id` FOREIGN KEY (`parts_category_id`) REFERENCES `parts_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-parts-storage_location_id` FOREIGN KEY (`storage_location_id`) REFERENCES `storage_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-parts-supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parts_inventory`
--
ALTER TABLE `parts_inventory`
  ADD CONSTRAINT `fk-parts_inventory-parts_id` FOREIGN KEY (`parts_id`) REFERENCES `parts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk-product-product_category_id` FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-product-storage_location_id` FOREIGN KEY (`storage_location_id`) REFERENCES `storage_location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-product-supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_inventory`
--
ALTER TABLE `product_inventory`
  ADD CONSTRAINT `fk-product_inventory-product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quotation`
--
ALTER TABLE `quotation`
  ADD CONSTRAINT `fk-quotation-customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-quotation-payment_type_id` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
