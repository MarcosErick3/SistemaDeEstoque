<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Movimentação</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/produto/registrarMovimentacao.css">
</head>

<body>
<header id="header">
        <nav id="navbar">
            <h1 id="system-name">Smart Stock</h1>
            <ul id="nav">
                <li class="nav-item"><a href="cadastroProduto.php">Cadastro de Produtos</a></li>
                <li class="nav-item"><a href="listaProduto.php">Lista de Produtos</a></li>
                <li class="nav-item"><a href="buscarProduto.php">Buscar Produtos</a></li>
                <li class="nav-item"><a href="registrarInventario.php">Registrar Inventário</a></li>
                <li class="nav-item"><a href="registrarSaidaProduto.php">Saída do Produto</a></li>
                <li class="nav-item"><a href="movimentacao.php">Movimentação</a></li>
                <li class="nav-item"><a href="../index.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <form method="POST" action="../controller/registrarMovimentacao.php">
        <label for="produto_id">Produto:</label>
        <select name="produto_id" required>
            <option value="">Selecione um produto</option>
            <?php
            require 'global.php';
            $conn = Conexao::conectar();

            try {
                $sql = "SELECT produto_id, nome FROM produto";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$row['produto_id']}\">{$row['nome']}</option>";
                }
            } catch (PDOException $e) {
                echo "<p>Erro ao buscar produtos: " . $e->getMessage() . "</p>";
            }
            ?>
        </select>

        <label for="localizacao_origem_id">Localização de Origem:</label>
        <select name="localizacao_origem_id" required>
            <option value="">Selecione uma localização</option>
            <?php
            try {
                $sql = "SELECT localizacao_id, CONCAT(corredor, ' - ', prateleira, ' - ', coluna) AS nome FROM localizacao";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$row['localizacao_id']}\">{$row['nome']}</option>";
                }
            } catch (PDOException $e) {
                echo "<p>Erro ao buscar localizações: " . $e->getMessage() . "</p>";
            }
            ?>
        </select>

        <label for="localizacao_destino_id">Localização de Destino:</label>
        <select name="localizacao_destino_id" required>
            <option value="">Selecione uma localização</option>
            <?php
            try {
                $sql = "SELECT localizacao_id, CONCAT(corredor, ' - ', prateleira, ' - ', coluna) AS nome FROM localizacao";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$row['localizacao_id']}\">{$row['nome']}</option>";
                }
            } catch (PDOException $e) {
                echo "<p>Erro ao buscar localizações: " . $e->getMessage() . "</p>";
            }
            ?>
        </select>

        <label for="data_movimentacao">Data:</label>
        <input type="date" name="data_movimentacao" required>

        <label for="motivo">Motivo:</label>
        <input type="text" name="motivo" required>

        <label for="quantidade_movimentada">Quantidade:</label>
        <input type="number" name="quantidade_movimentada" required>

        <button type="submit">Registrar Movimentação</button>
    </form>

    <h2>Movimentações Registradas</h2>
    <?php
    // Exibir as movimentações registradas
    try {
        $sql = "SELECT * FROM movimentacao";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Produto ID</th><th>Localização Origem</th><th>Localização Destino</th><th>Data</th><th>Motivo</th><th>Quantidade</th></tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>{$row['movimentacao_id']}</td>
                    <td>{$row['produto_id']}</td>
                    <td>{$row['localizacao_origem_id']}</td>
                    <td>{$row['localizacao_destino_id']}</td>
                    <td>{$row['data_movimentacao']}</td>
                    <td>{$row['motivo']}</td>
                    <td>{$row['quantidade_movimentada']}</td>
                  </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nenhuma movimentação registrada.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Erro ao buscar movimentações: " . $e->getMessage() . "</p>";
    }
    $conn = null; // Fechar a conexão
    ?>
</body>

</html>