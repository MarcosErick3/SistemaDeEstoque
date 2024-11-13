<?php
session_start(); // Certifique-se de que a sessão está iniciada
require 'global.php';
$conexao = Conexao::conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter os dados do formulário
    $produto_id = $_POST['produto_id'];
    $quantidade_solicitada = filter_var($_POST['quantidade'], FILTER_VALIDATE_INT);
    $destino = $_POST['destino'];
    $cliente = $_POST['cliente'];
    $fornecedor_id = $_POST['fornecedor_id'];

    // Verificar se a quantidade solicitada é válida
    if ($quantidade_solicitada === false) {
        $_SESSION['error_message'] = "Quantidade inválida.";
        header("Location: ../view/registrarSaidaProduto.php");
        exit;
    }

    // Consultar a quantidade disponível no estoque para o produto
    $sql = "SELECT e.quantidade FROM estoque e WHERE e.produto_id = :produto_id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
    $stmt->execute();
    $estoque = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($estoque) {
        $quantidade_estoque = $estoque['quantidade'];

        // Verificar se a quantidade solicitada é maior que a disponível
        if ($quantidade_solicitada > $quantidade_estoque) {
            $_SESSION['error_message'] = "A quantidade em estoque é insuficiente. Disponível: $quantidade_estoque";
            header("Location: ../view/registrarSaidaProduto.php");
            exit;
        } else {
            // Registrar a saída no banco de dados
            try {
                $sql = "INSERT INTO saida (produto_id, quantidade, destino, cliente, fornecedor_id, data_saida)
                        VALUES (:produto_id, :quantidade, :destino, :cliente, :fornecedor_id, NOW())";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                $stmt->bindParam(':quantidade', $quantidade_solicitada, PDO::PARAM_INT);
                $stmt->bindParam(':destino', $destino, PDO::PARAM_STR);
                $stmt->bindParam(':cliente', $cliente, PDO::PARAM_STR);
                $stmt->bindParam(':fornecedor_id', $fornecedor_id, PDO::PARAM_INT);
                $stmt->execute();

                // Atualizar a quantidade no estoque
                $nova_quantidade = $quantidade_estoque - $quantidade_solicitada;
                $sql = "UPDATE estoque SET quantidade = :quantidade WHERE produto_id = :produto_id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':quantidade', $nova_quantidade, PDO::PARAM_INT);
                $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                $stmt->execute();

                $_SESSION['success_message'] = "Saída registrada com sucesso!";
                header("Location: ../view/registrarSaidaProduto.php");
                exit;
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Erro ao registrar a saída: " . $e->getMessage();
                header("Location: ../view/registrarSaidaProduto.php");
                exit;
            }
        }
    } else {
        $_SESSION['error_message'] = "Produto não encontrado no estoque.";
        header("Location: ../view/registrarSaidaProduto.php");
        exit;
    }
}
