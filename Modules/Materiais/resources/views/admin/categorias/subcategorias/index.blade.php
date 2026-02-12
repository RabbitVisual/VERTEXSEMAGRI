@extends('admin.layouts.admin')

@section('title', 'Subcategorias - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in font-poppins pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="layer-group" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        {{ $categoria->nome }}
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <a href="{{ route('admin.materiais.categorias.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-bold">Categorias</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <span class="text-gray-900 dark:text-white font-bold tracking-tight">Estrutura de Subcategorias</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.materiais.categorias.index') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-all duration-300 shadow-sm active:scale-95 text-center">
                    <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                    Categorias
                </a>
                <a href="{{ route('admin.materiais.categorias.subcategorias.create', $categoria->id) }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-black text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all duration-300 active:scale-95 border-b-4 border-emerald-800">
                    <x-icon name="plus" style="duotone" class="w-5 h-5" />
                    Nova Subcategoria
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

    <!-- Lista de Subcategorias - Modern Layout -->
    @if($subcategorias->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($subcategorias as $sub)
        <div class="group relative bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
            <!-- Background Accent -->
            <div class="absolute -right-16 -top-16 w-32 h-32 bg-emerald-500/5 rounded-full group-hover:scale-[3] transition-transform duration-700 pointer-events-none"></div>

            <div class="p-8 relative z-10">
                <div class="flex items-start justify-between mb-8">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xl font-black text-gray-900 dark:text-white leading-tight group-hover:text-emerald-600 transition-colors">
                            {{ $sub->nome }}
                        </h3>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 dark:bg-slate-900 px-2 py-0.5 rounded border border-slate-100 dark:border-slate-700">
                                #{{ $sub->slug ?? 'SEGMENTO-PADRAO' }}
                            </span>
                        </div>
                    </div>
                    @if($sub->ativo)
                        <div title="Ativa" class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50 animate-pulse"></div>
                    @else
                        <div title="Inativa" class="w-2.5 h-2.5 rounded-full bg-slate-300"></div>
                    @endif
                </div>

                @if($sub->descricao)
                <div class="mb-8 p-4 bg-slate-50/50 dark:bg-slate-900/30 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700/50">
                    <p class="text-sm text-gray-500 dark:text-gray-400 italic line-clamp-2 leading-relaxed font-medium">
                        "{{ $sub->descricao }}"
                    </p>
                </div>
                @endif

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="p-4 bg-white dark:bg-slate-800 rounded-2xl border border-gray-50 dark:border-slate-700/50 shadow-sm group-hover:border-emerald-100 dark:group-hover:border-emerald-900/30 transition-all">
                        <div class="flex items-center gap-2 mb-1">
                            <x-icon name="table-columns" class="w-3.5 h-3.5 text-emerald-500/50" />
                            <p class="text-[10px] uppercase tracking-[0.15em] font-black text-slate-400">Atributos</p>
                        </div>
                        <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $sub->total_campos ?? 0 }}</p>
                    </div>
                    <div class="p-4 bg-white dark:bg-slate-800 rounded-2xl border border-gray-50 dark:border-slate-700/50 shadow-sm group-hover:border-emerald-100 dark:group-hover:border-emerald-900/30 transition-all">
                        <div class="flex items-center gap-2 mb-1">
                            <x-icon name="boxes-stacked" class="w-3.5 h-3.5 text-emerald-500/50" />
                            <p class="text-[10px] uppercase tracking-[0.15em] font-black text-slate-400">Insumos</p>
                        </div>
                        <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $sub->materiais_count ?? 0 }}</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.materiais.categorias.subcategorias.edit', [$categoria->id, $sub->id]) }}" title="Configurações Locais"
                       class="w-12 h-12 flex items-center justify-center text-slate-400 hover:text-emerald-600 bg-slate-50 dark:bg-slate-900 rounded-xl transition-all border border-transparent hover:border-emerald-100 dark:hover:border-emerald-800/50 active:scale-90">
                        <x-icon name="pen-to-square" style="duotone" class="w-5 h-5" />
                    </a>
                    <a href="{{ route('admin.materiais.categorias.subcategorias.campos.index', [$categoria->id, $sub->id]) }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-black text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-md shadow-emerald-500/20 transition-all active:scale-[0.98] border-b-4 border-emerald-800/50">
                        <x-icon name="table-list" style="duotone" class="w-4 h-4" />
                        Definir Propriedades
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-xl rounded-[2.5rem] border border-dashed border-slate-200 dark:border-slate-700 p-20 text-center shadow-inner">
        <div class="w-24 h-24 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-sm">
            <x-icon name="layer-group" style="duotone" class="w-10 h-10 text-slate-200" />
        </div>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Ausência de Subdivisões</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-10 max-w-sm mx-auto font-medium">A categoria <span class="text-emerald-600 font-bold">{{ $categoria->nome }}</span> ainda não possui subdivisões técnicas para segmentação de materiais.</p>
        <a href="{{ route('admin.materiais.categorias.subcategorias.create', $categoria->id) }}" class="inline-flex items-center gap-3 px-10 py-4 text-sm font-black text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/40 transition-all active:scale-95 border-b-4 border-emerald-800">
            <x-icon name="plus" style="duotone" class="w-5 h-5" />
            Adicionar Subcategoria
        </a>
    </div>
    @endif
</div>
@endsection
