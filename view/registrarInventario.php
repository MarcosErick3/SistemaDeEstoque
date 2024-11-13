<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Inventário</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/produto/registrarIventario.css">
    <link rel="stylesheet" href="../css/footer.css">
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

        <form method="POST" action="../controller/registrarInventario.php">
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

            <label for="quantidade_fisica">Quantidade Física:</label>
            <input type="number" name="quantidade_fisica" min="1" required placeholder="Ex: 10">

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
                $sql = "SELECT operador_id, nome FROM operador";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$row['operador_id']}\">{$row['nome']}</option>";
                }
                ?>
            </select>

            <button type="submit">Registrar Inventário</button>
            <button type="button" class="cancel-button" onclick="window.location.href='listaInventario.php'">Cancelar</button>
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