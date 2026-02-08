@extends('homepage::layouts.homepage')

@section('title', 'Calendário de Eventos - Portal do Agricultor - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-yellow-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('portal.agricultor.index') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 mb-4">
                <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                Voltar ao Portal do Agricultor
            </a>
            <h1 class="text-3xl md:text-4xl font-bold font-poppins text-gray-900 dark:text-white mb-2">
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
                        <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-6">
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
                                                    <h3 class="text-lg font-bold font-poppins text-gray-900 dark:text-white group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
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
                                                        <x-icon name="clock" style="duotone" class="w-4 h-4" />
                                                        <span>{{ $evento->hora_inicio->format('H:i') }}
                                                            @if($evento->hora_fim)
                                                                às {{ $evento->hora_fim->format('H:i') }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endif
                                                @if($evento->localidade)
                                                    <div class="flex items-center gap-2">
                                                        <x-icon name="location-dot" style="duotone" class="w-4 h-4" />
                                                        <span>{{ $evento->localidade->nome }}</span>
                                                    </div>
                                                @endif
                                                @if($evento->tem_vagas !== null)
                                                    <div class="flex items-center gap-2">
                                                        <x-icon name="users" style="duotone" class="w-4 h-4" />
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
                                            <x-icon name="arrow-right" style="duotone" class="w-5 h-5 text-gray-400 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors" />
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
                <x-icon name="calendar-xmark" style="duotone" class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                <h3 class="text-xl font-bold font-poppins text-gray-900 dark:text-white mb-2">Nenhum evento agendado</h3>
                <p class="text-gray-600 dark:text-gray-400">Não há eventos programados para os próximos 90 dias.</p>
            </div>
        @endif

        <!-- Link para Lista de Eventos -->
        <div class="text-center mt-8">
            <a href="{{ route('portal.agricultor.eventos') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300">
                <x-icon name="list" style="duotone" class="w-5 h-5" />
                Ver Lista Completa de Eventos
            </a>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection
