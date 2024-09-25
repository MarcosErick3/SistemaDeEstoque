<?php
require_once 'global.php';

class Produto
{
    private $produtoId;
    private $nome;
    private $descricao;
    private $categoria;
    private $marca;
    private $peso; // Se o peso for necessário
    private $dimensoes;
    private $numeroLote;
    private $numeroSerie;
    private $codBarras;
    private $fornecedorId;
    private $dataFabricacao;
    private $dataValidade;
    private $precoCusto;
    private $precoVenda;

    // Métodos set
    public function setProdutoId($produtoId)
    {
        $this->produtoId = $produtoId;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
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

    public function setCodBarras($codBarras)
    {
        $this->codBarras = $codBarras;
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

    public function setPrecoCusto($precoCusto)
    {
        $this->precoCusto = $precoCusto;
    }

    public function setPrecoVenda($precoVenda)
    {
        $this->precoVenda = $precoVenda;
    }

    // Métodos get
    public function getCodigo()
    {
        return $this->produtoId;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getCategoria()
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

    public function getCodBarras()
    {
        return $this->codBarras;
    }

    public function getFornecedorId()
    {
        return $this->fornecedorId;
    }

    public function getDataFabricacao()
    {
        return $this->dataFabricacao;
    }

    public function getDataValidade()
    {
        return $this->dataValidade;
    }

    public function getPrecoCusto()
    {
        return $this->precoCusto;
    }

    public function getPrecoVenda()
    {
        return $this->precoVenda;
    }
}
