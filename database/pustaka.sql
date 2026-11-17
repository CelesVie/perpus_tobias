-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: perpus_tobias
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.22.04.5

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_created_at_index` (`created_at`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-12 04:05:18'),(2,1,'borrowing.approved','App\\Models\\Borrowing',6,'Peminjaman PJM-261111-C4X2G disetujui oleh Rani Kusumawardhani.','127.0.0.1','2026-11-12 04:06:11'),(3,1,'borrowing.returned','App\\Models\\Borrowing',5,'Pengembalian PJM-261111-Y4ET8 diproses oleh Rani Kusumawardhani. Denda Rp13000.','127.0.0.1','2026-11-12 04:06:26'),(4,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-12 04:24:40'),(5,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-12 04:25:06'),(6,1,'borrowing.returned','App\\Models\\Borrowing',4,'Pengembalian PJM-261111-JFDQM diproses oleh Rani Kusumawardhani. Denda Rp1000.','127.0.0.1','2026-11-12 04:30:57'),(7,1,'borrowing.returned','App\\Models\\Borrowing',6,'Pengembalian PJM-261111-C4X2G diproses oleh Rani Kusumawardhani. Tepat waktu.','127.0.0.1','2026-11-12 04:31:39'),(8,1,'settings.updated',NULL,NULL,'Pengaturan aplikasi diperbarui.','127.0.0.1','2026-11-12 06:33:13'),(9,2,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-12 16:31:21'),(10,2,'borrowing.requested','App\\Models\\Borrowing',10,'Bagas Prakoso mengajukan peminjaman \"Pemrograman Web dengan PHP dan MySQL\".','127.0.0.1','2026-11-12 16:32:36'),(11,2,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-12 16:32:50'),(12,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-12 16:33:02'),(13,1,'borrowing.returned','App\\Models\\Borrowing',1,'Pengembalian PJM-261111-LSVWI diproses oleh Rani Kusumawardhani. Tepat waktu.','127.0.0.1','2026-11-12 16:34:11'),(14,1,'borrowing.rejected','App\\Models\\Borrowing',10,'Peminjaman PJM-261112-BFZ6G ditolak oleh Rani Kusumawardhani.','127.0.0.1','2026-11-12 16:34:59'),(15,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-12 16:35:06'),(16,2,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-12 16:35:15'),(17,2,'borrowing.requested','App\\Models\\Borrowing',11,'Bagas Prakoso mengajukan peminjaman \"Rich Dad Poor Dad\".','127.0.0.1','2026-11-12 18:33:53'),(18,2,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-12 18:33:59'),(19,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-12 18:34:08'),(20,2,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-13 14:42:56'),(21,2,'borrowing.requested','App\\Models\\Borrowing',12,'Bagas Prakoso mengajukan peminjaman \"Pedoman Penulisan Karya Ilmiah\".','127.0.0.1','2026-11-13 14:45:03'),(22,2,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-13 14:45:13'),(23,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-13 14:45:22'),(24,1,'book.updated','App\\Models\\Book',21,'Buku \"Rich Dad Poor Dad\" diperbarui.','127.0.0.1','2026-11-13 14:46:45'),(25,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-13 14:47:27'),(26,2,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-13 14:47:41'),(27,2,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-13 15:42:52'),(28,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-13 15:43:03'),(29,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-13 15:43:10'),(30,2,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-13 15:43:18'),(31,2,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-13 15:44:26'),(32,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-13 15:44:51'),(33,1,'borrowing.approved','App\\Models\\Borrowing',11,'Peminjaman PJM-261113-Z9PKP disetujui oleh Rani Kusumawardhani.','127.0.0.1','2026-11-13 15:44:59'),(34,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-13 15:45:03'),(35,2,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-13 15:45:13'),(36,2,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-13 15:49:26'),(37,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-13 15:49:36'),(38,1,'member.toggled','App\\Models\\User',9,'Akun Damar Wicaksono diaktifkan.','127.0.0.1','2026-11-13 15:50:08'),(39,1,'member.toggled','App\\Models\\User',9,'Akun Damar Wicaksono dinonaktifkan.','127.0.0.1','2026-11-13 15:50:11'),(40,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-13 16:03:25'),(41,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-16 08:34:03'),(42,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-16 11:28:52'),(43,1,'member.deleted',NULL,NULL,'Akun anggota Yoga Pratama dihapus permanen.','127.0.0.1','2026-11-16 13:05:41'),(44,1,'member.deleted',NULL,NULL,'Akun anggota Damar Wicaksono dihapus permanen.','127.0.0.1','2026-11-16 13:05:51'),(45,1,'book.updated','App\\Models\\Book',21,'Buku \"Rich Dad Poor Dad\" diperbarui.','127.0.0.1','2026-11-16 14:29:44'),(46,1,'borrowing.approved','App\\Models\\Borrowing',12,'Peminjaman PJM-261113-TQ5JZ disetujui oleh Rani Kusumawardhani.','127.0.0.1','2026-11-16 17:24:41'),(47,1,'borrowing.returned','App\\Models\\Borrowing',2,'Pengembalian PJM-261111-NLCBD diproses oleh Rani Kusumawardhani. Denda Rp4000.','127.0.0.1','2026-11-16 17:25:42'),(48,1,'fine.paid','App\\Models\\Fine',1,'Denda #1 ditandai lunas oleh Rani Kusumawardhani.','127.0.0.1','2026-11-16 17:26:02'),(49,1,'borrowing.returned','App\\Models\\Borrowing',12,'Pengembalian PJM-261113-TQ5JZ diproses oleh Rani Kusumawardhani. Tepat waktu.','127.0.0.1','2026-11-16 17:26:20'),(50,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-16 17:40:56'),(51,2,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-16 17:41:05'),(52,2,'borrowing.requested','App\\Models\\Borrowing',13,'Bagas Prakoso mengajukan peminjaman \"Kamus Besar Bahasa Indonesia\".','127.0.0.1','2026-11-16 17:42:37'),(53,2,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-16 18:03:31'),(54,10,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-16 19:35:12'),(55,10,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-16 19:35:50'),(56,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-16 19:36:01'),(57,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-16 19:36:31'),(58,4,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-16 19:37:03'),(59,4,'borrowing.requested','App\\Models\\Borrowing',14,'Fajar Ramadhan mengajukan peminjaman \"Kamus Besar Bahasa Indonesia\".','127.0.0.1','2026-11-16 19:37:34');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `authors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `authors_slug_unique` (`slug`),
  KEY `authors_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` VALUES (1,'Andrea Hirata','andrea-hirata','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(2,'Pramoedya Ananta Toer','pramoedya-ananta-toer','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(3,'Eka Kurniawan','eka-kurniawan','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(4,'Dee Lestari','dee-lestari','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(5,'Leila S. Chudori','leila-s-chudori','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(6,'Tere Liye','tere-liye','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(7,'Ayu Utami','ayu-utami','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(8,'Ahmad Tohari','ahmad-tohari','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(9,'Budi Darma','budi-darma','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(10,'M.C. Ricklefs','mc-ricklefs','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(11,'Tan Malaka','tan-malaka','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(12,'Denys Lombard','denys-lombard','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(13,'Ahmad Mansur Suryanegara','ahmad-mansur-suryanegara','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(14,'Carl Sagan','carl-sagan','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(15,'Yuval Noah Harari','yuval-noah-harari','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(16,'Tim Penyusun','tim-penyusun','Kredit penulis belum diverifikasi; entri ini bersifat data contoh.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(17,'Robert C. Martin','robert-c-martin','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(18,'Rinaldi Munir','rinaldi-munir','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(19,'Budi Raharjo','budi-raharjo','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(20,'Robert T. Kiyosaki','robert-t-kiyosaki','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(21,'Dumairy','dumairy','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(22,'Sugiyono','sugiyono','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(23,'Slameto','slameto','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(24,'Badan Pengembangan dan Pembinaan Bahasa','badan-pengembangan-dan-pembinaan-bahasa','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(25,'Anton M. Moeliono','anton-m-moeliono','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(26,'M. Quraish Shihab','m-quraish-shihab','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(27,'Sayyid Sabiq','sayyid-sabiq','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL);
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_author`
--

DROP TABLE IF EXISTS `book_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book_author` (
  `book_id` bigint unsigned NOT NULL,
  `author_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`book_id`,`author_id`),
  KEY `book_author_author_id_foreign` (`author_id`),
  CONSTRAINT `book_author_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_author_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_author`
--

LOCK TABLES `book_author` WRITE;
/*!40000 ALTER TABLE `book_author` DISABLE KEYS */;
INSERT INTO `book_author` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10),(11,11),(12,12),(13,13),(14,14),(15,15),(16,16),(20,16),(29,16),(30,16),(31,16),(32,16),(17,17),(18,18),(19,19),(21,20),(22,21),(23,22),(24,23),(25,24),(26,25),(27,26),(28,27);
/*!40000 ALTER TABLE `book_author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint unsigned NOT NULL,
  `publisher_id` bigint unsigned DEFAULT NULL,
  `publication_year` smallint unsigned DEFAULT NULL,
  `page_count` smallint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_copies` smallint unsigned NOT NULL DEFAULT '1',
  `available_copies` smallint unsigned NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `view_count` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `books_slug_unique` (`slug`),
  UNIQUE KEY `books_isbn_unique` (`isbn`),
  KEY `books_publisher_id_foreign` (`publisher_id`),
  KEY `books_category_id_available_copies_index` (`category_id`,`available_copies`),
  KEY `books_title_index` (`title`),
  KEY `books_publication_year_index` (`publication_year`),
  KEY `books_available_copies_index` (`available_copies`),
  CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `books_publisher_id_foreign` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'Laskar Pelangi','laskar-pelangi-1',NULL,1,1,2005,529,'Kisah sepuluh anak Belitung yang berjuang mendapat pendidikan layak di tengah keterbatasan.',NULL,2,2,1,120,'2026-11-11 12:10:31','2026-11-12 16:34:11',NULL),(2,'Bumi Manusia','bumi-manusia-2',NULL,2,2,1980,535,'Kisah Minke pada akhir masa kolonial, tentang cinta, kelas sosial, dan kebangkitan kesadaran pribumi.',NULL,3,3,0,118,'2026-11-11 12:10:31','2026-11-16 17:25:42',NULL),(3,'Cantik Itu Luka','cantik-itu-luka-3',NULL,1,3,2002,520,'Saga keluarga Dewi Ayu yang memikat, kelam, dan penuh kejutan sejarah.',NULL,4,3,0,114,'2026-11-11 12:10:31','2026-11-11 12:10:34',NULL),(4,'Perahu Kertas','perahu-kertas-4',NULL,1,1,2009,444,'Dua anak muda berbagi mimpi dan harus memilih antara cita-cita dan perasaan.',NULL,5,5,0,111,'2026-11-11 12:10:31','2026-11-12 04:30:57',NULL),(5,'Pulang','pulang-5',NULL,1,4,2013,552,'Kisah eksil politik 1965 dan generasi sesudahnya yang mencari jalan pulang.',NULL,2,2,0,108,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(6,'Hujan','hujan-6',NULL,1,3,2018,320,'Lail dan Esok bertahan melewati bencana dan luka, dalam dunia yang terus berubah.',NULL,3,3,0,105,'2026-11-11 12:10:31','2026-11-12 04:06:26',NULL),(7,'Saman','saman-7',NULL,2,4,1998,200,'Empat perempuan Jakarta dan seorang pemuda misterius di akhir Orde Baru.',NULL,4,4,1,102,'2026-11-11 12:10:31','2026-11-12 04:31:39',NULL),(8,'Ronggeng Dukuh Paruk','ronggeng-dukuh-paruk-8',NULL,2,3,1982,400,'Srintil, ronggeng cilik, dan kisah duka sebuah dusun di pedalaman Jawa.',NULL,5,5,0,99,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(9,'Orang-Orang Bloomington','orang-orang-bloomington-9',NULL,2,5,1980,175,'Sebelas cerita pendek tentang kesepian orang Indonesia di kota kecil Amerika.',NULL,2,2,0,96,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(10,'Sejarah Indonesia Modern','sejarah-indonesia-modern-10',NULL,3,6,2008,865,'Uraian komprehensif sejarah Indonesia dari abad ke-13 hingga era reformasi.',NULL,3,3,0,94,'2026-11-11 12:10:31','2026-11-12 04:04:25',NULL),(11,'Madilog','madilog-11',NULL,3,7,2016,564,'Materialisme, dialektika, dan logika sebagai cara berpikir yang dibangun Tan Malaka dari penjara.',NULL,4,4,0,92,'2026-11-11 12:10:31','2026-11-16 08:32:49',NULL),(12,'Nusa Jawa: Silang Budaya','nusa-jawa-silang-budaya-12',NULL,3,3,1996,640,'Kajian Denys Lombard tentang jaringan Asia dan akar budaya Jawa.',NULL,5,5,0,87,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(13,'Api Sejarah Nusantara','api-sejarah-nusantara-13',NULL,3,8,2013,532,'Rekonstruksi peran ulama dan santri dalam perjuangan kemerdekaan Indonesia.',NULL,2,2,1,84,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(14,'Kosmos','kosmos-14',NULL,4,4,2016,488,'Penjelajahan tentang alam semesta, evolusi bintang, dan tempat manusia di dalamnya.',NULL,3,3,0,81,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(15,'Sapiens: Riwayat Singkat Umat Manusia','sapiens-riwayat-singkat-umat-manusia-15',NULL,4,4,2017,524,'Rentang sejarah Homo sapiens dari pemburu-peramu hingga peradaban modern.',NULL,4,4,0,79,'2026-11-11 12:10:31','2026-11-16 19:51:41',NULL),(16,'Energi Terbarukan di Indonesia','energi-terbarukan-di-indonesia-16',NULL,4,9,2019,288,'Peta potensi dan tantangan transisi energi di Indonesia.',NULL,5,5,0,75,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(17,'Clean Code','clean-code-17',NULL,5,10,2008,464,'Prinsip dan praktik menulis kode yang mudah dibaca serta dipelihara.',NULL,2,2,0,73,'2026-11-11 12:10:31','2026-11-11 19:15:12',NULL),(18,'Algoritma dan Pemrograman','algoritma-dan-pemrograman-18',NULL,5,11,2011,408,'Dasar perancangan algoritma, struktur data, dan penyelesaian masalah secara sistematis.',NULL,3,3,0,69,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(19,'Pemrograman Web dengan PHP dan MySQL','pemrograman-web-dengan-php-dan-mysql-19',NULL,5,11,2016,356,'Langkah praktis membangun aplikasi web dinamis dengan PHP dan MySQL.',NULL,4,4,1,67,'2026-11-11 12:10:32','2026-11-12 16:32:33',NULL),(20,'Dasar-Dasar Ilmu Ekonomi','dasar-dasar-ilmu-ekonomi-20',NULL,6,12,2004,490,'Pengantar mikro dan makroekonomi untuk mahasiswa tahun pertama.',NULL,5,5,0,63,'2026-11-11 12:10:32','2026-11-11 12:10:32',NULL),(21,'Rich Dad Poor Dad','rich-dad-poor-dad-21',NULL,6,3,1997,256,'Dua pola pikir tentang uang dan pengelolaan aset keluarga.','covers/4OerWB9OAcynZ9ydm0FhSPu1Zu2AkgJ35zY6YjOM.jpg',2,1,0,65,'2026-11-11 12:10:32','2026-11-16 14:29:53',NULL),(22,'Perekonomian Indonesia','perekonomian-indonesia-22',NULL,6,13,2012,380,'Analisis kebijakan fiskal, moneter, dan pembangunan ekonomi nasional.',NULL,3,3,0,57,'2026-11-11 12:10:32','2026-11-11 12:10:32',NULL),(23,'Metode Penelitian Kuantitatif','metode-penelitian-kuantitatif-23',NULL,7,14,2013,334,'Prosedur penelitian kuantitatif dari perumusan masalah hingga pelaporan.',NULL,4,4,0,54,'2026-11-11 12:10:32','2026-11-11 12:10:32',NULL),(24,'Belajar dan Faktor yang Mempengaruhinya','belajar-dan-faktor-yang-mempengaruhinya-24',NULL,7,15,2010,195,'Kajian psikologis tentang proses belajar dan faktor pendukungnya.',NULL,5,5,0,51,'2026-11-11 12:10:32','2026-11-11 12:10:32',NULL),(25,'Kamus Besar Bahasa Indonesia','kamus-besar-bahasa-indonesia-25',NULL,8,16,2016,1700,'Rujukan makna, ejaan, dan pemakaian kata dalam bahasa Indonesia.',NULL,2,2,1,50,'2026-11-11 12:10:32','2026-11-16 19:37:27',NULL),(26,'Tata Bahasa Baku Bahasa Indonesia','tata-bahasa-baku-bahasa-indonesia-26',NULL,8,16,2017,520,'Pedoman baku tata bahasa Indonesia untuk penulisan formal.',NULL,3,3,0,45,'2026-11-11 12:10:32','2026-11-11 12:10:32',NULL),(27,'Tafsir Al-Misbah Jilid 1','tafsir-al-misbah-jilid-1-27',NULL,9,17,2000,640,'Penafsiran Al-Qur\'an dengan pendekatan bahasa dan konteks sosial.',NULL,4,4,0,42,'2026-11-11 12:10:32','2026-11-11 12:10:32',NULL),(28,'Fiqih Sunnah Jilid 2','fiqih-sunnah-jilid-2-28',NULL,9,18,2006,712,'Pembahasan fikih ibadah dan muamalah berdasarkan dalil.',NULL,5,5,0,39,'2026-11-11 12:10:32','2026-11-11 12:10:32',NULL),(29,'Cerita Rakyat Nusantara','cerita-rakyat-nusantara-29',NULL,10,19,2014,180,'Kumpulan cerita rakyat dari berbagai daerah dengan pesan moral.',NULL,2,2,0,37,'2026-11-11 12:10:32','2026-11-16 08:32:16',NULL),(30,'Kecil-Kecil Punya Karya','kecil-kecil-punya-karya-30',NULL,10,20,2018,160,'Antologi cerita anak tentang persahabatan dan keberanian.',NULL,3,3,0,33,'2026-11-11 12:10:32','2026-11-11 12:10:32',NULL),(31,'Sejarah Seni Rupa Indonesia','sejarah-seni-rupa-indonesia-31',NULL,11,21,1979,240,'Catatan perkembangan seni rupa Indonesia dari masa klasik hingga modern.',NULL,4,4,1,30,'2026-11-11 12:10:32','2026-11-11 12:10:32',NULL),(32,'Pedoman Penulisan Karya Ilmiah','pedoman-penulisan-karya-ilmiah-32',NULL,12,22,2019,210,'Panduan teknis penulisan karya ilmiah dan tata cara sitasi.',NULL,5,5,0,30,'2026-11-11 12:10:32','2026-11-16 17:26:20',NULL);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrowings`
--

DROP TABLE IF EXISTS `borrowings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `borrowings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `book_id` bigint unsigned NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'requested',
  `requested_at` timestamp NOT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `due_at` timestamp NULL DEFAULT NULL,
  `returned_at` timestamp NULL DEFAULT NULL,
  `processed_by` bigint unsigned DEFAULT NULL,
  `member_note` text COLLATE utf8mb4_unicode_ci,
  `reject_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `borrowings_code_unique` (`code`),
  KEY `borrowings_processed_by_foreign` (`processed_by`),
  KEY `borrowings_user_id_status_index` (`user_id`,`status`),
  KEY `borrowings_book_id_status_index` (`book_id`,`status`),
  KEY `borrowings_status_index` (`status`),
  KEY `borrowings_due_at_index` (`due_at`),
  CONSTRAINT `borrowings_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `borrowings_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `borrowings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowings`
--

LOCK TABLES `borrowings` WRITE;
/*!40000 ALTER TABLE `borrowings` DISABLE KEYS */;
INSERT INTO `borrowings` VALUES (1,'PJM-261111-LSVWI',2,1,'returned','2026-11-06 12:10:34','2026-11-07 12:10:34','2026-11-14 12:10:34','2026-11-12 16:34:11',1,NULL,NULL,'2026-11-11 12:10:34','2026-11-12 16:34:11'),(2,'PJM-261111-NLCBD',3,2,'returned','2026-11-06 12:10:34','2026-11-07 12:10:34','2026-11-13 12:10:34','2026-11-16 17:25:42',1,NULL,NULL,'2026-11-11 12:10:34','2026-11-16 17:25:42'),(3,'PJM-261111-OVYO3',4,3,'approved','2026-11-06 12:10:34','2026-11-07 12:10:34','2026-11-12 12:10:34',NULL,1,NULL,NULL,'2026-11-11 12:10:34','2026-11-11 12:10:34'),(4,'PJM-261111-JFDQM',5,4,'returned','2026-11-06 12:10:34','2026-11-07 12:10:34','2026-11-11 12:10:34','2026-11-12 04:30:57',1,NULL,NULL,'2026-11-11 12:10:34','2026-11-12 04:30:57'),(5,'PJM-261111-Y4ET8',6,6,'returned','2026-10-22 12:10:34','2026-10-23 12:10:34','2026-10-30 12:10:34','2026-11-12 04:06:26',1,NULL,NULL,'2026-11-11 12:10:34','2026-11-12 04:06:26'),(6,'PJM-261111-C4X2G',7,7,'returned','2026-11-11 06:10:34','2026-11-12 04:06:11','2026-11-19 04:06:11','2026-11-12 04:31:39',1,'Untuk tugas akhir, mohon disetujui.',NULL,'2026-11-11 12:10:34','2026-11-12 04:31:39'),(7,'PJM-261111-UIT7P',3,8,'rejected','2026-11-08 12:10:34',NULL,NULL,NULL,1,NULL,'Anggota masih memiliki pinjaman terlambat.','2026-11-11 12:10:34','2026-11-11 12:10:34'),(8,'PJM-261111-KXHUU',4,9,'returned','2026-10-12 12:10:34','2026-10-13 12:10:34','2026-10-20 12:10:34','2026-10-24 12:10:34',1,NULL,NULL,'2026-11-11 12:10:34','2026-11-11 12:10:34'),(9,'PJM-261111-N956S',5,10,'returned','2026-09-12 12:10:34','2026-09-13 12:10:34','2026-09-20 12:10:34','2026-09-22 12:10:34',1,NULL,NULL,'2026-11-11 12:10:34','2026-11-11 12:10:34'),(10,'PJM-261112-BFZ6G',2,19,'rejected','2026-11-12 16:32:36',NULL,NULL,NULL,1,NULL,'minjem mulu anying','2026-11-12 16:32:36','2026-11-12 16:34:59'),(11,'PJM-261113-Z9PKP',2,21,'approved','2026-11-12 18:33:53','2026-11-13 15:44:59','2026-11-20 15:44:59',NULL,1,'gua pengen baca buku ini',NULL,'2026-11-12 18:33:53','2026-11-13 15:44:59'),(12,'PJM-261113-TQ5JZ',2,32,'returned','2026-11-13 14:45:03','2026-11-16 17:24:41','2026-11-23 17:24:41','2026-11-16 17:26:20',1,NULL,NULL,'2026-11-13 14:45:03','2026-11-16 17:26:20'),(13,'PJM-261117-B3GYY',2,25,'requested','2026-11-16 17:42:37',NULL,NULL,NULL,NULL,'untuk dapat mengetahui beberapa makna kata',NULL,'2026-11-16 17:42:37','2026-11-16 17:42:37'),(14,'PJM-261117-4YV2Q',4,25,'requested','2026-11-16 19:37:34',NULL,NULL,NULL,NULL,NULL,NULL,'2026-11-16 19:37:34','2026-11-16 19:37:34');
/*!40000 ALTER TABLE `borrowings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('pustaka-cache-1b6453892473a467d07372d45eb05abc2031647a','i:1;',1794857914),('pustaka-cache-1b6453892473a467d07372d45eb05abc2031647a:timer','i:1794857914;',1794857914),('pustaka-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0','i:1;',1794851017),('pustaka-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer','i:1794851017;',1794851017),('pustaka-cache-setting.fine_per_day','s:4:\"1000\";',2109825194),('pustaka-cache-setting.library_address','s:26:\"Jl. Wisma Tajur, Tangerang\";',2109825194),('pustaka-cache-setting.library_email','s:17:\"halo@pustaka.test\";',2109825194),('pustaka-cache-setting.library_name','s:17:\"Pustaka Nusantara\";',2109825194),('pustaka-cache-setting.library_phone','s:15:\"(022) 8842 1901\";',2109825194),('pustaka-cache-setting.library_tagline','s:29:\"Ilmu yang terbuka untuk semua\";',2109825194),('pustaka-cache-setting.loan_duration_days','s:1:\"7\";',2109825194),('pustaka-cache-setting.max_active_loans','s:1:\"3\";',2109825194),('pustaka-cache-setting.max_fine_days','s:2:\"30\";',2109825194);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Fiksi','fiksi','Prosa rekaan yang menghibur sekaligus membuka perspektif baru.','2026-11-11 12:10:30','2026-11-11 12:10:30',NULL),(2,'Sastra','sastra','Karya sastra Indonesia dan dunia yang menjadi rujukan.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(3,'Sejarah','sejarah','Kajian sejarah nasional dan dunia.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(4,'Sains','sains','Populer sains dan buku teks dasar.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(5,'Teknologi','teknologi','Buku komputer, rekayasa, dan pemrograman.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(6,'Ekonomi','ekonomi','Ilmu ekonomi, keuangan, dan pembangunan.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(7,'Pendidikan','pendidikan','Teori pendidikan dan metode pengajaran.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(8,'Bahasa','bahasa','Kamus, tata bahasa, dan keterampilan berbahasa.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(9,'Agama','agama','Kajian keagamaan dan tafsir.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(10,'Buku Anak','buku-anak','Bacaan ringan untuk pembaca awal.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(11,'Seni','seni','Seni rupa, musik, dan pertunjukan.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(12,'Referensi','referensi','Ensiklopedia, pedoman, dan buku rujukan.','2026-11-11 12:10:31','2026-11-11 12:10:31',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fines`
--

DROP TABLE IF EXISTS `fines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fines` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `borrowing_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `days_late` int unsigned NOT NULL,
  `amount` int unsigned NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fines_borrowing_id_unique` (`borrowing_id`),
  KEY `fines_user_id_foreign` (`user_id`),
  KEY `fines_status_index` (`status`),
  CONSTRAINT `fines_borrowing_id_foreign` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fines_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fines`
--

LOCK TABLES `fines` WRITE;
/*!40000 ALTER TABLE `fines` DISABLE KEYS */;
INSERT INTO `fines` VALUES (1,8,4,4,4000,'paid','2026-11-16 17:26:02','2026-11-11 12:10:34','2026-11-16 17:26:02'),(2,9,5,2,2000,'paid','2026-09-23 12:10:34','2026-11-11 12:10:34','2026-11-11 12:10:34'),(3,5,6,13,13000,'unpaid',NULL,'2026-11-12 04:06:26','2026-11-12 04:06:26'),(4,4,5,1,1000,'unpaid',NULL,'2026-11-12 04:30:57','2026-11-12 04:30:57'),(5,2,3,4,4000,'unpaid',NULL,'2026-11-16 17:25:42','2026-11-16 17:25:42');
/*!40000 ALTER TABLE `fines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_11_11_000001_add_library_fields_to_users_table',1),(5,'2026_11_11_000002_create_categories_table',1),(6,'2026_11_11_000003_create_authors_table',1),(7,'2026_11_11_000004_create_publishers_table',1),(8,'2026_11_11_000005_create_books_table',1),(9,'2026_11_11_000006_create_book_author_table',1),(10,'2026_11_11_000007_create_borrowings_table',1),(11,'2026_11_11_000008_create_fines_table',1),(12,'2026_11_11_000009_create_settings_table',1),(13,'2026_11_11_000010_create_activity_logs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publishers`
--

DROP TABLE IF EXISTS `publishers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publishers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `publishers_name_unique` (`name`),
  UNIQUE KEY `publishers_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publishers`
--

LOCK TABLES `publishers` WRITE;
/*!40000 ALTER TABLE `publishers` DISABLE KEYS */;
INSERT INTO `publishers` VALUES (1,'Bentang Pustaka','bentang-pustaka',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(2,'Hasta Mitra','hasta-mitra',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(3,'Gramedia Pustaka Utama','gramedia-pustaka-utama',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(4,'Kepustakaan Populer Gramedia','kepustakaan-populer-gramedia',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(5,'Sinar Harapan','sinar-harapan',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(6,'Serambi Ilmu Semesta','serambi-ilmu-semesta',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(7,'Narasi','narasi',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(8,'Salamadani','salamadani',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(9,'Penerbit ITB','penerbit-itb',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(10,'Prentice Hall','prentice-hall',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(11,'Informatika','informatika',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(12,'Rajawali Pers','rajawali-pers',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(13,'Erlangga','erlangga',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(14,'Alfabeta','alfabeta',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(15,'Rineka Cipta','rineka-cipta',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(16,'Balai Pustaka','balai-pustaka',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(17,'Lentera Hati','lentera-hati',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(18,'Pustaka Al-Kautsar','pustaka-al-kautsar',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(19,'Yudhistira','yudhistira',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(20,'Mizan','mizan',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(21,'Departemen Pendidikan','departemen-pendidikan',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL),(22,'Universitas Negeri Malang','universitas-negeri-malang',NULL,'2026-11-11 12:10:31','2026-11-11 12:10:31',NULL);
/*!40000 ALTER TABLE `publishers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('Ei3uRY5yXJcF6pMUn6lj4vstizfUquG9tRC9A9PP',4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJlQlZQOFlXcUJ6RWVWeTQzWDJwQUlEbnRSS09sNVFySmI0MXBodUlYIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL21lbWJlclwvZGFzaGJvYXJkIiwicm91dGUiOiJtZW1iZXIuZGFzaGJvYXJkIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo0LCJwYXNzd29yZF9oYXNoX3dlYiI6IjUyYTNjNmY1Y2NmMmJmODI5M2YyNThmZGJhOWQxMmU5YjQzNDAxNjNjNWJlYjk2Mzg3ZjgyYTFkYzM0NmI5NGEifQ==',1794858711);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('fine_per_day','1000','2026-11-11 12:10:30','2026-11-11 12:10:30'),('library_address','Jl. Wisma Tajur, Tangerang','2026-11-11 12:10:30','2026-11-12 06:33:13'),('library_email','halo@pustaka.test','2026-11-11 12:10:30','2026-11-11 12:10:30'),('library_name','Pustaka Nusantara','2026-11-11 12:10:30','2026-11-11 12:10:30'),('library_phone','(022) 8842 1901','2026-11-11 12:10:30','2026-11-11 12:10:30'),('library_tagline','Ilmu yang terbuka untuk semua','2026-11-11 12:10:30','2026-11-11 12:10:30'),('loan_duration_days','7','2026-11-11 12:10:30','2026-11-11 12:10:30'),('max_active_loans','3','2026-11-11 12:10:30','2026-11-11 12:10:30'),('max_fine_days','30','2026-11-11 12:10:30','2026-11-11 12:10:30');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `joined_at` date DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_member_number_unique` (`member_number`),
  KEY `users_role_index` (`role`),
  KEY `users_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Rani Kusumawardhani','admin@pustaka.test',NULL,'2026-11-11 12:10:32','$2y$12$kXo8fSyQT9t1nFI.zX7JIelQxNvJkFASSHwo/3OlGu39wumnw07wW','admin',1,'081200000001','Jl. Kartini No. 8, Bandung','2023-11-11',NULL,'2026-11-11 12:10:32','2026-11-11 12:10:32',NULL),(2,'Bagas Prakoso','bagas.prakoso@example.test',NULL,'2026-11-11 12:10:32','$2y$12$Fo1SqcxMc9OQltEWyvfJ0.xScRcQaOOJVMn8eBH/5r8Vv1XwEpxh6','member',1,'081300000000','Jl. Merdeka No. 3, Bandung','2026-10-11',NULL,'2026-11-11 12:10:32','2026-11-11 12:10:32',NULL),(3,'Nadia Ayuningtyas','nadia.ayuningtyas@example.test',NULL,'2026-11-11 12:10:32','$2y$12$IDA4CccIlN5.fdfhlFJmYuN3fQ.FVN1FjiOHuKC5zG7wTinsaBR6m','member',1,'081300000001','Jl. Merdeka No. 4, Bandung','2026-09-11',NULL,'2026-11-11 12:10:33','2026-11-11 12:10:33',NULL),(4,'Fajar Ramadhan','fajar.ramadhan@example.test',NULL,'2026-11-11 12:10:33','$2y$12$SCN4D8Op3bmBg78brSOBJ.JHcGyXLVMaKCC78Jzfyeb8TSPcbGE0u','member',1,'081300000002','Jl. Merdeka No. 5, Bandung','2026-08-11',NULL,'2026-11-11 12:10:33','2026-11-11 12:10:33',NULL),(5,'Sinta Maharani','sinta.maharani@example.test',NULL,'2026-11-11 12:10:33','$2y$12$SZXXi3MwpU21oujEnWjY8uG2sOqt4iRo9HjgtkWC83bMOOgaaBWbS','member',1,'081300000003','Jl. Merdeka No. 6, Bandung','2026-07-11',NULL,'2026-11-11 12:10:33','2026-11-11 12:10:33',NULL),(6,'Rizky Hidayat','rizky.hidayat@example.test',NULL,'2026-11-11 12:10:33','$2y$12$f0mxf1Ipwh93UkDDPEOoceulRWGnPlWz5D9X8SJeR8X4mFhL3Kacq','member',1,'081300000004','Jl. Merdeka No. 7, Bandung','2026-06-11',NULL,'2026-11-11 12:10:33','2026-11-11 12:10:33',NULL),(7,'Melati Putri','melati.putri@example.test',NULL,'2026-11-11 12:10:33','$2y$12$j9eX9K/7pfIr0w7EmKtqUOPhORjM52DmEwGs3ugojwnmws07KsipS','member',1,'081300000005','Jl. Merdeka No. 8, Bandung','2026-05-11',NULL,'2026-11-11 12:10:34','2026-11-11 12:10:34',NULL),(10,'Jokowi Wowo','jokowow@pustaka.test',NULL,'2026-11-16 19:32:40','$2y$12$cyvGzVd7/Vs5ggRjl.Bs/.z71.sazULpZqY5/HWqtn7I97.sL/rqm','admin',1,NULL,NULL,'2026-11-17',NULL,'2026-11-16 19:32:41','2026-11-16 19:32:41',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-17  7:47:35
