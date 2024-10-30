<?php
require 'global.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar e validar os dados do formulário
    $produto_id = filter_input(INPUT_POST, 'produto_id', FILTER_SANITIZE_NUMBER_INT);
    $localizacao_id = filter_input(INPUT_POST, 'localizacao_id', FILTER_SANITIZE_NUMBER_INT);

    // Debug: verifique os valores recebidos
    var_dump($produto_id, $localizacao_id);

    // Verificar se os IDs são válidos
    if ($produto_id && $localizacao_id) {
        try {
            // Atualizar a localização
            ProdutoDAO::atualizarLocalizacao($produto_id, $localizacao_id); // Removido a quantidade aqui

            // Redirecionar para a página de sucesso ou para onde desejar
            header("Location: ../view/Armazenamento.php?produtoId=$produto_id"); // Corrigido para usar $produto_id
            exit();
        } catch (Exception $e) {
            echo '<pre>';
            print_r($e);
            echo '</pre>';
            echo '<p style="color:red;">Ocorreu um erro ao associar o produto à localização. Por favor, tente novamente mais tarde.</p>';
        }
    } else {
        echo '<p style="color:red;">Dados inválidos. Por favor, verifique e tente novamente.</p>';
    }
}
