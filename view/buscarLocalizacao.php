<?php
require 'global.php';

try {
    $conn = Conexao::conectar();

    if (isset($_GET['produto_id']) && !empty($_GET['produto_id'])) {
        $produtoId = $_GET['produto_id'];

        // Consulta para buscar a localização e quantidade do produto no estoque
        $sql = "SELECT l.localizacao_id, CONCAT(l.corredor, ' - ', l.prateleira, ' - ', l.coluna) AS nome, e.quantidade
                FROM localizacao AS l
                INNER JOIN estoque AS e ON l.localizacao_id = e.localizacao_id
                WHERE e.produto_id = :produto_id
                LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados) {
            // Retorna a localização e quantidade do produto em formato JSON
            echo json_encode($dados);
        } else {
            echo json_encode(['localizacao_id' => '', 'nome' => 'Localização não encontrada', 'quantidade' => 0]);
        }
    } else {
        echo json_encode(['erro' => 'Parâmetro produto_id não fornecido']);
    }
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao buscar localização: ' . $e->getMessage()]);
} finally {
    $conn = null; // Fecha a conexão com o banco de dados
}
