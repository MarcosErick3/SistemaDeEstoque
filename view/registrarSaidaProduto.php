<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Saída de Produto</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css//produto/registrarSaidaProduto.css">
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
    <form method="POST" action="../controller/registrarSaida.php">
        <label for="produto_id">Produto:</label>
        <select name="produto_id" required>
            <option value="">Selecione um produto</option>
            <?php
            require 'global.php';
            $conn = Conexao::conectar();

            $sql = "SELECT produto_id, nome FROM produto";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=\"{$row['produto_id']}\">{$row['nome']}</option>";
            }
            ?>
        </select>

        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" required>

        <label for="fornecedor">Fornecedor:</label>
        <select name="fornecedor" required>
            <option value="">Selecione um fornecedor</option>
            <?php
            $sql = "SELECT fornecedor_id, nome FROM fornecedor";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=\"{$row['fornecedor_id']}\">{$row['nome']}</option>";
            }
            ?>
        </select>

        <label for="destino">Destino:</label>
        <input type="text" name="destino" required>

        <label for="cliente">Cliente:</label>
        <input type="text" name="cliente" required>

        <button type="submit">Registrar Saída</button>
    </form>
</body>

</html>