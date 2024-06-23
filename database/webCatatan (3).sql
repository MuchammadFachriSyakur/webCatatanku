-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jun 2024 pada 12.14
-- Versi server: 11.3.2-MariaDB
-- Versi PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webCatatan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `folder`
--

CREATE TABLE `folder` (
  `id` int(11) NOT NULL,
  `username` varchar(244) NOT NULL,
  `name` varchar(244) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `folder`
--

INSERT INTO `folder` (`id`, `username`, `name`) VALUES
(6, 'fachri26', 'Teknik Informatika'),
(7, 'fachri26', 'Bahasa inggris'),
(8, 'fachri26', 'PPKN'),
(9, 'fachri26', 'Pengembangan Perangkat Lunak Dan Game'),
(11, 'fachri26', 'Matematika');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `titleNotes` varchar(255) NOT NULL,
  `descriptionNotes` varchar(64000) NOT NULL,
  `publish` varchar(64) NOT NULL DEFAULT 'Private',
  `idFolder` int(11) NOT NULL,
  `usernameFolder` varchar(64) NOT NULL,
  `NameFolder` varchar(244) NOT NULL,
  `view` int(11) NOT NULL DEFAULT 0,
  `like` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `notes`
--

INSERT INTO `notes` (`id`, `titleNotes`, `descriptionNotes`, `publish`, `idFolder`, `usernameFolder`, `NameFolder`, `view`, `like`) VALUES
(1, 'Pembelajaran 1', 'Mengenal Perangkat lunak ', 'Private', 0, '', '', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `level` varchar(64) NOT NULL DEFAULT 'user',
  `kode_verifikasi` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `image`, `tanggal`, `level`, `kode_verifikasi`) VALUES
(1, 'fachri26', '31202f8e70f9537acbfb7033256c53a5cb6c21bfa7718cb81eb287cf98993f18', 'muchammadfachrisyakur@gmail.com', '66630d4950bbc.jpeg', '2024-06-07', 'user', '404907');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `folder`
--
ALTER TABLE `folder`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `folder`
--
ALTER TABLE `folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
