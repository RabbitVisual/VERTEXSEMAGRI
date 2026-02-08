@extends('homepage::layouts.homepage')

@section('title', 'Consulta - Portal do Agricultor - SEMAGRI')

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
                Resultado da Consulta
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                CPF: <span class="font-mono">{{ substr($cpfLimpo, 0, 3) }}.***.***-**</span>
            </p>
        </div>

        @if($pessoa)
            <!-- Informações da Pessoa -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Dados Cadastrais</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Nome</span>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $pessoa->nom_pessoa }}</p>
                    </div>
                    @if($pessoa->localidade)
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Localidade</span>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $pessoa->localidade->nome }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Programas e Benefícios -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                Programas e Benefícios
            </h2>
            @if($beneficiarios->count() > 0)
                <div class="space-y-4">
                    @foreach($beneficiarios as $beneficiario)
                        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                                        {{ $beneficiario->programa->nome }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $beneficiario->programa->tipo_texto }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($beneficiario->status === 'beneficiado') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                    @elseif($beneficiario->status === 'aprovado') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                    @else bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                                    @endif">
                                    {{ $beneficiario->status_texto }}
                                </span>
                            </div>
                            <div class="grid md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Data de Inscrição</span>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $beneficiario->data_inscricao->format('d/m/Y') }}
                                    </p>
                                </div>
                                @if($beneficiario->data_aprovacao)
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Data de Aprovação</span>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $beneficiario->data_aprovacao->format('d/m/Y') }}
                                        </p>
                                    </div>
                                @endif
                                @if($beneficiario->data_beneficio)
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Data do Benefício</span>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $beneficiario->data_beneficio->format('d/m/Y') }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-slate-800 rounded-xl p-8 border border-gray-200 dark:border-gray-700 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h4.125M8.25 8.25l5.25 5.25" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Você não está inscrito em nenhum programa no momento.</p>
                    <a href="{{ route('portal.agricultor.programas') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-600 text-white rounded-xl font-semibold hover:bg-amber-700 transition-colors">
                        Ver Programas Disponíveis
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>

        <!-- Inscrições em Eventos -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                Inscrições em Eventos
            </h2>
            @if($inscricoesEventos->count() > 0)
                <div class="space-y-4">
                    @foreach($inscricoesEventos as $inscricao)
                        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                                        {{ $inscricao->evento->titulo }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $inscricao->evento->tipo_texto }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($inscricao->status === 'presente') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                    @elseif($inscricao->status === 'confirmado') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                    @else bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                                    @endif">
                                    {{ $inscricao->status_texto }}
                                </span>
                            </div>
                            <div class="grid md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Data do Evento</span>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $inscricao->evento->data_inicio->format('d/m/Y') }}
                                        @if($inscricao->evento->hora_inicio)
                                            às {{ $inscricao->evento->hora_inicio->format('H:i') }}
                                        @endif
                                    </p>
                                </div>
                                @if($inscricao->evento->localidade)
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Local</span>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $inscricao->evento->localidade->nome }}
                                        </p>
                                    </div>
                                @endif
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Data de Inscrição</span>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $inscricao->data_inscricao->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-slate-800 rounded-xl p-8 border border-gray-200 dark:border-gray-700 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Você não está inscrito em nenhum evento no momento.</p>
                    <a href="{{ route('portal.agricultor.eventos') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-yellow-600 text-white rounded-xl font-semibold hover:bg-yellow-700 transition-colors">
                        Ver Eventos Disponíveis
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection

