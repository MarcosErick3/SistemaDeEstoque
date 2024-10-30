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
        <h2>Registrar Saída de Produto</h2>
        <p>Para registrar a saída de um produto, selecione o produto desejado, insira a quantidade a ser retirada, escolha o fornecedor e preencha as informações de destino e cliente. Após preencher todos os campos obrigatórios, clique em "Registrar Saída" para salvar as informações.</p>

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
            <input type="number" name="quantidade" required min="1">

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
            <button type="button" class="cancel-button" onclick="window.location.href='listaSaida.php'">Cancelar</button>
        </form>
    </main>

</body>

</html>