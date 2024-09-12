-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/09/2024 às 06:11
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
-- Banco de dados: `bdsistemaestoque`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int NOT NULL,
  `nomeCliente` varchar(100) DEFAULT NULL,
  `cnpjCliente` varchar(14) DEFAULT NULL,
  `telefoneCliente` varchar(20) DEFAULT NULL,
  `emailCliente` varchar(100) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `ruaCliente` varchar(100) DEFAULT NULL,
  `numRuaCliente` int DEFAULT NULL,
  `compCliente` varchar(50) DEFAULT NULL,
  `bairroCliente` varchar(50) DEFAULT NULL,
  `cepCliente` varchar(10) DEFAULT NULL,
  `cidadeCliente` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `expedição`
--

CREATE TABLE `expedição` (
  `id_expedicao` int NOT NULL,
  `id_pedido` int DEFAULT NULL,
  `data_expedicao` date DEFAULT NULL,
  `status_expedicao` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id_fornecedor` int NOT NULL,
  `nomeFornecedor` varchar(100) DEFAULT NULL,
  `cnpj` char(14) DEFAULT NULL,
  `ruaFornecedor` int DEFAULT NULL,
  `compFornecedor` varchar(50) DEFAULT NULL,
  `bairroFornecedor` varchar(50) DEFAULT NULL,
  `cepFornecedor` char(10) DEFAULT NULL,
  `cidadeFornecedor` varchar(50) DEFAULT NULL,
  `telefoneFornecedor` varchar(20) DEFAULT NULL,
  `emailFornecedor` varchar(100) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor_produto`
--

CREATE TABLE `fornecedor_produto` (
  `idFornecedorProduto` int NOT NULL,
  `id_fornecedor` int DEFAULT NULL,
  `id_produto` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `gestaoestoque`
--

CREATE TABLE `gestaoestoque` (
  `id_gestao` int NOT NULL,
  `id_produto` int DEFAULT NULL,
  `quantidade_atual` int DEFAULT NULL,
  `data_movimentacao` date DEFAULT NULL,
  `tipo_movimentacao` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int NOT NULL,
  `id_cliente` int DEFAULT NULL,
  `data_pedido` date DEFAULT NULL,
  `data_entrega` date DEFAULT NULL,
  `status_pedido` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido_produto`
--

CREATE TABLE `pedido_produto` (
  `idPedidoProduto` int NOT NULL,
  `id_pedido` int DEFAULT NULL,
  `id_produto` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `idProduto` int NOT NULL,
  `nomeProduto` varchar(100) DEFAULT NULL,
  `descricaoProduto` varchar(255) DEFAULT NULL,
  `precoProduto` float DEFAULT NULL,
  `quantidade_estoque` int DEFAULT NULL,
  `data_validade` date DEFAULT NULL,
  `tipo_perecivel` tinyint(1) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `recebimentomercadoria`
--

CREATE TABLE `recebimentomercadoria` (
  `id_recebimento` int NOT NULL,
  `id_fornecedor` int DEFAULT NULL,
  `id_produto` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `data_recebimento` date DEFAULT NULL,
  `qualidade` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices de tabela `expedição`
--
ALTER TABLE `expedição`
  ADD PRIMARY KEY (`id_expedicao`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id_fornecedor`);

--
-- Índices de tabela `fornecedor_produto`
--
ALTER TABLE `fornecedor_produto`
  ADD PRIMARY KEY (`idFornecedorProduto`),
  ADD KEY `id_fornecedor` (`id_fornecedor`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `gestaoestoque`
--
ALTER TABLE `gestaoestoque`
  ADD PRIMARY KEY (`id_gestao`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices de tabela `pedido_produto`
--
ALTER TABLE `pedido_produto`
  ADD PRIMARY KEY (`idPedidoProduto`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`idProduto`);

--
-- Índices de tabela `recebimentomercadoria`
--
ALTER TABLE `recebimentomercadoria`
  ADD PRIMARY KEY (`id_recebimento`),
  ADD KEY `id_fornecedor` (`id_fornecedor`),
  ADD KEY `id_produto` (`id_produto`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `expedição`
--
ALTER TABLE `expedição`
  MODIFY `id_expedicao` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id_fornecedor` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedor_produto`
--
ALTER TABLE `fornecedor_produto`
  MODIFY `idFornecedorProduto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `gestaoestoque`
--
ALTER TABLE `gestaoestoque`
  MODIFY `id_gestao` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedido_produto`
--
ALTER TABLE `pedido_produto`
  MODIFY `idPedidoProduto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `idProduto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `recebimentomercadoria`
--
ALTER TABLE `recebimentomercadoria`
  MODIFY `id_recebimento` int NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `expedição`
--
ALTER TABLE `expedição`
  ADD CONSTRAINT `expedição_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`);

--
-- Restrições para tabelas `fornecedor_produto`
--
ALTER TABLE `fornecedor_produto`
  ADD CONSTRAINT `fornecedor_produto_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`),
  ADD CONSTRAINT `fornecedor_produto_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`idProduto`);

--
-- Restrições para tabelas `gestaoestoque`
--
ALTER TABLE `gestaoestoque`
  ADD CONSTRAINT `gestaoestoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`idProduto`);

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Restrições para tabelas `pedido_produto`
--
ALTER TABLE `pedido_produto`
  ADD CONSTRAINT `pedido_produto_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `pedido_produto_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`idProduto`);

--
-- Restrições para tabelas `recebimentomercadoria`
--
ALTER TABLE `recebimentomercadoria`
  ADD CONSTRAINT `recebimentomercadoria_ibfk_1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id_fornecedor`),
  ADD CONSTRAINT `recebimentomercadoria_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`idProduto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
