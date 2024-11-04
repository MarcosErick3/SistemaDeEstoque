document.addEventListener("DOMContentLoaded", function () {
    const logList = document.getElementById('log-list');

    function getCurrentDateTime() {
        const now = new Date();
        return now.toLocaleString();
    }

    window.registerMovement = function () {
        const productId = document.getElementById('product-id').value;
        const origin = document.getElementById('origin-location').value;
        const destination = document.getElementById('destination-location').value;
        const reason = document.getElementById('movement-reason').value;

        if (productId && origin && destination && reason) {
            const logEntry = document.createElement('li');
            logEntry.textContent = `Produto: ${productId}, De: ${origin}, Para: ${destination}, Motivo: ${reason}, Data/Hora: ${getCurrentDateTime()}`;
            logList.appendChild(logEntry);

            // Limpa os campos após o registro
            document.getElementById('product-id').value = '';
            document.getElementById('origin-location').value = '';
            document.getElementById('destination-location').value = '';
            document.getElementById('movement-reason').value = '';
        } else {
            alert("Por favor, preencha todos os campos!");
        }
    };
});
