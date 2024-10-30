<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel de Ocupação do Armazém</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <style>
        /* Estilos básicos para o layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            color: #444;
            text-align: center;
            font-size: 24px;
        }

        form {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 15px;
        }

        form label {
            font-weight: bold;
            margin-right: 5px;
        }

        form input[type="number"] {
            width: 80px;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            padding: 6px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .alert {
            background-color: #ffe6e6;
            color: #d9534f;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        @media (max-width: 600px) {

            th,
            td {
                font-size: 14px;
            }
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
    <div class="container">
        <h1>Painel de Ocupação do Armazém</h1>
        <form method="GET">
            <label for="nivelCritico">Nível Crítico (%):</label>
            <input type="number" id="nivelCritico" name="nivelCritico" min="0" max="100"
                value="<?php echo isset($_GET['nivelCritico']) ? htmlspecialchars($_GET['nivelCritico']) : 80; ?>">
            <button type="submit">Atualizar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Corredor</th>
                    <th>Prateleira</th>
                    <th>Coluna</th>
                    <th>Andar</th>
                    <th>Ocupação Atual</th>
                    <th>Capacidade Total</th>
                    <th>% Ocupação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'global.php';

                // Define o nível crítico conforme a entrada do usuário ou um valor padrão
                $nivelCritico = isset($_GET['nivelCritico']) ? (int)$_GET['nivelCritico'] : 80;

                try {
                    // Obtenha os dados de ocupação usando a função obterOcupacaoArmazem
                    $dadosOcupacao = LocalizacaoDao::obterOcupacaoArmazem($nivelCritico);

                    // Verifica se existem dados para exibir
                    if (empty($dadosOcupacao)) {
                        echo "<tr><td colspan='7' style='text-align: center;'>Nenhuma localização encontrada com o nível crítico especificado.</td></tr>";
                    } else {
                        // Exibe os dados em cada linha da tabela
                        foreach ($dadosOcupacao as $local) {
                            $percentualOcupacao = number_format($local['percentual_ocupacao'], 2);
                            $alertClass = $percentualOcupacao >= $nivelCritico ? 'alert' : '';

                            echo "<tr class='" . $alertClass . "'>";
                            echo "<td>" . htmlspecialchars($local['corredor']) . "</td>";
                            echo "<td>" . htmlspecialchars($local['prateleira']) . "</td>";
                            echo "<td>" . htmlspecialchars($local['coluna']) . "</td>";
                            echo "<td>" . htmlspecialchars($local['andar']) . "</td>";
                            echo "<td>" . htmlspecialchars($local['ocupacao_atual']) . "</td>";
                            echo "<td>" . htmlspecialchars($local['capacidade_total']) . "</td>";
                            echo "<td>" . $percentualOcupacao . "%</td>";
                            echo "</tr>";
                        }
                    }
                } catch (Exception $e) {
                    echo "<tr><td colspan='7' style='text-align: center;'>Erro ao buscar dados de ocupação: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>