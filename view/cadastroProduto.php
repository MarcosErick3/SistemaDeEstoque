<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/produto/cadastroProduto.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="shortcut icon" href="../img/logo.jpg" type="image/x-icon">
    <title>Smart Stock - Cadastro de Produto</title>
</head>

<body>
<header id="header">
        <nav id="navbar">
            <h1 id="system-name">Smart Stock</h1>
            <ul id="nav">
                <li class="nav-item"><a href="cadastroProduto.php">Cadastro de Produtos</a></li>
                <li class="nav-item"><a href="listaProduto.php">Buscar Produtos</a></li>
                <li class="nav-item"><a href="movimentacao.php">Movimentação</a></li>
                <li class="nav-item"><a href="mapaAmazem.php">Mapa do Armazenamem</a></li>
                <li class="nav-item"><a href="iventario.php">Inventário</a></li>
                <li class="nav-item"><a href="RegistrarDevolucao.php">Registrar Devolução</a></li>
                <li class="nav-item"><a href="RelatorioDeDevoluçoes.php">Relatório de Devoluções</a></li>
                <li class="nav-item"><a href="registrarSaidaProduto.php">Saída do Produto</a></li>
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
                        <option value="Alimentos">Alimenticios</option>
                        <option value="Brinquedos">Brinquedos</option>
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
                    <label for="dataRecebimento">Data de Recebimento</label>
                    <input type="date" id="dataRecebimento" name="data_recebimento" required>
                </div>
            </div>
            <div class="botao">
                <button type="submit" class="btn">Cadastrar Produto</button>
                <button type="button" class="btn btn-clear" onclick="resetar()">Resetar</button>
            </div>
        </form>



    </main>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-left">
                <p>&copy; 2024 Smart Stock. Todos os direitos reservados.</p>
            </div>
            <div class="footer-right">
                <a href="https://www.linkedin.com/in/seunome" target="_blank">LinkedIn</a> |
                <a href="https://github.com/seunome" target="_blank">GitHub</a>
            </div>
        </div>
    </footer>
    <script>
        function resetar() {
            window.location.reload();
        }

        function toggleValidade() {
            const dataValidade = document.getElementById('dataValidade');
            const naoAplicaCheckbox = document.getElementById('naoAplicaValidade');

            if (naoAplicaCheckbox.checked) {
                dataValidade.value = ""; 
                dataValidade.disabled = true; 
            } else {
<<<<<<< HEAD
                dataValidade.disabled = false;
                dataValidade.value = "";
=======
                dataValidade.disabled = false; 
                dataValidade.value = ""; 
>>>>>>> 5c7aff2cc7fd4bcddf5e60cca1220966df79c99d
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
            const hoje = new Date();
            const ano = hoje.getFullYear();
            const mes = String(hoje.getMonth() + 1).padStart(2, '0');
            const dia = String(hoje.getDate()).padStart(2, '0');
            const hojeFormatado = `${ano}-${mes}-${dia}`;
            dataFabricacao.value = hojeFormatado;
            preencherCamposAutomaticamente();
        };
    </script>
</body>

</html>