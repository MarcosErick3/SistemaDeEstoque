<?php
require 'global.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta dos dados do formulário
    $produtoId = $_POST['produto_id'];
    $nome = $_POST['nome'];
    $codigoBarras = $_POST['codigo_barras'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $numeroLote = $_POST['numero_lote'];
    $numeroSerie = $_POST['numero_serie'];
    $dimensoes = $_POST['dimensoes'];
    $dataFabricacao = $_POST['data_fabricacao'];
    $dataValidade = $_POST['data_validade'];
    $fornecedorId = $_POST['fornecedor_id'];
    $peso = $_POST['peso'];
    $zona = $_POST['zona'];
    $endereco = $_POST['endereco'];
    $quantidadeReservada = $_POST['quantidade_reservada'];
    $corredor = $_POST['corredor'];
    $prateleira = $_POST['prateleira'];
    $nivel = $_POST['nivel'];
    $posicao = $_POST['posicao'];

    // Cria um objeto Produto
    $produto = new Produto(
        $produtoId,
        $nome,
        $codigoBarras,
        $categoria,
        $marca,
        $numeroLote,
        $numeroSerie,
        $dimensoes,
        $dataFabricacao,
        $dataValidade,
        $fornecedorId,
        $peso,
        $zona,
        $endereco,
        $quantidadeReservada,
        $corredor,
        $prateleira,
        $nivel,
        $posicao
    );

    // Atualiza o produto no banco de dados
    try {
        ProdutoDAO::editarProduto($produto);
        echo "Produto atualizado com sucesso!";
        header("Location: ../view/listaProduto.php");
    } catch (Exception $e) {
        echo "Erro ao atualizar produto: " . $e->getMessage();
    }
} else {
    echo "Método não permitido.";
}
