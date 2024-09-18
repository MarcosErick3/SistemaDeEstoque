
const express = require('express');
const router = express.Router();
const fornecedorController = require('../controllers/fornecedorController');

// Rota para listar todos os fornecedores
router.get('/', fornecedorController.getTodosFornecedores);

// Rota para buscar fornecedores por nome
router.get('/search', fornecedorController.buscarFornecedores);

// Rota para adicionar um novo fornecedor
router.post('/', fornecedorController.criarFornecedor);

// Rota para atualizar um fornecedor
router.put('/:id', fornecedorController.atualizarFornecedor);

// Rota para deletar um fornecedor
router.delete('/:id', fornecedorController.deletarFornecedor);

module.exports = router;
