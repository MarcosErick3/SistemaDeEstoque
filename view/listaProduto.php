<?php
require_once 'global.php';

$produtos = [];
$query = '';
$produtosCadastrados = [];
// Verifica se foi feito um pedido para excluir um produto
if (isset($_GET['excluir_produto_id'])) {
    $produtoId = (int) $_GET['excluir_produto_id']; // Converte o ID do produto para inteiro

    try {
        // Chama a função de exclusão no ProdutoDao
        ProdutoDao::excluirProduto($produtoId);
        header("Location: listaProduto.php?msg=Produto excluído com sucesso!"); // Redireciona após a exclusão
        exit;
    } catch (Exception $e) {
        die("Erro ao excluir o produto: " . htmlspecialchars($e->getMessage())); // Tratamento de erro
    }
}

// Verifica se a requisição é do tipo POST e se há uma consulta
// Verifica se a requisição é do tipo POST e se há uma consulta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $query = strtolower(trim($_POST['query']));
}

try {
    // Modifiquei a busca para procurar pelo código de barras se for um número
    if (!empty($query)) {
        // Verifica se o valor da pesquisa parece um código de barras (pode ser um número)
        if (is_numeric($query)) {
            // Se for um número, realiza a busca pelo código de barras
            $produtos = ProdutoDao::buscarProdutoPorCodigoBarras($query);
        } else {
            // Caso contrário, realiza a busca normal
            $produtos = ProdutoDao::buscarProduto($query);
        }
    }

    // Listar todos os produtos cadastrados
    $produtosCadastrados = ProdutoDao::listarProduto(); // Chama a função para listar produtos no ProdutoDao
} catch (Exception $e) {
    die("Erro ao buscar produtos: " . htmlspecialchars($e->getMessage()));
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema Smart Stock - Gerenciamento eficiente de produtos e estoque.">
    <title>Smart Stock - Gestão de Produtos</title>
    <link rel="stylesheet" href="../css/produto/buscarProduto.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
        .footer {
            position: fixed;
            bottom: 0;
        }
    </style>
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
        <form method="POST" action="" aria-label="Barra de Pesquisa" class="form-main">
            <input type="text" id="barra-pesquisa" name="query" placeholder="Pesquisar produto..." value="<?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?>" required>
            <button id="botao-pesquisa" class="btn btn-search" type="submit" aria-label="Pesquisar">Pesquisar</button>
        </form>

        <section id="resultado-busca" aria-labelledby="resultado-busca-titulo" aria-live="polite">
            <div id="produtos">
                <?php if (count($produtos) > 0): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <div class="produto-card" onclick="exibirInfoProduto('<?php echo $produto['produto_id']; ?>')" role="button" tabindex="0" aria-label="Ver detalhes do produto">
                            <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                            <p><strong>Categoria:</strong> <?php echo htmlspecialchars($produto['categoria']); ?></p>
                            <p><strong>Fornecedor:</strong> <?php echo isset($produto['fornecedor_nome']) ? htmlspecialchars($produto['fornecedor_nome']) : 'Fornecedor não encontrado'; ?></p>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                <?php endif; ?>
            </div>
        </section>

        <section id="produtos-cadastrados" aria-labelledby="produtos-cadastrados-titulo">
            <h2 id="produtos-cadastrados-titulo">Produtos Cadastrados</h2>
            <div id="produtos">
                <?php if (count($produtosCadastrados) > 0): ?>
                    <?php foreach ($produtosCadastrados as $produto): ?>
                        <div class="produto-card" onclick="exibirInfoProduto(<?php echo htmlspecialchars($produto['produto_id']); ?>)" role="button" tabindex="0" aria-label="Ver detalhes do produto">
                            <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                            <p><strong>Categoria:</strong> <?php echo htmlspecialchars($produto['categoria']); ?></p>
                            <p><strong>Quantidade:</strong> <?php echo htmlspecialchars($produto['quantidade_reservada']); ?></p>
                            <p><strong>Marca:</strong> <?php echo htmlspecialchars($produto['marca']); ?></p>
                            <p><strong>Peso:</strong> <?php echo htmlspecialchars($produto['peso']); ?></p>
                            <p><strong>Dimensões:</strong> <?php echo htmlspecialchars($produto['dimensoes']); ?></p>
                            <p><strong>Número Lote:</strong> <?php echo htmlspecialchars($produto['numero_lote']); ?></p>
                            <p><strong>Número de Série:</strong> <?php echo htmlspecialchars($produto['numero_serie']); ?></p>
                            <p><strong>Código de Barras:</strong> <?php echo htmlspecialchars($produto['codigo_barras']); ?></p>
                            <p><strong>Fornecedor:</strong> <?php echo htmlspecialchars($produto['fornecedor_nome']); ?></p>
                            <p><strong>Data de Fabricação:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($produto['data_fabricacao']))); ?></p>
                            <p><strong>Data de Validade:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($produto['data_validade']))); ?></p>
<<<<<<< HEAD
                            <p><strong>Data de Recebimento:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($produto['data_recebimento']))); ?></p>
=======
                            <p><strong>Data de Recebimento:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($produto['data_recebimento']))); ?></p>    
>>>>>>> 5c7aff2cc7fd4bcddf5e60cca1220966df79c99d
                            <p><strong>Corredor:</strong> <?php echo htmlspecialchars($produto['corredor']); ?></p>
                            <p><strong>Prateleira:</strong> <?php echo htmlspecialchars($produto['prateleira']); ?></p>
                            <p><strong>Nível:</strong> <?php echo htmlspecialchars($produto['coluna']); ?></p>
                            <p><strong>Posição:</strong> <?php echo htmlspecialchars($produto['andar']); ?></p>

                            <a class="edit-link" href="editarProduto.php?id=<?php echo htmlspecialchars($produto['produto_id']); ?>" aria-label="Editar produto">Editar</a>
                            <a class="delete-link" href="listaProduto.php?excluir_produto_id=<?php echo htmlspecialchars($produto['produto_id']); ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?');" aria-label="Excluir produto">Excluir</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum produto cadastrado.</p>
                <?php endif; ?>
            </div>
        </section>
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
        function exibirInfoProduto(produtoId) {
            const detalhesProduto = document.getElementById('detalhes-produto');
            detalhesProduto.innerHTML = 'Carregando informações do produto...';

            // Faz a requisição para buscar as informações do produto
            fetch(`getProdutoInfo.php?id=${produtoId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na rede: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    // Verifica se os dados do produto foram retornados
                    if (data && Object.keys(data).length > 0) {
                        detalhesProduto.innerHTML = `
                        <h3>${data.nome}</h3>
                        <p><strong>Categoria:</strong> ${data.categoria}</p>
                        <p><strong>Marca:</strong> ${data.marca}</p>
                        <p><strong>Peso:</strong> ${data.peso} kg</p>
                        <p><strong>Dimensões:</strong> ${data.dimensoes}</p>
                        <p><strong>Número Lote:</strong> ${data.numero_lote}</p>
                        <p><strong>Número Série:</strong> ${data.numero_serie}</p>
                        <p><strong>Código de Barras:</strong> ${data.codigo_barras}</p>
                        <p><strong>Fornecedor:</strong> ${data.fornecedor_nome}</p>
                        <p><strong>Data de Fabricação:</strong> ${new Date(data.data_fabricacao).toLocaleDateString('pt-BR')}</p>
                        <p><strong>Data de Validade:</strong> ${new Date(data.data_validade).toLocaleDateString('pt-BR')}</p>
                        <p><strong>Corredor:</strong> ${data.corredor}</p>
                        <p><strong>Prateleira:</strong> ${data.prateleira}</p>
                    `;
                    } else {
                        detalhesProduto.innerHTML = 'Produto não encontrado.';
                    }
                })
                .catch(error => {
                    detalhesProduto.innerHTML = `Erro ao carregar detalhes do produto: ${error.message}`;
                });
        }
    </script>
</body>

</html>