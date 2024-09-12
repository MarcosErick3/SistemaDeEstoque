<?php
class Conexao
{
    public static function conectar()
    {
        try {
            
            $conexao = new PDO("mysql:host=localhost;dbname=bdsistemaestoque", "root", "02072004mM.");

            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "Conectado com sucesso!";

            return $conexao;
        } catch (PDOException $e) {
            // Se houver erro na conexão, captura a exceção e exibe a mensagem
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
            return null;
        }
    }
}

Conexao::conectar();
