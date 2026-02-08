<div class="card {{ $class ?? '' }} mb-4">
    @if(isset($title))
    <div class="card-header">
        @if(isset($icon))
            <i class="{{ $icon }} me-2"></i>
        @endif
        {{ $title }}
    </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
