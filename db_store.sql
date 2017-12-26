-- phpMyAdmin SQL Dump
-- version 4.0.10.11
-- http://www.phpmyadmin.net
--
-- Host: 10.10.23.183
-- Generation Time: Dec 26, 2017 at 02:50 PM
-- Server version: 5.5.46-0+deb8u1
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`) VALUES
(1, 'Laptops', NULL, NULL),
(2, 'Desktops', NULL, NULL),
(3, 'Monitors', NULL, NULL),
(4, 'Keyboards', NULL, NULL),
(5, 'Mice', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `password_digest` varchar(255) DEFAULT NULL,
  `remember_digest` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `activation_digest` varchar(255) DEFAULT NULL,
  `activated` tinyint(1) DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `reset_digest` varchar(255) DEFAULT NULL,
  `reset_sent_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_users_on_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------



--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `total` int(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` int(5) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `cat_id`, `name`, `description`, `price`, `image`) VALUES
(1, 1, 'MSI ge62', '', 725, 'img/laptops/1.jpg'),
(2, 1, 'MSI 72', '', 444, 'img/laptops/2.jpg'),
(3, 1, 'Razer Blade', '', 679, 'img/laptops/3.png'),
(4, 1, 'Mac Pro', '', 839, 'img/laptops/4.jpg'),
(5, 1, 'Dell xps', '', 419, 'img/laptops/5.jpg'),
(6, 2, 'Master gamer 1', '', 1890, 'img/desktops/1.jpg'),
(7, 2, 'Master gamer 2', '', 289, 'img/desktops/2.jpg'),
(8, 2, 'Mid range', '', 1250, 'img/desktops/3.jpg'),
(9, 2, 'The destroyer', '', 499, 'img/desktops/4.jpg'),
(10, 2, 'Low end', '', 3799, 'img/desktops/5.jpg'),
(11, 3, 'LG Ultrawide', '', 69, 'img/monitors/1.jpg'),
(12, 3, 'Acer blade 23', '', 333, 'img/monitors/2.jpg'),
(13, 3, 'HP ice', '', 222, 'img/monitors/3.jpg'),
(14, 3, 'Asus Victory ', '', 990, 'img/monitors/4.jpg'),
(15, 3, 'Predator Spider V 30', '', 199, 'img/monitors/5.jpg'),
(16, 4, 'Avenger IronMan', '', 279, 'img/keyboards/1.jpg'),
(17, 4, 'Razer Blackwidow', '', 99, 'img/keyboards/2.jpg'),
(18, 4, 'JHS Pedals', '', 249, 'img/keyboards/3.jpg'),
(19, 4, 'Roccat MXTR', '', 125, 'img/keyboards/4.jpg'),
(20, 4, 'Razer Blackwidow Chroma 2', '', 499, 'img/keyboards/5.jpg'),
(21, 5, 'the sssnake IPP1030', '', 3, 'img/mice/1.jpg'),
(22, 5, 'Pro Snake Patch ', '', 3, 'img/mice/2.jpg'),
(23, 5, 'Harley G', '', 18, 'img/mice/3.jpg'),
(24, 5, 'Razer Mamba', '', 29, 'img/mice/4.jpg'),
(25, 5, 'Daddario NYXL1046', '', 13, 'img/mice/5.jpg');

-- --------------------------------------------------------

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
