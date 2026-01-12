-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_mbg
DROP DATABASE IF EXISTS `db_mbg`;
CREATE DATABASE IF NOT EXISTS `db_mbg` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_mbg`;

-- Dumping structure for table db_mbg.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mbg.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table db_mbg.manajemen_sekolah
DROP TABLE IF EXISTS `manajemen_sekolah`;
CREATE TABLE IF NOT EXISTS `manajemen_sekolah` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `npsn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenjang` enum('SD','SMP','SMA','SMK') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Negeri','Swasta') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_porsi` int NOT NULL DEFAULT '0',
  `kepala_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_siswa` int DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `manajemen_sekolah_npsn_unique` (`npsn`),
  KEY `manajemen_sekolah_user_id_foreign` (`user_id`),
  CONSTRAINT `manajemen_sekolah_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mbg.manajemen_sekolah: ~2 rows (approximately)
REPLACE INTO `manajemen_sekolah` (`id`, `user_id`, `foto`, `nama_sekolah`, `npsn`, `jenjang`, `status`, `alamat`, `kecamatan`, `jumlah_porsi`, `kepala_sekolah`, `jumlah_siswa`, `telepon`, `created_at`, `updated_at`) VALUES
	(1, 2, 'sekolah/KCM0mdKYveFNY9KhCEEU2KWat5rG9QkfC3w0JNF5.png', 'SMAN 4 KARAWANG', '20217765', 'SMA', 'Negeri', 'Jl. Jend.Ahmad Yani', 'Kec. Karawang Barat', 200, NULL, NULL, NULL, '2026-01-06 23:47:42', '2026-01-10 22:18:47'),
	(2, 3, 'sekolah/d1EAknDciNyQF8cosmO9uOuameQH5fkzeYtJJDql.png', 'SMAN1 KARAWANG', '12345', 'SMA', 'Negeri', 'Jl.Jend. Ahmad Yani', 'Kec. Karawang Barat', 100, NULL, NULL, NULL, '2026-01-08 00:56:40', '2026-01-08 00:56:40');

-- Dumping structure for table db_mbg.mbg_hari
DROP TABLE IF EXISTS `mbg_hari`;
CREATE TABLE IF NOT EXISTS `mbg_hari` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `hari` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mbg.mbg_hari: ~7 rows (approximately)
REPLACE INTO `mbg_hari` (`id`, `tanggal`, `hari`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, '2026-01-12', 'Senin', 1, '2026-01-08 07:13:18', '2026-01-08 07:13:18'),
	(2, '2026-01-13', 'Selasa', 1, '2026-01-08 07:16:08', '2026-01-08 07:16:08'),
	(3, '2026-01-14', 'Rabu', 1, '2026-01-08 07:16:15', '2026-01-08 07:16:15'),
	(4, '2026-01-15', 'Kamis', 1, '2026-01-08 07:16:24', '2026-01-08 07:16:24'),
	(5, '2026-01-16', 'Jumat', 1, '2026-01-08 07:16:33', '2026-01-08 07:16:33'),
	(6, '2026-01-17', 'Sabtu', 0, '2026-01-08 07:16:40', '2026-01-08 09:41:35'),
	(7, '2026-01-18', 'Minggu', 0, '2026-01-08 07:16:59', '2026-01-08 09:42:02');

-- Dumping structure for table db_mbg.mbg_keluhan
DROP TABLE IF EXISTS `mbg_keluhan`;
CREATE TABLE IF NOT EXISTS `mbg_keluhan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sekolah_id` bigint unsigned NOT NULL,
  `kategori` enum('Kualitas Makanan','Keterlambatan','Kurang','Kebersihan','Lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Belum Diproses','Diproses','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Diproses',
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mbg_keluhan_sekolah_id_foreign` (`sekolah_id`),
  CONSTRAINT `mbg_keluhan_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `manajemen_sekolah` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mbg.mbg_keluhan: ~2 rows (approximately)
REPLACE INTO `mbg_keluhan` (`id`, `sekolah_id`, `kategori`, `deskripsi`, `foto`, `status`, `tanggal`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Kualitas Makanan', 'Menu hari ini tidak fresh kondisinya', 'keluhan/ULk41gBy65jaIUSv3PnP5rrL0XLwijfskJDEJvMC.jpg', 'Selesai', '2026-01-09', '2026-01-09 09:29:17', '2026-01-10 08:31:58'),
	(2, 2, 'Kebersihan', 'Tempat makannya kurang bersih', 'keluhan/LzVWQwlpGkO7ijLWbU40BCdoqn58Yr821SAfxSku.jpg', 'Diproses', '2026-01-12', '2026-01-09 19:50:52', '2026-01-09 21:07:56');

-- Dumping structure for table db_mbg.mbg_laporan_harian
DROP TABLE IF EXISTS `mbg_laporan_harian`;
CREATE TABLE IF NOT EXISTS `mbg_laporan_harian` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sekolah_id` bigint unsigned NOT NULL,
  `menu_id` bigint unsigned DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_lapor` time DEFAULT NULL,
  `jumlah_porsi` int NOT NULL,
  `jumlah_sisa` int NOT NULL DEFAULT '0',
  `status` enum('Pending','Belum Verifikasi','Terverifikasi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `rating` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kendala` enum('Tidak Ada','Terlambat','Porsi Kurang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tidak Ada',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mbg_laporan_harian_sekolah_id_tanggal_unique` (`sekolah_id`,`tanggal`),
  KEY `mbg_laporan_harian_menu_id_foreign` (`menu_id`),
  CONSTRAINT `mbg_laporan_harian_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `mbg_menu` (`id`) ON DELETE SET NULL,
  CONSTRAINT `mbg_laporan_harian_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `manajemen_sekolah` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mbg.mbg_laporan_harian: ~0 rows (approximately)
REPLACE INTO `mbg_laporan_harian` (`id`, `sekolah_id`, `menu_id`, `tanggal`, `jam_lapor`, `jumlah_porsi`, `jumlah_sisa`, `status`, `rating`, `kendala`, `catatan`, `foto`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2026-01-12', '08:49:00', 100, 100, 'Pending', '4.5', 'Porsi Kurang', 'Menu nya bergizi tetapi terdapat porsi kurang tidak sesuai', 'laporan/8yLwkYCsiUpEJLG5fIp6mIHvB06rPBvJGA8vRvq2.jpg', '2026-01-11 08:51:29', '2026-01-11 08:51:29');

-- Dumping structure for table db_mbg.mbg_menu
DROP TABLE IF EXISTS `mbg_menu`;
CREATE TABLE IF NOT EXISTS `mbg_menu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mbg_hari_id` bigint unsigned NOT NULL,
  `sekolah_id` bigint unsigned NOT NULL,
  `nama_menu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kalori` int NOT NULL,
  `protein` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mbg_menu_mbg_hari_id_foreign` (`mbg_hari_id`),
  KEY `mbg_menu_sekolah_id_foreign` (`sekolah_id`),
  CONSTRAINT `mbg_menu_mbg_hari_id_foreign` FOREIGN KEY (`mbg_hari_id`) REFERENCES `mbg_hari` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mbg_menu_sekolah_id_foreign` FOREIGN KEY (`sekolah_id`) REFERENCES `manajemen_sekolah` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mbg.mbg_menu: ~3 rows (approximately)
REPLACE INTO `mbg_menu` (`id`, `mbg_hari_id`, `sekolah_id`, `nama_menu`, `kalori`, `protein`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Nasi + Ayam + Sayur Sop + Pisang', 15, 30, 1, '2026-01-08 02:05:05', '2026-01-08 02:20:09'),
	(2, 2, 1, 'Roti + Susu + Kol + Permen', 12, 10, 1, '2026-01-08 02:22:51', '2026-01-08 07:49:04'),
	(3, 1, 2, 'Nasi + Ikan + Sayur + Susu + Jeruk', 100, 40, 1, '2026-01-08 03:00:25', '2026-01-08 03:00:25');

-- Dumping structure for table db_mbg.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mbg.migrations: ~12 rows (approximately)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2026_01_05_100157_create_manajemen_sekolah_table', 1),
	(6, '2026_01_08_063426_create_mbg_hari_table', 2),
	(7, '2026_01_08_063537_create_mbg_menu_table', 2),
	(10, '2026_01_08_154413_create_mbg_keluhan_table', 3),
	(12, '2026_01_09_161527_create_notifications_table', 4),
	(13, '2026_01_10_135626_create_mbg_laporan_harian_table', 5),
	(15, '2026_01_10_155430_add_profile_fields_to_manajemen_sekolah', 6),
	(16, '2026_01_11_152738_add_fields_to_mbg_laporan_harian_table', 7);

-- Dumping structure for table db_mbg.notifications
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL COMMENT 'Penerima notif (sekolah / admin)',
  `role` enum('admin','sekolah') COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Contoh: keluhan',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `notifications_role_is_read_index` (`role`,`is_read`),
  KEY `notifications_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mbg.notifications: ~2 rows (approximately)
REPLACE INTO `notifications` (`id`, `user_id`, `role`, `type`, `title`, `message`, `link`, `is_read`, `created_at`) VALUES
	(1, NULL, 'admin', 'laporan_harian', 'Laporan Harian Baru dari Sekolah', 'SMAN 4 KARAWANG mengirim laporan harian untuk tanggal 12 Jan 2026', 'http://127.0.0.1:8000/pemerintah/laporan', 1, '2026-01-10 14:45:28'),
	(2, 1, 'sekolah', 'keluhan', 'Update Status Keluhan', 'Keluhan Anda sekarang berstatus: Selesai', 'http://127.0.0.1:8000/sekolah/keluhan', 1, '2026-01-10 15:31:58'),
	(3, NULL, 'admin', 'laporan_harian', 'Laporan Harian Baru dari Sekolah', 'SMAN 4 KARAWANG mengirim laporan harian untuk tanggal 12 Jan 2026', 'http://127.0.0.1:8000/pemerintah/laporan', 1, '2026-01-11 15:51:29');

-- Dumping structure for table db_mbg.password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mbg.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table db_mbg.personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mbg.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table db_mbg.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','sekolah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sekolah',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mbg.users: ~2 rows (approximately)
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'VIERI SATRIA ARDIANSYAH', 'vierisatriaa08@gmail.com', NULL, '$2y$12$YLRA7v19dOugMNQbCdMzl.167juJ.rggtS8JpdIzW2bRhLgO8XoUC', 'admin', NULL, '2026-01-06 21:41:34', '2026-01-06 21:59:55'),
	(2, 'Faqih', 'faqih@gmail.com', NULL, '$2y$12$gYlslqUidFYcrvSrvLCYMuOnWR4O74QItQe9GbCtoFUw9Bjq8p.hy', 'sekolah', NULL, '2026-01-06 23:00:10', '2026-01-06 23:00:10'),
	(3, 'RAFLI FADHLIKA ARDIANSYAH', 'rafli@gmail.com', NULL, '$2y$12$GqulMgZODUtvjZylX1cfK.jZQJbG6PIRUqf6yOkAWAKkDm1o1hwAW', 'sekolah', NULL, '2026-01-08 00:54:09', '2026-01-08 00:54:09');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
