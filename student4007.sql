-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 31 Ιαν 2024 στις 17:01:37
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `student4007`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `main_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `announcements`
--

INSERT INTO `announcements` (`id`, `date`, `subject`, `main_text`) VALUES
(2, '2023-01-26', 'Έναρξη μαθημάτων', 'Τα μαθήματα αρχίζουν την Δευτέρα 17/12/2008'),
(3, '2023-02-23', 'Tέλος μαθημάτων', 'Τα μαθήματα λήγουν την Παρασκευή 22/5/2023'),
(44, '2024-01-27', 'Υποβλήθηκε η εργασία 10', 'Η ημερομηνία παράδοσης της εργασίας είναι 2024-02-27.');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `objectives` text DEFAULT NULL,
  `assignment_text` varchar(255) DEFAULT NULL,
  `deliverables` text DEFAULT NULL,
  `submission_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `assignments`
--

INSERT INTO `assignments` (`id`, `objectives`, `assignment_text`, `deliverables`, `submission_date`) VALUES
(1, 'Η συγκεκριμένη εργασία αποτελεί το πρώτο (Α) μέρος των εργασιών του μαθήματος με στόχο την υλοποίηση ενός στατικού ιστοχώρου', 'https://elearning.auth.gr/pluginfile.php/2632716/mod_assign/introattachment/0/2023-24-ERGASIA_partA1-HTML.doc?forcedownload=1', '1. Γραπτή αναφορά σε word\r\n                                                                                             2. Παρουσίαση σε powerpoint', '2023-02-21'),
(2, 'Η συγκεκριμένη εργασία αποτελεί συνέχεια (επαύξηση) της πρώτης με στόχο την μετατροπή του στατικού ιστοχώρου σε δυναμικό.', 'https://elearning.auth.gr/pluginfile.php/2632717/mod_assign/introattachment/0/2023-24-ERGASIA_partB-HTML-PHP-MySQL1.doc?forcedownload=1', '1. Γραπτή αναφορά σε word \r\n2. Παρουσίαση σε powerpoint', '2023-03-23'),
(10, 'Οι στόχοι τις εργασίας είναι....!', 'uploads/2023-24-ERGASIA_partB-HTML-PHP-MySQL1.pdf', 'Γραπτή αναφορά σε word, Παρουσίαση σε powerpoint!!!!!!', '2024-02-27');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `documents`
--

INSERT INTO `documents` (`id`, `title`, `description`, `file_name`) VALUES
(1, 'Πρώτη εργασία εξαμήνου', 'Εκπαιδευτικά Περιβάλλοντα Διαδικτύου: Εργασία 1', 'https://elearning.auth.gr/pluginfile.php/2632716/mod_assign/introattachment/0/2023-24-ERGASIA_partA1-HTML.doc?forcedownload=1'),
(2, 'Δεύτερη εργασία εξαμήνου', 'Εκπαιδευτικά Περιβάλλοντα Διαδικτύου: Εργασία 2', 'https://elearning.auth.gr/pluginfile.php/2632717/mod_assign/introattachment/0/2023-24-ERGASIA_partB-HTML-PHP-MySQL1.doc?forcedownload=1');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `loginame` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('Tutor','Student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `loginame`, `password`, `role`) VALUES
(1, 'Thanos', 'Raptis', 'testlogin', '123', 'Tutor'),
(2, 'Petros', 'Mantalos', 'testlogin2', '123', 'Student'),
(3, 'Κώστας', 'Μήτρογλου', 'glx123', '123', 'Student');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loginame` (`loginame`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT για πίνακα `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT για πίνακα `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
