@props([
    'label' => null,
    'name',
    'options' => [],
    'value' => null,
    'placeholder' => 'Selecione...',
    'required' => false,
    'help' => null,
    'class' => '',
    'error' => null,
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    <select 
        class="form-select {{ $error ? 'is-invalid' : '' }} {{ $class }}"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $key => $option)
            <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
                {{ is_array($option) ? $option['label'] : $option }}
            </option>
        @endforeach
    </select>
    @if($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @elseif($help)
        <div class="form-text">{{ $help }}</div>
    @endif
</div>

