-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 08:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `albumid` int(11) NOT NULL,
  `namaalbum` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggaldibuat` date NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`albumid`, `namaalbum`, `deskripsi`, `tanggaldibuat`, `userid`) VALUES
(18, 'Marvel', 'marvel', '2024-10-10', 9),
(19, 'X-Men', 'x-men', '2024-10-10', 9),
(21, 'Avengers', 'Assemble', '2024-10-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `fotoid` int(11) NOT NULL,
  `judulfoto` varchar(255) NOT NULL,
  `deskripsifoto` text NOT NULL,
  `tanggalunggah` date NOT NULL,
  `lokasifile` varchar(255) NOT NULL,
  `albumid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foto`
--

INSERT INTO `foto` (`fotoid`, `judulfoto`, `deskripsifoto`, `tanggalunggah`, `lokasifile`, `albumid`, `userid`) VALUES
(30, 'Storm', 'marvel', '2024-10-10', '430057250_storm.png', 18, 9),
(31, 'Jean Grey', 'marvel', '2024-10-10', '1688274452_186jgr_com_crd_01.png', 19, 9),
(32, 'Logan', 'marvel', '2024-10-10', '677853405_034wlv_com_crd_01.jpg', 19, 9),
(35, 'Cyclops', 'Marvel', '2024-10-11', '1819480399_191cyc_com_crd_01.png', 19, 9),
(37, 'Deadpool', 'BYE BYE BYE', '2024-10-14', '1780320445_deadpool.gif', 18, 1),
(38, 'Spider-Man', 'avengers', '2024-10-14', '401115785_037smm_com_crd_01.jpg', 21, 1),
(39, 'Iron Man', 'i am iron man', '2024-10-14', '741317297_Iron-Man-1-1024x731.jpg', 21, 1),
(40, 'Thor', 'bring me thanos', '2024-10-14', '235975249_Thor.webp', 21, 1),
(41, 'Captain America', 'assemble', '2024-10-14', '1535067558_Captain America Marvel Comics 4K Wallpaper - Free 4k Wallpapers - 40_000+ Free 4k Wallpapers - Pixel4k.jfif', 21, 1),
(42, 'Black Widow', 'sheesh', '2024-10-14', '1823219325_Black Widow.jpg', 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `komentarfoto`
--

CREATE TABLE `komentarfoto` (
  `komentarid` int(11) NOT NULL,
  `fotoid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `isikomentar` text NOT NULL,
  `tanggalkomentar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentarfoto`
--

INSERT INTO `komentarfoto` (`komentarid`, `fotoid`, `userid`, `isikomentar`, `tanggalkomentar`) VALUES
(36, 30, 1, 'wow', '2024-10-10'),
(37, 30, 1, 'wow', '2024-10-10'),
(40, 30, 1, 'lol', '2024-10-10'),
(44, 30, 1, 'sasa', '2024-10-10'),
(46, 30, 9, 'lol', '2024-10-10'),
(50, 31, 1, 'lol\n', '2024-10-10'),
(51, 32, 1, 'Logan Paul', '2024-10-10'),
(52, 31, 1, '', '2024-10-10'),
(53, 31, 1, 'cantik banget full gyatttttttttttttt + 10.0000 aura\n', '2024-10-10'),
(54, 32, 9, 'sasa', '2024-10-10'),
(55, 32, 9, 'sasa', '2024-10-10'),
(56, 32, 1, 'wow', '2024-10-11'),
(57, 32, 1, 'wow', '2024-10-11'),
(58, 32, 1, 'wow', '2024-10-11'),
(59, 32, 1, 'wow', '2024-10-11'),
(61, 30, 1, 'bagus', '2024-10-11'),
(62, 30, 9, 'wow\n', '2024-10-11'),
(63, 30, 1, 'wow', '2024-10-11'),
(64, 30, 1, 'asas', '2024-10-11'),
(65, 30, 1, 'saas', '2024-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `likefoto`
--

CREATE TABLE `likefoto` (
  `likeid` int(11) NOT NULL,
  `fotoid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `tanggallike` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likefoto`
--

INSERT INTO `likefoto` (`likeid`, `fotoid`, `userid`, `tanggallike`) VALUES
(290, 31, 10, '2024-10-10'),
(366, 31, 1, '2024-10-11'),
(372, 32, 1, '2024-10-11'),
(378, 32, 9, '2024-10-11'),
(379, 30, 9, '2024-10-11'),
(387, 30, 1, '2024-10-14'),
(388, 37, 1, '2024-10-14'),
(389, 38, 9, '2024-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `namalengkap` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `level` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `email`, `namalengkap`, `alamat`, `level`) VALUES
(1, 'admin', '123', 'user1@gmail.com', 'Naufal', 'Kajen', 'admin'),
(9, 'rafi', '123', 'rafisiregar1721@gmail.com', 'Rafi', 'what', 'user'),
(10, 'agil', '123', 'rafisiregar1721@gmail.com', 'Agil Azmi', 'wow', 'user'),
(11, 'denif', '123', 'denif123@gmail.com', 'Denif', '', 'user'),
(12, 'banu', '$2y$10$wDcWTCw3vAGsq4wKRpRd/uXqYP/UHXCCQWLCZ0wwYsJNOWigFkMPm', 'banu123@gmail.com', 'Banu Tresna', 'Punggur', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`albumid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`fotoid`),
  ADD KEY `albumid` (`albumid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  ADD PRIMARY KEY (`komentarid`),
  ADD KEY `fotoid` (`fotoid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `likefoto`
--
ALTER TABLE `likefoto`
  ADD PRIMARY KEY (`likeid`),
  ADD KEY `fotoid` (`fotoid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `albumid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `fotoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  MODIFY `komentarid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `likefoto`
--
ALTER TABLE `likefoto`
  MODIFY `likeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=390;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`albumid`) REFERENCES `album` (`albumid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foto_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  ADD CONSTRAINT `komentarfoto_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentarfoto_ibfk_2` FOREIGN KEY (`fotoid`) REFERENCES `foto` (`fotoid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likefoto`
--
ALTER TABLE `likefoto`
  ADD CONSTRAINT `likefoto_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likefoto_ibfk_2` FOREIGN KEY (`fotoid`) REFERENCES `foto` (`fotoid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
