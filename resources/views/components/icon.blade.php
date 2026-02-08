@props([
    'name' => null,
    'module' => null,
    'style' => 'duotone',
    'class' => '',
    'size' => null,
    'bordered' => false,
    'pulled' => null,
    'rotate' => null,
    'flip' => null,
    'spin' => false,
    'pulse' => false,
])

@php
    // 1. Resolve Name from Module (if applicable)
    if ($module && empty($name)) {
        $moduleKey = Illuminate\Support\Str::studly($module);
        $name = config("icons.modules.{$moduleKey}");
        
        if (!$name) {
            $name = 'circle-question'; // Fallback if module mapping missing
        }
    }

    // 2. Safety Fallback
    if (empty($name)) {
        $name = 'circle-question';
    }

    // 3. Resolve Style Prefix (Font Awesome 7 Pro)
    $stylePrefix = match ($style) {
        'duotone' => 'fa-duotone',
        'solid' => 'fa-solid',
        'regular' => 'fa-regular',
        'light' => 'fa-light',
        'thin' => 'fa-thin',
        'brands' => 'fa-brands',
        'sharp' => 'fa-sharp fa-solid',
        'sharp-solid' => 'fa-sharp fa-solid',
        'sharp-regular' => 'fa-sharp fa-regular',
        'sharp-light' => 'fa-sharp fa-light',
        'sharp-thin' => 'fa-sharp fa-thin',
        default => 'fa-duotone',
    };

    // 4. Construct Classes
    $classes = [
        $stylePrefix,
        "fa-{$name}",
        $size ? "fa-{$size}" : '',
        $bordered ? 'fa-border' : '',
        $pulled ? "fa-pull-{$pulled}" : '',
        $rotate ? "fa-rotate-{$rotate}" : '',
        $flip ? "fa-flip-{$flip}" : '',
        $spin ? 'fa-spin' : '',
        $pulse ? 'fa-pulse' : '',
        $class
    ];

    $finalClass = implode(' ', array_filter($classes));
@endphp

<i {{ $attributes->merge(['class' => $finalClass]) }} aria-hidden="true"></i>
