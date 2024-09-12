<?php
    //função que faz parte da SPL que significa Standard PHP Library
    spl_autoload_register('carregarClasse');
    
    function carregarClasse($nomeClasse)
    {
        if (file_exists('../../' . $nomeClasse . '.php')) 
        {
            require_once '../../' . $nomeClasse . '.php';
        }
        if(file_exists('../../Database' . $nomeClasse . '.php')) 
        {
            require_once '../../Database' . $nomeClasse . '.php';
        }
        if(file_exists('../../Controller' . $nomeClasse . '.php')) 
        {
            require_once '../../Controller' . $nomeClasse . '.php';
        }
    }

?>