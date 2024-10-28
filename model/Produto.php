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
    private $zona;
    private $endereco;
    private $quantidadeReservada;
    private $statusProduto;
    private $corredor;
    private $prateleira;
    private $nivel;
    private $posicao;

    // Construtor com parâmetros padrão
    public function __construct(
        $produtoId = 0, // Adicionando parâmetro para produto
        $nome = '',
        $categoria = '',
        $marca = '',
        $peso = 0.0,
        $dimensoes = '',
        $numeroLote = '',
        $numeroSerie = '',
        $codigoBarras = '',
        $fornecedorId = 0,
        $dataFabricacao = '',
        $dataValidade = '',
        $zona = '',
        $endereco = '',
        $quantidadeReservada = 0,
        $statusProduto = '',
        $corredor = '',
        $prateleira = '',
        $nivel = '',
        $posicao = ''
    ) {
        $this->produtoId = $produtoId; // Inicializando produto
        $this->nome = $nome;
        $this->categoria = $categoria;
        $this->marca = $marca;
        $this->peso = $peso;
        $this->dimensoes = $dimensoes;
        $this->numeroLote = $numeroLote;
        $this->numeroSerie = $numeroSerie;
        $this->codigoBarras = $codigoBarras;
        $this->fornecedorId = $fornecedorId;
        $this->dataFabricacao = $dataFabricacao;
        $this->dataValidade = $dataValidade;
        $this->zona = $zona;
        $this->endereco = $endereco;
        $this->quantidadeReservada = $quantidadeReservada;
        $this->statusProduto = $statusProduto;
        $this->corredor = $corredor;
        $this->prateleira = $prateleira;
        $this->nivel = $nivel;
        $this->posicao = $posicao;
    }

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
    public function setZona($zona)
    {
        $this->zona = $zona;
    }
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }
    public function setQuantidadeReservada($quantidadeReservada)
    {
        $this->quantidadeReservada = $quantidadeReservada;
    }
    public function setStatusProduto($statusProduto)
    {
        $this->statusProduto = $statusProduto;
    }
    public function setCorredor($corredor)
    {
        $this->corredor = $corredor;
    }
    public function setPrateleira($prateleira)
    {
        $this->prateleira = $prateleira;
    }
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }
    public function setPosicao($posicao)
    {
        $this->posicao = $posicao;
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
        return $this->dataFabricacao;
    }
    public function getDataValidade()
    {
        return $this->dataValidade;
    }
    public function getZona()
    {
        return $this->zona;
    }
    public function getEndereco()
    {
        return $this->endereco;
    }
    public function getQuantidadeReservada()
    {
        return $this->quantidadeReservada;
    }
    public function getStatusProduto()
    {
        return $this->statusProduto;
    }
    public function getCorredor()
    {
        return $this->corredor;
    }
    public function getPrateleira()
    {
        return $this->prateleira;
    }
    public function getNivel()
    {
        return $this->nivel;
    }
    public function getPosicao()
    {
        return $this->posicao;
    }
}
