@extends('homepage::layouts.homepage')

@section('title', $evento->titulo . ' - Portal do Agricultor - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-yellow-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('portal.agricultor.eventos') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 mb-4">
                <x-icon name="magnifying-glass" class="w-5 h-5" />
                        Consultar Minhas Inscrições
                    </a>
                </div>
            </div>
        @else
            <div class="bg-gray-100 dark:bg-slate-700 rounded-2xl p-8 text-center mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Inscrições Encerradas</h3>
                <p class="text-gray-600 dark:text-gray-400">As inscrições para este evento não estão mais disponíveis.</p>
            </div>
        @endif

        <!-- Link para Calendário -->
        <div class="text-center">
            <a href="{{ route('portal.agricultor.calendario') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                Ver Calendário de Eventos
            </a>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection

