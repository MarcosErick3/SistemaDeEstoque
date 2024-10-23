<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Fornecedores</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        #header {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
        }

        #navbar {
            display: flex;
            justify-content: space-around;
        }

        #nav {
            list-style-type: none;
            display: flex;
            gap: 20px;
        }

        .nav-item a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .nav-item a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .form-main {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 1500px;
            margin: 20px auto;
        }

        .input-column {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .input-group {
            flex: 1;
            margin: 0 10px;
            min-width: 220px;
        }

        .input-group label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .botao {
            display: flex;
            align-self: center;
            justify-content: center;
            gap: 32px;
            margin-top: 20px;
        }

        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-clear {
            background-color: #f44336;
        }

        .btn-clear:hover {
            background-color: #d32f2f;
        }

        input[disabled] {
            background-color: #f7f7f7;
        }

        .table-container {
            margin: 20px;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .styled-table thead tr {
            background-color: #007bff;
            color: white;
            text-align: left;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #007bff;
        }

        .edit-link,
        .delete-link {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
        }

        .edit-link:hover,
        .delete-link:hover {
            text-decoration: underline;
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
    <main id="main">
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
        if (isset($listaFornecedores) && !empty($listaFornecedores)) {
        ?>
            <div class="table-container">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>CNPJ</th>
                            <th>Rua</th>
                            <th>Número</th>
                            <th>Bairro</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                            <th>CEP</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaFornecedores as $fornecedor) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fornecedor['fornecedor_id']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['nome']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['telefone']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['email']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['cnpj']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['rua']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['numero']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['bairro']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['cidade']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['estado']); ?></td>
                                <td><?php echo htmlspecialchars($fornecedor['cep']); ?></td>
                                <td>
                                    <a class="edit-link" href="editarFornecedor.php?id=<?php echo htmlspecialchars($fornecedor['fornecedor_id']); ?>">Editar</a>
                                    <a class="delete-link" href="listaFornecedor.php?excluir_fornecedor_id=<?php echo htmlspecialchars($fornecedor['fornecedor_id']); ?>" onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
            echo '<p>Nenhum fornecedor encontrado.</p>';
        }
        ?>
    </main>




</body>

</html>