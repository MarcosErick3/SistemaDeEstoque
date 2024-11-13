<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Relatórios de devoluções - Smart Stock">
    <title>Smart Stock - Relatórios de Devoluções</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/RelatorioDeDevoluçoes.css">
    <style>
        .footer {
            position: fixed;
            bottom: 0;
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
        require 'global.php';

        // Conexão com o banco
        $conexao = Conexao::conectar();

        // Receber parâmetros do formulário
        $data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
        $data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';
        $fornecedor_id = isset($_GET['fornecedor_id']) ? $_GET['fornecedor_id'] : '';
        $produto_id = isset($_GET['produto_id']) ? $_GET['produto_id'] : '';
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : '';

        // Montar a consulta para as devoluções com base nos filtros selecionados
        $queryDevolucoes = "SELECT d.produto_id, d.cliente, p.nome AS produto, f.nome AS fornecedor, d.motivo, d.data_devolucao
                        FROM devolucoes d
                        JOIN produto p ON d.produto_id = p.produto_id
                        JOIN fornecedor f ON p.fornecedor_id = f.fornecedor_id
                        WHERE 1=1"; // Sempre verdadeiro, útil para adicionar filtros dinamicamente

        // Adicionar filtros dinâmicos
        if (!empty($data_inicio)) {
            $queryDevolucoes .= " AND d.data_devolucao >= :data_inicio";
        }
        if (!empty($data_fim)) {
            $queryDevolucoes .= " AND d.data_devolucao <= :data_fim";
        }
        if (!empty($fornecedor_id)) {
            $queryDevolucoes .= " AND p.fornecedor_id = :fornecedor_id";
        }
        if (!empty($produto_id)) {
            $queryDevolucoes .= " AND d.produto_id = :produto_id";
        }
        if (!empty($motivo)) {
            $queryDevolucoes .= " AND d.motivo = :motivo";
        }

        $queryDevolucoes .= " ORDER BY d.data_devolucao DESC";

        // Preparar a consulta
        $stmtDevolucoes = $conexao->prepare($queryDevolucoes);

        // Vincular os parâmetros, se existirem
        if (!empty($data_inicio)) {
            $stmtDevolucoes->bindParam(':data_inicio', $data_inicio);
        }
        if (!empty($data_fim)) {
            $stmtDevolucoes->bindParam(':data_fim', $data_fim);
        }
        if (!empty($fornecedor_id)) {
            $stmtDevolucoes->bindParam(':fornecedor_id', $fornecedor_id, PDO::PARAM_INT);
        }
        if (!empty($produto_id)) {
            $stmtDevolucoes->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        }
        if (!empty($motivo)) {
            $stmtDevolucoes->bindParam(':motivo', $motivo);
        }

        // Executar a consulta de devoluções
        $stmtDevolucoes->execute();

        // Consultas para preencher as opções de produtos e fornecedores
        $produtosQuery = "SELECT DISTINCT p.produto_id, p.nome FROM devolucoes d
                      JOIN produto p ON d.produto_id = p.produto_id
                      ORDER BY p.nome ASC";
        $produtosStmt = $conexao->prepare($produtosQuery);
        $produtosStmt->execute();

        $fornecedoresQuery = "SELECT fornecedor_id, nome FROM fornecedor ORDER BY nome ASC";
        $fornecedoresStmt = $conexao->prepare($fornecedoresQuery);
        $fornecedoresStmt->execute();
        ?>

        <div id="filters">
            <form action="" method="GET">
                <label for="data_inicio">Data de Início:</label>
                <input type="date" name="data_inicio" id="data_inicio" value="<?= htmlspecialchars($data_inicio) ?>">

                <label for="data_fim">Data de Fim:</label>
                <input type="date" name="data_fim" id="data_fim" value="<?= htmlspecialchars($data_fim) ?>">

                <label for="fornecedor_id">Fornecedor:</label>
                <select name="fornecedor_id" id="fornecedor_id">
                    <option value="">Selecione um Fornecedor</option>
                    <?php
                    if ($fornecedoresStmt->rowCount() > 0) {
                        while ($fornecedor = $fornecedoresStmt->fetch()) {
                            $selected = ($fornecedor['fornecedor_id'] == $fornecedor_id) ? 'selected' : '';
                            echo "<option value='{$fornecedor['fornecedor_id']}' $selected>{$fornecedor['nome']}</option>";
                        }
                    }
                    ?>
                </select>

                <label for="produto_id">Produto:</label>
                <select name="produto_id" id="produto_id">
                    <option value="">Selecione um Produto</option>
                    <?php
                    if ($produtosStmt->rowCount() > 0) {
                        while ($produto = $produtosStmt->fetch()) {
                            $selected = ($produto['produto_id'] == $produto_id) ? 'selected' : '';
                            echo "<option value='{$produto['produto_id']}' $selected>{$produto['nome']}</option>";
                        }
                    }
                    ?>
                </select>

                <label for="motivo">Motivo da Devolução:</label>
                <select name="motivo" id="motivo">
                    <option value="">Todos</option>
                    <option value="Danos" <?= ($motivo == 'Danos') ? 'selected' : '' ?>>Danos</option>
                    <option value="Produto Incorreto" <?= ($motivo == 'Produto Incorreto') ? 'selected' : '' ?>>Produto Incorreto</option>
                    <option value="Insatisfação" <?= ($motivo == 'Insatisfação') ? 'selected' : '' ?>>Insatisfação</option>
                    <option value="Outros" <?= ($motivo == 'Outros') ? 'selected' : '' ?>>Outros</option>
                </select>

                <button type="submit">Gerar Relatório</button>
            </form>
        </div>

        <div id="report-container">
            <h2>Relatório de Devoluções</h2>
            <table id="report-table">
                <thead>
                    <tr>
                        <th>Produto ID</th>
                        <th>Cliente</th>
                        <th>Produto</th>
                        <th>Fornecedor</th>
                        <th>Motivo</th>
                        <th>Data de Devolução</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($stmtDevolucoes->rowCount() > 0) {
                        while ($row = $stmtDevolucoes->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                    <td>" . htmlspecialchars($row['produto_id']) . "</td>
                    <td>" . htmlspecialchars($row['cliente']) . "</td>
                    <td>" . htmlspecialchars($row['produto']) . "</td>
                    <td>" . htmlspecialchars($row['fornecedor']) . "</td>
                    <td>" . htmlspecialchars($row['motivo']) . "</td>
                    <td>" . htmlspecialchars($row['data_devolucao']) . "</td>
                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Nenhuma devolução encontrada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>

        <?php $conexao = null; // Encerrando conexão 
        ?>
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
        document.addEventListener("DOMContentLoaded", function() {
            const fornecedorInput = document.getElementById("fornecedor_id");
            const produtoSelect = document.getElementById("produto_id");

            fornecedorInput.addEventListener("input", function() {
                const fornecedorId = this.value.trim();
                if (fornecedorId) {
                    fetch(`../controller/buscarProdutos.php?fornecedor_id=${encodeURIComponent(fornecedorId)}`)
                        .then(response => response.ok ? response.json() : Promise.reject('Erro na resposta da rede.'))
                        .then(data => {
                            produtoSelect.innerHTML = "<option value=''>Selecione um Produto</option>";
                            data.forEach(produto => {
                                const option = document.createElement("option");
                                option.value = produto.produto_id;
                                option.textContent = produto.nome;
                                produtoSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error("Erro ao buscar produtos:", error);
                            alert("Não foi possível carregar os produtos. Tente novamente mais tarde.");
                        });
                } else {
                    produtoSelect.innerHTML = "<option value=''>Selecione um Produto</option>";
                }
            });
        });
    </script>
</body>

</html>