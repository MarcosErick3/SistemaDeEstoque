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
        <form method="POST" action="../controller/registrarMovimentacao.php">

            <label for="operador_id">Operador:</label>
            <input type="text" name="operador_id" id="operador_id" required placeholder="Insira o ID do operador">

            <label for="produto_id">Produto:</label>
            <select name="produto_id" id="produto_id" required onchange="buscarLocalizacaoQuantidade()">
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
                    echo "<p>Erro ao buscar produtos: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
                ?>
            </select>

            <label for="localizacao_origem_id">Localização de Origem:</label>
            <select name="localizacao_origem_id" id="localizacao_origem_id" required>
                <option value="">Selecione a localização de origem</option>
            </select>

            <label for="quantidade_disponivel">Quantidade Disponível:</label>
            <input type="number" id="quantidade_disponivel" name="quantidade_disponivel" readonly>

            <label for="quantidade_movimentada">Quantidade a Movimentar:</label>
            <input type="number" name="quantidade_movimentada" id="quantidade_movimentada" min="1" required placeholder="Insira a quantidade">

            <label for="motivo">Motivo:</label>
            <input type="text" name="motivo" id="motivo" required placeholder="Insira o motivo da movimentação">

            <label for="data_movimentacao">Data da Movimentação:</label>
            <input type="date" name="data_movimentacao" id="data_movimentacao" required>

            <label for="localizacao_destino_id">Localização de Destino:</label>
            <select name="localizacao_destino_id" required>
                <option value="">Selecione a localização de destino</option>
                <?php
                try {
                    $sql = "SELECT localizacao_id, CONCAT(corredor, ' - ', prateleira, ' - ', coluna, ' - ', andar) AS nome FROM localizacao";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value=\"{$row['localizacao_id']}\">{$row['nome']}</option>";
                    }
                } catch (PDOException $e) {
                    echo "<p>Erro ao buscar localizações de destino: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
                ?>
            </select>

            <button type="submit">Registrar Movimentação</button>
        </form>

        <script>
            function buscarLocalizacaoQuantidade() {
                const produtoId = document.getElementById('produto_id').value;

                if (produtoId) {
                    fetch(`buscarLocalizacao.php?produto_id=${produtoId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erro ao buscar localização: ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            const localizacaoOrigemSelect = document.getElementById('localizacao_origem_id');
                            const quantidadeDisponivelInput = document.getElementById('quantidade_disponivel');

                            localizacaoOrigemSelect.innerHTML = '';

                            if (data.localizacao_id) {
                                localizacaoOrigemSelect.innerHTML = `<option value="${data.localizacao_id}">${data.localizacao_nome}</option>`;
                                quantidadeDisponivelInput.value = data.quantidade; // Captura a quantidade do produto
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