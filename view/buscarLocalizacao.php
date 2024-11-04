<?php
require_once 'global.php';

if (isset($_GET['produto_id'])) {
    $produtoId = $_GET['produto_id'];

    $conn = Conexao::conectar();

    try {
        $sql = "SELECT l.localizacao_id, 
                       CONCAT(l.corredor, ' - ', l.prateleira, ' - ', l.coluna, ' - ', l.andar) AS localizacao_nome, 
                       p.quantidade_reservada AS quantidade 
                FROM produto p 
                JOIN produto_localizacao pl ON p.produto_id = pl.produto_id 
                JOIN localizacao l ON pl.localizacao_id = l.localizacao_id 
                WHERE p.produto_id = :produto_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(['localizacao_id' => null, 'quantidade' => 0]);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
