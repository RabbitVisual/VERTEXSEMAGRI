@extends('homepage::layouts.homepage')

@section('title', $localidade->nome . ' - Portal de Infraestrutura - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <!-- Breadcrumb -->
        <nav class="mb-6 md:mb-8" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2 text-sm">
                <li>
                    <a href="{{ route('homepage') }}" class="text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        Início
                    </a>
                </li>
                <li><span class="text-gray-400 dark:text-gray-500">/</span></li>
                <li>
                    <a href="{{ route('portal.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        Portal
                    </a>
                </li>
                <li><span class="text-gray-400 dark:text-gray-500">/</span></li>
                <li class="text-gray-900 dark:text-white font-medium truncate">{{ $localidade->nome }}</li>
            </ol>
        </nav>

        <!-- Header Card -->
        <div class="bg-gradient-to-br from-white to-emerald-50/50 dark:from-slate-800 dark:to-slate-900 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 p-6 md:p-8 mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/5 dark:bg-emerald-400/5 rounded-full -mr-32 -mt-32"></div>
            <div class="relative z-10">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex-1">
                        <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                            <x-icon module="localidades" class="w-4 h-4" />
                            {{ ucfirst($localidade->tipo ?? 'Localidade') }}
                        </div>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold font-poppins text-gray-900 dark:text-white mb-3 leading-tight">
                            {{ $localidade->nome }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-4 text-gray-600 dark:text-gray-300">
                            <div class="flex items-center gap-2">
                                <x-icon module="localidades" class="w-5 h-5" />
                                <span>{{ $localidade->cidade ?? 'N/A' }}, {{ $localidade->estado ?? 'BA' }}</span>
                            </div>
                            @if($localidade->numero_moradores)
                            <div class="flex items-center gap-2">
                                <x-icon name="users" style="duotone" class="w-5 h-5" />
                                <span class="font-semibold">{{ number_format($localidade->numero_moradores, 0, ',', '.') }}</span>
                                <span class="text-sm">moradores</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('portal.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium hover:bg-gray-50 dark:hover:bg-slate-600 transition-all duration-300 shadow-md hover:shadow-lg border border-gray-200 dark:border-slate-600">
                        <x-icon name="arrow-left" style="duotone" class="w-4 h-4" />
                        <span class="hidden sm:inline">Voltar ao Portal</span>
                        <span class="sm:hidden">Voltar</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Estatísticas Resumidas -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
            <!-- Poços -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/30 rounded-xl p-4 md:p-6 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-500 dark:bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <x-icon module="pocos" class="w-5 h-5 md:w-6 md:h-6 text-white" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs md:text-sm text-blue-600 dark:text-blue-400 font-medium">Poços</p>
                        <p class="text-xl md:text-2xl font-bold text-blue-700 dark:text-blue-300">{{ count($infraestrutura['poços'] ?? []) }}</p>
                    </div>
                </div>
            </div>

            <!-- Pontos de Água -->
            <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-900/30 rounded-xl p-4 md:p-6 border border-cyan-200 dark:border-cyan-800">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-cyan-500 dark:bg-cyan-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <x-icon module="agua" class="w-5 h-5 md:w-6 md:h-6 text-white" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs md:text-sm text-cyan-600 dark:text-cyan-400 font-medium">Água</p>
                        <p class="text-xl md:text-2xl font-bold text-cyan-700 dark:text-cyan-300">{{ count($infraestrutura['pontos_agua'] ?? []) }}</p>
                    </div>
                </div>
            </div>

            <!-- Pontos de Luz -->
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-900/30 rounded-xl p-4 md:p-6 border border-amber-200 dark:border-amber-800">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-500 dark:bg-amber-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <x-icon module="iluminacao" class="w-5 h-5 md:w-6 md:h-6 text-white" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs md:text-sm text-amber-600 dark:text-amber-400 font-medium">Luz</p>
                        <p class="text-xl md:text-2xl font-bold text-amber-700 dark:text-amber-300">{{ count($infraestrutura['pontos_luz'] ?? []) }}</p>
                    </div>
                </div>
            </div>

            <!-- Estradas -->
            <div class="bg-gradient-to-br from-violet-50 to-violet-100 dark:from-violet-900/20 dark:to-violet-900/30 rounded-xl p-4 md:p-6 border border-violet-200 dark:border-violet-800">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-violet-500 dark:bg-violet-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <x-icon module="estradas" class="w-5 h-5 md:w-6 md:h-6 text-white" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs md:text-sm text-violet-600 dark:text-violet-400 font-medium">Estradas</p>
                        <p class="text-xl md:text-2xl font-bold text-violet-700 dark:text-violet-300">{{ count($infraestrutura['estradas'] ?? []) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Infraestrutura Detalhada -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <!-- Poços Artesianos -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 p-6 md:p-8 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-200 dark:border-slate-700">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon module="pocos" class="w-7 h-7 text-white" />
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl md:text-2xl font-bold font-poppins text-gray-900 dark:text-white">Poços Artesianos</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ count($infraestrutura['poços'] ?? []) }} poço(s) cadastrado(s)</p>
                    </div>
                </div>
                @if(!empty($infraestrutura['poços']))
                <div class="space-y-4">
                    @foreach($infraestrutura['poços'] as $poco)
                    <div class="group bg-gradient-to-br from-gray-50 to-blue-50/30 dark:from-slate-700/50 dark:to-slate-700/30 border border-gray-200 dark:border-slate-600 rounded-xl p-5 hover:shadow-md transition-all duration-300 hover:border-blue-300 dark:hover:border-blue-600">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1">{{ $poco['codigo'] }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
                                    <x-icon name="location-dot" style="duotone" class="w-4 h-4 mt-0.5 flex-shrink-0" />
                                    <span class="break-words">{{ $poco['endereco'] ?? 'N/A' }}</span>
                                </p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                                @if($poco['status'] === 'ativo') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300
                                @elseif($poco['status'] === 'manutencao') bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300
                                @endif">
                                {{ $poco['status_texto'] }}
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-3 mt-4">
                            @if($poco['vazao'])
                            <div class="flex items-center gap-2 text-sm">
                                <x-icon name="faucet-drip" style="duotone" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                <span class="text-gray-700 dark:text-gray-300"><strong>Vazão:</strong> {{ number_format($poco['vazao'], 2, ',', '.') }} L/h</span>
                            </div>
                            @endif
                            @if($poco['proxima_manutencao'])
                            <div class="flex items-center gap-2 text-sm">
                                <x-icon name="wrench" style="duotone" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                <span class="text-gray-700 dark:text-gray-300">Manutenção: {{ $poco['proxima_manutencao'] }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <div class="w-16 h-16 mx-auto mb-4 opacity-50">
                        <x-icon module="pocos" class="w-16 h-16" />
                    </div>
                    <p class="text-lg font-medium">Nenhum poço cadastrado</p>
                    <p class="text-sm mt-1">Não há poços artesianos cadastrados nesta localidade</p>
                </div>
                @endif
            </div>

            <!-- Pontos de Água -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 p-6 md:p-8 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-200 dark:border-slate-700">
                    <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-cyan-600 dark:from-cyan-600 dark:to-cyan-700 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon module="agua" class="w-7 h-7 text-white" />
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl md:text-2xl font-bold font-poppins text-gray-900 dark:text-white">Pontos de Distribuição de Água</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ count($infraestrutura['pontos_agua'] ?? []) }} ponto(s) cadastrado(s)</p>
                    </div>
                </div>
                @if(!empty($infraestrutura['pontos_agua']))
                <div class="space-y-4">
                    @foreach($infraestrutura['pontos_agua'] as $ponto)
                    <div class="group bg-gradient-to-br from-gray-50 to-cyan-50/30 dark:from-slate-700/50 dark:to-slate-700/30 border border-gray-200 dark:border-slate-600 rounded-xl p-5 hover:shadow-md transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1">{{ $ponto['codigo'] }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
                                    <x-icon name="location-dot" style="duotone" class="w-4 h-4 mt-0.5 flex-shrink-0" />
                                    <span class="break-words">{{ $ponto['endereco'] ?? 'N/A' }}</span>
                                </p>
                            </div>
                        </div>
                        @if($ponto['conexoes'])
                        <div class="flex items-center gap-2 text-sm mt-4">
                            <x-icon name="network-wired" style="duotone" class="w-4 h-4 text-cyan-600 dark:text-cyan-400" />
                            <span class="text-gray-700 dark:text-gray-300"><strong>Conexões:</strong> {{ $ponto['conexoes'] }}</span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <div class="w-16 h-16 mx-auto mb-4 opacity-50">
                        <x-icon module="agua" class="w-16 h-16" />
                    </div>
                    <p class="text-lg font-medium">Nenhum ponto cadastrado</p>
                    <p class="text-sm mt-1">Não há pontos de água cadastrados nesta localidade</p>
                </div>
                @endif
            </div>

            <!-- Pontos de Luz -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 p-6 md:p-8 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-200 dark:border-slate-700">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 dark:from-amber-600 dark:to-amber-700 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon module="iluminacao" class="w-7 h-7 text-white" />
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl md:text-2xl font-bold font-poppins text-gray-900 dark:text-white">Iluminação Pública</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ count($infraestrutura['pontos_luz'] ?? []) }} ponto(s) cadastrado(s)</p>
                    </div>
                </div>
                @if(!empty($infraestrutura['pontos_luz']))
                <div class="space-y-4">
                    @foreach($infraestrutura['pontos_luz'] as $ponto)
                    <div class="group bg-gradient-to-br from-gray-50 to-amber-50/30 dark:from-slate-700/50 dark:to-slate-700/30 border border-gray-200 dark:border-slate-600 rounded-xl p-5 hover:shadow-md transition-all duration-300 hover:border-amber-300 dark:hover:border-amber-600">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1">{{ $ponto['codigo'] }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-start gap-2">
                                    <x-icon name="location-dot" style="duotone" class="w-4 h-4 mt-0.5 flex-shrink-0" />
                                    <span class="break-words">{{ $ponto['endereco'] ?? 'N/A' }}</span>
                                </p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                                @if($ponto['status'] === 'funcionando') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300
                                @elseif($ponto['status'] === 'com_defeito') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300
                                @endif">
                                {{ $ponto['status_texto'] }}
                            </span>
                        </div>
                        @if($ponto['potencia'])
                        <div class="flex flex-wrap items-center gap-3 mt-4">
                            <div class="flex items-center gap-2 text-sm">
                                <x-icon name="bolt" style="duotone" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                <span class="text-gray-700 dark:text-gray-300"><strong>Potência:</strong> {{ $ponto['potencia'] }}W</span>
                            </div>
                            @if($ponto['tipo_lampada'])
                            <div class="flex items-center gap-2 text-sm">
                                <x-icon name="lightbulb" style="duotone" class="w-4 h-4 text-gray-500 dark:text-gray-400" />
                                <span class="text-gray-600 dark:text-gray-400">{{ $ponto['tipo_lampada'] }}</span>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <div class="w-16 h-16 mx-auto mb-4 opacity-50">
                        <x-icon module="iluminacao" class="w-16 h-16" />
                    </div>
                    <p class="text-lg font-medium">Nenhum ponto cadastrado</p>
                    <p class="text-sm mt-1">Não há pontos de luz cadastrados nesta localidade</p>
                </div>
                @endif
            </div>

            <!-- Estradas -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 p-6 md:p-8 hover:shadow-2xl transition-all duration-300 lg:col-span-2">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-200 dark:border-slate-700">
                    <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-violet-600 dark:from-violet-600 dark:to-violet-700 rounded-xl flex items-center justify-center shadow-lg">
                        <x-icon module="estradas" class="w-7 h-7 text-white" />
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl md:text-2xl font-bold font-poppins text-gray-900 dark:text-white">Estradas e Vicinais</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ count($infraestrutura['estradas'] ?? []) }} trecho(s) cadastrado(s)</p>
                    </div>
                </div>
                @if(!empty($infraestrutura['estradas']))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($infraestrutura['estradas'] as $estrada)
                    <div class="group bg-gradient-to-br from-gray-50 to-violet-50/30 dark:from-slate-700/50 dark:to-slate-700/30 border border-gray-200 dark:border-slate-600 rounded-xl p-5 hover:shadow-md transition-all duration-300 hover:border-violet-300 dark:hover:border-violet-600">
                        <div class="mb-3">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1">{{ $estrada['nome'] }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $estrada['codigo'] }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-4">
                            @if($estrada['extensao_km'])
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                <x-icon name="ruler" style="duotone" class="w-3 h-3" />
                                {{ number_format($estrada['extensao_km'], 2, ',', '.') }} km
                            </span>
                            @endif
                            @if($estrada['tipo_pavimento_texto'])
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300">
                                {{ $estrada['tipo_pavimento_texto'] }}
                            </span>
                            @endif
                            @if($estrada['condicao_texto'])
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                @if($estrada['condicao'] === 'boa') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300
                                @elseif($estrada['condicao'] === 'regular') bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300
                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                @endif">
                                {{ $estrada['condicao_texto'] }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <div class="w-16 h-16 mx-auto mb-4 opacity-50">
                        <x-icon module="estradas" class="w-16 h-16" />
                    </div>
                    <p class="text-lg font-medium">Nenhuma estrada cadastrada</p>
                    <p class="text-sm mt-1">Não há estradas cadastradas nesta localidade</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')
@endsection
