<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Armazenamento</title>
    <style>
        .container {
            flex-grow: 1;
            margin: 100px auto;
            margin-left: 300px;
            /* Espaço para o menu */
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            text-align: center;
        }

        .map {
            margin: 20px 0;
            display: flex;
            flex-direction: column;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 10px 20px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .corredor {
            font-weight: bold;
            text-align: left;
            background-color: #eee;
        }

        .selected-row {
            background-color: #007BFF;
            color: white;
        }

        .status-disponivel {
            color: green;
            font-weight: bold;
        }

        .status-sobrecarregado {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<?php
require 'global.php'; // Conectar ao banco de dados e carregar classes necessárias

// Obtém as localizações disponíveis do banco de dados
$localizacoes = LocalizacaoDao::ListarLocalizacao();
$produtoId = isset($_GET['produtoId']) ? $_GET['produtoId'] : null; // Obtém o produtoId da URL
?>

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

    <div class="container">
        <h1>Selecione o Local de Armazenamento</h1>

        <form id="form-locacao" action="../controller/cadastrarLocalizacao.php" method="post">
            <!-- Campo oculto para armazenar o ID do produto -->
            <input type="hidden" name="produto_id" value="<?php echo htmlspecialchars($produtoId); ?>">

            <div class="map">
                <h2>Mapa do Armazém</h2>
                <table id="warehouse-map">
                    <thead>
                        <tr>
                            <th>Corredor</th>
                            <th>Prateleira</th>
                            <th>Coluna</th>
                            <th>Andar</th>
                            <th>Capacidade Total</th>
                            <th>Ocupação Atual</th>
                            <th>Status</th>
                            <th>Selecionar</th>
                        </tr>
                    </thead>
                    <tbody id="location-table">
                        <?php foreach ($localizacoes as $localizacao): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($localizacao['corredor']); ?></td>
                                <td><?php echo htmlspecialchars($localizacao['prateleira']); ?></td>
                                <td><?php echo htmlspecialchars($localizacao['coluna']); ?></td>
                                <td><?php echo htmlspecialchars($localizacao['andar']); ?></td>
                                <td><?php echo htmlspecialchars($localizacao['capacidade_total']); ?></td>
                                <td><?php echo htmlspecialchars($localizacao['ocupacao_atual']); ?></td>
                                <td class="<?php echo ($localizacao['ocupacao_atual'] < $localizacao['capacidade_total']) ? 'status-disponivel' : 'status-sobrecarregado'; ?>">
                                    <?php echo ($localizacao['ocupacao_atual'] < $localizacao['capacidade_total']) ? 'Disponível' : 'Sobrecarregado'; ?>
                                </td>
                                <td>
                                    <input type="radio" name="localizacao_id" value="<?php echo htmlspecialchars($localizacao['localizacao_id']); ?>"
                                        data-corredor="<?php echo htmlspecialchars($localizacao['corredor']); ?>"
                                        data-prateleira="<?php echo htmlspecialchars($localizacao['prateleira']); ?>"
                                        data-coluna="<?php echo htmlspecialchars($localizacao['coluna']); ?>"
                                        data-andar="<?php echo htmlspecialchars($localizacao['andar']); ?>"
                                        data-capacidade="<?php echo htmlspecialchars($localizacao['capacidade_total']); ?>"
                                        data-ocupacao="<?php echo htmlspecialchars($localizacao['ocupacao_atual']); ?>"
                                        onchange="updateSelectedLocation(this)" required>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="buttons">
                <button type="button" id="btn-cancelar">Cancelar</button>
                <button type="submit" id="btn-ok">Ok</button>
            </div>
        </form>




        <script>
            function updateSelectedLocation(radio) {
                // Atualizar a lógica para manipular a localização selecionada, se necessário
                console.log("Localização selecionada:", radio.value);
            }
        </script>
    </div>

</body>

</html>