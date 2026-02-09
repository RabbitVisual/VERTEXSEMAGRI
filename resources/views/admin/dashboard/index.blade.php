@extends('admin.layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="chart-pie" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Dashboard Administrativo</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" style="duotone" />
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
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['total_users'] ?? 0 }}</p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">{{ $stats['active_users'] ?? 0 }} ativos</p>
                </div>
                <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                    <x-icon name="users" class="w-8 h-8 text-emerald-600 dark:text-emerald-400" style="duotone" />
                </div>
            </div>
        </div>

        <!-- Card Logs Hoje -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Logs Hoje</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['logs_today'] ?? 0 }}</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">{{ $stats['logs_week'] ?? 0 }} esta semana</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <x-icon name="book" class="w-8 h-8 text-blue-600 dark:text-blue-400" style="duotone" />
                </div>
            </div>
        </div>

        <!-- Card Total de Logs -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Logs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['total_logs'] ?? 0) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Registros de auditoria</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <x-icon name="database" class="w-8 h-8 text-green-600 dark:text-green-400" style="duotone" />
                </div>
            </div>
        </div>

        <!-- Card Usuários Inativos -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Usuários Inativos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['inactive_users'] ?? 0 }}</p>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">Necessitam atenção</p>
                </div>
                <div class="p-3 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                    <x-icon name="user-xmark" class="w-8 h-8 text-amber-600 dark:text-amber-400" style="duotone" />
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas - Flowbite Alert -->
    @if(isset($stats['solicitacoes_campo_pendentes']) && $stats['solicitacoes_campo_pendentes'] > 0)
    <div id="alert-solicitacoes" class="flex items-center p-4 mb-4 text-amber-800 border border-amber-300 rounded-lg bg-amber-50 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800" role="alert">
        <x-icon name="triangle-exclamation" class="flex-shrink-0 w-5 h-5" style="duotone" />
        <div class="ml-3 text-sm font-medium flex-1">
            <strong class="font-bold">Solicitações Pendentes:</strong> Há <strong>{{ $stats['solicitacoes_campo_pendentes'] }}</strong> solicitação(ões) de materiais aguardando processamento.
        </div>
        <a href="{{ route('admin.materiais.solicitacoes-campo.index') }}" class="ml-auto -mx-1.5 -my-1.5 bg-amber-50 text-amber-500 rounded-lg focus:ring-2 focus:ring-amber-400 p-1.5 hover:bg-amber-200 inline-flex h-8 w-8 dark:bg-amber-900/20 dark:text-amber-400 dark:hover:bg-amber-900/30" aria-label="Ver Solicitações">
            <span class="sr-only">Ver Solicitações</span>
            <x-icon name="arrow-right" class="w-5 h-5" style="duotone" />
        </a>
    </div>
    @endif

    <!-- Formulários Manuais - Flowbite Card -->
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                <x-icon name="file-pdf" class="w-6 h-6 text-blue-600 dark:text-blue-400" style="duotone" />
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Formulários Manuais para Manutenção</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Gere formulários para preenchimento manual quando o sistema estiver em manutenção ou indisponível.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.formularios.demanda') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <x-icon name="file-lines" class="w-4 h-4" style="duotone" />
                        Formulário de Demanda
                    </a>
                    <a href="{{ route('admin.formularios.ordem') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-700 rounded-lg hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                        <x-icon name="clipboard-list" class="w-4 h-4" style="duotone" />
                        Formulário de Ordem de Serviço
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas por Módulo - Flowbite Cards Grid -->
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <x-icon name="cubes" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" style="duotone" />
            Estatísticas por Módulo
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($moduleStats ?? [] as $module => $count)
            <div class="p-4 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-lg hover:shadow-md transition-shadow">
                <div class="flex items-center justify-center mb-3">
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                        <x-module-icon module="{{ strtolower($module) }}" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" style="duotone" />
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
                    <x-icon name="chart-line" class="w-5 h-5 text-blue-600 dark:text-blue-400" style="duotone" />
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
                    <x-icon name="chart-pie" class="w-5 h-5 text-violet-600 dark:text-violet-400" style="duotone" />
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
                <x-icon name="clock-rotate-left" class="w-5 h-5 text-amber-600 dark:text-amber-400" style="duotone" />
                Últimas Atividades
            </h2>
            <a href="{{ route('admin.audit.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 inline-flex items-center gap-1">
                Ver Todas
                <x-icon name="arrow-right" class="w-4 h-4" style="duotone" />
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
                    @forelse($recentLogs ?? [] as $log)
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
                                <x-icon name="calendar" class="w-4 h-4" style="duotone" />
                                <span class="hidden sm:inline">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                                <span class="sm:hidden">{{ $log->created_at->format('d/m H:i') }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <x-icon name="inbox" class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-3" style="duotone" />
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




