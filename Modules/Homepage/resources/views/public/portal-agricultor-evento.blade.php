@extends('homepage::layouts.homepage')

@section('title', $evento->titulo . ' - Portal do Agricultor - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-yellow-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('portal.agricultor.eventos') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Voltar para Eventos
            </a>
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <span class="inline-block px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-sm font-semibold rounded-full mb-3">
                        {{ $evento->tipo_texto }}
                    </span>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ $evento->titulo }}
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        {{ $evento->descricao }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Informações do Evento -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 border border-gray-200 dark:border-gray-700 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Informações do Evento</h2>
            
            <div class="space-y-6">
                <!-- Data e Hora -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Data</span>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ $evento->data_inicio->format('d/m/Y') }}
                            @if($evento->data_fim && $evento->data_fim->ne($evento->data_inicio))
                                até {{ $evento->data_fim->format('d/m/Y') }}
                            @endif
                        </p>
                    </div>
                    @if($evento->hora_inicio)
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Horário</span>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                {{ $evento->hora_inicio->format('H:i') }}
                                @if($evento->hora_fim)
                                    às {{ $evento->hora_fim->format('H:i') }}
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Local -->
                @if($evento->localidade || $evento->endereco)
                    <div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Local</span>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            @if($evento->localidade)
                                {{ $evento->localidade->nome }}
                                @if($evento->endereco)
                                    - {{ $evento->endereco }}
                                @endif
                            @elseif($evento->endereco)
                                {{ $evento->endereco }}
                            @endif
                        </p>
                    </div>
                @endif

                <!-- Vagas -->
                @if($evento->tem_vagas !== null)
                    <div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Vagas</span>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ $evento->vagas_restantes ?? 'Ilimitado' }} de {{ $evento->vagas_totais ?? 'Ilimitado' }} vagas disponíveis
                        </p>
                        @if($evento->data_limite_inscricao)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Inscrições até {{ $evento->data_limite_inscricao->format('d/m/Y') }}
                            </p>
                        @endif
                    </div>
                @endif

                <!-- Status -->
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Status</span>
                    <p class="font-semibold">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm
                            @if($evento->status === 'agendado') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                            @elseif($evento->status === 'em_andamento') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                            @elseif($evento->status === 'concluido') bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400
                            @else bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                            @endif">
                            {{ $evento->status_texto }}
                        </span>
                    </p>
                </div>

                <!-- Público-Alvo -->
                @if($evento->publico_alvo)
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Público-Alvo</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $evento->publico_alvo }}</p>
                    </div>
                @endif

                <!-- Conteúdo Programático -->
                @if($evento->conteudo_programatico)
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Conteúdo Programático</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $evento->conteudo_programatico }}</p>
                        </div>
                    </div>
                @endif

                <!-- Instrutor/Palestrante -->
                @if($evento->instrutor_palestrante)
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Instrutor/Palestrante</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $evento->instrutor_palestrante }}</p>
                    </div>
                @endif

                <!-- Materiais Necessários -->
                @if($evento->materiais_necessarios)
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Materiais Necessários</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $evento->materiais_necessarios }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Call to Action -->
        @if($evento->pode_inscrever)
            <div class="bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl p-8 text-center text-white mb-6">
                <h3 class="text-2xl font-bold mb-4">Inscrições Abertas!</h3>
                <p class="text-white/90 mb-6">Participe deste evento e amplie seus conhecimentos</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="tel:+557532482489" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-yellow-600 rounded-xl font-semibold hover:bg-yellow-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                        Ligar para Inscrição
                    </a>
                    <a href="{{ route('portal.agricultor.index') }}#consultar" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/30 text-white rounded-xl font-semibold hover:bg-white/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
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

