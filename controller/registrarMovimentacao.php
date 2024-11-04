<?php
require_once 'global.php';

$conn = Conexao::conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = (int)$_POST['produto_id'];
    $data_movimentacao = $_POST['data_movimentacao'];
    $localizacao_origem_id = (int)$_POST['localizacao_origem_id'];
    $localizacao_destino_id = (int)$_POST['localizacao_destino_id'];
    $motivo = $_POST['motivo'];
    $quantidade_movimentada = (int)$_POST['quantidade_movimentada'];
    $operador_id = isset($_POST['operador_id']) ? (int)$_POST['operador_id'] : null;

    try {
        // Inserir movimentação
        $sql = "INSERT INTO movimentacao (produto_id, data_movimentacao, localizacao_origem_id, localizacao_destino_id, motivo, quantidade_movimentada, operador_id) 
                VALUES (:produto_id, :data_movimentacao, :localizacao_origem_id, :localizacao_destino_id, :motivo, :quantidade_movimentada, :operador_id)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':data_movimentacao', $data_movimentacao);
        $stmt->bindParam(':localizacao_origem_id', $localizacao_origem_id, PDO::PARAM_INT);
        $stmt->bindParam(':localizacao_destino_id', $localizacao_destino_id, PDO::PARAM_INT);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':quantidade_movimentada', $quantidade_movimentada, PDO::PARAM_INT);
        $stmt->bindParam(':operador_id', $operador_id, PDO::PARAM_INT);

        $stmt->execute();

        echo "<p>Movimentação registrada com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p>Erro: " . $e->getMessage() . "</p>";
    }
}
