-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 19, 2024 at 12:53 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `worksmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bank_id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `swift_code` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bank_id`, `bank_name`, `account_name`, `account_number`, `swift_code`, `is_active`, `created_at`) VALUES
(1, 'Bank Mandiri', 'Mufrida Fara Diani', '1430029739875', 'BMRIIDJAXXX', 1, '2024-11-16 19:59:19');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chat_id`, `sender_id`, `receiver_id`, `message`, `is_read`, `sent_at`) VALUES
(74, 25, 23, 'Halo, saya tertarik dengan workshop: Video Editing Mastery. Boleh tanya informasi lebih lanjut?', 0, '2024-11-18 23:27:18'),
(75, 25, 23, 'Halo, saya tertarik dengan workshop: Video Editing Mastery. Boleh tanya informasi lebih lanjut?', 0, '2024-11-18 23:28:58'),
(79, 25, 23, 'Halo, saya tertarik dengan workshop: Video Editing Mastery. Boleh tanya informasi lebih lanjut?', 0, '2024-11-18 23:32:33'),
(84, 25, 23, 'Halo, saya tertarik dengan workshop: Creative Writing Workshop. Boleh tanya informasi lebih lanjut?', 0, '2024-11-18 23:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `workshop_id`, `rating`, `comment`, `created_at`) VALUES
(3, 25, 15, 5, 'Keren Sekali', '2024-11-18 21:58:04'),
(4, 25, 14, 5, 'Bagus sekali', '2024-11-18 21:34:02'),
(5, 25, 11, 5, 'Bagus', '2024-11-18 22:05:11'),
(6, 25, 9, 5, 'Very Good', '2024-11-18 23:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `payment_method` enum('bank_transfer','e-wallet') NOT NULL,
  `payment_status` enum('successful','pending','failed') NOT NULL,
  `payment_receipt` varchar(50) NOT NULL,
  `bank_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `registration_id`, `amount`, `payment_date`, `payment_method`, `payment_status`, `payment_receipt`, `bank_id`) VALUES
(8, 14, 550000.00, '2024-11-18 04:58:03', 'bank_transfer', 'successful', 'INV-14.jpeg', 1),
(9, 15, 600000.00, '2024-11-18 07:50:49', 'bank_transfer', 'successful', 'INV-15.jpg', 1),
(10, 16, 350000.00, '2024-11-18 08:48:42', 'bank_transfer', 'successful', 'INV-16.jpeg', 1),
(11, 17, 350000.00, '2024-11-19 04:43:43', 'bank_transfer', 'successful', 'INV-17.png', 1),
(12, 18, 350000.00, '2024-11-19 05:46:06', 'bank_transfer', 'successful', 'INV-18.png', 1),
(13, 19, 450000.00, '2024-11-19 05:54:39', 'bank_transfer', 'successful', 'INV-19.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `registration_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `registration_date` datetime DEFAULT current_timestamp(),
  `status` enum('registered','cancelled','completed') NOT NULL DEFAULT 'registered',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`registration_id`, `user_id`, `workshop_id`, `registration_date`, `status`, `created_at`, `updated_at`) VALUES
(14, 25, 15, '2024-11-18 04:58:03', 'registered', '2024-11-17 21:58:03', '2024-11-17 21:58:03'),
(15, 25, 14, '2024-11-18 07:50:49', 'registered', '2024-11-18 00:50:49', '2024-11-18 00:50:49'),
(16, 26, 11, '2024-11-18 08:48:42', 'registered', '2024-11-18 01:48:42', '2024-11-18 01:48:42'),
(17, 25, 11, '2024-11-19 04:43:43', 'registered', '2024-11-18 21:43:43', '2024-11-18 21:43:43'),
(18, 25, 11, '2024-11-19 05:46:06', 'registered', '2024-11-18 22:46:06', '2024-11-18 22:46:06'),
(19, 25, 9, '2024-11-19 05:54:39', 'registered', '2024-11-18 22:54:39', '2024-11-18 22:54:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `role` enum('admin','mitra','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `email`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(23, 'mitratama', '$2y$10$VIt0/ssFv8ttYmOVoijjkelOsP80iOOepKlyGTLlda8/JCwjjbE2i', 'Mitra', 'Tama', 'mitratama@gmail.com', '6288989472152', 'mitra', '2024-11-17 20:01:35', '2024-11-18 01:28:13'),
(24, 'admin', '$2y$10$IAOtsD3XjAguw.aBAqCgd.VUKp5xvULVIFRU207oXjQnhpucDtBTm', 'Admin', 'Tama', 'admin@gmail.com', '6288989472152', 'admin', '2024-11-17 20:01:35', '2024-11-17 21:31:50'),
(25, 'pesertatama', '$2y$10$q7v3KXtdiXaogdXHuCUy5eS8x6uRMbTp9EAI7CRbfDL3SEm4eXkOK', 'Peserta', 'Tama', 'pesertatama@gmail.com', '6288989472152', 'user', '2024-11-17 20:01:35', '2024-11-18 01:28:31'),
(26, 'mufrida', '$2y$10$Cy01N700tUpCs.jGsIbohe6B/wqFNsUkcu1.QBoJy6XiVwkSGR2gq', 'mufrida', 'peserta', 'mufrida@gmail.com', '62895339046899', 'user', '2024-11-18 01:47:42', '2024-11-18 23:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `workshop_id` int(11) NOT NULL,
  `mitra_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `banner` varchar(100) NOT NULL,
  `training_overview` text NOT NULL,
  `trained_competencies` text NOT NULL,
  `training_session` text NOT NULL,
  `requirements` text NOT NULL,
  `benefits` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` enum('active','inactive','cancelled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`workshop_id`, `mitra_id`, `title`, `description`, `banner`, `training_overview`, `trained_competencies`, `training_session`, `requirements`, `benefits`, `price`, `location`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(3, 23, 'UI/UX Design', 'Pelatihan untuk menjadi desainer UI/UX profesional.', 'sample.jpg', 'Dasar-dasar desain UI/UX, riset pengguna, prototipe, dan testing.', 'Riset UX, Wireframing, Prototyping', '2 hari (8 jam/hari)', 'Laptop dengan software Figma atau Adobe XD', 'Sertifikat resmi, materi pelatihan, dan akses komunitas', 300000.00, 'Yogyakarta', '2024-12-10 08:00:00', '2024-12-11 16:00:00', 'active', '2024-11-15 09:02:38', '2024-11-17 20:01:53'),
(4, 23, 'Data Science Basics', 'Pengantar analisis data untuk pemula.', 'sample.jpg', 'Pengantar Python, analisis data, dan visualisasi.', 'Python, Pandas, Matplotlib', '1 hari (8 jam)', 'Laptop dengan Python terinstal', 'Sertifikat resmi dan contoh dataset', 250000.00, 'Jakarta', '2024-12-15 09:00:00', '2024-12-15 17:00:00', 'active', '2024-11-15 09:02:38', '2024-11-17 20:01:56'),
(5, 23, 'Public Speaking Mastery', 'Workshop untuk menguasai seni berbicara di depan umum.', 'sample.jpg', 'Strategi komunikasi efektif, melatih kepercayaan diri, dan penguasaan audiens.', 'Komunikasi verbal, penguasaan emosi', '1 hari (6 jam)', 'Antusiasme belajar', 'Sertifikat, rekaman sesi, dan konsultasi', 150000.00, 'Surabaya', '2024-12-20 10:00:00', '2024-12-20 16:00:00', 'active', '2024-11-15 09:02:38', '2024-11-17 20:01:58'),
(6, 23, 'Digital Illustration', 'Belajar ilustrasi digital menggunakan tablet grafis.', 'sample.jpg', 'Teknik menggambar digital, pewarnaan, dan rendering.', 'Menguasai software CorelDRAW/Photoshop', '2 hari (6 jam/hari)', 'Laptop atau tablet grafis', 'Sertifikat, contoh desain, dan akses forum', 400000.00, 'Malang', '2024-12-25 09:00:00', '2024-12-26 15:00:00', 'active', '2024-11-15 09:02:38', '2024-11-17 20:02:00'),
(8, 23, 'Photography Basics', 'Dasar-dasar fotografi untuk pemula.', 'sample.jpg', 'Pengaturan kamera, komposisi, dan editing dasar.', 'Keterampilan fotografi dasar', '1 hari (5 jam)', 'Kamera DSLR atau smartphone', 'Sertifikat dan hasil foto', 200000.00, 'Bali', '2025-01-05 08:00:00', '2025-01-05 13:00:00', 'active', '2024-11-15 09:02:38', '2024-11-17 20:02:07'),
(9, 23, 'Cloud Computing', 'Pengantar komputasi awan untuk bisnis dan IT.', 'sample.jpg', 'Konsep dasar cloud, praktik AWS dan Azure.', 'Dasar cloud, manajemen data', '1 hari (6 jam)', 'Laptop dan akun AWS/Azure gratis', 'Sertifikat dan akses percobaan cloud', 450000.00, 'Semarang', '2025-01-10 09:00:00', '2025-01-10 15:00:00', 'active', '2024-11-15 09:02:38', '2024-11-17 20:02:11'),
(10, 27, 'Mobile App Development', 'Pelatihan untuk mengembangkan aplikasi mobile menggunakan Flutter.', 'sample.jpg', 'Pengenalan Flutter, pengembangan UI/UX, dan integrasi API.', 'Flutter, Dart, API integration', '2 hari (7 jam/hari)', 'Laptop dengan Flutter SDK', 'Sertifikat resmi, akses materi pelatihan, dan contoh aplikasi', 500000.00, 'Jakarta', '2025-01-15 09:00:00', '2025-01-16 16:00:00', 'active', '2024-11-17 02:03:00', '2024-11-18 23:15:59'),
(11, 23, 'SEO & Digital Marketing', 'Dasar-dasar SEO dan teknik pemasaran digital untuk meningkatkan trafik.', 'sample.jpg', 'Optimasi mesin pencari, strategi pemasaran digital, dan analisis trafik.', 'SEO, Google Ads, Content Marketing', '1 hari (6 jam)', 'Laptop dan akun Google Ads', 'Sertifikat dan panduan SEO', 350000.00, 'Bandung', '2025-01-20 09:00:00', '2025-01-20 15:00:00', 'active', '2024-11-17 02:03:10', '2024-11-17 13:02:25'),
(12, 23, 'Blockchain Fundamentals', 'Pengenalan teknologi blockchain dan cara kerjanya dalam dunia digital.', 'sample.jpg', 'Dasar-dasar blockchain, Bitcoin, dan aplikasi cryptocurrency.', 'Blockchain, Bitcoin, Smart Contracts', '1 hari (5 jam)', 'Laptop dan koneksi internet', 'Sertifikat dan e-book tentang Blockchain', 400000.00, 'Surabaya', '2025-01-25 10:00:00', '2025-01-25 15:00:00', 'active', '2024-11-17 02:03:20', '2024-11-17 13:02:35'),
(13, 23, 'Creative Writing Workshop', 'Pelatihan menulis kreatif untuk mengembangkan keterampilan menulis.', 'sample.jpg', 'Teknik menulis naratif, pengembangan karakter, dan struktur cerita.', 'Penulisan kreatif, storytelling, karakterisasi', '2 hari (6 jam/hari)', 'Laptop atau buku catatan', 'Sertifikat dan akses ke forum menulis', 250000.00, 'Bali', '2025-02-01 08:00:00', '2025-02-02 14:00:00', 'active', '2024-11-17 02:03:30', '2024-11-17 13:02:45'),
(14, 23, 'Video Editing Mastery', 'Pelatihan untuk menjadi editor video profesional menggunakan Adobe Premiere.', 'sample.jpg', 'Dasar-dasar pengeditan video, efek, dan audio mastering.', 'Adobe Premiere, Final Cut Pro, editing video', '3 hari (7 jam/hari)', 'Laptop dengan Adobe Premiere', 'Sertifikat, video editan, dan akses ke komunitas editing', 600000.00, 'Yogyakarta', '2025-02-10 09:00:00', '2025-02-12 16:00:00', 'active', '2024-11-17 02:03:40', '2024-11-17 13:02:55'),
(15, 23, 'Introduction to Machine Learning', 'Pelatihan pengantar machine learning untuk pemula.', 'sample.jpg', 'Algoritma dasar machine learning, Python, dan data preprocessing.', 'Machine learning, Python, Scikit-learn', '2 hari (8 jam/hari)', 'Laptop dengan Python dan Jupyter Notebook', 'Sertifikat dan akses ke dataset', 550000.00, 'Semarang', '2025-02-15 09:00:00', '2025-02-16 16:00:00', 'active', '2024-11-17 02:03:50', '2024-11-17 13:03:05');

-- --------------------------------------------------------

--
-- Table structure for table `workshop_schedules`
--

CREATE TABLE `workshop_schedules` (
  `schedule_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workshop_schedules`
--

INSERT INTO `workshop_schedules` (`schedule_id`, `workshop_id`, `date`, `start_time`, `end_time`, `location`) VALUES
(1, 1, '2024-12-01', '09:00:00', '15:00:00', 'Jakarta'),
(2, 2, '2024-12-05', '09:00:00', '16:00:00', 'Bandung');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `payments_ibfk_1` (`registration_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registration_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
  ADD PRIMARY KEY (`workshop_id`);

--
-- Indexes for table `workshop_schedules`
--
ALTER TABLE `workshop_schedules`
  ADD PRIMARY KEY (`schedule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `workshop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `workshop_schedules`
--
ALTER TABLE `workshop_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`registration_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
