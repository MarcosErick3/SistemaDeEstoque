<?php
require_once 'global.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['usuario']) && isset($_POST['senha'])) {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        if ($usuario === "adm" && $senha === "123") {
            $_SESSION['usuario'] = $usuario;
            header("Location: ../view/cadastroFornecedor.php");
            exit();
        } else {
            echo "Usuário ou senha incorretos.";
        }
    }
}
?>