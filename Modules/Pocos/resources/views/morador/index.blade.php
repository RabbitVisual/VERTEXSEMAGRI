@extends('pocos::morador.layouts.app')

@section('title', 'Consulta de Faturas')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 py-12 md:py-24">
    <div class="container mx-auto px-4">
        <div class="max-w-xl mx-auto">
            <!-- Header Institucional -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2.5 bg-blue-50/50 dark:bg-blue-900/10 text-blue-600 dark:text-blue-400 px-5 py-2.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800/30 backdrop-blur-sm">
                    <x-icon name="house-user" style="duotone" class="w-4 h-4" />
                    Portal do Morador
                </div>
                <h1 class="text-4xl md:text-6xl font-black font-poppins text-gray-900 dark:text-white mb-6 tracking-tighter">
                    Bem-vindo de <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Volta</span>
                </h1>
                <p class="text-base md:text-lg text-gray-500 dark:text-slate-400 max-w-sm mx-auto leading-relaxed font-medium">
                    Acesse suas faturas e histórico de consumo de forma simples e intuitiva.
                </p>
            </div>

            <!-- Card de Consulta -->
            <div class="premium-card overflow-hidden mb-12">
                <div class="p-8 md:p-10">
                    @if(session('error'))
                        <div class="mb-8 rounded-2xl bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 p-5" role="alert">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0 text-red-600 dark:text-red-400">
                                    <x-icon name="circle-exclamation" style="duotone" class="w-6 h-6" />
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-red-800 dark:text-red-200 uppercase tracking-wider mb-1">Acesso Negado</h3>
                                    <p class="text-xs text-red-700 dark:text-red-300 font-medium">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('morador-poco.autenticar') }}" class="space-y-8" id="acessoForm">
                        @csrf

                        <div class="space-y-4">
                            <label for="codigo_acesso" class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-[0.2em] px-1">
                                Código de Acesso Individual
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                    <x-icon name="key" style="duotone" class="h-6 w-6" />
                                </div>
                                <input
                                    type="text"
                                    id="codigo_acesso"
                                    name="codigo_acesso"
                                    value="{{ old('codigo_acesso') }}"
                                    placeholder="XXXXXXXX"
                                    class="block w-full pl-16 pr-6 py-6 bg-gray-50 dark:bg-slate-900/40 border-2 border-transparent focus:border-blue-500 focus:bg-white dark:focus:bg-slate-900 rounded-[2rem] text-gray-900 dark:text-white text-3xl font-black font-mono tracking-[0.6em] transition-all duration-300 shadow-inner group-hover:bg-gray-100 dark:group-hover:bg-slate-800/50"
                                    required
                                    autofocus
                                    autocomplete="off"
                                    maxlength="8"
                                >
                            </div>
                            @error('codigo_acesso')
                                <p class="text-xs font-bold text-red-600 dark:text-red-400 flex items-center gap-1.5 px-1">
                                    <x-icon name="circle-exclamation" style="duotone" class="w-4 h-4" />
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full relative group overflow-hidden bg-blue-600 text-white px-8 py-5 rounded-2xl font-black text-lg transition-all active:scale-[0.98] shadow-xl shadow-blue-500/20 hover:shadow-blue-500/40"
                            id="submitBtn"
                        >
                            <span class="relative z-10 flex items-center justify-center gap-3" id="submitText">
                                Entrar no Portal
                                <x-icon name="arrow-right" style="solid" class="w-6 h-6 group-hover:translate-x-1 transition-transform" />
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <svg id="loadingSpinner" class="hidden absolute top-1/2 left-1/2 -mt-4 -ml-4 w-8 h-8 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="px-8 py-5 bg-blue-50/50 dark:bg-blue-900/10 border-t border-blue-100 dark:border-blue-900/20 text-center">
                    <p class="text-xs font-bold text-blue-800/60 dark:text-blue-400/60 uppercase tracking-widest leading-relaxed">
                        Esqueceu seu código? Consulte o líder da sua comunidade.
                    </p>
                </div>
            </div>

            <!-- Links de Navegação -->
            <div class="text-center">
                <a href="{{ route('homepage') }}" class="group inline-flex items-center gap-2 text-sm font-bold text-gray-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-all uppercase tracking-widest">
                    <x-icon name="arrow-left" style="duotone" class="w-4 h-4 group-hover:-translate-x-1 transition-transform" />
                    Página Inicial
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('acessoForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');

    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitText.textContent = 'Acessando...';
            loadingSpinner.classList.remove('hidden');
        });
    }

    // Auto-uppercase no código
    const codigoInput = document.getElementById('codigo_acesso');
    if (codigoInput) {
        codigoInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });
    }
});
</script>
@endpush
@endsection
