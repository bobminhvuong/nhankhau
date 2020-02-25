-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 25, 2020 lúc 06:13 PM
-- Phiên bản máy phục vụ: 10.4.6-MariaDB
-- Phiên bản PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `chat`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhankhau`
--

CREATE TABLE `nhankhau` (
  `id` int(11) NOT NULL,
  `number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_hk` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_strees` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_ward` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_qh` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
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
  `sex` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhankhau`
--

INSERT INTO `nhankhau` (`id`, `number`, `number_hk`, `full_name`, `from_strees`, `from_ward`, `from_city`, `from_name`, `from_qh`, `top`, `date`, `to_strees`, `to_ward`, `to_city`, `birtdate`, `nguyenquan`, `dantoc`, `tongiao`, `quoctich`, `cmnd`, `type`, `hk01`, `hk02`, `hk07`, `hk08`, `khaisinh`, `kethon`, `giaycmnd`, `nhaoHP`, `sex`) VALUES
(141, '1', 'CPH-2336', 'LÊ THỊ THU HÀ', '283/30/19 BÔNG SAO', 'PHƯỜNG 5', 'QUẬN 8 - TP .H CM', 'LÊ THỊ THU HÀ', 'CH', 1, 'Ngày 03 tháng 01 năm 2018', 'KHU PHỐ 8', 'P. CHÁNH PHÚ HÒA', 'thị xã Bến Cát, Bình Dương', '26/10/1985', 'THANH HÓA', 'KINH', 'KHÔNG', 'Việt Nam', '038185006125', '2', 1, 2, 1, NULL, NULL, NULL, 1, 1, 'NỮ'),
(142, '1', 'CPH-2336', 'CHẾ NGỌC THANH THẢO', NULL, NULL, NULL, NULL, 'CON', 0, NULL, NULL, NULL, NULL, '14/7/2005', 'THANH HÓA', 'KINH', 'KHÔNG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NỮ'),
(143, '1', 'CPH-2336', 'HUỲNH LÊ TÂM AN', NULL, NULL, NULL, NULL, 'CON', 0, NULL, NULL, NULL, NULL, '26/12/2012', 'QUẢNG NAM', 'KINH', 'KHÔNG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NỮ'),
(144, '441', 'TH-1524', 'TRẦN THANH SƠN', 'PHONG HÒA', 'LAI VUNG', 'ĐỒNG THÁP', 'TRẦN THANH SƠN', 'CH', 1, 'Ngày 21 tháng 12 năm 2017', 'TỔ 12, KHU PHỐ 3', 'P.TÂN ĐỊNH', 'thị xã Bến Cát, Bình Dương', '1978', 'ĐỒNG THÁP', 'KINH', 'KHÔNG', 'Việt Nam', '362407465', '3', 1, 1, 1, 0, 0, 0, 1, 1, 'NAM'),
(145, '441', 'TH-1524', 'TRẦN THỊ THU BA', NULL, NULL, NULL, NULL, 'VỢ', 0, NULL, NULL, NULL, NULL, '1981', 'CẦN THƠ', 'KINH', 'KHÔNG', NULL, '361768508', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NỮ'),
(146, '441', 'TH-1524', 'TRẦN THIỆN NHƯ HUỲNH', NULL, NULL, NULL, NULL, 'CON', 0, NULL, NULL, NULL, NULL, '2001', 'CẦN THƠ', 'KINH', 'KHÔNG', NULL, '092301006093', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NỮ'),
(147, '441', 'TH-1524', 'TRẦN THỊ THẢO VY', NULL, NULL, NULL, NULL, 'CON', 0, NULL, NULL, NULL, NULL, '2013', 'CẦN THƠ', 'KINH', 'KHÔNG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NỮ');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `nhankhau`
--
ALTER TABLE `nhankhau`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `nhankhau`
--
ALTER TABLE `nhankhau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
