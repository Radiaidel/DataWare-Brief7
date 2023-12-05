-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 04 déc. 2023 à 15:03
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

-- --------------------------------------------------------

--
-- Structure de la table `in_team`
--

CREATE TABLE `in_team` (
  `id_user_team` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `Id_Team` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'Projet C', 'Description du Projet C', 'Terminé', '2023-12-07 10:15:00', '2023-12-30', 45),
(4, 'Projet D', 'Description du Projet D', 'En cours', '2023-12-08 11:30:00', '2024-01-05', 46),
(5, 'Projet A', 'Description du Projet A', 'En cours', '2023-12-05 08:30:00', '2023-12-20', 47),
(6, 'Projet B', 'Description du Projet B', 'En attente', '2023-12-06 09:45:00', '2023-12-25', 48),
(7, 'Projet C', 'Description du Projet C', 'Terminé', '2023-12-07 10:15:00', '2023-12-30', 49),
(8, 'Projet D', 'Description du Projet D', 'En cours', '2023-12-08 11:30:00', '2024-01-05', 50),
(9, 'Projet A', 'Description du Projet A', 'En cours', '2023-12-05 08:30:00', '2023-12-20', 51),
(10, 'Projet B', 'Description du Projet B', 'En attente', '2023-12-06 09:45:00', '2023-12-25', 52),
(11, 'Projet C', 'Description du Projet C', 'Terminé', '2023-12-07 10:15:00', '2023-12-30', 53),
(12, 'Projet D', 'Description du Projet D', 'En cours', '2023-12-08 11:30:00', '2024-01-05', 54),
(13, 'Projet A', 'Description du Projet A', 'En cours', '2023-12-05 08:30:00', '2023-12-20', 55),
(14, 'Projet B', 'Description du Projet B', 'En attente', '2023-12-06 09:45:00', '2023-12-25', 56),
(15, 'Projet C', 'Description du Projet C', 'Terminé', '2023-12-07 10:15:00', '2023-12-30', 57),
(16, 'Projet D', 'Description du Projet D', 'En cours', '2023-12-08 11:30:00', '2024-01-05', 58);

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
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`question_id`, `user_id`, `Id_Project`, `question_text`, `likes`, `dislikes`, `created_at`, `archived`) VALUES
(31, 41, 1, 'Quand est la date limite pour soumettre les contributions?', 10, 2, '2023-12-04 13:30:00', 0),
(32, 42, 2, 'Pouvez-vous recommander des ressources pour le projet?', 8, 1, '2023-12-04 14:45:00', 0),
(33, 43, 3, 'Quelles sont les compétences nécessaires pour participer?', 15, 3, '2023-12-04 15:15:00', 0),
(34, 44, 4, 'Y a-t-il des réunions prévues cette semaine?', 12, 2, '2023-12-04 16:20:00', 0),
(35, 45, 5, 'Comment puis-je signaler un problème technique?', 18, 4, '2023-12-04 17:00:00', 0),
(36, 46, 6, 'Quelle est la prochaine étape du développement?', 22, 1, '2023-12-05 07:30:00', 0),
(37, 47, 7, 'Y a-t-il des opportunités de collaboration?', 14, 3, '2023-12-05 08:45:00', 0),
(38, 48, 8, 'Pouvez-vous clarifier la spécification du projet?', 20, 5, '2023-12-05 09:15:00', 0),
(39, 49, 9, 'Comment puis-je rejoindre léquipe de développement?', 16, 2, '2023-12-05 10:20:00', 0),
(40, 50, 10, 'Quelles sont les exigences minimales pour participer?', 25, 1, '2023-12-05 11:00:00', 0),
(41, 51, 11, 'Pouvez-vous donner des conseils aux nouveaux contributeurs?', 13, 3, '2023-12-05 13:30:00', 0),
(42, 52, 12, 'Quels sont les objectifs à court terme du projet?', 19, 2, '2023-12-05 14:45:00', 0),
(43, 53, 13, 'Comment fonctionne la fonctionnalité Y?', 11, 4, '2023-12-05 15:15:00', 0),
(44, 54, 14, 'Y a-t-il des événements communautaires prévus?', 17, 1, '2023-12-05 16:20:00', 0),
(45, 55, 15, 'Quelle est la politique de gestion des problèmes?', 23, 5, '2023-12-05 17:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `question_tag`
--

CREATE TABLE `question_tag` (
  `id_question_tag` int(11) NOT NULL,
  `id_question` int(11) DEFAULT NULL,
  `id_tag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id_tag` int(11) NOT NULL,
  `tag_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass_word` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `pass_word`, `role`, `status`) VALUES
(41, 'fahed', 'fahed5656@gmail.com', '12345', 'po', 'active'),
(42, 'hiba', 'hiba0000@gmail.com', '1255345', 'sm', 'active'),
(43, 'simo', 'simo00@gmail.com', '665345', 'user', 'active'),
(44, 'kamal', 'kamal@gmail.com', '665345', 'user', 'inactive'),
(45, 'fahed', 'fahedj@gmail.com', '12345', 'po', 'active'),
(46, 'hiba', 'hiba5@gmail.com', '1255345', 'sm', 'active'),
(47, 'simo', 'simo5@gmail.com', '665345', 'user', 'active'),
(48, 'kamal', 'kamal6@gmail.com', '665345', 'user', 'inactive'),
(49, 'fahed', 'fahed22@gmail.com', '12345', 'po', 'active'),
(50, 'hiba', 'hiba22@gmail.com', '1255345', 'sm', 'active'),
(51, 'simo', 'simo44@gmail.com', '665345', 'user', 'active'),
(52, 'kamal', 'kamal45@gmail.com', '665345', 'user', 'inactive'),
(53, 'fahed', 'fahed222@gmail.com', '12345', 'po', 'active'),
(54, 'hiba', 'hiba21@gmail.com', '1255345', 'sm', 'active'),
(55, 'simo', 'simo534@gmail.com', '665345', 'user', 'active'),
(56, 'kamal', 'kama546l@gmail.com', '665345', 'user', 'inactive'),
(57, 'fahed', 'fahed@gmail.com', '12345', 'po', 'active'),
(58, 'hiba', 'hiba5444@gmail.com', '1255345', 'sm', 'active'),
(59, 'simo', 'simo788@gmail.com', '665345', 'user', 'active'),
(60, 'kamal', 'kamal58786@gmail.com', '665345', 'user', 'inactive');

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
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `in_team`
--
ALTER TABLE `in_team`
  MODIFY `id_user_team` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `project`
--
ALTER TABLE `project`
  MODIFY `Id_Project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `question_tag`
--
ALTER TABLE `question_tag`
  MODIFY `id_question_tag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `team`
--
ALTER TABLE `team`
  MODIFY `Id_Team` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `user_questions`
--
ALTER TABLE `user_questions`
  MODIFY `id_user_question` int(11) NOT NULL AUTO_INCREMENT;

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
