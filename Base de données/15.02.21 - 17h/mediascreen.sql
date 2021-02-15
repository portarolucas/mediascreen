-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 15 fév. 2021 à 16:00
-- Version du serveur :  5.7.32
-- Version de PHP : 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données : `mediascreen`
--

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
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mdp`) VALUES
(1, 'Gehin', 'Evann', 'admin@local.dev', '$2y$10$/gK8zHZup/Jyd9cYF0Fge.fSMAVF8oxy7TxjvT3Ena4fdnN45C6Ga'),
(2, 'tom', 'durand', 'admin@local.dev', '$2y$10$/gK8zHZup/Jyd9cYF0Fge.fSMAVF8oxy7TxjvT3Ena4fdnN45C6Ga');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
