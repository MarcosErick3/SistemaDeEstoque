<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/footer.css">
    <title>Login</title>
</head>

<body>
    <main id="main">
        <img src="img/logo.jpg" alt="Logo do Site" class="logo">
        <h1>LOGIN</h1>
        <form action="./controller/processaLogin.php" method="post" id="form">
            <div class="input-group">
                <label for="usuario">Usuário</label>
                <input type="text" name="usuario" id="usuario" required autofocus>
            </div>
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            <div class="error-message" id="loginError">Usuário ou senha incorretos.</div>
            <div class="links">
                <button type="submit" class="btn">Entrar</button>
            </div>
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
        document.getElementById('form').addEventListener('submit', function(event) {
            var usuario = document.getElementById('usuario').value;
            var senha = document.getElementById('senha').value;
            var errorElement = document.getElementById('loginError');

            if (usuario !== 'adm' || senha !== '123') {
                event.preventDefault();
                errorElement.style.display = 'block';
            }
        });
    </script>
</body>

</html>