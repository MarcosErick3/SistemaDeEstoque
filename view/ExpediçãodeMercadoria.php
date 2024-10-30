<!DOCTYPE html>
<html lang="pt-br">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/header.css">
<link rel="stylesheet" href="../css/index.css">

<head>
    <title>Smart Stock - Sistema de Gestão</title>
    <style>
        .content {
            flex-grow: 1;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .filter {
            margin-bottom: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            background-color: #00aaff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #007acc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .Verificacao input[type="checkbox"] {
            transform: scale(1.5);
            cursor: pointer;
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
        <main class="content">
            <section class="Expedição">
                <h2>Expedição de Produtos</h2>
                <div class="filter">
                    <input type="text" placeholder="Número do Pedido">
                    <input type="date">
                    <select>
                        <option>Todos</option>
                        <option>Pendente</option>
                        <option>Em Rota de Entrega</option>
                        <option>Entregue</option>
                    </select>
                    <button>Pesquisar</button>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Número da Movimentação</th>
                            <th>Data da Movimentação</th>
                            <th>Fornecedor</th>
                            <th>Produto</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'global.php';
                        $conexao = Conexao::conectar(); // Conecta ao banco de dados

                        // Consulta para obter os dados necessários da tabela produto
                        $sql = "SELECT 
                p.produto_id AS numero_pedido, 
                p.data_fabricacao AS data_pedido, 
                f.nome AS cliente, 
                p.nome AS produto, 
                p.status_produto AS status 
            FROM 
                produto AS p 
            LEFT JOIN 
                fornecedor AS f ON p.fornecedor_id = f.fornecedor_id"; // Ajuste conforme necessário

                        $result = $conexao->query($sql);

                        if ($result && $result->rowCount() > 0) {
                            // Saída dos dados de cada linha
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['numero_pedido']) . "</td>"; // Número do Pedido (produto_id)
                                echo "<td>" . htmlspecialchars($row['data_pedido']) . "</td>"; // Data do Pedido (data_fabricacao)
                                echo "<td>" . htmlspecialchars($row['cliente']) . "</td>"; // Cliente
                                echo "<td>" . htmlspecialchars($row['produto']) . "</td>"; // Produto
                                echo "<td>" . htmlspecialchars($row['status']) . "</td>"; // Status do Produto
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Nenhum produto encontrado</td></tr>";
                        }

                        // Fecha a conexão
                        $conexao = null; // Para PDO, você pode definir como null para fechar a conexão
                        ?>
                    </tbody>


                </table>
            </section>

            <section class="Verificacao">
                <h2>Verificação de Mercadorias</h2>
                <table id="Mercadorias">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade Reservada</th>
                            <th>Destino</th>
                            <th>Verificada</th>
                            <th>Divergências</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conexao = Conexao::conectar(); // Conecta ao banco de dados

                        // Consulta para obter os dados dos produtos
                        $sql = "SELECT 
                        p.nome AS produto, 
                        p.quantidade_reservada AS quantidade_reservada, 
                        p.zona AS destino  -- Aqui você pode ajustar o campo de destino, se necessário
                    FROM 
                        produto AS p"; // Use a tabela correta

                        $result = $conexao->query($sql);

                        if ($result && $result->rowCount() > 0) {
                            // Saída dos dados de cada linha
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['produto']) . "</td>"; // Nome do Produto
                                echo "<td>" . htmlspecialchars($row['quantidade_reservada']) . "</td>"; // Quantidade Reservada
                                echo "<td>" . htmlspecialchars($row['destino']) . "</td>"; // Destino
                                echo "<td><input type='checkbox' class='Verificada'></td>"; // Checkbox para verificada
                                echo "<td><input type='checkbox' class='Divergencia'></td>"; // Checkbox para divergências
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Nenhum produto encontrado</td></tr>";
                        }

                        // Fecha a conexão
                        $conexao = null; // Para PDO, você pode definir como null para fechar a conexão
                        ?>
                    </tbody>
                </table>
                <button id="submitBtn" type="button">Enviar</button>
            </section>

        </main>

    </div>


</body>

</html>