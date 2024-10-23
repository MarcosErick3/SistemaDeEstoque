<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/produto/cadastroProduto.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Cadastro de Produto</title>
    <style>
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="gray"><path d="M2 6h12L8 12 2 6z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }

        select:hover {
            border-color: #888;
        }

        select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .input-group {
            position: relative;
        }
    </style>
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
                <li class="nav-item"><a href="Armazenamento.php">Armazenamento</a></li>
                <li class="nav-item"><a href="ExpediçãodeMercadoria.php">Expedição de Mercadoria</a></li>
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
                    <input type="text" id="nome" name="nome" required placeholder="Digite o nome do produto">
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="categoria">Categoria</label>
                    <input type="text" id="categoria" name="categoria" required placeholder="Digite a categoria do produto">
                </div>
                <div class="input-group">
                    <label for="marca">Marca</label>
                    <input type="text" id="marca" name="marca" required placeholder="Digite a marca do produto">
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="peso">Peso (kg)</label>
                    <input type="number" id="peso" name="peso" required step="0.01" placeholder="Ex: 1.5">
                </div>
                <div class="input-group">
                    <label for="dimensoes">Dimensões (altura x largura x comprimento)</label>
                    <input type="text" id="dimensoes" name="dimensoes" required placeholder="Ex: 10x20x30">
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="numeroLote">Número de Lote</label>
                    <input type="text" id="numeroLote" name="numero_lote" required placeholder="Digite o número do lote">
                </div>
                <div class="input-group">
                    <label for="numeroSerie">Número de Série</label>
                    <input type="text" id="numeroSerie" name="numero_serie" required placeholder="Digite o número de série">
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="codigoBarras">Código de Barras</label>
                    <input type="text" id="codigoBarras" name="codigo_barras" required placeholder="Digite o código de barras">
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
                    <label for="zona">Zona</label>
                    <input type="text" id="zona" name="zona" required placeholder="Digite a zona de armazenamento">
                </div>
                <div class="input-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco" required placeholder="Digite o endereço de armazenamento">
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="quantidadeReservada">Quantidade Reservada</label>
                    <input type="number" id="quantidadeReservada" name="quantidade_reservada" required min="0" value="0" placeholder="Ex: 10">
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