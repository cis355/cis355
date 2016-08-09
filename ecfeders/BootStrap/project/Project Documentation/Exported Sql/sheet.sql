-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 05, 2016 at 12:45 PM
-- Server version: 5.5.50-0+deb8u1
-- PHP Version: 5.6.24-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ecfeders`
--

-- --------------------------------------------------------

--
-- Table structure for table `sheet`
--

CREATE TABLE IF NOT EXISTS `sheet` (
`id` int(11) NOT NULL,
  `buss_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `grill1` int(11) DEFAULT NULL,
  `grill2` int(11) DEFAULT NULL,
  `fryer1` int(11) DEFAULT NULL,
  `fryer2` int(11) DEFAULT NULL,
  `creamer` int(11) DEFAULT NULL,
  `dateMod` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sheet`
--

INSERT INTO `sheet` (`id`, `buss_id`, `worker_id`, `grill1`, `grill2`, `fryer1`, `fryer2`, `creamer`, `dateMod`) VALUES
(2, 2, 2, 150, 200, 36, 23, 30, '2016-07-01 00:00:00'),
(13, 5, 3, 65, 65, 65, 65, 65, '2016-01-08 00:00:00'),
(14, 5, 3, 98, 98, 65, 65, 25, '2016-08-02 00:00:00'),
(15, 1, 4, 78, 78, 78, 78, 30, '2016-08-04 00:00:00'),
(16, 1, 1, 67, 67, 78, 78, 28, '2016-01-01 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sheet`
--
ALTER TABLE `sheet`
 ADD PRIMARY KEY (`id`), ADD KEY `buss_id` (`buss_id`), ADD KEY `worker_id` (`worker_id`), ADD KEY `buss_id_2` (`buss_id`,`worker_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sheet`
--
ALTER TABLE `sheet`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
