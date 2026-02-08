@extends('campo.layouts.app')

@section('title', 'Minhas Ordens')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header - HyperUI Style -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <span>Minhas Ordens de Serviço</span>
            </h1>
            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">
                Visualize e gerencie suas ordens de serviço
            </p>
        </div>
    </div>

    <!-- Guia Rápido de Uso - HyperUI Card Style -->
    <div id="guia-rapido-container" class="relative">
        <div id="guia-rapido-content" class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-xl p-[1px] transition-all duration-300 shadow-lg">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 md:p-6">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3 flex-1">
                        <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm md:text-base font-bold text-gray-900 dark:text-white mb-3">Guia Rápido - Como Usar o Painel Campo</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 text-xs md:text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-start gap-2 p-2 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800">
                                    <span class="w-6 h-6 bg-amber-500 dark:bg-amber-600 text-white rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">1</span>
                                    <div>
                                        <strong class="text-gray-900 dark:text-white block mb-1">Selecione a OS</strong>
                                        <p class="text-xs leading-relaxed">Clique em uma ordem pendente para ver os detalhes e iniciar o atendimento.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2 p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                                    <span class="w-6 h-6 bg-emerald-500 dark:bg-emerald-600 text-white rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">2</span>
                                    <div>
                                        <strong class="text-gray-900 dark:text-white block mb-1">Inicie o Atendimento</strong>
                                        <p class="text-xs leading-relaxed">Clique em "Iniciar" para liberar a adição de fotos e materiais utilizados.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <span class="w-6 h-6 bg-blue-500 dark:bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">3</span>
                                    <div>
                                        <strong class="text-gray-900 dark:text-white block mb-1">Registre o Serviço</strong>
                                        <p class="text-xs leading-relaxed">Adicione fotos ANTES, selecione materiais (serão <strong>reservados</strong>) e tire foto DEPOIS.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2 p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-800">
                                    <span class="w-6 h-6 bg-purple-500 dark:bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">4</span>
                                    <div>
                                        <strong class="text-gray-900 dark:text-white block mb-1">Conclua a OS</strong>
                                        <p class="text-xs leading-relaxed">Finalize com relatório e foto DEPOIS. Os materiais serão <strong>confirmados</strong> no estoque.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 space-y-2">
                                <div class="flex flex-wrap items-center gap-3 text-xs md:text-sm">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-full font-medium">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z" />
                                    </svg>
                                    Funciona offline! Sincroniza quando houver internet.
                                </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-full font-medium">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5l3-3m0 0l3 3m-3-3v12m0 0h-3m3 0h3" />
                                        </svg>
                                        Materiais são <strong>reservados</strong> ao adicionar, <strong>confirmados</strong> ao concluir
                                    </span>
                                </div>
                                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg">
                                    <p class="text-xs text-indigo-800 dark:text-indigo-300 leading-relaxed">
                                        <strong>Dica sobre Materiais:</strong> Ao selecionar um material, ele é <strong>reservado</strong> no estoque (fica indisponível para outros).
                                        Se remover antes de concluir, a reserva é cancelada. Ao <strong>concluir a OS</strong>, a reserva é confirmada e o material é baixado definitivamente do estoque.
                                        Se um material não estiver disponível, você pode <strong>solicitá-lo</strong> através do botão "Solicitar Material".
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button
                        id="btn-fechar-guia"
                        onclick="fecharGuiaRapido()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors flex-shrink-0"
                        title="Fechar dicas"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <button
            id="btn-mostrar-guia"
            onclick="mostrarGuiaRapido()"
            class="text-xs md:text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 hover:underline flex items-center gap-1.5 cursor-pointer hidden mt-2"
        >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
            </svg>
            Mostrar dicas de uso
        </button>
    </div>

    <script>
        function fecharGuiaRapido() {
            const content = document.getElementById('guia-rapido-content');
            const btnMostrar = document.getElementById('btn-mostrar-guia');
            if (content && btnMostrar) {
                content.classList.add('hidden');
                btnMostrar.classList.remove('hidden');
                localStorage.setItem('campo_tips_closed', 'true');
            }
        }

        function mostrarGuiaRapido() {
            const content = document.getElementById('guia-rapido-content');
            const btnMostrar = document.getElementById('btn-mostrar-guia');
            if (content && btnMostrar) {
                content.classList.remove('hidden');
                btnMostrar.classList.add('hidden');
                localStorage.removeItem('campo_tips_closed');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const isClosed = localStorage.getItem('campo_tips_closed') === 'true';
            const content = document.getElementById('guia-rapido-content');
            const btnMostrar = document.getElementById('btn-mostrar-guia');
            if (isClosed && content && btnMostrar) {
                content.classList.add('hidden');
                btnMostrar.classList.remove('hidden');
            }
        });
    </script>

    <!-- Filtros - HyperUI Filter Style -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 md:p-6">
        <form method="GET" action="{{ route('campo.ordens.index') }}" class="flex flex-col lg:flex-row gap-4">
            <!-- Busca -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Número, descrição ou solicitante..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                    >
                </div>
            </div>

            <!-- Status -->
            <div class="lg:w-48">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select
                    name="status"
                    id="status"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                >
                    <option value="">Todos</option>
                    <option value="pendente" {{ request('status') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="em_execucao" {{ request('status') === 'em_execucao' ? 'selected' : '' }}>Em Execução</option>
                    <option value="concluida" {{ request('status') === 'concluida' ? 'selected' : '' }}>Concluída</option>
                </select>
            </div>

            <!-- Prioridade -->
            <div class="lg:w-48">
                <label for="prioridade" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Prioridade</label>
                <select
                    name="prioridade"
                    id="prioridade"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                >
                    <option value="">Todas</option>
                    <option value="urgente" {{ request('prioridade') === 'urgente' ? 'selected' : '' }}>Urgente</option>
                    <option value="alta" {{ request('prioridade') === 'alta' ? 'selected' : '' }}>Alta</option>
                    <option value="media" {{ request('prioridade') === 'media' ? 'selected' : '' }}>Média</option>
                    <option value="baixa" {{ request('prioridade') === 'baixa' ? 'selected' : '' }}>Baixa</option>
                </select>
            </div>

            <!-- Botões -->
            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="px-4 md:px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium shadow-sm hover:shadow-md active:scale-95"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span class="hidden sm:inline">Filtrar</span>
                    <span class="sm:hidden">Buscar</span>
                </button>
                @if(request()->anyFilled(['search', 'status', 'prioridade']))
                    <a
                        href="{{ route('campo.ordens.index') }}"
                        class="px-4 md:px-6 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-all duration-200 font-medium shadow-sm hover:shadow-md active:scale-95"
                    >
                        Limpar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Lista de Ordens - HyperUI Card Grid -->
    @if($ordens->count() > 0)
        <div class="grid grid-cols-1 gap-4 md:gap-6">
            @foreach($ordens as $ordem)
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6 hover:shadow-lg hover:border-indigo-300 dark:hover:border-indigo-600 transition-all duration-300">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <!-- Informações Principais -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start gap-3 mb-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 md:gap-3 mb-2">
                                        <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">{{ $ordem->numero }}</h3>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border bg-{{ $ordem->status_cor }}-100 text-{{ $ordem->status_cor }}-800 dark:bg-{{ $ordem->status_cor }}-900/20 dark:text-{{ $ordem->status_cor }}-400 border-{{ $ordem->status_cor }}-200 dark:border-{{ $ordem->status_cor }}-800">
                                            {{ $ordem->status_texto }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border bg-{{ $ordem->prioridade_cor }}-100 text-{{ $ordem->prioridade_cor }}-800 dark:bg-{{ $ordem->prioridade_cor }}-900/20 dark:text-{{ $ordem->prioridade_cor }}-400 border-{{ $ordem->prioridade_cor }}-200 dark:border-{{ $ordem->prioridade_cor }}-800">
                                            {{ ucfirst($ordem->prioridade) }}
                                        </span>
                                    </div>
                                    <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">{{ $ordem->descricao }}</p>

                                    <div class="flex flex-wrap items-center gap-3 md:gap-4 text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                        @if($ordem->demanda && $ordem->demanda->localidade)
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                                </svg>
                                                <span class="truncate">{{ $ordem->demanda->localidade->nome }}</span>
                                            </span>
                                        @endif
                                        @if($ordem->demanda && $ordem->demanda->solicitante_nome)
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                </svg>
                                                <span class="truncate">{{ $ordem->demanda->solicitante_nome }}</span>
                                            </span>
                                        @endif
                                        @if($ordem->equipe)
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.645-5.888-1.76a3 3 0 00-4.682 2.72 9.097 9.097 0 003.741.488m6.194-8.24a9.099 9.099 0 011.65-.175 9.094 9.094 0 015.721 2.526 9.098 9.098 0 011.65-.175 3 3 0 013.682 2.72m-9.364 5.658a9.098 9.098 0 00-1.65-.175 9.094 9.094 0 00-5.721 2.526 9.098 9.098 0 00-1.65-.175m4.909 1.664a9.099 9.099 0 011.65-.175 9.094 9.094 0 015.721 2.526 9.099 9.099 0 011.65-.175" />
                                                </svg>
                                                <span class="truncate">{{ $ordem->equipe->nome }}</span>
                                            </span>
                                        @endif
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                            {{ $ordem->data_abertura->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ações - HyperUI Button Group -->
                        <div class="flex flex-col sm:flex-row gap-2 lg:flex-col lg:min-w-[200px]">
                            <a
                                href="{{ route('campo.ordens.show', $ordem->id) }}"
                                class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all duration-200 text-center flex items-center justify-center gap-2 font-medium shadow-sm hover:shadow-md active:scale-95"
                            >
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Ver Detalhes
                            </a>

                            @if($ordem->status === 'pendente')
                                <form
                                    method="POST"
                                    action="{{ route('campo.ordens.iniciar', $ordem->id) }}"
                                    class="flex-1"
                                    onsubmit="return confirm('Deseja iniciar o atendimento desta ordem?');"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium shadow-sm hover:shadow-md active:scale-95"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                        </svg>
                                        Iniciar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginação - HyperUI Pagination -->
        <div class="mt-6 md:mt-8">
            {{ $ordens->links() }}
        </div>
    @else
        <!-- Empty State - HyperUI Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 md:p-16 text-center">
            <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>
            </div>
            <h3 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-2">Nenhuma ordem encontrada</h3>
            <p class="text-sm md:text-base text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
                @if(request()->anyFilled(['search', 'status', 'prioridade']))
                    Tente ajustar os filtros para encontrar ordens.
                @else
                    Você não possui ordens atribuídas no momento.
                @endif
            </p>
            @if(request()->anyFilled(['search', 'status', 'prioridade']))
                <a
                    href="{{ route('campo.ordens.index') }}"
                    class="inline-flex items-center px-4 md:px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all duration-200 font-medium shadow-sm hover:shadow-md active:scale-95"
                >
                    Limpar Filtros
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
