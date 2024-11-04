document.addEventListener("DOMContentLoaded", function () {
    // Simula os dados dos indicadores de desempenho
    const indicators = {
        occupancyRate: 75, // Taxa de ocupação em %
        avgPickingTime: 12, // Tempo médio de separação em minutos
        pickingErrors: 3, // Erros de picking
        operatorProductivity: 35 // Itens por hora por operador
    };

    // Função para exibir os indicadores na tela
    function displayIndicators() {
        document.getElementById("occupancy-rate").textContent = indicators.occupancyRate;
        document.getElementById("avg-picking-time").textContent = indicators.avgPickingTime;
        document.getElementById("picking-errors").textContent = indicators.pickingErrors;
        document.getElementById("operator-productivity").textContent = indicators.operatorProductivity;
    }

    // Chama a função para mostrar os indicadores ao carregar a página
    displayIndicators();
});

// Função para gerar um relatório em PDF (usando uma biblioteca como jsPDF)
function generateReport() {
    const reportContent = `
        Relatório de Indicadores de Eficiência do Armazém
        ----------------------------------------
        Taxa de Ocupação: 75%
        Tempo Médio de Separação: 12 minutos
        Erros de Picking: 3
        Produtividade por Operador: 35 itens/hora
    `;
    console.log(reportContent); // Substituir por uma função para gerar PDF
    alert("Relatório gerado com sucesso!");
}
