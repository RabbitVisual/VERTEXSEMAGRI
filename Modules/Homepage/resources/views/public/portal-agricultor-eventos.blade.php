@extends('homepage::layouts.homepage')

@section('title', 'Eventos e Capacitações - Portal do Agricultor - SEMAGRI')

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
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold font-poppins text-gray-900 dark:text-white mb-2">
                        Eventos e Capacitações
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Participe de eventos, palestras, capacitações e feiras para agricultores
                    </p>
                </div>
                <a href="{{ route('portal.agricultor.calendario') }}" class="hidden md:inline-flex items-center gap-2 px-6 py-3 bg-yellow-600 text-white rounded-xl font-semibold hover:bg-yellow-700 transition-colors">
                    <x-icon name="calendar-days" style="duotone" class="w-5 h-5" />
                    Ver Calendário
                </a>
            </div>
        </div>

        @if($eventos->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($eventos as $evento)
                    <a href="{{ route('portal.agricultor.evento', $evento->id) }}" class="group bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <span class="inline-block px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-semibold rounded-full">
                                {{ $evento->tipo_texto }}
                            </span>
                            @if($evento->pode_inscrever)
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">
                                    Inscrições Abertas
                                </span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold font-poppins text-gray-900 dark:text-white mb-3 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                            {{ $evento->titulo }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                            {{ Str::limit($evento->descricao ?? 'Evento para agricultores', 100) }}
                        </p>
                        <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-2">
                                <x-icon name="calendar" style="duotone" class="w-4 h-4" />
                                <span>{{ $evento->data_inicio->format('d/m/Y') }}</span>
                                @if($evento->hora_inicio)
                                    <span>às {{ $evento->hora_inicio->format('H:i') }}</span>
                                @endif
                            </div>
                            @if($evento->localidade)
                                <div class="flex items-center gap-2">
                                    <x-icon name="location-dot" style="duotone" class="w-4 h-4" />
                                    <span>{{ $evento->localidade->nome }}</span>
                                </div>
                            @endif
                            @if($evento->tem_vagas !== null)
                                <div class="flex items-center gap-2">
                                    <x-icon name="users" style="duotone" class="w-4 h-4" />
                                    <span>{{ $evento->vagas_restantes ?? 'Ilimitado' }} vagas disponíveis</span>
                                </div>
                            @endif
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <span class="text-yellow-600 dark:text-yellow-400 font-medium text-sm group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                Ver detalhes
                                <x-icon name="arrow-right" style="duotone" class="w-4 h-4" />
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Paginação -->
            <div class="mt-8">
                {{ $eventos->links() }}
            </div>

            <!-- Link para Calendário -->
            <div class="text-center mt-8">
                <a href="{{ route('portal.agricultor.calendario') }}" class="md:hidden inline-flex items-center gap-2 px-6 py-3 bg-yellow-600 text-white rounded-xl font-semibold hover:bg-yellow-700 transition-colors">
                    <x-icon name="calendar-days" style="duotone" class="w-5 h-5" />
                    Ver Calendário Completo
                </a>
            </div>
        @else
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-12 border border-gray-200 dark:border-gray-700 text-center">
                <x-icon name="calendar-xmark" style="duotone" class="w-16 h-16 text-gray-400 mx-auto mb-4 opacity-50" />
                <h3 class="text-xl font-bold font-poppins text-gray-900 dark:text-white mb-2">Nenhum evento disponível</h3>
                <p class="text-gray-600 dark:text-gray-400">Não há eventos agendados no momento. Tente novamente mais tarde.</p>
            </div>
        @endif
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection
