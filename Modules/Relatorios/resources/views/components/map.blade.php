@props([
    'id' => 'relatorios-map-' . uniqid(),
    'height' => '500px',
    'markers' => [],
    'centerLat' => -12.2336,
    'centerLng' => -38.7454,
    'zoom' => 12,
    'showLegend' => true,
    'showFullscreen' => true,
    'showLayerControl' => true,
    'clusterMarkers' => false,
])

<div {{ $attributes->merge(['class' => 'relative w-full']) }} style="height: {{ $height }};">
    @php
        $apiKey = \App\Models\SystemConfig::get('google_maps.api_key');
    @endphp

    @if($apiKey)
        <div id="{{ $id }}" class="w-full h-full rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden"></div>

        <!-- Legenda -->
        @if($showLegend && count($markers) > 0)
        <div class="absolute bottom-4 left-4 z-10 bg-white dark:bg-gray-800 p-3 rounded-lg shadow-lg border border-gray-100 dark:border-gray-700 max-w-xs max-h-48 overflow-y-auto hidden md:block">
            <h4 class="text-xs font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                <x-icon name="list-bullet" class="w-3 h-3" />
                Legenda
            </h4>
            <div id="{{ $id }}-legend" class="space-y-1.5 text-xs">
                <!-- Preenchido via JS -->
            </div>
        </div>
        @endif

        <script>
            (function() {
                const mapId = '{{ $id }}';
                const centerLat = {{ $centerLat }};
                const centerLng = {{ $centerLng }};
                const zoom = {{ $zoom }};
                const markersData = @json($markers);

                async function initMap() {
                    const mapElement = document.getElementById(mapId);
                    if (!mapElement) return;

                    // Request libraries
                    const { Map } = await google.maps.importLibrary("maps");
                    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");
                    const { InfoWindow } = await google.maps.importLibrary("maps");

                    const map = new Map(mapElement, {
                        center: { lat: centerLat, lng: centerLng },
                        zoom: zoom,
                        mapId: 'RELATORIOS_MAP_ID', // Required for advanced markers
                        mapTypeId: 'hybrid',
                        mapTypeControl: {{ $showLayerControl ? 'true' : 'false' }},
                        streetViewControl: true,
                        fullscreenControl: {{ $showFullscreen ? 'true' : 'false' }},
                        zoomControl: true,
                    });

                    // Cores para legenda
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

                    const legendTypes = new Set();
                    const bounds = new google.maps.LatLngBounds();

                    markersData.forEach(m => {
                        if (m.lat && m.lng) {
                            const position = { lat: parseFloat(m.lat), lng: parseFloat(m.lng) };
                            const type = m.tipo || 'default';
                            const color = m.color || markerColors[type] || markerColors.default;

                            // Marcador Avançado (Pin Element)
                            const pin = new PinElement({
                                background: color,
                                borderColor: '#ffffff',
                                glyphColor: '#ffffff',
                                scale: 0.8
                            });

                            const marker = new AdvancedMarkerElement({
                                position: position,
                                map: map,
                                title: m.nome,
                                content: pin.element
                            });

                            // InfoWindow
                            if (m.popup || m.nome) {
                                const content = m.popup || `
                                    <div class="p-2 text-center text-gray-800">
                                        <div class="font-bold">${m.nome || 'Sem nome'}</div>
                                        ${m.tipo ? `<div class="text-xs text-gray-500 capitalize">${m.tipo.replace('_', ' ')}</div>` : ''}
                                        ${m.info ? `<div class="text-xs mt-1">${m.info}</div>` : ''}
                                    </div>
                                `;

                                const infoWindow = new InfoWindow({
                                    content: content
                                });

                                marker.addListener('click', () => {
                                    infoWindow.open({
                                        anchor: marker,
                                        map: map,
                                    });
                                });
                            }

                            bounds.extend(position);
                            legendTypes.add(type);
                        }
                    });

                    // Ajustar zoom se houver marcadores
                    if (markersData.length > 0) {
                        map.fitBounds(bounds);
                    }

                    // Preencher Legenda
                    const legendContainer = document.getElementById(mapId + '-legend');
                    if (legendContainer && legendTypes.size > 0) {
                        const labels = {
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
                        legendTypes.forEach(type => {
                            const color = markerColors[type] || markerColors.default;
                            const label = labels[type] || type;
                            html += `
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full" style="background-color: ${color}"></span>
                                    <span class="text-gray-700 dark:text-gray-300 capitalize">${label}</span>
                                </div>
                            `;
                        });
                        legendContainer.innerHTML = html;
                    }
                }

                // Google Maps Loader (2026 official standard - Robust version v4)
                if (!window.google?.maps?.importLibrary) {
                    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await a;m.head.append(k=m.createElement("script"));e.set("libraries",[...r]+"");for(k.src=`https://maps.${c}apis.com/maps/api/js?`+e;p in d; )d[p]=null;k.async=!0;k.onerror=()=>h=n(Error(p+" could not load."));d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))}));a=new Promise(f=>m.addEventListener("DOMContentLoaded",f));for(var z in g)e.set(z.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[z]);e.set("callback",c+".maps."+q);d[q]=f=>f&&d[l](f);u().then(()=>initMap())})({
                        key: "{{ $apiKey }}",
                        v: "weekly",
                        loading: "async"
                    });
                } else {
                    initMap();
                }
            })();
        </script>
    @else
        <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-500">
            <x-icon name="map" class="w-12 h-12 opacity-30 mb-2" />
            <p>Mapa indisponível</p>
            <p class="text-xs">Chave de API não configurada</p>
        </div>
    @endif
</div>
