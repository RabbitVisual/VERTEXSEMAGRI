@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Configurar Chave PIX - Líder de Comunidade')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 md:pb-8 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <a href="{{ route('lider-comunidade.dashboard') }}" class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-gray-400 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Canais de Recebimento</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Configure sua chave <span class="text-emerald-500 font-black">PIX</span> para automação das faturas</p>
            </div>
        </div>
    </div>

    <!-- Alert Messages (Refined) -->
    @if(session('success'))
    <div class="premium-card bg-emerald-50/50 dark:bg-emerald-900/10 border-emerald-100 dark:border-emerald-900/20 p-4 mb-6" role="alert">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-xs font-bold text-emerald-800 dark:text-emerald-400 uppercase tracking-wider">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Formulário Premium -->
        <div class="lg:col-span-2">
            <div class="premium-card p-8">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75m15 0h.75a.75.75 0 01.75.75v.75m0 0H9m11.25-9h.75a.75.75 0 01.75.75v.75m0 0H21m-1.5-1.5H3.75m0 0h-.375c-.621 0-1.125.504-1.125 1.125v9.75c0 .621.504 1.125 1.125 1.125h.375M9 19.5v-1.5m0-1.5h1.5m-1.5 0H9m0 0v-1.5m0 1.5h1.5m-1.5 0H9" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Chave PIX</h2>
                        <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest italic">Dados para transferência instantânea</p>
                    </div>
                </div>

                <form action="{{ route('lider-comunidade.pix.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="tipo_chave_pix" class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-3 px-1">Tipo de Chave</label>
                            <select name="tipo_chave_pix" id="tipo_chave_pix" required
                                class="w-full px-5 py-4 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-emerald-500 focus:bg-white dark:focus:bg-slate-900 transition-all">
                                <option value="">Selecione o tipo</option>
                                <option value="cpf" {{ old('tipo_chave_pix', $lider->tipo_chave_pix) === 'cpf' ? 'selected' : '' }}>CPF</option>
                                <option value="cnpj" {{ old('tipo_chave_pix', $lider->tipo_chave_pix) === 'cnpj' ? 'selected' : '' }}>CNPJ</option>
                                <option value="email" {{ old('tipo_chave_pix', $lider->tipo_chave_pix) === 'email' ? 'selected' : '' }}>E-mail</option>
                                <option value="telefone" {{ old('tipo_chave_pix', $lider->tipo_chave_pix) === 'telefone' ? 'selected' : '' }}>Telefone</option>
                                <option value="aleatoria" {{ old('tipo_chave_pix', $lider->tipo_chave_pix) === 'aleatoria' ? 'selected' : '' }}>Chave Aleatória (UUID)</option>
                            </select>
                        </div>

                        <div>
                            <label for="chave_pix" class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-3 px-1">Chave PIX</label>
                            <input type="text" name="chave_pix" id="chave_pix" value="{{ old('chave_pix', $lider->chave_pix) }}" required
                                class="w-full px-5 py-4 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-gray-900 dark:text-white font-black font-mono placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:bg-white dark:focus:bg-slate-900 transition-all"
                                placeholder="Digite sua chave">
                            @error('chave_pix')
                                <p class="mt-2 text-xs font-bold text-red-500 px-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if($lider->chave_pix)
                    <div class="p-6 rounded-2xl bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2">Configuração Ativa</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-black text-gray-900 dark:text-white">Status:</span>
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ $lider->pix_ativo ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-600' }}">
                                        {{ $lider->pix_ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 font-medium">Cadastrada em {{ $lider->updated_at->format('d/m/Y') }}</p>
                            </div>
                            @if($lider->pix_ativo)
                            <button type="submit" name="action" value="desativar" class="px-4 py-2 text-xs font-black text-red-600 hover:text-white hover:bg-red-600 dark:hover:bg-red-900/40 rounded-xl transition-all border border-red-200 dark:border-red-900/30 uppercase tracking-tighter active:scale-95">
                                Desativar Chave
                            </button>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 relative group overflow-hidden bg-emerald-600 text-white px-8 py-4 rounded-2xl font-black text-lg shadow-xl shadow-emerald-500/20 active:scale-95 transition-all">
                            <span class="relative z-10">Salvar Alterações</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-700 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Guia Lateral -->
        <div class="space-y-8">
            <div class="premium-card p-6 border-l-4 border-l-blue-500">
                <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest mb-4">Manual do Líder</h3>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 flex-shrink-0 text-xs font-black">01</div>
                        <p class="text-xs text-gray-600 dark:text-slate-400 leading-relaxed">Sua chave é usada para gerar o <strong>QR Code PIX</strong> nas faturas dos moradores.</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 flex-shrink-0 text-xs font-black">02</div>
                        <p class="text-xs text-gray-600 dark:text-slate-400 leading-relaxed">O valor cai instantaneamente na sua conta cadastrada no banco.</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 flex-shrink-0 text-xs font-black">03</div>
                        <p class="text-xs text-gray-600 dark:text-slate-400 leading-relaxed">Recomendamos usar <strong>Chave Aleatória</strong> para maior privacidade.</p>
                    </div>
                </div>
            </div>

            <div class="premium-card p-6 bg-amber-50/50 dark:bg-amber-900/10 border-amber-100 dark:border-amber-900/20">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <h3 class="text-[10px] font-black text-amber-800 dark:text-amber-400 uppercase tracking-widest">Atenção Técnica</h3>
                </div>
                <p class="text-[10px] text-amber-700 dark:text-amber-300 font-bold leading-relaxed uppercase opacity-80">
                    Sua chave deve estar devidamente vinculada ao seu banco.
                    <br><br>
                    <strong>Nota Importante:</strong> Em caso de faturamento via Plataforma, o valor será recebido pela central e sua parte será repassada automaticamente (Split) ou manualmente para esta chave.
                </p>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
    // Máscara para CPF/CNPJ
    document.getElementById('tipo_chave_pix').addEventListener('change', function() {
        const tipo = this.value;
        const chaveInput = document.getElementById('chave_pix');

        if (tipo === 'cpf') {
            chaveInput.placeholder = '00000000000 (11 dígitos)';
        } else if (tipo === 'cnpj') {
            chaveInput.placeholder = '00000000000000 (14 dígitos)';
        } else if (tipo === 'email') {
            chaveInput.placeholder = 'seu@email.com';
            chaveInput.type = 'email';
        } else if (tipo === 'telefone') {
            chaveInput.placeholder = '+5511999999999';
        } else if (tipo === 'aleatoria') {
            chaveInput.placeholder = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        } else {
            chaveInput.placeholder = 'Digite sua chave PIX';
            chaveInput.type = 'text';
        }
    });
</script>
@endpush
@endsection
