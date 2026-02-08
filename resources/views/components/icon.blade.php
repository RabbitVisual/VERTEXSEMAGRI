@props([
    'name' => null,
    'module' => null,
    'style' => 'duotone',
    'class' => '',
    'bordered' => false,
    'pulled' => null, // 'left' or 'right'
    'size' => null, // 'xs', 'sm', 'lg', 'xl', '2xl', etc.
])

@php
    // Se um módulo for fornecido, tenta buscar o ícone padrão dele
    if ($module && empty($name)) {
        // Normaliza o nome do módulo (ex: 'agua' -> 'Agua')
        $moduleName = Illuminate\Support\Str::studly($module);
        $name = config("icons.modules.{$moduleName}");

        // Se não encontrar, fallback visual para erro (ex: circle-question)
        if (!$name) {
            $name = 'circle-question';
        }
    }

    $styleMap = [
        'duotone'       => 'fa-duotone',
        'solid'         => 'fa-solid',
        'regular'       => 'fa-regular',
        'light'         => 'fa-light',
        'thin'          => 'fa-thin',
        'brands'        => 'fa-brands',
        'sharp'         => 'fa-sharp fa-solid', // Atalho para sharp solid
        'sharp-solid'   => 'fa-sharp fa-solid',
        'sharp-regular' => 'fa-sharp fa-regular',
        'sharp-light'   => 'fa-sharp fa-light',
        'sharp-thin'    => 'fa-sharp fa-thin',
    ];

    $faStyle = $styleMap[$style] ?? $styleMap['duotone'];

    $classes = [
        $faStyle,
        "fa-{$name}",
        $bordered ? 'fa-border' : '',
        $pulled ? "fa-pull-{$pulled}" : '',
        $size ? "fa-{$size}" : '',
        $class
    ];

    $finalClass = implode(' ', array_filter($classes));
@endphp

<i {{ $attributes->merge(['class' => $finalClass]) }} aria-hidden="true"></i>
