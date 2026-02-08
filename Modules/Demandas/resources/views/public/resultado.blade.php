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
                    <x-icon name="file-pdf" class="w-5 h-5" />
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
                                <x-icon name="file-pdf" class="w-5 h-5" />
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

