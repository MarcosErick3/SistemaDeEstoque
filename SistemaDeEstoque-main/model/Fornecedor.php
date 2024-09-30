<?php
class Fornecedor
{
    private $fornecedorId;
    private $nome;
    private $telefone;
    private $email;
    private $cnpj;
    private $rua;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;

    // Getters e setters
    public function getFornecedorId()
    {
        return $this->fornecedorId;
    }
    public function setFornecedorId($fornecedorId)
    {
        $this->fornecedorId = $fornecedorId;
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    public function getRua()
    {
        return $this->rua;
    }
    public function setRua($rua)
    {
        $this->rua = $rua;
    }

    public function getNumero()
    {
        return $this->numero;
    }
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getComplemento()
    {
        return $this->complemento;
    }
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    public function getBairro()
    {
        return $this->bairro;
    }
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function getCidade()
    {
        return $this->cidade;
    }
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getCep()
    {
        return $this->cep;
    }
    public function setCep($cep)
    {
        $this->cep = $cep;
    }
}
