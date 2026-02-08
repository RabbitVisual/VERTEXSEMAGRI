@extends('homepage::layouts.homepage')

@section('title', $programa->nome . ' - Portal do Agricultor - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-yellow-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('portal.agricultor.programas') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 mb-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Voltar para Programas
            </a>
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <span class="inline-block px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-sm font-semibold rounded-full mb-3">
                        {{ $programa->tipo_texto }}
                    </span>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ $programa->nome }}
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400">
                        {{ $programa->descricao }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Informações do Programa -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 border border-gray-200 dark:border-gray-700 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Informações do Programa</h2>

            <div class="space-y-6">
                <!-- Status e Vagas -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Status</span>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm
                                @if($programa->status === 'ativo') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                @elseif($programa->status === 'suspenso') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                @else bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400
                                @endif">
                                {{ $programa->status_texto }}
                            </span>
                        </p>
                    </div>
                    @if($programa->tem_vagas !== null)
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Vagas Disponíveis</span>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                {{ $programa->vagas_restantes ?? 'Ilimitado' }} de {{ $programa->vagas_disponiveis ?? 'Ilimitado' }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Período -->
                @if($programa->data_inicio || $programa->data_fim)
                    <div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Período de Vigência</span>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            @if($programa->data_inicio)
                                De {{ $programa->data_inicio->format('d/m/Y') }}
                            @endif
                            @if($programa->data_fim)
                                até {{ $programa->data_fim->format('d/m/Y') }}
                            @else
                                (sem data de término)
                            @endif
                        </p>
                    </div>
                @endif

                <!-- Órgão Responsável -->
                @if($programa->orgao_responsavel)
                    <div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Órgão Responsável</span>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $programa->orgao_responsavel }}</p>
                    </div>
                @endif

                <!-- Requisitos -->
                @if($programa->requisitos)
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Requisitos</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $programa->requisitos }}</p>
                        </div>
                    </div>
                @endif

                <!-- Documentos Necessários -->
                @if($programa->documentos_necessarios)
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Documentos Necessários</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $programa->documentos_necessarios }}</p>
                        </div>
                    </div>
                @endif

                <!-- Benefícios -->
                @if($programa->beneficios)
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Benefícios</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $programa->beneficios }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-gradient-to-br from-amber-500 to-yellow-600 rounded-2xl p-8 text-center text-white">
            <h3 class="text-2xl font-bold mb-4">Quer participar deste programa?</h3>
            <p class="text-white/90 mb-6">Entre em contato com a Secretaria Municipal de Agricultura</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+557532482489" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-amber-600 rounded-xl font-semibold hover:bg-amber-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    (75) 3248-2489
                </a>
                <a href="{{ route('portal.agricultor.index') }}#consultar" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/30 text-white rounded-xl font-semibold hover:bg-white/20 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    Consultar Meus Benefícios
                </a>
            </div>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection

