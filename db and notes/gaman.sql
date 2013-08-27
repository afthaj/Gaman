-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 28, 2013 at 12:25 AM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gaman`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_level` int(5) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` VALUES(1, 'user', '123', 3, 'Admin', 'User', 'aftha.jaldin88@gmail.com');
INSERT INTO `admins` VALUES(2, 'afthaj', 'afthaj', 3, 'Aftha', 'Jaldin', 'afthajaldin@yahoo.com');
INSERT INTO `admins` VALUES(4, 'buddhi', 'buddhi123', 3, 'Buddhi', 'De Silva', 'gbidsilva@gmail.com');
INSERT INTO `admins` VALUES(7, 'laleen', 'laleen123', 3, 'Laleen', 'Pallegoda', 'laleen.kp@gmail.com');
INSERT INTO `admins` VALUES(8, 'sachith', 'sachith123', 3, 'Sachith', 'Senevirathna', 'vihanga88@gmail.com');
INSERT INTO `admins` VALUES(9, 'john', 'john123', 2, 'John', 'Smith', 'john.smith@acme.com');
INSERT INTO `admins` VALUES(10, 'sandunika', 'sandunika123', 3, 'Sandunika', 'Wijerathne', 'swijerathne35@gmail.com');
INSERT INTO `admins` VALUES(11, 'janitha', 'janitha123', 1, 'Janitha', 'Rasanga', 'janitharasanga@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `reg_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` VALUES(1, 1, '12-3456', 'KK Express');
INSERT INTO `buses` VALUES(2, 1, '23-4567', '');
INSERT INTO `buses` VALUES(3, 1, 'WP-GA-9876', 'Kaduwela Kumari');
INSERT INTO `buses` VALUES(4, 1, 'WP-GA-1234', 'Kolpetty Rider');
INSERT INTO `buses` VALUES(5, 2, 'WP-GB-1212', 'Sudu Menike');
INSERT INTO `buses` VALUES(6, 2, 'WP-GB-2323', 'Koswatte Rider');
INSERT INTO `buses` VALUES(7, 4, 'WP-GA-1919', 'Godagama Rider');

-- --------------------------------------------------------

--
-- Table structure for table `buses_bus_personnel`
--

CREATE TABLE `buses_bus_personnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_id` int(11) NOT NULL,
  `bus_personnel_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bus_id` (`bus_id`),
  KEY `bus_personnel_id` (`bus_personnel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `buses_bus_personnel`
--

INSERT INTO `buses_bus_personnel` VALUES(2, 2, 1);
INSERT INTO `buses_bus_personnel` VALUES(3, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bus_personnel`
--

CREATE TABLE `bus_personnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(3) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bus_personnel`
--

INSERT INTO `bus_personnel` VALUES(1, 1, 'John', 'Smith');

-- --------------------------------------------------------

--
-- Table structure for table `bus_personnel_role`
--

CREATE TABLE `bus_personnel_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bus_personnel_role`
--

INSERT INTO `bus_personnel_role` VALUES(1, 'Bus Owner');
INSERT INTO `bus_personnel_role` VALUES(2, 'Bus Driver');
INSERT INTO `bus_personnel_role` VALUES(3, 'Bus Conductor');
INSERT INTO `bus_personnel_role` VALUES(4, 'Bus Owner + Driver');
INSERT INTO `bus_personnel_role` VALUES(5, 'Bus Owner + Conductor');

-- --------------------------------------------------------

--
-- Table structure for table `commuters`
--

CREATE TABLE `commuters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `commuters`
--


-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `complaint_type` int(11) NOT NULL,
  `bus_route_id` int(11) NOT NULL,
  `stop_id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `bus_personnel_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `complaints`
--


-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_number` int(11) NOT NULL,
  `length` float NOT NULL,
  `trip_time` time NOT NULL,
  `begin_stop` int(11) NOT NULL,
  `end_stop` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` VALUES(1, 177, 20, '00:45:00', 26, 1);
INSERT INTO `routes` VALUES(2, 171, 15, '00:30:00', 27, 40);
INSERT INTO `routes` VALUES(3, 170, 20, '00:45:00', 47, 52);
INSERT INTO `routes` VALUES(4, 190, 23, '00:45:00', 53, 52);
INSERT INTO `routes` VALUES(5, 174, 15, '00:35:00', 41, 32);
INSERT INTO `routes` VALUES(6, 163, 22, '00:45:00', 23, 69);
INSERT INTO `routes` VALUES(7, 176, 24, '00:40:00', 70, 79);

-- --------------------------------------------------------

--
-- Table structure for table `stops`
--

CREATE TABLE `stops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `stops`
--

INSERT INTO `stops` VALUES(1, 'Kolpetty - Railway Station');
INSERT INTO `stops` VALUES(2, 'Kolpetty - Supermarket');
INSERT INTO `stops` VALUES(3, 'Kolpetty - Alwis Place');
INSERT INTO `stops` VALUES(4, 'Colombo Public Library');
INSERT INTO `stops` VALUES(5, 'SLTA');
INSERT INTO `stops` VALUES(6, 'Nelum Pokuna Theater');
INSERT INTO `stops` VALUES(7, 'Central');
INSERT INTO `stops` VALUES(8, 'Wijerama');
INSERT INTO `stops` VALUES(9, 'Borella - Horton Place');
INSERT INTO `stops` VALUES(10, 'Devi Balika');
INSERT INTO `stops` VALUES(11, 'Castle Street');
INSERT INTO `stops` VALUES(12, 'Ayurveda');
INSERT INTO `stops` VALUES(13, 'Rajagiriya');
INSERT INTO `stops` VALUES(14, 'NAITA');
INSERT INTO `stops` VALUES(15, 'Welikada');
INSERT INTO `stops` VALUES(16, 'Ethul Kotte - Sri Jayawardenapura Mw');
INSERT INTO `stops` VALUES(17, 'Polduwa');
INSERT INTO `stops` VALUES(18, 'Sethsiripaya');
INSERT INTO `stops` VALUES(19, 'Battaramulla');
INSERT INTO `stops` VALUES(20, 'Battaramulla - Singer');
INSERT INTO `stops` VALUES(21, 'Ganahena');
INSERT INTO `stops` VALUES(22, 'Koswatte - Thalangama Depot');
INSERT INTO `stops` VALUES(23, 'Koswatte');
INSERT INTO `stops` VALUES(24, 'Thalangama - Cemetary');
INSERT INTO `stops` VALUES(25, 'Malabe');
INSERT INTO `stops` VALUES(26, 'Kaduwela');
INSERT INTO `stops` VALUES(27, 'Pelawatte - Palam thuna (3 bridges)');
INSERT INTO `stops` VALUES(28, 'Videsha Seva (Foreign Employment Bureau)');
INSERT INTO `stops` VALUES(29, 'Palath Sabha (Western Provincial Council)');
INSERT INTO `stops` VALUES(30, 'Gothami Road');
INSERT INTO `stops` VALUES(31, 'Cotta Road');
INSERT INTO `stops` VALUES(32, 'Borella - Supermarket');
INSERT INTO `stops` VALUES(33, 'Borella - Maradana Road');
INSERT INTO `stops` VALUES(34, 'Borella - Aquinas');
INSERT INTO `stops` VALUES(35, 'Punchi Borella');
INSERT INTO `stops` VALUES(36, 'Maradana');
INSERT INTO `stops` VALUES(37, 'Technical Junction');
INSERT INTO `stops` VALUES(38, 'Bo Gaha Handiya (Bo Tree Junction)');
INSERT INTO `stops` VALUES(39, 'Hultsdorf');
INSERT INTO `stops` VALUES(40, 'Fort');
INSERT INTO `stops` VALUES(41, 'Kottawa');
INSERT INTO `stops` VALUES(42, 'Pannipitiya - Old Road');
INSERT INTO `stops` VALUES(43, 'Thalawathugoda');
INSERT INTO `stops` VALUES(44, 'Jayawadanagama');
INSERT INTO `stops` VALUES(45, 'Isurupaya');
INSERT INTO `stops` VALUES(46, 'Pelawatte');
INSERT INTO `stops` VALUES(47, 'Athurugiriya');
INSERT INTO `stops` VALUES(48, 'Borella - Ward Place');
INSERT INTO `stops` VALUES(49, 'Eye Hospital');
INSERT INTO `stops` VALUES(50, 'Darley Road');
INSERT INTO `stops` VALUES(51, 'McCallum Road (D. R. Wijewardena Mw)');
INSERT INTO `stops` VALUES(52, 'Pettah');
INSERT INTO `stops` VALUES(53, 'Meegoda');
INSERT INTO `stops` VALUES(54, 'Godagama');
INSERT INTO `stops` VALUES(55, 'Ethul Kotte - Telecom');
INSERT INTO `stops` VALUES(56, 'Mati Ambalama');
INSERT INTO `stops` VALUES(57, 'Kotubamma (Rampart Road)');
INSERT INTO `stops` VALUES(58, 'CMS');
INSERT INTO `stops` VALUES(59, 'Solis');
INSERT INTO `stops` VALUES(60, 'Pita Kotte');
INSERT INTO `stops` VALUES(61, 'Ananda Balika');
INSERT INTO `stops` VALUES(62, 'Pagoda Road');
INSERT INTO `stops` VALUES(63, 'Nugegoda - Pagoda Road');
INSERT INTO `stops` VALUES(64, 'Nugegoda - Supermarket');
INSERT INTO `stops` VALUES(65, 'Nugegoda - High Level Road');
INSERT INTO `stops` VALUES(66, 'Kohuwala');
INSERT INTO `stops` VALUES(67, 'Kalubowila');
INSERT INTO `stops` VALUES(68, 'William''s Grinding Mill');
INSERT INTO `stops` VALUES(69, 'Dehiwala');
INSERT INTO `stops` VALUES(70, 'Karagampitiya');
INSERT INTO `stops` VALUES(71, 'Dehiwala - Zoo');
INSERT INTO `stops` VALUES(72, 'S. De S. Jayasinghe Ground');
INSERT INTO `stops` VALUES(73, 'Nugegoda - Nawala Road');
INSERT INTO `stops` VALUES(74, 'Nawala');
INSERT INTO `stops` VALUES(75, 'Nawala - Koswatte');
INSERT INTO `stops` VALUES(76, 'Kotte Municipal Council');
INSERT INTO `stops` VALUES(77, 'Borella - YMBA');
INSERT INTO `stops` VALUES(78, 'Armor Street');
INSERT INTO `stops` VALUES(79, 'Hettiyawatte');

-- --------------------------------------------------------

--
-- Table structure for table `stops_routes`
--

CREATE TABLE `stops_routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `stop_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `route_id` (`route_id`),
  KEY `stop_id` (`stop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=162 ;

--
-- Dumping data for table `stops_routes`
--

INSERT INTO `stops_routes` VALUES(1, 1, 26);
INSERT INTO `stops_routes` VALUES(2, 1, 25);
INSERT INTO `stops_routes` VALUES(3, 1, 24);
INSERT INTO `stops_routes` VALUES(4, 1, 23);
INSERT INTO `stops_routes` VALUES(5, 1, 22);
INSERT INTO `stops_routes` VALUES(6, 1, 21);
INSERT INTO `stops_routes` VALUES(7, 1, 20);
INSERT INTO `stops_routes` VALUES(8, 1, 19);
INSERT INTO `stops_routes` VALUES(9, 1, 18);
INSERT INTO `stops_routes` VALUES(10, 1, 17);
INSERT INTO `stops_routes` VALUES(11, 1, 16);
INSERT INTO `stops_routes` VALUES(12, 1, 15);
INSERT INTO `stops_routes` VALUES(13, 1, 14);
INSERT INTO `stops_routes` VALUES(14, 1, 13);
INSERT INTO `stops_routes` VALUES(15, 1, 12);
INSERT INTO `stops_routes` VALUES(16, 1, 11);
INSERT INTO `stops_routes` VALUES(17, 1, 10);
INSERT INTO `stops_routes` VALUES(18, 1, 9);
INSERT INTO `stops_routes` VALUES(19, 1, 8);
INSERT INTO `stops_routes` VALUES(20, 1, 7);
INSERT INTO `stops_routes` VALUES(21, 1, 6);
INSERT INTO `stops_routes` VALUES(22, 1, 5);
INSERT INTO `stops_routes` VALUES(23, 1, 4);
INSERT INTO `stops_routes` VALUES(24, 1, 3);
INSERT INTO `stops_routes` VALUES(25, 1, 2);
INSERT INTO `stops_routes` VALUES(26, 1, 1);
INSERT INTO `stops_routes` VALUES(27, 2, 27);
INSERT INTO `stops_routes` VALUES(28, 2, 28);
INSERT INTO `stops_routes` VALUES(29, 2, 29);
INSERT INTO `stops_routes` VALUES(30, 2, 23);
INSERT INTO `stops_routes` VALUES(31, 2, 22);
INSERT INTO `stops_routes` VALUES(32, 2, 21);
INSERT INTO `stops_routes` VALUES(33, 2, 20);
INSERT INTO `stops_routes` VALUES(34, 2, 19);
INSERT INTO `stops_routes` VALUES(35, 2, 18);
INSERT INTO `stops_routes` VALUES(36, 2, 17);
INSERT INTO `stops_routes` VALUES(37, 2, 16);
INSERT INTO `stops_routes` VALUES(38, 2, 15);
INSERT INTO `stops_routes` VALUES(39, 2, 14);
INSERT INTO `stops_routes` VALUES(40, 2, 13);
INSERT INTO `stops_routes` VALUES(41, 2, 12);
INSERT INTO `stops_routes` VALUES(42, 2, 30);
INSERT INTO `stops_routes` VALUES(43, 2, 31);
INSERT INTO `stops_routes` VALUES(44, 2, 32);
INSERT INTO `stops_routes` VALUES(45, 2, 33);
INSERT INTO `stops_routes` VALUES(46, 2, 34);
INSERT INTO `stops_routes` VALUES(47, 2, 35);
INSERT INTO `stops_routes` VALUES(48, 2, 36);
INSERT INTO `stops_routes` VALUES(49, 2, 37);
INSERT INTO `stops_routes` VALUES(50, 2, 38);
INSERT INTO `stops_routes` VALUES(51, 2, 40);
INSERT INTO `stops_routes` VALUES(52, 3, 47);
INSERT INTO `stops_routes` VALUES(53, 3, 25);
INSERT INTO `stops_routes` VALUES(54, 3, 24);
INSERT INTO `stops_routes` VALUES(55, 3, 23);
INSERT INTO `stops_routes` VALUES(56, 3, 22);
INSERT INTO `stops_routes` VALUES(57, 3, 21);
INSERT INTO `stops_routes` VALUES(58, 3, 20);
INSERT INTO `stops_routes` VALUES(59, 3, 19);
INSERT INTO `stops_routes` VALUES(60, 3, 18);
INSERT INTO `stops_routes` VALUES(61, 3, 17);
INSERT INTO `stops_routes` VALUES(62, 3, 16);
INSERT INTO `stops_routes` VALUES(63, 3, 15);
INSERT INTO `stops_routes` VALUES(64, 3, 14);
INSERT INTO `stops_routes` VALUES(65, 3, 13);
INSERT INTO `stops_routes` VALUES(66, 3, 12);
INSERT INTO `stops_routes` VALUES(67, 3, 30);
INSERT INTO `stops_routes` VALUES(68, 3, 31);
INSERT INTO `stops_routes` VALUES(69, 3, 32);
INSERT INTO `stops_routes` VALUES(70, 3, 48);
INSERT INTO `stops_routes` VALUES(71, 3, 49);
INSERT INTO `stops_routes` VALUES(72, 3, 50);
INSERT INTO `stops_routes` VALUES(73, 3, 51);
INSERT INTO `stops_routes` VALUES(74, 3, 52);
INSERT INTO `stops_routes` VALUES(75, 4, 53);
INSERT INTO `stops_routes` VALUES(76, 4, 54);
INSERT INTO `stops_routes` VALUES(77, 4, 47);
INSERT INTO `stops_routes` VALUES(78, 4, 25);
INSERT INTO `stops_routes` VALUES(79, 4, 24);
INSERT INTO `stops_routes` VALUES(80, 4, 23);
INSERT INTO `stops_routes` VALUES(81, 4, 22);
INSERT INTO `stops_routes` VALUES(82, 4, 21);
INSERT INTO `stops_routes` VALUES(83, 4, 20);
INSERT INTO `stops_routes` VALUES(84, 4, 19);
INSERT INTO `stops_routes` VALUES(85, 4, 18);
INSERT INTO `stops_routes` VALUES(86, 4, 17);
INSERT INTO `stops_routes` VALUES(87, 4, 16);
INSERT INTO `stops_routes` VALUES(88, 4, 15);
INSERT INTO `stops_routes` VALUES(89, 4, 14);
INSERT INTO `stops_routes` VALUES(90, 4, 13);
INSERT INTO `stops_routes` VALUES(91, 4, 12);
INSERT INTO `stops_routes` VALUES(92, 4, 30);
INSERT INTO `stops_routes` VALUES(93, 4, 31);
INSERT INTO `stops_routes` VALUES(94, 4, 32);
INSERT INTO `stops_routes` VALUES(95, 4, 48);
INSERT INTO `stops_routes` VALUES(96, 4, 49);
INSERT INTO `stops_routes` VALUES(97, 4, 50);
INSERT INTO `stops_routes` VALUES(98, 4, 51);
INSERT INTO `stops_routes` VALUES(99, 4, 52);
INSERT INTO `stops_routes` VALUES(100, 5, 41);
INSERT INTO `stops_routes` VALUES(101, 5, 42);
INSERT INTO `stops_routes` VALUES(102, 5, 43);
INSERT INTO `stops_routes` VALUES(103, 5, 44);
INSERT INTO `stops_routes` VALUES(104, 5, 45);
INSERT INTO `stops_routes` VALUES(105, 5, 46);
INSERT INTO `stops_routes` VALUES(106, 5, 27);
INSERT INTO `stops_routes` VALUES(107, 5, 19);
INSERT INTO `stops_routes` VALUES(108, 5, 18);
INSERT INTO `stops_routes` VALUES(109, 5, 17);
INSERT INTO `stops_routes` VALUES(110, 5, 16);
INSERT INTO `stops_routes` VALUES(111, 5, 15);
INSERT INTO `stops_routes` VALUES(112, 5, 14);
INSERT INTO `stops_routes` VALUES(113, 5, 13);
INSERT INTO `stops_routes` VALUES(114, 5, 12);
INSERT INTO `stops_routes` VALUES(115, 5, 30);
INSERT INTO `stops_routes` VALUES(116, 5, 31);
INSERT INTO `stops_routes` VALUES(117, 5, 32);
INSERT INTO `stops_routes` VALUES(118, 6, 23);
INSERT INTO `stops_routes` VALUES(119, 6, 22);
INSERT INTO `stops_routes` VALUES(120, 6, 21);
INSERT INTO `stops_routes` VALUES(121, 6, 20);
INSERT INTO `stops_routes` VALUES(122, 6, 19);
INSERT INTO `stops_routes` VALUES(123, 6, 18);
INSERT INTO `stops_routes` VALUES(124, 6, 17);
INSERT INTO `stops_routes` VALUES(125, 6, 16);
INSERT INTO `stops_routes` VALUES(126, 6, 55);
INSERT INTO `stops_routes` VALUES(127, 6, 56);
INSERT INTO `stops_routes` VALUES(128, 6, 57);
INSERT INTO `stops_routes` VALUES(129, 6, 58);
INSERT INTO `stops_routes` VALUES(130, 6, 59);
INSERT INTO `stops_routes` VALUES(131, 6, 60);
INSERT INTO `stops_routes` VALUES(132, 6, 61);
INSERT INTO `stops_routes` VALUES(133, 6, 62);
INSERT INTO `stops_routes` VALUES(134, 6, 63);
INSERT INTO `stops_routes` VALUES(135, 6, 64);
INSERT INTO `stops_routes` VALUES(136, 6, 65);
INSERT INTO `stops_routes` VALUES(137, 6, 66);
INSERT INTO `stops_routes` VALUES(138, 6, 67);
INSERT INTO `stops_routes` VALUES(139, 6, 68);
INSERT INTO `stops_routes` VALUES(140, 6, 69);
INSERT INTO `stops_routes` VALUES(141, 7, 70);
INSERT INTO `stops_routes` VALUES(142, 7, 71);
INSERT INTO `stops_routes` VALUES(143, 7, 72);
INSERT INTO `stops_routes` VALUES(144, 7, 67);
INSERT INTO `stops_routes` VALUES(145, 7, 66);
INSERT INTO `stops_routes` VALUES(146, 7, 65);
INSERT INTO `stops_routes` VALUES(147, 7, 73);
INSERT INTO `stops_routes` VALUES(148, 7, 74);
INSERT INTO `stops_routes` VALUES(149, 7, 75);
INSERT INTO `stops_routes` VALUES(150, 7, 76);
INSERT INTO `stops_routes` VALUES(151, 7, 13);
INSERT INTO `stops_routes` VALUES(152, 7, 12);
INSERT INTO `stops_routes` VALUES(153, 7, 11);
INSERT INTO `stops_routes` VALUES(154, 7, 10);
INSERT INTO `stops_routes` VALUES(155, 7, 77);
INSERT INTO `stops_routes` VALUES(156, 7, 33);
INSERT INTO `stops_routes` VALUES(157, 7, 34);
INSERT INTO `stops_routes` VALUES(158, 7, 35);
INSERT INTO `stops_routes` VALUES(159, 7, 36);
INSERT INTO `stops_routes` VALUES(160, 7, 78);
INSERT INTO `stops_routes` VALUES(161, 7, 79);

-- --------------------------------------------------------

--
-- Table structure for table `stop_activity`
--

CREATE TABLE `stop_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trip_id` int(11) NOT NULL,
  `stop_id` int(11) NOT NULL,
  `alighted_commuters` int(11) NOT NULL,
  `boarded_commuters` int(11) NOT NULL,
  `arrival_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `departure_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `trip_id` (`trip_id`),
  KEY `stop_id` (`stop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `stop_activity`
--


-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `begin_stop` int(11) NOT NULL,
  `end_stop` int(11) NOT NULL,
  `departure_from_begin_stop` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `arrival_at_end_stop` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `route_id` (`route_id`),
  KEY `bus_id` (`bus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `trips`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `buses_bus_personnel`
--
ALTER TABLE `buses_bus_personnel`
  ADD CONSTRAINT `buses_bus_personnel_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buses_bus_personnel_ibfk_2` FOREIGN KEY (`bus_personnel_id`) REFERENCES `bus_personnel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stops_routes`
--
ALTER TABLE `stops_routes`
  ADD CONSTRAINT `stops_routes_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stops_routes_ibfk_2` FOREIGN KEY (`stop_id`) REFERENCES `stops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stop_activity`
--
ALTER TABLE `stop_activity`
  ADD CONSTRAINT `stop_activity_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stop_activity_ibfk_2` FOREIGN KEY (`stop_id`) REFERENCES `stops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trips_ibfk_2` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
