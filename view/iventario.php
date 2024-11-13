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
    <title>Smart Stock - Inventário</title>
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

        .status-available {
            color: green;
        }

        .status-reserved {
            color: orange;
        }

        .status-perishable {
            color: red;
        }

        .quantity-action {
            display: flex;
            gap: 10px;
        }

        .quantity-action input {
            width: 50px;
        }

        .quantity-action button {
            padding: 5px 10px;
        }
<<<<<<< HEAD

        .footer {
            position: fixed;
            bottom: 0;
        }
=======
>>>>>>> 5c7aff2cc7fd4bcddf5e60cca1220966df79c99d
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
                <h2>Inventário de Produtos</h2>
                <div class="filter">
                    <input type="text" id="searchProduct" placeholder="Buscar por nome, código ou localização">
                    <button id="filterBtn" onclick="filtrarDados()">Filtrar</button>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Nome do Produto</th>
                            <th>Código</th>
                            <th>Categoria</th>
                            <th>Localização</th>
                            <th>Quantidade</th>
                            <th>Status</th>
                            <th>Adicionar / Remover</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php
<<<<<<< HEAD
                        // Conectando ao banco de dados
                        $conexao = Conexao::conectar();

                        // Consultando os produtos e suas localizações
                        $sql = "SELECT 
                        p.produto_id AS codigo_produto, 
                        p.nome AS nome_produto, 
                        p.categoria, 
                        IFNULL(l.corredor, 'N/A') AS corredor,
                        IFNULL(l.prateleira, 'N/A') AS prateleira,
                        IFNULL(l.coluna, 'N/A') AS coluna,
                        IFNULL(l.andar, 'N/A') AS andar,
                        IFNULL(SUM(e.quantidade), 0) AS quantidade, 
                        p.status_produto AS status 
                    FROM produto AS p
                    LEFT JOIN produto_localizacao AS lp ON p.produto_id = lp.produto_id
                    LEFT JOIN localizacao AS l ON lp.localizacao_id = l.localizacao_id
                    LEFT JOIN estoque AS e ON p.produto_id = e.produto_id
                    GROUP BY p.produto_id, l.corredor, l.prateleira, l.coluna, l.andar, p.status_produto";
=======
                        $conexao = Conexao::conectar();

                        $sql = "SELECT 
                p.produto_id AS codigo_produto, 
                p.nome AS nome_produto, 
                p.categoria, 
                IFNULL(l.corredor, 'N/A') AS corredor,
                IFNULL(l.prateleira, 'N/A') AS prateleira,
                IFNULL(l.coluna, 'N/A') AS coluna,
                IFNULL(l.andar, 'N/A') AS andar,
                e.quantidade AS quantidade,  
                p.status_produto AS status 
                FROM produto AS p
                LEFT JOIN produto_localizacao AS lp ON p.produto_id = lp.produto_id
                LEFT JOIN localizacao AS l ON lp.localizacao_id = l.localizacao_id
                LEFT JOIN estoque AS e ON p.produto_id = e.produto_id";
>>>>>>> 5c7aff2cc7fd4bcddf5e60cca1220966df79c99d

                        $result = $conexao->query($sql);

                        if ($result && $result->rowCount() > 0) {
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                $statusClass = '';
                                switch ($row['status']) {
                                    case 'disponível':
                                        $statusClass = 'status-available';
                                        break;
                                    case 'reservado':
                                        $statusClass = 'status-reserved';
                                        break;
                                    case 'perecível':
                                        $statusClass = 'status-perishable';
                                        break;
                                }
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['nome_produto']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['codigo_produto']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['categoria']) . "</td>";
                                echo "<td>";
                                echo isset($row['corredor']) ? htmlspecialchars($row['corredor']) : 'N/A';
                                echo isset($row['prateleira']) ? ' ' . htmlspecialchars($row['prateleira']) : '';
                                echo isset($row['coluna']) ? ' ' . htmlspecialchars($row['coluna']) : '';
                                echo isset($row['andar']) ? ' ' . htmlspecialchars($row['andar']) : '';
                                echo "</td>";
<<<<<<< HEAD
                                echo "<td>" . htmlspecialchars($row['quantidade']) . "</td>";
                                echo "<td class='{$statusClass}'>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>
                                <div class='quantity-action'>
                                    <input type='number' class='quantity' value='1'>
                                    <button onclick='updateQuantity(" . $row['codigo_produto'] . ", \"add\")'>Adicionar</button>
                                    <button onclick='updateQuantity(" . $row['codigo_produto'] . ", \"remove\")'>Remover</button>
                                </div>
                            </td>";
=======

                                echo "<td>" . htmlspecialchars($row['quantidade']) . "</td>";
                                echo "<td class='{$statusClass}'>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>
                            <div class='quantity-action'>
                                <input type='number' class='quantity' value='1'>
                                <button onclick='updateQuantity(" . $row['codigo_produto'] . ", \"add\")'>Adicionar</button>
                                <button onclick='updateQuantity(" . $row['codigo_produto'] . ", \"remove\")'>Remover</button>
                            </div>
                          </td>";
>>>>>>> 5c7aff2cc7fd4bcddf5e60cca1220966df79c99d
                                echo "<td><button class='notifyBtn' onclick='notifyDiscrepancy(this)'>Notificar Divergência</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Nenhum produto encontrado</td></tr>";
                        }

<<<<<<< HEAD
                        // Fechando a conexão
=======
>>>>>>> 5c7aff2cc7fd4bcddf5e60cca1220966df79c99d
                        $conexao = null;
                        ?>
                    </tbody>
                </table>
            </section>
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

        <script>
<<<<<<< HEAD
            // Função para filtrar dados na tabela
            function filtrarDados() {
                const searchInput = document.getElementById("searchProduct").value.toLowerCase();
                const tableRows = document.querySelectorAll("#tableBody tr");

                tableRows.forEach(row => {
                    const nomeProduto = row.cells[0].textContent.toLowerCase();
                    const codigoProduto = row.cells[1].textContent.toLowerCase();
                    const categoriaProduto = row.cells[2].textContent.toLowerCase();
                    const localizacaoProduto = row.cells[3].textContent.toLowerCase();

                    if (nomeProduto.includes(searchInput) ||
                        codigoProduto.includes(searchInput) ||
                        categoriaProduto.includes(searchInput) ||
                        localizacaoProduto.includes(searchInput)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            // Função para adicionar ou remover a quantidade
            function updateQuantity(produtoId, action) {
                const quantityInput = event.target.closest('tr').querySelector('.quantity');
                let quantidade = parseInt(quantityInput.value);

                if (action === "add") {
                    quantidade += 1;
                } else if (action === "remove" && quantidade > 0) {
                    quantidade -= 1;
                }

                quantityInput.value = quantidade;
            }

            // Função para notificar divergência
            function notifyDiscrepancy(button) {
                const produtoId = button.closest('tr').querySelector('td').textContent;
                const nomeProduto = button.closest('tr').querySelector('td').nextElementSibling.textContent;

                alert("Produto com ID " + produtoId + " (" + nomeProduto + ") foi marcado para divergência.");
            }
        </script>   
=======
            function updateQuantity(produtoId, action) {
                const quantityInput = document.querySelector(`#quantity_${produtoId}`);
                let currentQuantity = parseInt(quantityInput.value);
                if (action === 'add') {
                    currentQuantity += 1;
                } else if (action === 'remove' && currentQuantity > 0) {
                    currentQuantity -= 1;
                }
                quantityInput.value = currentQuantity;

                // Enviar a atualização da quantidade via AJAX
                fetch('../controller/updateEstoque.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `produto_id=${produtoId}&action=${action}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            alert(data.message);
                        } else {
                            alert("Erro ao atualizar a quantidade.");
                        }
                    })
                    .catch(error => {
                        console.error("Erro na solicitação:", error);
                        alert("Erro ao atualizar a quantidade.");
                    });
            }

            function notifyDiscrepancy(button) {
                const row = button.closest('tr');
                const produtoId = row.cells[1].innerText; // Código do Produto
                const destino = row.cells[3].innerText; // Localização (corrigido para 'destino')

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
                        if (data.status === 'success') {
                            alert("Divergência registrada com sucesso.");
                        } else {
                            alert("Erro ao registrar divergência.");
                        }
                    })
                    .catch(error => {
                        console.error("Erro na solicitação:", error);
                        alert("Erro ao registrar divergência.");
                    });
            }
        </script>
>>>>>>> 5c7aff2cc7fd4bcddf5e60cca1220966df79c99d


</body>

</html>