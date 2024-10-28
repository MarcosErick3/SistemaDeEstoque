<?php
require_once 'global.php';

$produtos = [];
$query = '';
$produtoSelecionado = null;

function buscarProduto($query)
{
    try {
        $conexao = Conexao::conectar();
        $query = "%$query%";
        $stmt = $conexao->prepare("SELECT p.*, f.nome AS fornecedor_nome 
                                    FROM produto p 
                                    LEFT JOIN fornecedor f ON p.fornecedor_id = f.fornecedor_id
                                    WHERE p.nome LIKE :query
                                    LIMIT 10");
        $stmt->bindParam(':query', $query, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception('Erro ao buscar produtos: ' . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $query = strtolower(trim($_POST['query']));
}

try {
    if (!empty($query)) {
        $produtos = buscarProduto($query);

        if (count($produtos) > 0) {
            $produtoSelecionado = $produtos[0];
        } else {
            echo '<p>Nenhum produto encontrado para a pesquisa.</p>';
        }
    }
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
        <form method="POST" action="" aria-label="Barra de Pesquisa">
            <input type="text" id="barra-pesquisa" name="query" placeholder="Pesquisar produto..." value="<?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?>" required>
            <button id="botao-pesquisa" type="submit">Pesquisar</button>
        </form>
        <section id="lista-produtos" aria-labelledby="lista-produtos-titulo">
            <h2 id="lista-produtos-titulo">Resultado da Busca</h2>
            <ul id="produtos">
                <?php if (count($produtos) > 0): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <li onclick="exibirInfoProduto('<?php echo $produto['produto_id']; ?>')">
                            <?php echo htmlspecialchars($produto['nome']); ?>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Nenhum produto encontrado.</li>
                <?php endif; ?>
            </ul>
        </section>

        <section id="info-produto" aria-labelledby="info-produto-titulo">
            <h2 id="info-produto-titulo">Informações do Produto</h2>
            <article id="detalhes-produto">
                <?php if ($produtoSelecionado): ?>
                    <p>Nome: <?php echo htmlspecialchars($produtoSelecionado['nome']); ?></p>
                    <p>Categoria: <?php echo htmlspecialchars($produtoSelecionado['categoria']); ?></p>
                    <p>Marca: <?php echo htmlspecialchars($produtoSelecionado['marca']); ?></p>
                    <p>Peso: <?php echo htmlspecialchars($produtoSelecionado['peso']); ?> kg</p>
                    <p>Dimensões: <?php echo htmlspecialchars($produtoSelecionado['dimensoes']); ?></p>
                    <p>Número de Lote: <?php echo htmlspecialchars($produtoSelecionado['numero_lote']); ?></p>
                    <p>Número de Série: <?php echo htmlspecialchars($produtoSelecionado['numero_serie']); ?></p>
                    <p>Código de Barras: <?php echo htmlspecialchars($produtoSelecionado['codigo_barras']); ?></p>
                    <p>Fornecedor: <?php echo htmlspecialchars($produtoSelecionado['fornecedor_nome']); ?></p>
                    <p>Data de Fabricação: <?php echo htmlspecialchars($produtoSelecionado['data_fabricacao']); ?></p>
                    <p>Data de Validade: <?php echo htmlspecialchars($produtoSelecionado['data_validade']); ?></p>
                    <p>Quantidade Reservada: <?php echo htmlspecialchars($produtoSelecionado['quantidade_reservada']); ?></p>
                    <p>Status do Produto: <?php echo htmlspecialchars($produtoSelecionado['status_produto']); ?></p>
                <?php else: ?>
                    <p>Nenhum produto selecionado.</p>
                <?php endif; ?>
            </article>
        </section>

        <section id="mapa-armazem" aria-labelledby="mapa-armazem-titulo">
            <h2 id="mapa-armazem-titulo">Mapa do Armazém</h2>
            <div id="mapa">
                <div class="corredor" id="C1">
                    <div class="prateleira">
                        <div class="modulo" id="CR1-PR1-NV5-PS1" onclick="exibirInfoProduto('CR1-PR1-NV5-PS1')">CR1-PR1-NV5-PS1</div>
                        <div class="modulo" id="CR1-PR1-NV5-PS2" onclick="exibirInfoProduto('CR1-PR1-NV5-PS2')">CR1-PR1-NV5-PS2</div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        function exibirInfoProduto(produtoId) {
            // Lógica para exibir informações do produto com base no produtoId
            console.log("Produto ID: " + produtoId);

            // Aqui você pode implementar a lógica para exibir as informações do produto
            // Adicionando destaque na prateleira correspondente ao produto
            document.querySelectorAll('.modulo').forEach(function(modulo) {
                modulo.classList.remove('destaque'); // Remove destaque de todos os módulos
            });

            var moduloSelecionado = document.getElementById(produtoId);
            if (moduloSelecionado) {
                moduloSelecionado.classList.add('destaque'); // Adiciona destaque ao módulo selecionado
            }

            // Fazer a requisição para buscar os detalhes do produto
            // Aqui você pode usar AJAX ou atualizar a parte do DOM com as informações do produto selecionado
        }
    </script>

    <style>
        /* Adicione esse estilo no CSS para o destaque */
        .modulo.destaque {
            background-color: yellow;
            /* Cor de destaque */
            border: 2px solid red;
            /* Borda para chamar atenção */
        }
    </style>


    <script>
        function exibirInfoProduto(produtoId) {
            // Lógica para exibir informações do produto com base no produtoId
            // Por exemplo, você pode fazer uma nova requisição AJAX para buscar os detalhes do produto
            console.log("Produto ID: " + produtoId);
            // Aqui você pode implementar a lógica para exibir as informações do produto
        }
    </script>
</body>

</html>