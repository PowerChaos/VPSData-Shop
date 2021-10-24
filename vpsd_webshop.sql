-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 20 okt 2021 om 23:06
-- Serverversie: 10.5.12-MariaDB-log
-- PHP-versie: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vpsd_webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling`
--

CREATE TABLE `bestelling` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `bestel` varchar(32) NOT NULL,
  `pid` int(11) NOT NULL,
  `prijs` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `clouds` decimal(10,0) NOT NULL,
  `kleur` text NOT NULL,
  `datum` int(11) NOT NULL,
  `status` decimal(1,0) NOT NULL DEFAULT 0,
  `levering` varchar(16) NOT NULL,
  `leverkosten` decimal(10,2) NOT NULL,
  `betaalkosten` decimal(10,2) NOT NULL,
  `betaling` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bonus`
--

CREATE TABLE `bonus` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `prijs` decimal(10,0) NOT NULL,
  `datum` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `discount` decimal(11,0) NOT NULL,
  `clouds` decimal(11,0) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--
INSERT INTO `discount` (`id`, `discount`, `clouds`) VALUES
(1, '0', '0');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL COMMENT 'id',
  `naam` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT 'gebruiker naam',
  `wachtwoord` tinytext COLLATE utf8_bin NOT NULL COMMENT 'hash',
  `rechten` varchar(1) COLLATE utf8_bin NOT NULL COMMENT 'Rechten',
  `groep` varchar(3) COLLATE utf8_bin NOT NULL COMMENT 'Groep',
  `punten` text COLLATE utf8_bin NOT NULL,
  `voornaam` text COLLATE utf8_bin NOT NULL,
  `achternaam` text COLLATE utf8_bin NOT NULL,
  `phone` text COLLATE utf8_bin NOT NULL,
  `adress` text COLLATE utf8_bin NOT NULL,
  `nummer` text COLLATE utf8_bin NOT NULL,
  `bus` text COLLATE utf8_bin NOT NULL,
  `gemeente` text COLLATE utf8_bin NOT NULL,
  `postcode` text COLLATE utf8_bin NOT NULL,
  `land` text COLLATE utf8_bin NOT NULL,
  `vat` varchar(16) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='gebruikers Tabel';

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `naam`, `wachtwoord`, `rechten`, `groep`, `punten`, `voornaam`, `achternaam`, `phone`, `adress`, `nummer`, `bus`, `gemeente`, `postcode`, `land`, `vat`) VALUES
(1, 'test@test.com', 'sha1:64000:18:rzKNRHDMeUPE7dorz73copsDo0E6OeN5:U8ejAe+lgNiB9xXNzaYHhEBb', '3', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groep`
--

CREATE TABLE `groep` (
  `id` int(11) NOT NULL COMMENT 'id',
  `user` text COLLATE utf8_bin NOT NULL COMMENT 'user id',
  `naam` tinytext COLLATE utf8_bin NOT NULL COMMENT 'groepnaam'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Groep Tabel';

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `img` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `merk` text NOT NULL,
  `cat` text NOT NULL,
  `info` text NOT NULL,
  `prijs` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `merk`, `cat`, `info`, `prijs`) VALUES
(1, 'placeholder', 'placeholder', 'placeholder', 'placeholder', '0.00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `naam` varchar(32) NOT NULL,
  `stock` tinyint(11) NOT NULL,
  `prijs` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `stock`
--

INSERT INTO `stock` (`id`, `pid`, `naam`, `stock`, `prijs`) VALUES
(1, 1, 'placeholder', -1, '0.00');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bestelling`
--
ALTER TABLE `bestelling`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `bonus`
--
ALTER TABLE `bonus`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`naam`);

--
-- Indexen voor tabel `groep`
--
ALTER TABLE `groep`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bestelling`
--
ALTER TABLE `bestelling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `bonus`
--
ALTER TABLE `bonus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `groep`
--
ALTER TABLE `groep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- AUTO_INCREMENT voor een tabel `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
