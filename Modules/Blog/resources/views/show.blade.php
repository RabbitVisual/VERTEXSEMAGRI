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
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300 shadow-sm border border-emerald-200 dark:border-emerald-800">
                <x-icon module="Blog" class="w-4 h-4 mr-2" />
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
                    <div class="flex items-center space-x-2 px-4 py-2 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-100 dark:border-slate-600">
                        <x-icon name="clock" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                        <span class="font-medium">{{ $post->reading_time }} min de leitura</span>
                    </div>
                    <div class="flex items-center space-x-2 px-4 py-2 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-100 dark:border-slate-600">
                        <x-icon name="eye" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                        <span class="font-medium">{{ $post->views_count }} visualizações</span>
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
                <x-icon name="tag" class="w-4 h-4 mr-2" />
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
                    <x-icon name="images" class="w-6 h-6 mr-3 text-emerald-600 dark:text-emerald-400" />
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
                                <x-icon name="magnifying-glass-plus" class="w-5 h-5" />
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
                    <x-icon name="xmark" class="w-6 h-6" />
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
                    <x-icon name="chevron-left" class="w-6 h-6" />
                </button>
                <button id="modal-next"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 bg-black bg-opacity-50 hover:bg-opacity-70 rounded-full p-3 transition-all duration-200 hover:scale-110">
                    <x-icon name="chevron-right" class="w-6 h-6" />
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

    </header>

    <!-- Attachments -->
    @if($post->attachments && count($post->attachments) > 0)
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-emerald-100 dark:border-slate-700 p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <x-icon name="paperclip" class="w-6 h-6 mr-3 text-emerald-600 dark:text-emerald-400" />
            Anexos e Documentos
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($post->attachments as $attachment)
            <a href="{{ Storage::url($attachment['path']) }}" target="_blank"
               class="flex items-center p-4 bg-gray-50 dark:bg-slate-700/50 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-xl border border-gray-200 dark:border-slate-600 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all duration-300 group">
                <div class="p-3 bg-red-100 dark:bg-red-900/40 rounded-lg group-hover:scale-110 transition-transform">
                    <x-icon name="file-pdf" class="w-6 h-6 text-red-600 dark:text-red-400" />
                </div>
                <div class="ml-4 overflow-hidden">
                    <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $attachment['name'] }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 uppercase font-bold tracking-widest mt-1">PDF Document</div>
                </div>
                <x-icon name="download" class="w-4 h-4 ml-auto text-gray-400 group-hover:text-emerald-600 transition-colors" />
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Post Content -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-8 lg:p-12 mb-8">
        <div class="prose prose-lg prose-emerald dark:prose-invert max-w-none prose-headings:text-gray-900 dark:prose-headings:text-white prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-strong:text-gray-900 dark:prose-strong:text-white prose-ul:text-gray-700 dark:prose-ul:text-gray-300 prose-ol:text-gray-700 dark:prose-ol:text-gray-300">
            {!! htmlspecialchars_decode($post->content) !!}
        </div>
    </div>

    <!-- Module Data (se gerado automaticamente) -->
    @if($post->module_data && $post->auto_generated_from)
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-blue-100 dark:border-blue-900/30 p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <x-icon name="chart-mixed" class="w-6 h-6 mr-3 text-blue-600 dark:text-blue-400" />
            Dados Relacionados - {{ ucfirst($post->auto_generated_from) }}
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($post->module_data as $key => $value)
            <div class="p-4 bg-blue-50/50 dark:bg-blue-900/10 rounded-xl border border-blue-100 dark:border-blue-800/50 text-center">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ $value }}</div>
                <div class="text-xs text-blue-800/70 dark:text-blue-300/70 uppercase font-bold tracking-widest">{{ str_replace('_', ' ', $key) }}</div>
            </div>
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
               class="flex items-center px-4 py-2 bg-[#1877F2] hover:bg-[#166fe5] text-white rounded-lg transition-colors font-medium">
                <x-icon name="facebook" brand class="w-4 h-4 mr-2" />
                Facebook
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
               target="_blank" rel="noopener"
               class="flex items-center px-4 py-2 bg-[#1DA1F2] hover:bg-[#1a91da] text-white rounded-lg transition-colors font-medium">
                <x-icon name="twitter" brand class="w-4 h-4 mr-2" />
                Twitter
            </a>
            <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url()->current()) }}"
               target="_blank" rel="noopener"
               class="flex items-center px-4 py-2 bg-[#25D366] hover:bg-[#21bd5c] text-white rounded-lg transition-colors font-medium">
                <x-icon name="whatsapp" brand class="w-4 h-4 mr-2" />
                WhatsApp
            </a>
            <button onclick="copyToClipboard('{{ url()->current() }}')"
                    class="flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors font-medium">
                <x-icon name="copy" class="w-4 h-4 mr-2" />
                Copiar Link
            </button>
        </div>
    </div>

    <!-- Comments Section -->
    @if($post->allow_comments)
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <x-icon name="comments" class="w-6 h-6 mr-3 text-emerald-600 dark:text-emerald-400" />
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
               class="flex items-center p-4 bg-white dark:bg-slate-800 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 dark:border-slate-700 max-w-sm group">
                <div class="mr-4">
                    <x-icon name="chevron-left" class="w-6 h-6 text-gray-400 group-hover:text-emerald-600 transition-colors" />
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
               class="flex items-center p-4 bg-white dark:bg-slate-800 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 dark:border-slate-700 max-w-sm text-right group">
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Próximo Post</div>
                    <div class="font-medium text-gray-900 dark:text-gray-100 line-clamp-2">{{ $nextPost->title }}</div>
                </div>
                <div class="ml-4">
                    <x-icon name="chevron-right" class="w-6 h-6 text-gray-400 group-hover:text-emerald-600 transition-colors" />
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
