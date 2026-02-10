@extends('homepage::layouts.homepage')

@section('title', 'Status da Demanda - ' . ($demanda->codigo ?? 'N/A'))

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <x-icon name="magnifying-glass-chart" style="duotone" class="w-4 h-4" />
                    Resultado da Consulta
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4 font-poppins">
                    Acompanhamento de Demanda
                </h1>
                <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Confira abaixo os detalhes e o andamento atualizado da sua solicitação.
                </p>
            </div>

            <!-- Status Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border-2 border-emerald-100 dark:border-emerald-900/50 overflow-hidden mb-8 transition-transform hover:shadow-2xl">
                <!-- Status Header Gradient -->
                <div id="statusHeader" class="bg-gradient-to-r {{
                    match($demanda->status) {
                        'concluida' => 'from-emerald-500 to-teal-600',
                        'cancelada' => 'from-red-500 to-red-600',
                        'em_andamento' => 'from-amber-500 to-orange-600',
                        default => 'from-blue-500 to-indigo-600' // aberta/pendente
                    }
                }} px-6 py-6 md:px-8 md:py-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-bl-full pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium mb-1 uppercase tracking-wider">Protocolo</p>
                            <h2 class="text-2xl md:text-3xl font-bold font-mono tracking-wide">{{ $demanda->codigo }}</h2>
                        </div>
                        <div class="flex items-center gap-3 bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20">
                            <x-icon name="{{
                                match($demanda->status) {
                                    'concluida' => 'circle-check',
                                    'cancelada' => 'circle-xmark',
                                    'em_andamento' => 'clock',
                                    default => 'circle-exclamation'
                                }
                            }}" class="w-6 h-6 animate-pulse" />
                            <div class="text-left">
                                <p class="text-xs text-white/80 uppercase font-bold">Status Atual</p>
                                <p class="text-lg font-bold" id="statusTexto">{{ $demanda->status_texto }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalhes -->
                <div class="p-6 md:p-8">
                    <!-- Mapa (se houver) -->
                    @if($demanda->localidade && $demanda->localidade->latitude)
                    <div class="w-full h-64 rounded-xl mb-8 border-2 border-gray-100 dark:border-gray-700 shadow-inner overflow-hidden z-0">
                         <x-maps.google
                            :lat="$demanda->localidade->latitude"
                            :lng="$demanda->localidade->longitude"
                            height="100%"
                            zoom="16"
                            id="demanda-map-{{ $demanda->id }}"
                            class="w-full h-full"
                        />
                    </div>
                    @endif

                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                                <x-icon name="user" style="duotone" class="w-5 h-5 text-gray-500" />
                                Dados do Solicitante
                            </h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome</dt>
                                    <dd class="mt-1 text-base font-medium text-gray-900 dark:text-white">{{ $demanda->nome_solicitante ?? 'Anônimo' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Abertura</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white flex items-center gap-2">
                                        <x-icon name="calendar" style="duotone" class="w-4 h-4 text-gray-400" />
                                        {{ $demanda->data_abertura->format('d/m/Y \à\s H:i') }}
                                    </dd>
                                </div>
                                @if($demanda->bairro)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Localidade/Bairro</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $demanda->bairro }}</dd>
                                </div>
                                @endif
                                @if($demanda->tipo)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo de Solicitação</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ $demanda->tipo_texto }}
                                        </span>
                                    </dd>
                                </div>
                                @endif
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                                <x-icon name="file-lines" style="duotone" class="w-5 h-5 text-gray-500" />
                                Detalhes da Solicitação
                            </h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Descrição do Pedido</dt>
                                    <dd class="mt-1 text-base text-gray-900 dark:text-white leading-relaxed bg-gray-50 dark:bg-slate-700/50 p-3 rounded-lg border border-gray-100 dark:border-slate-600">
                                        {{ $demanda->motivo }}
                                    </dd>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    @if($demanda->data_conclusao)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Conclusão</dt>
                                        <dd class="mt-1 text-base text-emerald-600 dark:text-emerald-400 font-medium">
                                            {{ $demanda->data_conclusao->format('d/m/Y H:i') }}
                                        </dd>
                                    </div>
                                    @endif

                                    @php $diasAberta = $demanda->diasAberta(); @endphp
                                    @if($diasAberta !== null && $diasAberta > 0)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tempo Decorrido</dt>
                                        <dd class="mt-1 text-base text-gray-900 dark:text-white">
                                            {{ $diasAberta }} dia(s)
                                        </dd>
                                    </div>
                                    @endif
                                </div>

                                @if($demanda->total_interessados && $demanda->total_interessados > 1)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Impacto Social</dt>
                                    <dd class="mt-1 flex items-center gap-2">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 font-bold text-sm ring-2 ring-amber-50 dark:ring-amber-900/10">
                                            {{ $demanda->total_interessados }}
                                        </span>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">pessoas aguardam esta solução</span>
                                    </dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ordem de Serviço Card -->
            @php
                $os = $demanda->ordemServico;
                $temOS = !empty($os);
            @endphp

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border-2 border-gray-200 dark:border-slate-700 p-6 md:p-8 mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <x-icon name="screwdriver-wrench" style="duotone" class="w-5 h-5" />
                    </div>
                    Execução do Serviço
                </h3>

                @if($temOS)
                    @php
                        $fotosAntes = $os->fotos_antes ?? [];
                        $fotosDepois = $os->fotos_depois ?? [];
                    @endphp
                    <div class="bg-slate-50 dark:bg-slate-700/30 rounded-xl p-6 border border-slate-200 dark:border-slate-600 space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Coluna 1: Info OS -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Status da OS</p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            @if($os->status === 'concluida') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300
                                            @elseif($os->status === 'em_execucao') bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300
                                            @elseif($os->status === 'pendente') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                            @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                            @endif" data-os-status>
                                            {{ $os->status_texto ?? ucfirst(str_replace('_', ' ', $os->status ?? 'N/A')) }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Número OS</p>
                                        <p class="font-mono font-medium text-gray-700 dark:text-gray-300">#{{ $os->numero ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    @if($os->data_inicio)
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Início</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $os->data_inicio->format('d/m H:i') }}</p>
                                    </div>
                                    @endif
                                    @if($os->data_conclusao)
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Conclusão</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $os->data_conclusao->format('d/m H:i') }}</p>
                                    </div>
                                    @endif
                                </div>

                                @if($os->equipe)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Equipe Técnica</p>
                                    <div class="flex items-center gap-2">
                                        <x-icon name="helmet-safety" style="duotone" class="w-4 h-4 text-indigo-500" />
                                        <span class="text-sm text-gray-900 dark:text-white">{{ $os->equipe->nome ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Coluna 2: Relatório -->
                            @if($os->relatorio_execucao)
                            <div class="bg-white dark:bg-slate-700/50 p-4 rounded-lg border border-slate-200 dark:border-slate-600 h-full">
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-2 flex items-center gap-2">
                                    <x-icon name="clipboard-check" style="duotone" class="w-4 h-4" />
                                    Relatório Técnico
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed max-h-40 overflow-y-auto pr-2 custom-scrollbar">
                                    {{ $os->relatorio_execucao }}
                                </p>
                            </div>
                            @endif
                        </div>

                        <!-- Galeria de Fotos -->
                        @if(!empty($fotosAntes) || !empty($fotosDepois))
                        <div class="grid md:grid-cols-2 gap-6 pt-4 border-t border-slate-200 dark:border-slate-600">
                            @if(!empty($fotosAntes))
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Antes
                                </h4>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach(array_slice($fotosAntes, 0, 4) as $foto)
                                        <a href="{{ Storage::url($foto) }}" target="_blank" class="group relative aspect-video overflow-hidden rounded-lg bg-gray-200">
                                            <img src="{{ Storage::url($foto) }}" alt="Antes" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if(!empty($fotosDepois))
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Depois
                                </h4>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach(array_slice($fotosDepois, 0, 4) as $foto)
                                        <a href="{{ Storage::url($foto) }}" target="_blank" class="group relative aspect-video overflow-hidden rounded-lg bg-gray-200">
                                            <img src="{{ Storage::url($foto) }}" alt="Depois" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                @else
                    <!-- Estado Vazio (Sem OS) -->
                    <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-400 p-4 rounded-r-lg">
                        <div class="flex items-start gap-4">
                            <x-icon name="hourglass-start" style="duotone" class="w-6 h-6 text-amber-500 mt-1 flex-shrink-0" />
                            <div>
                                <h4 class="text-base font-bold text-amber-800 dark:text-amber-100">Aguardando Análise Técnica</h4>
                                <p class="text-sm text-amber-700 dark:text-amber-200 mt-1">
                                    Sua solicitação foi recebida e está na fila para triagem. Em breve uma Ordem de Serviço será gerada e uma equipe será designada.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Timeline Vertical -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border-2 border-gray-200 dark:border-slate-700 p-6 md:p-8 mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center text-purple-600 dark:text-purple-400">
                        <x-icon name="timeline" style="duotone" class="w-5 h-5" />
                    </div>
                    Linha do Tempo
                </h3>

                <div class="relative pl-4">
                    @php
                        // Construção da Linha do Tempo
                        $etapas = [];

                        // 1. Abertura
                        $etapas[] = [
                            'titulo' => 'Solicitação Registrada',
                            'descricao' => 'Protocolo gerado e aguardando triagem.',
                            'data' => $demanda->data_abertura,
                            'status' => 'concluido',
                            'cor' => 'emerald',
                            'icone' => 'file-circle-check'
                        ];

                        // 2. OS Criada
                        if ($temOS) {
                            $etapas[] = [
                                'titulo' => 'Ordem de Serviço Emitida',
                                'descricao' => "Equipe designada (#{$os->numero}).",
                                'data' => $os->created_at,
                                'status' => 'concluido',
                                'cor' => 'blue',
                                'icone' => 'file-contract'
                            ];

                            // 3. Em execução
                            if ($os->status === 'em_execucao' || $os->data_inicio) {
                                $etapas[] = [
                                    'titulo' => 'Execução Iniciada',
                                    'descricao' => 'Equipe técnica iniciou os trabalhos.',
                                    'data' => $os->data_inicio,
                                    'status' => 'concluido',
                                    'cor' => 'amber',
                                    'icone' => 'person-digging'
                                ];
                            }

                            // 4. Conclusão
                            if ($os->status === 'concluida' && $os->data_conclusao) {
                                $etapas[] = [
                                    'titulo' => 'Serviço Finalizado',
                                    'descricao' => 'Demanda atendida com sucesso.',
                                    'data' => $os->data_conclusao,
                                    'status' => 'concluido',
                                    'cor' => 'emerald', // Final green
                                    'icone' => 'flag-checkered'
                                ];
                            }
                        }

                        // Cancelamento
                        if ($demanda->status === 'cancelada') {
                            $etapas[] = [
                                'titulo' => 'Solicitação Cancelada',
                                'descricao' => $demanda->observacoes ?? 'Motivo não informado.',
                                'data' => $demanda->updated_at,
                                'status' => 'erro',
                                'cor' => 'red',
                                'icone' => 'ban'
                            ];
                        }
                    @endphp

                    @foreach($etapas as $index => $etapa)
                        <div class="relative pb-8 last:pb-0">
                            <!-- Linha conectora -->
                            @if(!$loop->last)
                            <div class="absolute left-5 top-10 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                            @endif

                            <div class="flex items-start gap-4">
                                <!-- Ícone da etapa -->
                                <div class="relative z-10 flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full border-4 border-white dark:border-slate-800 shadow-md bg-{{ $etapa['cor'] }}-100 dark:bg-{{ $etapa['cor'] }}-900/50 text-{{ $etapa['cor'] }}-600 dark:text-{{ $etapa['cor'] }}-400">
                                    <x-icon name="{{ $etapa['icone'] }}" style="duotone" class="w-5 h-5" />
                                </div>

                                <div class="flex-1 pt-1">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
                                        <h4 class="text-base font-bold text-gray-900 dark:text-white">{{ $etapa['titulo'] }}</h4>
                                        @if($etapa['data'])
                                        <time class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-full whitespace-nowrap">
                                            {{ $etapa['data']->format('d/m/Y H:i') }}
                                        </time>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $etapa['descricao'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Share & Actions -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- QR Code Box -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-6 flex flex-col items-center text-center">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <x-icon name="qrcode" style="duotone" class="w-4 h-4 text-emerald-500" />
                        Acesso Rápido
                    </h4>
                    <div class="bg-white p-2 rounded-lg border border-gray-100 shadow-sm mb-4">
                        <canvas id="qrcode-public-canvas" class="w-32 h-32"></canvas>
                    </div>
                    <p class="text-xs text-gray-500 mb-4 px-4">Escaneie para acessar o status desta demanda no seu celular</p>
                    <div class="flex gap-2 w-full">
                        <button onclick="copiarLink()" class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-lg text-xs font-medium transition-colors text-gray-700 dark:text-gray-300">
                            <x-icon name="copy" class="w-3 h-3" /> Copiar Link
                        </button>
                    </div>
                </div>

                <!-- Navigation Box -->
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 flex flex-col justify-center items-center text-center text-white">
                    <h4 class="text-lg font-bold mb-2">Precisa de mais alguma coisa?</h4>
                    <p class="text-emerald-50 text-sm mb-6 max-w-xs">Retorne à página inicial ou realize uma nova consulta.</p>

                    <div class="flex flex-col w-full gap-3">
                        <a href="{{ route('demandas.public.consulta') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white text-emerald-600 rounded-xl font-bold hover:bg-emerald-50 transition-colors shadow-md">
                            <x-icon name="magnifying-glass" class="w-4 h-4" />
                            Nova Consulta
                        </a>
                        <a href="{{ route('homepage') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-emerald-700/50 text-white rounded-xl font-bold hover:bg-emerald-700 transition-colors">
                            <x-icon name="house" class="w-4 h-4" />
                            Voltar ao Início
                        </a>
                    </div>
                </div>
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

    // Dados para o mapa
    @if($demanda->localidade && $demanda->localidade->latitude)
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

    document.addEventListener('DOMContentLoaded', function() {
        // QR Code
        const qrCodeUrl = '{{ route('demandas.public.show', ['codigo' => $demanda->codigo]) }}';
        if (window.generateQRCode) {
            window.generateQRCode(qrCodeUrl, 'qrcode-public-canvas', {
                width: 150,
                margin: 0,
                color: { dark: '#111827', light: '#FFFFFF' }
            }).catch(console.error);
        }



        // Polling
        iniciarAtualizacaoTempoReal();
    });



    /* Lógica de Polling Simplificada */
    function iniciarAtualizacaoTempoReal() {
        if(isPolling) return;
        isPolling = true;
        pollingInterval = setInterval(atualizarStatus, 30000);
    }

    async function atualizarStatus() {
        try {
            const response = await fetch(statusUrl, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();

            if (data.updated_at !== lastUpdateTime) {
                // Se status mudou, recarrega para atualizar UI
                window.location.reload();
            }
        } catch (e) {
            console.error('Polling error', e);
        }
    }

    function copiarLink() {
        const link = '{{ route('demandas.public.show', ['codigo' => $demanda->codigo]) }}';
        navigator.clipboard.writeText(link).then(() => {
            alert('Link copiado!');
        });
    }
</script>
@endpush
@endsection
