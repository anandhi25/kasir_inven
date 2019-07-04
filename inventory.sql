-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 04, 2019 at 12:51 PM
-- Server version: 5.6.34-log
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('7256d138593679ea4bf4e79f34330d80', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', 1561324656, 'a:11:{s:9:\"user_data\";s:0:\"\";s:9:\"user_name\";s:5:\"admin\";s:4:\"name\";s:13:\"Administrator\";s:11:\"employee_id\";s:1:\"0\";s:17:\"employee_login_id\";s:1:\"0\";s:8:\"loggedin\";b:1;s:9:\"user_type\";s:1:\"1\";s:8:\"user_pic\";s:0:\"\";s:3:\"url\";s:15:\"admin/dashboard\";s:14:\"menu_active_id\";a:3:{i:0;s:2:\"27\";i:1;s:2:\"25\";i:2;s:1:\"0\";}s:13:\"business_info\";a:0:{}}'),
('f11788c2c8c7fe94eebf76f3059c35af', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', 1561325152, 'a:11:{s:9:\"user_data\";s:0:\"\";s:9:\"user_name\";s:5:\"admin\";s:4:\"name\";s:13:\"Administrator\";s:11:\"employee_id\";s:1:\"0\";s:17:\"employee_login_id\";s:1:\"0\";s:8:\"loggedin\";b:1;s:9:\"user_type\";s:1:\"1\";s:8:\"user_pic\";s:0:\"\";s:3:\"url\";s:15:\"admin/dashboard\";s:14:\"menu_active_id\";a:3:{i:0;s:2:\"27\";i:1;s:2:\"25\";i:2;s:1:\"0\";}s:13:\"business_info\";a:0:{}}');

-- --------------------------------------------------------

--
-- Table structure for table `installer`
--

CREATE TABLE `installer` (
  `id` int(1) NOT NULL,
  `installer_flag` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `installer`
--

INSERT INTO `installer` (`id`, `installer_flag`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attribute`
--

CREATE TABLE `tbl_attribute` (
  `attribute_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `attribute_name` varchar(100) NOT NULL,
  `attribute_value` text NOT NULL,
  `attribute_set_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_attribute`
--

INSERT INTO `tbl_attribute` (`attribute_id`, `product_id`, `attribute_name`, `attribute_value`, `attribute_set_id`) VALUES
(1, 6, 'Warna', 'Merah', 1),
(2, 7, 'Ukuran', '5 Kg', 3),
(3, 7, 'Ukuran', '3 kg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attribute_set`
--

CREATE TABLE `tbl_attribute_set` (
  `attribute_set_id` int(11) NOT NULL,
  `attribute_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_attribute_set`
--

INSERT INTO `tbl_attribute_set` (`attribute_set_id`, `attribute_name`) VALUES
(1, 'Warna'),
(3, 'Ukuran');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brand_id` int(11) NOT NULL,
  `name` longtext,
  `description` longtext,
  `logo` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_brand`
--

INSERT INTO `tbl_brand` (`brand_id`, `name`, `description`, `logo`) VALUES
(1, 'Asus', 'Brand Buat Asus', 'img/uploads/asus.png'),
(2, 'Sumo', 'Merek beras', 'img/uploads/beras-sumo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_business_profile`
--

CREATE TABLE `tbl_business_profile` (
  `business_profile_id` int(2) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `logo` varchar(150) DEFAULT NULL,
  `full_path` varchar(150) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `tax_sale` int(11) NOT NULL,
  `tax_purchase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_business_profile`
--

INSERT INTO `tbl_business_profile` (`business_profile_id`, `company_name`, `logo`, `full_path`, `email`, `address`, `phone`, `currency`, `tax_sale`, `tax_purchase`) VALUES
(1, 'Sembakoku', NULL, NULL, 'admin@sembakoku.co.id', 'Sidoarjo', '03158555555', 'Rp', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campaign`
--

CREATE TABLE `tbl_campaign` (
  `campaign_id` int(11) NOT NULL,
  `campaign_name` varchar(128) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `email_body` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campaign_result`
--

CREATE TABLE `tbl_campaign_result` (
  `campaign_result_id` int(11) NOT NULL,
  `campaign_id` int(10) NOT NULL,
  `campaign_name` varchar(128) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `send_by` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(5) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cat_icon` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`, `created_datetime`, `cat_icon`) VALUES
(1, 'Sembako', '2019-06-25 06:58:21', 'img/uploads/no-category.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_code` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `discount` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`customer_id`, `customer_code`, `customer_name`, `email`, `phone`, `address`, `discount`) VALUES
(1, 256332332, 'Robby Geisha', 'robby@gmail.com', '0189282992', '', '0'),
(2, 8727152, 'Rio', 'rio@gmail.com', '098192882822', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_damage_product`
--

CREATE TABLE `tbl_damage_product` (
  `damage_product_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `product_name` varchar(127) NOT NULL,
  `category` varchar(128) NOT NULL,
  `qty` int(5) NOT NULL,
  `note` text NOT NULL,
  `decrease` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0= no; 1= yes',
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory`
--

CREATE TABLE `tbl_inventory` (
  `inventory_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `product_quantity` int(5) NOT NULL,
  `notify_quantity` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_inventory`
--

INSERT INTO `tbl_inventory` (`inventory_id`, `product_id`, `product_quantity`, `notify_quantity`) VALUES
(1, 6, 10, 2),
(2, 7, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `invoice_id` int(5) NOT NULL,
  `invoice_no` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `menu_id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `parent` int(5) NOT NULL,
  `sort` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`menu_id`, `label`, `link`, `icon`, `parent`, `sort`) VALUES
(1, 'Dashboard', 'admin/dashboard', 'fa fa-dashboard', 0, 1),
(2, 'Settings', '#', 'fa fa-cogs', 0, 15),
(3, 'Business Profile', 'admin/settings/business_profile', 'glyphicon glyphicon-briefcase', 2, 1),
(4, 'Employee Management', '#', 'entypo-users', 0, 20),
(5, 'Employee List', 'admin/employee/employee_list', 'fa fa-users', 4, 1),
(6, 'Add Employee', 'admin/employee/add_employee', 'entypo-user-add', 4, 2),
(7, 'Product', '#', 'glyphicon glyphicon-th-large', 0, 5),
(8, 'Category', '#', 'glyphicon glyphicon-indent-left', 7, 4),
(9, 'Product Category', 'admin/product/category', 'glyphicon glyphicon-tag', 8, 1),
(10, 'Sub Category', 'admin/product/subcategory', 'glyphicon glyphicon-tags', 8, 2),
(13, 'Add Product', 'admin/product/add_product', 'glyphicon glyphicon-plus', 7, 1),
(14, 'Manage Product', 'admin/product/manage_product', 'glyphicon glyphicon-th-list', 7, 2),
(17, 'Manage Tax Rules', 'admin/settings/tax', 'glyphicon glyphicon-credit-card', 2, 2),
(18, 'Manage Purchase', '#', 'fa fa-truck', 0, 3),
(19, 'Supplier', '#', 'glyphicon glyphicon-gift', 18, 1),
(20, 'Add Supplier', 'admin/purchase/add_supplier', 'glyphicon glyphicon-plus', 19, 1),
(21, 'Manage Supplier', 'admin/purchase/manage_supplier', 'glyphicon glyphicon-briefcase', 19, 2),
(22, 'Purchase', '#', 'glyphicon glyphicon-credit-card', 18, 2),
(23, 'New Purchase', 'admin/purchase/new_purchase', 'glyphicon glyphicon-shopping-cart', 22, 1),
(24, 'Purchase History', 'admin/purchase/purchase_list', 'glyphicon glyphicon-th-list', 22, 2),
(25, 'Customer', '', 'glyphicon glyphicon-user', 0, 7),
(26, 'Add Customer', 'admin/customer/add_customer', 'glyphicon glyphicon-plus', 25, 1),
(27, 'Manage Customer', 'admin/customer/manage_customer', 'glyphicon glyphicon-th-list', 25, 2),
(28, 'Damage Product', 'admin/product/damage_product', 'glyphicon glyphicon-trash', 7, 3),
(29, 'Barcode Print', 'admin/product/print_barcode', 'glyphicon glyphicon-barcode', 7, 3),
(30, 'Order Process', '#', 'glyphicon glyphicon-shopping-cart', 0, 6),
(31, 'New Order', 'admin/order/new_order', 'fa fa-cart-plus', 30, 1),
(32, 'Manage Order', 'admin/order/manage_order', 'glyphicon glyphicon-th-list', 30, 2),
(33, 'Manage Invoice', 'admin/order/manage_invoice', 'glyphicon glyphicon-list-alt', 30, 3),
(34, 'Report', 'admin/report', 'glyphicon glyphicon-signal', 0, 8),
(35, 'Sales Report', 'admin/report/sales_report', 'fa fa-bar-chart', 34, 1),
(36, 'Purchase Report', 'admin/report/purchase_report', 'fa fa-line-chart', 34, 2),
(37, 'Email Campaign', '#', 'glyphicon glyphicon-send', 0, 8),
(38, 'New campaign', 'admin/campaign/new_campaign', 'glyphicon glyphicon-envelope', 37, 1),
(39, 'Manage Campaign', 'admin/campaign/manage_campaign', 'glyphicon glyphicon-th-list', 37, 2),
(40, 'Camaign Result', 'admin/campaign/campaign_result', 'glyphicon glyphicon-bullhorn', 37, 3),
(41, 'Outlet', 'admin/settings/outlet', 'fa fa-home', 2, 3),
(42, 'Brand', 'admin/product/brand', 'fa fa-globe', 7, 4),
(43, 'Variasi', 'admin/product/variasi', 'fa fa-list-alt', 7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(11) NOT NULL,
  `order_no` int(10) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(128) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(100) NOT NULL,
  `customer_address` text NOT NULL,
  `shipping_address` text NOT NULL,
  `sub_total` double NOT NULL,
  `discount` double NOT NULL,
  `discount_amount` double NOT NULL,
  `total_tax` double NOT NULL,
  `grand_total` double NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `payment_ref` varchar(120) NOT NULL,
  `order_status` int(2) NOT NULL DEFAULT '0' COMMENT '0= pending; 1= cancel; 2=confirm',
  `note` text NOT NULL,
  `sales_person` varchar(100) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `uang_muka` double NOT NULL,
  `jatuh_tempo` varchar(65) DEFAULT NULL,
  `discount_type` varchar(65) DEFAULT NULL,
  `persen_pajak` decimal(10,0) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_attribute`
--

CREATE TABLE `tbl_order_attribute` (
  `id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `order_detail_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_details`
--

CREATE TABLE `tbl_order_details` (
  `order_details_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `product_code` int(10) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `product_quantity` int(5) NOT NULL,
  `buying_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `product_tax` double NOT NULL,
  `sub_total` double NOT NULL,
  `price_option` varchar(100) NOT NULL,
  `purchase_product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_serial`
--

CREATE TABLE `tbl_order_serial` (
  `id` int(11) NOT NULL,
  `serial_no` varchar(254) NOT NULL,
  `order_detail_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_outlets`
--

CREATE TABLE `tbl_outlets` (
  `id` int(11) NOT NULL,
  `name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `receipt_header` longtext COLLATE utf8_unicode_ci NOT NULL,
  `receipt_footer` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(11) NOT NULL COMMENT '1: Active, 0: Inactive'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_outlets`
--

INSERT INTO `tbl_outlets` (`id`, `name`, `address`, `contact_number`, `receipt_header`, `receipt_footer`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES
(1, 'Uniqlo - NEX Outlet', '#02-11, B2, Nex Shopping Mall, Serangoon Central', '88837492', '', '<p>Thank you for coming!</p>', 1, '2016-09-11 19:24:33', 0, '0000-00-00 00:00:00', 1),
(2, 'Uniqlo - Changi Outlet', '#02, B2, Changi Airport', '92828394', '', '<p>Thank you for coming!</p>', 1, '2016-09-11 19:25:13', 0, '0000-00-00 00:00:00', 1),
(4, 'GKB', 'GKB Gresik', '0911919', '', '', 0, '2019-06-24 03:42:58', 0, '2019-06-25 05:09:58', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_note` text NOT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '0=Inactive,1=Active',
  `subcategory_id` int(5) NOT NULL,
  `barcode_path` varchar(300) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `serial` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `product_code`, `product_name`, `product_note`, `status`, `subcategory_id`, `barcode_path`, `barcode`, `tax_id`, `serial`, `brand_id`, `category_id`) VALUES
(6, '44433356', 'Beras Sumo Super Premium 20kg', 'Beras Sumo Super Premium 20kg', 1, 1, 'D:\\htdocs\\inventory/img/barcode/44433356.jpg', 'img/barcode/44433356.jpg', 0, 0, 2, 1),
(7, '58186047', 'Beras Rojo Lele', 'Produk Buat Rojo Lele', 1, 1, 'D:\\htdocs\\inventory/img/barcode/58186047.jpg', 'img/barcode/58186047.jpg', 0, 0, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_image`
--

CREATE TABLE `tbl_product_image` (
  `product_image_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `image_path` varchar(300) NOT NULL,
  `filename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product_image`
--

INSERT INTO `tbl_product_image` (`product_image_id`, `product_id`, `image_path`, `filename`) VALUES
(1, 6, 'D:/htdocs/inventory/img/uploads/beras-sumo1.jpg', 'img/uploads/beras-sumo1.jpg'),
(2, 7, 'D:/htdocs/inventory/img/uploads/beras-rojo-lele.jpg', 'img/uploads/beras-rojo-lele.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_price`
--

CREATE TABLE `tbl_product_price` (
  `product_price_id` int(11) NOT NULL,
  `product_id` int(5) NOT NULL,
  `buying_price` double NOT NULL,
  `selling_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product_price`
--

INSERT INTO `tbl_product_price` (`product_price_id`, `product_id`, `buying_price`, `selling_price`) VALUES
(1, 6, 250000, 256000),
(2, 7, 35000, 37000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_tag`
--

CREATE TABLE `tbl_product_tag` (
  `product_tag_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_product_tag`
--

INSERT INTO `tbl_product_tag` (`product_tag_id`, `product_id`, `tag`) VALUES
(1, 6, 'sumo'),
(2, 6, 'beras'),
(3, 7, 'beras'),
(4, 7, 'rojolele');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase`
--

CREATE TABLE `tbl_purchase` (
  `purchase_id` int(11) NOT NULL,
  `purchase_order_number` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(128) NOT NULL,
  `grand_total` int(5) NOT NULL,
  `purchase_ref` varchar(128) NOT NULL,
  `payment_method` varchar(128) NOT NULL,
  `payment_ref` varchar(128) NOT NULL,
  `purchase_by` varchar(100) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `outlet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_product`
--

CREATE TABLE `tbl_purchase_product` (
  `purchase_product_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `qty` int(5) NOT NULL,
  `unit_price` int(5) NOT NULL,
  `sub_total` int(5) NOT NULL,
  `sisa_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_special_offer`
--

CREATE TABLE `tbl_special_offer` (
  `special_offer_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `offer_price` double DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategory`
--

CREATE TABLE `tbl_subcategory` (
  `subcategory_id` int(5) NOT NULL,
  `category_id` int(5) NOT NULL,
  `subcategory_name` varchar(100) NOT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sub_icon` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_subcategory`
--

INSERT INTO `tbl_subcategory` (`subcategory_id`, `category_id`, `subcategory_name`, `created_datetime`, `sub_icon`) VALUES
(1, 1, 'Beras', '2019-06-25 09:13:03', 'img/uploads/beras.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `supplier_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`supplier_id`, `company_name`, `supplier_name`, `email`, `phone`, `address`) VALUES
(1, 'PT Jaya Baru', 'Jaya Baru', 'jayabaru@gmail.com', '081728272288', 'Jl Makasar 90');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tag`
--

CREATE TABLE `tbl_tag` (
  `tag_id` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tag`
--

INSERT INTO `tbl_tag` (`tag_id`, `tag`) VALUES
(1, 'sumo'),
(2, 'beras'),
(3, 'rojolele');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tax`
--

CREATE TABLE `tbl_tax` (
  `tax_id` int(11) NOT NULL,
  `tax_title` varchar(100) NOT NULL,
  `tax_rate` double NOT NULL,
  `tax_type` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tax`
--

INSERT INTO `tbl_tax` (`tax_id`, `tax_title`, `tax_rate`, `tax_type`) VALUES
(1, 'PPN', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tier_price`
--

CREATE TABLE `tbl_tier_price` (
  `tier_price_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `tier_price` double NOT NULL,
  `quantity_above` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(5) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `filename` varchar(128) NOT NULL,
  `image_path` varchar(128) NOT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT '0',
  `outlet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `name`, `email`, `password`, `filename`, `image_path`, `flag`, `outlet_id`) VALUES
(0, 'admin', 'Administrator', 'eltech@yahoo.com', '17ada7ce7a6a9f01f0aabbb431321d365b01a3e3474f107562e738afbfe0c13abf9ea7ee61e22c990912fd2bc5ef0e4c657b4c82f132bf8e79f6dacb14d3c466', '', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_role`
--

CREATE TABLE `tbl_user_role` (
  `user_role_id` int(11) NOT NULL,
  `employee_login_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `tbl_attribute`
--
ALTER TABLE `tbl_attribute`
  ADD PRIMARY KEY (`attribute_id`);

--
-- Indexes for table `tbl_attribute_set`
--
ALTER TABLE `tbl_attribute_set`
  ADD PRIMARY KEY (`attribute_set_id`);

--
-- Indexes for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `tbl_business_profile`
--
ALTER TABLE `tbl_business_profile`
  ADD PRIMARY KEY (`business_profile_id`);

--
-- Indexes for table `tbl_campaign`
--
ALTER TABLE `tbl_campaign`
  ADD PRIMARY KEY (`campaign_id`);

--
-- Indexes for table `tbl_campaign_result`
--
ALTER TABLE `tbl_campaign_result`
  ADD PRIMARY KEY (`campaign_result_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `tbl_damage_product`
--
ALTER TABLE `tbl_damage_product`
  ADD PRIMARY KEY (`damage_product_id`);

--
-- Indexes for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_order_attribute`
--
ALTER TABLE `tbl_order_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  ADD PRIMARY KEY (`order_details_id`);

--
-- Indexes for table `tbl_order_serial`
--
ALTER TABLE `tbl_order_serial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_outlets`
--
ALTER TABLE `tbl_outlets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tbl_product_image`
--
ALTER TABLE `tbl_product_image`
  ADD PRIMARY KEY (`product_image_id`);

--
-- Indexes for table `tbl_product_price`
--
ALTER TABLE `tbl_product_price`
  ADD PRIMARY KEY (`product_price_id`);

--
-- Indexes for table `tbl_product_tag`
--
ALTER TABLE `tbl_product_tag`
  ADD PRIMARY KEY (`product_tag_id`);

--
-- Indexes for table `tbl_purchase`
--
ALTER TABLE `tbl_purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `tbl_purchase_product`
--
ALTER TABLE `tbl_purchase_product`
  ADD PRIMARY KEY (`purchase_product_id`);

--
-- Indexes for table `tbl_special_offer`
--
ALTER TABLE `tbl_special_offer`
  ADD PRIMARY KEY (`special_offer_id`);

--
-- Indexes for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  ADD PRIMARY KEY (`subcategory_id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tbl_tag`
--
ALTER TABLE `tbl_tag`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `tbl_tax`
--
ALTER TABLE `tbl_tax`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `tbl_tier_price`
--
ALTER TABLE `tbl_tier_price`
  ADD PRIMARY KEY (`tier_price_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  ADD PRIMARY KEY (`user_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attribute`
--
ALTER TABLE `tbl_attribute`
  MODIFY `attribute_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_attribute_set`
--
ALTER TABLE `tbl_attribute_set`
  MODIFY `attribute_set_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_business_profile`
--
ALTER TABLE `tbl_business_profile`
  MODIFY `business_profile_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_campaign`
--
ALTER TABLE `tbl_campaign`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_campaign_result`
--
ALTER TABLE `tbl_campaign_result`
  MODIFY `campaign_result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_damage_product`
--
ALTER TABLE `tbl_damage_product`
  MODIFY `damage_product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  MODIFY `inventory_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `invoice_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_attribute`
--
ALTER TABLE `tbl_order_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  MODIFY `order_details_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_serial`
--
ALTER TABLE `tbl_order_serial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_outlets`
--
ALTER TABLE `tbl_outlets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_product_image`
--
ALTER TABLE `tbl_product_image`
  MODIFY `product_image_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_product_price`
--
ALTER TABLE `tbl_product_price`
  MODIFY `product_price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_product_tag`
--
ALTER TABLE `tbl_product_tag`
  MODIFY `product_tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_purchase`
--
ALTER TABLE `tbl_purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchase_product`
--
ALTER TABLE `tbl_purchase_product`
  MODIFY `purchase_product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_special_offer`
--
ALTER TABLE `tbl_special_offer`
  MODIFY `special_offer_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  MODIFY `subcategory_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_tag`
--
ALTER TABLE `tbl_tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_tax`
--
ALTER TABLE `tbl_tax`
  MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_tier_price`
--
ALTER TABLE `tbl_tier_price`
  MODIFY `tier_price_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
