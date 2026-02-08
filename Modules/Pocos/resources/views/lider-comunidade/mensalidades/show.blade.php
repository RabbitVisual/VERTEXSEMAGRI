@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Detalhes da Mensalidade')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.mensalidades.index') }}" class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Mensalidade {{ $mensalidade->mes_ano }}</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Controle de arrecadação e baixas</p>
            </div>
        </div>
    </div>

    <!-- Configuração de Recebimento -->
    <!-- Configurações Inteligentes -->
    <div class="premium-card p-6">
        <h2 class="text-sm font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-6 border-b border-gray-50 dark:border-slate-800 pb-3 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" /></svg>
            Configurações de Recebimento
        </h2>
        <form method="POST" action="{{ route('lider-comunidade.mensalidades.update-recebimento', $mensalidade->id) }}" class="flex flex-wrap items-end gap-6">
            @csrf
            @method('PUT')
            <div class="flex-1 min-w-[250px]">
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Forma Preferencial</label>
                <select name="forma_recebimento" id="forma_recebimento" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    <option value="maos" {{ $mensalidade->forma_recebimento == 'maos' ? 'selected' : '' }}>Em Mãos (Dinheiro)</option>
                    <option value="pix" {{ $mensalidade->forma_recebimento == 'pix' ? 'selected' : '' }}>Digital (PIX)</option>
                </select>
            </div>
            <div id="chave_pix_container" class="flex-1 min-w-[300px]" style="display: {{ $mensalidade->forma_recebimento == 'pix' ? 'block' : 'none' }};">
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Chave PIX Específica</label>
                <input type="text" name="chave_pix" id="chave_pix" value="{{ $mensalidade->chave_pix }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all" placeholder="E-mail, CPF, Chave Aleatória...">
            </div>
            <button type="submit" class="px-8 py-2.5 text-sm font-bold text-white bg-slate-900 dark:bg-blue-600 rounded-xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-lg active:scale-95">
                Salvar Alterações
            </button>
        </form>
    </div>

    <!-- Resumo de Caixa -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="premium-card p-6 border-l-4 border-l-blue-500">
            <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Valor Unitário</p>
            <p class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">R$ {{ number_format($mensalidade->valor_mensalidade, 2, ',', '.') }}</p>
        </div>
        <div class="premium-card p-6 border-l-4 border-l-emerald-500">
            <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Total Arrecadado</p>
            <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight">R$ {{ number_format($mensalidade->total_arrecadado, 2, ',', '.') }}</p>
        </div>
        <div class="premium-card p-6 border-l-4 border-l-amber-500">
            <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Total Pendente</p>
            <p class="text-2xl font-black text-amber-600 dark:text-amber-400 tracking-tight">R$ {{ number_format($mensalidade->total_pendente, 2, ',', '.') }}</p>
        </div>
        <div class="premium-card p-6 border-l-4 border-l-gray-500">
            <p class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-1">Status Global</p>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider mt-1 {{ $mensalidade->status === 'aberta' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400' }}">
                {{ $mensalidade->status_texto }}
            </span>
        </div>
    </div>

    <!-- Tabela Detalhada -->
    <div class="premium-card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/30 dark:bg-slate-900/50">
            <h2 class="text-sm font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest">Controle de Moradores</h2>
            <span class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest bg-blue-50 dark:bg-blue-900/20 px-3 py-1 rounded-full border border-blue-100 dark:border-blue-900/30">{{ $mensalidade->usuarios_pagantes }} / {{ $mensalidade->total_usuarios }} Pagos</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] text-gray-400 uppercase tracking-widest bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Morador</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Data Pagto</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Valor Pago</th>
                        <th scope="col" class="px-6 py-4 font-bold text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $usuario->nome }}</td>
                        <td class="px-6 py-4">
                            @if($usuario->pagou)
                            <span class="px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">Pago</span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium rounded bg-amber-100 text-amber-800 dark:bg-amber-900/20 dark:text-amber-400">Pendente</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($usuario->pagou)
                            {{ $usuario->pagamento->data_pagamento->format('d/m/Y') }}
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($usuario->pagou)
                            <span class="font-semibold text-green-600 dark:text-green-400">R$ {{ number_format($usuario->pagamento->valor_pago, 2, ',', '.') }}</span>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if(!$usuario->pagou)
                            <div class="flex items-center gap-2">
                                @if($mensalidade->lider->pix_ativo && $mensalidade->lider->chave_pix)
                                <button onclick="window.exibirQrCodeModal && window.exibirQrCodeModal({{ $mensalidade->id }}, {{ $usuario->id }})"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                                    </svg>
                                    QR Code PIX
                                </button>
                                @endif
                                <button onclick="openPaymentModal({{ $usuario->id }}, '{{ $usuario->nome }}')" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">Registrar Pagamento</button>
                            </div>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Registro de Pagamento -->
<div id="paymentModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black opacity-50" onclick="closePaymentModal()"></div>
        <div class="relative bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Registrar Pagamento</h3>
            <form method="POST" action="{{ route('lider-comunidade.pagamentos.store') }}">
                @csrf
                <input type="hidden" name="mensalidade_id" value="{{ $mensalidade->id }}">
                <input type="hidden" name="usuario_poco_id" id="usuario_poco_id">

                <div class="mb-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Usuário: <strong id="usuario_nome" class="text-gray-900 dark:text-white"></strong></p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data do Pagamento *</label>
                    <input type="date" name="data_pagamento" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Valor Pago (R$) *</label>
                    <input type="number" name="valor_pago" value="{{ $mensalidade->valor_mensalidade }}" step="0.01" min="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Forma de Pagamento *</label>
                    <select name="forma_pagamento" required class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                        <option value="dinheiro">Dinheiro</option>
                        <option value="pix">PIX</option>
                        <option value="transferencia">Transferência</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Observações</label>
                    <textarea name="observacoes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-slate-700 dark:border-slate-600 dark:text-white"></textarea>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Registrar
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
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}

// Toggle chave PIX
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
