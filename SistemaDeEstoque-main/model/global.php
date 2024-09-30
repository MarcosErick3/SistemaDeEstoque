<?php
spl_autoload_register('carregarClasse');


if (!function_exists('carregarClasse')) {
    function carregarClasse($nomeClasse)
    {
        if (file_exists('model/' . $nomeClasse . '.php')) {
            require_once 'model/' . $nomeClasse . '.php';
        }
        if (file_exists('dao/' . $nomeClasse . '.php')) {
            require_once 'dao/' . $nomeClasse . '.php';
        }
        if (file_exists('controller/' . $nomeClasse . '.php')) {
            require_once 'controller/' . $nomeClasse . '.php';
        }
    }
}
