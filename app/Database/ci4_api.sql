-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Des 2023 pada 04.21
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci4_api`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL COMMENT 'Primary Key',
  `nama_produk` varchar(100) NOT NULL COMMENT 'Nama Produk',
  `harga` varchar(255) NOT NULL COMMENT 'Harga'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='datatable produk table';

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `harga`) VALUES
(8, 'Mousev2', '20000'),
(9, 'Mosde', '20000');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
