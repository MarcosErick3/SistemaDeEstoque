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
        // Iniciando transação
        $conn->beginTransaction();

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

        if ($stmt->execute()) {
            echo "<p>Movimentação registrada com sucesso!</p>";
        } else {
            throw new Exception("Falha ao registrar movimentação na tabela.");
        }

        // Verificar se existe o produto na localizacao de origem
        $sqlOrigemCheck = "SELECT quantidade FROM estoque WHERE produto_id = :produto_id AND localizacao_id = :localizacao_origem_id";
        $stmt = $conn->prepare($sqlOrigemCheck);
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':localizacao_origem_id', $localizacao_origem_id, PDO::PARAM_INT);
        $stmt->execute();

        $origem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($origem) {
            // Atualizar a quantidade no estoque - decrementando na origem
            $sqlOrigem = "UPDATE estoque SET quantidade = quantidade - :quantidade_movimentada 
                          WHERE produto_id = :produto_id AND localizacao_id = :localizacao_origem_id";
            $stmt = $conn->prepare($sqlOrigem);
            $stmt->bindParam(':quantidade_movimentada', $quantidade_movimentada, PDO::PARAM_INT);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->bindParam(':localizacao_origem_id', $localizacao_origem_id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            throw new Exception("Produto não encontrado na localização de origem.");
        }

        // Verificar se existe o produto na localizacao de destino
        $sqlDestinoCheck = "SELECT quantidade FROM estoque WHERE produto_id = :produto_id AND localizacao_id = :localizacao_destino_id";
        $stmt = $conn->prepare($sqlDestinoCheck);
        $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':localizacao_destino_id', $localizacao_destino_id, PDO::PARAM_INT);
        $stmt->execute();

        $destino = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($destino) {
            // Atualizar a quantidade no estoque - incrementando no destino
            $sqlDestino = "UPDATE estoque SET quantidade = quantidade + :quantidade_movimentada 
                           WHERE produto_id = :produto_id AND localizacao_id = :localizacao_destino_id";
            $stmt = $conn->prepare($sqlDestino);
            $stmt->bindParam(':quantidade_movimentada', $quantidade_movimentada, PDO::PARAM_INT);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->bindParam(':localizacao_destino_id', $localizacao_destino_id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            // Caso não exista, inserir a nova quantidade na localização de destino
            $sqlDestinoInsert = "INSERT INTO estoque (produto_id, localizacao_id, quantidade) 
                                 VALUES (:produto_id, :localizacao_destino_id, :quantidade_movimentada)";
            $stmt = $conn->prepare($sqlDestinoInsert);
            $stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt->bindParam(':localizacao_destino_id', $localizacao_destino_id, PDO::PARAM_INT);
            $stmt->bindParam(':quantidade_movimentada', $quantidade_movimentada, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Commitar a transação
        $conn->commit();
        header("Location: ../view/movimentacao.php");
    } catch (Exception $e) {
        // Caso algum erro ocorra, fazer rollback da transação
        $conn->rollBack();
        echo "<p>Erro: " . $e->getMessage() . "</p>";
    }
}
