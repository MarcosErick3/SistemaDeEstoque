<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Estoque</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        header {
            background-color: #ff6700;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            width: 40px;
            margin-right: 10px;
        }

        .container {
            display: flex;
            flex-direction: row;
            max-width: 1250px;
            /* Limite a largura da página */
        }

        .menu {
            width: 225px;
            background-color: #ff6700;
            color: white;
            position: relative;
            height: 100%;
            padding: 20px;
        }

        .menu h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .menu ul {
            list-style: none;
            padding: 0;
        }

        .menu li {
            padding: 15px 10px;
            cursor: pointer;
            border-bottom: 1px solid #ffa733;
        }

        .menu li:hover {
            background-color: #00aaff;
            color: #ffffff;
        }

        .content {
            flex-grow: 1;
            /* Permite que o conteúdo ocupe o espaço restante */
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="number"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            background-color: #00aaff;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #007acc;
        }

        .report {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: #e9ecef;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo-container">
            <img src="LogoSmartStock.jpeg" alt="Smart Stock Logo">
            <span>Smart Stock</span>
        </div>
    </header>

    <div class="container">
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
        <div class="content">
            <h1>Gestão de Estoque</h1>

            <form id="inventoryForm">
                <input type="text" id="productName" placeholder="Nome do Produto" required>
                <input type="number" id="physicalStock" placeholder="Estoque Físico" required>
                <input type="number" id="registeredStock" placeholder="Estoque Registrado" required>
                <button type="submit">Registrar Inventário</button>
            </form>

            <div class="report" id="report"></div>

            <h2>Histórico de Inventários</h2>
            <table id="inventoryTable">
                <thead>
                    <tr>
                        <th>Nome do Produto</th>
                        <th>Estoque Físico</th>
                        <th>Estoque Registrado</th>
                        <th>Diferença</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'global.php'; // Certifique-se de usar require_once
                    $conexao = Conexao::conectar(); // Conecta ao banco de dados

                    // Consulta para obter os dados dos produtos
                    $sql = "SELECT 
                                p.nome AS produto, 
                                p.quantidade_reservada AS estoque_fisico -- ou utilize o campo correto do seu banco
                            FROM 
                                produto AS p";

                    $result = $conexao->query($sql);

                    if ($result && $result->rowCount() > 0) {
                        // Saída dos dados de cada linha
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $physicalStock = $row['estoque_fisico'];
                            $registeredStock = 0; // Defina conforme necessário, se você tiver esses dados
                            $difference = $physicalStock - $registeredStock;

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['produto']) . "</td>"; // Nome do Produto
                            echo "<td>" . htmlspecialchars($physicalStock) . "</td>"; // Estoque Físico
                            echo "<td>" . htmlspecialchars($registeredStock) . "</td>"; // Estoque Registrado
                            echo "<td>" . htmlspecialchars($difference) . "</td>"; // Diferença
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Nenhum produto encontrado</td></tr>";
                    }

                    // Fecha a conexão
                    $conexao = null; // Para PDO, você pode definir como null para fechar a conexão
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const inventoryForm = document.getElementById('inventoryForm');
        const reportDiv = document.getElementById('report');
        const inventoryTableBody = document.getElementById('inventoryTable').getElementsByTagName('tbody')[0];

        let inventoryHistory = [];

        inventoryForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const productName = document.getElementById('productName').value;
            const physicalStock = parseInt(document.getElementById('physicalStock').value);
            const registeredStock = parseInt(document.getElementById('registeredStock').value);
            const difference = physicalStock - registeredStock;

            // Adicionando ao histórico
            inventoryHistory.push({
                productName,
                physicalStock,
                registeredStock,
                difference
            });

            // Atualizando a tabela
            updateInventoryTable();
            // Gerar relatório
            generateReport();

            // Resetar o formulário
            inventoryForm.reset();
        });

        function updateInventoryTable() {
            // Limpar o corpo da tabela
            inventoryTableBody.innerHTML = '';
            inventoryHistory.forEach(item => {
                const row = inventoryTableBody.insertRow();
                row.insertCell(0).textContent = item.productName;
                row.insertCell(1).textContent = item.physicalStock;
                row.insertCell(2).textContent = item.registeredStock;
                row.insertCell(3).textContent = item.difference;
            });
        }

        function generateReport() {
            const excessProducts = inventoryHistory.filter(item => item.difference < 0);
            const shortageProducts = inventoryHistory.filter(item => item.difference > 0);
            const totalDifference = inventoryHistory.reduce((sum, item) => sum + item.difference, 0);

            reportDiv.innerHTML = `
                <h3>Relatório de Estoque</h3>
                <p>Produtos em excesso: ${excessProducts.length}</p>
                <p>Produtos em falta: ${shortageProducts.length}</p>
                <p>Diferença total no estoque: ${totalDifference}</p>
            `;
        }
    </script>
</body>

</html>