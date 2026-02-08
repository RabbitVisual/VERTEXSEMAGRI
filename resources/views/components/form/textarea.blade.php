@props([
    'label' => null,
    'name',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'help' => null,
    'class' => '',
    'error' => null,
    'rows' => 3,
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
    <textarea 
        class="form-control {{ $error ? 'is-invalid' : '' }} {{ $class }}"
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>
    @if($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @elseif($help)
        <div class="form-text">{{ $help }}</div>
    @endif
</div>

