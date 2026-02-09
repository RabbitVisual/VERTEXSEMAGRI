<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Efetivos & Agentes - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fontes Locais (Sistema 100% Offline) -->
    <style>
        @font-face {
            font-family: 'Inter';
            src: url('/fonts/Inter-VariableFont_slnt,wght.ttf') format('truetype');
            font-weight: 100 900;
            font-display: swap;
            font-style: normal;
        }

        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Custom Scrollbar Premium */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: rgba(15, 23, 42, 0.1);
            border-radius: 10px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.05);
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.4);
        }

        .premium-card {
            @apply bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 dark:shadow-none transition-all duration-300;
        }
    </style>

    <!-- Font Awesome Pro 6.4.0 (Local/Offline) -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">

    {{-- Configurações Globais Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="antialiased bg-gray-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 overflow-x-hidden min-h-screen">

    <div class="relative min-h-screen">
        {{-- Background Accents --}}
        <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-[-1] overflow-hidden opacity-30 dark:opacity-20">
            <div class="absolute -top-1/4 -right-1/4 w-1/2 h-1/2 bg-emerald-500/20 blur-[120px] rounded-full"></div>
            <div class="absolute -bottom-1/4 -left-1/4 w-1/2 h-1/2 bg-indigo-500/20 blur-[120px] rounded-full"></div>
        </div>

        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>
