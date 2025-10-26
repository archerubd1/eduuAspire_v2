-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 26, 2025 at 07:47 AM
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `module_id`, `topic_title`, `topic_description`, `topic_order`, `created`) VALUES
(1, 1, '1', '32132', 1, 1761419187),
(2, 1, '2', '32132', 2, 1761419187),
(3, 2, '423', '434324324', 1, 1761450905),
(4, 2, '423', '434324324', 2, 1761450905),
(5, 3, '423', '434324324', 1, 1761450947),
(6, 3, '423', '434324324', 2, 1761450947),
(7, 4, '423', '434324324', 1, 1761450963),
(8, 4, '423', '434324324', 2, 1761450963),
(9, 5, '423', '434324324', 1, 1761451576),
(10, 5, '423', '434324324', 2, 1761451576),
(11, 6, '32131', '321312312', 1, 1761452611),
(12, 6, '32131232', '321312312', 2, 1761452611),
(13, 7, '1', '2132', 1, 1761459463),
(14, 7, '2', '2132', 2, 1761459463);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `course_marketplace`
--

INSERT INTO `course_marketplace` (`id`, `lesson_id`, `subtitle`, `price`, `discount_price`, `rating_avg`, `total_reviews`, `enrollments_count`, `badge`, `featured`, `image`, `is_active`) VALUES
(1, 1, 'fd', '23.00', '321.00', '4.5', 0, 0, 'Featured', 'No', 'uploads/courses/1761419187_person-m-4.webp', 1),
(2, 0, 'rewrwer', '432.00', '432.00', '4.5', 0, 0, 'New', 'No', NULL, 1),
(3, 0, 'rewrwer', '432.00', '432.00', '4.5', 0, 0, 'New', 'No', NULL, 1),
(4, 0, 'rewrwer', '432.00', '432.00', '4.5', 0, 0, 'New', 'No', NULL, 1),
(5, 2, 'rewrwer', '432.00', '432.00', '4.5', 0, 0, 'New', 'No', '', 1),
(6, 3, 'ddsdds', '1234.00', '123.00', '4.5', 0, 0, 'New', 'No', 'uploads/courses/1761452611_avatar-female.png', 1),
(7, 4, 'fdsfdf', '324.00', '342.00', '4.5', 0, 0, 'Popular', 'No', 'uploads/courses/1761459463_person-f-3.webp', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `course_metadata`
--

INSERT INTO `course_metadata` (`id`, `course_id`, `overview`, `modules`, `skills`, `objectives`, `audience`, `brochure_path`, `brochure_type`) VALUES
(1, 1, 'fffd', NULL, 'fddsfdsf', 'fdsdsfds', 'dfdfdsfdsf', NULL, ''),
(2, 0, '434324324234324', NULL, '3243243243', '432432432432', '3432432432', NULL, ''),
(3, 0, '434324324234324', NULL, '3243243243', '432432432432', '3432432432', NULL, ''),
(4, 0, '434324324234324', NULL, '3243243243', '432432432432', '3432432432', NULL, ''),
(5, 2, '434324324234324', NULL, '3243243243', '432432432432', '3432432432', '', ''),
(6, 3, '3212323', NULL, '2323123213', '2323123123', '12312312312', '', ''),
(7, 4, 'ssdssd', NULL, 'sadsad', 'dsadasd', 'dasds', '', '');

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
  `direction_type` enum('Category','Subcategory') COLLATE utf8mb4_unicode_ci DEFAULT 'Category',
  `academic_level` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'K12',
  `parent_direction_ID` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `featured` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=65 ;

--
-- Dumping data for table `directions`
--

INSERT INTO `directions` (`id`, `name`, `direction_type`, `academic_level`, `parent_direction_ID`, `description`, `featured`, `active`, `created_at`) VALUES
(1, 'Academia', 'Category', '', NULL, 'for Academic B2C Marketplace Courses ', 1, 1, '2025-10-25 04:59:53'),
(2, 'K12', 'Subcategory', 'K12', 1, 'For CBSE, ICSE, Goa Board, Class V - X ', 1, 1, '2025-10-25 05:01:43'),
(3, 'CBSE', 'Subcategory', 'K12', 2, 'Academia B2C Marketplace Courses aligned to CBSE Board', 1, 1, '2025-10-25 14:05:02'),
(4, 'ICSE', 'Subcategory', 'K12', 2, 'Academia B2C MArketplace courses for ICSE Board', 1, 1, '2025-10-25 14:06:20'),
(5, 'Goa Board', 'Subcategory', 'K12', 2, 'Academia B2C Marketplace Goa Board Courses', 1, 1, '2025-10-25 14:13:19'),
(6, 'Class V', 'Subcategory', 'K12', 3, 'CBSE Class V', 1, 1, '2025-10-25 14:32:06'),
(7, 'Class VI', 'Subcategory', 'K12', 3, 'CBSE Class VI', 1, 1, '2025-10-25 14:32:06'),
(8, 'Class VII', 'Subcategory', 'K12', 3, 'CBSE Class VII', 1, 1, '2025-10-25 14:32:06'),
(9, 'Class VIII', 'Subcategory', 'K12', 3, 'CBSE Class VIII', 1, 1, '2025-10-25 14:32:06'),
(10, 'Class IX', 'Subcategory', 'K12', 3, 'CBSE Class IX', 1, 1, '2025-10-25 14:32:06'),
(11, 'Class X', 'Subcategory', 'K12', 3, 'CBSE Class X', 1, 1, '2025-10-25 14:32:06'),
(12, 'Class V', 'Subcategory', 'K12', 4, 'ICSE Class V', 1, 1, '2025-10-25 14:32:06'),
(13, 'Class VI', 'Subcategory', 'K12', 4, 'ICSE Class VI', 1, 1, '2025-10-25 14:32:06'),
(14, 'Class VII', 'Subcategory', 'K12', 4, 'ICSE Class VII', 1, 1, '2025-10-25 14:32:06'),
(15, 'Class VIII', 'Subcategory', 'K12', 4, 'ICSE Class VIII', 1, 1, '2025-10-25 14:32:06'),
(16, 'Class IX', 'Subcategory', 'K12', 4, 'ICSE Class IX', 1, 1, '2025-10-25 14:32:06'),
(17, 'Class X', 'Subcategory', 'K12', 4, 'ICSE Class X', 1, 1, '2025-10-25 14:32:06'),
(18, 'Class V', 'Subcategory', 'K12', 5, 'Goa Board Class V', 1, 1, '2025-10-25 14:32:06'),
(19, 'Class VI', 'Subcategory', 'K12', 5, 'Goa Board Class VI', 1, 1, '2025-10-25 14:32:06'),
(20, 'Class VII', 'Subcategory', 'K12', 5, 'Goa Board Class VII', 1, 1, '2025-10-25 14:32:06'),
(21, 'Class VIII', 'Subcategory', 'K12', 5, 'Goa Board Class VIII', 1, 1, '2025-10-25 14:32:06'),
(22, 'Class IX', 'Subcategory', 'K12', 5, 'Goa Board Class IX', 1, 1, '2025-10-25 14:32:06'),
(23, 'Class X', 'Subcategory', 'K12', 5, 'Goa Board Class X', 1, 1, '2025-10-25 14:32:06'),
(24, 'PUC', 'Subcategory', 'PUC', 1, 'PUC (11th & 12th) under Academia', 1, 1, '2025-10-25 14:38:32'),
(25, 'CBSE', 'Subcategory', 'PUC', 24, 'CBSE for PUC (Class XI & XII)', 1, 1, '2025-10-25 14:38:33'),
(26, 'ICSE', 'Subcategory', 'PUC', 24, 'ICSE for PUC (Class XI & XII)', 1, 1, '2025-10-25 14:38:33'),
(27, 'State PUC', 'Subcategory', 'PUC', 24, 'State PUC (local board) for XI & XII', 1, 1, '2025-10-25 14:38:33'),
(28, 'Class XI', 'Subcategory', 'PUC', 25, 'CBSE PUC - Class XI', 1, 1, '2025-10-25 14:38:33'),
(29, 'Class XII', 'Subcategory', 'PUC', 25, 'CBSE PUC - Class XII', 1, 1, '2025-10-25 14:38:33'),
(30, 'Class XI', 'Subcategory', 'PUC', 26, 'ICSE PUC - Class XI', 1, 1, '2025-10-25 14:38:33'),
(31, 'Class XII', 'Subcategory', 'PUC', 26, 'ICSE PUC - Class XII', 1, 1, '2025-10-25 14:38:33'),
(32, 'Class XI', 'Subcategory', 'PUC', 27, 'State PUC - Class XI', 1, 1, '2025-10-25 14:38:33'),
(33, 'Class XII', 'Subcategory', 'PUC', 27, 'State PUC - Class XII', 1, 1, '2025-10-25 14:38:33'),
(49, 'BA', 'Subcategory', 'UG', 44, 'Bachelor of Arts', 1, 1, '2025-10-25 15:17:01'),
(48, 'BBA', 'Subcategory', 'UG', 44, 'Bachelor of Business Administration', 1, 1, '2025-10-25 15:17:01'),
(47, 'BCom', 'Subcategory', 'UG', 44, 'Bachelor of Commerce', 1, 1, '2025-10-25 15:17:01'),
(44, 'UG', 'Subcategory', 'UG', 1, 'Undergraduate Degree Programs (BCA, BSc, BCom, BBA, BA)', 1, 1, '2025-10-25 15:17:01'),
(45, 'BCA', 'Subcategory', 'UG', 44, 'Bachelor of Computer Applications', 1, 1, '2025-10-25 15:17:01'),
(46, 'BSc', 'Subcategory', 'UG', 44, 'Bachelor of Science', 1, 1, '2025-10-25 15:17:01'),
(50, '1st Year', 'Subcategory', 'UG', 49, 'BA - 1st Year', 1, 1, '2025-10-25 15:17:01'),
(51, '1st Year', 'Subcategory', 'UG', 48, 'BBA - 1st Year', 1, 1, '2025-10-25 15:17:01'),
(52, '1st Year', 'Subcategory', 'UG', 47, 'BCom - 1st Year', 1, 1, '2025-10-25 15:17:01'),
(53, '1st Year', 'Subcategory', 'UG', 45, 'BCA - 1st Year', 1, 1, '2025-10-25 15:17:01'),
(54, '1st Year', 'Subcategory', 'UG', 46, 'BSc - 1st Year', 1, 1, '2025-10-25 15:17:01'),
(55, '2nd Year', 'Subcategory', 'UG', 49, 'BA - 2nd Year', 1, 1, '2025-10-25 15:17:01'),
(56, '2nd Year', 'Subcategory', 'UG', 48, 'BBA - 2nd Year', 1, 1, '2025-10-25 15:17:01'),
(57, '2nd Year', 'Subcategory', 'UG', 47, 'BCom - 2nd Year', 1, 1, '2025-10-25 15:17:01'),
(58, '2nd Year', 'Subcategory', 'UG', 45, 'BCA - 2nd Year', 1, 1, '2025-10-25 15:17:01'),
(59, '2nd Year', 'Subcategory', 'UG', 46, 'BSc - 2nd Year', 1, 1, '2025-10-25 15:17:01'),
(60, '3rd Year', 'Subcategory', 'UG', 49, 'BA - 3rd Year', 1, 1, '2025-10-25 15:17:01'),
(61, '3rd Year', 'Subcategory', 'UG', 48, 'BBA - 3rd Year', 1, 1, '2025-10-25 15:17:01'),
(62, '3rd Year', 'Subcategory', 'UG', 47, 'BCom - 3rd Year', 1, 1, '2025-10-25 15:17:01'),
(63, '3rd Year', 'Subcategory', 'UG', 45, 'BCA - 3rd Year', 1, 1, '2025-10-25 15:17:01'),
(64, '3rd Year', 'Subcategory', 'UG', 46, 'BSc - 3rd Year', 1, 1, '2025-10-25 15:17:01');

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
  `user_login` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'assets/img/person/default-avatar.webp',
  `specialty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` float DEFAULT '4.5',
  `total_reviews` int(11) DEFAULT '0',
  `total_students` int(11) DEFAULT '0',
  `active_courses` int(11) DEFAULT '0',
  `verified` tinyint(1) DEFAULT '0',
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `user_login`, `first_name`, `last_name`, `avatar`, `specialty`, `rating`, `total_reviews`, `total_students`, `active_courses`, `verified`, `status`, `last_login`, `created_at`, `updated_at`, `last_updated`, `email`, `mobile`) VALUES
(1, 'professor', 'uday', 'deshpande', 'uploads/instructors/avatar_68fb83892559f0.65327740.png', 'lisas lust', 4.5, 0, 0, 0, 1, 'active', NULL, '2025-10-24 13:47:54', '2025-10-25 04:09:05', '2025-10-25 04:09:05', 'archerubd@gmail.com', '+917411275974');

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
(1, 1, 'lick lisa', 4, 'erw', 'rewrewrewrewre', 'https://dsadssdsdsds', 'https://ddfdfdfdfdf', 'https://fdfdfdfdsfd', 'rerewrewrew', 'Conclave', 'eefddhttps://', 'https://dsadssdsdsds');

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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) DEFAULT '0',
  `learners` int(11) DEFAULT '0',
  `rating` decimal(2,1) DEFAULT '4.5',
  `reviews` int(11) DEFAULT '0',
  `price` decimal(10,2) DEFAULT '0.00',
  `course_type` enum('Free','Paid','Subscription') COLLATE utf8mb4_unicode_ci DEFAULT 'Paid',
  `direction_id` int(11) DEFAULT NULL,
  `sub_direction_id` int(11) DEFAULT NULL,
  `class_direction_id` int(11) DEFAULT NULL,
  `board` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_LOGIN` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `active` tinyint(1) DEFAULT '1',
  `show_catalog` tinyint(1) DEFAULT '1',
  `publish` tinyint(1) DEFAULT '1',
  `created` int(11) DEFAULT '0',
  `course_mode` enum('SPL','ILT','Hybrid') COLLATE utf8mb4_unicode_ci DEFAULT 'SPL',
  `delivery_type` enum('Online','Offline','Hybrid') COLLATE utf8mb4_unicode_ci DEFAULT 'Online',
  `assessment_type` enum('Practice Tests','Monthly Assessments','Board Prep Series','Exams','Project','Practical','Online Quiz') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `name`, `course_code`, `info`, `duration`, `learners`, `rating`, `reviews`, `price`, `course_type`, `direction_id`, `sub_direction_id`, `class_direction_id`, `board`, `creator_LOGIN`, `active`, `show_catalog`, `publish`, `created`, `course_mode`, `delivery_type`, `assessment_type`) VALUES
(1, 'dfdfd', NULL, '232321321321', 32, 0, '4.5', 0, '23.00', 'Paid', 1, 2, NULL, 'CBSE', 'admin', 1, 1, 1, 1761419187, 'ILT', 'Online', 'Online Quiz'),
(2, 'dder', NULL, '4324324324324', 342, 0, '4.5', 0, '432.00', 'Paid', 1, 2, NULL, 'ICSE', 'admin', 1, 1, 1, 1761451576, 'SPL', 'Online', NULL),
(3, 'puc', NULL, '21444332132', 21, 0, '4.5', 0, '1234.00', 'Paid', 1, 24, NULL, 'State PUC', 'admin', 1, 1, 1, 1761452611, 'SPL', 'Online', NULL),
(4, 'ffdfdsf', NULL, 'fddfdsd', 3, 0, '4.5', 0, '324.00', 'Paid', 1, 44, NULL, 'BBA', 'admin', 1, 1, 1, 1761459463, 'SPL', 'Online', NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `course_id`, `module_title`, `module_description`, `module_order`, `created`) VALUES
(1, 1, '32', '32132', 0, 1761419187),
(2, 0, '432432432', '434324324', 0, 1761450905),
(3, 0, '432432432', '434324324', 0, 1761450947),
(4, 0, '432432432', '434324324', 0, 1761450963),
(5, 2, '432432432', '434324324', 0, 1761451576),
(6, 3, '321321312', '321312312', 0, 1761452611),
(7, 4, '123', '2132', 0, 1761459463);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users_to_lessons`
--

INSERT INTO `users_to_lessons` (`id`, `users_LOGIN`, `lessons_ID`, `user_type`, `progress`, `enrolled_on`) VALUES
(1, 'professor', 1, 'instructor', 0, '2025-10-25 19:06:27');

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `course_media`
--
ALTER TABLE `course_media`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_metadata`
--
ALTER TABLE `course_metadata`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
