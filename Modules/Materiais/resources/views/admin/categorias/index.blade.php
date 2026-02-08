@extends('admin.layouts.admin')

@section('title', 'Categorias de Materiais - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="Materiais" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Categorias</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Categorias</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.materiais.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('admin.materiais.categorias.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
                <x-icon name="plus" class="w-5 h-5" />
                Nova Categoria
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

    <!-- Lista de Categorias - Modern Cards -->
    @if($categorias->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categorias as $categoria)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-all duration-300 group">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl group-hover:scale-110 transition-transform">
                            <x-icon name="{{ $categoria->icone ?? 'tag' }}" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 transition-colors">
                                {{ $categoria->nome }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">
                                {{ $categoria->subcategorias_count ?? 0 }} Subcategorias
                            </p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-full {{ $categoria->ativo ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400' : 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-400' }}">
                        {{ $categoria->ativo ? 'Ativa' : 'Inativa' }}
                    </span>
                </div>

                @if($categoria->descricao)
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 line-clamp-2 italic">
                    "{{ $categoria->descricao }}"
                </p>
                @endif

                <div class="space-y-2 mb-6">
                    @forelse($categoria->subcategorias->take(3) as $sub)
                    <div class="flex items-center justify-between p-2.5 bg-gray-50 dark:bg-slate-900/50 rounded-lg group/sub hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover/sub:text-emerald-600 transition-colors truncate">
                            {{ $sub->nome }}
                        </span>
                        <span class="text-xs bg-white dark:bg-slate-800 px-2 py-0.5 rounded-full border border-gray-100 dark:border-slate-700 text-gray-500">
                            {{ $sub->materiais_count ?? 0 }}
                        </span>
                    </div>
                    @empty
                    <p class="text-xs text-center text-gray-400 py-2">Nenhuma subcategoria</p>
                    @endforelse

                    @if($categoria->subcategorias->count() > 3)
                    <div class="text-center">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">+ {{ $categoria->subcategorias->count() - 3 }} extras</span>
                    </div>
                    @endif
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.materiais.categorias.edit', $categoria->id) }}" title="Editar Categoria"
                       class="p-2.5 text-gray-500 hover:text-emerald-600 dark:hover:text-emerald-400 bg-gray-50 dark:bg-slate-900/50 rounded-lg transition-colors border border-transparent hover:border-emerald-200">
                        <x-icon name="pen-to-square" class="w-5 h-5" />
                    </a>
                    <a href="{{ route('admin.materiais.categorias.subcategorias.index', $categoria->id) }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-md shadow-emerald-500/20 transition-all">
                        <x-icon name="layer-group" class="w-4 h-4" />
                        Gerenciar Subcategorias
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-16 text-center">
        <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900/50 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <x-icon name="folder-open" class="w-10 h-10 text-gray-300" />
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Sem categorias</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-sm mx-auto">Organize seus materiais criando categorias para facilitar a busca e o controle de estoque.</p>
        <a href="{{ route('admin.materiais.categorias.create') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all">
            <x-icon name="plus" class="w-5 h-5" />
            Criar Minha Primeira Categoria
        </a>
    </div>
    @endif
</div>
@endsection
