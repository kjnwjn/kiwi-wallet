-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 26, 2022 lúc 07:46 PM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `project_database`
--
CREATE DATABASE IF NOT EXISTS `project_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `project_database`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phoneNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idCard_front` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idCard_back` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `initialPassword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wrongPassCount` int(10) DEFAULT 0,
  `active` tinyint(1) DEFAULT 0,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'pending',
  `createdAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `updatedAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `wallet` int(255) NOT NULL DEFAULT 50000
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`email`, `phoneNumber`, `fullname`, `gender`, `address`, `birthday`, `idCard_front`, `idCard_back`, `password`, `initialPassword`, `wrongPassCount`, `active`, `role`, `createdAt`, `updatedAt`, `wallet`) VALUES
('kjnwjnpham@gmail.com', '0399551917', 'pham nguyen hoang quan', 'Male', '793 tran xuan soan tp hcm', '219372831', NULL, NULL, '$2y$10$81EYVppoK7lPSLWiWwE5J.vVfHguADx.4imeWArHElHi7HVT2E9h2', 'NULL', 0, 0, 'actived', '1647444034', '1653200098', 18370000),
('phamnguyenhoang.quan.1412@gmail.com', '0948995290', 'pham van hoang phat', 'Female', 'tp hcm,vie nam', '1638378000', NULL, NULL, '$2y$10$GGLan04NUGFB/wDJ.Sn71uOemEIlDutXPUPnvRLBYAvOCFl3WeZHi', 'NULL', 0, 0, 'pending', '1652353198', '1652475198', 50000),
('test.mytest.user@gmail.com', '0702907154', 'Phạm Trường Giang', 'Male', '793/49/3 Trần Xuân Soạn, Tân Hưng, Quận 7, HCM', '986213568000', NULL, NULL, '$2y$10$W2D9qWU8XVsfY0XWkt/EnOI0MCAiA8buBqkuqACBlDf5nMZiMBwK2', 'NULL', 0, 0, 'actived', '1646324757', '1652357774', 4750001);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `card`
--

CREATE TABLE `card` (
  `card_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiredDay` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cvv` int(255) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `card`
--

INSERT INTO `card` (`card_id`, `expiredDay`, `cvv`, `description`) VALUES
('111111', '10/10/2022', 411, 'Không giới hạn số lần nạp và số tiền mỗi lần nạp.'),
('222222', '11/11/2022', 443, 'Không giới hạn số lần nạp nhưng chỉ được nạp tối đa 1 triệu/lần.'),
('333333', '12/12/2022', 577, 'Khi nạp bằng thẻ này thì luôn nhận được thông báo là “thẻ hết tiền”.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phonecard`
--

CREATE TABLE `phonecard` (
  `phoneCard_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_id` int(255) NOT NULL,
  `mno` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phoneCardType` int(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `createdAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updatedAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phonecard`
--

INSERT INTO `phonecard` (`phoneCard_id`, `transaction_id`, `mno`, `phoneCardType`, `amount`, `createdAt`, `updatedAt`) VALUES
('1111135672', 97939, 'viettel', 10000, 1, '1652209739', '1652209739');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(255) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phoneRecipient` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_transaction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value_money` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `costBearer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updatedAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` int(11) DEFAULT 1,
  `card_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `email`, `phoneRecipient`, `type_transaction`, `value_money`, `description`, `costBearer`, `createdAt`, `updatedAt`, `action`, `card_id`) VALUES
(97939, 'kjnwjnpham@gmail.com', NULL, '4', '10000', NULL, NULL, '1652209739', '1652209739', 1, NULL),
(309764, 'kjnwjnpham@gmail.com', '0948995290', '2', '50000', 'ádsadsadsad', 'receiver', '1652475213', '1652475198', 1, NULL),
(313081, 'kjnwjnpham@gmail.com', '0948995290', '2', '5000000', '123456 anh co danh roi nhip nao k', 'sender', '1652336668', '1652336653', 1, NULL),
(385648, 'kjnwjnpham@gmail.com', '0948995290', '2', '-5000000', 'gui tien am', 'sender', '1652353505', '1652353490', 1, NULL),
(829937, 'kjnwjnpham@gmail.com', NULL, '1', '10000000', NULL, NULL, '1652095561', '1652095561', 1, '111111'),
(849576, 'kjnwjnpham@gmail.com', NULL, '3', '6000000', 'withdraw 2', NULL, '1652095655', '1652095655', 0, NULL),
(933138, 'kjnwjnpham@gmail.com', NULL, '3', '1000000', 'withdraw 1', NULL, '1652095618', '1652095618', 1, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`card_id`);

--
-- Chỉ mục cho bảng `phonecard`
--
ALTER TABLE `phonecard`
  ADD PRIMARY KEY (`phoneCard_id`),
  ADD KEY `fk_transaction_id_phonecard` (`transaction_id`);

--
-- Chỉ mục cho bảng `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `email` (`email`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `phonecard`
--
ALTER TABLE `phonecard`
  ADD CONSTRAINT `fk_transaction_id_phonecard` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `fk_account_email_transaction` FOREIGN KEY (`email`) REFERENCES `account` (`email`),
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`email`) REFERENCES `account` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
