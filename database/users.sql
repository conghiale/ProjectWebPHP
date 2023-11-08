-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2022 at 09:49 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kho_ung_dung`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `pass` text NOT NULL,
  `money` text NOT NULL,
  `fv_game` text NOT NULL,
  `dl_game` text NOT NULL,
  `type` int(5) NOT NULL DEFAULT 0,
  `user` text DEFAULT 'Bigboss',
  `phone` text DEFAULT '\'0826611778\'',
  `code_OTP` varchar(20) CHARACTER SET armscii8 NOT NULL,
  `state` varchar(15) CHARACTER SET armscii8 NOT NULL DEFAULT 'not verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `pass`, `money`, `fv_game`, `dl_game`, `type`, `user`, `phone`, `code_OTP`, `state`) VALUES
(13, 'adc05102002@gmail.com', '123456', '1.000.000', 'action_game 1/naction_game 3/npuzzle_game 2/nmoba_game 1/naction_game 2/n', 'action_game 2/nmoba_game 3/nmoba_game 2/npuzzle_game 7/naction_game 3/naction_game 1/n', 0, 'Bigboss', '0826611778', '', 'not verified'),
(14, 'abc@gmail.com', '1234567', '2.000.000', '', '', 1, 'Bigboss', '0826611778', '', 'not verified'),
(16, 'azx@gmail.com', '123', '2.500.000', '', '', 0, 'Bigboss', '0826611778', '', 'not verified'),
(21, 'abcd@gmail.com', '300498', '', 'action_game 9/n', 'action_game 2/n', 0, 'Bigboss', '0826611778', '', 'not verified'),
(101, 'legend.mighty28102002@gmail.com', '28102002', '', '', '', 0, 'Conghiale', '0826611778', '', 'verified');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
