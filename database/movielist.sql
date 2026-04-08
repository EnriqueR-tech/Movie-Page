-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2026 at 10:46 PM
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
-- Database: `movielist`
--

-- --------------------------------------------------------

--
-- Table structure for table `movie details`
--

CREATE TABLE `movie details` (
  `movie_id` int(11) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Runtime` time NOT NULL,
  `Rating` decimal(3,1) NOT NULL,
  `Description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie details`
--

INSERT INTO `movie details` (`movie_id`, `Title`, `Runtime`, `Rating`, `Description`, `image`) VALUES
(1, 'A Minecraft Movie', '01:41:00', 5.6, 'Four misfits are suddenly pulled through a mysterious portal into a bizarre cubic wonderland that thrives on imagination. To get back home they\'ll have to master this world while embarking on a quest with an unexpected expert crafter.', 'AMinecraftMovie.jpg'),
(2, 'Summer Wars', '01:54:00', 7.4, 'A student tries to fix a problem he accidentally caused in OZ, a digital world, while pretending to be the fiancé of his friend at her grandmother\'s 90th birthday.', 'SummerWars.jpg'),
(3, 'Point Break', '02:51:02', 7.2, 'An F.B.I. Agent goes undercover to catch a gang of surfers who may be bank robbers.', 'PointBreak.jpg'),
(6, 'Starship Troopers(1997)', '02:09:00', 7.3, 'Humans, in a fascist militaristic future, wage war with giant alien bugs. Would you like to know more?', 'StarshipTroopers.jpg'),
(7, 'Hello World', '00:00:10', 14.0, 'Hello From Dallas College and Team Popcorn. This is a test of Input Data on this form', 'HelloWorld.jpg'),
(8, 'Transformers(2007)', '02:24:00', 7.6, 'An ancient struggle between two Cybertronian races, the heroic Autobots and the evil Decepticons, comes to Earth, with a clue to the ultimate power held by a teenager.', 'Transformers_2007.jpg'),
(9, 'John Wick', '01:40:00', 10.0, '     Hello World Testing 4', ''),
(10, 'Unbreakable(200)', '01:47:00', 10.0, '   A man learns something extraordinary about himself after a devastating accident.', ''),
(12, 'Sasuage Party', '02:00:00', 2.0, ' A terrible rated R movie that tricked parents thinking this is a cute PG-13 movie with cutesy food characters, but it contain ADULT THEME AND ADULT HUMOR (college humor)', 'SasuageParty.jpg'),
(14, 'Project Hail Mary', '02:03:50', 8.0, '  Science teacher Ryland Grace (Ryan Gosling) wakes up on a spaceship light years from home with no recollection of who he is or how he got there. As his memory returns, he begins to uncover his mission: solve the riddle of the mysterious substance causing the sun to die out. He must call on his scientific knowledge and unorthodox ideas to save everything on Earth from extinction… but an unexpected friendship means he may not have to do it alone.', '');

-- --------------------------------------------------------

--
-- Table structure for table `screening`
--

CREATE TABLE `screening` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `screening`
--

INSERT INTO `screening` (`id`, `movie_id`, `start_time`, `end_time`) VALUES
(1, 1, '2026-04-07 12:00:00', '2026-04-07 15:00:00'),
(2, 2, '2026-04-09 15:00:00', '2026-04-09 17:00:00'),
(3, 14, '2026-04-09 12:00:00', '2026-04-09 15:00:00'),
(4, 2, '2026-04-07 16:00:00', '2026-04-07 17:00:00'),
(5, 1, '2026-04-06 14:00:00', '2026-04-06 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `tickets` int(11) NOT NULL,
  `show_date` date NOT NULL,
  `show_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='To store movie tickets and connect table to movie details';

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `movie_id`, `customer_name`, `tickets`, `show_date`, `show_time`) VALUES
(1, 2, 'Enrique R', 1, '2026-03-27', '15:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movie details`
--
ALTER TABLE `movie details`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `screening`
--
ALTER TABLE `screening`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movie details`
--
ALTER TABLE `movie details`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `screening`
--
ALTER TABLE `screening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movie details` (`movie_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
