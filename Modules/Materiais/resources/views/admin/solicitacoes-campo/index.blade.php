@extends('admin.layouts.admin')

@section('title', 'Solicitações do Campo - Materiais')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="helmet-safety" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Solicitações do Campo</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Solicitações do Campo</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.materiais.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
        </div>
    </div>

    <!-- Filtros - Modern Panel -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        <form method="GET" action="{{ route('admin.materiais.solicitacoes-campo.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="block mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest pl-1">Buscar por Funcionário ou Material</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <x-icon name="magnifying-glass" class="w-4 h-4" />
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-10 p-3 dark:bg-slate-900 dark:border-slate-700 dark:placeholder-gray-500 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-all font-medium"
                            placeholder="Nome do solicitante, e-mail ou nome do material...">
                    </div>
                </div>
                <div>
                    <label for="status" class="block mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest pl-1">Status</label>
                    <select name="status" id="status"
                        class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-all font-medium">
                        <option value="">Todos os status</option>
                        <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendentes</option>
                        <option value="processada" {{ request('status') == 'processada' ? 'selected' : '' }}>Processadas</option>
                        <option value="cancelada" {{ request('status') == 'cancelada' ? 'selected' : '' }}>Canceladas</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-md shadow-emerald-500/20 transition-all">
                        Filtrar
                    </button>
                    <a href="{{ route('admin.materiais.solicitacoes-campo.index') }}" class="p-3 text-gray-500 hover:text-emerald-600 dark:hover:text-emerald-400 bg-gray-50 dark:bg-slate-900/50 rounded-xl transition-colors border border-transparent hover:border-emerald-200">
                        <x-icon name="rotate-right" class="w-5 h-5" />
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela de Solicitações do Campo -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        @if($solicitacoes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/50 dark:bg-slate-900/50 text-[10px] uppercase tracking-widest font-bold text-gray-400">
                        <tr>
                            <th class="px-6 py-4">Solicitante</th>
                            <th class="px-6 py-4">Material / Qtd</th>
                            <th class="px-6 py-4">Relacionamento</th>
                            <th class="px-6 py-4">Status / Data</th>
                            <th class="px-6 py-4 text-right pr-10">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @foreach($solicitacoes as $solicitacao)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-900/40 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold text-xs">
                                            {{ strtoupper(substr($solicitacao->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white">{{ $solicitacao->user->name }}</div>
                                            <div class="text-[10px] text-gray-500">{{ $solicitacao->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-emerald-600 dark:text-emerald-400 group-hover:underline">
                                        {{ $solicitacao->material_nome }}
                                    </div>
                                    <div class="text-xs font-medium text-gray-600 dark:text-gray-300">
                                        Qtd: <span class="font-bold">{{ formatar_quantidade($solicitacao->quantidade, $solicitacao->unidade_medida) }} {{ $solicitacao->unidade_medida }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($solicitacao->ordemServico)
                                        <a href="{{ route('admin.ordens.show', $solicitacao->ordem_servico_id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-xs font-bold border border-blue-100 dark:border-blue-800/30 hover:bg-blue-600 hover:text-white transition-all">
                                            <x-icon name="clipboard-list" class="w-3.5 h-3.5" />
                                            OS #{{ $solicitacao->ordemServico->numero }}
                                        </a>
                                    @else
                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Sem OS Vinculada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'pendente' => ['bg' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400', 'label' => 'Pendente'],
                                            'processada' => ['bg' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400', 'label' => 'Processada'],
                                            'cancelada' => ['bg' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400', 'label' => 'Cancelada'],
                                        ];
                                        $s = $statusConfig[$solicitacao->status] ?? ['bg' => 'bg-gray-100', 'label' => $solicitacao->status];
                                    @endphp
                                    <span class="inline-flex px-2 py-0.5 rounded-lg {{ $s['bg'] }} text-[10px] font-bold uppercase tracking-tighter mb-1">
                                        {{ $s['label'] }}
                                    </span>
                                    <div class="text-[10px] text-gray-500 italic">
                                        {{ $solicitacao->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right pr-10">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($solicitacao->status === 'pendente')
                                            <a href="{{ route('admin.materiais.solicitacoes-campo.processar', $solicitacao->id) }}"
                                               class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-md shadow-emerald-500/20 transition-all">
                                                <x-icon name="arrow-right-to-bracket" class="w-4 h-4" />
                                                Processar
                                            </a>
                                            <button type="button" onclick="confirmarCancelamento({{ $solicitacao->id }})"
                                                    class="p-2 text-red-500 hover:text-white bg-red-50 hover:bg-red-500 dark:bg-red-900/20 dark:hover:bg-red-600 rounded-lg transition-all">
                                                <x-icon name="trash-can" class="w-4 h-4" />
                                            </button>
                                        @else
                                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Finalizado</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($solicitacoes->hasPages())
            <div class="px-6 py-4 bg-gray-50/30 dark:bg-slate-900/30 border-t border-gray-100 dark:border-slate-700">
                {{ $solicitacoes->links() }}
            </div>
            @endif
        @else
            <div class="p-16 text-center">
                <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900/50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <x-icon name="helmet-safety" class="w-10 h-10 text-gray-300" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Tudo em dia!</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-sm mx-auto">Não há novas solicitações de materiais vindas do campo para processamento.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal de Cancelamento Simplificado -->
<div id="modalCancelar" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm animate-fadeIn">
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-slideUp">
        <div class="p-8 text-center">
            <div class="w-20 h-20 bg-red-100 dark:bg-red-900/30 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <x-icon name="triangle-exclamation" class="w-10 h-10" />
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Cancelar Solicitação?</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-8">Esta ação não poderá ser desfeita. O colaborador será notificado sobre o cancelamento.</p>

            <form id="formCancelar" method="POST" class="space-y-4 text-left">
                @csrf
                <div>
                    <label for="motivo" class="block mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest pl-1">Motivo (Opcional)</label>
                    <textarea id="motivo" name="motivo" rows="3" placeholder="Informe o motivo para transparência..."
                        class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-2xl focus:ring-red-500 focus:border-red-500 block w-full p-4 dark:bg-slate-900 dark:border-slate-700 dark:text-white transition-all"></textarea>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="fecharModal()" class="flex-1 px-6 py-3 text-sm font-bold text-gray-700 bg-gray-100 rounded-2xl hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:hover:bg-slate-600 transition-all">Manter</button>
                    <button type="submit" class="flex-1 px-6 py-3 text-sm font-bold text-white bg-red-600 rounded-2xl hover:bg-red-700 shadow-lg shadow-red-500/30 transition-all">Cancelar Agora</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmarCancelamento(id) {
        const form = document.getElementById('formCancelar');
        form.action = '{{ route("admin.materiais.solicitacoes-campo.cancelar", ":id") }}'.replace(':id', id);
        document.getElementById('modalCancelar').classList.remove('hidden');
    }

    function fecharModal() {
        document.getElementById('modalCancelar').classList.add('hidden');
    }
</script>

<style>
.animate-fadeIn { animation: fadeIn 0.3s ease-out; }
.animate-slideUp { animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>
@endpush
@endsection
