-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 06 déc. 2023 à 15:31
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dataware_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `answer_text` text NOT NULL,
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `answer`
--

INSERT INTO `answer` (`answer_id`, `question_id`, `user_id`, `answer_text`, `likes`, `dislikes`, `created_at`, `archived`) VALUES
(107, 32, 73, 'La date limite pour soumettre les contributions est le 15 décembre 2023.', 8, 1, '2023-12-04 12:45:00', 0),
(108, 32, 57, 'Je recommande les livres \"X\" et \"Y\" ainsi que le site web \"Z\" pour des ressources utiles.', 15, 2, '2023-12-04 14:00:00', 0),
(109, 33, 73, 'Les compétences nécessaires incluent la programmation en Java, la gestion de projet et la communication.', 20, 3, '2023-12-04 15:30:00', 0),
(110, 34, 59, 'Oui, il y a une réunion prévue demain à 14h. Soyez prêt!', 12, 1, '2023-12-04 16:00:00', 0),
(111, 35, 73, 'Pour signaler un problème technique, veuillez contacter notre équipe de support à support@example.com.', 18, 4, '2023-12-05 07:00:00', 0),
(117, 36, 73, 'La prochaine étape du développement est la phase de test. Nous avons besoin de vos retours!', 25, 2, '2023-12-05 08:30:00', 0),
(118, 37, 60, 'Nous encourageons la collaboration! pas à proposer des idées et à participer à nos réunions.', 14, 3, '2023-12-05 09:45:00', 0),
(119, 38, 73, 'La spécification du projet sera clarifiée lors de la réunion de demain à 11h. Soyez là!', 20, 5, '2023-12-05 10:15:00', 0),
(120, 39, 55, 'Pour rejoindre léquipe de développement, veuillez envoyer votre CV à careers@example.com.', 16, 2, '2023-12-05 11:30:00', 0),
(121, 40, 55, 'Les exigences minimales pour participer incluent une connaissance de base de Python et une expérience dans le développement web.', 23, 1, '2023-12-05 12:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `category_tag`
--

CREATE TABLE `category_tag` (
  `id` int(11) NOT NULL,
  `name_category` varchar(255) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category_tag`
--

INSERT INTO `category_tag` (`id`, `name_category`, `tag_id`) VALUES
(1, 'Category1', 1),
(2, 'Category2', 2),
(3, 'Category3', 3),
(4, 'Category4', 1),
(5, 'Category5', 2),
(6, 'Category6', 3),
(7, 'Category7', 1),
(8, 'Category8', 2),
(9, 'Category9', 3),
(10, 'Category10', 1);

-- --------------------------------------------------------

--
-- Structure de la table `in_team`
--

CREATE TABLE `in_team` (
  `id_user_team` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `Id_Team` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `in_team`
--

INSERT INTO `in_team` (`id_user_team`, `id_user`, `Id_Team`) VALUES
(1, 55, 1),
(9, 73, 1),
(13, 55, 1),
(14, 70, 1),
(19, 55, 1),
(22, 56, 2),
(24, 73, 2),
(28, 55, 1),
(31, 56, 2),
(32, 55, 2),
(39, 73, 1);

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

CREATE TABLE `project` (
  `Id_Project` int(11) NOT NULL,
  `project_name` varchar(50) DEFAULT NULL,
  `project_description` varchar(125) DEFAULT NULL,
  `project_status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deadline` date DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`Id_Project`, `project_name`, `project_description`, `project_status`, `created_at`, `deadline`, `id_user`) VALUES
(1, 'Projet A', 'Description du Projet A', 'En cours', '2023-12-05 08:30:00', '2023-12-20', 43),
(2, 'Projet B', 'Description du Projet B', 'En attente', '2023-12-06 09:45:00', '2023-12-25', 44),
(3, 'Projet C', 'Description du Projet C', 'Terminé', '2023-12-07 10:15:00', '2023-12-30', 73),
(4, 'Projet D', 'Description du Projet D', 'En cours', '2023-12-08 11:30:00', '2024-01-05', 46),
(5, 'Projet A', 'Description du Projet A', 'En cours', '2023-12-05 08:30:00', '2023-12-20', 73),
(6, 'Projet B', 'Description du Projet B', 'En attente', '2023-12-06 09:45:00', '2023-12-25', 48),
(7, 'Projet C', 'Description du Projet C', 'Terminé', '2023-12-07 10:15:00', '2023-12-30', 49),
(8, 'Projet D', 'Description du Projet D', 'En cours', '2023-12-08 11:30:00', '2024-01-05', 50),
(9, 'Projet A', 'Description du Projet A', 'En cours', '2023-12-05 08:30:00', '2023-12-20', 51),
(10, 'Projet B', 'Description du Projet B', 'En attente', '2023-12-06 09:45:00', '2023-12-25', 52),
(11, 'Projet C', 'Description du Projet C', 'Terminé', '2023-12-07 10:15:00', '2023-12-30', 73),
(12, 'Projet D', 'Description du Projet D', 'En cours', '2023-12-08 11:30:00', '2024-01-05', 54),
(13, 'Projet A', 'Description du Projet A', 'En cours', '2023-12-05 08:30:00', '2023-12-20', 55),
(14, 'Projet B', 'Description du Projet B', 'En attente', '2023-12-06 09:45:00', '2023-12-25', 73),
(15, 'Projet C', 'Description du Projet C', 'Terminé', '2023-12-07 10:15:00', '2023-12-30', 57),
(16, 'Projet D', 'Description du Projet D', 'En cours', '2023-12-08 11:30:00', '2024-01-05', 58),
(17, 'Projet 1', 'Description du projet 1', 'En cours', '2023-12-05 21:43:15', '2023-12-31', 55),
(18, 'Projet 1', 'Description du projet 1', 'En cours', '2023-12-05 21:43:41', '2023-12-31', 55),
(19, 'Projet 2', 'Description du projet 2', 'Terminé', '2023-12-05 21:43:41', '2023-11-15', 56),
(20, 'Projet 3', 'Description du projet 3', 'En cours', '2023-12-05 21:43:41', '2023-12-20', 60),
(21, 'Projet 4', 'Description du projet 4', 'En attente', '2023-12-05 21:43:41', '2023-10-01', 70);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `Id_Project` int(11) DEFAULT NULL,
  `question_text` text NOT NULL,
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived` tinyint(1) DEFAULT 0,
  `title_question` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`question_id`, `user_id`, `Id_Project`, `question_text`, `likes`, `dislikes`, `created_at`, `archived`, `title_question`) VALUES
(31, 41, 1, 'Quand est la date limite pour soumettre les contributions?', 10, 2, '2023-12-04 13:30:00', 0, NULL),
(32, 42, 2, 'Pouvez-vous recommander des ressources pour le projet?', 8, 1, '2023-12-04 14:45:00', 0, NULL),
(33, 43, 3, 'Quelles sont les compétences nécessaires pour participer?', 15, 3, '2023-12-04 15:15:00', 0, NULL),
(34, 44, 4, 'Y a-t-il des réunions prévues cette semaine?', 12, 2, '2023-12-04 16:20:00', 0, NULL),
(35, 45, 5, 'Comment puis-je signaler un problème technique?', 18, 4, '2023-12-04 17:00:00', 0, NULL),
(36, 46, 6, 'Quelle est la prochaine étape du développement?', 22, 1, '2023-12-05 07:30:00', 0, NULL),
(37, 47, 7, 'Y a-t-il des opportunités de collaboration?', 14, 3, '2023-12-05 08:45:00', 0, NULL),
(38, 48, 8, 'Pouvez-vous clarifier la spécification du projet?', 20, 5, '2023-12-05 09:15:00', 0, NULL),
(39, 49, 9, 'Comment puis-je rejoindre léquipe de développement?', 16, 2, '2023-12-05 10:20:00', 0, NULL),
(40, 50, 10, 'Quelles sont les exigences minimales pour participer?', 25, 1, '2023-12-05 11:00:00', 0, NULL),
(41, 51, 11, 'Pouvez-vous donner des conseils aux nouveaux contributeurs?', 13, 3, '2023-12-05 13:30:00', 0, NULL),
(42, 52, 12, 'Quels sont les objectifs à court terme du projet?', 19, 2, '2023-12-05 14:45:00', 0, NULL),
(43, 53, 13, 'Comment fonctionne la fonctionnalité Y?', 11, 4, '2023-12-05 15:15:00', 0, NULL),
(44, 54, 14, 'Y a-t-il des événements communautaires prévus?', 17, 1, '2023-12-05 16:20:00', 0, NULL),
(45, 55, 15, 'Quelle est la politique de gestion des problèmes?', 23, 5, '2023-12-05 17:00:00', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `question_tag`
--

CREATE TABLE `question_tag` (
  `id_question_tag` int(11) NOT NULL,
  `id_question` int(11) DEFAULT NULL,
  `id_tag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `question_tag`
--

INSERT INTO `question_tag` (`id_question_tag`, `id_question`, `id_tag`) VALUES
(1, 41, 3),
(2, 33, 4),
(3, 38, 1),
(4, 37, 2),
(5, 41, NULL),
(6, 41, 6);

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id_tag` int(11) NOT NULL,
  `tag_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tags`
--

INSERT INTO `tags` (`id_tag`, `tag_name`) VALUES
(1, 'html'),
(2, 'php'),
(3, 'CSS'),
(4, 'WEB'),
(5, 'AJAX'),
(6, 'JSON');

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

CREATE TABLE `team` (
  `Id_Team` int(11) NOT NULL,
  `team_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL,
  `Id_Project` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `team`
--

INSERT INTO `team` (`Id_Team`, `team_name`, `created_at`, `id_user`, `Id_Project`) VALUES
(1, 'Équipe 1', '2023-12-05 21:45:12', 73, 1),
(2, 'Équipe 2', '2023-12-05 21:45:12', 56, 2),
(3, 'Équipe 3', '2023-12-05 21:45:12', 55, 3),
(4, 'Équipe 4', '2023-12-05 21:45:12', 55, 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass_word` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `pass_word`, `role`, `status`, `image_url`) VALUES
(41, 'fahed', 'fahed5656@gmail.com', '12345', 'po', 'active', NULL),
(42, 'hiba', 'hiba0000@gmail.com', '1255345', 'sm', 'active', NULL),
(43, 'simo', 'simo00@gmail.com', '665345', 'user', 'active', NULL),
(44, 'kamal', 'kamal@gmail.com', '665345', 'user', 'inactive', NULL),
(45, 'fahed', 'fahedj@gmail.com', '12345', 'po', 'active', NULL),
(46, 'hiba', 'hiba5@gmail.com', '1255345', 'sm', 'active', NULL),
(47, 'simo', 'simo5@gmail.com', '665345', 'user', 'active', NULL),
(48, 'kamal', 'kamal6@gmail.com', '665345', 'user', 'inactive', NULL),
(49, 'fahed', 'fahed22@gmail.com', '12345', 'po', 'active', NULL),
(50, 'hiba', 'hiba22@gmail.com', '1255345', 'sm', 'active', NULL),
(51, 'simo', 'simo44@gmail.com', '665345', 'user', 'active', NULL),
(52, 'kamal', 'kamal45@gmail.com', '665345', 'user', 'inactive', NULL),
(53, 'fahed', 'fahed222@gmail.com', '12345', 'po', 'active', NULL),
(54, 'hiba', 'hiba21@gmail.com', '1255345', 'sm', 'active', NULL),
(55, 'simo', 'simo534@gmail.com', '665345', 'user', 'active', NULL),
(56, 'kamal', 'kama546l@gmail.com', '665345', 'user', 'inactive', NULL),
(57, 'fahed', 'fahed@gmail.com', '12345', 'po', 'active', NULL),
(58, 'hiba', 'hiba5444@gmail.com', '1255345', 'sm', 'active', NULL),
(59, 'simo', 'simo788@gmail.com', '665345', 'user', 'active', NULL),
(60, 'kamal', 'kamal58786@gmail.com', '665345', 'user', 'inactive', NULL),
(63, 'oumaima', 'erradaoumaima@gmail.com', '$2y$10$m0skQN2rIueUKu2aaZGRduXWTHlPfbeYWX/z/.dtagc', 'user', NULL, 'upload/jhon.jpg'),
(65, '', '', '$2y$10$sJe6/6lIzmDOLkFvs32nxuo.XR3g.X6vBoXvLqKrZnH', 'user', NULL, 'default.jpg'),
(66, 'rawole', 'karo@mailinator.com', '$2y$10$kVWyEWBRTYodS37em7uZse/U5RPU.DBACOSH2tXWRFk', 'user', NULL, 'upload/jane.jpg'),
(69, 'fahedd', 'fah@gmail.com', '$2y$10$OwMAHFZv5l6IHS.Gb5izDufPsrwtWxJO2KL3D9WKEqR', 'user', NULL, 'upload/maxresdefault-removebg-preview.png'),
(70, 'radia', 'radia@gmail.com', '$2y$10$BqyB.IHVevOeQTHLdoaCFelrOYfaHJb.qdh.d3vhhqU', 'po', NULL, 'default.jpg'),
(71, 'aaa', 'a@gmail.com', '$2y$10$h5bQ4boiieBoOksW8FFaPeOnMfWVdXiLmdqYplKQ0wd', 'user', 'active', 'default.jpg'),
(72, 'test', 'test@gmail.com', '$2y$10$VtI6qETRz3zcMW9bw0Faw.hEYJMzlA4jKP5tzluhSON/bhQqaGXmy', 'user', 'active', 'default.jpg'),
(73, 'radia', 'rad@gmail.com', '$2y$10$nFeiHs.npVQy5QKMuo0edOTO3aefJM4jon3udVboXPF8pnNjqh9a.', 'user', 'active', 'default.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `user_questions`
--

CREATE TABLE `user_questions` (
  `id_user_question` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_questions`
--

INSERT INTO `user_questions` (`id_user_question`, `id_user`, `question_id`) VALUES
(1, 73, 41),
(2, 71, 34),
(3, 63, 31),
(4, 53, 42),
(5, 72, 31),
(6, 42, 39);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Index pour la table `category_tag`
--
ALTER TABLE `category_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Index pour la table `in_team`
--
ALTER TABLE `in_team`
  ADD PRIMARY KEY (`id_user_team`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `Id_Team` (`Id_Team`);

--
-- Index pour la table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`Id_Project`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `Id_Project` (`Id_Project`);

--
-- Index pour la table `question_tag`
--
ALTER TABLE `question_tag`
  ADD PRIMARY KEY (`id_question_tag`),
  ADD KEY `id_question` (`id_question`),
  ADD KEY `id_tag` (`id_tag`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id_tag`);

--
-- Index pour la table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`Id_Team`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `Id_Project` (`Id_Project`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `user_questions`
--
ALTER TABLE `user_questions`
  ADD PRIMARY KEY (`id_user_question`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `question_id` (`question_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT pour la table `category_tag`
--
ALTER TABLE `category_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `in_team`
--
ALTER TABLE `in_team`
  MODIFY `id_user_team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `project`
--
ALTER TABLE `project`
  MODIFY `Id_Project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `question_tag`
--
ALTER TABLE `question_tag`
  MODIFY `id_question_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `team`
--
ALTER TABLE `team`
  MODIFY `Id_Team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT pour la table `user_questions`
--
ALTER TABLE `user_questions`
  MODIFY `id_user_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`);

--
-- Contraintes pour la table `category_tag`
--
ALTER TABLE `category_tag`
  ADD CONSTRAINT `category_tag_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id_tag`);

--
-- Contraintes pour la table `in_team`
--
ALTER TABLE `in_team`
  ADD CONSTRAINT `in_team_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `in_team_ibfk_2` FOREIGN KEY (`Id_Team`) REFERENCES `team` (`Id_Team`);

--
-- Contraintes pour la table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`Id_Project`) REFERENCES `project` (`Id_Project`);

--
-- Contraintes pour la table `question_tag`
--
ALTER TABLE `question_tag`
  ADD CONSTRAINT `question_tag_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `question_tag_ibfk_2` FOREIGN KEY (`id_tag`) REFERENCES `tags` (`id_tag`);

--
-- Contraintes pour la table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `team_ibfk_2` FOREIGN KEY (`Id_Project`) REFERENCES `project` (`Id_Project`);

--
-- Contraintes pour la table `user_questions`
--
ALTER TABLE `user_questions`
  ADD CONSTRAINT `user_questions_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `user_questions_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
