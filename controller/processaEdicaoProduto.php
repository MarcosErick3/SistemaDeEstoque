<?php
require_once 'global.php';

try {
    // Verifica se o ID do produto foi enviado no POST
    if (!isset($_POST['codigo'])) {
        throw new Exception("ID do produto não fornecido.");
    }

    // Obtém o ID do produto
    $produtoId = $_POST['codigo'];

    // Crie um objeto Produto e defina seus atributos com os dados do formulário
    $produtoObj = new Produto();
    $produtoObj->setProdutoId($produtoId);
    $produtoObj->setNome($_POST['nome']);
    $produtoObj->setDescricao($_POST['descricao']);
    $produtoObj->setCategoria($_POST['categoria']);
    $produtoObj->setMarca($_POST['marca']);
    $produtoObj->setPeso($_POST['peso']);
    $produtoObj->setDimensoes($_POST['dimensoes']);
    $produtoObj->setNumeroLote($_POST['numeroLote']);
    $produtoObj->setNumeroSerie($_POST['numeroSerie']);
    $produtoObj->setCodBarras($_POST['codBarras']);
    $produtoObj->setFornecedorId($_POST['fornecedorId']);
    $produtoObj->setDataFabricacao($_POST['dataFabricacao']);
    $produtoObj->setDataValidade($_POST['dataValidade']);
    $produtoObj->setPrecoCusto($_POST['valorCusto']);
    $produtoObj->setPrecoVenda($_POST['valorVenda']);
    $produtoObj->setZona($_POST['zona']);
    $produtoObj->setEndereco($_POST['endereco']);
    $produtoObj->setQuantidadeReservada($_POST['quantidadeReservada']);
    $produtoObj->setStatusProduto($_POST['statusProduto']);

    // Chama o método de edição do ProdutoDao
    $mensagem = ProdutoDao::editarProduto($produtoObj);

    // Redireciona ou exibe mensagem de sucesso
    header("Location: ../view/listaProduto.php?mensagem=" . urlencode($mensagem));
    exit();
} catch (Exception $e) {
    echo 'Erro ao editar o produto: ' . htmlspecialchars($e->getMessage());
}
