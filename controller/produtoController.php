
<?php
include_once 'global.php';

class ProdutoController
{
    private $produtoModel;
    private $localizacaoModel;

    public function __construct()
    {
        $this->produtoModel = new Produto();
        $this->localizacaoModel = new Localizacao();
    }

    public function buscarProduto($corredor, $prateleira, $coluna, $andar)
    {
        return $this->produtoModel->getProdutosPorLocalizacao($corredor, $prateleira, $coluna, $andar);
    }
}
?>
