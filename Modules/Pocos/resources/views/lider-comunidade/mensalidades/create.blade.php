@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Criar Mensalidade')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.mensalidades.index') }}" class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Lançar Mensalidade</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Gere novos boletos para a comunidade</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('lider-comunidade.mensalidades.store') }}" class="premium-card p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Mês de Referência *</label>
                <select name="mes" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ old('mes', now()->month) == $i ? 'selected' : '' }}>
                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }} - {{ ['', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'][$i] }}
                    </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Ano de Referência *</label>
                <input type="number" name="ano" value="{{ old('ano', now()->year) }}" required min="2020" max="2100" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Valor Unitário (R$) *</label>
                <input type="number" name="valor_mensalidade" value="{{ old('valor_mensalidade') }}" step="0.01" min="0.01" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all" placeholder="0.00">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Data Limite de Vencimento *</label>
                <input type="date" name="data_vencimento" value="{{ old('data_vencimento') }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Forma de Recebimento Padrão *</label>
                <select name="forma_recebimento" id="forma_recebimento" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    <option value="maos" {{ old('forma_recebimento', 'maos') == 'maos' ? 'selected' : '' }}>Em Mãos (Dinheiro)</option>
                    <option value="pix" {{ old('forma_recebimento') == 'pix' ? 'selected' : '' }}>Digital (PIX)</option>
                </select>
            </div>

            <div id="chave_pix_container" style="display: none;">
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Chave PIX Própria *</label>
                <input type="text" name="chave_pix" id="chave_pix" value="{{ old('chave_pix') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all" placeholder="E-mail, CPF, Chave Aleatória...">
                <p class="text-[10px] text-gray-500 uppercase font-black tracking-tight mt-1 px-1 italic">Será exibida para todos os moradores no portal.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Observações / Informativo no Boleto</label>
                <textarea name="observacoes" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">{{ old('observacoes') }}</textarea>
            </div>
        </div>

        @push('scripts')
        <script>
            document.getElementById('forma_recebimento').addEventListener('change', function() {
                const pixContainer = document.getElementById('chave_pix_container');
                const pixInput = document.getElementById('chave_pix');
                if (this.value === 'pix') {
                    pixContainer.style.display = 'block';
                    pixInput.required = true;
                } else {
                    pixContainer.style.display = 'none';
                    pixInput.required = false;
                    pixInput.value = '';
                }
            });
            // Trigger on load
            document.getElementById('forma_recebimento').dispatchEvent(new Event('change'));
        </script>
        @endpush

        <div class="mt-8 p-6 bg-blue-50/50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 transition-all">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                </div>
                <div class="text-sm">
                    <p class="font-black text-blue-900 dark:text-blue-300 uppercase tracking-widest mb-1">Impacto da Operação</p>
                    <p class="text-blue-800/80 dark:text-blue-400/80 font-bold">Ao prosseguir, registros de mensalidade serão gerados para <strong>{{ $poco->usuariosPoco()->where('status', 'ativo')->count() }}</strong> moradores ativos.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-10 pt-8 border-t border-gray-100 dark:border-slate-800">
            <a href="{{ route('lider-comunidade.mensalidades.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 dark:text-slate-400 dark:hover:text-slate-200 uppercase tracking-widest">
                Cancelar
            </a>
            <button type="submit" class="px-10 py-3 text-sm font-black text-white bg-slate-900 dark:bg-blue-600 rounded-xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-xl active:scale-95 uppercase tracking-widest">
                Confirmar Lançamento
            </button>
        </div>
    </form>
</div>
@endsection
