<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sessão Expirada - {{ config('app.name', 'Laravel') }}</title>
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
<body class="antialiased bg-gradient-to-br from-slate-50 via-white to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 p-8 md:p-12">
            <!-- Ícone de Sessão Expirada -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Título -->
            <div class="text-center mb-6">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                    Sessão Expirada
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Código de Erro: 419
                </p>
            </div>

            <!-- Mensagem -->
            <div class="bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-indigo-500 dark:border-indigo-400 p-6 rounded-r-lg mb-8">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-indigo-900 dark:text-indigo-200 mb-2">
                            Token de segurança inválido.
                        </h3>
                        <p class="text-indigo-800 dark:text-indigo-300 leading-relaxed">
                            Sua sessão expirou devido à inatividade ou o formulário foi enviado sem um token de segurança válido.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Recarregar e Tentar Novamente
                </button>

                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Fazer Login Novamente
                </a>
            </div>

            <!-- Informações Adicionais -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-700 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Para sua segurança, as sessões são encerradas após um período de inatividade.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
