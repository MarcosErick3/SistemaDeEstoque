<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Smart Stock - WMS</title>
</head>

<body>
    <header>
        <h1>Smart Stock - WMS</h1>
    </header>
    <main>
        <section class="barra_buscar">
            <input type="text" id="buscar" placeholder="Buscar Produto">
        </section>

        <div class="container">
            <h2>Adicionar Produto</h2>
            <form action="/adicionar-produto" method="post" enctype="multipart/form-data">

                <!-- Identificação do Produto -->

                <div class="formulario">
                    <label for="nome_produto">Nome do Produto:</label>
                    <input type="text" id="nome_produto" name="nome_produto" required>
                </div>

                <div class="formulario">
                    <label for="codigo_produto">Código do Produto:</label>
                    <input type="text" id="codigo_produto" name="codigo_produto" required>
                </div>

                <div class="formulario">
                    <label for="categoria">Categoria:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Selecioe a Categoria</option>
                        <option value="">Eletrônicos</option>
                        <option value="">Alimentos</option>
                        <option value="">Brinquedos</option>
                    </select>
                </div>

                <div class="formulario">
                    <label for="subcategoria">Subcategoria:</label>
                    <input type="text" id="subcategoria" name="subcategoria">
                </div>

                <!-- Caracteristicas Físicas -->

                <div class="formulario">
                    <label for="peso">Peso(kg):</label>
                    <input type="number" step="0.01" id="peso" name="peso">
                </div>

                <div class="formulario">
                    <label for="dimensoes">Dimensões(cm):</label>
                    <input type="text" id="dimensoes" name="dimensoes" placeholder="Altura x Largura x Profundidade">
                </div>

                <div class="formulario">
                    <label for="volume">Volume(m³):</label>
                    <input type="number" step="0.001" id="volume" name="volume">
                </div>

                <!-- Estoque -->

                <div class="formulario">
                    <label for="qtd_inicial">Quantidade Inicial:</label>
                    <input type="number" id="qtd_inicial" name="qtd_inicial" required>
                </div>

                <div class="formulario">
                    <label for="unidade_medida">Unidade de Medida:</label>
                    <input type="text" id="unidade_medida" name="unidade_medida" required>
                </div>

                <!-- Localização no Armazém -->

                <div class="formulario">
                    <label for="endereco">Endereço/Localização:</label>
                    <input type="text" id="endereco" name="endereco">
                </div>

                <div class="formulario">
                    <label for="zona">Zona/Setor:</label>
                    <input type="text" id="zona" name="zona">
                </div>

                <!-- Informações Logisticas -->

                <div class="formulario">
                    <label for="data_validade">Data de Validade:</label>
                    <input type="date" id="data_validade" name="data_validade">
                </div>

                <div class="formulario">
                    <label for="numero_lote">Número de Lote:</label>
                    <input type="text" id="numero_lote" name="numero_lote">
                </div>

                <div class="formulario">
                    <label for="codigo_RFID">Código de RFID:</label>
                    <input type="text" id="codigo_RFID" name="codigo_RFID">
                </div>

                <div class="formulario">
                    <label for="num_serie">Número de Série:</label>
                    <input type="text" id="num_serie" name="num_serie">
                </div>

                <!-- Dados Adicionais -->
                <div class="formulario">
                    <label for="fornecedor">Fornecedor:</label>
                    <input type="text" id="fornecedor" name="fornecedor">
                </div>

                <div class="formulario">
                    <label for="preco_custo">Preço de Custo:</label>
                    <input type="number" step="0.01" id="preco_custo" name="preco_custo">
                </div>

                <div class="formulario">
                    <label for="preco_venda">Preço de Venda:</label>
                    <input type="number" step="0.01" id="preco_venda" name="preco_venda">
                </div>

                <!-- Botões -->
                <div class="formulario_botoes">
                    <button type="submit">Adicionar Produto</button>
                </div>
            </form>
        </div>

    </main>
</body>

</html>