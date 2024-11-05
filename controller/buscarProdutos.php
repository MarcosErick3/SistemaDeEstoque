<?php
require 'global.php';

if (isset($_GET['fornecedor_id'])) {
    $fornecedorId = $_GET['fornecedor_id'];

    try {
        $query = "SELECT produto_id, nome FROM produtos WHERE fornecedor_id = :fornecedor_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':fornecedor_id', $fornecedorId);
        $stmt->execute();

        // Busca os resultados
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retorna os produtos em formato JSON
        echo json_encode($produtos);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode([]);
}
?>
