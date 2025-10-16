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

-- Tabela de Cursos (COM NOVOS CAMPOS)
CREATE TABLE `courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `instructor` VARCHAR(255),
  `price` DECIMAL(10, 2) NULL,
  `image_url` VARCHAR(255),
  `workload` VARCHAR(50) NULL, 
  `target_audience` TEXT NULL, 
  `format` VARCHAR(255) NULL, 
  `level` VARCHAR(255) NULL, 
  `modality` VARCHAR(255) NULL, 
  `category` ENUM('essential', 'premium', 'platinum') NOT NULL DEFAULT 'essential', -- NOVO CAMPO: Categoria
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

-- DADOS DE EXEMPLO (COM NOVOS CAMPOS E CATEGORIAS)

INSERT INTO `courses` (`title`, `description`, `instructor`, `price`, `status`, `workload`, `target_audience`, `format`, `level`, `modality`, `category`) VALUES
('Introdução à Psicologia Positiva', 'Descubra os fundamentos da psicologia positiva...', 'Dra. Sofia Almeida', 179.90, 'published', '45h', 'Estudantes e público geral.', 'Vídeo-aulas', 'Iniciante', 'Online', 'essential'),
('Técnicas de Mindfulness', 'Aprenda práticas para gerir o stress...', 'Dr. Marcos Oliveira', 199.50, 'published', '30h', 'Qualquer pessoa que queira reduzir o stress.', 'Áudios guiados', 'Iniciante', 'Online', 'essential'),
('Comunicação Não-Violenta', 'Transforme as suas relações...', 'Clara Mendes', 249.90, 'published', '60h', 'Casais, profissionais de RH, líderes.', 'Role-playing', 'Intermediário', 'Online', 'premium'),
('Fundamentos da Terapia de Casal', 'Um curso essencial para terapeutas...', 'Dr. Ricardo Bastos', 349.00, 'published', '80h', 'Psicólogos e terapeutas.', 'Estudos de caso', 'Avançado', 'Online', 'platinum'),
('Inteligência Emocional', 'Desenvolva a sua inteligência emocional...', 'Beatriz Costa', 219.90, 'published', '50h', 'Profissionais de todas as áreas.', 'Testes práticos', 'Intermediário', 'Online', 'essential'),
('Psicologia do Desenvolvimento Infantil', 'Explore as fases do desenvolvimento infantil...', 'Dra. Helena Martins', 299.00, 'published', '75h', 'Pais, educadores e profissionais da saúde.', 'Fóruns de discussão', 'Intermediário', 'Online', 'premium'),
('Como Lidar com a Ansiedade Social', 'Este curso oferece ferramentas práticas...', 'Felipe Rocha', 189.90, 'published', '40h', 'Pessoas que sofrem com ansiedade social.', 'Exercícios práticos', 'Iniciante', 'Online', 'premium'),
('Neurociência para Terapeutas', 'Compreenda como o cérebro funciona...', 'Dr. Lucas Farias', 399.00, 'published', '100h', 'Psicólogos, psiquiatras e neurocientistas.', 'Aulas expositivas', 'Avançado', 'Online', 'platinum'),
('O Poder do Hábito', 'Aprenda como os hábitos são formados...', 'Júlia Nunes', 159.50, 'published', '25h', 'Qualquer pessoa interessada em desenvolvimento pessoal.', 'Ferramentas de planejamento', 'Iniciante', 'Online', 'essential'),
('Terapia de Aceitação e Compromisso (ACT)', 'Uma introdução aos conceitos da ACT...', 'Mariana Esteves', 279.90, 'published', '65h', 'Estudantes e profissionais de psicologia.', 'Dinâmicas em grupo', 'Intermediário', 'Online', 'platinum');

-- Utilizadores de Exemplo
-- Senha para todos: "123456"
INSERT INTO `users_app` (`name`, `email`, `password_hash`, `role`, `subscription_plan`) VALUES
('Bruno Admin', 'brunojsilvasuporte@gmail.com', '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'admin', 'premium'),
('Ana Premium', 'premium@email.com', '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'premium'),
('João Essencial', 'essential@email.com', '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'essential'),
('Carlos Avulso', 'semplano@email.com', '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG', 'user', 'none');

-- Acessos de Exemplo
INSERT INTO `user_courses` (`user_id`, `course_id`, `status`) VALUES
-- João (Essencial) tem acesso automático ao curso 1 (essential) e comprou o 4 (platinum)
(2, 1, 'Em Andamento'),
(2, 4, 'Finalizado'),
-- Carlos (Sem Plano) comprou 1 curso (essential)
(3, 2, 'Em Andamento');

