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
    $quantidadeReservada = $_POST['quantidade_reservada'];

    // Cria um objeto Produto e define os valores usando setters
    $produto = new Produto();
    $produto->setProdutoId($produtoId);
    $produto->setNome($nome);
    $produto->setCodigoBarras($codigoBarras);
    $produto->setCategoria($categoria);
    $produto->setMarca($marca);
    $produto->setNumeroLote($numeroLote);
    $produto->setNumeroSerie($numeroSerie);
    $produto->setDimensoes($dimensoes);
    $produto->setDataFabricacao($dataFabricacao);
    $produto->setDataValidade($dataValidade);
    $produto->setFornecedorId($fornecedorId);
    $produto->setPeso($peso);
    $produto->setQuantidade_reservada($quantidadeReservada);

    try {
        ProdutoDAO::editarProduto($produto);
        header("Location: ../view/listaProduto.php");
        exit();
    } catch (Exception $e) {
        echo "Erro ao atualizar produto: " . $e->getMessage();
    }
} else {
    echo "Método não permitido.";
}
