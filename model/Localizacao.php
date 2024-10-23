<?php
require_once 'global.php';

class Localizacao
{
    // Propriedades
    private $localizacaoId;
    private $corredor;
    private $prateleira;
    private $coluna;
    private $andar;
    private $capacidadeTotal;
    private $ocupacaoAtual;

    // Métodos set
    public function setLocalizacaoId($localizacaoId)
    {
        $this->localizacaoId = $localizacaoId;
    }

    public function setCorredor($corredor)
    {
        $this->corredor = $corredor;
    }

    public function setPrateleira($prateleira)
    {
        $this->prateleira = $prateleira;
    }

    public function setColuna($coluna)
    {
        $this->coluna = $coluna;
    }

    public function setAndar($andar)
    {
        $this->andar = $andar;
    }

    public function setCapacidadeTotal($capacidadeTotal)
    {
        $this->capacidadeTotal = $capacidadeTotal;
    }

    public function setOcupacaoAtual($ocupacaoAtual)
    {
        $this->ocupacaoAtual = $ocupacaoAtual;
    }

    // Métodos get
    public function getLocalizacaoId()
    {
        return $this->localizacaoId;
    }

    public function getCorredor()
    {
        return $this->corredor;
    }

    public function getPrateleira()
    {
        return $this->prateleira;
    }

    public function getColuna()
    {
        return $this->coluna;
    }

    public function getAndar()
    {
        return $this->andar;
    }

    public function getCapacidadeTotal()
    {
        return $this->capacidadeTotal;
    }

    public function getOcupacaoAtual()
    {
        return $this->ocupacaoAtual;
    }

    // Método para exibir as informações da localização
    public function __toString()
    {
        return "ID: {$this->localizacaoId}, Corredor: {$this->corredor}, Prateleira: {$this->prateleira}, Coluna: {$this->coluna}, Andar: {$this->andar}, Capacidade Total: {$this->capacidadeTotal}, Ocupação Atual: {$this->ocupacaoAtual}";
    }
}
