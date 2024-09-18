const express = require('express');
const app = express();
const cors = require('cors'); // Certifique-se de que o CORS está configurado se necessário
const produtosRouter = require('./routers/produtos');
const fornecedoresRouter = require('./routers/fornecedores'); 

// Middleware para JSON
app.use(express.json());
app.use(cors()); // Adicione esta linha se você estiver fazendo requisições cross-origin

// Rota de produtos
app.use('/api/produtos', produtosRouter);

// Rota de fornecedores
app.use('/api/fornecedores', fornecedoresRouter);

// Iniciar o servidor
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Servidor rodando na porta ${PORT}`);
});

