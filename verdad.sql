-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2019 at 06:23 AM
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
  `body` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `reviews_fk` int(40) DEFAULT NULL,
  `avg_score` float DEFAULT NULL,
  `satire` tinyint(1) NOT NULL,
  `opinion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `author`, `url`, `publisher_fk`, `publish_date`, `publish_time`, `submit_date`, `body`, `reviews_fk`, `avg_score`, `satire`, `opinion`) VALUES
(1, 'House to hold question hour for Diokno over 2019 budget', 'Mara Cepeda', 'https://www.rappler.com/nation/218551-house-question-hour-benjamin-diokno-december-11-2018', 1, '2018-12-09', '13:06:00', '2018-12-09 16:42:32', '(UPDATED) The question hour comes after Senator Panfilo Lacson accused the House of passing a national budget riddled with alleged pork barrel funds \r\n\r\nMANILA, Philippines (UPDATED) – The House of Representatives is set to subject Budget Secretary Benjamin Diokno to a question hour at 3 pm on Tuesday, December 11.\r\n\r\nLawmakers summoned Diokno to a question hour – a period during the plenary session wherein legislators can ask questions to a department head regarding all matters concerning his agency – after the plenary adopted Minority Leader Danilo Suarez’s House Resolution (HR) 2307 on December 4.\r\n\r\nSuarez and other minority lawmakers have previously aired concerns over the proposed P3.757-trillion budget for 2019, which the House had approved on 3rd and final reading.\r\n\r\nThe congressmen are wary that the 2019 budget may be used by politicians to campaign in the 2019 elections. They also slammed the underspending under President Rodrigo Duterte’s administration.\r\n\r\nMajority Leader Rolando Andaya Jr already wrote a letter to Diokno informing him that he is “hereby required to appear” at the Batasang Pambansa’s session hall on Tuesday.\r\n\r\nDiokno confirmed to Rappler that he would attend the question hour on Tuesday.\r\n\r\nSenator Panfilo Lacson recently accused the House of passing a 2019 budget riddled with pork barrel funds. He disclosed that P2.4 billion was allocated for Pampanga’s 2nd District alone, which is represented by Speaker Gloria Macapagal Arroyo.\r\n\r\nAndaya himself previously admitted that every lawmaker got P60 million and each senator P200 million to allot for their pet projects. But he and other minority lawmakers denied these discretionary funds were a form of Priority Development Assistance Fund, which the Supreme Court declared unconstitutional in 2013.\r\n\r\nDiokno himself had denied the presence of pork barrel funds in the 2019 budget that the Department of Budget and Management helped prepare.\r\n\r\nAndaya also said that the House got delayed in passing the proposed 2019 budget as several departments in the executive branch were still requesting more reallocations, which will be finalized only at the bicameral conference committee level with the Senate.\r\n\r\nThe goverment is already expected to operate on a reenacted budget until February 2019, given the limited time senators have to deliberate on the 2019 budget before the 17th Congress suspends session for the holidays by Wednesday, December 12. – With a report from Aika Rey/Rappler.com', NULL, NULL, 0, 0),
(2, 'Malacañang to Trillanes: Stop \'smearing\' Duterte, face libel charges', 'Rappler.com', 'https://www.rappler.com/nation/218558-malacanang-statement-antonio-trillanes-libel-charges', 1, '2018-12-09', '16:55:00', '2018-12-09 18:50:48', 'Presidential Spokesperson Salvador Panelo calls Senator Antonio Trillanes IV a \'perennial whiner\' for saying that plunderers are being set free while critics are being jailed\r\n\r\nMANILA, Philippines – Malacañang on Sunday, December 9, slammed Senator Antonio Trillanes IV, calling him \"out of his wits\" after he condemned the arrest warrants issued against him by a Davao City court.\r\n\r\nIn a statement, Presidential Spokesperson Salvador Panelo called out Trillanes for \"attacking\" President Rodrigo Duterte before the media instead of focusing on the libel complaints filed by the President\'s son Paolo Duterte and son-in-law Manases Carpio.\r\n\r\n\"His latest remarks prove once and for all that he is an incorrigible [rabble]-rouser and perennial whiner, a false accuser who, when hailed to court, cries like a baby reminiscent of staging a coup and surrenders instantly even without a gun being fired from the government forces,\" Panelo said.\r\n\r\nJudge Melinda Alconcel Dayanghirang of Davao City Regional Trial Court Branch 54 had issued 4 arrest warrants against Trillanes, one for each libel complaint.\r\n\r\nTrillanes, on Friday, December 7, denounced what he called \"topsy-turvy\" justice under the Duterte administration, citing the acquittal of former senator Ramon \"Bong\" Revilla Jr in relation to the pork barrel scam. He said plunderers are being set free, while critics are being jailed.\r\n\r\nPanelo said the President\'s fiercest critic should focus on legal remedies instead of \"employing squid tactics and smearing the administration.\"\r\n\r\nPlan to pos\r\n\r\nt bail\r\n\r\nNational Capital Region Police Office Director Guillermo Eleazar confirmed that his office now has copies of the arrest warrants for Trillanes.\r\n\r\nBut he added that they are coordinating with the Senate regarding Trillanes\' plan to post bail on Monday, December 10.\r\n\r\n\"If the senator wishes to turn himself [in] to us, then we will get him from the Senate,\" Eleazar said on Sunday.\r\n\r\nBack in September, Trillanes was arrested for rebellion over the 2003 Oakwood mutiny and the 2007 Manila Peninsula siege, after a Duterte proclamation sought to void his amnesty. The senator, a former soldier, posted bail of P200,000. (READ: INSIDE STORY: How Duterte handled Trillanes fiasco from Israel, Jordan)\r\n\r\nTrillanes is the second opposition senator to be arrested following Senator Leila de Lima, another critic of Duterte, who was jailed over drug charges in February 2017. – Rappler.com', NULL, NULL, 0, 0);

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
(14, 'Second  message', 'Cool stuff');

-- --------------------------------------------------------

--
-- Table structure for table `publish_sites`
--

CREATE TABLE `publish_sites` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `url` text NOT NULL,
  `avg_score` float DEFAULT NULL,
  `published_by` int(11) DEFAULT NULL COMMENT 'foreign key'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `publish_sites`
--

INSERT INTO `publish_sites` (`id`, `name`, `url`, `avg_score`, `published_by`) VALUES
(1, 'Rappler', 'https://rappler.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `article_fk` int(11) NOT NULL,
  `reviewer_fk` int(11) NOT NULL,
  `score` float NOT NULL,
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
(1, 1, 1, 5, 'Similarly reported by GMA News[1] on the same day and almost the same time.\r\n\r\nhttps://www.gmanetwork.com/news/news/nation/677571/house-summons-diokno-to-a-question-hour-on-2019-budget/story/', 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `publish_sites`
--
ALTER TABLE `publish_sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_fk` (`article_fk`),
  ADD UNIQUE KEY `reviewer_fk` (`reviewer_fk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `publish_sites`
--
ALTER TABLE `publish_sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
