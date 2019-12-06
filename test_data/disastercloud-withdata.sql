-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-db
-- Generation Time: Dec 06, 2019 at 04:11 PM
-- Server version: 8.0.18
-- PHP Version: 7.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `disastercloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE IF NOT EXISTS `Students` (
  `ID` varchar(10) NOT NULL,
  `NAME` text NOT NULL,
  `SURNAME` text NOT NULL,
  `FATHERNAME` text NOT NULL,
  `GRADE` float NOT NULL,
  `MOBILENUMBER` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `BIRTHDAY` date NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `MOBILENUMBER` (`MOBILENUMBER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`ID`, `NAME`, `SURNAME`, `FATHERNAME`, `GRADE`, `MOBILENUMBER`, `BIRTHDAY`) VALUES
('C1GZvEk5DD', 'Matthew', 'Clark', 'Randy', 8.75, '9025083023', '1996-11-09'),
('cXPfag0F5N', 'Stacey', 'Clayton', 'Ray', 8.9, '3721780680', '2019-11-03'),
('Ff8nxWCme4', 'Marilyn', 'Smith', 'Harry', 1.5, '3960953063', '1995-11-18'),
('IMjubvIAKW', 'bob', 'anderson', 'jarvis', 5.8, '6973085459', '2019-11-21'),
('JsHUlPgQ1s', 'Walter', 'White', 'Sean', 10, '5876914523', '1959-12-11'),
('K0NImuM3Hg', 'alice', 'anderson', 'casper', 8.5, '8754263548', '2019-08-06'),
('KhJB8PtAhO', 'Shirley', 'Carter', 'Christopher', 4.8, '8764041491', '1988-11-11'),
('lco1yotmtA', 'fasdf', 'asdf', 'asdfasdf', 8.5, '6994554784', '2019-11-07'),
('NLngFPmHrl', 'Patrick', 'Harris', 'Andrew', 10, '4560047205', '2019-11-22'),
('rjGkzem6eI', 'Hank', 'Schrader', 'Phillip', 6.3, '6455039350', '1949-11-09'),
('ry2xQMCrfQ', 'Ronnie', 'Dio', 'Ryan', 6.5, '6326064734', '1942-07-10'),
('sbs1pIBf3u', 'David', 'Gilmour', 'Douglas', 8.5, '6495564573', '1943-03-06'),
('tJ4Wg6hLsL', 'asdf', 'asdf', 'asdf', 1, '6973085454', '2019-11-21'),
('VhVwaLlbBz', 'John', 'Mcclain', 'Bobby', 9.5, '5698120519', '1988-11-10'),
('yMWnMNg8Kz', 'Diana', 'Perry', 'Robert', 10, '3294979826', '1987-09-25');

-- --------------------------------------------------------

--
-- Table structure for table `Teachers`
--

CREATE TABLE IF NOT EXISTS `Teachers` (
  `ID` varchar(10) NOT NULL,
  `NAME` text NOT NULL,
  `SURNAME` text NOT NULL,
  `USERNAME` varchar(20) NOT NULL,
  `PASSWORD` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `EMAIL` varchar(320) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `USERNAME` (`USERNAME`),
  UNIQUE KEY `EMAIL` (`EMAIL`),
  KEY `username_index` (`USERNAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Teachers`
--

INSERT INTO `Teachers` (`ID`, `NAME`, `SURNAME`, `USERNAME`, `PASSWORD`, `EMAIL`) VALUES
('puJo1lvGbe', 'admin', 'admin', 'admin', '$2y$10$Nsa5G/eZr5pIG4hgt14VYulzJE.HjRfu9X30YHQ0YTh4xyAq4UaEi', 'admin@admin.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;