@props([
    'id',
    'type' => 'bar', // bar, line, pie, doughnut, area, mixed
    'title' => null,
    'data' => [],
    'options' => [],
    'height' => 300,
    'class' => '',
    'emptyMessage' => 'Não há dados disponíveis para exibir neste gráfico.',
])

@php
    $chartId = $id ?? 'chart_' . uniqid();

    // Verificar se há dados
    $hasData = false;

    // Para gráficos de pizza/rosquinha (labels + values)
    if (isset($data['labels']) && isset($data['values'])) {
        $values = is_array($data['values']) ? $data['values'] : [];
        // Verificar se há pelo menos um valor maior que zero
        if (!empty($values)) {
            $hasData = array_sum(array_filter($values, function($v) {
                return is_numeric($v) && $v > 0;
            })) > 0;
        }
    }
    // Para gráficos de linha/barra (labels + datasets)
    elseif (isset($data['labels']) && isset($data['datasets'])) {
        $labels = is_array($data['labels']) ? $data['labels'] : [];
        $datasets = is_array($data['datasets']) ? $data['datasets'] : [];

        if (!empty($labels) && !empty($datasets) && is_array($datasets) && count($datasets) > 0) {
            // Verificar se algum dataset tem dados válidos
            foreach ($datasets as $dataset) {
                if (isset($dataset['data']) && is_array($dataset['data']) && !empty($dataset['data'])) {
                    $datasetData = array_filter($dataset['data'], function($v) {
                        return $v !== null && $v !== '' && (is_numeric($v) ? $v > 0 : true);
                    });
                    if (!empty($datasetData)) {
                        $sum = array_sum(array_map(function($v) {
                            return is_numeric($v) ? $v : 0;
                        }, $datasetData));
                        if ($sum > 0) {
                            $hasData = true;
                            break;
                        }
                    }
                }
            }
        }
    }
@endphp

<div class="chart-container {{ $class }}" style="height: {{ $height }}px; position: relative;">
    @if($title)
        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ $title }}</h4>
    @endif

    @if(!$hasData)
        {{-- Mensagem quando não há dados --}}
        <div class="flex flex-col items-center justify-center h-full min-h-[200px] text-center p-8 bg-gray-50 dark:bg-gray-800/50 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Sem dados disponíveis</p>
            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $emptyMessage }}</p>
        </div>
    @else
        <canvas id="{{ $chartId }}" style="max-height: {{ $height }}px;"></canvas>
    @endif
</div>

@push('scripts')
<script>
(function() {
    const chartId = '{{ $chartId }}';
    const chartType = '{{ $type }}';
    const chartData = @json($data);
    const chartOptions = @json($options ?? []);

    // Aguardar Chart.js estar disponível
    function initChart() {
        // Verificar se Chart.js está disponível
        if (typeof window.Chart === 'undefined') {
            setTimeout(initChart, 100);
            return;
        }

        const ChartLib = window.Chart;
        const canvas = document.getElementById(chartId);
        if (!canvas) {
            setTimeout(initChart, 100);
            return;
        }

        // Verificar se já foi inicializado
        if (canvas.chart) {
            return;
        }

        const ctx = canvas.getContext('2d');
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#f1f5f9' : '#1f2937';
        const gridColor = isDark ? '#334155' : '#e5e7eb';

        // Converter "area" para "line" com fill: true
        const actualType = chartType === 'area' ? 'line' : chartType;
        const isAreaChart = chartType === 'area';

        // Preparar dados baseado no tipo
        let config = {
            type: actualType,
            data: {},
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: textColor }
                    }
                },
                ...chartOptions
            }
        };

        // Configurar dados baseado no tipo de gráfico
        if (chartData.labels && chartData.datasets) {
            config.data = {
                labels: chartData.labels,
                datasets: chartData.datasets.map(dataset => {
                    // Para gráficos de área, garantir que fill está habilitado
                    if (isAreaChart) {
                        return {
                            ...dataset,
                            fill: true,
                            tension: 0.4
                        };
                    }
                    return dataset;
                })
            };
        } else if (chartData.labels && chartData.values) {
            // Para gráficos de pizza/rosquinha
            config.data = {
                labels: chartData.labels,
                datasets: [{
                    data: chartData.values,
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(20, 184, 166, 0.8)',
                    ].slice(0, chartData.values.length)
                }]
            };
        }

        // Adicionar configurações de escala para gráficos com eixos
        if (['bar', 'line', 'area'].includes(chartType)) {
            config.options.scales = {
                x: {
                    grid: { color: gridColor },
                    ticks: { color: textColor }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { color: textColor }
                }
            };
        }

        // Criar gráfico e armazenar referência
        const chart = new ChartLib(ctx, config);
        canvas.chart = chart;

        // Adicionar à lista global de instâncias
        if (window.chartInstances) {
            window.chartInstances.push(chart);
        }
    }

    // Inicializar quando Chart.js estiver pronto
    function waitForChartJS() {
        if (typeof window.Chart !== 'undefined') {
            initChart();
        } else {
            // Aguardar evento ou tentar novamente
            window.addEventListener('chartjs:ready', initChart, { once: true });
            setTimeout(waitForChartJS, 100);
        }
    }

    // Verificar se há dados antes de inicializar
    const hasData = @json($hasData);

    if (hasData) {
        // Inicializar quando o DOM estiver pronto
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', waitForChartJS);
        } else {
            waitForChartJS();
        }
    } else {
        // Se não há dados, não tentar inicializar o gráfico
        console.info('Gráfico {{ $chartId }} não será inicializado: sem dados disponíveis');
    }
})();
</script>
@endpush

