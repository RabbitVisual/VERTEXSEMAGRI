@props(['name', 'class' => 'w-5 h-5', 'solid' => false])

@php
    $map = [
        'clipboard-check' => 'clipboard-check',
        'folder-open' => 'folder-open',
        'clock-history' => 'clock-rotate-left',
        'check-circle' => 'circle-check',
        'exclamation-triangle' => 'triangle-exclamation',
        'document-x' => 'file-circle-xmark',
        'plus-circle' => 'circle-plus',
        'pencil' => 'pencil',
        'eye' => 'eye',
        'trash' => 'trash',
        'printer' => 'print',
        'document-plus' => 'file-circle-plus',
        'map-pin' => 'location-dot',
        'calendar' => 'calendar',
        'clock' => 'clock',
        'droplet' => 'droplet',
        'light-bulb' => 'lightbulb',
        'road' => 'road',
        'phone' => 'phone',
        'envelope' => 'envelope',
        'arrow-left' => 'arrow-left',
        'x-mark' => 'xmark',
        'arrow-right' => 'arrow-right',
    ];

    $faName = $map[$name] ?? $name;
    $style = $solid ? 'solid' : 'duotone';
@endphp

<x-icon :name="$faName" :style="$style" :class="$class" />
