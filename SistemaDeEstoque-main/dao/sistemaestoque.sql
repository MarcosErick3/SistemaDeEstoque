-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/09/2024 às 03:55
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
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `estoque_id` int NOT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `localizacao_id` int DEFAULT NULL,
  `nivel_minimo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `fornecedor_id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cnpj` varchar(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `operador_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `localizacao`
--

CREATE TABLE `localizacao` (
  `localizacao_id` int NOT NULL,
  `setor` varchar(50) DEFAULT NULL,
  `prateleira` varchar(50) DEFAULT NULL,
  `coluna` varchar(50) DEFAULT NULL,
  `andar` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `movimentacao_id` int NOT NULL,
  `produto_id` int DEFAULT NULL,
  `localizacao_origem_id` int DEFAULT NULL,
  `localizacao_destino_id` int DEFAULT NULL,
  `data_movimentacao` date DEFAULT NULL,
  `operador_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `produto_id` int NOT NULL,
  `codigo_produto` varchar(50) DEFAULT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text,
  `categoria` varchar(100) DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `dimensoes` varchar(100) DEFAULT NULL,
  `numero_lote` varchar(50) DEFAULT NULL,
  `numero_serie` varchar(50) DEFAULT NULL,
  `codigo_barras` varchar(50) DEFAULT NULL,
  `fornecedor_id` int DEFAULT NULL,
  `data_fabricacao` date DEFAULT NULL,
  `data_validade` date DEFAULT NULL,
  `preco_custo` decimal(10,2) DEFAULT NULL,
  `preco_venda` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `relatorioestoque`
--

CREATE TABLE `relatorioestoque` (
  `relatorio_id` int NOT NULL,
  `produto_id` int DEFAULT NULL,
  `quantidade_atual` int DEFAULT NULL,
  `quantidade_minima` int DEFAULT NULL,
  `data_geracao` date DEFAULT NULL,
  `tipo_relatorio` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `status` varchar(50) DEFAULT NULL,
  `fornecedor_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`estoque_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`fornecedor_id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`);

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
  ADD KEY `localizacao_destino_id` (`localizacao_destino_id`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`produto_id`),
  ADD UNIQUE KEY `codigo_produto` (`codigo_produto`),
  ADD KEY `fornecedor_id` (`fornecedor_id`);

--
-- Índices de tabela `recebimento`
--
ALTER TABLE `recebimento`
  ADD PRIMARY KEY (`recebimento_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `relatorioestoque`
--
ALTER TABLE `relatorioestoque`
  ADD PRIMARY KEY (`relatorio_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `reposicao`
--
ALTER TABLE `reposicao`
  ADD PRIMARY KEY (`reposicao_id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `fornecedor_id` (`fornecedor_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `estoque_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `fornecedor_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `inventario`
--
ALTER TABLE `inventario`
  MODIFY `inventario_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `localizacao`
--
ALTER TABLE `localizacao`
  MODIFY `localizacao_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `movimentacao_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `produto_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `recebimento`
--
ALTER TABLE `recebimento`
  MODIFY `recebimento_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `relatorioestoque`
--
ALTER TABLE `relatorioestoque`
  MODIFY `relatorio_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reposicao`
--
ALTER TABLE `reposicao`
  MODIFY `reposicao_id` int NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`);

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
  ADD CONSTRAINT `movimentacao_ibfk_3` FOREIGN KEY (`localizacao_destino_id`) REFERENCES `localizacao` (`localizacao_id`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`fornecedor_id`);

--
-- Restrições para tabelas `recebimento`
--
ALTER TABLE `recebimento`
  ADD CONSTRAINT `recebimento_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`);

--
-- Restrições para tabelas `relatorioestoque`
--
ALTER TABLE `relatorioestoque`
  ADD CONSTRAINT `relatorioestoque_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`);

--
-- Restrições para tabelas `reposicao`
--
ALTER TABLE `reposicao`
  ADD CONSTRAINT `reposicao_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`produto_id`),
  ADD CONSTRAINT `reposicao_ibfk_2` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`fornecedor_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
