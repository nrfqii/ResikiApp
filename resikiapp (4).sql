-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jul 02, 2025 at 12:47 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resikiapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `paket_jasa`
--

CREATE TABLE `paket_jasa` (
  `id` bigint NOT NULL,
  `nama_paket` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `harga` int DEFAULT NULL,
  `durasi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket_jasa`
--

INSERT INTO `paket_jasa` (`id`, `nama_paket`, `deskripsi`, `harga`, `durasi`, `created_at`, `updated_at`) VALUES
(1, 'Besih ruangan', 'membersihkan ruangan', 150000, '60', '2025-06-15 14:24:37', '2025-06-18 11:46:32'),
(2, 'Bersih Gudang', 'Jasa membersihkan gudang', 300000, '60', '2025-06-15 14:30:40', '2025-06-15 14:30:40'),
(3, 'Sapu-Pel', 'paket membersihkan sapu dan mengepel', 75000, '60000', '2025-06-15 14:30:40', '2025-06-15 14:30:40'),
(4, 'Cuci-Kaca', 'Jasa membersihkan cuci kaca', 100000, '60', '2025-06-15 14:31:10', '2025-06-15 14:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `petugas_id` bigint DEFAULT NULL,
  `paket_id` bigint DEFAULT NULL,
  `nama_paket` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `harga_paket` decimal(10,2) DEFAULT NULL,
  `custom_request` text COLLATE utf8mb4_general_ci,
  `status` enum('pending','dikonfirmasi','diproses','selesai','dibatalkan') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `alamat_lokasi` text COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `user_id`, `petugas_id`, `paket_id`, `nama_paket`, `harga_paket`, `custom_request`, `status`, `alamat_lokasi`, `tanggal`, `waktu`, `total_harga`, `gambar`, `created_at`, `updated_at`, `deleted_at`, `latitude`, `longitude`) VALUES
(3, 1, NULL, 1, 'Bersih Ruangan', 150000.00, NULL, 'selesai', 'pekalongan', '2025-06-15', '21:24:00', 150000.00, '', '2025-06-15 07:24:53', '2025-06-18 11:45:12', NULL, NULL, NULL),
(4, 1, NULL, 2, 'Bersih Gudang', 300000.00, NULL, 'pending', 'pekalongan', '2025-06-17', '18:11:00', 300000.00, '', '2025-06-17 04:11:40', '2025-06-19 04:38:55', '2025-06-19 04:38:55', NULL, NULL),
(5, 1, NULL, 3, NULL, NULL, NULL, 'pending', 'pekalongan', '2025-06-18', '19:28:00', NULL, '', '2025-06-18 05:28:12', '2025-06-19 04:39:48', '2025-06-19 04:39:48', NULL, NULL),
(6, 1, NULL, 4, NULL, NULL, NULL, 'pending', 'pekalongan', '2025-06-18', '19:32:00', NULL, '', '2025-06-18 05:32:41', '2025-06-19 04:45:27', '2025-06-19 04:45:27', NULL, NULL),
(7, 1, NULL, 4, 'Cuci-Kaca', 100000.00, NULL, 'pending', 'pekalongan', '2025-06-18', '19:56:00', 100000.00, '', '2025-06-18 05:56:12', '2025-06-19 04:45:31', '2025-06-19 04:45:31', NULL, NULL),
(8, 1, NULL, 4, 'Cuci-Kaca', 100000.00, NULL, 'dikonfirmasi', 'pekalongan', '2025-06-18', '20:00:00', 100000.00, '', '2025-06-18 06:00:14', '2025-06-19 05:21:25', NULL, NULL, NULL),
(9, 1, NULL, 4, 'Cuci-Kaca', 100000.00, NULL, 'dikonfirmasi', 'pekalongan', '2025-06-18', '20:08:00', 100000.00, '', '2025-06-18 06:09:06', '2025-06-25 04:41:07', NULL, NULL, NULL),
(10, 1, 2, 2, 'Bersih Gudang', 300000.00, NULL, 'dikonfirmasi', 'pekalongan', '2025-06-18', '20:16:00', 300000.00, '', '2025-06-18 06:17:00', '2025-06-25 04:50:15', NULL, NULL, NULL),
(11, 1, NULL, 4, 'Cuci-Kaca', 100000.00, NULL, 'pending', 'pekalongan', '2025-06-18', '20:44:00', 100000.00, NULL, '2025-06-18 06:44:06', '2025-06-25 04:50:23', '2025-06-25 04:50:23', NULL, NULL),
(12, 1, 2, 3, 'Sapu-Pel', 75000.00, 'jksdkjas', 'dibatalkan', 'pekalongan', '2025-06-18', '20:57:00', 75000.00, NULL, '2025-06-18 06:57:52', '2025-07-02 01:41:44', NULL, NULL, NULL),
(13, 1, 2, 1, 'Besih ruangan', 150000.00, 'akklkasda', 'dikonfirmasi', 'pekalongan', '2025-06-18', '21:39:00', 150000.00, NULL, '2025-06-18 07:41:07', '2025-07-02 03:29:51', NULL, NULL, NULL),
(14, 4, NULL, 2, 'Bersih Gudang', 300000.00, NULL, 'selesai', 'rumah rehan', '2025-06-20', '07:35:00', 300000.00, NULL, '2025-06-19 17:35:52', '2025-06-19 18:44:15', NULL, NULL, NULL),
(15, 5, NULL, 3, 'Sapu-Pel', 75000.00, NULL, 'selesai', 'rumah rehan', '2025-06-20', '01:01:00', 75000.00, NULL, '2025-06-19 19:17:15', '2025-06-19 19:34:51', NULL, NULL, NULL),
(16, 5, 2, 1, 'Besih ruangan', 150000.00, NULL, 'dikonfirmasi', 'rumah rehan', '2025-06-30', '01:01:00', 150000.00, NULL, '2025-06-19 19:32:28', '2025-06-30 23:07:52', NULL, NULL, NULL),
(17, 1, NULL, NULL, NULL, NULL, 'masakin nasi goreng dong', 'pending', 'rumah rehan', '2025-06-23', '16:25:00', 0.00, NULL, '2025-06-23 00:25:45', '2025-06-23 00:25:45', NULL, NULL, NULL),
(18, 1, 2, NULL, NULL, 18.00, 'Ikut summit bang', 'dikonfirmasi', 'Rumah rehan', '2025-06-23', '15:26:00', 0.00, NULL, '2025-06-23 01:26:07', '2025-07-02 03:30:23', NULL, NULL, NULL),
(20, 4, NULL, NULL, NULL, NULL, 'Qui maxime aut praes', 'selesai', 'Error nostrud quia v', '2025-06-23', '18:56:00', 0.00, NULL, '2025-06-23 01:45:29', '2025-06-24 02:54:18', NULL, NULL, NULL),
(21, 1, NULL, NULL, NULL, NULL, 'Mabar', 'pending', 'Upt', '2025-06-23', '15:59:00', 0.00, NULL, '2025-06-23 01:59:38', '2025-06-23 01:59:38', NULL, NULL, NULL),
(22, 1, 2, NULL, NULL, NULL, 'Mabar', 'dikonfirmasi', 'Rumah rehan', '2025-06-23', '16:00:00', 0.00, NULL, '2025-06-23 02:00:32', '2025-07-02 03:15:47', NULL, NULL, NULL),
(23, 1, NULL, NULL, NULL, NULL, 'Tes 1', 'pending', 'Tes 1', '2025-06-23', '16:03:00', 0.00, NULL, '2025-06-23 02:03:50', '2025-06-23 02:03:50', NULL, NULL, NULL),
(24, 1, NULL, NULL, NULL, NULL, 'Tes 2', 'pending', 'Tes 2', '2025-06-23', '16:10:00', 0.00, NULL, '2025-06-23 02:10:20', '2025-06-23 02:10:20', NULL, NULL, NULL),
(25, 1, NULL, NULL, NULL, NULL, 'Asep', 'pending', 'Tes 3', '2025-06-23', '16:41:00', 0.00, NULL, '2025-06-23 02:41:53', '2025-06-23 02:41:53', NULL, NULL, NULL),
(26, 4, 2, NULL, NULL, 10000.00, 'tes11', 'selesai', 'rumah rehan', '2025-06-23', '17:25:00', 0.00, 'upload/pesanan/pesanan_1750674342_k6Jmk.jpg', '2025-06-23 03:25:42', '2025-07-02 05:11:20', NULL, NULL, NULL),
(27, 1, 2, 4, 'Cuci-Kaca', 100000.00, NULL, 'dikonfirmasi', 'iwima', '2025-06-24', '15:38:00', 100000.00, NULL, '2025-06-24 01:38:18', '2025-07-02 02:35:29', NULL, NULL, NULL),
(28, 1, 2, 1, 'Besih ruangan', 150000.00, NULL, 'dibatalkan', 'lab 7', '2025-06-24', '15:53:00', 150000.00, NULL, '2025-06-24 01:53:56', '2025-07-02 02:35:03', NULL, -6.875098491505271, 109.66493520392551),
(29, 1, 2, NULL, NULL, NULL, 'mabar', 'selesai', 'rumah rehan', '2025-06-24', '17:26:00', 0.00, 'upload/pesanan/pesanan_1750760812_xEwLD.png', '2025-06-24 03:26:52', '2025-07-02 04:49:53', NULL, -6.960988694988601, 109.64809513039656),
(30, 4, 2, NULL, NULL, NULL, 'mabar papji', 'selesai', 'rumah rehan', '2025-06-30', '08:51:00', 0.00, 'upload/pesanan/pesanan_1750816354_uT2wk.png', '2025-06-24 18:52:34', '2025-07-02 04:54:22', NULL, -6.875043972471284, 109.66497276069371),
(31, 4, 2, 4, 'Cuci-Kaca', 100000.00, NULL, 'selesai', 'stmik', '2025-06-25', '19:33:00', 100000.00, NULL, '2025-06-25 05:33:37', '2025-07-02 04:55:15', NULL, -6.875101575729906, 109.66493292521118),
(32, 1, 2, 1, 'Besih ruangan', 150000.00, 'mkjkasdhh', 'selesai', 'pekalongan', '2025-07-01', '13:05:00', 150000.00, 'upload/pesanan/pesanan_1751349971_1HeKM.png', '2025-06-30 23:06:11', '2025-06-30 23:10:23', NULL, -6.87512390653319, 109.66492896468742),
(33, 4, 2, 2, 'Bersih Gudang', 320000.00, NULL, 'selesai', 'rumah rehan', '2025-07-02', '19:11:00', 300000.00, NULL, '2025-07-02 05:11:53', '2025-07-02 05:39:21', NULL, -6.875086674155514, 109.66493650000001);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5j2eUZywaQFDVloT4nEFiyJlop8PiOd7qNAIiJMA', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVVZydXRHaExXT0NZbWMzVGJ1azdiZkZ6eHVTS0tyQVh0T1YzaDBkeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vcmVzaWtpYXBwLmNhcmUvZGFzaGJvYXJkL3BldHVnYXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1751458464),
('bjjPbmqNzRp1t61lTOnQDLmUNED6cGuQj1ERstGo', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTDdXZDRJaXdCYkpYeGtkUGY1NEVzTTVsWHpxbWkyWmdzaThYNnJzWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vcmVzaWtpYXBwLmNhcmUvZGFzaGJvYXJkL3BldHVnYXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1751460439);

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `pesanan_id` bigint DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `komentar` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id`, `user_id`, `pesanan_id`, `rating`, `komentar`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 5, 'pekalongan', '2025-06-15 07:49:30', '2025-06-15 07:49:30'),
(2, 5, 15, 1, 'rehannya gada', '2025-06-19 19:36:47', '2025-06-19 19:36:47'),
(3, 4, 14, 1, 'terimakasih mas , rumah saya tambah kotor', '2025-06-22 23:20:48', '2025-06-22 23:20:48'),
(4, 1, 32, 5, 'mantap', '2025-06-30 23:10:56', '2025-06-30 23:10:56'),
(5, 4, 31, 3, 'y', '2025-07-02 05:10:07', '2025-07-02 05:10:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','petugas','konsumen') COLLATE utf8mb4_general_ci DEFAULT 'konsumen',
  `no_hp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `no_hp`, `alamat`, `created_at`, `updated_at`, `latitude`, `longitude`) VALUES
(1, 'Nur Rifqi Tri Aji Saputra', 'konsumen@gmail.com', '$2y$12$8U.ddtm/HCNaMtz9f.sOKu3IWJIW2bUhrK5/p1UXndK/zbrO8OwTW', 'konsumen', '089878987678', 'pekalongan', '2025-06-13 02:44:46', '2025-06-15 11:40:22', NULL, NULL),
(2, 'Nur Rifqi', 'petugas@gmail.com', '$2y$12$8U.ddtm/HCNaMtz9f.sOKu3IWJIW2bUhrK5/p1UXndK/zbrO8OwTW', 'petugas', '089878987678', 'pekalongan', '2025-06-13 13:23:15', '2025-07-02 04:59:28', -6.8750866741555, 109.6649365),
(3, 'salman', 'salman@gmail.com', '$2y$12$/fCW7gifk8bulerrJiykReqqNtgXU6lem94SUDgZ3a0dKmUO4HtG6', 'konsumen', '089763823', 'pekalongan', '2025-06-17 03:39:43', '2025-06-17 03:39:43', NULL, NULL),
(4, 'mas faris', 'faris@gmail.com', '$2y$12$Vf8.g1Ertn6SCW0SxBstWu5y1hiwZShdbw6m2Y/bgARBbybu5Iyke', 'konsumen', '1', 'wiradesa', '2025-06-19 17:35:00', '2025-06-19 17:35:00', NULL, NULL),
(5, 'iman kanaeru', 'iman@kanaeru.com', '$2y$12$zRflr3PZez/c9.DpcIonSO5x1Ip4RrP90TwvPKN9yZvLcLohw3RSy', 'konsumen', 'apacoba', 'KRAPYAK', '2025-06-19 19:13:26', '2025-06-19 19:13:26', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `paket_jasa`
--
ALTER TABLE `paket_jasa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paket_id` (`paket_id`),
  ADD KEY `idx_pesanan_user_id` (`user_id`),
  ADD KEY `idx_pesanan_status` (`status`),
  ADD KEY `idx_pesanan_tanggal` (`tanggal`),
  ADD KEY `petugas_id` (`petugas_id`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `paket_jasa`
--
ALTER TABLE `paket_jasa`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_3` FOREIGN KEY (`paket_id`) REFERENCES `paket_jasa` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pesanan_ibfk_4` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
