@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Detalhes da Mensalidade')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.mensalidades.index') }}" class="w-10 h-10 rounded-xl bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Mensalidade {{ $mensalidade->mes_ano }}</h1>
                <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                    <span>Cobranças</span>
                    <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                    <span class="text-blue-600">Arrecadação Ativa</span>
                </nav>
            </div>
        </div>
    </div>

    <!-- Interface de Controle Financeiro -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Resumo Expandido -->
        <div class="lg:col-span-2 space-y-8">
            <div class="premium-card overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <x-icon name="coins" style="duotone" class="w-5 text-blue-500" />
                        Fluxo Financeiro
                    </h2>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Valor Unitário</p>
                            <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">
                                <span class="text-sm font-bold text-slate-400 mr-1">R$</span>{{ number_format($mensalidade->valor_mensalidade, 2, ',', '.') }}
                            </p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tight italic">Referência Mensal</p>
                        </div>
                        <div class="p-5 bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/20 rounded-3xl space-y-1">
                            <p class="text-[10px] font-black text-emerald-600/70 dark:text-emerald-400/50 uppercase tracking-widest">Total Arrecadado</p>
                            <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tighter">
                                <span class="text-sm font-bold text-emerald-500 mr-1">R$</span>{{ number_format($mensalidade->total_arrecadado, 2, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-5 bg-amber-50/50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/20 rounded-3xl space-y-1">
                            <p class="text-[10px] font-black text-amber-600/70 dark:text-amber-400/50 uppercase tracking-widest">Saldo Pendente</p>
                            <p class="text-3xl font-black text-amber-600 dark:text-amber-400 tracking-tighter">
                                <span class="text-sm font-bold text-amber-500 mr-1">R$</span>{{ number_format($mensalidade->total_pendente, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-10 pt-8 border-t border-gray-100 dark:border-slate-800">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Progresso da Arrecadação</h3>
                            <span class="text-xs font-black text-blue-600 dark:text-blue-400">{{ round(($mensalidade->usuarios_pagantes / max(1, $mensalidade->total_usuarios)) * 100) }}%</span>
                        </div>
                        <div class="w-full h-4 bg-gray-100 dark:bg-slate-800 rounded-full overflow-hidden shadow-inner flex">
                            @php
                                $pagos = ($mensalidade->usuarios_pagantes / max(1, $mensalidade->total_usuarios)) * 100;
                            @endphp
                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-1000 shadow-lg" style="width: {{ $pagos }}%"></div>
                        </div>
                        <p class="mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-tight text-center">
                            {{ $mensalidade->usuarios_pagantes }} de {{ $mensalidade->total_usuarios }} moradores realizaram a contribuição
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tabela de Moradores -->
            <div class="premium-card overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-900/50 flex items-center justify-between">
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <x-icon name="users-gear" style="duotone" class="w-5 text-indigo-500" />
                        Lista de Contribuintes
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[9px] text-slate-400 uppercase tracking-[0.2em] bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-800">
                            <tr>
                                <th scope="col" class="px-8 py-4 font-black">Morador</th>
                                <th scope="col" class="px-8 py-4 font-black text-center">Situação</th>
                                <th scope="col" class="px-8 py-4 font-black text-center">Data/Valor</th>
                                <th scope="col" class="px-8 py-4 font-black text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                            @foreach($usuarios as $usuario)
                            <tr class="hover:bg-gray-50/30 dark:hover:bg-slate-800/30 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $usuario->nome }}</div>
                                    <div class="text-[9px] text-slate-400 uppercase font-black tracking-widest italic">Beneficiário Cadastrado</div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($usuario->pagou)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 text-[9px] font-black uppercase tracking-widest">
                                        <x-icon name="circle-check" class="w-3 h-3" />
                                        Pago
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 text-[9px] font-black uppercase tracking-widest animate-pulse">
                                        <x-icon name="circle-exclamation" class="w-3 h-3" />
                                        Pendente
                                    </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($usuario->pagou)
                                    <div class="text-[11px] font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $usuario->pagamento->data_pagamento->format('d/m/Y') }}</div>
                                    <div class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 tracking-tighter">R$ {{ number_format($usuario->pagamento->valor_pago, 2, ',', '.') }}</div>
                                    @else
                                    <span class="text-slate-300 dark:text-slate-700">---</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @if(!$usuario->pagou)
                                    <div class="flex items-center justify-end gap-2">
                                        @if($mensalidade->lider->pix_ativo && $mensalidade->lider->chave_pix)
                                        <button onclick="window.exibirQrCodeModal && window.exibirQrCodeModal({{ $mensalidade->id }}, {{ $usuario->id }})"
                                                class="p-2 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-xl transition-all" title="Gerar QR Code">
                                            <x-icon name="qrcode" style="duotone" class="w-5 h-5" />
                                        </button>
                                        @endif
                                        <button onclick="openPaymentModal({{ $usuario->id }}, '{{ $usuario->nome }}')"
                                            class="inline-flex items-center gap-2 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-xl transition-all dark:bg-blue-900/10 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white shadow-sm border border-blue-100 dark:border-blue-900/30">
                                            Baixar
                                        </button>
                                    </div>
                                    @else
                                    <div class="flex justify-end pr-4">
                                        <x-icon name="check-double" class="w-4 h-4 text-emerald-500" />
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Pagamento Digital -->
            <div class="premium-card p-8 bg-gradient-to-br from-white to-blue-50/30 dark:from-slate-800 dark:to-slate-900/50">
                <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2 mb-6">
                    <x-icon name="gears" style="duotone" class="w-5 text-blue-500" />
                    Configurar Ciclo
                </h2>

                <form method="POST" action="{{ route('lider-comunidade.mensalidades.update-recebimento', $mensalidade->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Método Preferencial</label>
                        <select name="forma_recebimento" id="forma_recebimento" class="w-full px-5 py-3.5 bg-white dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                            <option value="maos" {{ $mensalidade->forma_recebimento == 'maos' ? 'selected' : '' }}>Dinheiro Espécie</option>
                            <option value="pix" {{ $mensalidade->forma_recebimento == 'pix' ? 'selected' : '' }}>Transferência Digital (PIX)</option>
                        </select>
                    </div>

                    <div id="chave_pix_container" style="display: {{ $mensalidade->forma_recebimento == 'pix' ? 'block' : 'none' }};">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Chave Destinatária</label>
                        <input type="text" name="chave_pix" id="chave_pix" value="{{ $mensalidade->chave_pix }}"
                            class="w-full px-5 py-3.5 bg-white dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white"
                            placeholder="E-mail, CPF ou Aleatória">
                    </div>

                    <button type="submit" class="w-full px-8 py-4 text-[10px] font-black text-white bg-slate-900 dark:bg-blue-600 rounded-2xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-xl active:scale-95 uppercase tracking-widest">
                        Atualizar Regras
                    </button>
                </form>
            </div>

            <!-- Ajuda Contextual -->
            <div class="bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/20 rounded-3xl p-6">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm text-indigo-500">
                        <x-icon name="lightbulb" style="duotone" class="w-6 h-6" />
                    </div>
                    <div class="space-y-2">
                        <h4 class="text-xs font-black text-indigo-900 dark:text-indigo-300 uppercase tracking-widest">Controle de Baixa</h4>
                        <p class="text-[11px] text-indigo-700 dark:text-indigo-400/80 leading-relaxed font-bold uppercase tracking-tight">Utilize o botão "Baixar" para registrar recebimentos manuais. Para PIX, o sistema gera o QR Code automaticamente se configurado.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Classic Remastered -->
<div id="paymentModal" class="hidden fixed inset-0 z-[100] animate-fade-in">
    <div class="flex items-center justify-center min-h-screen px-4 py-12">
        <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" onclick="closePaymentModal()"></div>

        <div class="relative bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl max-w-lg w-full overflow-hidden border border-white/20">
            <div class="px-10 pt-10 pb-6 flex items-center justify-between border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-800/50">
                <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Baixa de Pagamento</h3>
                <button onclick="closePaymentModal()" class="w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-slate-700 flex items-center justify-center text-gray-400 transition-colors">
                    <x-icon name="xmark" class="w-5 h-5" />
                </button>
            </div>

            <form method="POST" action="{{ route('lider-comunidade.pagamentos.store') }}" class="p-10 space-y-8">
                @csrf
                <input type="hidden" name="mensalidade_id" value="{{ $mensalidade->id }}">
                <input type="hidden" name="usuario_poco_id" id="usuario_poco_id">

                <div class="p-5 bg-blue-50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 rounded-3xl flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center text-blue-600 shadow-sm border border-blue-50">
                        <x-icon name="user-tag" style="duotone" class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-blue-600 uppercase tracking-[0.2em] mb-0.5">Contribuinte</p>
                        <p id="usuario_nome" class="text-lg font-black text-blue-900 dark:text-blue-300 uppercase tracking-tight"></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Data Efetiva</label>
                        <input type="date" name="data_pagamento" value="{{ date('Y-m-d') }}" required
                            class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Valor Recebido</label>
                        <input type="number" name="valor_pago" value="{{ $mensalidade->valor_mensalidade }}" step="0.01" min="0.01" required
                            class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white font-mono">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Canal de Entrada</label>
                    <select name="forma_pagamento" required
                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                        <option value="dinheiro">Dinheiro vivo</option>
                        <option value="pix">Transferência PIX</option>
                        <option value="transferencia">T.E.F / DOC / TED</option>
                        <option value="outro">Outros meio</option>
                    </select>
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="button" onclick="closePaymentModal()"
                        class="flex-1 px-8 py-4 text-[10px] font-black text-slate-500 bg-gray-100 dark:bg-slate-800 rounded-2xl hover:bg-gray-200 dark:hover:bg-slate-700 transition-all uppercase tracking-widest">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="flex-1 px-8 py-4 text-[10px] font-black text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20 active:scale-95 uppercase tracking-widest">
                        Confirmar Baixa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
@vite(['resources/js/pix.js'])
<script>
function openPaymentModal(usuarioId, usuarioNome) {
    document.getElementById('usuario_poco_id').value = usuarioId;
    document.getElementById('usuario_nome').textContent = usuarioNome;
    document.getElementById('paymentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('forma_recebimento').addEventListener('change', function() {
    const pixContainer = document.getElementById('chave_pix_container');
    const pixInput = document.getElementById('chave_pix');
    if (this.value === 'pix') {
        pixContainer.style.display = 'block';
        pixInput.required = true;
    } else {
        pixContainer.style.display = 'none';
        pixInput.required = false;
    }
});
</script>
@endpush
@endsection
