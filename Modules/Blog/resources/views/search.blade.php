@extends('blog::layouts.blog')

@section('title', 'Buscar: "' . $query . '" - Blog VERTEXSEMAGRI')
@section('meta_description', 'Resultados da busca por "' . $query . '" no blog oficial da Secretaria Municipal de Agricultura')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('homepage') }}" class="text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">Início</a></li>
            <li><span class="text-gray-300 dark:text-gray-600">/</span></li>
            <li><a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">Blog</a></li>
            <li><span class="text-gray-300 dark:text-gray-600">/</span></li>
            <li><span class="text-emerald-600 dark:text-emerald-400 font-medium">Busca</span></li>
        </ol>
    </nav>

    <!-- Header da Busca -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Resultados da Busca</h1>
        <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto mb-6">
            Resultados para: <span class="font-semibold text-emerald-600 dark:text-emerald-400">"{!! e($query) !!}"</span>
        </p>

        <!-- Formulário de busca -->
        <form action="{{ route('blog.search') }}" method="GET" class="max-w-md mx-auto">
            <div class="relative">
                <input type="text" name="q" value="{{ $query }}"
                    class="w-full px-4 py-3 pl-12 pr-4 text-gray-900 dark:text-gray-100 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    placeholder="Buscar no blog...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-icon name="magnifying-glass" class="w-5 h-5 text-gray-400" />
                </div>
            </div>
        </form>
    </div>

    <!-- Resultados da Busca -->
    @if($posts->count() > 0)
        <div class="mb-6">
            <p class="text-gray-600 dark:text-gray-400">
                {{ $posts->total() }} resultado{{ $posts->total() !== 1 ? 's' : '' }} encontrado{{ $posts->total() !== 1 ? 's' : '' }}
            </p>
        </div>

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
        <!-- Nenhum resultado encontrado -->
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <x-icon name="magnifying-glass" class="w-12 h-12 text-gray-400" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Nenhum resultado encontrado</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Não encontramos artigos que correspondam à sua busca por "{!! e($query) !!}".
            </p>

            <div class="space-y-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Sugestões:</p>
                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                    <li>• Verifique se há erros de digitação</li>
                    <li>• Use palavras-chave mais simples</li>
                    <li>• Tente termos relacionados</li>
                </ul>
            </div>

            <div class="mt-8">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors mr-4">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                    Voltar ao Blog
                </a>
                <a href="{{ route('homepage') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                    <x-icon name="home" class="w-4 h-4 mr-2" />
                    Página Inicial
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
