<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA Meta Tags - Optimizing for Field Use -->
    <meta name="theme-color" content="#059669">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="SEMAGRI Campo">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="SEMAGRI Campo">
    <meta name="msapplication-TileColor" content="#059669">
    <meta name="msapplication-tap-highlight" content="no">

    <title>@yield('title', 'Painel Campo') - VERTEX</title>

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Icons - Duotone Preferred -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('icons/icon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon.svg') }}">

    <!-- Premium Typography: Inter -->
    <style>
        @font-face {
            font-family: 'Inter';
            src: url('/fonts/Inter-VariableFont_slnt,wght.ttf') format('truetype');
            font-weight: 100 900;
            font-style: normal;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Custom Scrollbar for Premium Feel */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #334155;
        }

        /* Glassmorphism Classes */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .dark .glass-panel {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>

    <script>
        // Imminent Theme Initialization
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const html = document.documentElement;
            html.classList.toggle('dark', savedTheme === 'dark');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- PWA Offline Script -->
    <script src="{{ asset('js/campo-offline.js') }}" defer></script>

    @stack('styles')
</head>
<body class="h-full bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 flex flex-col selection:bg-emerald-500/20 selection:text-emerald-700 overflow-x-hidden" x-data="{ sidebarOpen: false }">

    <!-- Global Loading Overlay Standardized -->
    <div id="global-loading" class="fixed inset-0 z-[100] flex items-center justify-center bg-white/80 dark:bg-slate-950/80 backdrop-blur-md transition-opacity duration-300 pointer-events-none opacity-0">
        <div class="flex flex-col items-center">
            <div class="relative w-16 h-16">
                <div class="absolute inset-0 rounded-2xl border-4 border-emerald-500/20"></div>
                <div class="absolute inset-0 rounded-2xl border-4 border-t-emerald-500 animate-spin"></div>
            </div>
            <p class="mt-4 text-[10px] font-black uppercase tracking-[0.3em] text-emerald-600 animate-pulse italic">Processando Dados...</p>
        </div>
    </div>

    <!-- Layout Wrapper -->
    <div class="flex h-full overflow-hidden">
        <!-- Sidebar Navigation -->
        <div
            x-show="sidebarOpen"
            class="fixed inset-0 z-40 lg:hidden"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
        >
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        </div>

        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            @include('campo.layouts.sidebar')
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
            @include('campo.layouts.navbar')

            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 md:p-6 lg:p-8 space-y-6 md:space-y-8">
                <!-- Breadcrumbs Operacional -->
                <div class="flex items-center gap-2 text-[9px] font-black uppercase tracking-widest text-slate-400 mb-2 overflow-x-auto whitespace-nowrap scrollbar-hide">
                    <x-icon name="map-pin" class="w-2.5 h-2.5 text-emerald-500" />
                    <span>Painel de Campo</span>
                    @yield('breadcrumbs')
                </div>

                @yield('content')
            </main>

            <!-- Mobile Bottom Nav (Optional but recommended for mobile-first) -->
            <div class="lg:hidden h-20 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-t border-slate-200 dark:border-slate-800 flex items-center justify-around px-4 pb-safe">
                <a href="{{ route('campo.dashboard') }}" class="flex flex-col items-center gap-1 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('campo.dashboard') ? 'bg-emerald-500 text-white shadow-lg' : 'text-slate-400' }}">
                        <x-icon name="grid-2-plus" style="{{ request()->routeIs('campo.dashboard') ? 'solid' : 'duotone' }}" class="w-5 h-5" />
                    </div>
                </a>
                <a href="{{ route('campo.ordens.index') }}" class="flex flex-col items-center gap-1 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('campo.ordens.*') ? 'bg-emerald-500 text-white shadow-lg' : 'text-slate-400' }}">
                        <x-icon name="list-check" style="{{ request()->routeIs('campo.ordens.*') ? 'solid' : 'duotone' }}" class="w-5 h-5" />
                    </div>
                </a>
                <a href="{{ route('campo.chat.page') }}" class="flex flex-col items-center gap-1 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('campo.chat.*') ? 'bg-emerald-500 text-white shadow-lg' : 'text-slate-400' }}">
                        <x-icon name="messages" style="{{ request()->routeIs('campo.chat.*') ? 'solid' : 'duotone' }}" class="w-5 h-5" />
                    </div>
                </a>
                <a href="{{ route('campo.profile.index') }}" class="flex flex-col items-center gap-1 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('campo.profile.*') ? 'bg-emerald-500 text-white shadow-lg' : 'text-slate-400' }}">
                        <x-icon name="user-gear" style="{{ request()->routeIs('campo.profile.*') ? 'solid' : 'duotone' }}" class="w-5 h-5" />
                    </div>
                </a>
            </div>
        </div>
    </div>

    @stack('scripts')

    <script>
        // Global UI Interactions
        window.showLoading = () => {
            const el = document.getElementById('global-loading');
            el.classList.remove('pointer-events-none', 'opacity-0');
            el.classList.add('opacity-100');
        };
        window.hideLoading = () => {
            const el = document.getElementById('global-loading');
            el.classList.add('opacity-0');
            setTimeout(() => el.classList.add('pointer-events-none'), 300);
        };
    </script>
</body>
</html>
