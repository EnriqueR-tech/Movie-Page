-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2026 at 08:43 AM
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
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie details`
--

INSERT INTO `movie details` (`movie_id`, `Title`, `Runtime`, `Rating`, `Description`, `image_url`) VALUES
(1, 'A Minecraft Movie', '01:41:00', 5.6, 'Four misfits are suddenly pulled through a mysterious portal into a bizarre cubic wonderland that thrives on imagination. To get back home they\'ll have to master this world while embarking on a quest with an unexpected expert crafter.', ''),
(2, 'Summer Wars', '01:54:00', 7.4, 'A student tries to fix a problem he accidentally caused in OZ, a digital world, while pretending to be the fiancé of his friend at her grandmother\'s 90th birthday.', ''),
(3, 'Point Break', '02:51:02', 7.2, 'An F.B.I. Agent goes undercover to catch a gang of surfers who may be bank robbers.', ''),
(6, 'Starship Troopers(1997)', '02:09:00', 7.3, 'Humans, in a fascist militaristic future, wage war with giant alien bugs. Would you like to know more?', ''),
(7, 'Hello World', '00:00:10', 14.0, 'Hello From Dallas College and Team Popcorn. This is a test of Input Data on this form', ''),
(8, 'Transformers(2007)', '02:24:00', 7.6, 'An ancient struggle between two Cybertronian races, the heroic Autobots and the evil Decepticons, comes to Earth, with a clue to the ultimate power held by a teenager.', ''),
(9, 'John Wick', '01:40:00', 10.0, '   Hello World Testing 2', ''),
(10, '    Unbreakable(200)', '01:47:00', 10.0, '  A man learns something extraordinary about himself after a devastating accident.', ''),
(12, 'Sasuage Party', '00:00:06', 17.0, 'A terrible rated R movie that tricked parents thinking this is a cute PG-13 movie with cutesy food characters, but it contain ADULT THEME AND ADULT HUMOR (college humor)', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movie details`
--
ALTER TABLE `movie details`
  ADD PRIMARY KEY (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movie details`
--
ALTER TABLE `movie details`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
