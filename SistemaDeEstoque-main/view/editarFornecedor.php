<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fornecedor/editarFornecedor.css">
    <title>Editar Fornecedor</title>
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
        <?php
        require "global.php";
        if (isset($_GET['id'])) {
            $fornecedorId = $_GET['id'];
            try {
                $fornecedor = FornecedorDAO::buscarFornecedorPorId($fornecedorId);
            } catch (Exception $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                echo $e->getMessage();
            }
            if (isset($fornecedor) && is_array($fornecedor)) {
        ?>
                <form action="../controller/processaEdicaoFornecedor.php" method="post" id="form">
                    <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($fornecedor['fornecedor_id']); ?>">

                    <div>
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($fornecedor['nome']); ?>" required>
                    </div>

                    <div>
                        <label for="telefone">Telefone:</label>
                        <input type="text" id="telefone" name="telefone" oninput="formatTelefone(this)" value="<?php echo htmlspecialchars($fornecedor['telefone']); ?>" required>
                    </div>

                    <div>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($fornecedor['email']); ?>" required>
                    </div>

                    <div>
                        <label for="cnpj">CNPJ:</label>
                        <input type="text" id="cnpj" name="cnpj" oninput="formatCNPJ(this)" value="<?php echo htmlspecialchars($fornecedor['cnpj']); ?>" required>
                    </div>

                    <div>
                        <label for="rua">Rua:</label>
                        <input type="text" id="rua" name="rua" value="<?php echo htmlspecialchars($fornecedor['rua']); ?>" required>
                    </div>

                    <div>
                        <label for="numero">Número:</label>
                        <input type="text" id="numero" name="numero" value="<?php echo htmlspecialchars($fornecedor['numero']); ?>" required>
                    </div>

                    <div>
                        <label for="complemento">Complemento:</label>
                        <input type="text" id="complemento" name="complemento" value="<?php echo htmlspecialchars($fornecedor['complemento']); ?>">
                    </div>

                    <div>
                        <label for="bairro">Bairro:</label>
                        <input type="text" id="bairro" name="bairro" value="<?php echo htmlspecialchars($fornecedor['bairro']); ?>" required>
                    </div>

                    <div>
                        <label for="cidade">Cidade:</label>
                        <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($fornecedor['cidade']); ?>" required>
                    </div>

                    <div>
                        <label for="estado">Estado:</label>
                        <input type="text" id="estado" name="estado" value="<?php echo htmlspecialchars($fornecedor['estado']); ?>" required>
                    </div>

                    <div>
                        <label for="cep">CEP:</label>
                        <input type="text" id="cep" name="cep" oninput="formatCEP(this)" value="<?php echo htmlspecialchars($fornecedor['cep']); ?>" required>
                    </div>

                    <button type="submit">Salvar Alterações</button>
                </form>

                <script>
                    function formatCNPJ(cnpjField) {
                        let cnpj = cnpjField.value.replace(/\D/g, '');

                        if (cnpj.length > 14) {
                            cnpj = cnpj.substring(0, 14);
                        }

                        if (cnpj.length > 12) {
                            cnpj = cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
                        } else if (cnpj.length > 8) {
                            cnpj = cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})$/, "$1.$2.$3/$4");
                        } else if (cnpj.length > 5) {
                            cnpj = cnpj.replace(/^(\d{2})(\d{3})(\d{3})$/, "$1.$2.$3");
                        } else if (cnpj.length > 2) {
                            cnpj = cnpj.replace(/^(\d{2})(\d{3})$/, "$1.$2");
                        }

                        cnpjField.value = cnpj;
                    }

                    function formatCEP(cep) {
                        cep.value = cep.value.replace(/\D/g, '');
                        if (cep.value.length > 5) {
                            cep.value = cep.value.replace(/(\d{5})(\d)/, '$1-$2');
                        }
                    }

                    function formatTelefone(telefoneField) {
                        let telefone = telefoneField.value.replace(/\D/g, '');

                        if (telefone.length > 10) {
                            telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
                        } else if (telefone.length > 5) {
                            telefone = telefone.replace(/^(\d{2})(\d{5})(\d{0,4})$/, '($1) $2-$3');
                        } else if (telefone.length > 2) {
                            telefone = telefone.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
                        }

                        telefoneField.value = telefone;
                    }
                </script>

        <?php
            }
        }
        ?>


    </main>


</body>

</html>