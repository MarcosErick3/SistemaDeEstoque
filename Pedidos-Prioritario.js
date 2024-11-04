document.addEventListener("DOMContentLoaded", function () {
    const orders = [
        { id: 1, client: 'Cliente A', priority: true },
        { id: 2, client: 'Cliente B', priority: false },
        { id: 3, client: 'Cliente C', priority: true },
        { id: 4, client: 'Cliente D', priority: false },
        { id: 5, client: 'Cliente E', priority: true }
    ];

    const priorityOrdersList = document.getElementById('priority-orders');

    function listOrders() {
        // Limpa a lista antes de adicionar
        priorityOrdersList.innerHTML = '';

        // Filtra os pedidos prioritários e os normais
        const priorityOrders = orders.filter(order => order.priority);
        const normalOrders = orders.filter(order => !order.priority);

        // Exibe os pedidos prioritários primeiro
        priorityOrders.forEach(order => {
            const listItem = document.createElement('li');
            listItem.textContent = `Pedido #${order.id} - ${order.client}`;
            listItem.classList.add('priority');
            priorityOrdersList.appendChild(listItem);
        });

        // Exibe os pedidos normais
        normalOrders.forEach(order => {
            const listItem = document.createElement('li');
            listItem.textContent = `Pedido #${order.id} - ${order.client}`;
            listItem.classList.add('normal');
            priorityOrdersList.appendChild(listItem);
        });
    }

    // Chama a função para listar os pedidos
    listOrders();
});
