-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 04 nov. 2024 à 10:01
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `banque`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `loginAdmin` varchar(50) NOT NULL,
  `passwordAdmin` varchar(75) NOT NULL,
  `isProductOwner` tinyint(1) NOT NULL,
  `mail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`loginAdmin`, `passwordAdmin`, `isProductOwner`, `mail`) VALUES
('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 0, 'admin.bills@bills.fr'),
('po', '6199aecf23aba7e87b2dafb8b4915260da85e3cf53568197b7e451982392fb8e', 1, 'po.bills@bills.fr');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `numClient` int(11) NOT NULL,
  `numSiren` char(9) NOT NULL,
  `loginClient` varchar(50) NOT NULL,
  `passwordClient` varchar(150) NOT NULL,
  `raisonSociale` varchar(20) NOT NULL,
  `mail` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`numClient`, `numSiren`, `loginClient`, `passwordClient`, `raisonSociale`, `mail`) VALUES
(1, '123456789', 'client', '948fe603f61dc036b5c596dc09fe3ce3f3d30dc90f024c85f3c82db2ccab679d', 'Carrefour', 'carrefour.direction@gmail.com'),
(3, '987654321', 'auchan', '3e23e8160039594a33894f6564e1b1348bbd7a0088d42c4acb73eeaed59c009d', 'Auchan', 'auchan@auchan.fr'),
(4, '123456789', 'aa', '961b6dd3ede3cb8ecbaacbd68de040cd78eb2ed5889130cceb4c49268ea4d506', 'leclerc', 'auchan.test@auchan.fr'),
(5, '050505050', 'inter', 'c84c8016356014e02b049ff270c079dd03ab5c5d44a120bee60242782b234ddd', 'Intermarché', 'interdirection@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `codeimpaye`
--

CREATE TABLE `codeimpaye` (
  `codeImpaye` char(2) NOT NULL,
  `libelleImpaye` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `codeimpaye`
--

INSERT INTO `codeimpaye` (`codeImpaye`, `libelleImpaye`) VALUES
('01', 'Fraude à la carte'),
('02', 'Compte à découvert'),
('03', 'Compte clôturé'),
('04', 'Compte bloqué'),
('05', 'Provision insuffisante'),
('06', 'Opération contestée par le débiteur'),
('07', 'Titulaire décédé'),
('08', 'Raison non communiquée, contactez la banque du client');

-- --------------------------------------------------------

--
-- Structure de la table `impaye`
--

CREATE TABLE `impaye` (
  `numTransaction` int(11) NOT NULL,
  `numDossierImpaye` char(5) NOT NULL,
  `codeImpaye` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `impaye`
--

INSERT INTO `impaye` (`numTransaction`, `numDossierImpaye`, `codeImpaye`) VALUES
(6, '1', '08'),
(7, '1', '08'),
(12, '2', '01'),
(13, '2', '01'),
(14, '2', '01'),
(19, '3', '05'),
(20, '3', '05'),
(27, '4', '08'),
(28, '4', '08'),
(30, '5', '04'),
(34, '6', '05'),
(39, '7', '08'),
(43, '8', '01'),
(45, '9', '01'),
(50, '10', '02');

-- --------------------------------------------------------

--
-- Structure de la table `mdptemp`
--

CREATE TABLE `mdptemp` (
  `numClient` int(11) NOT NULL,
  `mail` varchar(200) NOT NULL,
  `pw` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `remise`
--

CREATE TABLE `remise` (
  `numRemise` int(11) NOT NULL,
  `nbrTransaction` int(11) NOT NULL,
  `montantTotal` int(11) NOT NULL,
  `devise` char(3) NOT NULL,
  `dateRemise` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `numClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `remise`
--

INSERT INTO `remise` (`numRemise`, `nbrTransaction`, `montantTotal`, `devise`, `dateRemise`, `numClient`) VALUES
(1, 5, 50, 'EUR', '2020-10-05 22:00:00', 1),
(2, 2, -1025, 'EUR', '2020-10-06 08:15:18', 1),
(3, 4, 72, 'EUR', '2020-10-20 18:46:51', 1),
(4, 3, -179, 'EUR', '2020-12-01 10:34:05', 1),
(5, 1, 5, 'EUR', '2020-05-01 02:01:24', 1),
(6, 3, 84, 'EUR', '2020-10-02 10:36:16', 1),
(7, 2, -42, 'EUR', '2020-07-03 13:48:04', 1),
(8, 4, 75, 'EUR', '2020-08-09 17:53:19', 1),
(9, 1, 63, 'EUR', '2020-11-19 15:05:00', 1),
(10, 1, 81, 'EUR', '2020-07-08 09:36:03', 1),
(11, 2, -31, 'EUR', '2020-02-15 06:05:40', 1),
(12, 1, 32, 'EUR', '2020-07-22 14:09:53', 1),
(13, 1, -34, 'EUR', '2020-05-10 16:14:48', 1),
(14, 3, 23, 'EUR', '2020-05-29 01:02:24', 1),
(15, 1, -57, 'EUR', '2020-05-05 02:40:33', 1),
(16, 2, 95, 'EUR', '2020-04-30 20:51:32', 1),
(17, 1, 29, 'EUR', '2020-11-20 02:51:18', 1),
(18, 1, 2, 'EUR', '2020-01-30 23:54:42', 1),
(19, 1, -10, 'EUR', '2020-07-21 22:19:45', 1),
(20, 1, 61, 'EUR', '2020-04-10 05:14:03', 1),
(21, 1, 49, 'EUR', '2020-03-29 07:12:41', 3),
(22, 1, 19, 'EUR', '2020-06-10 21:35:26', 3),
(23, 1, -58, 'EUR', '2020-02-10 08:57:10', 3),
(24, 1, 24, 'EUR', '2020-12-29 12:17:51', 3),
(25, 1, -89, 'EUR', '2020-06-21 13:41:25', 3),
(26, 1, 65, 'EUR', '2020-02-26 06:19:01', 3),
(27, 1, 2, 'EUR', '2020-07-04 16:49:03', 3),
(28, 1, 44, 'EUR', '2020-05-16 19:46:22', 3),
(29, 1, 44, 'EUR', '2020-12-13 17:37:46', 3),
(30, 1, -61, 'EUR', '2020-10-01 03:06:57', 3);

-- --------------------------------------------------------

--
-- Structure de la table `suppression`
--

CREATE TABLE `suppression` (
  `numClient` int(11) NOT NULL,
  `dateDemande` date NOT NULL,
  `justificatif` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `suppression`
--

INSERT INTO `suppression` (`numClient`, `dateDemande`, `justificatif`) VALUES
(3, '2024-11-04', 'Ce compte est inactif depuis plus de 6 mois.');

-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE `transaction` (
  `numTransaction` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `devise` char(3) NOT NULL,
  `numCarte` char(16) NOT NULL,
  `numAutorisation` char(6) DEFAULT NULL,
  `reseau` char(5) NOT NULL,
  `numRemise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `transaction`
--

INSERT INTO `transaction` (`numTransaction`, `montant`, `devise`, `numCarte`, `numAutorisation`, `reseau`, `numRemise`) VALUES
(1, 10, 'EUR', '3562********1578', '1', 'VISA', 1),
(2, 15, 'EUR', '3562********1578', '1', 'MC', 1),
(3, 12, 'EUR', '3562********1578', '1', 'VISA', 1),
(4, 6, 'EUR', '3562********1578', '1', 'AE', 1),
(5, 7, 'EUR', '3562********1578', '1', 'VISA', 1),
(6, -24, 'EUR', '3562********1578', '1', 'MC', 2),
(7, -1001, 'EUR', '3562********1578', '1', 'VISA', 2),
(8, 16, 'EUR', '3562********1578', '1', 'AE', 3),
(9, 39, 'EUR', '3562********1578', '1', 'VISA', 3),
(10, 3, 'EUR', '3562********1578', '1', 'MC', 3),
(11, 14, 'EUR', '3562********1578', '1', 'VISA', 3),
(12, -16, 'EUR', '3562********1578', '1', 'AE', 4),
(13, -155, 'EUR', '3562********1578', '1', 'VISA', 4),
(14, -8, 'EUR', '3562********1578', '1', 'MC', 4),
(15, 5, 'EUR', '3562********1578', '1', 'VISA', 5),
(16, 19, 'EUR', '3562********1578', '1', 'AE', 6),
(17, 47, 'EUR', '3562********1578', '1', 'VISA', 6),
(18, 18, 'EUR', '3562********1578', '1', 'MC', 6),
(19, -24, 'EUR', '3562********1578', '1', 'VISA', 7),
(20, -18, 'EUR', '3562********1578', '1', 'AE', 7),
(21, 20, 'EUR', '3562********1578', '1', 'VISA', 8),
(22, 14, 'EUR', '3562********1578', '1', 'MC', 8),
(23, 17, 'EUR', '3562********1578', '1', 'VISA', 8),
(24, 24, 'EUR', '3562********1578', '1', 'AE', 8),
(25, 63, 'EUR', '3562********1578', '1', 'VISA', 9),
(26, 81, 'EUR', '3562********1578', '1', 'MC', 10),
(27, -15, 'EUR', '3562********1578', '1', 'VISA', 11),
(28, -16, 'EUR', '3562********1578', '1', 'AE', 11),
(29, 32, 'EUR', '3562********1578', '1', 'VISA', 12),
(30, -34, 'EUR', '3562********1578', '1', 'MC', 13),
(31, 7, 'EUR', '3562********1578', '1', 'VISA', 14),
(32, 9, 'EUR', '3562********1578', '1', 'AE', 14),
(33, 7, 'EUR', '3562********1578', '1', 'VISA', 14),
(34, -57, 'EUR', '3562********1578', '1', 'MC', 15),
(35, 45, 'EUR', '3562********1578', '1', 'VISA', 16),
(36, 50, 'EUR', '3562********1578', '1', 'AE', 16),
(37, 29, 'EUR', '3562********1578', '1', 'VISA', 17),
(38, 2, 'EUR', '3562********1578', '1', 'MC', 18),
(39, -10, 'EUR', '3562********1578', '1', 'VISA', 19),
(40, 61, 'EUR', '3562********1578', '1', 'AE', 20),
(41, 49, 'EUR', '3562********1578', '1', 'VISA', 21),
(42, 19, 'EUR', '3562********1578', '1', 'MC', 22),
(43, -58, 'EUR', '3562********1578', '1', 'VISA', 23),
(44, 24, 'EUR', '3562********1578', '1', 'AE', 24),
(45, -89, 'EUR', '3562********1578', '1', 'VISA', 25),
(46, 65, 'EUR', '3562********1578', '1', 'MC', 26),
(47, 2, 'EUR', '3562********1578', '1', 'VISA', 27),
(48, 44, 'EUR', '3562********1578', '1', 'AE', 28),
(49, 44, 'EUR', '3562********1578', '1', 'VISA', 29),
(50, -61, 'EUR', '3562********1578', '1', 'MC', 30);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`loginAdmin`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`numClient`);

--
-- Index pour la table `codeimpaye`
--
ALTER TABLE `codeimpaye`
  ADD PRIMARY KEY (`codeImpaye`);

--
-- Index pour la table `impaye`
--
ALTER TABLE `impaye`
  ADD PRIMARY KEY (`numTransaction`),
  ADD KEY `codeImpaye` (`codeImpaye`);

--
-- Index pour la table `mdptemp`
--
ALTER TABLE `mdptemp`
  ADD PRIMARY KEY (`numClient`);

--
-- Index pour la table `remise`
--
ALTER TABLE `remise`
  ADD PRIMARY KEY (`numRemise`),
  ADD KEY `REMISE_CLIENT_FK` (`numClient`);

--
-- Index pour la table `suppression`
--
ALTER TABLE `suppression`
  ADD PRIMARY KEY (`numClient`,`dateDemande`);

--
-- Index pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`numTransaction`),
  ADD KEY `TRANSACTION_REMISE_FK` (`numRemise`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `numClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `remise`
--
ALTER TABLE `remise`
  MODIFY `numRemise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `numTransaction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `impaye`
--
ALTER TABLE `impaye`
  ADD CONSTRAINT `impaye_ibfk_1` FOREIGN KEY (`numTransaction`) REFERENCES `transaction` (`numTransaction`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `impaye_ibfk_2` FOREIGN KEY (`codeImpaye`) REFERENCES `codeimpaye` (`codeImpaye`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mdptemp`
--
ALTER TABLE `mdptemp`
  ADD CONSTRAINT `mdptemp_ibfk_1` FOREIGN KEY (`numClient`) REFERENCES `client` (`numClient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `remise`
--
ALTER TABLE `remise`
  ADD CONSTRAINT `REMISE_CLIENT_FK` FOREIGN KEY (`numClient`) REFERENCES `client` (`numClient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `suppression`
--
ALTER TABLE `suppression`
  ADD CONSTRAINT `fk_suppression_client` FOREIGN KEY (`numClient`) REFERENCES `client` (`numClient`) ON DELETE CASCADE;

--
-- Contraintes pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `TRANSACTION_REMISE_FK` FOREIGN KEY (`numRemise`) REFERENCES `remise` (`numRemise`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
