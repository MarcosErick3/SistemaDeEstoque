<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/produto/editarProduto.css">
    <title>Editar Produto</title>
</head>

<body>
    <header id="header">
        <nav id="navbar">
            <ul id="nav">
                <li class="nav-item"><a href="cadastroFornecedor.php">Cadastro de Fornecedor</a></li>
                <li class="nav-item"><a href="listaFornecedor.php">Lista de Fornecedor</a></li>
                <li class="nav-item"><a href="cadastroProduto.php">Cadastro de Produtos</a></li>
                <li class="nav-item"><a href="listaProduto.php">Lista de Produtos</a></li>
                <li class="nav-item"><a href="../index.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form action="../controller/processaEdicaoProduto.php" method="post" id="form">
            <?php
            require "global.php";
            if (isset($_GET['id'])) {
                $produtoId = $_GET['id'];
                try {
                    $produto = ProdutoDao::buscarProdutoPorId($produtoId);
                } catch (Exception $e) {
                    echo '<pre>';
                    print_r($e);
                    echo '</pre>';
                    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
                }

                if (isset($produto) && is_array($produto)) {
            ?>
                    <div class="form-main">
                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($produto['produto_id']); ?>">

                        <div class="input-column">
                            <div class="input-group">
                                <label for="nome">Nome</label>
                                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
                            </div>
                            <div class="input-group">
                                <label for="codBarras">Código de Barras</label>
                                <input type="text" id="codBarras" name="codBarras" value="<?php echo htmlspecialchars($produto['codigo_barras']); ?>" required>
                            </div>
                            <div class="input-group">
                                <label for="valorVenda">Valor de Venda</label>
                                <input type="number" step="0.01" id="valorVenda" name="valorVenda" value="<?php echo htmlspecialchars($produto['preco_venda']); ?>" required>
                            </div>
                            <div class="input-group">
                                <label for="valorCusto">Valor de Custo</label>
                                <input type="number" step="0.01" id="valorCusto" name="valorCusto" value="<?php echo htmlspecialchars($produto['preco_custo']); ?>" required>
                            </div>
                        </div>

                        <div class="input-column">
                            <div class="input-group">
                                <label for="categoria">Categoria</label>
                                <input type="text" id="categoria" name="categoria" value="<?php echo htmlspecialchars($produto['categoria']); ?>" required>
                            </div>
                            <div class="input-group">
                                <label for="marca">Marca</label>
                                <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($produto['marca']); ?>" required>
                            </div>
                            <div class="input-group">
                                <label for="descricao">Descrição</label>
                                <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
                            </div>
                        </div>

                        <div class="input-column">
                            <div class="input-group">
                                <label for="numeroLote">Número do Lote</label>
                                <input type="text" id="numeroLote" name="numeroLote" value="<?php echo htmlspecialchars($produto['numero_lote']); ?>" required>
                            </div>
                            <div class="input-group">
                                <label for="numeroSerie">Número de Série</label>
                                <input type="text" id="numeroSerie" name="numeroSerie" value="<?php echo htmlspecialchars($produto['numero_serie']); ?>" required>
                            </div>
                            <div class="input-group">
                                <label for="dimensoes">Dimensões</label>
                                <input type="text" id="dimensoes" name="dimensoes" value="<?php echo htmlspecialchars($produto['dimensoes']); ?>" required>
                            </div>
                        </div>

                        <div class="input-column">
                            <div class="input-group">
                                <label for="dataFabricacao">Data de Fabricação</label>
                                <input type="date" id="dataFabricacao" name="dataFabricacao" value="<?php echo htmlspecialchars($produto['data_fabricacao']); ?>" required>
                            </div>
                            <div class="input-group">
                                <label for="dataValidade">Data de Validade</label>
                                <input type="date" id="dataValidade" name="dataValidade" value="<?php echo htmlspecialchars($produto['data_validade']); ?>" required>
                            </div>
                            <div class="input-group">
                                <label for="fornecedorId">Fornecedor</label>
                                <input type="text" id="fornecedorId" name="fornecedorId" value="<?php echo htmlspecialchars($produto['fornecedor_id']); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="botao">
                        <button type="submit" class="btn">Salvar Alterações</button>
                        <a href="../view/listaProduto.php" class="btn">Voltar</a>
                    </div>
            <?php
                }
            }
            ?>
        </form>
    </main>
</body>

</html>