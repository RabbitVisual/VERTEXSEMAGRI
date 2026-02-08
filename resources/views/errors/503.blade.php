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
            font-family: system-ui, -apple-system, sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-slate-50 via-white to-amber-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 p-8 md:p-12">
            <!-- Ícone de Manutenção -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.83-5.83m-4.75 4.75l-5.83 5.83A2.652 2.652 0 113 17.25l5.83-5.83m4.75 4.75V3.75c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V11.25m-4.75 4.75l-4.75-4.75M9.75 11.25V3.75c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V11.25" />
                    </svg>
                </div>
            </div>

            <!-- Título -->
            <div class="text-center mb-6">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                    Sistema em Manutenção
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Código de Erro: 503
                </p>
            </div>

            <!-- Mensagem -->
            <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 dark:border-amber-400 p-6 rounded-r-lg mb-8">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-amber-900 dark:text-amber-200 mb-2">
                            Estamos trabalhando para melhorar!
                        </h3>
                        <p class="text-amber-800 dark:text-amber-300 leading-relaxed">
                            O sistema está passando por uma manutenção programada e voltará a ficar disponível em breve. Pedimos desculpas pelo transtorno.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-medium transition-colors shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
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
