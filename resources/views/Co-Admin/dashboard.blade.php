@extends('Co-Admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 mb-6 md:mb-8 border-b border-gray-200 dark:border-gray-700">
    <div>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-3.75v3.75m-3 .75h3.75m-3.75 0h-3.75" />
                </svg>
            </div>
            <span>Dashboard</span>
        </h1>
        <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Visão geral completa do sistema</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 sm:gap-3">
        <a href="{{ route('co-admin.dashboard', ['period' => 'today']) }}"
           class="inline-flex items-center gap-2 px-3 py-2 md:px-4 md:py-2.5 text-sm font-medium rounded-xl transition-all duration-300 {{ ($period ?? 'today') === 'today' ? 'bg-indigo-600 text-white shadow-md hover:shadow-lg' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <span class="hidden sm:inline">Hoje</span>
        </a>
        <a href="{{ route('co-admin.dashboard', ['period' => 'week']) }}"
           class="inline-flex items-center gap-2 px-3 py-2 md:px-4 md:py-2.5 text-sm font-medium rounded-xl transition-all duration-300 {{ ($period ?? 'today') === 'week' ? 'bg-indigo-600 text-white shadow-md hover:shadow-lg' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <span class="hidden sm:inline">Semana</span>
        </a>
        <a href="{{ route('co-admin.dashboard', ['period' => 'month']) }}"
           class="inline-flex items-center gap-2 px-3 py-2 md:px-4 md:py-2.5 text-sm font-medium rounded-xl transition-all duration-300 {{ ($period ?? 'today') === 'month' ? 'bg-indigo-600 text-white shadow-md hover:shadow-lg' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <span class="hidden sm:inline">Mês</span>
        </a>
        @if(\Nwidart\Modules\Facades\Module::isEnabled('Relatorios') && Route::has('co-admin.relatorios.index'))
        <a href="{{ route('co-admin.relatorios.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 md:px-4 md:py-2.5 text-sm font-semibold rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 text-white hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
            <span class="hidden sm:inline">Relatórios</span>
        </a>
        @endif
    </div>
</div>

<!-- Alertas Críticos -->
@if(!empty($alertas_criticos))
    <div class="space-y-3 md:space-y-4 mb-6 md:mb-8">
        @foreach($alertas_criticos as $alerta)
            @php
                $alertConfig = [
                    'danger' => [
                        'bg' => 'bg-red-50 dark:bg-red-900/20',
                        'border' => 'border-red-200 dark:border-red-800',
                        'text' => 'text-red-800 dark:text-red-200',
                        'icon' => 'text-red-600 dark:text-red-400',
                        'iconPath' => 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z'
                    ],
                    'warning' => [
                        'bg' => 'bg-amber-50 dark:bg-amber-900/20',
                        'border' => 'border-amber-200 dark:border-amber-800',
                        'text' => 'text-amber-800 dark:text-amber-200',
                        'icon' => 'text-amber-600 dark:text-amber-400',
                        'iconPath' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z'
                    ],
                    'info' => [
                        'bg' => 'bg-blue-50 dark:bg-blue-900/20',
                        'border' => 'border-blue-200 dark:border-blue-800',
                        'text' => 'text-blue-800 dark:text-blue-200',
                        'icon' => 'text-blue-600 dark:text-blue-400',
                        'iconPath' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z'
                    ],
                    'success' => [
                        'bg' => 'bg-emerald-50 dark:bg-emerald-900/20',
                        'border' => 'border-emerald-200 dark:border-emerald-800',
                        'text' => 'text-emerald-800 dark:text-emerald-200',
                        'icon' => 'text-emerald-600 dark:text-emerald-400',
                        'iconPath' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                ];
                $config = $alertConfig[$alerta['tipo']] ?? $alertConfig['info'];
            @endphp
            <div class="rounded-xl border-2 p-4 md:p-5 {{ $config['bg'] }} {{ $config['border'] }} shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3 md:gap-4">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 md:h-6 md:w-6 {{ $config['icon'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $config['iconPath'] }}" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm md:text-base font-semibold {{ $config['text'] }} mb-1">{{ $alerta['titulo'] }}</h3>
                        <p class="text-sm {{ $config['text'] }} opacity-90">{{ $alerta['mensagem'] }}</p>
                    </div>
                    @if(isset($alerta['link']))
                        <a href="{{ $alerta['link'] }}" class="ml-4 flex-shrink-0 inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg {{ $config['text'] }} hover:opacity-80 transition-opacity">
                            <span>Ver</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- Cards de Estatísticas Principais -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
    <x-stat-card
        title="Demandas Abertas"
        :value="$stats['demandas_abertas'] ?? 0"
        icon="bi-clipboard-check"
        color="primary"
        subtitle="Aguardando atendimento"
        :link="(\Nwidart\Modules\Facades\Module::isEnabled('Demandas') && Route::has('co-admin.demandas.index')) ? route('co-admin.demandas.index', ['status' => 'aberta']) : null"
    />
    <x-stat-card
        title="OS em Execução"
        :value="$stats['os_execucao'] ?? 0"
        icon="bi-file-earmark-text"
        color="warning"
        subtitle="Em andamento"
        :link="(\Nwidart\Modules\Facades\Module::isEnabled('Ordens') && Route::has('co-admin.ordens.index')) ? route('co-admin.ordens.index', ['status' => 'em_execucao']) : null"
    />
    <x-stat-card
        title="OS Concluídas"
        :value="$stats['os_concluidas'] ?? 0"
        icon="bi-check-circle"
        color="success"
        subtitle="Este período"
        :link="Route::has('co-admin.ordens.index') ? route('co-admin.ordens.index', ['status' => 'concluida']) : null"
    />
    <x-stat-card
        title="Estoque Baixo"
        :value="$stats['materiais_baixo_estoque'] ?? 0"
        icon="bi-exclamation-triangle"
        color="danger"
        subtitle="Necessitam reposição"
        :link="(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('co-admin.materiais.index')) ? route('co-admin.materiais.index', ['baixo_estoque' => 1]) : null"
    />
</div>

<!-- Cards de Estatísticas Secundárias - Demandas e OS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
    <x-stat-card
        title="Total de Demandas"
        :value="$stats['demandas_total'] ?? 0"
        icon="bi-clipboard-data"
        color="info"
        subtitle="Todas as demandas"
        :link="Route::has('co-admin.demandas.index') ? route('co-admin.demandas.index') : null"
    />
    <x-stat-card
        title="Demandas em Andamento"
        :value="$stats['demandas_em_andamento'] ?? 0"
        icon="bi-arrow-right-circle"
        color="warning"
        subtitle="Em processamento"
        :link="Route::has('co-admin.demandas.index') ? route('co-admin.demandas.index', ['status' => 'em_andamento']) : null"
    />
    <x-stat-card
        title="Total de OS"
        :value="$stats['os_total'] ?? 0"
        icon="bi-file-earmark-check"
        color="secondary"
        subtitle="Todas as ordens"
        :link="Route::has('co-admin.ordens.index') ? route('co-admin.ordens.index') : null"
    />
    <x-stat-card
        title="OS Pendentes"
        :value="$stats['os_pendentes'] ?? 0"
        icon="bi-clock-history"
        color="info"
        subtitle="Aguardando início"
        :link="Route::has('co-admin.ordens.index') ? route('co-admin.ordens.index', ['status' => 'pendente']) : null"
    />
</div>

<!-- Cards de Estatísticas - Recursos Humanos e Infraestrutura -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
    <x-stat-card
        title="Equipes Ativas"
        :value="$stats['equipes_ativas'] ?? 0"
        icon="bi-people"
        color="primary"
        subtitle="Em operação"
        :link="(\Nwidart\Modules\Facades\Module::isEnabled('Equipes') && Route::has('co-admin.equipes.index')) ? route('co-admin.equipes.index') : null"
    />
    <x-stat-card
        title="Funcionários Ativos"
        :value="$stats['funcionarios_ativos'] ?? 0"
        icon="bi-person-check"
        color="success"
        subtitle="Total: {{ $stats['funcionarios_total'] ?? 0 }}"
        :link="(\Nwidart\Modules\Facades\Module::isEnabled('Funcionarios') && Route::has('co-admin.funcionarios.index')) ? route('co-admin.funcionarios.index') : null"
    />
    <x-stat-card
        title="Localidades Ativas"
        :value="$stats['localidades_total'] ?? 0"
        icon="bi-geo-alt"
        color="info"
        subtitle="Cadastradas no sistema"
        :link="(\Nwidart\Modules\Facades\Module::isEnabled('Localidades') && Route::has('co-admin.localidades.index')) ? route('co-admin.localidades.index') : null"
    />
    <x-stat-card
        title="Pessoas Cadastradas"
        :value="$stats['pessoas_total'] ?? 0"
        icon="bi-person-badge"
        color="secondary"
        subtitle="{{ $stats['pessoas_beneficiarias'] ?? 0 }} beneficiárias"
        :link="(\Nwidart\Modules\Facades\Module::isEnabled('Pessoas') && Route::has('co-admin.pessoas.index')) ? route('co-admin.pessoas.index') : null"
    />
</div>

<!-- Cards de Estatísticas - Materiais e Infraestrutura -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
    <x-stat-card
        title="Materiais Ativos"
        :value="$stats['materiais_ativos'] ?? 0"
        icon="bi-box-seam"
        color="success"
        subtitle="Total: {{ $stats['materiais_total'] ?? 0 }}"
        :link="Route::has('co-admin.materiais.index') ? route('co-admin.materiais.index') : null"
    />
    <x-stat-card
        title="Materiais Sem Estoque"
        :value="$stats['materiais_sem_estoque'] ?? 0"
        icon="bi-x-circle"
        color="danger"
        subtitle="Necessitam reposição"
        :link="Route::has('co-admin.materiais.index') ? route('co-admin.materiais.index') : null"
    />
    <x-stat-card
        title="Pontos de Luz"
        :value="$stats['pontos_luz_ativos'] ?? 0"
        icon="bi-lightbulb"
        color="warning"
        subtitle="Total: {{ $stats['pontos_luz_total'] ?? 0 }}"
        :link="(\Nwidart\Modules\Facades\Module::isEnabled('Iluminacao') && Route::has('co-admin.iluminacao.index')) ? route('co-admin.iluminacao.index') : null"
    />
    <x-stat-card
        title="Redes de Água"
        :value="$stats['redes_agua_ativas'] ?? 0"
        icon="bi-droplet"
        color="info"
        subtitle="Total: {{ $stats['redes_agua_total'] ?? 0 }}"
        :link="(\Nwidart\Modules\Facades\Module::isEnabled('Agua') && Route::has('co-admin.agua.index')) ? route('co-admin.agua.index') : null"
    />
</div>

<!-- Gráficos - Primeira Linha -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                    </svg>
                </div>
                <span>Demandas por Status</span>
            </h3>
        </div>
        <div class="p-4 md:p-6">
            <canvas id="demandasStatusChart" height="250"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <span>OS por Mês ({{ now()->year }})</span>
            </h3>
        </div>
        <div class="p-4 md:p-6">
            <canvas id="osPorMesChart" height="250"></canvas>
        </div>
    </div>
</div>

<!-- Gráficos - Segunda Linha -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                    </svg>
                </div>
                <span>Demandas por Tipo</span>
            </h3>
        </div>
        <div class="p-4 md:p-6">
            <canvas id="demandasTipoChart" height="250"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-violet-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <span>OS por Status</span>
            </h3>
        </div>
        <div class="p-4 md:p-6">
            <canvas id="osStatusChart" height="250"></canvas>
        </div>
    </div>
</div>

<!-- Gráficos - Terceira Linha -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5h16.5m-1.8-10H5.55c-.512 0-.96.384-1.05.888L3.75 7.5h16.5l-1.8-10.112c-.09-.504-.538-.888-1.05-.888z" />
                    </svg>
                </div>
                <span>Materiais por Categoria</span>
            </h3>
        </div>
        <div class="p-4 md:p-6">
            <canvas id="materiaisCategoriaChart" height="250"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008V14.25m.75 3.75h.008v.008h-.008V18m-3.75-3.75h.008v.008h-.008V14.25m.75 3.75h.008v.008h-.008V18" />
                    </svg>
                </div>
                <span>Resumo de Infraestrutura</span>
            </h3>
        </div>
        <div class="p-4 md:p-6">
            <canvas id="infraestruturaChart" height="250"></canvas>
        </div>
    </div>
</div>

<!-- Materiais com Estoque Baixo -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6 md:mb-8 overflow-hidden">
    <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <span>Materiais com Estoque Baixo</span>
        </h3>
        @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('co-admin.materiais.index'))
            <a href="{{ route('co-admin.materiais.index', ['baixo_estoque' => 1]) }}" class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                <span>Ver todos</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        @endif
    </div>
    <div class="p-4 md:p-6">
        @if(!empty($chartData['materiais_estoque']))
            <div class="space-y-3 md:space-y-4">
                @foreach($chartData['materiais_estoque'] as $material)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 md:p-5 bg-red-50 dark:bg-red-900/20 rounded-xl border-2 border-red-200 dark:border-red-800 hover:shadow-md transition-shadow">
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-base md:text-lg text-gray-900 dark:text-white mb-2">{{ $material['nome'] ?? 'N/A' }}</p>
                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5h16.5m-1.8-10H5.55c-.512 0-.96.384-1.05.888L3.75 7.5h16.5l-1.8-10.112c-.09-.504-.538-.888-1.05-.888z" />
                                    </svg>
                                    <span>Estoque: <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($material['quantidade_estoque'] ?? 0, 2, ',', '.') }}</span> {{ $material['unidade_medida'] ?? '' }}</span>
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                    <span>Mínimo: <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($material['quantidade_minima'] ?? 0, 2, ',', '.') }}</span> {{ $material['unidade_medida'] ?? '' }}</span>
                                </span>
                            </div>
                        </div>
                        <span class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 border-2 border-red-300 dark:border-red-700 whitespace-nowrap">
                            @php
                                $percentual = ($material['quantidade_minima'] ?? 1) > 0
                                    ? round((($material['quantidade_estoque'] ?? 0) / ($material['quantidade_minima'] ?? 1)) * 100)
                                    : 0;
                            @endphp
                            {{ $percentual }}%
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 md:py-16">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-base md:text-lg font-semibold text-gray-900 dark:text-white mb-1">Nenhum material com estoque baixo</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Todos os materiais estão com estoque adequado</p>
            </div>
        @endif
    </div>
</div>

<!-- Tabelas de Atividades Recentes -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span>Últimas Demandas</span>
            </h3>
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Demandas') && Route::has('co-admin.demandas.index'))
                <a href="{{ route('co-admin.demandas.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                    <span>Ver todas</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Solicitante</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Prioridade</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($ultimas_demandas ?? [] as $demanda)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $demanda->solicitante_nome ?? 'N/A' }}</div>
                                @if(isset($demanda->codigo))
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $demanda->codigo }}</div>
                                @endif
                            </td>
                            <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                @php
                                    $tipoLabels = [
                                        'agua' => 'Água',
                                        'luz' => 'Luz',
                                        'estrada' => 'Estrada',
                                        'poco' => 'Poço'
                                    ];
                                    $tipoColors = [
                                        'agua' => 'text-blue-600 dark:text-blue-400',
                                        'luz' => 'text-amber-600 dark:text-amber-400',
                                        'estrada' => 'text-gray-600 dark:text-gray-400',
                                        'poco' => 'text-indigo-600 dark:text-indigo-400'
                                    ];
                                @endphp
                                <div class="flex items-center text-sm font-medium {{ $tipoColors[$demanda->tipo] ?? 'text-gray-900 dark:text-white' }}">
                                    {{ $tipoLabels[$demanda->tipo] ?? ucfirst($demanda->tipo) }}
                                </div>
                            </td>
                            <td class="px-4 md:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                @php
                                    $prioridadeColors = [
                                        'baixa' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                        'media' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                        'alta' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                        'urgente' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $prioridadeColors[$demanda->prioridade] ?? $prioridadeColors['baixa'] }}">
                                    {{ ucfirst($demanda->prioridade) }}
                                </span>
                            </td>
                            <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'aberta' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
                                        'em_andamento' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                        'concluida' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                        'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$demanda->status] ?? $statusColors['aberta'] }}">
                                    {{ ucfirst(str_replace('_', ' ', $demanda->status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5h16.5m-1.8-10H5.55c-.512 0-.96.384-1.05.888L3.75 7.5h16.5l-1.8-10.112c-.09-.504-.538-.888-1.05-.888z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Nenhuma demanda recente</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Não há demandas registradas no momento.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <span>OS em Execução</span>
            </h3>
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Ordens') && Route::has('co-admin.ordens.index'))
                <a href="{{ route('co-admin.ordens.index', ['status' => 'em_execucao']) }}" class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                    <span>Ver todas</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Número</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Equipe</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($os_execucao ?? [] as $os)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $os->numero ?? 'N/A' }}</div>
                            </td>
                            <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white hidden sm:table-cell">
                                @if(isset($os->equipe_id))
                                    @php
                                        $equipe = \Modules\Equipes\App\Models\Equipe::find($os->equipe_id);
                                    @endphp
                                    {{ $equipe->nome ?? 'N/A' }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $os->tipo_servico ?? 'N/A' }}</td>
                            <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                    {{ ucfirst(str_replace('_', ' ', $os->status ?? 'N/A')) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Nenhuma OS em execução</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Não há ordens de serviço em execução no momento.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Cards de Acesso Rápido aos Módulos -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
        <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
            </div>
            <span>Acesso Rápido aos Módulos</span>
        </h3>
    </div>
    <div class="p-4 md:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Demandas') && Route::has('co-admin.demandas.index'))
                <x-module-card
                    title="Demandas"
                    description="Gerenciar demandas da população"
                    route="demandas.index"
                    color="primary"
                    module="demandas"
                />
            @endif
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Ordens') && Route::has('co-admin.ordens.index'))
                <x-module-card
                    title="Ordens de Serviço"
                    description="Controle de ordens de serviço"
                    route="ordens.index"
                    color="warning"
                    module="ordens"
                />
            @endif
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('co-admin.materiais.index'))
                <x-module-card
                    title="Materiais"
                    description="Controle de estoque"
                    route="co-admin.materiais.index"
                    color="info"
                    module="materiais"
                />
            @endif
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Localidades') && Route::has('co-admin.localidades.index'))
                <x-module-card
                    title="Localidades"
                    description="Cadastro de localidades"
                    route="co-admin.localidades.index"
                    color="success"
                    module="localidades"
                />
            @endif
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Equipes') && Route::has('co-admin.equipes.index'))
                <x-module-card
                    title="Equipes"
                    description="Gerenciar equipes de trabalho"
                    route="co-admin.equipes.index"
                    color="primary"
                    module="equipes"
                />
            @endif
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Funcionarios') && Route::has('co-admin.funcionarios.index'))
                <x-module-card
                    title="Funcionários"
                    description="Cadastro de funcionários"
                    route="co-admin.funcionarios.index"
                    color="success"
                    module="funcionarios"
                />
            @endif
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Pessoas') && Route::has('co-admin.pessoas.index'))
                <x-module-card
                    title="Pessoas"
                    description="Cadastro de pessoas"
                    route="co-admin.pessoas.index"
                    color="secondary"
                    module="pessoas"
                />
            @endif
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Iluminacao') && Route::has('co-admin.iluminacao.index'))
                <x-module-card
                    title="Iluminação"
                    description="Pontos de luz"
                    route="co-admin.iluminacao.index"
                    color="warning"
                    module="iluminacao"
                />
            @endif
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Agua') && Route::has('co-admin.agua.index'))
                <x-module-card
                    title="Água"
                    description="Redes de água"
                    route="co-admin.agua.index"
                    color="info"
                    module="agua"
                />
            @endif
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('co-admin.pocos.index'))
                <x-module-card
                    title="Poços"
                    description="Gerenciar poços"
                    route="co-admin.pocos.index"
                    color="info"
                    module="pocos"
                />
            @endif
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Estradas') && Route::has('co-admin.estradas.index'))
                <x-module-card
                    title="Estradas"
                    description="Gerenciar estradas"
                    route="co-admin.estradas.index"
                    color="secondary"
                    module="estradas"
                />
            @endif
            @if(\Nwidart\Modules\Facades\Module::isEnabled('Relatorios') && Route::has('co-admin.relatorios.index'))
                <x-module-card
                    title="Relatórios"
                    description="Relatórios e análises"
                    icon="bi-graph-up"
                    route="co-admin.relatorios.index"
                    color="success"
                />
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Dados dos gráficos
const chartDataDemandasStatus = {!! json_encode($chartData['demandas_por_status'] ?? []) !!};
const chartDataOSPorMes = {!! json_encode($chartData['os_por_mes'] ?? []) !!};
const chartDataDemandasTipo = {!! json_encode($chartData['demandas_por_tipo'] ?? []) !!};
const chartDataOSStatus = {!! json_encode($chartData['os_por_status'] ?? []) !!};
const chartDataMateriaisCategoria = {!! json_encode($chartData['materiais_por_categoria'] ?? []) !!};
const chartDataInfraestrutura = {!! json_encode($chartData['infraestrutura_resumo'] ?? []) !!};

document.addEventListener('DOMContentLoaded', function() {
    // Aguardar Chart.js estar disponível
    function waitForChartJS(callback) {
        if (typeof Chart !== 'undefined' || typeof window.Chart !== 'undefined') {
            callback();
        } else {
            setTimeout(() => waitForChartJS(callback), 100);
        }
    }

    waitForChartJS(function() {
        const ChartLib = window.Chart || Chart;
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#f1f5f9' : '#1f2937';
        const gridColor = isDark ? '#334155' : '#e5e7eb';

        // Função para mostrar mensagem de "sem dados"
        function showNoDataMessage(canvasId, message) {
            const canvas = document.getElementById(canvasId);
            if (canvas) {
                const container = canvas.parentElement;
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg class="h-16 w-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">${message}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Não há dados disponíveis para exibir</p>
                    </div>
                `;
            }
        }

        // Gráfico de Demandas por Status
        const demandasStatusCtx = document.getElementById('demandasStatusChart');
        if (demandasStatusCtx) {
            const demandasStatusData = chartDataDemandasStatus;
            const hasData = Object.keys(demandasStatusData).length > 0 && Object.values(demandasStatusData).some(v => v > 0);

            if (hasData) {
                new ChartLib(demandasStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(demandasStatusData).map(key => {
                            const labels = {
                                'aberta': 'Aberta',
                                'em_andamento': 'Em Andamento',
                                'concluida': 'Concluída',
                                'cancelada': 'Cancelada'
                            };
                            return labels[key] || key;
                        }),
                        datasets: [{
                            data: Object.values(demandasStatusData),
                            backgroundColor: [
                                '#6366f1',
                                '#f59e0b',
                                '#10b981',
                                '#ef4444'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: textColor
                                }
                            }
                        }
                    }
                });
            } else {
                showNoDataMessage('demandasStatusChart', 'Nenhuma demanda encontrada');
            }
        }

        // Gráfico de OS por Mês
        const osPorMesCtx = document.getElementById('osPorMesChart');
        if (osPorMesCtx) {
            const osPorMesData = chartDataOSPorMes;
            const hasData = Object.keys(osPorMesData).length > 0 && Object.values(osPorMesData).some(v => v > 0);

            if (hasData) {
                new ChartLib(osPorMesCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(osPorMesData),
                        datasets: [{
                            label: 'OS Criadas',
                            data: Object.values(osPorMesData),
                            backgroundColor: '#10b981'
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
                                ticks: {
                                    stepSize: 1,
                                    color: textColor
                                },
                                grid: {
                                    color: gridColor
                                }
                            },
                            x: {
                                ticks: {
                                    color: textColor
                                },
                                grid: {
                                    color: gridColor
                                }
                            }
                        }
                    }
                });
            } else {
                showNoDataMessage('osPorMesChart', 'Nenhuma OS encontrada');
            }
        }

        // Gráfico de Demandas por Tipo
        const demandasTipoCtx = document.getElementById('demandasTipoChart');
        if (demandasTipoCtx) {
            const demandasTipoData = chartDataDemandasTipo;
            const hasData = Object.keys(demandasTipoData).length > 0 && Object.values(demandasTipoData).some(v => v > 0);

            if (hasData) {
                new ChartLib(demandasTipoCtx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(demandasTipoData).map(key => {
                            const labels = {
                                'agua': 'Água',
                                'luz': 'Luz',
                                'estrada': 'Estrada',
                                'poco': 'Poço'
                            };
                            return labels[key] || key;
                        }),
                        datasets: [{
                            data: Object.values(demandasTipoData),
                            backgroundColor: [
                                '#3b82f6',
                                '#f59e0b',
                                '#64748b',
                                '#6366f1'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: textColor
                                }
                            }
                        }
                    }
                });
            } else {
                showNoDataMessage('demandasTipoChart', 'Nenhuma demanda por tipo encontrada');
            }
        }

        // Gráfico de OS por Status
        const osStatusCtx = document.getElementById('osStatusChart');
        if (osStatusCtx) {
            const osStatusData = chartDataOSStatus;
            const hasData = Object.keys(osStatusData).length > 0 && Object.values(osStatusData).some(v => v > 0);

            if (hasData) {
                new ChartLib(osStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(osStatusData).map(key => {
                            const labels = {
                                'pendente': 'Pendente',
                                'em_execucao': 'Em Execução',
                                'concluida': 'Concluída',
                                'cancelada': 'Cancelada'
                            };
                            return labels[key] || key;
                        }),
                        datasets: [{
                            data: Object.values(osStatusData),
                            backgroundColor: [
                                '#6366f1',
                                '#f59e0b',
                                '#10b981',
                                '#ef4444'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: textColor
                                }
                            }
                        }
                    }
                });
            } else {
                showNoDataMessage('osStatusChart', 'Nenhuma OS encontrada');
            }
        }

        // Gráfico de Materiais por Categoria
        const materiaisCategoriaCtx = document.getElementById('materiaisCategoriaChart');
        if (materiaisCategoriaCtx) {
            const materiaisCategoriaData = chartDataMateriaisCategoria;
            const hasData = Object.keys(materiaisCategoriaData).length > 0 && Object.values(materiaisCategoriaData).some(v => v > 0);

            if (hasData) {
                new ChartLib(materiaisCategoriaCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(materiaisCategoriaData),
                        datasets: [{
                            label: 'Materiais',
                            data: Object.values(materiaisCategoriaData),
                            backgroundColor: '#6366f1'
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
                                ticks: {
                                    stepSize: 1,
                                    color: textColor
                                },
                                grid: {
                                    color: gridColor
                                }
                            },
                            x: {
                                ticks: {
                                    color: textColor
                                },
                                grid: {
                                    color: gridColor
                                }
                            }
                        }
                    }
                });
            } else {
                showNoDataMessage('materiaisCategoriaChart', 'Nenhum material encontrado');
            }
        }

        // Gráfico de Infraestrutura
        const infraestruturaCtx = document.getElementById('infraestruturaChart');
        if (infraestruturaCtx) {
            const infraestruturaData = chartDataInfraestrutura;
            const hasData = Object.keys(infraestruturaData).length > 0 && Object.values(infraestruturaData).some(v => v > 0);

            if (hasData) {
                new ChartLib(infraestruturaCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(infraestruturaData).map(key => {
                            const labels = {
                                'pontos_luz': 'Pontos de Luz',
                                'redes_agua': 'Redes de Água',
                                'pocos': 'Poços',
                                'trechos': 'Trechos'
                            };
                            return labels[key] || key;
                        }),
                        datasets: [{
                            label: 'Quantidade',
                            data: Object.values(infraestruturaData),
                            backgroundColor: [
                                '#f59e0b',
                                '#3b82f6',
                                '#6366f1',
                                '#64748b'
                            ]
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
                                ticks: {
                                    stepSize: 1,
                                    color: textColor
                                },
                                grid: {
                                    color: gridColor
                                }
                            },
                            x: {
                                ticks: {
                                    color: textColor
                                },
                                grid: {
                                    color: gridColor
                                }
                            }
                        }
                    }
                });
            } else {
                showNoDataMessage('infraestruturaChart', 'Nenhum dado de infraestrutura encontrado');
            }
        }
    });
});
</script>
@endpush
@endsection
