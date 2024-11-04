<?php
require 'global.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = $_POST['produto_id'];
    $destino = $_POST['destino'];
    $descricao = "Divergência notificada para o produto ID $produto_id no destino $destino";

    try {
        $conexao = Conexao::conectar();

        $sql = "INSERT INTO divergencia (produto_id, destino, descricao, status) VALUES (:produto_id, :destino, :descricao, 'Pendente')";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':destino', $destino, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Divergência registrada com sucesso."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao registrar a divergência."]);
        }

        $conexao = null;
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erro de conexão: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método inválido"]);
}
