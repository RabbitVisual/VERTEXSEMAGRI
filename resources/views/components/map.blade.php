@props([
    'latitudeField' => 'latitude',
    'longitudeField' => 'longitude',
    'nomeMapaField' => 'nome_mapa',
    'latitude' => null,
    'longitude' => null,
    'nomeMapa' => null,
    'height' => '400px',
    'readonly' => false,
    'centerLat' => -12.2336, // Coração de Maria - BA
    'centerLng' => -38.7454,
    'zoom' => 13,
    'iconType' => 'default', // Tipo de ícone (poco, ponto_luz, localidade, ponto_distribuicao)
])

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
            </svg>
            Localização no Mapa
        </label>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
            @if(!$readonly)
                Clique no mapa para marcar a localização, use a busca para encontrar endereços ou arraste o marcador para ajustar.
            @else
                Visualização da localização no mapa.
            @endif
        </p>
    </div>

    <!-- Container do Mapa -->
    <div
        id="map-container-{{ md5($latitudeField . $longitudeField) }}"
        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 overflow-hidden shadow-sm bg-gray-100 dark:bg-gray-800 z-0"
        style="height: {{ $height }};"
    ></div>

    <!-- Campos ocultos para nome do mapa (se necessário) -->
    @if($nomeMapaField)
        <input
            type="hidden"
            id="{{ $nomeMapaField }}"
            name="{{ $nomeMapaField }}"
            value="{{ old($nomeMapaField, $nomeMapa ?? '') }}"
        />
    @endif

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapId = 'map-container-{{ md5($latitudeField . $longitudeField) }}';
            const latFieldId = '{{ $latitudeField }}';
            const lngFieldId = '{{ $longitudeField }}';
            const nomeFieldId = @json($nomeMapaField ?: null);

            // Função para inicializar o mapa
            const initializeMap = () => {
                // Obter valores existentes
                const latInput = document.getElementById(latFieldId);
                const lngInput = document.getElementById(lngFieldId);
                const nomeInput = nomeFieldId ? document.getElementById(nomeFieldId) : null;

                // Prioridade: valor passado > old() > valor do input
                const existingLat = @json($latitude ?: '');
                const existingLng = @json($longitude ?: '');
                const existingNome = @json($nomeMapa ?: '');

                // Configurar coordenadas iniciais
                let centerLat = {{ $centerLat }};
                let centerLng = {{ $centerLng }};
                let initialZoom = {{ $zoom }};

                if (existingLat && existingLng) {
                    centerLat = parseFloat(existingLat);
                    centerLng = parseFloat(existingLng);
                    initialZoom = 16;
                } else if (latInput?.value && lngInput?.value) {
                    centerLat = parseFloat(latInput.value);
                    centerLng = parseFloat(lngInput.value);
                    initialZoom = 16;
                }

                // Aguardar funções do mapa estarem disponíveis
                let attempts = 0;
                const maxAttempts = 100;

                const tryInit = () => {
                    if (typeof window.initVertexMap === 'function') {
                        // Inicializar mapa
                        const map = window.initVertexMap(mapId, {
                            center: [centerLat, centerLng],
                            zoom: initialZoom,
                            latitudeField: latFieldId,
                            longitudeField: lngFieldId,
                            nomeMapaField: nomeFieldId,
                            readonly: {{ $readonly ? 'true' : 'false' }},
                            iconType: @json($iconType ?? 'default'),
                            existingMarker: (existingLat && existingLng) ? {
                                lat: parseFloat(existingLat),
                                lng: parseFloat(existingLng),
                                nome: existingNome || ''
                            } : (latInput?.value && lngInput?.value) ? {
                                lat: parseFloat(latInput.value),
                                lng: parseFloat(lngInput.value),
                                nome: nomeInput?.value || ''
                            } : null
                        });

                        // Atualizar mapa quando coordenadas forem alteradas manualmente
                        if (latInput && lngInput && !{{ $readonly ? 'true' : 'false' }}) {
                            let updateTimeout;

                            const updateMarker = () => {
                                const lat = parseFloat(latInput.value);
                                const lng = parseFloat(lngInput.value);

                                if (lat && lng && !isNaN(lat) && !isNaN(lng)) {
                                    if (typeof window.updateVertexMapMarker === 'function') {
                                        const nome = nomeInput?.value || '';
                                        const iconType = @json($iconType ?? 'default');
                                        window.updateVertexMapMarker(map, lat, lng, nome, iconType);
                                    }
                                }
                            };

                            const scheduleUpdate = () => {
                                clearTimeout(updateTimeout);
                                updateTimeout = setTimeout(updateMarker, 500);
                            };

                            latInput.addEventListener('input', scheduleUpdate);
                            lngInput.addEventListener('input', scheduleUpdate);
                        }
                    } else if (attempts < maxAttempts) {
                        attempts++;
                        setTimeout(tryInit, 100);
                    } else {
                        console.warn('Mapa não inicializado: funções do mapa não carregadas. Certifique-se de que os assets foram compilados.');
                    }
                };

                tryInit();
            };

            // Inicializar após um pequeno delay para garantir que o DOM está pronto
            setTimeout(initializeMap, 100);
        });
    </script>
    @endpush
</div>
