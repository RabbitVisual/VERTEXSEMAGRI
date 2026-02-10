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
    'zoom' => 15,
    'iconType' => 'default',
])

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            <x-icon name="map-pin" class="w-4 h-4 inline mr-1" />
            Localização no Mapa
        </label>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
            @if(!$readonly)
                Clique no mapa para marcar a localização ou arraste o marcador para ajustar.
            @else
                Visualização da localização no mapa.
            @endif
        </p>
    </div>

    @php
        $apiKey = \App\Models\SystemConfig::get('google_maps.api_key');
        $mapId = 'map-select-' . md5($latitudeField . $longitudeField . uniqid());
    @endphp

    @if($apiKey)
        <div
            id="{{ $mapId }}"
            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 overflow-hidden shadow-sm bg-gray-100 dark:bg-gray-800"
            style="height: {{ $height }};"
        ></div>

        @if($nomeMapaField && !$readonly)
            <input
                type="hidden"
                id="{{ $nomeMapaField }}"
                name="{{ $nomeMapaField }}"
                value="{{ old($nomeMapaField, $nomeMapa ?? '') }}"
            />
        @endif

        <script>
            (function() {
                const mapId = '{{ $mapId }}';
                const latFieldId = '{{ $latitudeField }}';
                const lngFieldId = '{{ $longitudeField }}';
                const nomeFieldId = '{{ $nomeMapaField }}';
                const isReadonly = {{ $readonly ? 'true' : 'false' }};

                // Valores iniciais
                let currentLat = {{ $latitude ?? 'null' }};
                let currentLng = {{ $longitude ?? 'null' }};

                // Default center
                const defaultCenter = { lat: {{ $centerLat }}, lng: {{ $centerLng }} };

                async function initMap() {
                    const mapElement = document.getElementById(mapId);
                    if (!mapElement) return;

                    // Request libraries
                    const { Map } = await google.maps.importLibrary("maps");
                    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
                    const { Geocoder } = await google.maps.importLibrary("geocoding");

                    // Tentar pegar valores dos inputs se não passados via props
                    const latInput = document.getElementById(latFieldId);
                    const lngInput = document.getElementById(lngFieldId);
                    const nomeInput = document.getElementById(nomeFieldId);

                    if (!currentLat && latInput && latInput.value) currentLat = parseFloat(latInput.value);
                    if (!currentLng && lngInput && lngInput.value) currentLng = parseFloat(lngInput.value);

                    const initialPosition = (currentLat && currentLng)
                        ? { lat: currentLat, lng: currentLng }
                        : defaultCenter;

                    const map = new Map(mapElement, {
                        center: initialPosition,
                        zoom: {{ $zoom }},
                        mapId: 'FORM_MAP_ID',
                        mapTypeId: 'hybrid',
                        streetViewControl: false,
                        fullscreenControl: true,
                        mapTypeControl: true,
                    });

                    let marker = null;

                    if (currentLat && currentLng) {
                        addMarker(initialPosition);
                    }

                    if (!isReadonly) {
                        map.addListener('click', (e) => {
                            const pos = { lat: e.latLng.lat(), lng: e.latLng.lng() };
                            addMarker(pos);
                            updateInputs(pos, Geocoder);
                        });
                    }

                    function addMarker(location) {
                        if (marker) {
                            marker.position = location;
                        } else {
                            marker = new AdvancedMarkerElement({
                                position: location,
                                map: map,
                                gmpDraggable: !isReadonly,
                                title: "Localização Selecionada"
                            });

                            if (!isReadonly) {
                                marker.addListener('dragend', (e) => {
                                    const pos = { lat: e.latLng.lat(), lng: e.latLng.lng() };
                                    updateInputs(pos, Geocoder);
                                });
                            }
                        }
                    }

                    function updateInputs(pos, GeocoderClass) {
                        if (latInput) {
                            latInput.value = pos.lat.toFixed(6);
                            latInput.dispatchEvent(new Event('input')); // Trigger Alpine/Livewire
                        }
                        if (lngInput) {
                            lngInput.value = pos.lng.toFixed(6);
                            lngInput.dispatchEvent(new Event('input'));
                        }

                        // Opcional: Geocoding reverso para nome do mapa
                        if (nomeInput && GeocoderClass) {
                             const geocoder = new GeocoderClass();
                             geocoder.geocode({ location: pos }, (results, status) => {
                                 if (status === "OK" && results[0]) {
                                     nomeInput.value = results[0].formatted_address;
                                 }
                             });
                        }
                    }

                    // Escutar mudanças externos nos inputs
                    if (!isReadonly && latInput && lngInput) {
                        const updateFromInputs = () => {
                             const lat = parseFloat(latInput.value);
                             const lng = parseFloat(lngInput.value);
                             if (!isNaN(lat) && !isNaN(lng)) {
                                 const pos = { lat, lng };
                                 addMarker(pos);
                                 map.panTo(pos);
                             }
                        };
                        latInput.addEventListener('change', updateFromInputs);
                        lngInput.addEventListener('change', updateFromInputs);
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
        <div class="w-full h-full min-h-[300px] flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-500">
            <x-icon name="map" class="w-12 h-12 opacity-30 mb-2" />
            <p>Mapa indisponível</p>
            <p class="text-xs">Chave de API não configurada</p>
        </div>
    @endif
</div>
