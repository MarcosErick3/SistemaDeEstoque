<?php
require_once "global.php";

class ProdutoDAO
{
    public static function  cadastrar($produto)
    {
        // Conectando ao banco de dados
        $conexao = Conexao::conectar();

        // Verifica se a conexão foi bem-sucedida
        if (!$conexao) {
            throw new Exception("Erro ao conectar ao banco de dados.");
        }

        // Prepara a consulta SQL
        $sql = "INSERT INTO produto (nome, marca, peso, dimensoes, numero_lote, numero_serie, codigo_barras, 
                                      fornecedor_id, data_fabricacao, data_validade, data_recebimento, quantidade_reservada, 
                                      status_produto, categoria) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Usa o objeto de conexão para preparar a declaração
        $stmt = $conexao->prepare($sql);

        // Bind de parâmetros
        $stmt->bindValue(1, $produto->getNome());
        $stmt->bindValue(2, $produto->getMarca());
        $stmt->bindValue(3, $produto->getPeso());
        $stmt->bindValue(4, $produto->getDimensoes());
        $stmt->bindValue(5, $produto->getNumeroLote());
        $stmt->bindValue(6, $produto->getNumeroSerie());
        $stmt->bindValue(7, $produto->getCodigoBarras());
        $stmt->bindValue(8, $produto->getFornecedorId());
        $stmt->bindValue(9, $produto->getDataFabricacao()); // Verifique o formato
        $stmt->bindValue(10, $produto->getDataValidade()); // Verifique o formato
        $stmt->bindValue(11, $produto->getDataRecebimento()); // Verifique o formato
        $stmt->bindValue(12, $produto->getQuantidade_reservada()); // Verifique se este método está correto
        $stmt->bindValue(13, $produto->getStatusProduto());
        $stmt->bindValue(14, $produto->getCategoriaId()); // Corrigido para getCategoria()

        // Executa a declaração
        if (!$stmt->execute()) {
            throw new Exception("Erro ao cadastrar o produto: " . implode(", ", $stmt->errorInfo()));
        }

        // Retorna o ID do produto inserido
        return $conexao->lastInsertId(); // Use lastInsertId() para retornar o ID do novo produto
    }

    public static function editarProduto($produto)
    {
        try {
            $conexao = Conexao::conectar();
            $queryUpdate = "UPDATE produto SET 
                             nome = :nome, categoria = :categoria, marca = :marca, 
                             peso = :peso, dimensoes = :dimensoes, numero_lote = :numero_lote, 
                             numero_serie = :numero_serie, codigo_barras = :codigo_barras, 
                             fornecedor_id = :fornecedor_id, data_fabricacao = :data_fabricacao, 
                             data_validade = :data_validade, quantidade_reservada = :quantidade_reservada 
                             WHERE produto_id = :produto_id";

            $stmt = $conexao->prepare($queryUpdate);

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
            $stmt->bindValue(':quantidade_reservada', $produto->getQuantidade_reservada());
            $stmt->bindValue(':produto_id', $produto->getProdutoId(), PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }


    public static function buscarProduto($query)
    {
        try {
            $conexao = Conexao::conectar();
            $query = "%$query%";
            $stmt = $conexao->prepare("SELECT p.*, f.nome AS fornecedor_nome 
                                        FROM produto p 
                                        LEFT JOIN fornecedor f ON p.fornecedor_id = f.fornecedor_id
                                        WHERE p.nome LIKE :query
                                        LIMIT 10");
            $stmt->bindParam(':query', $query, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar produtos: ' . $e->getMessage());
        }
    }


    public static function atualizarLocalizacao($produto_id, $localizacao_id)
    {
        $conexao = Conexao::conectar();

        // Consulta SQL para atualizar a localização do produto
        $sql = "INSERT INTO estoque (produto_id, localizacao_id) VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE localizacao_id = ?";
        $stmt = $conexao->prepare($sql);

        // Verifica se a preparação da consulta falhou
        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . implode(", ", $conexao->errorInfo()));
        }

        // Execute a declaração com os parâmetros
        $params = [$produto_id, $localizacao_id, $localizacao_id]; // Atualizando apenas o localizacao_id
        $success = $stmt->execute($params);

        if (!$success) {
            throw new Exception("Erro ao atualizar a localização: " . implode(", ", $stmt->errorInfo())); // Converte o erro em uma string
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
                       f.nome AS fornecedor_nome,
                       SUM(e.quantidade) AS quantidade_reservada, 
                       p.data_recebimento  -- Adicionando a coluna data_recebimento
                FROM produto p
                LEFT JOIN produto_localizacao pl ON p.produto_id = pl.produto_id
                LEFT JOIN localizacao l ON pl.localizacao_id = l.localizacao_id
                LEFT JOIN fornecedor f ON p.fornecedor_id = f.fornecedor_id
                LEFT JOIN estoque e ON p.produto_id = e.produto_id
                GROUP BY p.produto_id, l.corredor, l.prateleira, l.coluna, l.andar, f.nome, p.data_recebimento";  // Incluindo data_recebimento no GROUP BY

        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public static function buscarProdutoPorId($codigo)
    {
        try {
            $conexao = Conexao::conectar();
            $querySelect = "
            SELECT p.*, 
                   l.corredor, l.prateleira, l.coluna, l.andar, 
                   f.nome AS fornecedor_nome, 
                   COALESCE(e.quantidade, 0) AS quantidade_estoque
            FROM produto AS p
            LEFT JOIN produto_localizacao AS pl ON p.produto_id = pl.produto_id
            LEFT JOIN localizacao AS l ON pl.localizacao_id = l.localizacao_id
            LEFT JOIN fornecedor AS f ON p.fornecedor_id = f.fornecedor_id
            LEFT JOIN estoque AS e ON p.produto_id = e.produto_id
            WHERE p.produto_id = :produto_id
            ";

            $stmt = $conexao->prepare($querySelect);
            $stmt->bindValue(':produto_id', $codigo, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $produto = $stmt->fetch(PDO::FETCH_ASSOC);
                return $produto;
            } else {
                throw new Exception("Produto não encontrado.");
            }
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar produto por ID: " . $e->getMessage());
        }
    }




    public static function adicionarLocalizacao($produtoId, $localizacaoId)
    {
        $conexao = Conexao::conectar();
        $sql = "INSERT INTO produto_localizacao (produto_id, localizacao_id) VALUES (?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$produtoId, $localizacaoId]);
    }

    public static function excluirProduto($produtoId)
    {
        $conexao = Conexao::conectar();
        try {
            // Iniciar uma transação
            $conexao->beginTransaction();

            // 1. Excluir as devoluções associadas ao produto (antes de excluir o produto)
            $stmt = $conexao->prepare("DELETE FROM devolucoes WHERE produto_id = :produto_id");
            $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
            $stmt->execute();

            // 2. Excluir as movimentações associadas ao produto
            $stmt = $conexao->prepare("DELETE FROM movimentacao WHERE produto_id = :produto_id");
            $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
            $stmt->execute();

            // 3. Excluir as divergências associadas ao produto
            $stmt = $conexao->prepare("DELETE FROM divergencia WHERE produto_id = :produto_id");
            $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
            $stmt->execute();

            // 4. Excluir as saídas associadas ao produto
            $stmt = $conexao->prepare("DELETE FROM saida WHERE produto_id = :produto_id");
            $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
            $stmt->execute();

            // 5. Excluir o estoque do produto
            $stmt = $conexao->prepare("DELETE FROM estoque WHERE produto_id = :produto_id");
            $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
            $stmt->execute();

            // 6. Obter o localizacao_id do produto (caso haja)
            $stmt = $conexao->prepare("SELECT localizacao_id FROM produto_localizacao WHERE produto_id = :produto_id");
            $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
            $stmt->execute();
            $localizacao = $stmt->fetch(PDO::FETCH_ASSOC);

            // 7. Excluir o produto_localizacao (vinculação entre produto e localizacao)
            if ($localizacao) {
                $stmt = $conexao->prepare("DELETE FROM produto_localizacao WHERE produto_id = :produto_id");
                $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
                $stmt->execute();
            }

            // 8. Atualizar a ocupação da localização, diminuindo a quantidade do produto
            if ($localizacao && $localizacao['localizacao_id']) {
                $stmt = $conexao->prepare("UPDATE localizacao 
                                           SET ocupacao_atual = GREATEST(ocupacao_atual - 1, 0) 
                                           WHERE localizacao_id = :localizacao_id");
                $stmt->bindParam(':localizacao_id', $localizacao['localizacao_id'], PDO::PARAM_INT);
                $stmt->execute();
            }

            // 9. Excluir o produto da tabela produto
            $stmt = $conexao->prepare("DELETE FROM produto WHERE produto_id = :produto_id");
            $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
            $stmt->execute();

            // 10. Confirmar a transação
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
                SELECT p.nome, p.quantidade, p.status_produto, l.zona, l.endereco
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

    public static function buscarProdutoPorCodigoBarras($codigoBarras)
    {
        try {
            // Conecta ao banco de dados
            $conexao = Conexao::conectar();

            // Consulta para buscar o produto pelo código de barras
            $sql = "SELECT * FROM produto WHERE codigo_barras = :codigo_barras";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':codigo_barras', $codigoBarras, PDO::PARAM_STR);
            $stmt->execute();

            // Retorna o resultado
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            return $produto ? $produto : null;
        } catch (PDOException $e) {
            echo "Erro ao buscar produto por código de barras: " . $e->getMessage();
            return null;
        } finally {
            // Fecha a conexão
            $conexao = null;
        }
    }
}
