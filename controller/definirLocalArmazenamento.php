<?php
require_once 'global.php';
function definirLocalArmazenamento($categoria)
{
    $localizacao = [
        'Eletrônicos' => [
            'zona' => 'Zona A',
            'endereco' => 'Estante 1'
        ],
        'Alimentos' => [
            'zona' => 'Zona B',
            'endereco' => 'Estante 2'
        ],
        'Roupas' => [
            'zona' => 'Zona C',
            'endereco' => 'Estante 3'
        ],
        // Adicione mais categorias conforme necessário
    ];

    // Retorna a localização com base na categoria do produto
    return isset($localizacao[$categoria]) ? $localizacao[$categoria] : null;
}
