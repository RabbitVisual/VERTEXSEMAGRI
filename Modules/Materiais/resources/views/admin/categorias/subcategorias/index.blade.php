@extends('admin.layouts.admin')

@section('title', 'Subcategorias - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="layer-group" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Subcategorias: {{ $categoria->nome }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.categorias.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Categorias</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Subcategorias</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.materiais.categorias.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('admin.materiais.categorias.subcategorias.create', $categoria->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
                <x-icon name="plus" class="w-5 h-5" />
                Nova Subcategoria
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <div class="flex items-center">
            <x-icon name="circle-check" class="w-5 h-5 mr-3" />
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Lista de Subcategorias - Modern Grid -->
    @if($subcategorias->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($subcategorias as $sub)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-all group">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate group-hover:text-emerald-600 transition-colors">
                            {{ $sub->nome }}
                        </h3>
                        @if($sub->descricao)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                            {{ $sub->descricao }}
                        </p>
                        @endif
                    </div>
                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-full {{ $sub->ativo ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400' : 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-400' }}">
                        {{ $sub->ativo ? 'Ativa' : 'Inativa' }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="p-3 bg-gray-50 dark:bg-slate-900/50 rounded-xl border border-transparent group-hover:border-emerald-100 dark:group-hover:border-emerald-900/30 transition-all">
                        <p class="text-[10px] uppercase tracking-wider font-bold text-gray-400 mb-1">Campos</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $sub->total_campos ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 dark:bg-slate-900/50 rounded-xl border border-transparent group-hover:border-emerald-100 dark:group-hover:border-emerald-900/30 transition-all">
                        <p class="text-[10px] uppercase tracking-wider font-bold text-gray-400 mb-1">Materiais</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $sub->materiais_count ?? 0 }}</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.materiais.categorias.subcategorias.edit', [$categoria->id, $sub->id]) }}" title="Editar Subcategoria"
                       class="p-2.5 text-gray-500 hover:text-emerald-600 dark:hover:text-emerald-400 bg-gray-50 dark:bg-slate-900/50 rounded-lg transition-colors border border-transparent hover:border-emerald-200">
                        <x-icon name="pen-to-square" class="w-5 h-5" />
                    </a>
                    <a href="{{ route('admin.materiais.categorias.campos.index', [$categoria->id, $sub->id]) }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-md shadow-emerald-500/20 transition-all">
                        <x-icon name="table-list" class="w-4 h-4" />
                        Gerenciar Campos
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-16 text-center">
        <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900/50 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <x-icon name="layer-group" class="w-10 h-10 text-gray-300" />
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Nenhuma subcategoria</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-sm mx-auto">Esta categoria ainda não possui subcategorias definidas.</p>
        <a href="{{ route('admin.materiais.categorias.subcategorias.create', $categoria->id) }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all">
            <x-icon name="plus" class="w-5 h-5" />
            Criar Primeira Subcategoria
        </a>
    </div>
    @endif
</div>
@endsection
