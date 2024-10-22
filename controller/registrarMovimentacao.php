<?php
require_once 'global.php';

$conn = Conexao::conectar(); // Obtenha a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = $_POST['produto_id'];
    $data_movimentacao = $_POST['data_movimentacao'];
    $localizacao_origem_id = $_POST['localizacao_origem_id'];
    $localizacao_destino_id = $_POST['localizacao_destino_id'];
    $motivo = $_POST['motivo'];
    $quantidade_movimentada = $_POST['quantidade_movimentada'];

    try {
        // Prepare a SQL query
        $sql = "INSERT INTO movimentacao (produto_id, data_movimentacao, localizacao_origem_id, localizacao_destino_id, motivo, quantidade_movimentada) 
                VALUES (:produto_id, :data_movimentacao, :localizacao_origem_id, :localizacao_destino_id, :motivo, :quantidade_movimentada)";

        $stmt = $conn->prepare($sql);

        // Bind os parâmetros
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':data_movimentacao', $data_movimentacao);
        $stmt->bindParam(':localizacao_origem_id', $localizacao_origem_id, PDO::PARAM_INT);
        $stmt->bindParam(':localizacao_destino_id', $localizacao_destino_id, PDO::PARAM_INT);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':quantidade_movimentada', $quantidade_movimentada, PDO::PARAM_INT);

        // Executa a query
        $stmt->execute();

        echo "<p>Movimentação registrada com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p>Erro: " . $e->getMessage() . "</p>";
    }

    // A conexão será fechada automaticamente ao final do script
}
