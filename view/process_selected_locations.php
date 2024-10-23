<?php
require 'global.php'; // Carrega a conexão e classes necessárias
// process_selected_locations.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Verifica se as localizações e produtoId foram recebidos
    if (isset($data['locations']) && isset($data['produtoId'])) {
        foreach ($data['locations'] as $localizacaoId) {
            // Chame a função de associação
            $result = LocalizacaoDAO::AssociarProdutoLocalizacao($data['produtoId'], $localizacaoId);
            if (!$result['success']) {
                echo json_encode(['success' => false, 'message' => $result['message']]);
                return; // Pare a execução se houver erro
            }
        }
        echo json_encode(['success' => true, 'message' => 'Associação realizada com sucesso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Dados não recebidos corretamente']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}
