-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2019 at 08:54 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verdad`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliations`
--

CREATE TABLE `affiliations` (
  `id` int(11) NOT NULL,
  `occupation` varchar(50) NOT NULL,
  `organization_fk` int(11) NOT NULL,
  `reviewer_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `affiliations`
--

INSERT INTO `affiliations` (`id`, `occupation`, `organization_fk`, `reviewer_fk`) VALUES
(1, 'Student', 1, 1),
(3, 'Member', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `author` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `url` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `publisher_fk` int(11) NOT NULL,
  `publish_date` date DEFAULT NULL,
  `publish_time` time DEFAULT NULL,
  `submit_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avg_score` float DEFAULT NULL,
  `satire` tinyint(1) DEFAULT NULL,
  `opinion` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `author`, `url`, `publisher_fk`, `publish_date`, `publish_time`, `submit_date`, `avg_score`, `satire`, `opinion`) VALUES
(1, 'House to hold question hour for Diokno over 2019 budget', 'Mara Cepeda', 'https://www.rappler.com/nation/218551-house-question-hour-benjamin-diokno-december-11-2018', 1, '2018-12-09', '13:06:00', '2018-12-09 16:42:32', 5, 0, 0),
(2, 'Malacañang to Trillanes: Stop \'smearing\' Duterte, face libel charges', 'Rappler.com', 'https://www.rappler.com/nation/218558-malacanang-statement-antonio-trillanes-libel-charges', 1, '2018-12-09', '16:55:00', '2018-12-09 18:50:48', 5, 0, 0),
(3, 'Malaysian Prime Minister Mahathir arrives in Manila for official visit', 'Pia Ranada', 'https://www.rappler.com/nation/225056-mahathir-mohamad-arrives-manila-march-6-2019', 1, '2019-03-06', '19:47:00', '2019-03-06 23:04:33', 5, 0, 0),
(4, 'EU says talks with UK ’difficult’ as Brexit impasse drags on', 'Associated Press', 'https://newsinfo.inquirer.net/1092900/eu-says-talks-with-uk-difficult-as-brexit-impasse-drags-on?utm_expid=.XqNwTug2W6nwDVUSgFJXed.1', 2, '2019-03-06', '21:29:00', '2019-03-06 23:34:15', 5, NULL, NULL),
(5, 'Mon Tulfo refuses to apologize for calling Filipino workers \'lazy\'', 'Aika Rey', 'https://www.rappler.com/nation/225350-mon-tulfo-refuse-apologize-statement-against-filipino-workers', 1, '2019-03-09', '20:57:00', '2019-03-09 23:10:05', 5, NULL, NULL),
(6, 'Ex-PCSO chief Balutan rejects corruption allegations', 'Frances G. Mangosing', 'https://newsinfo.inquirer.net/1093867/ex-pcso-chief-balutan-rejects-corruption-allegations?utm_expid=.XqNwTug2W6nwDVUSgFJXed.1', 2, '2019-03-09', '14:34:00', '2019-03-09 23:11:12', NULL, NULL, NULL),
(7, 'Comelec hopes VRVM pilot test to go smoothly', 'Philippine News Agency', 'https://news.mb.com.ph/2019/03/09/comelec-hopes-vrvm-pilot-test-to-go-smoothly/', 3, '2019-03-09', '21:47:00', '2019-03-09 23:21:19', NULL, NULL, NULL),
(8, '‘Find alternative to sugar import liberalization’: Zubiri', 'Philippine News Agency', 'https://news.mb.com.ph/2019/03/09/find-alternative-to-sugar-import-liberalization-zubiri/', 3, '2019-03-09', '22:47:00', '2019-03-09 23:26:53', NULL, NULL, NULL),
(9, 'Go not violating poll rules: Comelec chief', 'Philippine News Agency', 'https://news.mb.com.ph/2019/03/09/go-not-violating-poll-rules-comelec-chief/', 3, '2019-03-09', '21:55:00', '2019-03-09 23:31:14', NULL, NULL, NULL),
(10, 'Senior citizens deserve to live a life of dignity', 'Mario Casayuran', 'https://news.mb.com.ph/2019/03/09/senior-citizens-deserve-to-live-a-life-of-dignity/', 3, '2019-03-09', '18:55:00', '2019-03-09 23:39:36', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `msgkey` varchar(45) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `msgkey`, `message`) VALUES
(1, 'HelloWorld', 'So apparently this is a database.'),
(2, '', 'It\'s all coming back to me now\''),
(3, 'Second  message', 'It\'s all coming back to me now\''),
(4, 'Second  message', 'It\'s all coming back to me now\''),
(5, 'Second  message', 'It\'s all coming back to me now\''),
(6, 'Second  message', 'Cool stuff'),
(7, 'Second  message', 'Cool stuff'),
(8, 'Second  message', 'Cool stuff'),
(9, 'Second  message', 'Cool stuff'),
(10, 'Second  message', 'Cool stuff'),
(11, 'Second  message', 'Cool stuff'),
(12, 'Second  message', 'Cool stuff'),
(13, 'Second  message', 'Cool stuff'),
(14, 'Second  message', 'Cool stuff'),
(15, 'Second  message', 'Cool stuff');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `org_name` varchar(50) NOT NULL,
  `org_address` text,
  `org_phone` text,
  `org_logo` text,
  `org_type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `org_name`, `org_address`, `org_phone`, `org_logo`, `org_type`) VALUES
(1, 'University of the Philippines Los Baños', 'College, Los Baños, Laguna', NULL, NULL, 'Academic'),
(2, 'UP Jammers\' Club', 'Los Baños, Laguna', NULL, NULL, 'Socio-cultural'),
(13, 'Galactic Federation', NULL, NULL, NULL, ''),
(14, 'Dr. Light', NULL, NULL, NULL, ''),
(15, 'Maverick Hunters', NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `pending_affiliations`
--

CREATE TABLE `pending_affiliations` (
  `id` int(11) NOT NULL,
  `occupation` varchar(50) NOT NULL,
  `id_img_path` varchar(1024) NOT NULL,
  `organization_fk` int(11) NOT NULL,
  `pending_reviewer_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pending_affiliations`
--

INSERT INTO `pending_affiliations` (`id`, `occupation`, `id_img_path`, `organization_fk`, `pending_reviewer_fk`) VALUES
(12, 'Bounty Hunter', 'uploads/username2/orgIDupload1.jpg', 13, 8),
(13, 'Super Fighting Robot', 'uploads/username2/orgIDupload2.jpg', 14, 8),
(14, 'Commander', 'uploads/username2/orgIDupload3.jpg', 15, 8);

-- --------------------------------------------------------

--
-- Table structure for table `pending_reviewers`
--

CREATE TABLE `pending_reviewers` (
  `id` int(11) NOT NULL,
  `profile_img_path` varchar(1024) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `phone_area` varchar(3) NOT NULL,
  `user_fk` int(11) NOT NULL,
  `approved_reviewer` tinyint(1) DEFAULT NULL,
  `approved_reviewer_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pending_reviewers`
--

INSERT INTO `pending_reviewers` (`id`, `profile_img_path`, `phone`, `phone_area`, `user_fk`, `approved_reviewer`, `approved_reviewer_fk`) VALUES
(8, 'uploads/username2/profileUpload.jpeg', '88884444', '02', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pending_users`
--

CREATE TABLE `pending_users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) NOT NULL,
  `name_suffix` varchar(5) DEFAULT NULL,
  `verification_code` varchar(6) NOT NULL,
  `approved_user` tinyint(1) NOT NULL,
  `approved_user_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pending_users`
--

INSERT INTO `pending_users` (`id`, `username`, `password`, `email`, `last_name`, `first_name`, `middle_name`, `name_suffix`, `verification_code`, `approved_user`, `approved_user_fk`) VALUES
(2, 'username2', '$2y$10$RvlazU621FgBjUp11AwEI.mLmhvyPr8SDy/d/SCCKt5K5D7XkfegG', 'jsrombawa@up.edu.ph', 'Rombawa', 'Justin Aaron', 'Santiago', '', 'X9446e', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `publish_sites`
--

CREATE TABLE `publish_sites` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `url` text,
  `avg_score` float DEFAULT NULL,
  `published_by` int(11) DEFAULT NULL COMMENT 'foreign key'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `publish_sites`
--

INSERT INTO `publish_sites` (`id`, `name`, `url`, `avg_score`, `published_by`) VALUES
(1, 'Rappler', 'https://rappler.com', NULL, NULL),
(2, 'Inquirer', 'https://newsinfo.inquirer.net', NULL, NULL),
(3, 'Manila Bulletin', 'https:news.mb.com.ph', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviewers`
--

CREATE TABLE `reviewers` (
  `id` int(11) NOT NULL,
  `profile_img_path` varchar(1024) DEFAULT NULL,
  `phone_number` varchar(15) NOT NULL,
  `phone_area` varchar(3) DEFAULT NULL,
  `user_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviewers`
--

INSERT INTO `reviewers` (`id`, `profile_img_path`, `phone_number`, `phone_area`, `user_fk`) VALUES
(1, 'uploads/username1/profile.jpg', '09677062985', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `article_fk` int(11) NOT NULL,
  `reviewer_fk` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `comments` text NOT NULL,
  `satire_flag` tinyint(1) NOT NULL,
  `opinion_flag` tinyint(1) NOT NULL,
  `erroneous_flag` tinyint(1) NOT NULL,
  `report_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `article_fk`, `reviewer_fk`, `score`, `comments`, `satire_flag`, `opinion_flag`, `erroneous_flag`, `report_fk`) VALUES
(1, 1, 1, 5, 'Similarly reported by GMA News[1] on the same day and almost the same time.\r\n\r\nhttps://www.gmanetwork.com/news/news/nation/677571/house-summons-diokno-to-a-question-hour-on-2019-budget/story/', 0, 0, 0, 0),
(2, 5, 1, 5, 'Mr. Tulfo\'s tweet is still shown in his Twitter account. https://twitter.com/RamonTulfoII/status/1104232510886535168?ref_src=twsrc%5Etfw', 0, 0, 0, NULL),
(3, 4, 1, 5, 'Original report by the Associated Press can be seen here: https://apnews.com/01725bac555d49758e563f2b317816d9', 0, 0, 0, NULL),
(8, 2, 1, 5, 'Similary reported by The Manila Bulletin. https://news.mb.com.ph/2018/12/09/palace-to-trillanes-face-libel-charges/', 0, 0, 0, NULL),
(9, 3, 1, 5, 'Prime Minister Mahathir did arrive on March 6, 2019. https://news.abs-cbn.com/news/03/06/19/malaysian-pm-mahathir-arrives-in-ph', 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(5) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `username`, `password`) VALUES
(1, 'username', '$2y$10$RvlazU621FgBjUp11AwEI.mLmhvyPr8SDy/d/SCCKt5K5D7XkfegG');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) NOT NULL,
  `name_suffix` varchar(5) DEFAULT NULL,
  `reviewer_status` tinyint(1) NOT NULL,
  `reviewer_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `last_name`, `first_name`, `middle_name`, `name_suffix`, `reviewer_status`, `reviewer_fk`) VALUES
(1, 'username1', '$2y$10$RvlazU621FgBjUp11AwEI.mLmhvyPr8SDy/d/SCCKt5K5D7XkfegG', 'jusrombawa@gmail.com', 'Rombawa', 'Justin Aaron', 'Santiago', '', 1, NULL),
(5, 'username2', '$2y$10$RvlazU621FgBjUp11AwEI.mLmhvyPr8SDy/d/SCCKt5K5D7XkfegG', 'jsrombawa@up.edu.ph', 'Rombawa', 'Justin Aaron', 'Santiago', 'Jr.', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliations`
--
ALTER TABLE `affiliations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_affiliations`
--
ALTER TABLE `pending_affiliations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_reviewers`
--
ALTER TABLE `pending_reviewers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_users`
--
ALTER TABLE `pending_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publish_sites`
--
ALTER TABLE `publish_sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviewers`
--
ALTER TABLE `reviewers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliations`
--
ALTER TABLE `affiliations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pending_affiliations`
--
ALTER TABLE `pending_affiliations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pending_reviewers`
--
ALTER TABLE `pending_reviewers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pending_users`
--
ALTER TABLE `pending_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `publish_sites`
--
ALTER TABLE `publish_sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviewers`
--
ALTER TABLE `reviewers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
