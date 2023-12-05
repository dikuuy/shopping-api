-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Bulan Mei 2021 pada 11.35
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoppingapp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel shoppingapp 
--

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` int(1) NOT NULL,
  `refreshToken` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1

CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code_product` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `info` varchar(255) NOT NULL,
  `stock` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL,
  `sold` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `carts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code_product` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `info` varchar(255) NOT NULL,
  `stock` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL,
  `sold` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

