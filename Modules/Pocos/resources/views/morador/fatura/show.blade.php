@extends('pocos::morador.layouts.app')

@section('title', 'Detalhes da Fatura')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 md:pb-8 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('morador-poco.dashboard') }}" class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Fatura Detalhada</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Referência: <span class="font-black text-blue-600">{{ $boleto->mensalidade->mes_ano }}</span></p>
            </div>
        </div>
    </div>

    <div class="premium-card p-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div>
                <h2 class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-8 border-b border-gray-50 dark:border-slate-800 pb-4">Especificações da Cobrança</h2>
                <dl class="space-y-6">
                    <div class="flex items-center justify-between">
                        <dt class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest">Número do Documento</dt>
                        <dd class="text-sm font-black font-mono text-gray-900 dark:text-white tracking-widest">{{ $boleto->numero_boleto }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest">Data Limite</dt>
                        <dd class="flex flex-col items-end">
                            <span class="text-sm font-black {{ $boleto->esta_vencido ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                                {{ $boleto->data_vencimento->format('d/m/Y') }}
                            </span>
                            @if($boleto->esta_vencido)
                            <span class="text-[10px] font-black text-red-500 uppercase mt-0.5">(Atrasado há {{ $boleto->dias_vencido }} dias)</span>
                            @endif
                        </dd>
                    </div>
                    <div class="mt-8 p-6 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-gray-100 dark:border-slate-800 flex items-center justify-between">
                        <dt class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Total a Pagar</dt>
                        <dd class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">R$ {{ number_format($boleto->valor, 2, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>

            <div>
                <h2 class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-8 border-b border-gray-50 dark:border-slate-800 pb-4">Escala de Situação</h2>
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        @if($boleto->status === 'pago')
                        <span class="px-5 py-2 rounded-full bg-emerald-100/50 dark:bg-emerald-900/20 text-xs font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest border border-emerald-100 dark:border-emerald-800/30">Liquidado</span>
                        @elseif($boleto->status === 'vencido' || $boleto->esta_vencido)
                        <span class="px-5 py-2 rounded-full bg-red-100/50 dark:bg-red-900/20 text-xs font-black text-red-600 dark:text-red-400 uppercase tracking-widest border border-red-100 dark:border-red-800/30">Em Atraso</span>
                        @else
                        <span class="px-5 py-2 rounded-full bg-amber-100/50 dark:bg-amber-900/20 text-xs font-black text-amber-600 dark:text-amber-400 uppercase tracking-widest border border-amber-100 dark:border-amber-800/30">Em Aberto</span>
                        @endif
                    </div>

                    @if($pagamento)
                    <div class="p-5 bg-emerald-50/50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/30 rounded-2xl">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            </div>
                            <p class="text-sm font-black text-emerald-900 dark:text-emerald-300 uppercase tracking-tight">Pagamento Efetivado</p>
                        </div>
                        <p class="text-xs text-emerald-700 dark:text-emerald-400 font-bold uppercase tracking-wide">Data: {{ $pagamento->data_pagamento->format('d/m/Y') }} • Via: {{ $pagamento->forma_pagamento_texto }}</p>
                    </div>
                    @elseif($solicitacaoBaixa)
                    <div class="p-5 {{ $solicitacaoBaixa->status === 'aprovada' ? 'bg-emerald-50/50 border-emerald-100' : ($solicitacaoBaixa->status === 'rejeitada' ? 'bg-red-50/50 border-red-100' : 'bg-blue-50/50 border-blue-100') }} dark:bg-slate-900/50 border rounded-2xl shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5">
                                @if($solicitacaoBaixa->status === 'pendente') <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                @elseif($solicitacaoBaixa->status === 'aprovada') <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                @else <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Status da Solicitação</p>
                                <p class="text-sm font-black {{ $solicitacaoBaixa->status === 'aprovada' ? 'text-emerald-900 dark:text-emerald-300' : ($solicitacaoBaixa->status === 'rejeitada' ? 'text-red-900 dark:text-red-300' : 'text-blue-900 dark:text-blue-300') }} uppercase tracking-tight">
                                    {{ $solicitacaoBaixa->status_texto }}
                                </p>
                                @if($solicitacaoBaixa->status === 'pendente')
                                <p class="text-[10px] text-blue-700/70 dark:text-blue-400/70 font-bold uppercase mt-2 italic">Aguardando análise da liderança.</p>
                                @elseif($solicitacaoBaixa->status === 'rejeitada' && $solicitacaoBaixa->motivo_rejeicao)
                                <p class="text-xs text-red-700 dark:text-red-400 font-bold mt-2 uppercase tracking-wide">Motivo: {{ $solicitacaoBaixa->motivo_rejeicao }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        </div>

        <!-- Canal de Quitação -->
        @if(!$pagamento)
        <div class="mt-10 pt-10 border-t border-gray-100 dark:border-slate-800">
            <h3 class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-6 px-1">Método de Quitação Disponível</h3>

            @if($boleto->mensalidade->forma_recebimento == 'pix' && $boleto->mensalidade->chave_pix)
            <div class="relative group">
                <div class="absolute inset-0 bg-emerald-500 opacity-0 group-hover:opacity-5 blur-2xl transition-opacity duration-500"></div>
                <div class="relative bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-900/10 dark:to-slate-900 border-2 border-emerald-100 dark:border-emerald-800/30 rounded-3xl p-8 transition-all duration-300 group-hover:border-emerald-200 dark:group-hover:border-emerald-700/50">
                    <div class="flex flex-col md:flex-row items-center gap-10">
                        <div class="flex-1 text-center md:text-left">
                            <div class="flex items-center justify-center md:justify-start gap-3 mb-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" /></svg>
                                </div>
                                <h4 class="text-xl font-black text-emerald-900 dark:text-emerald-300 uppercase tracking-tight">Pagamento Instantâneo (PIX)</h4>
                            </div>
                            <p class="text-sm text-emerald-800/60 dark:text-emerald-400/60 font-bold mb-8 uppercase tracking-wide">Utilize o QR Code ou a chave abaixo para pagar agora.</p>

                            <div class="bg-white/80 dark:bg-slate-950/50 backdrop-blur rounded-2xl p-5 border border-emerald-100 dark:border-emerald-800/50 shadow-sm">
                                <p class="text-[10px] font-black text-emerald-600/50 uppercase tracking-widest mb-2 px-1">Chave Pix Registrada</p>
                                <div class="flex items-center gap-3">
                                    <code class="flex-1 text-sm font-mono font-black text-emerald-900 dark:text-emerald-200 break-all leading-relaxed">{{ $boleto->mensalidade->chave_pix }}</code>
                                    <button onclick="copiarChavePix(event)" class="px-6 py-3 text-[10px] font-black text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-all shadow-lg active:scale-95 uppercase tracking-widest">
                                        Copiar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-white dark:bg-slate-950 p-6 rounded-3xl border border-emerald-100 dark:border-emerald-800/50 shadow-2xl relative">
                                <div class="absolute -top-3 -left-3 bg-emerald-500 text-white text-[8px] font-black uppercase px-3 py-1.5 rounded-full shadow-lg">Scan & Pay</div>
                                <div id="qrcode" class="flex justify-center"></div>
                                <p class="text-[8px] font-black text-center text-emerald-400 uppercase mt-4 tracking-widest">Aponte a câmera para pagar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800 rounded-3xl p-8">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 shadow-inner">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Recebimento Presencial</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 font-bold max-w-md mt-1 uppercase tracking-wide">Procure a liderança da comunidade para realizar o acerto em espécie.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Central de Solicitação -->
        @if(!$pagamento && !$solicitacaoBaixa && $boleto->status === 'aberto')
        <div class="mt-10 pt-10 border-t border-gray-100 dark:border-slate-800">
            <div class="bg-blue-50/50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 rounded-3xl p-8 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg class="w-32 h-32 text-blue-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                </div>
                <div class="relative flex flex-col md:flex-row md:items-center gap-8">
                    <div class="flex-1">
                        <h4 class="text-xl font-black text-blue-900 dark:text-blue-300 uppercase tracking-tight mb-2">Pagamento já realizado?</h4>
                        <p class="text-sm text-blue-800/60 dark:text-blue-400/60 font-medium leading-relaxed max-w-xl">Caso tenha pago via transferência ou em mãos e o status ainda não atualizou, você pode anexar seu comprovante aqui para análise.</p>
                    </div>
                    <button onclick="openSolicitarBaixaModal()" class="whitespace-nowrap px-8 py-4 text-xs font-black text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20 active:scale-95 uppercase tracking-widest">
                        Informar Pagamento
                    </button>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-12 pt-8 border-t border-gray-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6">
            <a href="{{ route('morador-poco.dashboard') }}" class="w-full sm:w-auto px-8 py-4 text-xs font-black text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white uppercase tracking-widest transition-all text-center">
                Retornar ao Painel
            </a>

            <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                @if($pagamento)
                <a href="{{ route('morador-poco.fatura.comprovante', $boleto->id) }}" class="w-full sm:w-auto flex items-center justify-center gap-3 px-10 py-4 rounded-2xl bg-emerald-600 text-white text-xs font-black hover:bg-emerald-700 transition-all shadow-2xl active:scale-95 uppercase tracking-widest">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    Baixar Comprovante (PDF)
                </a>
                @elseif($solicitacaoBaixa && $solicitacaoBaixa->status === 'pendente')
                <div class="w-full sm:w-auto flex items-center justify-center gap-2.5 px-6 py-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-800 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <svg class="w-4 h-4 shadow-sm" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    <span>Fatura em Análise • 2ª Via Bloqueada</span>
                </div>
                @else
                <a href="{{ route('morador-poco.fatura.segunda-via', $boleto->id) }}" class="w-full sm:w-auto flex items-center justify-center gap-3 px-10 py-4 rounded-2xl bg-slate-900 dark:bg-blue-600 text-white text-xs font-black hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-2xl active:scale-95 uppercase tracking-widest">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                    Pagar / Obter 2ª Via (PDF)
                </a>
                @endif
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Modal Solicitar Baixa -->
<div id="solicitarBaixaModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black opacity-50" onclick="closeSolicitarBaixaModal()"></div>
        <div class="relative bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl max-w-lg w-full p-10 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>

            <div class="relative">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tighter mb-2">Informar Pagamento</h3>
                <p class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest mb-8 pb-6 border-b border-gray-50 dark:border-slate-800">Anexe as informações do seu comprovante</p>

                <form method="POST" action="{{ route('morador-poco.solicitacoes-baixa.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="boleto_poco_id" value="{{ $boleto->id }}">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Data Realizada *</label>
                            <input type="date" name="data_pagamento" value="{{ date('Y-m-d') }}" required max="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Valor Final *</label>
                            <input type="number" name="valor_pago" value="{{ number_format($boleto->valor, 2, '.', '') }}" step="0.01" min="0.01" required class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Canal de Pagamento *</label>
                        <select name="forma_pagamento" required class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500 transition-all">
                            <option value="dinheiro">Dinheiro (Em Mãos)</option>
                            <option value="pix">PIX / Transferência</option>
                            <option value="outro">Outro (Especifique)</option>
                        </select>
                    </div>

                    <div class="relative group">
                        <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Arquivo do Comprovante (Opcional)</label>
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-100 dark:border-slate-700 rounded-[2rem] bg-gray-50/50 dark:bg-slate-900/50 hover:bg-white dark:hover:bg-slate-800 hover:border-blue-500/30 transition-all cursor-pointer group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" /></svg>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Clique ou arraste o PDF/IMG</p>
                            </div>
                            <input type="file" name="comprovante" accept="image/*,.pdf" class="hidden">
                        </label>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Notas Adicionais</label>
                        <textarea name="observacoes" rows="2" class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500 transition-all" placeholder="Ex: Pago pro líder na rua..."></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6">
                        <button type="button" onclick="closeSolicitarBaixaModal()" class="px-6 py-4 text-[10px] font-black text-slate-400 hover:text-slate-900 uppercase tracking-widest transition-all">
                            Desistir
                        </button>
                        <button type="submit" class="px-10 py-4 text-[10px] font-black text-white bg-slate-900 dark:bg-blue-600 rounded-2xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-xl active:scale-95 uppercase tracking-widest">
                            Enviar Dados
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openSolicitarBaixaModal() {
    document.getElementById('solicitarBaixaModal').classList.remove('hidden');
}

function closeSolicitarBaixaModal() {
    document.getElementById('solicitarBaixaModal').classList.add('hidden');
}
</script>
@endpush
    </div>
</div>

@if($boleto->mensalidade->forma_recebimento == 'pix' && $boleto->mensalidade->chave_pix)
@push('scripts')
@vite(['resources/js/qrcode.js'])
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const chavePix = @json($boleto->mensalidade->chave_pix);
        const qrcodeDiv = document.getElementById('qrcode');

        if (qrcodeDiv && typeof window.generateQRCode !== 'undefined') {
            // Criar canvas para o QR Code
            const canvas = document.createElement('canvas');
            canvas.id = 'qrcode-canvas';
            qrcodeDiv.appendChild(canvas);

            try {
                // Gerar QR Code usando a biblioteca instalada
                await window.generateQRCode(chavePix, 'qrcode-canvas', {
                    width: 200,
                    margin: 2,
                    color: {
                        dark: '#000000',
                        light: '#FFFFFF'
                    }
                });
            } catch (error) {
                console.error('Erro ao gerar QR Code:', error);
                qrcodeDiv.innerHTML = '<p class="text-xs text-red-600">Erro ao gerar QR Code</p>';
            }
        }

        // Função para copiar chave PIX
        window.copiarChavePix = function(event) {
            const chavePix = @json($boleto->mensalidade->chave_pix);
            navigator.clipboard.writeText(chavePix).then(function() {
                // Mostrar feedback visual
                const button = event.target;
                const originalText = button.textContent;
                button.textContent = 'Copiado!';
                button.classList.add('bg-green-700');
                setTimeout(function() {
                    button.textContent = originalText;
                    button.classList.remove('bg-green-700');
                }, 2000);
            }).catch(function(err) {
                console.error('Erro ao copiar:', err);
                // Fallback para navegadores antigos
                const textarea = document.createElement('textarea');
                textarea.value = chavePix;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    const button = event.target;
                    const originalText = button.textContent;
                    button.textContent = 'Copiado!';
                    button.classList.add('bg-green-700');
                    setTimeout(function() {
                        button.textContent = originalText;
                        button.classList.remove('bg-green-700');
                    }, 2000);
                } catch (err) {
                    alert('Erro ao copiar chave PIX. Por favor, copie manualmente.');
                }
                document.body.removeChild(textarea);
            });
        };
    });
</script>
@endpush
@endif
@endsection
