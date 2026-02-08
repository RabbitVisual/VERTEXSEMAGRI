@extends('blog::layouts.blog')

@section('title', $category->name . ' - Blog VERTEXSEMAGRI')
@section('meta_description', 'Artigos da categoria ' . $category->name . ' no blog oficial da Secretaria Municipal de Agricultura')
@section('meta_keywords', $category->name . ', blog, noticias, secretaria agricultura')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('homepage') }}" class="text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">Início</a></li>
            <li><span class="text-gray-300 dark:text-gray-600">/</span></li>
            <li><a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">Blog</a></li>
            <li><span class="text-gray-300 dark:text-gray-600">/</span></li>
            <li><span class="text-emerald-600 dark:text-emerald-400 font-medium">{{ $category->name }}</span></li>
        </ol>
    </nav>

    <!-- Header da Categoria -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">{{ $category->description }}</p>
        @endif
    </div>

    <!-- Posts da Categoria -->
    @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($posts as $post)
                <article class="bg-white dark:bg-slate-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                    @if($post->featured_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ asset('storage/' . $post->featured_image) }}"
                                 alt="{{ $post->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">
                                {{ $post->category->name }}
                            </span>
                            @if($post->is_featured)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                    Destaque
                                </span>
                            @endif
                        </div>

                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h2>

                        <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                            {!! Str::limit(strip_tags($post->excerpt ?? $post->content), 150) !!}
                        </p>

                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center gap-2">
                                @if($post->author)
                                    <span>Por {{ $post->author->name }}</span>
                                @endif
                                <span>{{ $post->published_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span>{{ $post->views()->count() }} visualizações</span>
                                @if($post->comments->count() > 0)
                                    <span>{{ $post->comments->count() }} comentários</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $posts->links() }}
        </div>
    @else
        <!-- Nenhum post encontrado -->
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <x-module-icon module="Blog" class="w-12 h-12 text-gray-400" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Nenhum artigo encontrado</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Não há artigos publicados nesta categoria ainda.</p>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Voltar ao Blog
            </a>
        </div>
    @endif
</div>
@endsection
