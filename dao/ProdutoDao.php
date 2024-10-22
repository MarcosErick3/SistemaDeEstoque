<?php
require_once "global.php";

class ProdutoDAO
{
    public static function cadastrar($produto)
    {
        try {
            $conexao = Conexao::conectar();
            $queryInsert = "INSERT INTO produto (nome, descricao, categoria, marca, peso, dimensoes, numero_lote, numero_serie, codigo_barras, fornecedor_id, data_fabricacao, data_validade, preco_custo, preco_venda, zona, endereco, quantidade_reservada, status_produto) 
                            VALUES (:nome, :descricao, :categoria, :marca, :peso, :dimensoes, :numero_lote, :numero_serie, :codigo_barras, :fornecedor_id, :data_fabricacao, :data_validade, :preco_custo, :preco_venda, :zona, :endereco, :quantidade_reservada, :status_produto)";

            $stmt = $conexao->prepare($queryInsert);

            // Bind dos parâmetros
            $stmt->bindValue(':nome', $produto->getNome());
            $stmt->bindValue(':descricao', $produto->getDescricao());
            $stmt->bindValue(':categoria', $produto->getCategoria());
            $stmt->bindValue(':marca', $produto->getMarca());
            $stmt->bindValue(':peso', $produto->getPeso());
            $stmt->bindValue(':dimensoes', $produto->getDimensoes());
            $stmt->bindValue(':numero_lote', $produto->getNumeroLote());
            $stmt->bindValue(':numero_serie', $produto->getNumeroSerie());
            $stmt->bindValue(':codigo_barras', $produto->getCodBarras());
            $stmt->bindValue(':fornecedor_id', $produto->getFornecedorId());
            $stmt->bindValue(':data_fabricacao', $produto->getDataFabricacao());
            $stmt->bindValue(':data_validade', $produto->getDataValidade());
            $stmt->bindValue(':preco_custo', $produto->getPrecoCusto());
            $stmt->bindValue(':preco_venda', $produto->getPrecoVenda());
            $stmt->bindValue(':zona', $produto->getZona());
            $stmt->bindValue(':endereco', $produto->getEndereco());
            $stmt->bindValue(':quantidade_reservada', $produto->getQuantidadeReservada());
            $stmt->bindValue(':status_produto', $produto->getStatusProduto());

            // Executa a consulta
            $stmt->execute();
            return "Produto cadastrado com sucesso!";
        } catch (PDOException $e) {
            throw new Exception('Erro ao cadastrar o produto: ' . $e->getMessage());
        }
    }

    public static function listarProduto()
    {
        try {
            $conexao = Conexao::conectar();
            $query = "SELECT p.*, f.nome AS fornecedor_nome 
                      FROM produto p 
                      LEFT JOIN fornecedor f ON p.fornecedor_id = f.fornecedor_id";
            $stmt = $conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao listar produtos: ' . $e->getMessage());
        }
    }

    public static function buscarProdutoPorId($codigo)
    {
        try {
            $conexao = Conexao::conectar();
            $querySelect = "SELECT * FROM produto WHERE produto_id = :produto_id";
            $stmt = $conexao->prepare($querySelect);
            $stmt->bindValue(':produto_id', $codigo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar produto por ID: " . $e->getMessage());
        }
    }

    public static function editarProduto($produto)
    {
        try {
            $conexao = Conexao::conectar();
            $queryUpdate = "UPDATE produto SET 
                nome = :nome, 
                descricao = :descricao, 
                categoria = :categoria, 
                marca = :marca, 
                peso = :peso, 
                dimensoes = :dimensoes, 
                numero_lote = :numero_lote, 
                numero_serie = :numero_serie, 
                codigo_barras = :codigo_barras, 
                fornecedor_id = :fornecedor_id, 
                data_fabricacao = :data_fabricacao, 
                data_validade = :data_validade, 
                preco_custo = :preco_custo, 
                preco_venda = :preco_venda, 
                zona = :zona, 
                endereco = :endereco, 
                quantidade_reservada = :quantidade_reservada, 
                status_produto = :status_produto 
                WHERE produto_id = :produto_id";

            $stmt = $conexao->prepare($queryUpdate);

            // Bind dos valores
            $stmt->bindValue(':produto_id', $produto->getProdutoId(), PDO::PARAM_INT);
            $stmt->bindValue(':nome', $produto->getNome());
            $stmt->bindValue(':descricao', $produto->getDescricao());
            $stmt->bindValue(':categoria', $produto->getCategoria());
            $stmt->bindValue(':marca', $produto->getMarca());
            $stmt->bindValue(':peso', $produto->getPeso());
            $stmt->bindValue(':dimensoes', $produto->getDimensoes());
            $stmt->bindValue(':numero_lote', $produto->getNumeroLote());
            $stmt->bindValue(':numero_serie', $produto->getNumeroSerie());
            $stmt->bindValue(':codigo_barras', $produto->getCodBarras());
            $stmt->bindValue(':fornecedor_id', $produto->getFornecedorId());
            $stmt->bindValue(':data_fabricacao', $produto->getDataFabricacao());
            $stmt->bindValue(':data_validade', $produto->getDataValidade());
            $stmt->bindValue(':preco_custo', $produto->getPrecoCusto());
            $stmt->bindValue(':preco_venda', $produto->getPrecoVenda());
            $stmt->bindValue(':zona', $produto->getZona());
            $stmt->bindValue(':endereco', $produto->getEndereco());
            $stmt->bindValue(':quantidade_reservada', $produto->getQuantidadeReservada());
            $stmt->bindValue(':status_produto', $produto->getStatusProduto());

            // Executa a atualização
            $stmt->execute();

            return "Produto atualizado com sucesso.";
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }

    public static function excluirProduto($codigo)
    {
        try {
            $conexao = Conexao::conectar();
            $queryDelete = "DELETE FROM produto WHERE produto_id = :produto_id";
            $stmt = $conexao->prepare($queryDelete);
            $stmt->bindValue(':produto_id', $codigo, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0; // Retorna true se a exclusão foi bem-sucedida
        } catch (PDOException $e) {
            throw new Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }

    public static function pesquisarProdutoPorNome($nomeProduto)
    {
        try {
            $conexao = Conexao::conectar();
            $sql = 'SELECT * FROM produto WHERE nome LIKE :nome';
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':nome', '%' . $nomeProduto . '%');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna os produtos encontrados
        } catch (PDOException $e) {
            throw new Exception("Erro ao pesquisar produtos: " . $e->getMessage());
        }
    }

    public static function buscarProdutoPorLocalizacao($localizacao_id)
    {
        try {
            $conexao = Conexao::conectar();
            $sql = '
                SELECT p.nome, p.quantidade_reservada, p.status_produto, l.zona, l.endereco
                FROM produto p
                INNER JOIN localizacao l ON p.localizacao_id = l.localizacao_id
                WHERE l.localizacao_id = :localizacao_id';
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':localizacao_id', $localizacao_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna os produtos encontrados com as informações de localização
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar produtos por localização: " . $e->getMessage());
        }
    }
}
