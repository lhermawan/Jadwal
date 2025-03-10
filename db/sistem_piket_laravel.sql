-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Mar 2025 pada 03.33
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_piket_laravel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `name`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Adilla', 2, NULL, NULL),
(2, 'Santi', 2, NULL, NULL),
(3, 'Baiqa', 2, NULL, NULL),
(4, 'Haidar', 1, NULL, NULL),
(5, 'Gagah', 1, NULL, NULL),
(6, 'Khairul', 1, NULL, NULL),
(7, 'Acep', 3, NULL, NULL),
(8, 'Dimas', 3, NULL, NULL),
(9, 'Cucu', 3, NULL, NULL),
(10, 'Pak Aep', 3, NULL, NULL),
(11, 'Pak Totong', 3, NULL, NULL),
(12, 'Aldrian', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_03_07_183053_create_employees_table', 1),
(6, '2025_03_07_183058_create_schedules_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `shift` int(11) DEFAULT NULL,
  `is_holiday` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `schedules`
--

INSERT INTO `schedules` (`id`, `employee_id`, `date`, `shift`, `is_holiday`, `created_at`, `updated_at`) VALUES
(1, 3, '2025-03-03', NULL, 1, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(2, 6, '2025-03-03', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(3, 7, '2025-03-03', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(4, 5, '2025-03-03', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(5, 4, '2025-03-03', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(6, 2, '2025-03-03', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(7, 1, '2025-03-03', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(8, 4, '2025-03-04', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(9, 6, '2025-03-04', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(10, 3, '2025-03-04', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(11, 2, '2025-03-04', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(12, 5, '2025-03-04', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(13, 1, '2025-03-04', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(14, 1, '2025-03-05', NULL, 1, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(15, 6, '2025-03-05', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(16, 12, '2025-03-05', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(17, 3, '2025-03-05', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(18, 5, '2025-03-05', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(19, 4, '2025-03-05', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(20, 2, '2025-03-05', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(21, 4, '2025-03-06', NULL, 1, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(22, 5, '2025-03-06', NULL, 1, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(23, 10, '2025-03-06', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(24, 8, '2025-03-06', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(25, 1, '2025-03-06', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(26, 6, '2025-03-06', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(27, 2, '2025-03-06', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(28, 3, '2025-03-06', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(29, 4, '2025-03-07', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(30, 5, '2025-03-07', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(31, 6, '2025-03-07', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(32, 2, '2025-03-07', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(33, 3, '2025-03-07', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(34, 1, '2025-03-07', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(35, 2, '2025-03-08', NULL, 1, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(36, 5, '2025-03-08', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(37, 11, '2025-03-08', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(38, 3, '2025-03-08', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(39, 6, '2025-03-08', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(40, 1, '2025-03-08', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(41, 4, '2025-03-08', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(42, 6, '2025-03-09', NULL, 1, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(43, 5, '2025-03-09', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(44, 9, '2025-03-09', 3, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(45, 4, '2025-03-09', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(46, 2, '2025-03-09', 1, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(47, 1, '2025-03-09', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20'),
(48, 3, '2025-03-09', 2, 0, '2025-03-07 22:03:20', '2025-03-07 22:03:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_employee_id_foreign` (`employee_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
