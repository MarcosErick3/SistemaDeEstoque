<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Document</title>
    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <main id="main">
        <form action="./controller/processaLogin.php" method="post" id="form">
            <div class="input-group">
                <label for="usuario">Usuário</label>
                <input type="text" name="usuario" id="usuario" required autofocus>
            </div>
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            <div class="error-message" id="loginError"></div>
            <div class="links">
                <button type="submit" class="btn">Entrar</button>
            </div>
        </form>
    </main>

    <script>
        document.getElementById('form').addEventListener('submit', function(event) {
            var usuario = document.getElementById('usuario').value;
            var senha = document.getElementById('senha').value;
            var errorElement = document.getElementById('loginError');
            if (usuario !== 'adm' || senha !== '123') {
                event.preventDefault(); 
                errorElement.textContent = 'Usuário ou senha incorretos.';
            }
        });
    </script>
</body>

</html>
