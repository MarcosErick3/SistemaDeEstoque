<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios de Devoluções</title>
    <link rel="stylesheet" href="../css/RelatorioDeDevoluçoes.css">
</head>

<body>
    <h1>Relatórios de Devoluções</h1>
    <div id="filters">
        <form action="../controller/gerarRelatorioDevolucao.php" method="GET">
            <label for="data_inicio">Data de Início</label>
            <input type="date" name="data_inicio" id="data_inicio" required>

            <label for="data_fim">Data de Fim</label>
            <input type="date" name="data_fim" id="data_fim" required>

            <label for="fornecedor_id">Fornecedor</label>
            <input type="text" name="fornecedor_id" id="fornecedor_id" placeholder="Nome do Fornecedor">

            <label for="produto_id">Produto</label>
            <select name="produto_id" id="produto_id" required>
                <option value="">Selecione um Produto</option>
            </select>

            <label for="motivo">Motivo da Devolução</label>
            <select name="motivo" id="motivo">
                <option value="">Todos</option>
                <option value="Danos">Danos</option>
                <option value="Produto Incorreto">Produto Incorreto</option>
                <option value="Insatisfação">Insatisfação</option>
                <option value="Outros">Outros</option>
            </select>

            <button type="submit">Gerar Relatório</button>
        </form>
    </div>

    <div id="report-container">
        <h2>Relatório de Devoluções</h2>
        <table id="report-table">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Fornecedor</th>
                    <th>Produto</th>
                    <th>Motivo</th>
                    <th>Data de Devolução</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'global.php'; // Ajuste o caminho conforme necessário

                $conexao = Conexao::conectar(); // Conecta ao banco de dados

                $query = "SELECT f.nome AS fornecedor, p.nome AS produto, d.motivo, d.data_devolucao
              FROM devolucoes d
              JOIN fornecedor f ON d.fornecedor_id = f.fornecedor_id
              JOIN produto p ON d.produto_id = p.produto_id
              ORDER BY d.data_devolucao DESC";

                $stmt = $conexao->prepare($query); // Prepara a consulta
                $stmt->execute(); // Executa a consulta

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch()) {
                        echo "<tr>
                    <td>{$row['fornecedor']}</td>
                    <td>{$row['produto']}</td>
                    <td>{$row['motivo']}</td>
                    <td>{$row['data_devolucao']}</td>
                  </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhuma devolução encontrada.</td></tr>";
                }

                $conexao = null; // Fecha a conexão
                ?>
            </tbody>



        </table>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fornecedorInput = document.getElementById("fornecedor_id");
            const produtoSelect = document.getElementById("produto_id");

            fornecedorInput.addEventListener("change", function() {
                const fornecedorId = this.value;

                // Verifica se o fornecedor ID não está vazio
                if (fornecedorId) {
                    fetch(`../controller/buscarProdutos.php?fornecedor_id=${fornecedorId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Erro na rede ao tentar buscar os produtos.");
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Limpa o select antes de adicionar os novos produtos
                            produtoSelect.innerHTML = "<option value=''>Selecione um Produto</option>";

                            // Adiciona os produtos retornados ao select
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
                    // Se não há fornecedor selecionado, limpa o select de produtos
                    produtoSelect.innerHTML = "<option value=''>Selecione um Produto</option>";
                }
            });
        });
    </script>
</body>

</html>