<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Fornecedor</title>
    <link rel="stylesheet" href="../css/fornecedor/cadastroFornecedor.css">
</head>

<body>
    <header id="header">
        <nav id="navbar">
            <ul id="nav">
                <li class="nav-item"><a href="cadastroFornecedor.php">Cadastro de Fornecedor</a></li>
                <li class="nav-item"><a href="listaFornecedor.php">Lista de Fornecedor</a></li>
                <li class="nav-item"><a href="cadastroProduto.php">Cadastro de Produtos</a></li>
                <li class="nav-item"><a href="listaProduto.php">Lista de Produtos</a></li>
                <li class="nav-item"><a href="../index.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form action="../controller/cadastroFornecedor.php" method="post" id="form">
            <div class="form-main">
                <div class="input-column">
                    <div class="input-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite o nome do fornecedor" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Digite o email do fornecedor" required>
                    </div>
                </div>
                <div class="input-column">
                    <div class="input-group">
                        <label for="cep">CEP</label>
                        <input type="text" id="cep" name="cep" class="form-control" required oninput="formatCEP(this)" placeholder="Digite seu cep">
                    </div>
                    <div class="input-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" id="bairro" name="bairro" class="form-control" placeholder="Digite o bairro" required disabled>
                    </div>
                </div>
                <div class="input-column">
                    <div class="input-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade" class="form-control" placeholder="Digite a cidade" required disabled>
                    </div>
                    <div class="input-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" id="complemento" name="complemento" class="form-control" placeholder="Digite o complemento">
                    </div>
                </div>
                <div class="input-column">
                    <div class="input-group">
                        <label for="cnpj">CNPJ:</label>
                        <input type="text" id="cnpj" name="cnpj" class="form-control" required oninput="formatCNPJ(this)" placeholder="Digite seu CNPJ">
                    </div>
                    <div class="input-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" id="telefone" name="telefone" class="form-control" oninput="formatTelefone(this)" placeholder="Digite o telefone do fornecedor" maxlength="15" required>
                    </div>
                </div>
                <div class="input-column">
                    <div class="input-group">
                        <label for="rua">Rua</label>
                        <input type="text" id="rua" name="rua" class="form-control" placeholder="Digite a rua" required disabled>
                    </div>
                    <div class="input-group">
                        <label for="numero">Número</label>
                        <input type="text" id="numero" name="numero" class="form-control" placeholder="Digite o número da rua" required>
                    </div>
                </div>
                <div class="input-column">
                    <div class="input-group">
                        <label for="estado">Estado</label>
                        <input type="text" id="estado" name="estado" class="form-control" placeholder="Digite o estado" required disabled>
                    </div>
                </div>
                <div class="botao">
                    <button type="submit" class="btn">Cadastrar</button>
                    <button type="reset" class="btn btn-clear">Limpar</button>
                </div>
            </div>
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

                if (telefone.length > 11) {
                    telefone = telefone.substring(0, 11);
                }

                if (telefone.length > 10) {
                    telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
                } else if (telefone.length > 6) {
                    telefone = telefone.replace(/^(\d{2})(\d{4})(\d{4})$/, "($1) $2-$3");
                } else if (telefone.length > 2) {
                    telefone = telefone.replace(/^(\d{2})(\d{4})$/, "($1) $2");
                }

                telefoneField.value = telefone;
            }
        </script>
        <script src="../JS/BuscaCep.js"></script>
    </main>
</body>

</html>