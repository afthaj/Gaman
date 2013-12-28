-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2013 at 11:10 PM
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
-- Table structure for table `admin_levels`
--

CREATE TABLE `admin_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_level_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `admin_levels`
--

INSERT INTO `admin_levels` VALUES(1, 'Time Keeper');
INSERT INTO `admin_levels` VALUES(2, 'Stand OIC');
INSERT INTO `admin_levels` VALUES(3, 'Scheduler');
INSERT INTO `admin_levels` VALUES(4, 'Admin Level 4');
INSERT INTO `admin_levels` VALUES(5, 'Admin Level 5');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `buses_bus_personnel`
--

INSERT INTO `buses_bus_personnel` VALUES(2, 2, 1);
INSERT INTO `buses_bus_personnel` VALUES(3, 3, 1);
INSERT INTO `buses_bus_personnel` VALUES(4, 5, 1);
INSERT INTO `buses_bus_personnel` VALUES(5, 7, 2);
INSERT INTO `buses_bus_personnel` VALUES(6, 5, 3);
INSERT INTO `buses_bus_personnel` VALUES(7, 2, 3);
INSERT INTO `buses_bus_personnel` VALUES(8, 1, 2);
INSERT INTO `buses_bus_personnel` VALUES(9, 1, 1);
INSERT INTO `buses_bus_personnel` VALUES(10, 7, 3);
INSERT INTO `buses_bus_personnel` VALUES(11, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `bus_personnel`
--

CREATE TABLE `bus_personnel` (
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

INSERT INTO `bus_personnel` VALUES(1, 4, 1, 'kamal', '123', 'Kamal', 'Indika', '801231511v', '0774422980');
INSERT INTO `bus_personnel` VALUES(2, 4, 4, 'nihal', '123', 'Nihal', 'Shantha', '823231511v', '');
INSERT INTO `bus_personnel` VALUES(3, 4, 3, 'hasitha', '123', 'Hasitha', 'Perera', '842321151v', '');

-- --------------------------------------------------------

--
-- Table structure for table `bus_personnel_roles`
--

CREATE TABLE `bus_personnel_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bus_personnel_roles`
--

INSERT INTO `bus_personnel_roles` VALUES(1, 'Bus Owner');
INSERT INTO `bus_personnel_roles` VALUES(2, 'Bus Driver');
INSERT INTO `bus_personnel_roles` VALUES(3, 'Bus Conductor');
INSERT INTO `bus_personnel_roles` VALUES(4, 'Bus Owner + Driver');
INSERT INTO `bus_personnel_roles` VALUES(5, 'Bus Owner + Conductor');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
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

INSERT INTO `complaints` VALUES(1, 1, 2, 5, 1, 2, 1378815876, 1, 'Buses are consistently overcrowded');
INSERT INTO `complaints` VALUES(2, 2, 12, 4, 1, 5, 1365441021, 1, 'There''s no proper bus stop for the commuters to stand at');
INSERT INTO `complaints` VALUES(3, 3, 3, 5, 1, 9, 1376137476, 1, 'The bus loiters consistently at the Rajagiriya Bus Stop');
INSERT INTO `complaints` VALUES(4, 2, 19, 4, 1, 8, 1376143840, 1, 'There isn''t enough room for buses to stop most of the time');
INSERT INTO `complaints` VALUES(5, 3, 7, 5, 1, 20, 1373885115, 1, 'The conductor smelled of alcohol');
INSERT INTO `complaints` VALUES(6, 3, 1, 5, 1, 9, 1379597255, 1, 'Bus loitered at the rajagiriya bus stop for over 10 minutes');
INSERT INTO `complaints` VALUES(7, 1, 6, 5, 1, 4, 1379599906, 1, 'Buses are not to be seen after 7pm even though the operational hours end at 9.30');
INSERT INTO `complaints` VALUES(8, 3, 2, 5, 1, 15, 1379599940, 1, 'This particular bus driver was talking on the phone while driving, endangering the lives of the passengers');
INSERT INTO `complaints` VALUES(9, 3, 5, 5, 1, 16, 1379599972, 1, 'Conductor didn''t give the proper balance money back to me.');
INSERT INTO `complaints` VALUES(10, 3, 2, 5, 1, 10, 1379599995, 1, 'Conductor didn''t issue a ticket to me');
INSERT INTO `complaints` VALUES(11, 1, 1, 6, 1, 1, 1379788569, 1, 'Bus delays are very common in this bus route');
INSERT INTO `complaints` VALUES(12, 3, 1, 6, 1, 10, 1379789236, 1, 'The bus conductor did not issue a ticket to me.');
INSERT INTO `complaints` VALUES(13, 2, 18, 6, 1, 6, 1379789291, 1, 'Buses don''t stop at the proper place in the bus stop');
INSERT INTO `complaints` VALUES(14, 1, 1, 6, 1, 2, 1379833500, 1, 'The buses are consistently overcrowded on this route');
INSERT INTO `complaints` VALUES(15, 2, 5, 6, 1, 7, 1379836155, 1, 'There is no sign board that informs commuters of the bus stop at this bus stop.');
INSERT INTO `complaints` VALUES(16, 3, 6, 6, 1, 11, 1379838343, 1, 'The bus was overcrowded purposefully without regard to passenger safety');
INSERT INTO `complaints` VALUES(17, 1, 1, 5, 1, 4, 1379847113, 1, 'during the weekends, the buses don''t run for all of the operational hours');
INSERT INTO `complaints` VALUES(18, 1, 1, 4, 1, 2, 1380614624, 1, 'The route is always crowded and the buses keep crowding it even more');
INSERT INTO `complaints` VALUES(19, 3, 7, 6, 1, 11, 1380615922, 1, 'The bus picked up more people than it could carry, making the ride uncomfortable for the passengers');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_status`
--

CREATE TABLE `complaint_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comp_status_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `complaint_status`
--

INSERT INTO `complaint_status` VALUES(1, 'Submitted');
INSERT INTO `complaint_status` VALUES(2, 'Pending Review');
INSERT INTO `complaint_status` VALUES(3, 'Reviewed and Closed');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_types`
--

CREATE TABLE `complaint_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_object_type` int(11) NOT NULL,
  `comp_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `related_object_type` (`related_object_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `complaint_types`
--

INSERT INTO `complaint_types` VALUES(1, 1, 'Bus Delays');
INSERT INTO `complaint_types` VALUES(2, 1, 'Overcrowded Buses');
INSERT INTO `complaint_types` VALUES(3, 1, 'Lack of Buses');
INSERT INTO `complaint_types` VALUES(4, 1, 'Lack of Buses during the Route''s Operational Hours');
INSERT INTO `complaint_types` VALUES(5, 2, 'No proper Bus Stop');
INSERT INTO `complaint_types` VALUES(6, 2, 'Buses don''t stop at the correct area in the Bus Stop');
INSERT INTO `complaint_types` VALUES(7, 2, 'Bus Stop not marked correctly');
INSERT INTO `complaint_types` VALUES(8, 2, 'Insufficient area for Buses to stop');
INSERT INTO `complaint_types` VALUES(9, 3, 'Loitering at Bus Stop');
INSERT INTO `complaint_types` VALUES(10, 3, 'Not issuing a valid ticket');
INSERT INTO `complaint_types` VALUES(11, 3, 'Overcrowding the Bus');
INSERT INTO `complaint_types` VALUES(12, 3, 'Stopping at undesignated Bus Stops');
INSERT INTO `complaint_types` VALUES(13, 3, 'Reckless driving');
INSERT INTO `complaint_types` VALUES(14, 3, 'Neglecting road rules');
INSERT INTO `complaint_types` VALUES(15, 3, 'Diverting attention while driving');
INSERT INTO `complaint_types` VALUES(16, 3, 'Providing the improper balance money');
INSERT INTO `complaint_types` VALUES(17, 3, 'Not providing the balance money at all');
INSERT INTO `complaint_types` VALUES(18, 3, 'Overcharging a bus fare');
INSERT INTO `complaint_types` VALUES(19, 3, 'Rude/discourteous service');
INSERT INTO `complaint_types` VALUES(20, 3, 'Unhygienic/non-presentable appearance and/or attire');
INSERT INTO `complaint_types` VALUES(21, 3, 'Failure to display the Fare Table in the Bus');
INSERT INTO `complaint_types` VALUES(22, 3, 'Operating without a valid Driver''s license');
INSERT INTO `complaint_types` VALUES(23, 3, 'Operating without a valid Conductor''s license');
INSERT INTO `complaint_types` VALUES(24, 3, 'Operating without a valid Route Permit');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_items`
--

CREATE TABLE `feedback_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_object_type` int(11) NOT NULL,
  `related_object_id` int(11) NOT NULL,
  `user_object_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_time_submitted` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `feedback_items`
--

INSERT INTO `feedback_items` VALUES(1, 1, 1, 6, 1, 1379841516, 'This route is very good. The AC buses are fairly comfortable and prompt. The normal buses loiter a little too much at certain stops.');
INSERT INTO `feedback_items` VALUES(2, 1, 2, 4, 1, 1380613376, 'The route is very good');
INSERT INTO `feedback_items` VALUES(3, 2, 1, 4, 1, 1380613542, 'The bus stop can get quite congested sometimes');
INSERT INTO `feedback_items` VALUES(4, 3, 2, 4, 1, 1380614580, 'This bus did a very good job');
INSERT INTO `feedback_items` VALUES(5, 1, 2, 6, 1, 1380615545, 'The route is very enjoyable');
INSERT INTO `feedback_items` VALUES(6, 4, 3, 6, 1, 1380825234, 'He is a very good bus conductor');

-- --------------------------------------------------------

--
-- Table structure for table `object_types`
--

CREATE TABLE `object_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_flag` int(1) NOT NULL,
  `object_type_name` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `object_types`
--

INSERT INTO `object_types` VALUES(1, 0, 'route', 'Bus Route');
INSERT INTO `object_types` VALUES(2, 0, 'stop', 'Bus Stop');
INSERT INTO `object_types` VALUES(3, 0, 'bus', 'Bus');
INSERT INTO `object_types` VALUES(4, 1, 'bus_personnel', 'Bus Personnel');
INSERT INTO `object_types` VALUES(5, 1, 'admin', 'Admin User');
INSERT INTO `object_types` VALUES(6, 1, 'commuter', 'Commuter');
INSERT INTO `object_types` VALUES(7, 0, 'complaint', 'Complaint');

-- --------------------------------------------------------

--
-- Table structure for table `photographs`
--

CREATE TABLE `photographs` (
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

INSERT INTO `photographs` VALUES(18, 5, 8, 9, 'generic-user.jpg', 'image/jpeg', '6195');
INSERT INTO `photographs` VALUES(19, 5, 11, 9, 'generic-user.jpg', 'image/jpeg', '261559');
INSERT INTO `photographs` VALUES(20, 5, 1, 9, 'generic-user.jpg', 'image/jpeg', '70034');
INSERT INTO `photographs` VALUES(21, 5, 4, 9, 'generic-user.jpg', 'image/jpeg', '33102');
INSERT INTO `photographs` VALUES(22, 2, 1, 10, 'generic-bus-stop.jpg', 'image/jpeg', '21804');
INSERT INTO `photographs` VALUES(23, 2, 1, 11, 'generic-bus-stop.jpg', 'image/jpeg', '105293');
INSERT INTO `photographs` VALUES(24, 2, 1, 12, 'generic-bus-stop.jpg', 'image/jpeg', '90063');
INSERT INTO `photographs` VALUES(25, 2, 2, 10, 'generic-bus-stop.jpg', 'image/jpeg', '22031');
INSERT INTO `photographs` VALUES(26, 2, 2, 11, 'generic-bus-stop.jpg', 'image/jpeg', '73071');
INSERT INTO `photographs` VALUES(27, 3, 1, 1, 'generic-bus.jpg', 'image/jpeg', '37090');
INSERT INTO `photographs` VALUES(28, 3, 1, 2, 'generic-bus.jpg', 'image/jpeg', '43218');
INSERT INTO `photographs` VALUES(29, 3, 2, 1, 'generic-bus.jpg', 'image/jpeg', '37227');
INSERT INTO `photographs` VALUES(30, 3, 2, 2, 'generic-bus.jpg', 'image/jpeg', '68710');
INSERT INTO `photographs` VALUES(31, 3, 3, 1, 'generic-bus.jpg', 'image/jpeg', '34694');
INSERT INTO `photographs` VALUES(32, 3, 3, 5, 'generic-bus.jpg', 'image/jpeg', '53572');
INSERT INTO `photographs` VALUES(33, 3, 1, 6, 'generic-bus.jpg', 'image/jpeg', '24515');
INSERT INTO `photographs` VALUES(34, 4, 1, 9, 'generic-user.jpg', 'image/jpeg', '31614');
INSERT INTO `photographs` VALUES(35, 4, 2, 9, 'generic-user.jpg', 'image/jpeg', '37737');
INSERT INTO `photographs` VALUES(36, 4, 3, 9, 'generic-user.jpg', 'image/jpeg', '28270');
INSERT INTO `photographs` VALUES(37, 5, 7, 9, 'generic-user.jpg', 'image/jpeg', '27079');

-- --------------------------------------------------------

--
-- Table structure for table `photo_types`
--

CREATE TABLE `photo_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_object` varchar(50) NOT NULL,
  `photo_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `related_object` (`related_object`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `photo_types`
--

INSERT INTO `photo_types` VALUES(1, 'bus', 'Front of Bus');
INSERT INTO `photo_types` VALUES(2, 'bus', 'Rear of Bus');
INSERT INTO `photo_types` VALUES(3, 'bus', 'Port side of Bus');
INSERT INTO `photo_types` VALUES(4, 'bus', 'Starboard side of Bus');
INSERT INTO `photo_types` VALUES(5, 'bus', 'Front + Port side of Bus');
INSERT INTO `photo_types` VALUES(6, 'bus', 'Front + Starboard side of Bus');
INSERT INTO `photo_types` VALUES(7, 'bus', 'Rear + Port side of Bus');
INSERT INTO `photo_types` VALUES(8, 'bus', 'Rear + Starboard side of Bus');
INSERT INTO `photo_types` VALUES(9, 'other', 'User Profile');
INSERT INTO `photo_types` VALUES(10, 'bus_stop', 'Location of Stop');
INSERT INTO `photo_types` VALUES(11, 'bus_stop', 'Facing forward at Bus Stop');
INSERT INTO `photo_types` VALUES(12, 'bus_stop', 'Facing behind at Bus Stop');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
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

INSERT INTO `routes` VALUES(1, 177, 20, 35, 26, 1);
INSERT INTO `routes` VALUES(2, 171, 15, 30, 27, 40);
INSERT INTO `routes` VALUES(3, 170, 20, 45, 47, 52);
INSERT INTO `routes` VALUES(4, 190, 23, 45, 53, 52);
INSERT INTO `routes` VALUES(5, 174, 15, 35, 41, 32);
INSERT INTO `routes` VALUES(6, 163, 22, 45, 23, 69);
INSERT INTO `routes` VALUES(7, 176, 24, 40, 70, 79);

-- --------------------------------------------------------

--
-- Table structure for table `stops`
--

CREATE TABLE `stops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location_latitude` varchar(255) NOT NULL,
  `location_longitude` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `stops`
--

INSERT INTO `stops` VALUES(1, 'Kolpetty - Railway Station', '6.911111', '79.849189');
INSERT INTO `stops` VALUES(2, 'Kolpetty - Supermarket', '6.911995', '79.850505');
INSERT INTO `stops` VALUES(3, 'Kolpetty - Alwis Place', '6.91265', '79.85367');
INSERT INTO `stops` VALUES(4, 'Colombo Public Library', '6.912946', '79.858058');
INSERT INTO `stops` VALUES(5, 'SLTA', '6.910853', '79.858648');
INSERT INTO `stops` VALUES(6, 'Nelum Pokuna Theater', '6.9104', '79.863701');
INSERT INTO `stops` VALUES(7, 'Central', '6.911574', '79.868336');
INSERT INTO `stops` VALUES(8, 'Wijerama', '6.911508', '79.871109');
INSERT INTO `stops` VALUES(9, 'Borella - Horton Place', '6.911356', '79.877021');
INSERT INTO `stops` VALUES(10, 'Devi Balika', '6.911074', '79.882619');
INSERT INTO `stops` VALUES(11, 'Castle Street', '6.911031', '79.885754');
INSERT INTO `stops` VALUES(12, 'Ayurveda', '6.910794', '79.88875');
INSERT INTO `stops` VALUES(13, 'Rajagiriya', '6.910126', '79.894361');
INSERT INTO `stops` VALUES(14, 'NAITA', '6.907482', '79.899948');
INSERT INTO `stops` VALUES(15, 'Welikada', '6.907482', '79.899948');
INSERT INTO `stops` VALUES(16, 'Ethul Kotte - Sri Jayawardenapura Mw', '6.90315', '79.907528');
INSERT INTO `stops` VALUES(17, 'Polduwa', '6.903096', '79.911637');
INSERT INTO `stops` VALUES(18, 'Sethsiripaya', '6.902194', '79.915559');
INSERT INTO `stops` VALUES(19, 'Battaramulla', '6.902087', '79.917938');
INSERT INTO `stops` VALUES(20, 'Battaramulla - Singer', '6.903544', '79.92168');
INSERT INTO `stops` VALUES(21, 'Ganahena', '6.904183', '79.92396');
INSERT INTO `stops` VALUES(22, 'Koswatte - Thalangama Depot', '6.90594', '79.926478');
INSERT INTO `stops` VALUES(23, 'Koswatte', '6.907623', '79.92916');
INSERT INTO `stops` VALUES(24, 'Thalahena', '6.907961', '79.944975');
INSERT INTO `stops` VALUES(25, 'Malabe', '6.904036', '79.954526');
INSERT INTO `stops` VALUES(26, 'Kaduwela', '6.936438', '79.982994');
INSERT INTO `stops` VALUES(27, 'Pelawatte - Palam thuna (3 bridges)', '', '');
INSERT INTO `stops` VALUES(28, 'Videsha Seva (Foreign Employment Bureau)', '', '');
INSERT INTO `stops` VALUES(29, 'Palath Sabha (Western Provincial Council)', '', '');
INSERT INTO `stops` VALUES(30, 'Gothami Road', '', '');
INSERT INTO `stops` VALUES(31, 'Cotta Road', '', '');
INSERT INTO `stops` VALUES(32, 'Borella - Supermarket', '', '');
INSERT INTO `stops` VALUES(33, 'Borella - Maradana Road', '', '');
INSERT INTO `stops` VALUES(34, 'Borella - Aquinas', '', '');
INSERT INTO `stops` VALUES(35, 'Punchi Borella', '', '');
INSERT INTO `stops` VALUES(36, 'Maradana', '', '');
INSERT INTO `stops` VALUES(37, 'Technical Junction', '', '');
INSERT INTO `stops` VALUES(38, 'Bo Gaha Handiya (Bo Tree Junction)', '', '');
INSERT INTO `stops` VALUES(39, 'Hultsdorf', '', '');
INSERT INTO `stops` VALUES(40, 'Fort', '', '');
INSERT INTO `stops` VALUES(41, 'Kottawa', '', '');
INSERT INTO `stops` VALUES(42, 'Pannipitiya - Old Road', '', '');
INSERT INTO `stops` VALUES(43, 'Thalawathugoda', '', '');
INSERT INTO `stops` VALUES(44, 'Jayawadanagama', '', '');
INSERT INTO `stops` VALUES(45, 'Isurupaya', '', '');
INSERT INTO `stops` VALUES(46, 'Pelawatte', '', '');
INSERT INTO `stops` VALUES(47, 'Athurugiriya', '6.877389', '79.989303');
INSERT INTO `stops` VALUES(48, 'Borella - Ward Place', '', '');
INSERT INTO `stops` VALUES(49, 'Eye Hospital', '', '');
INSERT INTO `stops` VALUES(50, 'Darley Road', '', '');
INSERT INTO `stops` VALUES(51, 'McCallum Road (D. R. Wijewardena Mw)', '', '');
INSERT INTO `stops` VALUES(52, 'Pettah', '', '');
INSERT INTO `stops` VALUES(53, 'Meegoda', '6.854978', '80.058182');
INSERT INTO `stops` VALUES(54, 'Godagama', '6.851313', '80.032905');
INSERT INTO `stops` VALUES(55, 'Ethul Kotte - Telecom', '', '');
INSERT INTO `stops` VALUES(56, 'Mati Ambalama', '', '');
INSERT INTO `stops` VALUES(57, 'Kotubamma (Rampart Road)', '', '');
INSERT INTO `stops` VALUES(58, 'CMS', '', '');
INSERT INTO `stops` VALUES(59, 'Solis', '', '');
INSERT INTO `stops` VALUES(60, 'Pita Kotte', '', '');
INSERT INTO `stops` VALUES(61, 'Ananda Balika', '', '');
INSERT INTO `stops` VALUES(62, 'Pagoda Road', '', '');
INSERT INTO `stops` VALUES(63, 'Nugegoda - Pagoda Road', '', '');
INSERT INTO `stops` VALUES(64, 'Nugegoda - Supermarket', '', '');
INSERT INTO `stops` VALUES(65, 'Nugegoda - High Level Road', '', '');
INSERT INTO `stops` VALUES(66, 'Kohuwala', '', '');
INSERT INTO `stops` VALUES(67, 'Kalubowila', '', '');
INSERT INTO `stops` VALUES(68, 'William''s Grinding Mill', '', '');
INSERT INTO `stops` VALUES(69, 'Dehiwala', '', '');
INSERT INTO `stops` VALUES(70, 'Karagampitiya', '', '');
INSERT INTO `stops` VALUES(71, 'Dehiwala - Zoo', '', '');
INSERT INTO `stops` VALUES(72, 'S. De S. Jayasinghe Ground', '', '');
INSERT INTO `stops` VALUES(73, 'Nugegoda - Nawala Road', '', '');
INSERT INTO `stops` VALUES(74, 'Nawala', '', '');
INSERT INTO `stops` VALUES(75, 'Nawala - Koswatte', '', '');
INSERT INTO `stops` VALUES(76, 'Kotte Municipal Council', '', '');
INSERT INTO `stops` VALUES(77, 'Borella - YMBA', '', '');
INSERT INTO `stops` VALUES(78, 'Armor Street', '', '');
INSERT INTO `stops` VALUES(79, 'Hettiyawatte', '', '');

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
-- Table structure for table `stop_activities`
--

CREATE TABLE `stop_activities` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `stop_activities`
--

INSERT INTO `stop_activities` VALUES(1, 1, 1, 0, 11, 0, 1369323600);
INSERT INTO `stop_activities` VALUES(2, 1, 2, 0, 10, 1369323840, 1369323900);

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
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

INSERT INTO `surveys` VALUES(1, 1, 1369267200, 1369267200);

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
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

INSERT INTO `trips` VALUES(1, 1, 1, 1, 1, 13, 1369323600, 1369325880);
INSERT INTO `trips` VALUES(2, 1, 1, 2, 1, 13, 1369328580, 1369330980);
INSERT INTO `trips` VALUES(3, 1, 1, 3, 1, 13, 1369333140, 1369334820);
INSERT INTO `trips` VALUES(4, 1, 1, 1, 13, 1, 1369326780, 1369328100);
INSERT INTO `trips` VALUES(5, 1, 1, 2, 13, 1, 1369330980, 1369332540);

-- --------------------------------------------------------

--
-- Table structure for table `user_admins`
--

CREATE TABLE `user_admins` (
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

INSERT INTO `user_admins` VALUES(1, 5, 'admin', '123', 3, 'Admin', 'User', 'aftha.jaldin88@gmail.com');
INSERT INTO `user_admins` VALUES(2, 5, 'afthaj', 'afthaj', 3, 'Aftha', 'Jaldin', 'afthajaldin@yahoo.com');
INSERT INTO `user_admins` VALUES(4, 5, 'buddhi', 'buddhi123', 3, 'Buddhi', 'De Silva', 'gbidsilva@gmail.com');
INSERT INTO `user_admins` VALUES(7, 5, 'laleen', 'laleen123', 3, 'Laleen', 'Pallegoda', 'laleen.kp@gmail.com');
INSERT INTO `user_admins` VALUES(8, 5, 'sachith', 'sachith123', 3, 'Sachith', 'Senevirathna', 'vihanga88@gmail.com');
INSERT INTO `user_admins` VALUES(10, 5, 'sandunika', 'sandunika123', 3, 'Sandunika', 'Wijerathne', 'swijerathne35@gmail.com');
INSERT INTO `user_admins` VALUES(11, 5, 'janitha', 'janitha123', 1, 'Janitha', 'Rasanga', 'janitharasanga@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_commuters`
--

CREATE TABLE `user_commuters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_type` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `object_type` (`object_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user_commuters`
--

INSERT INTO `user_commuters` VALUES(1, 6, 'heisenberg', '123', 'Walter', 'White', 'gamantransport@gmail.com');
INSERT INTO `user_commuters` VALUES(2, 6, 'whysoserious', '123', 'The', 'Joker', 'thejoker@gothamnet.com');
INSERT INTO `user_commuters` VALUES(4, 6, 'adopted', '123', 'Loki', 'Laufeyson', 'loki@asgardnet.com');
INSERT INTO `user_commuters` VALUES(5, 6, 'manofirony', '123', 'Tony', 'Stark', 'tony@starkindustries.com');

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
