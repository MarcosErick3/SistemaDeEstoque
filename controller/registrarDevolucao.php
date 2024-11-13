<?php
require 'global.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta dos dados do formulário
    $produtoId = intval($_POST['produto_id']); // Coleta o produto_id diretamente do formulário
    $cliente = intval($_POST['cliente']); // Certifique-se de que o cliente é válido
    $quantidade = intval($_POST['quantidade']);
    $dataDevolucao = $_POST['data_devolucao'];
    $motivo = $_POST['motivo'];
    $categoria = $_POST['categoria'];

    try {
        // Conexão com o banco de dados
        $conexao = Conexao::conectar();

        // Registrar a devolução
        $sql = "INSERT INTO devolucoes (produto_id, cliente, quantidade, data_devolucao, motivo, categoria) 
                VALUES (:produto_id, :cliente, :quantidade, :data_devolucao, :motivo, :categoria)";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
        $stmt->bindParam(':cliente', $cliente, PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':data_devolucao', $dataDevolucao);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':categoria', $categoria);

        $stmt->execute();
        echo "Devolução registrada com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao registrar devolução: " . $e->getMessage();
    }
}
