-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 07 déc. 2023 à 10:56
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
  `archived` varchar(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `answer`
--

INSERT INTO `answer` (`answer_id`, `question_id`, `user_id`, `answer_text`, `likes`, `dislikes`, `created_at`, `archived`) VALUES
(122, 68, 75, 'Closures in JavaScript provide a way to encapsulate variables and create private scopes. Here is an example: ...', 10, 2, '2023-12-07 09:01:34', '0'),
(123, 66, 76, 'When redesigning a database for a large-scale application, consider normalization, indexing, and partitioning for performance. Avoid common pitfalls such as ...', 15, 5, '2023-12-07 09:01:34', '0'),
(124, 67, 77, 'For responsive web design, use media queries, flexible grid layouts, and frameworks like Bootstrap. Here are some tips and tricks: ...', 8, 3, '2023-12-07 09:01:34', '0'),
(125, 65, 76, 'Security best practices include using strong password hashing, implementing two-factor authentication, and role-based access control. Here is a guide on implementing these practices: ...', 20, 1, '2023-12-07 09:01:34', '0'),
(126, 65, 77, 'In the upcoming year, trends in web development include the adoption of serverless architecture, the rise of progressive web apps (PWAs), and the continued popularity of JavaScript frameworks like React and Vue.', 12, 4, '2023-12-07 09:01:34', '0');

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
(43, 75, 5),
(44, 75, 7),
(45, 76, 6),
(46, 76, 5),
(47, 77, 7),
(48, 77, 6);

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
(24, 'Web Development', 'Building a new website', 'ongoing', '2023-12-07 08:22:51', '2023-12-31', 74),
(25, 'Mobile App', 'Developing a mobile application', 'pending', '2023-12-07 08:22:51', '2024-01-15', 74);

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
  `archived` varchar(20) DEFAULT '0',
  `title_question` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`question_id`, `user_id`, `Id_Project`, `question_text`, `likes`, `dislikes`, `created_at`, `archived`, `title_question`) VALUES
(65, 75, 24, 'I am working on a web development project using JavaScript, and I am struggling with understanding the concept of closures. Can someone provide a detailed explanation with examples?', 0, 0, '2023-12-07 08:50:43', '0', 'Understanding JavaScript Closures'),
(66, 76, 25, 'In our team, we are planning to redesign our database for a large-scale application. What are the best practices for designing a scalable and efficient database schema? Are there any common pitfalls we should avoid?', 0, 0, '2023-12-07 08:50:43', '0', 'Best Practices for Database Schema Design'),
(67, 77, 24, 'I have been learning front-end development, and I find responsive web design challenging. Can someone share tips and tricks for creating responsive layouts? Are there any recommended frameworks or libraries for responsive design?', 0, 0, '2023-12-07 08:50:43', '0', 'Tips for Responsive Web Design'),
(68, 75, 25, 'As a backend developer, I often deal with handling user authentication and authorization. What are the security best practices for user authentication, and how can I implement role-based access control in my applications?', 0, 0, '2023-12-07 08:50:43', '0', 'Security Best Practices for User Authentication and Aut'),
(69, 76, 24, 'I am curious about the latest trends in web development for the upcoming year. What technologies, frameworks, or methodologies are gaining popularity, and how can developers stay up-to-date with industry trends?', 0, 0, '2023-12-07 08:50:43', '0', 'Exploring Web Development Trends for the Future');

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
  `tag_name` varchar(50) DEFAULT NULL,
  `category` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tags`
--

INSERT INTO `tags` (`id_tag`, `tag_name`, `category`) VALUES
(7, 'JavaScript', 'Programming'),
(8, 'PHP', 'Programming'),
(9, 'HTML', 'Web Development'),
(10, 'CSS', 'Web Development'),
(11, 'MySQL', 'Database'),
(12, 'Programming', 'Programming');

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
(5, 'Development Team 1', '2023-12-07 09:06:19', 78, 24),
(6, 'Design Team', '2023-12-07 09:06:19', 78, 24),
(7, 'QA Team', '2023-12-07 09:06:19', 78, 24),
(8, 'Development Team 1', '2023-12-07 09:06:32', 78, 25),
(9, 'Design Team', '2023-12-07 09:06:32', 78, 25),
(10, 'QA Team', '2023-12-07 09:06:32', 78, 25);

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
(74, 'oumaima', 'oumaima@gmail.com', '$2y$10$ljxMUm1Yb7rZWY2aGx3F9OTXXMdsmVcBhJPIjC/ItxOgso/foi77W', 'po', 'active', 'default.jpg'),
(75, 'yassir', 'yassir@gmail.com', '$2y$10$O2xTEWnowOml2ZTbfD53QOfa4ZCqrgeMqvG/vNvywo0kUsWHGOIUW', 'user', 'active', 'default.jpg'),
(76, 'ahmed', 'ahmed@gmail.com', '$2y$10$nT5sh/h51aEv5K.V6K.kqO0k.aY6SDr8IJECsrwR5kJem6i88UHuq', 'user', 'active', 'default.jpg'),
(77, 'abderahman', 'abderahman@gmail.com', '$2y$10$iBVbVUdpW3OELQ8DO5pGZ./6P/7FcFQcod6pGY4zvrtYZO5fHNi6u', 'user', 'active', 'default.jpg'),
(78, 'sm', 'sm@gmail.com', '$2y$10$tYoCRXKQ.GGbIsIoDYzVf.IO.gH/05LwKUzCDt95rsiap59AbtGeS', 'sm', 'active', 'default.jpg');

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
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT pour la table `in_team`
--
ALTER TABLE `in_team`
  MODIFY `id_user_team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `project`
--
ALTER TABLE `project`
  MODIFY `Id_Project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pour la table `question_tag`
--
ALTER TABLE `question_tag`
  MODIFY `id_question_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `team`
--
ALTER TABLE `team`
  MODIFY `Id_Team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
