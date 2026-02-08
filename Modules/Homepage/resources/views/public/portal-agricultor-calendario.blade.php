@extends('homepage::layouts.homepage')

@section('title', 'Calendário de Eventos - Portal do Agricultor - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-yellow-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('portal.agricultor.index') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Voltar ao Portal do Agricultor
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                Calendário de Eventos
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Confira os próximos eventos, capacitações e atividades programadas
            </p>
        </div>

        @if($eventos->count() > 0)
            <div class="space-y-8">
                @foreach($eventos as $mes => $eventosMes)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            @php
                                $dataMes = \Carbon\Carbon::createFromFormat('Y-m', $mes);
                                $meses = [
                                    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                                    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                                    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                                ];
                            @endphp
                            {{ $meses[$dataMes->month] }} de {{ $dataMes->year }}
                        </h2>
                        
                        <div class="space-y-4">
                            @foreach($eventosMes as $evento)
                                <a href="{{ route('portal.agricultor.evento', $evento->id) }}" class="group block bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-slate-700 dark:to-slate-600 rounded-xl p-6 border border-amber-200 dark:border-amber-800 hover:shadow-lg transition-all duration-300">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <span class="text-white font-bold text-lg">
                                                        {{ $evento->data_inicio->format('d') }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                                                        {{ $evento->titulo }}
                                                    </h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $evento->tipo_texto }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="ml-0 md:ml-15 space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                                @if($evento->hora_inicio)
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>{{ $evento->hora_inicio->format('H:i') }}
                                                            @if($evento->hora_fim)
                                                                às {{ $evento->hora_fim->format('H:i') }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endif
                                                @if($evento->localidade)
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                                        </svg>
                                                        <span>{{ $evento->localidade->nome }}</span>
                                                    </div>
                                                @endif
                                                @if($evento->tem_vagas !== null)
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                                        </svg>
                                                        <span>{{ $evento->vagas_restantes ?? 'Ilimitado' }} vagas</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            @if($evento->pode_inscrever)
                                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full whitespace-nowrap">
                                                    Inscrições Abertas
                                                </span>
                                            @endif
                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-12 border border-gray-200 dark:border-gray-700 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Nenhum evento agendado</h3>
                <p class="text-gray-600 dark:text-gray-400">Não há eventos programados para os próximos 90 dias.</p>
            </div>
        @endif

        <!-- Link para Lista de Eventos -->
        <div class="text-center mt-8">
            <a href="{{ route('portal.agricultor.eventos') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 17.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
                Ver Lista Completa de Eventos
            </a>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection

