@extends('blog::layouts.blog')

@section('title', 'Blog - Notícias e Novidades')
@section('meta_description', 'Acompanhe as últimas notícias, novidades e informações da Secretaria Municipal de Agricultura de Coração de Maria - BA.')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white bg-opacity-20 backdrop-blur-sm rounded-full mb-6 shadow-lg">
                <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! \App\Helpers\ModuleIcons::getIconPath('Blog') !!}
                </svg>
            </div>
            <h1 class="text-4xl lg:text-6xl xl:text-7xl font-bold mb-6 leading-tight text-white drop-shadow-lg">
                Blog <span class="text-emerald-200 drop-shadow-md">VERTEXSEMAGRI</span>
            </h1>
            <p class="text-lg lg:text-xl xl:text-2xl text-emerald-50 max-w-4xl mx-auto leading-relaxed drop-shadow-md font-light">
                Notícias, novidades e informações da Secretaria Municipal de Agricultura de Coração de Maria - BA
            </p>
        </div>

        <!-- Featured Posts -->
        @if($featuredPosts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredPosts as $post)
            <article class="bg-white bg-opacity-95 backdrop-blur-md rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-white border-opacity-30 text-gray-900">
                @if($post->featured_image)
                <div class="aspect-video overflow-hidden">
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800 shadow-sm">
                            {{ $post->category->name }}
                        </span>
                        <time class="text-sm text-gray-600">
                            {{ $post->published_at->format('d M Y') }}
                        </time>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 line-clamp-2 leading-tight">
                        <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-emerald-600 transition-colors">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <p class="text-gray-700 text-sm line-clamp-3 mb-6 leading-relaxed">
                        {!! Str::limit(strip_tags($post->excerpt ?? $post->content), 120) !!}
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ $post->views()->count() }}
                            </span>
                            <span>{{ $post->reading_time }} min</span>
                        </div>
                        <a href="{{ route('blog.show', $post->slug) }}"
                           class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors text-sm shadow-sm hover:shadow-md">
                            Ler mais
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @endif
    </div>
</section>

<!-- Main Content -->
<section class="bg-gray-50 dark:bg-slate-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Posts List -->
            <div class="lg:col-span-3">
                <!-- Header and Filters -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-6 mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Últimas Publicações</h2>
                            <p class="text-gray-600 dark:text-gray-400">Acompanhe as novidades e informações mais recentes</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Filtrar por:</span>
                            <select onchange="window.location.href = this.value"
                                    class="border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                <option value="{{ route('blog.index') }}">Todas as categorias</option>
                                @foreach($categories as $category)
                                <option value="{{ route('blog.category', $category->slug) }}"
                                        {{ request()->route('slug') === $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->published_posts_count }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <form action="{{ route('blog.search') }}" method="GET" class="mb-6">
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar artigos..."
                                   class="w-full px-4 py-3 pl-12 pr-4 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            @if(request('q'))
                            <button type="button" onclick="window.location.href='{{ route('blog.index') }}'"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Posts Grid -->
                @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    @foreach($posts as $post)
                    <article class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group border border-gray-200 dark:border-slate-700">
                        @if($post->featured_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        @endif

                        <div class="p-6">
                            <!-- Category Badge & Date -->
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300 shadow-sm">
                                    {{ $post->category->name }}
                                </span>
                                <time class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $post->published_at->format('d M Y') }}
                                </time>
                            </div>

                            <!-- Title -->
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                                <a href="{{ route('blog.show', $post->slug) }}"
                                   class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors line-clamp-2">
                                    {{ $post->title }}
                                </a>
                            </h2>

                            <!-- Excerpt -->
                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-6 leading-relaxed">
                                {!! Str::limit(strip_tags($post->excerpt ?? $post->content), 150) !!}
                            </p>

                            <!-- Meta Info & CTA -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ $post->views()->count() }}
                                    </span>
                                    @if($post->allow_comments)
                                    <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 01-9 9 9.75 9.75 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                        {{ $post->approvedComments->count() }}
                                    </span>
                                    @endif
                                    <span>{{ $post->reading_time }} min</span>
                                </div>
                                <a href="{{ route('blog.show', $post->slug) }}"
                                   class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors text-sm shadow-sm hover:shadow-md">
                                    Ler mais
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>

                            <!-- Tags -->
                            @if($post->tags->count() > 0)
                            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-slate-700">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($post->tags->take(3) as $tag)
                                    <a href="{{ route('blog.tag', $tag->slug) }}"
                                       class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 transition-all duration-200 hover:shadow-sm">
                                        {{ $tag->name }}
                                    </a>
                                    @endforeach
                                    @if($post->tags->count() > 3)
                                    <span class="text-sm text-gray-500 dark:text-gray-400 px-3 py-1">
                                        +{{ $post->tags->count() - 3 }} mais
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </article>
                    @endforeach
                </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $posts->links() }}
            </div>
                @else
                <!-- No posts found -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! \App\Helpers\ModuleIcons::getIconPath('Blog') !!}
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Nenhum artigo encontrado</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                        Não há artigos publicados no blog ainda. Volte em breve para ver as novidades da Secretaria Municipal de Agricultura.
                    </p>
                    <a href="{{ route('homepage') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Voltar ao Início
                    </a>
                </div>
                @endif
        </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-1 space-y-8">
                <!-- Categories -->
                @if($categories->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-6">
                    <div class="flex items-center mb-6">
                        <svg class="w-5 h-5 mr-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Categorias</h3>
                    </div>
                    <ul class="space-y-1">
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('blog.category', $category->slug) }}"
                               class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 transition-all duration-200 group">
                                <span class="text-gray-700 dark:text-gray-300 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ $category->name }}</span>
                                <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900 px-2 py-1 rounded-full">
                                    {{ $category->published_posts_count }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Popular Tags -->
                @if($popularTags->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-6">
                    <div class="flex items-center mb-6">
                        <svg class="w-5 h-5 mr-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tags Populares</h3>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @foreach($popularTags->take(8) as $tag)
                        <a href="{{ route('blog.tag', $tag->slug) }}"
                           class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-emerald-50 to-emerald-100 text-emerald-800 hover:from-emerald-100 hover:to-emerald-200 dark:from-emerald-900 dark:to-emerald-800 dark:text-emerald-300 dark:hover:from-emerald-800 dark:hover:to-emerald-700 transition-all duration-200 shadow-sm hover:shadow-md border border-emerald-200 dark:border-emerald-700">
                            {{ $tag->name }}
                            <span class="ml-2 text-xs bg-emerald-200 dark:bg-emerald-700 px-2 py-0.5 rounded-full">{{ $tag->published_posts_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Newsletter/Info Card -->
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-lg font-bold mb-2">Fique por Dentro</h3>
                        <p class="text-emerald-100 text-sm mb-4">Receba as últimas novidades da Secretaria Municipal de Agricultura diretamente no seu email.</p>
                        <a href="{{ route('homepage') }}" class="inline-flex items-center px-4 py-2 bg-white text-emerald-600 rounded-lg font-medium hover:bg-emerald-50 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Saiba Mais
                        </a>
                    </div>
                </div>

                <!-- Recent Posts -->
                @if($posts->count() > 3)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 p-6">
                    <div class="flex items-center mb-6">
                        <svg class="w-5 h-5 mr-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Posts Recentes</h3>
                    </div>
                    <div class="space-y-4">
                        @foreach($posts->take(5) as $recentPost)
                        <div class="border-b border-gray-100 dark:border-slate-700 last:border-b-0 pb-4 last:pb-0">
                            <a href="{{ route('blog.show', $recentPost->slug) }}" class="group">
                                <h4 class="font-medium text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors line-clamp-2 mb-1">
                                    {{ $recentPost->title }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $recentPost->published_at->format('d M Y') }}
                                </p>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
        </aside>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Custom styles for blog index page */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Improve hover effects */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

/* Enhanced card shadows */
.shadow-lg:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Gradient text effects */
.text-emerald-200 {
    background: linear-gradient(135deg, #a7f3d0, #6ee7b7);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

/* Custom focus states */
.focus\:ring-emerald-500:focus {
    --tw-ring-color: rgb(16 185 129 / var(--tw-ring-opacity));
}

/* Enhanced mobile responsiveness */
@media (max-width: 768px) {
    .aspect-video {
        aspect-ratio: 16 / 9;
    }

    .grid-cols-1.md\\:grid-cols-2 {
        grid-template-columns: 1fr;
    }
}

/* Dark mode enhancements */
.dark .bg-white {
    background-color: rgb(30 41 59);
}

.dark .bg-gray-50 {
    background-color: rgb(17 24 39);
}

/* Custom scrollbar for sidebar */
aside::-webkit-scrollbar {
    width: 4px;
}

aside::-webkit-scrollbar-track {
    background: transparent;
}

aside::-webkit-scrollbar-thumb {
    background: rgb(16 185 129);
    border-radius: 2px;
}

aside::-webkit-scrollbar-thumb:hover {
    background: rgb(5 150 105);
}
</style>
@endpush
