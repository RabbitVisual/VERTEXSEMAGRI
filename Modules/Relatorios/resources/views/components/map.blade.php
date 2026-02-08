@props([
    'id' => 'relatorios-map-' . uniqid(),
    'height' => '500px',
    'markers' => [], // Array de marcadores: [{lat, lng, nome, tipo, popup, color}]
    'centerLat' => -12.2336, // Coração de Maria - BA
    'centerLng' => -38.7454,
    'zoom' => 12,
    'showLegend' => true,
    'showFullscreen' => true,
    'showLayerControl' => true,
    'clusterMarkers' => false, // Agrupar marcadores próximos
])

<div {{ $attributes->merge(['class' => 'relative']) }}>
    <!-- Container do Mapa -->
    <div
        id="{{ $id }}"
        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 overflow-hidden shadow-sm bg-gray-100 dark:bg-gray-800"
        style="height: {{ $height }}; z-index: 1;"
    ></div>

    <!-- Controles Customizados -->
    <div class="absolute top-3 right-3 z-10 flex flex-col gap-2">
        @if($showFullscreen)
        <button
            type="button"
            onclick="toggleFullscreen{{ Str::camel($id) }}()"
            class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
            title="Tela Cheia"
        >
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
            </svg>
        </button>
        @endif
        <button
            type="button"
            onclick="resetView{{ Str::camel($id) }}()"
            class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
            title="Resetar Visualização"
        >
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
            </svg>
        </button>
    </div>

    <!-- Legenda -->
    @if($showLegend && count($markers) > 0)
    <div class="absolute bottom-3 left-3 z-10 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-3 max-w-xs">
        <h4 class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
            </svg>
            Legenda
        </h4>
        <div class="space-y-1.5 text-xs max-h-32 overflow-y-auto" id="{{ $id }}-legend">
            <!-- Preenchido via JavaScript -->
        </div>
    </div>
    @endif

    <!-- Estatísticas do Mapa -->
    <div class="absolute top-3 left-3 z-10 bg-white/90 dark:bg-gray-800/90 backdrop-blur rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 px-3 py-2">
        <div class="flex items-center gap-3 text-xs">
            <div class="flex items-center gap-1">
                <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                <span class="font-semibold text-gray-700 dark:text-gray-300" id="{{ $id }}-count">{{ count($markers) }}</span>
                <span class="text-gray-500 dark:text-gray-400">pontos</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mapId = '{{ $id }}';
    const markers = @json($markers);
    const centerLat = {{ $centerLat }};
    const centerLng = {{ $centerLng }};
    const initialZoom = {{ $zoom }};
    const clusterMarkers = {{ $clusterMarkers ? 'true' : 'false' }};

    let map = null;
    let markersLayer = null;
    let isFullscreen = false;

    // Cores para diferentes tipos de marcadores
    const markerColors = {
        'localidade': '#10b981',      // verde
        'demanda': '#6366f1',         // indigo
        'ordem': '#f59e0b',           // âmbar
        'poco': '#0ea5e9',            // azul claro
        'ponto_luz': '#eab308',       // amarelo
        'ponto_distribuicao': '#3b82f6', // azul
        'pessoa': '#8b5cf6',          // roxo
        'default': '#6b7280'          // cinza
    };

    // Função para criar ícone SVG customizado
    function createMarkerIcon(tipo, cor = null) {
        const color = cor || markerColors[tipo] || markerColors.default;

        const svgIcons = {
            'localidade': `<svg width="32" height="40" viewBox="0 0 32 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24s16-12 16-24C32 7.16 24.84 0 16 0z" fill="${color}" stroke="#ffffff" stroke-width="2"/>
                <circle cx="16" cy="16" r="8" fill="#ffffff"/>
                <path d="M16 10l-4 4v6h3v-4h2v4h3v-6l-4-4z" fill="${color}"/>
            </svg>`,
            'demanda': `<svg width="32" height="40" viewBox="0 0 32 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24s16-12 16-24C32 7.16 24.84 0 16 0z" fill="${color}" stroke="#ffffff" stroke-width="2"/>
                <circle cx="16" cy="16" r="8" fill="#ffffff"/>
                <path d="M12 12h8v2h-8v-2zm0 3h8v2h-8v-2zm0 3h5v2h-5v-2z" fill="${color}"/>
            </svg>`,
            'ordem': `<svg width="32" height="40" viewBox="0 0 32 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24s16-12 16-24C32 7.16 24.84 0 16 0z" fill="${color}" stroke="#ffffff" stroke-width="2"/>
                <circle cx="16" cy="16" r="8" fill="#ffffff"/>
                <path d="M13 11l6 5-6 5V11z" fill="${color}"/>
            </svg>`,
            'poco': `<svg width="32" height="40" viewBox="0 0 32 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24s16-12 16-24C32 7.16 24.84 0 16 0z" fill="${color}" stroke="#ffffff" stroke-width="2"/>
                <circle cx="16" cy="16" r="8" fill="#ffffff"/>
                <path d="M16 10c-1.5 3-3 5-3 7 0 1.66 1.34 3 3 3s3-1.34 3-3c0-2-1.5-4-3-7z" fill="${color}"/>
            </svg>`,
            'ponto_luz': `<svg width="32" height="40" viewBox="0 0 32 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24s16-12 16-24C32 7.16 24.84 0 16 0z" fill="${color}" stroke="#ffffff" stroke-width="2"/>
                <circle cx="16" cy="16" r="8" fill="#ffffff"/>
                <circle cx="16" cy="14" r="4" fill="${color}"/>
                <line x1="16" y1="18" x2="16" y2="22" stroke="${color}" stroke-width="2"/>
            </svg>`,
            'ponto_distribuicao': `<svg width="32" height="40" viewBox="0 0 32 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24s16-12 16-24C32 7.16 24.84 0 16 0z" fill="${color}" stroke="#ffffff" stroke-width="2"/>
                <circle cx="16" cy="16" r="8" fill="#ffffff"/>
                <rect x="12" y="11" width="8" height="6" fill="${color}" rx="1"/>
                <rect x="14" y="17" width="4" height="5" fill="${color}"/>
            </svg>`,
            'pessoa': `<svg width="32" height="40" viewBox="0 0 32 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24s16-12 16-24C32 7.16 24.84 0 16 0z" fill="${color}" stroke="#ffffff" stroke-width="2"/>
                <circle cx="16" cy="16" r="8" fill="#ffffff"/>
                <circle cx="16" cy="13" r="3" fill="${color}"/>
                <path d="M11 21c0-2.76 2.24-5 5-5s5 2.24 5 5" fill="${color}"/>
            </svg>`,
            'default': `<svg width="32" height="40" viewBox="0 0 32 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24s16-12 16-24C32 7.16 24.84 0 16 0z" fill="${color}" stroke="#ffffff" stroke-width="2"/>
                <circle cx="16" cy="16" r="6" fill="#ffffff"/>
            </svg>`
        };

        const svg = svgIcons[tipo] || svgIcons.default;
        const svgUrl = 'data:image/svg+xml;base64,' + btoa(svg);

        return L.icon({
            iconUrl: svgUrl,
            iconSize: [32, 40],
            iconAnchor: [16, 40],
            popupAnchor: [0, -40]
        });
    }

    // Inicializar mapa
    function initMap() {
        if (typeof L === 'undefined') {
            console.warn('Leaflet não carregado, tentando novamente...');
            setTimeout(initMap, 200);
            return;
        }

        // Criar mapa
        map = L.map(mapId, {
            center: [centerLat, centerLng],
            zoom: initialZoom,
            zoomControl: true,
            scrollWheelZoom: true,
        });

        // Adicionar camadas de tile
        const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
        });

        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: '© Esri',
            maxZoom: 19,
        });

        const topoLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenTopoMap',
            maxZoom: 17,
        });

        // Adicionar camada padrão
        osmLayer.addTo(map);

        // Controle de camadas
        @if($showLayerControl)
        const baseLayers = {
            'Mapa': osmLayer,
            'Satélite': satelliteLayer,
            'Topográfico': topoLayer
        };
        L.control.layers(baseLayers, null, { position: 'topright' }).addTo(map);
        @endif

        // Adicionar marcadores
        markersLayer = L.layerGroup().addTo(map);
        const bounds = [];
        const tiposEncontrados = new Set();

        markers.forEach(function(marker) {
            if (marker.lat && marker.lng) {
                const lat = parseFloat(marker.lat);
                const lng = parseFloat(marker.lng);

                if (!isNaN(lat) && !isNaN(lng)) {
                    const tipo = marker.tipo || 'default';
                    const cor = marker.color || null;
                    const icon = createMarkerIcon(tipo, cor);

                    const m = L.marker([lat, lng], { icon: icon });

                    // Popup com informações
                    if (marker.popup || marker.nome) {
                        const popupContent = marker.popup || `
                            <div class="text-center p-2">
                                <strong class="text-gray-900">${marker.nome || 'Sem nome'}</strong>
                                ${marker.tipo ? `<br><span class="text-xs text-gray-500">${marker.tipo}</span>` : ''}
                                ${marker.info ? `<br><span class="text-xs text-gray-600">${marker.info}</span>` : ''}
                            </div>
                        `;
                        m.bindPopup(popupContent, { maxWidth: 300 });
                    }

                    m.addTo(markersLayer);
                    bounds.push([lat, lng]);
                    tiposEncontrados.add(tipo);
                }
            }
        });

        // Ajustar visualização para mostrar todos os marcadores
        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [50, 50], maxZoom: 15 });
        }

        // Atualizar legenda
        updateLegend(tiposEncontrados);
    }

    // Atualizar legenda
    function updateLegend(tipos) {
        const legendContainer = document.getElementById(mapId + '-legend');
        if (!legendContainer) return;

        const tipoLabels = {
            'localidade': 'Localidades',
            'demanda': 'Demandas',
            'ordem': 'Ordens de Serviço',
            'poco': 'Poços',
            'ponto_luz': 'Pontos de Luz',
            'ponto_distribuicao': 'Pontos de Distribuição',
            'pessoa': 'Pessoas',
            'default': 'Outros'
        };

        let html = '';
        tipos.forEach(function(tipo) {
            const color = markerColors[tipo] || markerColors.default;
            const label = tipoLabels[tipo] || tipo;
            html += `
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: ${color}"></span>
                    <span class="text-gray-700 dark:text-gray-300">${label}</span>
                </div>
            `;
        });

        legendContainer.innerHTML = html;
    }

    // Função para toggle fullscreen
    window['toggleFullscreen{{ Str::camel($id) }}'] = function() {
        const container = document.getElementById(mapId).parentElement;

        if (!isFullscreen) {
            container.style.position = 'fixed';
            container.style.top = '0';
            container.style.left = '0';
            container.style.width = '100vw';
            container.style.height = '100vh';
            container.style.zIndex = '9999';
            document.getElementById(mapId).style.height = '100vh';
            isFullscreen = true;
        } else {
            container.style.position = 'relative';
            container.style.top = '';
            container.style.left = '';
            container.style.width = '';
            container.style.height = '';
            container.style.zIndex = '';
            document.getElementById(mapId).style.height = '{{ $height }}';
            isFullscreen = false;
        }

        if (map) {
            setTimeout(() => map.invalidateSize(), 100);
        }
    };

    // Função para resetar visualização
    window['resetView{{ Str::camel($id) }}'] = function() {
        if (map) {
            const bounds = [];
            markersLayer.eachLayer(function(layer) {
                if (layer.getLatLng) {
                    const latlng = layer.getLatLng();
                    bounds.push([latlng.lat, latlng.lng]);
                }
            });

            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [50, 50], maxZoom: 15 });
            } else {
                map.setView([centerLat, centerLng], initialZoom);
            }
        }
    };

    // Inicializar
    setTimeout(initMap, 100);
});
</script>
@endpush

