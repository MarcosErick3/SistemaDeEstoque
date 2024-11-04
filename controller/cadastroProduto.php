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
    $quantidadeReservada = $_POST['quantidade_reservada'] ?? 0;
    $statusProduto = $_POST['status_produto'];

    // Criar o objeto Produto e definir os atributos
    $produto = new Produto(); // Instância de Produto
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
    $produto->setQuantidade_reservada($quantidadeReservada);
    $produto->setStatusProduto($statusProduto);

    // Validação e formatação das datas
    try {
        // Cadastrar o produto
        $produtoId = ProdutoDAO::cadastrar($produto);

        // Adicionar entrada na tabela estoque com dados padrão
        $conexao = Conexao::conectar();
        $sqlInserirEstoque = "INSERT INTO estoque (produto_id, quantidade, localizacao_id, nivel_minimo, nivel_atual, alerta_critico)
                              VALUES (:produto_id, :quantidade, :localizacao_id, 0, :quantidade, 0)";
        $stmtEstoque = $conexao->prepare($sqlInserirEstoque);
        $stmtEstoque->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
        $stmtEstoque->bindParam(':quantidade', $quantidadeReservada, PDO::PARAM_INT);
        $stmtEstoque->bindParam(':localizacao_id', $localizacao_id, PDO::PARAM_INT);
        $stmtEstoque->execute();

        // Redirecionar para a página de armazenamento com o produtoId
        header("Location: ../view/Armazenamento.php?produtoId=" . urlencode($produtoId));
        exit();
    } catch (Exception $e) {
        echo '<pre>';
        print_r($e);
        echo '</pre>';
        echo '<p style="color:red;">' . htmlspecialchars($e->getMessage()) . '</p>';
    } finally {
        $conexao = null;
    }
}
