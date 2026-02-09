@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Lançar Mensalidade')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.mensalidades.index') }}" class="w-10 h-10 rounded-xl bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Lançar Mensalidade</h1>
                <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                    <span>Fluxo Financeiro</span>
                    <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                    <span class="text-blue-600">Abertura de Ciclo</span>
                </nav>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('lider-comunidade.mensalidades.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf

        <!-- Coluna Principal -->
        <div class="lg:col-span-2 space-y-8">
            <div class="premium-card overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <x-icon name="file-invoice-dollar" style="duotone" class="w-5 text-blue-500" />
                        Parâmetros da Cobrança
                    </h2>
                </div>

                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Mês de Referência <span class="text-red-500">*</span></label>
                            <select name="mes" required class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('mes', now()->month) == $i ? 'selected' : '' }}>
                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }} - {{ \Carbon\Carbon::create(null, $i)->locale('pt_BR')->monthName }}
                                </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Ano Civil <span class="text-red-500">*</span></label>
                            <input type="number" name="ano" value="{{ old('ano', now()->year) }}" required min="2020" max="2100" class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Valor Unitário Base <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest">R$</span>
                                <input type="number" name="valor_mensalidade" value="{{ old('valor_mensalidade') }}" step="0.01" min="0.01" required
                                    class="w-full pl-12 pr-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white font-mono" placeholder="0,00">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Data de Vencimento <span class="text-red-500">*</span></label>
                            <input type="date" name="data_vencimento" value="{{ old('data_vencimento') }}" required
                                class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-slate-800">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Observações ou Informativo no Boleto</label>
                        <textarea name="observacoes" rows="4"
                            class="w-full px-5 py-4 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-3xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white leading-relaxed"
                            placeholder="Ex: Taxa de manutenção extra para reparo na bomba principal do setor norte.">{{ old('observacoes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Alerta de Impacto -->
             <div class="p-8 bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 rounded-[2rem] flex items-start gap-5">
                <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-900 flex items-center justify-center text-blue-600 shadow-sm border border-blue-50">
                    <x-icon name="users-gear" style="duotone" class="w-7 h-7" />
                </div>
                <div>
                    <h4 class="text-xs font-black text-blue-900 dark:text-blue-300 uppercase tracking-widest mb-1.5 px-0.5">Processamento Automático</h4>
                    <p class="text-[11px] text-blue-800/80 dark:text-blue-400/80 font-bold uppercase tracking-tight leading-relaxed line-clamp-2">
                        Ao confirmar, o sistema gerará cobranças individuais para <strong>{{ $poco->usuariosPoco()->where('status', 'ativo')->count() }}</strong> moradores ativos vinculados à sua gestão.
                    </p>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral -->
        <div class="lg:col-span-1 space-y-8">
            <div class="premium-card p-8 bg-gradient-to-br from-white to-blue-50/30 dark:from-slate-800 dark:to-slate-900/50">
                <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2 mb-6">
                    <x-icon name="credit-card" style="duotone" class="w-5 text-emerald-500" />
                    Regras de Entrada
                </h2>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Via de Recebimento</label>
                        <select name="forma_recebimento" id="forma_recebimento" required class="w-full px-5 py-3.5 bg-white dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                            <option value="maos" {{ old('forma_recebimento', 'maos') == 'maos' ? 'selected' : '' }}>Dinheiro Vivo (Espécie)</option>
                            <option value="pix" {{ old('forma_recebimento') == 'pix' ? 'selected' : '' }}>Transferência Digital (PIX)</option>
                        </select>
                    </div>

                    <div id="chave_pix_container" style="display: none;" class="animate-fade-in">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Chave PIX de Destino</label>
                        <div class="relative">
                            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-emerald-500">
                                <x-icon name="qrcode" class="w-4 h-4" />
                            </div>
                            <input type="text" name="chave_pix" id="chave_pix" value="{{ old('chave_pix') }}"
                                class="w-full pl-12 pr-5 py-3.5 bg-white dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white"
                                placeholder="E-mail, CPF ou Aleatória">
                        </div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-2 px-1 italic">Esta chave será vinculada ao boleto digital dos moradores.</p>
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-gray-100 dark:border-slate-800 space-y-4">
                    <button type="submit" class="w-full px-8 py-4 text-[10px] font-black text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20 active:scale-95 uppercase tracking-widest flex items-center justify-center gap-3">
                        <x-icon name="check-double" class="w-5 h-5" />
                        Lançar Mensalidades
                    </button>
                    <a href="{{ route('lider-comunidade.mensalidades.index') }}" class="w-full px-8 py-4 text-[10px] font-black text-slate-500 bg-gray-50/50 dark:bg-slate-900/50 rounded-2xl hover:bg-gray-100 dark:hover:bg-slate-800 transition-all uppercase tracking-widest text-center border border-gray-100 dark:border-slate-800">
                        Desistir
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('forma_recebimento');
        const container = document.getElementById('chave_pix_container');
        const input = document.getElementById('chave_pix');

        function togglePix() {
            if (select.value === 'pix') {
                container.style.display = 'block';
                input.required = true;
            } else {
                container.style.display = 'none';
                input.required = false;
                input.value = '';
            }
        }

        select.addEventListener('change', togglePix);
        togglePix(); // Run initial
    });
</script>
@endpush
@endsection
