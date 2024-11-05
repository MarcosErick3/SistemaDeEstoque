<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Devolução</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <header id="header">
        <nav id="navbar">
            <h1 id="system-name">Smart Stock</h1>
            <ul id="nav">
                <li class="nav-item"><a href="cadastroProduto.php">Cadastro de Produtos</a></li>
                <li class="nav-item"><a href="listaProduto.php">Buscar Produtos</a></li>
                <li class="nav-item"><a href="registrarInventario.php">Registrar Inventário</a></li>
                <li class="nav-item"><a href="registrarSaidaProduto.php">Saída do Produto</a></li>
                <li class="nav-item"><a href="Armazenamento.php">Armazenamento</a></li>
                <li class="nav-item"><a href="ExpediçãodeMercadoria.php">Expedição de Mercadoria</a></li>
                <li class="nav-item"><a href="movimentacao.php">Movimentação</a></li>
                <li class="nav-item"><a href="RegistrarDevolucao.php">Registrar Devolucao</a></li>
                <li class="nav-item"><a href="RelatorioDeDevoluçoes.php">Relatorio De Devoluçoes</a></li>
                <li class="nav-item"><a href="../index.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="../controller/registrarDevolucao.php" method="POST">
            <label for="produto_id">Produto</label>
            <input type="text" name="produto_id" id="produto_id" placeholder="ID ou Nome do Produto" required>
            <label for="categoria">Categoria</label>
            <input type="text" name="categoria" id="categoria" required>
            <label for="fornecedor_id">Fornecedor</label>
            <input type="text" name="fornecedor_id" id="fornecedor_id" placeholder="ID ou Nome do Fornecedor" required>
            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade" min="1" required>
            <label for="data_devolucao">Data da Devolução</label>
            <input type="date" name="data_devolucao" id="data_devolucao" required>
            <label for="motivo">Motivo da Devolução</label>
            <select name="motivo" id="motivo" required>
                <option value="">Selecione o Motivo</option>
                <option value="Danos">Danos</option>
                <option value="Produto incorreto">Produto incorreto</option>
                <option value="Insatisfação">Insatisfação</option>
            </select>
            <button type="submit">Registrar Devolução</button>
        </form>
    </main>
</body>

</html>