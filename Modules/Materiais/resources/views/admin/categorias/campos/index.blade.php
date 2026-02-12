@extends('admin.layouts.admin')

@section('title', 'Campos Dinâmicos - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in font-poppins pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="table-list" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1 leading-tight">
                        {{ $subcategoria->nome }}
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <a href="{{ route('admin.materiais.categorias.subcategorias.index', $categoria->id) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-bold">{{ $categoria->nome }}</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <span class="text-gray-900 dark:text-white font-bold tracking-tight">Atributos Dinâmicos</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.materiais.categorias.subcategorias.index', $categoria->id) }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-all duration-300 shadow-sm active:scale-95 text-center">
                    <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                    Subcategorias
                </a>
                <a href="{{ route('admin.materiais.categorias.subcategorias.campos.create', [$categoria->id, $subcategoria->id]) }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-black text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all duration-300 active:scale-95 border-b-4 border-emerald-800">
                    <x-icon name="plus" style="duotone" class="w-5 h-5" />
                    Novo Atributo
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

    <!-- Lista de Campos - Modern Design -->
    @if($campos->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($campos as $campo)
        <div class="group relative bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
            <!-- Glass Background Decorator -->
            <div class="absolute -right-16 -top-16 w-32 h-32 bg-emerald-500/5 rounded-full group-hover:scale-[3] transition-transform duration-700 pointer-events-none"></div>

            <div class="p-8 relative z-10">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <h3 class="text-xl font-black text-gray-900 dark:text-white leading-tight group-hover:text-emerald-600 transition-colors truncate max-w-[180px]">
                                {{ $campo->nome }}
                            </h3>
                            @if($campo->obrigatorio)
                            <span class="px-2 py-0.5 text-[8px] font-black uppercase rounded-lg bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 border border-red-100 dark:border-red-800/50">
                                Mandatório
                            </span>
                            @endif
                        </div>
                        <p class="text-[9px] uppercase tracking-[0.2em] font-black text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded inline-block">
                            {{ $campo->tipo_texto }}
                        </p>
                    </div>
                    @if($campo->ativo)
                        <div title="Campo Ativo" class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50 animate-pulse"></div>
                    @else
                        <div title="Campo Inativo" class="w-2.5 h-2.5 rounded-full bg-slate-300"></div>
                    @endif
                </div>

                @if($campo->descricao)
                <div class="mb-6 p-4 bg-slate-50/50 dark:bg-slate-900/30 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700/50">
                    <p class="text-xs text-gray-500 dark:text-gray-400 italic line-clamp-2 leading-relaxed font-medium">
                        "{{ $campo->descricao }}"
                    </p>
                </div>
                @endif

                <div class="space-y-3 mb-8">
                    @if($campo->placeholder)
                    <div class="flex items-center justify-between p-3.5 bg-white dark:bg-slate-800 rounded-xl border border-gray-50 dark:border-slate-700/50 shadow-sm">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Dica Visual</span>
                        <span class="text-xs text-gray-700 dark:text-gray-300 font-bold italic">{{ $campo->placeholder }}</span>
                    </div>
                    @endif

                    @if($campo->opcoes && count($campo->opcoes_array) > 0)
                    <div class="p-4 bg-white dark:bg-slate-800 rounded-2xl border border-gray-50 dark:border-slate-700/50 shadow-sm">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-3 border-b border-slate-50 dark:border-slate-700 pb-2">Seleções Válidas</span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($campo->opcoes_array as $opcao)
                            <span class="px-2.5 py-1 text-[9px] font-black rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-100/50 dark:border-emerald-800/30 shadow-sm">
                                {{ $opcao }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.materiais.categorias.subcategorias.campos.edit', [$categoria->id, $subcategoria->id, $campo->id]) }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-black text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/20 transition-all active:scale-[0.98] border-b-4 border-emerald-800">
                        <x-icon name="pen-to-square" style="duotone" class="w-4 h-4" />
                        Configurar Atributo
                    </a>
                </div>
            </div>

            <!-- Footer decorator -->
            <div class="px-8 py-3 bg-slate-50 dark:bg-slate-900/50 border-t border-gray-50 dark:border-slate-700/50 flex items-center justify-between text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                <span>Ordem: {{ $campo->ordem }}</span>
                @if($campo->slug)
                    <span class="text-emerald-500/50">#{{ $campo->slug }}</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-xl rounded-[2.5rem] border border-dashed border-slate-200 dark:border-slate-700 p-20 text-center shadow-inner">
        <div class="w-24 h-24 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-sm">
            <x-icon name="table-columns" style="duotone" class="w-10 h-10 text-slate-200" />
        </div>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Sem Atributos Dinâmicos</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-10 max-w-sm mx-auto font-medium">Esta subcategoria utiliza apenas os campos básicos. Adicione atributos personalizados para enriquecer os dados técnicos dos itens.</p>
        <a href="{{ route('admin.materiais.categorias.subcategorias.campos.create', [$categoria->id, $subcategoria->id]) }}" class="inline-flex items-center gap-3 px-10 py-4 text-sm font-black text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/40 transition-all active:scale-95 border-b-4 border-emerald-800">
            <x-icon name="plus" style="duotone" class="w-5 h-5" />
            Adicionar Primeiro Campo
        </a>
    </div>
    @endif
</div>
@endsection
