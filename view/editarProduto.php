<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/produto/editarProduto.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Editar Produto</title>
</head>

<body>
<header id="header">
        <nav id="navbar">
            <h1 id="system-name">Smart Stock</h1>
            <ul id="nav">
                <li class="nav-item"><a href="cadastroProduto.php">Cadastro de Produtos</a></li>
                <li class="nav-item"><a href="listaProduto.php">Buscar Produtos</a></li>
                <li class="nav-item"><a href="registrarInventario.php">Registrar Inventário</a></li>
                <li class="nav-item"><a href="registrarSaidaProduto.php">Saída do Produto</a></li>
                <li class="nav-item"><a href="Armazenamento.php">Armazenamento</a></li>
                <li class="nav-item"><a href="ExpediçãodeMercadoria.php">Expedição de Mercadoria</a></li>
                <li class="nav-item"><a href="movimentacao.php">Movimentação</a></li>
                <li class="nav-item"><a href="RegistrarDevolucao.php">Registrar Devolucao</a></li>
                <li class="nav-item"><a href="RelatorioDeDevoluçoes.php">Relatorio De Devoluçoes</a></li>
                <li class="nav-item"><a href="../index.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form action="../controller/processaEdicaoProduto.php" method="post" id="form">
            <?php
            require "global.php";

            // Verifica se o ID do produto foi passado na URL
            if (isset($_GET['id'])) {
                $produtoId = (int)$_GET['id']; // Converte para inteiro para evitar injeção de SQL

                try {
                    $produto = ProdutoDao::buscarProdutoPorId($produtoId);

                    if ($produto) { // Verifica se o produto foi encontrado
            ?>
                        <div class="form-main">
                            <input type="hidden" name="produto_id" value="<?php echo htmlspecialchars($produto['produto_id']); ?>">

                            <div class="input-column">
                                <div class="input-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="codigo_barras">Código de Barras</label>
                                    <input type="text" id="codigo_barras" name="codigo_barras" value="<?php echo htmlspecialchars($produto['codigo_barras']); ?>" required>
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
                            </div>

                            <div class="input-column">
                                <div class="input-group">
                                    <label for="numero_lote">Número do Lote</label>
                                    <input type="text" id="numero_lote" name="numero_lote" value="<?php echo htmlspecialchars($produto['numero_lote']); ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="numero_serie">Número de Série</label>
                                    <input type="text" id="numero_serie" name="numero_serie" value="<?php echo htmlspecialchars($produto['numero_serie']); ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="dimensoes">Dimensões</label>
                                    <input type="text" id="dimensoes" name="dimensoes" value="<?php echo htmlspecialchars($produto['dimensoes']); ?>" required>
                                </div>
                            </div>

                            <div class="input-column">
                                <div class="input-group">
                                    <label for="data_fabricacao">Data de Fabricação</label>
                                    <input type="date" id="data_fabricacao" name="data_fabricacao" value="<?php echo htmlspecialchars($produto['data_fabricacao']); ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="data_validade">Data de Validade</label>
                                    <input type="date" id="data_validade" name="data_validade" value="<?php echo htmlspecialchars($produto['data_validade']); ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="fornecedor_id">Fornecedor ID</label>
                                    <input type="text" id="fornecedor_id" name="fornecedor_id" value="<?php echo htmlspecialchars($produto['fornecedor_id']); ?>" required>
                                </div>
                            </div>

                            <div class="input-column">
                                <div class="input-group">
                                    <label for="peso">Peso</label>
                                    <input type="number" step="0.01" id="peso" name="peso" value="<?php echo htmlspecialchars($produto['peso']); ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="quantidade_reservada">Quantidade Reservada</label>
                                    <input type="number" id="quantidade_reservada" name="quantidade_reservada" value="<?php echo htmlspecialchars($produto['quantidade_reservada']); ?>" required>
                                </div>
                            </div>

                            <div class="input-column">
                                <div class="input-group">
                                    <label>Corredor:</label>
                                    <input type="text" name="corredor" value="<?php echo htmlspecialchars($produto['corredor']); ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="prateleira">Prateleira</label>
                                    <input type="text" id="prateleira" name="prateleira" value="<?php echo htmlspecialchars($produto['prateleira']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit">Salvar</button>
                            <a href="listaProduto.php">Voltar</a>
                        </div>
            <?php
                    } else {
                        echo '<p>Produto não encontrado.</p>';
                    }
                } catch (Exception $e) {
                    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>'; // Exibe mensagem de erro
                }
            } else {
                echo '<p>ID do produto não fornecido.</p>';
            }
            ?>
        </form>
    </main>

</body>

</html>