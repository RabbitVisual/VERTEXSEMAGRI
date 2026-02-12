@props(['label', 'name', 'required' => false, 'options' => [], 'help' => null, 'icon' => null])

@php
    $errorClass = $errors->has($name) ? 'border-rose-300 ring-rose-500/10 dark:border-rose-900/50' : 'border-gray-200 dark:border-slate-800 focus:border-emerald-500 focus:ring-emerald-500/10';
@endphp

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @if($label)
        <label for="{{ $name }}" class="flex items-center gap-2 text-[9px] font-black uppercase text-slate-400 tracking-widest italic ml-2">
            {{ $label }}
            @if($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative group">
        @if($icon)
            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors pointer-events-none">
                <x-icon :name="$icon" class="w-4 h-4" />
            </div>
        @endif

        <select id="{{ $name }}"
                name="{{ $name }}"
                @if($required) required @endif
                {{ $attributes->merge(['class' => "w-full py-4 bg-white dark:bg-slate-950 rounded-2xl text-[11px] font-black uppercase tracking-widest dark:text-white transition-all appearance-none bg-none cursor-pointer " . ($icon ? 'pl-14 pr-12' : 'px-8') . " " . $errorClass]) }}>
            {{ $slot }}
            @foreach($options as $val => $txt)
                <option value="{{ $val }}" {{ old($name) == $val ? 'selected' : '' }}>{{ strtoupper($txt) }}</option>
            @endforeach
        </select>

        <div class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">
            <x-icon name="chevron-down" class="w-3 h-3" />
        </div>
    </div>

    @error($name)
        <div class="flex items-center gap-2 px-4 py-1.5 bg-rose-50 dark:bg-rose-900/10 rounded-xl animate-fade-in border border-rose-100 dark:border-rose-900/30">
            <x-icon name="circle-exclamation" class="w-3 h-3 text-rose-500" />
            <p class="text-[9px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest italic">{{ $message }}</p>
        </div>
    @enderror

    @if($help)
        <p class="px-2 text-[9px] font-semibold text-slate-400 uppercase tracking-widest italic leading-relaxed opacity-60">{{ $help }}</p>
    @endif
</div>
