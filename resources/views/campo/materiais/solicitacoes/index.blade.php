@extends('campo.layouts.app')

@section('title', 'Minhas Solicitações de Materiais')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header - HyperUI Style -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <span>Minhas Solicitações de Materiais</span>
            </h1>
            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">
                Acompanhe o status das suas solicitações de materiais enviadas ao administrador
            </p>
        </div>
        <a href="{{ route('campo.dashboard') }}" class="inline-flex items-center px-4 md:px-6 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-all duration-200 font-medium shadow-sm hover:shadow-md active:scale-95">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Voltar
        </a>
    </div>

    <!-- Card Informativo - HyperUI Info Card -->
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-purple-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-5 md:p-6 shadow-sm">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">ℹ️ Como Funciona a Solicitação de Materiais</h3>
                <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                    <p class="flex items-start gap-2">
                        <span class="font-bold text-blue-600 dark:text-blue-400 mt-0.5">1.</span>
                        <span>Quando um material não está disponível no estoque, você pode <strong>solicitar</strong> através do botão "Solicitar Material".</span>
                    </p>
                    <p class="flex items-start gap-2">
                        <span class="font-bold text-emerald-600 dark:text-emerald-400 mt-0.5">2.</span>
                        <span>Sua solicitação é enviada para o <strong>administrador</strong>, que será notificado no painel admin.</span>
                    </p>
                    <p class="flex items-start gap-2">
                        <span class="font-bold text-amber-600 dark:text-amber-400 mt-0.5">3.</span>
                        <span>O administrador <strong>processa</strong> sua solicitação e cria uma solicitação oficial de material.</span>
                    </p>
                    <p class="flex items-start gap-2">
                        <span class="font-bold text-purple-600 dark:text-purple-400 mt-0.5">4.</span>
                        <span>Você pode acompanhar o status aqui: <strong>Pendente</strong> (aguardando), <strong>Processada</strong> (solicitação oficial criada) ou <strong>Cancelada</strong>.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros - HyperUI Filter Style -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 md:p-6">
        <form method="GET" action="{{ route('campo.materiais.solicitacoes.index') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                        </svg>
                        Status
                    </span>
                </label>
                <select
                    id="status"
                    name="status"
                    class="w-full px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                >
                    <option value="">Todos os Status</option>
                    <option value="pendente" {{ request('status') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="processada" {{ request('status') === 'processada' ? 'selected' : '' }}>Processada</option>
                    <option value="cancelada" {{ request('status') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="px-4 md:px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-all duration-200 font-semibold shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                    </svg>
                    <span class="hidden sm:inline">Filtrar</span>
                    <span class="sm:hidden">Buscar</span>
                </button>
                @if(request('status'))
                    <a
                        href="{{ route('campo.materiais.solicitacoes.index') }}"
                        class="px-4 md:px-6 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl transition-all duration-200 font-semibold shadow-sm hover:shadow-md active:scale-95 flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="hidden sm:inline">Limpar</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Lista de Solicitações - HyperUI Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if($solicitacoes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                        <tr>
                            <th scope="col" class="px-4 md:px-6 py-3 md:py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Material</th>
                            <th scope="col" class="px-4 md:px-6 py-3 md:py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Quantidade</th>
                            <th scope="col" class="px-4 md:px-6 py-3 md:py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">OS Relacionada</th>
                            <th scope="col" class="px-4 md:px-6 py-3 md:py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-4 md:px-6 py-3 md:py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Data</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($solicitacoes as $solicitacao)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5l3-3m0 0l3 3m-3-3v12m0 0h-3m3 0h3" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $solicitacao->material_nome }}</p>
                                            @if($solicitacao->material_codigo)
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Cód: {{ $solicitacao->material_codigo }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ number_format($solicitacao->quantidade, 2, ',', '.') }}
                                        <span class="text-gray-500 dark:text-gray-400">{{ $solicitacao->unidade_medida }}</span>
                                    </span>
                                </td>
                                <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                    @if($solicitacao->ordemServico)
                                        <a
                                            href="{{ route('campo.ordens.show', $solicitacao->ordem_servico_id) }}"
                                            class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                            </svg>
                                            OS #{{ $solicitacao->ordemServico->numero }}
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusConfig = [
                                            'pendente' => [
                                                'bg' => 'bg-amber-100 dark:bg-amber-900/30',
                                                'text' => 'text-amber-800 dark:text-amber-300',
                                                'border' => 'border-amber-200 dark:border-amber-800',
                                                'icon' => ''
                                            ],
                                            'processada' => [
                                                'bg' => 'bg-emerald-100 dark:bg-emerald-900/30',
                                                'text' => 'text-emerald-800 dark:text-emerald-300',
                                                'border' => 'border-emerald-200 dark:border-emerald-800',
                                                'icon' => ''
                                            ],
                                            'cancelada' => [
                                                'bg' => 'bg-red-100 dark:bg-red-900/30',
                                                'text' => 'text-red-800 dark:text-red-300',
                                                'border' => 'border-red-200 dark:border-red-800',
                                                'icon' => ''
                                            ],
                                        ];
                                        $status = $statusConfig[$solicitacao->status] ?? $statusConfig['pendente'];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border {{ $status['bg'] }} {{ $status['text'] }} {{ $status['border'] }}">
                                        {{ $solicitacao->status_texto }}
                                    </span>
                                </td>
                                <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        <span>{{ $solicitacao->created_at->format('d/m/Y') }}</span>
                                        <span class="text-gray-400 dark:text-gray-500">•</span>
                                        <span class="text-xs">{{ $solicitacao->created_at->format('H:i') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginação - HyperUI Pagination -->
            <div class="px-4 md:px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                {{ $solicitacoes->links() }}
            </div>
        @else
            <!-- Empty State - HyperUI Empty State -->
            <div class="p-12 md:p-16 text-center">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-2">Nenhuma solicitação encontrada</h3>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    @if(request('status'))
                        Não há solicitações com o status selecionado. Tente ajustar os filtros.
                    @else
                        Você ainda não enviou nenhuma solicitação de material. Quando um material não estiver disponível no estoque, você poderá solicitá-lo através do botão "Solicitar Material".
                    @endif
                </p>
                @if(request('status'))
                    <a
                        href="{{ route('campo.materiais.solicitacoes.index') }}"
                        class="inline-flex items-center px-4 md:px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-all duration-200 font-semibold shadow-sm hover:shadow-md active:scale-95"
                    >
                        Limpar Filtros
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

