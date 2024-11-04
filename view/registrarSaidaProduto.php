<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Saída de Produto</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
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
    </style>
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

                // Seleciona o produto, a quantidade reservada e o nome do fornecedor
                $sql = "SELECT p.produto_id, p.nome, p.quantidade_reservada, f.fornecedor_id, f.nome AS fornecedor_nome 
                FROM produto p
                JOIN fornecedor f ON p.fornecedor_id = f.fornecedor_id";
                $stmt = $conexao->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$row['produto_id']}\" 
                   data-quantidade=\"{$row['quantidade_reservada']}\" 
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



    </main>

</body>

</html>