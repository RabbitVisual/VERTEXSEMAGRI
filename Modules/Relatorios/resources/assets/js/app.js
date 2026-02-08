// Importar módulos
import './charts.js';
import './filters.js';

// Inicialização quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    // Observar mudanças de tema
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === 'class') {
                // Atualizar tema dos gráficos se houver
                if (window.chartInstances && Array.isArray(window.chartInstances)) {
                    window.updateChartTheme(window.chartInstances);
                }
            }
        });
    });

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });

    // Armazenar instâncias de gráficos globalmente
    window.chartInstances = window.chartInstances || [];
});

// Função helper para inicializar gráficos de forma segura
window.initChart = function(chartType, canvasId, data, options = {}) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) {
        console.warn(`Canvas #${canvasId} não encontrado`);
        return null;
    }

    let chart = null;
    
    switch (chartType) {
        case 'line':
            chart = window.createLineChart(canvasId, data, options);
            break;
        case 'bar':
            chart = window.createBarChart(canvasId, data, options);
            break;
        case 'pie':
            chart = window.createPieChart(canvasId, data, options);
            break;
        case 'doughnut':
            chart = window.createDoughnutChart(canvasId, data, options);
            break;
        case 'area':
            chart = window.createAreaChart(canvasId, data, options);
            break;
        case 'mixed':
            chart = window.createMixedChart(canvasId, data, options);
            break;
        default:
            console.warn(`Tipo de gráfico desconhecido: ${chartType}`);
    }

    if (chart && window.chartInstances) {
        window.chartInstances.push(chart);
    }

    return chart;
};

