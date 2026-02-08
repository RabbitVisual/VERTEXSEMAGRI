import { Chart, registerables } from 'chart.js';

// Registrar todos os componentes do Chart.js
Chart.register(...registerables);

// Configuração global do Chart.js
Chart.defaults.responsive = true;
Chart.defaults.maintainAspectRatio = false;
Chart.defaults.plugins.legend.display = true;
Chart.defaults.plugins.legend.position = 'bottom';

// Função para obter cores do tema
function getThemeColors() {
    const isDark = document.documentElement.classList.contains('dark');
    return {
        text: isDark ? '#f1f5f9' : '#1f2937',
        grid: isDark ? '#334155' : '#e5e7eb',
        background: isDark ? '#1f2937' : '#ffffff',
    };
}

// Paleta de cores padrão
const colorPalette = [
    'rgba(99, 102, 241, 0.8)',   // indigo
    'rgba(34, 197, 94, 0.8)',    // green
    'rgba(251, 191, 36, 0.8)',   // yellow
    'rgba(239, 68, 68, 0.8)',    // red
    'rgba(59, 130, 246, 0.8)',   // blue
    'rgba(168, 85, 247, 0.8)',   // purple
    'rgba(236, 72, 153, 0.8)',   // pink
    'rgba(20, 184, 166, 0.8)',   // teal
    'rgba(245, 158, 11, 0.8)',   // amber
    'rgba(107, 114, 128, 0.8)',  // gray
];

// Função para criar gráfico de linha
export function createLineChart(canvasId, data, options = {}) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return null;

    const ctx = canvas.getContext('2d');
    const colors = getThemeColors();

    const defaultOptions = {
        type: 'line',
        data: {
            labels: data.labels || [],
            datasets: data.datasets || []
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: colors.text
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                x: {
                    grid: {
                        color: colors.grid
                    },
                    ticks: {
                        color: colors.text
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: colors.grid
                    },
                    ticks: {
                        color: colors.text
                    }
                }
            },
            ...options
        }
    };

    return new Chart(ctx, defaultOptions);
}

// Função para criar gráfico de barras
export function createBarChart(canvasId, data, options = {}) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return null;

    const ctx = canvas.getContext('2d');
    const colors = getThemeColors();

    const defaultOptions = {
        type: 'bar',
        data: {
            labels: data.labels || [],
            datasets: data.datasets || []
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: colors.text
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: colors.grid
                    },
                    ticks: {
                        color: colors.text
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: colors.grid
                    },
                    ticks: {
                        color: colors.text
                    }
                }
            },
            ...options
        }
    };

    return new Chart(ctx, defaultOptions);
}

// Função para criar gráfico de pizza
export function createPieChart(canvasId, data, options = {}) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return null;

    const ctx = canvas.getContext('2d');
    const colors = getThemeColors();

    const datasets = data.datasets || [{
        data: data.values || [],
        backgroundColor: colorPalette.slice(0, data.values?.length || 0)
    }];

    const defaultOptions = {
        type: 'pie',
        data: {
            labels: data.labels || [],
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: colors.text,
                        padding: 15
                    }
                }
            },
            ...options
        }
    };

    return new Chart(ctx, defaultOptions);
}

// Função para criar gráfico de rosquinha
export function createDoughnutChart(canvasId, data, options = {}) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return null;

    const ctx = canvas.getContext('2d');
    const colors = getThemeColors();

    const datasets = data.datasets || [{
        data: data.values || [],
        backgroundColor: colorPalette.slice(0, data.values?.length || 0)
    }];

    const defaultOptions = {
        type: 'doughnut',
        data: {
            labels: data.labels || [],
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: colors.text,
                        padding: 15
                    }
                }
            },
            ...options
        }
    };

    return new Chart(ctx, defaultOptions);
}

// Função para criar gráfico de área
export function createAreaChart(canvasId, data, options = {}) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return null;

    const ctx = canvas.getContext('2d');
    const colors = getThemeColors();

    const datasets = (data.datasets || []).map(dataset => ({
        ...dataset,
        fill: true,
        tension: 0.4
    }));

    const defaultOptions = {
        type: 'line',
        data: {
            labels: data.labels || [],
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: colors.text
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: colors.grid
                    },
                    ticks: {
                        color: colors.text
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: colors.grid
                    },
                    ticks: {
                        color: colors.text
                    }
                }
            },
            ...options
        }
    };

    return new Chart(ctx, defaultOptions);
}

// Função para criar gráfico combinado
export function createMixedChart(canvasId, data, options = {}) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return null;

    const ctx = canvas.getContext('2d');
    const colors = getThemeColors();

    const defaultOptions = {
        type: 'bar',
        data: {
            labels: data.labels || [],
            datasets: data.datasets || []
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: colors.text
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: colors.grid
                    },
                    ticks: {
                        color: colors.text
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: colors.grid
                    },
                    ticks: {
                        color: colors.text
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false,
                    },
                    ticks: {
                        color: colors.text
                    }
                }
            },
            ...options
        }
    };

    return new Chart(ctx, defaultOptions);
}

// Função para destruir gráfico
export function destroyChart(chart) {
    if (chart) {
        chart.destroy();
    }
}

// Função para atualizar tema dos gráficos
export function updateChartTheme(charts) {
    const colors = getThemeColors();
    charts.forEach(chart => {
        if (chart && chart.options) {
            if (chart.options.plugins?.legend?.labels) {
                chart.options.plugins.legend.labels.color = colors.text;
            }
            if (chart.options.scales) {
                Object.keys(chart.options.scales).forEach(scaleKey => {
                    const scale = chart.options.scales[scaleKey];
                    if (scale.grid) scale.grid.color = colors.grid;
                    if (scale.ticks) scale.ticks.color = colors.text;
                });
            }
            chart.update();
        }
    });
}

// Exportar Chart para uso global
window.Chart = Chart;
window.createLineChart = createLineChart;
window.createBarChart = createBarChart;
window.createPieChart = createPieChart;
window.createDoughnutChart = createDoughnutChart;
window.createAreaChart = createAreaChart;
window.createMixedChart = createMixedChart;
window.destroyChart = destroyChart;
window.updateChartTheme = updateChartTheme;

// Disparar evento quando Chart.js estiver pronto
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        window.dispatchEvent(new CustomEvent('chartjs:ready'));
    });
} else {
    window.dispatchEvent(new CustomEvent('chartjs:ready'));
}

