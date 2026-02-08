<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#f97316">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="SEMAGRI Campo">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="SEMAGRI Campo">
    <meta name="msapplication-TileColor" content="#f97316">
    <meta name="msapplication-tap-highlight" content="no">

    <title>@yield('title', 'Painel Campo') - SEMAGRI</title>

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Icons - SVG Only -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('icons/icon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon.svg') }}">

    <!-- Apple Touch Icons - SVG -->
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('icons/icon.svg') }}">
    <link rel="apple-touch-icon" sizes="96x96" href="{{ asset('icons/icon.svg') }}">
    <link rel="apple-touch-icon" sizes="128x128" href="{{ asset('icons/icon.svg') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('icons/icon.svg') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icons/icon.svg') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('icons/icon.svg') }}">
    <link rel="apple-touch-icon" sizes="384x384" href="{{ asset('icons/icon.svg') }}">
    <link rel="apple-touch-icon" sizes="512x512" href="{{ asset('icons/icon.svg') }}">

    <script>
        // Inicialização imediata para evitar flash - Tailwind CSS v4.1 nativo
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const html = document.documentElement;
            html.classList.remove('dark');
            if (savedTheme === 'dark') {
                html.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Self-Healing Script: Detects and fixes stale cache with dev assets -->
    <script>
        (function() {
            // Check if we are on localhost
            const isLocal = window.location.hostname === 'localhost' ||
                           window.location.hostname === '127.0.0.1' ||
                           window.location.hostname.includes('.local');

            // Check if we have dev assets (localhost:5173)
            const hasDevAssets = document.querySelector('script[src*=":5173"]') ||
                                 document.querySelector('link[href*=":5173"]');

            // ONLY purge if we have dev assets but are NOT on a local environment
            // This prevents the loop during legitimate development
            if (hasDevAssets && !isLocal) {
                console.warn('[Auto-Fix] ⚠️ Detected stale development assets in non-local environment! Purging Service Worker...');

                if ('serviceWorker' in navigator) {
                    navigator.serviceWorker.getRegistrations().then(function(registrations) {
                        let unregisterPromises = [];
                        for(let registration of registrations) {
                            unregisterPromises.push(registration.unregister());
                        }

                        Promise.all(unregisterPromises).then(function() {
                            console.log('[Auto-Fix] ✅ SW Unregistered. Reloading...');
                            // Force reload from server to get fresh assets
                            window.location.reload(true);
                        });
                    });
                }
            }
        })();
    </script>

    <!-- PWA Offline Script -->
    <script src="{{ asset('js/campo-offline.js') }}" defer></script>

    <!-- Estilos PWA Específicos -->
    <style>
        /* PWA Install Banner - HyperUI Style */
        .pwa-install-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            padding: 1rem;
            display: none;
            z-index: 9999;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
        }

        .pwa-install-banner.show {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            animation: slide-up 0.3s ease-out;
        }

        @keyframes slide-up {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }

        /* Connection Badge - HyperUI Style */
        .connection-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .connection-badge.online {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .connection-badge.offline {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .connection-badge .status-dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            animation: pulse-dot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .connection-badge.online .status-dot {
            background: #10b981;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-dot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .connection-badge.offline .status-dot {
            background: #ef4444;
        }

        @keyframes pulse-dot {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.5;
                transform: scale(0.8);
            }
        }

        /* Notifications - HyperUI Toast Style */
        .notifications-container {
            position: fixed;
            top: 5rem;
            right: 1rem;
            z-index: 9998;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            max-width: 24rem;
        }

        .notification {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            animation: slide-in-right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .notification-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .notification-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .notification-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .notification-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        @keyframes slide-in-right {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .notification-fade {
            animation: slide-out-right 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes slide-out-right {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Pending Badge */
        .pending-badge {
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
            background: #ef4444;
            color: white;
            font-size: 0.625rem;
            font-weight: 700;
            min-width: 1.125rem;
            height: 1.125rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 0.25rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Sync Indicator */
        .sync-indicator {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Touch Optimizations */
        @media (hover: none) and (pointer: coarse) {
            button, a, .clickable {
                min-height: 44px;
                min-width: 44px;
            }
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .loading-overlay.show {
            display: flex;
        }

        .loading-spinner {
            width: 3rem;
            height: 3rem;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top-color: #f97316;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        /* PWA Installed Styles */
        .pwa-installed body {
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
        }

        /* Animations */
        @keyframes animate-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: animate-in 0.3s ease-out;
        }

        @keyframes slide-in-from-right {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .slide-in-from-right {
            animation: slide-in-from-right 0.3s ease-out;
        }

        /* Safe Area Support for iOS */
        @supports (padding: max(0px)) {
            .pwa-installed nav {
                padding-top: max(1rem, env(safe-area-inset-top));
            }
        }
    </style>
</head>
<body x-data="{ sidebarOpen: false }" class="h-full bg-gradient-to-br from-gray-50 via-gray-50 to-gray-100 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 transition-colors duration-200 antialiased selection:bg-indigo-500 selection:text-white">
    @if(session()->has('impersonator_id'))
        <!-- Impersonation Banner -->
        <div class="bg-amber-500 text-white py-2 px-4 shadow-md sticky top-0 z-[100] border-b border-amber-600">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-1 bg-white/20 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="text-sm font-bold tracking-tight">
                        MODO VISUALIZAÇÃO: <span class="font-black uppercase">{{ Auth::user()->name }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.stop-impersonation') }}" class="inline-flex items-center gap-2 px-4 py-1.5 text-xs font-black bg-white text-amber-600 rounded-lg hover:bg-amber-50 transition-all shadow-sm transform hover:scale-105 active:scale-95">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                    VOLTAR AO ADMIN
                </a>
            </div>
        </div>
    @endif
    <div id="app" class="min-h-full bg-gray-50 dark:bg-gray-900">
        @auth
            @include('campo.layouts.navbar')

            <!-- Desktop Sidebar (Fixed) -->
            <aside class="hidden lg:block fixed inset-y-0 left-0 z-30 w-72 lg:top-20 overflow-y-auto bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 pb-10">
                @include('campo.layouts.sidebar')
            </aside>

                <!-- Mobile Sidebar Overlay -->
                <div x-show="sidebarOpen"
                     x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden"
                     @click="sidebarOpen = false"></div>

                <!-- Mobile Sidebar -->
                <aside x-show="sidebarOpen"
                       x-transition:enter="transition ease-in-out duration-300 transform"
                       x-transition:enter-start="-translate-x-full"
                       x-transition:enter-end="translate-x-0"
                       x-transition:leave="transition ease-in-out duration-300 transform"
                       x-transition:leave-start="translate-x-0"
                       x-transition:leave-end="-translate-x-full"
                       class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-gray-800 lg:hidden shadow-2xl">
                    <div class="flex flex-col h-full">
                        @include('campo.layouts.sidebar')
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="lg:pl-72 w-full pt-4">
                    <div class="py-4 sm:py-6 lg:py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
                        <!-- Flash Messages - HyperUI Alert Style -->
                        @if(session('success'))
                            <div class="mb-4 md:mb-6 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 p-4 shadow-sm animate-in slide-in-from-top">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
                                    </div>
                                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-200 transition-colors">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 md:mb-6 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4 shadow-sm animate-in slide-in-from-top">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                                    </div>
                                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if(session('warning'))
                            <div class="mb-4 md:mb-6 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-4 shadow-sm animate-in slide-in-from-top">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-amber-800 dark:text-amber-200">{!! session('warning') !!}</p>
                                    </div>
                                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-200 transition-colors">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-4 md:mb-6 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4 shadow-sm">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-sm font-semibold text-red-800 dark:text-red-200 mb-2">Erros encontrados:</h3>
                                        <ul class="space-y-1 text-sm text-red-700 dark:text-red-300">
                                            @foreach($errors->all() as $error)
                                                <li class="flex items-start gap-2">
                                                    <span class="text-red-500 mt-0.5">•</span>
                                                    <span>{{ $error }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- Sistema de Alerta Global para Ordens Pendentes - HyperUI Style -->
                        @if(isset($campoOrdensPendentes) && $campoOrdensPendentes > 0)
                            <div id="ordens-alerta-global" class="mb-4 md:mb-6 bg-white dark:bg-gray-800 lg:grid lg:place-content-center rounded-2xl shadow-xl border-2 border-amber-200 dark:border-amber-800 overflow-hidden">
                                <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 md:grid md:grid-cols-2 md:items-center md:gap-6 lg:px-8 lg:py-12">
                                    <!-- Conteúdo do Alerta -->
                                    <div class="max-w-prose text-left mb-4 md:mb-0">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>
                                            </div>
                                            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                                                Você tem
                                                <strong class="text-amber-600 dark:text-amber-400">{{ $campoOrdensPendentes }}</strong>
                                                {{ $campoOrdensPendentes == 1 ? 'ordem pendente' : 'ordens pendentes' }}
                                            </h2>
                                        </div>

                                        <p class="mt-3 text-sm sm:text-base text-pretty text-gray-700 dark:text-gray-300 leading-relaxed">
                                            Existem <strong class="font-semibold text-gray-900 dark:text-white">{{ $campoOrdensPendentes }}</strong>
                                            {{ $campoOrdensPendentes == 1 ? 'ordem de serviço aguardando' : 'ordens de serviço aguardando' }} sua atenção.
                                            Revise e inicie a execução para manter o fluxo de trabalho atualizado.
                                        </p>

                                        <div class="mt-5 sm:mt-6 flex flex-col sm:flex-row gap-3">
                                            <a href="{{ route('campo.ordens.index', ['status' => 'pendente']) }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-amber-600 bg-amber-600 px-4 py-2.5 sm:px-5 sm:py-3 font-semibold text-white shadow-sm transition-all duration-300 hover:bg-amber-700 hover:shadow-md hover:scale-105 active:scale-95 text-sm sm:text-base">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                </svg>
                                                <span>Ver Ordens Pendentes</span>
                                            </a>

                                            <button onclick="dismissOrdensAlertaGlobal()" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 sm:px-5 sm:py-3 font-semibold text-gray-700 dark:text-gray-300 shadow-sm transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white hover:shadow-md text-sm sm:text-base">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                <span>Fechar</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Ilustração SVG -->
                                    <div class="hidden md:block mx-auto max-w-md text-gray-900 dark:text-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 768" class="w-full h-auto">
                                            <g fill="none" fill-rule="evenodd">
                                                <g fill="currentColor" opacity="0.1">
                                                    <path d="M512 384c0 141.385-114.615 256-256 256S0 525.385 0 384 114.615 128 256 128s256 114.615 256 256z"/>
                                                    <path d="M1024 384c0 141.385-114.615 256-256 256S512 525.385 512 384 626.615 128 768 128s256 114.615 256 256z"/>
                                                </g>
                                                <g fill="#f59e0b" opacity="0.8">
                                                    <path d="M400 300c-46.392 0-84 37.608-84 84s37.608 84 84 84 84-37.608 84-84-37.608-84-84-84zm0 24c33.137 0 60 26.863 60 60s-26.863 60-60 60-60-26.863-60-60 26.863-60 60-60z"/>
                                                    <path d="M624 300c-46.392 0-84 37.608-84 84s37.608 84 84 84 84-37.608 84-84-37.608-84-84-84zm0 24c33.137 0 60 26.863 60 60s-26.863 60-60 60-60-26.863-60-60 26.863-60 60-60z"/>
                                                    <path d="M512 200c-46.392 0-84 37.608-84 84s37.608 84 84 84 84-37.608 84-84-37.608-84-84-84zm0 24c33.137 0 60 26.863 60 60s-26.863 60-60 60-60-26.863-60-60 26.863-60 60-60z"/>
                                                </g>
                                                <g fill="none" stroke="currentColor" stroke-width="2" opacity="0.3">
                                                    <path d="M256 384h512M512 128v512"/>
                                                </g>
                                                <g fill="#f59e0b">
                                                    <path d="M450 450h124v24H450v-24zm0-48h124v24H450v-24zm0-48h124v24H450v-24z"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
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

    <script>
        // Sidebar toggle function
        function toggleSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (sidebar && overlay) {
                const isHidden = sidebar.classList.contains('-translate-x-full');
                if (isHidden) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
        }

        // User menu dropdown toggle
        window.toggleUserMenu = function() {
            const menu = document.getElementById('userMenuDropdownMenu');
            if (menu) {
                const isHidden = menu.style.display === 'none' || menu.classList.contains('hidden');
                if (isHidden) {
                    menu.style.display = 'block';
                    menu.classList.remove('hidden');
                } else {
                    menu.style.display = 'none';
                    menu.classList.add('hidden');
                }
            }
        };

        // Fechar menu do usuário ao clicar fora
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userMenuDropdown');
            const menu = document.getElementById('userMenuDropdownMenu');
            if (dropdown && menu && !dropdown.contains(e.target)) {
                menu.style.display = 'none';
                menu.classList.add('hidden');
            }
        });

        // Theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');

            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }

            updateThemeIcons(!isDark);
        }

        function updateThemeIcons(isDark) {
            const sunIcon = document.getElementById('sunIcon');
            const moonIcon = document.getElementById('moonIcon');

            if (sunIcon && moonIcon) {
                if (isDark) {
                    sunIcon.classList.remove('opacity-0', 'scale-0');
                    sunIcon.classList.add('opacity-100', 'scale-100');
                    moonIcon.classList.add('opacity-0', 'scale-0');
                    moonIcon.classList.remove('opacity-100', 'scale-100');
                } else {
                    moonIcon.classList.remove('opacity-0', 'scale-0');
                    moonIcon.classList.add('opacity-100', 'scale-100');
                    sunIcon.classList.add('opacity-0', 'scale-0');
                    sunIcon.classList.remove('opacity-100', 'scale-100');
                }
            }
        }

        // Inicializar ícones do tema
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            updateThemeIcons(isDark);
        });

        // Função para fazer logout com fallback para GET se CSRF expirar
        window.handleLogout = function() {
            const logoutUrl = '{{ route("logout") }}';
            const logoutUrlGet = '{{ route("logout.get") }}';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (csrfToken) {
                fetch(logoutUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (response.ok || response.redirected) {
                        window.location.href = '{{ route("login") }}';
                    } else if (response.status === 419) {
                        window.location.href = logoutUrlGet;
                    } else {
                        window.location.href = logoutUrlGet;
                    }
                })
                .catch(error => {
                    console.error('Erro ao fazer logout:', error);
                    window.location.href = logoutUrlGet;
                });
            } else {
                window.location.href = logoutUrlGet;
            }
        };
    </script>

    @stack('scripts')

    <!-- Global Loading Overlay -->
    <div id="loading-overlay" class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- PWA Install Banner -->
    <div id="pwa-install-banner" class="pwa-install-banner">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-sm">Instalar SEMAGRI Campo</p>
                <p class="text-xs opacity-90">Acesse offline a qualquer momento</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button id="pwa-install-btn" class="px-4 py-2 bg-white text-orange-600 rounded-lg font-semibold text-sm hover:bg-orange-50 transition-colors shadow-md">
                Instalar
            </button>
            <button id="pwa-dismiss-btn" class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- PWA Registration Script -->
    <script>
        // Variável global para o prompt de instalação
        let deferredPrompt;

        // Detectar prompt de instalação
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;

            if (!localStorage.getItem('pwa-install-dismissed')) {
                document.getElementById('pwa-install-banner').classList.add('show');
            }
        });

        // Instalar PWA
        document.getElementById('pwa-install-btn')?.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;

                if (outcome === 'accepted') {
                    console.log('PWA instalado');
                }

                deferredPrompt = null;
                document.getElementById('pwa-install-banner').classList.remove('show');
            }
        });

        // Descartar banner
        document.getElementById('pwa-dismiss-btn')?.addEventListener('click', () => {
            document.getElementById('pwa-install-banner').classList.remove('show');
            localStorage.setItem('pwa-install-dismissed', Date.now());
        });

        // Detectar quando instalado
        window.addEventListener('appinstalled', () => {
            console.log('SEMAGRI Campo instalado com sucesso!');
            document.getElementById('pwa-install-banner')?.classList.remove('show');
        });

        // Limpar cache de dismissed após 7 dias
        const dismissedAt = localStorage.getItem('pwa-install-dismissed');
        if (dismissedAt && (Date.now() - parseInt(dismissedAt)) > 7 * 24 * 60 * 60 * 1000) {
            localStorage.removeItem('pwa-install-dismissed');
        }
    </script>

    <!-- Service Worker Registration - Profissional -->
    <script>
        if ('serviceWorker' in navigator) {
            let refreshing = false;

            window.addEventListener('load', async () => {
                try {
                    const registration = await navigator.serviceWorker.register('/sw.js', {
                        scope: '/',
                        updateViaCache: 'none' // Sempre verificar atualizações
                    });

                    console.log('[Campo PWA] Service Worker registrado:', registration.scope);

                    // Verificar atualizações periodicamente (a cada 1 hora)
                    setInterval(() => {
                        registration.update();
                    }, 60 * 60 * 1000);

                    // Cachear páginas quando online
                    if (navigator.onLine && registration.active) {
                        registration.active.postMessage({
                            type: 'CACHE_PAGES',
                            pages: [
                                '/campo/dashboard',
                                '/campo/ordens',
                                '/campo/profile',
                                '/campo/chat/page',
                                '/campo/materiais/solicitacoes',
                                window.location.pathname
                            ]
                        });
                    }

                    // Detectar nova versão disponível
                    registration.addEventListener('updatefound', () => {
                        const newWorker = registration.installing;

                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                // Nova versão disponível
                                showUpdateNotification();
                            }
                        });
                    });

                    // Detectar quando o Service Worker assume controle
                    navigator.serviceWorker.addEventListener('controllerchange', () => {
                        if (!refreshing) {
                            refreshing = true;
                            window.location.reload();
                        }
                    });

                } catch (error) {
                    console.error('[Campo PWA] Erro ao registrar Service Worker:', error);
                }
            });

            // Sincronização quando voltar online
            window.addEventListener('online', () => {
                if (navigator.serviceWorker.controller) {
                    navigator.serviceWorker.controller.postMessage({
                        type: 'SYNC_NOW'
                    });
                }

                if (window.campoOffline) {
                    window.campoOffline.syncPendingData();
                }
            });

            // Função para mostrar notificação de atualização
            function showUpdateNotification() {
                const notification = document.createElement('div');
                notification.className = 'fixed top-20 right-4 z-50 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 p-4 max-w-sm animate-in slide-in-from-right';
                notification.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Nova Versão Disponível</h3>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">Uma nova versão do aplicativo está disponível. Atualize para obter as últimas melhorias.</p>
                            <div class="flex gap-2">
                                <button onclick="updateApp()" class="flex-1 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-lg transition-colors">
                                    Atualizar Agora
                                </button>
                                <button onclick="this.closest('.fixed').remove()" class="px-3 py-1.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-medium rounded-lg transition-colors">
                                    Depois
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(notification);

                // Remover após 10 segundos se não interagir
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.style.opacity = '0';
                        notification.style.transform = 'translateX(100%)';
                        setTimeout(() => notification.remove(), 300);
                    }
                }, 10000);
            }

            // Função para atualizar o app
            window.updateApp = function() {
                if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
                    navigator.serviceWorker.controller.postMessage({ type: 'SKIP_WAITING' });
                }
            };
        }

        // Pré-carregar dados quando online para uso offline
        // Nota: isDevelopment e logger já estão definidos em campo-offline.js
        document.addEventListener('DOMContentLoaded', () => {
            // Disponibilizar dados do usuário para cache offline (antes de qualquer coisa)
            @auth
            window.currentUserId = {{ Auth::id() }};
            window.currentUserName = @json(Auth::user()->name);
            window.currentUserEmail = @json(Auth::user()->email);
            window.currentUserPhoto = @json(Auth::user()->photo);
            window.currentUserPhone = @json(Auth::user()->phone ?? '');
            @endauth

            if (navigator.onLine && window.campoOffline) {
                // Aguardar um pouco antes de pré-carregar para não sobrecarregar
                setTimeout(() => {
                    window.campoOffline.refreshOrdensCache();
                    window.campoOffline.refreshMateriaisCache();
                    window.campoOffline.preloadUserProfile();
                    // Usar logger global se disponível, senão usar console.log silenciosamente
                    if (typeof logger !== 'undefined' && logger) {
                        logger.log('[Campo PWA] Dados cacheados para uso offline');
                    }
                }, 2000);
            }
        });

        // Detectar se está rodando como PWA instalado
        window.addEventListener('DOMContentLoaded', () => {
            const isStandalone = window.matchMedia('(display-mode: standalone)').matches ||
                                window.navigator.standalone ||
                                document.referrer.includes('android-app://');

            if (isStandalone) {
                document.documentElement.classList.add('pwa-installed');
                if (typeof logger !== 'undefined') {
                    logger.log('[Campo PWA] Rodando como aplicativo instalado');
                }
            }
        });

        // Função para fechar o alerta global de ordens pendentes
        window.dismissOrdensAlertaGlobal = function() {
            const alerta = document.getElementById('ordens-alerta-global');
            if (alerta) {
                // Salvar no localStorage que o usuário fechou o alerta
                const hoje = new Date().toDateString();
                localStorage.setItem('ordens-alerta-global-dismissed', hoje);

                // Animação de fade out
                alerta.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                alerta.style.opacity = '0';
                alerta.style.transform = 'translateY(-10px)';

                setTimeout(() => {
                    alerta.remove();
                }, 300);
            }
        };

        // GARANTIR que qualquer overlay de loading seja removido ao carregar
        // Isso previne que overlays fiquem travando a página após redirecionamentos
        (function ensureNoStuckOverlays() {
            function removeAllOverlays() {
                // Remover overlay global
                const globalOverlay = document.getElementById('global-loading-overlay');
                if (globalOverlay) {
                    globalOverlay.classList.remove('show', 'visible');
                }

                // Remover overlay local do campo
                const localOverlay = document.getElementById('loading-overlay');
                if (localOverlay) {
                    localOverlay.classList.remove('show');
                }
            }

            // Remover imediatamente se já estiver visível
            if (document.readyState === 'loading' || document.readyState === 'interactive') {
                removeAllOverlays();
            }

            // Remover em múltiplos eventos para garantir
            ['DOMContentLoaded', 'load', 'pageshow'].forEach(eventName => {
                window.addEventListener(eventName, removeAllOverlays, { once: true, passive: true });
            });

            // Remover ao sair da página
            window.addEventListener('beforeunload', removeAllOverlays, { passive: true });
            window.addEventListener('pagehide', removeAllOverlays, { passive: true });
        })();

        // Verificar se o alerta global foi fechado hoje
        document.addEventListener('DOMContentLoaded', function() {
            const alerta = document.getElementById('ordens-alerta-global');
            if (alerta) {
                const hoje = new Date().toDateString();
                const dismissed = localStorage.getItem('ordens-alerta-global-dismissed');

                // Se foi fechado hoje, não mostrar
                if (dismissed === hoje) {
                    alerta.remove();
                } else {
                    // Limpar dismiss antigo se for de outro dia
                    if (dismissed && dismissed !== hoje) {
                        localStorage.removeItem('ordens-alerta-global-dismissed');
                    }

                    // Animação de entrada
                    alerta.style.opacity = '0';
                    alerta.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        alerta.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                        alerta.style.opacity = '1';
                        alerta.style.transform = 'translateY(0)';
                    }, 100);
                }
            }

            // Atualizar alerta quando houver mudanças offline
            if (window.campoOffline) {
                async function verificarOrdensOfflineGlobal() {
                    try {
                        const ordens = await window.campoOffline.getAllOrdens();
                        const pendentes = ordens.filter(o => o.status === 'pendente');
                        const alerta = document.getElementById('ordens-alerta-global');

                        if (pendentes.length > 0) {
                            if (typeof logger !== 'undefined') {
                                logger.log('[Campo Alerta Global] Ordens pendentes detectadas offline:', pendentes.length);
                            }

                            // Se não houver alerta visível, criar dinamicamente (opcional)
                            if (!alerta && pendentes.length > 0) {
                                // Atualizar contador se existir
                                const contador = document.querySelector('[data-pendentes-count]');
                                if (contador) {
                                    contador.textContent = pendentes.length;
                                }

                                // Atualizar texto do alerta se existir
                                const alertaTexto = document.querySelector('#ordens-alerta-global strong');
                                if (alertaTexto) {
                                    alertaTexto.textContent = pendentes.length;
                                }
                            }
                        }
                    } catch (err) {
                        if (typeof logger !== 'undefined') {
                            logger.warn('[Campo Alerta Global] Erro ao verificar ordens offline:', err);
                        }
                    }
                }

                // Verificar a cada 30 segundos quando offline
                if (!navigator.onLine) {
                    verificarOrdensOfflineGlobal();
                    setInterval(verificarOrdensOfflineGlobal, 30000);
                }
            }
        });
    </script>
</body>
</html>
