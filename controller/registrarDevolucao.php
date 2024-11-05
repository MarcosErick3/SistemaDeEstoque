<?php
require 'global.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta dos dados do formulário
    $nomeProduto = $_POST['produto_id']; // Supondo que você passe o nome ou ID
    $fornecedorId = intval($_POST['fornecedor_id']); // Garanta que este valor seja um inteiro
    $quantidade = intval($_POST['quantidade']);
    $dataDevolucao = $_POST['data_devolucao'];
    $motivo = $_POST['motivo'];
    $categoria = $_POST['categoria']; // Adicionando a categoria

    try {
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare("SELECT produto_id FROM produto WHERE nome = :nome");
        $stmt->bindParam(':nome', $nomeProduto);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$produto) {
            throw new Exception("Produto não encontrado.");
        }

        $produtoId = $produto['produto_id'];

        // Registrar a devolução
        $sql = "INSERT INTO devolucoes (produto_id, fornecedor_id, quantidade, data_devolucao, motivo, categoria) 
                VALUES (:produto_id, :fornecedor_id, :quantidade, :data_devolucao, :motivo, :categoria)";
        
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
        $stmt->bindParam(':fornecedor_id', $fornecedorId, PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':data_devolucao', $dataDevolucao);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':categoria', $categoria); // Adicionando o bind da categoria
        
        $stmt->execute();
        echo "Devolução registrada com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao registrar devolução: " . $e->getMessage();
    }
}
