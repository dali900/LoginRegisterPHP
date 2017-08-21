-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2016 at 12:29 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `permissions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'Standard user', ''),
(2, 'Administrator', '{"admin":1}');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `name` varchar(50) NOT NULL,
  `joined` datetime NOT NULL,
  `groups` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `salt`, `name`, `joined`, `groups`) VALUES
(1, 'alex', 'alex@mail.com', 'password', 'salt', 'Alex BB', '2016-08-03 00:00:00', 1),
(2, 'dali', '', 'pass11', 'saltD', 'Dalibor', '2016-08-22 21:15:15', 1),
(3, 'Dale', 'dale@m.com', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'salt', 'Dale Barett', '0000-00-00 00:00:00', 0),
(4, 'dali90', 'dali90@mail.com', 'a8d80d737ac9ccd997964c387300e83e25fee459688911de06b5c697cae89522', '~ÒîËþ[ù²õZRms¢²+gsZ¯ÊIñq', 'Dalibor Grujic', '2016-08-25 23:18:56', 1),
(5, 'jhon', '', '5443238683c7a9a1a2bc34e495dc12e769cca3a3c08e606ef97921880c97a9f3', 'Iqrq‹=qZi61NÒÒJX¡`Jë¯@ù=VhÑ™Æ', 'John Sean', '2016-08-25 23:20:28', 1),
(6, 'user1', '', '1cf8f6e0fb5b5da9f7ff3534833f3ea541ede666de5d17e09eddb708f174ac36', '×­‚	Ìzäwý(3j£^‡‡ˆtTnñ8ÓV„œ*\ZØn¼', 'User One', '2016-08-25 23:35:22', 1),
(7, 'user2', '', '991ad01f6ed7fcfa5e52161495c219517cad44d4734007074a95cec5ce22eb2e', 'ÂâƒàdÍJ$`šqR4+3Àº¶Òwk"º^¿©Ý[', 'User dva', '2016-08-29 14:08:24', 1),
(8, '', '', '1e8fdb2748933463265ad2ed721c3dac8a1a081e309f2cc30b350d5bca3eead5', '‡0üýØµÍ»0KÓ%ñS¼Eã¸2 Ïiq¿9g8uh', '', '2016-08-29 14:56:15', 1),
(9, '', '', 'd60b53d636aa755c5622e8b16639da75c131826362d8cf7f117e378bd512937f', 'h@s>Ñ¤0‚Îªz&KÌžˆ?oø¨{Lµ¿žwD', '', '2016-08-29 14:57:14', 1),
(10, '', '', 'f2129ebeb688301a422f566913ca44d347a1baccdc1267cb05eee5ba946e992c', '7¦Æ!\nµeë‚q¿cðÌˆ}BïÔÂø³~4-aô@\n', '', '2016-08-29 14:57:57', 1),
(11, '', '', 'f821a34c29c7f4f3a3d71851d8c6c6b82ce944897a48a3b04cd7cb874242321d', 'ø–NÂ˜Oe³«îôÁMØ@ášù	sç¬Hÿµ¤Þû', '', '2016-08-29 14:58:28', 1),
(12, 'user3', '', '9ebc7a6841b5437ae509090ea3b673ce4ec753a7cccc22c4938227bc99a95543', '÷^2Üí¸DSˆ­>?±YÀÀOõïŽá„è=Ú@¯4S£', 'User Tri', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_session`
--

INSERT INTO `users_session` (`id`, `user_id`, `hash`) VALUES
(3, 12, '2911f737b9b115fabdb9d4506be327df038a2f44aa6214ed7ec0c47154b8b96d');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
