@extends('admin.layouts.admin')

@section('title', 'Gerenciar Módulos')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                </div>
                <span>Gerenciar Módulos</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">Módulos</span>
            </nav>
        </div>
    </div>

    <!-- Flash Messages - Flowbite Alerts -->
    @if(session('success'))
        <div id="success-alert" class="flex items-center p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
            </svg>
            <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-green-900/20 dark:text-green-400 dark:hover:bg-green-900/30" data-dismiss-target="#success-alert" aria-label="Close">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div id="error-alert" class="flex items-center p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
            </svg>
            <div class="ml-3 text-sm font-medium">{{ session('error') }}</div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30" data-dismiss-target="#error-alert" aria-label="Close">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Estatísticas Principais - Flowbite Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Total de Módulos -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Módulos</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $overallStats['total'] }}</p>
                    <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-1">Módulos instalados</p>
                </div>
                <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Módulos Habilitados -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Habilitados</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $overallStats['enabled'] }}</p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">{{ $overallStats['percentage_enabled'] }}% do total</p>
                </div>
                <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                    <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Módulos Desabilitados -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Desabilitados</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $overallStats['disabled'] }}</p>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">Inativos no sistema</p>
                </div>
                <div class="p-3 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                    <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Taxa de Ativação -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Taxa de Ativação</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $overallStats['percentage_enabled'] }}%</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">Módulos em uso</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros e Busca - Flowbite Card -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
        <div class="p-4 md:p-6">
            <form method="GET" action="{{ route('admin.modules.index') }}" class="flex flex-col sm:flex-row gap-4">
                <!-- Busca -->
                <div class="flex-1">
                    <label for="search" class="sr-only">Buscar módulos</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="search" 
                            name="search" 
                            value="{{ $search }}"
                            placeholder="Buscar por nome ou descrição..." 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                        />
                    </div>
                </div>

                <!-- Filtro de Status -->
                <div class="sm:w-48">
                    <label for="filter" class="sr-only">Filtrar por status</label>
                    <select 
                        id="filter" 
                        name="filter" 
                        onchange="this.form.submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                    >
                        <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Todos os Módulos</option>
                        <option value="enabled" {{ $filter === 'enabled' ? 'selected' : '' }}>Habilitados</option>
                        <option value="disabled" {{ $filter === 'disabled' ? 'selected' : '' }}>Desabilitados</option>
                    </select>
                </div>

                <!-- Botão Buscar -->
                <button 
                    type="submit" 
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span class="hidden sm:inline">Buscar</span>
                </button>

                @if($search || $filter !== 'all')
                    <a 
                        href="{{ route('admin.modules.index') }}" 
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-800 dark:text-white dark:border-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-700 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="hidden sm:inline">Limpar</span>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Grid de Módulos -->
    @if(count($modules) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6">
            @foreach($modules as $index => $module)
                @php
                    $moduleId = 'module-' . preg_replace('/[^a-zA-Z0-9]/', '-', strtolower($module['name']));
                @endphp
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-all duration-300">
                    <!-- Header do Card -->
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-slate-700 {{ $module['enabled'] ? 'bg-emerald-50 dark:bg-emerald-900/20' : 'bg-gray-50 dark:bg-slate-900/50' }}">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-12 h-12 bg-gradient-to-br {{ $module['enabled'] ? 'from-emerald-500 to-emerald-600' : 'from-gray-400 to-gray-500' }} rounded-lg flex items-center justify-center shadow-md flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ $module['name'] }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">v{{ $module['version'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                @if($module['enabled'])
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                        </svg>
                                        Habilitado
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                        </svg>
                                        Desabilitado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Body do Card -->
                    <div class="p-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $module['description'] ?? 'Sem descrição disponível' }}</p>
                        
                        <!-- Informações Técnicas -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-500 dark:text-gray-400 font-medium">Versão:</span>
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 rounded font-mono text-xs">
                                    v{{ $module['version'] ?? '1.0.0' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-500 dark:text-gray-400 font-medium">Alias:</span>
                                <code class="px-2 py-1 bg-gray-100 dark:bg-slate-700 rounded text-xs font-mono text-gray-700 dark:text-gray-300">{{ $module['alias'] ?? $module['name'] }}</code>
                            </div>
                            @if(isset($module['keywords']) && is_array($module['keywords']) && count($module['keywords']) > 0)
                            <div class="flex flex-col gap-1.5">
                                <span class="text-gray-500 dark:text-gray-400 font-medium text-xs">Palavras-chave:</span>
                                <div class="flex flex-wrap gap-1">
                                    @foreach(array_slice($module['keywords'], 0, 3) as $keyword)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                            {{ $keyword }}
                                        </span>
                                    @endforeach
                                    @if(count($module['keywords']) > 3)
                                        <span class="text-xs text-gray-500 dark:text-gray-400">+{{ count($module['keywords']) - 3 }}</span>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @if(isset($module['priority']) && $module['priority'] > 0)
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-500 dark:text-gray-400 font-medium">Prioridade:</span>
                                <span class="text-gray-700 dark:text-gray-300">{{ $module['priority'] }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Créditos -->
                        @if((isset($module['author']) && $module['author'] !== 'N/A') || (isset($module['company']) && $module['company'] !== 'N/A'))
                        <div class="pt-3 border-t border-gray-200 dark:border-slate-700">
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                @if(isset($module['company']) && $module['company'] !== 'N/A')
                                    <span class="font-medium">{{ $module['company'] }}</span>
                                @endif
                                @if(isset($module['author']) && $module['author'] !== 'N/A')
                                    <span>{{ $module['author'] }}</span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Footer do Card -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-t border-gray-200 dark:border-slate-700">
                        <div class="flex items-center gap-2 flex-wrap">
                            <a 
                                href="{{ route('admin.modules.show', $module['name']) }}" 
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-800 dark:text-white dark:border-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-700 transition-colors flex-1 sm:flex-none"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="hidden sm:inline">Detalhes</span>
                            </a>
                            
                            @if($module['enabled'])
                                <button 
                                    type="button" 
                                    data-modal-target="disable-{{ $moduleId }}" 
                                    data-modal-toggle="disable-{{ $moduleId }}"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 focus:ring-4 focus:ring-yellow-200 dark:bg-yellow-900/20 dark:text-yellow-300 dark:border-yellow-800 dark:hover:bg-yellow-900/30 dark:focus:ring-yellow-800 transition-colors flex-1 sm:flex-none"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="hidden sm:inline">Desabilitar</span>
                                    <span class="sm:hidden">Off</span>
                                </button>
                            @else
                                <button 
                                    type="button" 
                                    data-modal-target="enable-{{ $moduleId }}" 
                                    data-modal-toggle="enable-{{ $moduleId }}"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors flex-1 sm:flex-none"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="hidden sm:inline">Habilitar</span>
                                    <span class="sm:hidden">On</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                @if(!$module['enabled'])
                <!-- Enable Modal -->
                <div id="enable-{{ $moduleId }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-slate-800">
                            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-hide="enable-{{ $moduleId }}">
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
                                    <button data-modal-hide="enable-{{ $moduleId }}" type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                                        Sim, habilitar
                                    </button>
                                </form>
                                <button data-modal-hide="enable-{{ $moduleId }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-indigo-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-slate-800 dark:text-gray-400 dark:border-slate-600 dark:hover:text-white dark:hover:bg-slate-700">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($module['enabled'])
                <!-- Disable Modal -->
                <div id="disable-{{ $moduleId }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-slate-800">
                            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-hide="disable-{{ $moduleId }}">
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
                                    <button data-modal-hide="disable-{{ $moduleId }}" type="submit" class="text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                        Sim, desabilitar
                                    </button>
                                </form>
                                <button data-modal-hide="disable-{{ $moduleId }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-indigo-600 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-slate-800 dark:text-gray-400 dark:border-slate-600 dark:hover:text-white dark:hover:bg-slate-700">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @else
        <!-- Estado Vazio - Flowbite Card -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Nenhum módulo encontrado</h3>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                    @if($search || $filter !== 'all')
                        Tente ajustar os filtros de busca.
                    @else
                        Não há módulos instalados no sistema.
                    @endif
                </p>
                @if($search || $filter !== 'all')
                    <a 
                        href="{{ route('admin.modules.index') }}" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Limpar Filtros
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection
