@props(['lat', 'lng', 'height' => '400px', 'zoom' => 15])

@php
    $apiKey = \App\Models\SystemConfig::get('google_maps.api_key');
@endphp

@if($apiKey)
    <div id="google-map-{{ $attributes->get('id', 'default') }}"
         style="height: {{ $height }}; width: 100%; border-radius: 0.5rem;"
         {{ $attributes }}></div>

    <script>
        (function() {
            const mapId = 'google-map-{{ $attributes->get('id', 'default') }}';
            const lat = {{ $lat }};
            const lng = {{ $lng }};
            const zoom = {{ $zoom }};

            async function initMap() {
                const mapElement = document.getElementById(mapId);
                if (!mapElement) return;

                // Request needed libraries.
                const { Map } = await google.maps.importLibrary("maps");
                const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

                const map = new Map(mapElement, {
                    center: { lat: lat, lng: lng },
                    zoom: zoom,
                    mapId: "DEMANDA_MAP_ID", // Requerido para AdvancedMarkerElement
                    mapTypeId: "hybrid",
                    mapTypeControl: true,
                    streetViewControl: true,
                    fullscreenControl: true
                });

                new AdvancedMarkerElement({
                    map: map,
                    position: { lat: lat, lng: lng },
                    title: "Localização da Demanda"
                });
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
    <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 rounded-lg" style="height: {{ $height }};">
        <div class="text-center p-4">
            <x-icon name="map" class="w-12 h-12 mx-auto mb-2 opacity-50" />
            <p>Mapa indisponível</p>
            <p class="text-xs mt-1">Chave de API não configurada</p>
        </div>
    </div>
@endif
