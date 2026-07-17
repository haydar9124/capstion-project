-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql313.infinityfree.com
-- Waktu pembuatan: 17 Jul 2026 pada 00.05
-- Versi server: 11.4.12-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42309829_ewarung`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alamat`
--

CREATE TABLE `alamat` (
  `id_alamat` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `label_alamat` varchar(50) DEFAULT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `alamat`
--

INSERT INTO `alamat` (`id_alamat`, `id_user`, `label_alamat`, `alamat_lengkap`, `no_hp`) VALUES
(1, 2, 'Rumah', 'kaliwinasuh', '-'),
(2, 2, 'Rumah', 'kaliwinasuh\r\n', '-'),
(3, 2, 'Rumah', 'pemalang', '-'),
(4, 5, 'Rumah', 'kalimandi', '-'),
(5, 5, 'Rumah', 'Klampok ', '-'),
(6, 5, 'Rumah', 'Klampok', '-'),
(7, 6, 'Rumah', ' Wanarejan selatan kec Taman kab Pemalang ', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `harga` decimal(12,2) DEFAULT NULL,
  `subtotal` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `qty`, `harga`, `subtotal`) VALUES
(1, 1, 3, 1, '18000.00', 0),
(2, 2, 12, 1, '16000.00', 0),
(3, 3, 2, 1, '18000.00', 0),
(4, 3, 5, 1, '13000.00', 0),
(5, 4, 12, 2, '16000.00', 0),
(6, 4, 11, 1, '16000.00', 0),
(7, 5, 11, 1, '16000.00', 0),
(8, 5, 12, 3, '16000.00', 0),
(9, 6, 1, 2, '15000.00', 0),
(10, 7, 8, 1, '16000.00', 0),
(11, 8, 3, 2, '18000.00', 36000),
(12, 9, 12, 1, '16000.00', 16000),
(13, 10, 12, 1, '16000.00', 16000),
(14, 11, 11, 1, '16000.00', 16000),
(15, 12, 12, 1, '16000.00', 16000),
(16, 13, 12, 1, '16000.00', 16000),
(17, 14, 12, 1, '16000.00', 16000),
(18, 15, 12, 1, '16000.00', 16000),
(19, 16, 12, 1, '16000.00', 16000),
(20, 17, 2, 2, '18000.00', 36000),
(21, 18, 11, 1, '16000.00', 16000),
(22, 19, 9, 1, '16000.00', 16000),
(23, 20, 12, 1, '24000.00', 24000),
(24, 20, 11, 1, '16000.00', 16000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Keripik Pisang'),
(2, 'Keripik Singkong'),
(3, 'Keripik Tempe'),
(4, 'Keripik Ubi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT 1,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id_metode` int(11) NOT NULL,
  `nama_metode` varchar(50) NOT NULL,
  `nomor` varchar(100) NOT NULL,
  `atas_nama` varchar(100) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id_metode`, `nama_metode`, `nomor`, `atas_nama`, `gambar`, `status`) VALUES
(1, 'Transfer BCA', '1234567890', 'Aji', '1784211860_6930.png', 'Aktif'),
(2, 'Transfer BRI', '987654321', 'E-Warung', '1784211844_7667.png', 'Aktif'),
(3, 'Dana', '081234567890', 'E-Warung', '1784211874_3153.png', 'Aktif'),
(4, 'OVO', '081234567891', 'E-Warung', '1784211884_4929.png', 'Aktif'),
(5, 'GoPay', '081234567892', 'E-Warung', '1784211895_8896.png', 'Aktif'),
(6, 'COD', '-', '-', '', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `id_alamat` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `subtotal` decimal(12,2) DEFAULT NULL,
  `ongkir` decimal(12,2) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status` enum('Menunggu Pembayaran','Diproses','Dikirim','Selesai','Dibatalkan') DEFAULT 'Menunggu Pembayaran',
  `status_sebelumnya` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `alamat`, `id_alamat`, `tanggal`, `subtotal`, `ongkir`, `total`, `metode_pembayaran`, `bukti_transfer`, `status`, `status_sebelumnya`) VALUES
(1, 2, NULL, 1, '2026-06-03 22:11:41', '18000.00', '0.00', '18000.00', 'Dana', NULL, 'Selesai', NULL),
(2, 2, NULL, 2, '2026-06-03 22:55:35', '16000.00', '0.00', '16000.00', 'Transfer Bank', NULL, 'Selesai', NULL),
(3, 2, NULL, 3, '2026-06-03 23:30:37', '31000.00', '0.00', '31000.00', 'COD', NULL, 'Selesai', NULL),
(4, 5, NULL, 4, '2026-06-18 22:58:00', '48000.00', '0.00', '48000.00', 'Transfer Bank', NULL, 'Diproses', NULL),
(5, 5, NULL, 5, '2026-06-19 07:18:23', '64000.00', '0.00', '64000.00', 'COD', NULL, 'Menunggu Pembayaran', NULL),
(6, 5, NULL, 6, '2026-06-19 07:32:45', '30000.00', '0.00', '30000.00', 'COD', NULL, 'Menunggu Pembayaran', NULL),
(7, 6, NULL, 7, '2026-06-30 21:47:19', '16000.00', '0.00', '16000.00', 'Dana', NULL, 'Selesai', NULL),
(8, 7, NULL, NULL, '2026-06-30 23:16:25', NULL, NULL, '36000.00', 'Transfer Bank (Alamat: a)', NULL, '', 'Menunggu Pembayaran'),
(9, 7, NULL, NULL, '2026-06-30 23:17:58', NULL, NULL, '16000.00', 'Transfer Bank (Alamat: Kaliwinasuh )', NULL, '', 'Menunggu Pembayaran'),
(10, 7, 'Kaliwinasuh ', NULL, '2026-06-30 23:22:38', NULL, NULL, '16000.00', 'Transfer Bank', NULL, 'Dibatalkan', NULL),
(11, 7, 'aa', NULL, '2026-06-30 23:23:39', NULL, NULL, '16000.00', 'Transfer Bank', NULL, 'Dibatalkan', NULL),
(12, 7, 'bb', NULL, '2026-06-30 23:24:07', NULL, NULL, '16000.00', 'Transfer Bank', NULL, 'Dibatalkan', NULL),
(13, 7, 'aas', NULL, '2026-06-30 23:25:55', NULL, NULL, '16000.00', 'Transfer Bank', NULL, 'Dibatalkan', NULL),
(14, 7, 'P', NULL, '2026-06-30 23:34:51', NULL, NULL, '16000.00', 'Transfer Bank', NULL, 'Dibatalkan', NULL),
(15, 7, 'Kaliwinasuh ', NULL, '2026-06-30 23:38:21', NULL, NULL, '16000.00', 'Transfer Bank', NULL, 'Dibatalkan', NULL),
(16, 7, 'Kalimandi', NULL, '2026-06-30 23:40:38', NULL, NULL, '16000.00', 'Transfer Bank', NULL, 'Dikirim', NULL),
(17, 8, 'Kalimantan ', NULL, '2026-07-08 20:17:13', NULL, NULL, '36000.00', 'Transfer Bank', NULL, 'Selesai', NULL),
(18, 8, 'Kalimantan ', NULL, '2026-07-08 20:18:33', NULL, NULL, '16000.00', 'Dana', NULL, 'Selesai', NULL),
(19, 7, 'Pagak', NULL, '2026-07-16 05:19:15', NULL, NULL, '16000.00', 'Transfer BCA', NULL, 'Selesai', NULL),
(20, 9, 'kalimantan', NULL, '2026-07-16 17:21:13', NULL, NULL, '40000.00', 'Transfer BRI', NULL, 'Menunggu Pembayaran', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `berat` varchar(20) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT 5.0,
  `terjual` int(11) DEFAULT 0,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `deskripsi`, `harga`, `stok`, `berat`, `rating`, `terjual`, `gambar`, `created_at`, `foto`) VALUES
(1, 1, 'Keripik Kentang Original', 'Komposisi ( Kentang pilihan, minyak sayur, garam )\r\nKeripik kentang klasik yang renyah dan gurih, cocok untuk segala suasana.', '20000.00', 100, '250 Gram', '5.0', 0, 'pisang1.jpg', '2026-06-03 14:31:30', '1784210272_34472.jpg'),
(2, 1, 'Onde-onde', 'Komposisi ( Tepung ketan, kacang hijau, wijen )\r\nOnde-onde kenyal gurih berselimut wijen dengan isian kacang hijau manis.', '23000.00', 98, '250 Gram', '5.0', 0, 'pisang2.jpg', '2026-06-03 14:31:30', '1784210009_34631.png'),
(3, 1, 'Keripik Pisang Original', 'Komposisi ( Pisang kepok pilihan, minyak sayur )\r\nKeripik pisang tipis dan renyah dengan rasa manis alami khas pisang kepok pilihan.', '17000.00', 100, '250 Gram', '5.0', 0, 'pisang3.jpg', '2026-06-03 14:31:30', '1784209797_37807.jpg'),
(4, 2, 'Keripik Singkong Original', 'Komposisi ( Singkong pilihan, minyak sayur, garam )\r\nKeripik singkong renyah dengan cita rasa gurih original, dipotong tipis dan digoreng garing hingga kriuk maksimal.', '14000.00', 100, '250 Gram', '5.0', 0, 'singkong1.jpg', '2026-06-03 14:31:30', '1784210618_37833.jpg'),
(5, 2, 'Keripik Pare Original', 'Komposisi ( Pare pilihan, tepung, bumbu rempah )\r\nKeripik pare renyah dengan rasa sedikit pahit khas yang menyehatkan, camilan unik anti mainstream.', '19000.00', 100, '250 Gram', '5.0', 0, 'singkong2.jpg', '2026-06-03 14:31:30', '1784210689_37834.jpg'),
(6, 2, 'Kue Nastar', 'Komposisi ( Tepung terigu, mentega, selai nanas asli )\r\nKue kering nastar isi selai nanas asli, klasik dan selalu jadi favorit musim lebaran.', '45000.00', 100, '250 Gram', '5.0', 0, 'singkong3.jpg', '2026-06-03 14:31:30', '1784210369_34567.png'),
(7, 3, 'Telur Gabus Pedas', 'Komposisi ( Tepung tapioka, telur, bumbu pedas )\r\nTelur gabus renyah gurih berbentuk unik dengan sensasi pedas yang nampol.', '15000.00', 100, '250 Gram', '5.0', 0, 'tempe1.jpg', '2026-06-03 14:31:30', '1784210851_34674.png'),
(8, 3, 'Keripik Tempe Original', 'Komposisi ( Tempe pilihan, tepung beras, bumbu bawang )\r\nKeripik tempe tipis nan renyah dengan rasa gurih khas bawang, cocok jadi teman nasi atau cemilan.', '16000.00', 100, '250 Gram', '5.0', 0, 'tempe2.jpg', '2026-06-03 14:31:30', '1784210748_37835.jpg'),
(9, 3, 'Keripik Tempe Pedas', 'Komposisi ( Tempe pilihan, tepung beras, bumbu cabai )\r\nKeripik tempe renyah dengan sensasi pedas gurih yang bikin nagih.', '16000.00', 99, '250 Gram', '5.0', 0, 'tempe3.jpg', '2026-06-03 14:31:30', '1784210918_37836.jpg'),
(10, 4, 'Kue Putri Salju', 'Komposisi ( Tepung terigu, mentega, kacang almond, gula halus )\r\nKue putri salju lembut dengan taburan gula halus, manis legit meleleh di mulut.', '23000.00', 100, '250 Gram', '5.0', 0, 'ubi1.jpg', '2026-06-03 14:31:30', '1784211194_34629.png'),
(11, 4, 'Basreng Pedas', 'Komposisi ( Bakso goreng, bumbu pedas, daun jeruk )\r\nBasreng kering pedas gurih dengan aroma daun jeruk yang khas, camilan viral kekinian.', '16000.00', 98, '250 Gram', '5.0', 0, 'ubi2.jpg', '2026-06-03 14:31:30', '1784211082_34635.png'),
(12, 4, 'Kue Kastengel Keju', 'Komposisi ( Tepung terigu, mentega, keju edam )\r\nKastengel gurih dengan taburan keju edam premium, renyah dan lumer di mulut.', '24000.00', 98, '250 Gram', '5.0', 0, 'ubi3.jpg', '2026-06-03 14:31:30', '1784210999_34593.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expired` datetime DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default.png',
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `reset_token`, `reset_expired`, `no_hp`, `foto`, `role`, `created_at`) VALUES
(2, 'Haydar Ali Aji Saputra', 'user@ewarung.com', 'user123', NULL, NULL, '085826635640', 'default.png', 'user', '2026-06-03 14:51:09'),
(3, 'Administrator', 'admin@ewarung.com', 'admin123', NULL, NULL, '08123456789', 'default.png', 'admin', '2026-06-03 15:31:56'),
(5, 'anisa', 'anis13@gmail.com', '12345678', NULL, NULL, '0823294294292', 'default.png', 'user', '2026-06-04 03:37:51'),
(6, 'Nabilah Zaenab Aqilatulwahyi', 'mahdazahraummulbatul@gmail.com', 'Ali11', NULL, NULL, '08976631014', 'default.png', 'user', '2026-07-01 04:43:44'),
(7, 'Reza', 'reza@gmail.com', 'reza123', NULL, NULL, '08123456789', 'default.png', 'user', '2026-07-01 04:43:44'),
(8, 'Santi', 'santi@gmail.com', '$2y$10$Lfxxj4DeyO5AG/46VF1CcOnPI3W8jEJ7L9OMuzr61SmKxK/34gN72', NULL, NULL, '085685453646', 'default.png', 'user', '2026-07-09 03:15:03'),
(9, 'sani', 'sani1234@gmail.com', '$2y$10$eC1pc0pUEHT4hnvmR6poYukMswQdZS9XbxmVGsfBVWQpjA6iGouLO', NULL, NULL, '083746287364', 'default.png', 'user', '2026-07-17 00:19:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id_alamat`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id_metode`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_alamat` (`id_alamat`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id_alamat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id_metode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `alamat`
--
ALTER TABLE `alamat`
  ADD CONSTRAINT `alamat_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id_alamat`);

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
