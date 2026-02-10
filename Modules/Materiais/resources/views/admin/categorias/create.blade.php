@extends('admin.layouts.admin')

@section('title', 'Nova Categoria - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in font-poppins pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="plus" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        Nova Categoria
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <a href="{{ route('admin.materiais.categorias.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-bold">Categorias</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <span class="text-gray-900 dark:text-white">Novo Registro</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.materiais.categorias.index') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-all duration-300 shadow-sm active:scale-95">
                    <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                    Cancelar
                </a>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="p-6 mb-8 text-sm text-red-800 rounded-2xl bg-red-50 border border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/50 flex items-start gap-3 animate-shake">
        <x-icon name="triangle-exclamation" class="w-6 h-6 mt-0.5" style="duotone" />
        <div>
            <p class="font-black uppercase tracking-wider text-xs mb-2">Restrições de Validação:</p>
            <ul class="list-disc list-inside space-y-1 font-bold">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
            <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-[0.2em] flex items-center gap-2">
                <x-icon name="pen-to-square" style="duotone" class="w-4 h-4 text-emerald-500" />
                Definição de Parâmetros
            </h3>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-white dark:bg-slate-800 px-3 py-1 rounded-full border border-gray-100 dark:border-slate-700">Módulo Materiais</span>
        </div>

        <form action="{{ route('admin.materiais.categorias.store') }}" method="POST" class="p-8 md:p-12">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                <div class="space-y-2">
                    <label for="nome" class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">
                        Nome da Categoria <span class="text-red-500">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <x-icon name="tag" class="w-4 h-4" />
                        </div>
                        <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold pl-12 p-4 transition-all shadow-inner"
                            placeholder="Ex: Instalações Elétricas">
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium pl-1 italic">Dica: Use nomes curtos e objetivos.</p>
                </div>

                <div class="space-y-2">
                    <label for="icone" class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">
                        Insignia / Ícone (FA)
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <x-icon name="icons" class="w-4 h-4" />
                        </div>
                        <input type="text" id="icone" name="icone" value="{{ old('icone') }}"
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold pl-12 p-4 transition-all shadow-inner"
                            placeholder="Ex: bolt, palette, hammer">
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium pl-1 italic">Consulte a biblioteca Font Awesome Pro.</p>
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label for="descricao" class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">
                        Considerações e Finalidade
                    </label>
                    <textarea id="descricao" name="descricao" rows="4"
                        class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-3xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold p-6 transition-all shadow-inner resize-none lg:h-32"
                        placeholder="Descreva o escopo desta categoria para facilitar a gestão de inventário...">{{ old('descricao') }}</textarea>
                </div>

                <div class="space-y-4">
                    <label for="ordem" class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">
                        Hierarquia de Exibição (Ordem)
                    </label>
                    <div class="flex items-center gap-4">
                        <input type="number" id="ordem" name="ordem" value="{{ old('ordem', 0) }}" min="0"
                            class="w-32 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-base font-black p-4 transition-all shadow-inner text-center">
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter leading-tight bg-slate-50 dark:bg-slate-900 p-3 rounded-xl border border-dashed border-slate-200 dark:border-slate-700">
                            Números menores aparecem primeiro na listagem.
                        </div>
                    </div>
                </div>

                <div class="flex items-center h-full pt-6">
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-slate-600 peer-checked:bg-emerald-600 shadow-inner"></div>
                        <div class="ml-4">
                            <span class="block text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight leading-none">Disponibilidade Imediata</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Marque para ativar no sistema</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mt-16 pt-8 border-t border-gray-100 dark:border-slate-700">
                <a href="{{ route('admin.materiais.categorias.index') }}" class="px-8 py-4 text-sm font-black text-gray-500 bg-white border-2 border-slate-100 rounded-2xl hover:bg-slate-50 hover:text-gray-700 transition-all active:scale-95 shadow-sm">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center gap-3 px-10 py-4 text-sm font-black text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/40 transition-all active:scale-95 border-b-4 border-emerald-800">
                    <x-icon name="floppy-disk" style="duotone" class="w-5 h-5" />
                    Efetivar Registro
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
