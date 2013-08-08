-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 호스트: localhost
-- 처리한 시간: 13-08-08 15:55
-- 서버 버전: 5.1.41-community
-- PHP 버전: 5.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 데이터베이스: `pac_test`
--
CREATE DATABASE IF NOT EXISTS `pac_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pac_test`;

-- --------------------------------------------------------

--
-- 테이블 구조 `pac_consumer`
--

CREATE TABLE IF NOT EXISTS `pac_consumer` (
  `consumer_key` varchar(20) NOT NULL,
  `secret_key` varchar(40) NOT NULL,
  `permission` tinytext NOT NULL,
  `highpass` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`consumer_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `pac_consumer`
--

INSERT INTO `pac_consumer` (`consumer_key`, `secret_key`, `permission`, `highpass`) VALUES
('TESTER', '', '*', 1),
('YFUO1KLQ9GO8UFQRORZB', 'EHXV47LCM2ESU578WJPQ8ZMWGO3COB7E170363R6', '*', 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `pac_used_nonce`
--

CREATE TABLE IF NOT EXISTS `pac_used_nonce` (
  `nonce` varchar(20) NOT NULL,
  `expire_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `consumer_key` varchar(20) NOT NULL,
  PRIMARY KEY (`nonce`),
  KEY `consumer_key` (`consumer_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pac_used_nonce`
--
ALTER TABLE `pac_used_nonce`
  ADD CONSTRAINT `pac_used_nonce_ibfk_1` FOREIGN KEY (`consumer_key`) REFERENCES `pac_consumer` (`consumer_key`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
