<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Inventário</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/produto/registrarIventario.css">
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
    <form method="POST" action="../controller/registrarIventario.php">
        <label for="produto_id">Produto:</label>
        <select name="produto_id" required>
            <option value="">Selecione um produto</option>
            <?php
            require 'global.php';
            $conn = Conexao::conectar();

            // Buscar produtos
            $sql = "SELECT produto_id, nome FROM produto";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=\"{$row['produto_id']}\">{$row['nome']}</option>";
            }
            ?>
        </select>

        <label for="quantidade_fisica">Quantidade Física:</label>
        <input type="number" name="quantidade_fisica" required>

        <label for="localizacao_id">Localização:</label>
        <select name="localizacao_id" required>
            <option value="">Selecione uma localização</option>
            <?php
            $sql = "SELECT localizacao_id, CONCAT(corredor, ' - ', prateleira) AS localizacao FROM localizacao";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=\"{$row['localizacao_id']}\">{$row['localizacao']}</option>";
            }
            ?>
        </select>

        <label for="data_inventario">Data do Inventário:</label>
        <input type="date" name="data_inventario" required>

        <label for="operador_id">Operador:</label>
        <select name="operador_id" required>
            <option value="">Selecione um operador</option>
            <?php
            // Buscar operadores
            $sql = "SELECT operador_id, nome FROM operador"; // Certifique-se de que a tabela 'operador' existe
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=\"{$row['operador_id']}\">{$row['nome']}</option>";
            }
            ?>
        </select>

        <button type="submit">Registrar Inventário</button>
    </form>

</body>

</html>