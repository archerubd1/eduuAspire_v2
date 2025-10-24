-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 24, 2025 at 02:51 PM
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_analytics`
--

CREATE TABLE IF NOT EXISTS `course_analytics` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `total_views` int(11) DEFAULT '0',
  `total_enrollments` int(11) DEFAULT '0',
  `completion_rate` decimal(5,2) DEFAULT '0.00',
  `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_enrichment`
--

CREATE TABLE IF NOT EXISTS `course_enrichment` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `highlights` text COLLATE utf8mb4_unicode_ci,
  `faqs` text COLLATE utf8mb4_unicode_ci,
  `related_courses` text COLLATE utf8mb4_unicode_ci,
  `outcomes` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

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
  `rating_avg` decimal(2,1) DEFAULT '4.5',
  `total_reviews` int(11) DEFAULT '0',
  `enrollments_count` int(11) DEFAULT '0',
  `badge` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` enum('No','Yes') COLLATE utf8mb4_unicode_ci DEFAULT 'No',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_media`
--

CREATE TABLE IF NOT EXISTS `course_media` (
`id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `media_type` enum('video','image','pdf','link') COLLATE utf8mb4_unicode_ci DEFAULT 'image',
  `media_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

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
  `name` varchar(255) NOT NULL,
  `direction_type` enum('Category','Subcategory') DEFAULT 'Category',
  `academic_level` varchar(50) DEFAULT 'K12',
  `parent_direction_ID` int(11) DEFAULT NULL,
  `description` text,
  `featured` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `directions`
--

INSERT INTO `directions` (`id`, `name`, `direction_type`, `academic_level`, `parent_direction_ID`, `description`, `featured`, `active`, `created_at`) VALUES
(1, 'Academic', 'Category', 'K12', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(2, 'K12', 'Subcategory', 'K12', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(3, 'PUC', 'Subcategory', 'PUC', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(4, 'UG', 'Subcategory', 'UG', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(5, 'PG', 'Subcategory', 'PG', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(6, 'Corporate Learning', 'Category', 'Corporate', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(7, 'Onboarding', 'Subcategory', 'Corporate', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(8, 'Professional Skills', 'Subcategory', 'Corporate', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(9, 'Compliance & Policies', 'Subcategory', 'Corporate', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(10, 'Leadership & Management', 'Subcategory', 'Corporate', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(11, 'Technology', 'Category', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(12, 'Software Development', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(13, 'AI & Data Science', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(14, 'Cybersecurity', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(15, 'Business & Finance', 'Category', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(16, 'Entrepreneurship', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(17, 'Marketing', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(18, 'Finance & Accounting', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(19, 'Arts & Creativity', 'Category', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(20, 'Visual Arts', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(21, 'Creative Writing', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(22, 'Languages', 'Category', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(23, 'English', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(24, 'Hindi', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(25, 'Konkani', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(26, 'Goa Specific', 'Category', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(27, 'Goa Tourism & Culture', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35'),
(28, 'Goa History & Heritage', 'Subcategory', 'Skill', NULL, NULL, 0, 1, '2025-10-23 15:35:35');

-- --------------------------------------------------------

--
-- Stand-in structure for view `direction_hierarchy`
--
CREATE TABLE IF NOT EXISTS `direction_hierarchy` (
`id` int(11)
,`name` varchar(255)
,`direction_type` enum('Category','Subcategory')
,`academic_level` varchar(50)
,`parent_direction_ID` int(11)
,`parent_name` varchar(255)
,`parent_type` enum('Category','Subcategory')
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
-- Table structure for table `institutions`
--

CREATE TABLE IF NOT EXISTS `institutions` (
`id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('School','College','Coaching','University','Training Center') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `board_affiliation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
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
  `user_login` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'assets/img/person/default-avatar.webp',
  `specialty` varchar(255) DEFAULT NULL,
  `rating` float DEFAULT '4.5',
  `total_reviews` int(11) DEFAULT '0',
  `total_students` int(11) DEFAULT '0',
  `active_courses` int(11) DEFAULT '0',
  `verified` tinyint(1) DEFAULT '0',
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `user_login`, `first_name`, `last_name`, `avatar`, `specialty`, `rating`, `total_reviews`, `total_students`, `active_courses`, `verified`, `status`, `last_login`, `created_at`, `updated_at`, `email`, `mobile`) VALUES
(1, 'professor', 'uday', 'deshpande', 'uploads/instructors/avatar_68fb83892559f0.65327740.png', 'fds', 4.5, 0, 0, 0, 1, 'active', NULL, '2025-10-24 13:47:54', '2025-10-24 13:47:54', 'archerubd@gmail.com', '+917411275974');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_profiles`
--

CREATE TABLE IF NOT EXISTS `instructor_profiles` (
`id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_years` int(11) DEFAULT '0',
  `languages_known` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `achievements` text COLLATE utf8mb4_unicode_ci,
  `linkedin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_hours` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `instructor_profiles`
--

INSERT INTO `instructor_profiles` (`id`, `instructor_id`, `qualification`, `experience_years`, `languages_known`, `achievements`, `linkedin_url`, `facebook_url`, `youtube_url`, `bio`, `location`, `office_hours`, `website`) VALUES
(1, 1, '43242343232', 4, 'erw', 'rewrewrewrewre', 'https://dsadssdsdsds', 'https://ddfdfdfdfdf', 'https://fdfdfdfdsfd', 'rerewrewrew', 'Conclave', 'eefddhttps://', 'https://dsadssdsdsds');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_reviews`
--

CREATE TABLE IF NOT EXISTS `instructor_reviews` (
`id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `reviewer_name` varchar(150) NOT NULL,
  `reviewer_role` varchar(150) DEFAULT NULL,
  `rating` decimal(2,1) NOT NULL DEFAULT '5.0',
  `review_text` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

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
  `name` varchar(255) NOT NULL,
  `course_code` varchar(50) DEFAULT NULL,
  `info` text NOT NULL,
  `duration` int(11) DEFAULT '0',
  `learners` int(11) DEFAULT '0',
  `rating` decimal(2,1) DEFAULT '4.5',
  `reviews` int(11) DEFAULT '0',
  `price` decimal(10,2) DEFAULT '0.00',
  `course_type` enum('Free','Paid','Subscription') DEFAULT 'Paid',
  `direction_id` int(11) DEFAULT NULL,
  `sub_direction_id` int(11) DEFAULT NULL,
  `board` varchar(50) DEFAULT NULL,
  `creator_LOGIN` varchar(100) DEFAULT 'admin',
  `active` tinyint(1) DEFAULT '1',
  `show_catalog` tinyint(1) DEFAULT '1',
  `publish` tinyint(1) DEFAULT '1',
  `created` int(11) DEFAULT '0',
  `course_mode` enum('SPL','ILT','Hybrid') DEFAULT 'SPL',
  `delivery_type` enum('Online','Offline','Hybrid') DEFAULT 'Online',
  `assessment_type` enum('Practice Tests','Monthly Assessments','Board Prep Series','Exams','Project','Practical','Online Quiz') DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `name`, `course_code`, `info`, `duration`, `learners`, `rating`, `reviews`, `price`, `course_type`, `direction_id`, `sub_direction_id`, `board`, `creator_LOGIN`, `active`, `show_catalog`, `publish`, `created`, `course_mode`, `delivery_type`, `assessment_type`) VALUES
(1, 'CBSE Mathematics - Class V', NULL, 'Concepts of Numbers, Fractions, Geometry for CBSE 5th Grade', 0, 120, '4.7', 45, '0.00', 'Paid', 1, 2, 'CBSE', 'admin', 1, 1, 1, 1761233735, 'SPL', 'Online', 'Practice Tests'),
(2, 'ICSE English - Class VII', NULL, 'Literature, Grammar & Vocabulary for ICSE Students', 0, 180, '4.6', 50, '0.00', 'Paid', 1, 2, 'ICSE', 'admin', 1, 1, 1, 1761233735, 'Hybrid', 'Online', 'Board Prep Series'),
(3, 'Goa Board Science - Class X', NULL, 'Board-focused practical science program', 0, 200, '4.9', 65, '0.00', 'Paid', 1, 2, 'Goa Board', 'admin', 1, 1, 1, 1761233735, 'ILT', 'Online', 'Practical'),
(4, 'PUC Commerce - Accountancy', NULL, 'Comprehensive Accounting course for 1st Year Commerce', 0, 100, '4.6', 55, '0.00', 'Paid', 1, 3, 'PUC', 'admin', 1, 1, 1, 1761233735, 'SPL', 'Online', 'Monthly Assessments'),
(5, 'PUC Science - Physics', NULL, 'Applied physics concepts for 2nd Year Science students', 0, 130, '4.7', 48, '0.00', 'Paid', 1, 3, 'PUC', 'admin', 1, 1, 1, 1761233735, 'Hybrid', 'Online', 'Practical'),
(6, 'BCA - C Programming', NULL, 'Intro to structured programming in C', 0, 180, '4.7', 70, '0.00', 'Paid', 1, 4, 'UG', 'admin', 1, 1, 1, 1761233735, 'SPL', 'Online', 'Project'),
(7, 'BBA - Business Law', NULL, 'Business legal framework and case studies', 0, 160, '4.7', 64, '0.00', 'Paid', 1, 4, 'UG', 'admin', 1, 1, 1, 1761233735, 'ILT', 'Online', 'Online Quiz'),
(8, 'Front Office Onboarding', NULL, 'Hospitality onboarding for new hires', 0, 150, '4.8', 52, '0.00', 'Paid', 6, 7, 'Hospitality', 'admin', 1, 1, 1, 1761233735, 'ILT', 'Online', 'Practical'),
(9, 'Workplace Compliance 101', NULL, 'Corporate compliance & HR policies awareness', 0, 220, '4.6', 80, '0.00', 'Paid', 6, 9, 'Industrial', 'admin', 1, 1, 1, 1761233735, 'SPL', 'Online', 'Online Quiz'),
(10, 'Leadership Development', NULL, 'Managerial communication & growth mindset', 0, 250, '4.9', 92, '0.00', 'Paid', 6, 10, 'Corporate', 'admin', 1, 1, 1, 1761233735, 'Hybrid', 'Online', 'Project'),
(11, 'Python Programming', NULL, 'Learn Python basics & data handling', 0, 300, '4.8', 120, '0.00', 'Paid', 11, 12, 'Technology', 'admin', 1, 1, 1, 1761233735, 'SPL', 'Online', 'Project'),
(12, 'AI Fundamentals', NULL, 'Intro to AI & ML for beginners', 0, 270, '4.9', 110, '0.00', 'Paid', 11, 13, 'Technology', 'admin', 1, 1, 1, 1761233735, 'Hybrid', 'Online', 'Project');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

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
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
`id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT '0.00',
  `payment_status` enum('Pending','Completed','Failed','Refunded') COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `payment_method` enum('Online','COD','UPI','CreditCard','Wallet') COLLATE utf8mb4_unicode_ci DEFAULT 'Online',
  `transaction_ref` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `surname`, `email`, `comments`, `user_type`, `avatar`, `active`, `timestamp`) VALUES
(1, '', '5395a2c08cbcf00f6d5676911d63bf91', '', '', '', '', 'instructor', 'assets/img/person/default-avatar.webp', 1, 1760941188),
(3, 'archerubd1', '200fc19fb7550bde018d370170141d2f', 'uday', 'D', 'testuser@example.com', '7411275974', 'instructor', 'uploads/instructors/1760958094_fp7.jpg', 1, 1760958095),
(4, 'fgfgfdgf', '85dc8b61c4e4d6c40bea9c392e93904e', 'gfgfg', 'gfdgfdgf', 'future@astralminds.in', '+917411275974', 'instructor', 'uploads/instructors/1761301450_avatar-male.png', 1, 1761301450);

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
-- Table structure for table `wishlist`
--

CREATE TABLE IF NOT EXISTS `wishlist` (
`id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
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
-- Indexes for table `course_analytics`
--
ALTER TABLE `course_analytics`
 ADD PRIMARY KEY (`id`), ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_enrichment`
--
ALTER TABLE `course_enrichment`
 ADD PRIMARY KEY (`id`), ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_marketplace`
--
ALTER TABLE `course_marketplace`
 ADD PRIMARY KEY (`id`), ADD KEY `idx_marketplace_lesson` (`lesson_id`);

--
-- Indexes for table `course_media`
--
ALTER TABLE `course_media`
 ADD PRIMARY KEY (`id`), ADD KEY `course_id` (`course_id`);

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
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
 ADD PRIMARY KEY (`id`), ADD KEY `learner_id` (`learner_id`), ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `institutions`
--
ALTER TABLE `institutions`
 ADD PRIMARY KEY (`id`);

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
-- Indexes for table `instructor_profiles`
--
ALTER TABLE `instructor_profiles`
 ADD PRIMARY KEY (`id`), ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `instructor_reviews`
--
ALTER TABLE `instructor_reviews`
 ADD PRIMARY KEY (`id`), ADD KEY `idx_instructor` (`instructor_id`);

--
-- Indexes for table `learners`
--
ALTER TABLE `learners`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
 ADD PRIMARY KEY (`id`);

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
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
 ADD PRIMARY KEY (`id`), ADD KEY `learner_id` (`learner_id`), ADD KEY `course_id` (`course_id`);

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
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
 ADD PRIMARY KEY (`id`), ADD KEY `learner_id` (`learner_id`), ADD KEY `course_id` (`course_id`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_analytics`
--
ALTER TABLE `course_analytics`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_enrichment`
--
ALTER TABLE `course_enrichment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_marketplace`
--
ALTER TABLE `course_marketplace`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_media`
--
ALTER TABLE `course_media`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_metadata`
--
ALTER TABLE `course_metadata`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `institutions`
--
ALTER TABLE `institutions`
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `instructor_profiles`
--
ALTER TABLE `instructor_profiles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `instructor_reviews`
--
ALTER TABLE `instructor_reviews`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `learners`
--
ALTER TABLE `learners`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users_to_lessons`
--
ALTER TABLE `users_to_lessons`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
