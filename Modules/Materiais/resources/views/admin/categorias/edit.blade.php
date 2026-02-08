@extends('admin.layouts.admin')

@section('title', 'Editar Categoria - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="pen-to-square" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Editar Categoria</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.categorias.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Categorias</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">{{ $categoria->nome }}</span>
            </nav>
        </div>
        <a href="{{ route('admin.materiais.categorias.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-red-900/20 dark:text-red-400 border border-red-200 dark:border-red-800" role="alert">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon name="circle-info" class="w-5 h-5 text-emerald-500" />
                Informações da Categoria
            </h3>
        </div>
        <form action="{{ route('admin.materiais.categorias.update', $categoria->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="nome" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        Nome da Categoria <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome', $categoria->nome) }}" required
                        class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:placeholder-gray-500 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-all"
                        placeholder="Ex: Elétrica, Hidráulica, Ferramentas">
                </div>

                <div>
                    <label for="icone" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        Ícone (Font Awesome)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <x-icon name="icons" class="w-4 h-4" />
                        </div>
                        <input type="text" id="icone" name="icone" value="{{ old('icone', $categoria->icone) }}"
                            class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-10 p-3 dark:bg-slate-900 dark:border-slate-700 dark:placeholder-gray-500 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-all"
                            placeholder="Ex: bolt, droplet, screwdriver-wrench">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="descricao" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        Descrição
                    </label>
                    <textarea id="descricao" name="descricao" rows="4"
                        class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:placeholder-gray-500 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-all"
                        placeholder="Descreva o propósito desta categoria...">{{ old('descricao', $categoria->descricao) }}</textarea>
                </div>

                <div>
                    <label for="ordem" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">
                        Ordem de Exibição
                    </label>
                    <input type="number" id="ordem" name="ordem" value="{{ old('ordem', $categoria->ordem) }}" min="0"
                        class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 transition-all">
                </div>

                <div class="flex items-center space-x-3 pt-8">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', $categoria->ativo) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 dark:peer-focus:ring-emerald-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-emerald-600"></div>
                        <span class="ml-3 text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Categoria Ativa</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-slate-700">
                <a href="{{ route('admin.materiais.categorias.index') }}" class="px-6 py-3 text-sm font-bold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:hover:bg-slate-600 transition-all">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all">
                    <x-icon name="floppy-disk" class="w-5 h-5" />
                    Atualizar Categoria
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
