<?php
require_once "global.php";

class LocalizacaoDAO
{
    public static function cadastrar(Localizacao $localizacao)
    {
        try {
            $conexao = Conexao::conectar();

            $queryInsert = "INSERT INTO localizacao 
                            (corredor, prateleira, coluna, andar, capacidade_total, ocupacao_atual) 
                            VALUES 
                            (:corredor, :prateleira, :coluna, :andar, :capacidade_total, :ocupacao_atual)";

            $stmt = $conexao->prepare($queryInsert);

            // Bind dos parâmetros
            $stmt->bindValue(':corredor', $localizacao->getCorredor());
            $stmt->bindValue(':prateleira', $localizacao->getPrateleira());
            $stmt->bindValue(':coluna', $localizacao->getColuna());
            $stmt->bindValue(':andar', $localizacao->getAndar());
            $stmt->bindValue(':capacidade_total', $localizacao->getCapacidadeTotal());
            $stmt->bindValue(':ocupacao_atual', $localizacao->getOcupacaoAtual());

            // Executa a consulta
            $stmt->execute();

            return "Localização cadastrada com sucesso!";
        } catch (PDOException $e) {
            throw new Exception('Erro ao cadastrar a localização: ' . $e->getMessage());
        }
    }

    public static function listarLocalizacao()
    {
        try {
            $conexao = Conexao::conectar();
            $query = "SELECT * FROM localizacao";
            $stmt = $conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao listar localizações: ' . $e->getMessage());
        }
    }
    public static function AssociarProdutoLocalizacao($produtoId, $localizacaoId)
    {
        // Conectar ao banco de dados
        $conexao = Conexao::conectar();
        if (!$conexao) {
            return ['success' => false, 'message' => 'Não foi possível conectar ao banco de dados'];
        }

        // Prepara a instrução SQL para inserir a associação
        $sql = "INSERT INTO produto_localizacao (produto_id, localizacao_id) VALUES (:produtoId, :localizacaoId)";

        try {
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':produtoId', $produtoId);
            $stmt->bindParam(':localizacaoId', $localizacaoId);
            $stmt->execute();
            return ['success' => true]; // Retorna verdadeiro se a operação for bem-sucedida
        } catch (PDOException $e) {
            // Log do erro para depuração
            error_log('Erro ao associar produto e localização: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Erro ao associar produto e localização'];
        }
    }


    public static function buscarLocalizacaoPorId($localizacaoId)
    {
        try {
            $conexao = Conexao::conectar();
            $querySelect = "SELECT * FROM localizacao WHERE localizacao_id = :localizacao_id";
            $stmt = $conexao->prepare($querySelect);
            $stmt->bindValue(':localizacao_id', $localizacaoId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar localização por ID: " . $e->getMessage());
        }
    }

    public static function editarLocalizacao(Localizacao $localizacao)
    {
        try {
            $conexao = Conexao::conectar();
            $queryUpdate = "UPDATE localizacao SET 
                corredor = :corredor, 
                prateleira = :prateleira, 
                coluna = :coluna, 
                andar = :andar, 
                capacidade_total = :capacidade_total, 
                ocupacao_atual = :ocupacao_atual 
                WHERE localizacao_id = :localizacao_id";

            $stmt = $conexao->prepare($queryUpdate);
            $stmt->bindValue(':localizacao_id', $localizacao->getLocalizacaoId(), PDO::PARAM_INT);
            $stmt->bindValue(':corredor', $localizacao->getCorredor(), PDO::PARAM_STR);
            $stmt->bindValue(':prateleira', $localizacao->getPrateleira(), PDO::PARAM_STR);
            $stmt->bindValue(':coluna', $localizacao->getColuna(), PDO::PARAM_STR);
            $stmt->bindValue(':andar', $localizacao->getAndar(), PDO::PARAM_INT);
            $stmt->bindValue(':capacidade_total', $localizacao->getCapacidadeTotal(), PDO::PARAM_INT);
            $stmt->bindValue(':ocupacao_atual', $localizacao->getOcupacaoAtual(), PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar localização: " . $e->getMessage());
        }
    }

    public static function excluirLocalizacao($localizacaoId)
    {
        try {
            $conexao = Conexao::conectar();
            $stmt = $conexao->prepare("DELETE FROM localizacao WHERE localizacao_id = :localizacao_id");
            $stmt->bindValue(':localizacao_id', $localizacaoId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao excluir localização: " . $e->getMessage());
        }
    }

    public static function pesquisarLocalizacaoPorCorredor($corredor)
    {
        try {
            $conexao = Conexao::conectar();
            $sql = 'SELECT * FROM localizacao WHERE corredor LIKE :corredor';
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':corredor', '%' . $corredor . '%');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna as localizações encontradas
        } catch (PDOException $e) {
            throw new Exception("Erro ao pesquisar localizações: " . $e->getMessage());
        }
    }

    public static function obterOcupacaoArmazem($nivelCritico)
    {
        try {
            $conexao = Conexao::conectar();
            $sql = "SELECT localizacao_id, corredor, prateleira, coluna, andar, ocupacao_atual, capacidade_total,
                           (ocupacao_atual / capacidade_total * 100) AS percentual_ocupacao
                    FROM localizacao
                    WHERE (ocupacao_atual / capacidade_total * 100) >= :nivel_critico
                    LIMIT 25";

            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':nivel_critico', $nivelCritico, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar ocupação do armazém: ' . $e->getMessage());
        }
    }
}
