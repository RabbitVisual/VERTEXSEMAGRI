@props([
    'label',
    'value' => '-',
    'bold' => false
])

<div>
    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1">{{ $label }}</p>
    <p @class([
        'text-sm transition-colors',
        'font-bold text-gray-900 dark:text-white' => $bold,
        'text-gray-600 dark:text-gray-300' => !$bold,
    ])>
        {{ $value ?? '-' }}
    </p>
</div>
