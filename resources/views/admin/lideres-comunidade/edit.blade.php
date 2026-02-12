@extends('admin.layouts.admin')

@section('title', 'Editar Líder de Comunidade')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header Premium -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50/50 dark:bg-blue-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="user-pen" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        Editar <span class="text-blue-600 dark:text-blue-400">Gestor</span>
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.lideres-comunidade.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Líderes</a>
                        <x-icon name="chevron-right" class="w-3 h-3" />
                        <span class="text-gray-900 dark:text-white font-bold">{{ $lider->nome }}</span>
                    </nav>
                </div>
            </div>

            <a href="{{ route('admin.lideres-comunidade.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-slate-500 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar à Lista
            </a>
        </div>
    </div>

    <form action="{{ route('admin.lideres-comunidade.update', $lider) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Informações do Líder -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-900/50">
                        <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider flex items-center gap-2">
                            <x-icon name="user-tie" style="duotone" class="w-5 h-5 text-blue-500" />
                            Dados de Identificação
                        </h2>
                    </div>
                    <div class="p-6 md:p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nome" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Nome Completo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nome" name="nome" value="{{ old('nome', $lider->nome) }}" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:text-white @error('nome') border-red-500 @enderror">
                                @error('nome')
                                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cpf" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">CPF</label>
                                <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $lider->cpf_formatado) }}"
                                    class="cpf-mask w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:text-white"
                                    placeholder="000.000.000-00">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="telefone" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Telefone de Contato</label>
                                <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $lider->telefone) }}"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:text-white"
                                    placeholder="(00) 00000-0000">
                            </div>

                            <div>
                                <label for="email" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Endereço de E-mail</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $lider->email) }}"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:text-white"
                                    placeholder="email@exemplo.com">
                            </div>
                        </div>

                        <div>
                            <label for="endereco" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Localização Geográfica <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                     <x-icon name="location-dot" style="duotone" class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" />
                                </div>
                                <input type="text" id="endereco" name="endereco" value="{{ old('endereco', $lider->endereco) }}" required readonly
                                    class="w-full pl-12 pr-5 py-3.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-500 dark:text-slate-400 cursor-not-allowed uppercase tracking-wide">
                            </div>
                            <p class="mt-2 text-xs text-slate-400 font-medium">O logradouro é sincronizado automaticamente através da localidade vinculada.</p>
                        </div>
                    </div>
                </div>

                <!-- Vinculação Estrutural -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-900/50">
                        <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider flex items-center gap-2">
                            <x-icon name="link" style="duotone" class="w-5 h-5 text-indigo-500" />
                            Relacionamentos do Sistema
                        </h2>
                    </div>
                    <div class="p-6 md:p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="localidade_id" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Localidade Atendida <span class="text-red-500">*</span>
                                </label>
                                <select id="localidade_id" name="localidade_id" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:text-white">
                                    <option value="">Selecione...</option>
                                    @foreach($localidades as $localidade)
                                        <option value="{{ $localidade->id }}" {{ old('localidade_id', $lider->localidade_id) == $localidade->id ? 'selected' : '' }}>
                                            {{ $localidade->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="poco_id" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Poço Responsável <span class="text-red-500">*</span>
                                </label>
                                <select id="poco_id" name="poco_id" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:text-white">
                                    <option value="">Selecione...</option>
                                    @foreach($pocos as $poco)
                                        <option value="{{ $poco->id }}" {{ old('poco_id', $lider->poco_id) == $poco->id ? 'selected' : '' }}>
                                            {{ $poco->nome_mapa ?? $poco->codigo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="user_id" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Acesso ao Painel</label>
                                <select id="user_id" name="user_id"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:text-white">
                                    <option value="">Nenhum Vínculo</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $lider->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="pessoa_id" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Vínculo CadÚnico</label>
                                <div class="relative group">
                                     <input type="text" id="pessoa_search_edit" name="pessoa_search"
                                        value="{{ $lider->pessoa ? $lider->pessoa->nom_pessoa : '' }}"
                                        placeholder="Pesquisar..."
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:text-white">
                                    <div id="pessoa_results_edit" class="hidden absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-xl max-h-64 overflow-y-auto"></div>
                                </div>
                                <input type="hidden" id="pessoa_id" name="pessoa_id" value="{{ old('pessoa_id', $lider->pessoa_id) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Status e Controle -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 md:p-8 space-y-8">
                    <div>
                         <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-6 flex items-center gap-2">
                            <x-icon name="shield-halved" style="duotone" class="w-5 h-5 text-emerald-500" />
                            Controle de Status
                        </h2>
                        <label for="status" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Situação do Gestor <span class="text-red-500">*</span></label>
                        <select id="status" name="status" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:text-white">
                            <option value="ativo" {{ old('status', $lider->status) === 'ativo' ? 'selected' : '' }}>Ativo / Operacional</option>
                            <option value="inativo" {{ old('status', $lider->status) === 'inativo' ? 'selected' : '' }}>Inativo / Suspenso</option>
                        </select>
                    </div>

                    <div>
                        <label for="observacoes" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Registros Administrativos</label>
                        <textarea id="observacoes" name="observacoes" rows="5"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:text-white placeholder:text-slate-400"
                            placeholder="Notas importantes sobre este líder...">{{ old('observacoes', $lider->observacoes) }}</textarea>
                    </div>

                    <div class="pt-4 space-y-3">
                         <button type="submit" class="w-full inline-flex items-center justify-center gap-3 px-6 py-3.5 text-sm font-bold uppercase tracking-wider text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-sm active:scale-95 group">
                            <x-icon name="floppy-disk" style="duotone" class="w-5 h-5 group-hover:rotate-12 transition-transform" />
                            Salvar Alterações
                        </button>
                        <a href="{{ route('admin.lideres-comunidade.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 transition-colors">
                            Desistir
                        </a>
                    </div>
                </div>

                <!-- Card de Ajuda -->
                <div class="bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/20 rounded-3xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm text-indigo-500">
                            <x-icon name="circle-info" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-indigo-900 dark:text-indigo-300 uppercase tracking-wider mb-1">Dica de Gestão</h4>
                            <p class="text-xs text-indigo-700 dark:text-indigo-400/80 leading-relaxed">Vincular um usuário do sistema permite que o líder acesse seu próprio painel para gerenciar mensalidades.</p>
                        </div>
                    </div>
                </div>
            </div>
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
            if (localidadeId) {
                fetch(`/localidades/${localidadeId}/dados`)
                .then(response => response.json())
                .then(data => {
                    let enderecoCompleto = data.endereco || '';
                    if (data.numero) enderecoCompleto += (enderecoCompleto ? ', ' : '') + data.numero;
                    if (data.complemento) enderecoCompleto += (enderecoCompleto ? ' - ' : '') + data.complemento;
                    if (data.bairro) enderecoCompleto += (enderecoCompleto ? ', ' : '') + data.bairro;
                    if (data.cidade) enderecoCompleto += (enderecoCompleto ? ' - ' : '') + data.cidade;
                    if (data.cep) enderecoCompleto += (enderecoCompleto ? ' - CEP: ' : '') + data.cep;
                    enderecoInput.value = enderecoCompleto || data.nome || '';
                });
            } else {
                enderecoInput.value = '';
            }
        });
    }
});
</script>
@endpush
@endsection
