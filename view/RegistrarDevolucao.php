<form action="../controller/registrarDevolucao.php" method="POST">
    <label for="produto_id">Produto</label>
    <input type="text" name="produto_id" id="produto_id" placeholder="ID ou Nome do Produto" required>
    
    <label for="categoria">Categoria</label>
    <input type="text" name="categoria" id="categoria" required>


    <label for="fornecedor_id">Fornecedor</label>
    <input type="text" name="fornecedor_id" id="fornecedor_id" placeholder="ID ou Nome do Fornecedor" required>

    <label for="quantidade">Quantidade</label>
    <input type="number" name="quantidade" id="quantidade" min="1" required>

    <label for="data_devolucao">Data da Devolução</label>
    <input type="date" name="data_devolucao" id="data_devolucao" required>

    <label for="motivo">Motivo da Devolução</label>
    <select name="motivo" id="motivo" required>
        <option value="">Selecione o Motivo</option>
        <option value="Danos">Danos</option>
        <option value="Produto incorreto">Produto incorreto</option>
        <option value="Insatisfação">Insatisfação</option>
    </select>

    <button type="submit">Registrar Devolução</button>
</form>