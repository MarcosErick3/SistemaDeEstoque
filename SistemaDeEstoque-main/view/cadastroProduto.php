<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/produto/cadastroProduto.css">
    <title>Cadastro de Produto</title>
</head>

<body>
    <header id="header">
        <nav id="navbar">
            <ul id="nav">
                <li class="nav-item">
                    <a href="cadastroFornecedor.php">Cadastro de Fornecedor</a>
                </li>
                <li class="nav-item">
                    <a href="listaFornecedor.php">Lista de Fornecedor</a>
                </li>
                <li class="nav-item">
                    <a href="cadastroProduto.php">Cadastro de Produtos</a>
                </li>
                <li class="nav-item">
                    <a href="listaProduto.php">Lista de Produtos</a>
                </li>
                <li class="nav-item">
                    <a href="../index.php">Sair</a>
                </li>
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
                    <label for="peso">Peso</label>
                    <input type="number" id="peso" name="peso" required step="0.01">
                </div>
                <div class="input-group">
                    <label for="dimensoes">Dimensões</label>
                    <input type="text" id="dimensoes" name="dimensoes" required>
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="numeroLote">Número de Lote</label>
                    <input type="text" id="numeroLote" name="numeroLote" required>
                </div>
                <div class="input-group">
                    <label for="numeroSerie">Número de Série</label>
                    <input type="text" id="numeroSerie" name="numeroSerie" required>
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="codigoBarras">Código de Barras</label>
                    <input type="text" id="codigoBarras" name="codBarras" required>
                </div>
                <div class="input-group">
                    <?php
                    require_once 'global.php';
                    $fornecedores = FornecedorDAO::listarFornecedor(); 

                    ?>
                    <label for="fornecedorNome">Fornecedor</label>
                    <select name="fornecedorNome" id="fornecedorNome" required>
                        <option value="">Selecione um fornecedor</option>
                        <?php
                        foreach ($fornecedores as $fornecedor) :
                        ?>
                            <option value="<?php echo htmlspecialchars($fornecedor['fornecedor_id']); ?>">
                                <?php echo htmlspecialchars($fornecedor['nome']); ?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>

            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="dataFabricacao">Data de Fabricação</label>
                    <input type="date" id="dataFabricacao" name="dataFabricacao" required>
                </div>
                <div class="input-group">
                    <label for="dataValidade">Data de Validade</label>
                    <input type="date" id="dataValidade" name="dataValidade" required>
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="precoCusto">Preço de Custo</label>
                    <input type="number" id="precoCusto" name="precoCusto" required step="0.01">
                </div>
                <div class="input-group">
                    <label for="precoVenda">Preço de Venda</label>
                    <input type="number" id="precoVenda" name="precoVenda" required step="0.01">
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