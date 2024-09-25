<?php
require_once 'global.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo'])) {
    try {
        $fornecedor = new Fornecedor();
        $fornecedor->setFornecedorId($_POST['codigo']); 
        $fornecedor->setNome($_POST['nome']);
        $fornecedor->setTelefone($_POST['telefone']);
        $fornecedor->setEmail($_POST['email']);
        $fornecedor->setCnpj($_POST['cnpj']);
        $fornecedor->setRua($_POST['rua']);
        $fornecedor->setNumero($_POST['numero']);
        $fornecedor->setComplemento($_POST['complemento']);
        $fornecedor->setBairro($_POST['bairro']);
        $fornecedor->setCidade($_POST['cidade']);
        $fornecedor->setEstado($_POST['estado']);
        $fornecedor->setCep($_POST['cep']);

        
        if (FornecedorDAO::editarFornecedor($fornecedor)) {
            echo "Atualização realizada com sucesso.";
            header("Location: ../view/listaFornecedor.php");
        } else {
            echo "Nenhuma alteração foi realizada.";
        }
        exit();
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>
