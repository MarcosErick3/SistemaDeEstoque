const fornecedorModel = require('../models/fornecedorModel');

exports.getTodosFornecedores = (req, res) => {
    fornecedorModel.getTodos((err, fornecedores) => {
        if (err) {
            return res.status(500).json({ error: 'Erro ao buscar fornecedores.' });
        }
        res.json(fornecedores);
    });
};

exports.buscarFornecedores = (req, res) => {
    const nome = req.query.search;
    fornecedorModel.buscarPorNome(nome, (err, fornecedores) => {
        if (err) {
            return res.status(500).json({ error: 'Erro ao buscar fornecedores.' });
        }
        res.json(fornecedores);
    });
};

exports.criarFornecedor = (req, res) => {
    const novoFornecedor = req.body;
    fornecedorModel.criar(novoFornecedor, (err, result) => {
        if (err) {
            return res.status(500).json({ error: 'Erro ao adicionar fornecedor.' });
        }
        res.json({ message: 'Fornecedor cadastrado com sucesso!', fornecedorId: result.insertId });
    });
};

exports.atualizarFornecedor = (req, res) => {
    const { id } = req.params;
    const fornecedorAtualizado = req.body;
    fornecedorModel.atualizar(id, fornecedorAtualizado, (err, result) => {
        if (err) {
            return res.status(500).json({ error: 'Erro ao atualizar fornecedor.' });
        }
        res.json({ message: 'Fornecedor atualizado com sucesso!' });
    });
};

exports.deletarFornecedor = (req, res) => {
    const { id } = req.params;
    fornecedorModel.deletar(id, (err, result) => {
        if (err) {
            return res.status(500).json({ error: 'Erro ao deletar fornecedor.' });
        }
        res.json({ message: 'Fornecedor deletado com sucesso!' });
    });
};
