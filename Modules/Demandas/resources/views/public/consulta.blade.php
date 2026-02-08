@extends('homepage::layouts.homepage')

@section('title', 'Consultar Demanda - Secretaria Municipal de Agricultura')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header Institucional -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <x-icon name="magnifying-glass" style="duotone" class="w-4 h-4" />
                    Consulta Pública de Demandas
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    Acompanhe sua Demanda
                </h1>
                <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed font-poppins">
                    Digite o código/protocolo da sua demanda para acompanhar o status em tempo real e obter informações atualizadas sobre o andamento do seu atendimento.
                </p>
            </div>

            <!-- Card de Consulta -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border-2 border-gray-200 dark:border-slate-700 overflow-hidden mb-8 transition-transform hover:shadow-2xl">
                <!-- Alertas -->
                @if(session('error'))
                    <div class="m-6 mb-0 rounded-xl bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 p-5" role="alert">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <x-icon name="circle-exclamation" style="duotone" class="h-6 w-6 text-red-500" />
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base font-bold text-red-800 dark:text-red-200 mb-1 font-poppins">Erro na Consulta</h3>
                                <p class="text-sm text-red-700 dark:text-red-300 leading-relaxed">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="m-6 mb-0 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border-2 border-emerald-200 dark:border-emerald-800 p-5" role="alert">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <x-icon name="circle-check" style="duotone" class="h-6 w-6 text-emerald-500" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-emerald-800 dark:text-emerald-200 font-medium font-poppins">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="p-6 md:p-8">
                    <form action="{{ route('demandas.public.consultar') }}" method="POST" class="space-y-6" id="consultaForm">
                        @csrf

                        <div>
                            <label for="codigo" class="block text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2 font-poppins">
                                <x-icon name="hashtag" style="duotone" class="w-5 h-5 text-emerald-500" />
                                Código/Protocolo da Demanda
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <x-icon name="file-invoice" style="duotone" class="h-6 w-6 text-gray-400" />
                                </div>
                                <input
                                    type="text"
                                    id="codigo"
                                    name="codigo"
                                    value="{{ old('codigo') }}"
                                    placeholder="Ex: DEM-AGU-202411-0001"
                                    class="block w-full pl-14 pr-4 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg font-mono transition-all @error('codigo') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                    required
                                    autofocus
                                    autocomplete="off"
                                    maxlength="50"
                                >
                            </div>
                            @error('codigo')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-2 font-poppins">
                                    <x-icon name="circle-info" style="duotone" class="w-4 h-4" />
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Guia Visual de Como Encontrar o Código -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-6">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2 font-poppins">
                                <x-icon name="circle-question" style="duotone" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                Onde encontrar o código/protocolo?
                            </h3>
                            <div class="grid md:grid-cols-3 gap-4">
                                <div class="flex items-start gap-3 p-3 bg-white dark:bg-slate-700 rounded-lg shadow-sm border border-gray-100 dark:border-slate-600">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <x-icon name="file-lines" style="duotone" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1 font-poppins">Comprovante</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 leading-tight">No documento recebido na abertura da demanda</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-white dark:bg-slate-700 rounded-lg shadow-sm border border-gray-100 dark:border-slate-600">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <x-icon name="envelope" style="duotone" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1 font-poppins">E-mail</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 leading-tight">Na mensagem de confirmação enviada por e-mail</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-white dark:bg-slate-700 rounded-lg shadow-sm border border-gray-100 dark:border-slate-600">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <x-icon name="hashtag" style="duotone" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1 font-poppins">Protocolo</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 leading-tight">No protocolo de atendimento fornecido</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-8 py-4 rounded-xl font-bold hover:from-emerald-600 hover:to-teal-700 active:scale-[0.98] transition-all duration-300 shadow-lg hover:shadow-emerald-500/30 flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed text-lg group"
                            id="submitBtn"
                        >
                            <x-icon name="magnifying-glass" style="duotone" class="w-6 h-6 group-hover:scale-110 transition-transform" />
                            <span id="submitText">Consultar Demanda</span>
                            <x-icon name="spinner" style="duotone" class="hidden w-6 h-6 fa-spin" id="loadingSpinner" />
                        </button>
                    </form>
                </div>
            </div>

            <!-- Informações sobre a Consulta -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Benefícios da Consulta -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border-2 border-gray-200 dark:border-slate-700 p-6 flex flex-col">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2 font-poppins">
                        <x-icon name="list-check" style="duotone" class="w-5 h-5 text-emerald-500" />
                        O que você pode fazer
                    </h3>
                    <ul class="space-y-4 flex-1">
                        <li class="flex items-start gap-3 group">
                            <x-icon name="clock" style="duotone" class="w-5 h-5 text-emerald-500 mt-1 flex-shrink-0 group-hover:scale-110 transition-transform" />
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white font-poppins">Acompanhamento em tempo real</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Status atualizado instantaneamente pela nossa equipe</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 group">
                            <x-icon name="history" style="duotone" class="w-5 h-5 text-emerald-500 mt-1 flex-shrink-0 group-hover:scale-110 transition-transform" />
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white font-poppins">Histórico completo</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Visualize todas as etapas desde a abertura</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 group">
                            <x-icon name="location-dot" style="duotone" class="w-5 h-5 text-emerald-500 mt-1 flex-shrink-0 group-hover:scale-110 transition-transform" />
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white font-poppins">Localização no mapa</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Visualize o local exato da demanda no mapa</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Proteção LGPD -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl shadow-lg border-2 border-blue-200 dark:border-blue-800 p-6 flex flex-col">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2 font-poppins">
                        <x-icon name="shield-halved" style="duotone" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        Proteção de Dados (LGPD)
                    </h3>
                    <div class="space-y-4 flex-1">
                        <div class="flex items-start gap-3 group">
                            <x-icon name="lock" style="duotone" class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-1 flex-shrink-0 group-hover:scale-110 transition-transform" />
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white font-poppins">Segurança garantida</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Dados tratados conforme a Lei nº 13.709/2018</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 group">
                            <x-icon name="user-shield" style="duotone" class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-1 flex-shrink-0 group-hover:scale-110 transition-transform" />
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white font-poppins">Privacidade absoluta</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Nenhum dado pessoal sensível é exposto</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-blue-200 dark:border-blue-700">
                        <a href="{{ route('privacidade') }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium group">
                            <span class="font-poppins">Política de Privacidade</span>
                            <x-icon name="arrow-right" style="duotone" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </a>
                    </div>
                </div>
            </div>

            <!-- Links de Navegação -->
            <div class="text-center">
                <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all font-medium group">
                    <x-icon name="arrow-left" style="duotone" class="w-4 h-4 group-hover:-translate-x-1 transition-transform" />
                    <span class="font-poppins">Voltar para a página inicial</span>
                </a>
            </div>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('consultaForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');

    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitText.textContent = 'Consultando...';
            loadingSpinner.classList.remove('hidden');
        });
    }

    // Auto-uppercase no código
    const codigoInput = document.getElementById('codigo');
    if (codigoInput) {
        codigoInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });
    }
});
</script>
@endpush
@endsection
