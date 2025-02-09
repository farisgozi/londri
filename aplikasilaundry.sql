-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Jan 2022 pada 00.17
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `aplikasilaundry`

-- --------------------------------------------------------

-- Struktur dari tabel `detail_transaksi`

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id_detail_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data untuk tabel `detail_transaksi`

INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_paket`, `qty`, `keterangan`) VALUES
(1, 1, 2, 3, '-');

-- --------------------------------------------------------

-- Struktur dari tabel `member`

CREATE TABLE `member` (
  `id_member` int(11) NOT NULL AUTO_INCREMENT,
  `nama_member` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan','','') NOT NULL,
  `tlp` varchar(15) NOT NULL,
  PRIMARY KEY (`id_member`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data untuk tabel `member`

INSERT INTO `member` (`id_member`, `nama_member`, `alamat`, `jenis_kelamin`, `tlp`) VALUES
(1, 'Calista Zalfa', 'Jl Bintaro Tgh Bl U-3/13 RT 006/05, Dki Jakarta', 'Perempuan', '081578198726'),
(2, 'Zahrah Aulia', 'Jl Pinangsia Raya Glodok Plaza Bl A/11, Dki Jakarta', 'Perempuan', '081578198795');

-- --------------------------------------------------------

-- Struktur dari tabel `outlet`

CREATE TABLE `outlet` (
  `id_outlet` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tlp` varchar(15) NOT NULL,
  PRIMARY KEY (`id_outlet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data untuk tabel `outlet`

INSERT INTO `outlet` (`id_outlet`, `nama`, `alamat`, `tlp`) VALUES
(1, 'Family Laundry 01', 'Jl Holtikultura Kompl Pertanian 13, Dki Jakarta', '081386186028'),
(2, 'Family Laundry 02', 'Jl Pinangsia Raya Glodok Plaza Bl A/11, Dki Jakarta', '081468199628');

-- --------------------------------------------------------

-- Struktur dari tabel `paket`

CREATE TABLE `paket` (
  `id_paket` int(11) NOT NULL AUTO_INCREMENT,
  `id_outlet` int(11) NOT NULL,
  `jenis` enum('kiloan','selimut','bed_cover','kaos','lain') NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  PRIMARY KEY (`id_paket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data untuk tabel `paket`

INSERT INTO `paket` (`id_paket`, `id_outlet`, `jenis`, `nama_paket`, `harga`) VALUES
(1, 1, 'bed_cover', 'Cuci bed cover sedang', 15000),
(2, 1, 'selimut', 'Cuci Selimut Tipis', 10000),
(3, 1, 'selimut', 'Cuci Selimut Sedang', 15000);

-- --------------------------------------------------------

-- Struktur dari tabel `transaksi`

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_outlet` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `batas_waktu` date NOT NULL,
  `tgl_bayar` date DEFAULT NULL, -- Set default value to NULL
  `status` enum('baru','proses','selesai','diambil') NOT NULL,
  `dibayar` enum('dibayar','belum dibayar') NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data untuk tabel `transaksi`

INSERT INTO `transaksi` (`id_transaksi`, `id_outlet`, `id_member`, `tgl`, `batas_waktu`, `tgl_bayar`, `status`, `dibayar`, `id_user`, `id_paket`) VALUES
(1, 1, 1, '2022-01-22', '2022-01-25', '2022-01-26', 'diambil', 'dibayar', 123, 2);

-- --------------------------------------------------------

-- Struktur dari tabel `user`

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `role` enum('admin','kasir','owner','') NOT NULL,
  `id_outlet` int(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data untuk tabel `user`

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `role`, `id_outlet`) VALUES
(123, 'Inkra Andini', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 'admin', 1);

COMMIT;
