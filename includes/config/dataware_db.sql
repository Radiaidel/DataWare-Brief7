-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 16 déc. 2023 à 15:17
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
  `archived` tinyint(1) DEFAULT 0,
  `is_solution` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `answer`
--

INSERT INTO `answer` (`answer_id`, `question_id`, `user_id`, `answer_text`, `likes`, `dislikes`, `created_at`, `archived`, `is_solution`) VALUES
(123, 66, 76, 'When redesigning a database for a large-scale application, consider normalization, indexing, and partitioning for performance. Avoid common pitfalls such as ...', 15, 5, '2023-12-07 08:01:34', 0, NULL),
(124, 67, 77, 'For responsive web design, use media queries, flexible grid layouts, and frameworks like Bootstrap. Here are some tips and tricks: ...', 8, 3, '2023-12-07 08:01:34', 0, NULL),
(125, 65, 76, 'Security best practices include using strong password hashing, implementing two-factor authentication, and role-based access control. Here is a guide on implementing these practices: ...', 20, 1, '2023-12-07 08:01:34', 0, NULL),
(126, 65, 77, 'In the upcoming year, trends in web development include the adoption of serverless architecture, the rise of progressive web apps (PWAs), and the continued popularity of JavaScript frameworks like React and Vue.', 12, 4, '2023-12-07 08:01:34', 0, NULL),
(152, 65, 75, ' test1 test1 test1 test1 test1 test1 test1 test1 test1 ', 0, 0, '2023-12-09 15:54:02', 1, NULL),
(156, 65, 75, 'repondre', 0, 0, '2023-12-11 10:00:45', 1, NULL),
(160, 65, 75, 'tesssssssssssst', 0, 0, '2023-12-11 10:06:22', 1, NULL),
(161, 65, 75, 'test2', 0, 0, '2023-12-11 10:10:19', 0, NULL),
(162, 65, 75, 'test2', 0, 0, '2023-12-11 10:11:31', 0, NULL),
(163, 65, 75, 'test2', 0, 0, '2023-12-11 10:13:26', 0, NULL),
(164, 65, 75, 'azertyuiop^mlqsdfghjklm', 0, 0, '2023-12-11 10:13:50', 0, NULL),
(165, 65, 75, 'azertyuiop^mlqsdfghjklm', 0, 0, '2023-12-11 10:14:02', 0, NULL),
(166, 65, 75, 'jyztfdjzetfd', 0, 0, '2023-12-11 10:14:22', 0, NULL),
(167, 65, 75, 'raaaaaaaaaaaaaaaaadia', 0, 0, '2023-12-11 10:16:23', 0, NULL),
(168, 65, 75, 'repooooooooooooooooooooooooooooooooooooooondre', 0, 0, '2023-12-11 10:30:29', 0, NULL),
(169, 65, 75, 'i\'m radia', 0, 0, '2023-12-11 10:33:54', 0, NULL),
(170, 65, 75, 'test test teestt', 0, 0, '2023-12-11 10:36:25', 0, NULL),
(171, 65, 75, 'repo', 0, 0, '2023-12-11 10:36:40', 0, NULL),
(172, 65, 75, 'repo', 0, 0, '2023-12-11 10:36:47', 0, NULL),
(173, 65, 75, 'rep', 0, 0, '2023-12-11 10:36:54', 0, NULL),
(174, 65, 75, 'ertyuio', 0, 0, '2023-12-11 10:37:39', 0, NULL),
(175, 65, 75, 'ukydf', 0, 0, '2023-12-11 10:41:03', 0, NULL),
(176, 65, 75, 'aizuegd', 0, 0, '2023-12-11 10:42:36', 0, NULL),
(177, 65, 75, 'aizuegd', 0, 0, '2023-12-11 10:42:50', 0, NULL),
(178, 65, 75, 'aizuegd', 0, 0, '2023-12-11 10:43:04', 0, NULL),
(179, 65, 75, 'jdbch', 0, 0, '2023-12-11 10:43:23', 0, NULL),
(180, 65, 75, 'iegdulzeiuf', 0, 0, '2023-12-11 10:43:37', 0, NULL),
(181, 65, 75, 'qiudg', 0, 0, '2023-12-11 10:43:47', 0, NULL),
(182, 65, 75, 'iducgy', 0, 0, '2023-12-11 10:44:29', 0, NULL),
(183, 65, 75, 'heeeeeeeeeeeeeeeeeeeellllllllllllllllllllllooooooooooooooooooooooo wooooooooooooooooooooooooorllllllllllllllllllllllllllllllllllllllllllld', 0, 0, '2023-12-11 10:44:55', 0, NULL),
(184, 65, 75, 'yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasssssssssssssssssssssssssssssssssssssssssssssiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiirrrrrrrrrrrrrrrrrrrrrrr', 0, 0, '2023-12-11 10:46:03', 0, NULL),
(185, 65, 75, 'fdxfgcnfc', 0, 0, '2023-12-11 10:48:07', 0, NULL),
(186, 67, 75, 'tessst', 0, 0, '2023-12-11 10:54:12', 0, NULL),
(187, 66, 75, 'repondre', 0, 0, '2023-12-11 10:55:02', 0, NULL),
(188, 68, 75, 'zkjebndlizejb', 0, 0, '2023-12-12 19:18:59', 1, NULL),
(189, 68, 75, ';jhvckvhdyec', 0, 0, '2023-12-12 19:19:10', 1, NULL),
(191, 68, 75, 'anaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 0, 0, '2023-12-12 23:20:30', 0, 1),
(194, 65, 75, 'hiiiiii', 0, 0, '2023-12-15 10:27:58', 0, NULL),
(195, 65, 75, 'hiiiiii', 0, 0, '2023-12-15 10:28:10', 0, NULL),
(196, 69, 75, 'ouiiiiiiiii', 0, 0, '2023-12-15 10:28:42', 0, NULL),
(197, 69, 75, 'ouiiiiiiiii', 0, 0, '2023-12-15 10:28:46', 0, NULL),
(206, NULL, 75, 'hellooo dear', 0, 0, '2023-12-16 04:36:36', 0, 0),
(207, NULL, 75, 'teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeet', 0, 0, '2023-12-16 04:37:37', 0, 0),
(208, 67, 75, 'idaaaa', 0, 0, '2023-12-16 04:40:35', 0, 0),
(209, 68, 75, 'helooooooooooooooooooooooooo', 0, 0, '2023-12-16 04:57:28', 0, 0);

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
(48, 77, 6),
(61, 75, 16),
(62, 79, 16),
(64, 77, 8),
(65, 81, 8);

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
(24, 'Web Development', 'Building a new website', 'ongoing', '2023-12-07 08:22:51', '2023-12-31', 78),
(25, 'Mobile App', 'Developing a mobile application', 'pending', '2023-12-07 08:22:51', '2024-01-15', 78);

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
(65, 75, 24, 'I am working on a web development project using JavaScript, and I am struggling with understanding the concept of closures. Can someone provide a detailed explanation with examples?', 4, 5, '2023-12-07 08:50:43', 1, 'Understanding JavaScript Closures'),
(66, 76, 25, 'In our team, we are planning to redesign our database for a large-scale application. What are the best practices for designing a scalable and efficient database schema? Are there any common pitfalls we should avoid?', 1, 2, '2023-12-07 08:50:43', 1, 'Best Practices for Database Schema Design'),
(67, 77, 24, 'I have been learning front-end development, and I find responsive web design challenging. Can someone share tips and tricks for creating responsive layouts? Are there any recommended frameworks or libraries for responsive design?', 1, 2, '2023-12-07 08:50:43', 0, 'Tips for Responsive Web Design'),
(68, 75, 25, 'As a backend developer, I often deal with handling user authentication and authorization. What are the security best practices for user authentication, and how can I implement role-based access control in my applications?', 0, 0, '2023-12-07 08:50:43', 0, '        Security Best Practices for User Authentication'),
(69, 76, 24, 'I am curious about the latest trends in web development for the upcoming year. What technologies, frameworks, or methodologies are gaining popularity, and how can developers stay up-to-date with industry trends?', 0, 0, '2023-12-07 08:50:43', 0, 'Exploring Web Development Trends for the Future'),
(109, 75, 24, 'll', 0, 0, '2023-12-15 10:24:41', 1, 'll');

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
(103, 65, 8),
(104, 65, 7),
(140, 68, 11),
(141, 68, 11);

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
(16, 'helloTeam', '2023-12-15 15:29:29', 78, 25);

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
(74, 'oumaima', 'oumaima@gmail.com', '$2y$10$ljxMUm1Yb7rZWY2aGx3F9OTXXMdsmVcBhJPIjC/ItxOgso/foi77W', 'po', 'active', 'upload/jane.jpg'),
(75, 'yassir', 'yassir@gmail.com', '$2y$10$O2xTEWnowOml2ZTbfD53QOfa4ZCqrgeMqvG/vNvywo0kUsWHGOIUW', 'user', 'active', 'upload/jane.jpg'),
(76, 'ahmed', 'ahmed@gmail.com', '$2y$10$nT5sh/h51aEv5K.V6K.kqO0k.aY6SDr8IJECsrwR5kJem6i88UHuq', 'user', 'active', 'upload/jane.jpg'),
(77, 'abderahman', 'abderahman@gmail.com', '$2y$10$iBVbVUdpW3OELQ8DO5pGZ./6P/7FcFQcod6pGY4zvrtYZO5fHNi6u', 'user', 'active', 'upload/jane.jpg'),
(78, 'sm', 'sm@gmail.com', '$2y$10$tYoCRXKQ.GGbIsIoDYzVf.IO.gH/05LwKUzCDt95rsiap59AbtGeS', 'sm', 'active', 'upload/jane.jpg'),
(79, 'er', 'fahedd@gmail.com', '$2y$10$rSqcfwuOHChAj/PB89MaOOeVzoDFBAZCV0Ns74iEH3fvYbkHiISwa', 'user', 'active', NULL),
(80, 'radia', 'radia@gmail.com', '$2y$10$SahHLwePhGEDl0BkNA1z.e7PI3quA9TAhIZBtJRzbKusMTYqBJw6m', 'user', 'active', NULL),
(81, 'ayoub88', 'ayoub@gmail.com', '$2y$10$6wV0hWqNrE/xHg/SUb7CuuVed4fal4OararLeB.wsU0fTWtEsNjV.', 'user', 'active', 'upload/mesh-267.png'),
(82, 'radiaaaaaaaa', 'radiaaaaaaaaa@gmail.com', '$2y$10$lEPolUZcJ..ru6SzPYlMsuJ5cJLb5BNcMN4uq5W1zo1ky935e5c3S', 'user', 'active', 'upload/zany-jadraque-YLdC7qO9M3g-unsplash.jpg');

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
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT pour la table `in_team`
--
ALTER TABLE `in_team`
  MODIFY `id_user_team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT pour la table `project`
--
ALTER TABLE `project`
  MODIFY `Id_Project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT pour la table `question_tag`
--
ALTER TABLE `question_tag`
  MODIFY `id_question_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `team`
--
ALTER TABLE `team`
  MODIFY `Id_Team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answer_ibf` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answer_ibfk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`);

--
-- Contraintes pour la table `in_team`
--
ALTER TABLE `in_team`
  ADD CONSTRAINT `in_team_ibf` FOREIGN KEY (`Id_Team`) REFERENCES `team` (`Id_Team`) ON DELETE CASCADE,
  ADD CONSTRAINT `in_team_ibfk1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `in_team_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `in_team_ibfk_2` FOREIGN KEY (`Id_Team`) REFERENCES `team` (`Id_Team`);

--
-- Contraintes pour la table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ib` FOREIGN KEY (`Id_Project`) REFERENCES `project` (`Id_Project`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_ibf` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`Id_Project`) REFERENCES `project` (`Id_Project`);

--
-- Contraintes pour la table `question_tag`
--
ALTER TABLE `question_tag`
  ADD CONSTRAINT `question_tag` FOREIGN KEY (`id_question`) REFERENCES `question` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_tag_i` FOREIGN KEY (`id_tag`) REFERENCES `tags` (`id_tag`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_tag_ib` FOREIGN KEY (`id_question`) REFERENCES `question` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_tag_ibf` FOREIGN KEY (`id_question`) REFERENCES `question` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_tag_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `question` (`question_id`),
  ADD CONSTRAINT `question_tag_ibfk_2` FOREIGN KEY (`id_tag`) REFERENCES `tags` (`id_tag`);

--
-- Contraintes pour la table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ib` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_ibf` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `team_ibfk_2` FOREIGN KEY (`Id_Project`) REFERENCES `project` (`Id_Project`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
