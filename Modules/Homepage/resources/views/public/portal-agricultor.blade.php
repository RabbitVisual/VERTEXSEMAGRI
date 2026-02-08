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
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Portal do Agricultor</span>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    Programas e Benefícios para Você
                </h1>
                <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed mb-8">
                    Consulte programas governamentais, eventos, capacitações e acompanhe seus benefícios
                </p>

                <!-- Consulta por CPF -->
                <div id="consultar" class="max-w-2xl mx-auto mt-8">
                    <form action="{{ route('portal.agricultor.consultar') }}" method="POST" class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                        @csrf
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <input 
                                    type="text" 
                                    name="cpf" 
                                    id="cpf" 
                                    placeholder="Digite seu CPF (apenas números)"
                                    class="w-full px-6 py-4 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent transition-all"
                                    value="{{ old('cpf') }}"
                                    maxlength="14"
                                >
                                @error('cpf')
                                    <p class="mt-2 text-sm text-red-200">{{ $message }}</p>
                                @enderror
                            </div>
                            <button 
                                type="submit"
                                class="px-8 py-4 bg-white text-amber-600 rounded-xl font-semibold hover:bg-amber-50 hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl whitespace-nowrap"
                            >
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
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
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            @if($programas->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($programas as $programa)
                        <a href="{{ route('portal.agricultor.programa', $programa->id) }}" class="group bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 rounded-2xl p-6 border border-amber-200 dark:border-amber-800 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h4.125M8.25 8.25l5.25 5.25" />
                                    </svg>
                                </div>
                                <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-semibold rounded-full">
                                    {{ $programa->tipo_texto }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                                {{ $programa->nome }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                {{ Str::limit($programa->descricao ?? 'Programa governamental para agricultores', 100) }}
                            </p>
                            @if($programa->tem_vagas !== null)
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    <span>{{ $programa->vagas_restantes ?? 'Ilimitado' }} vagas disponíveis</span>
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h4.125M8.25 8.25l5.25 5.25" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400">Nenhum programa disponível no momento.</p>
                </div>
            @endif

            <div class="text-center mt-8">
                <a href="{{ route('portal.agricultor.programas') }}" class="md:hidden inline-flex items-center gap-2 px-6 py-3 bg-amber-600 text-white rounded-xl font-semibold hover:bg-amber-700 transition-colors">
                    Ver Todos os Programas
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Próximos Eventos -->
    <section class="py-16 bg-gradient-to-br from-slate-50 to-gray-100 dark:from-slate-800 dark:to-slate-900">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                        Próximos Eventos
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Capacitações, palestras e eventos para agricultores
                    </p>
                </div>
                <a href="{{ route('portal.agricultor.eventos') }}" class="hidden md:inline-flex items-center gap-2 px-6 py-3 bg-yellow-600 text-white rounded-xl font-semibold hover:bg-yellow-700 transition-colors">
                    Ver Todos
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            @if($eventos->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($eventos as $evento)
                        <a href="{{ route('portal.agricultor.evento', $evento->id) }}" class="group bg-white dark:bg-slate-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <span class="inline-block px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-semibold rounded-full mb-2">
                                        {{ $evento->tipo_texto }}
                                    </span>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                                        {{ $evento->titulo }}
                                    </h3>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                    <span>{{ $evento->data_inicio->format('d/m/Y') }}</span>
                                </div>
                                @if($evento->localidade)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        <span>{{ $evento->localidade->nome }}</span>
                                    </div>
                                @endif
                                @if($evento->tem_vagas !== null)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                        <span>{{ $evento->vagas_restantes ?? 'Ilimitado' }} vagas</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400">Nenhum evento agendado no momento.</p>
                </div>
            @endif

            <div class="text-center mt-8">
                <a href="{{ route('portal.agricultor.eventos') }}" class="md:hidden inline-flex items-center gap-2 px-6 py-3 bg-yellow-600 text-white rounded-xl font-semibold hover:bg-yellow-700 transition-colors">
                    Ver Todos os Eventos
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-gradient-to-br from-amber-600 to-yellow-600">
        <div class="container mx-auto px-4 text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Acompanhe seus Benefícios
            </h2>
            <p class="text-xl text-white/90 max-w-2xl mx-auto mb-8">
                Consulte seus programas, eventos e capacitações usando seu CPF
            </p>
            <a href="#consultar" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-amber-600 rounded-xl font-semibold hover:bg-amber-50 hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
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

