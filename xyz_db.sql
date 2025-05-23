-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 07:05 AM
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
-- Database: `xyz_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id_departemen` int(11) NOT NULL,
  `kode_departemen` varchar(5) NOT NULL,
  `nama_departemen` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id_departemen`, `kode_departemen`, `nama_departemen`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'AUD', 'Audit', 'Departemen Audit Internal', '2025-05-19 17:34:02', '2025-05-19 17:34:02'),
(2, 'IT', 'Teknologi Informasi', 'Departemen Teknologi Informasi', '2025-05-19 17:34:02', '2025-05-19 17:34:02'),
(3, 'HC', 'Human Capital', 'Departemen Sumber Daya Manusia', '2025-05-19 17:34:02', '2025-05-19 17:34:02'),
(4, 'OPS', 'Operations', 'Departemen Operasional', '2025-05-19 17:34:02', '2025-05-19 17:34:02'),
(5, 'MKT', 'Marketing', 'Departemen Pemasaran', '2025-05-19 17:34:02', '2025-05-19 17:34:02'),
(6, 'FIN', 'Finance', 'Departemen Keuangan', '2025-05-19 17:34:02', '2025-05-19 17:34:02'),
(7, 'SUS', 'Sustainability', 'Departemen Keberlanjutan', '2025-05-19 17:34:02', '2025-05-19 17:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(50) NOT NULL,
  `level_jabatan` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `level_jabatan`, `deskripsi`) VALUES
(1, 'Staff', 1, 'Posisi entry level'),
(2, 'Officer', 2, 'Posisi pelaksana'),
(3, 'Senior Staff', 3, 'Posisi staf senior'),
(4, 'Supervisor', 4, 'Posisi penyelia'),
(5, 'Manajer', 5, 'Posisi manajerial'),
(6, 'Kepala Divisi', 6, 'Posisi kepala divisi'),
(7, 'VP', 7, 'Wakil Presiden');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `NIP` decimal(9,1) DEFAULT NULL,
  `Nama_Pegawai` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Tgl_Lahir` datetime DEFAULT NULL,
  `Unit_Kerja` varchar(14) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Jabatan` varchar(14) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Tgl_Masuk` datetime DEFAULT NULL,
  `Tgl_Keluar` datetime DEFAULT NULL,
  `Status` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Pendidikan` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Pelatihan_Wajib` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Email_Kerja` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`NIP`, `Nama_Pegawai`, `Tgl_Lahir`, `Unit_Kerja`, `Jabatan`, `Tgl_Masuk`, `Tgl_Keluar`, `Status`, `Pendidikan`, `Pelatihan_Wajib`, `Email_Kerja`) VALUES
(3999315.0, 'Balidin Dongoran, S.T.', '1981-01-05 00:00:00', 'Audit - AnalIS', 'Senior Staff', '2014-02-22 00:00:00', NULL, 'Tetap', 'Sarjana', 'ya', 'wastutihafshah@perum.org'),
(21429110.0, 'Darimin Pradipta', '1998-09-27 00:00:00', 'IT', 'Senior Staff', '2020-08-03 00:00:00', NULL, 'Tetap', 'Magister', 'tidak', 'salsabilapalastri@cv.com'),
(48181396.0, 'Lintang Siregar, S.T.', '1974-12-06 00:00:00', 'Human Capital', 'Manajer', '2014-01-04 00:00:00', NULL, 'Tetap', 'Magister', 'Tidak tahu', 'iswahyudiprabawa@gmail.com'),
(6150444.0, 'dr. Rahmi Saptono, S.Gz', '1995-08-13 00:00:00', 'Audit', 'Officer', '2019-06-22 00:00:00', NULL, 'Tetap', 'S2', 'Tidak tahu', 'jhutapea@perum.net'),
(89949389.0, 'Darsirah Siregar, S.Pt', '1980-03-11 00:00:00', 'Operations', 'Supervisor', '2025-02-02 00:00:00', '2026-02-02 00:00:00', 'Kontrak', 'S1', 'ya', 'dsetiawan@cv.mil'),
(7507864.0, 'Tira Zulaika', '1969-03-17 00:00:00', 'Operations', 'VP', '2020-09-17 00:00:00', NULL, 'Tetap', 'SMA', 'tidak', 'gamantohariyah@ud.co.id'),
(42235350.0, 'Rizki Firmansyah', '1985-10-25 00:00:00', 'Operations', 'VP', '2017-03-04 00:00:00', NULL, 'Kontrak', 'S.Kom', 'Sudah', 'prabowojessica@hotmail.com'),
(99990728.0, 'Marwata Mandasari', '1991-04-10 00:00:00', 'Marketing', 'Senior Staff', '2021-04-14 00:00:00', '2024-04-14 00:00:00', 'Kontrak', 'S.Kom', '-', 'kartamandala@gmail.com'),
(12201654.0, 'Dr. Eluh Padmasari', '1993-07-03 00:00:00', 'Audit', 'Senior Staff', '2020-04-10 00:00:00', NULL, 'Tetap', 'Sarjana', 'Belum', 'ismail28@yahoo.com'),
(62820592.0, 'Dt. Satya Kusumo, S.E.I', '1975-03-28 00:00:00', 'Operations', 'Manajer', '2023-10-28 00:00:00', NULL, 'Tetap', 'S2', 'ya', 'winarnoprabowo@hotmail.com'),
(60897765.0, 'T. Kadir Anggriawan', '1972-02-23 00:00:00', 'IT', 'VP', '2021-12-12 00:00:00', '2025-01-12 00:00:00', 'Kontrak', 'D3', '-', 'darmana46@gmail.com'),
(71182864.0, 'Xanana Saptono', '1998-06-01 00:00:00', 'Sustainability', 'Supervisor', '2023-04-24 00:00:00', NULL, 'Tetap', 'D3', 'tidak', 'utamilembah@cv.ponpes.id'),
(9289546.0, 'Liman Sinaga', '1997-08-07 00:00:00', 'Audit', 'Manajer', '2010-09-06 00:00:00', '2023-12-01 00:00:00', 'Kontrak', 'S.Kom', 'Sudah', 'luwes30@perum.net.id'),
(90152297.0, 'Dr. Pranata Mahendra, S.E.I', '1996-09-10 00:00:00', 'Operations', 'VP', '2019-09-14 00:00:00', '2023-09-14 00:00:00', 'Kontrak', 'S1', 'Sudah', 'elvina96@perum.go.id'),
(78979095.0, 'Hardi Farida, M.TI.', '1995-01-27 00:00:00', 'IT', 'Senior Officer', '2012-05-28 00:00:00', NULL, 'Kontrak', 'Sarjana', 'tidak', 'cagaksirait@perum.id'),
(72374753.0, 'Adiarja Hidayanto', '1968-05-10 00:00:00', 'IT', 'Manajer', '2014-03-30 00:00:00', NULL, 'Kontrak', 'Sarjana', 'Tidak tahu', 'sitompulcaket@ud.mil'),
(88447167.0, 'Nyoman Pertiwi', '1996-07-07 00:00:00', 'Finance', 'Manajer', '2014-06-25 00:00:00', NULL, 'Tetap', 'Magister', 'tidak', 'gnainggolan@gmail.com'),
(71979055.0, 'Kamila Anggraini', '1992-04-29 00:00:00', 'Operations', 'Senior Staff', '2018-04-17 00:00:00', NULL, 'Tetap', 'Sarjana', 'Belum', 'halimreksa@pt.mil'),
(13141087.0, 'Dina Anggraini', '1976-11-01 00:00:00', 'Marketing', 'Officer', '2015-02-01 00:00:00', NULL, 'Kontrak', 'Magister', 'ya', 'cakrawangsahandayani@hotmail.com'),
(289289.0, 'Martana Namaga', '1965-05-09 00:00:00', 'Audit', 'Kepala Divisi', '2011-12-08 00:00:00', NULL, 'Kontrak', 'SMA', 'ya', 'rahmatlaksita@cv.go.id'),
(7849494.0, 'Hani Hasanah', '1983-10-05 00:00:00', 'Marketing', 'Staff', '2017-07-18 00:00:00', NULL, 'Kontrak', 'Magister', 'Belum', 'harjasasihombing@gmail.com'),
(24941004.0, 'Drs. Almira Sihotang', '1968-03-28 00:00:00', 'Operations', 'Manajer', '2011-03-15 00:00:00', NULL, 'Tetap', 'S1', 'Belum', 'balijanmelani@gmail.com'),
(88231132.0, 'Legawa Hidayat', '1980-05-10 00:00:00', 'Marketing', 'Staff', '2017-03-20 00:00:00', NULL, 'Tetap', 'S1', 'ya', 'kiandrariyanti@perum.mil.id'),
(90152735.0, 'Ir. Putri Sihotang', '1982-02-04 00:00:00', 'IT', 'Senior Staff', '2013-10-28 00:00:00', NULL, 'Tetap', 'Sarjana', 'tidak', 'kartawidodo@gmail.com'),
(67898694.0, 'Eja Haryanti, S.Psi', '1969-04-15 00:00:00', 'IT', 'Senior Officer', '2010-07-04 00:00:00', NULL, 'Tetap', 'S1', 'Tidak tahu', 'hidayantogawati@gmail.com'),
(40181935.0, 'Diah Tampubolon', '1969-01-11 00:00:00', 'Sustainability', 'Manajer', '2025-04-22 00:00:00', NULL, 'Kontrak', 'S2', '-', 'kairav27@perum.ponpes.id'),
(65569635.0, 'Bala Mansur, S.T.', '1972-03-15 00:00:00', 'Sustainability', 'Senior Officer', '2012-03-03 00:00:00', NULL, 'Tetap', 'D3', 'Belum', 'kardi93@cv.or.id'),
(85511909.0, 'Zulfa Habibi', '1970-08-19 00:00:00', 'HC', 'Manajer', '2021-02-20 00:00:00', NULL, 'Tetap', 'SMA', 'Sudah', 'bakidin05@gmail.com'),
(20005727.0, 'Elisa Handayani', '2001-11-22 00:00:00', 'Human Capital', 'Staff', '2022-05-09 00:00:00', NULL, 'Kontrak', 'SMA', 'Tidak tahu', 'kusumocakrawangsa@hotmail.com'),
(5354599.0, 'Dt. Rafid Uwais', '2001-12-13 00:00:00', 'Audit', 'Senior Officer', '2012-11-13 00:00:00', NULL, 'Tetap', 'Magister', 'Belum', 'bakdasamosir@yahoo.com'),
(3326769.0, 'Fathonah Zulaika', '1981-05-01 00:00:00', 'Operations', 'Senior Officer', '2021-09-11 00:00:00', '2024-07-01 00:00:00', 'Kontrak', 'D3', 'Sudah', 'ira69@cv.mil.id'),
(61780854.0, 'Okto Sitorus', '1992-05-14 00:00:00', 'Finance', 'Officer', '2023-12-30 00:00:00', NULL, 'Kontrak', 'S2', '-', 'galuh16@pd.mil'),
(53643924.0, 'Ina Pradana', '1979-07-09 00:00:00', 'Human Capital', 'Officer', '2010-10-02 00:00:00', NULL, 'Kontrak', 'S.Kom', 'Sudah', 'rsitompul@ud.or.id'),
(14549543.0, 'Saiful Nasyiah, S.Psi', '1966-03-25 00:00:00', 'IT', 'Senior Officer', '2012-04-23 00:00:00', NULL, 'Tetap', 'S2', 'Belum', 'kaniasaptono@gmail.com'),
(72269803.0, 'drg. Jelita Sihotang', '1994-01-17 00:00:00', 'IT', 'Senior Staff', '2020-08-29 00:00:00', '2025-02-22 00:00:00', 'Kontrak', 'S.Kom', 'Tidak tahu', 'mpermata@pt.or.id'),
(54009265.0, 'Najib Winarsih, S.Kom', '1989-02-18 00:00:00', 'Audit', 'Staff', '2017-09-07 00:00:00', NULL, 'Tetap', 'S.Kom', 'Belum', 'padmi51@perum.co.id'),
(54502486.0, 'Ida Puspasari, S.E.I', '1977-05-28 00:00:00', 'Marketing', 'Senior Officer', '2017-07-02 00:00:00', NULL, 'Tetap', 'S.Kom', 'tidak', 'patriciapurnawati@yahoo.com'),
(28682516.0, 'Dt. Gadang Suwarno', '1978-08-27 00:00:00', 'Marketing', 'Staff', '2017-08-30 00:00:00', '2024-08-30 00:00:00', 'Kontrak', 'S1', 'tidak', 'chandayani@hotmail.com'),
(30150759.0, 'drg. Putu Narpati', '1970-02-13 00:00:00', 'Audit', 'Senior Officer', '2015-03-06 00:00:00', NULL, 'Tetap', 'D3', 'ya', 'prakasavanya@yahoo.com'),
(19806690.0, 'Sutan Cakrajiya Dongoran, S.Gz', '1981-01-04 00:00:00', 'Sustainability', 'Staff', '2018-06-07 00:00:00', NULL, 'Kontrak', 'SMA', 'Sudah', 'oagustina@pd.id'),
(89600766.0, 'Malik Ardianto, S.IP', '1993-04-13 00:00:00', 'Human Capital', 'Senior Staff', '2014-01-26 00:00:00', NULL, 'Tetap', 'SMA', 'Tidak tahu', 'jhardiansyah@pt.my.id'),
(60407340.0, 'Dr. Legawa Simanjuntak', '1994-06-20 00:00:00', 'Marketing', 'Senior Staff', '2020-10-08 00:00:00', NULL, 'Tetap', 'Magister', 'Tidak tahu', 'vmanullang@yahoo.com'),
(95770370.0, 'Umi Prayoga', '1983-03-22 00:00:00', 'Marketing', 'VP', '2023-05-18 00:00:00', '2025-05-18 00:00:00', 'Kontrak', 'D3', '-', 'kuntharafarida@gmail.com'),
(44410148.0, 'Gilda Saputra', '1987-03-16 00:00:00', 'Finance', 'Officer', '2015-10-15 00:00:00', NULL, 'Tetap', 'Sarjana', '-', 'gadapradipta@cv.mil.id'),
(77267850.0, 'drg. Heryanto Halim', '1978-06-04 00:00:00', 'Finance', 'Senior Staff', '2024-07-08 00:00:00', NULL, 'Tetap', 'S2', 'Tidak tahu', 'spadmasari@gmail.com'),
(73300637.0, 'Natalia Ardianto', '1988-04-15 00:00:00', 'Sustainability', 'Manajer', '2015-06-06 00:00:00', NULL, 'Kontrak', 'D3', 'ya', 'vnasyiah@hotmail.com'),
(89774697.0, 'Drs. Usman Prasetya, M.Kom.', '1979-04-13 00:00:00', 'Finance', 'Kepala Divisi', '2014-12-28 00:00:00', NULL, 'Tetap', 'S2', 'Tidak tahu', 'ydabukke@yahoo.com'),
(18213276.0, 'Raditya Waskita, S.E.', '1996-02-27 00:00:00', 'Audit', 'Kepala Divisi', '2012-07-09 00:00:00', NULL, 'Tetap', 'D3', 'ya', 'krahayu@pt.mil.id'),
(2601580.0, 'Dr. Elvina Hardiansyah, S.T.', '1990-02-23 00:00:00', 'Audit', 'Supervisor', '2015-12-02 00:00:00', NULL, 'Kontrak', 'S1', 'Tidak tahu', 'vsimbolon@ud.net.id'),
(16941092.0, 'Puput Habibi, S.I.Kom', '1979-08-11 00:00:00', 'IT', 'Kepala Divisi', '2021-05-29 00:00:00', NULL, 'Kontrak', 'S1', 'Sudah', 'dabukkejumari@pt.id'),
(111.0, 'apis adrimaulanaaaaaw', '2025-05-01 00:00:00', 'Audit', 'Supervisor', '2025-05-01 00:00:00', NULL, 'Kontrak', 'S.Kom', 'Sudah', 'admin@laraveltemplate.com'),
(113.0, 'tes', '2025-05-01 00:00:00', 'Audit', 'VP', '2025-05-01 00:00:00', NULL, 'Kontrak', 'S.Kom', 'Sudah', 'admin@laraveltemplate.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
