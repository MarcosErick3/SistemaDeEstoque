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

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecione o Local de Armazenamento</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
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
                <li class="nav-item"><a href="Armazenamento.php">Armazenamento</a></li>
                <li class="nav-item"><a href="ExpediçãodeMercadoria.php">Expedição de Mercadoria</a></li>
                <li class="nav-item"><a href="movimentacao.php">Movimentação</a></li>
                <li class="nav-item"><a href="../index.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <nav class="menu" id="menu">
        <h2>Menu</h2>
        <ul>
            <!-- Lista de menus -->
        </ul>
    </nav>

    <div class="container">
        <h1>Selecione o Local de Armazenamento</h1>

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
                                <input type="checkbox" class="select-location" data-id="<?php echo htmlspecialchars($localizacao['localizacao_id']); ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="buttons">
            <button id="btn-cancelar">Cancelar</button>
            <button id="btn-ok">Ok</button>
        </div>
    </div>

    <script>
        document.getElementById('btn-ok').addEventListener('click', function() {
            console.log('Botão Ok clicado'); // Verifica se o botão foi clicado

            const selectedLocations = [];
            const checkboxes = document.querySelectorAll('.select-location:checked');

            checkboxes.forEach((checkbox) => {
                selectedLocations.push(checkbox.getAttribute('data-id'));
            });

            // Verifica se alguma localização foi selecionada
            if (selectedLocations.length > 0) {
                console.log('Localizações selecionadas:', selectedLocations); // Mostra as localizações selecionadas
                fetch('process_selected_locations.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            locations: selectedLocations,
                            produtoId: '<?php echo htmlspecialchars($produtoId); ?>' // Inclua o produtoId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Resposta do servidor:', data); // Veja a resposta do servidor
                        if (data.success) {
                            alert('Localizações processadas com sucesso!');
                            location.reload();
                        } else {
                            alert('Erro ao processar localizações: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erro na requisição:', error);
                    });
            } else {
                alert('Por favor, selecione pelo menos uma localização.');
            }
        });
    </script>
</body>

</html>