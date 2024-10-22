<?php
require_once 'global.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo'])) {

    try {
        // Receber os dados do formulário
        $produto = new Produto();
        $produto->setProdutoId($_POST['codigo']);
        $produto->setNome($_POST['nome']);
        $produto->setDescricao($_POST['descricao']);
        $produto->setCategoria($_POST['categoria']);
        $produto->setMarca($_POST['marca']);    
        $produto->setDimensoes($_POST['dimensoes']);
        $produto->setNumeroLote($_POST['numeroLote']);
        $produto->setNumeroSerie($_POST['numeroSerie']);
        $produto->setCodBarras($_POST['codBarras']);
        $produto->setFornecedorId($_POST['fornecedorId']);
        $produto->setDataFabricacao($_POST['dataFabricacao']);
        $produto->setDataValidade($_POST['dataValidade']);
        $produto->setPrecoCusto($_POST['valorCusto']);
        $produto->setPrecoVenda($_POST['valorVenda']);

        // Chamar o método de edição no ProdutoDao
        ProdutoDao::editarProduto($produto);

        // Redirecionar após o sucesso
        header("Location: ../view/listaProduto.php");
        exit;
    } catch (Exception $e) {
        echo '<pre>';
        print_r($e);
        echo '</pre>';
        echo "Erro ao editar o produto: " . $e->getMessage();
    }
}
