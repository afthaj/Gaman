-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2013 at 02:34 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gaman`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_levels`
--

CREATE TABLE IF NOT EXISTS `admin_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_level_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `admin_levels`
--

INSERT INTO `admin_levels` (`id`, `admin_level_name`) VALUES
(1, 'Time Keeper'),
(2, 'Stand OIC'),
(3, 'Scheduler'),
(4, 'Admin Level 4'),
(5, 'Admin Level 5');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE IF NOT EXISTS `buses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `reg_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `route_id` (`route_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `route_id`, `reg_number`, `name`) VALUES
(1, 1, '12-3456', 'KK Express'),
(2, 1, '23-4567', ''),
(3, 1, 'WP-GA-9876', 'Kaduwela Kumari'),
(4, 1, 'WP-GA-1234', 'Kolpetty Rider'),
(5, 2, 'WP-GB-1212', 'Sudu Menike'),
(6, 2, 'WP-GB-2323', 'Koswatte Rider'),
(7, 4, 'WP-GA-1919', 'Godagama Rider');

-- --------------------------------------------------------

--
-- Table structure for table `buses_bus_personnel`
--

CREATE TABLE IF NOT EXISTS `buses_bus_personnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_id` int(11) NOT NULL,
  `bus_personnel_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bus_id` (`bus_id`),
  KEY `bus_personnel_id` (`bus_personnel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `buses_bus_personnel`
--

INSERT INTO `buses_bus_personnel` (`id`, `bus_id`, `bus_personnel_id`) VALUES
(2, 2, 1),
(3, 3, 1),
(4, 5, 1),
(5, 7, 2),
(6, 5, 3),
(7, 2, 3),
(8, 1, 2),
(9, 1, 1),
(10, 7, 3),
(11, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `bus_personnel`
--

CREATE TABLE IF NOT EXISTS `bus_personnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_type` int(11) NOT NULL,
  `role` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `nic_number` varchar(20) NOT NULL,
  `telephone_number` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `object_type` (`object_type`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bus_personnel`
--

INSERT INTO `bus_personnel` (`id`, `object_type`, `role`, `username`, `password`, `first_name`, `last_name`, `nic_number`, `telephone_number`) VALUES
(1, 4, 1, 'john', 'john123', 'John', 'Smith', '801231511v', '0774422980'),
(2, 4, 4, 'busdriver', 'busdriver123', 'Bus', 'Driver', '823231511v', ''),
(3, 4, 3, 'busconductor', 'busconductor123', 'Bus', 'Conductor', '842321151v', '');

-- --------------------------------------------------------

--
-- Table structure for table `bus_personnel_roles`
--

CREATE TABLE IF NOT EXISTS `bus_personnel_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bus_personnel_roles`
--

INSERT INTO `bus_personnel_roles` (`id`, `role_name`) VALUES
(1, 'Bus Owner'),
(2, 'Bus Driver'),
(3, 'Bus Conductor'),
(4, 'Bus Owner + Driver'),
(5, 'Bus Owner + Conductor');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE IF NOT EXISTS `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_object_type` int(11) NOT NULL,
  `related_object_id` int(11) NOT NULL,
  `user_object_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `complaint_type` int(11) NOT NULL,
  `date_time_submitted` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `complaint_type` (`complaint_type`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `related_object_type`, `related_object_id`, `user_object_type`, `user_id`, `complaint_type`, `date_time_submitted`, `status`, `content`) VALUES
(1, 1, 2, 5, 1, 2, 1378815876, 1, 'Buses are consistently overcrowded'),
(2, 2, 12, 4, 1, 5, 1365441021, 1, 'There''s no proper bus stop for the commuters to stand at'),
(3, 3, 3, 5, 1, 9, 1376137476, 1, 'The bus loiters consistently at the Rajagiriya Bus Stop'),
(4, 2, 19, 4, 1, 8, 1376143840, 1, 'There isn''t enough room for buses to stop most of the time'),
(5, 3, 7, 5, 1, 20, 1373885115, 1, 'The conductor smelled of alcohol'),
(6, 3, 1, 5, 1, 9, 1379597255, 1, 'Bus loitered at the rajagiriya bus stop for over 10 minutes'),
(7, 1, 6, 5, 1, 4, 1379599906, 1, 'Buses are not to be seen after 7pm even though the operational hours end at 9.30'),
(8, 3, 2, 5, 1, 15, 1379599940, 1, 'This particular bus driver was talking on the phone while driving, endangering the lives of the passengers'),
(9, 3, 5, 5, 1, 16, 1379599972, 1, 'Conductor didn''t give the proper balance money back to me.'),
(10, 3, 2, 5, 1, 10, 1379599995, 1, 'Conductor didn''t issue a ticket to me'),
(11, 1, 1, 6, 1, 1, 1379788569, 1, 'Bus delays are very common in this bus route'),
(12, 3, 1, 6, 1, 10, 1379789236, 1, 'The bus conductor did not issue a ticket to me.'),
(13, 2, 18, 6, 1, 6, 1379789291, 1, 'Buses don''t stop at the proper place in the bus stop'),
(14, 1, 1, 6, 1, 2, 1379833500, 1, 'The buses are consistently overcrowded on this route'),
(15, 2, 5, 6, 1, 7, 1379836155, 1, 'There is no sign board that informs commuters of the bus stop at this bus stop.'),
(16, 3, 6, 6, 1, 11, 1379838343, 1, 'The bus was overcrowded purposefully without regard to passenger safety'),
(17, 1, 1, 5, 1, 4, 1379847113, 1, 'during the weekends, the buses don''t run for all of the operational hours'),
(18, 1, 1, 4, 1, 2, 1380614624, 1, 'The route is always crowded and the buses keep crowding it even more'),
(19, 3, 7, 6, 1, 11, 1380615922, 1, 'The bus picked up more people than it could carry, making the ride uncomfortable for the passengers');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_status`
--

CREATE TABLE IF NOT EXISTS `complaint_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comp_status_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `complaint_status`
--

INSERT INTO `complaint_status` (`id`, `comp_status_name`) VALUES
(1, 'Submitted'),
(2, 'Pending Review'),
(3, 'Reviewed and Closed');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_types`
--

CREATE TABLE IF NOT EXISTS `complaint_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_object_type` int(11) NOT NULL,
  `comp_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `related_object_type` (`related_object_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `complaint_types`
--

INSERT INTO `complaint_types` (`id`, `related_object_type`, `comp_type_name`) VALUES
(1, 1, 'Bus Delays'),
(2, 1, 'Overcrowded Buses'),
(3, 1, 'Lack of Buses'),
(4, 1, 'Lack of Buses during the Route''s Operational Hours'),
(5, 2, 'No proper Bus Stop'),
(6, 2, 'Buses don''t stop at the correct area in the Bus Stop'),
(7, 2, 'Bus Stop not marked correctly'),
(8, 2, 'Insufficient area for Buses to stop'),
(9, 3, 'Loitering at Bus Stop'),
(10, 3, 'Not issuing a valid ticket'),
(11, 3, 'Overcrowding the Bus'),
(12, 3, 'Stopping at undesignated Bus Stops'),
(13, 3, 'Reckless driving'),
(14, 3, 'Neglecting road rules'),
(15, 3, 'Diverting attention while driving'),
(16, 3, 'Providing the improper balance money'),
(17, 3, 'Not providing the balance money at all'),
(18, 3, 'Overcharging a bus fare'),
(19, 3, 'Rude/discourteous service'),
(20, 3, 'Unhygienic/non-presentable appearance and/or attire'),
(21, 3, 'Failure to display the Fare Table in the Bus'),
(22, 3, 'Operating without a valid Driver''s license'),
(23, 3, 'Operating without a valid Conductor''s license'),
(24, 3, 'Operating without a valid Route Permit');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_items`
--

CREATE TABLE IF NOT EXISTS `feedback_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_object_type` int(11) NOT NULL,
  `related_object_id` int(11) NOT NULL,
  `user_object_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_time_submitted` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `feedback_items`
--

INSERT INTO `feedback_items` (`id`, `related_object_type`, `related_object_id`, `user_object_type`, `user_id`, `date_time_submitted`, `content`) VALUES
(1, 1, 1, 6, 1, 1379841516, 'This route is very good. The AC buses are fairly comfortable and prompt. The normal buses loiter a little too much at certain stops.'),
(2, 1, 2, 4, 1, 1380613376, 'The route is very good'),
(3, 2, 1, 4, 1, 1380613542, 'The bus stop can get quite congested sometimes'),
(4, 3, 2, 4, 1, 1380614580, 'This bus did a very good job'),
(5, 1, 2, 6, 1, 1380615545, 'The route is very enjoyable');

-- --------------------------------------------------------

--
-- Table structure for table `object_types`
--

CREATE TABLE IF NOT EXISTS `object_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_flag` int(1) NOT NULL,
  `object_type_name` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `object_types`
--

INSERT INTO `object_types` (`id`, `user_flag`, `object_type_name`, `display_name`) VALUES
(1, 0, 'route', 'Bus Route'),
(2, 0, 'stop', 'Bus Stop'),
(3, 0, 'bus', 'Bus'),
(4, 1, 'bus_personnel', 'Bus Personnel'),
(5, 1, 'admin', 'Admin User'),
(6, 1, 'commuter', 'Commuter'),
(7, 0, 'complaint', 'Complaint');

-- --------------------------------------------------------

--
-- Table structure for table `photographs`
--

CREATE TABLE IF NOT EXISTS `photographs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_object_type` int(11) NOT NULL,
  `related_object_id` int(11) NOT NULL,
  `photo_type` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `size` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `related_object_type` (`related_object_type`),
  KEY `photo_type` (`photo_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `photographs`
--

INSERT INTO `photographs` (`id`, `related_object_type`, `related_object_id`, `photo_type`, `filename`, `file_type`, `size`) VALUES
(18, 5, 8, 9, '8-Sachith-Senevirathna.jpg', 'image/jpeg', '6195'),
(19, 5, 11, 9, '11-Janitha-Rasanga.jpg', 'image/jpeg', '261559'),
(20, 5, 1, 9, '1-Admin-User.jpg', 'image/jpeg', '70034'),
(21, 5, 4, 9, '4-Buddhi-De Silva.jpg', 'image/jpeg', '33102'),
(22, 2, 1, 10, 'bus_stop_pic_1_10.jpg', 'image/jpeg', '21804'),
(23, 2, 1, 11, 'bus_stop_pic_1_11.jpg', 'image/jpeg', '105293'),
(24, 2, 1, 12, 'bus_stop_pic_1_12.jpg', 'image/jpeg', '90063'),
(25, 2, 2, 10, 'bus_stop_pic_2_10.jpg', 'image/jpeg', '22031'),
(26, 2, 2, 11, 'bus_stop_pic_2_11.jpg', 'image/jpeg', '73071'),
(27, 3, 1, 1, 'bus_pic_1_1.jpeg', 'image/jpeg', '37090'),
(28, 3, 1, 2, 'bus_pic_1_2.jpeg', 'image/jpeg', '43218'),
(29, 3, 2, 1, 'bus_pic_2_1.jpg', 'image/jpeg', '37227'),
(30, 3, 2, 2, 'bus_pic_2_2.jpg', 'image/jpeg', '68710'),
(31, 3, 3, 1, 'bus_pic_3_1.jpg', 'image/jpeg', '34694'),
(32, 3, 3, 5, 'bus_pic_3_5.jpg', 'image/jpeg', '53572'),
(33, 3, 1, 6, 'bus_pic_1_6.jpeg', 'image/jpeg', '24515'),
(34, 4, 1, 9, 'bus_personnel_prof_pic_1_John_Smith.jpg', 'image/jpeg', '31614'),
(35, 4, 2, 9, 'bus_personnel_prof_pic_2_Bus_Driver.jpg', 'image/jpeg', '37737'),
(36, 4, 3, 9, 'bus_personnel_prof_pic_3_Bus_Conductor.jpg', 'image/jpeg', '28270'),
(37, 5, 7, 9, 'admin_prof_pic_7_Laleen_Pallegoda.jpg', 'image/jpeg', '27079');

-- --------------------------------------------------------

--
-- Table structure for table `photo_types`
--

CREATE TABLE IF NOT EXISTS `photo_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_object` varchar(50) NOT NULL,
  `photo_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `related_object` (`related_object`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `photo_types`
--

INSERT INTO `photo_types` (`id`, `related_object`, `photo_type_name`) VALUES
(1, 'bus', 'Front of Bus'),
(2, 'bus', 'Rear of Bus'),
(3, 'bus', 'Port side of Bus'),
(4, 'bus', 'Starboard side of Bus'),
(5, 'bus', 'Front + Port side of Bus'),
(6, 'bus', 'Front + Starboard side of Bus'),
(7, 'bus', 'Rear + Port side of Bus'),
(8, 'bus', 'Rear + Starboard side of Bus'),
(9, 'other', 'User Profile'),
(10, 'bus_stop', 'Location of Stop'),
(11, 'bus_stop', 'Facing forward at Bus Stop'),
(12, 'bus_stop', 'Facing behind at Bus Stop');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_number` int(11) NOT NULL,
  `length` float NOT NULL,
  `trip_time` int(11) NOT NULL,
  `begin_stop` int(11) NOT NULL,
  `end_stop` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `route_number`, `length`, `trip_time`, `begin_stop`, `end_stop`) VALUES
(1, 177, 20, 35, 26, 1),
(2, 171, 15, 30, 27, 40),
(3, 170, 20, 45, 47, 52),
(4, 190, 23, 45, 53, 52),
(5, 174, 15, 35, 41, 32),
(6, 163, 22, 45, 23, 69),
(7, 176, 24, 40, 70, 79);

-- --------------------------------------------------------

--
-- Table structure for table `stops`
--

CREATE TABLE IF NOT EXISTS `stops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location_latitude` varchar(255) NOT NULL,
  `location_longitude` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `stops`
--

INSERT INTO `stops` (`id`, `name`, `location_latitude`, `location_longitude`) VALUES
(1, 'Kolpetty - Railway Station', '6.911111', '79.849189'),
(2, 'Kolpetty - Supermarket', '6.911995', '79.850505'),
(3, 'Kolpetty - Alwis Place', '6.91265', '79.85367'),
(4, 'Colombo Public Library', '6.912946', '79.858058'),
(5, 'SLTA', '6.910853', '79.858648'),
(6, 'Nelum Pokuna Theater', '6.9104', '79.863701'),
(7, 'Central', '6.911574', '79.868336'),
(8, 'Wijerama', '6.911508', '79.871109'),
(9, 'Borella - Horton Place', '6.911356', '79.877021'),
(10, 'Devi Balika', '6.911074', '79.882619'),
(11, 'Castle Street', '6.911031', '79.885754'),
(12, 'Ayurveda', '6.910794', '79.88875'),
(13, 'Rajagiriya', '6.910126', '79.894361'),
(14, 'NAITA', '6.907482', '79.899948'),
(15, 'Welikada', '6.907482', '79.899948'),
(16, 'Ethul Kotte - Sri Jayawardenapura Mw', '6.90315', '79.907528'),
(17, 'Polduwa', '6.903096', '79.911637'),
(18, 'Sethsiripaya', '6.902194', '79.915559'),
(19, 'Battaramulla', '6.902087', '79.917938'),
(20, 'Battaramulla - Singer', '6.903544', '79.92168'),
(21, 'Ganahena', '6.904183', '79.92396'),
(22, 'Koswatte - Thalangama Depot', '6.90594', '79.926478'),
(23, 'Koswatte', '6.907623', '79.92916'),
(24, 'Thalahena', '6.907961', '79.944975'),
(25, 'Malabe', '6.904036', '79.954526'),
(26, 'Kaduwela', '6.936438', '79.982994'),
(27, 'Pelawatte - Palam thuna (3 bridges)', '', ''),
(28, 'Videsha Seva (Foreign Employment Bureau)', '', ''),
(29, 'Palath Sabha (Western Provincial Council)', '', ''),
(30, 'Gothami Road', '', ''),
(31, 'Cotta Road', '', ''),
(32, 'Borella - Supermarket', '', ''),
(33, 'Borella - Maradana Road', '', ''),
(34, 'Borella - Aquinas', '', ''),
(35, 'Punchi Borella', '', ''),
(36, 'Maradana', '', ''),
(37, 'Technical Junction', '', ''),
(38, 'Bo Gaha Handiya (Bo Tree Junction)', '', ''),
(39, 'Hultsdorf', '', ''),
(40, 'Fort', '', ''),
(41, 'Kottawa', '', ''),
(42, 'Pannipitiya - Old Road', '', ''),
(43, 'Thalawathugoda', '', ''),
(44, 'Jayawadanagama', '', ''),
(45, 'Isurupaya', '', ''),
(46, 'Pelawatte', '', ''),
(47, 'Athurugiriya', '6.877389', '79.989303'),
(48, 'Borella - Ward Place', '', ''),
(49, 'Eye Hospital', '', ''),
(50, 'Darley Road', '', ''),
(51, 'McCallum Road (D. R. Wijewardena Mw)', '', ''),
(52, 'Pettah', '', ''),
(53, 'Meegoda', '6.854978', '80.058182'),
(54, 'Godagama', '6.851313', '80.032905'),
(55, 'Ethul Kotte - Telecom', '', ''),
(56, 'Mati Ambalama', '', ''),
(57, 'Kotubamma (Rampart Road)', '', ''),
(58, 'CMS', '', ''),
(59, 'Solis', '', ''),
(60, 'Pita Kotte', '', ''),
(61, 'Ananda Balika', '', ''),
(62, 'Pagoda Road', '', ''),
(63, 'Nugegoda - Pagoda Road', '', ''),
(64, 'Nugegoda - Supermarket', '', ''),
(65, 'Nugegoda - High Level Road', '', ''),
(66, 'Kohuwala', '', ''),
(67, 'Kalubowila', '', ''),
(68, 'William''s Grinding Mill', '', ''),
(69, 'Dehiwala', '', ''),
(70, 'Karagampitiya', '', ''),
(71, 'Dehiwala - Zoo', '', ''),
(72, 'S. De S. Jayasinghe Ground', '', ''),
(73, 'Nugegoda - Nawala Road', '', ''),
(74, 'Nawala', '', ''),
(75, 'Nawala - Koswatte', '', ''),
(76, 'Kotte Municipal Council', '', ''),
(77, 'Borella - YMBA', '', ''),
(78, 'Armor Street', '', ''),
(79, 'Hettiyawatte', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `stops_routes`
--

CREATE TABLE IF NOT EXISTS `stops_routes` (
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

INSERT INTO `stops_routes` (`id`, `route_id`, `stop_id`) VALUES
(1, 1, 26),
(2, 1, 25),
(3, 1, 24),
(4, 1, 23),
(5, 1, 22),
(6, 1, 21),
(7, 1, 20),
(8, 1, 19),
(9, 1, 18),
(10, 1, 17),
(11, 1, 16),
(12, 1, 15),
(13, 1, 14),
(14, 1, 13),
(15, 1, 12),
(16, 1, 11),
(17, 1, 10),
(18, 1, 9),
(19, 1, 8),
(20, 1, 7),
(21, 1, 6),
(22, 1, 5),
(23, 1, 4),
(24, 1, 3),
(25, 1, 2),
(26, 1, 1),
(27, 2, 27),
(28, 2, 28),
(29, 2, 29),
(30, 2, 23),
(31, 2, 22),
(32, 2, 21),
(33, 2, 20),
(34, 2, 19),
(35, 2, 18),
(36, 2, 17),
(37, 2, 16),
(38, 2, 15),
(39, 2, 14),
(40, 2, 13),
(41, 2, 12),
(42, 2, 30),
(43, 2, 31),
(44, 2, 32),
(45, 2, 33),
(46, 2, 34),
(47, 2, 35),
(48, 2, 36),
(49, 2, 37),
(50, 2, 38),
(51, 2, 40),
(52, 3, 47),
(53, 3, 25),
(54, 3, 24),
(55, 3, 23),
(56, 3, 22),
(57, 3, 21),
(58, 3, 20),
(59, 3, 19),
(60, 3, 18),
(61, 3, 17),
(62, 3, 16),
(63, 3, 15),
(64, 3, 14),
(65, 3, 13),
(66, 3, 12),
(67, 3, 30),
(68, 3, 31),
(69, 3, 32),
(70, 3, 48),
(71, 3, 49),
(72, 3, 50),
(73, 3, 51),
(74, 3, 52),
(75, 4, 53),
(76, 4, 54),
(77, 4, 47),
(78, 4, 25),
(79, 4, 24),
(80, 4, 23),
(81, 4, 22),
(82, 4, 21),
(83, 4, 20),
(84, 4, 19),
(85, 4, 18),
(86, 4, 17),
(87, 4, 16),
(88, 4, 15),
(89, 4, 14),
(90, 4, 13),
(91, 4, 12),
(92, 4, 30),
(93, 4, 31),
(94, 4, 32),
(95, 4, 48),
(96, 4, 49),
(97, 4, 50),
(98, 4, 51),
(99, 4, 52),
(100, 5, 41),
(101, 5, 42),
(102, 5, 43),
(103, 5, 44),
(104, 5, 45),
(105, 5, 46),
(106, 5, 27),
(107, 5, 19),
(108, 5, 18),
(109, 5, 17),
(110, 5, 16),
(111, 5, 15),
(112, 5, 14),
(113, 5, 13),
(114, 5, 12),
(115, 5, 30),
(116, 5, 31),
(117, 5, 32),
(118, 6, 23),
(119, 6, 22),
(120, 6, 21),
(121, 6, 20),
(122, 6, 19),
(123, 6, 18),
(124, 6, 17),
(125, 6, 16),
(126, 6, 55),
(127, 6, 56),
(128, 6, 57),
(129, 6, 58),
(130, 6, 59),
(131, 6, 60),
(132, 6, 61),
(133, 6, 62),
(134, 6, 63),
(135, 6, 64),
(136, 6, 65),
(137, 6, 66),
(138, 6, 67),
(139, 6, 68),
(140, 6, 69),
(141, 7, 70),
(142, 7, 71),
(143, 7, 72),
(144, 7, 67),
(145, 7, 66),
(146, 7, 65),
(147, 7, 73),
(148, 7, 74),
(149, 7, 75),
(150, 7, 76),
(151, 7, 13),
(152, 7, 12),
(153, 7, 11),
(154, 7, 10),
(155, 7, 77),
(156, 7, 33),
(157, 7, 34),
(158, 7, 35),
(159, 7, 36),
(160, 7, 78),
(161, 7, 79);

-- --------------------------------------------------------

--
-- Table structure for table `stop_activities`
--

CREATE TABLE IF NOT EXISTS `stop_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trip_id` int(11) NOT NULL,
  `stop_id` int(11) NOT NULL,
  `alighted_commuters` int(11) NOT NULL,
  `boarded_commuters` int(11) NOT NULL,
  `arrival_time` int(11) NOT NULL,
  `departure_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trip_id` (`trip_id`),
  KEY `stop_id` (`stop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE IF NOT EXISTS `surveys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `route_id` (`route_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `route_id`, `start_date`, `end_date`) VALUES
(1, 1, 1369267200, 1369267200);

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE IF NOT EXISTS `trips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `begin_stop` int(11) NOT NULL,
  `end_stop` int(11) NOT NULL,
  `departure_from_begin_stop` int(11) NOT NULL,
  `arrival_at_end_stop` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `route_id` (`route_id`),
  KEY `bus_id` (`bus_id`),
  KEY `survey_id` (`survey_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `survey_id`, `route_id`, `bus_id`, `begin_stop`, `end_stop`, `departure_from_begin_stop`, `arrival_at_end_stop`) VALUES
(1, 1, 1, 1, 1, 13, 1369323600, 1369325880),
(2, 1, 1, 2, 1, 13, 1369328580, 1369330980),
(3, 1, 1, 3, 1, 13, 1369333140, 1369334820),
(4, 1, 1, 1, 13, 1, 1369326780, 1369328100),
(5, 1, 1, 2, 13, 1, 1369330980, 1369332540);

-- --------------------------------------------------------

--
-- Table structure for table `user_admins`
--

CREATE TABLE IF NOT EXISTS `user_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_type` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_level` int(5) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `object_type` (`object_type`),
  KEY `admin_level` (`admin_level`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user_admins`
--

INSERT INTO `user_admins` (`id`, `object_type`, `username`, `password`, `admin_level`, `first_name`, `last_name`, `email_address`) VALUES
(1, 5, 'admin', '123', 3, 'Admin', 'User', 'aftha.jaldin88@gmail.com'),
(2, 5, 'afthaj', 'afthaj', 3, 'Aftha', 'Jaldin', 'afthajaldin@yahoo.com'),
(4, 5, 'buddhi', 'buddhi123', 3, 'Buddhi', 'De Silva', 'gbidsilva@gmail.com'),
(7, 5, 'laleen', 'laleen123', 3, 'Laleen', 'Pallegoda', 'laleen.kp@gmail.com'),
(8, 5, 'sachith', 'sachith123', 3, 'Sachith', 'Senevirathna', 'vihanga88@gmail.com'),
(10, 5, 'sandunika', 'sandunika123', 3, 'Sandunika', 'Wijerathne', 'swijerathne35@gmail.com'),
(11, 5, 'janitha', 'janitha123', 1, 'Janitha', 'Rasanga', 'janitharasanga@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_commuters`
--

CREATE TABLE IF NOT EXISTS `user_commuters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_type` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `object_type` (`object_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_commuters`
--

INSERT INTO `user_commuters` (`id`, `object_type`, `username`, `password`, `first_name`, `last_name`, `email_address`) VALUES
(1, 6, 'gencomm', 'gencomm123', 'Generic', 'Commuter', 'aftha.jaldin88@gmail.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buses`
--
ALTER TABLE `buses`
  ADD CONSTRAINT `buses_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `buses_bus_personnel`
--
ALTER TABLE `buses_bus_personnel`
  ADD CONSTRAINT `buses_bus_personnel_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buses_bus_personnel_ibfk_2` FOREIGN KEY (`bus_personnel_id`) REFERENCES `bus_personnel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bus_personnel`
--
ALTER TABLE `bus_personnel`
  ADD CONSTRAINT `bus_personnel_ibfk_1` FOREIGN KEY (`object_type`) REFERENCES `object_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bus_personnel_ibfk_2` FOREIGN KEY (`role`) REFERENCES `bus_personnel_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`complaint_type`) REFERENCES `complaint_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `complaints_ibfk_2` FOREIGN KEY (`status`) REFERENCES `complaint_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complaint_types`
--
ALTER TABLE `complaint_types`
  ADD CONSTRAINT `complaint_types_ibfk_1` FOREIGN KEY (`related_object_type`) REFERENCES `object_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `photographs`
--
ALTER TABLE `photographs`
  ADD CONSTRAINT `photographs_ibfk_1` FOREIGN KEY (`related_object_type`) REFERENCES `object_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `photographs_ibfk_2` FOREIGN KEY (`photo_type`) REFERENCES `photo_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stops_routes`
--
ALTER TABLE `stops_routes`
  ADD CONSTRAINT `stops_routes_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stops_routes_ibfk_2` FOREIGN KEY (`stop_id`) REFERENCES `stops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stop_activities`
--
ALTER TABLE `stop_activities`
  ADD CONSTRAINT `stop_activities_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stop_activities_ibfk_2` FOREIGN KEY (`stop_id`) REFERENCES `stops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surveys`
--
ALTER TABLE `surveys`
  ADD CONSTRAINT `surveys_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trips_ibfk_2` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trips_ibfk_3` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_admins`
--
ALTER TABLE `user_admins`
  ADD CONSTRAINT `user_admins_ibfk_1` FOREIGN KEY (`object_type`) REFERENCES `object_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_admins_ibfk_2` FOREIGN KEY (`admin_level`) REFERENCES `admin_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_commuters`
--
ALTER TABLE `user_commuters`
  ADD CONSTRAINT `user_commuters_ibfk_1` FOREIGN KEY (`object_type`) REFERENCES `object_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
