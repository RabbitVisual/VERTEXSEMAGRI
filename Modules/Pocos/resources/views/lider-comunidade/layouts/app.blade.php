<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel do Líder') - VERTEXSEMAGRI</title>
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
            --surface-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --surface-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }
        .dark {
            --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
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
        .nav-link-active {
            background: var(--primary-gradient);
            color: white !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }
    </style>
</head>
<body class="h-full bg-slate-50 dark:bg-slate-950 transition-colors duration-300 antialiased font-[Inter,sans-serif]">
    <div id="app" class="min-h-full flex flex-col">
        @auth
            @include('pocos::lider-comunidade.layouts.navbar')
            <div class="flex-1 flex overflow-hidden pt-16">
                <!-- Desktop Sidebar -->
                <aside id="default-sidebar" class="fixed top-16 left-0 z-30 w-64 h-[calc(100vh-4rem)] transition-transform translate-x-0 hidden lg:block" aria-label="Sidebar">
                    @include('pocos::lider-comunidade.layouts.sidebar')
                </aside>

                <!-- Mobile Sidebar -->
                <div id="drawer-navigation" class="fixed top-0 left-0 z-40 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700 lg:hidden" tabindex="-1">
                    @include('pocos::lider-comunidade.layouts.sidebar')
                </div>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-slate-900 lg:ml-64">
                    <div class="py-4 sm:py-6 lg:py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
                        <!-- Flash Messages -->
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

                        @if(session('warning'))
                            <div id="alert-warning" class="flex items-center p-4 mb-4 text-amber-800 border border-amber-300 rounded-lg bg-amber-50 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800" role="alert">
                                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3 text-sm font-medium flex-1">{!! session('warning') !!}</div>
                                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-amber-50 text-amber-500 rounded-lg focus:ring-2 focus:ring-amber-400 p-1.5 hover:bg-amber-200 inline-flex h-8 w-8 dark:bg-amber-900/20 dark:text-amber-400 dark:hover:bg-amber-900/30" data-dismiss-target="#alert-warning" aria-label="Close">
                                    <span class="sr-only">Fechar</span>
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div id="alert-errors" class="flex items-start p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800" role="alert">
                                <svg class="flex-shrink-0 w-5 h-5 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3 text-sm font-medium flex-1">
                                    <h3 class="font-semibold mb-2">Erros encontrados:</h3>
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30" data-dismiss-target="#alert-errors" aria-label="Close">
                                    <span class="sr-only">Fechar</span>
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </main>
            </div>
        @else
            @yield('content')
        @endauth
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
