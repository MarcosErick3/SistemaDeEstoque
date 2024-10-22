<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/login.css">
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
        <form action="" method="post" id="form">
            <div class="input-group">
                <label for="usuario">Usuário</label>
                <input type="text" name="usuario" id="usuario" require autofocus checked>
            </div>
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            <div class="links">
                <button type="submit" class="btn">Entrar</button>
                <a href="" class="btn-cadastrar">Cadastrar</a>
            </div>
        </form>
    </main>
</body>

</html>