@props([
    'id',
    'title' => null,
    'size' => 'lg', // sm, md, lg, xl, 2xl
    'footer' => null,
    'static' => false,
    'closeOnBackdrop' => true,
])

@php
    $sizeClasses = [
        'sm' => 'sm:max-w-md',
        'md' => 'sm:max-w-lg',
        'lg' => 'sm:max-w-2xl',
        'xl' => 'sm:max-w-4xl',
        '2xl' => 'sm:max-w-6xl',
    ];
    $modalSize = $sizeClasses[$size] ?? $sizeClasses['lg'];
@endphp

<div id="{{ $id }}" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="{{ $id }}Label" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        @if($closeOnBackdrop)
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity cursor-pointer" aria-hidden="true" onclick="document.getElementById('{{ $id }}').classList.add('hidden'); document.body.style.overflow = '';"></div>
        @else
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        @endif
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle {{ $modalSize }} w-full">
            @if($title)
                <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="{{ $id }}Label">{{ $title }}</h3>
                        <button type="button" onclick="document.getElementById('{{ $id }}').classList.add('hidden'); document.body.style.overflow = '';" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
            <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6">
                {{ $slot }}
            </div>
            @if($footer)
                <div class="bg-gray-50 dark:bg-slate-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-slate-600">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Função helper para abrir o modal
    function openModal{{ str_replace('-', '', $id) }}() {
        const modal = document.getElementById('{{ $id }}');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    // Função helper para fechar o modal
    function closeModal{{ str_replace('-', '', $id) }}() {
        const modal = document.getElementById('{{ $id }}');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    // Tornar funções globais
    window['openModal{{ str_replace('-', '', $id) }}'] = openModal{{ str_replace('-', '', $id) }};
    window['closeModal{{ str_replace('-', '', $id) }}'] = closeModal{{ str_replace('-', '', $id) }};

    // Fechar com Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('{{ $id }}');
            if (modal && !modal.classList.contains('hidden')) {
                closeModal{{ str_replace('-', '', $id) }}();
            }
        }
    });
</script>
@endpush

