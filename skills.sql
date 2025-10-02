-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2025 at 08:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skillswap`
--

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `rate_per_hr` decimal(8,2) NOT NULL,
  `level` enum('Beginner','Intermediate','Expert') NOT NULL DEFAULT 'Intermediate',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skill_id`, `title`, `description`, `category`, `image_path`, `rate_per_hr`, `level`, `created_at`) VALUES
(5, 'Beginner Guitar Lessons', 'Learn basic chords, strumming patterns and simple songs in your first month.', 'Music', 'photo1.png', 30.00, 'Beginner', '2025-10-02 23:37:59'),
(6, 'Intermediate Fingerstyle', 'Develop fingerstyle technique, patterns, and repertoire.', 'Music', 'photo2.png', 45.00, 'Intermediate', '2025-10-02 23:37:59'),
(7, 'Artisan Bread Baking', 'Mixing, proofing and baking beautiful artisan loaves.', 'Cooking', 'photo3.png', 25.00, 'Beginner', '2025-10-02 23:37:59'),
(8, 'French Pastry Making', 'Classic techniques for pâte à choux, custards and laminated doughs.', 'Cooking', 'photo4.png', 50.00, 'Expert', '2025-10-02 23:37:59'),
(9, 'Watercolor Basics', 'Brush control, washes and color mixing for beginners.', 'Art', 'photo5.png', 20.00, 'Beginner', '2025-10-02 23:37:59'),
(10, 'Digital Illustration with Procreate', 'Layers, brushes and workflows for digital art on tablet.', 'Art', 'photo6.png', 40.00, 'Intermediate', '2025-10-02 23:37:59'),
(11, 'Morning Vinyasa Flow', 'Breath-led sequences to build strength and flexibility.', 'Wellness', 'photo7.png', 35.00, 'Intermediate', '2025-10-02 23:37:59'),
(12, 'Intro to PHP & MySQL', 'Connect PHP to a database and build basic dynamic pages.', 'Programming', 'photo8.png', 55.00, 'Expert', '2025-10-02 23:37:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
