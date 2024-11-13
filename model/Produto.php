<?php
require_once 'global.php';
class Produto
{
    private $produtoId; // Adicionando o campo produto
    private $nome;
    private $categoria;
    private $marca;
    private $peso;
    private $dimensoes;
    private $numeroLote;
    private $numeroSerie;
    private $codigoBarras;
    private $fornecedorId;
    private $dataFabricacao;
    private $dataValidade;

    private $dataRecebimento;

    private $quantidade_reservada;
    private $statusProduto;
    // Métodos set
    public function setProdutoId($produtoId)
    {
        $this->produtoId = $produtoId;
    } // Método para setar produto
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }
    public function setPeso($peso)
    {
        $this->peso = $peso;
    }
    public function setDimensoes($dimensoes)
    {
        $this->dimensoes = $dimensoes;
    }
    public function setNumeroLote($numeroLote)
    {
        $this->numeroLote = $numeroLote;
    }
    public function setNumeroSerie($numeroSerie)
    {
        $this->numeroSerie = $numeroSerie;
    }
    public function setCodigoBarras($codigoBarras)
    {
        $this->codigoBarras = $codigoBarras;
    }
    public function setFornecedorId($fornecedorId)
    {
        $this->fornecedorId = $fornecedorId;
    }
    public function setDataFabricacao($dataFabricacao)
    {
        $this->dataFabricacao = $dataFabricacao;
    }
    public function setDataValidade($dataValidade)
    {
        $this->dataValidade = $dataValidade;
    }

    public function setDataRecebimento($dataRecebimento)
    {
        $this->dataRecebimento = $dataRecebimento;
    }
    public function setQuantidade_reservada($quantidade_reservada)
    {
        $this->quantidade_reservada = $quantidade_reservada;
    }
    public function setStatusProduto($statusProduto)
    {
        $this->statusProduto = $statusProduto;
    }

    // Métodos get
    public function getProdutoId()
    {
        return $this->produtoId;
    } // Método para obter produto
    public function getNome()
    {
        return $this->nome;
    }
    public function getCategoriaId()
    {
        return $this->categoria;
    }
    public function getMarca()
    {
        return $this->marca;
    }
    public function getPeso()
    {
        return $this->peso;
    }
    public function getDimensoes()
    {
        return $this->dimensoes;
    }
    public function getNumeroLote()
    {
        return $this->numeroLote;
    }
    public function getNumeroSerie()
    {
        return $this->numeroSerie;
    }
    public function getCodigoBarras()
    {
        return $this->codigoBarras;
    }
    public function getFornecedorId()
    {
        return $this->fornecedorId;
    }
    public function getDataFabricacao()
    {
        // Certifique-se de que a data está no formato correto
        $data = $this->dataFabricacao; // Supondo que você tenha uma propriedade
        $dateTime = DateTime::createFromFormat('Y-m-d', $data);
        return $dateTime ? $dateTime->format('Y-m-d') : null; // Retorna nulo se o formato estiver errado
    }
    public function getDataValidade()
    {
        $data = $this->dataValidade; // Supondo que você tenha uma propriedade
        $dateTime = DateTime::createFromFormat('Y-m-d', $data);
        return $dateTime ? $dateTime->format('Y-m-d') : null; // Retorna nulo se o formato estiver errado
    }

    public function getDataRecebimento()
    {
        // Certifique-se de que a data está no formato correto
        $data = $this->dataRecebimento; // Supondo que você tenha uma propriedade
        $dateTime = DateTime::createFromFormat('Y-m-d', $data);
        return $dateTime ? $dateTime->format('Y-m-d') : null; // Retorna nulo se o formato estiver errado
    }
    public function getQuantidade_reservada()
    {
        return $this->quantidade_reservada;
    }
    public function getStatusProduto()
    {
        return $this->statusProduto;
    }
}
