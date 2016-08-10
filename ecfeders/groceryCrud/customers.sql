-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2016 at 10:42 AM
-- Server version: 5.5.47-0+deb8u1
-- PHP Version: 5.6.17-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gpcorser`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `tedlocations_id` int(11) NOT NULL,
  `password` varchar(16) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filesize` bigint(20) DEFAULT NULL,
  `filetype` varchar(50) DEFAULT NULL,
  `filecontent` mediumblob
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `status`, `image`, `email`, `mobile`, `tedlocations_id`, `password`, `filename`, `filesize`, `filetype`, `filecontent`) VALUES
(4, 'asd', '', NULL, 'asdq@asd.asda', 'asd', 0, '', '', 0, NULL, ''),
(8, 'George', 'Snazzy', '34c11-download.jpg', 'george@george.george', '1231231233', 0, '', NULL, NULL, NULL, NULL),
(9, 'name', '', NULL, 'blah@blah.com', '123456', 0, '', NULL, NULL, NULL, NULL),
(10, 'qwe', '', NULL, 'qwe@qwe.qwe', '123', 0, '', NULL, NULL, NULL, NULL),
(13, 'Jimmy', 'Nifty', NULL, '', '', 0, '', NULL, NULL, NULL, NULL),
(14, 'Nawaf', 'Cool', 'df613-download.jpg', '', '', 0, '', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
