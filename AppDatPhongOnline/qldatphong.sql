-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2023 at 08:54 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qldatphong`
--

-- --------------------------------------------------------

--
-- Table structure for table `datphong`
--

CREATE TABLE `datphong` (
  `DatPhongID` int(11) NOT NULL,
  `NgayDat` date NOT NULL,
  `NgayNhanPhong` date NOT NULL,
  `TongTien` decimal(10,2) NOT NULL,
  `KhachHangID` int(11) DEFAULT NULL,
  `PhongID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `KhachHangID` int(11) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `SoDienThoai` varchar(15) NOT NULL,
  `QuyenTruyCap` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nhanghi`
--

CREATE TABLE `nhanghi` (
  `NhaNghiID` int(11) NOT NULL,
  `TenNhaNghi` varchar(255) NOT NULL,
  `DiaChi` varchar(255) NOT NULL,
  `SoDienThoai` varchar(15) NOT NULL,
  `Anh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhanghi`
--

INSERT INTO `nhanghi` (`NhaNghiID`, `TenNhaNghi`, `DiaChi`, `SoDienThoai`, `Anh`) VALUES
(1, 'Nhà nghỉ Hòa Bình', '334 Nguyễn Đức Cảnh', '0314585479', 'nhanghi1.jpg'),
(2, 'Hanoi Aria Central Hotel & Spa', '45 Lê Duẩn', '0319999999', 'nhanghi2.jpg'),
(3, 'Nhà nghỉ Hà Nội City Backpackers', '55B Bat Su Hà Nội', '0319998888', 'nhanghi3.jpg'),
(4, 'Hanoi Golden Charm Hotel', '24A Hàng Quất ST Hoàn Kiếm, Hà Nội', '0319998888', 'nhanghi4.jpg'),
(5, 'Vatc Sleeppod Terminal 2', 'Tầng 2 Temainal Sân Bay Nội Bài, Hà Nội', '0319777777', 'nhanghi5.jpg'),
(6, 'Hanoi Stella hotel', '36 Hàng Tre Hoàn Kiếm, Hà Nội', '0319777777', 'nhanghi6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `phong`
--

CREATE TABLE `phong` (
  `PhongID` int(11) NOT NULL,
  `TenPhong` varchar(50) NOT NULL,
  `GiaPhong` decimal(10,2) NOT NULL,
  `SoLuongGiuong` int(11) NOT NULL,
  `NhaNghiID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datphong`
--
ALTER TABLE `datphong`
  ADD PRIMARY KEY (`DatPhongID`),
  ADD KEY `KhachHangID` (`KhachHangID`),
  ADD KEY `PhongID` (`PhongID`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`KhachHangID`);

--
-- Indexes for table `nhanghi`
--
ALTER TABLE `nhanghi`
  ADD PRIMARY KEY (`NhaNghiID`);

--
-- Indexes for table `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`PhongID`),
  ADD KEY `NhaNghiID` (`NhaNghiID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `datphong`
--
ALTER TABLE `datphong`
  ADD CONSTRAINT `datphong_ibfk_1` FOREIGN KEY (`KhachHangID`) REFERENCES `khachhang` (`KhachHangID`),
  ADD CONSTRAINT `datphong_ibfk_2` FOREIGN KEY (`PhongID`) REFERENCES `phong` (`PhongID`);

--
-- Constraints for table `phong`
--
ALTER TABLE `phong`
  ADD CONSTRAINT `phong_ibfk_1` FOREIGN KEY (`NhaNghiID`) REFERENCES `nhanghi` (`NhaNghiID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
