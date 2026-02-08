@extends('admin.layouts.admin')

@section('title', 'Editar Líder de Comunidade')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.lideres-comunidade.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Líderes de Comunidade</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">{{ $lider->nome }}</span>
            </nav>
        </div>
        <a href="{{ route('admin.lideres-comunidade.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:text-gray-300 dark:bg-slate-700 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>

    <form action="{{ route('admin.lideres-comunidade.update', $lider) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Informações do Líder -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Líder</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Nome Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nome" name="nome" value="{{ old('nome', $lider->nome) }}" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nome') border-red-500 dark:border-red-600 @enderror">
                        @error('nome')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cpf" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CPF</label>
                        <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $lider->cpf_formatado) }}"
                            class="cpf-mask bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('cpf') border-red-500 dark:border-red-600 @enderror"
                            placeholder="000.000.000-00">
                        @error('cpf')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telefone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefone</label>
                        <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $lider->telefone) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $lider->email) }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label for="endereco" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Endereço Completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="endereco" name="endereco" value="{{ old('endereco', $lider->endereco) }}" required readonly
                        class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg block w-full px-4 py-2.5 dark:bg-slate-600 dark:border-slate-600 dark:text-gray-300 dark:placeholder-gray-400 cursor-not-allowed">
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">O endereço será atualizado automaticamente ao alterar a localidade</p>
                </div>
            </div>
        </div>

        <!-- Vinculação -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Vinculação</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="localidade_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Localidade <span class="text-red-500">*</span>
                        </label>
                        <select id="localidade_id" name="localidade_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Selecione uma localidade...</option>
                            @foreach($localidades as $localidade)
                                <option value="{{ $localidade->id }}" {{ old('localidade_id', $lider->localidade_id) == $localidade->id ? 'selected' : '' }}>
                                    {{ $localidade->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="poco_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Poço Artesiano <span class="text-red-500">*</span>
                        </label>
                        <select id="poco_id" name="poco_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Selecione um poço...</option>
                            @foreach($pocos as $poco)
                                <option value="{{ $poco->id }}" {{ old('poco_id', $lider->poco_id) == $poco->id ? 'selected' : '' }}>
                                    {{ $poco->nome_mapa ?? $poco->codigo }} - {{ $poco->localidade->nome ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Usuário do Sistema
                        </label>
                        <select id="user_id" name="user_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Nenhum (remover vínculo)</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $lider->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Altere o usuário vinculado ao líder</p>
                    </div>

                    <div>
                        <label for="pessoa_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Pessoa do CadÚnico
                        </label>
                        <div class="relative">
                            <input type="text" id="pessoa_search_edit" name="pessoa_search"
                                value="{{ $lider->pessoa ? $lider->pessoa->nom_pessoa : '' }}"
                                placeholder="Buscar pessoa do CadÚnico..."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <div id="pessoa_results_edit" class="hidden absolute z-10 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg max-h-60 overflow-y-auto"></div>
                        </div>
                        <input type="hidden" id="pessoa_id" name="pessoa_id" value="{{ old('pessoa_id', $lider->pessoa_id) }}">
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Busque e selecione uma pessoa do CadÚnico</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status e Observações -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Status e Observações</h2>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="ativo" {{ old('status', $lider->status) === 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="inativo" {{ old('status', $lider->status) === 'inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>

                <div>
                    <label for="observacoes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observações</label>
                    <textarea id="observacoes" name="observacoes" rows="3"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('observacoes', $lider->observacoes) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-slate-700">
            <a href="{{ route('admin.lideres-comunidade.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0h-1.5A2.25 2.25 0 0012 1.5h-1.5m9 0h-1.5A2.25 2.25 0 0012 1.5H6A2.25 2.25 0 003.75 3.75v1.5" />
                </svg>
                Atualizar Líder
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const localidadeSelect = document.getElementById('localidade_id');
    const enderecoInput = document.getElementById('endereco');
    
    if (localidadeSelect && enderecoInput) {
        localidadeSelect.addEventListener('change', function() {
            const localidadeId = this.value;
            
            // Buscar dados da localidade e preencher endereço
            if (localidadeId) {
                fetch(`/localidades/${localidadeId}/dados`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Montar endereço completo
                    let enderecoCompleto = data.endereco || '';
                    if (data.numero) {
                        enderecoCompleto += (enderecoCompleto ? ', ' : '') + data.numero;
                    }
                    if (data.complemento) {
                        enderecoCompleto += (enderecoCompleto ? ' - ' : '') + data.complemento;
                    }
                    if (data.bairro) {
                        enderecoCompleto += (enderecoCompleto ? ', ' : '') + data.bairro;
                    }
                    if (data.cidade) {
                        enderecoCompleto += (enderecoCompleto ? ' - ' : '') + data.cidade;
                        if (data.estado) {
                            enderecoCompleto += '/' + data.estado;
                        }
                    }
                    if (data.cep) {
                        enderecoCompleto += (enderecoCompleto ? ' - CEP: ' : '') + data.cep;
                    }
                    
                    if (enderecoCompleto) {
                        enderecoInput.value = enderecoCompleto;
                    } else if (data.nome) {
                        enderecoInput.value = data.nome;
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar dados da localidade:', error);
                });
            } else {
                // Limpar endereço se nenhuma localidade foi selecionada
                enderecoInput.value = '';
            }
        });
    }
});
</script>
@endpush
@endsection

