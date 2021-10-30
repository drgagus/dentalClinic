-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Okt 2021 pada 17.50
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dentalclinic`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `costs`
--

CREATE TABLE `costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tindakan` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `doktergigi` int(11) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `costs`
--

INSERT INTO `costs` (`id`, `tindakan`, `harga`, `doktergigi`, `diskon`, `created_at`, `updated_at`) VALUES
(1, 'Konsultasi Dental', 0, 0, NULL, '2020-09-01 18:26:42', '2020-09-14 06:35:05'),
(2, 'Pemeriksaan dental + premedikasi', 50000, 60, NULL, '2020-09-01 20:33:51', '2020-09-14 06:35:21'),
(3, 'Filling Anterior Resin Komposit', 160000, 40, NULL, '2020-09-04 10:08:25', '2020-09-14 06:37:04'),
(4, 'Fiiling Posterior Resin Komposit', 150000, 50, NULL, '2020-09-08 09:12:33', '2020-09-14 06:37:14'),
(5, 'Filling GIC', 200000, 45, NULL, '2020-09-08 09:12:53', '2020-09-14 06:37:26'),
(6, 'Scalling RA+RB ringan', 150000, 70, NULL, '2020-09-11 17:25:48', '2020-09-14 06:37:38'),
(7, 'Scalling RA+RB sedang', 200000, 60, NULL, '2020-09-12 18:18:07', '2020-09-14 06:37:47'),
(8, 'Scalling RA+RB berat', 200000, 50, NULL, '2020-09-12 18:18:33', '2020-09-14 06:37:57'),
(9, 'Exo anterior tanpa komplikasi', 200000, 45, NULL, '2020-09-12 18:20:33', '2020-09-14 06:38:18'),
(10, 'Exo anterior dengan komplikasi', 250000, 50, NULL, '2020-09-12 18:20:53', '2020-09-14 06:38:32'),
(11, 'Exo posterior tanpa komplikasi', 250000, 45, NULL, '2020-09-12 18:21:33', '2020-09-14 06:38:45'),
(12, 'Exo posterior dengan komplikasi', 300000, 50, NULL, '2020-09-12 18:21:53', '2020-09-14 06:39:07'),
(13, 'Exo gigi susu', 100000, 70, NULL, '2020-09-12 18:22:35', '2020-09-14 06:39:21'),
(14, 'Endo - BAP+dressing', 150000, 30, NULL, '2020-09-12 18:23:41', '2020-09-14 06:39:32'),
(15, 'Endo - kontrol dressing', 100000, 40, NULL, '2020-09-12 18:24:14', '2020-09-14 06:39:44'),
(16, 'Endo - Pengisian saluran akar', 250000, 60, NULL, '2020-09-12 18:24:57', '2020-09-14 06:39:55'),
(19, 'Odontektomi', 2500000, 50, 15, '2020-09-12 19:35:05', '2020-09-14 06:40:09'),
(20, 'frenulektomi', 1500000, NULL, 10, '2020-09-14 06:42:45', '2020-09-14 06:42:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` int(11) NOT NULL,
  `usia` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggalkunjungan` date NOT NULL,
  `keluhanutama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tinggibadan` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `beratbadan` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tekanandarah` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pernafasan` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detakjantung` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suhutubuh` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selesai` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dens`
--

CREATE TABLE `dens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gigi` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rahang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `person` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dens`
--

INSERT INTO `dens` (`id`, `gigi`, `rahang`, `person`, `created_at`, `updated_at`) VALUES
(1, 'Gigi 18', 'Maxila', 1, NULL, NULL),
(2, 'Gigi 17', 'Maxila', 1, NULL, NULL),
(3, 'Gigi 16', 'Maxila', 1, NULL, NULL),
(4, 'Gigi 15', 'Maxila', 1, NULL, NULL),
(5, 'Gigi 14', 'Maxila', 1, NULL, NULL),
(6, 'Gigi 13', 'Maxila', 1, NULL, NULL),
(7, 'Gigi 12', 'Maxila', 1, NULL, NULL),
(8, 'Gigi 11', 'Maxila', 1, NULL, NULL),
(9, 'Gigi 21', 'Maxila', 1, NULL, NULL),
(10, 'Gigi 22', 'Maxila', 1, NULL, NULL),
(11, 'Gigi 23', 'Maxila', 1, NULL, NULL),
(12, 'Gigi 24', 'Maxila', 1, NULL, NULL),
(13, 'Gigi 25', 'Maxila', 1, NULL, NULL),
(14, 'Gigi 26', 'Maxila', 1, NULL, NULL),
(15, 'Gigi 27', 'Maxila', 1, NULL, NULL),
(16, 'Gigi 28', 'Maxila', 1, NULL, NULL),
(17, 'Gigi 48', 'Mandibula', 1, NULL, NULL),
(18, 'Gigi 47', 'Mandibula', 1, NULL, NULL),
(19, 'Gigi 46', 'Mandibula', 1, NULL, NULL),
(20, 'Gigi 45', 'Mandibula', 1, NULL, NULL),
(21, 'Gigi 44', 'Mandibula', 1, NULL, NULL),
(22, 'Gigi 43', 'Mandibula', 1, NULL, NULL),
(23, 'Gigi 42', 'Mandibula', 1, NULL, NULL),
(24, 'Gigi 41', 'Mandibula', 1, NULL, NULL),
(25, 'Gigi 31', 'Mandibula', 1, NULL, NULL),
(26, 'Gigi 32', 'Mandibula', 1, NULL, NULL),
(27, 'Gigi 33', 'Mandibula', 1, NULL, NULL),
(28, 'Gigi 34', 'Mandibula', 1, NULL, NULL),
(29, 'Gigi 35', 'Mandibula', 1, NULL, NULL),
(30, 'Gigi 36', 'Mandibula', 1, NULL, NULL),
(31, 'Gigi 37', 'Mandibula', 1, NULL, NULL),
(32, 'Gigi 38', 'Mandibula', 1, NULL, NULL),
(33, 'Rahang Atas', 'Maxila', 1, NULL, NULL),
(34, 'Rahang Bawah', 'Mandibula', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dentalrecords`
--

CREATE TABLE `dentalrecords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` int(11) NOT NULL,
  `tanggalkunjungan` date NOT NULL,
  `usiatahun` int(11) NOT NULL,
  `usiabulan` int(11) NOT NULL,
  `usiahari` int(11) NOT NULL,
  `keluhanutama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tinggibadan` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `beratbadan` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tekanandarah` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pernafasan` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detakjantung` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suhutubuh` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pemeriksaansubjektif` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pemeriksaanobjektif` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosa` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informedconsent` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengobatan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dentalrecords`
--

INSERT INTO `dentalrecords` (`id`, `patient_id`, `tanggalkunjungan`, `usiatahun`, `usiabulan`, `usiahari`, `keluhanutama`, `tinggibadan`, `beratbadan`, `tekanandarah`, `pernafasan`, `detakjantung`, `suhutubuh`, `pemeriksaansubjektif`, `pemeriksaanobjektif`, `diagnosa`, `informedconsent`, `pengobatan`, `user_id`, `created_at`, `updated_at`) VALUES
(32, 3, '2020-08-01', 25, 8, 12, 'Gigi berlubang.', '170', '65', '120/80', NULL, NULL, NULL, 'Gigi berrlubang, belum pernah sakit, kalau makan sering nyangkut.\r\nterkadang giginya ngilu, tapi cuma sebentar.', 'Gigi 46 karies dentin.\r\nsonde -, perkusi -, chloretil +\r\nRa+rb ada kalkulus', 'Gigi 46 => Karies dentin\r\nRa+Rb => gingivitis ringan', 'images/informedconsent/ID3-1599961947-informedconsent.jpg', 'Amoxicilin 3x1', 1, '2020-09-12 18:52:28', '2020-09-12 18:52:28'),
(33, 4, '2020-08-01', 16, 5, 9, 'Nafas bau', '165', '45', '120/80', NULL, NULL, NULL, 'Nafas bau walaupun sudah sering sikat gigi.\r\nKetika sikat gigi sering berdarah gusinya', 'Rahang atas dan bawah terdapat banyak kalkulus dan adanya beberapa gigi mengalami resesi gingiva', 'Rahang atas dan bawah => gingivitis', 'images/informedconsent/ID4-1599962201-informedconsent.jpg', 'Amox 3x1', 1, '2020-09-12 18:56:42', '2020-09-12 18:56:42'),
(34, 6, '2020-08-01', 29, 8, 12, 'Gigi berlubang, sering sakit', '150', '50', '130/90', NULL, NULL, NULL, 'Gigi berlubang, sering sakit.\r\nKalau makan sakit, tengah malam sering sakit.\r\nSudah 2hari ini giginya sakit terus menerus.', 'Gigi 36 karies pulpa.\r\nsonde +, perkusi +, chloretil +', 'Gigi 36 => pulpitis', NULL, 'Amox 3x1\r\nAsmet 3x1', 2, '2020-09-12 18:59:12', '2020-09-12 19:04:14'),
(35, 1, '2020-09-13', 25, 5, 11, 'Gigi berlubang', '173', '60', '120/80', NULL, NULL, NULL, 'Gigi berlubang, dulu pernah sakit tapi sekarang tidak pernah sakit lagi.', 'Gigi 36 nekrose.\r\nperkusi -, sonde -, chlorethil -', 'gigi 36 nekrose', 'images/informedconsent/ID1-1599965083-informedconsent.jpg', 'Amox 3x1\r\nasmet 3x1', 3, '2020-09-12 19:44:44', '2020-09-12 19:44:44'),
(36, 5, '2020-09-13', 27, 6, 10, 'Sikat gigi sering berdarah', '150', '45', '120/80', NULL, NULL, NULL, 'gusi sering berdarah ketika sikat gigi.\r\nterkadang adanya baumulut.', 'rahang atas bawah terdapat banyak kalkulus', 'rahang atas bawah gingivitis', 'images/informedconsent/ID5-1599965433-informedconsent.jpg', 'Amox 3x1', 1, '2020-09-12 19:50:33', '2020-09-12 19:50:33'),
(37, 7, '2020-09-13', 31, 9, 11, 'Gigi berlubang, bengkak', '167', '67', '120/80', NULL, NULL, NULL, 'gigi berlubang dan bengkang. kadang ada keluar nanah', 'gigi 46 abses +, perkusi +, sonderen +, chloretil +\r\nrahang atas bawah banyak terdapat kalkulus', 'Gigi 46 => pulpitis asymptomatis dengan abses gingiva\r\nRahang atas bawah => gingivitis', NULL, 'Klindamisin 4x1\r\namoxicilin 3x1', 2, '2020-09-12 19:54:06', '2020-09-12 19:54:06'),
(38, 7, '2020-09-14', 31, 9, 12, 'Gigi berlubang', NULL, NULL, '120/80', NULL, NULL, NULL, NULL, NULL, NULL, 'images/informedconsent/ID7-1600091247-informedconsent.jpg', 'Amox 3x1\r\nAsmet 3x1', 1, '2020-09-14 06:47:28', '2020-09-14 06:47:28'),
(39, 4, '2021-10-29', 17, 6, 25, 'sakit gigi', NULL, NULL, '120/80', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'amox 3x1\r\nasmet 3x1', 2, '2021-10-29 08:25:59', '2021-10-29 08:27:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dentaltreatments`
--

CREATE TABLE `dentaltreatments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dentalrecord_id` int(11) NOT NULL,
  `gigi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diag_id` int(11) NOT NULL,
  `imagebefore` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imageafter` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tindakan` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_id` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `doktergigi` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dentaltreatments`
--

INSERT INTO `dentaltreatments` (`id`, `dentalrecord_id`, `gigi`, `diag_id`, `imagebefore`, `imageafter`, `tindakan`, `cost_id`, `harga`, `doktergigi`, `created_at`, `updated_at`) VALUES
(27, 32, 'Gigi 46', 10, 'images/before/ID3-1599961947-1-before.jpg', 'images/after/ID3-1599961947-1-after.jpg', 'Tambal GIC kelas I black', 5, 200000, 95000, '2020-09-12 18:52:28', '2020-09-12 19:08:46'),
(28, 32, 'Maxila+Mandibula', 3, 'images/before/ID3-1599961947-2-before.jpg', 'images/after/ID3-1599961947-2-after.jpg', 'Scalling dengan dressing povidone iodine 1%', 6, 150000, 105000, '2020-09-12 18:52:28', '2020-09-12 19:08:46'),
(29, 33, 'Rahang atas dan bawah', 3, 'images/before/ID4-1599962201-1-before.jpg', 'images/after/ID4-1599962201-1-after.jpg', 'Scallig dengan dressing povidone iodine 10%', 7, 200000, 120000, '2020-09-12 18:56:42', '2020-09-12 19:08:54'),
(30, 34, 'Gigi 36', 5, NULL, NULL, 'Premedikasi', 2, 50000, 30000, '2020-09-12 18:59:12', '2020-09-12 19:09:02'),
(31, 35, 'gigi 36', 1, 'images/before/ID1-1599965083-1-before.jpg', 'images/after/ID1-1599965083-1-after.jpg', 'Anestesi Blok+submucus\r\nExo\r\npremedikasi', 11, 250000, 112500, '2020-09-12 19:44:44', '2020-09-12 19:55:18'),
(32, 36, 'rahang atas bawah', 3, 'images/before/ID5-1599965433-1-before.jpg', 'images/after/ID5-1599965433-1-after.jpg', 'scalling dengan dressing povidone iodine', 8, 200000, 100000, '2020-09-12 19:50:33', '2020-09-12 19:55:29'),
(33, 37, 'gigi 46', 5, NULL, NULL, 'Premedikasi', 2, 50000, 30000, '2020-09-12 19:54:06', '2020-09-12 19:55:35'),
(34, 38, 'gigi 36', 5, NULL, NULL, 'Premedikasi', 2, 50000, 30000, '2020-09-14 06:47:28', '2020-09-14 06:53:28'),
(35, 38, 'Rahang atas dan rahang bawah', 3, 'images/before/ID7-1600091247-2-before.jpg', 'images/after/ID7-1600091247-2-after.jpg', 'Scalling rahang atas dan bawah\r\nSpulling povidine iodine', 7, 200000, 120000, '2020-09-14 06:47:28', '2020-09-14 06:53:28'),
(36, 39, 'gigi 46', 5, NULL, NULL, 'premedikasi', 2, 50000, 30000, '2021-10-29 08:25:59', '2021-10-29 08:44:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `diags`
--

CREATE TABLE `diags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `diagnosa` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `diags`
--

INSERT INTO `diags` (`id`, `diagnosa`, `created_at`, `updated_at`) VALUES
(1, 'Nekrosa', '2020-09-01 17:34:46', '2020-09-12 18:08:29'),
(2, 'Pulpitis Symptomatis', '2020-09-01 17:41:13', '2020-09-12 18:07:46'),
(3, 'Gingivitis', '2020-09-01 18:03:01', '2020-09-01 18:03:01'),
(4, 'Impacted', '2020-09-08 09:13:24', '2020-09-08 09:13:24'),
(5, 'Pulpitis Asymptomatis', '2020-09-08 09:13:36', '2020-09-12 18:07:18'),
(6, 'Embeded', '2020-09-12 18:08:41', '2020-09-12 18:08:41'),
(7, 'Periodontitis', '2020-09-12 18:08:53', '2020-09-12 18:08:53'),
(8, 'Hipersensitif Dentin', '2020-09-12 18:09:05', '2020-09-12 18:09:05'),
(9, 'Karies Pit&Fisure', '2020-09-12 18:09:30', '2020-09-12 18:09:30'),
(10, 'Karies Dentin', '2020-09-12 18:09:39', '2020-09-12 18:09:39'),
(11, 'Karies Email', '2020-09-12 18:09:49', '2020-09-12 18:09:49'),
(12, 'Hiperemi Pulpa', '2020-09-12 18:10:07', '2020-09-12 18:10:07'),
(13, 'Fraktur  Email', '2020-09-12 18:10:39', '2020-09-12 18:10:39'),
(14, 'Fraktur Dentin', '2020-09-12 18:11:01', '2020-09-12 18:11:01'),
(15, 'Fraktur Tertutup', '2020-09-12 18:11:12', '2020-09-12 18:11:12'),
(16, 'Fraktur Terbuka', '2020-09-12 18:11:24', '2020-09-12 18:11:24'),
(17, 'Odontulus', '2020-09-12 18:11:34', '2020-09-12 18:11:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `medicalrecords`
--

CREATE TABLE `medicalrecords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alergi` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `now` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `medicinerecords`
--

CREATE TABLE `medicinerecords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dentalrecord_id` int(11) NOT NULL,
  `medicine_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `medicinerecords`
--

INSERT INTO `medicinerecords` (`id`, `dentalrecord_id`, `medicine_id`, `jumlah`, `harga`, `user_id`, `created_at`, `updated_at`) VALUES
(17, 32, 1, 10, 3400, 1, '2020-09-12 19:04:56', '2020-09-12 19:08:46'),
(18, 33, 1, 10, 3400, 1, '2020-09-12 19:08:03', '2020-09-12 19:08:54'),
(19, 34, 1, 10, 3400, 1, '2020-09-12 19:08:24', '2020-09-12 19:09:02'),
(20, 34, 2, 10, 12000, 1, '2020-09-12 19:08:25', '2020-09-12 19:09:02'),
(21, 35, 1, 10, 3400, 1, '2020-09-12 19:54:34', '2020-09-12 19:55:18'),
(22, 35, 2, 10, 12000, 1, '2020-09-12 19:54:34', '2020-09-12 19:55:18'),
(23, 36, 1, 10, 3400, 1, '2020-09-12 19:54:46', '2020-09-12 19:55:29'),
(24, 37, 5, 20, 11400, 1, '2020-09-12 19:55:03', '2020-09-12 19:55:35'),
(25, 37, 2, 10, 12000, 1, '2020-09-12 19:55:03', '2020-09-12 19:55:35'),
(26, 38, 1, 10, 3400, 1, '2020-09-14 06:47:53', '2020-09-14 06:53:28'),
(27, 38, 2, 10, 12000, 1, '2020-09-14 06:47:53', '2020-09-14 06:53:28'),
(29, 39, 1, 19, 6460, 9, '2021-10-29 08:28:49', '2021-10-29 08:44:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `obat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `aktif` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `medicines`
--

INSERT INTO `medicines` (`id`, `obat`, `jumlah`, `harga`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'amoxicilin', 80, 340, 1, '2020-09-01 18:29:57', '2021-10-29 08:40:21'),
(2, 'Asmet', 35, 1200, 1, '2020-09-02 01:35:07', '2021-10-29 08:39:09'),
(3, 'diclofenac', 90, 2000, 1, '2020-09-05 02:54:20', '2020-09-10 11:30:04'),
(4, 'antasida', 60, 200, 1, '2020-09-05 02:54:34', '2020-09-09 17:39:07'),
(5, 'klindamisin', 90, 570, 1, '2020-09-12 19:51:35', '2021-10-29 08:40:09');

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
(94, '2014_10_12_000000_create_users_table', 1),
(95, '2014_10_12_100000_create_password_resets_table', 1),
(96, '2019_08_19_000000_create_failed_jobs_table', 1),
(97, '2020_08_26_172244_create_patients_table', 1),
(98, '2020_08_29_185217_create_customers_table', 1),
(99, '2020_08_31_084021_create_dens_table', 1),
(100, '2020_08_31_084058_create_dentalrecords_table', 1),
(101, '2020_08_31_084122_create_medicalrecords_table', 1),
(102, '2020_08_31_084146_create_medicinerecords_table', 1),
(103, '2020_08_31_084209_create_medicines_table', 1),
(104, '2020_08_31_084244_create_costs_table', 1),
(105, '2020_08_31_084527_create_odontograms_table', 1),
(106, '2020_08_31_084631_create_dentaltreatments_table', 1),
(107, '2020_09_01_100136_create_diags_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `odontograms`
--

CREATE TABLE `odontograms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `den_id` int(11) NOT NULL,
  `kondisi` int(11) NOT NULL,
  `bukal` int(11) NOT NULL,
  `mesial` int(11) NOT NULL,
  `palatal` int(11) NOT NULL,
  `distal` int(11) NOT NULL,
  `oklusal` int(11) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Struktur dari tabel `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomorrekammedis` int(11) NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jeniskelamin` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempatlahir` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggallahir` date DEFAULT NULL,
  `agama` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendidikan` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomortelepon` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `patients`
--

INSERT INTO `patients` (`id`, `nomorrekammedis`, `nik`, `nama`, `jeniskelamin`, `tempatlahir`, `tanggallahir`, `agama`, `pendidikan`, `pekerjaan`, `alamat`, `nomortelepon`, `created_at`, `updated_at`) VALUES
(1, 76345, '357151', 'Edi Kusnadi, S.H', 'Laki-laki', 'limau manis', '1995-04-02', 'Islam', 'SLTA/SMK/MA/Sederajat', 'Office Man', 'jl. M.Nuh', 798876, '2020-09-01 20:38:52', '2020-09-12 18:37:55'),
(3, 67426, '764527547', 'Mastari', 'Laki-laki', 'Percut', '1995-01-01', 'Islam', 'Diploma IV/S1', 'Imam Mesjid', 'Jl Surga No 99', 3897424, '2020-09-12 18:27:11', '2020-09-12 18:34:37'),
(4, 7263462, '54765876187', 'Nisa', 'Perempuan', 'Percut', '2004-04-04', 'Islam', 'SLTA/SMK/MA/Sederajat', 'Pelajar', 'Jl Surga No 99', 8472872, '2020-09-12 18:28:21', '2020-09-12 18:35:36'),
(5, 973332, '6478268', 'Rama', 'Perempuan', 'Tembung', '1993-03-03', 'Islam', 'SLTA/SMK/MA/Sederajat', 'Analis Kesehatan', 'Jl Pasar 3', 7236457, '2020-09-12 18:29:29', '2020-09-12 18:35:57'),
(6, 6527542, '384625425', 'Sadri', 'Laki-laki', 'Gunung Durian', '1991-01-01', 'Islam', 'Diploma III/Sarjana Muda', 'Perawat', 'jalan M. Nuh', 762546527, '2020-09-12 18:30:46', '2020-09-12 18:35:22'),
(7, 7625, '65275', 'Arpan', 'Laki-laki', 'Perbaungan', '1988-12-02', 'Islam', 'SLTA/SMK/MA/Sederajat', 'Teknisi', 'jl Lintas', 978628, '2020-09-12 18:31:57', '2020-09-12 18:35:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CEO` int(11) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `pendaftaran` int(11) DEFAULT NULL,
  `pemeriksaan` int(11) DEFAULT NULL,
  `dentist` int(11) DEFAULT NULL,
  `apotek` int(11) DEFAULT NULL,
  `kasir` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `CEO`, `admin`, `pendaftaran`, `pemeriksaan`, `dentist`, `apotek`, `kasir`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'drg.yahya', 'yahya', NULL, NULL, '$2y$10$EuGbwwYrQvpRcoAcBNbjGupvTgvHQjTKKgHHuSn2EZQlrnD1DQL9.', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-01 17:35:37', '2020-09-03 02:28:01'),
(2, 'drg. agus', 'agus', NULL, NULL, '$2y$10$EuGbwwYrQvpRcoAcBNbjGupvTgvHQjTKKgHHuSn2EZQlrnD1DQL9.', NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2020-09-01 17:35:56', '2020-09-02 09:41:04'),
(3, 'drg. franky', 'franky', NULL, NULL, '$2y$10$EuGbwwYrQvpRcoAcBNbjGupvTgvHQjTKKgHHuSn2EZQlrnD1DQL9.', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2020-09-01 17:36:38', '2020-09-02 09:40:52'),
(4, 'drg. nicko', 'nicko', NULL, NULL, '$2y$10$EuGbwwYrQvpRcoAcBNbjGupvTgvHQjTKKgHHuSn2EZQlrnD1DQL9.', NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2020-09-02 09:43:19', '2021-10-29 08:42:43'),
(5, 'mastari', 'mastari', NULL, NULL, '$2y$10$EuGbwwYrQvpRcoAcBNbjGupvTgvHQjTKKgHHuSn2EZQlrnD1DQL9.', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-11 08:23:59', '2020-09-11 08:58:00'),
(7, 'nisa', 'nisa', NULL, NULL, '$2y$10$Yaylwtb96H4RTbHl7vShpO795hhq1Pfjr6jS6SH5RzoicGjU9..G6', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2021-10-28 06:54:31', '2021-10-28 06:54:31'),
(8, 'laras', 'laras', NULL, NULL, '$2y$10$re..2RLtjDfT1GCp1R/B/e9aEeooegLwOXJV4mfzbzgZFMczuHCtu', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2021-10-28 07:08:35', '2021-10-28 07:08:35'),
(9, 'nazmy', 'nazmy', NULL, NULL, '$2y$10$Gwx/RBfMlw9eKf5s./jkCOJQQX/GxWTDIb49ApMLYLwXT5xKNO2mi', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2021-10-28 07:09:13', '2021-10-28 07:09:13'),
(10, 'lila', 'lila', NULL, NULL, '$2y$10$baqJdo2JPzX/86jI4s94Te2Czh4GhUe.LyESbVrhCK/82SigNhp/6', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2021-10-29 08:43:15', '2021-10-29 08:43:15');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `costs`
--
ALTER TABLE `costs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_id` (`patient_id`);

--
-- Indeks untuk tabel `dens`
--
ALTER TABLE `dens`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dentalrecords`
--
ALTER TABLE `dentalrecords`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dentaltreatments`
--
ALTER TABLE `dentaltreatments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `diags`
--
ALTER TABLE `diags`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `medicalrecords`
--
ALTER TABLE `medicalrecords`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `medicinerecords`
--
ALTER TABLE `medicinerecords`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `odontograms`
--
ALTER TABLE `odontograms`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `costs`
--
ALTER TABLE `costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `dens`
--
ALTER TABLE `dens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `dentalrecords`
--
ALTER TABLE `dentalrecords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `dentaltreatments`
--
ALTER TABLE `dentaltreatments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `diags`
--
ALTER TABLE `diags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `medicalrecords`
--
ALTER TABLE `medicalrecords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `medicinerecords`
--
ALTER TABLE `medicinerecords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT untuk tabel `odontograms`
--
ALTER TABLE `odontograms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
