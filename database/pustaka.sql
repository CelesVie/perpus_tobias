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
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-17 03:38:13'),(2,1,'member.deleted',NULL,NULL,'Akun anggota Yoga Pratama dihapus permanen.','127.0.0.1','2026-11-17 03:40:52'),(3,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-17 03:41:10'),(4,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-17 03:41:19'),(5,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-17 03:41:30'),(6,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-17 03:42:06'),(7,1,'book.deleted','App\\Models\\Book',32,'Buku \"Pedoman Penulisan Karya Ilmiah\" dihapus.','127.0.0.1','2026-11-17 03:42:57'),(8,1,'book.deleted','App\\Models\\Book',31,'Buku \"Sejarah Seni Rupa Indonesia\" dihapus.','127.0.0.1','2026-11-17 03:43:01'),(9,1,'book.deleted','App\\Models\\Book',30,'Buku \"Kecil-Kecil Punya Karya\" dihapus.','127.0.0.1','2026-11-17 03:43:04'),(10,1,'book.deleted','App\\Models\\Book',29,'Buku \"Cerita Rakyat Nusantara\" dihapus.','127.0.0.1','2026-11-17 03:43:06'),(11,1,'book.deleted','App\\Models\\Book',22,'Buku \"Perekonomian Indonesia\" dihapus.','127.0.0.1','2026-11-17 03:43:10'),(12,1,'book.deleted','App\\Models\\Book',16,'Buku \"Energi Terbarukan di Indonesia\" dihapus.','127.0.0.1','2026-11-17 03:43:30'),(13,1,'book.deleted','App\\Models\\Book',15,'Buku \"Sapiens: Riwayat Singkat Umat Manusia\" dihapus.','127.0.0.1','2026-11-17 03:44:06'),(14,1,'book.deleted','App\\Models\\Book',23,'Buku \"Metode Penelitian Kuantitatif\" dihapus.','127.0.0.1','2026-11-17 03:44:09'),(15,1,'author.created','App\\Models\\Author',28,'Penulis \"Test\" ditambahkan.','127.0.0.1','2026-11-17 03:45:08'),(16,1,'category.created','App\\Models\\Category',13,'Kategori \"Test\" ditambahkan.','127.0.0.1','2026-11-17 03:45:36'),(17,1,'book.updated','App\\Models\\Book',21,'Buku \"Rich Dad Poor Dad\" diperbarui.','127.0.0.1','2026-11-17 03:47:44'),(18,1,'book.updated','App\\Models\\Book',14,'Buku \"Kosmos\" diperbarui.','127.0.0.1','2026-11-17 03:48:48'),(19,1,'book.updated','App\\Models\\Book',17,'Buku \"Clean Code\" diperbarui.','127.0.0.1','2026-11-17 03:49:33'),(20,1,'book.updated','App\\Models\\Book',18,'Buku \"Algoritma dan Pemrograman\" diperbarui.','127.0.0.1','2026-11-17 03:50:41'),(21,1,'book.updated','App\\Models\\Book',19,'Buku \"Pemrograman Web dengan PHP dan MySQL\" diperbarui.','127.0.0.1','2026-11-17 03:52:00'),(22,1,'book.deleted','App\\Models\\Book',20,'Buku \"Dasar-Dasar Ilmu Ekonomi\" dihapus.','127.0.0.1','2026-11-17 03:52:26'),(23,1,'book.updated','App\\Models\\Book',13,'Buku \"Api Sejarah Nusantara\" diperbarui.','127.0.0.1','2026-11-17 03:53:57'),(24,1,'book.updated','App\\Models\\Book',17,'Buku \"Clean Code\" diperbarui.','127.0.0.1','2026-11-17 03:54:12'),(25,1,'book.updated','App\\Models\\Book',13,'Buku \"Api Sejarah Nusantara\" diperbarui.','127.0.0.1','2026-11-17 03:54:23'),(26,1,'book.deleted','App\\Models\\Book',26,'Buku \"Tata Bahasa Baku Bahasa Indonesia\" dihapus.','127.0.0.1','2026-11-17 03:54:52'),(27,1,'book.updated','App\\Models\\Book',25,'Buku \"Kamus Besar Bahasa Indonesia\" diperbarui.','127.0.0.1','2026-11-17 04:01:47'),(28,1,'book.updated','App\\Models\\Book',28,'Buku \"Fiqih Sunnah Jilid 2\" diperbarui.','127.0.0.1','2026-11-17 04:03:26'),(29,1,'book.updated','App\\Models\\Book',27,'Buku \"Tafsir Al-Misbah Jilid 1\" diperbarui.','127.0.0.1','2026-11-17 04:04:38'),(30,1,'book.updated','App\\Models\\Book',24,'Buku \"Belajar dan Faktor yang Mempengaruhinya\" diperbarui.','127.0.0.1','2026-11-17 04:06:39'),(31,1,'member.toggled','App\\Models\\User',9,'Akun Damar Wicaksono diaktifkan.','127.0.0.1','2026-11-17 04:11:15'),(32,1,'member.created','App\\Models\\User',10,'Akun anggota Rafka Rahmansyah ditambahkan pustakawan.','127.0.0.1','2026-11-17 04:23:14'),(33,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-17 04:23:20'),(34,NULL,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-17 04:23:28'),(35,NULL,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-17 04:23:33'),(36,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-17 04:23:45'),(37,1,'book.deleted','App\\Models\\Book',28,'Buku \"Fiqih Sunnah Jilid 2\" dihapus.','127.0.0.1','2026-11-17 04:24:13'),(38,1,'book.created','App\\Models\\Book',33,'Buku \"123\" ditambahkan.','127.0.0.1','2026-11-17 04:24:44'),(39,1,'book.updated','App\\Models\\Book',33,'Buku \"123+321\" diperbarui.','127.0.0.1','2026-11-17 04:25:00'),(40,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-17 04:25:14'),(41,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-17 04:25:29'),(42,1,'member.deleted',NULL,NULL,'Akun anggota Rafka Rahmansyah dihapus permanen.','127.0.0.1','2026-11-17 04:25:37'),(43,1,'member.toggled','App\\Models\\User',9,'Akun Damar Wicaksono dinonaktifkan.','127.0.0.1','2026-11-17 04:25:57'),(44,1,'member.toggled','App\\Models\\User',9,'Akun Damar Wicaksono diaktifkan.','127.0.0.1','2026-11-17 04:26:03'),(45,1,'member.created','App\\Models\\User',11,'Akun anggota Joko ditambahkan pustakawan.','127.0.0.1','2026-11-17 04:26:49'),(46,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-17 04:26:54'),(47,11,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-17 04:27:01'),(48,11,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-17 04:27:06'),(49,11,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-17 04:27:14'),(50,11,'borrowing.requested','App\\Models\\Borrowing',10,'Joko mengajukan peminjaman \"123+321\".','127.0.0.1','2026-11-17 04:27:29'),(51,11,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-17 04:27:36'),(52,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-17 04:27:47'),(53,1,'borrowing.approved','App\\Models\\Borrowing',10,'Peminjaman PJM-261117-MBXZP disetujui oleh Rani Kusumawardhani.','127.0.0.1','2026-11-17 04:27:55'),(54,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-17 04:28:06'),(55,1,'auth.login',NULL,NULL,'Masuk ke aplikasi.','127.0.0.1','2026-11-17 04:28:13'),(56,1,'borrowing.returned','App\\Models\\Borrowing',10,'Pengembalian PJM-261117-MBXZP diproses oleh Rani Kusumawardhani.','127.0.0.1','2026-11-17 04:28:21'),(57,1,'borrowing.rejected','App\\Models\\Borrowing',6,'Peminjaman PJM-261117-ZYVKN ditolak oleh Rani Kusumawardhani.','127.0.0.1','2026-11-17 04:29:18'),(58,1,'member.toggled','App\\Models\\User',11,'Akun Joko dinonaktifkan.','127.0.0.1','2026-11-17 04:29:52'),(59,1,'member.toggled','App\\Models\\User',11,'Akun Joko diaktifkan.','127.0.0.1','2026-11-17 04:30:23'),(60,1,'member.toggled','App\\Models\\User',11,'Akun Joko dinonaktifkan.','127.0.0.1','2026-11-17 04:32:17'),(61,1,'member.toggled','App\\Models\\User',11,'Akun Joko diaktifkan.','127.0.0.1','2026-11-17 04:32:18'),(62,1,'member.toggled','App\\Models\\User',11,'Akun Joko dinonaktifkan.','127.0.0.1','2026-11-17 04:32:19'),(63,1,'member.toggled','App\\Models\\User',11,'Akun Joko diaktifkan.','127.0.0.1','2026-11-17 04:32:20'),(64,1,'auth.logout',NULL,NULL,'Keluar dari aplikasi.','127.0.0.1','2026-11-17 04:49:48');
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` VALUES (1,'Andrea Hirata','andrea-hirata','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(2,'Pramoedya Ananta Toer','pramoedya-ananta-toer','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(3,'Eka Kurniawan','eka-kurniawan','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(4,'Dee Lestari','dee-lestari','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(5,'Leila S. Chudori','leila-s-chudori','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(6,'Tere Liye','tere-liye','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(7,'Ayu Utami','ayu-utami','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(8,'Ahmad Tohari','ahmad-tohari','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(9,'Budi Darma','budi-darma','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(10,'M.C. Ricklefs','mc-ricklefs','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(11,'Tan Malaka','tan-malaka','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(12,'Denys Lombard','denys-lombard','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(13,'Ahmad Mansur Suryanegara','ahmad-mansur-suryanegara','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(14,'Carl Sagan','carl-sagan','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(15,'Yuval Noah Harari','yuval-noah-harari','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(16,'Tim Penyusun','tim-penyusun','Kredit penulis belum diverifikasi; entri ini bersifat data contoh.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(17,'Robert C. Martin','robert-c-martin','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(18,'Rinaldi Munir','rinaldi-munir','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(19,'Budi Raharjo','budi-raharjo','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(20,'Robert T. Kiyosaki','robert-t-kiyosaki','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(21,'Dumairy','dumairy','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(22,'Sugiyono','sugiyono','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(23,'Slameto','slameto','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(24,'Badan Pengembangan dan Pembinaan Bahasa','badan-pengembangan-dan-pembinaan-bahasa','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(25,'Anton M. Moeliono','anton-m-moeliono','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(26,'M. Quraish Shihab','m-quraish-shihab','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(27,'Sayyid Sabiq','sayyid-sabiq','Penulis yang karyanya tersedia di koleksi Perpustakaan Pustaka Nusantara.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(28,'Test','test-ddwp','Untuk testing','2026-11-17 03:45:08','2026-11-17 03:45:08',NULL);
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
INSERT INTO `book_author` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10),(11,11),(12,12),(13,13),(14,14),(15,15),(16,16),(20,16),(29,16),(30,16),(31,16),(32,16),(17,17),(18,18),(19,19),(21,20),(22,21),(23,22),(24,23),(25,24),(26,25),(27,26),(28,27),(33,28);
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'Laskar Pelangi','laskar-pelangi-1',NULL,1,1,2005,529,'Kisah sepuluh anak Belitung yang berjuang mendapat pendidikan layak di tengah keterbatasan.',NULL,2,1,1,120,'2026-11-17 03:20:01','2026-11-17 03:20:07',NULL),(2,'Bumi Manusia','bumi-manusia-2',NULL,2,2,1980,535,'Kisah Minke pada akhir masa kolonial, tentang cinta, kelas sosial, dan kebangkitan kesadaran pribumi.',NULL,3,2,0,117,'2026-11-17 03:20:01','2026-11-17 03:20:07',NULL),(3,'Cantik Itu Luka','cantik-itu-luka-3',NULL,1,3,2002,520,'Saga keluarga Dewi Ayu yang memikat, kelam, dan penuh kejutan sejarah.',NULL,4,3,0,114,'2026-11-17 03:20:02','2026-11-17 03:20:07',NULL),(4,'Perahu Kertas','perahu-kertas-4',NULL,1,1,2009,444,'Dua anak muda berbagi mimpi dan harus memilih antara cita-cita dan perasaan.',NULL,5,4,0,111,'2026-11-17 03:20:02','2026-11-17 03:20:07',NULL),(5,'Pulang','pulang-5',NULL,1,4,2013,552,'Kisah eksil politik 1965 dan generasi sesudahnya yang mencari jalan pulang.',NULL,2,2,0,108,'2026-11-17 03:20:02','2026-11-17 03:20:02',NULL),(6,'Hujan','hujan-6',NULL,1,3,2018,320,'Lail dan Esok bertahan melewati bencana dan luka, dalam dunia yang terus berubah.',NULL,3,2,0,105,'2026-11-17 03:20:02','2026-11-17 03:20:07',NULL),(7,'Saman','saman-7',NULL,2,4,1998,200,'Empat perempuan Jakarta dan seorang pemuda misterius di akhir Orde Baru.',NULL,4,4,1,102,'2026-11-17 03:20:02','2026-11-17 03:20:02',NULL),(8,'Ronggeng Dukuh Paruk','ronggeng-dukuh-paruk-8',NULL,2,3,1982,400,'Srintil, ronggeng cilik, dan kisah duka sebuah dusun di pedalaman Jawa.',NULL,5,5,0,99,'2026-11-17 03:20:02','2026-11-17 03:20:02',NULL),(9,'Orang-Orang Bloomington','orang-orang-bloomington-9',NULL,2,5,1980,175,'Sebelas cerita pendek tentang kesepian orang Indonesia di kota kecil Amerika.',NULL,2,2,0,96,'2026-11-17 03:20:02','2026-11-17 03:20:02',NULL),(10,'Sejarah Indonesia Modern','sejarah-indonesia-modern-10',NULL,3,6,2008,865,'Uraian komprehensif sejarah Indonesia dari abad ke-13 hingga era reformasi.',NULL,3,3,0,93,'2026-11-17 03:20:02','2026-11-17 03:20:02',NULL),(11,'Madilog','madilog-11',NULL,3,7,2016,564,'Materialisme, dialektika, dan logika sebagai cara berpikir yang dibangun Tan Malaka dari penjara.',NULL,4,4,0,90,'2026-11-17 03:20:02','2026-11-17 03:20:02',NULL),(12,'Nusa Jawa: Silang Budaya','nusa-jawa-silang-budaya-12',NULL,3,3,1996,640,'Kajian Denys Lombard tentang jaringan Asia dan akar budaya Jawa.',NULL,5,5,0,87,'2026-11-17 03:20:02','2026-11-17 03:20:02',NULL),(13,'Api Sejarah Nusantara','api-sejarah-nusantara-13',NULL,3,8,2013,532,'Rekonstruksi peran ulama dan santri dalam perjuangan kemerdekaan Indonesia.','covers/evRWA7mmN0D0xIurYjKoEZledFp5bMc6vedC22i0.webp',2,2,0,84,'2026-11-17 03:20:02','2026-11-17 03:54:23',NULL),(14,'Kosmos','kosmos-14',NULL,4,4,2016,488,'Penjelajahan tentang alam semesta, evolusi bintang, dan tempat manusia di dalamnya.','covers/n7G1okKm65ZeZzQdmGh0vd6CppZMIbgrfhqwQ0IX.jpg',3,3,0,81,'2026-11-17 03:20:02','2026-11-17 03:48:48',NULL),(15,'Sapiens: Riwayat Singkat Umat Manusia','sapiens-riwayat-singkat-umat-manusia-15',NULL,4,4,2017,524,'Rentang sejarah Homo sapiens dari pemburu-peramu hingga peradaban modern.',NULL,4,4,0,78,'2026-11-17 03:20:02','2026-11-17 03:44:06','2026-11-17 03:44:06'),(16,'Energi Terbarukan di Indonesia','energi-terbarukan-di-indonesia-16',NULL,4,9,2019,288,'Peta potensi dan tantangan transisi energi di Indonesia.',NULL,5,5,0,75,'2026-11-17 03:20:02','2026-11-17 03:43:30','2026-11-17 03:43:30'),(17,'Clean Code','clean-code-17',NULL,5,10,2008,464,'Prinsip dan praktik menulis kode yang mudah dibaca serta dipelihara.','covers/cWoLH3sfOO1MWpY5JDyuKZJXsShCfmkIIRgv0rOj.jpg',2,2,1,72,'2026-11-17 03:20:02','2026-11-17 03:54:12',NULL),(18,'Algoritma dan Pemrograman','algoritma-dan-pemrograman-18',NULL,5,11,2011,408,'Dasar perancangan algoritma, struktur data, dan penyelesaian masalah secara sistematis.','covers/FfdpMfV8Jd5hiQUHwTO63MFp2iI0WYpyosUEUNNM.jpg',3,3,0,69,'2026-11-17 03:20:02','2026-11-17 03:50:41',NULL),(19,'Pemrograman Web dengan PHP dan MySQL','pemrograman-web-dengan-php-dan-mysql-19',NULL,5,11,2016,356,'Langkah praktis membangun aplikasi web dinamis dengan PHP dan MySQL.','covers/iJwN3G25MBQpmM2MuZGAHWW7z0OzHVFCV5rHgWg9.jpg',4,4,1,66,'2026-11-17 03:20:02','2026-11-17 03:52:00',NULL),(20,'Dasar-Dasar Ilmu Ekonomi','dasar-dasar-ilmu-ekonomi-20',NULL,6,12,2004,490,'Pengantar mikro dan makroekonomi untuk mahasiswa tahun pertama.',NULL,5,5,0,63,'2026-11-17 03:20:02','2026-11-17 03:52:26','2026-11-17 03:52:26'),(21,'Rich Dad Poor Dad','rich-dad-poor-dad-21',NULL,6,3,1997,256,'Dua pola pikir tentang uang dan pengelolaan aset keluarga.','covers/6hKODYPu9W0GMOXStC6oHw5g3Nw0OxCUuvAjWK8z.jpg',2,2,0,60,'2026-11-17 03:20:02','2026-11-17 03:47:44',NULL),(22,'Perekonomian Indonesia','perekonomian-indonesia-22',NULL,6,13,2012,380,'Analisis kebijakan fiskal, moneter, dan pembangunan ekonomi nasional.',NULL,3,3,0,57,'2026-11-17 03:20:02','2026-11-17 03:43:10','2026-11-17 03:43:10'),(23,'Metode Penelitian Kuantitatif','metode-penelitian-kuantitatif-23',NULL,7,14,2013,334,'Prosedur penelitian kuantitatif dari perumusan masalah hingga pelaporan.',NULL,4,4,0,54,'2026-11-17 03:20:02','2026-11-17 03:44:09','2026-11-17 03:44:09'),(24,'Belajar dan Faktor yang Mempengaruhinya','belajar-dan-faktor-yang-mempengaruhinya-24',NULL,7,15,2010,195,'Kajian psikologis tentang proses belajar dan faktor pendukungnya.','covers/wwwLkP2tZUyxlIkvxgFb9d2QQYKhqninik5WfomM.jpg',5,5,0,51,'2026-11-17 03:20:02','2026-11-17 04:06:39',NULL),(25,'Kamus Besar Bahasa Indonesia','kamus-besar-bahasa-indonesia-25',NULL,8,16,2016,1700,'Rujukan makna, ejaan, dan pemakaian kata dalam bahasa Indonesia.','covers/ziebWZDsvODIixV8pMZBUyvDPc0luPeDPkJAeKpc.jpg',2,2,1,48,'2026-11-17 03:20:02','2026-11-17 04:01:47',NULL),(26,'Tata Bahasa Baku Bahasa Indonesia','tata-bahasa-baku-bahasa-indonesia-26',NULL,8,16,2017,520,'Pedoman baku tata bahasa Indonesia untuk penulisan formal.',NULL,3,3,0,45,'2026-11-17 03:20:02','2026-11-17 03:54:52','2026-11-17 03:54:52'),(27,'Tafsir Al-Misbah Jilid 1','tafsir-al-misbah-jilid-1-27',NULL,9,17,2000,640,'Penafsiran Al-Qur\'an dengan pendekatan bahasa dan konteks sosial.','covers/X8yd80PRkTXj721BTuqU54FZfvex9GF5r6WoW5bO.jpg',4,4,0,42,'2026-11-17 03:20:02','2026-11-17 04:04:38',NULL),(28,'Fiqih Sunnah Jilid 2','fiqih-sunnah-jilid-2-28',NULL,9,18,2006,712,'Pembahasan fikih ibadah dan muamalah berdasarkan dalil.','covers/I3QgWSgBlKPIJ61BT4DRdSif9D89wQjoGVQe4h04.webp',5,5,0,39,'2026-11-17 03:20:02','2026-11-17 04:24:13','2026-11-17 04:24:13'),(29,'Cerita Rakyat Nusantara','cerita-rakyat-nusantara-29',NULL,10,19,2014,180,'Kumpulan cerita rakyat dari berbagai daerah dengan pesan moral.',NULL,2,2,0,36,'2026-11-17 03:20:03','2026-11-17 03:43:06','2026-11-17 03:43:06'),(30,'Kecil-Kecil Punya Karya','kecil-kecil-punya-karya-30',NULL,10,20,2018,160,'Antologi cerita anak tentang persahabatan dan keberanian.',NULL,3,3,0,33,'2026-11-17 03:20:03','2026-11-17 03:43:04','2026-11-17 03:43:04'),(31,'Sejarah Seni Rupa Indonesia','sejarah-seni-rupa-indonesia-31',NULL,11,21,1979,240,'Catatan perkembangan seni rupa Indonesia dari masa klasik hingga modern.',NULL,4,4,1,30,'2026-11-17 03:20:03','2026-11-17 03:43:01','2026-11-17 03:43:01'),(32,'Pedoman Penulisan Karya Ilmiah','pedoman-penulisan-karya-ilmiah-32',NULL,12,22,2019,210,'Panduan teknis penulisan karya ilmiah dan tata cara sitasi.',NULL,5,5,0,27,'2026-11-17 03:20:03','2026-11-17 03:42:57','2026-11-17 03:42:57'),(33,'123+321','123-urfle','9793062797',12,18,2008,321,NULL,NULL,1,1,0,1,'2026-11-17 04:24:44','2026-11-17 04:28:21',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowings`
--

LOCK TABLES `borrowings` WRITE;
/*!40000 ALTER TABLE `borrowings` DISABLE KEYS */;
INSERT INTO `borrowings` VALUES (1,'PJM-261117-ZDAFO',2,1,'approved','2026-11-12 03:20:07','2026-11-13 03:20:07','2026-11-20 03:20:07',NULL,1,NULL,NULL,'2026-11-17 03:20:07','2026-11-17 03:20:07'),(2,'PJM-261117-FDLRG',3,2,'approved','2026-11-12 03:20:07','2026-11-13 03:20:07','2026-11-19 03:20:07',NULL,1,NULL,NULL,'2026-11-17 03:20:07','2026-11-17 03:20:07'),(3,'PJM-261117-KDND7',4,3,'approved','2026-11-12 03:20:07','2026-11-13 03:20:07','2026-11-18 03:20:07',NULL,1,NULL,NULL,'2026-11-17 03:20:07','2026-11-17 03:20:07'),(4,'PJM-261117-JSYBE',5,4,'approved','2026-11-12 03:20:07','2026-11-13 03:20:07','2026-11-17 03:20:07',NULL,1,NULL,NULL,'2026-11-17 03:20:07','2026-11-17 03:20:07'),(5,'PJM-261117-DXJRW',6,6,'approved','2026-10-28 03:20:07','2026-10-29 03:20:07','2026-11-05 03:20:07',NULL,1,NULL,NULL,'2026-11-17 03:20:07','2026-11-17 03:20:07'),(6,'PJM-261117-ZYVKN',7,7,'rejected','2026-11-16 21:20:07',NULL,NULL,NULL,1,'Untuk tugas akhir, mohon disetujui.','a','2026-11-17 03:20:07','2026-11-17 04:29:18'),(7,'PJM-261117-PB6S3',3,8,'rejected','2026-11-14 03:20:07',NULL,NULL,NULL,1,NULL,'Anggota masih memiliki pinjaman terlambat.','2026-11-17 03:20:07','2026-11-17 03:20:07'),(8,'PJM-261117-0HQPE',4,9,'returned','2026-10-18 03:20:07','2026-10-19 03:20:07','2026-10-26 03:20:07','2026-10-30 03:20:07',1,NULL,NULL,'2026-11-17 03:20:07','2026-11-17 03:20:07'),(9,'PJM-261117-WLHCU',5,10,'returned','2026-09-18 03:20:07','2026-09-19 03:20:07','2026-09-26 03:20:07','2026-09-28 03:20:07',1,NULL,NULL,'2026-11-17 03:20:07','2026-11-17 03:20:07'),(10,'PJM-261117-MBXZP',11,33,'returned','2026-11-17 04:27:29','2026-11-17 04:27:55','2026-11-24 04:27:55','2026-11-17 04:28:21',1,NULL,NULL,'2026-11-17 04:27:29','2026-11-17 04:28:21');
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
INSERT INTO `cache` VALUES ('pustaka-cache-17ba0791499db908433b80f37c5fbc89b870084b','i:1;',1794889709),('pustaka-cache-17ba0791499db908433b80f37c5fbc89b870084b:timer','i:1794889709;',1794889709),('pustaka-cache-setting.library_address','s:30:\"Jl. Diponegoro No. 42, Bandung\";',2110246686),('pustaka-cache-setting.library_email','s:17:\"halo@pustaka.test\";',2110246686),('pustaka-cache-setting.library_phone','s:15:\"(022) 8842 1901\";',2110246686),('pustaka-cache-setting.library_tagline','s:29:\"Ilmu yang terbuka untuk semua\";',2110246686),('pustaka-cache-setting.loan_duration_days','s:1:\"7\";',2110246686),('pustaka-cache-setting.max_active_loans','s:1:\"3\";',2110246686);
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Fiksi','fiksi','Prosa rekaan yang menghibur sekaligus membuka perspektif baru.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(2,'Sastra','sastra','Karya sastra Indonesia dan dunia yang menjadi rujukan.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(3,'Sejarah','sejarah','Kajian sejarah nasional dan dunia.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(4,'Sains','sains','Populer sains dan buku teks dasar.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(5,'Teknologi','teknologi','Buku komputer, rekayasa, dan pemrograman.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(6,'Ekonomi','ekonomi','Ilmu ekonomi, keuangan, dan pembangunan.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(7,'Pendidikan','pendidikan','Teori pendidikan dan metode pengajaran.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(8,'Bahasa','bahasa','Kamus, tata bahasa, dan keterampilan berbahasa.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(9,'Agama','agama','Kajian keagamaan dan tafsir.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(10,'Buku Anak','buku-anak','Bacaan ringan untuk pembaca awal.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(11,'Seni','seni','Seni rupa, musik, dan pertunjukan.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(12,'Referensi','referensi','Ensiklopedia, pedoman, dan buku rujukan.','2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(13,'Test','test','Untuk testing','2026-11-17 03:45:36','2026-11-17 03:45:36',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_11_11_000001_add_library_fields_to_users_table',1),(5,'2026_11_11_000002_create_categories_table',1),(6,'2026_11_11_000003_create_authors_table',1),(7,'2026_11_11_000004_create_publishers_table',1),(8,'2026_11_11_000005_create_books_table',1),(9,'2026_11_11_000006_create_book_author_table',1),(10,'2026_11_11_000007_create_borrowings_table',1),(11,'2026_11_11_000009_create_settings_table',1),(12,'2026_11_11_000010_create_activity_logs_table',1);
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
INSERT INTO `publishers` VALUES (1,'Bentang Pustaka','bentang-pustaka',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(2,'Hasta Mitra','hasta-mitra',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(3,'Gramedia Pustaka Utama','gramedia-pustaka-utama',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(4,'Kepustakaan Populer Gramedia','kepustakaan-populer-gramedia',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(5,'Sinar Harapan','sinar-harapan',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(6,'Serambi Ilmu Semesta','serambi-ilmu-semesta',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(7,'Narasi','narasi',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(8,'Salamadani','salamadani',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(9,'Penerbit ITB','penerbit-itb',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(10,'Prentice Hall','prentice-hall',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(11,'Informatika','informatika',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(12,'Rajawali Pers','rajawali-pers',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(13,'Erlangga','erlangga',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(14,'Alfabeta','alfabeta',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(15,'Rineka Cipta','rineka-cipta',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(16,'Balai Pustaka','balai-pustaka',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(17,'Lentera Hati','lentera-hati',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(18,'Pustaka Al-Kautsar','pustaka-al-kautsar',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(19,'Yudhistira','yudhistira',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(20,'Mizan','mizan',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(21,'Departemen Pendidikan','departemen-pendidikan',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL),(22,'Universitas Negeri Malang','universitas-negeri-malang',NULL,'2026-11-17 03:20:01','2026-11-17 03:20:01',NULL);
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
INSERT INTO `sessions` VALUES ('td5ZDBquDJUmRNsJBjmMeSKYJRvzldosrj1PiOdC',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJLVU1uSWN1MzJLYVRZME0zQUFOc0xCQmd4OHlNZnpnTnJ5ZG5RSGFHIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImhvbWUifX0=',1794890988);
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
INSERT INTO `settings` VALUES ('library_address','Jl. Diponegoro No. 42, Bandung','2026-11-17 03:20:01','2026-11-17 03:20:01'),('library_email','halo@pustaka.test','2026-11-17 03:20:01','2026-11-17 03:20:01'),('library_name','Pustaka Nusantara','2026-11-17 03:20:01','2026-11-17 03:20:01'),('library_phone','(022) 8842 1901','2026-11-17 03:20:01','2026-11-17 03:20:01'),('library_tagline','Ilmu yang terbuka untuk semua','2026-11-17 03:20:01','2026-11-17 03:20:01'),('loan_duration_days','7','2026-11-17 03:20:01','2026-11-17 03:20:01'),('max_active_loans','3','2026-11-17 03:20:01','2026-11-17 03:20:01');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Rani Kusumawardhani','admin@pustaka.test',NULL,'2026-11-17 03:20:03','$2y$12$Fk04C0GgYsXsEjzfoJoUYu4YFL3g3LJt693g1eKD3UGCTehuEBQLC','admin',1,'081200000001','Jl. Kartini No. 8, Bandung','2023-11-17',NULL,'2026-11-17 03:20:03','2026-11-17 03:20:03',NULL),(2,'Bagas Prakoso','bagas.prakoso@example.test',NULL,'2026-11-17 03:20:03','$2y$12$yvRzsY./QO73DbysNIj31eou6YPmA6k9bMIABI4mt5eAeDUbPYFcO','member',1,'081300000000','Jl. Merdeka No. 3, Bandung','2026-10-17',NULL,'2026-11-17 03:20:04','2026-11-17 03:20:04',NULL),(3,'Nadia Ayuningtyas','nadia.ayuningtyas@example.test',NULL,'2026-11-17 03:20:04','$2y$12$bAFl0B64sSldU7lZ6UxLu.4cSEbZ7eXXkBW7CbMNJM2BU7fPgGQ.S','member',1,'081300000001','Jl. Merdeka No. 4, Bandung','2026-09-17',NULL,'2026-11-17 03:20:04','2026-11-17 03:20:04',NULL),(4,'Fajar Ramadhan','fajar.ramadhan@example.test',NULL,'2026-11-17 03:20:04','$2y$12$OEgqXXNIaHEnXyFFim8SK.e2JexUjxYV.XuZAT2.HMeafc7AkQ.D2','member',1,'081300000002','Jl. Merdeka No. 5, Bandung','2026-08-17',NULL,'2026-11-17 03:20:04','2026-11-17 03:20:04',NULL),(5,'Sinta Maharani','sinta.maharani@example.test',NULL,'2026-11-17 03:20:04','$2y$12$RcUmuyVVwG1tN/NzvZd9uOXopWgUHi9OpQIixRhAy6fU.w.z5BxRK','member',1,'081300000003','Jl. Merdeka No. 6, Bandung','2026-07-17',NULL,'2026-11-17 03:20:05','2026-11-17 03:20:05',NULL),(6,'Rizky Hidayat','rizky.hidayat@example.test',NULL,'2026-11-17 03:20:05','$2y$12$4Fe8q0CMIy1bFFPWPsVGg.nGEpBMSKrj5dEBmZEWG89C2fOG304Ce','member',1,'081300000004','Jl. Merdeka No. 7, Bandung','2026-06-17',NULL,'2026-11-17 03:20:05','2026-11-17 03:20:05',NULL),(7,'Melati Putri','melati.putri@example.test',NULL,'2026-11-17 03:20:06','$2y$12$aUEDviXXI7DH9xWqzUXspuWPz2VgbH/QS0YoRbfRv4OdEUUe/Cy3e','member',1,'081300000005','Jl. Merdeka No. 8, Bandung','2026-05-17',NULL,'2026-11-17 03:20:06','2026-11-17 03:20:06',NULL),(9,'Damar Wicaksono','damar.wicaksono@example.test',NULL,'2026-11-17 03:20:07','$2y$12$DB/cym6lTI/LZgoQo60XA.0gEDVazrSoKqGztf4rigpZy38jdhuVi','member',1,'081300000007','Jl. Merdeka No. 10, Bandung','2026-03-17',NULL,'2026-11-17 03:20:07','2026-11-17 04:26:03',NULL),(11,'Joko','joko@contoh.com',NULL,'2026-11-17 04:26:49','$2y$12$LDhgfrCrVikuaG40j83gLuMRcRNnYxzhcFjJlwFWdC3NBVeW0rgVS','member',1,'089351637383',NULL,'2026-11-17',NULL,'2026-11-17 04:26:49','2026-11-17 04:32:20',NULL);
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

-- Dump completed on 2026-11-17 11:50:29
