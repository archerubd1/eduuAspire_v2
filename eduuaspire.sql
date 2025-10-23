-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 23, 2025 at 11:06 AM
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=37 ;

--
-- Dumping data for table `directions`
--

INSERT INTO `directions` (`id`, `name`, `direction_code`, `parent_direction_ID`, `direction_type`, `academic_level`, `description`, `icon`, `featured`, `display_order`, `active`) VALUES
(1, 'Academia', NULL, NULL, 'Category', 'K12', 'B2C Marketplace Courses for K12, UG, and PG.', NULL, 0, 0, 1),
(2, 'K12', NULL, 1, 'Category', 'K12', 'For Schools Goa Board, CBSE, ICSE, IB', NULL, 0, 0, 1),
(4, 'CBSE', NULL, 2, 'Category', 'K12', 'CBSE Board ', NULL, 0, 0, 1),
(5, 'ICSE', NULL, 2, 'Category', 'K12', 'ICSE Board ', NULL, 0, 0, 1),
(6, 'Goa Board', NULL, 2, 'Category', 'K12', 'Goa Board', NULL, 0, 0, 1),
(7, 'K-12', 'K12', NULL, 'Level', 'K12', 'School-level curriculum Classes V–X', NULL, 0, 0, 1),
(8, 'CBSE', 'CBSE', 1, 'Board', 'K12', 'Central Board of Secondary Education', NULL, 0, 0, 1),
(9, 'ICSE', 'ICSE', 1, 'Board', 'K12', 'Indian Certificate of Secondary Education', NULL, 0, 0, 1),
(10, 'Class V', 'C5', 2, '', 'K12', 'CBSE Class V', NULL, 0, 0, 1),
(11, 'Class VI', 'C6', 2, '', 'K12', 'CBSE Class VI', NULL, 0, 0, 1),
(12, 'Class VII', 'C7', 2, '', 'K12', 'CBSE Class VII', NULL, 0, 0, 1),
(13, 'Class VIII', 'C8', 2, '', 'K12', 'CBSE Class VIII', NULL, 0, 0, 1),
(14, 'Class IX', 'C9', 2, '', 'K12', 'CBSE Class IX', NULL, 0, 0, 1),
(15, 'Class X', 'C10', 2, '', 'K12', 'CBSE Class X', NULL, 0, 0, 1),
(16, 'Class V', 'I5', 3, '', 'K12', 'ICSE Class V', NULL, 0, 0, 1),
(17, 'Class VI', 'I6', 3, '', 'K12', 'ICSE Class VI', NULL, 0, 0, 1),
(18, 'Class VII', 'I7', 3, '', 'K12', 'ICSE Class VII', NULL, 0, 0, 1),
(19, 'Class VIII', 'I8', 3, '', 'K12', 'ICSE Class VIII', NULL, 0, 0, 1),
(20, 'Class IX', 'I9', 3, '', 'K12', 'ICSE Class IX', NULL, 0, 0, 1),
(21, 'Class X', 'I10', 3, '', 'K12', 'ICSE Class X', NULL, 0, 0, 1),
(22, 'Mathematics', 'MATH_CBSE', 2, 'Subject', 'K12', 'Mathematics foundation & board prep', NULL, 0, 0, 1),
(23, 'Science', 'SCI_CBSE', 2, 'Subject', 'K12', 'Physics, Chemistry, Biology integration', NULL, 0, 0, 1),
(24, 'Social Science', 'SST_CBSE', 2, 'Subject', 'K12', 'History | Geography | Civics | Economics', NULL, 0, 0, 1),
(25, 'English', 'ENG_CBSE', 2, 'Subject', 'K12', 'Language and grammar skills', NULL, 0, 0, 1),
(26, 'Hindi', 'HIN_CBSE', 2, 'Subject', 'K12', 'Hindi language improvement and writing', NULL, 0, 0, 1),
(27, 'Kannada', 'KAN_CBSE', 2, 'Subject', 'K12', 'Regional language Kannada', NULL, 0, 0, 1),
(28, 'Konkani', 'KON_CBSE', 2, 'Subject', 'K12', 'Regional language Konkani', NULL, 0, 0, 1),
(29, 'Geography', 'GEO_CBSE', 2, 'Subject', 'K12', 'Physical & Human Geography', NULL, 0, 0, 1),
(30, 'Olympic Arts (PE)', 'PE_CBSE', 2, 'Subject', 'K12', 'Physical Education & Sports Integration', NULL, 0, 0, 1),
(31, 'Mathematics', 'MATH_ICSE', 3, 'Subject', 'K12', 'Mathematics ICSE board program', NULL, 0, 0, 1),
(32, 'Science', 'SCI_ICSE', 3, 'Subject', 'K12', 'Integrated Science course', NULL, 0, 0, 1),
(33, 'English', 'ENG_ICSE', 3, 'Subject', 'K12', 'Language and Literature Skills', NULL, 0, 0, 1),
(34, 'Hindi', 'HIN_ICSE', 3, 'Subject', 'K12', 'Second Language – Hindi for ICSE', NULL, 0, 0, 1),
(35, 'Social Science', 'SST_ICSE', 3, 'Subject', 'K12', 'History Civics Geography', NULL, 0, 0, 1),
(36, 'Geography', 'GEO_ICSE', 3, 'Subject', 'K12', 'Detailed Physical & World Geography', NULL, 0, 0, 1);

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
  `bio` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

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
  `verified` tinyint(1) DEFAULT '0',
  `institution_verified` tinyint(1) DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `course_mode` enum('SPL','ILT','Hybrid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SPL',
  `delivery_type` enum('Online','Offline','Hybrid') COLLATE utf8mb4_unicode_ci DEFAULT 'Online',
  `assessment_type` enum('Practice Tests','Monthly Assessments','Board Prep Series','Exams','Project') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=586 ;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `name`, `course_code`, `info`, `duration`, `learners`, `rating`, `reviews`, `price`, `course_type`, `directions_ID`, `direction_id`, `sub_direction_id`, `academic_level`, `board`, `creator_LOGIN`, `instructor_id`, `institution_id`, `active`, `show_catalog`, `publish`, `verified`, `institution_verified`, `created`, `course_mode`, `delivery_type`, `assessment_type`) VALUES
(1, 'CBSE Mathematics - Class V SPL', NULL, 'Concepts of Numbers, Fractions, and Geometry for Class V learners.', 40, 120, '4.7', 45, '0.00', 'Paid', 1, NULL, NULL, '', 'CBSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'SPL', 'Online', 'Practice Tests'),
(2, 'CBSE Science - Class VI ILT', NULL, 'Interactive instructor-led course focusing on Physics, Chemistry & Biology fundamentals.', 50, 200, '4.8', 65, '0.00', 'Paid', 1, NULL, NULL, '', 'CBSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'ILT', 'Online', 'Monthly Assessments'),
(3, 'CBSE English - Class VII Hybrid', NULL, 'Grammar, literature and comprehension program aligned with NEP recommendations.', 60, 180, '4.6', 72, '0.00', 'Paid', 1, NULL, NULL, '', 'CBSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'Hybrid', 'Online', 'Board Prep Series'),
(4, 'CBSE Social Science - Class VIII SPL', NULL, 'Integrated History, Geography and Civics course with local Goa context.', 45, 220, '4.9', 58, '0.00', 'Paid', 1, NULL, NULL, '', 'CBSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'SPL', 'Online', ''),
(5, 'CBSE Hindi - Class IX ILT', NULL, 'Language proficiency and literature course delivered live by subject experts.', 55, 160, '4.8', 80, '0.00', 'Paid', 1, NULL, NULL, '', 'CBSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'ILT', 'Online', 'Exams'),
(6, 'CBSE Science - Class X Hybrid', NULL, 'Board prep batch focusing on experiments, past papers, and conceptual understanding.', 70, 300, '4.9', 110, '0.00', 'Paid', 1, NULL, NULL, '', 'CBSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'Hybrid', 'Online', 'Board Prep Series'),
(7, 'ICSE Mathematics - Class V ILT', NULL, 'Foundational math course with live problem solving sessions and practice sets.', 40, 90, '4.6', 30, '0.00', 'Paid', 1, NULL, NULL, '', 'ICSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'ILT', 'Online', 'Practice Tests'),
(8, 'ICSE Science - Class VI Hybrid', NULL, 'Focus on STEM learning through projects and virtual experiments.', 50, 150, '4.7', 44, '0.00', 'Paid', 1, NULL, NULL, '', 'ICSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'Hybrid', 'Online', 'Monthly Assessments'),
(9, 'ICSE English - Class VII SPL', NULL, 'Self-paced English grammar, comprehension and vocabulary building modules.', 45, 200, '4.8', 68, '0.00', 'Paid', 1, NULL, NULL, '', 'ICSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'SPL', 'Online', 'Board Prep Series'),
(10, 'ICSE Geography - Class VIII ILT', NULL, 'Map skills, environment and earth studies taught interactively via live ILT sessions.', 60, 170, '4.5', 52, '0.00', 'Paid', 1, NULL, NULL, '', 'ICSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'ILT', 'Online', ''),
(11, 'ICSE Hindi - Class IX Hybrid', NULL, 'Interactive hybrid model course strengthening reading, writing and grammar.', 55, 190, '4.8', 61, '0.00', 'Paid', 1, NULL, NULL, '', 'ICSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'Hybrid', 'Online', 'Exams'),
(12, 'ICSE Science - Class X SPL', NULL, 'Exam prep module for ICSE Board – extensive coverage of Physics, Chemistry & Biology.', 65, 240, '4.9', 89, '0.00', 'Paid', 1, NULL, NULL, '', 'ICSE', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'SPL', 'Online', 'Board Prep Series'),
(13, 'Goa Board Mathematics - Class V SPL', NULL, 'Mathematical foundation covering Number Systems, Fractions and Problem Solving.', 35, 100, '4.7', 25, '0.00', 'Paid', 1, NULL, NULL, '', 'Goa Board', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'SPL', 'Online', 'Practice Tests'),
(14, 'Goa Board Science - Class VI Hybrid', NULL, 'Curriculum-aligned science with experiments using local context and resources.', 45, 120, '4.6', 35, '0.00', 'Paid', 1, NULL, NULL, '', 'Goa Board', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'Hybrid', 'Online', 'Monthly Assessments'),
(15, 'Goa Board English - Class VII ILT', NULL, 'Instructor-led course for improving reading, writing and grammar skills.', 55, 130, '4.8', 40, '0.00', 'Paid', 1, NULL, NULL, '', 'Goa Board', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'ILT', 'Online', 'Board Prep Series'),
(16, 'Goa Board Social Science - Class VIII Hybrid', NULL, 'Interactive course combining History, Geography and Civics through digital resources.', 60, 110, '4.7', 38, '0.00', 'Paid', 1, NULL, NULL, '', 'Goa Board', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'Hybrid', 'Online', ''),
(17, 'Goa Board Konkani - Class IX SPL', NULL, 'Self-paced Konkani language program with cultural storytelling and local literature.', 40, 150, '4.8', 42, '0.00', 'Paid', 1, NULL, NULL, '', 'Goa Board', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'SPL', 'Online', 'Exams'),
(18, 'Goa Board Science - Class X ILT', NULL, 'Board-focused science revision course with past paper discussions and lab practicals.', 65, 210, '4.9', 75, '0.00', 'Paid', 1, NULL, NULL, '', 'Goa Board', 'admin', NULL, NULL, 1, 1, 1, 0, 0, 1761139162, 'ILT', 'Online', 'Board Prep Series'),
(19, 'PUC Arts - History SPL', NULL, 'Explore Indian and World History with concept videos.', 0, 150, '4.7', 35, '0.00', 'Paid', NULL, NULL, NULL, 'PUC', 'Arts', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761187335, 'SPL', 'Online', 'Practice Tests'),
(20, 'PUC Arts - Political Science ILT', NULL, 'Understand political systems and constitutions interactively.', 0, 180, '4.8', 42, '0.00', 'Paid', NULL, NULL, NULL, 'PUC', 'Arts', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761187335, 'ILT', 'Online', 'Monthly Assessments'),
(21, 'PUC Arts - Sociology Hybrid', NULL, 'Social behavior, institutions, and society through case studies.', 0, 200, '4.6', 39, '0.00', 'Paid', NULL, NULL, NULL, 'PUC', 'Arts', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761187335, 'Hybrid', 'Online', ''),
(22, 'PUC Commerce - Accountancy ILT', NULL, 'Financial accounting principles and ledger management.', 0, 230, '4.9', 55, '0.00', 'Paid', NULL, NULL, NULL, 'PUC', 'Commerce', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761187335, 'ILT', 'Online', 'Monthly Assessments'),
(23, 'PUC Commerce - Business Studies SPL', NULL, 'Modern business principles, case studies and entrepreneurship.', 0, 175, '4.8', 47, '0.00', 'Paid', NULL, NULL, NULL, 'PUC', 'Commerce', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761187335, 'SPL', 'Online', 'Practice Tests'),
(24, 'PUC Commerce - Statistics Hybrid', NULL, 'Applied statistics and data interpretation with exercises.', 0, 190, '4.7', 40, '0.00', 'Paid', NULL, NULL, NULL, 'PUC', 'Commerce', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761187335, 'Hybrid', 'Online', ''),
(25, 'PUC Science - Physics ILT', NULL, 'Mechanics, waves, and motion with virtual labs.', 0, 250, '4.9', 68, '0.00', 'Paid', NULL, NULL, NULL, 'PUC', 'Science', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761187335, 'ILT', 'Online', ''),
(26, 'PUC Science - Chemistry SPL', NULL, 'Organic and inorganic chemistry with self-paced videos.', 0, 220, '4.7', 52, '0.00', 'Paid', NULL, NULL, NULL, 'PUC', 'Science', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761187335, 'SPL', 'Online', 'Practice Tests'),
(27, 'PUC Science - Biology Hybrid', NULL, 'Life sciences, anatomy, and genetics with animations.', 0, 210, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, 'PUC', 'Science', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761187335, 'Hybrid', 'Online', ''),
(28, 'UG 1st Year BCA - C-Programming', NULL, 'Comprehensive BCA 1st Year course on C-Programming with Hybrid mode and Assignments based evaluation.', 0, 250, '4.7', 88, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(29, 'UG 1st Year BCA - DataBase Management System', NULL, 'Comprehensive BCA 1st Year course on DataBase Management System with Hybrid mode and Assignments based evaluation.', 0, 293, '4.7', 90, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(30, 'UG 1st Year BCA - Software Engineering', NULL, 'Comprehensive BCA 1st Year course on Software Engineering with Hybrid mode and Assignments based evaluation.', 0, 231, '4.7', 77, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(31, 'UG 1st Year BCA - Java Programming', NULL, 'Comprehensive BCA 1st Year course on Java Programming with Hybrid mode and Assignments based evaluation.', 0, 274, '4.7', 68, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(32, 'UG 1st Year BCA - Operating System', NULL, 'Comprehensive BCA 1st Year course on Operating System with Hybrid mode and Assignments based evaluation.', 0, 177, '4.7', 90, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(33, 'UG 1st Year BCA - Java Lab', NULL, 'Comprehensive BCA 1st Year course on Java Lab with Hybrid mode and Assignments based evaluation.', 0, 275, '4.7', 26, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(34, 'UG 1st Year BCA - MAD', NULL, 'Comprehensive BCA 1st Year course on MAD with Hybrid mode and Assignments based evaluation.', 0, 174, '4.7', 65, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(35, 'UG 1st Year BCA - AI Basics', NULL, 'Comprehensive BCA 1st Year course on AI Basics with Hybrid mode and Assignments based evaluation.', 0, 153, '4.7', 87, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(36, 'UG 1st Year BCA - Project Management', NULL, 'Comprehensive BCA 1st Year course on Project Management with Hybrid mode and Assignments based evaluation.', 0, 215, '4.7', 44, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(37, 'UG 2nd Year BCA - C-Programming', NULL, 'Comprehensive BCA 2nd Year course on C-Programming with Hybrid mode and Assignments based evaluation.', 0, 221, '4.7', 75, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(38, 'UG 2nd Year BCA - DataBase Management System', NULL, 'Comprehensive BCA 2nd Year course on DataBase Management System with Hybrid mode and Assignments based evaluation.', 0, 206, '4.7', 30, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(39, 'UG 2nd Year BCA - Software Engineering', NULL, 'Comprehensive BCA 2nd Year course on Software Engineering with Hybrid mode and Assignments based evaluation.', 0, 155, '4.7', 46, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(40, 'UG 2nd Year BCA - Java Programming', NULL, 'Comprehensive BCA 2nd Year course on Java Programming with Hybrid mode and Assignments based evaluation.', 0, 139, '4.7', 65, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(41, 'UG 2nd Year BCA - Operating System', NULL, 'Comprehensive BCA 2nd Year course on Operating System with Hybrid mode and Assignments based evaluation.', 0, 268, '4.7', 88, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(42, 'UG 2nd Year BCA - Java Lab', NULL, 'Comprehensive BCA 2nd Year course on Java Lab with Hybrid mode and Assignments based evaluation.', 0, 282, '4.7', 88, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(43, 'UG 2nd Year BCA - MAD', NULL, 'Comprehensive BCA 2nd Year course on MAD with Hybrid mode and Assignments based evaluation.', 0, 235, '4.7', 60, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(44, 'UG 2nd Year BCA - AI Basics', NULL, 'Comprehensive BCA 2nd Year course on AI Basics with Hybrid mode and Assignments based evaluation.', 0, 266, '4.7', 72, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(45, 'UG 2nd Year BCA - Project Management', NULL, 'Comprehensive BCA 2nd Year course on Project Management with Hybrid mode and Assignments based evaluation.', 0, 188, '4.7', 49, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(46, 'UG 3rd Year BCA - C-Programming', NULL, 'Comprehensive BCA 3rd Year course on C-Programming with Hybrid mode and Assignments based evaluation.', 0, 175, '4.7', 89, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(47, 'UG 3rd Year BCA - DataBase Management System', NULL, 'Comprehensive BCA 3rd Year course on DataBase Management System with Hybrid mode and Assignments based evaluation.', 0, 167, '4.7', 46, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(48, 'UG 3rd Year BCA - Software Engineering', NULL, 'Comprehensive BCA 3rd Year course on Software Engineering with Hybrid mode and Assignments based evaluation.', 0, 187, '4.7', 47, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(49, 'UG 3rd Year BCA - Java Programming', NULL, 'Comprehensive BCA 3rd Year course on Java Programming with Hybrid mode and Assignments based evaluation.', 0, 300, '4.7', 74, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(50, 'UG 3rd Year BCA - Operating System', NULL, 'Comprehensive BCA 3rd Year course on Operating System with Hybrid mode and Assignments based evaluation.', 0, 203, '4.7', 84, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(51, 'UG 3rd Year BCA - Java Lab', NULL, 'Comprehensive BCA 3rd Year course on Java Lab with Hybrid mode and Assignments based evaluation.', 0, 266, '4.7', 55, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(52, 'UG 3rd Year BCA - MAD', NULL, 'Comprehensive BCA 3rd Year course on MAD with Hybrid mode and Assignments based evaluation.', 0, 220, '4.7', 40, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(53, 'UG 3rd Year BCA - AI Basics', NULL, 'Comprehensive BCA 3rd Year course on AI Basics with Hybrid mode and Assignments based evaluation.', 0, 195, '4.7', 79, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(54, 'UG 3rd Year BCA - Project Management', NULL, 'Comprehensive BCA 3rd Year course on Project Management with Hybrid mode and Assignments based evaluation.', 0, 139, '4.7', 55, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(55, 'UG 1st Year BBA - Business Environment', NULL, 'Comprehensive BBA 1st Year course on Business Environment with ILT mode and Semester Exams based evaluation.', 0, 107, '4.8', 64, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(56, 'UG 1st Year BBA - Business Law', NULL, 'Comprehensive BBA 1st Year course on Business Law with ILT mode and Semester Exams based evaluation.', 0, 118, '4.8', 38, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(57, 'UG 1st Year BBA - Organizational Behavior', NULL, 'Comprehensive BBA 1st Year course on Organizational Behavior with ILT mode and Semester Exams based evaluation.', 0, 171, '4.8', 49, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(58, 'UG 1st Year BBA - Company Secretarial', NULL, 'Comprehensive BBA 1st Year course on Company Secretarial with ILT mode and Semester Exams based evaluation.', 0, 280, '4.8', 51, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(59, 'UG 1st Year BBA - Banking & Finance Service', NULL, 'Comprehensive BBA 1st Year course on Banking & Finance Service with ILT mode and Semester Exams based evaluation.', 0, 226, '4.8', 67, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(60, 'UG 1st Year BBA - Skill & Development', NULL, 'Comprehensive BBA 1st Year course on Skill & Development with ILT mode and Semester Exams based evaluation.', 0, 238, '4.8', 73, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(61, 'UG 1st Year BBA - Digital Marketing', NULL, 'Comprehensive BBA 1st Year course on Digital Marketing with ILT mode and Semester Exams based evaluation.', 0, 222, '4.8', 36, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(62, 'UG 1st Year BBA - Human Resource Management', NULL, 'Comprehensive BBA 1st Year course on Human Resource Management with ILT mode and Semester Exams based evaluation.', 0, 258, '4.8', 57, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(63, 'UG 1st Year BBA - Corporate Governance', NULL, 'Comprehensive BBA 1st Year course on Corporate Governance with ILT mode and Semester Exams based evaluation.', 0, 197, '4.8', 49, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(64, 'UG 2nd Year BBA - Business Environment', NULL, 'Comprehensive BBA 2nd Year course on Business Environment with ILT mode and Semester Exams based evaluation.', 0, 154, '4.8', 33, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(65, 'UG 2nd Year BBA - Business Law', NULL, 'Comprehensive BBA 2nd Year course on Business Law with ILT mode and Semester Exams based evaluation.', 0, 102, '4.8', 73, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(66, 'UG 2nd Year BBA - Organizational Behavior', NULL, 'Comprehensive BBA 2nd Year course on Organizational Behavior with ILT mode and Semester Exams based evaluation.', 0, 190, '4.8', 57, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(67, 'UG 2nd Year BBA - Company Secretarial', NULL, 'Comprehensive BBA 2nd Year course on Company Secretarial with ILT mode and Semester Exams based evaluation.', 0, 156, '4.8', 48, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(68, 'UG 2nd Year BBA - Banking & Finance Service', NULL, 'Comprehensive BBA 2nd Year course on Banking & Finance Service with ILT mode and Semester Exams based evaluation.', 0, 181, '4.8', 58, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(69, 'UG 2nd Year BBA - Skill & Development', NULL, 'Comprehensive BBA 2nd Year course on Skill & Development with ILT mode and Semester Exams based evaluation.', 0, 127, '4.8', 43, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(70, 'UG 2nd Year BBA - Digital Marketing', NULL, 'Comprehensive BBA 2nd Year course on Digital Marketing with ILT mode and Semester Exams based evaluation.', 0, 211, '4.8', 40, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(71, 'UG 2nd Year BBA - Human Resource Management', NULL, 'Comprehensive BBA 2nd Year course on Human Resource Management with ILT mode and Semester Exams based evaluation.', 0, 237, '4.8', 51, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(72, 'UG 2nd Year BBA - Corporate Governance', NULL, 'Comprehensive BBA 2nd Year course on Corporate Governance with ILT mode and Semester Exams based evaluation.', 0, 275, '4.8', 33, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(73, 'UG 3rd Year BBA - Business Environment', NULL, 'Comprehensive BBA 3rd Year course on Business Environment with ILT mode and Semester Exams based evaluation.', 0, 253, '4.8', 38, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(74, 'UG 3rd Year BBA - Business Law', NULL, 'Comprehensive BBA 3rd Year course on Business Law with ILT mode and Semester Exams based evaluation.', 0, 276, '4.8', 43, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(75, 'UG 3rd Year BBA - Organizational Behavior', NULL, 'Comprehensive BBA 3rd Year course on Organizational Behavior with ILT mode and Semester Exams based evaluation.', 0, 215, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(76, 'UG 3rd Year BBA - Company Secretarial', NULL, 'Comprehensive BBA 3rd Year course on Company Secretarial with ILT mode and Semester Exams based evaluation.', 0, 208, '4.8', 48, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(77, 'UG 3rd Year BBA - Banking & Finance Service', NULL, 'Comprehensive BBA 3rd Year course on Banking & Finance Service with ILT mode and Semester Exams based evaluation.', 0, 253, '4.8', 43, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(78, 'UG 3rd Year BBA - Skill & Development', NULL, 'Comprehensive BBA 3rd Year course on Skill & Development with ILT mode and Semester Exams based evaluation.', 0, 158, '4.8', 53, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(79, 'UG 3rd Year BBA - Digital Marketing', NULL, 'Comprehensive BBA 3rd Year course on Digital Marketing with ILT mode and Semester Exams based evaluation.', 0, 225, '4.8', 71, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(80, 'UG 3rd Year BBA - Human Resource Management', NULL, 'Comprehensive BBA 3rd Year course on Human Resource Management with ILT mode and Semester Exams based evaluation.', 0, 118, '4.8', 38, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(81, 'UG 3rd Year BBA - Corporate Governance', NULL, 'Comprehensive BBA 3rd Year course on Corporate Governance with ILT mode and Semester Exams based evaluation.', 0, 263, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BBA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'ILT', 'Online', ''),
(82, 'UG 1st Year BCom - Financial Accounting', NULL, 'Comprehensive BCom 1st Year course on Financial Accounting with SPL mode and Practice Tests based evaluation.', 0, 195, '4.6', 49, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(83, 'UG 1st Year BCom - Business Communication', NULL, 'Comprehensive BCom 1st Year course on Business Communication with SPL mode and Practice Tests based evaluation.', 0, 225, '4.6', 52, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(84, 'UG 1st Year BCom - Business Economics', NULL, 'Comprehensive BCom 1st Year course on Business Economics with SPL mode and Practice Tests based evaluation.', 0, 174, '4.6', 33, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(85, 'UG 1st Year BCom - Corporate Accounting', NULL, 'Comprehensive BCom 1st Year course on Corporate Accounting with SPL mode and Practice Tests based evaluation.', 0, 234, '4.6', 24, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(86, 'UG 1st Year BCom - Business Law', NULL, 'Comprehensive BCom 1st Year course on Business Law with SPL mode and Practice Tests based evaluation.', 0, 260, '4.6', 36, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(87, 'UG 1st Year BCom - Business Statistics', NULL, 'Comprehensive BCom 1st Year course on Business Statistics with SPL mode and Practice Tests based evaluation.', 0, 189, '4.6', 47, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(88, 'UG 1st Year BCom - Cost Accounting', NULL, 'Comprehensive BCom 1st Year course on Cost Accounting with SPL mode and Practice Tests based evaluation.', 0, 228, '4.6', 38, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(89, 'UG 1st Year BCom - Income Tax', NULL, 'Comprehensive BCom 1st Year course on Income Tax with SPL mode and Practice Tests based evaluation.', 0, 169, '4.6', 36, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(90, 'UG 1st Year BCom - Marketing Management', NULL, 'Comprehensive BCom 1st Year course on Marketing Management with SPL mode and Practice Tests based evaluation.', 0, 241, '4.6', 44, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(91, 'UG 2nd Year BCom - Financial Accounting', NULL, 'Comprehensive BCom 2nd Year course on Financial Accounting with SPL mode and Practice Tests based evaluation.', 0, 199, '4.6', 34, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(92, 'UG 2nd Year BCom - Business Communication', NULL, 'Comprehensive BCom 2nd Year course on Business Communication with SPL mode and Practice Tests based evaluation.', 0, 184, '4.6', 32, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(93, 'UG 2nd Year BCom - Business Economics', NULL, 'Comprehensive BCom 2nd Year course on Business Economics with SPL mode and Practice Tests based evaluation.', 0, 249, '4.6', 58, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(94, 'UG 2nd Year BCom - Corporate Accounting', NULL, 'Comprehensive BCom 2nd Year course on Corporate Accounting with SPL mode and Practice Tests based evaluation.', 0, 221, '4.6', 59, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(95, 'UG 2nd Year BCom - Business Law', NULL, 'Comprehensive BCom 2nd Year course on Business Law with SPL mode and Practice Tests based evaluation.', 0, 230, '4.6', 50, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(96, 'UG 2nd Year BCom - Business Statistics', NULL, 'Comprehensive BCom 2nd Year course on Business Statistics with SPL mode and Practice Tests based evaluation.', 0, 236, '4.6', 53, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(97, 'UG 2nd Year BCom - Cost Accounting', NULL, 'Comprehensive BCom 2nd Year course on Cost Accounting with SPL mode and Practice Tests based evaluation.', 0, 223, '4.6', 28, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(98, 'UG 2nd Year BCom - Income Tax', NULL, 'Comprehensive BCom 2nd Year course on Income Tax with SPL mode and Practice Tests based evaluation.', 0, 172, '4.6', 69, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(99, 'UG 2nd Year BCom - Marketing Management', NULL, 'Comprehensive BCom 2nd Year course on Marketing Management with SPL mode and Practice Tests based evaluation.', 0, 253, '4.6', 33, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(100, 'UG 3rd Year BCom - Financial Accounting', NULL, 'Comprehensive BCom 3rd Year course on Financial Accounting with SPL mode and Practice Tests based evaluation.', 0, 246, '4.6', 36, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(101, 'UG 3rd Year BCom - Business Communication', NULL, 'Comprehensive BCom 3rd Year course on Business Communication with SPL mode and Practice Tests based evaluation.', 0, 177, '4.6', 34, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(102, 'UG 3rd Year BCom - Business Economics', NULL, 'Comprehensive BCom 3rd Year course on Business Economics with SPL mode and Practice Tests based evaluation.', 0, 178, '4.6', 61, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(103, 'UG 3rd Year BCom - Corporate Accounting', NULL, 'Comprehensive BCom 3rd Year course on Corporate Accounting with SPL mode and Practice Tests based evaluation.', 0, 240, '4.6', 21, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(104, 'UG 3rd Year BCom - Business Law', NULL, 'Comprehensive BCom 3rd Year course on Business Law with SPL mode and Practice Tests based evaluation.', 0, 186, '4.6', 21, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(105, 'UG 3rd Year BCom - Business Statistics', NULL, 'Comprehensive BCom 3rd Year course on Business Statistics with SPL mode and Practice Tests based evaluation.', 0, 191, '4.6', 63, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(106, 'UG 3rd Year BCom - Cost Accounting', NULL, 'Comprehensive BCom 3rd Year course on Cost Accounting with SPL mode and Practice Tests based evaluation.', 0, 210, '4.6', 23, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(107, 'UG 3rd Year BCom - Income Tax', NULL, 'Comprehensive BCom 3rd Year course on Income Tax with SPL mode and Practice Tests based evaluation.', 0, 165, '4.6', 51, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(108, 'UG 3rd Year BCom - Marketing Management', NULL, 'Comprehensive BCom 3rd Year course on Marketing Management with SPL mode and Practice Tests based evaluation.', 0, 249, '4.6', 45, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BCom', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'SPL', 'Online', 'Practice Tests'),
(109, 'UG 1st Year BA - Industrial Economics', NULL, 'Comprehensive BA 1st Year course on Industrial Economics with Hybrid mode and Projects based evaluation.', 0, 188, '4.7', 51, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(110, 'UG 1st Year BA - English', NULL, 'Comprehensive BA 1st Year course on English with Hybrid mode and Projects based evaluation.', 0, 191, '4.7', 43, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(111, 'UG 1st Year BA - Managerial Economics', NULL, 'Comprehensive BA 1st Year course on Managerial Economics with Hybrid mode and Projects based evaluation.', 0, 166, '4.7', 57, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(112, 'UG 1st Year BA - Indian Economics', NULL, 'Comprehensive BA 1st Year course on Indian Economics with Hybrid mode and Projects based evaluation.', 0, 130, '4.7', 45, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(113, 'UG 1st Year BA - Hindi', NULL, 'Comprehensive BA 1st Year course on Hindi with Hybrid mode and Projects based evaluation.', 0, 127, '4.7', 40, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(114, 'UG 1st Year BA - Micro and Macro Economics', NULL, 'Comprehensive BA 1st Year course on Micro and Macro Economics with Hybrid mode and Projects based evaluation.', 0, 194, '4.7', 55, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(115, 'UG 2nd Year BA - Industrial Economics', NULL, 'Comprehensive BA 2nd Year course on Industrial Economics with Hybrid mode and Projects based evaluation.', 0, 96, '4.7', 36, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(116, 'UG 2nd Year BA - English', NULL, 'Comprehensive BA 2nd Year course on English with Hybrid mode and Projects based evaluation.', 0, 137, '4.7', 56, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(117, 'UG 2nd Year BA - Managerial Economics', NULL, 'Comprehensive BA 2nd Year course on Managerial Economics with Hybrid mode and Projects based evaluation.', 0, 162, '4.7', 59, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(118, 'UG 2nd Year BA - Indian Economics', NULL, 'Comprehensive BA 2nd Year course on Indian Economics with Hybrid mode and Projects based evaluation.', 0, 136, '4.7', 53, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192670, 'Hybrid', 'Online', ''),
(119, 'UG 2nd Year BA - Hindi', NULL, 'Comprehensive BA 2nd Year course on Hindi with Hybrid mode and Projects based evaluation.', 0, 109, '4.7', 61, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192671, 'Hybrid', 'Online', ''),
(120, 'UG 2nd Year BA - Micro and Macro Economics', NULL, 'Comprehensive BA 2nd Year course on Micro and Macro Economics with Hybrid mode and Projects based evaluation.', 0, 188, '4.7', 28, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192671, 'Hybrid', 'Online', ''),
(121, 'UG 3rd Year BA - Industrial Economics', NULL, 'Comprehensive BA 3rd Year course on Industrial Economics with Hybrid mode and Projects based evaluation.', 0, 144, '4.7', 56, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192671, 'Hybrid', 'Online', ''),
(122, 'UG 3rd Year BA - English', NULL, 'Comprehensive BA 3rd Year course on English with Hybrid mode and Projects based evaluation.', 0, 108, '4.7', 26, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192671, 'Hybrid', 'Online', ''),
(123, 'UG 3rd Year BA - Managerial Economics', NULL, 'Comprehensive BA 3rd Year course on Managerial Economics with Hybrid mode and Projects based evaluation.', 0, 174, '4.7', 37, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192671, 'Hybrid', 'Online', ''),
(124, 'UG 3rd Year BA - Indian Economics', NULL, 'Comprehensive BA 3rd Year course on Indian Economics with Hybrid mode and Projects based evaluation.', 0, 133, '4.7', 30, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192671, 'Hybrid', 'Online', ''),
(125, 'UG 3rd Year BA - Hindi', NULL, 'Comprehensive BA 3rd Year course on Hindi with Hybrid mode and Projects based evaluation.', 0, 163, '4.7', 61, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192671, 'Hybrid', 'Online', ''),
(126, 'UG 3rd Year BA - Micro and Macro Economics', NULL, 'Comprehensive BA 3rd Year course on Micro and Macro Economics with Hybrid mode and Projects based evaluation.', 0, 199, '4.7', 46, '0.00', 'Paid', NULL, NULL, NULL, 'UG', 'BA', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761192671, 'Hybrid', 'Online', ''),
(127, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 182, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'Hybrid', 'Online', ''),
(128, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 253, '4.8', 67, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'Hybrid', 'Online', ''),
(129, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 264, '4.8', 80, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'Hybrid', 'Online', ''),
(130, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 181, '4.8', 76, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'Hybrid', 'Online', ''),
(131, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 111, '4.8', 64, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'Hybrid', 'Online', ''),
(132, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 258, '4.8', 60, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'Hybrid', 'Online', ''),
(133, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 318, '4.7', 79, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'ILT', 'Online', ''),
(134, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 229, '4.7', 87, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'ILT', 'Online', ''),
(135, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 226, '4.7', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'ILT', 'Online', ''),
(136, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 186, '4.7', 65, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'ILT', 'Online', ''),
(137, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 231, '4.7', 42, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'ILT', 'Online', ''),
(138, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 220, '4.6', 43, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'ILT', 'Online', ''),
(139, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 141, '4.6', 45, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'ILT', 'Online', ''),
(140, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 231, '4.6', 32, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'ILT', 'Online', ''),
(141, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 165, '4.6', 51, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'ILT', 'Online', ''),
(142, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 256, '4.6', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'ILT', 'Online', ''),
(143, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 119, '4.8', 48, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'SPL', 'Online', ''),
(144, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 119, '4.8', 52, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'SPL', 'Online', ''),
(145, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 139, '4.8', 83, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'SPL', 'Online', ''),
(146, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 225, '4.8', 56, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'SPL', 'Online', ''),
(147, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 241, '4.8', 58, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'SPL', 'Online', ''),
(148, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 98, '4.7', 52, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'Hybrid', 'Online', 'Project'),
(149, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 223, '4.7', 24, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'Hybrid', 'Online', 'Project'),
(150, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 128, '4.7', 42, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'Hybrid', 'Online', 'Project'),
(151, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 156, '4.7', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'Hybrid', 'Online', 'Project'),
(152, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 149, '4.7', 31, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197908, 'Hybrid', 'Online', 'Project'),
(153, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 146, '4.8', 65, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(154, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 296, '4.8', 34, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(155, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 189, '4.8', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(156, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 281, '4.8', 57, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(157, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 266, '4.8', 56, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(158, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 234, '4.8', 68, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(159, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 270, '4.7', 68, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(160, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 199, '4.7', 56, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(161, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 245, '4.7', 55, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(162, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 171, '4.7', 56, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(163, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 286, '4.7', 70, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', '');
INSERT INTO `lessons` (`id`, `name`, `course_code`, `info`, `duration`, `learners`, `rating`, `reviews`, `price`, `course_type`, `directions_ID`, `direction_id`, `sub_direction_id`, `academic_level`, `board`, `creator_LOGIN`, `instructor_id`, `institution_id`, `active`, `show_catalog`, `publish`, `verified`, `institution_verified`, `created`, `course_mode`, `delivery_type`, `assessment_type`) VALUES
(164, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 153, '4.6', 44, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(165, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 269, '4.6', 65, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(166, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 125, '4.6', 53, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(167, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 190, '4.6', 61, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(168, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 206, '4.6', 48, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(169, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 241, '4.8', 72, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'SPL', 'Online', ''),
(170, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 138, '4.8', 43, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'SPL', 'Online', ''),
(171, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 199, '4.8', 69, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'SPL', 'Online', ''),
(172, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 249, '4.8', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'SPL', 'Online', ''),
(173, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 144, '4.8', 80, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'SPL', 'Online', ''),
(174, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 141, '4.7', 58, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', 'Project'),
(175, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 90, '4.7', 29, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', 'Project'),
(176, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 132, '4.7', 47, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', 'Project'),
(177, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 176, '4.7', 20, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', 'Project'),
(178, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 127, '4.7', 44, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', 'Project'),
(179, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 190, '4.8', 31, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(180, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 137, '4.8', 68, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(181, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 107, '4.8', 54, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(182, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 280, '4.8', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(183, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 273, '4.8', 43, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(184, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 102, '4.8', 76, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', ''),
(185, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 177, '4.7', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(186, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 250, '4.7', 74, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(187, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 266, '4.7', 75, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(188, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 316, '4.7', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(189, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 233, '4.7', 67, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(190, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 276, '4.6', 29, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(191, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 176, '4.6', 30, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(192, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 182, '4.6', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(193, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 219, '4.6', 35, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(194, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 129, '4.6', 64, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'ILT', 'Online', ''),
(195, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 241, '4.8', 45, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'SPL', 'Online', ''),
(196, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 172, '4.8', 48, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'SPL', 'Online', ''),
(197, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 181, '4.8', 83, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'SPL', 'Online', ''),
(198, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 182, '4.8', 59, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'SPL', 'Online', ''),
(199, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 119, '4.8', 75, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'SPL', 'Online', ''),
(200, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 193, '4.7', 40, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', 'Project'),
(201, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 206, '4.7', 42, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', 'Project'),
(202, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 101, '4.7', 58, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', 'Project'),
(203, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 160, '4.7', 43, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', 'Project'),
(204, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 93, '4.7', 56, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197910, 'Hybrid', 'Online', 'Project'),
(205, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 160, '4.8', 35, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'Hybrid', 'Online', ''),
(206, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 146, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'Hybrid', 'Online', ''),
(207, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 258, '4.8', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'Hybrid', 'Online', ''),
(208, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 233, '4.8', 76, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'Hybrid', 'Online', ''),
(209, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 156, '4.8', 34, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'Hybrid', 'Online', ''),
(210, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 206, '4.8', 80, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'Hybrid', 'Online', ''),
(211, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 253, '4.7', 47, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'ILT', 'Online', ''),
(212, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 210, '4.7', 72, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'ILT', 'Online', ''),
(213, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 289, '4.7', 85, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'ILT', 'Online', ''),
(214, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 340, '4.7', 62, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'ILT', 'Online', ''),
(215, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 259, '4.7', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'ILT', 'Online', ''),
(216, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 270, '4.6', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'ILT', 'Online', ''),
(217, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 165, '4.6', 39, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'ILT', 'Online', ''),
(218, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 156, '4.6', 45, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'ILT', 'Online', ''),
(219, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 221, '4.6', 31, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'ILT', 'Online', ''),
(220, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 169, '4.6', 38, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'ILT', 'Online', ''),
(221, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 223, '4.8', 35, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'SPL', 'Online', ''),
(222, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 128, '4.8', 67, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'SPL', 'Online', ''),
(223, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 183, '4.8', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'SPL', 'Online', ''),
(224, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 134, '4.8', 68, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'SPL', 'Online', ''),
(225, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 110, '4.8', 76, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'SPL', 'Online', ''),
(226, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 146, '4.7', 57, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'Hybrid', 'Online', 'Project'),
(227, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 226, '4.7', 58, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'Hybrid', 'Online', 'Project'),
(228, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 129, '4.7', 39, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'Hybrid', 'Online', 'Project'),
(229, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 178, '4.7', 39, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'Hybrid', 'Online', 'Project'),
(230, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 200, '4.7', 58, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197911, 'Hybrid', 'Online', 'Project'),
(231, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 243, '4.8', 69, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'Hybrid', 'Online', ''),
(232, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 175, '4.8', 51, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'Hybrid', 'Online', ''),
(233, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 188, '4.8', 65, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'Hybrid', 'Online', ''),
(234, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 106, '4.8', 56, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'Hybrid', 'Online', ''),
(235, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 204, '4.8', 60, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'Hybrid', 'Online', ''),
(236, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 143, '4.8', 44, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'Hybrid', 'Online', ''),
(237, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 185, '4.7', 54, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'ILT', 'Online', ''),
(238, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 331, '4.7', 57, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'ILT', 'Online', ''),
(239, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 175, '4.7', 45, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'ILT', 'Online', ''),
(240, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 261, '4.7', 80, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'ILT', 'Online', ''),
(241, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 269, '4.7', 87, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'ILT', 'Online', ''),
(242, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 142, '4.6', 35, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'ILT', 'Online', ''),
(243, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 167, '4.6', 29, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'ILT', 'Online', ''),
(244, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 140, '4.6', 60, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'ILT', 'Online', ''),
(245, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 191, '4.6', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'ILT', 'Online', ''),
(246, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 199, '4.6', 67, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'ILT', 'Online', ''),
(247, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 217, '4.8', 49, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'SPL', 'Online', ''),
(248, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 208, '4.8', 72, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'SPL', 'Online', ''),
(249, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 176, '4.8', 60, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'SPL', 'Online', ''),
(250, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 210, '4.8', 85, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'SPL', 'Online', ''),
(251, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 149, '4.8', 57, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'SPL', 'Online', ''),
(252, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 90, '4.7', 48, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'Hybrid', 'Online', 'Project'),
(253, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 149, '4.7', 57, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'Hybrid', 'Online', 'Project'),
(254, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 167, '4.7', 37, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'Hybrid', 'Online', 'Project'),
(255, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 176, '4.7', 32, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'Hybrid', 'Online', 'Project'),
(256, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 204, '4.7', 31, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197963, 'Hybrid', 'Online', 'Project'),
(257, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 112, '4.8', 51, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197969, 'Hybrid', 'Online', ''),
(258, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 251, '4.8', 74, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197969, 'Hybrid', 'Online', ''),
(259, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 199, '4.8', 61, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197969, 'Hybrid', 'Online', ''),
(260, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 271, '4.8', 44, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197969, 'Hybrid', 'Online', ''),
(261, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 125, '4.8', 68, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197969, 'Hybrid', 'Online', ''),
(262, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 115, '4.8', 34, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197969, 'Hybrid', 'Online', ''),
(263, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 286, '4.7', 48, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197969, 'ILT', 'Online', ''),
(264, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 329, '4.7', 61, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197969, 'ILT', 'Online', ''),
(265, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 225, '4.7', 74, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197969, 'ILT', 'Online', ''),
(266, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 203, '4.7', 83, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(267, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 335, '4.7', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(268, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 227, '4.6', 48, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(269, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 208, '4.6', 72, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(270, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 131, '4.6', 69, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(271, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 276, '4.6', 69, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(272, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 271, '4.6', 32, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(273, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 167, '4.8', 49, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'SPL', 'Online', ''),
(274, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 144, '4.8', 81, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'SPL', 'Online', ''),
(275, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 190, '4.8', 62, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'SPL', 'Online', ''),
(276, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 174, '4.8', 47, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'SPL', 'Online', ''),
(277, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 207, '4.8', 58, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'SPL', 'Online', ''),
(278, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 165, '4.7', 49, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', 'Project'),
(279, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 157, '4.7', 36, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', 'Project'),
(280, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 225, '4.7', 39, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', 'Project'),
(281, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 111, '4.7', 29, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', 'Project'),
(282, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 187, '4.7', 23, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', 'Project'),
(283, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 164, '4.8', 66, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', ''),
(284, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 205, '4.8', 78, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', ''),
(285, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 299, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', ''),
(286, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 110, '4.8', 39, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', ''),
(287, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 249, '4.8', 41, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', ''),
(288, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 216, '4.8', 41, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', ''),
(289, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 208, '4.7', 79, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(290, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 265, '4.7', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(291, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 320, '4.7', 81, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(292, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 150, '4.7', 66, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(293, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 178, '4.7', 75, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(294, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 174, '4.6', 48, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(295, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 181, '4.6', 37, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(296, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 207, '4.6', 54, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(297, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 167, '4.6', 67, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(298, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 135, '4.6', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'ILT', 'Online', ''),
(299, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 123, '4.8', 48, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'SPL', 'Online', ''),
(300, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 244, '4.8', 43, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'SPL', 'Online', ''),
(301, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 181, '4.8', 81, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'SPL', 'Online', ''),
(302, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 193, '4.8', 52, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'SPL', 'Online', ''),
(303, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 214, '4.8', 66, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'SPL', 'Online', ''),
(304, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 227, '4.7', 21, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', 'Project'),
(305, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 163, '4.7', 49, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', 'Project');
INSERT INTO `lessons` (`id`, `name`, `course_code`, `info`, `duration`, `learners`, `rating`, `reviews`, `price`, `course_type`, `directions_ID`, `direction_id`, `sub_direction_id`, `academic_level`, `board`, `creator_LOGIN`, `instructor_id`, `institution_id`, `active`, `show_catalog`, `publish`, `verified`, `institution_verified`, `created`, `course_mode`, `delivery_type`, `assessment_type`) VALUES
(306, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 171, '4.7', 35, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', 'Project'),
(307, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 99, '4.7', 22, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', 'Project'),
(308, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 142, '4.7', 58, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197970, 'Hybrid', 'Online', 'Project'),
(309, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 118, '4.8', 80, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(310, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 263, '4.8', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(311, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 265, '4.8', 47, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(312, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 276, '4.8', 60, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(313, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 294, '4.8', 53, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(314, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 107, '4.8', 49, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(315, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 301, '4.7', 49, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(316, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 201, '4.7', 79, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(317, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 330, '4.7', 85, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(318, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 150, '4.7', 84, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(319, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 274, '4.7', 59, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(320, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 160, '4.6', 37, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(321, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 221, '4.6', 26, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(322, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 194, '4.6', 75, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(323, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 145, '4.6', 59, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(324, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 218, '4.6', 61, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(325, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 239, '4.8', 67, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'SPL', 'Online', ''),
(326, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 133, '4.8', 61, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'SPL', 'Online', ''),
(327, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 128, '4.8', 75, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'SPL', 'Online', ''),
(328, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 122, '4.8', 84, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'SPL', 'Online', ''),
(329, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 182, '4.8', 58, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'SPL', 'Online', ''),
(330, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 210, '4.7', 27, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', 'Project'),
(331, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 130, '4.7', 40, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', 'Project'),
(332, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 151, '4.7', 51, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', 'Project'),
(333, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 112, '4.7', 29, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', 'Project'),
(334, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 131, '4.7', 51, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', 'Project'),
(335, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 173, '4.8', 57, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(336, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 179, '4.8', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(337, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 223, '4.8', 67, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(338, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 144, '4.8', 80, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(339, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 125, '4.8', 63, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(340, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 246, '4.8', 75, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', ''),
(341, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 275, '4.7', 74, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(342, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 228, '4.7', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(343, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 214, '4.7', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(344, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 185, '4.7', 77, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(345, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 337, '4.7', 82, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(346, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 208, '4.6', 44, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(347, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 231, '4.6', 33, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(348, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 198, '4.6', 30, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(349, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 168, '4.6', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(350, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 193, '4.6', 27, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'ILT', 'Online', ''),
(351, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 249, '4.8', 37, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'SPL', 'Online', ''),
(352, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 169, '4.8', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'SPL', 'Online', ''),
(353, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 176, '4.8', 75, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'SPL', 'Online', ''),
(354, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 230, '4.8', 53, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'SPL', 'Online', ''),
(355, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 246, '4.8', 36, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'SPL', 'Online', ''),
(356, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 191, '4.7', 37, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', 'Project'),
(357, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 118, '4.7', 23, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', 'Project'),
(358, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 159, '4.7', 22, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', 'Project'),
(359, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 143, '4.7', 53, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', 'Project'),
(360, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 108, '4.7', 55, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761197989, 'Hybrid', 'Online', 'Project'),
(361, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 146, '4.8', 60, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'Hybrid', 'Online', ''),
(362, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 124, '4.8', 77, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'Hybrid', 'Online', ''),
(363, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 295, '4.8', 41, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'Hybrid', 'Online', ''),
(364, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 183, '4.8', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'Hybrid', 'Online', ''),
(365, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 163, '4.8', 32, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'Hybrid', 'Online', ''),
(366, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 199, '4.8', 65, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'Hybrid', 'Online', ''),
(367, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 248, '4.7', 88, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'ILT', 'Online', ''),
(368, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 213, '4.7', 44, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'ILT', 'Online', ''),
(369, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 191, '4.7', 51, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'ILT', 'Online', ''),
(370, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 222, '4.7', 45, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'ILT', 'Online', ''),
(371, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 288, '4.7', 78, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'ILT', 'Online', ''),
(372, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 214, '4.6', 42, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'ILT', 'Online', ''),
(373, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 225, '4.6', 69, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'ILT', 'Online', ''),
(374, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 194, '4.6', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'ILT', 'Online', ''),
(375, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 171, '4.6', 45, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'ILT', 'Online', ''),
(376, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 276, '4.6', 44, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'ILT', 'Online', ''),
(377, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 166, '4.8', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'SPL', 'Online', ''),
(378, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 189, '4.8', 79, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'SPL', 'Online', ''),
(379, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 127, '4.8', 67, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'SPL', 'Online', ''),
(380, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 141, '4.8', 83, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'SPL', 'Online', ''),
(381, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 139, '4.8', 61, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'SPL', 'Online', ''),
(382, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 147, '4.7', 49, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'Hybrid', 'Online', 'Project'),
(383, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 211, '4.7', 28, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'Hybrid', 'Online', 'Project'),
(384, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 102, '4.7', 52, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'Hybrid', 'Online', 'Project'),
(385, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 205, '4.7', 21, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'Hybrid', 'Online', 'Project'),
(386, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 194, '4.7', 29, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214633, 'Hybrid', 'Online', 'Project'),
(387, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 188, '4.8', 42, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'Hybrid', 'Online', ''),
(388, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 141, '4.8', 61, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'Hybrid', 'Online', ''),
(389, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 210, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'Hybrid', 'Online', ''),
(390, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 194, '4.8', 65, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'Hybrid', 'Online', ''),
(391, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 140, '4.8', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'Hybrid', 'Online', ''),
(392, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 290, '4.8', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'Hybrid', 'Online', ''),
(393, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 275, '4.7', 66, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'ILT', 'Online', ''),
(394, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 273, '4.7', 56, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'ILT', 'Online', ''),
(395, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 255, '4.7', 81, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'ILT', 'Online', ''),
(396, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 336, '4.7', 69, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'ILT', 'Online', ''),
(397, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 175, '4.7', 67, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'ILT', 'Online', ''),
(398, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 260, '4.6', 62, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'ILT', 'Online', ''),
(399, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 143, '4.6', 27, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'ILT', 'Online', ''),
(400, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 265, '4.6', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'ILT', 'Online', ''),
(401, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 250, '4.6', 32, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'ILT', 'Online', ''),
(402, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 280, '4.6', 59, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'ILT', 'Online', ''),
(403, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 226, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'SPL', 'Online', ''),
(404, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 197, '4.8', 42, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'SPL', 'Online', ''),
(405, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 169, '4.8', 40, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'SPL', 'Online', ''),
(406, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 214, '4.8', 80, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'SPL', 'Online', ''),
(407, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 153, '4.8', 41, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'SPL', 'Online', ''),
(408, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 207, '4.7', 20, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'Hybrid', 'Online', 'Project'),
(409, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 190, '4.7', 25, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'Hybrid', 'Online', 'Project'),
(410, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 210, '4.7', 24, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'Hybrid', 'Online', 'Project'),
(411, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 139, '4.7', 39, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'Hybrid', 'Online', 'Project'),
(412, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 129, '4.7', 32, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761214696, 'Hybrid', 'Online', 'Project'),
(413, 'Front Office Onboarding', NULL, 'Corporate onboarding and skilling course in Front Office Onboarding for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 187, '4.8', 30, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215106, 'Hybrid', 'Online', ''),
(414, 'Housekeeping Essentials', NULL, 'Corporate onboarding and skilling course in Housekeeping Essentials for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 116, '4.8', 36, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'Hybrid', 'Online', ''),
(415, 'Food & Beverage Service', NULL, 'Corporate onboarding and skilling course in Food & Beverage Service for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 239, '4.8', 32, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'Hybrid', 'Online', ''),
(416, 'Hospitality Etiquette', NULL, 'Corporate onboarding and skilling course in Hospitality Etiquette for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 245, '4.8', 66, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'Hybrid', 'Online', ''),
(417, 'Customer Service Excellence', NULL, 'Corporate onboarding and skilling course in Customer Service Excellence for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 168, '4.8', 53, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'Hybrid', 'Online', ''),
(418, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding and skilling course in Safety & Hygiene Induction for Hospitality & Tourism sector. Delivered in Hybrid mode with Practical evaluation.', 0, 135, '4.8', 63, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'Hybrid', 'Online', ''),
(419, 'Industrial Safety Induction', NULL, 'Corporate onboarding and skilling course in Industrial Safety Induction for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 168, '4.7', 69, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'ILT', 'Online', ''),
(420, 'Machine Operations Basics', NULL, 'Corporate onboarding and skilling course in Machine Operations Basics for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 332, '4.7', 42, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'ILT', 'Online', ''),
(421, 'Electrical & Maintenance', NULL, 'Corporate onboarding and skilling course in Electrical & Maintenance for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 184, '4.7', 52, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'ILT', 'Online', ''),
(422, 'Workplace Discipline & SOPs', NULL, 'Corporate onboarding and skilling course in Workplace Discipline & SOPs for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 328, '4.7', 63, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'ILT', 'Online', ''),
(423, 'Supervisory Skills Development', NULL, 'Corporate onboarding and skilling course in Supervisory Skills Development for Industrial & Manufacturing sector. Delivered in ILT mode with Practical evaluation.', 0, 209, '4.7', 81, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'ILT', 'Online', ''),
(424, 'Basic Security Training', NULL, 'Corporate onboarding and skilling course in Basic Security Training for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 214, '4.6', 25, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'ILT', 'Online', ''),
(425, 'Emergency Response & First Aid', NULL, 'Corporate onboarding and skilling course in Emergency Response & First Aid for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 229, '4.6', 31, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'ILT', 'Online', ''),
(426, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding and skilling course in Fire Safety & Evacuation Drill for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 276, '4.6', 39, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'ILT', 'Online', ''),
(427, 'Crowd Management Skills', NULL, 'Corporate onboarding and skilling course in Crowd Management Skills for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 128, '4.6', 51, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'ILT', 'Online', ''),
(428, 'Supervisory Security Officer Induction', NULL, 'Corporate onboarding and skilling course in Supervisory Security Officer Induction for Security & Allied Services sector. Delivered in ILT mode with Online evaluation.', 0, 201, '4.6', 44, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'ILT', 'Online', ''),
(429, 'POS Handling', NULL, 'Corporate onboarding and skilling course in POS Handling for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 197, '4.8', 77, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'SPL', 'Online', ''),
(430, 'Customer Communication Skills', NULL, 'Corporate onboarding and skilling course in Customer Communication Skills for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 133, '4.8', 80, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'SPL', 'Online', ''),
(431, 'Complaint Management', NULL, 'Corporate onboarding and skilling course in Complaint Management for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 126, '4.8', 56, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'SPL', 'Online', ''),
(432, 'Sales Etiquette', NULL, 'Corporate onboarding and skilling course in Sales Etiquette for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 168, '4.8', 80, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'SPL', 'Online', ''),
(433, 'Product Knowledge & Display', NULL, 'Corporate onboarding and skilling course in Product Knowledge & Display for Retail & Customer Care sector. Delivered in SPL mode with Online evaluation.', 0, 215, '4.8', 41, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'SPL', 'Online', ''),
(434, 'Material Handling Safety', NULL, 'Corporate onboarding and skilling course in Material Handling Safety for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 122, '4.7', 20, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'Hybrid', 'Online', 'Project'),
(435, 'Warehouse Operations', NULL, 'Corporate onboarding and skilling course in Warehouse Operations for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 122, '4.7', 32, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'Hybrid', 'Online', 'Project'),
(436, 'Maintenance Basics', NULL, 'Corporate onboarding and skilling course in Maintenance Basics for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 100, '4.7', 33, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'Hybrid', 'Online', 'Project'),
(437, 'Driver Induction Program', NULL, 'Corporate onboarding and skilling course in Driver Induction Program for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 202, '4.7', 51, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'Hybrid', 'Online', 'Project'),
(438, 'Fleet & Transport Management', NULL, 'Corporate onboarding and skilling course in Fleet & Transport Management for Facility & Logistics sector. Delivered in Hybrid mode with Project evaluation.', 0, 218, '4.7', 36, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215107, 'Hybrid', 'Online', 'Project'),
(439, 'Front Office Onboarding', NULL, 'Corporate onboarding training for Hospitality & Tourism: Front Office Onboarding, delivered in SPL mode with Project evaluation.', 0, 240, '4.9', 33, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'SPL', 'Online', 'Project'),
(440, 'Housekeeping Essentials', NULL, 'Corporate onboarding training for Hospitality & Tourism: Housekeeping Essentials, delivered in ILT mode with Project evaluation.', 0, 176, '4.7', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'ILT', 'Online', 'Project'),
(441, 'Food & Beverage Service', NULL, 'Corporate onboarding training for Hospitality & Tourism: Food & Beverage Service, delivered in Hybrid mode with Practical evaluation.', 0, 214, '4.8', 23, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'Hybrid', 'Online', ''),
(442, 'Hospitality Etiquette', NULL, 'Corporate onboarding training for Hospitality & Tourism: Hospitality Etiquette, delivered in Hybrid mode with Practical evaluation.', 0, 99, '4.9', 37, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'Hybrid', 'Online', ''),
(443, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding training for Hospitality & Tourism: Safety & Hygiene Induction, delivered in SPL mode with Project evaluation.', 0, 198, '4.7', 61, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'SPL', 'Online', 'Project'),
(444, 'Industrial Safety Induction', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Industrial Safety Induction, delivered in Hybrid mode with Online evaluation.', 0, 207, '4.3', 26, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'Hybrid', 'Online', ''),
(445, 'Machine Operations Basics', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Machine Operations Basics, delivered in SPL mode with Practical evaluation.', 0, 191, '4.4', 69, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'SPL', 'Online', ''),
(446, 'Electrical & Maintenance', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Electrical & Maintenance, delivered in ILT mode with Online evaluation.', 0, 146, '4.9', 39, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'ILT', 'Online', ''),
(447, 'Supervisory Skills Development', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Supervisory Skills Development, delivered in SPL mode with Project evaluation.', 0, 155, '4.4', 62, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'SPL', 'Online', 'Project');
INSERT INTO `lessons` (`id`, `name`, `course_code`, `info`, `duration`, `learners`, `rating`, `reviews`, `price`, `course_type`, `directions_ID`, `direction_id`, `sub_direction_id`, `academic_level`, `board`, `creator_LOGIN`, `instructor_id`, `institution_id`, `active`, `show_catalog`, `publish`, `verified`, `institution_verified`, `created`, `course_mode`, `delivery_type`, `assessment_type`) VALUES
(448, 'Basic Security Training', NULL, 'Corporate onboarding training for Security & Allied Services: Basic Security Training, delivered in Hybrid mode with Online evaluation.', 0, 178, '4.7', 29, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'Hybrid', 'Online', ''),
(449, 'Emergency Response & First Aid', NULL, 'Corporate onboarding training for Security & Allied Services: Emergency Response & First Aid, delivered in SPL mode with Project evaluation.', 0, 133, '4.5', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'SPL', 'Online', 'Project'),
(450, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding training for Security & Allied Services: Fire Safety & Evacuation Drill, delivered in Hybrid mode with Practical evaluation.', 0, 88, '4.6', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'Hybrid', 'Online', ''),
(451, 'Crowd Management Skills', NULL, 'Corporate onboarding training for Security & Allied Services: Crowd Management Skills, delivered in SPL mode with Project evaluation.', 0, 204, '4.7', 41, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'SPL', 'Online', 'Project'),
(452, 'POS Handling', NULL, 'Corporate onboarding training for Retail & Customer Care: POS Handling, delivered in Hybrid mode with Project evaluation.', 0, 189, '4.8', 44, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'Hybrid', 'Online', 'Project'),
(453, 'Customer Communication Skills', NULL, 'Corporate onboarding training for Retail & Customer Care: Customer Communication Skills, delivered in SPL mode with Project evaluation.', 0, 86, '4.8', 53, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'SPL', 'Online', 'Project'),
(454, 'Sales Etiquette', NULL, 'Corporate onboarding training for Retail & Customer Care: Sales Etiquette, delivered in SPL mode with Practical evaluation.', 0, 86, '4.7', 47, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'SPL', 'Online', ''),
(455, 'Complaint Management', NULL, 'Corporate onboarding training for Retail & Customer Care: Complaint Management, delivered in ILT mode with Online evaluation.', 0, 209, '4.8', 52, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'ILT', 'Online', ''),
(456, 'Material Handling Safety', NULL, 'Corporate onboarding training for Facility & Logistics: Material Handling Safety, delivered in ILT mode with Practical evaluation.', 0, 142, '4.5', 66, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'ILT', 'Online', ''),
(457, 'Warehouse Operations', NULL, 'Corporate onboarding training for Facility & Logistics: Warehouse Operations, delivered in SPL mode with Practical evaluation.', 0, 180, '4.6', 74, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'SPL', 'Online', ''),
(458, 'Driver Induction Program', NULL, 'Corporate onboarding training for Facility & Logistics: Driver Induction Program, delivered in Hybrid mode with Practical evaluation.', 0, 98, '4.4', 49, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'Hybrid', 'Online', ''),
(459, 'Fleet & Transport Management', NULL, 'Corporate onboarding training for Facility & Logistics: Fleet & Transport Management, delivered in ILT mode with Online evaluation.', 0, 130, '4.3', 43, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215203, 'ILT', 'Online', ''),
(460, 'Front Office Onboarding', NULL, 'Corporate onboarding training for Hospitality & Tourism: Front Office Onboarding, delivered in SPL mode with Online evaluation.', 0, 94, '4.9', 34, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'SPL', 'Online', ''),
(461, 'Housekeeping Essentials', NULL, 'Corporate onboarding training for Hospitality & Tourism: Housekeeping Essentials, delivered in ILT mode with Project evaluation.', 0, 239, '4.7', 30, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'ILT', 'Online', 'Project'),
(462, 'Food & Beverage Service', NULL, 'Corporate onboarding training for Hospitality & Tourism: Food & Beverage Service, delivered in ILT mode with Project evaluation.', 0, 220, '4.5', 59, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'ILT', 'Online', 'Project'),
(463, 'Hospitality Etiquette', NULL, 'Corporate onboarding training for Hospitality & Tourism: Hospitality Etiquette, delivered in ILT mode with Online evaluation.', 0, 182, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'ILT', 'Online', ''),
(464, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding training for Hospitality & Tourism: Safety & Hygiene Induction, delivered in SPL mode with Project evaluation.', 0, 170, '4.3', 78, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'SPL', 'Online', 'Project'),
(465, 'Industrial Safety Induction', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Industrial Safety Induction, delivered in Hybrid mode with Project evaluation.', 0, 200, '4.6', 44, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'Hybrid', 'Online', 'Project'),
(466, 'Machine Operations Basics', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Machine Operations Basics, delivered in Hybrid mode with Practical evaluation.', 0, 201, '4.6', 58, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'Hybrid', 'Online', ''),
(467, 'Electrical & Maintenance', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Electrical & Maintenance, delivered in SPL mode with Online evaluation.', 0, 90, '4.3', 47, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'SPL', 'Online', ''),
(468, 'Supervisory Skills Development', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Supervisory Skills Development, delivered in Hybrid mode with Practical evaluation.', 0, 244, '4.3', 17, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'Hybrid', 'Online', ''),
(469, 'Basic Security Training', NULL, 'Corporate onboarding training for Security & Allied Services: Basic Security Training, delivered in ILT mode with Project evaluation.', 0, 137, '4.7', 32, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'ILT', 'Online', 'Project'),
(470, 'Emergency Response & First Aid', NULL, 'Corporate onboarding training for Security & Allied Services: Emergency Response & First Aid, delivered in Hybrid mode with Project evaluation.', 0, 250, '4.5', 27, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'Hybrid', 'Online', 'Project'),
(471, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding training for Security & Allied Services: Fire Safety & Evacuation Drill, delivered in ILT mode with Project evaluation.', 0, 121, '4.5', 23, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'ILT', 'Online', 'Project'),
(472, 'Crowd Management Skills', NULL, 'Corporate onboarding training for Security & Allied Services: Crowd Management Skills, delivered in ILT mode with Practical evaluation.', 0, 127, '4.4', 60, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'ILT', 'Online', ''),
(473, 'POS Handling', NULL, 'Corporate onboarding training for Retail & Customer Care: POS Handling, delivered in SPL mode with Practical evaluation.', 0, 105, '4.9', 23, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'SPL', 'Online', ''),
(474, 'Customer Communication Skills', NULL, 'Corporate onboarding training for Retail & Customer Care: Customer Communication Skills, delivered in Hybrid mode with Project evaluation.', 0, 168, '4.3', 76, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'Hybrid', 'Online', 'Project'),
(475, 'Sales Etiquette', NULL, 'Corporate onboarding training for Retail & Customer Care: Sales Etiquette, delivered in ILT mode with Project evaluation.', 0, 107, '4.7', 69, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'ILT', 'Online', 'Project'),
(476, 'Complaint Management', NULL, 'Corporate onboarding training for Retail & Customer Care: Complaint Management, delivered in SPL mode with Online evaluation.', 0, 174, '4.5', 18, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'SPL', 'Online', ''),
(477, 'Material Handling Safety', NULL, 'Corporate onboarding training for Facility & Logistics: Material Handling Safety, delivered in Hybrid mode with Project evaluation.', 0, 220, '4.8', 21, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'Hybrid', 'Online', 'Project'),
(478, 'Warehouse Operations', NULL, 'Corporate onboarding training for Facility & Logistics: Warehouse Operations, delivered in SPL mode with Project evaluation.', 0, 95, '4.3', 65, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'SPL', 'Online', 'Project'),
(479, 'Driver Induction Program', NULL, 'Corporate onboarding training for Facility & Logistics: Driver Induction Program, delivered in SPL mode with Practical evaluation.', 0, 135, '4.3', 34, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'SPL', 'Online', ''),
(480, 'Fleet & Transport Management', NULL, 'Corporate onboarding training for Facility & Logistics: Fleet & Transport Management, delivered in Hybrid mode with Practical evaluation.', 0, 233, '4.3', 27, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215204, 'Hybrid', 'Online', ''),
(481, 'Front Office Onboarding', NULL, 'Corporate onboarding training for Hospitality & Tourism: Front Office Onboarding, delivered in Hybrid mode with Practical evaluation.', 0, 126, '4.9', 33, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'Hybrid', 'Online', ''),
(482, 'Housekeeping Essentials', NULL, 'Corporate onboarding training for Hospitality & Tourism: Housekeeping Essentials, delivered in ILT mode with Practical evaluation.', 0, 82, '4.6', 17, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'ILT', 'Online', ''),
(483, 'Food & Beverage Service', NULL, 'Corporate onboarding training for Hospitality & Tourism: Food & Beverage Service, delivered in Hybrid mode with Project evaluation.', 0, 174, '4.4', 59, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'Hybrid', 'Online', 'Project'),
(484, 'Hospitality Etiquette', NULL, 'Corporate onboarding training for Hospitality & Tourism: Hospitality Etiquette, delivered in Hybrid mode with Project evaluation.', 0, 211, '4.3', 44, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'Hybrid', 'Online', 'Project'),
(485, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding training for Hospitality & Tourism: Safety & Hygiene Induction, delivered in Hybrid mode with Project evaluation.', 0, 172, '4.3', 38, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'Hybrid', 'Online', 'Project'),
(486, 'Industrial Safety Induction', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Industrial Safety Induction, delivered in ILT mode with Practical evaluation.', 0, 195, '4.9', 52, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'ILT', 'Online', ''),
(487, 'Machine Operations Basics', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Machine Operations Basics, delivered in ILT mode with Online evaluation.', 0, 213, '4.3', 51, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'ILT', 'Online', ''),
(488, 'Electrical & Maintenance', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Electrical & Maintenance, delivered in SPL mode with Practical evaluation.', 0, 210, '4.9', 56, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'SPL', 'Online', ''),
(489, 'Supervisory Skills Development', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Supervisory Skills Development, delivered in Hybrid mode with Project evaluation.', 0, 94, '4.5', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'Hybrid', 'Online', 'Project'),
(490, 'Basic Security Training', NULL, 'Corporate onboarding training for Security & Allied Services: Basic Security Training, delivered in SPL mode with Project evaluation.', 0, 173, '4.5', 74, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'SPL', 'Online', 'Project'),
(491, 'Emergency Response & First Aid', NULL, 'Corporate onboarding training for Security & Allied Services: Emergency Response & First Aid, delivered in Hybrid mode with Practical evaluation.', 0, 198, '4.8', 39, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'Hybrid', 'Online', ''),
(492, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding training for Security & Allied Services: Fire Safety & Evacuation Drill, delivered in Hybrid mode with Project evaluation.', 0, 101, '4.5', 61, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'Hybrid', 'Online', 'Project'),
(493, 'Crowd Management Skills', NULL, 'Corporate onboarding training for Security & Allied Services: Crowd Management Skills, delivered in ILT mode with Online evaluation.', 0, 190, '4.9', 29, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'ILT', 'Online', ''),
(494, 'POS Handling', NULL, 'Corporate onboarding training for Retail & Customer Care: POS Handling, delivered in ILT mode with Project evaluation.', 0, 250, '4.5', 40, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'ILT', 'Online', 'Project'),
(495, 'Customer Communication Skills', NULL, 'Corporate onboarding training for Retail & Customer Care: Customer Communication Skills, delivered in Hybrid mode with Practical evaluation.', 0, 184, '4.6', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'Hybrid', 'Online', ''),
(496, 'Sales Etiquette', NULL, 'Corporate onboarding training for Retail & Customer Care: Sales Etiquette, delivered in SPL mode with Practical evaluation.', 0, 116, '4.4', 63, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'SPL', 'Online', ''),
(497, 'Complaint Management', NULL, 'Corporate onboarding training for Retail & Customer Care: Complaint Management, delivered in SPL mode with Practical evaluation.', 0, 204, '4.5', 80, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'SPL', 'Online', ''),
(498, 'Material Handling Safety', NULL, 'Corporate onboarding training for Facility & Logistics: Material Handling Safety, delivered in Hybrid mode with Online evaluation.', 0, 139, '4.5', 28, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'Hybrid', 'Online', ''),
(499, 'Warehouse Operations', NULL, 'Corporate onboarding training for Facility & Logistics: Warehouse Operations, delivered in Hybrid mode with Practical evaluation.', 0, 121, '4.9', 38, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'Hybrid', 'Online', ''),
(500, 'Driver Induction Program', NULL, 'Corporate onboarding training for Facility & Logistics: Driver Induction Program, delivered in SPL mode with Practical evaluation.', 0, 239, '4.5', 74, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'SPL', 'Online', ''),
(501, 'Fleet & Transport Management', NULL, 'Corporate onboarding training for Facility & Logistics: Fleet & Transport Management, delivered in Hybrid mode with Practical evaluation.', 0, 198, '4.3', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215205, 'Hybrid', 'Online', ''),
(502, 'Front Office Onboarding', NULL, 'Corporate onboarding training for Hospitality & Tourism: Front Office Onboarding, delivered in Hybrid mode with Project evaluation.', 0, 137, '4.9', 57, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'Hybrid', 'Online', 'Project'),
(503, 'Housekeeping Essentials', NULL, 'Corporate onboarding training for Hospitality & Tourism: Housekeeping Essentials, delivered in SPL mode with Practical evaluation.', 0, 106, '4.8', 65, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'SPL', 'Online', ''),
(504, 'Food & Beverage Service', NULL, 'Corporate onboarding training for Hospitality & Tourism: Food & Beverage Service, delivered in ILT mode with Project evaluation.', 0, 82, '4.3', 75, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'ILT', 'Online', 'Project'),
(505, 'Hospitality Etiquette', NULL, 'Corporate onboarding training for Hospitality & Tourism: Hospitality Etiquette, delivered in Hybrid mode with Project evaluation.', 0, 226, '4.7', 48, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'Hybrid', 'Online', 'Project'),
(506, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding training for Hospitality & Tourism: Safety & Hygiene Induction, delivered in SPL mode with Practical evaluation.', 0, 167, '4.4', 76, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'SPL', 'Online', ''),
(507, 'Industrial Safety Induction', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Industrial Safety Induction, delivered in SPL mode with Project evaluation.', 0, 93, '4.7', 29, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'SPL', 'Online', 'Project'),
(508, 'Machine Operations Basics', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Machine Operations Basics, delivered in Hybrid mode with Online evaluation.', 0, 242, '4.7', 43, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'Hybrid', 'Online', ''),
(509, 'Electrical & Maintenance', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Electrical & Maintenance, delivered in SPL mode with Project evaluation.', 0, 114, '4.4', 45, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'SPL', 'Online', 'Project'),
(510, 'Supervisory Skills Development', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Supervisory Skills Development, delivered in ILT mode with Practical evaluation.', 0, 130, '4.5', 25, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'ILT', 'Online', ''),
(511, 'Basic Security Training', NULL, 'Corporate onboarding training for Security & Allied Services: Basic Security Training, delivered in ILT mode with Online evaluation.', 0, 216, '4.3', 60, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'ILT', 'Online', ''),
(512, 'Emergency Response & First Aid', NULL, 'Corporate onboarding training for Security & Allied Services: Emergency Response & First Aid, delivered in Hybrid mode with Project evaluation.', 0, 125, '4.9', 53, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'Hybrid', 'Online', 'Project'),
(513, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding training for Security & Allied Services: Fire Safety & Evacuation Drill, delivered in Hybrid mode with Project evaluation.', 0, 134, '4.6', 41, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'Hybrid', 'Online', 'Project'),
(514, 'Crowd Management Skills', NULL, 'Corporate onboarding training for Security & Allied Services: Crowd Management Skills, delivered in Hybrid mode with Practical evaluation.', 0, 132, '4.4', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'Hybrid', 'Online', ''),
(515, 'POS Handling', NULL, 'Corporate onboarding training for Retail & Customer Care: POS Handling, delivered in Hybrid mode with Project evaluation.', 0, 222, '4.9', 70, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215249, 'Hybrid', 'Online', 'Project'),
(516, 'Customer Communication Skills', NULL, 'Corporate onboarding training for Retail & Customer Care: Customer Communication Skills, delivered in Hybrid mode with Online evaluation.', 0, 133, '4.9', 18, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215250, 'Hybrid', 'Online', ''),
(517, 'Sales Etiquette', NULL, 'Corporate onboarding training for Retail & Customer Care: Sales Etiquette, delivered in Hybrid mode with Practical evaluation.', 0, 184, '4.9', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215250, 'Hybrid', 'Online', ''),
(518, 'Complaint Management', NULL, 'Corporate onboarding training for Retail & Customer Care: Complaint Management, delivered in SPL mode with Online evaluation.', 0, 233, '4.9', 47, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215250, 'SPL', 'Online', ''),
(519, 'Material Handling Safety', NULL, 'Corporate onboarding training for Facility & Logistics: Material Handling Safety, delivered in Hybrid mode with Practical evaluation.', 0, 125, '4.5', 26, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215250, 'Hybrid', 'Online', ''),
(520, 'Warehouse Operations', NULL, 'Corporate onboarding training for Facility & Logistics: Warehouse Operations, delivered in ILT mode with Practical evaluation.', 0, 86, '4.9', 67, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215250, 'ILT', 'Online', ''),
(521, 'Driver Induction Program', NULL, 'Corporate onboarding training for Facility & Logistics: Driver Induction Program, delivered in ILT mode with Project evaluation.', 0, 87, '4.8', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215250, 'ILT', 'Online', 'Project'),
(522, 'Fleet & Transport Management', NULL, 'Corporate onboarding training for Facility & Logistics: Fleet & Transport Management, delivered in Hybrid mode with Project evaluation.', 0, 99, '4.7', 32, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215250, 'Hybrid', 'Online', 'Project'),
(523, 'Front Office Onboarding', NULL, 'Corporate onboarding training for Hospitality & Tourism: Front Office Onboarding, delivered in SPL mode with Project evaluation.', 0, 189, '4.9', 16, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'SPL', 'Online', 'Project'),
(524, 'Housekeeping Essentials', NULL, 'Corporate onboarding training for Hospitality & Tourism: Housekeeping Essentials, delivered in SPL mode with Practical evaluation.', 0, 102, '4.5', 59, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'SPL', 'Online', ''),
(525, 'Food & Beverage Service', NULL, 'Corporate onboarding training for Hospitality & Tourism: Food & Beverage Service, delivered in SPL mode with Project evaluation.', 0, 231, '4.4', 25, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'SPL', 'Online', 'Project'),
(526, 'Hospitality Etiquette', NULL, 'Corporate onboarding training for Hospitality & Tourism: Hospitality Etiquette, delivered in Hybrid mode with Project evaluation.', 0, 143, '4.4', 23, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'Hybrid', 'Online', 'Project'),
(527, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding training for Hospitality & Tourism: Safety & Hygiene Induction, delivered in SPL mode with Project evaluation.', 0, 226, '4.5', 30, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'SPL', 'Online', 'Project'),
(528, 'Industrial Safety Induction', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Industrial Safety Induction, delivered in Hybrid mode with Online evaluation.', 0, 241, '4.5', 26, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'Hybrid', 'Online', ''),
(529, 'Machine Operations Basics', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Machine Operations Basics, delivered in Hybrid mode with Project evaluation.', 0, 198, '4.4', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'Hybrid', 'Online', 'Project'),
(530, 'Electrical & Maintenance', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Electrical & Maintenance, delivered in Hybrid mode with Practical evaluation.', 0, 226, '4.3', 55, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'Hybrid', 'Online', ''),
(531, 'Supervisory Skills Development', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Supervisory Skills Development, delivered in Hybrid mode with Online evaluation.', 0, 226, '4.9', 30, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'Hybrid', 'Online', ''),
(532, 'Basic Security Training', NULL, 'Corporate onboarding training for Security & Allied Services: Basic Security Training, delivered in Hybrid mode with Practical evaluation.', 0, 192, '4.8', 23, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'Hybrid', 'Online', ''),
(533, 'Emergency Response & First Aid', NULL, 'Corporate onboarding training for Security & Allied Services: Emergency Response & First Aid, delivered in Hybrid mode with Practical evaluation.', 0, 154, '4.5', 32, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'Hybrid', 'Online', ''),
(534, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding training for Security & Allied Services: Fire Safety & Evacuation Drill, delivered in ILT mode with Online evaluation.', 0, 148, '4.8', 26, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'ILT', 'Online', ''),
(535, 'Crowd Management Skills', NULL, 'Corporate onboarding training for Security & Allied Services: Crowd Management Skills, delivered in SPL mode with Project evaluation.', 0, 236, '4.8', 26, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'SPL', 'Online', 'Project'),
(536, 'POS Handling', NULL, 'Corporate onboarding training for Retail & Customer Care: POS Handling, delivered in ILT mode with Practical evaluation.', 0, 112, '4.5', 18, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'ILT', 'Online', ''),
(537, 'Customer Communication Skills', NULL, 'Corporate onboarding training for Retail & Customer Care: Customer Communication Skills, delivered in SPL mode with Practical evaluation.', 0, 192, '4.3', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'SPL', 'Online', ''),
(538, 'Sales Etiquette', NULL, 'Corporate onboarding training for Retail & Customer Care: Sales Etiquette, delivered in Hybrid mode with Project evaluation.', 0, 158, '4.8', 65, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'Hybrid', 'Online', 'Project'),
(539, 'Complaint Management', NULL, 'Corporate onboarding training for Retail & Customer Care: Complaint Management, delivered in SPL mode with Project evaluation.', 0, 82, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'SPL', 'Online', 'Project'),
(540, 'Material Handling Safety', NULL, 'Corporate onboarding training for Facility & Logistics: Material Handling Safety, delivered in SPL mode with Practical evaluation.', 0, 222, '4.9', 21, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'SPL', 'Online', ''),
(541, 'Warehouse Operations', NULL, 'Corporate onboarding training for Facility & Logistics: Warehouse Operations, delivered in ILT mode with Practical evaluation.', 0, 111, '4.3', 48, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'ILT', 'Online', ''),
(542, 'Driver Induction Program', NULL, 'Corporate onboarding training for Facility & Logistics: Driver Induction Program, delivered in SPL mode with Online evaluation.', 0, 98, '4.3', 76, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'SPL', 'Online', ''),
(543, 'Fleet & Transport Management', NULL, 'Corporate onboarding training for Facility & Logistics: Fleet & Transport Management, delivered in SPL mode with Project evaluation.', 0, 82, '4.6', 41, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215789, 'SPL', 'Online', 'Project'),
(544, 'Front Office Onboarding', NULL, 'Corporate onboarding training for Hospitality & Tourism: Front Office Onboarding, delivered in SPL mode with Practical evaluation.', 0, 175, '4.3', 42, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'SPL', 'Online', ''),
(545, 'Housekeeping Essentials', NULL, 'Corporate onboarding training for Hospitality & Tourism: Housekeeping Essentials, delivered in Hybrid mode with Practical evaluation.', 0, 240, '4.4', 52, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', ''),
(546, 'Food & Beverage Service', NULL, 'Corporate onboarding training for Hospitality & Tourism: Food & Beverage Service, delivered in Hybrid mode with Project evaluation.', 0, 84, '4.5', 39, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', 'Project'),
(547, 'Hospitality Etiquette', NULL, 'Corporate onboarding training for Hospitality & Tourism: Hospitality Etiquette, delivered in SPL mode with Online evaluation.', 0, 96, '4.6', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'SPL', 'Online', ''),
(548, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding training for Hospitality & Tourism: Safety & Hygiene Induction, delivered in SPL mode with Practical evaluation.', 0, 233, '4.9', 64, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'SPL', 'Online', ''),
(549, 'Industrial Safety Induction', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Industrial Safety Induction, delivered in ILT mode with Project evaluation.', 0, 106, '4.8', 63, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'ILT', 'Online', 'Project'),
(550, 'Machine Operations Basics', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Machine Operations Basics, delivered in Hybrid mode with Project evaluation.', 0, 211, '4.5', 36, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', 'Project'),
(551, 'Electrical & Maintenance', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Electrical & Maintenance, delivered in ILT mode with Online evaluation.', 0, 153, '4.3', 42, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'ILT', 'Online', ''),
(552, 'Supervisory Skills Development', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Supervisory Skills Development, delivered in Hybrid mode with Practical evaluation.', 0, 124, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', ''),
(553, 'Basic Security Training', NULL, 'Corporate onboarding training for Security & Allied Services: Basic Security Training, delivered in Hybrid mode with Project evaluation.', 0, 219, '4.5', 69, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', 'Project'),
(554, 'Emergency Response & First Aid', NULL, 'Corporate onboarding training for Security & Allied Services: Emergency Response & First Aid, delivered in SPL mode with Project evaluation.', 0, 125, '4.5', 71, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'SPL', 'Online', 'Project'),
(555, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding training for Security & Allied Services: Fire Safety & Evacuation Drill, delivered in Hybrid mode with Project evaluation.', 0, 133, '4.6', 21, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', 'Project'),
(556, 'Crowd Management Skills', NULL, 'Corporate onboarding training for Security & Allied Services: Crowd Management Skills, delivered in SPL mode with Practical evaluation.', 0, 233, '4.7', 22, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'SPL', 'Online', ''),
(557, 'POS Handling', NULL, 'Corporate onboarding training for Retail & Customer Care: POS Handling, delivered in Hybrid mode with Project evaluation.', 0, 130, '4.5', 79, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', 'Project'),
(558, 'Customer Communication Skills', NULL, 'Corporate onboarding training for Retail & Customer Care: Customer Communication Skills, delivered in Hybrid mode with Practical evaluation.', 0, 178, '4.4', 75, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', ''),
(559, 'Sales Etiquette', NULL, 'Corporate onboarding training for Retail & Customer Care: Sales Etiquette, delivered in Hybrid mode with Practical evaluation.', 0, 82, '4.4', 65, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', ''),
(560, 'Complaint Management', NULL, 'Corporate onboarding training for Retail & Customer Care: Complaint Management, delivered in Hybrid mode with Practical evaluation.', 0, 132, '4.6', 24, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', ''),
(561, 'Material Handling Safety', NULL, 'Corporate onboarding training for Facility & Logistics: Material Handling Safety, delivered in Hybrid mode with Practical evaluation.', 0, 185, '4.8', 72, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', ''),
(562, 'Warehouse Operations', NULL, 'Corporate onboarding training for Facility & Logistics: Warehouse Operations, delivered in Hybrid mode with Practical evaluation.', 0, 220, '4.8', 28, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'Hybrid', 'Online', ''),
(563, 'Driver Induction Program', NULL, 'Corporate onboarding training for Facility & Logistics: Driver Induction Program, delivered in ILT mode with Project evaluation.', 0, 228, '4.4', 19, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'ILT', 'Online', 'Project'),
(564, 'Fleet & Transport Management', NULL, 'Corporate onboarding training for Facility & Logistics: Fleet & Transport Management, delivered in SPL mode with Online evaluation.', 0, 126, '4.8', 46, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761215842, 'SPL', 'Online', ''),
(565, 'Front Office Onboarding', NULL, 'Corporate onboarding training for Hospitality & Tourism: Front Office Onboarding, delivered in SPL mode with Project evaluation.', 0, 97, '4.7', 62, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217291, 'SPL', 'Online', 'Project'),
(566, 'Housekeeping Essentials', NULL, 'Corporate onboarding training for Hospitality & Tourism: Housekeeping Essentials, delivered in SPL mode with Project evaluation.', 0, 154, '4.4', 27, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'SPL', 'Online', 'Project'),
(567, 'Food & Beverage Service', NULL, 'Corporate onboarding training for Hospitality & Tourism: Food & Beverage Service, delivered in Hybrid mode with Practical evaluation.', 0, 166, '4.9', 34, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'Hybrid', 'Online', ''),
(568, 'Hospitality Etiquette', NULL, 'Corporate onboarding training for Hospitality & Tourism: Hospitality Etiquette, delivered in Hybrid mode with Online evaluation.', 0, 240, '4.9', 16, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'Hybrid', 'Online', ''),
(569, 'Safety & Hygiene Induction', NULL, 'Corporate onboarding training for Hospitality & Tourism: Safety & Hygiene Induction, delivered in Hybrid mode with Online evaluation.', 0, 162, '4.7', 54, '0.00', 'Paid', NULL, NULL, NULL, '', 'Hospitality & Tourism', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'Hybrid', 'Online', ''),
(570, 'Industrial Safety Induction', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Industrial Safety Induction, delivered in ILT mode with Online evaluation.', 0, 239, '4.8', 15, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'ILT', 'Online', ''),
(571, 'Machine Operations Basics', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Machine Operations Basics, delivered in SPL mode with Practical evaluation.', 0, 113, '4.3', 79, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'SPL', 'Online', ''),
(572, 'Electrical & Maintenance', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Electrical & Maintenance, delivered in SPL mode with Project evaluation.', 0, 105, '4.9', 66, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'SPL', 'Online', 'Project'),
(573, 'Supervisory Skills Development', NULL, 'Corporate onboarding training for Industrial & Manufacturing: Supervisory Skills Development, delivered in SPL mode with Practical evaluation.', 0, 247, '4.8', 43, '0.00', 'Paid', NULL, NULL, NULL, '', 'Industrial & Manufacturing', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'SPL', 'Online', ''),
(574, 'Basic Security Training', NULL, 'Corporate onboarding training for Security & Allied Services: Basic Security Training, delivered in Hybrid mode with Project evaluation.', 0, 136, '4.4', 26, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'Hybrid', 'Online', 'Project'),
(575, 'Emergency Response & First Aid', NULL, 'Corporate onboarding training for Security & Allied Services: Emergency Response & First Aid, delivered in SPL mode with Practical evaluation.', 0, 108, '4.5', 50, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'SPL', 'Online', ''),
(576, 'Fire Safety & Evacuation Drill', NULL, 'Corporate onboarding training for Security & Allied Services: Fire Safety & Evacuation Drill, delivered in ILT mode with Project evaluation.', 0, 185, '4.4', 70, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'ILT', 'Online', 'Project'),
(577, 'Crowd Management Skills', NULL, 'Corporate onboarding training for Security & Allied Services: Crowd Management Skills, delivered in SPL mode with Project evaluation.', 0, 95, '4.7', 59, '0.00', 'Paid', NULL, NULL, NULL, '', 'Security & Allied Services', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'SPL', 'Online', 'Project'),
(578, 'POS Handling', NULL, 'Corporate onboarding training for Retail & Customer Care: POS Handling, delivered in Hybrid mode with Project evaluation.', 0, 224, '4.4', 34, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'Hybrid', 'Online', 'Project'),
(579, 'Customer Communication Skills', NULL, 'Corporate onboarding training for Retail & Customer Care: Customer Communication Skills, delivered in SPL mode with Project evaluation.', 0, 194, '4.9', 27, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'SPL', 'Online', 'Project'),
(580, 'Sales Etiquette', NULL, 'Corporate onboarding training for Retail & Customer Care: Sales Etiquette, delivered in Hybrid mode with Project evaluation.', 0, 104, '4.8', 60, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'Hybrid', 'Online', 'Project'),
(581, 'Complaint Management', NULL, 'Corporate onboarding training for Retail & Customer Care: Complaint Management, delivered in ILT mode with Project evaluation.', 0, 147, '4.5', 73, '0.00', 'Paid', NULL, NULL, NULL, '', 'Retail & Customer Care', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'ILT', 'Online', 'Project'),
(582, 'Material Handling Safety', NULL, 'Corporate onboarding training for Facility & Logistics: Material Handling Safety, delivered in SPL mode with Practical evaluation.', 0, 94, '4.3', 19, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'SPL', 'Online', ''),
(583, 'Warehouse Operations', NULL, 'Corporate onboarding training for Facility & Logistics: Warehouse Operations, delivered in SPL mode with Project evaluation.', 0, 109, '4.3', 42, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'SPL', 'Online', 'Project'),
(584, 'Driver Induction Program', NULL, 'Corporate onboarding training for Facility & Logistics: Driver Induction Program, delivered in ILT mode with Practical evaluation.', 0, 240, '4.9', 41, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'ILT', 'Online', ''),
(585, 'Fleet & Transport Management', NULL, 'Corporate onboarding training for Facility & Logistics: Fleet & Transport Management, delivered in Hybrid mode with Project evaluation.', 0, 218, '4.8', 43, '0.00', 'Paid', NULL, NULL, NULL, '', 'Facility & Logistics', NULL, NULL, NULL, 1, 1, 1, 0, 0, 1761217292, 'Hybrid', 'Online', 'Project');

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
 ADD PRIMARY KEY (`id`), ADD KEY `idx_directions_parent` (`parent_direction_ID`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `instructor_profiles`
--
ALTER TABLE `instructor_profiles`
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=586;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
