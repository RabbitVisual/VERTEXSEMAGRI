@props(['posicao' => 'topo', 'limit' => null])

@php
    use Modules\Avisos\App\Services\AvisoService;
    $avisoService = app(AvisoService::class);
    $avisos = $avisoService->obterAvisosPorPosicao($posicao, $limit);
@endphp

@if($avisos->count() > 0)
    <div class="avisos-container avisos-{{ $posicao }} {{ $posicao == 'flutuante' ? '' : 'space-y-4' }}">
        @foreach($avisos as $aviso)
            @include('avisos::components.banner', ['aviso' => $aviso])
        @endforeach
    </div>
@endif

