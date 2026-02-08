@extends('admin.layouts.admin')

@section('title', 'Categorias de Materiais - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="chevron-right" class="w-4 h-4" />
                    <x-icon name="boxes-stacked" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Categorias de Materiais</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Categorias</span>
            </nav>
            <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm">
                Gerencie categorias, subcategorias e campos dinâmicos para materiais
            </p>
        </div>
        <a href="{{ route('admin.materiais.categorias.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
            <x-icon name="plus" class="w-5 h-5" />
            Nova Categoria
        </a>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800" role="alert">
        <x-icon name="circle-check" class="flex-shrink-0 w-5 h-5" />
        <div class="ml-3 text-sm font-medium flex-1">{{ session('success') }}</div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-green-900/20 dark:text-green-400 dark:hover:bg-green-900/30" data-dismiss-target="#alert-success" aria-label="Close">
            <span class="sr-only">Fechar</span>
            <x-icon name="xmark" class="w-3 h-3" />
        </button>
    </div>
    @endif

    @if(session('error'))
    <div id="alert-error" class="flex items-center p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800" role="alert">
        <x-icon name="circle-xmark" class="flex-shrink-0 w-5 h-5" />
        <div class="ml-3 text-sm font-medium flex-1">{{ session('error') }}</div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30" data-dismiss-target="#alert-error" aria-label="Close">
            <span class="sr-only">Fechar</span>
            <x-icon name="xmark" class="w-3 h-3" />
        </button>
    </div>
    @endif

    <!-- Lista de Categorias - Flowbite Cards -->
    @if($categorias->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        @foreach($categorias as $categoria)
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 hover:shadow-lg transition-shadow">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3 flex-1">
                        @if($categoria->icone)
                        <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                            <x-icon name="boxes-stacked" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">
                                {{ $categoria->nome }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $categoria->subcategorias_count ?? 0 }} subcategorias
                            </p>
                        </div>
                    </div>
                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $categoria->ativo ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                        {{ $categoria->ativo ? 'Ativa' : 'Inativa' }}
                    </span>
                </div>

                @if($categoria->descricao)
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                    {{ $categoria->descricao }}
                </p>
                @endif

                @if($categoria->subcategorias->count() > 0)
                <div class="space-y-2 mb-4">
                    @foreach($categoria->subcategorias->take(3) as $subcategoria)
                    <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-slate-700/50 rounded-lg">
                        <div class="flex items-center gap-2 flex-1 min-w-0">
                            <span class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ $subcategoria->nome }}
                            </span>
                            @if($subcategoria->materiais_count > 0)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                {{ $subcategoria->materiais_count }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @if($categoria->subcategorias->count() > 3)
                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                        +{{ $categoria->subcategorias->count() - 3 }} mais
                    </p>
                    @endif
                </div>
                @endif

                <div class="flex gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.materiais.categorias.edit', $categoria->id) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                        <x-icon name="pen" class="w-4 h-4" />
                        Editar
                    </a>
                    <a href="{{ route('admin.materiais.categorias.subcategorias.index', $categoria->id) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
                        <x-icon name="eye" class="w-4 h-4" />
                        Gerenciar
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-12 text-center">
        <x-icon name="boxes-stacked" class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" />
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Nenhuma categoria cadastrada</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Comece criando sua primeira categoria de materiais.</p>
        <a href="{{ route('admin.materiais.categorias.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
            <x-icon name="plus" class="w-5 h-5" />
            Criar Primeira Categoria
        </a>
    </div>
    @endif
</div>
@endsection
