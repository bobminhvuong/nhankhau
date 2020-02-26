-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2020 at 07:49 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('0b8hkb8obsc87euvgnffikvlfqfjdhaa', '::1', 1582694874, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323639343837343b),
('29hkm0vn75af2bdjo20ec6mffmanoi24', '::1', 1582619592, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323631393539323b),
('2lck2h34tg5tnra50ogf30al78fr8qnl', '::1', 1582680557, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323638303231383b),
('2msa2bdmgq88kemednr02rfhsudutifg', '::1', 1582620275, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632303237353b),
('3kijnfjbtu0vlsj35eiulq15nl', '::1', 1565835709, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353730393b),
('41s0v9igruus51876juntqifj35ki6kj', '::1', 1582622257, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632323235373b),
('42m44qt3h1a7mrbn9edn1b2uar', '::1', 1565835664, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353636343b),
('4uvp03ir23fheofcs7kvjulmu2be182m', '::1', 1582683528, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323638333532383b),
('59secsoudfjj3ms8al57hh6tand0ekr4', '::1', 1582688520, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323638383532303b),
('6h4ua2mmm0aeh54c804naioqct47e8vh', '::1', 1582624861, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632343836313b),
('6h56k2qieq3tusbu4kttpcd4f5', '::1', 1565835920, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353932303b),
('72onivmr7hro8s2gbhn0779tg6qkad8i', '::1', 1582618976, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323631383937363b),
('7i1rcfc4o4vuvc9lvauij3c8df26qlgs', '::1', 1582619279, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323631393237393b),
('87l2g2u6u0uoujbag5m8p8fcf5njstoc', '::1', 1582623047, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632333034373b),
('8fkgmqdla6vb1ssrtun56j0ap5nb1bn9', '::1', 1582625372, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632353136363b),
('8kejftsr8u440lffabm0al2oj4', '::1', 1565835441, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353434313b),
('9bol7ae7io3s6odmtnq0r673afr7d7dl', '::1', 1582699278, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323639393237383b),
('9q5bvgof986htmjjp4gjv2mok2', '::1', 1565835568, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353536383b),
('a6gek3e78mopv2fih7chhqc8o5chl0r9', '::1', 1582622578, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632323537383b),
('baqu451hon626bkla9s6ioll5ds74o6r', '::1', 1582699583, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323639393538333b),
('caqjsnmq6mfhoc4dr3rhgeondgohcfqb', '::1', 1582614433, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323631333034363b),
('cjl5r85in8ip0mkka5jhsb9akaoqpokg', '::1', 1582682008, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323638323030383b),
('ckk1gqbceflnq1p8b54o4qfens', '::1', 1565835907, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353930373b),
('d35h17k0dk6vrkqv8olh39kl05', '::1', 1565835902, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353930323b),
('dee7qqbsqsmd887f622m4r0t12', '::1', 1565835440, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353434303b),
('e2m48iurkkvu4ucr9242brfup6vo6afl', '::1', 1582690022, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323639303032323b),
('ebal1urrggd84b81gmcg4vi2vh', '::1', 1565835572, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353537323b),
('fpj5df2vtkq9m8aao836obl4jujrfme2', '::1', 1582690798, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323639303739383b),
('fvgb5118h7pkrhcqf29m8o1oe287lq74', '::1', 1582689631, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323638393633313b),
('gff2firuj7m556pfseci7m9phqffiamo', '::1', 1582685416, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323638353431363b),
('h6946ui7i61914coh33lk5ph8e', '::1', 1565835920, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353932303b),
('i9ua3e8nab5ku9nf95chd7s3uvorhu31', '::1', 1582621621, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632313632313b),
('ig6n68uk0628v799cih67uso64', '::1', 1565835855, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353835353b),
('igcdcq1d236npvp1a6alqmn67p', '::1', 1565836323, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833363332333b),
('ij76uf61fs1p5dbf6gnh2ofun5', '::1', 1565835925, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353932353b),
('ilqh40pmkm5r50ssrnb8gdo8s7tdk28q', '::1', 1582690360, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323639303336303b),
('ivklakilhiqa0g5cfv0aku3h08oq9s51', '::1', 1582686716, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323638363731363b),
('j3t5m7v2ouq6ropftrsdg0fh6nn3tnvh', '::1', 1582624344, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632343334343b),
('kbmpm3khnoijhdv7pfrc6q0fcmpgq2r4', '::1', 1582620638, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632303633383b),
('kd5khbe81lav61454om7s64472mfte5h', '::1', 1582620947, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632303934373b),
('khl03ki6dfibi48p85r7mvjljt', '::1', 1565835580, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353538303b),
('koqeleq2r8avuiv0acg94j0vnq1r62go', '::1', 1582683948, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323638333934383b),
('lqh60cq823sf7rgoijnuf2sgpr', '::1', 1565835586, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353538363b),
('ltbblo5jv3j1rh5kfe6gd2fsof7amk08', '::1', 1582621248, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632313234383b),
('mvssa1jles1ev2fsfhouu6upb4', '::1', 1565835869, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353836393b),
('nbma7qnok875scnpnpj2m0jfl4ckjjbi', '::1', 1582682313, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323638323331333b),
('o491c8ltcpgfkcvk6re38o2o3cjuaubg', '::1', 1582699769, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323639393538333b),
('o55sdujv7cdssfmu0sr1a1d27qaqtam4', '::1', 1582617527, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323631373532373b),
('p65cde55pb6jur0f9ctpe2lan5nqrb15', '::1', 1582687472, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323638373437323b),
('q1rp5qom26irnsmcqg3kdh5n5b0brrek', '::1', 1582623371, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632333337313b),
('q201jhce7r5qfd7m6pa7n8cd44531iot', '::1', 1582625166, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632353136363b),
('qe5fj9dbcb3jps34jf22q0dss2', '::1', 1565836292, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833363239323b),
('sktcatau9kv28kluheirqk98c9', '::1', 1565835696, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353639363b),
('sve51uul0f286pf9o1inmjbe4kfibf1h', '::1', 1582623776, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323632333737363b),
('u9aolbfhvskmcon418cb8ikurc6svldu', '::1', 1582688157, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323638383135373b),
('v5hildngoajrtragpiqh209gl4', '::1', 1565835884, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536353833353838343b),
('vbfgn8orl88k4k94kskjq5jd05vmr5ob', '::1', 1582619965, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323631393936353b);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(7) NOT NULL,
  `user` varchar(255) CHARACTER SET latin1 NOT NULL,
  `msg` text CHARACTER SET latin1 NOT NULL,
  `time` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nhankhau`
--

CREATE TABLE `nhankhau` (
  `id` int(11) NOT NULL,
  `number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_hk` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_hk_old` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_strees` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_ward` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_qh` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qh` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `top` tinyint(4) NOT NULL DEFAULT 0,
  `date` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `to_strees` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `to_ward` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `to_city` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birtdate` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nguyenquan` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dantoc` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tongiao` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quoctich` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cmnd` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hk01` int(11) DEFAULT NULL,
  `hk02` int(11) DEFAULT NULL,
  `hk07` int(11) DEFAULT NULL,
  `hk08` int(11) DEFAULT NULL,
  `khaisinh` int(11) DEFAULT NULL,
  `kethon` int(11) DEFAULT NULL,
  `giaycmnd` int(11) DEFAULT NULL,
  `nhaoHP` int(11) DEFAULT NULL,
  `sex` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1 chuyển đi',
  `chuyenden` int(11) NOT NULL DEFAULT 0,
  `ngaychuyenden` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chuyendi` int(11) NOT NULL DEFAULT 0,
  `ngaychuyendi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nhankhau`
--

INSERT INTO `nhankhau` (`id`, `number`, `number_hk`, `number_hk_old`, `full_name`, `from_strees`, `from_ward`, `from_city`, `from_name`, `from_qh`, `qh`, `top`, `date`, `to_strees`, `to_ward`, `to_city`, `birtdate`, `nguyenquan`, `dantoc`, `tongiao`, `quoctich`, `cmnd`, `type`, `hk01`, `hk02`, `hk07`, `hk08`, `khaisinh`, `kethon`, `giaycmnd`, `nhaoHP`, `sex`, `status`, `chuyenden`, `ngaychuyenden`, `chuyendi`, `ngaychuyendi`) VALUES
(41, '7', 'TH-4858', NULL, 'BÙI THỊ THÚY NGA', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'TỔ KMR, KP 6', 'P. THỚI HÒA', ', thị xã Bến Cát, Bình Dương', '41452', 'HÀ TĨNH', 'KINH', 'KHÔNG', 'Việt Nam', 'KHAI SINH', '1', NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 'NỮ', 0, 0, NULL, 0, NULL),
(42, '2', 'TH-5174', NULL, 'LÊ VĂN LỊCH', 'THÔN 3', 'X. TẾ NÔNG', NULL, 'LÊ VĂN ĐIỆP', NULL, 'CON', 1, 'Ngày 09 tháng 01 năm 2019', 'TỔ 4-KP 3A', 'P. THỚI HÒA', 'thị xã Bến Cát, Bình Dương', '10/10/1991', 'THANH HÓA', 'KINH', 'KHÔNG', 'Việt Nam', '173251539', '0', 0, 0, 0, NULL, NULL, NULL, 0, 0, 'NAM', 0, 0, NULL, 0, NULL),
(43, '1', 'PA-2258', NULL, 'NGUYỄN HUY HOÀNG', 'TỔ 1 KP TÂN BÌNH', 'P. TÂN HIỆP', 'TX TÂN UYÊN, BÌNH DƯƠNG', 'NGUYỄN HUY HOÀNG', NULL, 'CH', 1, 'Ngày 07 tháng 01 năm 2019', 'TỔ 9 ẤP AN THUẬN', 'XÃ PHÚ AN', 'thị xã Bến Cát, Bình Dương', '25/01/1985', 'THANH HÓA', 'KINH', 'KHÔNG', 'Việt Nam', '281314284', '3', 0, 0, 0, 0, 0, 0, 0, 0, 'NAM', 0, 0, NULL, 0, NULL),
(44, '1', 'PA-2258', NULL, 'TRẦN THỊ ĐIỆP', 'TỔ 1 KP TÂN BÌNH', 'P. TÂN HIỆP', 'TX TÂN UYÊN, BÌNH DƯƠNG', 'NGUYỄN HUY HOÀNG', NULL, 'VỢ', 0, 'Ngày 07 tháng 01 năm 2019', 'TỔ 9 ẤP AN THUẬN', 'XÃ PHÚ AN', 'thị xã Bến Cát, Bình Dương', '20/02/1987', 'BÌNH ĐỊNH', 'KINH', 'VN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NỮ', 0, 0, NULL, 0, NULL),
(45, '1', 'PA-2258', NULL, 'NGUYỄN HUY HẢI', 'TỔ 1 KP TÂN BÌNH', 'P. TÂN HIỆP', 'TX TÂN UYÊN, BÌNH DƯƠNG', 'NGUYỄN HUY HOÀNG', NULL, 'CON', 0, 'Ngày 07 tháng 01 năm 2019', 'TỔ 9 ẤP AN THUẬN', 'XÃ PHÚ AN', 'thị xã Bến Cát, Bình Dương', '23/7/2009', 'THANH HÓA', 'KINH', 'VN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NAM', 0, 0, NULL, 0, NULL),
(46, '1', 'PA-2258', NULL, 'NGUYỄN THỊ THU HƯƠNG', 'TỔ 1 KP TÂN BÌNH', 'P. TÂN HIỆP', 'TX TÂN UYÊN, BÌNH DƯƠNG', 'NGUYỄN HUY HOÀNG', NULL, 'CON', 0, 'Ngày 07 tháng 01 năm 2019', 'TỔ 9 ẤP AN THUẬN', 'XÃ PHÚ AN', 'thị xã Bến Cát, Bình Dương', '14/10/2016', 'THANH HÓA', 'KINH', 'VN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NỮ', 0, 0, NULL, 0, NULL),
(47, '8', 'MP-1706', '119', 'NGUYỄN DƯƠNG BẢO NGỌC', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'TỔ 16, KP 3', 'P. MỸ PHƯỚC', ', thị xã Bến Cát, Bình Dương', '25/01/2018', 'BÌNH DƯƠNG', 'KINH', 'KHÔNG', 'Việt Nam', 'KHAI SINH', '0', NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 'NỮ', 0, 0, NULL, 0, NULL),
(48, '1', 'PA-1250', '1256', 'ĐỖ THANH THẢO', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'TỔ 6 KP 3', 'P. MỸ PHƯỚC', ', thị xã Bến Cát, Bình Dương', '19/01/2015', 'QUẢNG NGÃI', 'KINH', 'KHÔNG', 'Việt Nam', 'KHAI SINH', NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, 'NỮ', 0, 0, NULL, 0, NULL),
(49, '6', 'CPH-2718', '341', 'NGUYỄN LÊ MINH KHANG', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'TỔ 7, KP 4', 'P. CHÁNH PHÚ HÒA', ', thị xã Bến Cát, Bình Dương', '12/07/2015', 'BÌNH DƯƠNG', 'KINH', 'KHÔNG', 'Việt Nam', 'KHAI SINH', NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, 'NAM', 0, 0, NULL, 0, NULL),
(50, '9', 'HL-3044', NULL, 'LÂM TIẾN ĐẠT', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'KP AN LỢI', 'P. HÒA LỢI', ', thị xã Bến Cát, Bình Dương', '21/04/2016', 'CÀ MAU', 'KINH', 'KHÔNG', 'Việt Nam', 'KHAI SINH', '0', NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 'NAM', 0, 0, NULL, 0, NULL),
(51, '16', 'TĐ-3576', '587', 'LÊ THỊ LOAN', 'ẤP HƯNG TRUNG', 'XÃ ĐÀO HỮU CẢNH', 'H. CHÂU PHÚ, AN GIANG', 'TRẦN THỊ BẢY', NULL, 'VỢ', 0, 'Ngày 09 tháng 01 năm 2019', 'TỔ 17, KP 3', 'P. TÂN ĐỊNH', 'thị xã Bến Cát, tỉnh Bình Dương', '1984', 'AN GIANG', 'KINH', 'PHẬT', 'Việt Nam', '351603788', NULL, 0, 0, 0, NULL, NULL, 0, 0, NULL, 'NỮ', 0, 1, 'Ngày 09 tháng 01 năm 2019', 0, NULL),
(52, '14', 'MP-4396', NULL, 'ĐẶNG THỊ LIỂU CHÂU', 'KHÓM 7', 'PHƯỜNG 8', 'TP. CÀ MAU, TỈNH CÀ MAU', 'ĐẶNG THỊ LIỂU CHÂU', NULL, 'Ở NHỜ', 0, 'Ngày  07 tháng 01 năm 2019', 'TỔ 19, KP 3', 'P. MỸ PHƯỚC', 'thị xã Bến Cát, tỉnh Bình Dương', '01/01/1983', 'CÀ MAU', 'KINH', 'KHÔNG', 'Việt Nam', '381733710', '0', 0, 0, 0, NULL, NULL, NULL, 0, NULL, 'NỮ', 0, 1, 'Ngày  07 tháng 01 năm 2019', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `online` tinyint(4) NOT NULL DEFAULT 1,
  `added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nhankhau`
--
ALTER TABLE `nhankhau`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nhankhau`
--
ALTER TABLE `nhankhau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
