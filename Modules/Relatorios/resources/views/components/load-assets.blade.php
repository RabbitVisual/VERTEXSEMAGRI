{{-- Chart.js já está carregado via resources/js/app.js (chart-admin.js) do projeto principal --}}
{{-- Este componente carrega os scripts específicos do módulo Relatorios --}}

@php
    $manifestPath = public_path('build-relatorios/manifest.json');
    $manifest = null;
    $manifestExists = file_exists($manifestPath);

    if ($manifestExists) {
        try {
            $manifestContent = file_get_contents($manifestPath);
            $manifest = json_decode($manifestContent, true);
        } catch (\Exception $e) {
            // Erro ao ler manifest
        }
    }
@endphp

@if($manifest && isset($manifest['resources/assets/js/app.js']['file']))
    @if(isset($manifest['resources/assets/sass/app.scss']['file']))
        <link rel="stylesheet" href="{{ asset('build-relatorios/' . $manifest['resources/assets/sass/app.scss']['file']) }}">
    @endif
    {{-- app.js do módulo já importa charts.js e filters.js --}}
    <script type="module" src="{{ asset('build-relatorios/' . $manifest['resources/assets/js/app.js']['file']) }}"></script>
@else
    {{-- Se o build do módulo não existir, Chart.js do projeto principal será usado --}}
    @if(!$manifestExists)
        <script>
        console.info('Manifest do módulo Relatorios não encontrado. Chart.js será carregado do projeto principal.');
        </script>
    @endif
@endif

{{-- Garantir que Chart.js e Leaflet estejam disponíveis globalmente (do projeto principal ou do módulo) --}}
@push('scripts')
<script>
// Aguardar Chart.js e Leaflet estarem disponíveis (carregados via app.js principal ou módulo)
(function() {
    let chartAttempts = 0;
    let leafletAttempts = 0;
    const maxAttempts = 50; // 5 segundos máximo

    function checkChartJS() {
        chartAttempts++;

        if (typeof window.Chart !== 'undefined') {
            // Chart.js já está disponível
            window.dispatchEvent(new CustomEvent('chartjs:ready'));
            return;
        }

        // Se exceder tentativas, avisar
        if (chartAttempts >= maxAttempts) {
            console.warn('Chart.js não foi carregado automaticamente. Verifique se o build foi executado.');
            return;
        }

        // Aguardar um pouco mais
        setTimeout(checkChartJS, 100);
    }

    function checkLeaflet() {
        leafletAttempts++;

        if (typeof window.L !== 'undefined') {
            // Leaflet já está disponível
            window.dispatchEvent(new CustomEvent('leaflet:ready'));
            return;
        }

        // Se exceder tentativas, avisar
        if (leafletAttempts >= maxAttempts) {
            console.warn('Leaflet não foi carregado automaticamente. Verifique se o build foi executado.');
            return;
        }

        // Aguardar um pouco mais
        setTimeout(checkLeaflet, 100);
    }

    // Iniciar verificação após DOM estar pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            checkChartJS();
            checkLeaflet();
        });
    } else {
        checkChartJS();
        checkLeaflet();
    }
})();
</script>
@endpush

