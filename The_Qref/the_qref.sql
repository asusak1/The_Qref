-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 18, 2020 at 01:51 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `the_qref`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` varchar(255) NOT NULL,
  `published_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `text`, `user_id`, `quiz_id`, `published_on`) VALUES
(26, 'Ovo je jako slab rezultat', 17, '5ec2758c4df56', '2020-05-18 13:50:34'),
(27, 'sad je malo bolji ipak', 17, '5ec2758c4df56', '2020-05-18 13:50:55');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `type` tinyint(4) NOT NULL,
  `choices` text DEFAULT NULL,
  `correct` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `text`, `type`, `choices`, `correct`) VALUES
('5ebf07db3ebe4', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ebf0828da05e', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ebf082f2e6fa', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ebf084bf2bce', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ebf087c0f0b4', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ebf092013eea', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ebf092014663', 'Kako se zove češka nacionalna valuta?', 1, 'kruna,kuna,euro,dolar', 'kruna'),
('5ebf0b8a10225', 'Koji je najmnogoljudniji otok na svijetu?', 1, 'Java,Python,Ruby,Go', 'Java'),
('5ebf0b8a10b02', 'Izaberi zicane instrumente:', 2, 'klavir,gitara,fagot,flauta', 'klavir,gitara'),
('5ebf0b8a10d53', 'Izaberi samoglasnike:', 2, 'a,e,b,o', 'a,e,o'),
('5ebf0b8a10fed', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ebf0b8a111ee', 'Kako se zove grčki bog rata?', 3, NULL, 'Ares'),
('5ebf0b8a11c6d', 'Glavni grad Hrvatske?', 3, NULL, 'Zagreb'),
('5ebf0b8a1200b', 'Tko su od navedenih sisavci?', 2, 'čovjek,papiga,plavetni kit,dupin', 'čovjek,plavetni kit,dupin'),
('5ebf0b8a12294', 'Koliko gitara u pravilu ima žica?', 1, 'četiri,pet,šest,sedam', 'šest'),
('5ebf0b8a12519', 'Koji su od navedenih hrvatski gradovi?', 2, 'Maribor,Zagreb,Vodnjan,Neum', 'Vodnjan,Zagreb'),
('5ebf0b8a12788', 'Koje od navedenih rijeka ne teku Europom?', 2, 'Po,Orinoko,Piva,Yukon', 'Orinoko,Yukon'),
('5ebf0b8a129f7', 'Kako se zove češka nacionalna valuta?', 1, 'kruna,kuna,euro,dolar', 'kruna'),
('5ebf0b8a12c5b', 'Koji rimski car je zapalio rim?', 1, 'Cezar,Augustin,Kaligula,Neron', 'Neron'),
('5ebf827bb43d6', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ebf827bb5bed', 'Kako se zove češka nacionalna valuta?', 1, 'kruna,kuna,euro,dolar', 'kruna'),
('5ebf8514daa99', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ebf8514db2db', 'Kako se zove češka nacionalna valuta?', 1, 'kruna,kuna,euro,dolar', 'kruna'),
('5ebf85a1b94ac', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ebf85a1ba0f8', 'Kako se zove češka nacionalna valuta?', 1, 'kruna,kuna,euro,dolar', 'kruna'),
('5ec26d3bc70a6', 'Glavni grad Hrvatske?', 3, NULL, 'Zagreb'),
('5ec26d3bc786d', 'Tko su od navedenih sisavci?', 2, 'čovjek,papiga,plavetni kit,dupin', 'čovjek,plavetni kit'),
('5ec26d3bc80b8', 'Koliko gitara u pravilu ima žica?', 1, 'četiri,pet,šest,sedam', 'šest'),
('5ec26d3bc8766', 'Koji su od navedenih hrvatski gradovi?', 2, 'Maribor,Zagreb,Vodnjan,Neum', 'Zagreb,Vodnjan'),
('5ec26d3bc8b4b', 'Koje od navedenih rijeka ne teku Europom?', 2, 'Po,Orinoko,Piva,Yukon', 'Orinoko,Yukon'),
('5ec26d3bc91fb', 'Kako se zove češka nacionalna valuta?', 1, 'kruna,kuna,euro,dolar', 'kruna'),
('5ec26d3bc96c8', 'Koji rimski car je zapalio rim?', 1, 'Cezar,Augustin,Kaligula,Neron', 'Neron'),
('5ec2758c4e458', 'Koji je najmnogoljudniji otok na svijetu?', 1, 'Java,Python,Ruby,Go', 'Java'),
('5ec2758c4eab0', 'Izaberi zicane instrumente:', 2, 'klavir,gitara,fagot,flauta', 'klavir,gitara'),
('5ec2758c4ee44', 'Izaberi samoglasnike:', 2, 'a,e,b,o', 'a,e,o'),
('5ec2758c4f761', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ec2758c4fc31', 'Kako se zove grčki bog rata?', 3, NULL, 'Ares'),
('5ec2758c4fef5', 'Glavni grad Hrvatske?', 3, NULL, 'Zagreb'),
('5ec2758c500fa', 'Tko su od navedenih sisavci?', 2, 'čovjek,papiga,plavetni kit,dupin', 'čovjek,plavetni kit'),
('5ec2758c503a1', 'Koliko gitara u pravilu ima žica?', 1, 'četiri,pet,šest,sedam', 'šest'),
('5ec2758c505fc', 'Koji su od navedenih hrvatski gradovi?', 2, 'Maribor,Zagreb,Vodnjan,Neum', 'Vodnjan,Zagreb'),
('5ec2758c5085f', 'Koje od navedenih rijeka ne teku Europom?', 2, 'Po,Orinoko,Piva,Yukon', 'Orinoko,Yukon'),
('5ec2758c50a73', 'Kako se zove češka nacionalna valuta?', 1, 'kruna,kuna,euro,dolar', 'kruna'),
('5ec2758c50c7a', 'Koji rimski car je zapalio rim?', 1, 'Cezar,Augustin,Kaligula,Neron', 'Neron'),
('5ec275d1166b9', 'Koja je treća najmnogoljudnija država svijeta?', 3, NULL, 'SAD'),
('5ec275d116efe', 'Kako se zove češka nacionalna valuta?', 1, 'kruna,kuna,euro,dolar', 'kruna');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` varchar(255) NOT NULL,
  `name` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `time_limit` smallint(6) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `comments_allowed` tinyint(1) NOT NULL DEFAULT 0,
  `public` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `name`, `description`, `time_limit`, `author_id`, `comments_allowed`, `public`) VALUES
('5ec2758c4df56', 'Opci kviz kulture', 'opis opceg kviza kulture', 20, 17, 1, 1),
('5ec275d11603c', 'Kviz #2', 'opis kviza', 5, 17, 1, 1),
('5ec276227e940', 'Normal Quiz', 'Dynamic quiz', 60, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question`
--

CREATE TABLE `quiz_question` (
  `id` int(11) NOT NULL,
  `quiz_id` varchar(255) NOT NULL,
  `question_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_question`
--

INSERT INTO `quiz_question` (`id`, `quiz_id`, `question_id`) VALUES
(230, '5ec2758c4df56', '5ec2758c4e458'),
(231, '5ec2758c4df56', '5ec2758c4eab0'),
(232, '5ec2758c4df56', '5ec2758c4ee44'),
(233, '5ec2758c4df56', '5ec2758c4f761'),
(234, '5ec2758c4df56', '5ec2758c4fc31'),
(235, '5ec2758c4df56', '5ec2758c4fef5'),
(236, '5ec2758c4df56', '5ec2758c500fa'),
(237, '5ec2758c4df56', '5ec2758c503a1'),
(238, '5ec2758c4df56', '5ec2758c505fc'),
(239, '5ec2758c4df56', '5ec2758c5085f'),
(240, '5ec2758c4df56', '5ec2758c50a73'),
(241, '5ec2758c4df56', '5ec2758c50c7a'),
(242, '5ec275d11603c', '5ec275d1166b9'),
(243, '5ec275d11603c', '5ec275d116efe'),
(244, '5ec276227e940', '5ec2758c4e458'),
(245, '5ec276227e940', '5ebf084bf2bce'),
(246, '5ec276227e940', '5ebf0b8a10d53'),
(247, '5ec276227e940', '5ec2758c50c7a'),
(248, '5ec276227e940', '5ebf0828da05e'),
(249, '5ec276227e940', '5ec26d3bc80b8'),
(250, '5ec276227e940', '5ebf827bb43d6'),
(251, '5ec276227e940', '5ebf85a1ba0f8'),
(252, '5ec276227e940', '5ec26d3bc91fb'),
(253, '5ec276227e940', '5ec2758c500fa'),
(254, '5ec276227e940', '5ec2758c4ee44'),
(255, '5ec276227e940', '5ebf0b8a1200b'),
(256, '5ec276227e940', '5ec26d3bc8b4b'),
(257, '5ec276227e940', '5ebf082f2e6fa'),
(258, '5ec276227e940', '5ec2758c505fc');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `id` varchar(255) NOT NULL,
  `quiz_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `score` float(10,1) NOT NULL,
  `max_score` decimal(10,1) NOT NULL,
  `points` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `is_late` tinyint(1) NOT NULL,
  `given_answers` text NOT NULL,
  `correct_answers` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`id`, `quiz_id`, `user_id`, `score`, `max_score`, `points`, `start_time`, `end_time`, `is_late`, `given_answers`, `correct_answers`) VALUES
('5ec2759d19c33', '5ec2758c4df56', 17, 3.0, '12.0', '1,1,0,0,1,0,0,0,0,0,0,0', '2020-05-18 13:46:27', '2020-05-18 13:46:37', 0, 'Java-klavir,gitara---ares-------', 'Java-klavir,gitara-a,e,o-SAD-Ares-Zagreb-čovjek,plavetni kit-šest-Vodnjan,Zagreb-Orinoko,Yukon-kruna-Neron'),
('5ec275dde210d', '5ec275d11603c', 17, 2.0, '2.0', '1,1', '2020-05-18 13:47:34', '2020-05-18 13:47:41', 0, 'SAD-kruna', 'SAD-kruna'),
('5ec2760407266', '5ec2758c4df56', 17, 6.0, '12.0', '0,0,0,0,0,1,0,1,1,1,1,1', '2020-05-18 13:47:56', '2020-05-18 13:48:20', 0, '-----zagreb--šest-Zagreb,Vodnjan-Orinoko,Yukon-kruna-Neron', 'Java-klavir,gitara-a,e,o-SAD-Ares-Zagreb-čovjek,plavetni kit-šest-Vodnjan,Zagreb-Orinoko,Yukon-kruna-Neron'),
('5ec2762860267', '5ec276227e940', 17, 1.0, '15.0', '0,0,0,1,0,0,0,0,0,0,0,0,0,0,0', '2020-05-18 13:48:50', '2020-05-18 13:48:56', 0, '---Neron-----------', 'Java-SAD-a,e,o-Neron-SAD-šest-SAD-kruna-kruna-čovjek,plavetni kit-a,e,o-čovjek,plavetni kit,dupin-Orinoko,Yukon-SAD-Vodnjan,Zagreb'),
('5ec27681070de', '5ec2758c4df56', 17, 0.0, '12.0', '0,0,0,0,0,0,0,0,0,0,0,0', '2020-05-18 13:50:22', '2020-05-18 13:50:25', 0, '----------dolar-', 'Java-klavir,gitara-a,e,o-SAD-Ares-Zagreb-čovjek,plavetni kit-šest-Vodnjan,Zagreb-Orinoko,Yukon-kruna-Neron'),
('5ec276981df9b', '5ec2758c4df56', 17, 1.0, '12.0', '0,0,0,0,0,0,0,0,0,0,1,0', '2020-05-18 13:50:44', '2020-05-18 13:50:48', 0, '----------kruna-', 'Java-klavir,gitara-a,e,o-SAD-Ares-Zagreb-čovjek,plavetni kit-šest-Vodnjan,Zagreb-Orinoko,Yukon-kruna-Neron');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `date_of_birth`, `email`, `password`) VALUES
(17, 'Ante', 'Susak', '1994-07-27', 'ante@gmail.com', '$2y$10$7MOtcTtY3A45ltZk3syjk.0SBnt584MGT0Kdh1wlHn1.RBROympYO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_user` (`user_id`),
  ADD KEY `fk_comment_quiz` (`quiz_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author_id`);

--
-- Indexes for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_quiz` (`quiz_id`),
  ADD KEY `fk_question` (`question_id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_result_quiz` (`quiz_id`),
  ADD KEY `fk_result_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `quiz_question`
--
ALTER TABLE `quiz_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `author` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD CONSTRAINT `fk_question` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `fk_result_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_result_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
