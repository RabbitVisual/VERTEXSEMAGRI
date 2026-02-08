@props(['label', 'name', 'required' => false, 'placeholder' => '', 'rows' => 4, 'help' => null])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
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
              {{ $attributes->merge(['class' => 'block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 sm:text-sm' . ($errors->has($name) ? ' border-red-500' : '')]) }}>{{ old($name) }}</textarea>
    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
    @if($help)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $help }}</p>
    @endif
</div>

