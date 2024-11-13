<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Stock - Registrar Saída de Produto</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/produto/registrarSaidaProduto.css">
    <style>
        /* Estilo para mensagens de sucesso ou erro */
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            color: white;
            text-align: center;
            /* Centraliza o texto das mensagens */
        }

        .success {
            background-color: green;
        }

        .error {
            background-color: red;
        }

        /* Estilo do botão de cancelar */
        .cancel-button {
            background-color: gray;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            margin-top: 10px;
            /* Margem superior para espaçamento */
        }

        .footer {
            position: fixed;
            bottom: 0;
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
        <!-- Exibir mensagens de sucesso ou erro -->
        <?php
        session_start(); // Certifique-se de que a sessão está iniciada
        if (isset($_SESSION['success_message'])) {
            echo "<div class='message success'>{$_SESSION['success_message']}</div>";
            unset($_SESSION['success_message']); // Limpa a mensagem após exibi-la
        }
        if (isset($_SESSION['error_message'])) {
            echo "<div class='message error'>{$_SESSION['error_message']}</div>";
            unset($_SESSION['error_message']); // Limpa a mensagem após exibi-la
        }
        ?>

        <form method="POST" action="../controller/registrarSaida.php">
            <label for="produto_id">Produto:</label>
            <select name="produto_id" id="produto_id" required onchange="atualizarQuantidadeFornecedor(this)">
                <option value="">Selecione um produto</option>
                <?php
                require 'global.php';
                $conexao = Conexao::conectar();

                // Seleciona o produto, a quantidade disponível no estoque e o nome do fornecedor
                $sql = "
    SELECT 
        p.produto_id, 
        p.nome, 
        IFNULL(SUM(e.quantidade), 0) AS quantidade_estoque,  -- Soma de todas as quantidades associadas ao produto
        f.fornecedor_id, 
        f.nome AS fornecedor_nome 
    FROM produto p
    JOIN estoque e ON p.produto_id = e.produto_id
    JOIN fornecedor f ON p.fornecedor_id = f.fornecedor_id
    GROUP BY p.produto_id, p.nome, f.fornecedor_id, f.nome  -- Garante que não haverá duplicação
";

                $stmt = $conexao->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$row['produto_id']}\" 
                    data-quantidade=\"{$row['quantidade_estoque']}\" 
                    data-fornecedor-id=\"{$row['fornecedor_id']}\" 
                    data-fornecedor-nome=\"{$row['fornecedor_nome']}\">{$row['nome']}</option>";
                }
                ?>
            </select>

            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" required min="1" value="">

            <input type="hidden" id="fornecedor_id" name="fornecedor_id">

            <label for="destino">Destino:</label>
            <input type="text" name="destino" required>

            <label for="cliente">Cliente:</label>
            <input type="text" name="cliente" required>

            <button type="submit">Registrar Saída</button>
            <button type="button" class="cancel-button" onclick="window.location.href='listaSaida.php'">Cancelar</button>
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
    <script>
        function atualizarQuantidadeFornecedor(produtoSelect) {
            // Obtem os valores dos atributos data
            const quantidade = produtoSelect.selectedOptions[0].getAttribute("data-quantidade");
            const fornecedorId = produtoSelect.selectedOptions[0].getAttribute("data-fornecedor-id");
            const fornecedorNome = produtoSelect.selectedOptions[0].getAttribute("data-fornecedor-nome");

            // Atualiza os campos de quantidade e fornecedor
            document.getElementById("quantidade").value = quantidade || "";
            document.getElementById("fornecedor_id").value = fornecedorId || "";
        }
    </script>
</body>

</html>