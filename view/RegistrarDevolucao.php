<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Stock - Registrar Devolução</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
        main {
            max-width: 800px;
            margin: 40px auto;
            margin-left: 35%;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
<header id="header">
        <nav id="navbar">
            <h1 id="system-name">Smart Stock</h1>
            <ul id="nav">
                <li class="nav-item"><a href="cadastroProduto.php">Cadastro de Produtos</a></li>
                <li class="nav-item"><a href="listaProduto.php">Buscar Produtos</a></li>
                <li class="nav-item"><a href="movimentacao.php">Movimentação</a></li>
                <li class="nav-item"><a href="mapaAmazem.php">Mapa do Armazenamem</a></li>
                <li class="nav-item"><a href="iventario.php">Inventário</a></li>
                <li class="nav-item"><a href="RegistrarDevolucao.php">Registrar Devolução</a></li>
                <li class="nav-item"><a href="RelatorioDeDevoluçoes.php">Relatório de Devoluções</a></li>
                <li class="nav-item"><a href="registrarSaidaProduto.php">Saída do Produto</a></li>
                <li class="nav-item"><a href="../index.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="../controller/registrarDevolucao.php" method="POST">
            <label for="produto_id">Produto</label>
            <select name="produto_id" id="produto_id" required>
                <option value="">Selecione um produto</option>
                <?php
                require 'global.php';

                try {
                    $listaProdutos = ProdutoDAO::listarProduto();
                } catch (Exception $e) {
                    echo '<pre>';
                    print_r($e);
                    echo '</pre>';
                    echo '<p style="color:red;">' . htmlspecialchars($e->getMessage()) . '</p>';
                }
                ?>
                <?php foreach ($listaProdutos as $produto) { ?>
                    <option value="<?php echo htmlspecialchars($produto['produto_id']); ?>">
                        <?php echo htmlspecialchars($produto['nome']); ?>
                    </option>
                <?php } ?>
            </select>
            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria" required>
                <option value="">Selecione uma categoria</option>
                <option value="Eletrônicos">Eletrônicos</option>
                <option value="Vestuário">Vestuário</option>
                <option value="Alimentos">Alimenticios</option>
                <option value="Brinquedos">Brinquedos</option>
            </select>
            <label for="cliente">Cliente</label>
            <input type="text" name="cliente" id="cliente" placeholder="Nome do Cliente" required>
            <label for="quantidade">Quantidade Devolvida</label>
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
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-left">
                <p>&copy; 2024 Smart Stock. Todos os direitos reservados.</p>
            </div>
            <div class="footer-right">
                <a href="https://www.linkedin.com/in/seunome" target="_blank">LinkedIn</a> |
                <a href="https://github.com/seunome" target="_blank">GitHub</a>
            </div>
        </div>
    </footer>
</body>

</html>