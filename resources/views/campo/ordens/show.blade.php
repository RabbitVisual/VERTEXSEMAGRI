@extends('campo.layouts.app')

@section('title', 'Detalhes da Ordem')

@section('content')
<div class="space-y-6">
    <!-- Page Header - HyperUI Style -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <span>OS: <span class="text-indigo-600 dark:text-indigo-400">{{ $ordem->numero }}</span></span>
            </h1>
            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Detalhes e ações da ordem de serviço</p>
        </div>
        <a href="{{ route('campo.ordens.index') }}" class="inline-flex items-center px-4 md:px-6 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-all duration-200 font-medium shadow-sm hover:shadow-md active:scale-95">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Voltar
        </a>
    </div>

    <!-- Status Badges - HyperUI Badge Style -->
    <div class="flex flex-wrap items-center gap-3">
        <span class="inline-flex items-center px-3 md:px-4 py-1.5 md:py-2 text-sm font-semibold rounded-full border bg-{{ $ordem->status_cor }}-100 text-{{ $ordem->status_cor }}-800 dark:bg-{{ $ordem->status_cor }}-900/20 dark:text-{{ $ordem->status_cor }}-400 border-{{ $ordem->status_cor }}-200 dark:border-{{ $ordem->status_cor }}-800">
            {{ $ordem->status_texto }}
        </span>
        <span class="inline-flex items-center px-3 md:px-4 py-1.5 md:py-2 text-sm font-semibold rounded-full border bg-{{ $ordem->prioridade_cor }}-100 text-{{ $ordem->prioridade_cor }}-800 dark:bg-{{ $ordem->prioridade_cor }}-900/20 dark:text-{{ $ordem->prioridade_cor }}-400 border-{{ $ordem->prioridade_cor }}-200 dark:border-{{ $ordem->prioridade_cor }}-800">
            Prioridade: {{ ucfirst($ordem->prioridade) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Conteúdo Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informações da Demanda - HyperUI Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-4 md:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>
                    Informações da Demanda
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($ordem->demanda)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código da Demanda</label>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $ordem->demanda->codigo ?? 'N/A' }}</p>
                        </div>
                        @if($ordem->demanda->localidade)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white flex items-center gap-1">
                                    <x-icon name="map-pin" class="w-4 h-4" />
                                    {{ $ordem->demanda->localidade->nome }}
                                </p>
                            </div>
                        @endif
                        @if($ordem->demanda->solicitante_nome)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Solicitante</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white flex items-center gap-1">
                                    <x-icon name="user" class="w-4 h-4" />
                                    {{ $ordem->demanda->solicitante_nome }}
                                </p>
                            </div>
                        @endif
                        @if($ordem->demanda->solicitante_telefone)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Telefone</label>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $ordem->demanda->solicitante_telefone }}</p>
                            </div>
                        @endif
                    @endif
                    @if($ordem->equipe)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Equipe</label>
                            <p class="text-sm font-medium text-gray-900 dark:text-white flex items-center gap-1">
                                <x-icon name="user-group" class="w-4 h-4" />
                                {{ $ordem->equipe->nome }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Descrição - HyperUI Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-4 md:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    Descrição do Serviço
                </h2>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $ordem->descricao }}</p>
            </div>

            <!-- Fotos Antes - HyperUI Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-4 md:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>
                    </div>
                    Fotos Antes
                </h2>
                <div id="fotosAntesContainer" class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                    @if(!empty($fotosAntesUrls))
                        @foreach($fotosAntesUrls as $index => $url)
                            <div class="relative group">
                                <img src="{{ $url }}" alt="Foto antes {{ $index + 1 }}" class="w-full h-48 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                @if($ordem->status === 'em_execucao')
                                    <button
                                        onclick="removerFoto('{{ $ordem->fotos_antes[$index] }}', 'antes')"
                                        class="absolute top-2 right-2 p-2 bg-red-600 hover:bg-red-700 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                                        title="Remover foto"
                                    >
                                        <x-icon name="x-mark" class="w-4 h-4" />
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
                @if($ordem->status === 'em_execucao')
                    <x-campo-upload-fotos ordem-id="{{ $ordem->id }}" tipo="antes" />
                @endif
            </div>

            <!-- Fotos Depois - HyperUI Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-4 md:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>
                    </div>
                    Fotos Depois
                </h2>

                @if(!empty($fotosDepoisUrls) && count($fotosDepoisUrls) > 0)
                    <!-- Exibir fotos já adicionadas -->
                    <div id="fotosDepoisContainer" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($fotosDepoisUrls as $index => $url)
                            <div class="relative group">
                                <img src="{{ $url }}" alt="Foto depois {{ $index + 1 }}" class="w-full h-48 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                            </div>
                        @endforeach
                    </div>
                @elseif($ordem->status === 'em_execucao')
                    <!-- Dica: foto será adicionada na conclusão -->
                    <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <svg class="w-6 h-6 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>
                        <div class="text-sm text-blue-700 dark:text-blue-300">
                            <strong>Foto do resultado:</strong> Ao clicar em <strong>"Concluir Ordem"</strong>, você poderá adicionar a foto do serviço finalizado junto com o relatório.
                        </div>
                    </div>
                @elseif($ordem->status === 'concluida')
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma foto depois registrada.</p>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">As fotos serão adicionadas durante a execução.</p>
                @endif
            </div>

            <!-- Materiais Utilizados - HyperUI Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-4 md:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5l3-3m0 0l3 3m-3-3v12m0 0h-3m3 0h3" />
                        </svg>
                    </div>
                    Materiais Utilizados
                </h2>

                @if($ordem->status === 'em_execucao' || $ordem->status === 'pendente')
                    <!-- Card Explicativo sobre Sistema de Reserva - HyperUI Info Card -->
                    <div class="mb-4 p-4 bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-purple-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-2">Como Funciona o Sistema de Materiais</h3>
                                <div class="space-y-2 text-xs md:text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                    <p class="flex items-start gap-2">
                                        <span class="font-bold text-blue-600 dark:text-blue-400 mt-0.5">1.</span>
                                        <span><strong>Reserva:</strong> Ao selecionar um material, ele é <strong class="text-blue-600 dark:text-blue-400">RESERVADO</strong> no estoque (fica indisponível para outros).</span>
                                    </p>
                                    <p class="flex items-start gap-2">
                                        <span class="font-bold text-emerald-600 dark:text-emerald-400 mt-0.5">2.</span>
                                        <span><strong>Confirmação:</strong> Quando você <strong class="text-emerald-600 dark:text-emerald-400">concluir a OS</strong>, a reserva é confirmada e o material é baixado definitivamente do estoque.</span>
                                    </p>
                                    <p class="flex items-start gap-2">
                                        <span class="font-bold text-amber-600 dark:text-amber-400 mt-0.5">3.</span>
                                        <span><strong>Cancelamento:</strong> Se remover um material antes de concluir, a reserva é <strong class="text-amber-600 dark:text-amber-400">cancelada</strong> e o estoque é restaurado.</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($ordem->materiais && $ordem->materiais->count() > 0)
                    <!-- Contador de Materiais Reservados -->
                    <div id="contador-materiais" class="mb-4 inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5l3-3m0 0l3 3m-3-3v12m0 0h-3m3 0h3" />
                        </svg>
                        <span class="text-sm font-semibold text-indigo-900 dark:text-indigo-200">
                            <span id="materiais-reservados-count">{{ $ordem->materiais->count() }}</span>
                            <span id="materiais-reservados-text">{{ $ordem->materiais->count() == 1 ? 'material reservado' : 'materiais reservados' }}</span> para esta OS
                        </span>
                    </div>

                    <div id="materiais-container" class="space-y-3 mb-4">
                        @foreach($ordem->materiais as $ordemMaterial)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white dark:from-gray-700/50 dark:to-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg hover:shadow-md transition-all duration-200" data-material-id="{{ $ordemMaterial->material_id }}">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $ordemMaterial->material->nome ?? 'N/A' }}</p>
                                        @php
                                            // Se não tiver status_reserva, considerar baseado no status da OS
                                            // Se a OS está concluída, o material deve estar confirmado
                                            if ($ordem->status === 'concluida') {
                                                $statusReserva = 'confirmado';
                                            } else {
                                                $statusReserva = $ordemMaterial->status_reserva ?? 'reservado';
                                            }
                                        @endphp
                                        @if($statusReserva === 'reservado')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Reservado
                                            </span>
                                        @elseif($statusReserva === 'confirmado')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Confirmado
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <span class="font-medium">Quantidade:</span> {{ number_format($ordemMaterial->quantidade, 2, ',', '.') }} {{ $ordemMaterial->material->unidade_medida ?? '' }}
                                        @if($ordemMaterial->valor_unitario)
                                            <span class="mx-2">•</span>
                                            <span class="font-medium">Valor:</span> R$ {{ number_format($ordemMaterial->valor_unitario * $ordemMaterial->quantidade, 2, ',', '.') }}
                                        @endif
                                    </p>
                                    @php
                                        // Se a OS está concluída, o material deve estar confirmado
                                        if ($ordem->status === 'concluida') {
                                            $statusReserva = 'confirmado';
                                        } else {
                                            $statusReserva = $ordemMaterial->status_reserva ?? 'reservado';
                                        }
                                    @endphp
                                    @if($statusReserva === 'reservado' && $ordem->status === 'em_execucao')
                                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                            Será confirmado ao concluir a OS
                                        </p>
                                    @endif
                                </div>
                                @php
                                    // Se a OS está concluída, o material deve estar confirmado
                                    if ($ordem->status === 'concluida') {
                                        $statusReserva = 'confirmado';
                                    } else {
                                        $statusReserva = $ordemMaterial->status_reserva ?? 'reservado';
                                    }
                                @endphp
                                @if($ordem->status === 'em_execucao' && $statusReserva === 'reservado')
                                    <button
                                        onclick="removerMaterial({{ $ordemMaterial->material_id }})"
                                        class="ml-3 p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200 hover:scale-110 active:scale-95"
                                        title="Remover material (a reserva será cancelada e o estoque restaurado)"
                                    >
                                        <x-icon name="trash" class="w-5 h-5" />
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div id="materiais-container" class="space-y-3 mb-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Nenhum material registrado.</p>
                    </div>
                @endif

                @if($ordem->status === 'pendente')
                    <div class="flex items-start gap-3 p-4 bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-200 dark:border-amber-800 rounded-xl">
                        <div class="flex-shrink-0 w-10 h-10 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-amber-900 dark:text-amber-200 mb-1">Ação Necessária</h4>
                            <p class="text-sm text-amber-800 dark:text-amber-300">
                                <strong>Inicie o atendimento</strong> primeiro para poder adicionar materiais utilizados. Após iniciar, você poderá selecionar os materiais que serão <strong>reservados</strong> no estoque.
                            </p>
                        </div>
                    </div>
                @endif

                @if($ordem->status === 'em_execucao')
                    <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-6 mt-6">
                        <!-- Checkbox para informar que não precisou de material -->
                        <div id="sem-material-container" class="mb-6">
                            <label class="flex items-start gap-3 p-4 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border-2 border-emerald-200 dark:border-emerald-800 rounded-xl cursor-pointer hover:shadow-md transition-all duration-200">
                                <input
                                    type="checkbox"
                                    id="sem_material"
                                    onchange="toggleMaterialForm()"
                                    {{ $ordem->sem_material ? 'checked' : '' }}
                                    class="w-5 h-5 mt-0.5 text-emerald-600 border-gray-300 dark:border-gray-600 rounded focus:ring-emerald-500"
                                >
                                <div class="flex-1">
                                    <span class="font-semibold text-gray-900 dark:text-white block mb-1">Não precisou de material</span>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Marque esta opção se o serviço foi realizado apenas com reparo no local, sem necessidade de materiais do estoque.</p>
                                </div>
                            </label>
                        </div>

                        <!-- Formulário de adicionar material -->
                        <form id="formAdicionarMaterial" class="space-y-4 {{ $ordem->sem_material ? 'hidden' : '' }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-2">
                                    <label for="material_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5l3-3m0 0l3 3m-3-3v12m0 0h-3m3 0h3" />
                                            </svg>
                                            Material
                                        </span>
                                    </label>
                                    <select
                                        id="material_id"
                                        name="material_id"
                                        onchange="verificarEstoqueMaterial(this)"
                                        class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm md:text-base"
                                    >
                                        <option value="">Selecione um material</option>
                                        @php
                                            // Buscar todos os materiais ativos
                                            // O quantidade_estoque já reflete o estoque disponível (já descontando reservas)
                                            $materiais = \Modules\Materiais\App\Models\Material::where('ativo', true)
                                                ->orderBy('nome')
                                                ->get();
                                        @endphp
                                        @foreach($materiais as $material)
                                            @php
                                                // O estoque disponível é simplesmente quantidade_estoque (já descontando reservas)
                                                $estoqueDisponivel = max(0, $material->quantidade_estoque);
                                                $temEstoque = $estoqueDisponivel > 0;
                                                $estoqueTexto = $temEstoque
                                                    ? 'Disponível: ' . number_format($estoqueDisponivel, 2, ',', '.') . ' ' . $material->unidade_medida
                                                    : 'Sem Estoque';
                                            @endphp
                                            <option
                                                value="{{ $material->id }}"
                                                data-estoque="{{ $estoqueDisponivel }}"
                                                data-unidade="{{ $material->unidade_medida }}"
                                                data-tem-estoque="{{ $temEstoque ? '1' : '0' }}"
                                                data-material-nome="{{ $material->nome }}"
                                                data-material-codigo="{{ $material->codigo ?? '' }}"
                                                {{ !$temEstoque ? 'disabled' : '' }}
                                                class="{{ !$temEstoque ? 'text-gray-400 italic' : '' }}"
                                            >
                                                {{ $material->nome }}
                                                @if($material->codigo)
                                                    ({{ $material->codigo }})
                                                @endif
                                                - {{ $estoqueTexto }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                        </svg>
                                        O material será <strong>reservado</strong> no estoque ao adicionar
                                    </p>
                                    <div id="material-sem-estoque-alerta" class="hidden mt-3 p-4 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl shadow-sm">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/50 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-bold text-red-900 dark:text-red-200 mb-1">Material sem estoque disponível</h4>
                                                <p class="text-xs text-red-700 dark:text-red-300 mb-3 leading-relaxed">
                                                    Este material não está disponível no estoque no momento. Você pode solicitar o material através do botão abaixo. O administrador será notificado e processará sua solicitação.
                                                </p>
                                                <button
                                                    type="button"
                                                    onclick="abrirModalSolicitarMaterial()"
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105 active:scale-95"
                                                >
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                    </svg>
                                                    Solicitar Material
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="quantidade_material" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                            </svg>
                                            Quantidade
                                        </span>
                                    </label>
                                    <input
                                        type="number"
                                        id="quantidade_material"
                                        name="quantidade"
                                        step="0.01"
                                        min="0.01"
                                        class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm md:text-base"
                                        placeholder="0.00"
                                    >
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Informe a quantidade necessária</p>
                                </div>
                                <div class="md:col-span-3">
                                    <label for="poste_codigo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m4.5 0a12.05 12.05 0 004.5 0m0 0a12.05 12.05 0 00-4.5 0m4.5 0v5.25M9 18v-5.25m0 0a6.01 6.01 0 00-1.5-.189M9 12.75a6.01 6.01 0 011.5-.189m-1.5.189a6.01 6.01 0 00-1.5-.189m1.5.189v5.25m0 0a12.05 12.05 0 01-4.5 0m4.5 0v5.25" /></svg>
                                            Código do Poste (Opcional - Iluminação)
                                        </span>
                                    </label>
                                    <input
                                        type="text"
                                        id="poste_codigo"
                                        name="poste_codigo"
                                        class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm md:text-base"
                                        placeholder="Digite o código da plaqueta..."
                                    >
                                </div>
                            </div>
                            <button
                                type="button"
                                onclick="adicionarMaterial()"
                                class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg hover:scale-[1.02] active:scale-95"
                            >
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Adicionar Material (Reservar no Estoque)
                            </button>
                        </form>
                    </div>
                @endif

                @if($ordem->status === 'concluida' && $ordem->sem_material)
                    <div class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-full text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Serviço realizado sem uso de materiais
                    </div>
                @endif
            </div>

            <!-- Relatório de Execução - HyperUI Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-4 md:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    Relatório de Execução
                </h2>
                @if($ordem->status === 'em_execucao')
                    <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <svg class="w-6 h-6 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        <div class="text-sm text-blue-700 dark:text-blue-300">
                            <strong>Dica:</strong> O relatório será preenchido quando você clicar em <strong>"Concluir Ordem"</strong>.
                            Primeiro registre as fotos ANTES, materiais utilizados e tire a foto DEPOIS do serviço.
                        </div>
                    </div>
                @elseif($ordem->status === 'concluida' && $ordem->relatorio_execucao)
                    <div class="prose dark:prose-invert max-w-none">
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $ordem->relatorio_execucao }}</p>
                    </div>
                    @if($ordem->sem_material)
                        <div class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-full text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Serviço realizado sem uso de materiais
                        </div>
                    @endif
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Nenhum relatório registrado.</p>
                @endif
            </div>
        </div>

        <!-- Sidebar de Ações -->
        <div class="space-y-6">
            <!-- Dicas de Uso Contextual -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800 p-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-indigo-900 dark:text-indigo-300 mb-2">
                            @if($ordem->status === 'pendente')
                                Como Começar
                            @elseif($ordem->status === 'em_execucao')
                                Dicas de Execução
                            @else
                                Ordem Concluída
                            @endif
                        </h3>
                        <div class="text-xs text-indigo-700 dark:text-indigo-400 space-y-2">
                            @if($ordem->status === 'pendente')
                                <p class="flex items-start gap-2">
                                    <span class="font-bold text-indigo-500">1.</span>
                                    <span>Clique em <strong>"Iniciar Atendimento"</strong> para começar.</span>
                                </p>
                                <p class="flex items-start gap-2">
                                    <span class="font-bold text-indigo-500">2.</span>
                                    <span>Tire fotos ANTES e registre os materiais utilizados.</span>
                                </p>
                                <p class="flex items-start gap-2">
                                    <span class="font-bold text-indigo-500">3.</span>
                                    <span>Ao concluir, preencha o relatório e tire foto DEPOIS.</span>
                                </p>
                            @elseif($ordem->status === 'em_execucao')
                                <p class="flex items-start gap-2">
                                    <span class="font-bold text-indigo-500">1.</span>
                                    <span><strong>Foto ANTES:</strong> Registre o estado inicial.</span>
                                </p>
                                <p class="flex items-start gap-2">
                                    <span class="font-bold text-indigo-500">2.</span>
                                    <span><strong>Materiais:</strong> Adicione os materiais usados ou marque "sem material".</span>
                                </p>
                                <p class="flex items-start gap-2">
                                    <span class="font-bold text-indigo-500">3.</span>
                                    <span><strong>Foto DEPOIS:</strong> Registre o resultado do serviço.</span>
                                </p>
                                <p class="flex items-start gap-2">
                                    <span class="font-bold text-indigo-500">4.</span>
                                    <span><strong>Concluir:</strong> Preencha o relatório e finalize.</span>
                                </p>
                            @else
                                <p class="flex items-start gap-2">
                                    <span class="font-bold text-indigo-500">•</span>
                                    <span>Esta ordem foi concluída com sucesso!</span>
                                </p>
                                <p class="flex items-start gap-2">
                                    <span class="font-bold text-indigo-500">•</span>
                                    <span>Os dados estão registrados para relatórios e auditoria.</span>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações Rápidas - HyperUI Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-4 md:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    Ações
                </h2>
                <div class="space-y-3">
                    @if($ordem->status === 'pendente')
                        <form method="POST" action="{{ route('campo.ordens.iniciar', $ordem->id) }}" onsubmit="return confirm('Deseja iniciar o atendimento desta ordem?');">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium shadow-sm hover:shadow-md active:scale-95">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                </svg>
                                Iniciar Atendimento
                            </button>
                        </form>
                    @endif

                    @if($ordem->status === 'em_execucao')
                        <button
                            onclick="concluirOrdem()"
                            class="w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium shadow-sm hover:shadow-md active:scale-95"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Concluir Ordem
                        </button>
                    @endif
                </div>
            </div>

            <!-- Timeline do Atendimento - HyperUI Timeline -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-4 md:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Timeline do Atendimento
                </h2>
                <div class="relative">
                    <!-- Abertura -->
                    <div class="relative pb-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 text-white">
                                    <x-icon name="check-circle" class="w-6 h-6" />
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-base font-semibold text-gray-900 dark:text-white">Ordem Criada</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ordem->data_abertura->format('d/m/Y H:i') }}</p>
                                @if($ordem->usuarioAbertura)
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Por: {{ $ordem->usuarioAbertura->name }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="absolute left-5 top-10 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                    </div>

                    <!-- Início -->
                    @if($ordem->data_inicio)
                        <div class="relative pb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-emerald-500 text-white">
                                        <x-icon name="play" class="w-6 h-6" />
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-base font-semibold text-gray-900 dark:text-white">Atendimento Iniciado</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ordem->data_inicio->format('d/m/Y H:i') }}</p>
                                    @if($ordem->usuarioExecucao)
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Por: {{ $ordem->usuarioExecucao->name }}</p>
                                    @endif
                                </div>
                            </div>
                            @if($ordem->data_conclusao)
                                <div class="absolute left-5 top-10 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                            @endif
                        </div>
                    @endif

                    <!-- Conclusão -->
                    @if($ordem->data_conclusao)
                        <div class="relative">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-emerald-600 text-white">
                                        <x-icon name="check-circle" class="w-6 h-6" />
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-base font-semibold text-gray-900 dark:text-white">Ordem Concluída</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ordem->data_conclusao->format('d/m/Y H:i') }}</p>
                                    @if($ordem->tempo_execucao_formatado)
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Tempo de execução: {{ $ordem->tempo_execucao_formatado }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Histórico de Auditoria filtrado - apenas eventos relevantes --}}
                    @if(isset($historico) && $historico->count() > 0)
                        @php
                            // Filtrar apenas logs relevantes (com mudança de status ou ações específicas)
                            $logsRelevantes = $historico->filter(function($log) {
                                // Ações sempre relevantes
                                $acoesRelevantes = ['created', 'deleted', 'restored', 'status_changed', 'started', 'completed', 'cancelled', 'ordem.iniciar', 'ordem.concluir'];
                                if (in_array(strtolower($log->action ?? ''), $acoesRelevantes)) {
                                    return true;
                                }
                                // Para 'updated', mostrar apenas se tiver mudança de status
                                if (strtolower($log->action ?? '') === 'updated') {
                                    if (isset($log->new_data) && is_array($log->new_data) && isset($log->new_data['status'])) {
                                        return true;
                                    }
                                    return false;
                                }
                                return false;
                            });

                            // Tradução dos status para português
                            $statusTraduzido = [
                                'pendente' => 'Pendente',
                                'em_execucao' => 'Em Execução',
                                'em_andamento' => 'Em Andamento',
                                'concluida' => 'Concluída',
                                'concluido' => 'Concluído',
                                'cancelada' => 'Cancelada',
                                'cancelado' => 'Cancelado',
                                'aberta' => 'Aberta',
                                'fechada' => 'Fechada',
                            ];
                        @endphp
                        @foreach($logsRelevantes as $log)
                            @php
                                // Tradução das ações para português
                                $acaoTraduzida = match(strtolower($log->action ?? '')) {
                                    'created' => 'Registro Criado',
                                    'updated' => 'Status Alterado',
                                    'deleted' => 'Registro Excluído',
                                    'restored' => 'Registro Restaurado',
                                    'status_changed' => 'Status Alterado',
                                    'started', 'ordem.iniciar' => 'Atendimento Iniciado',
                                    'completed', 'ordem.concluir' => 'Serviço Concluído',
                                    'cancelled' => 'Cancelado',
                                    default => ucfirst(str_replace(['_', '.'], ' ', $log->action ?? ''))
                                };
                            @endphp
                            <div class="relative pb-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-400 dark:bg-gray-600 text-white">
                                            <x-icon name="document-text" class="w-6 h-6" />
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">
                                            {{ $acaoTraduzida }}
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}
                                        </p>
                                        @if(isset($log->new_data) && is_array($log->new_data) && isset($log->new_data['status']))
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                                Status: <strong>{{ $statusTraduzido[strtolower($log->new_data['status'])] ?? ucfirst(str_replace('_', ' ', $log->new_data['status'])) }}</strong>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <div class="absolute left-5 top-10 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Informações Adicionais - HyperUI Details List -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-4 md:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Informações
                </h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Abertura</label>
                        <p class="text-gray-900 dark:text-white">{{ $ordem->data_abertura->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($ordem->data_inicio)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Iniciada em</label>
                            <p class="text-gray-900 dark:text-white">{{ $ordem->data_inicio->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                    @if($ordem->data_conclusao)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Concluída em</label>
                            <p class="text-gray-900 dark:text-white">{{ $ordem->data_conclusao->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                    @if($ordem->tempo_execucao_formatado)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tempo de Execução</label>
                            <p class="text-gray-900 dark:text-white">{{ $ordem->tempo_execucao_formatado }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Conclusão - HyperUI Modal -->
<div id="modalConcluir" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-2xl w-full p-5 md:p-6 my-8 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Concluir Ordem de Serviço
            </h3>
            <button
                type="button"
                onclick="fecharModalConcluir()"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
            >
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Resumo antes de concluir -->
        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>
                Resumo da Execução
            </h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Fotos Antes:</span>
                    <span class="ml-2 font-medium text-gray-900 dark:text-white" id="resumo-fotos-antes">
                        {{ is_array($ordem->fotos_antes) ? count($ordem->fotos_antes) : 0 }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Fotos Depois:</span>
                    <span class="ml-2 font-medium text-gray-900 dark:text-white" id="resumo-fotos-depois">
                        {{ is_array($ordem->fotos_depois) ? count($ordem->fotos_depois) : 0 }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Materiais:</span>
                    <span class="ml-2 font-medium text-gray-900 dark:text-white" id="resumo-materiais">
                        @if($ordem->sem_material)
                            Nenhum (sem necessidade)
                        @else
                            {{ $ordem->materiais ? $ordem->materiais->count() : 0 }} item(s)
                        @endif
                    </span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Tempo:</span>
                    <span class="ml-2 font-medium text-gray-900 dark:text-white">
                        @if($ordem->data_inicio)
                            {{ $ordem->data_inicio->diffForHumans(now(), ['parts' => 2, 'short' => true]) }}
                        @else
                            --
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <form id="formConcluir" method="POST" action="{{ route('campo.ordens.concluir', $ordem->id) }}" enctype="multipart/form-data">
            @csrf

            <!-- Upload Foto DEPOIS (no modal de conclusão) -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>
                        Foto do Resultado (Depois)
                    </span>
                </label>

                @if(is_array($ordem->fotos_depois) && count($ordem->fotos_depois) > 0)
                    <!-- Já tem fotos depois -->
                    <div class="flex items-center gap-2 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg mb-3">
                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm text-emerald-700 dark:text-emerald-300">
                            <strong>{{ count($ordem->fotos_depois) }} foto(s)</strong> do resultado já adicionada(s).
                        </span>
                    </div>
                @endif

                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-4 text-center hover:border-emerald-500 dark:hover:border-emerald-400 transition-colors cursor-pointer"
                     onclick="document.getElementById('fotos_depois_modal').click()">

                    <input type="file"
                           id="fotos_depois_modal"
                           name="fotos_depois[]"
                           class="hidden"
                           accept="image/*"
                           multiple
                           capture="environment"
                           onchange="previewFotosModal(this)">

                    <div class="flex flex-col items-center gap-2">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                Tirar foto ou selecionar imagem
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Registre o resultado final do serviço
                            </p>
                        </div>
                        <span class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium rounded-lg transition-colors">
                            Adicionar Foto
                        </span>
                    </div>
                </div>

                <!-- Preview das fotos selecionadas -->
                <div id="preview-fotos-modal" class="mt-3 grid grid-cols-3 gap-2 hidden"></div>
            </div>

            <div class="mb-4">
                <label for="relatorio_final" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        Relatório de Conclusão <span class="text-red-500">*</span>
                    </span>
                </label>
                <textarea
                    id="relatorio_final"
                    name="relatorio_execucao"
                    rows="5"
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Descreva o que foi realizado:&#10;- Problema encontrado&#10;- Solução aplicada&#10;- Observações importantes"
                >{{ $ordem->relatorio_execucao ?? '' }}</textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Descreva detalhadamente o serviço executado, problemas encontrados e soluções aplicadas.
                </p>
            </div>

            <div class="mb-6">
                <label for="observacoes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Observações Adicionais (Opcional)
                </label>
                <textarea
                    id="observacoes"
                    name="observacoes"
                    rows="2"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Ex: Necessita retorno, verificar novamente em 30 dias..."
                >{{ $ordem->observacoes ?? '' }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button
                    type="button"
                    onclick="fecharModalConcluir()"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors"
                >
                    Cancelar
                </button>
                <button
                    type="submit"
                    class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Concluir Ordem
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Solicitação de Material -->
<div id="modalSolicitarMaterial" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Solicitar Material</h3>
                <button
                    onclick="fecharModalSolicitarMaterial()"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                >
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="formSolicitarMaterial" onsubmit="event.preventDefault(); enviarSolicitacaoMaterial();">
                @csrf
                <input type="hidden" id="solicitar_material_id" name="material_id">
                <input type="hidden" id="solicitar_ordem_servico_id" name="ordem_servico_id" value="{{ $ordem->id }}">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nome do Material <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="solicitar_material_nome"
                            name="material_nome"
                            required
                            readonly
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Código do Material
                        </label>
                        <input
                            type="text"
                            id="solicitar_material_codigo"
                            name="material_codigo"
                            readonly
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                        >
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Quantidade <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                name="quantidade"
                                step="0.01"
                                min="0.01"
                                required
                                placeholder="0.00"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Unidade <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="solicitar_unidade_medida"
                                name="unidade_medida"
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            >
                                <option value="unidade">Unidade</option>
                                <option value="metro">Metro</option>
                                <option value="litro">Litro</option>
                                <option value="kg">KG</option>
                                <option value="caixa">Caixa</option>
                                <option value="pacote">Pacote</option>
                                <option value="rolo">Rolo</option>
                                <option value="conjunto">Conjunto</option>
                                <option value="peca">Peça</option>
                                <option value="galoes">Galões</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Justificativa <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="justificativa"
                            rows="3"
                            required
                            placeholder="Ex: Necessário para reparo urgente na OS #{{ $ordem->numero }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Observações (Opcional)
                        </label>
                        <textarea
                            name="observacoes"
                            rows="2"
                            placeholder="Informações adicionais sobre a solicitação"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                        ></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button
                        type="button"
                        onclick="fecharModalSolicitarMaterial()"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors"
                    >
                        Enviar Solicitação
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle formulário de material quando marcar "Não precisou de material"
    function toggleMaterialForm() {
        const checkbox = document.getElementById('sem_material');
        const formMaterial = document.getElementById('formAdicionarMaterial');

        if (checkbox && formMaterial) {
            if (checkbox.checked) {
                formMaterial.classList.add('hidden');
                // Salvar preferência no servidor
                salvarSemMaterial(true);
            } else {
                formMaterial.classList.remove('hidden');
                salvarSemMaterial(false);
            }
        }
    }

    // Salvar no servidor a opção "sem material"
    function salvarSemMaterial(semMaterial) {
        fetch('{{ route("campo.ordens.sem-material", $ordem->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ sem_material: semMaterial })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Atualizado silenciosamente
                console.log('Preferência de material atualizada');
            }
        })
        .catch(error => {
            console.error('Erro ao salvar preferência:', error);
        });
    }

    function removerFoto(path, tipo) {
        if (!confirm('Deseja remover esta foto?')) return;

        fetch('{{ route("campo.ordens.fotos.remover", $ordem->id) }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ path, tipo })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao remover foto.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao remover foto.');
        });
    }

    // Adicionar material à lista dinamicamente
    function adicionarMaterialNaLista(materialData) {
        const container = document.getElementById('materiais-container');

        // Se não existir, criar o container
        if (!container) {
            const materiaisSection = document.querySelector('.bg-white.dark\\:bg-gray-800.rounded-xl');
            if (materiaisSection) {
                const newContainer = document.createElement('div');
                newContainer.id = 'materiais-container';
                newContainer.className = 'space-y-3 mb-4';
                materiaisSection.appendChild(newContainer);
            }
            return;
        }

        // Remover mensagem "Nenhum material registrado" se existir
        const emptyMessage = container.querySelector('p.text-gray-500');
        if (emptyMessage) {
            emptyMessage.remove();
        }

        // Criar elemento do material
        const materialDiv = document.createElement('div');
        materialDiv.className = 'flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white dark:from-gray-700/50 dark:to-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg hover:shadow-md transition-all duration-200';
        materialDiv.setAttribute('data-material-id', materialData.id);

        const quantidadeFormatada = parseFloat(materialData.quantidade).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const valorTotalFormatado = materialData.valor_total ? parseFloat(materialData.valor_total).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0,00';

        materialDiv.innerHTML = `
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1 flex-wrap">
                    <p class="font-semibold text-gray-900 dark:text-white">${materialData.nome || 'N/A'}</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800 shadow-sm">
                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Reservado
                    </span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-medium">Quantidade:</span> ${quantidadeFormatada} ${materialData.unidade_medida || ''}
                    ${materialData.valor_unitario ? `<span class="mx-2">•</span><span class="font-medium">Valor:</span> R$ ${valorTotalFormatado}` : ''}
                </p>
                <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    Será confirmado ao concluir a OS
                </p>
            </div>
            <button
                onclick="removerMaterial(${materialData.id})"
                class="ml-3 p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200 hover:scale-110 active:scale-95"
                title="Remover material (a reserva será cancelada e o estoque restaurado)"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m-4.788-5l.324-1.41A2 2 0 0111.982 3h2.036a2 2 0 011.732 1.59L15.74 5l1.259 4m-4.788 0L9.26 9m-4.788-5l.324-1.41A2 2 0 015.982 3h2.036a2 2 0 011.732 1.59L9.74 5l1.259 4M9.26 9l.346 9m4.788 0l.346-9M9.26 9h5.48" />
                </svg>
            </button>
        `;

        // Adicionar ao container
        container.appendChild(materialDiv);

        // Mostrar contador se estiver oculto
        const contadorDiv = document.querySelector('#materiais-reservados-count')?.closest('.inline-flex');
        if (contadorDiv) {
            contadorDiv.classList.remove('hidden');
        }
    }

    // Atualizar contador de materiais
    function atualizarContadorMateriais() {
        const container = document.getElementById('materiais-container');
        if (!container) return;

        const materiais = container.querySelectorAll('[data-material-id]');
        const count = materiais.length;
        const countElement = document.getElementById('materiais-reservados-count');
        const textElement = document.getElementById('materiais-reservados-text');
        const contadorDiv = document.getElementById('contador-materiais');

        if (countElement) {
            countElement.textContent = count;
        }

        if (textElement) {
            textElement.textContent = count === 1 ? 'material reservado' : 'materiais reservados';
        }

        // Mostrar ou ocultar contador
        if (contadorDiv) {
            if (count === 0) {
                contadorDiv.classList.add('hidden');
            } else {
                contadorDiv.classList.remove('hidden');
            }
        }
    }

    // Mostrar mensagem de sucesso
    function mostrarMensagemSucesso(message) {
        // Criar ou atualizar mensagem de sucesso
        let alertDiv = document.getElementById('material-success-alert');

        if (!alertDiv) {
            alertDiv = document.createElement('div');
            alertDiv.id = 'material-success-alert';
            alertDiv.className = 'mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg';

            const formMaterial = document.getElementById('formAdicionarMaterial');
            if (formMaterial) {
                formMaterial.parentElement.insertBefore(alertDiv, formMaterial);
            }
        }

        alertDiv.innerHTML = `
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">${message}</p>
            </div>
        `;

        // Remover após 5 segundos
        setTimeout(() => {
            if (alertDiv) {
                alertDiv.remove();
            }
        }, 5000);
    }

    function adicionarMaterial() {
        const materialId = document.getElementById('material_id').value;
        const quantidade = document.getElementById('quantidade_material').value;
        const posteCodigo = document.getElementById('poste_codigo')?.value;

        if (!materialId || !quantidade || parseFloat(quantidade) <= 0) {
            alert('Selecione um material e informe a quantidade.');
            return;
        }

        const materialSelect = document.getElementById('material_id');
        const materialOption = materialSelect.options[materialSelect.selectedIndex];
        const estoque = parseFloat(materialOption.getAttribute('data-estoque'));

        if (parseFloat(quantidade) > estoque) {
            alert(`Quantidade excede o estoque disponível (${estoque}).`);
            return;
        }

        fetch('{{ route("campo.ordens.materiais", $ordem->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                material_id: materialId,
                quantidade: quantidade,
                poste_codigo: posteCodigo
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Adicionar material à lista dinamicamente
                adicionarMaterialNaLista(data.material);

                // Limpar formulário
                document.getElementById('material_id').value = '';
                document.getElementById('quantidade_material').value = '';
                if(document.getElementById('poste_codigo')) document.getElementById('poste_codigo').value = '';
                document.getElementById('material-sem-estoque-alerta').classList.add('hidden');

                // Atualizar contador
                atualizarContadorMateriais();

                // Mostrar mensagem de sucesso
                mostrarMensagemSucesso(data.message || 'Material adicionado com sucesso!');
            } else {
                alert('Erro ao adicionar material: ' + (data.error || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao adicionar material.');
        });
    }

    function removerMaterial(materialId) {
        if (!confirm('Deseja remover este material? A reserva será cancelada e o estoque será restaurado.')) return;

        fetch('{{ route("campo.ordens.materiais.remover", [$ordem->id, ":materialId"]) }}'.replace(':materialId', materialId), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            // Verificar se a resposta é JSON antes de fazer parse
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                // Se não for JSON, provavelmente é uma página de erro HTML
                return response.text().then(text => {
                    console.error('Resposta não é JSON:', text.substring(0, 200));
                    throw new Error('Resposta do servidor não é JSON. Verifique se a rota está correta.');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Remover elemento do DOM - usar seletor mais específico
                const container = document.getElementById('materiais-container');
                if (container) {
                    const materialElement = container.querySelector(`[data-material-id="${materialId}"]`);
                    if (materialElement) {
                        materialElement.remove();
                    }
                }

                // Atualizar contador
                atualizarContadorMateriais();

                // Se não houver mais materiais, mostrar mensagem
                if (container && container.querySelectorAll('[data-material-id]').length === 0) {
                    container.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Nenhum material registrado.</p>';
                }

                mostrarMensagemSucesso(data.message || 'Material removido com sucesso!');
            } else {
                alert('Erro ao remover material: ' + (data.error || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            console.error('Erro ao remover material:', error);
            alert('Erro ao remover material. ' + (error.message || 'Tente recarregar a página.'));
        });
    }

    // Verificar estoque do material selecionado
    function verificarEstoqueMaterial(select) {
        const alerta = document.getElementById('material-sem-estoque-alerta');
        const option = select.options[select.selectedIndex];
        const temEstoque = option.getAttribute('data-tem-estoque') === '1';

        if (!temEstoque && option.value) {
            alerta.classList.remove('hidden');
            // Armazenar dados do material para o modal
            window.materialSelecionado = {
                id: option.value,
                nome: option.getAttribute('data-material-nome'),
                codigo: option.getAttribute('data-material-codigo'),
                unidade: option.getAttribute('data-unidade')
            };
        } else {
            alerta.classList.add('hidden');
            window.materialSelecionado = null;
        }
    }

    // Abrir modal de solicitação de material
    function abrirModalSolicitarMaterial() {
        const material = window.materialSelecionado || {
            id: null,
            nome: document.getElementById('material_id').options[document.getElementById('material_id').selectedIndex]?.getAttribute('data-material-nome') || '',
            codigo: document.getElementById('material_id').options[document.getElementById('material_id').selectedIndex]?.getAttribute('data-material-codigo') || '',
            unidade: document.getElementById('material_id').options[document.getElementById('material_id').selectedIndex]?.getAttribute('data-unidade') || 'unidade'
        };

        // Preencher formulário do modal
        document.getElementById('solicitar_material_nome').value = material.nome;
        document.getElementById('solicitar_material_codigo').value = material.codigo || '';
        document.getElementById('solicitar_material_id').value = material.id || '';
        document.getElementById('solicitar_unidade_medida').value = material.unidade;
        document.getElementById('solicitar_ordem_servico_id').value = {{ $ordem->id }};

        // Mostrar modal
        document.getElementById('modalSolicitarMaterial').classList.remove('hidden');
    }

    // Fechar modal de solicitação
    function fecharModalSolicitarMaterial() {
        document.getElementById('modalSolicitarMaterial').classList.add('hidden');
        document.getElementById('formSolicitarMaterial').reset();
    }

    // Enviar solicitação de material
    function enviarSolicitacaoMaterial() {
        const form = document.getElementById('formSolicitarMaterial');
        const formData = new FormData(form);

        fetch('{{ route("campo.materiais.solicitar.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Solicitação enviada com sucesso! O administrador será notificado.');
                fecharModalSolicitarMaterial();
                // Limpar seleção de material
                document.getElementById('material_id').value = '';
                document.getElementById('material-sem-estoque-alerta').classList.add('hidden');
            } else {
                alert('Erro ao enviar solicitação: ' + (data.message || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao enviar solicitação.');
        });
    }

    function concluirOrdem() {
        document.getElementById('modalConcluir').classList.remove('hidden');
    }

    function fecharModalConcluir() {
        document.getElementById('modalConcluir').classList.add('hidden');
    }

    // Preview das fotos selecionadas no modal de conclusão
    function previewFotosModal(input) {
        const previewContainer = document.getElementById('preview-fotos-modal');
        const files = Array.from(input.files);

        if (files.length === 0) {
            previewContainer.classList.add('hidden');
            previewContainer.innerHTML = '';
            return;
        }

        previewContainer.classList.remove('hidden');
        previewContainer.innerHTML = '';

        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-20 object-cover rounded-lg border border-emerald-300 dark:border-emerald-600">
                    <div class="absolute bottom-1 left-1 px-1.5 py-0.5 bg-emerald-500 text-white text-xs font-medium rounded">
                        Nova
                    </div>
                `;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });

        // Atualizar contador no resumo
        const resumoFotosDepois = document.getElementById('resumo-fotos-depois');
        if (resumoFotosDepois) {
            const existentes = {{ is_array($ordem->fotos_depois) ? count($ordem->fotos_depois) : 0 }};
            resumoFotosDepois.textContent = (existentes + files.length) + ' (+ ' + files.length + ' nova(s))';
        }
    }
</script>
@endpush
@endsection


