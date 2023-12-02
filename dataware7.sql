-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 02 déc. 2023 à 16:19
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
-- Base de données : `dataware7`
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
(1, 1, 3, 'You can achieve task X by following these steps...', 0, 0, '2023-12-02 15:18:29', 0),
(2, 2, 2, 'The goals for Project B include...', 0, 0, '2023-12-02 15:18:29', 0);

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
(1, 3, 1),
(2, 3, 2),
(3, 2, 2);

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
(1, 'Project A', 'Description for Project A', 'ongoing', '2023-12-02 15:18:29', '2023-01-31', 2),
(2, 'Project B', 'Description for Project B', 'completed', '2023-12-02 15:18:29', '2023-02-28', 2);

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
(1, 3, 1, 'How to achieve task X?', 0, 0, '2023-12-02 15:18:29', 0),
(2, 2, 2, 'What are the goals for Project B?', 0, 0, '2023-12-02 15:18:29', 0);

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
(1, 1, 1),
(2, 2, 2);

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
(1, 'web'),
(2, 'html');

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

CREATE TABLE `team` (
  `Id_Team` int(11) NOT NULL,
  `team_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) DEFAULT NULL,
  `Id_Project` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `team`
--

INSERT INTO `team` (`Id_Team`, `team_name`, `created_at`, `id_user`, `Id_Project`) VALUES
(1, 'Team 1', '2023-12-02 15:18:29', 2, 1),
(2, 'Team 2', '2023-12-02 15:18:29', 2, 2);

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
(1, 'po', 'po@gmail.com', 'po', 'po', 'active'),
(2, 'sm', 'sm@gmail.com', 'sm', 'sm', 'active'),
(3, 'mm', 'mm@gmail.com', 'pass456', 'user', 'inactive');

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
(1, 3, 1),
(2, 2, 2);

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
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `in_team`
--
ALTER TABLE `in_team`
  MODIFY `id_user_team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `project`
--
ALTER TABLE `project`
  MODIFY `Id_Project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `question_tag`
--
ALTER TABLE `question_tag`
  MODIFY `id_question_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `team`
--
ALTER TABLE `team`
  MODIFY `Id_Team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user_questions`
--
ALTER TABLE `user_questions`
  MODIFY `id_user_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
