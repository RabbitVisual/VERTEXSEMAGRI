@extends('admin.layouts.admin')

@section('title', 'Gerenciar Carousel')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                    </svg>
                </div>
                <span>Gerenciar Carousel</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">Carousel</span>
            </nav>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <!-- Toggle Carousel - Flowbite Toggle -->
            <div class="flex items-center gap-3 px-4 py-2.5 rounded-lg border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Carousel:</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="carouselToggle" class="sr-only peer" {{ $isEnabled ? 'checked' : '' }} data-toggle-route="{{ route('admin.carousel.toggle') }}">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300" id="carouselStatus">{{ $isEnabled ? 'Ativado' : 'Desativado' }}</span>
                </label>
            </div>
            <!-- Novo Slide Button - Flowbite Button -->
            <a href="{{ route('admin.carousel.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Novo Slide
            </a>
        </div>
    </div>

    <!-- Slides List - Flowbite Card -->
    @if($slides->count() > 0)
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Slides do Carousel</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Arraste para reordenar os slides</p>
            </div>
            <div id="slidesList" class="divide-y divide-gray-200 dark:divide-slate-700" data-reorder-route="{{ route('admin.carousel.reorder') }}">
                @foreach($slides as $slide)
                    <div class="slide-item p-6 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors" data-id="{{ $slide->id }}">
                        <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">
                            <!-- Drag Handle -->
                            <div class="flex-shrink-0 cursor-move drag-handle p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </div>

                            <!-- Image Preview -->
                            @if($slide->image && $slide->show_image)
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->title ?? 'Slide' }}" class="w-32 h-20 md:w-40 md:h-24 object-cover rounded-lg border border-gray-200 dark:border-slate-700">
                                </div>
                            @else
                                <div class="flex-shrink-0 w-32 h-20 md:w-40 md:h-24 bg-gray-100 dark:bg-slate-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-slate-600 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                            @endif

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                            @if($slide->title)
                                                @php
                                                    $previewTitle = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $slide->title);
                                                    $previewTitle = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $previewTitle);
                                                @endphp
                                                {{ Str::limit(strip_tags($previewTitle), 80) ?: 'Sem título' }}
                                            @else
                                                Sem título
                                            @endif
                                        </h4>
                                        @if($slide->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                                {{ Str::limit(strip_tags($slide->description), 100) }}
                                            </p>
                                        @endif
                                        @if($slide->title && strip_tags($slide->title) !== $slide->title)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full dark:bg-indigo-900/30 dark:text-indigo-300 mt-1">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                                                </svg>
                                                HTML formatado
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <!-- Status Badge - Flowbite Badge -->
                                        @if($slide->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Ativo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Inativo
                                            </span>
                                        @endif
                                        <!-- Order Badge - Flowbite Badge -->
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300 text-xs font-bold">
                                            {{ $slide->order }}
                                        </span>
                                    </div>
                                </div>
                                @if($slide->link)
                                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mt-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                        </svg>
                                        <span class="truncate">{{ $slide->link }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <a href="{{ route('admin.carousel.edit', $slide) }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-indigo-600 rounded-lg hover:bg-indigo-50 focus:ring-4 focus:ring-indigo-300 dark:text-indigo-400 dark:hover:bg-indigo-900/20 dark:focus:ring-indigo-800 transition-colors" title="Editar">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <button type="button" data-modal-target="delete-modal-{{ $slide->id }}" data-modal-toggle="delete-modal-{{ $slide->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-red-600 rounded-lg hover:bg-red-50 focus:ring-4 focus:ring-red-300 dark:text-red-400 dark:hover:bg-red-900/20 dark:focus:ring-red-800 transition-colors" title="Excluir">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165l0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal - Flowbite Modal -->
                    <div id="delete-modal-{{ $slide->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-slate-800">
                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-hide="delete-modal-{{ $slide->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Fechar</span>
                                </button>
                                <div class="p-4 md:p-5 text-center">
                                    <svg class="mx-auto mb-4 w-12 h-12 text-gray-400 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Tem certeza que deseja excluir este slide?</h3>
                                    <form action="{{ route('admin.carousel.destroy', $slide) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button data-modal-hide="delete-modal-{{ $slide->id }}" type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                            Sim, excluir
                                        </button>
                                    </form>
                                    <button data-modal-hide="delete-modal-{{ $slide->id }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-indigo-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-slate-800 dark:text-gray-400 dark:border-slate-600 dark:hover:text-white dark:hover:bg-slate-700">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Empty State - Flowbite Card -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                </svg>
            </div>
            <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Nenhum slide cadastrado</h3>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">Comece criando seu primeiro slide do carousel</p>
            <a href="{{ route('admin.carousel.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Criar Primeiro Slide
            </a>
        </div>
    @endif
</div>

@push('scripts')
@vite(['resources/js/carousel-admin.js'])
@endpush
@endsection
