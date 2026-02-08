<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Blog') - VERTEXSEMAGRI</title>
    <meta name="description" content="@yield('meta_description', 'Blog oficial da Secretaria Municipal de Agricultura - Notícias, novidades e informações sobre os serviços municipais.')">
    <meta name="keywords" content="@yield('meta_keywords', 'blog, prefeitura, agricultura, notícias, coração de maria')">
    <meta name="author" content="VERTEXSEMAGRI">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'Blog - VERTEXSEMAGRI')">
    <meta property="og:description" content="@yield('og_description', 'Blog oficial da Secretaria Municipal de Agricultura')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo-vertex-full.svg'))">
    <meta property="og:site_name" content="VERTEXSEMAGRI">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('twitter_title', 'Blog - VERTEXSEMAGRI')">
    <meta property="twitter:description" content="@yield('twitter_description', 'Blog oficial da Secretaria Municipal de Agricultura')">
    <meta property="twitter:image" content="@yield('twitter_image', asset('images/logo-vertex-full.svg'))">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- RSS Feed -->
    <link rel="alternate" type="application/rss+xml" title="Blog VERTEXSEMAGRI" href="{{ route('blog.rss') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Inicialização do tema ANTES do CSS para evitar FOUC -->
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('theme') || 'light';
                const html = document.documentElement;
                if (savedTheme === 'dark') {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
            } catch (e) {
                console.warn('Theme initialization failed:', e);
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-gray-100 antialiased">
    <!-- Header -->
    <header class="bg-white dark:bg-slate-800 shadow-sm border-b border-gray-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('homepage') }}" class="flex items-center">
                        <img src="{{ asset('images/logo-vertex-semagri.svg') }}" alt="VERTEXSEMAGRI" class="h-8 w-auto">
                        <span class="ml-2 text-xl font-bold text-emerald-600 dark:text-emerald-400">VERTEXSEMAGRI</span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('homepage') }}" class="text-gray-600 hover:text-emerald-600 dark:text-gray-300 dark:hover:text-emerald-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Início
                    </a>
                    <a href="{{ route('blog.index') }}" class="text-emerald-600 dark:text-emerald-400 px-3 py-2 rounded-md text-sm font-medium">
                        Blog
                    </a>
                    <a href="{{ route('portal.index') }}" class="text-gray-600 hover:text-emerald-600 dark:text-gray-300 dark:hover:text-emerald-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Portal
                    </a>
                </nav>

                <!-- Search & Theme Toggle -->
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <form action="{{ route('blog.search') }}" method="GET" class="hidden sm:block">
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar..."
                                class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </form>

                    <!-- Theme Toggle -->
                    <button type="button" id="theme-toggle" class="p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2L13.09 8.26L20 9L14 14.74L15.18 21.02L10 17.77L4.82 21.02L6 14.74L0 9L6.91 8.26L10 2Z"></path>
                        </svg>
                    </button>

                    <!-- Mobile menu button -->
                    <button type="button" class="md:hidden p-2 text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700" id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-200 dark:border-slate-700">
                    <a href="{{ route('homepage') }}" class="block px-3 py-2 text-gray-600 hover:text-emerald-600 dark:text-gray-300 dark:hover:text-emerald-400 rounded-md text-base font-medium">
                        Início
                    </a>
                    <a href="{{ route('blog.index') }}" class="block px-3 py-2 text-emerald-600 dark:text-emerald-400 rounded-md text-base font-medium">
                        Blog
                    </a>
                    <a href="{{ route('portal.index') }}" class="block px-3 py-2 text-gray-600 hover:text-emerald-600 dark:text-gray-300 dark:hover:text-emerald-400 rounded-md text-base font-medium">
                        Portal
                    </a>
                </div>
                <!-- Mobile Search -->
                <div class="px-2 pb-3">
                    <form action="{{ route('blog.search') }}" method="GET">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar no blog..."
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Sobre o Blog</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        Blog oficial da Secretaria Municipal de Agricultura de Coração de Maria - BA.
                        Acompanhe as últimas notícias e novidades sobre os serviços municipais.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Links Rápidos</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">Todas as Notícias</a></li>
                        <li><a href="{{ route('blog.rss') }}" class="text-gray-600 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">RSS Feed</a></li>
                        <li><a href="{{ route('portal.index') }}" class="text-gray-600 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">Portal de Transparência</a></li>
                        <li><a href="{{ route('homepage') }}" class="text-gray-600 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">Página Inicial</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Contato</h3>
                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <p>Secretaria Municipal de Agricultura</p>
                        <p>Coração de Maria - BA</p>
                        <p>Tel: (75) 3248-2489</p>
                        <p>Email: gabinete@coracaodemaria.ba.gov.br</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-slate-700">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        © {{ date('Y') }} VERTEXSEMAGRI. Todos os direitos reservados.
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-0">
                        Desenvolvido por <a href="mailto:r.rodriguesjs@gmail.com" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">Vertex Solutions LTDA</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        // Theme toggle functionality
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
            document.documentElement.classList.add('dark');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
            document.documentElement.classList.remove('dark');
        }

        themeToggleBtn.addEventListener('click', function() {
            // Toggle icons
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // If set via local storage previously
            if (localStorage.getItem('theme')) {
                if (localStorage.getItem('theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }
        });

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
