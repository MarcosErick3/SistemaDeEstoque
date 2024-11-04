<?php
require_once 'global.php';

$conn = Conexao::conectar(); // Obtenha a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = isset($_POST['produto_id']) ? $_POST['produto_id'] : null;
    $quantidade = isset($_POST['quantidade']) ? $_POST['quantidade'] : null;
    $fornecedor_id = isset($_POST['fornecedor_id']) ? $_POST['fornecedor_id'] : null; // ID do fornecedor
    $destino = isset($_POST['destino']) ? $_POST['destino'] : null;
    $cliente = isset($_POST['cliente']) ? $_POST['cliente'] : null; // Capture o cliente

    // Verificar se todos os campos obrigatórios estão preenchidos
    if ($produto_id === null || $quantidade === null || $fornecedor_id === null || $destino === null || $cliente === null) {
        echo "<p>Erro: Todos os campos são obrigatórios.</p>";
        exit;
    }

    try {
        // Prepare a SQL query
        $sql = "INSERT INTO saida (produto_id, quantidade, data_saida, cliente, destino, fornecedor_id) 
                VALUES (:produto_id, :quantidade, NOW(), :cliente, :destino, :fornecedor_id)";

        $stmt = $conn->prepare($sql);

        // Bind os parâmetros
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':fornecedor_id', $fornecedor_id, PDO::PARAM_INT);
        $stmt->bindParam(':destino', $destino);
        $stmt->bindParam(':cliente', $cliente);

        // Executa a query
        $stmt->execute();

        echo "<p>Saída registrada com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p>Erro ao registrar saída: " . $e->getMessage() . "</p>";
    }
}
