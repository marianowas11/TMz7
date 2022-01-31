-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql01.marianowas11.beep.pl:3306
-- Czas generowania: 31 Sty 2022, 12:10
-- Wersja serwera: 5.7.31-34-log
-- Wersja PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `tmlab6z6`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `film`
--

CREATE TABLE `film` (
  `idf` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `musician` text COLLATE utf8_polish_ci NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idu` int(11) NOT NULL,
  `filename` text COLLATE utf8_polish_ci NOT NULL,
  `lyrics` text COLLATE utf8_polish_ci NOT NULL,
  `idft` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `filmtype`
--

CREATE TABLE `filmtype` (
  `idft` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `filmtype`
--

INSERT INTO `filmtype` (`idft`, `name`) VALUES
(1, 'document'),
(2, 'reportaz'),
(3, 'publicystyka'),
(4, 'film akcji'),
(5, 'sci-fi'),
(6, 'horror'),
(7, 'familijny'),
(8, 'przyrodniczy'),
(9, 'koncert'),
(10, 'animowany'),
(11, 'None/Unknown');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `playlistdatabase`
--

CREATE TABLE `playlistdatabase` (
  `idpldb` int(11) NOT NULL,
  `idpl` int(11) NOT NULL,
  `idf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `playlistname`
--

CREATE TABLE `playlistname` (
  `idpl` int(11) NOT NULL,
  `idu` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `public` tinyint(1) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `UsersLab5`
--

CREATE TABLE `UsersLab5` (
  `id` int(11) NOT NULL,
  `username` text COLLATE utf8_polish_ci NOT NULL,
  `password` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`idf`),
  ADD KEY `idu` (`idu`),
  ADD KEY `idft` (`idft`);

--
-- Indeksy dla tabeli `filmtype`
--
ALTER TABLE `filmtype`
  ADD PRIMARY KEY (`idft`);

--
-- Indeksy dla tabeli `playlistdatabase`
--
ALTER TABLE `playlistdatabase`
  ADD PRIMARY KEY (`idpldb`),
  ADD KEY `idpl` (`idpl`),
  ADD KEY `idf` (`idf`);

--
-- Indeksy dla tabeli `playlistname`
--
ALTER TABLE `playlistname`
  ADD PRIMARY KEY (`idpl`),
  ADD KEY `idu` (`idu`);

--
-- Indeksy dla tabeli `UsersLab5`
--
ALTER TABLE `UsersLab5`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `film`
--
ALTER TABLE `film`
  MODIFY `idf` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `filmtype`
--
ALTER TABLE `filmtype`
  MODIFY `idft` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `playlistdatabase`
--
ALTER TABLE `playlistdatabase`
  MODIFY `idpldb` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `playlistname`
--
ALTER TABLE `playlistname`
  MODIFY `idpl` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `UsersLab5`
--
ALTER TABLE `UsersLab5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `film_ibfk_1` FOREIGN KEY (`idu`) REFERENCES `UsersLab5` (`id`),
  ADD CONSTRAINT `film_ibfk_2` FOREIGN KEY (`idft`) REFERENCES `filmtype` (`idft`);

--
-- Ograniczenia dla tabeli `playlistdatabase`
--
ALTER TABLE `playlistdatabase`
  ADD CONSTRAINT `playlistdatabase_ibfk_1` FOREIGN KEY (`idpl`) REFERENCES `playlistname` (`idpl`),
  ADD CONSTRAINT `playlistdatabase_ibfk_2` FOREIGN KEY (`idf`) REFERENCES `film` (`idf`);

--
-- Ograniczenia dla tabeli `playlistname`
--
ALTER TABLE `playlistname`
  ADD CONSTRAINT `playlistname_ibfk_1` FOREIGN KEY (`idu`) REFERENCES `UsersLab5` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
