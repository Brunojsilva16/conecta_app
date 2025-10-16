-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Set-2025 às 02:06
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agenda`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `id_disponibilidade` int(11) NOT NULL,
  `id_servico` int(11) DEFAULT NULL,
  `id_profissional` int(11) DEFAULT NULL,
  `nome_cliente` varchar(160) NOT NULL,
  `telefone_cliente` varchar(20) DEFAULT NULL,
  `email_cliente` varchar(140) NOT NULL,
  `data_hora` datetime NOT NULL,
  `status` enum('confirmado','cancelado','concluido') DEFAULT 'confirmado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `id_disponibilidade`, `id_servico`, `id_profissional`, `nome_cliente`, `telefone_cliente`, `email_cliente`, `data_hora`, `status`) VALUES
(1, 4, 3, 3, 'teste bruno', '81 99999 2222', 'teste@gmail.com', '2025-08-21 20:00:00', 'confirmado'),
(2, 2, 1, 1, 'teste', '71898749879', 'teste@mail.com', '2025-08-21 19:00:00', 'confirmado'),
(3, 7, 4, 3, 'reste 1830', '81897 9879798', 'teste@mail.com', '2025-08-22 15:00:00', 'confirmado'),
(4, 9, 2, 2, 'teste tati', '81 9879874654', 'tati@mail.com', '2025-08-21 21:00:00', 'confirmado'),
(5, 11, 5, 4, 'bruno', '81 98889999', 'teste@mail.com', '2025-08-25 16:00:00', 'confirmado'),
(6, 16, 5, 4, 'teste', '81 98989798 79879', 'teste@mail.com', '2025-08-26 21:00:00', 'confirmado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `disponibilidade`
--

CREATE TABLE `disponibilidade` (
  `id` int(11) NOT NULL,
  `profissionalId` int(11) DEFAULT NULL,
  `profissionalNome` varchar(255) NOT NULL,
  `id_servico` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `status` enum('disponivel','agendado') DEFAULT 'disponivel',
  `clienteNome` varchar(255) DEFAULT NULL,
  `clienteEmail` varchar(255) DEFAULT NULL,
  `clienteTelefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `disponibilidade`
--

INSERT INTO `disponibilidade` (`id`, `profissionalId`, `profissionalNome`, `id_servico`, `data`, `hora`, `status`, `clienteNome`, `clienteEmail`, `clienteTelefone`) VALUES
(1, 1, 'Carlos Machado', 1, '2025-08-21', '18:00:00', 'disponivel', NULL, NULL, NULL),
(2, 1, 'Carlos Machado', 1, '2025-08-21', '19:00:00', 'agendado', 'teste', 'teste@mail.com', '71898749879'),
(3, 3, 'Pamela Almeida', 3, '2025-08-21', '19:00:00', 'disponivel', NULL, NULL, NULL),
(4, 3, 'Pamela Almeida', 3, '2025-08-21', '20:00:00', 'agendado', 'teste bruno', 'teste@gmail.com', '81 99999 2222'),
(5, 3, 'Pamela Almeida', 3, '2025-08-21', '21:00:00', 'disponivel', NULL, NULL, NULL),
(6, 3, 'Pamela Almeida', 4, '2025-08-22', '14:00:00', 'disponivel', NULL, NULL, NULL),
(7, 3, 'Pamela Almeida', 4, '2025-08-22', '15:00:00', 'agendado', 'reste 1830', 'teste@mail.com', '81897 9879798'),
(8, 2, 'Tatiana Brito', 2, '2025-08-21', '20:00:00', 'disponivel', NULL, NULL, NULL),
(9, 2, 'Tatiana Brito', 2, '2025-08-21', '21:00:00', 'agendado', 'teste tati', 'tati@mail.com', '81 9879874654'),
(10, 2, 'Tatiana Brito', 2, '2025-08-21', '22:00:00', 'disponivel', NULL, NULL, NULL),
(11, 4, 'Jaqueline Souza', 5, '2025-08-25', '16:00:00', 'agendado', 'bruno', 'teste@mail.com', '81 98889999'),
(12, 3, 'Pamela Almeida', 3, '2025-08-25', '20:00:00', 'disponivel', NULL, NULL, NULL),
(13, 1, 'Carlos Machado', 1, '2025-08-26', '20:00:00', 'disponivel', NULL, NULL, NULL),
(14, 1, 'Carlos Machado', 1, '2025-08-26', '21:00:00', 'disponivel', NULL, NULL, NULL),
(15, 1, 'Carlos Machado', 1, '2025-08-26', '22:10:00', 'disponivel', NULL, NULL, NULL),
(16, 4, 'Jaqueline Souza', 5, '2025-08-26', '21:00:00', 'agendado', 'teste', 'teste@mail.com', '81 98989798 79879');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `grupos`
--

INSERT INTO `grupos` (`id`, `nome`, `slug`, `descricao`, `telefone`, `logo_url`, `created_at`, `updated_at`) VALUES
(1, 'Clínica Geral', 'clinica-geral', 'Agendamentos para a Clínica Geral', '11999998888', NULL, '2025-09-15 20:33:34', '2025-09-15 20:33:34');

-- --------------------------------------------------------

--
-- Estrutura da tabela `profissionais`
--

CREATE TABLE `profissionais` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `grupo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `profissionais`
--

INSERT INTO `profissionais` (`id`, `nome`, `email`, `telefone`, `grupo_id`) VALUES
(1, 'Carlos Machado', 'carlosmteste@mail.com', '81 99880 0000', 1),
(2, 'Tatiana Brito', 'tatianeb@mail.com', '81 99000 5555', 1),
(3, 'Pamela Almeida', 'pamela@mail.com', '81 98833 6644', NULL),
(4, 'Jaqueline Souza', 'jaquesouza@mail.com', '81 93336 0000', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `profissional_servicos`
--

CREATE TABLE `profissional_servicos` (
  `id_profissional` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `profissional_servicos`
--

INSERT INTO `profissional_servicos` (`id_profissional`, `id_servico`) VALUES
(1, 1),
(2, 2),
(3, 3),
(3, 4),
(4, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `duracao_min` int(11) NOT NULL,
  `preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `servicos`
--

INSERT INTO `servicos` (`id`, `nome`, `duracao_min`, `preco`) VALUES
(1, 'Psicoterapia', 45, 150.00),
(2, 'Massoterapia', 50, 180.00),
(3, 'Fono', 50, 200.00),
(4, 'TO', 60, 200.00),
(5, 'Nutrição', 50, 250.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `created_at`) VALUES
(1, 'Ada Lovelace fakes', 'ada.lovelace@example.com', '2025-08-18 19:48:03'),
(2, 'Grace Hopper', 'grace.hopper@example.com', '2025-08-18 19:48:03'),
(3, 'Margaret Hamilton', 'margaret.hamilton@example.com', '2025-08-18 19:48:03'),
(4, 'Novo user', 'testeuser@mail.com', '2025-08-25 19:24:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `perfil`) VALUES
(1, 'Bruno Silva', 'brunoteste@gmail.com', '123456', 'admin'),
(2, 'bruno Adm', 'teste@mail.com', '$2y$10$c0cTE1hSbWnpDD/WrGiLCeFuO/zst33robvgEipSaPP1PtZl2sr6G', 'admin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_grupo`
--

CREATE TABLE `usuario_grupo` (
  `usuario_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuario_grupo`
--

INSERT INTO `usuario_grupo` (`usuario_id`, `grupo_id`) VALUES
(1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_id_servico_ag` (`id_servico`),
  ADD KEY `idx_id_profissional_ag` (`id_profissional`),
  ADD KEY `idx_id_disponibilidade_ag` (`id_disponibilidade`);

--
-- Índices para tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_slot` (`data`,`hora`,`profissionalId`),
  ADD KEY `idx_id_servico_disp` (`id_servico`);

--
-- Índices para tabela `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Índices para tabela `profissionais`
--
ALTER TABLE `profissionais`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_profissionais_grupo` (`grupo_id`);

--
-- Índices para tabela `profissional_servicos`
--
ALTER TABLE `profissional_servicos`
  ADD PRIMARY KEY (`id_profissional`,`id_servico`),
  ADD KEY `id_servico` (`id_servico`);

--
-- Índices para tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `usuario_grupo`
--
ALTER TABLE `usuario_grupo`
  ADD PRIMARY KEY (`usuario_id`,`grupo_id`),
  ADD KEY `fk_ug_grupo` (`grupo_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `profissionais`
--
ALTER TABLE `profissionais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `fk_ag_disponibilidade` FOREIGN KEY (`id_disponibilidade`) REFERENCES `disponibilidade` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ag_profissional` FOREIGN KEY (`id_profissional`) REFERENCES `profissionais` (`id`),
  ADD CONSTRAINT `fk_ag_servico` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`);

--
-- Limitadores para a tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  ADD CONSTRAINT `fk_disp_servico` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`);

--
-- Limitadores para a tabela `profissionais`
--
ALTER TABLE `profissionais`
  ADD CONSTRAINT `fk_profissionais_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `profissional_servicos`
--
ALTER TABLE `profissional_servicos`
  ADD CONSTRAINT `fk_ps_profissional` FOREIGN KEY (`id_profissional`) REFERENCES `profissionais` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ps_servico` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `usuario_grupo`
--
ALTER TABLE `usuario_grupo`
  ADD CONSTRAINT `fk_ug_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ug_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
