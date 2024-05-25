-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Bulan Mei 2024 pada 08.30
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbgoryuk`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_sewa8` (IN `p_id_user8` INT, IN `p_id_lapangan8` INT, IN `p_lama_sewa8` INT, IN `p_jam_mulai8` TIMESTAMP, IN `p_jam_habis8` TIMESTAMP, IN `p_harga8` INT, IN `p_total8` INT, OUT `p_last_id` INT)   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `set_status_bayar` (IN `id_sewa_param` INT, IN `bukti_file_param` VARCHAR(255))   BEGIN
    UPDATE bayar8 SET konfirmasi8 = 'Sudah Bayar', bukti8 = bukti_file_param WHERE id_sewa8 = id_sewa_param;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin8`
--

CREATE TABLE `admin8` (
  `id_user8` int(11) NOT NULL,
  `username8` varchar(20) DEFAULT NULL,
  `password8` varchar(20) DEFAULT NULL,
  `nama8` varchar(50) DEFAULT NULL,
  `no_handphone8` varchar(15) DEFAULT NULL,
  `email8` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin8`
--

INSERT INTO `admin8` (`id_user8`, `username8`, `password8`, `nama8`, `no_handphone8`, `email8`) VALUES
(8893, 'Skanpat', '11', 'Skanpat', '083186867022', 'redmiredmi600@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayar8`
--

CREATE TABLE `bayar8` (
  `id_bayar8` int(11) NOT NULL,
  `id_sewa8` int(11) DEFAULT NULL,
  `bukti8` text DEFAULT NULL,
  `tanggal_upload8` timestamp NULL DEFAULT current_timestamp(),
  `konfirmasi8` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bayar8`
--

INSERT INTO `bayar8` (`id_bayar8`, `id_sewa8`, `bukti8`, `tanggal_upload8`, `konfirmasi8`) VALUES
(1, 94, NULL, '2024-05-24 06:28:25', 'Belum Bayar'),
(2, 95, '665033b17dba4.png', '2024-05-24 06:28:36', 'Sudah Bayar'),
(3, 96, '665033c0598f7.png', '2024-05-24 06:28:46', 'Terkonfirmasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lapangan8`
--

CREATE TABLE `lapangan8` (
  `id_lapangan8` int(11) NOT NULL,
  `nama8` varchar(35) DEFAULT NULL,
  `keterangan8` text DEFAULT NULL,
  `harga8` int(11) DEFAULT NULL,
  `foto8` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lapangan8`
--

INSERT INTO `lapangan8` (`id_lapangan8`, `nama8`, `keterangan8`, `harga8`, `foto8`) VALUES
(39, 'Skanpat Futsal', 'Lapangan Futsal Rumput (SMK Negeri 4 Tanjungpinang) ', 1500000, '664d4b4543b07.png'),
(40, 'Skanpat  MinSoc', 'Lapangan Mini Soccer (SMK Negeri 4 Tanjungpinang)', 250000, '664d4bc0a6d51.jpg'),
(41, 'Skanpat  Badmin 1', 'Lapangan Badminton (SMK Negeri 4 Tanjungpinang)', 50000, '664d4c072776e.png'),
(42, 'Skanpat  Badmin 2', 'Lapangan Badminton (SMK Negeri 4 Tanjungpinang)', 50000, '664d4c62a2e8e.png'),
(43, 'Skanpat  Badmin 3', 'Lapangan Badminton  (SMK Negeri 4 Tanjungpinang)', 50000, '664d4ca3b43ae.png'),
(44, 'Skanpat  Badmin 4', 'Lapangan Badminton  (SMK Negeri 4 Tanjungpinang)', 50000, '664d4ed63b4a2.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaduan_pelanggan8`
--

CREATE TABLE `pengaduan_pelanggan8` (
  `id` int(11) NOT NULL,
  `name8` varchar(255) NOT NULL,
  `email8` varchar(255) NOT NULL,
  `phone8` varchar(20) NOT NULL,
  `message8` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sewa8`
--

CREATE TABLE `sewa8` (
  `id_sewa8` int(11) NOT NULL,
  `id_user8` int(11) DEFAULT NULL,
  `id_lapangan8` int(11) DEFAULT NULL,
  `tanggal_pesan8` timestamp NULL DEFAULT current_timestamp(),
  `lama_sewa8` int(11) NOT NULL,
  `jam_mulai8` timestamp NULL DEFAULT NULL,
  `jam_habis8` timestamp NULL DEFAULT NULL,
  `harga8` int(11) DEFAULT NULL,
  `total8` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Dipesan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sewa8`
--

INSERT INTO `sewa8` (`id_sewa8`, `id_user8`, `id_lapangan8`, `tanggal_pesan8`, `lama_sewa8`, `jam_mulai8`, `jam_habis8`, `harga8`, `total8`, `status`) VALUES
(94, 13, 39, '2024-05-24 06:28:25', 12, '2024-05-24 06:28:00', '2024-05-24 18:28:00', 1500000, 18000000, 'Dipakai'),
(95, 13, 40, '2024-05-24 06:28:36', 1, '2024-05-24 06:28:00', '2024-05-24 07:28:00', 250000, 250000, 'Dipakai'),
(96, 13, 41, '2024-05-24 06:28:46', 2, '2024-05-24 06:28:00', '2024-05-24 08:28:00', 50000, 100000, 'Dipakai');

--
-- Trigger `sewa8`
--
DELIMITER $$
CREATE TRIGGER `before_insert_sewa8` BEFORE INSERT ON `sewa8` FOR EACH ROW BEGIN
    IF NEW.jam_mulai8 <= NOW() AND NEW.jam_habis8 >= NOW() THEN
        SET NEW.status = 'Dipakai';
    ELSEIF NEW.jam_mulai8 > NOW() THEN
        SET NEW.status = 'Dipesan';
    ELSE
        SET NEW.status = 'Selesai';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_sewa8` BEFORE UPDATE ON `sewa8` FOR EACH ROW BEGIN
    IF NEW.jam_mulai8 <= NOW() AND NEW.jam_habis8 >= NOW() THEN
        SET NEW.status = 'Dipakai';
    ELSEIF NEW.jam_mulai8 > NOW() THEN
        SET NEW.status = 'Dipesan';
    ELSE
        SET NEW.status = 'Selesai';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user8`
--

CREATE TABLE `user8` (
  `id_user8` int(11) NOT NULL,
  `email8` varchar(50) NOT NULL,
  `password8` varchar(32) NOT NULL,
  `no_handphone8` varchar(20) DEFAULT NULL,
  `jenis_kelamin8` varchar(10) DEFAULT NULL,
  `nama_lengkap8` varchar(60) NOT NULL,
  `alamat8` text DEFAULT NULL,
  `foto8` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user8`
--

INSERT INTO `user8` (`id_user8`, `email8`, `password8`, `no_handphone8`, `jenis_kelamin8`, `nama_lengkap8`, `alamat8`, `foto8`) VALUES
(13, 'red@mail.com', '11', NULL, NULL, 'Irfan', NULL, NULL),
(14, 'm@gmail.com', '11', '083186867022', 'Perempuan', 'adhe', NULL, '664d9c3a97815.jpeg'),
(16, 'i@gmail.com', '11', NULL, NULL, 'iyuun', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin8`
--
ALTER TABLE `admin8`
  ADD PRIMARY KEY (`id_user8`);

--
-- Indeks untuk tabel `bayar8`
--
ALTER TABLE `bayar8`
  ADD PRIMARY KEY (`id_bayar8`),
  ADD KEY `id_sewa` (`id_sewa8`);

--
-- Indeks untuk tabel `lapangan8`
--
ALTER TABLE `lapangan8`
  ADD PRIMARY KEY (`id_lapangan8`);

--
-- Indeks untuk tabel `pengaduan_pelanggan8`
--
ALTER TABLE `pengaduan_pelanggan8`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sewa8`
--
ALTER TABLE `sewa8`
  ADD PRIMARY KEY (`id_sewa8`),
  ADD KEY `id_user` (`id_user8`),
  ADD KEY `sewa8_ibfk_2` (`id_lapangan8`);

--
-- Indeks untuk tabel `user8`
--
ALTER TABLE `user8`
  ADD PRIMARY KEY (`id_user8`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin8`
--
ALTER TABLE `admin8`
  MODIFY `id_user8` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8895;

--
-- AUTO_INCREMENT untuk tabel `bayar8`
--
ALTER TABLE `bayar8`
  MODIFY `id_bayar8` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `lapangan8`
--
ALTER TABLE `lapangan8`
  MODIFY `id_lapangan8` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `pengaduan_pelanggan8`
--
ALTER TABLE `pengaduan_pelanggan8`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sewa8`
--
ALTER TABLE `sewa8`
  MODIFY `id_sewa8` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT untuk tabel `user8`
--
ALTER TABLE `user8`
  MODIFY `id_user8` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bayar8`
--
ALTER TABLE `bayar8`
  ADD CONSTRAINT `bayar8_ibfk_1` FOREIGN KEY (`id_sewa8`) REFERENCES `sewa8` (`id_sewa8`);

--
-- Ketidakleluasaan untuk tabel `sewa8`
--
ALTER TABLE `sewa8`
  ADD CONSTRAINT `sewa8_ibfk_1` FOREIGN KEY (`id_user8`) REFERENCES `user8` (`id_user8`),
  ADD CONSTRAINT `sewa8_ibfk_2` FOREIGN KEY (`id_lapangan8`) REFERENCES `lapangan8` (`id_lapangan8`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
