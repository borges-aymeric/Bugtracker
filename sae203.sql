-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 16 mai 2023 à 15:51
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sae203`
--

-- --------------------------------------------------------

--
-- Structure de la table `sae203_ticket`
--

CREATE TABLE `sae203_ticket` (
  `id` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sae203_ticket`
--

INSERT INTO `sae203_ticket` (`id`, `date_create`, `user_id`) VALUES
(1, '2023-05-16 15:13:27', 2);

-- --------------------------------------------------------

--
-- Structure de la table `sae203_user`
--

CREATE TABLE `sae203_user` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `statut` tinyint(4) NOT NULL COMMENT '0:admin\r\n1:dev\r\n2:testeur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sae203_user`
--

INSERT INTO `sae203_user` (`id`, `login`, `password`, `statut`) VALUES
(1, 'admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 0),
(2, 'dev1', '85568b20c3315286c4dfebb330b25146f92bed66', 1),
(3, 'dev2', '445cd2fd3273962bdf09425109a2d09f7170e837', 1),
(4, 'testeur1', '00bebc9eea9ca936f1db21cd28f0538196f4fabf', 2),
(5, 'testeur2', '83de061fb52099b8b9b03b3ae4e888d6b10d9e5e', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `sae203_ticket`
--
ALTER TABLE `sae203_ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `sae203_user`
--
ALTER TABLE `sae203_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `sae203_ticket`
--
ALTER TABLE `sae203_ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `sae203_user`
--
ALTER TABLE `sae203_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `sae203_ticket`
--
ALTER TABLE `sae203_ticket`
  ADD CONSTRAINT `sae203_ticket_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sae203_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
