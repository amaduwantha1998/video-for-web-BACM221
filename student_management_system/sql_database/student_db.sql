-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 14, 2025 at 10:46 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `subject_id`, `enrollment_date`) VALUES
(1, 1, 1, '2025-01-15'),
(2, 1, 2, '2025-01-15'),
(3, 2, 1, '2025-01-16'),
(4, 2, 3, '2025-01-16'),
(5, 3, 4, '2025-01-17'),
(6, 3, 5, '2025-01-17'),
(7, 4, 2, '2025-01-18'),
(8, 4, 6, '2025-01-18'),
(9, 5, 3, '2025-01-19'),
(10, 5, 7, '2025-01-19'),
(11, 6, 8, '2025-01-20'),
(12, 7, 1, '2025-01-21'),
(13, 7, 2, '2025-01-21'),
(14, 8, 5, '2025-01-22'),
(15, 8, 6, '2025-01-22');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `class` varchar(10) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `age`, `gender`, `class`, `email`, `phone`) VALUES
(1, 'Nimal Perera', 20, 'Male', 'A1', 'nimal1@example.com', '0771234567'),
(2, 'Kamal Silva', 22, 'Male', 'B1', 'kamal1@example.com', '0772345678'),
(3, 'Saman Kumara', 19, 'Male', 'A1', 'saman1@example.com', '0773456789'),
(4, 'Amali Fernando', 21, 'Female', 'B2', 'amali1@example.com', '0774567890'),
(5, 'Nadeesha Wijesinghe', 20, 'Female', 'C1', 'nadeesha1@example.com', '0775678901'),
(6, 'Ruwan Jayasuriya', 23, 'Male', 'C2', 'ruwan1@example.com', '0776789012'),
(7, 'Dilani Peris', 19, 'Female', 'A2', 'dilani1@example.com', '0777890123'),
(8, 'Heshan Rathnayake', 22, 'Male', 'B3', 'heshan1@example.com', '0778901234');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_code` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `subject_code`, `description`) VALUES
(1, 'Mathematics', 'MATH101', 'Basic Mathematics'),
(2, 'English', 'ENG102', 'English Language & Literature'),
(3, 'Science', 'SCI103', 'General Science'),
(4, 'History', 'HIS104', 'World and Sri Lankan History'),
(5, 'ICT', 'ICT105', 'Information & Communication Technology'),
(6, 'Physics', 'PHY106', 'Fundamentals of Physics'),
(7, 'Chemistry', 'CHEM107', 'Introduction to Chemistry'),
(8, 'Biology', 'BIO108', 'Human & Plant Biology');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Teacher','Student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Admin'),
(2, 'teacher1', 'a426dcf72ba25d046591f81a5495eab7', 'Teacher'),
(3, 'teacher2', '00bcc89aaa027c2ca8aa55b5ad1bcdd0', 'Teacher'),
(4, 'student1', 'ad6a280417a0f533d8b670c61667e1a0', 'Student'),
(5, 'student2', '1578eb8143e36f4c3752f96e1e39bd07', 'Student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
