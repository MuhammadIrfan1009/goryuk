-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: dbgoryuk
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin8`
--

DROP TABLE IF EXISTS `admin8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin8` (
  `id_user8` int(11) NOT NULL AUTO_INCREMENT,
  `username8` varchar(20) DEFAULT NULL,
  `password8` varchar(20) DEFAULT NULL,
  `nama8` varchar(50) DEFAULT NULL,
  `no_handphone8` varchar(15) DEFAULT NULL,
  `email8` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_user8`)
) ENGINE=InnoDB AUTO_INCREMENT=8899 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin8`
--

LOCK TABLES `admin8` WRITE;
/*!40000 ALTER TABLE `admin8` DISABLE KEYS */;
INSERT INTO `admin8` VALUES (8893,'Skanpat','11','Skanpat','083186867022','redmiredmi600@gmail.com'),(8898,'redmiredmi6000@gmail','11','q q','11','tigak206@gmail.com');
/*!40000 ALTER TABLE `admin8` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bayar8`
--

DROP TABLE IF EXISTS `bayar8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bayar8` (
  `id_bayar8` int(11) NOT NULL AUTO_INCREMENT,
  `id_sewa8` int(11) DEFAULT NULL,
  `bukti8` text DEFAULT NULL,
  `tanggal_upload8` timestamp NULL DEFAULT current_timestamp(),
  `konfirmasi8` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_bayar8`),
  KEY `id_sewa` (`id_sewa8`),
  CONSTRAINT `bayar8_ibfk_1` FOREIGN KEY (`id_sewa8`) REFERENCES `sewa8` (`id_sewa8`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bayar8`
--

LOCK TABLES `bayar8` WRITE;
/*!40000 ALTER TABLE `bayar8` DISABLE KEYS */;
INSERT INTO `bayar8` VALUES (5,98,'6651e10f66a64.png','2024-05-25 13:00:54','Terkonfirmasi'),(6,99,NULL,'2024-05-26 00:10:22','Belum Bayar'),(7,100,NULL,'2024-05-26 00:11:02','Belum Bayar'),(8,101,NULL,'2024-05-26 01:29:28','Belum Bayar'),(9,102,NULL,'2024-05-26 01:29:42','Belum Bayar'),(10,103,NULL,'2024-05-26 01:31:08','Belum Bayar'),(11,104,NULL,'2024-05-26 01:31:32','Belum Bayar');
/*!40000 ALTER TABLE `bayar8` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lapangan8`
--

DROP TABLE IF EXISTS `lapangan8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lapangan8` (
  `id_lapangan8` int(11) NOT NULL AUTO_INCREMENT,
  `nama8` varchar(35) DEFAULT NULL,
  `keterangan8` text DEFAULT NULL,
  `harga8` int(11) DEFAULT NULL,
  `foto8` text DEFAULT NULL,
  PRIMARY KEY (`id_lapangan8`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lapangan8`
--

LOCK TABLES `lapangan8` WRITE;
/*!40000 ALTER TABLE `lapangan8` DISABLE KEYS */;
INSERT INTO `lapangan8` VALUES (41,'Skanpat  Badmin 1','Lapangan Badminton (SMK Negeri 4 Tanjungpinang)',50000,'6651c98f90e1c.jpg'),(42,'Skanpat  Badmin 2','Lapangan Badminton (SMK Negeri 4 Tanjungpinang)',50000,'664d4c62a2e8e.png'),(43,'Skanpat  Badmin 3','Lapangan Badminton  (SMK Negeri 4 Tanjungpinang)',50000,'664d4ca3b43ae.png'),(48,'Kacapuri','11',111111,'6651ca7f892fc.jpg');
/*!40000 ALTER TABLE `lapangan8` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaduan_pelanggan8`
--

DROP TABLE IF EXISTS `pengaduan_pelanggan8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengaduan_pelanggan8` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name8` varchar(255) NOT NULL,
  `email8` varchar(255) NOT NULL,
  `phone8` varchar(20) NOT NULL,
  `message8` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaduan_pelanggan8`
--

LOCK TABLES `pengaduan_pelanggan8` WRITE;
/*!40000 ALTER TABLE `pengaduan_pelanggan8` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengaduan_pelanggan8` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sewa8`
--

DROP TABLE IF EXISTS `sewa8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sewa8` (
  `id_sewa8` int(11) NOT NULL AUTO_INCREMENT,
  `id_user8` int(11) DEFAULT NULL,
  `id_lapangan8` int(11) DEFAULT NULL,
  `tanggal_pesan8` timestamp NULL DEFAULT current_timestamp(),
  `lama_sewa8` int(11) NOT NULL,
  `jam_mulai8` timestamp NULL DEFAULT NULL,
  `jam_habis8` timestamp NULL DEFAULT NULL,
  `harga8` int(11) DEFAULT NULL,
  `total8` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Dipesan',
  PRIMARY KEY (`id_sewa8`),
  KEY `id_user` (`id_user8`),
  KEY `sewa8_ibfk_2` (`id_lapangan8`),
  CONSTRAINT `sewa8_ibfk_1` FOREIGN KEY (`id_user8`) REFERENCES `user8` (`id_user8`),
  CONSTRAINT `sewa8_ibfk_2` FOREIGN KEY (`id_lapangan8`) REFERENCES `lapangan8` (`id_lapangan8`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sewa8`
--

LOCK TABLES `sewa8` WRITE;
/*!40000 ALTER TABLE `sewa8` DISABLE KEYS */;
INSERT INTO `sewa8` VALUES (98,17,42,'2024-05-25 13:00:54',1,'2024-05-25 13:00:00','2024-05-25 14:00:00',50000,50000,'Dipakai'),(99,18,42,'2024-05-26 00:10:22',5,'2024-05-26 00:10:00','2024-05-26 05:10:00',50000,250000,'Dipakai'),(100,18,43,'2024-05-26 00:11:02',1,'2024-05-26 00:10:00','2024-05-26 01:10:00',50000,50000,'Dipakai'),(101,18,42,'2024-05-26 01:29:28',1,'2024-05-26 01:15:00','2024-05-26 02:15:00',50000,50000,'Dipakai'),(102,18,42,'2024-05-26 01:29:42',1,'2024-05-26 01:29:00','2024-05-26 02:29:00',50000,50000,'Dipakai'),(103,18,42,'2024-05-26 01:31:08',1,'2024-05-26 01:31:00','2024-05-26 02:31:00',50000,50000,'Dipakai'),(104,18,42,'2024-05-26 01:31:32',77,'2024-05-26 01:31:00','2024-05-29 06:31:00',50000,3850000,'Dipakai');
/*!40000 ALTER TABLE `sewa8` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER before_insert_sewa8
BEFORE INSERT ON sewa8
FOR EACH ROW
BEGIN
    IF NEW.jam_mulai8 <= NOW() AND NEW.jam_habis8 >= NOW() THEN
        SET NEW.status = 'Dipakai';
    ELSEIF NEW.jam_mulai8 > NOW() THEN
        SET NEW.status = 'Dipesan';
    ELSE
        SET NEW.status = 'Selesai';
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER before_update_sewa8
BEFORE UPDATE ON sewa8
FOR EACH ROW
BEGIN
    IF NEW.jam_mulai8 <= NOW() AND NEW.jam_habis8 >= NOW() THEN
        SET NEW.status = 'Dipakai';
    ELSEIF NEW.jam_mulai8 > NOW() THEN
        SET NEW.status = 'Dipesan';
    ELSE
        SET NEW.status = 'Selesai';
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `user8`
--

DROP TABLE IF EXISTS `user8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user8` (
  `id_user8` int(11) NOT NULL AUTO_INCREMENT,
  `email8` varchar(50) NOT NULL,
  `password8` varchar(32) NOT NULL,
  `no_handphone8` varchar(20) DEFAULT NULL,
  `jenis_kelamin8` varchar(10) DEFAULT NULL,
  `nama_lengkap8` varchar(60) NOT NULL,
  `alamat8` text DEFAULT NULL,
  `foto8` text DEFAULT NULL,
  PRIMARY KEY (`id_user8`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user8`
--

LOCK TABLES `user8` WRITE;
/*!40000 ALTER TABLE `user8` DISABLE KEYS */;
INSERT INTO `user8` VALUES (17,'r@gmail.com','11','083186867022','Laki-laki','Muhammad Irfan','Jalan in aja dlu','6651f47bedd84.png'),(18,'red@mail.com','11','083186867022','Laki-laki','Muhammad Irfan',NULL,'6651eaeac7038.jpg');
/*!40000 ALTER TABLE `user8` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'dbgoryuk'
--
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insert_sewa8` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_sewa8`(IN `p_id_user8` INT, IN `p_id_lapangan8` INT, IN `p_lama_sewa8` INT, IN `p_jam_mulai8` TIMESTAMP, IN `p_jam_habis8` TIMESTAMP, IN `p_harga8` INT, IN `p_total8` INT, OUT `p_last_id` INT)
BEGIN
    DECLARE exit handler for sqlexception
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    INSERT INTO sewa8 (
        id_user8,
        id_lapangan8,
        tanggal_pesan8,
        lama_sewa8,
        jam_mulai8,
        jam_habis8,
        harga8,
        total8
    ) VALUES (
        p_id_user8,
        p_id_lapangan8,
        CURRENT_TIMESTAMP,
        p_lama_sewa8,
        p_jam_mulai8,
        p_jam_habis8,
        p_harga8,
        p_total8
    );

    SET p_last_id = LAST_INSERT_ID();

    INSERT INTO bayar8 (id_sewa8, konfirmasi8) VALUES (p_last_id, 'Belum Bayar');

    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `set_status_bayar` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `set_status_bayar`(IN `id_sewa_param` INT, IN `bukti_file_param` VARCHAR(255))
BEGIN
    UPDATE bayar8 SET konfirmasi8 = 'Sudah Bayar', bukti8 = bukti_file_param WHERE id_sewa8 = id_sewa_param;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-28  9:00:00
