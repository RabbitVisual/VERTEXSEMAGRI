@props(['label', 'name', 'required' => false, 'options' => [], 'help' => null, 'icon' => null, 'value' => null])

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

        <select id="{{ $name }}"
                name="{{ $name }}"
                @if($required) required @endif
                {{ $attributes->merge(['class' => 'block w-full ' . ($icon ? 'pl-10' : 'px-4') . ' py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:text-white sm:text-sm transition-all duration-200 appearance-none' . ($errors->has($name) ? ' border-red-500 ring-2 ring-red-500/10' : '')]) }}>
            {{ $slot }}
            @foreach($options as $val => $lbl)
                <option value="{{ $val }}" {{ old($name, $value) == $val ? 'selected' : '' }}>{{ $lbl }}</option>
            @endforeach
        </select>

        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
            <x-icon name="chevron-down" class="w-4 h-4" />
        </div>
    </div>

    @error($name)
        <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
    @enderror
    @if($help)
        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ $help }}</p>
    @endif
</div>
