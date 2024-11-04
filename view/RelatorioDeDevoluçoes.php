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
        <form action="../controller/registrarDevolucao.php" method="POST">
            <label for="produto">Produto</label>
            <input type="text" name="produto" id="produto" required>

            <label for="fornecedor">Fornecedor</label>
            <input type="text" name="fornecedor" id="fornecedor" required>

            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade" required min="1" step="1">

            <label for="data_solicitacao">Data de Solicitação</label>
            <input type="date" name="data_solicitacao" id="data_solicitacao" required>

            <label for="data_reposicao">Data de Reposição</label>
            <input type="date" name="data_reposicao" id="data_reposicao">

            <label for="status_produto">Status do Produto</label>
            <select name="status_produto" id="status_produto" required>
                <option value="Disponível">Disponível</option>
                <option value="Indisponível">Indisponível</option>
                <option value="Reservado">Reservado</option>
                <option value="Descontinuado">Descontinuado</option>
            </select>

            <button type="submit">Registrar Devolução</button>
        </form>

    </div>

    <div id="report-container">
        <h2>Relatório de Devoluções</h2>
        <table id="report-table">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Transportadora</th>
                    <th>Motivo</th>
                    <th>Data de Devolução</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script src="RelatorioDeDevoluçoes.js"></script>
</body>

</html>