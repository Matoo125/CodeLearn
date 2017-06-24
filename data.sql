-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.2.3-MariaDB-log - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for codelearn
CREATE DATABASE IF NOT EXISTS `codelearn` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `codelearn`;

-- Dumping structure for table codelearn.finishedlessons
CREATE TABLE IF NOT EXISTS `finishedlessons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_finishedLessonsUser` (`user_id`),
  KEY `FK_finishedLessonsLesson` (`lesson_id`),
  CONSTRAINT `FK_finishedLessonsLesson` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_finishedLessonsUser` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table codelearn.finishedlessons: ~0 rows (approximately)
/*!40000 ALTER TABLE `finishedlessons` DISABLE KEYS */;
/*!40000 ALTER TABLE `finishedlessons` ENABLE KEYS */;

-- Dumping structure for table codelearn.lessons
CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `brief` text DEFAULT NULL,
  `theory` text DEFAULT NULL,
  `exercise` text DEFAULT NULL,
  `topic_id` int(11) NOT NULL,
  `turn` int(11) DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_LessonOfTopic` (`topic_id`),
  CONSTRAINT `FK_LessonOfTopic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table codelearn.lessons: ~0 rows (approximately)
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` (`id`, `title`, `brief`, `theory`, `exercise`, `topic_id`, `turn`, `createdAt`, `updatedAt`) VALUES
	(1, 'Introduction', 'Simple introduction to HTML', 'HTML (Hyper Text Markup Language) is structural document which is being read by web browsers to deliver you your Facebook feed (and all those other stuff). It is not really a programming language. All you need to do is to learn some tags and their attributes to gain the ability of creating web pages. Those pages might not look beautiful or be super useful, but they will be a web pages created with the same language as the most popular websites online. So let’s dive straight  into it.', 'Paste this code to editor and click run!\n\n```html\n<!DOCTYPE html>\n<html>\n<head>\n  <title>Page Title</title>\n</head>\n  <body>\n    <h1>My First Heading</h1>\n    <p>My first paragraph.</p>\n  </body>\n</html>\n```', 1, 1, '2017-06-12 10:50:40', '2017-06-12 10:50:49');
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;

-- Dumping structure for table codelearn.solutions
CREATE TABLE IF NOT EXISTS `solutions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL,
  `solution` text NOT NULL,
  `explanation` text DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 0,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_Solutions` (`lesson_id`),
  CONSTRAINT `FK_Solutions` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table codelearn.solutions: ~0 rows (approximately)
/*!40000 ALTER TABLE `solutions` DISABLE KEYS */;
/*!40000 ALTER TABLE `solutions` ENABLE KEYS */;

-- Dumping structure for table codelearn.topics
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table codelearn.topics: ~3 rows (approximately)
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` (`id`, `title`, `description`, `createdAt`, `updatedAt`) VALUES
	(1, 'HTML', 'hyper text markup language', '2017-06-12 10:24:47', '2017-06-12 10:24:47'),
	(2, 'CSS', 'cascading stylesheet', '2017-06-12 10:25:01', '2017-06-12 10:25:01'),
	(3, 'JavaScript', 'browser\'s language', '2017-06-12 10:25:33', '2017-06-12 10:25:33');
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;

-- Dumping structure for table codelearn.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) DEFAULT NULL,
  `slug` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `about_me` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(1) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table codelearn.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `slug`, `password`, `first_name`, `last_name`, `about_me`, `email`, `role`, `image_id`, `created_at`, `updated_at`) VALUES
	(1, 'Matej', 'matej', '$2y$10$kV6r6a/IfmzUYnCXFvetZ.04Va2XI.VoJz1lfFB2/wC0QX.3ZSS8G', NULL, NULL, NULL, 'vrzala.matej@gmail.com', 1, NULL, '2017-06-06 11:16:14', '2017-06-06 11:16:14');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
