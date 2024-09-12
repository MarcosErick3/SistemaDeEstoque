document.addEventListener('DOMContentLoaded', () => {
    const productForm = document.getElementById('product-form');
    const productList = document.getElementById('product-list');
    let editingProductId = null;

    function renderProducts(products) {
        productList.innerHTML = '';
        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.id}</td>
                <td>${product.name}</td>
                <td>${product.quantity}</td>
                <td>${product.price}</td>
                <td>
                    <button class="edit-btn" data-id="${product.id}">Editar</button>
                    <button class="delete-btn" data-id="${product.id}">Excluir</button>
                </td>
            `;
            productList.appendChild(row);
        });

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', handleEdit);
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', handleDelete);
        });
    }

    function handleFormSubmit(event) {
        event.preventDefault();

        const name = document.getElementById('name').value;
        const quantity = document.getElementById('quantity').value;
        const price = document.getElementById('price').value;

        if (!name || !quantity || !price) {
            alert('Por favor, preencha todos os campos.');
            return;
        }

        if (editingProductId) {
            const product = products.find(p => p.id === editingProductId);
            product.name = name;
            product.quantity = quantity;
            product.price = price;
        } else {
            const newProduct = {
                id: products.length ? Math.max(products.map(p => p.id)) + 1 : 1,
                name,
                quantity,
                price
            };
            products.push(newProduct);
        }

        productForm.reset();
        editingProductId = null;
        renderProducts(products);
    }

    function handleEdit(event) {
        const id = parseInt(event.target.getAttribute('data-id'));
        const product = products.find(p => p.id === id);
        document.getElementById('name').value = product.name;
        document.getElementById('quantity').value = product.quantity;
        document.getElementById('price').value = product.price;
        editingProductId = id;
    }

    function handleDelete(event) {
        const id = parseInt(event.target.getAttribute('data-id'));
        const confirmDelete = confirm('Tem certeza que deseja excluir este produto?');
        if (confirmDelete) {
            products = products.filter(p => p.id !== id);
            renderProducts(products);
        }
    }

    let products = [];
    productForm.addEventListener('submit', handleFormSubmit);
    renderProducts(products);
});