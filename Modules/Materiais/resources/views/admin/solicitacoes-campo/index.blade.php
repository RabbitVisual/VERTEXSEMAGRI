@extends('admin.layouts.admin')

@section('title', 'Solicitações de Materiais do Campo')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                        Filtrar
                    </button>
                    <a href="{{ route('admin.materiais.solicitacoes-campo.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                        <x-icon name="rotate-right" class="w-5 h-5" />
                        Limpar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Lista de Solicitações - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Solicitações de Materiais do Campo</h3>
        </div>
        @if($solicitacoes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Funcionário</th>
                            <th scope="col" class="px-6 py-3">Material</th>
                            <th scope="col" class="px-6 py-3">Quantidade</th>
                            <th scope="col" class="px-6 py-3">OS</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Data</th>
                            <th scope="col" class="px-6 py-3 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitacoes as $solicitacao)
                            <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $solicitacao->user->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $solicitacao->user->email }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $solicitacao->material_nome }}</p>
                                        @if($solicitacao->material_codigo)
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Cód: {{ $solicitacao->material_codigo }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900 dark:text-white">
                                        {{ formatar_quantidade($solicitacao->quantidade, $solicitacao->unidade_medida) }} {{ $solicitacao->unidade_medida }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($solicitacao->ordemServico)
                                        <a href="{{ route('admin.ordens.show', $solicitacao->ordem_servico_id) }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300">
                                            OS #{{ $solicitacao->ordemServico->numero }}
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusCores = [
                                            'pendente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'processada' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                            'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusCores[$solicitacao->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $solicitacao->status_texto }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $solicitacao->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($solicitacao->status === 'pendente')
                                            <a
                                                href="{{ route('admin.materiais.solicitacoes-campo.processar', $solicitacao->id) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors"
                                            >
                                                <x-icon name="eye" class="w-5 h-5" />
                                                Ver Solicitação
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            @if($solicitacoes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                {{ $solicitacoes->links() }}
            </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Nenhuma solicitação encontrada</h3>
                <p class="text-gray-600 dark:text-gray-400">Não há solicitações de materiais do campo no momento.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal de Cancelamento - Flowbite Modal -->
<div id="modalCancelar" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-slate-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-slate-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Cancelar Solicitação
                </h3>
                <button type="button" onclick="fecharModalCancelar()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Fechar</span>
                </button>
            </div>
            <!-- Modal body -->
            <form id="formCancelar" method="POST">
                @csrf
                <div class="p-4 md:p-5">
                    <div class="mb-4">
                        <label for="motivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Motivo do Cancelamento (Opcional)
                        </label>
                        <textarea
                            id="motivo"
                            name="motivo"
                            rows="3"
                            placeholder="Informe o motivo do cancelamento..."
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500"
                        ></textarea>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-slate-600">
                    <button
                        type="submit"
                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 transition-colors"
                    >
                        Confirmar Cancelamento
                    </button>
                    <button
                        type="button"
                        onclick="fecharModalCancelar()"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-emerald-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-slate-700 dark:bg-slate-800 dark:text-gray-400 dark:border-slate-600 dark:hover:text-white dark:hover:bg-slate-700 transition-colors"
                    >
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function cancelarSolicitacao(id) {
        document.getElementById('formCancelar').action = '{{ route("admin.materiais.solicitacoes-campo.cancelar", ":id") }}'.replace(':id', id);
        document.getElementById('modalCancelar').classList.remove('hidden');
    }

    function fecharModalCancelar() {
        document.getElementById('modalCancelar').classList.add('hidden');
        document.getElementById('formCancelar').reset();
    }
</script>
@endpush
@endsection

