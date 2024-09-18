// produtoModel.js
const db = require('../config/database');

// Listar todos os produtos
const getTodos = (callback) => {
    const sql = 'SELECT * FROM Produto';
    db.query(sql, callback);
};

// Adicionar um novo produto
const criar = (produto, callback) => {
    const sql = 'INSERT INTO Produto (nome, descricao, categoria, peso, dimensoes, fornecedor_id, data_fabricacao, data_validade) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    db.query(sql, [produto.nome, produto.descricao, produto.categoria, produto.peso, produto.dimensoes, produto.fornecedor_id, produto.data_fabricacao, produto.data_validade], callback);
};

module.exports = { getTodos, criar };
