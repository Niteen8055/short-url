-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 02, 2024 at 06:10 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `short_url`
--

-- --------------------------------------------------------

--
-- Table structure for table `lara_cache`
--

CREATE TABLE `lara_cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lara_cache_locks`
--

CREATE TABLE `lara_cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lara_failed_jobs`
--

CREATE TABLE `lara_failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lara_jobs`
--

CREATE TABLE `lara_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lara_job_batches`
--

CREATE TABLE `lara_job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lara_migrations`
--

CREATE TABLE `lara_migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lara_migrations`
--

INSERT INTO `lara_migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_21_061717_create_short_u_r_l_s_table', 2),
(5, '2024_11_27_124451_create_short_u_r_l_s_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `lara_password_reset_tokens`
--

CREATE TABLE `lara_password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lara_sessions`
--

CREATE TABLE `lara_sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lara_sessions`
--

INSERT INTO `lara_sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bVJxNZlfsmzno03fb7ITSwc9g6AXQ8SetOYZnQ0c', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaVMzVzl1aFRnYXQ1VDROSUpxbTAxSmp5MmJIR0swZ3FJUjJ5TFN1MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733116349),
('Cg89NtN9KjPDWlvzg0LZbMUfFyYormQiwhPBEGoq', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicTREdzZwQ1NiZjNNZThSU05hbjNWS3M4dDA0S3Z3RVV6UzJuUFVmVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaG9ydC11cmwvc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1732882788),
('LCZRDRCnGCnyFM8VtTR7ddbPRwUpIVdF2V0BjvaK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVjhmMkQybE1IeUtUTDJ3anE2dWJ5RnpSSGI4MVNuaExLdjBXZlhiZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1733116415);

-- --------------------------------------------------------

--
-- Table structure for table `lara_short_u_r_l_s`
--

CREATE TABLE `lara_short_u_r_l_s` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `destination_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `default_short_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `single_use` tinyint(1) NOT NULL,
  `track_visits` tinyint(1) NOT NULL,
  `redirect_status_code` int NOT NULL DEFAULT '301',
  `track_ip_address` tinyint(1) NOT NULL DEFAULT '0',
  `track_operating_system` tinyint(1) NOT NULL DEFAULT '0',
  `track_operating_system_version` tinyint(1) NOT NULL DEFAULT '0',
  `track_browser` tinyint(1) NOT NULL DEFAULT '0',
  `track_browser_version` tinyint(1) NOT NULL DEFAULT '0',
  `track_referer_url` tinyint(1) NOT NULL DEFAULT '0',
  `track_device_type` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lara_short_u_r_l_s`
--

INSERT INTO `lara_short_u_r_l_s` (`id`, `user_id`, `destination_url`, `url_key`, `default_short_url`, `single_use`, `track_visits`, `redirect_status_code`, `track_ip_address`, `track_operating_system`, `track_operating_system_version`, `track_browser`, `track_browser_version`, `track_referer_url`, `track_device_type`, `created_at`, `updated_at`) VALUES
(46, 1, 'https://app.bitly.com/', 'D1E51', 'https://localhost.8000/short/D1E51', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 00:37:50', '2024-11-29 00:37:50'),
(47, 1, 'https://app.bitly.com/', 'mrdbP', 'https://localhost.8000/short/mrdbP', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 00:38:20', '2024-11-29 00:38:20'),
(48, 1, 'https://app.bitly.com/', 'P3x0j', 'https://localhost.8000/short/P3x0j', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 00:38:30', '2024-11-29 00:38:30'),
(49, 1, 'https://app.bitly.com/', 'm8vyP', 'https://localhost.8000/short/m8vyP', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 00:42:51', '2024-11-29 00:42:51'),
(50, 1, 'https://app.bitly.com/', '1lbgj', 'https://localhost.8000/short/1lbgj', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 00:50:18', '2024-11-29 00:50:18'),
(51, 1, 'https://app.bitly.com/', 'mNR4m', 'https://localhost.8000/short/mNR4m', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 00:55:53', '2024-11-29 00:55:53'),
(52, 1, 'https://www.google.co.in/', '12GMP', 'https://localhost.8000/short/12GMP', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 00:57:09', '2024-11-29 00:57:09'),
(53, 1, 'https://www.youtube.com/', 'mplam', 'https://localhost.8000/short/mplam', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 00:59:21', '2024-11-29 00:59:21'),
(54, 1, 'https://www.youtube.com/', 'PyQqP', 'https://localhost.8000/short/PyQqP', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 01:00:30', '2024-11-29 01:00:30'),
(55, 1, 'https://app.bitly.com/', '1GWD1', 'https://localhost.8000/short/1GWD1', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 01:09:21', '2024-11-29 01:09:21'),
(56, 1, 'https://app.bitly.com/', 'jDbK1', 'https://localhost.8000/short/jDbK1', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 01:15:47', '2024-11-29 01:15:47'),
(57, 1, 'https://www.google.co.in/', 'PJRdP', 'https://localhost.8000/short/PJRdP', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 01:18:36', '2024-11-29 01:18:36'),
(58, 1, 'https://www.youtube.com/', 'mO8Z1', 'https://localhost.8000/mO8Z1', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 01:22:24', '2024-11-29 01:22:24'),
(59, 1, 'https://app.bitly.com/', 'j9rXm', 'https://localhost.8000/j9rXm', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 01:23:17', '2024-11-29 01:23:17'),
(60, 1, 'https://www.youtube.com/watch?v=YKSe6v-M91o', 'jd8Wj', 'https://localhost.8000/jd8Wj', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 01:24:10', '2024-11-29 01:24:10'),
(61, 1, 'https://www.youtube.com/', 'jwL9m', 'https://localhost.8000/jwL9m', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 02:41:10', '2024-11-29 02:41:10'),
(62, 1, 'https://www.google.co.in/', '1LNVj', 'https://localhost.8000/1LNVj', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 02:41:42', '2024-11-29 02:41:42'),
(63, 1, 'https://www.google.co.in/', 'mz5aj', 'https://localhost.8000/mz5aj', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 02:42:02', '2024-11-29 02:42:02'),
(64, 1, 'https://www.google.co.in/', '1Bxzj', 'https://localhost.8000/1Bxzj', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 02:50:36', '2024-11-29 02:50:36'),
(65, 1, 'https://app.bitly.com/', '1a3oj', 'https://localhost.8000/1a3oj', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 02:53:17', '2024-11-29 02:53:17'),
(66, 1, 'https://www.google.co.in/', 'jnVJj', 'https://localhost.8000/jnVJj', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 02:54:09', '2024-11-29 02:54:09'),
(67, 1, 'https://app.bitly.com/', 'j5V8m', 'https://localhost.8000/j5V8m', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:01:48', '2024-11-29 03:01:48'),
(68, 1, 'https://www.google.co.in/', 'mMbB1', 'https://localhost.8000/mMbB1', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:18:03', '2024-11-29 03:18:03'),
(69, 1, 'https://www.youtube.com/', 'jobqP', 'https://localhost.8000/jobqP', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:18:53', '2024-11-29 03:18:53'),
(70, 1, 'https://www.google.co.in/', 'PYG0m', 'https://localhost.8000/PYG0m', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:23:59', '2024-11-29 03:23:59'),
(71, 1, 'https://app.bitly.com/', 'mVKr1', 'http://127.0.0.1:8000//mVKr1', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:26:05', '2024-11-29 03:26:05'),
(72, 1, 'https://www.google.co.in/', 'j0Qom', 'http://127.0.0.1:8000/j0Qom', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:27:07', '2024-11-29 03:27:07'),
(73, 1, 'https://www.youtube.com/', 'P6RBP', 'http://127.0.0.1:8000/P6RBP', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:33:16', '2024-11-29 03:33:16'),
(74, 1, 'https://www.google.co.in/', 'PqOEm', 'http://127.0.0.1:8000/PqOEm', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:38:35', '2024-11-29 03:38:35'),
(75, 1, 'https://www.google.co.in/', 'jAlDP', 'http://127.0.0.1:8000/jAlDP', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:40:40', '2024-11-29 03:40:40'),
(76, 1, 'https://www.google.co.in/', 'j4lNj', 'http://127.0.0.1:8000/j4lNj', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:45:24', '2024-11-29 03:45:24'),
(77, 1, 'https://www.google.co.in/', 'mXyR1', 'http://127.0.0.1:8000/mXyR1', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:46:20', '2024-11-29 03:46:20'),
(78, 1, 'https://app.bitly.com/', 'jZZkj', 'http://127.0.0.1:8000/jZZkj', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:48:35', '2024-11-29 03:48:35'),
(79, 1, 'https://app.bitly.com/', '17peP', 'http://127.0.0.1:8000/17peP', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:51:12', '2024-11-29 03:51:12'),
(80, 1, 'https://www.youtube.com/', '1vdWj', 'http://127.0.0.1:8000/1vdWj', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:52:24', '2024-11-29 03:52:24'),
(81, 1, 'https://app.bitly.com/', 'jgWQj', 'http://127.0.0.1:8000/jgWQj', 1, 1, 301, 1, 1, 1, 1, 1, 1, 1, '2024-11-29 03:59:57', '2024-11-29 03:59:57');

-- --------------------------------------------------------

--
-- Table structure for table `lara_users`
--

CREATE TABLE `lara_users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lara_users`
--

INSERT INTO `lara_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `phone`, `address`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$Mx5QYfUYTgazOkYUadbfg.k/JAS1XU8BFDWFZFP2f0Ty7k6Lq9x7K', '202411201744profile.png', NULL, NULL, 'admin', 'active', NULL, NULL, '2024-11-21 04:38:37'),
(2, 'User', 'user@gmail.com', NULL, '$2y$12$l84WVcu5jlS3q0Gn9HY1L.T1xTNqCbEbvQwW.eHkdTbr5W6.eBGj.', NULL, NULL, NULL, 'user', 'active', NULL, NULL, NULL),
(7, 'raj', 'raj@gmail.com', NULL, '$2y$12$4q2c2WVE1CLRTpfUxjFhleM8lfcRF4/eV9LFgjUQJJYs9i0WDYW3C', NULL, NULL, NULL, 'user', 'active', NULL, '2024-11-26 05:19:09', '2024-11-26 05:19:09'),
(8, 'abc', 'abc@gmail.com', NULL, '$2y$12$keri2QwIPzYIYtWXQV5UXecDqChPIM9s2VhOJKZLMDajbR.zGa/MO', NULL, NULL, NULL, 'user', 'active', NULL, '2024-11-26 05:20:15', '2024-11-26 05:20:15'),
(9, 'use123', 'use123@gmail.com', NULL, '$2y$12$GhwvKq.uEB0w30XVE.FZluUPTY1PV04CGI3M0HYZkCPWRsEdNbe6.', NULL, NULL, NULL, 'user', 'active', NULL, '2024-11-26 05:21:15', '2024-11-26 05:21:15'),
(10, 'user345', 'user345@gmail.com', NULL, '$2y$12$Kb1Hx3m7Sgp7vID4auQIw.idinA2lerhyNsasYDY3d33jBWoxbTSa', NULL, NULL, NULL, 'user', 'active', NULL, '2024-11-26 05:24:36', '2024-11-26 05:24:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lara_cache`
--
ALTER TABLE `lara_cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `lara_cache_locks`
--
ALTER TABLE `lara_cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `lara_failed_jobs`
--
ALTER TABLE `lara_failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lara_failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `lara_jobs`
--
ALTER TABLE `lara_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lara_jobs_queue_index` (`queue`);

--
-- Indexes for table `lara_job_batches`
--
ALTER TABLE `lara_job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lara_migrations`
--
ALTER TABLE `lara_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lara_password_reset_tokens`
--
ALTER TABLE `lara_password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `lara_sessions`
--
ALTER TABLE `lara_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lara_sessions_user_id_index` (`user_id`),
  ADD KEY `lara_sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `lara_short_u_r_l_s`
--
ALTER TABLE `lara_short_u_r_l_s`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lara_short_u_r_l_s_url_key_unique` (`url_key`),
  ADD KEY `lara_short_u_r_l_s_user_id_foreign` (`user_id`);

--
-- Indexes for table `lara_users`
--
ALTER TABLE `lara_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lara_users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lara_failed_jobs`
--
ALTER TABLE `lara_failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lara_jobs`
--
ALTER TABLE `lara_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lara_migrations`
--
ALTER TABLE `lara_migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lara_short_u_r_l_s`
--
ALTER TABLE `lara_short_u_r_l_s`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `lara_users`
--
ALTER TABLE `lara_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lara_short_u_r_l_s`
--
ALTER TABLE `lara_short_u_r_l_s`
  ADD CONSTRAINT `lara_short_u_r_l_s_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `lara_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
