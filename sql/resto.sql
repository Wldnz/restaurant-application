-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Feb 2025 pada 04.09
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `your_database`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detailpesanan`
--

CREATE TABLE `detailpesanan` (
  `id` int(11) NOT NULL,
  `id_meja` int(11) NOT NULL,
  `nama_pengguna` varchar(80) NOT NULL,
  `jumlah_orang` int(11) NOT NULL DEFAULT 1,
  `tanggal` date NOT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detailpesanan`
--


--
-- Struktur dari tabel `histori`
--

CREATE TABLE `histori` (
  `id` int(11) NOT NULL,
  `id_detailpesanan` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `tanggal_selesai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `histori`
--

--
-- Struktur dari tabel `meja`
--

CREATE TABLE `meja` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tipe_meja` varchar(20) NOT NULL DEFAULT 'standar',
  `nama_pengguna` varchar(80) NOT NULL,
  `jumlah_orang` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `meja`
--

INSERT INTO `meja` (`id`, `nama`, `tipe_meja`, `nama_pengguna`, `jumlah_orang`, `status`) VALUES
(1, 'A1', 'standar', '', 0, 0),
(2, 'A2', 'standar', '', 0, 0),
(3, 'A3', 'standar', '', 0, 0),
(4, 'A4', 'standar', '', 0, 0),
(5, 'B1', 'standar', '', 0, 0),
(6, 'B2', 'standar', '', 0, 0),
(7, 'B3', 'standar', '', 0, 0),
(8, 'B4', 'standar', '', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama` varchar(265) DEFAULT NULL,
  `password` varchar(265) DEFAULT NULL,
  `role` varchar(6) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `password`, `role`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin'),
(2, 'kasir', '2c7ee7ade401a7cef9ef4dad9978998cf42ed805243d6c91f89408c6097aa571', 'kasir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `id_detailpesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `harga` int(11) NOT NULL,
  `kategori` varchar(27) NOT NULL DEFAULT 'makanan',
  `image_url` varchar(265) NOT NULL DEFAULT 'https://lh6.googleusercontent.com/Bu-pRqU_tWZV7O3rJ5nV1P6NjqFnnAs8kVLC5VGz_Kf7ws0nDUXoGTc7pP87tyUCfu8VyXi0YviIm7CxAISDr2lJSwWwXQxxz98qxVfMcKTJfLPqbcfhn-QEeOowjrlwX1LYDFJN'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `deskripsi`, `harga`, `kategori`, `image_url`) VALUES
(1, 'Mie Ayam', 'Mie Ayam Sangat Lezat Dan Berkualitas Tinggi', 10000, 'makanan', 'https://i.ytimg.com/vi/QiZt1ALYVEQ/maxresdefault.jpg'),
(2, 'Bakso Ayam', 'Bakso Ini Sangat Berkualitas Tinggi, Meningkatkan Hunger Bar Sebanyak 50 Points', 10000, 'makanan', 'https://assets.tmecosys.com/image/upload/t_web767x639/img/recipe/ras/Assets/193a3f08ee8bdb713ea0e392beccc4cd/Derivates/bd9265788361a10041eb31dd210c547c211ef509.jpg'),
(3, 'Air Putih', 'Air Putih Dari Pegunungan Asli, Rill No Fake', 5000, 'minuman', 'https://www.astronauts.id/blog/wp-content/uploads/2022/12/Harus-Tahu-Ini-Manfaat-Minum-Air-Putih-2-Liter-Sehari.jpg'),
(4, 'Es Teh manis', 'Es Teh Manis, Sangat Memiliki Khasiat Tinggi Yakni menyegarkan mulut peminumnya', 5000, 'minuman', 'https://tribratanews.ntb.polri.go.id/wp-content/uploads/2024/10/Image-21.jpg'),
(5, 'Bakwan Crispy', 'Bakwan Lezattttttttt', 5000, 'makanan', 'https://asset-a.grid.id/crop/0x0:0x0/x/photo/2021/02/17/bakwan-crispyjpg-20210217122049.jpg'),
(6, 'Udang Crispy', 'udang yang sangat nikmat', 10000, 'makanan', 'https://www.dapurkobe.co.id/wp-content/uploads/udang-cirspy-boncabe.jpg'),
(12, 'Ayam Goreng Crispy', 'enak', 18000, 'makanan', 'https://www.unileverfoodsolutions.co.id/dam/global-ufs/mcos/SEA/calcmenu/recipes/ID-recipes/chicken-&-other-poultry-dishes/crispy-fried-chicken/Ayam%20Goreng%20Krispy1260x700.jpg'),
(13, 'Teh Sosro', 'enak', 8000, 'minuman', 'https://upload.wikimedia.org/wikipedia/commons/0/01/Teh_Botol_Sosro.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detailpesanan`
--
ALTER TABLE `detailpesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_meja` (`id_meja`);

--
-- Indeks untuk tabel `histori`
--
ALTER TABLE `histori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_detailpesanan2` (`id_detailpesanan`);

--
-- Indeks untuk tabel `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_detailpesanan` (`id_detailpesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Ketidakleluasaan untuk tabel `detailpesanan`
--
ALTER TABLE `detailpesanan`
  ADD CONSTRAINT `id_meja` FOREIGN KEY (`id_meja`) REFERENCES `meja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `histori`
--
ALTER TABLE `histori`
  ADD CONSTRAINT `id_detailpesanan2` FOREIGN KEY (`id_detailpesanan`) REFERENCES `detailpesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `id_detailpesanan` FOREIGN KEY (`id_detailpesanan`) REFERENCES `detailpesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
