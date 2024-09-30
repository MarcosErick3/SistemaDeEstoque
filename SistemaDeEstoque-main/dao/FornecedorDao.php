<?php
require_once "global.php";

class FornecedorDAO
{
    public static function cadastrar($fornecedor)
    {
        try {
            $conexao = Conexao::conectar();
            $query = "INSERT INTO fornecedor (fornecedor_id, nome, telefone, email, cnpj, rua, numero, complemento, bairro, cidade, estado, cep) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexao->prepare($query);
            $stmt->bindValue(1, $fornecedor->getFornecedorId());
            $stmt->bindValue(2, $fornecedor->getNome());
            $stmt->bindValue(3, $fornecedor->getTelefone());
            $stmt->bindValue(4, $fornecedor->getEmail());
            $stmt->bindValue(5, $fornecedor->getCnpj());
            $stmt->bindValue(6, $fornecedor->getRua());
            $stmt->bindValue(7, $fornecedor->getNumero());
            $stmt->bindValue(8, $fornecedor->getComplemento());
            $stmt->bindValue(9, $fornecedor->getBairro());
            $stmt->bindValue(10, $fornecedor->getCidade());
            $stmt->bindValue(11, $fornecedor->getEstado());
            $stmt->bindValue(12, $fornecedor->getCep());

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Fornecedor cadastrado com sucesso!';
            } else {
                return 'Erro ao cadastrar o fornecedor';
            }
        } catch (PDOException $e) {
            throw new Exception('Erro ao cadastrar o fornecedor: ' . $e->getMessage());
        }
    }

    public static function listarFornecedor()
    {
        try {
            $conexao = Conexao::conectar();
            $querySelect = "SELECT fornecedor_id, nome, telefone, email, cnpj, rua, numero, complemento, bairro, cidade, estado, cep FROM fornecedor";
            $resultado = $conexao->query($querySelect);
            $lista = $resultado->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } catch (PDOException $e) {
            throw new Exception("Erro ao listar fornecedores: " . $e->getMessage());
        }
    }

    public static function buscarFornecedorPorNome($nome)
    {
        try {
            $conexao = Conexao::conectar();
            $querySelect = "SELECT * FROM fornecedor WHERE nome = :nome";
            $stmt = $conexao->prepare($querySelect);
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->execute();

            // Retorna o fornecedor encontrado ou null se não existir
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar fornecedor pelo nome: " . $e->getMessage());
        }
    }


    public static function buscarFornecedorPorId($id)
    {
        try {
            $conexao = Conexao::conectar();
            $querySelect = "SELECT * FROM fornecedor WHERE fornecedor_id = :id";
            $stmt = $conexao->prepare($querySelect);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);
            return $fornecedor;
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar fornecedor por ID: " . $e->getMessage());
        }
    }

    public static function editarFornecedor($fornecedor)
    {
        try {
            $conexao = Conexao::conectar();
            $queryUpdate = "UPDATE fornecedor SET 
                nome = :nome, 
                telefone = :telefone, 
                email = :email, 
                cnpj = :cnpj, 
                rua = :rua, 
                numero = :numero, 
                complemento = :complemento, 
                bairro = :bairro, 
                cidade = :cidade, 
                estado = :estado, 
                cep = :cep 
                WHERE fornecedor_id = :codigo";

            $stmt = $conexao->prepare($queryUpdate);
            $stmt->bindValue(':codigo', $fornecedor->getFornecedorId(), PDO::PARAM_INT);
            $stmt->bindValue(':nome', $fornecedor->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(':telefone', $fornecedor->getTelefone(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $fornecedor->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':cnpj', $fornecedor->getCnpj(), PDO::PARAM_STR);
            $stmt->bindValue(':rua', $fornecedor->getRua(), PDO::PARAM_STR);
            $stmt->bindValue(':numero', $fornecedor->getNumero(), PDO::PARAM_STR);
            $stmt->bindValue(':complemento', $fornecedor->getComplemento(), PDO::PARAM_STR);
            $stmt->bindValue(':bairro', $fornecedor->getBairro(), PDO::PARAM_STR);
            $stmt->bindValue(':cidade', $fornecedor->getCidade(), PDO::PARAM_STR);
            $stmt->bindValue(':estado', $fornecedor->getEstado(), PDO::PARAM_STR);
            $stmt->bindValue(':cep', $fornecedor->getCep(), PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar fornecedor: " . $e->getMessage());
        }
    }


    public static function excluirFornecedor($fornecedorId)
    {
        try {
            $conexao = Conexao::conectar();

            // Excluir produtos relacionados
            $stmtProdutos = $conexao->prepare("DELETE FROM produto WHERE fornecedor_id = :fornecedor_id");
            $stmtProdutos->bindValue(':fornecedor_id', $fornecedorId);
            $stmtProdutos->execute();

            // Agora excluir o fornecedor
            $stmtFornecedor = $conexao->prepare("DELETE FROM fornecedor WHERE fornecedor_id = :fornecedor_id");
            $stmtFornecedor->bindValue(':fornecedor_id', $fornecedorId);
            $stmtFornecedor->execute();

            return "Fornecedor excluído com sucesso.";
        } catch (PDOException $e) {
            throw new Exception("Erro ao excluir fornecedor: " . $e->getMessage());
        }
    }
}
