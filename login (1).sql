-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/12/2024 às 23:45
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `login`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  `status` enum('pendente','aprovado','rejeitado') DEFAULT 'pendente',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `conteudo`, `imagem`, `id_usuarios`, `status`, `data_criacao`) VALUES
(8, 'Despedida de Adriano terá Ronaldo, Zico e Materazzi; veja mais \'convocados\'', 'Adriano Imperador divulgou mais detalhes do seu jogo de despedida, que acontece no dia 15 de dezembro, um domingo, às 17h (de Brasília), no Maracanã…', 'uploads/blog.webp', 4, 'aprovado', '2024-12-03 22:36:14'),
(9, 'Lavieri: Ciclo de Rony no Palmeiras se encerrou; situação é ruim para todos', 'O atacante Rony não pode seguir no Palmeiras em 2025, opinou Danilo Lavieri na Live do clube, nesta terça (3).\r\n\r\nNa opinião do comentarista, Rony teve uma ótima passagem no clube alviverde, mas vive uma situação difícil que indica o fim do ciclo dele.\r\n\r\nO Rony não pode continuar no Palmeiras porque o ciclo dele se encerrou. Isso não significa que precisa sair pelas portas do fundo, que não serve mais, ou que é todos os palavrões possíveis. Ele teve uma ótima passagem pelo Palmeiras, tem bons números, ótimos títulos e um lugar legal na história.', 'uploads/noticia.webp', 4, 'aprovado', '2024-12-03 22:37:20'),
(10, 'Lavieri: Ciclo de Rony no Palmeiras se encerrou; situação é ruim para todos', 'O atacante Rony não pode seguir no Palmeiras em 2025, opinou Danilo Lavieri na Live do clube, nesta terça (3).\r\n\r\nNa opinião do comentarista, Rony teve uma ótima passagem no clube alviverde, mas vive uma situação difícil que indica o fim do ciclo dele.\r\n\r\nO Rony não pode continuar no Palmeiras porque o ciclo dele se encerrou. Isso não significa que precisa sair pelas portas do fundo, que não serve mais, ou que é todos os palavrões possíveis. Ele teve uma ótima passagem pelo Palmeiras, tem bons números, ótimos títulos e um lugar legal na história.', 'uploads/noticia.webp', 4, 'aprovado', '2024-12-03 22:40:33'),
(11, 'Lavieri: Ciclo de Rony no Palmeiras se encerrou; situação é ruim para todos', 'O atacante Rony não pode seguir no Palmeiras em 2025, opinou Danilo Lavieri na Live do clube, nesta terça (3).\r\n\r\nNa opinião do comentarista, Rony teve uma ótima passagem no clube alviverde, mas vive uma situação difícil que indica o fim do ciclo dele.\r\n\r\nO Rony não pode continuar no Palmeiras porque o ciclo dele se encerrou. Isso não significa que precisa sair pelas portas do fundo, que não serve mais, ou que é todos os palavrões possíveis. Ele teve uma ótima passagem pelo Palmeiras, tem bons números, ótimos títulos e um lugar legal na história.', 'uploads/noticia.webp', 4, 'aprovado', '2024-12-03 22:40:49');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `tipo_usuario` enum('admin','escritor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo_usuario`) VALUES
(3, 'Ana Carolina', 'carolina.trabalho@gmail.com', '123456', 'admin'),
(4, 'Ana Paula', 'anapaula@gmail.com', '456789', 'escritor');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuarios` (`id_usuarios`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
