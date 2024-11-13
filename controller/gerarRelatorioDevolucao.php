<?php
require "global.php";

$data_inicio = $_GET['data_inicio'] ?? null;
$data_fim = $_GET['data_fim'] ?? null;
$fornecedor_id = $_GET['fornecedor_id'] ?? null;
$produto_id = $_GET['produto_id'] ?? null;
$motivo = $_GET['motivo'] ?? null;

// Constrói a consulta com os filtros aplicados
$query = "SELECT d.produto_id, d.cliente, p.nome AS produto, d.motivo, d.data_devolucao
          FROM devolucoes d
          JOIN produto p ON d.produto_id = p.produto_id
          WHERE 1 = 1"; // Base da consulta

// Adiciona condições ao WHERE conforme os parâmetros recebidos
if ($data_inicio) {
    $query .= " AND d.data_devolucao >= :data_inicio";
}
if ($data_fim) {
    $query .= " AND d.data_devolucao <= :data_fim";
}
if ($fornecedor_id) {
    $query .= " AND p.fornecedor_id = :fornecedor_id";
}
if ($produto_id) {
    $query .= " AND d.produto_id = :produto_id";
}
if ($motivo) {
    $query .= " AND d.motivo = :motivo";
}

$query .= " ORDER BY d.data_devolucao DESC";

// Conecta ao banco e prepara a consulta
$stmt = $conexao->prepare($query);

// Vincula os parâmetros à consulta
if ($data_inicio) {
    $stmt->bindParam(':data_inicio', $data_inicio);
}
if ($data_fim) {
    $stmt->bindParam(':data_fim', $data_fim);
}
if ($fornecedor_id) {
    $stmt->bindParam(':fornecedor_id', $fornecedor_id);
}
if ($produto_id) {
    $stmt->bindParam(':produto_id', $produto_id);
}
if ($motivo) {
    $stmt->bindParam(':motivo', $motivo);
}

// Executa a consulta e exibe os resultados
$stmt->execute();
$resultados = $stmt->fetchAll();

// Exibe a tabela com os resultados
echo "<table>
        <thead>
            <tr>
                <th>Produto ID</th>
                <th>Cliente</th>
                <th>Produto</th>
                <th>Motivo</th>
                <th>Data de Devolução</th>
            </tr>
        </thead>
        <tbody>";

foreach ($resultados as $row) {
    // Formata a data para exibição
    $data_devolucao = new DateTime($row['data_devolucao']);
    echo "<tr>
          <td>" . htmlspecialchars($row['produto_id']) . "</td>
          <td>" . htmlspecialchars($row['cliente']) . "</td>
          <td>" . htmlspecialchars($row['produto']) . "</td>
          <td>" . htmlspecialchars($row['motivo']) . "</td>
          <td>" . $data_devolucao->format('d/m/Y') . "</td>
        </tr>";
}

echo "</tbody>
      </table>";
