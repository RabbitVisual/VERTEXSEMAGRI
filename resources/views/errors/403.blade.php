<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acesso Negado - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    @php
        // Carregar assets do manifest.json em produção
        $manifestPath = public_path('build/manifest.json');
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
            $vendorCss = $manifest['_vendor-CfZ7kyuK.css']['file'] ?? null;
        }
    @endphp

    @if(isset($cssFile))
        <link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}">
    @endif
    @if(isset($vendorCss))
        <link rel="stylesheet" href="{{ asset('build/' . $vendorCss) }}">
    @endif

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-slate-50 via-white to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 min-h-screen flex items-center justify-center px-4">
    @if(session()->has('impersonator_id'))
        <!-- Impersonation Banner -->
        <div class="bg-amber-500 text-white py-2 px-4 shadow-md fixed top-0 left-0 right-0 z-[100] border-b border-amber-600">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-1 bg-white/20 rounded-lg">
                        <x-icon name="eye" class="w-5 h-5 text-white" />
                    </div>
                    <div class="text-sm font-bold tracking-tight">
                        MODO VISUALIZAÇÃO: <span class="font-black uppercase">{{ Auth::user()->name }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.stop-impersonation') }}" class="inline-flex items-center gap-2 px-4 py-1.5 text-xs font-black bg-white text-amber-600 rounded-lg hover:bg-amber-50 transition-all shadow-sm transform hover:scale-105 active:scale-95">
                    <x-icon name="arrow-left" class="w-4 h-4" />
                    VOLTAR AO ADMIN
                </a>
            </div>
        </div>
    @endif

    <div class="max-w-2xl w-full">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 p-8 md:p-12">
            <!-- Ícone de Erro -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                    <x-icon name="triangle-exclamation" class="w-12 h-12 text-red-600 dark:text-red-400" />
                </div>
            </div>

            <!-- Título -->
            <div class="text-center mb-6">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                    Acesso Negado
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Código de Erro: 403
                </p>
            </div>

            <!-- Mensagem -->
            <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 dark:border-amber-400 p-6 rounded-r-lg mb-6">
                <div class="flex items-start gap-3">
                    <x-icon name="circle-info" class="w-6 h-6 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" />
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-amber-900 dark:text-amber-200 mb-2">
                            Informação Importante
                        </h3>
                        <p class="text-amber-800 dark:text-amber-300 leading-relaxed">
                            {{ isset($exception) && $exception ? $exception->getMessage() : 'Você não possui permissão para acessar este recurso.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="window.history.back()" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition-colors shadow-sm">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                    Voltar à Página Anterior
                </button>

                <a href="@auth
                    @if(auth()->user()->hasRole('admin')){{ route('admin.dashboard') }}
                    @elseif(auth()->user()->hasRole('co-admin')){{ route('co-admin.dashboard') }}
                    @elseif(auth()->user()->hasRole('campo')){{ route('campo.dashboard') }}
                    @elseif(auth()->user()->hasRole('consulta')){{ route('consulta.dashboard') }}
                    @else{{ route('login') }}
                    @endif
                @else{{ route('login') }}
                @endauth" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors shadow-md hover:shadow-lg">
                    <x-icon name="house" class="w-5 h-5" />
                    Painel Principal
                </a>
            </div>

            <!-- Informações Adicionais -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-700 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Se você acredita que deveria ter acesso a este recurso, entre em contato com o administrador do sistema.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
