@extends('Co-Admin.layouts.app')

@section('title', 'Editar Material')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-800 dark:to-indigo-900 rounded-2xl shadow-xl p-6 md:p-8 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <x-module-icon module="Materiais" class="w-8 h-8 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Editar Material</h1>
                    <p class="text-indigo-100 dark:text-indigo-200 mt-2 text-sm md:text-base">
                        {{ $material->nome }}
                        @if($material->codigo)
                            <span class="text-white/80">({{ $material->codigo }})</span>
                        @endif
                    </p>
                </div>
            </div>
            <x-materiais::button href="{{ route('materiais.show', $material) }}" variant="outline" class="bg-white/10 text-white border-white/30 hover:bg-white/20">
                <x-materiais::icon name="arrow-left" class="w-5 h-5 mr-2" />
                Voltar
            </x-materiais::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-materiais::alert type="success" dismissible>
            <div class="flex items-center gap-2">
                <x-materiais::icon name="check-circle" class="w-5 h-5" />
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </x-materiais::alert>
    @endif

    @if($errors->any())
        <x-materiais::alert type="danger" dismissible>
            <div class="flex items-start gap-2">
                <x-materiais::icon name="exclamation-triangle" class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <div>
                    <p class="font-medium mb-2">Por favor, corrija os seguintes erros:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </x-materiais::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2 space-y-6">
            <x-materiais::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <x-materiais::icon name="information-circle" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Informações do Material
                        </h3>
                    </div>
                </x-slot>

                <form action="{{ route('materiais.update', $material) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Informações Básicas -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="p-1.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <x-materiais::icon name="information-circle" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Informações Básicas
                            </h4>
                        </div>

                        <div>
                            <x-materiais::form.input
                                label="Nome"
                                name="nome"
                                type="text"
                                required
                                value="{{ old('nome', $material->nome) }}"
                            />
                        </div>

                        @if($material->codigo)
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                            <label class="block text-xs font-medium text-blue-900 dark:text-blue-200 mb-1">Código</label>
                            <div class="text-sm font-semibold text-blue-800 dark:text-blue-300">{{ $material->codigo }}</div>
                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">O código será gerado automaticamente se estiver vazio ao salvar.</p>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-materiais::form.select
                                label="Categoria / Subcategoria"
                                name="subcategoria_id"
                                id="subcategoria_id"
                                required
                            >
                                <option value="">Selecione uma subcategoria</option>
                                @foreach($categorias as $categoria)
                                    <optgroup label="{{ $categoria->nome }}">
                                        @foreach($categoria->subcategorias as $subcategoria)
                                            <option value="{{ $subcategoria->id }}"
                                                {{ old('subcategoria_id', $material->subcategoria_id) == $subcategoria->id ? 'selected' : '' }}
                                                data-categoria-id="{{ $categoria->id }}"
                                                data-subcategoria-slug="{{ $subcategoria->slug }}"
                                                data-campos="{{ json_encode($subcategoria->campos->map(function($campo) {
                                                    return [
                                                        'id' => $campo->id,
                                                        'nome' => $campo->nome,
                                                        'slug' => $campo->slug,
                                                        'tipo' => $campo->tipo,
                                                        'opcoes' => $campo->opcoes_array,
                                                        'placeholder' => $campo->placeholder,
                                                        'descricao' => $campo->descricao,
                                                        'obrigatorio' => $campo->obrigatorio,
                                                    ];
                                                })) }}"
                                            >
                                                {{ $subcategoria->nome }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </x-materiais::form.select>
                            <x-materiais::form.select
                                label="Unidade de Medida"
                                name="unidade_medida"
                                required
                            >
                                <option value="unidade" {{ old('unidade_medida', $material->unidade_medida) == 'unidade' ? 'selected' : '' }}>Unidade</option>
                                <option value="metro" {{ old('unidade_medida', $material->unidade_medida) == 'metro' ? 'selected' : '' }}>Metro</option>
                                <option value="litro" {{ old('unidade_medida', $material->unidade_medida) == 'litro' ? 'selected' : '' }}>Litro</option>
                                <option value="kg" {{ old('unidade_medida', $material->unidade_medida) == 'kg' ? 'selected' : '' }}>Quilograma</option>
                            </x-materiais::form.select>
                        </div>
                    </div>

                    <!-- Estoque e Valores -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3">
                            <div class="p-1.5 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                                <x-materiais::icon name="archive-box" class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Estoque e Valores
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <x-materiais::form.input
                                label="Quantidade em Estoque"
                                name="quantidade_estoque"
                                type="number"
                                step="0.01"
                                required
                                value="{{ old('quantidade_estoque', $material->quantidade_estoque) }}"
                            />
                            <x-materiais::form.input
                                label="Quantidade Mínima"
                                name="quantidade_minima"
                                type="number"
                                step="0.01"
                                required
                                value="{{ old('quantidade_minima', $material->quantidade_minima) }}"
                            />
                            <x-materiais::form.input
                                label="Valor Unitário (R$)"
                                name="valor_unitario"
                                type="number"
                                step="0.01"
                                value="{{ old('valor_unitario', $material->valor_unitario) }}"
                            />
                        </div>
                    </div>

                    <!-- Campos Específicos da Categoria -->
                    <div id="campos-especificos" class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3">
                            <div class="p-1.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                <x-materiais::icon name="cog" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Informações Específicas da Categoria
                            </h4>
                        </div>
                        <div id="campos-dinamicos" class="space-y-4">
                            <!-- Campos serão inseridos dinamicamente via JavaScript -->
                        </div>
                    </div>

                    <!-- Informações Adicionais -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3">
                            <div class="p-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                <x-materiais::icon name="document-text" class="w-4 h-4 text-gray-600 dark:text-gray-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Informações Adicionais
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-materiais::form.input
                                label="Fornecedor"
                                name="fornecedor"
                                type="text"
                                value="{{ old('fornecedor', $material->fornecedor) }}"
                            />
                            <x-materiais::form.input
                                label="Localização no Estoque"
                                name="localizacao_estoque"
                                type="text"
                                value="{{ old('localizacao_estoque', $material->localizacao_estoque) }}"
                            />
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="ativo"
                                   name="ativo"
                                   value="1"
                                   {{ old('ativo', $material->ativo) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                            <label for="ativo" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                Material ativo
                            </label>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 -mx-6 -mb-6 px-6 py-4 rounded-b-xl">
                        <x-materiais::button href="{{ route('materiais.show', $material) }}" variant="outline" class="border-2">
                            <x-materiais::icon name="x-mark" class="w-4 h-4 mr-2" />
                            Cancelar
                        </x-materiais::button>
                        <x-materiais::button type="submit" variant="primary" class="shadow-lg hover:shadow-xl transition-shadow">
                            <x-materiais::icon name="check-circle" class="w-4 h-4 mr-2" />
                            Atualizar Material
                        </x-materiais::button>
                    </div>
                </form>
            </x-materiais::card>
        </div>

        <!-- Sidebar com Informações -->
        <div class="lg:col-span-1 space-y-6">
            <x-materiais::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                            <x-materiais::icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Informações do Sistema
                        </h3>
                    </div>
                </x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                        <div class="text-base font-semibold text-gray-900 dark:text-white">#{{ $material->id }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $material->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @if($material->updated_at)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $material->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status do Estoque</label>
                        <div>
                            @if($material->quantidade_estoque <= $material->quantidade_minima)
                                <x-materiais::badge variant="danger">
                                    <x-materiais::icon name="exclamation-triangle" class="w-3 h-3 mr-1" />
                                    Estoque Baixo
                                </x-materiais::badge>
                            @else
                                <x-materiais::badge variant="success">
                                    <x-materiais::icon name="check-circle" class="w-3 h-3 mr-1" />
                                    Estoque OK
                                </x-materiais::badge>
                            @endif
                        </div>
                    </div>
                </div>
            </x-materiais::card>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subcategoriaSelect = document.getElementById('subcategoria_id');
    const camposEspecificosDiv = document.getElementById('campos-especificos');
    const camposDinamicosDiv = document.getElementById('campos-dinamicos');
    const materialCamposEspecificos = @json($material->campos_especificos ?? []);

    function atualizarCamposEspecificos() {
        const selectedOption = subcategoriaSelect.options[subcategoriaSelect.selectedIndex];
        camposDinamicosDiv.innerHTML = '';

        if (selectedOption && selectedOption.value) {
            const camposData = selectedOption.getAttribute('data-campos');
            
            if (camposData) {
                try {
                    const campos = JSON.parse(camposData);
                    camposEspecificosDiv.classList.remove('hidden');

                    campos.forEach(campo => {
                        const campoDiv = document.createElement('div');
                        campoDiv.className = 'space-y-1';

                        const campoName = `campos_especificos[${campo.slug}]`;
                        const campoId = `campo_${campo.slug}`;
                        const oldValue = materialCamposEspecificos[campo.slug] || '';

                        let campoHTML = `
                            <label for="${campoId}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                ${campo.nome}${campo.obrigatorio ? ' *' : ''}
                            </label>
                        `;

                        if (campo.tipo === 'select' && campo.opcoes && campo.opcoes.length > 0) {
                            campoHTML += `
                                <select name="${campoName}" id="${campoId}" ${campo.obrigatorio ? 'required' : ''}
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                    <option value="">Selecione</option>
                                    ${campo.opcoes.map(opt => `<option value="${opt}" ${oldValue === opt ? 'selected' : ''}>${opt}</option>`).join('')}
                                </select>
                            `;
                        } else if (campo.tipo === 'textarea') {
                            campoHTML += `
                                <textarea name="${campoName}" id="${campoId}" ${campo.obrigatorio ? 'required' : ''}
                                    rows="3"
                                    placeholder="${campo.placeholder || ''}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">${oldValue}</textarea>
                            `;
                        } else if (campo.tipo === 'boolean') {
                            campoHTML += `
                                <div class="flex items-center">
                                    <input type="checkbox" name="${campoName}" id="${campoId}" value="1" ${oldValue ? 'checked' : ''}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                    <label for="${campoId}" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                        Sim
                                    </label>
                                </div>
                            `;
                        } else {
                            const inputType = campo.tipo === 'number' ? 'number' : (campo.tipo === 'date' ? 'date' : 'text');
                            campoHTML += `
                                <input type="${inputType}"
                                    name="${campoName}"
                                    id="${campoId}"
                                    ${campo.obrigatorio ? 'required' : ''}
                                    ${campo.tipo === 'number' ? 'step="0.01"' : ''}
                                    value="${oldValue}"
                                    placeholder="${campo.placeholder || ''}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            `;
                        }

                        if (campo.descricao) {
                            campoHTML += `
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    <x-materiais::icon name="information-circle" class="w-3 h-3 inline mr-1" />
                                    ${campo.descricao}
                                </p>
                            `;
                        }

                        campoDiv.innerHTML = campoHTML;
                        camposDinamicosDiv.appendChild(campoDiv);
                    });
                } catch (e) {
                    console.error('Erro ao processar campos:', e);
                    camposEspecificosDiv.classList.add('hidden');
                }
            } else {
                camposEspecificosDiv.classList.add('hidden');
            }
        } else {
            camposEspecificosDiv.classList.add('hidden');
        }
    }

    subcategoriaSelect.addEventListener('change', atualizarCamposEspecificos);

    // Atualizar ao carregar se já houver subcategoria selecionada
    if (subcategoriaSelect.value) {
        atualizarCamposEspecificos();
    }
});
</script>
@endpush
@endsection

