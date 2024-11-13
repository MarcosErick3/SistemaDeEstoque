<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/produto/editarProduto.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <style>
        select {
            width: calc(100% - 20px);
            padding: 15px;
            border: 1px solid #ccc;
            /* Cor da borda padrão */
            border-radius: 4px;
            background-color: #ffffff;
            /* Cor de fundo dos campos */
            font-size: 16px;
            color: #333333;
            /* Cor do texto nos campos */
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s, background-color 0.3s;
        }
    </style>
    <title>Smart Stock - Editar Produto</title>
</head>

<body>
    <header id="header">
        <nav id="navbar">
            <h1 id="system-name">Smart Stock</h1>
            <ul id="nav">
                <li class="nav-item"><a href="cadastroProduto.php">Cadastro de Produtos</a></li>
                <li class="nav-item"><a href="listaProduto.php">Buscar Produtos</a></li>
                <li class="nav-item"><a href="movimentacao.php">Movimentação</a></li>
                <li class="nav-item"><a href="mapaAmazem.php">Mapa do Armazenamem</a></li>
                <li class="nav-item"><a href="iventario.php">Inventário</a></li>
                <li class="nav-item"><a href="RegistrarDevolucao.php">Registrar Devolução</a></li>
                <li class="nav-item"><a href="RelatorioDeDevoluçoes.php">Relatório de Devoluções</a></li>
                <li class="nav-item"><a href="registrarSaidaProduto.php">Saída do Produto</a></li>
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
                    $listaFornecedores = FornecedorDAO::listarFornecedor();
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
                                    <select name="categoria" id="categoria" required>
                                        <option value="">Selecione uma categoria</option>
                                        <option value="Eletrônicos" <?php echo ($produto['categoria'] === 'Eletrônicos') ? 'selected' : ''; ?>>Eletrônicos</option>
                                        <option value="Vestuário" <?php echo ($produto['categoria'] === 'Vestuário') ? 'selected' : ''; ?>>Vestuário</option>
                                        <option value="Alimentos" <?php echo ($produto['categoria'] === 'Alimentos') ? 'selected' : ''; ?>>Alimentos</option>
                                        <option value="Brinquedos" <?php echo ($produto['categoria'] === 'Brinquedos') ? 'selected' : ''; ?>>Brinquedos</option>
                                    </select>

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
                                    <label for="dataValidade">Data de Validade:</label>
                                    <input type="date" id="dataValidade" name="data_validade">
                                    <label for="naoAplicaValidade">Não se aplica</label>
                                    <input type="checkbox" id="naoAplicaValidade" onclick="toggleValidade()">
                                </div>
                                <div class="input-group">
                                    <label for="fornecedor_id">Fornecedor</label>
                                    <select name="fornecedor_id" id="fornecedor_id" required>
                                        <option value="">Selecione um Fornecedor</option>
                                        <?php foreach ($listaFornecedores as $listaFornecedor) { ?>
                                            <option value="<?php echo htmlspecialchars($listaFornecedor['fornecedor_id']); ?>"
                                                <?php echo ($produto['fornecedor_id'] == $listaFornecedor['fornecedor_id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($listaFornecedor['nome']); ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>

                            <div class="input-column">
                                <div class="input-group">
                                    <label for="peso">Peso</label>
                                    <input type="number" step="0.01" id="peso" name="peso" value="<?php echo htmlspecialchars($produto['peso']); ?>" required>
                                </div>
                                <div class="input-column">
                                    <div class="input-group">
                                        <label for="quantidade_estoque">Quantidade em Estoque</label>
                                        <input type="number" id="quantidade_estoque" name="quantidade_estoque" value="<?php echo htmlspecialchars($produto['quantidade_estoque']); ?>" required>
                                    </div>
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
                            <div class="input-column">
                                <div class="input-group">
                                    <label>Nível:</label>
                                    <input type="text" id="coluna" name="coluna" value="<?php echo htmlspecialchars($produto['coluna']); ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="posicao">Posição</label>
                                    <input type="text" id="andar" name="andar" value="<?php echo htmlspecialchars($produto['andar']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit">Salvar</button>
                            <a class="delete-link" href="listaProduto.php">Voltar</a>
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
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-left">
                <p>&copy; 2024 Smart Stock. Todos os direitos reservados.</p>
            </div>
            <div class="footer-right">
                <a href="https://www.linkedin.com/in/seunome" target="_blank">LinkedIn</a> |
                <a href="https://github.com/seunome" target="_blank">GitHub</a>
            </div>
        </div>
    </footer>
    <script>
        function toggleValidade() {
            const dataValidade = document.getElementById('dataValidade');
            const naoAplicaCheckbox = document.getElementById('naoAplicaValidade');

            if (naoAplicaCheckbox.checked) {
                dataValidade.value = ""; // Limpa o campo
                dataValidade.disabled = true; // Desabilita o campo
            } else {
                dataValidade.disabled = false; // Habilita o campo novamente
            }
        }
    </script>

</body>

</html>