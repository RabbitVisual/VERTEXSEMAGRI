<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema em Manutenção - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    @php
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
<body class="antialiased bg-gradient-to-br from-slate-50 via-white to-amber-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 p-8 md:p-12">
            <!-- Ícone de Manutenção -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                    <x-icon name="rotate-right" class="w-5 h-5" />
                    Atualizar Página
                </button>
            </div>

            <!-- Informações Adicionais -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-700 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Agradecemos a sua paciência e compreensão.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
