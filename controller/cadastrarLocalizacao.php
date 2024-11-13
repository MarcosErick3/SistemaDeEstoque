<?php
require 'global.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = $_POST['produto_id']; // ID do produto
    $localizacao_id = $_POST['localizacao_id']; // ID da localização
    $quantidade = $_POST['quantidade']; // Quantidade fornecida pelo usuário

    try {
        $conexao = Conexao::conectar();

        // Registrar o produto na localização
        $sqlInserirProduto = "INSERT INTO produto_localizacao (produto_id, localizacao_id) VALUES (:produto_id, :localizacao_id)";
        $stmt = $conexao->prepare($sqlInserirProduto);
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':localizacao_id', $localizacao_id, PDO::PARAM_INT);
        $stmt->execute();

        // Incrementar a ocupação atual da localização com a quantidade fornecida
        $sqlIncrementarOcupacao = "UPDATE localizacao SET ocupacao_atual = ocupacao_atual + :quantidade WHERE localizacao_id = :localizacao_id";
        $stmtIncrementar = $conexao->prepare($sqlIncrementarOcupacao);
        $stmtIncrementar->bindParam(':quantidade', $quantidade, PDO::PARAM_INT); // Usar a quantidade fornecida
        $stmtIncrementar->bindParam(':localizacao_id', $localizacao_id, PDO::PARAM_INT);
        $stmtIncrementar->execute();

        // Inserir o produto na tabela estoque com localização e a quantidade fornecida
        $sqlInserirEstoque = "INSERT INTO estoque (produto_id, quantidade, localizacao_id, nivel_minimo, nivel_atual, alerta_critico)
                              VALUES (:produto_id, :quantidade, :localizacao_id, 0, :quantidade, 0)";
        $stmtEstoque = $conexao->prepare($sqlInserirEstoque);
        $stmtEstoque->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmtEstoque->bindParam(':quantidade', $quantidade, PDO::PARAM_INT); // Usar a quantidade fornecida
        $stmtEstoque->bindParam(':localizacao_id', $localizacao_id, PDO::PARAM_INT);
        $stmtEstoque->execute();

        echo "Produto armazenado, ocupação atualizada e estoque registrado com sucesso.";
        header("Location: ../view/Armazenamento.php?produto_id=" . urlencode($produto_id));
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    } finally {
        $conexao = null;
    }
} else {
    echo "Método inválido.";
}
