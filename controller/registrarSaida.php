<?php
require_once 'global.php';

$conn = Conexao::conectar(); // Obtenha a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $fornecedor_id = $_POST['fornecedor']; // ID do fornecedor
    $destino = $_POST['destino'];
    $cliente = $_POST['cliente']; // Capture o cliente

    try {
        // Prepare a SQL query
        $sql = "INSERT INTO saida (produto_id, quantidade, data_saida, cliente, destino, fornecedor_id) 
                VALUES (:produto_id, :quantidade, NOW(), :cliente, :destino, :fornecedor_id)";

        $stmt = $conn->prepare($sql);

        // Bind os parâmetros
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':fornecedor_id', $fornecedor_id);
        $stmt->bindParam(':destino', $destino);
        $stmt->bindParam(':cliente', $cliente);

        // Executa a query
        $stmt->execute();

        echo "<p>Saída registrada com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p>Erro: " . $e->getMessage() . "</p>";
    }
}
