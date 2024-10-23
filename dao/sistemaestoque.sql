-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23/10/2024 às 13:58
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
  `prateleira` varchar(50) DEFAULT NULL,
  `coluna` varchar(50) DEFAULT NULL,
  `andar` int DEFAULT NULL,
  `capacidade_total` int DEFAULT NULL,
  `ocupacao_atual` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `localizacao`
--

INSERT INTO `localizacao` (`localizacao_id`, `corredor`, `prateleira`, `coluna`, `andar`, `capacidade_total`, `ocupacao_atual`) VALUES
(1, 'Corredor A', 'Prateleira 1', 'Coluna 1', 1, 100, 50),
(2, 'Corredor A', 'Prateleira 2', 'Coluna 1', 1, 100, 30),
(3, 'Corredor B', 'Prateleira 1', 'Coluna 2', 2, 200, 75),
(4, 'Corredor B', 'Prateleira 2', 'Coluna 2', 2, 200, 150),
(5, 'Corredor C', 'Prateleira 1', 'Coluna 3', 3, 150, 20);

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `movimentacao_id` int NOT NULL,
  `produto_id` int DEFAULT NULL,
  `localizacao_origem_id` int DEFAULT NULL,
  `localizacao_destino_id` int DEFAULT NULL,
  `data_movimentacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `operador_id` int DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `quantidade_movimentada` int DEFAULT NULL
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
  `zona` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `quantidade_reservada` int DEFAULT '0',
  `status_produto` varchar(50) DEFAULT 'Disponível',
  `corredor` varchar(50) NOT NULL,
  `prateleira` varchar(50) NOT NULL,
  `nivel` varchar(50) NOT NULL,
  `posicao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`produto_id`, `nome`, `categoria`, `marca`, `peso`, `dimensoes`, `numero_lote`, `numero_serie`, `codigo_barras`, `fornecedor_id`, `data_fabricacao`, `data_validade`, `zona`, `endereco`, `quantidade_reservada`, `status_produto`, `corredor`, `prateleira`, `nivel`, `posicao`) VALUES
(6, '1', NULL, NULL, 1.00, '1', '1', '1', '1', 1, '0111-11-11', '1111-11-11', '1', '1', 1, 'Disponível', '1', '1', '1', '1'),
(8, 'Produto Exemplo', 'Categoria Exemplo', 'Marca Exemplo', 1.00, '10x10x10', 'L123', 'S123', '1234567890123', 1, '2024-01-01', '2025-01-01', 'Zona Exemplo', 'Endereço Exemplo', 0, 'Ativo', 'Corredor 1', 'Prateleira 1', 'Nível 1', 'Posição 1'),
(10, '2', '2', '2', 2.00, '2', '2', '2', '2', 1, '2222-02-22', '2222-02-22', '2', '2', 2, 'Disponível', '', '', '', ''),
(11, '55', '55', '5', 55.00, '5', '5', '5', '5', 1, '5555-05-05', '0555-05-05', '5', '5', 5, 'Disponível', '', '', '', ''),
(12, '55', '55', '5', 55.00, '5', '5', '5', '5', 1, '5555-05-05', '0555-05-05', '5', '5', 5, 'Disponível', '', '', '', ''),
(13, '6', '6', '6', 6.00, '6', '6', '6', '6', 1, '6666-06-06', '6666-06-06', '6', '6', 6, 'Disponível', '', '', '', ''),
(14, '9', '9', '9', 9.00, '9', '9', '9', '9', 1, '9999-09-09', '9999-09-09', '9', '9', 9, 'Disponível', '', '', '', '');

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
  ADD KEY `localizacao_destino_id` (`localizacao_destino_id`);

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
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `estoque_id` int NOT NULL AUTO_INCREMENT;

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
  MODIFY `localizacao_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `movimentacao_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `operador`
--
ALTER TABLE `operador`
  MODIFY `operador_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `produto_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `saida_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

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
