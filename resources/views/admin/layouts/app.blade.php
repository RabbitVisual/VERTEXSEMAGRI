<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VERTEXSEMAGRI') - Sistema Municipal</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <script>
        (function() {
            'use strict';
            try {
                const savedTheme = localStorage.getItem('theme') || 'light';
                const html = document.documentElement;
                if (savedTheme === 'dark') {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900 antialiased">
    @if(session()->has('impersonator_id'))
        <div class="bg-amber-500 text-white py-2 px-4 shadow-md sticky top-0 z-[100] border-b border-amber-600">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="text-sm font-bold tracking-tight">
                        MODO VISUALIZAÇÃO: <span class="font-black uppercase">{{ Auth::user()->name }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.stop-impersonation') }}" class="px-4 py-1.5 bg-white text-amber-600 rounded-lg text-xs font-bold">
                    Sair
                </a>
            </div>
        </div>
    @endif

    <div class="min-h-full flex">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar-admin')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 lg:pl-72">

            <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-200">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
