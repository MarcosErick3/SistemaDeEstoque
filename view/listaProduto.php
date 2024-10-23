<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/produto/listaProduto.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Lista de Produtos</title>
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
    <?php
    require_once 'global.php';

    // Verifica se um produto deve ser excluído
    if (isset($_GET['excluir_produto_id'])) {
        $produtoId = $_GET['excluir_produto_id'];

        try {
            $resultado = ProdutoDao::excluirProduto($produtoId);
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

    try {
        $listaProdutos = ProdutoDao::listarProduto();
    } catch (Exception $e) {
        echo 'Erro ao listar produtos: ' . $e->getMessage();
    }
    ?>

    <main id="main">
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Marca</th>
                        <th>Peso</th>
                        <th>Dimensões</th>
                        <th>Número de Lote</th>
                        <th>Número de Série</th>
                        <th>Código de Barras</th>
                        <th>Fornecedor</th>
                        <th>Data de Fabricação</th>
                        <th>Data de Validade</th>
                        <th>Zona</th>
                        <th>Endereço</th>
                        <th>Quantidade Reservada</th>
                        <th>Status do Produto</th>
                        <th>Corredor</th>
                        <th>Prateleira</th>
                        <th>Nível</th>
                        <th>Posição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($listaProdutos)): ?>
                        <?php foreach ($listaProdutos as $produto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($produto['produto_id']); ?></td>
                                <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                                <td><?php echo htmlspecialchars($produto['categoria']); ?></td>
                                <td><?php echo htmlspecialchars($produto['marca']); ?></td>
                                <td><?php echo htmlspecialchars($produto['peso']); ?></td>
                                <td><?php echo htmlspecialchars($produto['dimensoes']); ?></td>
                                <td><?php echo htmlspecialchars($produto['numero_lote']); ?></td>
                                <td><?php echo htmlspecialchars($produto['numero_serie']); ?></td>
                                <td><?php echo htmlspecialchars($produto['codigo_barras']); ?></td>
                                <td><?php echo htmlspecialchars($produto['fornecedor_nome']); ?></td>
                                <td><?php echo htmlspecialchars($produto['data_fabricacao']); ?></td>
                                <td><?php echo htmlspecialchars($produto['data_validade']); ?></td>
                                <td><?php echo htmlspecialchars($produto['zona']); ?></td>
                                <td><?php echo htmlspecialchars($produto['endereco']); ?></td>
                                <td><?php echo htmlspecialchars($produto['quantidade_reservada']); ?></td>
                                <td><?php echo htmlspecialchars($produto['status_produto']); ?></td>
                                <td><?php echo htmlspecialchars($produto['corredor']); ?></td>
                                <td><?php echo htmlspecialchars($produto['prateleira']); ?></td>
                                <td><?php echo htmlspecialchars($produto['nivel']); ?></td>
                                <td><?php echo htmlspecialchars($produto['posicao']); ?></td>
                                <td>
                                    <a class="edit-link" href="editarProduto.php?id=<?php echo htmlspecialchars($produto['produto_id']); ?>">Editar</a>
                                    <a class="delete-link" href="listaProduto.php?excluir_produto_id=<?php echo htmlspecialchars($produto['produto_id']); ?>"
                                        onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="20">Nenhum produto encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>