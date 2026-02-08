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
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                    Consulta Pública de Demandas
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    Acompanhe sua Demanda
                </h1>
                <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Digite o código/protocolo da sua demanda para acompanhar o status em tempo real e obter informações atualizadas sobre o andamento do seu atendimento.
                </p>
            </div>

            <!-- Card de Consulta -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border-2 border-gray-200 dark:border-slate-700 overflow-hidden mb-8">
                <!-- Alertas -->
                @if(session('error'))
                    <div class="m-6 mb-0 rounded-xl bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 p-5" role="alert">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <x-icon name="circle-exclamation" class="w-6 h-6 text-red-600 dark:text-red-400" />
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-red-800 dark:text-red-200">Ops! Algo deu errado</h3>
                                <div class="mt-1 text-sm text-red-700 dark:text-red-300">
                                    {{ session('error') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('demandas.public.consultar') }}" method="POST" id="consultaForm" class="p-8 md:p-12">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="codigo" class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-3">
                                Código/Protocolo da Demanda
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <x-icon name="ticket" class="w-6 h-6 text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                                </div>
                                <input type="text"
                                       name="codigo"
                                       id="codigo"
                                       required
                                       value="{{ old('codigo') }}"
                                       placeholder="EX: DEM-2024-XXXX"
                                       class="block w-full pl-14 pr-4 py-5 bg-gray-50 dark:bg-slate-900 border-2 border-gray-200 dark:border-slate-700 rounded-2xl text-xl font-mono text-gray-900 dark:text-white placeholder-gray-400 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all uppercase">
                            </div>
                            @error('codigo')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button type="submit"
                                id="submitBtn"
                                class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-5 px-8 rounded-2xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transform hover:-translate-y-1 transition-all flex items-center justify-center gap-3 text-lg">
                            <span id="submitText">Consultar Agora</span>
                            <div id="loadingSpinner" class="hidden">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                            <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shadow-md">
                                    <x-icon name="shield-check" class="w-6 h-6 text-white" />
                                </div>
                                <div class="text-sm">
                                    <p class="font-bold text-blue-900 dark:text-blue-200">Segurança Total</p>
                                    <p class="text-blue-700 dark:text-blue-300">Consulta protegida pela LGPD</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800">
                                <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center shadow-md">
                                    <x-icon name="bolt" class="w-6 h-6 text-white" />
                                </div>
                                <div class="text-sm">
                                    <p class="font-bold text-amber-900 dark:text-amber-200">Tempo Real</p>
                                    <p class="text-amber-700 dark:text-amber-300">Status atualizado pela equipe</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="text-center">
                <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                    Voltar para a página inicial
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
