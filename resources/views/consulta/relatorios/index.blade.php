@extends('consulta.layouts.consulta')

@section('title', 'Relatórios - Consulta')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="eye" class="w-5 h-5" />
                    Somente visualização
                </div>
            </div>
        </div>

        <!-- Card de Relatório -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mb-4">
                    <x-icon name="eye" class="w-5 h-5" />
                    Somente visualização
                </div>
            </div>
        </div>

        <!-- Card de Relatório -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center mb-4">
                    <x-icon name="eye" class="w-5 h-5" />
                    Somente visualização
                </div>
            </div>
        </div>

        <!-- Card de Relatório -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl flex items-center justify-center mb-4">
                    <x-icon name="eye" class="w-5 h-5" />
                    Somente visualização
                </div>
            </div>
        </div>

        <!-- Card de Relatório -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center mb-4">
                    <x-icon name="eye" class="w-5 h-5" />
                    Somente visualização
                </div>
            </div>
        </div>

        <!-- Card de Relatório -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mb-4">
                    <x-icon name="eye" class="w-5 h-5" />
                    Somente visualização
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas Resumidas -->
    @if(isset($stats))
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <x-icon name="eye" class="w-5 h-5" />
        </div>
        <h4 class="text-xl font-bold text-blue-800 dark:text-blue-300 mb-2">Modo Consulta</h4>
        <p class="text-sm text-blue-600 dark:text-blue-400 max-w-md mx-auto">
            Você está no modo de consulta. Os relatórios estão disponíveis apenas para visualização de dados agregados. 
            Para gerar relatórios completos com download, entre em contato com o administrador do sistema.
        </p>
    </div>
</div>
@endsection

