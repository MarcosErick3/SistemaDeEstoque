<?php
require_once "global.php";

class ProdutoDAO
{
    public static function cadastrar($produto)
    {
        try {
            $conexao = Conexao::conectar();
            $queryInsert = "INSERT INTO produto (nome, descricao, categoria, marca, peso, dimensoes, numero_lote, numero_serie, codigo_barras, fornecedor_id, data_fabricacao, data_validade, preco_custo, preco_venda) 
                        VALUES (:nome, :descricao, :categoria, :marca, :peso, :dimensoes, :numero_lote, :numero_serie, :codigo_barras, :fornecedor_id, :data_fabricacao, :data_validade, :preco_custo, :preco_venda)";

            $stmt = $conexao->prepare($queryInsert);

            // Aqui está o mapeamento dos parâmetros
            $stmt->bindValue(':nome', $produto->getNome());
            $stmt->bindValue(':descricao', $produto->getDescricao());
            $stmt->bindValue(':categoria', $produto->getCategoria());
            $stmt->bindValue(':marca', $produto->getMarca());
            $stmt->bindValue(':peso', $produto->getPeso());
            $stmt->bindValue(':dimensoes', $produto->getDimensoes());
            $stmt->bindValue(':numero_lote', $produto->getNumeroLote());
            $stmt->bindValue(':numero_serie', $produto->getNumeroSerie());
            $stmt->bindValue(':codigo_barras', $produto->getCodBarras());
            $stmt->bindValue(':fornecedor_id', $produto->getFornecedorId()); // Certifique-se de que este método existe
            $stmt->bindValue(':data_fabricacao', $produto->getDataFabricacao());
            $stmt->bindValue(':data_validade', $produto->getDataValidade());
            $stmt->bindValue(':preco_custo', $produto->getPrecoCusto());
            $stmt->bindValue(':preco_venda', $produto->getPrecoVenda());

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
            $query = "SELECT * FROM produto"; // Ajuste conforme necessário
            $stmt = $conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao listar produtos: " . $e->getMessage());
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
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);
            return $produto;
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
            codigo_barras = :codBarras, 
            preco_venda = :valorVenda, 
            preco_custo = :valorCusto, 
            dimensoes = :dimensoes, 
            numero_lote = :numeroLote, 
            numero_serie = :numeroSerie, 
            data_fabricacao = :dataFabricacao, 
            data_validade = :dataValidade, 
            fornecedor_id = :fornecedorId 
            WHERE produto_id = :codigo";

            $stmt = $conexao->prepare($queryUpdate);

            // Bind dos valores
            $stmt->bindValue(':codigo', $produto->getCodigo(), PDO::PARAM_INT);
            $stmt->bindValue(':nome', $produto->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(':descricao', $produto->getDescricao(), PDO::PARAM_STR);
            $stmt->bindValue(':categoria', $produto->getCategoria(), PDO::PARAM_STR);
            $stmt->bindValue(':marca', $produto->getMarca(), PDO::PARAM_STR);
            $stmt->bindValue(':codBarras', $produto->getCodBarras(), PDO::PARAM_STR);
            $stmt->bindValue(':valorVenda', $produto->getPrecoVenda(), PDO::PARAM_STR);
            $stmt->bindValue(':valorCusto', $produto->getPrecoCusto(), PDO::PARAM_STR);
            $stmt->bindValue(':dimensoes', $produto->getDimensoes(), PDO::PARAM_STR);
            $stmt->bindValue(':numeroLote', $produto->getNumeroLote(), PDO::PARAM_STR);
            $stmt->bindValue(':numeroSerie', $produto->getNumeroSerie(), PDO::PARAM_STR);
            $stmt->bindValue(':dataFabricacao', $produto->getDataFabricacao(), PDO::PARAM_STR);
            $stmt->bindValue(':dataValidade', $produto->getDataValidade(), PDO::PARAM_STR);
            $stmt->bindValue(':fornecedorId', $produto->getFornecedorId(), PDO::PARAM_INT);

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

            // Retorna true se a exclusão foi bem-sucedida, caso contrário, false
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Lança uma exceção com uma mensagem mais detalhada
            throw new Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }
}
