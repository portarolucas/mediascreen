-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 06 jan. 2021 à 23:55
-- Version du serveur :  10.3.23-MariaDB-0+deb10u1
-- Version de PHP : 7.3.19-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mediascreen`
--

-- --------------------------------------------------------

--
-- Structure de la table `ecrans`
--

CREATE TABLE `ecrans` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `temps` int(11) NOT NULL,
  `id_sequence` int(11) NOT NULL,
  `id_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `ecrans`
--

INSERT INTO `ecrans` (`id`, `nom`, `contenu`, `temps`, `id_sequence`, `id_type`) VALUES
(1, 'SNCF-1', 'Showdown is a Javascript Markdown to HTML converter, based on the original works by John Gruber. It can be used client side (in the browser) or server side (with Node or io). \r\n\r\n\r\n# Installation\r\n\r\n## Download tarball\r\n\r\nYou can download the latest release tarball directly from [releases][releases]\r\n\r\n## Bower\r\n\r\n    bower install showdown\r\n\r\n## npm (server-side)\r\n\r\n    npm install showdown\r\n\r\n## CDN\r\n\r\nYou can also use one of several CDNs available: \r\n\r\n* rawgit CDN\r\n\r\n        https://cdn.rawgit.com/showdownjs/showdown/<version tag>/dist/showdown.min.js\r\n\r\n* cdnjs\r\n\r\n        https://cdnjs.cloudflare.com/ajax/libs/showdown/<version tag>/showdown.min.js\r\n', 5000, 1, 1),
(2, 'SNCF-2', '## LP CIASIE - TD Micro ORM\r\n\r\nGroupe :\r\n\r\n ~~- GEHIN Evann\r\n - KLOPFENSTEIN Vivien~~\r\n\r\n\r\nLes fichiers **main.php** et **secondary.php** sont des fichiers de t[ests qui nous pe](#)rmettaient de tester les différentes classes.\r\n\r\nLes cla*sses se trouvent dans le répertoire **src**.\r\nLe fichier de configuration à la base de données se* trouve dans le répertoire **conf**.', 5000, 1, 1),
(3, 'SNCF-3', 'Ecran génial n°3', 5000, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sequences`
--

CREATE TABLE `sequences` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sequences`
--

INSERT INTO `sequences` (`id`, `nom`, `token`) VALUES
(1, 'SNCF', 'abcdef'),
(2, 'OUIGo', 'ghijklm');

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ecrans`
--
ALTER TABLE `ecrans`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sequences`
--
ALTER TABLE `sequences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ecrans`
--
ALTER TABLE `ecrans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `sequences`
--
ALTER TABLE `sequences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
