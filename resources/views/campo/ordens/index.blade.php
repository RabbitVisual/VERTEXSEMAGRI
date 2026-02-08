@extends('campo.layouts.app')

@section('title', 'Minhas Ordens')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header - HyperUI Style -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
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
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
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
                                                <x-icon name="eye" class="w-5 h-5" />
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
