<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/produto/cadastroProduto.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Cadastro de Produto</title>
    <style>
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http: 16 16" fill="gray"><path d="M2 6h12L8 12 2 6z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }

        select:hover {
            border-color: #888;
        }

        select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .input-group {
            position: relative;
        }
    </style>
</head>

<body>
    <header id="header">
        <nav id="navbar">
            <h1 id="system-name">Smart Stock</h1>
            <ul id="nav">
                <li class="nav-item"><a href="cadastroProduto.php">Cadastro de Produtos</a></li>
                <li class="nav-item"><a href="listaProduto.php">Buscar Produtos</a></li>
                <li class="nav-item"><a href="registrarInventario.php">Registrar Inventário</a></li>
                <li class="nav-item"><a href="registrarSaidaProduto.php">Saída do Produto</a></li>
                <li class="nav-item"><a href="Armazenamento.php">Armazenamento</a></li>
                <li class="nav-item"><a href="ExpediçãodeMercadoria.php">Expedição de Mercadoria</a></li>
                <li class="nav-item"><a href="movimentacao.php">Movimentação</a></li>
                <li class="nav-item"><a href="RegistrarDevolucao.php">Registrar Devolucao</a></li>
                <li class="nav-item"><a href="RelatorioDeDevoluçoes.php">Relatorio De Devoluçoes</a></li>
                <li class="nav-item"><a href="../index.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        require 'global.php';

        try {
            $listaFornecedores = FornecedorDAO::listarFornecedor();
        } catch (Exception $e) {
            echo '<pre>';
            print_r($e);
            echo '</pre>';
            echo '<p style="color:red;">' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        ?>

        <form id="form" action="../controller/cadastroProduto.php" method="post" class="form-main">
            <div class="input-column">
                <div class="input-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" required placeholder="Digite o nome do produto">
                </div>
                <div class="input-group">
                    <label for="categoria">Categoria</label>
                    <select name="categoria" id="categoria" required>
                        <option value="">Selecione uma categoria</option>
                        <option value="Eletrônicos">Eletrônicos</option>
                        <option value="Vestuário">Vestuário</option>
                        <option value="Alimentos">Alimentos</option>
                        <option value="Móveis">Móveis</option>
                        <option value="Ferramentas">Ferramentas</option>
                    </select>
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="marca">Marca</label>
                    <input type="text" id="marca" name="marca" required placeholder="Digite a marca do produto">
                </div>
                <div class="input-group">
                    <label for="peso">Peso (kg)</label>
                    <input type="number" id="peso" name="peso" required step="0.01" placeholder="Ex: 1.5">
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="dimensoes">Dimensões (altura x largura x comprimento)</label>
                    <input type="text" id="dimensoes" name="dimensoes" required placeholder="Ex: 10x20x30">
                </div>
                <div class="input-group">
                    <label for="numeroLote">Número de Lote</label>
                    <input type="text" id="numeroLote" name="numero_lote" required placeholder="Digite o número do lote">
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="numeroSerie">Número de Série</label>
                    <input type="text" id="numeroSerie" name="numero_serie" required placeholder="Digite o número de série">
                </div>
                <div class="input-group">
                    <label for="codigoBarras">Código de Barras</label>
                    <input type="text" id="codigoBarras" name="codigo_barras" required placeholder="Digite o código de barras">
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="fornecedor_id">Fornecedor</label>
                    <?php if (isset($listaFornecedores) && !empty($listaFornecedores)) { ?>
                        <select name="fornecedor_id" id="fornecedor_id" required>
                            <option value="">Selecione um Fornecedor</option>
                            <?php foreach ($listaFornecedores as $listaFornecedor) { ?>
                                <option value="<?php echo htmlspecialchars($listaFornecedor['fornecedor_id']); ?>">
                                    <?php echo htmlspecialchars($listaFornecedor['nome']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    <?php } else {
                        echo '<p>Nenhum fornecedor disponível.</p>';
                    } ?>
                </div>
                <div class="input-group">
                    <label for="dataFabricacao">Data de Fabricação</label>
                    <input type="date" id="dataFabricacao" name="data_fabricacao" required>
                </div>
            </div>
            <div class="input-column">
                <div class="input-group">
                    <label for="dataValidade">Data de Validade</label>
                    <input type="date" id="dataValidade" name="data_validade" required>
                    <label for="naoSeAplica">Não se aplica</label>
                    <input type="checkbox" id="naoAplicaValidade" onclick="toggleValidade()">
                </div>
                <div class="input-group">
                    <label for="quantidade_reservada">Quantidade Disponivel:</label>
                    <input type="number" id="quantidade_reservada" name="quantidade_reservada" required>
                </div>
            </div>
            <div class="botao">
                <button type="submit" class="btn">Cadastrar Produto</button>
                <button type="reset" class="btn btn-clear">Limpar</button>
            </div>
        </form>



    </main>
    <script>
        function toggleValidade() {
            const dataValidade = document.getElementById('dataValidade');
            const naoAplicaCheckbox = document.getElementById('naoAplicaValidade');

            if (naoAplicaCheckbox.checked) {
                dataValidade.value = "";
                dataValidade.disabled = true;
            } else {
                dataValidade.disabled = false;
            }
        }


        function gerarCodigoBarras() {
            let codigo = '';
            for (let i = 0; i < 13; i++) {
                codigo += Math.floor(Math.random() * 10);
            }
            return codigo;
        }


        function gerarNumeroLote() {
            const prefixo = 'LOT';
            let numeroLote = prefixo;
            for (let i = 0; i < 5; i++) {
                numeroLote += Math.floor(Math.random() * 10);
            }
            return numeroLote;
        }


        function gerarNumeroSerie() {
            const prefixo = 'SER';
            let numeroSerie = prefixo;
            for (let i = 0; i < 7; i++) {
                numeroSerie += Math.floor(Math.random() * 10);
            }
            return numeroSerie;
        }


        function preencherCamposAutomaticamente() {
            document.getElementById('codigoBarras').value = gerarCodigoBarras();
            document.getElementById('numeroLote').value = gerarNumeroLote();
            document.getElementById('numeroSerie').value = gerarNumeroSerie();
        }
        window.onload = function() {
            const dataFabricacao = document.getElementById('dataFabricacao');
            const hoje = new Date().toISOString().split('T')[0]; // Formato AAAA-MM-DD
            dataFabricacao.value = hoje;
            preencherCamposAutomaticamente();
        };
    </script>
</body>

</html>