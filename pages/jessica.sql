-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 07 sep. 2023 à 10:19
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jessica`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nom_admin` varchar(100) DEFAULT NULL,
  `prenom_admin` varchar(100) DEFAULT NULL,
  `email_admin` varchar(100) DEFAULT NULL,
  `mdp_admin` varchar(100) DEFAULT NULL,
  `role` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `nom_admin`, `prenom_admin`, `email_admin`, `mdp_admin`, `role`) VALUES
(1, 'a', 'a', 'aaa', 'aaa', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `chantier`
--

CREATE TABLE `chantier` (
  `id_chantier` int(11) NOT NULL,
  `nom_chantier` varchar(100) DEFAULT NULL,
  `photo_av_chantier` varchar(300) DEFAULT NULL,
  `photo_ap_chantier` varchar(300) DEFAULT NULL,
  `description_chantier` varchar(150) DEFAULT NULL,
  `position_chantier` int(11) DEFAULT NULL,
  `id_travaux` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chantier`
--

INSERT INTO `chantier` (`id_chantier`, `nom_chantier`, `photo_av_chantier`, `photo_ap_chantier`, `description_chantier`, `position_chantier`, `id_travaux`) VALUES
(1, 'Renovation des murs chez tony', '', 'ImageApres1.jpg', 'Chez Tony c\'est très beau', 1, 1),
(2, 'Peinture Interieur chez tony', 'ImageAvant2.jpg', 'ImageApres2.jpg', 'Chez Tony c\'est très beau', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `collab`
--

CREATE TABLE `collab` (
  `id_style` int(11) NOT NULL,
  `nom_collab` varchar(100) DEFAULT NULL,
  `logo_collab` varchar(300) DEFAULT NULL,
  `id_collab` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `style_collab`
--

CREATE TABLE `style_collab` (
  `id_collab` int(11) NOT NULL,
  `type_collab` varchar(100) DEFAULT NULL,
  `visibilite` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `travaux`
--

CREATE TABLE `travaux` (
  `id_travaux` int(11) NOT NULL,
  `type_travaux` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `travaux`
--

INSERT INTO `travaux` (`id_travaux`, `type_travaux`) VALUES
(1, 'Rénovation des murs'),
(2, 'Peinture intérieur'),
(3, 'Revêtement des murs'),
(4, 'Revêtement des Sols');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Index pour la table `chantier`
--
ALTER TABLE `chantier`
  ADD PRIMARY KEY (`id_chantier`),
  ADD KEY `FK_chantier_id_travaux` (`id_travaux`);

--
-- Index pour la table `collab`
--
ALTER TABLE `collab`
  ADD PRIMARY KEY (`id_style`),
  ADD KEY `FK_collab_id_collab` (`id_collab`);

--
-- Index pour la table `style_collab`
--
ALTER TABLE `style_collab`
  ADD PRIMARY KEY (`id_collab`);

--
-- Index pour la table `travaux`
--
ALTER TABLE `travaux`
  ADD PRIMARY KEY (`id_travaux`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `chantier`
--
ALTER TABLE `chantier`
  MODIFY `id_chantier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `collab`
--
ALTER TABLE `collab`
  MODIFY `id_style` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `style_collab`
--
ALTER TABLE `style_collab`
  MODIFY `id_collab` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `travaux`
--
ALTER TABLE `travaux`
  MODIFY `id_travaux` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chantier`
--
ALTER TABLE `chantier`
  ADD CONSTRAINT `FK_chantier_id_travaux` FOREIGN KEY (`id_travaux`) REFERENCES `travaux` (`id_travaux`);

--
-- Contraintes pour la table `collab`
--
ALTER TABLE `collab`
  ADD CONSTRAINT `FK_collab_id_collab` FOREIGN KEY (`id_collab`) REFERENCES `style_collab` (`id_collab`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
