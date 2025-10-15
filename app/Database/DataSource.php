-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/10/2025 às 19:44
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `app_courses`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `instructor` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('published','draft') NOT NULL DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `instructor`, `price`, `image_url`, `status`, `created_at`) VALUES
(1, 'Introdução à Psicologia Positiva', 'Descubra os fundamentos da psicologia positiva e aprenda a aplicar os seus princípios para uma vida mais feliz e realizada.', 'Dra. Sofia Almeida', 179.90, NULL, 'published', '2025-10-15 16:40:47'),
(2, 'Técnicas de Mindfulness para Redução de Stress', 'Aprenda práticas de mindfulness e meditação para gerir o stress do dia a dia, aumentar o foco e promover o bem-estar mental.', 'Dr. Marcos Oliveira', 199.50, NULL, 'published', '2025-10-15 16:40:47'),
(3, 'Comunicação Não-Violenta nas Relações', 'Transforme as suas relações através de uma comunicação mais empática e eficaz.', 'Clara Mendes', 249.90, NULL, 'published', '2025-10-15 16:40:47'),
(4, 'Fundamentos da Terapia de Casal', 'Um curso essencial para terapeutas que desejam compreender as dinâmicas dos relacionamentos.', 'Dr. Ricardo Bastos', 349.00, NULL, 'published', '2025-10-15 16:40:47'),
(5, 'Inteligência Emocional: Teoria e Prática', 'Desenvolva a sua inteligência emocional para tomar melhores decisões e melhorar as suas relações.', 'Beatriz Costa', 219.90, '/assets/img-courses/68efda9d7e9d9-ASSISTA BRANCA.png', 'published', '2025-10-15 16:40:47'),
(6, 'Psicologia do Desenvolvimento Infantil', 'Explore as fases do desenvolvimento infantil, desde o nascimento até à adolescência.', 'Dra. Helena Martins', 299.00, NULL, 'published', '2025-10-15 16:40:47'),
(7, 'Como Lidar com a Ansiedade Social', 'Este curso oferece ferramentas práticas baseadas na TCC para gerir e superar a ansiedade social.', 'Felipe Rocha', 189.90, '/assets/img-courses/68efd99565abd-23da58265b9ff37dcfd919e93d7f23d0.jpg', 'published', '2025-10-15 16:40:47'),
(8, 'Neurociência para Terapeutas', 'Compreenda como o cérebro funciona e de que forma a neurociência pode enriquecer a prática clínica.', 'Dr. Lucas Farias', 399.00, NULL, 'published', '2025-10-15 16:40:47'),
(9, 'O Poder do Hábito: Construindo uma Rotina de Sucesso', 'Aprenda como os hábitos são formados e como pode criar rotinas positivas.', 'Júlia Nunes', 159.50, NULL, 'published', '2025-10-15 16:40:47'),
(10, 'Terapia de Aceitação e Compromisso (ACT)', 'Uma introdução aos conceitos da Terapia de Aceitação e Compromisso para aumentar a flexibilidade psicológica.', 'Mariana Esteves', 279.90, NULL, 'published', '2025-10-15 16:40:47'),
(11, 'teste', '', 'Ana Neves', 190.00, NULL, 'published', '2025-10-15 17:16:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `interested_users`
--

CREATE TABLE `interested_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users_app`
--

CREATE TABLE `users_app` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `subscription_plan` enum('none','essential','premium') NOT NULL DEFAULT 'none',
  `subscription_expires_at` datetime DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `password_reset_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users_app`
--

INSERT INTO `users_app` (`id`, `name`, `email`, `cpf`, `password_hash`, `role`, `subscription_plan`, `subscription_expires_at`, `password_reset_token`, `password_reset_expires`, `created_at`) VALUES
(1, 'Bruno Admin', 'brunojsilvasuporte@gmail.com', NULL, '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'admin', 'none', NULL, NULL, NULL, '2025-10-15 16:40:47'),
(2, 'João Essencial', 'essential@email.com', NULL, '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'essential', NULL, NULL, NULL, '2025-10-15 16:40:47'),
(3, 'Carlos Avulso', 'semplano@email.com', NULL, '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'none', NULL, NULL, NULL, '2025-10-15 16:40:47'),
(4, 'Ana Claudia', 'anaclaudia@email.com', NULL, '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'premium', NULL, NULL, NULL, '2025-10-15 16:51:20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status` enum('Em Andamento','Finalizado') NOT NULL DEFAULT 'Em Andamento',
  `access_granted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user_courses`
--

INSERT INTO `user_courses` (`id`, `user_id`, `course_id`, `status`, `access_granted_at`) VALUES
(1, 2, 1, 'Em Andamento', '2025-10-15 16:40:47'),
(2, 2, 2, 'Finalizado', '2025-10-15 16:40:47'),
(3, 3, 4, 'Em Andamento', '2025-10-15 16:40:47'),
(4, 4, 3, 'Finalizado', '2025-10-15 17:33:00'),
(5, 4, 10, 'Finalizado', '2025-10-15 17:33:38'),
(6, 4, 1, 'Finalizado', '2025-10-15 17:37:54');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `interested_users`
--
ALTER TABLE `interested_users`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users_app`
--
ALTER TABLE `users_app`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_course_unique` (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `interested_users`
--
ALTER TABLE `interested_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users_app`
--
ALTER TABLE `users_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `user_courses`
--
ALTER TABLE `user_courses`
  ADD CONSTRAINT `user_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_app` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
