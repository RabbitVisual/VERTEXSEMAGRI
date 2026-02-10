@extends('homepage::layouts.homepage')

@section('title', 'Consultar Demanda - Secretaria Municipal de Agricultura')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-12 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header Institucional -->
            <div class="text-center mb-12 animate-fade-in-up">
                <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-6 shadow-sm">
                    <x-icon name="magnifying-glass" style="duotone" class="w-4 h-4" />
                    Consulta Pública de Demandas
                </div>
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6 tracking-tight">
                    Acompanhe sua <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Demanda</span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Digite o código da sua demanda para verificar o status atual, visualizar o histórico de atualizações e obter informações detalhadas sobre o atendimento.
                </p>
            </div>

            <!-- Card de Consulta -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-gray-100 dark:border-slate-700/50 overflow-hidden mb-12 relative group hover:shadow-2xl transition-all duration-300 animate-fade-in-up delay-100">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>

                <!-- Alertas -->
                @if(session('error'))
                    <div class="mx-6 mt-6 md:mx-8 md:mt-8 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4 animate-shake" role="alert">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <x-icon name="circle-exclamation" style="duotone" class="h-6 w-6 text-red-500" />
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold text-red-800 dark:text-red-200 mb-1">Não encontramos essa demanda</h3>
                                <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mx-6 mt-6 md:mx-8 md:mt-8 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 p-4" role="alert">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <x-icon name="circle-check" style="duotone" class="h-6 w-6 text-emerald-500" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-emerald-800 dark:text-emerald-200 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="p-6 md:p-10">
                    <form action="{{ route('demandas.public.consultar') }}" method="POST" class="space-y-8" id="consultaForm">
                        @csrf

                        <div class="space-y-4">
                            <label for="codigo" class="block text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                Código do Protocolo
                                <span class="text-red-500" title="Obrigatório">*</span>
                            </label>
                            <div class="relative group/input">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <x-icon name="hashtag" style="duotone" class="h-6 w-6 text-gray-400 group-focus-within/input:text-emerald-500 transition-colors" />
                                </div>
                                <input
                                    type="text"
                                    id="codigo"
                                    name="codigo"
                                    value="{{ old('codigo') }}"
                                    placeholder="Ex: DEM-2024-0001"
                                    class="block w-full pl-14 pr-5 py-5 border-2 border-gray-200 dark:border-slate-600 rounded-2xl bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-0 focus:border-emerald-500 text-xl font-mono tracking-wide transition-all uppercase hover:bg-white dark:hover:bg-slate-800"
                                    required
                                    autofocus
                                    autocomplete="off"
                                    maxlength="50"
                                >
                            </div>
                            @error('codigo')
                                <p class="text-sm text-red-600 dark:text-red-400 flex items-center gap-2 mt-2">
                                    <x-icon name="circle-exclamation" style="duotone" class="w-4 h-4" />
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Onde encontrar o código -->
                        <div class="bg-blue-50/50 dark:bg-blue-900/10 rounded-2xl p-6 border border-blue-100 dark:border-blue-800/30">
                            <h3 class="text-sm font-bold text-blue-900 dark:text-blue-100 mb-4 flex items-center gap-2">
                                <x-icon name="circle-info" style="duotone" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                Onde encontrar meu código?
                            </h3>
                            <div class="grid sm:grid-cols-3 gap-4">
                                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-slate-800 p-3 rounded-xl border border-blue-100 dark:border-slate-700 shadow-sm">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                        <x-icon name="file-invoice" style="duotone" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <span>No comprovante impresso</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-slate-800 p-3 rounded-xl border border-blue-100 dark:border-slate-700 shadow-sm">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                        <x-icon name="envelope" style="duotone" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <span>No e-mail de confirmação</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-slate-800 p-3 rounded-xl border border-blue-100 dark:border-slate-700 shadow-sm">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                        <x-icon name="message-sms" style="duotone" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <span>Via SMS (se solicitado)</span>
                                </div>
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-bold py-5 rounded-2xl shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-3"
                        >
                            <x-icon name="magnifying-glass" style="duotone" class="w-6 h-6" />
                            Consultar Demanda
                        </button>
                    </form>
                </div>
            </div>

            <!-- Informações Adicionais -->
            <div class="grid md:grid-cols-2 gap-6 animate-fade-in-up delay-200">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center mb-4">
                        <x-icon name="shield-check" style="duotone" class="w-7 h-7 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Transparência Total</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Acompanhe cada etapa do processo, desde a solicitação até a conclusão, com atualizações em tempo real sobre o andamento.
                    </p>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4">
                        <x-icon name="user-lock" style="duotone" class="w-7 h-7 text-blue-600 dark:text-blue-400" />
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Segurança e Privacidade</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Seus dados são protegidos. O acesso às informações detalhadas é exclusivo para quem possui o protocolo da demanda.
                    </p>
                    <a href="{{ route('privacidade') }}" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium mt-3">
                        Ler Política de Privacidade
                        <x-icon name="arrow-right" class="w-3 h-3" />
                    </a>
                </div>
            </div>

            <div class="mt-12 text-center animate-fade-in-up delay-300">
                <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 transition-colors font-medium">
                    <x-icon name="arrow-left" class="w-4 h-4" />
                    Voltar para a Página Inicial
                </a>
            </div>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-uppercase no código
    const codigoInput = document.getElementById('codigo');
    if (codigoInput) {
        codigoInput.addEventListener('input', function(e) {
            let start = this.selectionStart;
            let end = this.selectionEnd;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(start, end);
        });
    }
});
</script>
@endpush
@endsection
