<?php
require 'global.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação dos dados recebidos
    if (isset($_POST['produto_id'], $_POST['destino']) && is_numeric($_POST['produto_id']) && !empty($_POST['destino'])) {
        $produto_id = $_POST['produto_id'];
        $destino = trim($_POST['destino']);
        $descricao = "Divergência notificada para o produto ID $produto_id no destino $destino";

        try {
            // Conexão com o banco de dados
            $conexao = Conexao::conectar();

            // Inserção no banco
            $sql = "INSERT INTO divergencia (produto_id, destino, descricao, status) VALUES (:produto_id, :destino, :descricao, 'Pendente')";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->bindParam(':destino', $destino, PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);

            // Execução da query e resposta
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Divergência registrada com sucesso."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Erro ao registrar a divergência."]);
            }

            $conexao = null;
        } catch (PDOException $e) {
            // Erro na conexão com o banco
            echo json_encode(["status" => "error", "message" => "Erro de conexão: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Dados inválidos ou incompletos."]);
    }
} else {
    // Caso o método não seja POST
    echo json_encode(["status" => "error", "message" => "Método inválido"]);
}
