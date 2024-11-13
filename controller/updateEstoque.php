<?php
// Conectar com o banco de dados
require '../global.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $action = $_POST['action'];

    if (is_numeric($produto_id) && is_numeric($quantidade)) {
        try {
            $conexao = Conexao::conectar();

            // Ação de adicionar ou remover
            if ($action === 'add') {
                $sql = "UPDATE estoque SET quantidade = quantidade + :quantidade WHERE produto_id = :produto_id";
            } else if ($action === 'remove') {
                $sql = "UPDATE estoque SET quantidade = quantidade - :quantidade WHERE produto_id = :produto_id AND quantidade >= :quantidade";
            } else {
                throw new Exception("Ação inválida.");
            }

            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Quantidade atualizada com sucesso']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar a quantidade']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Dados inválidos']);
    }
}
