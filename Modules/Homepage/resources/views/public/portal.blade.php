@extends('homepage::layouts.homepage')

@section('title', 'Portal de Infraestrutura Pública - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-teal-600 to-green-600 py-16 lg:py-24">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 60px 60px;"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center text-white">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-5 py-2.5 rounded-full text-sm font-medium mb-6">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>
                    <span>Transparência e Acesso à Informação</span>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    Portal de Infraestrutura Pública
                </h1>
                <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                    Conheça a infraestrutura disponível em sua localidade: poços artesianos, pontos de água, iluminação pública e estradas
                </p>
            </div>
        </div>
    </section>

    <!-- Estatísticas -->
    <section class="py-12 bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 md:gap-6">
                <!-- Localidades -->
                <div class="group bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl p-6 border border-emerald-200 dark:border-emerald-800 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-emerald-500 dark:bg-emerald-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <x-icon module="localidades" class="w-8 h-8 text-white" />
                        </div>
                        <div class="text-3xl md:text-4xl font-bold text-emerald-600 dark:text-emerald-400 mb-2">{{ number_format($estatisticas['localidades'] ?? 0, 0, ',', '.') }}</div>
                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Localidades</div>
                    </div>
                </div>

                <!-- Poços Artesianos -->
                <div class="group bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-blue-500 dark:bg-blue-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <x-icon module="pocos" class="w-8 h-8 text-white" />
                        </div>
                        <div class="text-3xl md:text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ number_format($estatisticas['poços'] ?? 0, 0, ',', '.') }}</div>
                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Poços Artesianos</div>
                    </div>
                </div>

                <!-- Pontos de Água -->
                <div class="group bg-gradient-to-br from-cyan-50 to-sky-50 dark:from-cyan-900/20 dark:to-sky-900/20 rounded-xl p-6 border border-cyan-200 dark:border-cyan-800 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-cyan-500 dark:bg-cyan-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <x-icon module="agua" class="w-8 h-8 text-white" />
                        </div>
                        <div class="text-3xl md:text-4xl font-bold text-cyan-600 dark:text-cyan-400 mb-2">{{ number_format($estatisticas['pontos_agua'] ?? 0, 0, ',', '.') }}</div>
                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Pontos de Água</div>
                    </div>
                </div>

                <!-- Pontos de Luz -->
                <div class="group bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 rounded-xl p-6 border border-amber-200 dark:border-amber-800 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-amber-500 dark:bg-amber-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <x-icon module="iluminacao" class="w-8 h-8 text-white" />
                        </div>
                        <div class="text-3xl md:text-4xl font-bold text-amber-600 dark:text-amber-400 mb-2">{{ number_format($estatisticas['pontos_luz'] ?? 0, 0, ',', '.') }}</div>
                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Pontos de Luz</div>
                    </div>
                </div>

                <!-- Km de Estradas -->
                <div class="group bg-gradient-to-br from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20 rounded-xl p-6 border border-violet-200 dark:border-violet-800 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-violet-500 dark:bg-violet-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <x-icon module="estradas" class="w-8 h-8 text-white" />
                        </div>
                        <div class="text-3xl md:text-4xl font-bold text-violet-600 dark:text-violet-400 mb-2">{{ number_format($estatisticas['km_estradas'] ?? 0, 1, ',', '.') }}</div>
                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Km de Estradas</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Localidades -->
    <section class="py-12 md:py-16 lg:py-20 bg-gradient-to-b from-transparent via-white/50 to-transparent dark:via-slate-900/50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 md:mb-12 lg:mb-16">
                <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <x-icon module="localidades" class="w-4 h-4" />
                    <span>Explorar Localidades</span>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 md:mb-6">
                    Localidades Atendidas
                </h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    Selecione uma localidade para ver detalhes da infraestrutura disponível
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 mb-12">
                @forelse($localidades as $localidade)
                <a href="{{ route('portal.localidade', $localidade->id) }}" class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-md border border-gray-200 dark:border-slate-700 p-6 md:p-8 hover:shadow-2xl hover:border-emerald-500 dark:hover:border-emerald-500 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <!-- Decorative background gradient -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 dark:from-emerald-500/10 dark:to-teal-500/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>

                    <div class="relative z-10">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-5">
                            <div class="flex-1 min-w-0 pr-4">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 dark:from-emerald-600 dark:to-teal-700 rounded-lg flex items-center justify-center flex-shrink-0 shadow-md">
                                        <x-icon module="localidades" class="w-5 h-5 text-white" />
                                    </div>
                                    <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors line-clamp-2">
                                        {{ $localidade->nome }}
                                    </h3>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span class="truncate">{{ $localidade->cidade ?? 'N/A' }}, {{ $localidade->estado ?? 'BA' }}</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0 w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/30 transition-colors">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </div>
                        </div>

                        <!-- Footer Info -->
                        <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                            @if($localidade->numero_moradores)
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-slate-700/50 px-3 py-1.5 rounded-lg">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                <span class="font-semibold">{{ number_format($localidade->numero_moradores, 0, ',', '.') }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">moradores</span>
                            </div>
                            @endif
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                {{ ucfirst($localidade->tipo ?? 'Localidade') }}
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-12 md:p-16 text-center">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Nenhuma localidade cadastrada</h3>
                        <p class="text-gray-500 dark:text-gray-400">Não há localidades disponíveis no momento.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Links Úteis -->
    <section class="py-16 bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Serviços Disponíveis
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <a href="{{ route('demandas.public.consulta') }}" class="group bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl p-6 border border-emerald-200 dark:border-emerald-800 hover:shadow-lg transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-emerald-500 rounded-lg flex items-center justify-center">
                            <x-icon module="demandas" class="w-6 h-6 text-white" />
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                Consultar Demanda
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Acompanhe o status da sua solicitação
                            </p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>

                <a href="{{ route('homepage') }}" class="group bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800 hover:shadow-lg transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                Página Inicial
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Voltar para a página principal
                            </p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </section>
</div>

@include('homepage::layouts.footer-homepage')
@endsection


