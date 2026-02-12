@extends('consulta.layouts.consulta')

@section('title', 'Relatórios - Consulta')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="chart-bar-square" class="w-5 h-5 md:w-6 md:h-6 text-white" />
                </div>
                Relatórios Gerenciais
            </h1>
            <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">
                Visualização de dados e estatísticas do sistema.
            </p>
        </div>
    </div>

    <!-- Grid de Relatórios -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Relatório de Atendimentos -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-all duration-300 group">
            <div class="p-6">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <x-icon name="clipboard-document-check" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Atendimentos</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Estatísticas de demandas atendidas, pendentes e canceladas por período.
                </p>
                <div class="flex items-center text-sm font-medium text-blue-600 dark:text-blue-400">
                    <span>Visualizar dados</span>
                    <x-icon name="arrow-right" class="w-4 h-4 ml-1" />
                </div>
            </div>
        </div>

        <!-- Relatório de Serviços -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-all duration-300 group">
            <div class="p-6">
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <x-icon name="wrench-screwdriver" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Serviços Executados</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Relatório detalhado de ordens de serviço executadas pelas equipes de campo.
                </p>
                <div class="flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400">
                    <span>Visualizar dados</span>
                    <x-icon name="arrow-right" class="w-4 h-4 ml-1" />
                </div>
            </div>
        </div>

        <!-- Relatório de Iluminação -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-all duration-300 group">
            <div class="p-6">
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <x-icon name="light-bulb" class="w-6 h-6 text-yellow-600 dark:text-yellow-400" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Iluminação Pública</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Monitoramento de pontos de luz, trocas de lâmpadas e manutenção da rede.
                </p>
                <div class="flex items-center text-sm font-medium text-yellow-600 dark:text-yellow-400">
                    <span>Visualizar dados</span>
                    <x-icon name="arrow-right" class="w-4 h-4 ml-1" />
                </div>
            </div>
        </div>

        <!-- Relatório de Frotas (Exemplo) -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-all duration-300 group opacity-60">
            <div class="p-6">
                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center mb-4">
                    <x-icon name="truck" class="w-6 h-6 text-gray-500 dark:text-gray-400" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Frotas e Maquinário</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Acesso restrito a administradores.
                </p>
                <div class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400">
                    <x-icon name="lock-closed" class="w-4 h-4 mr-1" />
                    <span>Acesso restrito</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas Resumidas -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-6">
        <div class="flex items-start gap-4">
            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <x-icon name="information-circle" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
            </div>
            <div>
                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Modo Consulta</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Você está acessando o painel em modo de consulta. Os relatórios exibidos aqui são simplificados para visualização rápida.
                    Para relatórios detalhados com exportação em PDF/Excel, solicite ao administrador do sistema ou acesse o painel administrativo caso tenha permissão.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
