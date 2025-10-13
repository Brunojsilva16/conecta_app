-- Removendo tabelas antigas se existirem, para evitar conflitos.
DROP TABLE IF EXISTS `user_courses`,
`interested_users`,
`courses`,
`users_app`;

-- Tabela de Usuários (com controle de assinatura, perfil e redefinição de senha)
CREATE TABLE
  `users_app` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `cpf` VARCHAR(14) NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('user', 'admin') NOT NULL DEFAULT 'user', -- CAMPO ADICIONADO PARA PERFIL
    `subscription_plan` ENUM ('none', 'essential', 'premium') NOT NULL DEFAULT 'none',
    `subscription_expires_at` DATETIME NULL,
    `password_reset_token` VARCHAR(255) NULL,
    `password_reset_expires` DATETIME NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabela de Cursos
CREATE TABLE
  `courses` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `instructor` VARCHAR(255),
    `price` DECIMAL(10, 2) NULL COMMENT 'Preço para compra avulsa',
    `image_url` VARCHAR(255),
    `status` ENUM ('published', 'draft') NOT NULL DEFAULT 'published',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabela de Acesso aos Cursos (Tabela Pivot)
CREATE TABLE
  `user_courses` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `course_id` INT NOT NULL,
    `access_granted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users_app` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
    UNIQUE KEY `user_course_unique` (`user_id`, `course_id`)
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabela para Lista de Espera
CREATE TABLE
  `interested_users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `course_title` VARCHAR(255) NOT NULL,
    `registered_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- DADOS DE EXEMPLO PARA TESTE
-- Inserindo Cursos de Exemplo
INSERT INTO
  `courses` (
    `title`,
    `description`,
    `instructor`,
    `price`,
    `image_url`
  )
VALUES
  (
    'Avaliação Neuropsicológica Infantil',
    'Aprenda as técnicas mais modernas para avaliação infantil.',
    'Dra. Helena Costa',
    149.90,
    'https://placehold.co/400x225/6D28D9/FFFFFF?text=Infantil'
  ),
  (
    'Terapia Cognitivo-Comportamental (TCC)',
    'Curso completo sobre os fundamentos e práticas da TCC.',
    'Dr. Ricardo Borges',
    299.90,
    'https://placehold.co/400x225/4C1D95/FFFFFF?text=TCC'
  ),
  (
    'Psicopatologia e Diagnóstico',
    'Entenda os principais transtornos e como diagnosticá-los.',
    'Dra. Ana Ferreira',
    199.90,
    'https://placehold.co/400x225/6D28D9/FFFFFF?text=Diagnóstico'
  ),
  (
    'Gestão de Consultório para Psicólogos',
    'Aprenda a administrar sua carreira e seu consultório.',
    'Carlos Mendes',
    99.90,
    'https://placehold.co/400x225/4C1D95/FFFFFF?text=Gestão'
  );

-- Inserindo Usuários de Exemplo
-- Senha para todos: "123456"

-- Usuário Administrador
INSERT INTO
  `users_app` (
    `name`,
    `email`,
    `cpf`,
    `password_hash`,
    `role`,
    `subscription_plan`,
    `subscription_expires_at`
  )
VALUES
  (
    'Bruno Silva',
    'brunojsilvasuporte@gmail.com',
    '222.222.222-22',
    '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG',
    'admin', -- PERFIL DE ADMIN
    'premium',
    DATE_ADD(NOW(), INTERVAL 1 YEAR)
  );

-- Usuário Premium (Comum)
INSERT INTO
  `users_app` (
    `name`,
    `email`,
    `cpf`,
    `password_hash`,
    `role`,
    `subscription_plan`,
    `subscription_expires_at`
  )
VALUES
  (
    'Mariana Premium',
    'premium@email.com',
    '111.111.111-11',
    '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG',
    'user', -- PERFIL DE USUÁRIO
    'premium',
    DATE_ADD(NOW(), INTERVAL 1 YEAR)
  );


-- Usuário Essencial (Comum)
INSERT INTO
  `users_app` (
    `name`,
    `email`,
    `cpf`,
    `password_hash`,
    `role`,
    `subscription_plan`,
    `subscription_expires_at`
  )
VALUES
  (
    'João Essencial',
    'essential@email.com',
    '333.333.333-33',
    '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG',
    'user', -- PERFIL DE USUÁRIO
    'essential',
    DATE_ADD(NOW(), INTERVAL 1 MONTH)
  );

-- Usuário sem plano (Comum)
INSERT INTO
  `users_app` (`name`, `email`, `cpf`, `password_hash`, `role`)
VALUES
  (
    'Carlos Avulso',
    'semplano@email.com',
    '444.444.444-44',
    '$2y$10$PIF3Tg6aT7LZIXNlHPSCSOuVrTQAu6p8ilAaJa5i0oqNu3.TE7zPG',
    'user' -- PERFIL DE USUÁRIO
  );

-- Dando acesso a cursos para o usuário Essencial (ele tem direito a 2 cursos)
INSERT INTO
  `user_courses` (`user_id`, `course_id`)
VALUES
  (3, 1), -- ID 3 (João Essencial) tem acesso ao curso 1
  (3, 3); -- ID 3 (João Essencial) tem acesso ao curso 3

-- Dando acesso a um curso comprado avulsamente pelo usuário sem plano
INSERT INTO
  `user_courses` (`user_id`, `course_id`)
VALUES
  (4, 4); -- ID 4 (Carlos Avulso) comprou o curso 4