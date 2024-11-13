<?php
require_once 'global.php';

if (isset($_GET['produto_id'])) {
    $produtoId = $_GET['produto_id'];

    $conn = Conexao::conectar();

    try {
        // Ajuste da consulta SQL para garantir que a coluna 'quantidade' é referenciada corretamente
        $sql = "SELECT l.localizacao_id, 
                       CONCAT(l.corredor, ' - ', l.prateleira, ' - ', l.coluna, ' - ', l.andar) AS localizacao_nome, 
                       e.quantidade AS quantidade_estoque  -- Alias da coluna 'quantidade'
                FROM produto p
                JOIN estoque e ON p.produto_id = e.produto_id
                JOIN localizacao l ON e.localizacao_id = l.localizacao_id
                WHERE p.produto_id = :produto_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(['localizacao_id' => null, 'quantidade_estoque' => 0]);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
