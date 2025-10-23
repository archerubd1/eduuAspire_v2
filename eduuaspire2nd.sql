-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 22, 2025 at 04:08 AM
-- Server version: 5.6.20-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eduuaspire`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminuser`
--

CREATE TABLE IF NOT EXISTS `adminuser` (
`id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('active','inactive','blocked') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `adminuser`
--

INSERT INTO `adminuser` (`id`, `username`, `email`, `password_hash`, `full_name`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.com', '0e7517141fb53f21ee439b355b5a1d0a', 'System Administrator', 'admin', 'active', '2025-09-07 04:32:41', '2025-09-07 04:53:25');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
`id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `topic_title` varchar(255) NOT NULL,
  `topic_description` text,
  `topic_order` int(11) DEFAULT '0',
  `created` int(11) DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `module_id`, `topic_title`, `topic_description`, `topic_order`, `created`) VALUES
(1, 1, 'fdfdsfsdsdf', '', 1, 1761059540),
(2, 1, 'fdsfsdfsdfsdd', '', 2, 1761059540),
(3, 1, 'fdsfsdfdfd', '', 3, 1761059540),
(4, 2, 'dsdds', '', 1, 1761059540),
(5, 2, 'dsadsasa', '', 2, 1761059540),
(6, 2, 'dsadasdas', '', 3, 1761059540);

-- --------------------------------------------------------

--
-- Table structure for table `course_marketplace`
--

CREATE TABLE IF NOT EXISTS `course_marketplace` (
`id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `badge` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `course_marketplace`
--

INSERT INTO `course_marketplace` (`id`, `lesson_id`, `subtitle`, `price`, `discount_price`, `badge`, `image`, `is_active`) VALUES
(1, 1, 'Let''s make Maths your best subject this year!', '12500.00', '5000.00', 'Popular', 'uploads/courses/1761059539_m1.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_metadata`
--

CREATE TABLE IF NOT EXISTS `course_metadata` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci,
  `modules` text COLLATE utf8mb4_unicode_ci,
  `skills` text COLLATE utf8mb4_unicode_ci,
  `objectives` text COLLATE utf8mb4_unicode_ci,
  `audience` text COLLATE utf8mb4_unicode_ci,
  `brochure_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brochure_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `course_metadata`
--

INSERT INTO `course_metadata` (`id`, `course_id`, `overview`, `modules`, `skills`, `objectives`, `audience`, `brochure_path`, `brochure_type`) VALUES
(1, 1, 'dggdgfdgff', 'gfgfdg', 'gfgfgfdgdfgfd', 'fgfdgdfgfdg', 'gfgfdgdfgdfgdfgdfg', 'uploads/brochures/1761059540_eduuAspire_cbse_xth_maths.pdf', 'pdf');

-- --------------------------------------------------------

--
-- Table structure for table `course_reviews`
--

CREATE TABLE IF NOT EXISTS `course_reviews` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `review_text` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_schedule`
--

CREATE TABLE IF NOT EXISTS `course_schedule` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `batch_name` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `session_time` varchar(50) DEFAULT NULL,
  `max_students` int(11) DEFAULT '0',
  `instructor_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_tags`
--

CREATE TABLE IF NOT EXISTS `course_tags` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `directions`
--

CREATE TABLE IF NOT EXISTS `directions` (
`id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_direction_ID` int(11) DEFAULT NULL,
  `direction_type` enum('Board','Stream','Subject','Level','Category','Subcategory','Program') COLLATE utf8mb4_unicode_ci DEFAULT 'Category',
  `academic_level` enum('K12','PUC','UG','PG','Professional','Skill') COLLATE utf8mb4_unicode_ci DEFAULT 'K12',
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(1) DEFAULT '0',
  `display_order` int(11) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `directions`
--

INSERT INTO `directions` (`id`, `name`, `direction_code`, `parent_direction_ID`, `direction_type`, `academic_level`, `description`, `icon`, `featured`, `display_order`, `active`) VALUES
(1, 'Academia', NULL, NULL, 'Category', 'K12', 'B2C Marketplace Courses for K12, UG, and PG.', NULL, 0, 0, 1),
(2, 'K12', NULL, 1, 'Category', 'K12', 'For Schools Goa Board, CBSE, ICSE, IB', NULL, 0, 0, 1),
(4, 'CBSE', NULL, 2, 'Category', 'K12', 'CBSE Board ', NULL, 0, 0, 1),
(5, 'ICSE', NULL, 2, 'Category', 'K12', 'ICSE Board ', NULL, 0, 0, 1),
(6, 'Goa Board', NULL, 2, 'Category', 'K12', 'Goa Board', NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `direction_hierarchy`
--
CREATE TABLE IF NOT EXISTS `direction_hierarchy` (
`id` int(11)
,`name` varchar(255)
,`direction_type` enum('Board','Stream','Subject','Level','Category','Subcategory','Program')
,`academic_level` enum('K12','PUC','UG','PG','Professional','Skill')
,`parent_direction_ID` int(11)
,`parent_name` varchar(255)
,`parent_type` enum('Board','Stream','Subject','Level','Category','Subcategory','Program')
);
-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE IF NOT EXISTS `enrollments` (
`id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `progress` float DEFAULT '0',
  `status` enum('active','completed','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'active'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `institution_courses`
--

CREATE TABLE IF NOT EXISTS `institution_courses` (
`id` int(11) NOT NULL,
  `institution_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE IF NOT EXISTS `instructors` (
`id` int(11) NOT NULL,
  `user_login` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'assets/img/person/default-avatar.webp',
  `specialty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` float DEFAULT '4.5',
  `total_reviews` int(11) DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `user_login`, `avatar`, `specialty`, `rating`, `total_reviews`) VALUES
(2, 'archerubd1', 'uploads/instructors/1760958094_fp7.jpg', 'Maths & Science', 4.5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `learners`
--

CREATE TABLE IF NOT EXISTS `learners` (
`id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'assets/img/person/default-avatar.webp',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE IF NOT EXISTS `lessons` (
`id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) DEFAULT '0',
  `learners` int(11) DEFAULT '0',
  `rating` decimal(2,1) DEFAULT '4.5',
  `reviews` int(11) DEFAULT '0',
  `price` decimal(10,2) DEFAULT '0.00',
  `course_type` enum('Free','Paid','Subscription') COLLATE utf8mb4_unicode_ci DEFAULT 'Paid',
  `directions_ID` int(11) DEFAULT NULL,
  `direction_id` int(11) DEFAULT NULL,
  `sub_direction_id` int(11) DEFAULT NULL,
  `academic_level` enum('K12','PUC','UG','PG','Professional','Skill') COLLATE utf8mb4_unicode_ci DEFAULT 'K12',
  `board` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_LOGIN` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `institution_id` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `show_catalog` tinyint(1) DEFAULT '1',
  `publish` tinyint(1) DEFAULT '1',
  `created` int(11) NOT NULL DEFAULT '0',
  `course_mode` enum('SPL','ILT','Hybrid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SPL',
  `delivery_type` enum('Online','Offline','Hybrid') COLLATE utf8mb4_unicode_ci DEFAULT 'Online',
  `assessment_type` enum('Practice Tests','Monthly Assessments','Board Prep Series','Exams','Project') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `name`, `course_code`, `info`, `duration`, `learners`, `rating`, `reviews`, `price`, `course_type`, `directions_ID`, `direction_id`, `sub_direction_id`, `academic_level`, `board`, `creator_LOGIN`, `instructor_id`, `institution_id`, `active`, `show_catalog`, `publish`, `created`, `course_mode`, `delivery_type`, `assessment_type`) VALUES
(1, 'Mathematics for X CBSE', NULL, 'Struggling to decide where to start your Class 10 Maths prep? The answer is in its syllabus. From challenging Trigonometry to crunching Statistics, the CBSE Class 10 Maths syllabus can seem dauntingâ€”until you divide it wisely.', 12, 0, '4.5', 0, '12500.00', 'Paid', 2, NULL, NULL, 'K12', NULL, 'archerubd1', NULL, NULL, 1, 1, 1, 1761059540, 'Hybrid', 'Online', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `module_title` varchar(255) NOT NULL,
  `module_description` text,
  `module_order` int(11) DEFAULT '0',
  `created` int(11) DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `course_id`, `module_title`, `module_description`, `module_order`, `created`) VALUES
(1, 1, 'Chapter 1 Real Numbers', 'fdfdfsdfsdfsd', 1, 1761059540),
(2, 1, 'Chapter 2 Integreas', 'dsdsddasdsd', 2, 1761059540);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
`id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `plan_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `duration_days` int(11) DEFAULT NULL,
  `status` enum('active','expired','cancelled') DEFAULT 'active',
  `started_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `login` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `user_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `timestamp` int(11) DEFAULT '0'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `surname`, `email`, `comments`, `user_type`, `avatar`, `active`, `timestamp`) VALUES
(1, '', '5395a2c08cbcf00f6d5676911d63bf91', '', '', '', '', 'instructor', 'assets/img/person/default-avatar.webp', 1, 1760941188),
(3, 'archerubd1', '200fc19fb7550bde018d370170141d2f', 'uday', 'D', 'testuser@example.com', '7411275974', 'instructor', 'uploads/instructors/1760958094_fp7.jpg', 1, 1760958095);

-- --------------------------------------------------------

--
-- Table structure for table `users_to_lessons`
--

CREATE TABLE IF NOT EXISTS `users_to_lessons` (
`id` int(11) NOT NULL,
  `users_LOGIN` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lessons_ID` int(11) NOT NULL,
  `user_type` enum('student','instructor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `progress` float DEFAULT '0',
  `enrolled_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure for view `direction_hierarchy`
--
DROP TABLE IF EXISTS `direction_hierarchy`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `direction_hierarchy` AS select `d1`.`id` AS `id`,`d1`.`name` AS `name`,`d1`.`direction_type` AS `direction_type`,`d1`.`academic_level` AS `academic_level`,`d1`.`parent_direction_ID` AS `parent_direction_ID`,`p`.`name` AS `parent_name`,`p`.`direction_type` AS `parent_type` from (`directions` `d1` left join `directions` `p` on((`d1`.`parent_direction_ID` = `p`.`id`)));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminuser`
--
ALTER TABLE `adminuser`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_marketplace`
--
ALTER TABLE `course_marketplace`
 ADD PRIMARY KEY (`id`), ADD KEY `idx_marketplace_lesson` (`lesson_id`);

--
-- Indexes for table `course_metadata`
--
ALTER TABLE `course_metadata`
 ADD PRIMARY KEY (`id`), ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_reviews`
--
ALTER TABLE `course_reviews`
 ADD PRIMARY KEY (`id`), ADD KEY `course_id` (`course_id`), ADD KEY `learner_id` (`learner_id`);

--
-- Indexes for table `course_schedule`
--
ALTER TABLE `course_schedule`
 ADD PRIMARY KEY (`id`), ADD KEY `course_id` (`course_id`), ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `course_tags`
--
ALTER TABLE `course_tags`
 ADD PRIMARY KEY (`id`), ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `directions`
--
ALTER TABLE `directions`
 ADD PRIMARY KEY (`id`), ADD KEY `idx_directions_parent` (`parent_direction_ID`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
 ADD PRIMARY KEY (`id`), ADD KEY `learner_id` (`learner_id`), ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `institution_courses`
--
ALTER TABLE `institution_courses`
 ADD PRIMARY KEY (`id`), ADD KEY `institution_id` (`institution_id`), ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user_login` (`user_login`);

--
-- Indexes for table `learners`
--
ALTER TABLE `learners`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
 ADD PRIMARY KEY (`id`), ADD KEY `creator_LOGIN` (`creator_LOGIN`), ADD KEY `idx_lessons_direction` (`directions_ID`), ADD KEY `fk_lessons_direction` (`direction_id`), ADD KEY `fk_lessons_subdirection` (`sub_direction_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
 ADD PRIMARY KEY (`id`), ADD KEY `learner_id` (`learner_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `login` (`login`);

--
-- Indexes for table `users_to_lessons`
--
ALTER TABLE `users_to_lessons`
 ADD PRIMARY KEY (`id`), ADD KEY `idx_user` (`users_LOGIN`), ADD KEY `idx_lesson` (`lessons_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminuser`
--
ALTER TABLE `adminuser`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `course_marketplace`
--
ALTER TABLE `course_marketplace`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `course_metadata`
--
ALTER TABLE `course_metadata`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `course_reviews`
--
ALTER TABLE `course_reviews`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_schedule`
--
ALTER TABLE `course_schedule`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_tags`
--
ALTER TABLE `course_tags`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `directions`
--
ALTER TABLE `directions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `institution_courses`
--
ALTER TABLE `institution_courses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `learners`
--
ALTER TABLE `learners`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users_to_lessons`
--
ALTER TABLE `users_to_lessons`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
