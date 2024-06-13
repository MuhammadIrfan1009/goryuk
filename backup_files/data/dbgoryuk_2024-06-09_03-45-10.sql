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
INSERT INTO `admin8` VALUES (8893,'Skanpat','11','Skanpat','083186867022','redmiredmi600@gmail.com'),(8898,'fine','11','q q','11','tigak206@gmail.com');
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bayar8`
--

LOCK TABLES `bayar8` WRITE;
/*!40000 ALTER TABLE `bayar8` DISABLE KEYS */;
INSERT INTO `bayar8` VALUES (16,109,'6663a8d059380.png','2024-06-08 00:41:27','Terkonfirmasi'),(17,110,'6663a8f1d5059.png','2024-06-08 00:42:15','Terkonfirmasi'),(19,112,'6664f3b6b469f.png','2024-06-09 00:08:03','Terkonfirmasi'),(20,113,'6664f48993a0c.png','2024-06-09 00:15:47','Sudah Bayar'),(21,114,'6664f6aae15b0.png','2024-06-09 00:26:07','Terkonfirmasi');
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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lapangan8`
--

LOCK TABLES `lapangan8` WRITE;
/*!40000 ALTER TABLE `lapangan8` DISABLE KEYS */;
INSERT INTO `lapangan8` VALUES (41,'Skanpat Futsal','Lapangan Futsal (SMK Negeri 4 Tanjungpinang)',150000,'665f1e86bf330.png'),(42,'Skanpat MinSoc','Lapangan Mini Soccer (SMK Negeri 4 Tanjungpinang)',250000,'665f1f41e67d8.jpg'),(43,'Skanpat  Badmin ','Lapangan Badminton  (SMK Negeri 4 Tanjungpinang)',50000,'665f1f5292c55.png'),(49,'Skanpat  Voli','Lapangan Voli  (SMK Negeri 4 Tanjungpinang)',50000,'6663a861a9075.png');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaduan_pelanggan8`
--

LOCK TABLES `pengaduan_pelanggan8` WRITE;
/*!40000 ALTER TABLE `pengaduan_pelanggan8` DISABLE KEYS */;
INSERT INTO `pengaduan_pelanggan8` VALUES (1,'Muhammad Irfan','admin@gmail.com','083186867022','Bismillah','2024-06-04 14:40:53');
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
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sewa8`
--

LOCK TABLES `sewa8` WRITE;
/*!40000 ALTER TABLE `sewa8` DISABLE KEYS */;
INSERT INTO `sewa8` VALUES (109,18,43,'2024-06-08 00:41:27',1,'2024-06-08 00:41:00','2024-06-08 01:41:00',50000,50000,'Dipakai'),(110,18,42,'2024-06-08 00:42:15',11,'2024-06-08 00:42:00','2024-06-08 11:42:00',250000,2750000,'Dipakai'),(112,18,41,'2024-06-09 00:08:03',11,'2024-06-09 00:08:00','2024-06-09 11:08:00',150000,1650000,'Dipakai'),(113,18,42,'2024-06-09 00:15:47',13,'2024-06-09 06:15:00','2024-06-09 19:15:00',250000,3250000,'Dipesan'),(114,19,41,'2024-06-09 00:26:07',1,'2024-06-26 00:26:00','2024-06-26 01:26:00',150000,150000,'Dipesan');
/*!40000 ALTER TABLE `sewa8` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `before_insert_sewa8` BEFORE INSERT ON `sewa8` FOR EACH ROW BEGIN
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
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `before_update_sewa8` BEFORE UPDATE ON `sewa8` FOR EACH ROW BEGIN
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user8`
--

LOCK TABLES `user8` WRITE;
/*!40000 ALTER TABLE `user8` DISABLE KEYS */;
INSERT INTO `user8` VALUES (17,'r@gmail.com','11','083186867022','Laki-laki','Muhammad Irfan','Jalan in aja dlu','6651f47bedd84.png'),(18,'red@mail.com','11','083186867022','Laki-laki','Muhammad Irfan',NULL,'6651eaeac7038.jpg'),(19,'rr@gmail.com','11',NULL,NULL,'Akhdan',NULL,NULL);
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

-- Dump completed on 2024-06-09  8:45:10
