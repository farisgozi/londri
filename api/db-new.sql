-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 15, 2025 at 11:37 PM
-- Server version: 11.5.2-MariaDB
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasilaundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_paket`, `qty`, `keterangan`) VALUES
(6, 2135, 4, 3, 'borongan sir'),
(7, 2136, 4, 2, 'cuci '),
(8, 2137, 4, 1, 'anjay'),
(9, 2138, 1, 1, 'jay'),
(10, 2139, 1, 1, 'as'),
(11, 2140, 5, 1, 'asd'),
(12, 2141, 4, 1, 'aksd'),
(13, 2142, 6, 1, 'oke'),
(14, 2143, 1, 1, 'jju'),
(15, 2144, 1, 1, 'jajan');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` int(11) NOT NULL,
  `nama_member` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan','','') NOT NULL,
  `tlp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `nama_member`, `alamat`, `jenis_kelamin`, `tlp`) VALUES
(1, 'Calista Zalfa', 'Jl Bintaro Tgh Bl U-3/13 RT 006/05, Dki Jakarta', 'Perempuan', '081578198726'),
(2, 'Zahrah Aulia', 'Jl Pinangsia Raya Glodok Plaza Bl A/11, Dki Jakarta', 'Perempuan', '081578198795'),
(3, 'Bayuu', 'Jln. Moleh No.78 Pondok Gede, Bekasi', 'Laki-laki', '08979464311'),
(4, 'Frieska', 'Jl Hj Uma', 'Perempuan', '0823489'),
(5, 'jaya', 'jl jaj', 'Perempuan', '0912479');

-- --------------------------------------------------------

--
-- Table structure for table `outlet`
--

CREATE TABLE `outlet` (
  `id_outlet` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tlp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outlet`
--

INSERT INTO `outlet` (`id_outlet`, `nama`, `alamat`, `tlp`) VALUES
(1, 'Family Laundry 01', 'Jl Holtikultura Kompl Pertanian 13, Dki Jakarta', '081386186028'),
(2, 'Family Laundry 02', 'Jl Pinangsia Raya Glodok Plaza Bl A/11, Dki Jakarta', '081468199628'),
(3, 'Aliefya Laundries', 'Jl. Pondok Aren No.153, Jakarta Tenggara', '08979464311'),
(4, 'Mawi Outlet', 'Jl Jakhar', '0895128372'),
(5, 'Mawi Outlet', 'Jl. Mawi', '098109238'),
(6, 'Mantap Outlet', 'Jl haji', '08291389');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id_paket` int(11) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `jenis` enum('kiloan','selimut','bed_cover','kaos','lain') NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id_paket`, `id_outlet`, `jenis`, `nama_paket`, `harga`) VALUES
(1, 1, 'bed_cover', 'Cuci bed cover sedang', 15000),
(2, 1, 'selimut', 'Cuci Selimut Tipis', 10000),
(3, 1, 'selimut', 'Cuci Selimut Sedang', 15000),
(4, 3, 'kaos', 'Cuci Kaos Tipis', 12000),
(5, 3, 'lain', 'Cuci Custom (apa aja)', 16000),
(6, 3, 'kaos', 'Cuci Custom Baju', 270000),
(7, 3, 'kiloan', 'Cuci Cumi', 7000),
(8, 3, 'kiloan', 'Cuci Satuan', 15000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `batas_waktu` date NOT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `status` enum('baru','proses','selesai','diambil') NOT NULL,
  `dibayar` enum('dibayar','belum dibayar') NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `diskon` decimal(5,2) DEFAULT 0.00,
  `pajak` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_outlet`, `id_member`, `tgl`, `batas_waktu`, `tgl_bayar`, `status`, `dibayar`, `id_user`, `id_paket`, `diskon`, `pajak`) VALUES
(2135, 3, 2, '2025-02-12', '2025-02-15', '2025-02-13', 'selesai', 'dibayar', 123, 4, 0.00, 0.00),
(2136, 3, 3, '2025-02-12', '2025-02-15', '2025-02-14', 'selesai', 'dibayar', 123, 4, 0.00, 0.00),
(2137, 3, 3, '2025-02-13', '2025-02-16', '2025-02-15', 'selesai', 'dibayar', 7, 4, 0.00, 0.00),
(2138, 1, 1, '2025-02-13', '2025-02-16', '2025-02-15', 'selesai', 'dibayar', 123, 1, 0.00, 0.00),
(2139, 3, 3, '2025-02-13', '2025-02-16', '2025-02-15', 'selesai', 'dibayar', 123, 1, 0.00, 0.00),
(2140, 3, 4, '2025-02-13', '2025-02-16', '2025-02-15', 'selesai', 'dibayar', 7, 5, 0.00, 0.00),
(2141, 2, 3, '2025-02-13', '2025-02-16', '2025-02-15', 'selesai', 'dibayar', 123, 4, 0.00, 0.00),
(2142, 3, 4, '2025-02-14', '2025-02-17', '2025-02-15', 'diambil', 'dibayar', 123, 6, 2.00, 12.00),
(2143, 3, 3, '2025-02-14', '2025-02-17', '2025-02-15', 'selesai', 'dibayar', 123, 1, 3.00, 12.00),
(2144, 3, 3, '2025-02-14', '2025-02-17', '2025-02-15', 'selesai', 'dibayar', 123, 1, 2.00, 12.00);

--
-- Triggers `transaksi`
--
DELIMITER $$
CREATE TRIGGER `before_insert_transaksi` BEFORE INSERT ON `transaksi` FOR EACH ROW BEGIN
    IF NEW.dibayar = 'dibayar' THEN
        SET NEW.tgl_bayar = CURRENT_DATE;
    ELSE
        SET NEW.tgl_bayar = NULL;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `role` enum('admin','kasir','owner','') NOT NULL,
  `id_outlet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `role`, `id_outlet`) VALUES
(7, 'Dimas', 'Jawir', '202cb962ac59075b964b07152d234b70', 'kasir', 1),
(123, 'Inkra Andini', 'admin', '5a61d78a46cd005a3a52bdf08dad60b8', 'admin', 1),
(235, 'yeo', 'yeo', '5a61d78a46cd005a3a52bdf08dad60b8', 'owner', 4),
(236, 'Diel', 'yael', '5a61d78a46cd005a3a52bdf08dad60b8', 'kasir', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `outlet`
--
ALTER TABLE `outlet`
  ADD PRIMARY KEY (`id_outlet`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `outlet`
--
ALTER TABLE `outlet`
  MODIFY `id_outlet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2145;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
