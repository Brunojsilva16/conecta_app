-- Remove tabelas antigas para uma instalação limpa.
DROP TABLE IF EXISTS `user_courses`, `interested_users`, `courses`, `users_app`;

-- Tabela de Utilizadores (com perfil, plano e redefinição de senha)
CREATE TABLE `users_app` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `cpf` VARCHAR(14) NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('user', 'admin') NOT NULL DEFAULT 'user',
  `subscription_plan` ENUM('none', 'essential', 'premium') NOT NULL DEFAULT 'none',
  `subscription_expires_at` DATETIME NULL,
  `password_reset_token` VARCHAR(255) NULL,
  `password_reset_expires` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Cursos
CREATE TABLE `courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `instructor` VARCHAR(255),
  `price` DECIMAL(10, 2) NULL,
  `image_url` VARCHAR(255),
  `status` ENUM('published', 'draft') NOT NULL DEFAULT 'published',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Acesso aos Cursos (com a coluna 'status' para o progresso)
CREATE TABLE `user_courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `status` ENUM('Em Andamento', 'Finalizado') NOT NULL DEFAULT 'Em Andamento',
  `access_granted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users_app` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `user_course_unique` (`user_id`, `course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela para Lista de Espera
CREATE TABLE `interested_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `course_title` VARCHAR(255) NOT NULL,
  `registered_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- DADOS DE EXEMPLO

-- Novos Cursos
INSERT INTO `courses` (`title`, `description`, `instructor`, `price`, `status`) VALUES
('Introdução à Psicologia Positiva', 'Descubra os fundamentos da psicologia positiva e aprenda a aplicar os seus princípios para uma vida mais feliz e realizada.', 'Dra. Sofia Almeida', 179.90, 'published'),
('Técnicas de Mindfulness para Redução de Stress', 'Aprenda práticas de mindfulness e meditação para gerir o stress do dia a dia, aumentar o foco e promover o bem-estar mental.', 'Dr. Marcos Oliveira', 199.50, 'published'),
('Comunicação Não-Violenta nas Relações', 'Transforme as suas relações através de uma comunicação mais empática e eficaz.', 'Clara Mendes', 249.90, 'published'),
('Fundamentos da Terapia de Casal', 'Um curso essencial para terapeutas que desejam compreender as dinâmicas dos relacionamentos.', 'Dr. Ricardo Bastos', 349.00, 'published'),
('Inteligência Emocional: Teoria e Prática', 'Desenvolva a sua inteligência emocional para tomar melhores decisões e melhorar as suas relações.', 'Beatriz Costa', 219.90, 'published'),
('Psicologia do Desenvolvimento Infantil', 'Explore as fases do desenvolvimento infantil, desde o nascimento até à adolescência.', 'Dra. Helena Martins', 299.00, 'published'),
('Como Lidar com a Ansiedade Social', 'Este curso oferece ferramentas práticas baseadas na TCC para gerir e superar a ansiedade social.', 'Felipe Rocha', 189.90, 'published'),
('Neurociência para Terapeutas', 'Compreenda como o cérebro funciona e de que forma a neurociência pode enriquecer a prática clínica.', 'Dr. Lucas Farias', 399.00, 'published'),
('O Poder do Hábito: Construindo uma Rotina de Sucesso', 'Aprenda como os hábitos são formados e como pode criar rotinas positivas.', 'Júlia Nunes', 159.50, 'published'),
('Terapia de Aceitação e Compromisso (ACT)', 'Uma introdução aos conceitos da Terapia de Aceitação e Compromisso para aumentar a flexibilidade psicológica.', 'Mariana Esteves', 279.90, 'published');

-- Utilizadores de Exemplo
-- Senha para todos: "123456"
INSERT INTO `users_app` (`name`, `email`, `password_hash`, `role`, `subscription_plan`) VALUES
('Bruno Admin', 'brunojsilvasuporte@gmail.com', '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'admin', 'none'),
('João Essencial', 'essential@email.com', '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'essential'),
('Carlos Avulso', 'semplano@email.com', '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'none'),
(4, 'Ana Claudia', 'anaclaudia@email.com', NULL, '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'premium', NULL, NULL, NULL, '2025-10-15 16:51:20');

-- Acessos de Exemplo
INSERT INTO `user_courses` (`user_id`, `course_id`, `status`) VALUES
(1, 2, 1, 'Em Andamento', '2025-10-15 16:40:47'),
(2, 2, 2, 'Finalizado', '2025-10-15 16:40:47'),
(3, 3, 4, 'Em Andamento', '2025-10-15 16:40:47'),
(4, 4, 3, 'Finalizado', '2025-10-15 17:33:00'),
(5, 4, 10, 'Finalizado', '2025-10-15 17:33:38'),
(6, 4, 1, 'Finalizado', '2025-10-15 17:37:54');
