<?php
require_once 'global.php';
class Conexao
{
    public static function conectar()
    {
        // $conexao = new PDO("TIPO_BANCO:host=SERVIDOR;dbname=NOME_BANCO", "USUARIO", "SENHA"); 
        $conexao = new PDO(
            "mysql:host=localhost;dbname=sistemaestoque",
            "root",
            "02072004mM."
        );
        //mysqli
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conexao;
    }
}
