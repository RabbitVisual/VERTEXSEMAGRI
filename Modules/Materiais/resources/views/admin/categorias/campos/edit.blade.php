@extends('admin.layouts.admin')

@section('title', 'Editar Campo - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="pen" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Editar Campo</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mt-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.categorias.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Categorias</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.categorias.subcategorias.index', $categoria->id) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">{{ $categoria->nome }}</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.categorias.campos.index', [$categoria->id, $subcategoria->id]) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Campos</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Editar</span>
            </nav>
            <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm">
                Subcategoria: <span class="font-medium">{{ $subcategoria->nome }}</span> ({{ $categoria->nome }})
            </p>
        </div>
        <a href="{{ route('admin.materiais.categorias.campos.index', [$categoria->id, $subcategoria->id]) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>

    <!-- Form Card - Flowbite -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Campo</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Este campo aparecerá automaticamente ao cadastrar materiais desta subcategoria</p>
        </div>
        <form action="{{ route('admin.materiais.categorias.campos.update', [$categoria->id, $subcategoria->id, $campo->id]) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nome do Campo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome', $campo->nome) }}" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500"
                        placeholder="Ex: Potência (W), Tensão (V)">
                </div>

                <div>
                    <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Slug
                    </label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $campo->slug) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Será gerado automaticamente se deixado em branco</p>
                </div>

                <div>
                    <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Tipo de Campo <span class="text-red-500">*</span>
                    </label>
                    <select id="tipo" name="tipo" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                        <option value="text" {{ old('tipo', $campo->tipo) == 'text' ? 'selected' : '' }}>Texto</option>
                        <option value="number" {{ old('tipo', $campo->tipo) == 'number' ? 'selected' : '' }}>Número</option>
                        <option value="select" {{ old('tipo', $campo->tipo) == 'select' ? 'selected' : '' }}>Seleção</option>
                        <option value="textarea" {{ old('tipo', $campo->tipo) == 'textarea' ? 'selected' : '' }}>Área de Texto</option>
                        <option value="date" {{ old('tipo', $campo->tipo) == 'date' ? 'selected' : '' }}>Data</option>
                        <option value="boolean" {{ old('tipo', $campo->tipo) == 'boolean' ? 'selected' : '' }}>Sim/Não</option>
                    </select>
                </div>

                <div id="opcoes-container" class="{{ old('tipo', $campo->tipo) == 'select' ? '' : 'hidden' }}">
                    <label for="opcoes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Opções (uma por linha ou separadas por vírgula)
                    </label>
                    <textarea id="opcoes" name="opcoes" rows="5"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500"
                        placeholder="Ex: LED&#10;Fluorescente&#10;Incandescente">{{ old('opcoes', $campo->opcoes_array ? implode("\n", $campo->opcoes_array) : '') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Digite uma opção por linha ou separe por vírgula</p>
                </div>

                <div>
                    <label for="placeholder" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Placeholder
                    </label>
                    <input type="text" id="placeholder" name="placeholder" value="{{ old('placeholder', $campo->placeholder) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500"
                        placeholder="Ex: 20, 40, 60">
                </div>

                <div>
                    <label for="descricao" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Descrição
                    </label>
                    <textarea id="descricao" name="descricao" rows="2"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500"
                        placeholder="Ex: Potência da lâmpada em watts">{{ old('descricao', $campo->descricao) }}</textarea>
                </div>

                <div>
                    <label for="ordem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Ordem
                    </label>
                    <input type="number" id="ordem" name="ordem" value="{{ old('ordem', $campo->ordem) }}" min="0"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Número para ordenar os campos (menor = primeiro)</p>
                </div>

                <div class="flex items-center gap-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="obrigatorio" name="obrigatorio" value="1" {{ old('obrigatorio', $campo->obrigatorio) ? 'checked' : '' }}
                            class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                        <label for="obrigatorio" class="ml-2 text-sm font-medium text-gray-900 dark:text-white">
                            Campo obrigatório
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo', $campo->ativo) ? 'checked' : '' }}
                            class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                        <label for="ativo" class="ml-2 text-sm font-medium text-gray-900 dark:text-white">
                            Campo ativo
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
                        <x-icon name="check" class="w-5 h-5" />
                        Atualizar Campo
                    </button>
                    <a href="{{ route('admin.materiais.categorias.campos.index', [$categoria->id, $subcategoria->id]) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.querySelector('select[name="tipo"]');
    const opcoesContainer = document.getElementById('opcoes-container');

    function toggleOpcoes() {
        if (tipoSelect.value === 'select') {
            opcoesContainer.classList.remove('hidden');
        } else {
            opcoesContainer.classList.add('hidden');
        }
    }

    tipoSelect.addEventListener('change', toggleOpcoes);
    toggleOpcoes(); // Verificar ao carregar
});
</script>
@endpush
@endsection

