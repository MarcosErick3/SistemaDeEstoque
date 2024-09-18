const produtoModel = require('../models/produtoModel');

// Listar todos os produtos
exports.getTodosProdutos = (req, res) => {
    produtoModel.getTodos((err, produtos) => {
        if (err) {
            return res.status(500).json({ error: 'Erro ao buscar produtos.' });
        }
        res.json(produtos);
    });
};

// Criar um novo produto
exports.criarProduto = (req, res) => {
    const novoProduto = req.body;
    produtoModel.criar(novoProduto, (err, result) => {
        if (err) {
            return res.status(500).json({ error: 'Erro ao adicionar produto.' });
        }
        res.json({ message: 'Produto cadastrado com sucesso!', produtoId: result.insertId });
    });
};

// Atualizar um produto
exports.atualizarProduto = (req, res) => {
    const { id } = req.params;
    const produtoAtualizado = req.body;
    produtoModel.atualizar(id, produtoAtualizado, (err, result) => {
        if (err) {
            return res.status(500).json({ error: 'Erro ao atualizar produto.' });
        }
        res.json({ message: 'Produto atualizado com sucesso!' });
    });
};

// Deletar um produto
exports.deletarProduto = (req, res) => {
    const { id } = req.params;
    produtoModel.deletar(id, (err, result) => {
        if (err) {
            return res.status(500).json({ error: 'Erro ao deletar produto.' });
        }
        res.json({ message: 'Produto deletado com sucesso!' });
    });
};
