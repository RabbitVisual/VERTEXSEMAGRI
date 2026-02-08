@props(['module', 'class' => 'w-5 h-5', 'size' => null])

@php
use App\Helpers\ModuleIcons;

// Mapeamento de rotas/nomes comuns para nomes de módulos
$moduleMap = [
    'demandas' => 'Demandas',
    'ordens' => 'Ordens',
    'localidades' => 'Localidades',
    'pessoas' => 'Pessoas',
    'iluminacao' => 'Iluminacao',
    'agua' => 'Agua',
    'pocos' => 'Pocos',
    'estradas' => 'Estradas',
    'funcionarios' => 'Funcionarios',
    'equipes' => 'Equipes',
    'materiais' => 'Materiais',
    'relatorios' => 'Relatorios',
    'notificacoes' => 'Notificacoes',
    'caf' => 'CAF',
    'chat' => 'Chat',
    'homepage' => 'Homepage',
    'programasagricultura' => 'ProgramasAgricultura',
    'programas-agricultura' => 'ProgramasAgricultura',
];

// Normalizar o nome do módulo
$moduleName = $moduleMap[strtolower($module)] ?? ucfirst($module);
$iconPath = ModuleIcons::getIconPath($moduleName);
$viewBox = ModuleIcons::getViewBox($moduleName);
$iconType = ModuleIcons::getIconType($moduleName);

// Aplicar tamanho se fornecido
$finalClass = $size ? "w-{$size} h-{$size}" : $class;
@endphp

@if($iconPath)
<svg class="{{ $finalClass }}"
     viewBox="{{ $viewBox }}"
     @if($iconType === 'fill')
     fill="currentColor"
     @else
     fill="none"
     stroke="currentColor"
     stroke-width="1.5"
     @endif
     {{ $attributes }}>
    {!! $iconPath !!}
</svg>
@else
{{-- Fallback para ícone padrão se não encontrar --}}
<svg class="{{ $finalClass }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" {{ $attributes }}>
    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
</svg>
@endif
