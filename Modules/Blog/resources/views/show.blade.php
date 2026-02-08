@extends('blog::layouts.blog')

@section('title', $post->meta_title ?: $post->title)
@section('meta_description', $post->meta_description ?: $post->excerpt)
@section('meta_keywords', $post->meta_keywords ? implode(', ', $post->meta_keywords) : '')

@section('og_type', 'article')
@section('og_title', $post->title)
@section('og_description', $post->excerpt)
@section('og_image', $post->featured_image ? Storage::url($post->featured_image) : asset('images/logo-social.png'))

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="{{ route('homepage') }}" class="text-gray-600 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 transition-colors">Início</a></li>
            <li><span class="text-gray-400 dark:text-gray-600">/</span></li>
            <li><a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 transition-colors">Blog</a></li>
            <li><span class="text-gray-400 dark:text-gray-600">/</span></li>
            <li><a href="{{ route('blog.category', $post->category->slug) }}" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">{{ $post->category->name }}</a></li>
            <li><span class="text-gray-400 dark:text-gray-600">/</span></li>
            <li><span class="text-gray-900 dark:text-gray-100 font-medium truncate">{{ Str::limit($post->title, 60) }}</span></li>
        </ol>
    </nav>

    <!-- Post Header -->
    <header class="mb-12">
        <!-- Category Badge -->
        <div class="mb-6">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! \App\Helpers\ModuleIcons::getIconPath('Blog') !!}
                </svg>
                {{ $post->category->name }}
            </span>
        </div>

        <!-- Post Title -->
        <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
            {{ $post->title }}
        </h1>

        <!-- Post Excerpt -->
        @if($post->excerpt)
        <div class="text-xl text-gray-700 dark:text-gray-300 leading-relaxed mb-8 font-light italic border-l-4 border-emerald-500 pl-6">
            "{{ $post->excerpt }}"
        </div>
        @endif

        <!-- Author and Meta Info Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-8 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <!-- Author -->
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-xl">
                            {{ substr($post->author->name, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Publicado por</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $post->author->name }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <time datetime="{{ $post->published_at->toISOString() }}">
                                {{ $post->published_at->format('d M Y \à\s H:i') }}
                            </time>
                        </div>
                    </div>
                </div>

                <!-- Meta Stats -->
                <div class="flex flex-wrap items-center gap-6 text-sm">
                    <div class="flex items-center space-x-2 px-4 py-2 bg-gray-50 dark:bg-slate-700 rounded-lg">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">{{ $post->reading_time }} min de leitura</span>
                    </div>
                    <div class="flex items-center space-x-2 px-4 py-2 bg-gray-50 dark:bg-slate-700 rounded-lg">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span class="font-medium">{{ $post->views()->count() }} visualizações</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tags -->
        @if($post->tags->count() > 0)
        <div class="flex flex-wrap gap-3 mb-8">
            @foreach($post->tags as $tag)
            <a href="{{ route('blog.tag', $tag->slug) }}"
               class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-emerald-50 to-emerald-100 text-emerald-800 hover:from-emerald-100 hover:to-emerald-200 dark:from-emerald-900 dark:to-emerald-800 dark:text-emerald-300 dark:hover:from-emerald-800 dark:hover:to-emerald-700 transition-all duration-200 shadow-sm hover:shadow-md border border-emerald-200 dark:border-emerald-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                {{ $tag->name }}
            </a>
            @endforeach
        </div>
        @endif

        <!-- Featured Image -->
        @if($post->featured_image)
        <div class="mb-8">
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                 class="w-full h-96 object-cover rounded-lg shadow-lg">
        </div>
        @endif

        <!-- Gallery Images -->
        @if($post->gallery_images && count($post->gallery_images) > 0)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-6 h-6 mr-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Galeria de Imagens
                </h3>
                <span class="text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-slate-700 px-3 py-1 rounded-full">
                    {{ count($post->gallery_images) }} {{ count($post->gallery_images) === 1 ? 'imagem' : 'imagens' }}
                </span>
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($post->gallery_images as $index => $image)
                <div class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-1"
                     onclick="openGalleryModal({{ $index }})">
                    <div class="aspect-square overflow-hidden">
                        <img src="{{ Storage::url($image) }}"
                             alt="Imagem {{ $index + 1 }} - {{ $post->title }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="flex items-center justify-between text-white">
                                <span class="text-sm font-medium">Imagem {{ $index + 1 }}</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- Hover border effect -->
                    <div class="absolute inset-0 rounded-xl ring-2 ring-transparent group-hover:ring-emerald-400 transition-all duration-300"></div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Gallery Modal -->
        <div id="gallery-modal" class="fixed inset-0 bg-black bg-opacity-95 hidden z-50 flex items-center justify-center p-4">
            <div class="relative w-full max-w-6xl max-h-screen">
                <!-- Close Button -->
                <button id="close-gallery-modal"
                        class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors z-60 bg-black bg-opacity-50 hover:bg-opacity-70 rounded-full p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Image Counter -->
                <div class="absolute -top-12 left-0 text-white text-sm bg-black bg-opacity-50 px-3 py-1 rounded-full">
                    <span id="image-counter">1</span> / {{ count($post->gallery_images) }}
                </div>

                <!-- Main Image -->
                <div id="gallery-modal-content" class="relative bg-black rounded-2xl overflow-hidden shadow-2xl">
                    @foreach($post->gallery_images as $index => $image)
                    <div class="gallery-modal-slide {{ $index === 0 ? 'block' : 'hidden' }}" data-slide="{{ $index }}">
                        <img src="{{ Storage::url($image) }}"
                             alt="Imagem {{ $index + 1 }} - {{ $post->title }}"
                             class="w-full h-auto max-h-screen object-contain">
                    </div>
                    @endforeach
                </div>

                <!-- Navigation Buttons -->
                @if(count($post->gallery_images) > 1)
                <button id="modal-prev"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 bg-black bg-opacity-50 hover:bg-opacity-70 rounded-full p-3 transition-all duration-200 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button id="modal-next"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 bg-black bg-opacity-50 hover:bg-opacity-70 rounded-full p-3 transition-all duration-200 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Thumbnail Navigation -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 bg-black bg-opacity-50 rounded-full px-4 py-2">
                    @foreach($post->gallery_images as $index => $image)
                    <button class="gallery-thumbnail w-3 h-3 rounded-full bg-white bg-opacity-50 {{ $index === 0 ? 'bg-opacity-100' : '' }} transition-all duration-200 hover:scale-125"
                            data-slide="{{ $index }}"
                            onclick="goToSlide({{ $index }})">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Excerpt -->
        @if($post->excerpt)
        <div class="text-xl text-gray-600 dark:text-gray-400 leading-relaxed mb-8 p-6 bg-gray-50 dark:bg-slate-800 rounded-lg border-l-4 border-emerald-500">
            {{ $post->excerpt }}
        </div>
        @endif
    </header>

    <!-- Post Content -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-8 lg:p-12 mb-8">
        <div class="prose prose-lg prose-emerald dark:prose-invert max-w-none prose-headings:text-gray-900 dark:prose-headings:text-white prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-strong:text-gray-900 dark:prose-strong:text-white prose-ul:text-gray-700 dark:prose-ul:text-gray-300 prose-ol:text-gray-700 dark:prose-ol:text-gray-300">
            {!! htmlspecialchars_decode($post->content) !!}
        </div>
    </div>

    <!-- Gallery Images -->
    @if($post->gallery_images && count($post->gallery_images) > 0)
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Galeria de Imagens</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($post->gallery_images as $image)
            <div class="aspect-video bg-gray-200 dark:bg-slate-700 rounded-lg overflow-hidden">
                <img src="{{ Storage::url($image) }}" alt="Imagem da galeria"
                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                     onclick="openImageModal('{{ Storage::url($image) }}')">
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Module Data (se gerado automaticamente) -->
    @if($post->module_data && $post->auto_generated_from)
    <div class="mb-8 p-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Dados Relacionados - {{ ucfirst($post->auto_generated_from) }}
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            @foreach($post->module_data as $key => $value)
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $value }}</div>
                <div class="text-blue-800 dark:text-blue-200 capitalize">{{ str_replace('_', ' ', $key) }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Tags -->
    @if($post->tags->count() > 0)
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Tags</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($post->tags as $tag)
            <a href="{{ route('blog.tag', $tag->slug) }}"
               class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 transition-colors">
                #{{ $tag->name }}
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Share Buttons -->
    <div class="mb-8 p-6 bg-gray-50 dark:bg-slate-800 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Compartilhar</h3>
        <div class="flex flex-wrap gap-3">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
               target="_blank" rel="noopener"
               class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
               target="_blank" rel="noopener"
               class="flex items-center px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
                Twitter
            </a>
            <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url()->current()) }}"
               target="_blank" rel="noopener"
               class="flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.085"/>
                </svg>
                WhatsApp
            </a>
            <button onclick="copyToClipboard('{{ url()->current() }}')"
                    class="flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Copiar Link
            </button>
        </div>
    </div>

    <!-- Comments Section -->
    @if($post->allow_comments)
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            Comentários ({{ $post->approvedComments->count() }})
        </h3>

        <!-- Existing Comments -->
        @if($post->approvedComments->count() > 0)
        <div class="space-y-4 mb-8">
            @foreach($post->approvedComments as $comment)
            <div class="bg-gray-50 dark:bg-slate-700 rounded-lg p-4">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">{{ substr($comment->user->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name ?? 'Anônimo' }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Comment Form -->
        @auth
        <div class="border-t border-gray-200 dark:border-slate-700 pt-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Deixe seu comentário</h4>
            <form action="{{ route('blog.comments.store', $post->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <textarea name="content" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100"
                              placeholder="Digite seu comentário..."></textarea>
                </div>
                <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium">
                    Enviar Comentário
                </button>
            </form>
        </div>
        @else
        <div class="text-center py-8">
            <p class="text-gray-600 dark:text-gray-400 mb-4">Faça login para comentar</p>
            <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                Fazer Login
            </a>
        </div>
        @endauth
    </div>
    @endif

    <!-- Navigation -->
    @if($previousPost || $nextPost)
    <nav class="mb-8">
        <div class="flex justify-between items-center">
            @if($previousPost)
            <a href="{{ route('blog.show', $previousPost->slug) }}"
               class="flex items-center p-4 bg-white dark:bg-slate-800 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 dark:border-slate-700 max-w-sm">
                <div class="mr-4">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Post Anterior</div>
                    <div class="font-medium text-gray-900 dark:text-gray-100 line-clamp-2">{{ $previousPost->title }}</div>
                </div>
            </a>
            @else
            <div></div>
            @endif

            @if($nextPost)
            <a href="{{ route('blog.show', $nextPost->slug) }}"
               class="flex items-center p-4 bg-white dark:bg-slate-800 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 dark:border-slate-700 max-w-sm text-right">
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Próximo Post</div>
                    <div class="font-medium text-gray-900 dark:text-gray-100 line-clamp-2">{{ $nextPost->title }}</div>
                </div>
                <div class="ml-4">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            @endif
        </div>
    </nav>
    @endif
</article>

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-gray-200 dark:border-slate-700">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Posts Relacionados</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($relatedPosts as $relatedPost)
        <article class="bg-white dark:bg-slate-800 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 dark:border-slate-700">
            @if($relatedPost->featured_image)
            <div class="aspect-video bg-gray-200 dark:bg-slate-700 rounded-t-lg overflow-hidden">
                <img src="{{ Storage::url($relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}"
                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
            </div>
            @endif
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2 line-clamp-2">
                    <a href="{{ route('blog.show', $relatedPost->slug) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                        {{ $relatedPost->title }}
                    </a>
                </h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-3">
                    {{ $relatedPost->excerpt }}
                </p>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $relatedPost->published_at->format('d/m/Y') }}
                </div>
            </div>
        </article>
        @endforeach
    </div>
</section>
@endif

<!-- Comments Section -->
@if($post->allow_comments)
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-gray-200 dark:border-slate-700">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
        Comentários ({{ $post->approvedComments->count() }})
    </h2>

    <!-- Comment Form -->
    <div class="mb-8 p-6 bg-gray-50 dark:bg-slate-800 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Deixe seu comentário</h3>
        <form action="{{ route('blog.comments.store', $post->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                @guest
                <div>
                    <label for="author_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nome *</label>
                    <input type="text" id="author_name" name="author_name" required
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label for="author_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">E-mail *</label>
                    <input type="email" id="author_email" name="author_email" required
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                @endguest
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comentário *</label>
                <textarea id="content" name="content" rows="4" required
                          class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                          placeholder="Escreva seu comentário..."></textarea>
            </div>
            <button type="submit"
                    class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors">
                Enviar Comentário
            </button>
        </form>
    </div>

    <!-- Comments List -->
    @if($post->approvedComments->count() > 0)
    <div class="space-y-6">
        @foreach($post->approvedComments->where('parent_id', null) as $comment)
        <div class="bg-white dark:bg-slate-800 rounded-lg p-6 border border-gray-200 dark:border-slate-700">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($comment->author_display_name, 0, 1)) }}
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-2">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $comment->author_display_name }}</h4>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $comment->created_at->format('d/m/Y \à\s H:i') }}
                        </span>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $comment->content }}</p>

                    <!-- Replies -->
                    @if($comment->replies->count() > 0)
                    <div class="mt-4 space-y-4">
                        @foreach($comment->replies as $reply)
                        <div class="bg-gray-50 dark:bg-slate-700 rounded-lg p-4 ml-8">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr($reply->author_display_name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <h5 class="font-medium text-gray-900 dark:text-gray-100">{{ $reply->author_display_name }}</h5>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $reply->created_at->format('d/m/Y \à\s H:i') }}
                                        </span>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $reply->content }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-8">
        <p class="text-gray-500 dark:text-gray-400">Seja o primeiro a comentar!</p>
    </div>
    @endif
</section>
@endif

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4" onclick="closeImageModal()">
    <img id="modalImage" src="" alt="Imagem ampliada" class="max-w-full max-h-full object-contain">
    <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300">×</button>
</div>
@endsection

@push('styles')
<style>
/* Custom animations and styles for the blog */
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}

/* Improve prose styling */
.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    font-weight: 700;
    line-height: 1.2;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose h1 { font-size: 2.25rem; }
.prose h2 { font-size: 1.875rem; }
.prose h3 { font-size: 1.5rem; }

.prose p {
    margin-bottom: 1.5rem;
    line-height: 1.7;
}

.prose ul, .prose ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose blockquote {
    border-left: 4px solid rgb(16 185 129);
    padding-left: 1rem;
    font-style: italic;
    background: rgb(236 253 245);
    padding: 1rem;
    border-radius: 0.5rem;
    margin: 1.5rem 0;
}

.dark .prose blockquote {
    background: rgb(4 47 46);
    border-left-color: rgb(16 185 129);
}

/* Gallery hover effects */
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

/* Modal improvements */
#gallery-modal img {
    transition: transform 0.3s ease;
}

#gallery-modal img:hover {
    transform: scale(1.02);
}
</style>
@endpush

@push('scripts')
<script>
let currentSlide = 0;
const totalSlides = {{ count($post->gallery_images ?? []) }};

// Gallery Carousel Functions
function initGalleryCarousel() {
    if (totalSlides <= 1) return;

    const carousel = document.getElementById('gallery-carousel');
    const prevBtn = document.getElementById('gallery-prev');
    const nextBtn = document.getElementById('gallery-next');
    const indicators = document.querySelectorAll('.gallery-indicator');

    function updateCarousel() {
        if (carousel) {
            carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        // Update indicators
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('bg-opacity-100', index === currentSlide);
            indicator.classList.toggle('bg-opacity-50', index !== currentSlide);
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1;
            updateCarousel();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0;
            updateCarousel();
        });
    }

    // Indicator clicks
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentSlide = index;
            updateCarousel();
        });
    });

    // Auto-play (optional)
    setInterval(() => {
        currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0;
        updateCarousel();
    }, 5000);
}

// Gallery Modal Functions
function openGalleryModal(startIndex = 0) {
    currentSlide = startIndex;
    const modal = document.getElementById('gallery-modal');
    if (modal) {
        modal.classList.remove('hidden');
        updateModalSlide();
        document.body.style.overflow = 'hidden';

        // Add entrance animation
        modal.querySelector('#gallery-modal-content').classList.add('animate-fade-in');
    }
}

function closeGalleryModal() {
    const modal = document.getElementById('gallery-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

function updateModalSlide() {
    const slides = document.querySelectorAll('.gallery-modal-slide');
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    const counter = document.getElementById('image-counter');

    slides.forEach((slide, index) => {
        slide.classList.toggle('block', index === currentSlide);
        slide.classList.toggle('hidden', index !== currentSlide);
    });

    // Update thumbnails
    thumbnails.forEach((thumb, index) => {
        thumb.classList.toggle('bg-opacity-100', index === currentSlide);
        thumb.classList.toggle('bg-opacity-50', index !== currentSlide);
    });

    // Update counter
    if (counter) {
        counter.textContent = currentSlide + 1;
    }
}

function goToSlide(index) {
    currentSlide = index;
    updateModalSlide();
}

// Modal Navigation
document.addEventListener('DOMContentLoaded', function() {
    initGalleryCarousel();

    // Modal controls
    const closeBtn = document.getElementById('close-gallery-modal');
    const modalPrev = document.getElementById('modal-prev');
    const modalNext = document.getElementById('modal-next');
    const modal = document.getElementById('gallery-modal');

    if (closeBtn) {
        closeBtn.addEventListener('click', closeGalleryModal);
    }

    if (modalPrev && totalSlides > 1) {
        modalPrev.addEventListener('click', () => {
            currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1;
            updateModalSlide();
        });
    }

    if (modalNext && totalSlides > 1) {
        modalNext.addEventListener('click', () => {
            currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0;
            updateModalSlide();
        });
    }

    // Close modal on background click
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeGalleryModal();
            }
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (modal && !modal.classList.contains('hidden')) {
            if (e.key === 'Escape') {
                closeGalleryModal();
            } else if (e.key === 'ArrowLeft' && totalSlides > 1) {
                currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1;
                updateModalSlide();
            } else if (e.key === 'ArrowRight' && totalSlides > 1) {
                currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0;
                updateModalSlide();
            }
        }
    });
});

// Make functions globally available
window.openGalleryModal = openGalleryModal;
window.goToSlide = goToSlide;
</script>
@endpush

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = button.innerHTML.replace('Copiar Link', 'Copiado!');
        button.classList.add('bg-green-600');
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('bg-green-600');
        }, 2000);
    });
}

function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Comment reply functions
function showReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    if (form) {
        form.classList.remove('hidden');
    }
}

function hideReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    if (form) {
        form.classList.add('hidden');
    }
}
</script>
@endpush
