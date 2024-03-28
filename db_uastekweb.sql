-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2023 at 09:31 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uastekweb21`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `status_aktif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `nama_admin`, `status_aktif`) VALUES
(1, 'admin0', 'admin0', 'admin0', 1),
(2, 'admin2', 'admin2', 'sat', 1),
(3, 'admin3', 'admin3', 'sat', 1),
(4, 'admin4', 'admin4', 'admin4', 1),
(5, 'admin5', 'admin5', 'admin5', 0),
(6, 'admin123', '1234', 'Satriya', 1),
(7, 'admin311', 'admin311', 'ber', 0);

-- --------------------------------------------------------

--
-- Table structure for table `log_pengiriman`
--

CREATE TABLE `log_pengiriman` (
  `tanggal` date NOT NULL,
  `kota` varchar(20) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `nomor_resi` int(11) NOT NULL,
  `log_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resi_pengiriman`
--

CREATE TABLE `resi_pengiriman` (
  `nomor_resi` int(11) NOT NULL,
  `tanggal_resi` date NOT NULL,
  `jenis_pengiriman` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resi_pengiriman`
--

INSERT INTO `resi_pengiriman` (`nomor_resi`, `tanggal_resi`, `jenis_pengiriman`) VALUES
(18, '2023-12-22', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `log_pengiriman`
--
ALTER TABLE `log_pengiriman`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_nomor_resi` (`nomor_resi`);

--
-- Indexes for table `resi_pengiriman`
--
ALTER TABLE `resi_pengiriman`
  ADD PRIMARY KEY (`nomor_resi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `log_pengiriman`
--
ALTER TABLE `log_pengiriman`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `resi_pengiriman`
--
ALTER TABLE `resi_pengiriman`
  MODIFY `nomor_resi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log_pengiriman`
--
ALTER TABLE `log_pengiriman`
  ADD CONSTRAINT `fk_nomor_resi` FOREIGN KEY (`nomor_resi`) REFERENCES `resi_pengiriman` (`nomor_resi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
