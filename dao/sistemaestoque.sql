-- Tabela fornecedor
CREATE TABLE fornecedor (
  fornecedor_id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  telefone VARCHAR(20) DEFAULT NULL,
  email VARCHAR(255) DEFAULT NULL,
  cnpj VARCHAR(20) DEFAULT NULL,
  rua VARCHAR(255) DEFAULT NULL,
  numero VARCHAR(10) DEFAULT NULL,
  complemento VARCHAR(50) DEFAULT NULL,
  bairro VARCHAR(100) DEFAULT NULL,
  cidade VARCHAR(100) DEFAULT NULL,
  estado VARCHAR(50) DEFAULT NULL,
  cep VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (fornecedor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Tabela localizacao
CREATE TABLE localizacao (
  localizacao_id INT NOT NULL AUTO_INCREMENT,
  corredor VARCHAR(50) DEFAULT NULL,
  prateleira VARCHAR(50) DEFAULT NULL,
  coluna VARCHAR(50) DEFAULT NULL,
  andar INT DEFAULT NULL,
  capacidade_total INT DEFAULT NULL,
  ocupacao_atual INT DEFAULT 0,
  PRIMARY KEY (localizacao_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Tabela produto
CREATE TABLE produto (
  produto_id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  descricao TEXT,
  categoria VARCHAR(100) DEFAULT NULL,
  marca VARCHAR(100) DEFAULT NULL,
  peso DECIMAL(10,2) DEFAULT NULL,
  dimensoes VARCHAR(100) DEFAULT NULL,
  numero_lote VARCHAR(50) DEFAULT NULL,
  numero_serie VARCHAR(50) DEFAULT NULL,
  codigo_barras VARCHAR(50) DEFAULT NULL,
  fornecedor_id INT DEFAULT NULL,
  data_fabricacao DATE DEFAULT NULL,
  data_validade DATE DEFAULT NULL,
  preco_custo DECIMAL(10,2) DEFAULT NULL,
  preco_venda DECIMAL(10,2) DEFAULT NULL,
  zona VARCHAR(100) DEFAULT NULL,
  endereco VARCHAR(255) DEFAULT NULL,
  quantidade_reservada INT DEFAULT 0,
  status_produto VARCHAR(50) DEFAULT 'Disponível',
  PRIMARY KEY (produto_id),
  FOREIGN KEY (fornecedor_id) REFERENCES fornecedor(fornecedor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci; 

-- Tabela estoque
CREATE TABLE estoque (
  estoque_id INT NOT NULL AUTO_INCREMENT,
  produto_id INT DEFAULT NULL,
  quantidade INT DEFAULT NULL,
  localizacao_id INT DEFAULT NULL,
  nivel_minimo INT DEFAULT NULL,
  nivel_atual INT DEFAULT NULL,
  alerta_critico BOOLEAN DEFAULT FALSE,
  PRIMARY KEY (estoque_id),
  FOREIGN KEY (produto_id) REFERENCES produto(produto_id),
  FOREIGN KEY (localizacao_id) REFERENCES localizacao(localizacao_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Tabela movimentacao
CREATE TABLE movimentacao (
  movimentacao_id INT NOT NULL AUTO_INCREMENT,
  produto_id INT DEFAULT NULL,
  localizacao_origem_id INT DEFAULT NULL,
  localizacao_destino_id INT DEFAULT NULL,
  data_movimentacao DATETIME DEFAULT CURRENT_TIMESTAMP,
  operador_id INT DEFAULT NULL,
  motivo VARCHAR(255) DEFAULT NULL,
  quantidade_movimentada INT DEFAULT NULL,
  PRIMARY KEY (movimentacao_id),
  FOREIGN KEY (produto_id) REFERENCES produto(produto_id),
  FOREIGN KEY (localizacao_origem_id) REFERENCES localizacao(localizacao_id),
  FOREIGN KEY (localizacao_destino_id) REFERENCES localizacao(localizacao_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Tabela recebimento
CREATE TABLE recebimento (
  recebimento_id INT NOT NULL AUTO_INCREMENT,
  produto_id INT DEFAULT NULL,
  quantidade_recebida INT DEFAULT NULL,
  data_recebimento DATE DEFAULT NULL,
  nota_fiscal VARCHAR(100) DEFAULT NULL,
  operador_id INT DEFAULT NULL,
  PRIMARY KEY (recebimento_id),
  FOREIGN KEY (produto_id) REFERENCES produto(produto_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Tabela inventario
CREATE TABLE inventario (
  inventario_id INT NOT NULL AUTO_INCREMENT,
  produto_id INT DEFAULT NULL,
  quantidade_fisica INT DEFAULT NULL,
  localizacao_id INT DEFAULT NULL,
  data_inventario DATE DEFAULT NULL,
  operador_id INT DEFAULT NULL,
  divergencia INT DEFAULT 0,
  PRIMARY KEY (inventario_id),
  FOREIGN KEY (produto_id) REFERENCES produto(produto_id),
  FOREIGN KEY (localizacao_id) REFERENCES localizacao(localizacao_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Tabela reposicao
CREATE TABLE reposicao (
  reposicao_id INT NOT NULL AUTO_INCREMENT,
  produto_id INT DEFAULT NULL,
  quantidade INT DEFAULT NULL,
  data_solicitacao DATE DEFAULT NULL,
  data_reposicao DATE DEFAULT NULL,
  status VARCHAR(50) DEFAULT 'Pendente',
  fornecedor_id INT DEFAULT NULL,
  PRIMARY KEY (reposicao_id),
  FOREIGN KEY (produto_id) REFERENCES produto(produto_id),
  FOREIGN KEY (fornecedor_id) REFERENCES fornecedor(fornecedor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Trigger para calcular divergencia antes da inserção
DELIMITER //

CREATE TRIGGER calcular_divergencia
BEFORE INSERT ON inventario
FOR EACH ROW
BEGIN
  DECLARE quantidade_estoque INT;

  SELECT quantidade INTO quantidade_estoque
  FROM estoque
  WHERE produto_id = NEW.produto_id AND localizacao_id = NEW.localizacao_id;

  SET NEW.divergencia = NEW.quantidade_fisica - IFNULL(quantidade_estoque, 0);
END;
//

DELIMITER ;
