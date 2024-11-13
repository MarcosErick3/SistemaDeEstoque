<?php require 'global.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/ExpediçãodeMercadoria.css">
    <link rel="stylesheet" href="../css/footer.css">
    <title>Smart Stock - Sistema de Gestão</title>
    <style>
        /* Estilos para o status de verificado e divergência */
        .status-verificado {
            background-color: #d4edda;
        }

        .status-divergencia {
            background-color: #f8d7da;
        }

        .container {
            padding: 20px;
        }

        .filter input,
        .filter button {
            padding: 8px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
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

    <div class="container">
        <main class="content">
            <section class="Verificacao">
                <h2>Verificação de Mercadorias</h2>
                <div class="filter">
                    <input type="date" id="dataVerificacao" placeholder="Data de Verificação">
                    <input type="text" id="destino" placeholder="Destino">
                    <button id="filterBtn" onclick="filtrarDados()">Filtrar</button>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Número da Movimentação</th>
                            <th>Data da Movimentação</th>
                            <th>Fornecedor</th>
                            <th>Produto</th>
                            <th>Status</th>
                            <th>Destino</th>
                            <th>Marcar como Verificado</th>
                            <th>Notificar Divergência</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php
                        $conexao = Conexao::conectar();

                        $sql = "SELECT 
            p.produto_id AS numero_pedido, 
            p.data_fabricacao AS data_pedido, 
            f.nome AS fornecedor, 
            p.nome AS produto,
            p.status_produto AS status, 
            s.destino 
        FROM 
            produto AS p
        LEFT JOIN 
            fornecedor AS f ON p.fornecedor_id = f.fornecedor_id
        LEFT JOIN 
            produto_localizacao AS lp ON p.produto_id = lp.produto_id
        LEFT JOIN 
            localizacao AS l ON lp.localizacao_id = l.localizacao_id
        LEFT JOIN 
            saida AS s ON p.produto_id = s.produto_id";


                        $result = $conexao->query($sql);

                        if ($result && $result->rowCount() > 0) {
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['numero_pedido']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['data_pedido']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fornecedor']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['produto']) . "</td>";
                                echo "<td class='status-available'>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['destino']) . "</td>";
                                echo "<td><input type='checkbox' class='checkbox' onclick='markVerified(this)'></td>";
                                echo "<td><button class='notifyBtn' onclick='notifyDiscrepancy(this)'>Notificar</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Nenhum produto encontrado</td></tr>";
                        }

                        $conexao = null;
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
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

    <script>
        function markVerified(checkbox) {
            const row = checkbox.closest('tr');
            if (checkbox.checked) {
                row.classList.add('status-verificado');
                row.classList.remove('status-divergencia');
            } else {
                row.classList.remove('status-verificado');
            }
        }

        function notifyDiscrepancy(button) {
            const row = button.closest('tr');
            const produtoId = row.cells[0].innerText; // Número da Movimentação (produto_id)
            const destino = row.cells[5].innerText; // Destino

            // Enviar dados da divergência via AJAX
            fetch('../controller/registrarDivergencia.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `produto_id=${encodeURIComponent(produtoId)}&destino=${encodeURIComponent(destino)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert(data.message);
                        row.classList.add('status-divergencia');
                    } else {
                        alert("Erro ao registrar a divergência: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Erro na solicitação:", error);
                    alert("Erro ao enviar a notificação de divergência.");
                });
        }


        function filtrarDados() {
            const data = document.getElementById('dataVerificacao').value;
            const destino = document.getElementById('destino').value;
            alert(`Filtrando por data: ${data} e destino: ${destino}`);
            // Implementar lógica de filtro conforme necessário
        }
    </script>
</body>

</html>