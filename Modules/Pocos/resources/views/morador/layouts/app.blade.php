<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Área do Morador') - VERTEXSEMAGRI</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

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
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --surface-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --surface-shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --surface-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --surface-shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.05), 0 8px 10px -6px rgb(0 0 0 / 0.05);
        }
        .bg-glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .dark .bg-glass {
            background: rgba(15, 23, 42, 0.7);
        }
        .premium-card {
            background: white;
            border-radius: 1rem;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: var(--surface-shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .dark .premium-card {
            background: #1e293b;
            border-color: rgba(51, 65, 85, 0.8);
        }
        .premium-card:hover {
            box-shadow: var(--surface-shadow-lg);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="h-full bg-slate-50 dark:bg-slate-950 transition-colors duration-300 antialiased font-[Inter,sans-serif]">
    <div id="app" class="min-h-full">
        @if(session('morador_codigo_acesso'))
        <nav class="fixed top-0 z-50 w-full bg-glass border-b border-gray-200/50 dark:border-slate-700/50">
            <div class="px-4 py-3 lg:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-icon.svg') }}" alt="Logo" class="w-10 h-10 object-contain">
                        <div>
                            <span class="block text-lg font-bold text-gray-900 dark:text-white leading-tight">Canal do Morador</span>
                            <span class="block text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Gestão de Poços</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Theme Toggle -->
                        <button type="button" id="darkModeToggle" onclick="toggleTheme()" class="p-2 text-gray-500 rounded-xl hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-slate-800 transition-all border border-transparent dark:hover:border-slate-700" title="Alternar tema">
                            <span id="theme-icon-sun" class="transition-all duration-300">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773l-1.591-1.591M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                </svg>
                            </span>
                            <span id="theme-icon-moon" class="transition-all duration-300 hidden">
                                <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                                </svg>
                            </span>
                        </button>

                        <form method="POST" action="{{ route('morador-poco.logout') }}">
                        @csrf
                        <button type="submit" class="p-2 text-red-500 bg-red-50 dark:bg-red-900/10 rounded-xl hover:bg-red-100 transition-all border border-red-100 dark:border-red-900/20" title="Sair do Portal">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="h-16"></div>
        @endif

        <main class="py-4 sm:py-6 lg:py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            @if(session('success'))
                <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3 text-sm font-medium flex-1">{{ session('success') }}</div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-green-900/20 dark:text-green-400 dark:hover:bg-green-900/30" data-dismiss-target="#alert-success" aria-label="Close">
                        <span class="sr-only">Fechar</span>
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div id="alert-error" class="flex items-center p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3 text-sm font-medium flex-1">{{ session('error') }}</div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30" data-dismiss-target="#alert-error" aria-label="Close">
                        <span class="sr-only">Fechar</span>
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            const newTheme = isDark ? 'light' : 'dark';

            if (newTheme === 'dark') {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }

            localStorage.setItem('theme', newTheme);
            updateThemeIcons();
        }

        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');

            if (sunIcon && moonIcon) {
                if (isDark) {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                } else {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                }
            }
        }

        // Initialize icons
        document.addEventListener('DOMContentLoaded', updateThemeIcons);
    </script>
</body>
</html>
