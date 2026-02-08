@extends('homepage::layouts.homepage')

@section('title', 'Portal do Agricultor - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-yellow-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-amber-600 via-yellow-600 to-orange-600 py-16 lg:py-24">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 60px 60px;"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center text-white">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-5 py-2.5 rounded-full text-sm font-medium mb-6">
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                                    Consultar
                                </span>
                            </button>
                        </div>
                        <p class="text-sm text-white/80 mt-4 text-center">
                            🔒 Seus dados estão protegidos pela LGPD. Apenas você pode consultar suas informações.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Estatísticas -->
    <section class="py-12 bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 rounded-xl p-6 border border-amber-200 dark:border-amber-800">
                    <div class="text-3xl md:text-4xl font-bold text-amber-600 dark:text-amber-400 mb-2">{{ $estatisticas['total_programas_ativos'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">Programas Ativos</div>
                </div>
                <div class="text-center bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl p-6 border border-yellow-200 dark:border-yellow-800">
                    <div class="text-3xl md:text-4xl font-bold text-yellow-600 dark:text-yellow-400 mb-2">{{ $estatisticas['total_eventos_proximos'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">Próximos Eventos</div>
                </div>
                <div class="text-center bg-gradient-to-br from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-xl p-6 border border-orange-200 dark:border-orange-800">
                    <div class="text-3xl md:text-4xl font-bold text-orange-600 dark:text-orange-400 mb-2">{{ $estatisticas['total_beneficiarios'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">Agricultores Beneficiados</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programas Disponíveis -->
    <section class="py-16 bg-white dark:bg-slate-800">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                        Programas Disponíveis
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Conheça os programas governamentais disponíveis para agricultores
                    </p>
                </div>
                <a href="{{ route('portal.agricultor.programas') }}" class="hidden md:inline-flex items-center gap-2 px-6 py-3 bg-amber-600 text-white rounded-xl font-semibold hover:bg-amber-700 transition-colors">
                    Ver Todos
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                Consultar Agora
            </a>
        </div>
    </section>
</div>

@include('homepage::layouts.footer-homepage')

@push('scripts')
<script>
// Máscara de CPF
document.addEventListener('DOMContentLoaded', function() {
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            }
        });
    }
});
</script>
@endpush

@endsection

