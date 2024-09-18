const API_URL = 'http://localhost:3000/api/produtos';

const listarProdutos = async () => {
    try {
        const response = await fetch(API_URL);
        const produtos = await response.json();

        const listaProdutos = document.getElementById('produto-list');
        listaProdutos.innerHTML = '';

        produtos.forEach(produto => {
            const item = document.createElement('li');
            item.textContent = `
                ID: ${produto.produto_id} | 
                Nome: ${produto.nome} | 
                Categoria: ${produto.categoria} | 
                Peso: ${produto.peso} kg | 
                Dimensões: ${produto.dimensoes} | 
                Fornecedor: ${produto.fornecedor_id}
            `;
            listaProdutos.appendChild(item);
        });
    } catch (error) {
        console.error('Erro ao listar produtos:', error);
    }
};


const adicionarProduto = async (event) => {
    event.preventDefault();

    const produto = {
        nome: document.getElementById('nome').value,
        descricao: document.getElementById('descricao').value,
        categoria: document.getElementById('categoria').value,
        peso: parseFloat(document.getElementById('peso').value),
        dimensoes: document.getElementById('dimensoes').value,
        fornecedor_id: parseInt(document.getElementById('fornecedor_id').value),
        data_fabricacao: document.getElementById('data_fabricacao').value,
        data_validade: document.getElementById('data_validade').value
    };

    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(produto)
        });

        if (response.ok) {
            listarProdutos(); // Atualizar a lista de produtos
        } else {
            const errorText = await response.text();
            console.error('Erro ao adicionar produto:', errorText);
        }
    } catch (error) {
        console.error('Erro ao adicionar produto:', error);
    }

    document.getElementById('produto-form').reset();
};

document.addEventListener('DOMContentLoaded', () => {
    listarProdutos();

    document.getElementById('produto-form').addEventListener('submit', adicionarProduto);
});
