<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/produto/cadastroProduto.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Cadastro de Produto</title>
</head>

<body>
<header id="header">
        <nav id="navbar">
            <h1 id="system-name">Smart Stock</h1>
            <ul id="nav">
                <li class="nav-item"><a href="cadastroProduto.php">Cadastro de Produtos</a></li>
                <li class="nav-item"><a href="listaProduto.php">Lista de Produtos</a></li>
                <li class="nav-item"><a href="buscarProduto.php">Buscar Produtos</a></li>
                <li class="nav-item"><a href="registrarInventario.php">Registrar Inventário</a></li>
                <li class="nav-item"><a href="registrarSaidaProduto.php">Saída do Produto</a></li>
                <li class="nav-item"><a href="movimentacao.php">Movimentação</a></li>
                <li class="nav-item"><a href="../index.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form id="form" action="../controller/cadastroProduto.php" method="post" class="form-main">
            <div class="input-column">
                <div class="input-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="input-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" required></textarea>
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="categoria">Categoria</label>
                    <input type="text" id="categoria" name="categoria" required>
                </div>
                <div class="input-group">
                    <label for="marca">Marca</label>
                    <input type="text" id="marca" name="marca" required>
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="peso">Peso (kg)</label>
                    <input type="number" id="peso" name="peso" required step="0.01">
                </div>
                <div class="input-group">
                    <label for="dimensoes">Dimensões (altura x largura x comprimento)</label>
                    <input type="text" id="dimensoes" name="dimensoes" required placeholder="Ex: 10x20x30">
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="numeroLote">Número de Lote</label>
                    <input type="text" id="numeroLote" name="numero_lote" required>
                </div>
                <div class="input-group">
                    <label for="numeroSerie">Número de Série</label>
                    <input type="text" id="numeroSerie" name="numero_serie" required>
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="codigoBarras">Código de Barras</label>
                    <input type="text" id="codigoBarras" name="codigo_barras" required>
                </div>
                <div class="input-group">
                    <label for="fornecedor_id">Fornecedor</label>
                    <?php
                    require 'global.php';
                    try {
                        $listaFornecedores = FornecedorDAO::listarFornecedor();
                    } catch (Exception $e) {
                        echo '<pre>';
                        print_r($e);
                        echo '</pre>';
                        echo '<p style="color:red;">' . htmlspecialchars($e->getMessage()) . '</p>';
                    }

                    if (isset($listaFornecedores) && !empty($listaFornecedores)) {
                    ?>
                        <select name="fornecedor_id" id="fornecedor_id" required>
                            <option value="">Selecione um Fornecedor</option>
                            <?php foreach ($listaFornecedores as $listaFornecedor) { ?>
                                <option value="<?php echo htmlspecialchars($listaFornecedor['fornecedor_id']); ?>">
                                    <?php echo htmlspecialchars($listaFornecedor['nome']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    <?php } else {
                        echo '<p>Nenhum fornecedor disponível.</p>';
                    } ?>
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="dataFabricacao">Data de Fabricação</label>
                    <input type="date" id="dataFabricacao" name="data_fabricacao" required>
                </div>
                <div class="input-group">
                    <label for="dataValidade">Data de Validade</label>
                    <input type="date" id="dataValidade" name="data_validade" required>
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="precoCusto">Preço de Custo</label>
                    <input type="number" id="precoCusto" name="preco_custo" required step="0.01">
                </div>
                <div class="input-group">
                    <label for="precoVenda">Preço de Venda</label>
                    <input type="number" id="precoVenda" name="preco_venda" required step="0.01">
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="zona">Zona</label>
                    <input type="text" id="zona" name="zona" required>
                </div>
                <div class="input-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco" required>
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="quantidadeReservada">Quantidade Reservada</label>
                    <input type="number" id="quantidadeReservada" name="quantidade_reservada" required min="0" value="0">
                </div>
                <div class="input-group">
                    <label for="statusProduto">Status do Produto</label>
                    <select name="status_produto" id="statusProduto" required>
                        <option value="Disponível">Disponível</option>
                        <option value="Indisponível">Indisponível</option>
                        <option value="Reservado">Reservado</option>
                        <option value="Descontinuado">Descontinuado</option>
                    </select>
                </div>
            </div>
            <div class="botao">
                <button type="submit" class="btn">Cadastrar Produto</button>
                <button type="reset" class="btn btn-clear">Limpar</button>
            </div>
        </form>





    </main>
</body>

</html>