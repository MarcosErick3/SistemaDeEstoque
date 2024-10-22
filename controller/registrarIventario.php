<?php
require_once 'global.php';

$conn = Conexao::conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se os dados foram recebidos corretamente
    var_dump($_POST); // Para depuração, remova depois

    // Extrair os dados do formulário
    $produto_id = $_POST['produto_id'] ?? null;
    $quantidade_fisica = $_POST['quantidade_fisica'] ?? null;
    $localizacao_id = $_POST['localizacao_id'] ?? null;
    $data_inventario = $_POST['data_inventario'] ?? null;
    $operador_id = $_POST['operador_id'] ?? null;

    try {
        // Prepare a SQL query
        $sql = "INSERT INTO inventario (produto_id, quantidade_fisica, localizacao_id, data_inventario, operador_id) 
                VALUES (:produto_id, :quantidade_fisica, :localizacao_id, :data_inventario, :operador_id)";

        $stmt = $conn->prepare($sql);

        // Bind os parâmetros
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantidade_fisica', $quantidade_fisica, PDO::PARAM_INT);
        $stmt->bindParam(':localizacao_id', $localizacao_id, PDO::PARAM_INT);
        $stmt->bindParam(':data_inventario', $data_inventario);
        $stmt->bindParam(':operador_id', $operador_id, PDO::PARAM_INT);

        // Executa a query
        if ($stmt->execute()) {
            $mensagem = "Inventário registrado com sucesso!";
            header("Location: ../view/registrarInventario.php?mensagem=" . urlencode($mensagem));
            exit();
        } else {
            // Capture e mostre erros
            $errorInfo = $stmt->errorInfo();
            echo "Erro na execução da query: " . $errorInfo[2];
        }
    } catch (PDOException $e) {
        echo "<p>Erro: " . $e->getMessage() . "</p>";
    }
}
