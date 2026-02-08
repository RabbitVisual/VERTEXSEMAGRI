@props([
    'label' => null,
    'name',
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
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
    <input 
        type="{{ $type }}" 
        class="form-control {{ $error ? 'is-invalid' : '' }} {{ $class }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >
    @if($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @elseif($help)
        <div class="form-text">{{ $help }}</div>
    @endif
</div>

