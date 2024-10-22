<?php
spl_autoload_register('carregarClasse');

function carregarClasse($nomeClasse)
{
    if (file_exists(__DIR__ . '/../model/' . $nomeClasse . '.php')) {
        require_once __DIR__ . '/../model/' . $nomeClasse . '.php';
    }
    if (file_exists(__DIR__ . '/../dao/' . $nomeClasse . '.php')) {
        require_once __DIR__ . '/../dao/' . $nomeClasse . '.php';
    }
    if (file_exists(__DIR__ . '/../controller/' . $nomeClasse . '.php')) {
        require_once __DIR__ . '/../controller/' . $nomeClasse . '.php';
    }
}
?>
