<?php
require 'global.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar os dados do formulário
    $nome = $_POST['nome'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $peso = $_POST['peso'];
    $dimensoes = $_POST['dimensoes'];
    $numeroLote = $_POST['numero_lote'];
    $numeroSerie = $_POST['numero_serie'];
    $codigoBarras = $_POST['codigo_barras'];
    $fornecedor_id = $_POST['fornecedor_id'];
    $dataFabricacao = $_POST['data_fabricacao'];
    $dataValidade = $_POST['data_validade'];
    $quantidadeReservada = $_POST['quantidade_reservada'];
    $statusProduto = $_POST['status_produto'];

    // Criar uma instância do Produto
    $produto = new Produto();
    $produto->setNome($nome);
    $produto->setCategoria($categoria);
    $produto->setMarca($marca);
    $produto->setPeso($peso);
    $produto->setDimensoes($dimensoes);
    $produto->setNumeroLote($numeroLote);
    $produto->setNumeroSerie($numeroSerie);
    $produto->setCodigoBarras($codigoBarras);
    $produto->setFornecedorId($fornecedor_id);
    $produto->setDataFabricacao($dataFabricacao);
    $produto->setDataValidade($dataValidade);
    $produto->setQuantidadeReservada($quantidadeReservada);
    $produto->setStatusProduto($statusProduto);

    // Chamar o método para inserir o produto
    try {
        $produtoId = ProdutoDAO::cadastrar($produto);

        // Redirecionar para a página de armazenamento passando o produtoId
        header("Location: ../view/Armazenamento.php?produtoId=$produtoId");
        exit();
    } catch (Exception $e) {
        echo '<pre>';
        print_r($e);
        echo '</pre>';
        echo '<p style="color:red;">' . htmlspecialchars($e->getMessage()) . '</p>';
    }
}
