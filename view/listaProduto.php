<?php
require_once 'global.php';

$produtos = [];
$query = '';
$produtosCadastrados = [];

// Função para buscar produtos
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

// Função para listar todos os produtos cadastrados
function listarProduto()
{
    $conexao = Conexao::conectar();
    $sql = "SELECT p.*, 
                    l.corredor, 
                    l.prateleira, 
                    l.coluna, 
                    l.andar, 
                    f.nome AS fornecedor_nome
             FROM produto p
             LEFT JOIN produto_localizacao pl ON p.produto_id = pl.produto_id
             LEFT JOIN localizacao l ON pl.localizacao_id = l.localizacao_id
             LEFT JOIN fornecedor f ON p.fornecedor_id = f.fornecedor_id";

    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para excluir um produto pelo ID
function excluirProduto($id)
{
    try {
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare("DELETE FROM produto WHERE produto_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute(); // Retorna verdadeiro se a exclusão foi bem-sucedida
    } catch (PDOException $e) {
        throw new Exception('Erro ao excluir produto: ' . $e->getMessage());
    }
}

// Verifica se a requisição é do tipo POST e se há uma consulta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $query = strtolower(trim($_POST['query']));
}

try {
    // Busca produtos com base na consulta
    if (!empty($query)) {
        $produtos = buscarProduto($query);
    }

    // Listar todos os produtos cadastrados
    $produtosCadastrados = listarProduto();
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        #header {
            background: #333;
            color: #fff;
            padding: 10px 0;
        }

        #navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        #system-name {
            margin: 0;
        }

        #nav {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-item {
            margin-left: 15px;
        }

        .nav-item a {
            color: #fff;
            text-decoration: none;
        }

        main {
            padding: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        #barra-pesquisa {
            padding: 10px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #botao-pesquisa {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            margin-left: 10px;
        }

        #botao-pesquisa:hover {
            background-color: #218838;
        }

        #produtos {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .produto-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
            flex: 1 1 200px;
            /* Flex grow, shrink and basis */
            transition: transform 0.2s;
            cursor: pointer;
        }

        .produto-card:hover {
            transform: scale(1.05);
        }

        .produto-card h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .produto-card p {
            margin: 5px 0;
            font-size: 0.9em;
        }

        #info-produto {
            margin-top: 30px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #info-produto h2 {
            margin-top: 0;
        }

        #detalhes-produto {
            margin-top: 15px;
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

        <section id="resultado-busca" aria-labelledby="resultado-busca-titulo">
            <h2 id="resultado-busca-titulo">Resultado da Busca</h2>
            <div id="produtos">
                <?php if (count($produtos) > 0): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <div class="produto-card" onclick="exibirInfoProduto('<?php echo $produto['produto_id']; ?>')">
                            <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                            <p><strong>Categoria:</strong> <?php echo htmlspecialchars($produto['categoria']); ?></p>
                            <p><strong>Fornecedor:</strong> <?php echo htmlspecialchars($produto['fornecedor_nome']); ?></p>
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
                        <div class="produto-card" onclick="exibirInfoProduto(<?php echo htmlspecialchars($produto['produto_id']); ?>)">

                            <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                            <p><strong>Categoria:</strong> <?php echo htmlspecialchars($produto['categoria']); ?></p>
                            <p><strong>Marca:</strong> <?php echo htmlspecialchars($produto['marca']); ?></p>
                            <p><strong>Peso:</strong> <?php echo htmlspecialchars($produto['peso']); ?></p>
                            <p><strong>Dimensões:</strong> <?php echo htmlspecialchars($produto['dimensoes']); ?></p>
                            <p><strong>Número Lote:</strong> <?php echo htmlspecialchars($produto['numero_lote']); ?></p>
                            <p><strong>Número de Série:</strong> <?php echo htmlspecialchars($produto['numero_serie']); ?></p>
                            <p><strong>Código de Barras:</strong> <?php echo htmlspecialchars($produto['codigo_barras']); ?></p>
                            <p><strong>Fornecedor:</strong> <?php echo htmlspecialchars($produto['fornecedor_nome']); ?></p>
                            <p><strong>Data de Fabricação:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($produto['data_fabricacao']))); ?></p>
                            <p><strong>Data de Validade:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($produto['data_validade']))); ?></p>
                            <p><strong>Status do Produto:</strong> <?php echo htmlspecialchars($produto['status_produto']); ?></p>
                            <p><strong>Corredor:</strong> <?php echo htmlspecialchars($produto['corredor']); ?></p>
                            <p><strong>Prateleira:</strong> <?php echo htmlspecialchars($produto['prateleira']); ?></p>

                            <a class="edit-link" href="editarProduto.php?id=<?php echo htmlspecialchars($produto['produto_id']); ?>">Editar</a>
                            <a class="delete-link" href="listaProduto.php?excluir_produto_id=<?php echo htmlspecialchars($produto['produto_id']); ?>"
                                onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                            <?php
                            require_once 'global.php';

                            if (isset($_GET['excluir_produto_id'])) {
                                $produtoId = intval($_GET['excluir_produto_id']); // Converte para inteiro

                                try {
                                    $resultado = ProdutoDao::excluirProduto($produtoId); // Chama a função de exclusão
                                    if ($resultado) {
                                        header("Location: listaProduto.php"); // Redireciona após a exclusão
                                        exit();
                                    } else {
                                        echo "Erro ao excluir o produto.";
                                    }
                                } catch (Exception $e) {
                                    echo 'Erro ao excluir produto: ' . $e->getMessage();
                                }
                            }

                            ?>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum produto cadastrado.</p>
                <?php endif; ?>
            </div>
        </section>

        <section id="info-produto" aria-labelledby="info-produto-titulo">
            <h2 id="info-produto-titulo">Detalhes do Produto</h2>
            <div id="detalhes-produto">
                <p>Nenhum produto selecionado.</p>
            </div>
        </section>

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
    <p><strong>Status do Produto:</strong> ${data.status_produto}</p>
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