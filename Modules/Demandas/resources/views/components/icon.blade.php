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
        'document-arrow-down' => 'file-arrow-down',
        'arrow-down-tray' => 'download',
        'arrow-path' => 'rotate',
        'bolt' => 'bolt',
        'map-pin' => 'location-dot',
        'calendar' => 'calendar',
        'clock' => 'clock',
        'droplet' => 'droplet',
        'water' => 'water',
        'light-bulb' => 'lightbulb',
        'road' => 'road',
        'map' => 'map',
        'phone' => 'phone',
        'envelope' => 'envelope',
        'arrow-left' => 'arrow-left',
        'x-mark' => 'xmark',
        'arrow-right' => 'arrow-right',
        'information-circle' => 'circle-info',
        'user-plus' => 'user-plus',
        'user' => 'user',
        'document-text' => 'file-lines',
        'search' => 'magnifying-glass',
        'x-circle' => 'circle-xmark',
        'lock-closed' => 'lock',
        'link' => 'link',
        'chart-bar' => 'chart-simple',
        'user-circle' => 'circle-user',
    ];

    $faName = $map[$name] ?? $name;
    $style = $solid ? 'solid' : 'duotone';
@endphp

<x-icon :name="$faName" :style="$style" :class="$class" />
