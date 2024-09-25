<?php
require_once 'global.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['cnpj'], $_POST['rua'], $_POST['numero'], $_POST['complemento'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['cep'])) {

        // Validação dos campos
        $cnpj = $_POST['cnpj'];
        $cep = $_POST['cep'];

        if (!isValidCNPJ($cnpj)) {
            header("Location: ../view/cadastroFornecedor.php?erro=" . urlencode("CNPJ inválido."));
            exit();
        }

        if (!isValidCEP($cep)) {
            header("Location: ../view/cadastroFornecedor.php?erro=" . urlencode("CEP inválido."));
            exit();
        }

        try {
            // Criando um objeto Fornecedor
            $fornecedor = new Fornecedor();
            $fornecedor->setNome($_POST['nome']);
            $fornecedor->setTelefone($_POST['telefone']);
            $fornecedor->setEmail($_POST['email']);
            $fornecedor->setCnpj($cnpj);
            $fornecedor->setRua($_POST['rua']);
            $fornecedor->setNumero($_POST['numero']);
            $fornecedor->setComplemento($_POST['complemento']);
            $fornecedor->setBairro($_POST['bairro']);
            $fornecedor->setCidade($_POST['cidade']);
            $fornecedor->setEstado($_POST['estado']);
            $fornecedor->setCep($cep);

            // Cadastrando o fornecedor no banco de dados
            $mensagem = FornecedorDao::cadastrar($fornecedor);

            // Redireciona para a página de sucesso ou lista de fornecedores
            header("Location: ../view/listaFornecedor.php?mensagem=" . urlencode("Fornecedor cadastrado com sucesso"));
            exit();
        } catch (Exception $e) {
            // Em caso de erro, redireciona com uma mensagem de erro
            header("Location: ../view/cadastroFornecedor.php?erro=" . urlencode($e->getMessage()));
            exit();
        }
    }
}

function isValidCNPJ($cnpj)
{
    $cnpj = preg_replace('/\D/', '', $cnpj); // Remove caracteres não numéricos

    if (strlen($cnpj) !== 14) {
        return false; // CNPJ deve ter 14 dígitos
    }

    // Adicione lógica de validação de CNPJ se necessário

    return true;
}

function isValidCEP($cep)
{
    $cep = preg_replace('/\D/', '', $cep); // Remove caracteres não numéricos

    if (strlen($cep) !== 8) {
        return false; // CEP deve ter 8 dígitos
    }

    return true;
}
