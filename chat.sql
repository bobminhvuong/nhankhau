-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2020 at 07:55 AM
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
('0jd5esof1vdbqgl0i60cboqqa0803sf8', '::1', 1582786281, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738363238313b),
('61qeldg7u19pdhjiq5dfforrbmb40gi7', '::1', 1582783192, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738333139323b),
('7j4kv15j4kd2mrkbopovr2i06lcmvcco', '::1', 1582785090, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738353039303b),
('897fd6bonds7mkuldlevqtjb5qv80f7d', '::1', 1582784779, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738343737393b),
('ba0bgnclpeoatgcrr6phr03pqefdvcr9', '::1', 1582783497, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738333439373b),
('fpeut890sshodgoe37gq8qrdtb18e2o9', '::1', 1582785399, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738353339393b),
('mdjfibqd31pcska6aroor04bnn29jht9', '::1', 1582782886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738323838363b),
('o4nkvb019382ieecf4265e1otnr4p6vu', '::1', 1582786515, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738363238313b),
('plsackkl2dehc2u72ruor2hlg2d9pd94', '::1', 1582782506, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738323530363b),
('r7lej4daorqq8e3ncdgcv6jrpnl4b3fu', '::1', 1582784207, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738343230373b),
('s48dthgdsu6mgcmo9pt29a8t5g1t4n98', '::1', 1582785936, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738353933363b),
('v63hg99s3ll8rt6tmt9tbhsh4kpvp7r6', '::1', 1582783864, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538323738333836343b);

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
  `birtdate` date DEFAULT NULL,
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
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 ho moi; 2 chyen den;3 chuyen di; 4 khai sinh',
  `chuyenden` int(11) NOT NULL DEFAULT 0,
  `ngaychuyenden` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chuyendi` int(11) NOT NULL DEFAULT 0,
  `ngaychuyendi` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `noichuyendi` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
