@extends('homepage::layouts.homepage')

@section('title', 'Status da Demanda - ' . ($demanda->codigo ?? 'N/A'))

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    Consulta Pública
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-3">
                    Status da Demanda
                </h1>
                <div class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-800 px-4 py-2 rounded-full">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    <span class="text-base text-gray-700 dark:text-gray-300">Protocolo:</span>
                    <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400 text-lg">{{ $demanda->codigo ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Indicador de Atualização em Tempo Real -->
            <div id="updateIndicator" class="mb-6 hidden items-center justify-center gap-2 text-sm bg-white dark:bg-slate-800 rounded-xl px-4 py-3 border-2 border-emerald-200 dark:border-emerald-800 shadow-sm">
                <svg class="w-4 h-4 animate-spin text-emerald-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-700 dark:text-gray-300 font-medium">Atualizando em tempo real...</span>
            </div>

            <!-- Card Principal -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border-2 border-gray-200 dark:border-slate-700 overflow-hidden mb-6" id="mainCard">
                <!-- Status Badge -->
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-8 py-6" id="statusHeader">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/80 text-sm mb-1">Status Atual</p>
                            <h2 class="text-2xl font-bold text-white" id="statusTexto">
                                {{ $demanda->status_texto }}
                            </h2>
                        </div>
                        <div class="text-right">
                            <p class="text-white/80 text-sm mb-1">Prioridade</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white" id="prioridadeBadge">
                                {{ $demanda->prioridade_texto }}
                            </span>
                        </div>
                    </div>
                    @if(isset($estatisticas) && $estatisticas['dias_aberta'] !== null)
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <p class="text-white/80 text-sm">
                            <span class="font-semibold">{{ $estatisticas['dias_aberta'] }}</span> dia(s) desde a abertura
                        </p>
                    </div>
                    @endif
                </div>

                <div class="p-8">
                    <!-- Informações da Demanda -->
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-gray-50 to-white dark:from-slate-700/50 dark:to-slate-700 rounded-xl p-6 border border-gray-200 dark:border-slate-600">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                Informações da Demanda
                            </h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white font-semibold">{{ $demanda->tipo_texto }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Solicitante</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white">
                                        @php
                                            use App\Helpers\LgpdHelper;
                                            $nomeSolicitante = $demanda->solicitante_nome ?? 'N/A';
                                            // Mascarar nome para proteção LGPD em consulta pública
                                            $nomeMascarado = LgpdHelper::maskName($nomeSolicitante);
                                        @endphp
                                        {{ $nomeMascarado }}
                                    </dd>
                                </div>
                                @if($demanda->localidade)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Localidade</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $demanda->localidade->nome }}</dd>
                                </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Abertura</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white">
                                        {{ $demanda->data_abertura ? $demanda->data_abertura->format('d/m/Y H:i') : 'N/A' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="bg-gradient-to-br from-gray-50 to-white dark:from-slate-700/50 dark:to-slate-700 rounded-xl p-6 border border-gray-200 dark:border-slate-600">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                Detalhes da Solicitação
                            </h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Motivo da Demanda</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white leading-relaxed">{{ $demanda->motivo }}</dd>
                                </div>
                                @if($demanda->data_conclusao)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Conclusão</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white">
                                        {{ $demanda->data_conclusao->format('d/m/Y H:i') }}
                                    </dd>
                                </div>
                                @endif
                                @php
                                    $diasAberta = $demanda->diasAberta();
                                @endphp
                                @if($diasAberta !== null && $diasAberta > 0)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tempo Aberta</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white">
                                        {{ $diasAberta }} dia(s)
                                    </dd>
                                </div>
                                @endif
                                @if($demanda->total_interessados && $demanda->total_interessados > 1)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pessoas Afetadas</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white flex items-center gap-2">
                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-sm font-bold">
                                            {{ $demanda->total_interessados }}
                                        </span>
                                        <span>pessoas reportaram esta mesma demanda</span>
                                    </dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Pessoas Relacionadas (Interessados) -->
                    @php
                        $interessados = $demanda->interessados()->with('pessoa')->get();
                        $totalInteressados = $interessados->count();
                    @endphp
                    @if($totalInteressados > 0)
                    <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-8 mt-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            Pessoas Relacionadas
                            <span class="ml-auto text-sm font-normal text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                                {{ $totalInteressados }} {{ $totalInteressados === 1 ? 'pessoa' : 'pessoas' }}
                            </span>
                        </h3>

                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl p-6 border-2 border-amber-200 dark:border-amber-800">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                <svg class="w-4 h-4 inline mr-1 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                Pessoas que reportaram ou estão afetadas por esta mesma demanda. Dados protegidos conforme LGPD.
                            </p>

                            <div class="grid gap-3">
                                @foreach($interessados as $index => $interessado)
                                <div class="flex items-center gap-4 p-4 bg-white dark:bg-slate-700 rounded-lg border border-amber-200 dark:border-amber-700">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                            {{ LgpdHelper::maskName($interessado->nome) }}
                                            @if($interessado->apelido)
                                                <span class="text-gray-500 dark:text-gray-400 font-normal">({{ $interessado->apelido }})</span>
                                            @endif
                                        </p>
                                        <div class="flex items-center gap-3 mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            @if($interessado->metodo_vinculo === 'solicitante_original')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-full">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Solicitante Original
                                            </span>
                                            @else
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Vinculado em {{ $interessado->data_vinculo ? $interessado->data_vinculo->format('d/m/Y') : 'N/A' }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($interessado->confirmado)
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-full text-xs font-medium">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Confirmado
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>

                            @if($totalInteressados > 1)
                            <div class="mt-4 pt-4 border-t border-amber-200 dark:border-amber-700">
                                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                    Demandas com múltiplas pessoas afetadas recebem prioridade maior no atendimento.
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Mapa da Localização -->
                    @if($demanda->localidade && $demanda->localidade->latitude && $demanda->localidade->longitude)
                    <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-8 mt-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                            </div>
                            Localização da Demanda
                        </h3>

                        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-xl p-4 border-2 border-indigo-200 dark:border-indigo-800">
                            <div class="mb-4 flex items-center justify-between">
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span class="font-medium">{{ $demanda->localidade->nome }}</span>
                                    @if($demanda->localidade->tipo)
                                    <span class="text-xs bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 px-2 py-0.5 rounded-full">
                                        {{ ucfirst($demanda->localidade->tipo) }}
                                    </span>
                                    @endif
                                </div>
                                <a href="https://www.google.com/maps?q={{ $demanda->localidade->latitude }},{{ $demanda->localidade->longitude }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                    Abrir no Google Maps
                                </a>
                            </div>
                            <div id="demanda-map-container" class="w-full h-64 md:h-80 rounded-lg border border-indigo-200 dark:border-indigo-700 overflow-hidden bg-gray-100 dark:bg-gray-800"></div>
                        </div>
                    </div>
                    @endif

                    <!-- Ordem de Serviço -->
                    @if($demanda->ordemServico)
                    <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-8 mt-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            Ordem de Serviço
                        </h3>
                        @php
                            $os = $demanda->ordemServico;
                            $fotosAntes = $os->fotos_antes ?? [];
                            $fotosDepois = $os->fotos_depois ?? [];
                        @endphp
                        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl p-6 border-2 border-emerald-200 dark:border-emerald-800 space-y-6">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Número da OS</p>
                                    <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $os->numero ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($os->status === 'concluida') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300
                                        @elseif($os->status === 'em_execucao') bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300
                                        @elseif($os->status === 'pendente') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                        @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                        @endif" data-os-status>
                                        {{ $os->status_texto ?? ucfirst(str_replace('_', ' ', $os->status ?? 'N/A')) }}
                                    </span>
                                </div>
                                @if($os->equipe)
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Equipe Responsável</p>
                                    <p class="text-base text-gray-900 dark:text-white">{{ $os->equipe->nome ?? 'N/A' }}</p>
                                </div>
                                @endif
                                @if($os->usuarioExecucao)
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Executado por</p>
                                    <p class="text-base text-gray-900 dark:text-white">{{ $os->usuarioExecucao->name }}</p>
                                </div>
                                @endif
                                @if($os->data_inicio)
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Início</p>
                                    <p class="text-base text-gray-900 dark:text-white">{{ $os->data_inicio->format('d/m/Y H:i') }}</p>
                                </div>
                                @endif
                                @if($os->data_conclusao)
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Conclusão</p>
                                    <p class="text-base text-gray-900 dark:text-white" id="osDataConclusao">{{ $os->data_conclusao->format('d/m/Y H:i') }}</p>
                                </div>
                                @endif
                                @if($os->tempo_execucao_formatado)
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tempo de Execução</p>
                                    <p class="text-base text-gray-900 dark:text-white">{{ $os->tempo_execucao_formatado }}</p>
                                </div>
                                @endif
                            </div>

                            @if($os->relatorio_execucao)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-600">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Relatório de Execução</p>
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $os->relatorio_execucao }}</p>
                            </div>
                            @endif

                            @if(!empty($fotosAntes))
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-600">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Fotos Antes</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($fotosAntes as $foto)
                                        <a href="{{ asset('storage/' . $foto) }}" target="_blank" class="block">
                                            <img src="{{ asset('storage/' . $foto) }}" alt="Foto antes" class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600 hover:opacity-80 transition-opacity">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if(!empty($fotosDepois))
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-600">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Fotos Depois</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($fotosDepois as $foto)
                                        <a href="{{ asset('storage/' . $foto) }}" target="_blank" class="block">
                                            <img src="{{ asset('storage/' . $foto) }}" alt="Foto depois" class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600 hover:opacity-80 transition-opacity">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($os->observacoes)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-600">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Observações</p>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $os->observacoes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                            <div class="flex items-start">
                                <x-icon name="information-circle" class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 mr-3 flex-shrink-0" />
                                <div>
                                    <p class="text-sm font-medium text-amber-800 dark:text-amber-200">Aguardando Ordem de Serviço</p>
                                    <p class="text-sm text-amber-700 dark:text-amber-300 mt-1">Sua demanda ainda não possui uma ordem de serviço associada. Ela será criada em breve.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- QR Code para Compartilhamento -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border-2 border-gray-200 dark:border-slate-700 p-8 mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                        </svg>
                    </div>
                    Compartilhar Demanda
                </h3>
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="flex-shrink-0">
                        <canvas id="qrcode-public-canvas" class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-2 bg-white"></canvas>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            Escaneie o QR Code para compartilhar ou salvar o link de consulta
                        </p>
                        <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                            <button onclick="copiarLink()" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm font-medium">
                                <x-icon name="clipboard" class="w-4 h-4" />
                                Copiar Link
                            </button>
                            <a href="whatsapp://send?text={{ urlencode('Acompanhe minha demanda: ' . route('demandas.public.show', ['codigo' => $demanda->codigo])) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                <x-icon name="chat-bubble-left-right" class="w-4 h-4" />
                                Compartilhar no WhatsApp
                            </a>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-3 font-mono break-all">
                            {{ route('demandas.public.show', ['codigo' => $demanda->codigo]) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border-2 border-gray-200 dark:border-slate-700 p-8 mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Acompanhamento da Demanda
                </h3>

                <div class="relative">
                    @php
                        // Determinar as etapas e seus estados
                        $etapas = [
                            [
                                'titulo' => 'Demanda Registrada',
                                'descricao' => 'Sua solicitação foi registrada no sistema.',
                                'data' => $demanda->data_abertura,
                                'concluida' => true,
                                'cor' => 'emerald',
                                'icone' => 'check-circle'
                            ]
                        ];

                        // Etapa 2: Ordem de Serviço criada
                        if ($demanda->ordemServico) {
                            $etapas[] = [
                                'titulo' => 'Ordem de Serviço Criada',
                                'descricao' => 'Uma equipe foi designada para atender sua demanda.',
                                'data' => $demanda->ordemServico->data_abertura ?? $demanda->ordemServico->created_at,
                                'concluida' => true,
                                'cor' => 'blue',
                                'icone' => 'document-text'
                            ];

                            // Etapa 3: Atendimento Iniciado
                            if ($demanda->ordemServico->data_inicio) {
                                $etapas[] = [
                                    'titulo' => 'Atendimento Iniciado',
                                    'descricao' => 'A equipe iniciou o atendimento no local.',
                                    'data' => $demanda->ordemServico->data_inicio,
                                    'concluida' => true,
                                    'cor' => 'amber',
                                    'icone' => 'arrow-right-circle'
                                ];
                            }

                            // Etapa 4: Serviço Concluído
                            if ($demanda->ordemServico->status === 'concluida' && $demanda->ordemServico->data_conclusao) {
                                $tempoExecucao = null;
                                if ($demanda->ordemServico->data_inicio && $demanda->ordemServico->data_conclusao) {
                                    $minutos = $demanda->ordemServico->data_inicio->diffInMinutes($demanda->ordemServico->data_conclusao);
                                    if ($minutos > 0) {
                                        $horas = floor($minutos / 60);
                                        $mins = $minutos % 60;
                                        $tempoExecucao = $horas > 0 ? "{$horas}h {$mins}min" : "{$mins} minutos";
                                    }
                                }

                                $etapas[] = [
                                    'titulo' => 'Serviço Concluído',
                                    'descricao' => 'O serviço foi finalizado com sucesso.' . ($tempoExecucao ? " Tempo de execução: {$tempoExecucao}." : ''),
                                    'data' => $demanda->ordemServico->data_conclusao,
                                    'concluida' => true,
                                    'cor' => 'emerald',
                                    'icone' => 'check-circle'
                                ];
                            }
                        }

                        // Se a demanda foi cancelada
                        if ($demanda->status === 'cancelada') {
                            $etapas[] = [
                                'titulo' => 'Demanda Cancelada',
                                'descricao' => $demanda->observacoes ?? 'Esta demanda foi cancelada.',
                                'data' => $demanda->data_conclusao ?? $demanda->updated_at,
                                'concluida' => true,
                                'cor' => 'red',
                                'icone' => 'x-circle'
                            ];
                        }

                        // Se ainda não tem OS mas está em andamento, mostrar etapa pendente
                        if (!$demanda->ordemServico && $demanda->status === 'em_andamento') {
                            $etapas[] = [
                                'titulo' => 'Aguardando Atendimento',
                                'descricao' => 'Sua demanda está na fila para atendimento.',
                                'data' => null,
                                'concluida' => false,
                                'cor' => 'gray',
                                'icone' => 'clock'
                            ];
                        }
                    @endphp

                    @foreach($etapas as $index => $etapa)
                    <div class="relative {{ !$loop->last ? 'pb-8' : '' }}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $etapa['concluida'] ? 'bg-' . $etapa['cor'] . '-500' : 'bg-gray-300 dark:bg-gray-600' }} text-white">
                                    <x-icon name="{{ $etapa['icone'] }}" class="w-6 h-6" />
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between flex-wrap gap-2">
                                    <h4 class="text-base font-semibold {{ $etapa['concluida'] ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ $etapa['titulo'] }}
                                    </h4>
                                    @if($etapa['data'])
                                    <time class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $etapa['data']->format('d/m/Y \à\s H:i') }}
                                    </time>
                                    @else
                                    <span class="text-sm text-gray-400 dark:text-gray-500 italic">Aguardando</span>
                                    @endif
                                </div>
                                <p class="mt-1 text-sm {{ $etapa['concluida'] ? 'text-gray-600 dark:text-gray-300' : 'text-gray-400 dark:text-gray-500' }}">
                                    {{ $etapa['descricao'] }}
                                </p>
                            </div>
                        </div>
                        @if(!$loop->last)
                        <div class="absolute left-5 top-10 bottom-0 w-0.5 {{ $etapas[$index + 1]['concluida'] ?? false ? 'bg-' . ($etapas[$index + 1]['cor'] ?? 'gray') . '-300' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Ações -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('demandas.public.consulta') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white dark:bg-slate-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    <x-icon name="arrow-left" class="w-4 h-4" />
                    Nova Consulta
                </a>
                <a href="{{ route('homepage') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition-colors">
                    <x-icon name="home" class="w-4 h-4" />
                    Página Inicial
                </a>
            </div>
        </div>
    </div>
</div>

@include('homepage::layouts.footer-homepage')

@push('scripts')
<script>
    const demandaCodigo = '{{ $demanda->codigo }}';
    const statusUrl = '{{ route('demandas.public.status', ['codigo' => $demanda->codigo]) }}';
    let lastUpdateTime = '{{ $demanda->updated_at->toIso8601String() }}';
    let pollingInterval = null;
    let isPolling = false;

    // Dados do mapa
    @if($demanda->localidade && $demanda->localidade->latitude && $demanda->localidade->longitude)
    const mapData = {
        lat: {{ $demanda->localidade->latitude }},
        lng: {{ $demanda->localidade->longitude }},
        nome: '{{ addslashes($demanda->localidade->nome) }}',
        tipo: '{{ $demanda->tipo_texto }}',
        codigo: '{{ $demanda->codigo }}'
    };
    @else
    const mapData = null;
    @endif

    // Gerar QR Code quando a página carregar
    document.addEventListener('DOMContentLoaded', function() {
        const qrCodeUrl = '{{ route('demandas.public.show', ['codigo' => $demanda->codigo]) }}';

        if (window.generateQRCode) {
            window.generateQRCode(qrCodeUrl, 'qrcode-public-canvas', {
                width: 200,
                margin: 2,
                color: {
                    dark: '#000000',
                    light: '#FFFFFF'
                }
            }).catch(function(error) {
                console.error('Erro ao gerar QR Code:', error);
            });
        }

        // Inicializar mapa se houver dados de localização
        if (mapData) {
            initDemandaMap();
        }

        // Iniciar atualização em tempo real
        iniciarAtualizacaoTempoReal();
    });

    // Função para inicializar o mapa da demanda
    function initDemandaMap() {
        const mapContainer = document.getElementById('demanda-map-container');
        if (!mapContainer || !mapData) return;

        // Tentar usar Leaflet se disponível, senão usar iframe do OpenStreetMap
        let attempts = 0;
        const maxAttempts = 50; // 5 segundos

        const tryInitMap = () => {
            if (typeof window.L !== 'undefined') {
                // Usar Leaflet
                const map = window.L.map('demanda-map-container', {
                    center: [mapData.lat, mapData.lng],
                    zoom: 15,
                    scrollWheelZoom: false
                });

                // Adicionar camada de tiles
                window.L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Criar ícone personalizado
                const customIcon = window.L.divIcon({
                    className: 'custom-map-marker',
                    html: `<div style="background: linear-gradient(135deg, #10b981, #059669); width: 32px; height: 32px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                        <div style="transform: rotate(45deg); display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
                            <svg style="width: 16px; height: 16px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                });

                // Adicionar marcador
                const marker = window.L.marker([mapData.lat, mapData.lng], { icon: customIcon }).addTo(map);

                // Popup com informações
                const popupContent = `
                    <div style="min-width: 200px; padding: 8px;">
                        <h4 style="font-weight: bold; margin: 0 0 8px 0; color: #1f2937;">${mapData.nome}</h4>
                        <p style="margin: 4px 0; font-size: 13px; color: #6b7280;">
                            <strong>Demanda:</strong> ${mapData.codigo}
                        </p>
                        <p style="margin: 4px 0; font-size: 13px; color: #6b7280;">
                            <strong>Tipo:</strong> ${mapData.tipo}
                        </p>
                        <a href="https://www.google.com/maps?q=${mapData.lat},${mapData.lng}"
                           target="_blank"
                           style="display: inline-block; margin-top: 8px; padding: 4px 12px; background: #4f46e5; color: white; border-radius: 4px; text-decoration: none; font-size: 12px;">
                            Ver no Google Maps
                        </a>
                    </div>
                `;
                marker.bindPopup(popupContent);

                // Invalidar tamanho após renderização
                setTimeout(() => map.invalidateSize(), 100);

            } else if (attempts < maxAttempts) {
                attempts++;
                setTimeout(tryInitMap, 100);
            } else {
                // Fallback: usar iframe do OpenStreetMap
                mapContainer.innerHTML = `
                    <iframe
                        width="100%"
                        height="100%"
                        frameborder="0"
                        scrolling="no"
                        marginheight="0"
                        marginwidth="0"
                        src="https://www.openstreetmap.org/export/embed.html?bbox=${mapData.lng - 0.01}%2C${mapData.lat - 0.01}%2C${mapData.lng + 0.01}%2C${mapData.lat + 0.01}&layer=mapnik&marker=${mapData.lat}%2C${mapData.lng}"
                        style="border: 0; border-radius: 8px;">
                    </iframe>
                `;
            }
        };

        tryInitMap();
    }

    // Função para iniciar atualização em tempo real
    function iniciarAtualizacaoTempoReal() {
        if (isPolling) return;

        isPolling = true;

        // Atualizar a cada 30 segundos
        pollingInterval = setInterval(function() {
            atualizarStatus();
        }, 30000);

        // Primeira atualização após 5 segundos
        setTimeout(function() {
            atualizarStatus();
        }, 5000);
    }

    // Função para atualizar status
    async function atualizarStatus() {
        const indicator = document.getElementById('updateIndicator');

        // Mostrar indicador durante a atualização
        if (indicator) {
            indicator.style.display = 'flex';
            indicator.style.opacity = '1';
            indicator.innerHTML = `
                <svg class="w-4 h-4 animate-spin text-emerald-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-700 dark:text-gray-300 font-medium">Atualizando em tempo real...</span>
            `;
        }

        try {
            const response = await fetch(statusUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('Erro ao buscar status');
            }

            const data = await response.json();

            // Verificar se houve atualização
            if (data.updated_at !== lastUpdateTime) {
                const statusAtual = '{{ $demanda->status }}';
                const novoStatus = data.status;

                // Se o status mudou para concluída ou cancelada, recarregar página para mostrar dados completos
                if (statusAtual !== novoStatus && (novoStatus === 'concluida' || novoStatus === 'cancelada')) {
                    mostrarNotificacaoAtualizacao('Status atualizado! Recarregando...');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                    return;
                }

                // Se a OS foi concluída, recarregar para mostrar relatório e fotos
                if (data.os_status === 'concluida' && data.os_status !== '{{ $demanda->ordemServico?->status ?? '' }}') {
                    mostrarNotificacaoAtualizacao('Ordem de Serviço concluída! Recarregando...');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                    return;
                }

                lastUpdateTime = data.updated_at;

                // Atualizar status
                const statusTexto = document.getElementById('statusTexto');
                if (statusTexto && data.status_texto) {
                    statusTexto.textContent = data.status_texto;
                }

                // Atualizar badge de status no header
                atualizarBadgeStatus(data.status);

                // Atualizar informações da OS se houver mudança
                if (data.tem_os && data.os_status) {
                    atualizarInfoOS(data);
                }

                // Atualizar dias abertos
                if (data.dias_aberta !== null) {
                    atualizarDiasAberta(data.dias_aberta);
                }

                // Mostrar notificação de atualização
                mostrarNotificacaoAtualizacao();
            }

            // Atualizar indicador
            atualizarIndicador(false);

        } catch (error) {
            console.error('Erro ao atualizar status:', error);
            atualizarIndicador(true);
        }
    }

    // Atualizar badge de status
    function atualizarBadgeStatus(status) {
        const statusHeader = document.getElementById('statusHeader');
        if (!statusHeader) return;

        const cores = {
            'aberta': 'from-blue-500 to-blue-600',
            'em_andamento': 'from-amber-500 to-amber-600',
            'concluida': 'from-emerald-500 to-teal-600',
            'cancelada': 'from-red-500 to-red-600'
        };

        const cor = cores[status] || 'from-emerald-500 to-teal-600';
        statusHeader.className = `bg-gradient-to-r ${cor} px-8 py-6`;
    }

    // Atualizar informações da OS
    function atualizarInfoOS(data) {
        // Atualizar status da OS se existir elemento
        const osStatusElement = document.querySelector('[data-os-status]');
        if (osStatusElement && data.os_status_texto) {
            osStatusElement.textContent = data.os_status_texto;

            // Atualizar cor do badge
            const cores = {
                'pendente': 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                'em_execucao': 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                'concluida': 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                'cancelada': 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'
            };
            osStatusElement.className = `inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${cores[data.os_status] || cores['pendente']}`;
        }
    }

    // Atualizar dias abertos
    function atualizarDiasAberta(dias) {
        const diasElement = document.querySelector('[data-dias-aberta]');
        if (diasElement) {
            diasElement.textContent = `${dias} dia(s) desde a abertura`;
        }
    }

    // Atualizar indicador visual
    function atualizarIndicador(erro) {
        const indicator = document.getElementById('updateIndicator');
        if (!indicator) return;

        if (erro) {
            indicator.innerHTML = `
                <svg class="w-4 h-4 text-red-500 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-red-600 dark:text-red-400 font-medium">Erro ao atualizar. Tentando novamente...</span>
            `;
            indicator.style.display = 'flex';
            indicator.style.opacity = '1';
        } else {
            indicator.innerHTML = `
                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-emerald-600 dark:text-emerald-400 font-medium">Atualizado em tempo real</span>
            `;

            // Ocultar após 2 segundos
            setTimeout(function() {
                indicator.style.transition = 'opacity 0.3s ease-out';
                indicator.style.opacity = '0';
                setTimeout(function() {
                    indicator.style.display = 'none';
                }, 300);
            }, 2000);
        }
    }

    // Mostrar notificação de atualização
    function mostrarNotificacaoAtualizacao(mensagem = 'Status atualizado!') {
        // Criar notificação toast
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-emerald-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2 animate-slide-in';
        toast.innerHTML = `
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>${mensagem}</span>
        `;

        document.body.appendChild(toast);

        setTimeout(function() {
            toast.style.opacity = '0';
            setTimeout(function() {
                toast.remove();
            }, 300);
        }, 3000);
    }

    // Parar polling quando a página não estiver visível
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
                isPolling = false;
            }
        } else {
            if (!isPolling) {
                iniciarAtualizacaoTempoReal();
            }
        }
    });

    // Função para copiar link
    function copiarLink() {
        const link = '{{ route('demandas.public.show', ['codigo' => $demanda->codigo]) }}';
        navigator.clipboard.writeText(link).then(function() {
            // Mostrar feedback visual
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Copiado!';
            button.classList.add('bg-green-600');
            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-600');
            }, 2000);
        }).catch(function(err) {
            console.error('Erro ao copiar:', err);
            alert('Erro ao copiar link. Por favor, copie manualmente.');
        });
    }
</script>
<style>
@keyframes slide-in {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
.animate-slide-in {
    animation: slide-in 0.3s ease-out;
}
</style>
@endpush
@endsection

