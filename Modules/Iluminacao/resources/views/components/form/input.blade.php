@props(['label', 'name', 'type' => 'text', 'required' => false, 'placeholder' => '', 'value' => '', 'help' => null, 'icon' => null])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative group">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                <x-icon :name="$icon" class="w-5 h-5" />
            </div>
        @endif

        <input type="{{ $type }}"
               id="{{ $name }}"
               name="{{ $name }}"
               value="{{ old($name, $value) }}"
               placeholder="{{ $placeholder }}"
               @if($required) required @endif
               {{ $attributes->merge(['class' => 'block w-full ' . ($icon ? 'pl-10' : 'px-4') . ' py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:text-white dark:placeholder-slate-500 sm:text-sm transition-all duration-200' . ($errors->has($name) ? ' border-red-500 ring-2 ring-red-500/10' : '')]) }}>
    </div>

    @error($name)
        <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
    @enderror
    @if($help)
        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ $help }}</p>
    @endif
</div>
