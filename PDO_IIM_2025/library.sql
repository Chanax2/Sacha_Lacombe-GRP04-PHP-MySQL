-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 07 mai 2025 à 01:16
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `library`
--

-- --------------------------------------------------------

--
-- Structure de la table `cards`
--

CREATE TABLE `cards` (
  `id` int NOT NULL,
  `name` varchar(40) NOT NULL,
  `type` varchar(40) NOT NULL DEFAULT 'normal',
  `image` varchar(255) NOT NULL DEFAULT 'pokemon default image',
  `hp` int NOT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `cards`
--

INSERT INTO `cards` (`id`, `name`, `type`, `image`, `hp`, `id_user`) VALUES
(23, 'Dracaufeu', 'feu', 'pokemon default image', 200, NULL),
(40, 'Noctali', 'ténèbres', 'pokemon default image', 125, NULL),
(62, 'Pikachu', 'Électrique', 'pokemon default image', 35, 1),
(63, 'Bulbizarre', 'Plante', 'pokemon default image', 45, 1),
(64, 'Salamèche', 'Feu', 'pokemon default image', 39, 1),
(65, 'Carapuce', 'Eau', 'pokemon default image', 44, 1),
(66, 'Roucool', 'Normal/Vol', 'pokemon default image', 40, 1),
(67, 'Rattata', 'Normal', 'pokemon default image', 30, 1),
(68, 'Dracaufeu', 'Feu/Vol', 'pokemon default image', 78, 1),
(69, 'Florizarre', 'Plante/Poison', 'pokemon default image', 80, 1),
(70, 'Tortank', 'Eau', 'pokemon default image', 79, 1),
(71, 'Evoli', 'Normal', 'pokemon default image', 55, 1),
(72, 'zqdq', 'qzdq', 'pokemon default image', -1, NULL),
(74, 'Jeanne D\'Arc', 'Arc', 'pokemon default image', 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

CREATE TABLE `livres` (
  `id` int NOT NULL,
  `titre` varchar(50) NOT NULL,
  `auteur` varchar(50) NOT NULL,
  `annee_publication` date NOT NULL,
  `disponible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id`, `titre`, `auteur`, `annee_publication`, `disponible`) VALUES
(1, 'Le Petit Prince', 'Antoine de Saint-Exupéry', '1943-04-06', 1),
(2, '1984', 'George Orwell', '1949-06-08', 1),
(3, 'Les Misérables', 'Victor Hugo', '1862-01-01', 0),
(4, 'L’Étranger', 'Albert Camus', '1942-05-19', 1),
(5, 'Don Quichotte', 'Miguel de Cervantes', '1605-01-16', 0),
(6, 'Cyrano de Bergerac', 'Edmond Rostand', '1897-12-28', 1),
(7, 'Harry Potter à l’école des sorciers', 'J.K. Rowling', '1997-06-26', 1),
(8, 'Le Comte de Monte-Cristo', 'Alexandre Dumas', '1844-08-28', 0),
(9, 'Fahrenheit 451', 'Ray Bradbury', '1953-10-19', 1),
(10, 'La Peste', 'Albert Camus', '1947-06-10', 0),
(11, 'Le petit prince', 'Antoine de Saint-Exupéry', '1943-02-06', 1),
(12, 'Le petit prince', 'Antoine de Saint-Exupéry', '1943-02-06', 1),
(13, 'Le petit prince', 'Antoine de Saint-Exupéry', '1943-02-06', 1),
(14, 'zdqdzq', 'qzdqzdq', '2025-04-22', 1),
(15, 'njeqdo', 'oqogznomg', '2025-04-22', 1),
(16, 'njeqdo', 'oqogznomg', '2025-04-22', 1),
(17, 'njeqdo', 'oqogznomg', '2025-04-22', 1),
(18, 'BOnne Amie', 'ZZZ', '1999-05-13', 1),
(19, 'BOnne Amie', 'ZZZ', '1999-05-13', 1),
(20, 'ZDS', 'ZDS', '2025-05-15', 1),
(21, 'ZDS', 'ZDS', '2025-05-15', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `iduser` int NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(450) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`iduser`, `email`, `password`) VALUES
(1, 'ezd', '$2y$10$fF0T0pnHd5ddl6Kr6XFLke.FQrzhC70/hYSeLV6y.3pJr/BVpB4We'),
(2, 'jean', '$2y$10$dAY25DKs1eeI8xfYXc6xQ.DSJ7oxwRcr.3m0cVpY.Ekfuq6vJ1BHi'),
(3, 'baptiste', '$2y$10$8hkfUm6myft6ZCK/Mag1U.rDM8XByES/Ncb43md0iQnfx1g9kOa6W'),
(4, 'baba', '$2y$10$dsSnjGNXNU.qAW5xG1eq9.X9n5H8SEJ8.lW9VuVfCQKJtaNgMWSqm'),
(5, 'zz', '$2y$10$SGrzwwQwo7kzvZnxCBz6S.b3mmdlr2oKV1zp3R36YQbJWt8wS3f3i');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cards_user` (`id_user`);

--
-- Index pour la table `livres`
--
ALTER TABLE `livres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `fk_cards_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
