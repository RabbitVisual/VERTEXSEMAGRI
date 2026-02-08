@extends('homepage::layouts.homepage')

@section('title', $programa->nome . ' - Portal do Agricultor - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-yellow-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('portal.agricultor.programas') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 mb-4">
                <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                Voltar para Programas
            </a>
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <span class="inline-block px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-sm font-semibold rounded-full mb-3">
                        {{ $programa->tipo_texto }}
                    </span>
                    <h1 class="text-3xl md:text-4xl font-bold font-poppins text-gray-900 dark:text-white mb-3">
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
            <h2 class="text-2xl font-bold font-poppins text-gray-900 dark:text-white mb-6">Informações do Programa</h2>

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
                        <h3 class="text-lg font-bold font-poppins text-gray-900 dark:text-white mb-3">Requisitos</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $programa->requisitos }}</p>
                        </div>
                    </div>
                @endif

                <!-- Documentos Necessários -->
                @if($programa->documentos_necessarios)
                    <div>
                        <h3 class="text-lg font-bold font-poppins text-gray-900 dark:text-white mb-3">Documentos Necessários</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $programa->documentos_necessarios }}</p>
                        </div>
                    </div>
                @endif

                <!-- Benefícios -->
                @if($programa->beneficios)
                    <div>
                        <h3 class="text-lg font-bold font-poppins text-gray-900 dark:text-white mb-3">Benefícios</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $programa->beneficios }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-gradient-to-br from-amber-500 to-yellow-600 rounded-2xl p-8 text-center text-white">
            <h3 class="text-2xl font-bold font-poppins mb-4">Quer participar deste programa?</h3>
            <p class="text-white/90 mb-6">Entre em contato com a Secretaria Municipal de Agricultura</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+557532482489" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-amber-600 rounded-xl font-semibold hover:bg-amber-50 transition-colors">
                    <x-icon name="phone" style="duotone" class="w-5 h-5" />
                    (75) 3248-2489
                </a>
                <a href="{{ route('portal.agricultor.index') }}#consultar" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/30 text-white rounded-xl font-semibold hover:bg-white/20 transition-colors">
                    <x-icon name="magnifying-glass" style="duotone" class="w-5 h-5" />
                    Consultar Meus Benefícios
                </a>
            </div>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection
