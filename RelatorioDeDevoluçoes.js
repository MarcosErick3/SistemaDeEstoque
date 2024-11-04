document.addEventListener("DOMContentLoaded", function () {
    const returns = [
        { orderId: 101, client: 'Cliente A', carrier: 'Transportadora X', reason: 'Produto Danificado', returnDate: '2024-10-15' },
        { orderId: 102, client: 'Cliente B', carrier: 'Transportadora Y', reason: 'Entrega Atrasada', returnDate: '2024-10-17' },
        { orderId: 103, client: 'Cliente C', carrier: 'Transportadora Z', reason: 'Pedido Incorreto', returnDate: '2024-10-20' }
    ];

    function filterReturns(startDate, endDate, client, carrier) {
        return returns.filter(returnItem => {
            const returnDate = new Date(returnItem.returnDate);
            const startDateValid = startDate ? new Date(startDate) <= returnDate : true;
            const endDateValid = endDate ? new Date(endDate) >= returnDate : true;
            const clientValid = client ? returnItem.client.includes(client) : true;
            const carrierValid = carrier ? returnItem.carrier.includes(carrier) : true;

            return startDateValid && endDateValid && clientValid && carrierValid;
        });
    }

    function populateTable(filteredReturns) {
        const tbody = document.querySelector("#report-table tbody");
        tbody.innerHTML = ''; // Limpa a tabela antes de preencher

        filteredReturns.forEach(returnItem => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${returnItem.orderId}</td>
                <td>${returnItem.client}</td>
                <td>${returnItem.carrier}</td>
                <td>${returnItem.reason}</td>
                <td>${returnItem.returnDate}</td>
            `;
            tbody.appendChild(row);
        });
    }

    window.generateReturnReport = function () {
        const startDate = document.getElementById("start-date").value;
        const endDate = document.getElementById("end-date").value;
        const client = document.getElementById("client").value;
        const carrier = document.getElementById("carrier").value;

        const filteredReturns = filterReturns(startDate, endDate, client, carrier);
        populateTable(filteredReturns);
    };

    // Popula a tabela inicialmente
    populateTable(returns);
});
