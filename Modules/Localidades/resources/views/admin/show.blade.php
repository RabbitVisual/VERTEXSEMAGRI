@extends('admin.layouts.admin')

@section('title', $localidade->nome . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon module="localidades" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>{{ $localidade->nome }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="eye" class="w-5 h-5" />
                Ver no Painel Padrão
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <div class="flex items-center">
            <x-icon name="circle-check" class="w-4 h-4 me-3" />
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Estatísticas Principais -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Pessoas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['total_pessoas'] }}</p>
                </div>
                <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl flex items-center justify-center border border-emerald-100 dark:border-emerald-800/50">
                    <x-icon name="users" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Demandas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['total_demandas'] }}</p>
                </div>
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center border border-blue-100 dark:border-blue-800/50">
                    <x-icon name="clipboard-list" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Demandas Abertas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['demandas_abertas'] }}</p>
                </div>
                <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-2xl flex items-center justify-center border border-amber-100 dark:border-amber-800/50">
                    <x-icon name="clock" class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pontos de Luz</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $infraestrutura['pontos_luz'] }}</p>
                </div>
                <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl flex items-center justify-center border border-indigo-100 dark:border-indigo-800/50">
                    <x-icon name="lightbulb" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                </div>
            </div>
        </div>
    </div>

    <!-- Dica de Uso - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">💡 Dicas de Uso</h3>
        </div>
        <div class="p-6">
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                <p><strong>Integração Completa:</strong> O módulo Localidades está totalmente integrado com os demais módulos do sistema.</p>
                <ul class="list-disc list-inside space-y-1 ml-4">
                    <li><strong>Pessoas:</strong> Todas as pessoas cadastradas no CadÚnico estão relacionadas a uma localidade.</li>
                    <li><strong>Demandas:</strong> As demandas são sempre relacionadas a uma localidade, permitindo rastreamento geográfico.</li>
                    <li><strong>Infraestrutura:</strong> Poços, pontos de luz, redes de água e trechos de estrada são relacionados às localidades.</li>
                    <li><strong>Relatórios:</strong> Gere relatórios por localidade para análise geográfica das demandas e serviços.</li>
                </ul>
                <p class="mt-3"><strong>Fluxo Recomendado:</strong> Cadastrar Localidade → Cadastrar Pessoas → Registrar Demandas → Atender com Ordens de Serviço → Gerar Relatórios</p>
            </div>
        </div>
    </div>
</div>
@endsection
