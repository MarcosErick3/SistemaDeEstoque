<?php
require_once 'global.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        !empty($_POST['nome']) && !empty($_POST['descricao']) &&
        !empty($_POST['categoria']) && !empty($_POST['marca']) &&
        !empty($_POST['peso']) && is_numeric($_POST['peso']) &&
        !empty($_POST['dimensoes']) && !empty($_POST['numeroLote']) &&
        !empty($_POST['numeroSerie']) && !empty($_POST['codBarras']) &&
        !empty($_POST['fornecedorNome']) && // Nome do fornecedor em vez do ID
        !empty($_POST['dataFabricacao']) && !empty($_POST['dataValidade']) &&
        !empty($_POST['precoCusto']) && is_numeric($_POST['precoCusto']) &&
        !empty($_POST['precoVenda']) && is_numeric($_POST['precoVenda'])
    ) {
        $fornecedorNome = $_POST['fornecedorNome'];
        $fornecedor = FornecedorDao::buscarFornecedorPorNome($fornecedorNome);

        if ($fornecedor) {
            $fornecedorId = $fornecedor['fornecedor_id']; 

            $produto = new Produto();
            $produto->setNome($_POST['nome']);
            $produto->setDescricao($_POST['descricao']);
            $produto->setCategoria($_POST['categoria']);
            $produto->setMarca($_POST['marca']);
            $produto->setPeso($_POST['peso']);
            $produto->setDimensoes($_POST['dimensoes']);
            $produto->setNumeroLote($_POST['numeroLote']);
            $produto->setNumeroSerie($_POST['numeroSerie']);
            $produto->setCodBarras($_POST['codBarras']);
            $produto->setFornecedorId($fornecedorId);
            $produto->setDataFabricacao($_POST['dataFabricacao']);
            $produto->setDataValidade($_POST['dataValidade']);
            $produto->setPrecoCusto($_POST['precoCusto']);
            $produto->setPrecoVenda($_POST['precoVenda']);

            $mensagem = ProdutoDao::cadastrar($produto);

            header("Location: ../view/cadastroProduto.php?mensagem=" . urlencode($mensagem));
            exit();
        } else {
            echo "Fornecedor não encontrado. Por favor, verifique o nome.";
        }
    } else {
        echo "Por favor, preencha todos os campos obrigatórios corretamente!";
    }
}
