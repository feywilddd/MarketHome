-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : mar. 28 mai 2024 à 14:16
-- Version du serveur : 11.2.2-MariaDB-1:11.2.2+maria~ubu2204
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `TP-1`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `restToken` varchar(255) NOT NULL,
  `isValid` tinyint(1) DEFAULT 0,
  `tokenTime` int(11) NOT NULL,
  `RememberMe` varchar(255) NOT NULL DEFAULT '''''',
  `RememberMeTime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `restToken`, `isValid`, `tokenTime`, `RememberMe`, `RememberMeTime`) VALUES
(7, 'caro', '$2y$10$TM/8Ie302cFtmIlKUDXXD.rjjk5WmwtgkNQyhWP86r89snsnDdvFW', '', 0, 0, '0', 0),
(8, 'toto', '$2y$10$WC0YS2KMB3aqXZ34Fnqzpukm1kocAoRJnaPbPDI5SAzf6BCnNVbyq', '', 0, 0, '0', 0),
(9, 'test', '$2y$10$kGL/sbatEbDD5m3f51UF4uxgzLiaR.poZsgW2kYao/nTlIzGtwBya', '', 0, 0, '0', 0),
(10, 'nic', '$2y$10$UeGw/8xhoEQS4BnwlCWlH.QXyrT3.5Bt8KECVZz7DCLS1JTEEDjnq', '', 0, 0, '0', 0),
(11, 'LesBarresDeTextesDeCréerUnCompteSontTrèsLongues; DROP Table test', '$2y$10$GZPNupG.kgmGZjvqQSUg9euUQOQsJgWek4CDl8bFFfSeogIRC0jHO', '', 0, 0, '0', 0),
(12, 'test', '$2y$10$.JdyjlBRo/XR9c3sz.6Uqu/9Xu8lxro1HX3vlAr1SWfhZcEPlWu1S', '', 0, 0, '0', 0),
(17, 'caro', '$2y$10$BSIBesCYF3nPZ8.UxeG2oe1EvK9yvpx66.ROpiBut7.Rzt9PGl01C', '', 0, 0, '0', 0),
(19, 'jaco', '$2y$10$ccCvmvftaVRNzp2Dd0rBduHByd5DhOVE2fHAvzkOXJgeXpE5n6euu', '', 0, 0, '0', 0),
(23, 'nico', '$2y$10$10gxU1ry41dE3aBrn.wiGux.UBsNkVjuJa3Dq6wrCEqq5W07JgG8W', '', 0, 0, '0', 0),
(24, 'philippe@gmail.com', '$2y$10$SWxzHRPSNBAZlOKb1RX.Kus5WRPwy0g3Efk6CtLTgsObfb41cowya', '562f79566a2eab18754644cffcf630ce', 1, 1716869001, 'b0eccdd212415abbda86f2f0', 1717509777),
(28, 'jaclev43@gmail.com', '$2y$10$d1cDrqTDckhFzXeZcA/U.eguoT0VibjjmQSOfd2TTAftrJO5QXHzS', '9210d7d5cef160ec5d9c1c07', 0, 1716902760, '\'\'', 0),
(31, 'jaclev34@gmail.com', '$2y$10$9n09FoE7SrM2P1WqK/LWP.DNgOpySddXD9nKMiaX38muXacpmn6G6', '8eba3e3ebafd858b342d5b0b', 1, 1716903255, '\'\'', 0),
(32, 'jaclev33@gmail.com', '$2y$10$jBx.2RTq2g9jnOpg6tLmi.IcIxxXArAV4VrdwlQ.fYk1he2.JbLmq', 'eb3ed21654c47b0c963c9065f5f7347c', 1, 1716903694, '98210f4fe2e324803cfaf61c', 0),
(33, '23@test.com', '$2y$10$5tFRuns/A99tVtWCGWTmseHUCB.WB1CkGDoqB.LKfIy0paTz1qJZG', 'dae062a07daa21d40c256f43', 1, 1716905890, '\'\'', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
