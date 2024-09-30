<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fornecedor/listaFornecedor.css">
    <title>Lista de Fornecedores</title>
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
    <main id="main">
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>CNPJ</th>
                        <th>Rua</th>
                        <th>Número</th>
                        <th>Complemento</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>CEP</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once "global.php";

                    // Verifica se há uma solicitação de exclusão
                    if (isset($_GET['excluir_fornecedor_id'])) {
                        $idFornecedorExcluir = $_GET['excluir_fornecedor_id'];

                        try {
                            FornecedorDAO::excluirFornecedor($idFornecedorExcluir);
                            header("Location: listaFornecedor.php");
                            exit();
                        } catch (Exception $e) {
                            echo '<p style="color:red;">Erro ao excluir o fornecedor: ' . htmlspecialchars($e->getMessage()) . '</p>';
                        }
                    }

                    try {
                        // Lógica para listar fornecedores
                        $listaFornecedores = FornecedorDAO::listarFornecedor();
                    } catch (Exception $e) {
                        echo '<pre>';
                        print_r($e);
                        echo '</pre>';
                        echo '<p style="color:red;">' . htmlspecialchars($e->getMessage()) . '</p>';
                    }

                    // Verifica se a lista de fornecedores não está vazia
                    if (isset($listaFornecedores) && !empty($listaFornecedores)) :
                        foreach ($listaFornecedores as $fornecedor) :
                    ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fornecedor['fornecedor_id']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['nome']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['telefone']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['email']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['cnpj']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['rua']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['numero']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['complemento']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['bairro']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['cidade']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['estado']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['cep']); ?></td>
                                <td class="botao">
                                    <a class="edit-link" href="editarFornecedor.php?id=<?php echo htmlspecialchars($fornecedor['fornecedor_id']); ?>">Editar</a>
                                    <a class="delete-link" href="listaFornecedor.php?excluir_fornecedor_id=<?php echo htmlspecialchars($fornecedor['fornecedor_id']); ?>" onclick="return confirm('Tem certeza que deseja excluir este fornecedor?');">Excluir</a>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                    else :
                        ?>
                        <tr>
                            <td colspan="15">Nenhum fornecedor encontrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </main>





</body>

</html>