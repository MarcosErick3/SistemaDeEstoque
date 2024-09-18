const express = require('express');
const router = express.Router();
const produtoController = require('../controllers/produtoController');

// Verifique se a importação está correta e se os métodos existem no controlador
console.log(produtoController); // Adicione esta linha para verificar o conteúdo do controlador

// Rota para listar todos os produtos
router.get('/', produtoController.getTodosProdutos);

// Rota para adicionar um novo produto
router.post('/', produtoController.criarProduto);

// Rota para atualizar um produto
router.put('/:id', produtoController.atualizarProduto);

// Rota para deletar um produto
router.delete('/:id', produtoController.deletarProduto);

module.exports = router;
