@extends('Co-Admin.layouts.app')

@section('title', 'Portal do Agricultor - Temporariamente Indisponível')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-amber-100 dark:bg-amber-900/20 mb-6">
                <svg class="w-10 h-10 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Portal do Agricultor</h1>
            <p class="text-xl text-gray-600 dark:text-gray-400">Temporariamente Indisponível</p>
        </div>

        <!-- Mensagem -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-amber-200 dark:border-amber-800 p-8 mb-8">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">
                        Módulo Temporariamente Desativado
                    </h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        O Portal do Agricultor está temporariamente indisponível devido à manutenção do módulo de Programas de Agricultura.
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Pedimos desculpas pelo inconveniente. O serviço será restaurado em breve.
                    </p>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            <strong>Dúvidas?</strong> Entre em contato com a Secretaria Municipal de Agricultura através dos canais oficiais.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botão Voltar -->
        <div class="text-center">
            <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar para a Página Inicial
            </a>
        </div>
    </div>
</div>
@endsection

