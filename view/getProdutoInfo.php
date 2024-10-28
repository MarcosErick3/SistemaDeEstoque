<?php
// Inclua o arquivo de conexão ao banco de dados
require 'global.php'; // Ajuste o caminho conforme necessário

// Verifique se o ID do produto foi passado como parâmetro
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Conecte ao banco de dados
        $conn = Conexao::conectar();

        // Prepare a consulta SQL para buscar o produto pelo ID
        $query = "SELECT p.*, 
                          l.corredor, 
                          l.prateleira, 
                          l.coluna, 
                          l.andar, 
                          f.nome AS fornecedor_nome 
                  FROM produto p 
                  LEFT JOIN produto_localizacao pl ON p.produto_id = pl.produto_id 
                  LEFT JOIN localizacao l ON pl.localizacao_id = l.localizacao_id 
                  JOIN fornecedor f ON p.fornecedor_id = f.fornecedor_id 
                  WHERE p.produto_id = :id";

        // Prepare o statement
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Verifique se o produto foi encontrado
        if ($stmt->rowCount() > 0) {
            // Converta o resultado para um array associativo
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);
            // Retorne os dados do produto como JSON
            echo json_encode($produto);
        } else {
            // Retorne um array vazio se o produto não for encontrado
            echo json_encode([]);
        }
    } catch (PDOException $e) {
        // Em caso de erro, retorne uma mensagem de erro
        echo json_encode(['error' => 'Erro na conexão: ' . $e->getMessage()]);
    }
} else {
    // Se o ID não foi passado, retorne um erro
    echo json_encode(['error' => 'ID do produto não fornecido.']);
}
