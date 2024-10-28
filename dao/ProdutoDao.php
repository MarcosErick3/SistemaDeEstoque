<?php
require_once "global.php";

class ProdutoDAO
{
    public static function cadastrar(Produto $produto)
    {
        try {
            $conexao = Conexao::conectar();

            $queryInsert = "INSERT INTO produto 
                    (nome, categoria, marca, peso, dimensoes, numero_lote, numero_serie, codigo_barras, fornecedor_id, 
                     data_fabricacao, data_validade, quantidade_reservada, status_produto) 
                    VALUES 
                    (:nome, :categoria, :marca, :peso, :dimensoes, :numero_lote, :numero_serie, :codigo_barras, 
                     :fornecedor_id, :data_fabricacao, :data_validade, :quantidade_reservada, 
                     :status_produto)";

            $stmt = $conexao->prepare($queryInsert);

            // Bind dos parâmetros
            $stmt->bindValue(':nome', $produto->getNome());
            $stmt->bindValue(':categoria', $produto->getCategoriaId());
            $stmt->bindValue(':marca', $produto->getMarca());
            $stmt->bindValue(':peso', $produto->getPeso());
            $stmt->bindValue(':dimensoes', $produto->getDimensoes());
            $stmt->bindValue(':numero_lote', $produto->getNumeroLote());
            $stmt->bindValue(':numero_serie', $produto->getNumeroSerie());
            $stmt->bindValue(':codigo_barras', $produto->getCodigoBarras());
            $stmt->bindValue(':fornecedor_id', $produto->getFornecedorId());
            $stmt->bindValue(':data_fabricacao', $produto->getDataFabricacao());
            $stmt->bindValue(':data_validade', $produto->getDataValidade());
            $stmt->bindValue(':quantidade_reservada', $produto->getQuantidadeReservada());
            $stmt->bindValue(':status_produto', $produto->getStatusProduto());

            $stmt->execute();
            return $conexao->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception('Erro ao cadastrar o produto: ' . $e->getMessage());
        }
    }


    public static function atualizarLocalizacao($produto_id, $localizacao_id)
    {
        // Conectar ao banco de dados
        $conexao = Conexao::conectar();

        // Iniciar uma transação
        $conexao->beginTransaction();

        try {
            // Inserir a nova localização do produto na tabela produto_localizacao
            $sql = "INSERT INTO produto_localizacao (produto_id, localizacao_id) VALUES (:produto_id, :localizacao_id)";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->bindParam(':localizacao_id', $localizacao_id, PDO::PARAM_INT);
            $stmt->execute();

            // Atualizar a ocupação atual na tabela localizacao
            $sql = "UPDATE localizacao SET ocupacao_atual = ocupacao_atual + 1 WHERE localizacao_id = :localizacao_id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':localizacao_id', $localizacao_id, PDO::PARAM_INT);
            $stmt->execute();

            // Confirmar a transação
            $conexao->commit();
        } catch (Exception $e) {
            // Reverter a transação em caso de erro
            $conexao->rollBack();
            throw $e; // Relançar a exceção para tratamento posterior
        }
    }


    public static function listarProduto()
    {
        $conexao = Conexao::conectar();
        $sql = "SELECT p.*, 
                    l.corredor, 
                    l.prateleira, 
                    l.coluna, 
                    l.andar, 
                    f.nome AS fornecedor_nome
             FROM produto p
             LEFT JOIN produto_localizacao pl ON p.produto_id = pl.produto_id
             LEFT JOIN localizacao l ON pl.localizacao_id = l.localizacao_id
             LEFT JOIN fornecedor f ON p.fornecedor_id = f.fornecedor_id";

        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function buscarProdutoPorId($codigo)
    {
        try {
            $conexao = Conexao::conectar();
            $querySelect = "SELECT * FROM produto WHERE produto_id = :produto_id";
            $stmt = $conexao->prepare($querySelect);
            $stmt->bindValue(':produto_id', $codigo, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Produto não encontrado.");
            }
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar produto por ID: " . $e->getMessage());
        }
    }


    public static function editarProduto(Produto $produto)
    {
        try {
            $conexao = Conexao::conectar();
            $queryUpdate = "UPDATE produto SET 
                nome = :nome, 
                codigo_barras = :codigo_barras, 
                categoria = :categoria, 
                marca = :marca, 
                numero_lote = :numero_lote, 
                numero_serie = :numero_serie, 
                dimensoes = :dimensoes, 
                data_fabricacao = :data_fabricacao, 
                data_validade = :data_validade, 
                fornecedor_id = :fornecedor_id, 
                peso = :peso, 
                zona = :zona, 
                endereco = :endereco, 
                quantidade_reservada = :quantidade_reservada, 
                corredor = :corredor, 
                prateleira = :prateleira, 
                nivel = :nivel, 
                posicao = :posicao 
                WHERE produto_id = :produto_id";

            $stmt = $conexao->prepare($queryUpdate);
            $stmt->bindValue(':produto_id', $produto->getProdutoId(), PDO::PARAM_INT);
            $stmt->bindValue(':nome', $produto->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(':codigo_barras', $produto->getCodigoBarras(), PDO::PARAM_STR);
            $stmt->bindValue(':categoria', $produto->getCategoriaId(), PDO::PARAM_STR);
            $stmt->bindValue(':marca', $produto->getMarca(), PDO::PARAM_STR);
            $stmt->bindValue(':numero_lote', $produto->getNumeroLote(), PDO::PARAM_STR);
            $stmt->bindValue(':numero_serie', $produto->getNumeroSerie(), PDO::PARAM_STR);
            $stmt->bindValue(':dimensoes', $produto->getDimensoes(), PDO::PARAM_STR);
            $stmt->bindValue(':data_fabricacao', $produto->getDataFabricacao(), PDO::PARAM_STR);
            $stmt->bindValue(':data_validade', $produto->getDataValidade(), PDO::PARAM_STR);
            $stmt->bindValue(':fornecedor_id', $produto->getFornecedorId(), PDO::PARAM_INT);
            $stmt->bindValue(':peso', $produto->getPeso(), PDO::PARAM_STR);
            $stmt->bindValue(':zona', $produto->getZona(), PDO::PARAM_STR);
            $stmt->bindValue(':endereco', $produto->getEndereco(), PDO::PARAM_STR);
            $stmt->bindValue(':quantidade_reservada', $produto->getQuantidadeReservada(), PDO::PARAM_INT);
            $stmt->bindValue(':corredor', $produto->getCorredor(), PDO::PARAM_STR);
            $stmt->bindValue(':prateleira', $produto->getPrateleira(), PDO::PARAM_STR);
            $stmt->bindValue(':nivel', $produto->getNivel(), PDO::PARAM_STR);
            $stmt->bindValue(':posicao', $produto->getPosicao(), PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }

    public static function adicionarLocalizacao($produtoId, $localizacaoId)
    {
        $conexao = Conexao::conectar();
        $sql = "INSERT INTO produto_localizacao (produto_id, localizacao_id) VALUES (?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$produtoId, $localizacaoId]);
    }






    public static function excluirMovimentacaoPorProdutoId($produtoId)
    {
        $conn = Conexao::conectar();
        $stmt = $conn->prepare("DELETE FROM movimentacao WHERE produto_id = ?");
        return $stmt->execute([$produtoId]);
    }

    public static function excluirSaidaPorProdutoId($produtoId)
    {
        $conn = Conexao::conectar();
        $stmt = $conn->prepare("DELETE FROM saida WHERE produto_id = ?");
        return $stmt->execute([$produtoId]);
    }

    public static function excluirInventarioPorProdutoId($produtoId)
    {
        $conn = Conexao::conectar();
        $stmt = $conn->prepare("DELETE FROM inventario WHERE produto_id = ?");
        return $stmt->execute([$produtoId]);
    }

    public static function excluirProduto($produtoId)
    {
        $conexao = Conexao::conectar();
        try {
            // Iniciar uma transação
            $conexao->beginTransaction();

            // Primeiro, exclua os registros relacionados na tabela produto_localizacao
            $stmt = $conexao->prepare("DELETE FROM produto_localizacao WHERE produto_id = :produto_id");
            $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
            $stmt->execute();

            // Agora, exclua o produto
            $stmt = $conexao->prepare("DELETE FROM produto WHERE produto_id = :produto_id");
            $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
            $stmt->execute();

            // Confirma a transação
            $conexao->commit();
            return true;
        } catch (PDOException $e) {
            // Em caso de erro, desfaz a transação
            $conexao->rollBack();
            throw new Exception('Erro ao excluir produto: ' . $e->getMessage());
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
            $stmt->bindValue(':localizacao_id', $localizacao_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna os produtos encontrados na localização
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar produtos por localização: " . $e->getMessage());
        }
    }
}
