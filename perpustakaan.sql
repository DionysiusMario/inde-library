-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2021 at 12:28 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `nim` int(14) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `kota` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `no_telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`nim`, `nama`, `password`, `alamat`, `kota`, `email`, `no_telp`) VALUES
(20000, 'okin', '$2y$10$fOwpBGtrm0/0sftoRElwm.h', 'Batang', 'Batang', 'okin@gmail.com', '081264924769'),
(20001, 'ale', '$2y$10$vRlEsj51iGu7IERF0lhSXey', 'Purwakarta', 'Purwakarta', 'ale@gmail.com', '081375091342'),
(20002, 'dion', '$2y$10$XIVNea5nh2PzdEVsuWCyHus', 'Jakarta', 'Jakarta', 'dion@gmail.com', '081295381211'),
(20003, 'japar', '$2y$10$IU0zNRDfhFFyVVGvzajz/eM', 'Jakarta', 'Jakarta', 'japar@gmail.com', '081295600143'),
(20004, 'asep', '$2y$10$/ZYcJX1o0NL4HGsa5I0yeu7', 'Semarang', 'Semarang', 'asep@gmail.com', '081315730568');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `idbuku` int(5) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `idkategori` int(5) NOT NULL,
  `pengarang` varchar(30) NOT NULL,
  `penerbit` varchar(30) NOT NULL,
  `kota_terbit` varchar(30) NOT NULL,
  `editor` varchar(30) NOT NULL,
  `file_gambar` varchar(255) DEFAULT NULL,
  `tgl_insert` date NOT NULL,
  `tgl_update` date NOT NULL,
  `stok` int(5) NOT NULL,
  `stok_tersedia` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`idbuku`, `isbn`, `judul`, `idkategori`, `pengarang`, `penerbit`, `kota_terbit`, `editor`, `file_gambar`, `tgl_insert`, `tgl_update`, `stok`, `stok_tersedia`) VALUES
(1, '001-1', 'The Adventures of Tom Sawyer', 7, 'Mark Twain', 'American Publishing Company', 'United States of America', 'Mark Twain', 'tomsawyer.png', '2021-10-22', '2021-10-22', 5, 5),
(2, '001-2', 'Laskar Pelangi', 9, 'Andrea Hirata', 'Bentang Pustaka', 'Yogyakarta', 'Andrea Hirata', 'laskarpelangi.png', '2021-10-22', '2021-10-22', 7, 4),
(3, '001-3', 'Frankenstein', 2, 'Mary Shelley', 'Lackington, Hughes, Harding, M', 'London', 'Mary Shelley', 'frankenstein.png', '2021-10-22', '2021-10-22', 3, 2),
(4, '001-4', 'Sang Pemimpi', 7, 'Andrea Hirata', 'Bentang Pustaka', 'Yogyakarta', 'Andrea Hirata', 'sangpemimpi.png', '2021-10-22', '2021-10-22', 5, 4),
(5, '001-5', 'Harry Potter and the Prisoner of Azkaban', 4, 'J. K. Rowling', 'Bloomsbury', 'London', 'J. K. Rowling', 'harrypotter.png', '2021-10-22', '2021-10-22', 10, 8);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pinjam`
--

CREATE TABLE `detail_pinjam` (
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `idtransaksi` int(5) NOT NULL,
  `idbuku` int(5) NOT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `denda` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int(5) NOT NULL,
  `nama` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `nama`) VALUES
(1, 'Fantasy'),
(2, 'Horror'),
(3, 'Romance'),
(4, 'Science Fiction'),
(5, 'Mistery'),
(6, 'Comedy'),
(7, 'Adventure'),
(8, 'Education'),
(9, 'Biographies'),
(10, 'History');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `idtransaksi` int(5) NOT NULL,
  `nim` int(14) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `total_denda` int(11) NOT NULL,
  `idpetugas` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `idpetugas` int(5) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`idpetugas`, `nama`, `password`) VALUES
(1, 'admin', '$2y$10$nEa7JQD70Cpd7qfo/vr6z.o');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`idbuku`),
  ADD KEY `FK_Buku_Kategori` (`idkategori`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD KEY `FK_DetailT_Buku` (`idbuku`),
  ADD KEY `FK_DetailT_Peminjaman` (`idtransaksi`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`idtransaksi`),
  ADD KEY `FK_Peminjaman_Anggota` (`nim`),
  ADD KEY `FK_Peminjaman_Petugas` (`idpetugas`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`idpetugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `idbuku` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `idtransaksi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `idpetugas` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `FK_Buku_Kategori` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`);

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `FK_DetailT_Buku` FOREIGN KEY (`idbuku`) REFERENCES `buku` (`idbuku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_DetailT_Peminjaman` FOREIGN KEY (`idtransaksi`) REFERENCES `peminjaman` (`idtransaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `FK_Peminjaman_Anggota` FOREIGN KEY (`nim`) REFERENCES `anggota` (`nim`),
  ADD CONSTRAINT `FK_Peminjaman_Petugas` FOREIGN KEY (`idpetugas`) REFERENCES `petugas` (`idpetugas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
