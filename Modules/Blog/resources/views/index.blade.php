@extends('blog::layouts.blog')

@section('title', 'Jornal Oficial - Notícias e Transparência')
@section('meta_description', 'Portal de notícias oficiais do município. Acompanhe as obras, editais e ações do governo.')

@section('content')
<div class="font-sans antialiased text-gray-900 bg-white dark:bg-slate-900">

    
    <!-- Hero Slider (Featured News) -->
    @if($featuredPosts->count() > 0)
    <div class="relative w-full overflow-hidden bg-gray-900" x-data="{ activeSlide: 0, slides: {{ $featuredPosts->count() }}, timer: null }" x-init="timer = setInterval(() => { activeSlide = (activeSlide === slides - 1) ? 0 : activeSlide + 1 }, 6000)">
        <!-- Slides -->
        <div class="relative h-[400px] md:h-[500px]">
            @foreach($featuredPosts as $index => $post)
            <div x-show="activeSlide === {{ $index }}"
            <div x-show="activeSlide === {{ $index }}" 
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 transform scale-105"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 w-full h-full">

                
                @if($post->featured_image)
                <img src="{{ Storage::url($post->featured_image) }}" class="object-cover w-full h-full opacity-60">
                @else
                <div class="w-full h-full bg-emerald-900 opacity-60"></div>
                @endif

                
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>

                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-white px-4 max-w-4xl pt-12">
                        <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded uppercase mb-6 inline-block tracking-wider shadow-lg">
                            {{ $post->category->name }}
                        </span>
                        <h2 class="text-3xl md:text-5xl font-bold mb-6 leading-tight drop-shadow-md font-serif">
                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-emerald-300 transition-colors">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="text-lg md:text-xl text-gray-100 mb-8 max-w-2xl mx-auto line-clamp-2 drop-shadow-sm hidden md:block">
                            {{ $post->excerpt }}
                        </p>
                        <a href="{{ route('blog.show', $post->slug) }}"
                        <a href="{{ route('blog.show', $post->slug) }}" 
                           class="inline-flex items-center px-8 py-3 bg-white text-gray-900 font-bold rounded-full hover:bg-emerald-50 transition-all transform hover:scale-105 shadow-lg group">
                            Ler Matéria Completa
                            <x-icon name="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Navigation -->
        @if($featuredPosts->count() > 1)
        <div class="absolute bottom-8 left-0 right-0 flex justify-center space-x-3 z-10">
            @foreach($featuredPosts as $index => $post)
            <button @click="activeSlide = {{ $index }}"
            <button @click="activeSlide = {{ $index }}" 
                    :class="{ 'bg-emerald-500 w-8': activeSlide === {{ $index }}, 'bg-white/50 w-3': activeSlide !== {{ $index }} }"
                    class="h-3 rounded-full transition-all duration-300 focus:outline-none"></button>
            @endforeach
        </div>
        <button @click="activeSlide = (activeSlide === 0) ? slides - 1 : activeSlide - 1"
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-3 rounded-full backdrop-blur-sm transition-colors z-10 hidden md:block">
            <x-icon name="chevron-left" class="w-6 h-6" />
        </button>
        <button @click="activeSlide = (activeSlide === slides - 1) ? 0 : activeSlide + 1"
        <button @click="activeSlide = (activeSlide === 0) ? slides - 1 : activeSlide - 1" 
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-3 rounded-full backdrop-blur-sm transition-colors z-10 hidden md:block">
            <x-icon name="chevron-left" class="w-6 h-6" />
        </button>
        <button @click="activeSlide = (activeSlide === slides - 1) ? 0 : activeSlide + 1" 
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-3 rounded-full backdrop-blur-sm transition-colors z-10 hidden md:block">
            <x-icon name="chevron-right" class="w-6 h-6" />
        </button>
        @endif
    </div>
    @else
    <!-- Static Banner Fallback -->
    <div class="relative w-full h-[300px] bg-emerald-900 overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-4xl font-bold mb-4 font-serif">Jornal Oficial</h1>
                <p class="text-xl text-emerald-100">Transparência e Ação</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Search & Filter Bar -->
    <div class="bg-gray-50 dark:bg-slate-800 border-y border-gray-200 dark:border-slate-700 sticky top-0 z-20 shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <form action="{{ route('blog.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <x-icon name="filter" class="w-5 h-5 text-emerald-600" style="duotone" />
                    <span class="font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide text-sm">Filtrar Notícias:</span>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto flex-1 justify-end">
                    <!-- Search -->
                    <div class="relative w-full sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Buscar notícia..."
                
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto flex-1 justify-end">
                    <!-- Search -->
                    <div class="relative w-full sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Buscar notícia..." 
                               class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:text-white text-sm transition-shadow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-icon name="search" class="w-4 h-4 text-gray-400" />
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="relative">
                        <select name="category" onchange="this.form.submit()"
                        <select name="category" onchange="this.form.submit()" 
                                class="w-full sm:w-48 py-2 pl-3 pr-8 rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:text-white text-sm appearance-none cursor-pointer">
                            <option value="">Todas as Categorias</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <x-icon name="chevron-down" class="w-4 h-4 text-gray-400" />
                        </div>
                    </div>

                    <!-- Month (Placeholder UI) -->
                    <div class="relative">
                        <select name="month" class="w-full sm:w-40 py-2 pl-3 pr-8 rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:text-white text-sm appearance-none cursor-pointer">
                             <option value="">Mês (Todos)</option>
                             @foreach(range(1, 12) as $m)
                             <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                             @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <x-icon name="calendar" class="w-4 h-4 text-gray-400" />
                        </div>
                    </div>

                    
                     <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition-colors text-sm font-bold shadow-sm hover:shadow">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content (Masonry) -->
    <div class="container mx-auto px-4 py-12 bg-gray-50 dark:bg-slate-900 min-h-screen">
        <div class="columns-1 md:columns-2 lg:columns-3 gap-8 space-y-8">
            @forelse($posts as $post)
            <article class="break-inside-avoid flex flex-col bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-slate-700 overflow-hidden group">
                <!-- Image -->
                <a href="{{ route('blog.show', $post->slug) }}" class="relative block overflow-hidden">
                    @if($post->featured_image)
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" 
                             class="w-full h-auto object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-48 bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                            <x-icon name="image" class="w-16 h-16 text-gray-300 dark:text-gray-600" />
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="bg-emerald-600/90 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm uppercase tracking-wide">
                            {{ $post->category->name }}
                        </span>
                    </div>
                    @if($post->is_featured)
                    <div class="absolute top-4 right-4">
                        <span class="bg-amber-500 text-white p-1 rounded-full shadow-sm" title="Destaque">
                            <x-icon name="star" class="w-3 h-3" solid />
                        </span>
                    </div>
                    @endif
                </a>

                <!-- Content -->
                <div class="p-6">
                    <div class="mb-3 flex items-center text-xs text-gray-500 dark:text-gray-400 space-x-3 font-medium uppercase tracking-wider">
                        <span class="flex items-center">
                            <x-icon name="calendar" class="w-3 h-3 mr-1.5 text-emerald-500" />
                            {{ $post->published_at->format('d/m/Y') }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 leading-snug font-serif group-hover:text-emerald-600 transition-colors">
                        <a href="{{ route('blog.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>

                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-6 line-clamp-3 leading-relaxed">
                        {{ $post->excerpt }}
                    </p>

                    <div class="pt-4 border-t border-gray-100 dark:border-slate-700 flex items-center justify-between">
                         <div class="flex items-center">
                             <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                 Por {{ Str::words($post->author->name, 2, '') }}
                             </span>
                         </div>
                         <a href="{{ route('blog.show', $post->slug) }}" class="text-emerald-600 hover:text-emerald-700 text-xs font-bold uppercase tracking-wide flex items-center group-hover:underline">
                             Ler <x-icon name="arrow-right" class="w-3 h-3 ml-1" />
                         </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-20 bg-white dark:bg-slate-800 rounded-xl border border-dashed border-gray-300 dark:border-slate-700">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 dark:bg-slate-700 mb-6">
                    <x-icon name="newspaper" class="w-10 h-10 text-gray-400" style="duotone" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Nenhuma notícia encontrada</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">Não encontramos publicações com os filtros selecionados.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $posts->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.font-serif {
    font-family: 'Merriweather', 'Georgia', serif;
}
</style>
@endpush
