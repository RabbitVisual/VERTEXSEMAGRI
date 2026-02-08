@props(['paginator'])

@if($paginator->hasPages())
<nav class="flex items-center justify-between border-t-2 border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 px-4 py-4 sm:px-6 rounded-b-xl" aria-label="Pagination">
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-700 dark:text-gray-300">
                Mostrando
                <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $paginator->firstItem() }}</span>
                até
                <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $paginator->lastItem() }}</span>
                de
                <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->total() }}</span>
                {{ $paginator->total() == 1 ? 'resultado' : 'resultados' }}
            </p>
        </div>
        <div>
            <span class="relative z-0 inline-flex rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800" role="group">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center rounded-l-lg border-r border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 px-3 py-2 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">
                        <x-icon name="arrow-left" class="w-4 h-4" />
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center rounded-l-lg border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 focus:z-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                        <x-icon name="arrow-left" class="w-4 h-4" />
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $currentPage = $paginator->currentPage();
                    $lastPage = $paginator->lastPage();
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($lastPage, $currentPage + 2);
                @endphp

                @if($startPage > 1)
                    <a href="{{ $paginator->url(1) }}" class="relative inline-flex items-center border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 focus:z-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                        1
                    </a>
                    @if($startPage > 2)
                        <span class="relative inline-flex items-center border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                            ...
                        </span>
                    @endif
                @endif

                @for ($page = $startPage; $page <= $endPage; $page++)
                    @if ($page == $currentPage)
                        <span aria-current="page" class="relative inline-flex items-center border-r border-gray-200 dark:border-gray-700 bg-indigo-600 dark:bg-indigo-500 px-4 py-2 text-sm font-semibold text-white focus:z-10 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($page) }}" class="relative inline-flex items-center border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 focus:z-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endfor

                @if($endPage < $lastPage)
                    @if($endPage < $lastPage - 1)
                        <span class="relative inline-flex items-center border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                            ...
                        </span>
                    @endif
                    <a href="{{ $paginator->url($lastPage) }}" class="relative inline-flex items-center border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 focus:z-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                        {{ $lastPage }}
                    </a>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center rounded-r-lg bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 focus:z-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                        <x-icon name="arrow-right" class="w-4 h-4" />
                    </a>
                @else
                    <span class="relative inline-flex items-center rounded-r-lg bg-gray-50 dark:bg-gray-700 px-3 py-2 text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">
                        <x-icon name="arrow-right" class="w-4 h-4" />
                    </span>
                @endif
            </span>
        </div>
    </div>

    {{-- Mobile Pagination --}}
    <div class="flex flex-1 justify-between items-center sm:hidden gap-2">
        <div class="text-xs text-gray-600 dark:text-gray-400">
            Página {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }}
        </div>
        <div class="flex gap-2">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 px-3 py-2 text-xs font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-1" />
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-colors">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-1" />
                    Anterior
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-colors">
                    Próximo
                    <x-icon name="arrow-right" class="w-4 h-4 ml-1" />
                </a>
            @else
                <span class="relative inline-flex items-center rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 px-3 py-2 text-xs font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">
                    Próximo
                    <x-icon name="arrow-right" class="w-4 h-4 ml-1" />
                </span>
            @endif
        </div>
    </div>
</nav>
@endif
