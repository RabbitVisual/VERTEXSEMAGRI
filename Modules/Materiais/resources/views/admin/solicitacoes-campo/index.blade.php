@extends('admin.layouts.admin')

@section('title', 'Solicitações do Campo - Materiais')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in font-poppins pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="helmet-safety" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        Demandas de Campo
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <span class="text-gray-900 dark:text-white font-bold">Solicitações de Servidores</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.materiais.index') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-all duration-300 shadow-sm active:scale-95">
                    <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                    Gerenciamento
                </a>
            </div>
        </div>
    </div>

    <!-- Filtros - Advanced Panel -->
    <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:shadow-md">
        <form method="GET" action="{{ route('admin.materiais.solicitacoes-campo.index') }}" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <div class="md:col-span-6">
                    <label for="search" class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest pl-1 mb-2 block">Filtrar por Agente ou Recurso</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <x-icon name="magnifying-glass" style="duotone" class="w-5 h-5" />
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold pl-12 p-4 transition-all shadow-inner"
                            placeholder="Pesquisar solicitante ou nome do material...">
                    </div>
                </div>
                <div class="md:col-span-3">
                    <label for="status" class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest pl-1 mb-2 block">Estado da Demanda</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors z-10">
                            <x-icon name="circle-dot" style="duotone" class="w-4 h-4" />
                        </div>
                        <select name="status" id="status"
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold pl-12 p-4 transition-all shadow-inner appearance-none relative">
                            <option value="">Todos os Status</option>
                            <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Aguardando Triagem</option>
                            <option value="processada" {{ request('status') == 'processada' ? 'selected' : '' }}>Convertidas em Ofício</option>
                            <option value="cancelada" {{ request('status') == 'cancelada' ? 'selected' : '' }}>Recusadas/Arquivadas</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                             <x-icon name="chevron-down" class="w-3 h-3" />
                        </div>
                    </div>
                </div>
                <div class="md:col-span-3 flex items-end gap-3">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 text-sm font-black text-white bg-slate-900 dark:bg-emerald-600 rounded-2xl hover:bg-black dark:hover:bg-emerald-700 transition-all shadow-lg active:scale-95">
                        <x-icon name="filter" style="duotone" class="w-4 h-4" />
                        Refinar
                    </button>
                    <a href="{{ route('admin.materiais.solicitacoes-campo.index') }}" class="p-4 text-slate-400 hover:text-emerald-600 bg-slate-50 dark:bg-slate-900 rounded-2xl transition-all shadow-inner border border-transparent hover:border-emerald-200">
                        <x-icon name="rotate-right" class="w-5 h-5" />
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela de Solicitações - Glass Design -->
    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        @if($solicitacoes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Agente Solicitante</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Recurso / Qtd</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Vínculo Operacional</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Triagem</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-slate-700">
                        @foreach($solicitacoes as $solicitacao)
                            <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-900/10 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-emerald-200 dark:shadow-none transition-transform group-hover:rotate-6">
                                                {{ strtoupper(substr($solicitacao->user->name, 0, 1)) }}
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-white dark:bg-slate-800 rounded-full flex items-center justify-center border-2 border-emerald-50 dark:border-emerald-900">
                                                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-black text-gray-900 dark:text-white group-hover:text-emerald-600 transition-colors text-base">{{ $solicitacao->user->name }}</div>
                                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $solicitacao->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-black text-gray-900 dark:text-white text-base">
                                        {{ $solicitacao->material_nome }}
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <x-icon name="arrows-left-right" class="w-3 h-3 text-slate-300" />
                                        <span class="text-xs font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-tighter">
                                            Carga: {{ formatar_quantidade($solicitacao->quantidade, $solicitacao->unidade_medida) }} {{ $solicitacao->unidade_medida }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($solicitacao->ordemServico)
                                        <a href="{{ route('admin.ordens.show', $solicitacao->ordem_servico_id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 text-[10px] font-black uppercase tracking-widest border border-blue-100 dark:border-blue-800/30 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                            <x-icon name="clipboard-check" style="duotone" class="w-4 h-4" />
                                            OS #{{ $solicitacao->ordemServico->numero }}
                                        </a>
                                    @else
                                        <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest border-b border-dashed border-slate-200">Demanda Direta</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $statusConfig = [
                                            'pendente' => ['bg' => 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/30', 'label' => 'Aguardando', 'icon' => 'clock'],
                                            'processada' => ['bg' => 'bg-emerald-50 text-emerald-600 border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/30', 'label' => 'Convertida', 'icon' => 'check-double'],
                                            'cancelada' => ['bg' => 'bg-red-50 text-red-600 border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/30', 'label' => 'Arquivada', 'icon' => 'xmark'],
                                        ];
                                        $s = $statusConfig[$solicitacao->status] ?? ['bg' => 'bg-slate-50', 'label' => $solicitacao->status, 'icon' => 'circle-question'];
                                    @endphp
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full {{ $s['bg'] }} text-[10px] font-black uppercase tracking-widest border shadow-sm">
                                        <x-icon name="{{ $s['icon'] }}" style="duotone" class="w-3 h-3" />
                                        {{ $s['label'] }}
                                    </div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase mt-2 pl-1">
                                        {{ $solicitacao->created_at->format('d/m/Y - H:i') }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        @if($solicitacao->status === 'pendente')
                                            <a href="{{ route('admin.materiais.solicitacoes-campo.processar', $solicitacao->id) }}"
                                               class="inline-flex items-center gap-2 px-6 py-3 text-xs font-black text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/20 transition-all active:scale-95 border-b-4 border-emerald-800">
                                                <x-icon name="arrow-right-to-bracket" style="duotone" class="w-4 h-4" />
                                                Gerar Ofício
                                            </a>
                                            <button type="button" onclick="confirmarCancelamento({{ $solicitacao->id }})"
                                                    class="w-12 h-12 flex items-center justify-center text-red-500 bg-red-50 dark:bg-red-900/20 rounded-2xl border border-red-100/50 dark:border-red-800/20 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                                <x-icon name="trash-can" style="duotone" class="w-5 h-5" />
                                            </button>
                                        @else
                                            <div class="w-10 h-10 flex items-center justify-center text-slate-200 bg-slate-50 dark:bg-slate-900/20 rounded-xl">
                                                <x-icon name="lock" style="duotone" class="w-5 h-5" />
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($solicitacoes->hasPages())
            <div class="px-8 py-6 bg-slate-50/30 dark:bg-slate-900/30 border-t border-gray-100 dark:border-slate-700">
                {{ $solicitacoes->links() }}
            </div>
            @endif
        @else
            <div class="p-20 text-center">
                <div class="w-24 h-24 bg-slate-50 dark:bg-slate-900/50 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-inner border-2 border-dashed border-slate-200 dark:border-slate-700 transition-transform hover:rotate-12">
                    <x-icon name="helmet-safety" style="duotone" class="w-12 h-12 text-slate-300" />
                </div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Triagem Concluída</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-10 max-w-sm mx-auto font-medium leading-relaxed">Não há novas solicitações provenientes das frentes de campo aguardando processamento técnico ou administrativo.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal de Cancelamento - Premium Design -->
<div id="modalCancelar" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/90 backdrop-blur-md animate-fade-in">
    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform scale-100 transition-all border border-slate-700/10">
        <div class="p-10 text-center">
            <div class="w-24 h-24 bg-red-50 dark:bg-red-900/30 text-red-600 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-inner">
                <x-icon name="triangle-exclamation" style="duotone" class="w-12 h-12" />
            </div>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3 tracking-tight">Arquivar Demanda?</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-10 text-sm leading-relaxed font-medium">Esta solicitação será marcada como 'Recusada' e ficará inativa. O agente solicitante não poderá reabri-la.</p>

            <form id="formCancelar" method="POST" class="space-y-6 text-left">
                @csrf
                <div>
                    <label for="motivo" class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest pl-1 mb-2 block">Justificativa da Recusa</label>
                    <textarea id="motivo" name="motivo" rows="3" placeholder="Por que esta solicitação não pode ser atendida no momento?"
                        class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-red-500/20 text-gray-900 dark:text-white text-sm font-bold p-4 transition-all shadow-inner resize-none"></textarea>
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="fecharModal()" class="flex-1 px-8 py-4 text-sm font-black text-gray-500 bg-white border-2 border-slate-100 rounded-2xl hover:bg-slate-50 transition-all active:scale-95 shadow-sm uppercase tracking-widest">Manter</button>
                    <button type="submit" class="flex-1 px-8 py-4 text-sm font-black text-white bg-red-600 rounded-2xl hover:bg-red-700 shadow-xl shadow-red-500/30 transition-all active:scale-95 border-b-4 border-red-800 uppercase tracking-widest">Confirmar</button>
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
@endpush
@endsection
