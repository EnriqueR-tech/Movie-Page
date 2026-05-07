-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2026 at 12:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_site_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `runtime` time NOT NULL,
  `rating` decimal(3,1) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `trailer_url` varchar(255) NOT NULL,
  `is_hidden` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Storing movie info';

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `runtime`, `rating`, `description`, `image`, `trailer_url`, `is_hidden`) VALUES
(1, 'A Minecraft Movie', '01:41:00', 5.6, 'Four misfits are suddenly pulled through a mysterious portal into a bizarre cubic wonderland that thrives on imagination. To get back home they\'ll have to master this world while embarking on a quest with an unexpected expert crafter.', 'AMinecraftMovie.jpg', 'PE2YZhcC4NY', 0),
(2, 'Summer Wars', '01:54:00', 7.4, 'A student tries to fix a problem he accidentally caused in OZ, a digital world, while pretending to be the fiancé of his friend at her grandmother\'s 90th birthday.', 'SummerWars.jpg', 'Rc8_JO4NAI0', 0),
(3, 'Point Break', '02:51:02', 7.2, 'An F.B.I. Agent goes undercover to catch a gang of surfers who may be bank robbers.', 'PointBreak.jpg', 'jcDD2-s4vWA', 0),
(6, 'Starship Troopers(1997)', '02:09:00', 7.3, 'Humans, in a fascist militaristic future, wage war with giant alien bugs. Would you like to know more?', 'StarshipTroopers.jpg', 'zPYuV_jGk7M', 0),
(7, 'Hello World', '00:00:10', 14.0, 'Hello From Dallas College and Team Popcorn. This is a test of Input Data on this form', 'HelloWorld.jpg', 'kh6gSLInIXo', 1),
(8, 'Transformers(2007)', '02:24:00', 7.6, 'An ancient struggle between two Cybertronian races, the heroic Autobots and the evil Decepticons, comes to Earth, with a clue to the ultimate power held by a teenager.', 'Transformers_2007.jpg', 'CbX_SIz_9fk', 0),
(9, 'John Wick', '01:40:00', 8.0, '      Hello World Testing 4', 'JohnWick.jpg', 'C0BMx-qxsP4', 0),
(10, 'Unbreakable(200)', '01:47:00', 10.0, '   A man learns something extraordinary about himself after a devastating accident.', 'Unbreakable.jpg', 'fNeCB2ALNoA', 0),
(14, 'Project Hail Mary', '02:03:50', 8.0, '  Science teacher Ryland Grace (Ryan Gosling) wakes up on a spaceship light years from home with no recollection of who he is or how he got there. As his memory returns, he begins to uncover his mission: solve the riddle of the mysterious substance causing the sun to die out. He must call on his scientific knowledge and unorthodox ideas to save everything on Earth from extinction… but an unexpected friendship means he may not have to do it alone.', '', '', 0),
(17, 'Ghost In The Shell', '01:22:40', 8.0, ' In the year 2029, the world has become interconnected by a vast electronic network that permeates every aspect of life. That same network also becomes a battelfield for Tokyo\'s Section Nine security force, which has been charged with apprehending the master hacker known only as the Puppet Master. Spearheading the investigation is Major Motoko Kusanagi, who - like many in her department - is a cyborg officer, far more powerful than her human appearance would suggest. And yet as the Puppet Master, who is even capable of hacking human minds, leaves a trail of victims robbed of their memories. Motoko begins to ponder the very nature of her existence: is she purely an artificial construct, or is there more? What, exactly, is the ', 'GhostInTheShell.jpg', 'aADTX6CmIx4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `screenings`
--

CREATE TABLE `screenings` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `theater_name` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `capacity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `screenings`
--

INSERT INTO `screenings` (`id`, `movie_id`, `theater_name`, `start_time`, `end_time`, `capacity`) VALUES
(1, 1, 'AMC DINE-IN Mesquite 30', '2026-04-07 12:00:00', '2026-04-07 15:00:00', 100),
(2, 2, 'AMC Center 12', '2026-04-09 15:00:00', '2026-04-09 17:00:00', 100),
(3, 14, 'AMC Heights 8', '2026-04-09 12:00:00', '2026-04-09 15:00:00', 100),
(4, 2, 'AMC DINE-IN Mesquite 30', '2026-04-07 16:00:00', '2026-04-07 17:00:00', 98),
(5, 1, 'AMC Plaza 15', '2026-04-06 14:00:00', '2026-04-06 16:00:00', 100),
(8, 14, 'AMC DINE-IN Mesquite 30', '2026-04-16 14:00:00', '2026-04-16 16:30:00', 30),
(9, 17, 'AMC DINE-IN Mesquite 30', '2026-04-16 12:00:00', '2026-04-16 14:00:00', 59),
(10, 2, 'AMC CLASSIC Forney 12', '2026-04-17 12:00:00', '2026-04-17 14:30:00', 22),
(11, 8, 'AMC DINE-IN Mesquite 30', '2026-04-16 17:00:00', '2026-04-16 20:00:00', 0),
(12, 9, 'AMC NorthPark 15', '2026-04-16 17:00:00', '2026-04-16 20:00:00', 0),
(13, 1, 'AMC DINE-IN Mesquite 30', '2026-05-02 14:00:00', '2026-05-02 16:00:00', 15),
(14, 8, 'AMC DINE-IN Mesquite 30', '2026-05-08 12:00:00', '2026-05-08 14:00:00', 20),
(15, 14, 'AMC DINE-IN Mesquite 30', '2026-05-08 14:00:00', '2026-05-08 16:00:00', 20);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `screening_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `tickets` int(11) NOT NULL,
  `theater_loc` varchar(255) NOT NULL,
  `show_date` date NOT NULL,
  `show_time` time NOT NULL,
  `ticket_code` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='To store movie tickets and connect table to movie details';

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `movie_id`, `screening_id`, `customer_name`, `tickets`, `theater_loc`, `show_date`, `show_time`, `ticket_code`) VALUES
(1, 2, 0, 'Enrique R', 1, '', '2026-03-27', '15:00:00', 'dcb7514f-45e4-11f1-9a32-7085c2c543ab'),
(2, 2, 0, 'NEMO', 1, 'AMC DINE-IN Mesquite 30', '2026-04-07', '16:00:00', 'dcb766d7-45e4-11f1-9a32-7085c2c543ab'),
(3, 2, 0, 'NEMO', 2, 'AMC CLASSIC Forney 12', '2026-04-17', '12:00:00', 'dcb76757-45e4-11f1-9a32-7085c2c543ab'),
(4, 2, 0, 'NEMO', 2, 'AMC CLASSIC Forney 12', '2026-04-17', '12:00:00', 'dcb767a4-45e4-11f1-9a32-7085c2c543ab'),
(5, 2, 0, 'FanGirl', 4, 'AMC CLASSIC Forney 12', '2026-04-17', '12:00:00', 'dcb767df-45e4-11f1-9a32-7085c2c543ab'),
(6, 17, 0, 'NEMO', 1, 'AMC DINE-IN Mesquite 30', '2026-04-16', '12:00:00', 'dcb76813-45e4-11f1-9a32-7085c2c543ab'),
(13, 1, 13, 'Goober', 1, 'AMC DINE-IN Mesquite 30', '0000-00-00', '14:00:00', 'TK-69F5978E561B3'),
(15, 1, 13, 'Goober', 1, 'AMC DINE-IN Mesquite 30', '2026-05-02', '14:00:00', 'TK-69F59A4C0B355');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `screenings`
--
ALTER TABLE `screenings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_tickets_code` (`ticket_code`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `screening_id` (`screening_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `screenings`
--
ALTER TABLE `screenings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `screenings`
--
ALTER TABLE `screenings`
  ADD CONSTRAINT `screenings_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`screening_id`) REFERENCES `screenings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
