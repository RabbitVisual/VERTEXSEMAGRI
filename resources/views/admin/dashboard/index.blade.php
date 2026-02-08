@extends('admin.layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Dashboard</span>
            </nav>
        </div>
    </div>

    <!-- Estatísticas Principais - Flowbite Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Card Total de Usuários -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Usuários</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['total_users'] }}</p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">{{ $stats['active_users'] }} ativos</p>
                </div>
                <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                    <x-icon name="file-pdf" class="w-5 h-5" />
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Formulários Manuais para Manutenção</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Gere formulários para preenchimento manual quando o sistema estiver em manutenção ou indisponível.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.formularios.demanda') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <x-icon name="file-pdf" class="w-5 h-5" />
                        Formulário de Demanda
                    </a>
                    <a href="{{ route('admin.formularios.ordem') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-700 rounded-lg hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                        <x-icon name="file-pdf" class="w-5 h-5" />
                        Formulário de Ordem de Serviço
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas por Módulo - Flowbite Cards Grid -->
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
            </svg>
            Estatísticas por Módulo
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($moduleStats as $module => $count)
            <div class="p-4 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-lg hover:shadow-md transition-shadow">
                <div class="flex items-center justify-center mb-3">
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                        </svg>
                    </div>
                </div>
                <h6 class="text-xs font-medium text-gray-600 dark:text-gray-400 text-center mb-1">{{ $module }}</h6>
                <p class="text-xl font-bold text-gray-900 dark:text-white text-center">{{ number_format($count) }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Gráficos - Flowbite Cards -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Gráfico Logs por Dia -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    Logs por Dia (Últimos 7 dias)
                </h2>
            </div>
            <div class="h-64">
                <canvas id="logsByDayChart"></canvas>
            </div>
        </div>

        <!-- Gráfico Distribuição de Ações -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                    </svg>
                    Distribuição de Ações
                </h2>
            </div>
            <div class="h-64">
                <canvas id="actionsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Atividades Recentes - Flowbite Table -->
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Últimas Atividades
            </h2>
            <a href="{{ route('admin.audit.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 inline-flex items-center gap-1">
                Ver Todas
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Usuário</th>
                        <th scope="col" class="px-4 py-3">Ação</th>
                        <th scope="col" class="px-4 py-3">Módulo</th>
                        <th scope="col" class="px-4 py-3 hidden md:table-cell">Descrição</th>
                        <th scope="col" class="px-4 py-3">Data</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLogs as $log)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700">
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 text-white flex items-center justify-center font-semibold text-xs">
                                    {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $log->user->name ?? 'Sistema' }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ $log->action }}</span>
                        </td>
                        <td class="px-4 py-4">
                            @if($log->module)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $log->module }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 hidden md:table-cell">
                            <span class="text-gray-900 dark:text-white">{{ Str::limit($log->description, 50) }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                <span class="hidden sm:inline">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                                <span class="sm:hidden">{{ $log->created_at->format('d/m H:i') }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5h16.5m-1.8-10H5.55c-.512 0-.96.384-1.05.888L3.75 7.5h16.5l-1.8-10.112c-.09-.504-.538-.888-1.05-.888z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-900 dark:text-white mb-1">Nenhuma atividade recente</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Não há atividades registradas no momento.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function initCharts() {
            if (typeof Chart === 'undefined') {
                setTimeout(initCharts, 100);
                return;
            }

            // Gráfico de logs por dia
            const logsByDayCtx = document.getElementById('logsByDayChart');
            if (!logsByDayCtx) return;
            
            const logsByDayChart = logsByDayCtx.getContext('2d');
            const logsByDayData = @json($chartData['logs_by_day'] ?? []);
            const logsByDayLabels = Object.keys(logsByDayData);
            const logsByDayValues = Object.values(logsByDayData);

            new Chart(logsByDayChart, {
                type: 'line',
                data: {
                    labels: logsByDayLabels.length > 0 ? logsByDayLabels : ['Sem dados'],
                    datasets: [{
                        label: 'Logs',
                        data: logsByDayValues.length > 0 ? logsByDayValues : [0],
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Gráfico de distribuição de ações
            const actionsCtx = document.getElementById('actionsChart');
            if (!actionsCtx) return;
            
            const actionsChart = actionsCtx.getContext('2d');
            const actionsData = @json($chartData['actions_distribution'] ?? []);
            const actionsLabels = Object.keys(actionsData);
            const actionsValues = Object.values(actionsData);

            new Chart(actionsChart, {
                type: 'doughnut',
                data: {
                    labels: actionsLabels.length > 0 ? actionsLabels : ['Sem dados'],
                    datasets: [{
                        data: actionsValues.length > 0 ? actionsValues : [1],
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(234, 179, 8, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(148, 163, 184, 0.8)',
                            'rgba(139, 92, 246, 0.8)',
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        
        initCharts();
    });
</script>
@endpush
@endsection
