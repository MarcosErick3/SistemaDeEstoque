-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/11/2024 às 00:30
-- Versão do servidor: 8.0.39
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistemaestoque`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `devolucoes`
--

CREATE TABLE `devolucoes` (
  `devolucao_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `fornecedor_id` int NOT NULL,
  `data_devolucao` date NOT NULL,
  `quantidade` int NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `divergencia`
--

CREATE TABLE `divergencia` (
  `divergencia_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `data_divergencia` datetime DEFAULT CURRENT_TIMESTAMP,
  `destino` varchar(255) DEFAULT NULL,
  `descricao` text,
  `status` varchar(50) DEFAULT 'Pendente',
  `operador_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `estoque_id` int NOT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `localizacao_id` int DEFAULT NULL,
  `nivel_minimo` int DEFAULT NULL,
  `nivel_atual` int DEFAULT NULL,
  `alerta_critico` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `fornecedor_id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `fornecedor`
--

INSERT INTO `fornecedor` (`fornecedor_id`, `nome`, `telefone`, `email`, `cnpj`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`) VALUES
(1, 'Nome do Fornecedor', '123456789', 'fornecedor@example.com', '12.345.678/0001-90', 'Rua Exemplo', '123', 'Apto 1', 'Bairro Exemplo', 'Cidade Exemplo', 'Estado Exemplo', '12345-678');

-- --------------------------------------------------------

--
-- Estrutura para tabela `inventario`
--

CREATE TABLE `inventario` (
  `inventario_id` int NOT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade_fisica` int DEFAULT NULL,
  `localizacao_id` int DEFAULT NULL,
  `data_inventario` date DEFAULT NULL,
  `operador_id` int DEFAULT NULL,
  `divergencia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `localizacao`
--

CREATE TABLE `localizacao` (
  `localizacao_id` int NOT NULL,
  `corredor` varchar(50) DEFAULT NULL,
  `prateleira` varchar(255) NOT NULL,
  `coluna` varchar(255) NOT NULL,
  `andar` int NOT NULL,
  `capacidade_total` int NOT NULL,
  `ocupacao_atual` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `localizacao`
--

INSERT INTO `localizacao` (`localizacao_id`, `corredor`, `prateleira`, `coluna`, `andar`, `capacidade_total`, `ocupacao_atual`) VALUES
(15, 'A', '1', '1', 1, 50, 0),
(16, 'A', '1', '2', 1, 50, 0),
(17, 'A', '1', '3', 1, 50, 0),
(18, 'B', '2', '1', 2, 75, 0),
(19, 'B', '2', '2', 2, 75, 0),
(20, 'C', '3', '1', 3, 100, 0),
(21, 'C', '3', '2', 3, 100, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `movimentacao_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `localizacao_origem_id` int NOT NULL,
  `localizacao_destino_id` int NOT NULL,
  `data_movimentacao` datetime NOT NULL,
  `operador_id` int NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `quantidade_movimentada` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `operador`
--

CREATE TABLE `operador` (
  `operador_id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `operador`
--

INSERT INTO `operador` (`operador_id`, `nome`, `telefone`, `email`) VALUES
(1, 'Maria Silva', '9876543210', 'maria.silva@email.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `produto_id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `dimensoes` varchar(100) DEFAULT NULL,
  `numero_lote` varchar(50) DEFAULT NULL,
  `numero_serie` varchar(50) DEFAULT NULL,
  `codigo_barras` varchar(50) DEFAULT NULL,
  `fornecedor_id` int DEFAULT NULL,
  `data_fabricacao` date DEFAULT NULL,
  `data_validade` date DEFAULT NULL,
  `quantidade_reservada` int DEFAULT '0',
  `status_produto` varchar(50) DEFAULT 'Disponível',
  `categoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_localizacao`
--

CREATE TABLE `produto_localizacao` (
  `id` int NOT NULL,
  `produto_id` int NOT NULL,
  `localizacao_id` int NOT NULL,
  `quantidade` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `recebimento`
--

CREATE TABLE `recebimento` (
  `recebimento_id` int NOT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade_recebida` int DEFAULT NULL,
  `data_recebimento` date DEFAULT NULL,
  `nota_fiscal` varchar(100) DEFAULT NULL,
  `operador_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reposicao`
--

CREATE TABLE `reposicao` (
  `reposicao_id` int NOT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `data_solicitacao` date DEFAULT NULL,
  `data_reposicao` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pendente',
  `fornecedor_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `saida`
--

CREATE TABLE `saida` (
  `saida_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `data_saida` datetime DEFAULT CURRENT_TIMESTAMP,
  `cliente` varchar(255) NOT NULL,
  `destino` varchar(255) NOT NULL,
  `fornecedor_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `devolucoes`
--
ALTER TABLE `devolucoes`
  ADD PRIMARY KEY (`devolucao_id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `fornecedor_id` (`fornecedor_id`);

--
-- Índices de tabela `divergencia`
--
ALTER TABLE `divergencia`
  ADD PRIMARY KEY (`divergencia_id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `operador_id` (`operador_id`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`estoque_id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `localizacao_id` (`localizacao_id`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`fornecedor_id`);

--
-- Índices de tabela `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`inventario_id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `localizacao_id` (`localizacao_id`);

--
-- Índices de tabela `localizacao`
--
ALTER TABLE `localizacao`
  ADD PRIMARY KEY (`localizacao_id`);

--
-- Índices de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`movimentacao_id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `localizacao_origem_id` (`localizacao_origem_id`),
  ADD KEY `localizacao_destino_id` (`localizacao_destino_id`),
  ADD KEY `operador_id` (`operador_id`);

--
-- Índices de tabela `operador`
--
ALTER TABLE `operador`
  ADD PRIMARY KEY (`operador_id`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`produto_id`),
  ADD KEY `fornecedor_id` (`fornecedor_id`);

--
-- Índices de tabela `produto_localizacao`
--
ALTER TABLE `produto_localizacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `localizacao_id` (`localizacao_id`);

--
-- Índices de tabela `recebimento`
--
ALTER TABLE `recebimento`
  ADD PRIMARY KEY (`recebimento_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `reposicao`
--
ALTER TABLE `reposicao`
  ADD PRIMARY KEY (`reposicao_id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `fornecedor_id` (`fornecedor_id`);

--
-- Índices de tabela `saida`
--
ALTER TABLE `saida`
  ADD PRIMARY KEY (`saida_id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `fk_fornecedor` (`fornecedor_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `devolucoes`
--
ALTER TABLE `devolucoes`
  MODIFY `devolucao_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `divergencia`
--
ALTER TABLE `divergencia`
  MODIFY `divergencia_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `estoque_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `fornecedor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `inventario`
--
ALTER TABLE `inventario`
  MODIFY `inventario_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `localizacao`
--
ALTER TABLE `localizacao`
  MODIFY `localizacao_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `movimentacao_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `operador`
--
ALTER TABLE `operador`
  MODIFY `operador_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `produto_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `produto_localizacao`
--
ALTER TABLE `produto_localizacao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `recebimento`
--
ALTER TABLE `recebimento`
  MODIFY `recebimento_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reposicao`
--
ALTER TABLE `reposicao`
  MODIFY `reposicao_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `saida`
--
ALTER TABLE `saida`
  MODIFY `saida_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `devolucoes`
--
ALTER TABLE `devolucoes`
  ADD CONSTRAINT `devolucoes_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`),
  ADD CONSTRAINT `devolucoes_ibfk_2` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`fornecedor_id`);

--
-- Restrições para tabelas `divergencia`
--
ALTER TABLE `divergencia`
  ADD CONSTRAINT `divergencia_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`),
  ADD CONSTRAINT `divergencia_ibfk_2` FOREIGN KEY (`operador_id`) REFERENCES `operador` (`operador_id`);

--
-- Restrições para tabelas `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`),
  ADD CONSTRAINT `estoque_ibfk_2` FOREIGN KEY (`localizacao_id`) REFERENCES `localizacao` (`localizacao_id`);

--
-- Restrições para tabelas `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`),
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`localizacao_id`) REFERENCES `localizacao` (`localizacao_id`);

--
-- Restrições para tabelas `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD CONSTRAINT `movimentacao_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`),
  ADD CONSTRAINT `movimentacao_ibfk_2` FOREIGN KEY (`localizacao_origem_id`) REFERENCES `localizacao` (`localizacao_id`),
  ADD CONSTRAINT `movimentacao_ibfk_3` FOREIGN KEY (`localizacao_destino_id`) REFERENCES `localizacao` (`localizacao_id`),
  ADD CONSTRAINT `movimentacao_ibfk_4` FOREIGN KEY (`operador_id`) REFERENCES `operador` (`operador_id`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`fornecedor_id`);

--
-- Restrições para tabelas `produto_localizacao`
--
ALTER TABLE `produto_localizacao`
  ADD CONSTRAINT `produto_localizacao_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`),
  ADD CONSTRAINT `produto_localizacao_ibfk_2` FOREIGN KEY (`localizacao_id`) REFERENCES `localizacao` (`localizacao_id`);

--
-- Restrições para tabelas `recebimento`
--
ALTER TABLE `recebimento`
  ADD CONSTRAINT `recebimento_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`);

--
-- Restrições para tabelas `reposicao`
--
ALTER TABLE `reposicao`
  ADD CONSTRAINT `reposicao_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`),
  ADD CONSTRAINT `reposicao_ibfk_2` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`fornecedor_id`);

--
-- Restrições para tabelas `saida`
--
ALTER TABLE `saida`
  ADD CONSTRAINT `fk_fornecedor` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`fornecedor_id`),
  ADD CONSTRAINT `saida_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
