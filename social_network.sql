-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2019 at 11:29 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_network`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(512) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`com_id`, `post_id`, `user_id`, `comment`, `comment_author`, `date`) VALUES
(2, 0, 6, 'how u doing?								', 'Pullak', '2019-04-22 08:06:41'),
(3, 1, 7, 'wats going on??									', 'Saksham', '2019-04-22 08:52:14'),
(4, 16, 11, '			good graph!!						', 'Prathyush', '2019-04-25 09:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `lid` int(100) NOT NULL,
  `ltime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`lid`, `ltime`, `userid`) VALUES
(21, '2019-04-25 14:44:42', 12),
(22, '2019-04-27 14:41:30', 11);

--
-- Triggers `login`
--
DELIMITER $$
CREATE TRIGGER `duplicate_login` BEFORE INSERT ON `login` FOR EACH ROW BEGIN
DECLARE curr_time DATETIME;
DECLARE uid INTEGER;
    SET @curr_time := NEW.ltime;
    SET @uid := NEW.userid;
IF EXISTS (SELECT * FROM login WHERE userid = uid)
THEN
	SIGNAL SQLSTATE '45000';
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `msg_body` varchar(1024) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msg_seen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(100) NOT NULL,
  `post_content` varchar(1000) NOT NULL,
  `upload_image` varchar(1000) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(32) NOT NULL,
  `email` varchar(256) NOT NULL,
  `f_name` text NOT NULL,
  `l_name` text NOT NULL,
  `password` varchar(60) NOT NULL,
  `country` text NOT NULL,
  `gender` text NOT NULL,
  `dob` varchar(100) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `posts` text NOT NULL,
  `recovery_account` varchar(1000) NOT NULL DEFAULT 'something'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `f_name`, `l_name`, `password`, `country`, `gender`, `dob`, `user_image`, `posts`, `recovery_account`) VALUES
(11, 'pullak@noemail.in', 'Pullak', 'Barik', 'd99457d4a46a259bcbcb3c2797bb720b4f3baa98', 'India', 'Male', '1999-04-10', 'print.jpg.100', 'yes', 'Gauravi');

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `delete_user` AFTER DELETE ON `user` FOR EACH ROW BEGIN
DELETE FROM posts WHERE user_id = OLD.user_id;
DELETE FROM messages WHERE user_from = OLD.user_id OR user_to = OLD.user_id;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`lid`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `lid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
