@extends('admin.layouts.admin')

@section('title', 'Categorias de Materiais - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in font-poppins pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="grid-2" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        Categorias de Materiais
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-bold">Materiais</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <span class="text-gray-900 dark:text-white font-bold tracking-tight">Gestão de Categorias</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.materiais.index') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-all duration-300 shadow-sm active:scale-95">
                    <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                    Voltar
                </a>
                <a href="{{ route('admin.materiais.categorias.create') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-black text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all duration-300 active:scale-95 border-b-4 border-emerald-800">
                    <x-icon name="plus" style="duotone" class="w-5 h-5" />
                    Nova Categoria
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-6 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50 flex items-center gap-3 animate-slide-in">
        <x-icon name="circle-check" class="w-5 h-5" style="duotone" />
        <span class="font-bold tracking-tight">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Lista de Categorias - Modern Cards -->
    @if($categorias->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($categorias as $categoria)
        <div class="group relative bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
            <!-- Glassy background decorator -->
            <div class="absolute -right-16 -top-16 w-32 h-32 bg-emerald-500/5 rounded-full group-hover:scale-[3] transition-transform duration-700 pointer-events-none"></div>

            <div class="p-8 relative z-10">
                <div class="flex items-start justify-between mb-8">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/30 rounded-2xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-inner group-hover:scale-110 group-hover:rotate-6 transition-transform border border-emerald-100/50 dark:border-emerald-700/50">
                            <x-icon name="{{ $categoria->icone ?? 'tag' }}" style="duotone" class="w-7 h-7" />
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white leading-tight group-hover:text-emerald-600 transition-colors">
                                {{ $categoria->nome }}
                            </h3>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-slate-900 px-2 py-0.5 rounded">
                                    {{ $categoria->subcategorias_count ?? 0 }} Segmentos
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($categoria->ativo)
                        <div title="Categoria Ativa" class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></div>
                    @else
                        <div title="Categoria Inativa" class="w-2.5 h-2.5 rounded-full bg-slate-300"></div>
                    @endif
                </div>

                @if($categoria->descricao)
                <div class="mb-8 p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-100/50 dark:border-slate-700/50">
                    <p class="text-sm text-gray-500 dark:text-gray-400 italic line-clamp-2 leading-relaxed font-medium">
                        "{{ $categoria->descricao }}"
                    </p>
                </div>
                @endif

                <div class="space-y-3 mb-8">
                    @forelse($categoria->subcategorias->take(3) as $sub)
                    <div class="flex items-center justify-between p-3.5 bg-white dark:bg-slate-800 rounded-xl border border-gray-50 dark:border-slate-700/50 group/sub hover:bg-emerald-50/30 dark:hover:bg-emerald-900/10 hover:border-emerald-100 dark:hover:border-emerald-800/30 transition-all duration-300">
                        <div class="flex items-center gap-2">
                            <x-icon name="circle-dot" class="w-2 h-2 text-emerald-400" />
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300 group-hover/sub:text-emerald-700 dark:group-hover/sub:text-emerald-400 transition-colors truncate">
                                {{ $sub->nome }}
                            </span>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 bg-slate-50 dark:bg-slate-900 px-2.5 py-1 rounded-lg">
                            {{ $sub->materiais_count ?? 0 }} ITENS
                        </span>
                    </div>
                    @empty
                    <div class="py-4 text-center border-2 border-dashed border-slate-100 dark:border-slate-700 rounded-2xl">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nenhuma subcategoria vinculada</span>
                    </div>
                    @endforelse

                    @if($categoria->subcategorias->count() > 3)
                    <div class="text-center pt-2">
                        <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em]">+ {{ $categoria->subcategorias->count() - 3 }} desdobramentos adicionais</span>
                    </div>
                    @endif
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.materiais.categorias.edit', $categoria->id) }}" title="Editar Parâmetros"
                       class="w-12 h-12 flex items-center justify-center text-slate-400 hover:text-emerald-600 bg-slate-50 dark:bg-slate-900 rounded-xl transition-all border border-transparent hover:border-emerald-100 dark:hover:border-emerald-800/50 active:scale-90">
                        <x-icon name="pen-to-square" style="duotone" class="w-5 h-5" />
                    </a>
                    <a href="{{ route('admin.materiais.categorias.subcategorias.index', $categoria->id) }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-black text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-md shadow-emerald-500/20 transition-all active:scale-[0.98] border-b-4 border-emerald-800/50">
                        <x-icon name="layer-group" style="duotone" class="w-4 h-4" />
                        Estruturar Subcategorias
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-xl rounded-[2.5rem] border border-dashed border-slate-200 dark:border-slate-700 p-20 text-center shadow-inner">
        <div class="w-24 h-24 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-sm">
            <x-icon name="folder-open" style="duotone" class="w-10 h-10 text-slate-200" />
        </div>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Nenhuma Categoria Definida</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-10 max-w-sm mx-auto font-medium">Inicie a estruturação do seu inventário criando as categorias principais para classificar seus insumos e ferramentas.</p>
        <a href="{{ route('admin.materiais.categorias.create') }}" class="inline-flex items-center gap-3 px-10 py-4 text-sm font-black text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/40 transition-all active:scale-95 border-b-4 border-emerald-800">
            <x-icon name="plus" style="duotone" class="w-5 h-5" />
            Criar Registro Inicial
        </a>
    </div>
    @endif
</div>
@endsection
