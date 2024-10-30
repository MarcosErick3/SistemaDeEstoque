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
                <!-- Menu de navegação -->
                <li class="nav-item"><a href="cadastroProduto.php">Cadastro de Produtos</a></li>
                <!-- Outros links omitidos para brevidade -->
                <li class="nav-item"><a href="movimentacao.php">Movimentação</a></li>
                <li class="nav-item"><a href="../index.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form method="POST" action="../controller/registrarMovimentacao.php">
            <label for="produto_id">Produto:</label>
            <select name="produto_id" id="produto_id" required onchange="buscarLocalizacaoOrigem()">
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

            <!-- Campo de Localização de Origem -->
            <label for="localizacao_origem_id">Localização de Origem:</label>
            <select name="localizacao_origem_id" id="localizacao_origem_id" required>
                <option value="">Selecione a localização de origem</option>
            </select>

            <!-- Campo de Quantidade Disponível -->
            <label for="quantidade_disponivel">Quantidade Disponível:</label>
            <input type="number" id="quantidade_disponivel" name="quantidade_disponivel" readonly>

            <!-- Campo de Quantidade a Movimentar -->
            <label for="quantidade_movimentada">Quantidade a Movimentar:</label>
            <input type="number" name="quantidade_movimentada" id="quantidade_movimentada" min="1" required placeholder="Insira a quantidade">

            <!-- Campo de Destino e Outros Campos... -->
            <label for="localizacao_destino_id">Localização de Destino:</label>
            <select name="localizacao_destino_id" required>
                <!-- Opções de destino aqui -->
            </select>

            <button type="submit">Registrar Movimentação</button>
        </form>

        <script>
            function buscarLocalizacaoOrigem() {
                const produtoId = document.getElementById('produto_id').value;

                if (produtoId) {
                    fetch(`buscarLocalizacao.php?produto_id=${produtoId}`)
                        .then(response => response.json())
                        .then(data => {
                            const localizacaoOrigemSelect = document.getElementById('localizacao_origem_id');
                            const quantidadeDisponivelInput = document.getElementById('quantidade_disponivel');

                            if (data.localizacao_id) {
                                localizacaoOrigemSelect.innerHTML = `<option value="${data.localizacao_id}">${data.nome}</option>`;
                                quantidadeDisponivelInput.value = data.quantidade;
                            } else {
                                localizacaoOrigemSelect.innerHTML = '<option value="">Localização não encontrada</option>';
                                quantidadeDisponivelInput.value = 0;
                            }
                        })
                        .catch(error => console.error('Erro ao buscar localização:', error));
                }
            }
        </script>
</body>

</html>