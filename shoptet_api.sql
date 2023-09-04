-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Pon 04. zář 2023, 12:50
-- Verze serveru: 10.1.48-MariaDB-0+deb9u2
-- Verze PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `uplabcz`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `shoptet_api`
--

CREATE TABLE `shoptet_api` (
  `id` int(11) NOT NULL,
  `addon` varchar(255) NOT NULL,
  `eshop_url` text NOT NULL,
  `eshopId` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `active_access_token` text,
  `last_update` datetime NOT NULL,
  `access_token` text NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `shoptet_api`
--

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `shoptet_api`
--
ALTER TABLE `shoptet_api`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `shoptet_api`
--
ALTER TABLE `shoptet_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
