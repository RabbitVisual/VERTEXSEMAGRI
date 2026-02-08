@extends('admin.layouts.admin')

@section('title', 'Detalhes do Módulo')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.modules.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Módulos</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">{{ $module['name'] }}</span>
            </nav>
        </div>
        <a 
            href="{{ route('admin.modules.index') }}" 
            class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-800 dark:text-white dark:border-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-700 transition-colors"
        >
            <x-icon name="arrow-left" class="w-5 h-5" />
            <span class="hidden sm:inline">Voltar</span>
        </a>
    </div>

    <!-- Status Banner - Flowbite Alert -->
    <div class="flex items-center p-4 mb-4 {{ $module['enabled'] ? 'text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800' : 'text-gray-800 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-900/20 dark:text-gray-400 dark:border-gray-800' }}" role="alert">
        <div class="flex items-center gap-4 flex-1">
            <div class="w-16 h-16 bg-gradient-to-br {{ $module['enabled'] ? 'from-emerald-500 to-emerald-600' : 'from-gray-400 to-gray-500' }} rounded-lg flex items-center justify-center shadow-lg flex-shrink-0">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                </svg>
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $module['name'] }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $module['description'] ?? 'Sem descrição' }}</p>
            </div>
            <div class="flex-shrink-0">
                @if($module['enabled'])
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        Módulo Habilitado
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                        Módulo Desabilitado
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
        <!-- Informações Principais -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informações do Módulo - Flowbite Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </div>
                        <span>Informações do Módulo</span>
                    </h2>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome do Módulo</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $module['name'] }}</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alias</dt>
                            <dd>
                                <code class="px-3 py-1.5 bg-gray-100 dark:bg-slate-700 rounded-lg text-sm font-mono text-gray-900 dark:text-white">{{ $module['alias'] }}</code>
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Versão</dt>
                            <dd>
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 rounded-lg font-mono text-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                    </svg>
                                    v{{ $module['version'] ?? '1.0.0' }}
                                </span>
                            </dd>
                        </div>
                        @if(isset($module['author']) && $module['author'] !== 'N/A')
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Desenvolvedor</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $module['author'] }}</dd>
                        </div>
                        @endif
                        @if(isset($module['company']) && $module['company'] !== 'N/A')
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Empresa</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $module['company'] }}</dd>
                        </div>
                        @endif
                        @if(isset($module['keywords']) && is_array($module['keywords']) && count($module['keywords']) > 0)
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Palavras-chave</dt>
                            <dd>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($module['keywords'] as $keyword)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                            {{ $keyword }}
                                        </span>
                                    @endforeach
                                </div>
                            </dd>
                        </div>
                        @endif
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                            <dd>
                                @if($module['enabled'])
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-800">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                        </svg>
                                        Habilitado
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                        </svg>
                                        Desabilitado
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Namespace</dt>
                            <dd>
                                <code class="block px-3 py-1.5 bg-gray-100 dark:bg-slate-700 rounded-lg text-xs font-mono text-gray-900 dark:text-white break-all">{{ $module['namespace'] }}</code>
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Caminho do Módulo</dt>
                            <dd>
                                <code class="block px-3 py-1.5 bg-gray-100 dark:bg-slate-700 rounded-lg text-xs font-mono text-gray-900 dark:text-white break-all">{{ $module['path'] }}</code>
                            </dd>
                        </div>
                        @if(isset($module['priority']))
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-4 border-b border-gray-200 dark:border-slate-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Prioridade</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $module['priority'] }}</dd>
                        </div>
                        @endif
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Descrição</dt>
                            <dd class="text-sm text-gray-900 dark:text-white text-right">{{ $module['description'] ?? 'Sem descrição disponível' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Estatísticas - Flowbite Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </div>
                        <span>Estatísticas</span>
                    </h2>
                </div>
                <div class="p-6">
                    @if(!empty($stats) && count($stats) > 2)
                        <div class="space-y-4">
                            @foreach($stats as $key => $value)
                                @if($key !== 'enabled' && $key !== 'version')
                                    <div class="pb-4 border-b border-gray-200 dark:border-slate-700 last:border-0 last:pb-0">
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                            {{ ucfirst(str_replace('_', ' ', $key)) }}
                                        </p>
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                            @if(is_numeric($value))
                                                {{ number_format((float)$value, 0, ',', '.') }}
                                            @elseif(is_bool($value))
                                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold {{ $value ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-200' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400' }}">
                                                    {{ $value ? 'Sim' : 'Não' }}
                                                </span>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma estatística disponível</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ações - Flowbite Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span>Ações</span>
                    </h2>
                </div>
                <div class="p-6">
                    @if($module['enabled'])
                        <button 
                            type="button" 
                            data-modal-target="disable-modal" 
                            data-modal-toggle="disable-modal"
                            class="w-full inline-flex items-center justify-center gap-3 px-6 py-3.5 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800 transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Desabilitar Módulo
                        </button>
                    @else
                        <button 
                            type="button" 
                            data-modal-target="enable-modal" 
                            data-modal-toggle="enable-modal"
                            class="w-full inline-flex items-center justify-center gap-3 px-6 py-3.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Habilitar Módulo
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(!$module['enabled'])
<!-- Enable Modal -->
<div id="enable-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-slate-800">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-hide="enable-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Fechar</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 w-12 h-12 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Deseja habilitar o módulo <strong class="text-gray-900 dark:text-white">{{ $module['name'] }}</strong>?</h3>
                <form action="{{ route('admin.modules.enable', $module['name']) }}" method="POST" class="inline">
                    @csrf
                    <button data-modal-hide="enable-modal" type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                        Sim, habilitar
                    </button>
                </form>
                <button data-modal-hide="enable-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-indigo-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-slate-800 dark:text-gray-400 dark:border-slate-600 dark:hover:text-white dark:hover:bg-slate-700">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@if($module['enabled'])
<!-- Disable Modal -->
<div id="disable-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-slate-800">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-hide="disable-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Fechar</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 w-12 h-12 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">⚠️ ATENÇÃO: Tem certeza que deseja desabilitar o módulo <strong class="text-gray-900 dark:text-white">{{ $module['name'] }}</strong>?</h3>
                <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">Isso pode afetar funcionalidades do sistema que dependem deste módulo.</p>
                <form action="{{ route('admin.modules.disable', $module['name']) }}" method="POST" class="inline">
                    @csrf
                    <button data-modal-hide="disable-modal" type="submit" class="text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                        Sim, desabilitar
                    </button>
                </form>
                <button data-modal-hide="disable-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-indigo-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-slate-800 dark:text-gray-400 dark:border-slate-600 dark:hover:text-white dark:hover:bg-slate-700">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
