const db = require('../config/database');

exports.getTodos = (callback) => {
    db.query('SELECT * FROM Fornecedor', (err, results) => {
        if (err) return callback(err, null);
        callback(null, results);
    });
};

exports.buscarPorNome = (nome, callback) => {
    const sql = 'SELECT * FROM Fornecedor WHERE nome LIKE ?';
    db.query(sql, [`%${nome}%`], (err, results) => {
        if (err) return callback(err, null);
        callback(null, results);
    });
};

exports.criar = (fornecedor, callback) => {
    const sql = 'INSERT INTO Fornecedor (nome, endereco, telefone) VALUES (?, ?, ?)';
    db.query(sql, [fornecedor.nome, fornecedor.endereco, fornecedor.telefone], (err, result) => {
        if (err) return callback(err, null);
        callback(null, result);
    });
};

exports.atualizar = (id, fornecedor, callback) => {
    const sql = 'UPDATE Fornecedor SET nome = ?, endereco = ?, telefone = ? WHERE id = ?';
    db.query(sql, [fornecedor.nome, fornecedor.endereco, fornecedor.telefone, id], (err, result) => {
        if (err) return callback(err, null);
        callback(null, result);
    });
};

exports.deletar = (id, callback) => {
    const sql = 'DELETE FROM Fornecedor WHERE id = ?';
    db.query(sql, [id], (err, result) => {
        if (err) return callback(err, null);
        callback(null, result);
    });
};
