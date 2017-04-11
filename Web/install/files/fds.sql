-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2017 at 06:41 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fdsbeta`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role_id` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL,
  `last_ip` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(255) NOT NULL,
  `options` text NOT NULL,
  `option_yesno` text NOT NULL,
  `option_notype` text NOT NULL,
  `option_notype_title` text NOT NULL,
  `title_custom` text NOT NULL,
  `menu_id` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `cart_type` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=147 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_code`
--

CREATE TABLE IF NOT EXISTS `coupon_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `status` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_detail`
--

CREATE TABLE IF NOT EXISTS `delivery_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_margin` varchar(255) NOT NULL,
  `delivery_charges` varchar(255) NOT NULL,
  `status` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_email` varchar(255) NOT NULL,
  `admin_email_pass` varchar(255) NOT NULL,
  `order_email` varchar(255) NOT NULL,
  `order_email_pass` varchar(255) NOT NULL,
  `info_email` varchar(255) NOT NULL,
  `info_email_pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `loyalty_points`
--

CREATE TABLE IF NOT EXISTS `loyalty_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loyalty_margin` varchar(255) NOT NULL,
  `loyalty_percent` varchar(255) NOT NULL,
  `status` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `featured_product` int(11) NOT NULL,
  `required_options` int(4) NOT NULL,
  `image` varchar(255) NOT NULL,
  `options_with_type` text NOT NULL,
  `integrate_cat_id` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu_custom_option`
--

CREATE TABLE IF NOT EXISTS `menu_custom_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `price` text NOT NULL,
  `option_with_type` text NOT NULL,
  `menu_id` varchar(500) NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu_option_type_no`
--

CREATE TABLE IF NOT EXISTS `menu_option_type_no` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `option_id` varchar(255) NOT NULL,
  `menu_id` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mobile_setting`
--

CREATE TABLE IF NOT EXISTS `mobile_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `mobile_token`
--

CREATE TABLE IF NOT EXISTS `mobile_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) NOT NULL,
  `device_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `option`
--

CREATE TABLE IF NOT EXISTS `option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `type_id` int(11) NOT NULL,
  `is_yes_no` int(11) NOT NULL,
  `input_type` text NOT NULL,
  `price_option` float NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `option_menu`
--

CREATE TABLE IF NOT EXISTS `option_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `price` float NOT NULL,
  `sort_order` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `option_notype_cart`
--

CREATE TABLE IF NOT EXISTS `option_notype_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(255) NOT NULL,
  `option_notype_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `option_type`
--

CREATE TABLE IF NOT EXISTS `option_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_detail_id` text NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `options` text NOT NULL,
  `option_yesno` text NOT NULL,
  `option_notype` text NOT NULL,
  `option_notype_title` text NOT NULL,
  `title_custom` text NOT NULL,
  `price` text NOT NULL,
  `price_all` text NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `about_order` text NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `pay_money_method` varchar(255) NOT NULL,
  `delivery_charges` int(4) NOT NULL,
  `discount` int(4) NOT NULL,
  `decline_reason` text NOT NULL,
  `order_time` text NOT NULL,
  `date_created` datetime NOT NULL,
  `status` int(8) NOT NULL,
  `email_send` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `permission_id` int(8) NOT NULL AUTO_INCREMENT,
  `role_id` int(8) NOT NULL,
  `category` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `created_by` int(8) NOT NULL,
  `modified_by` int(8) NOT NULL,
  `options` tinyint(4) NOT NULL,
  `loyaltypoint` tinyint(4) NOT NULL,
  `couponcode` tinyint(4) NOT NULL,
  `optiontype` tinyint(4) NOT NULL,
  `roles_management` tinyint(4) NOT NULL,
  `postcode` tinyint(4) NOT NULL,
  `orders` tinyint(4) NOT NULL,
  `user_management` tinyint(4) NOT NULL,
  `frontend_user_management` tinyint(4) NOT NULL,
  `mobile_setups` tinyint(4) NOT NULL,
  `system_config` tinyint(4) NOT NULL,
  `email_setups` tinyint(4) NOT NULL,
  PRIMARY KEY (`permission_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `post_code`
--

CREATE TABLE IF NOT EXISTS `post_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postcode` text NOT NULL,
  `price` float NOT NULL,
  `deleted` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(8) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `created_by` int(8) NOT NULL,
  `last_modified_by` int(8) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `system_config`
--

CREATE TABLE IF NOT EXISTS `system_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `website_title` varchar(255) NOT NULL,
  `website_path` text NOT NULL,
  `website_currency` varchar(255) NOT NULL,
  `price_discount` float NOT NULL,
  `store_postcode` text NOT NULL,
  `country_region` text NOT NULL,
  `card_pay_price` float NOT NULL,
  `status` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `add_1` varchar(255) NOT NULL,
  `add_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `post_code` varchar(255) NOT NULL,
  `loyalty_point` text NOT NULL,
  `loyalty_id` text NOT NULL,
  `status` int(8) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

-- --------------------------------------------------------

--
-- Table structure for table `website_open_close`
--

CREATE TABLE IF NOT EXISTS `website_open_close` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `system_config_id` int(11) NOT NULL,
  `days` text NOT NULL,
  `website_open` time NOT NULL,
  `website_close` time NOT NULL,
  `total_hours` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
