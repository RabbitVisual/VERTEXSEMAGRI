@extends('admin.layouts.admin')

@section('title', 'Campos Dinâmicos - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="table-list" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Campos Dinâmicos: {{ $subcategoria->nome }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.categorias.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Categorias</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.categorias.subcategorias.index', $categoria->id) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">{{ $categoria->nome }}</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Campos</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.materiais.categorias.subcategorias.index', $categoria->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('admin.materiais.categorias.campos.create', [$categoria->id, $subcategoria->id]) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
                <x-icon name="plus" class="w-5 h-5" />
                Novo Campo
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

    <!-- Lista de Campos - Modern Grid -->
    @if($campos->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($campos as $campo)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-all group">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate group-hover:text-emerald-600 transition-colors">
                                {{ $campo->nome }}
                            </h3>
                            @if($campo->obrigatorio)
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                Obrigatório
                            </span>
                            @endif
                        </div>
                        <p class="text-[10px] uppercase tracking-wider font-bold text-emerald-600 dark:text-emerald-400">
                            {{ $campo->tipo_texto }}
                        </p>
                    </div>
                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase rounded-full {{ $campo->ativo ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400' : 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-400' }}">
                        {{ $campo->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>

                @if($campo->descricao)
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 line-clamp-2 italic">
                    "{{ $campo->descricao }}"
                </p>
                @endif

                <div class="space-y-2 mb-6">
                    @if($campo->placeholder)
                    <div class="flex items-center justify-between p-2.5 bg-gray-50 dark:bg-slate-900/50 rounded-lg">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest text-[9px]">Placeholder</span>
                        <span class="text-xs text-gray-700 dark:text-gray-300 font-medium">{{ $campo->placeholder }}</span>
                    </div>
                    @endif

                    @if($campo->opcoes && count($campo->opcoes_array) > 0)
                    <div class="p-2.5 bg-gray-50 dark:bg-slate-900/50 rounded-lg">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest text-[9px] block mb-2">Opções Disponíveis</span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($campo->opcoes_array as $opcao)
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-lg bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30">
                                {{ $opcao }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.materiais.categorias.campos.edit', [$categoria->id, $subcategoria->id, $campo->id]) }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-md shadow-emerald-500/20 transition-all">
                        <x-icon name="pen-to-square" class="w-4 h-4" />
                        Editar Configurações
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-16 text-center">
        <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900/50 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <x-icon name="pen-nib" class="w-10 h-10 text-gray-300" />
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Sem campos dinâmicos</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-sm mx-auto">Esta subcategoria não possui campos personalizados. Adicione campos para capturar informações específicas dos materiais.</p>
        <a href="{{ route('admin.materiais.categorias.campos.create', [$categoria->id, $subcategoria->id]) }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all">
            <x-icon name="plus" class="w-5 h-5" />
            Adicionar Primeiro Campo
        </a>
    </div>
    @endif
</div>
@endsection
