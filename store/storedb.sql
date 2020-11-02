-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 02, 2020 at 09:23 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `storedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `previlige` enum('admin','member') NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `UNIQE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`fname`, `lname`, `email`, `password`, `id`, `previlige`) VALUES
('admin', 'admin', 'admin@gmail.com', 'admin', 9, 'admin'),
('Adam', 'Adam', 'adam@gmail.com', 'adam', 11, 'admin'),
('alex', 'alex', 'alex@gmail.com', 'alex', 12, 'member'),
('mina', 'mina', 'mina@gmail.com', 'mina', 13, 'member'),
('saeed', 'saeed', 'saeed@gmail.com', 'saeed', 14, 'member'),
('ola', 'ola', 'ola@gmail.com', 'ola', 15, 'member'),
('testname', 'testlastname', 'test@gmail.com', 'test', 16, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category-id` int(11) NOT NULL AUTO_INCREMENT,
  `category-name` varchar(100) NOT NULL,
  PRIMARY KEY (`category-id`),
  UNIQUE KEY `UNIQUE` (`category-name`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category-id`, `category-name`) VALUES
(3, 'denime'),
(26, 'jeans'),
(27, 'shirts'),
(6, 'short');

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
CREATE TABLE IF NOT EXISTS `model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelname` varchar(500) DEFAULT NULL,
  `smallnumber` int(11) DEFAULT NULL,
  `mediumnumber` int(11) DEFAULT NULL,
  `largenumber` int(11) DEFAULT NULL,
  `xlargenumber` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `category-id` int(11) NOT NULL,
  `imageurl` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQE` (`modelname`),
  KEY `model_ibfk_1` (`category-id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`id`, `modelname`, `smallnumber`, `mediumnumber`, `largenumber`, `xlargenumber`, `price`, `category-id`, `imageurl`) VALUES
(10, 'Black jeans', 20, 20, 20, 20, 35, 26, 'image/models/jeansblack.jpg'),
(11, 'Comfort fit Jeans', 25, 25, 25, 25, 40, 26, 'image/models/jeanscomfortfit.jpg'),
(12, 'Comfort Fit Black Jeans', 30, 30, 30, 30, 45, 26, 'image/models/jeanscomfortfitblack.jpg'),
(13, 'Skinny Fit Jeans', 40, 40, 50, 30, 35, 26, 'image/models/jeansskinnyfit.jpg'),
(14, 'Skinny Fit Tom Original Jeans', 40, 30, 40, 50, 40, 26, 'image/models/jeansskinnyfittomoriginal.jpg'),
(15, 'Slim Fit Jeans', 40, 40, 40, 40, 50, 26, 'image/models/jeansslimfit.jpg'),
(16, 'Button Down Green Shirt', 100, 100, 100, 100, 30, 27, 'image/models/shirtbuttondowngreen.jpg'),
(17, 'Button Down Grey Shirt', 50, 60, 60, 60, 35, 27, 'image/models/shirtbuttondowngrey.jpg'),
(18, 'Button Down Blue Shirt', 40, 50, 40, 50, 40, 27, 'image/models/shirtbuttondowntwillbluw.jpg'),
(20, 'Button Down Will Shirt', 50, 60, 60, 60, 35, 27, 'image/models/shirtbuttondowntwillcolorful.jpg'),
(21, 'Button Down Will Green', 80, 80, 70, 70, 40, 27, 'image/models/shirtbuttondowntwillgreen.jpg'),
(22, 'Button Down Will Light Blue', 75, 80, 60, 75, 36, 27, 'image/models/shirtbuttondowntwilllightblue.jpg'),
(23, 'Pop Slim White Shirt', 60, 90, 40, 50, 40, 27, 'image/models/shirtpoplinslimwhite.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

DROP TABLE IF EXISTS `shopping_cart`;
CREATE TABLE IF NOT EXISTS `shopping_cart` (
  `m_id` int(10) NOT NULL,
  `ip_add` varchar(255) NOT NULL,
  `qty` int(10) NOT NULL,
  `size` text NOT NULL,
  KEY `m_id` (`m_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`m_id`, `ip_add`, `qty`, `size`) VALUES
(22, '::1', 1, 'Small'),
(22, '::1', 1, 'Medium'),
(22, '::1', 1, 'Medium'),
(21, '::1', 1, 'Small'),
(21, '::1', 1, 'Small'),
(23, '::1', 1, 'Small'),
(22, '::1', 1, 'Small'),
(22, '::1', 1, 'Small'),
(22, '::1', 1, 'Small'),
(22, '::1', 1, 'Extra large'),
(22, '::1', 1, 'Small'),
(21, '::1', 1, 'Small'),
(21, '::1', 1, 'Medium'),
(22, '::1', 1, 'Small');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `model_ibfk_1` FOREIGN KEY (`category-id`) REFERENCES `category` (`category-id`) ON DELETE CASCADE;

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`m_id`) REFERENCES `model` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
