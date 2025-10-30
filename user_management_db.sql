-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2025 at 02:56 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nama_produk`, `kategori`, `stok`, `harga`, `created_at`) VALUES
(2, 'Susu Kotak', 'Minuman', 10, '17000.00', '2025-10-30 09:23:59'),
(3, 'Pel Lantai', 'Perlengkapan Gudang', 5, '20000.00', '2025-10-30 16:44:42'),
(4, 'Tepung Terigu', 'Bahan Baku', 14, '15000.00', '2025-10-30 17:26:23'),
(6, 'Bantal Kursi', 'Perlengkapan Rumah', 17, '16000.00', '2025-10-30 20:33:42'),
(7, 'Teh Kotak', 'Minuman', 10, '5000.00', '2025-10-30 20:52:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_code` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `is_verified`, `verification_code`, `created_at`) VALUES
(4, 'Diki', 'diki@gmail.com', '$2y$10$8MO8SZIJtXLR.ZarNV8At.M2RZScerJzL1owcTe5RaIJtaLxp/pxG', 0, NULL, '2025-10-30 09:08:11'),
(6, 'Resta Gevira Zalva', 'restagevira4@gmail.com', '$2y$10$nHe5VaPazVkwGBOZmrUV7.Nhsr3dMI5GWWJ929KuvoTGa04S/joFS', 1, NULL, '2025-10-30 13:22:47'),
(8, 'Admin Resta', 'restagevirazalva@gmail.com', '$2y$10$RJ6G3OugilL56eYJO9ug9Oz12mh62huRZz1gSsfs6/FqiNo97sI16', 0, 'b01d6dc39c9f7d9697bde6da4c366fbe', '2025-10-30 13:46:01'),
(9, 'Rita', 'srimulyatirita6@gmail.com', '$2y$10$gqbuM/MMItAbbTnkIptfMefS0oj4i3SiS2STfpYH3BSwMRUWEBxTa', 1, NULL, '2025-10-30 16:40:21'),
(10, 'Bapak', 'baberudi116@gmail.com', '$2y$10$EjottzJVWxFAQi6uH6WVT.f2nN.MnMOnOdLJagqqjJzZ9v.qdsBsy', 1, NULL, '2025-10-30 18:09:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
