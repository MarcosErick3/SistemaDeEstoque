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
    $quantidadeReservada = $_POST['quantidade_reservada'] ?? 0; // Use um valor padrão caso não exista
    $statusProduto = $_POST['status_produto'];

    // Validação e formatação das datas
    try {
        // Tente criar um objeto DateTime para cada data
        $dtFabricacao = new DateTime($dataFabricacao);
        $dtValidade = new DateTime($dataValidade);

        // Formate as datas para o padrão YYYY-MM-DD
        $dataFabricacao = $dtFabricacao->format('Y-m-d');
        $dataValidade = $dtValidade->format('Y-m-d');
    } catch (Exception $e) {
        echo '<p style="color:red;">Data inválida: ' . htmlspecialchars($e->getMessage()) . '</p>';
        exit();
    }

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
    $produto->setQuantidade_reservada($quantidadeReservada); // Corrigido aqui
    $produto->setStatusProduto($statusProduto);

    // Chamar o método para inserir o produto
    try {
        $produtoId = ProdutoDAO::cadastrar($produto);

        // Redirecionar para a página de armazenamento passando o produtoId
        header("Location: ../view/Armazenamento.php?produtoId=" . urlencode($produtoId));
        exit();
    } catch (Exception $e) {
        echo '<pre>';
        print_r($e);
        echo '</pre>';
        echo '<p style="color:red;">' . htmlspecialchars($e->getMessage()) . '</p>';
    }
}
