<?php
require 'global.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar e validar os dados do formulário
    $produto_id = filter_input(INPUT_POST, 'produto_id', FILTER_SANITIZE_NUMBER_INT);
    $localizacao_id = filter_input(INPUT_POST, 'localizacao_id', FILTER_SANITIZE_NUMBER_INT);

    // Verificar se os IDs são válidos
    if ($produto_id && $localizacao_id) {
        try {
            // Atualizar a localização e a quantidade reservada
            ProdutoDAO::atualizarLocalizacao($produto_id, $localizacao_id);

            // Redirecionar para a página de sucesso ou para onde desejar
            header("Location: ../view/Armazenamento.php?produtoId=$produtoId");
            exit();
        } catch (Exception $e) {
            // Exibir uma mensagem de erro ao usuário
            echo '<pre>';
            print_r($e);
            echo '</pre>';
            echo '<p style="color:red;">Ocorreu um erro ao associar o produto à localização. Por favor, tente novamente mais tarde.</p>';
        }
    } else {
        echo '<p style="color:red;">Dados inválidos. Por favor, verifique e tente novamente.</p>';
    }
}
