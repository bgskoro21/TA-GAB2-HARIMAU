-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jan 2023 pada 16.54
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_kas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_hutangs`
--

CREATE TABLE `tbl_hutangs` (
  `id` int(11) NOT NULL,
  `kode_hutang` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `tgl_tempo` date NOT NULL,
  `perincian` varchar(100) NOT NULL,
  `total_hutang` int(11) NOT NULL,
  `status` enum('Lunas','Belum Lunas') NOT NULL DEFAULT 'Belum Lunas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_hutangs`
--

INSERT INTO `tbl_hutangs` (`id`, `kode_hutang`, `user_id`, `no_hp`, `nama_pelanggan`, `tgl_transaksi`, `tgl_tempo`, `perincian`, `total_hutang`, `status`) VALUES
(19, 'HT001', 31, '083121288450', 'Bagaskara', '2023-01-27', '2023-01-31', 'Hutang Es Batu', 900000, 'Lunas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `waktu_transaksi` date NOT NULL,
  `perincian` varchar(500) NOT NULL,
  `pemasukan` int(11) NOT NULL DEFAULT 0,
  `pengeluaran` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_transaksi`
--

INSERT INTO `tbl_transaksi` (`id`, `user_id`, `waktu_transaksi`, `perincian`, `pemasukan`, `pengeluaran`, `created_at`, `updated_at`) VALUES
(357, 31, '2023-01-27', 'Bakso Aci', 900000, 0, '2023-01-27 13:13:49', '2023-01-27 13:13:49'),
(358, 31, '2023-01-27', 'Bakso Malang', 800000, 0, '2023-01-27 13:13:49', '2023-01-27 13:13:49'),
(359, 31, '2023-03-27', 'Bakso Solo', 850000, 0, '2023-01-27 13:13:49', '2023-01-27 13:13:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `level` enum('Admin','Bendahara') NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 0,
  `profile_picture` varchar(100) DEFAULT 'http://localhost/TA-GAB2-HARIMAU/Server/assets/images/default.png',
  `about` text NOT NULL,
  `is_login` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nama_lengkap`, `no_hp`, `level`, `is_active`, `profile_picture`, `about`, `is_login`) VALUES
(31, 'bagaskara148@gmail.com', '$2y$10$2T4G7wSSocJPS5/NrH.asegHVcCPXmxOJIakDuTjWpNEpG.EboA2W', 'Bagaskara', '083121288450', 'Admin', 1, 'http://localhost/TA-GAB2-HARIMAU/Server/assets/images/Bagaskara-picture.jpg', 'Halo saya adalah Baguskara, Mahasiswa Universitas Teknokrat Indonesia. Saya jurusan Informatika', 0),
(53, 'bagaskara_dwi_putra@teknokrat.ac.id', '$2y$10$trlNLqJNr8r7IlLl3hMIuuC7k.u8XEpXP8U6g4AH7ahtuKdLrj.9e', 'Putra Bagas', '083121288450', 'Bendahara', 1, 'http://localhost/TA-GAB2-HARIMAU/Server/assets/images/default.png', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_hutangs`
--
ALTER TABLE `tbl_hutangs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_hutang` (`kode_hutang`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_hutangs`
--
ALTER TABLE `tbl_hutangs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=366;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_hutangs`
--
ALTER TABLE `tbl_hutangs`
  ADD CONSTRAINT `tbl_hutangs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD CONSTRAINT `tbl_transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
