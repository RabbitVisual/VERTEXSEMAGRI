@props(['label', 'name', 'required' => false, 'placeholder' => '', 'rows' => 4, 'help' => null, 'value' => null])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea id="{{ $name }}"
              name="{{ $name }}"
              rows="{{ $rows }}"
              placeholder="{{ $placeholder }}"
              @if($required) required @endif
              {{ $attributes->merge(['class' => 'block w-full px-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:text-white dark:placeholder-slate-500 sm:text-sm transition-all duration-200' . ($errors->has($name) ? ' border-red-500 ring-2 ring-red-500/10' : '')]) }}>{{ old($name, $value) }}</textarea>

    @error($name)
        <p class="mt-1.5 text-xs font-medium text-red-500">{{ $message }}</p>
    @enderror
    @if($help)
        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ $help }}</p>
    @endif
</div>
