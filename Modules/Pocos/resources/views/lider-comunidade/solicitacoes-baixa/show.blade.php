@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Detalhes da Solicitação de Baixa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.solicitacoes-baixa.index') }}" class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Análise de Comprovante</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Verifique os dados antes de aprovar a baixa</p>
            </div>
        </div>
    </div>

    <!-- Dossiê da Solicitação -->
    <div class="premium-card p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h3 class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-6 border-b border-gray-50 dark:border-slate-800 pb-3">Doador / Morador</h3>
                <dl class="space-y-6">
                    <div>
                        <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Nome Completo</dt>
                        <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $solicitacao->usuarioPoco->nome }}</dd>
                    </div>
                    <div>
                        <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Documento (CPF)</dt>
                        <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $solicitacao->usuarioPoco->cpf_formatado ?: 'Não informado' }}</dd>
                    </div>
                    <div>
                        <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Endereço Residencial</dt>
                        <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $solicitacao->usuarioPoco->endereco }}{{ $solicitacao->usuarioPoco->numero_casa ? ', ' . $solicitacao->usuarioPoco->numero_casa : '' }}</dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-6 border-b border-gray-50 dark:border-slate-800 pb-3">Dados Financeiros</h3>
                <dl class="space-y-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Mês de Referência</dt>
                            <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $solicitacao->mensalidade->mes_ano }}</dd>
                        </div>
                        <div class="text-right">
                            <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Data do Pagto</dt>
                            <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $solicitacao->data_pagamento->format('d/m/Y') }}</dd>
                        </div>
                    </div>
                    <div>
                        <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Valor Informado</dt>
                        <dd class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">R$ {{ number_format($solicitacao->valor_pago, 2, ',', '.') }}</dd>
                    </div>
                    <div class="flex justify-between items-center bg-gray-50 dark:bg-slate-900/50 p-4 rounded-2xl border border-gray-100 dark:border-slate-800">
                        <div>
                            <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Método</dt>
                            <dd class="text-sm font-bold text-gray-900 dark:text-white uppercase">{{ $solicitacao->forma_pagamento_texto }}</dd>
                        </div>
                        <div class="text-right">
                            <dt class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Status Atual</dt>
                            <dd>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $solicitacao->status === 'aprovada' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400' : ($solicitacao->status === 'rejeitada' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/20 dark:text-amber-400') }}">
                                    {{ $solicitacao->status_texto }}
                                </span>
                            </dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

        @if($solicitacao->observacoes)
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Observações</h3>
            <p class="text-base text-gray-900 dark:text-white">{{ $solicitacao->observacoes }}</p>
        </div>
        @endif

        @if($solicitacao->comprovante)
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Comprovante</h3>
            <a href="{{ asset('storage/' . $solicitacao->comprovante) }}" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                </svg>
                Ver Comprovante
            </a>
        </div>
        @endif

        @if($solicitacao->status === 'rejeitada' && $solicitacao->motivo_rejeicao)
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
            <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <h3 class="text-sm font-medium text-red-900 dark:text-red-200 mb-2">Motivo da Rejeição</h3>
                <p class="text-sm text-red-700 dark:text-red-300">{{ $solicitacao->motivo_rejeicao }}</p>
            </div>
        </div>
        @endif

        @if($solicitacao->status === 'pendente')
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-end gap-4 p-6 bg-blue-50/50 dark:bg-blue-900/20 rounded-2xl border border-blue-100 dark:border-blue-900/30">
            <p class="text-xs font-bold text-blue-800 dark:text-blue-300 mr-auto italic">A aprovação registrará o pagamento no fluxo de caixa automaticamente.</p>
            <div class="flex gap-3 w-full sm:w-auto">
                <button onclick="openRejeitarModal()" class="flex-1 sm:flex-none px-6 py-2.5 text-sm font-bold text-red-600 bg-white dark:bg-slate-900 border border-red-200 dark:border-red-900/50 rounded-xl hover:bg-red-50 transition-all active:scale-95 uppercase tracking-tighter">
                    Rejeitar
                </button>
                <form method="POST" action="{{ route('lider-comunidade.solicitacoes-baixa.aprovar', $solicitacao->id) }}" class="flex-1 sm:flex-none">
                    @csrf
                    <button type="submit" onclick="return confirm('Confirmar aprovação?')" class="w-full px-8 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 active:scale-95 uppercase tracking-tighter text-center">
                        Aprovar Baixa
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Rejeitar -->
@if($solicitacao->status === 'pendente')
<div id="rejeitarModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black opacity-50" onclick="closeRejeitarModal()"></div>
        <div class="relative bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Rejeitar Solicitação</h3>
            <form method="POST" action="{{ route('lider-comunidade.solicitacoes-baixa.rejeitar', $solicitacao->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Motivo da Rejeição *</label>
                    <textarea name="motivo_rejeicao" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-slate-700 dark:border-slate-600 dark:text-white" placeholder="Informe o motivo da rejeição..."></textarea>
                </div>
                <div class="flex items-center justify-end gap-4">
                    <button type="button" onclick="closeRejeitarModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                        Rejeitar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openRejeitarModal() {
    document.getElementById('rejeitarModal').classList.remove('hidden');
}

function closeRejeitarModal() {
    document.getElementById('rejeitarModal').classList.add('hidden');
}
</script>
@endpush
@endif
@endsection
