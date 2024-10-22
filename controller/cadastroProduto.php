<?php
require_once 'global.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        !empty($_POST['nome']) &&
        !empty($_POST['descricao']) &&
        !empty($_POST['categoria']) &&
        !empty($_POST['marca']) &&
        !empty($_POST['peso']) && is_numeric($_POST['peso']) &&
        !empty($_POST['dimensoes']) &&
        !empty($_POST['numero_lote']) &&
        !empty($_POST['numero_serie']) &&
        !empty($_POST['codigo_barras']) && // Corrigido o nome do campo
        !empty($_POST['fornecedor_id']) &&
        !empty($_POST['data_fabricacao']) &&
        !empty($_POST['data_validade']) &&
        !empty($_POST['preco_custo']) && is_numeric($_POST['preco_custo']) &&
        !empty($_POST['preco_venda']) && is_numeric($_POST['preco_venda']) &&
        !empty($_POST['zona']) && // Adicionado
        !empty($_POST['endereco']) && // Adicionado
        !empty($_POST['quantidade_reservada']) && is_numeric($_POST['quantidade_reservada']) // Adicionado
    ) {
        $fornecedorId = $_POST['fornecedor_id'];

        // Criação do produto
        $produto = new Produto();
        $produto->setNome($_POST['nome']);
        $produto->setDescricao($_POST['descricao']);
        $produto->setCategoria($_POST['categoria']);
        $produto->setMarca($_POST['marca']);
        $produto->setPeso($_POST['peso']);
        $produto->setDimensoes($_POST['dimensoes']);
        $produto->setNumeroLote($_POST['numero_lote']);
        $produto->setNumeroSerie($_POST['numero_serie']);
        $produto->setCodBarras($_POST['codigo_barras']); // Corrigido o nome do campo
        $produto->setFornecedorId($fornecedorId);
        $produto->setDataFabricacao($_POST['data_fabricacao']);
        $produto->setDataValidade($_POST['data_validade']);
        $produto->setPrecoCusto($_POST['preco_custo']);
        $produto->setPrecoVenda($_POST['preco_venda']);
        $produto->setZona($_POST['zona']); // Adicionado
        $produto->setEndereco($_POST['endereco']); // Adicionado
        $produto->setQuantidadeReservada($_POST['quantidade_reservada']); // Adicionado
        $produto->setStatusProduto('Disponível'); // Usando o valor padrão

        try {
            $mensagem = ProdutoDao::cadastrar($produto);
            header("Location: ../view/cadastroProduto.php?mensagem=" . urlencode($mensagem));
            exit();
        } catch (Exception $e) {
            echo "Erro ao cadastrar produto: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "Por favor, preencha todos os campos obrigatórios corretamente!";
    }
}
